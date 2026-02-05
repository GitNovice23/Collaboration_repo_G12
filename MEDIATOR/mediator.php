<?php

// 1. The Mediator Interface
interface Mediator {
    public function notify(object $sender, string $event): void;
}

// 2. The Concrete Mediator
class RegistrationMediator implements Mediator {
    private $database;
    private $emailService;

    public function __construct(Database $db, EmailService $email) {
        $this->database = $db;
        $this->database->setMediator($this);
        
        $this->emailService = $email;
        $this->emailService->setMediator($this);
    }

    public function notify(object $sender, string $event): void {
        if ($event === "user_saved") {
            echo "Mediator: Database saved user. Now instructing EmailService...\n";
            $this->emailService->sendWelcomeEmail();
        }
    }
}

// 3. The Base Colleague
abstract class Component {
    protected $mediator;

    public function setMediator(Mediator $mediator): void {
        $this->mediator = $mediator;
    }
}

// 4. Concrete Colleagues
class Database extends Component {
    public function saveUser() {
        echo "Database: User record created.\n";
        $this->mediator->notify($this, "user_saved");
    }
}

class EmailService extends Component {
    public function sendWelcomeEmail() {
        echo "EmailService: Welcome email sent to the user.\n";
    }
}

// --- Client Code ---

$db = new Database();
$email = new EmailService();

// The mediator links them together
$mediator = new RegistrationMediator($db, $email);

// When we save a user, the mediator automatically handles the email trigger
$db->saveUser();
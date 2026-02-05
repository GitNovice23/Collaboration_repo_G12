<?php

class Database {
    private static $instance = null;
    
    // Private constructor prevents instantiation from outside
    private function __construct() {
        echo "Database connected\n";
    }
    
    // Private clone prevents cloning
    private function __clone() {}
    
    // Get the single instance
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function query($sql) {
        return "Executing: " . $sql;
    }
}

// Usage
$db1 = Database::getInstance();
$db2 = Database::getInstance();

echo $db1 === $db2 ? "Same instance\n" : "Different instances\n";  // Same instance
echo $db1->query("SELECT * FROM users");  // Executing: SELECT * FROM users [web:1][web:2]
?>

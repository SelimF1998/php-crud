<?php
    class DBConnection
    {
        private static $instance = null;
        private $pdo;
    
        private function __construct()
        {
            try {
                $this->pdo = new PDO("mysql:host=localhost;dbname=crud", "root", "");
            } catch (PDOException $e) {
                die("Could not connect to the database: " . $e->getMessage());
            }
        }
    
        public static function getInstance()
        {
            if (!self::$instance) {
                self::$instance = new DBConnection();
            }
            return self::$instance;
        }
    
        public function get()
        {
            return $this->pdo;
        }
    }  
?>
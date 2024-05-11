<?php

// Loading database credential file
include_once '../../config/database.php';

/**
 * [Description DB]
 */
class DB {
    /**
     * $conn - Database connection object
     * @var [type]
     */
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
            $this->conn = new PDO($dsn, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
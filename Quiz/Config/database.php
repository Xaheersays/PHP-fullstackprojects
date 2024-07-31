<?php

class Database {


	private $host     = 'localhost';
	private $user     = 'root';
	private $password = '';
	private $db_name  = 'quizappdb';

	private $conn;

	// get the database connection

	public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
       

        return $this->conn;
    }
}
?>
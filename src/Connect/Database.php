<?php
class Database
{
    private $servername = "mysql";
    private $username = "user";
    private $password = "password";
    private $database = "intas";
    private $port = 3306;
    private $conn;

    public function __construct()
    {
        $this->conn = new \mysqli($this->servername, $this->username, $this->password, $this->database, $this->port);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

}
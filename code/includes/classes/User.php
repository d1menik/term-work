<?php

class User
{
    private $conn;
    private $username;

    public function __construct($conn, $username)
    {
        $this->conn = $conn;
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getUserId()
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->bindParam('username', $this->username);
        $stmt->execute();

        $user = $stmt->fetch();
        return $user['user_id'];
    }

    public function sessionDestroy()
    {
        session_start();
        session_destroy();
    }

    public function getEmail()
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->bindParam('username', $this->username);
        $stmt->execute();

        $user = $stmt->fetch();
        return $user['email'];
    }
}
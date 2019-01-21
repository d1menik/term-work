<?php

class UserRepository
{

    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllUsers()
    {
        $stml = $this->conn->prepare("SELECT * FROM users");
        $stml->execute();
        return $stml->fetchAll();
    }
    public function getAllPremiumUsers()
    {
        $stml = $this->conn->prepare("SELECT * FROM users WHERE isPremium is TRUE");
        $stml->execute();
        return $stml->fetchAll();
    }

    public function getByEmail(string $email)
    {
        $stml = $this->conn->prepare("SELECT * FROM users WHERE email LIKE concat(:email, '%')");
        $stml->bindParam(":email", $email);
        $stml->execute();
        return $stml->fetchAll();
    }
}
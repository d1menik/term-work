<?php

class Account
{
    private $errorArray;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->errorArray = array();
    }

    public function login($un, $pw)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->bindParam('username', $un);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            array_push($this->errorArray, Constants::LOGIN_FAILED);
            return false;
        } else {
            $validPassword = password_verify($pw, $user['password']);
            if ($validPassword) {
                return true;
            } else {
                array_push($this->errorArray, Constants::LOGIN_FAILED);
                return false;
            }
        }
    }
    public function isAdmin ($un) {
        $stmt = $this->conn->prepare("SELECT isAdmin FROM users WHERE username=:username");
        $stmt->bindParam('username', $un);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin['isAdmin'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getError($error)
    {
        if (!in_array($error, $this->errorArray)) {
            $error = '';
        }
        return "<span class='errorMessage'>$error</span>";
    }

    public function validateUser($un, $em, $pw, $pw2)
    {
        $this->validateUsername($un);
        $this->validateEmail($em);
        $this->validatePasswds($pw, $pw2);

        if (empty($this->errorArray)) {
            return true;
        } else {
            return false;
        }
    }

    private function validateUsername($un)
    {
        if (strlen($un) > 25 || strlen($un) < 5) {
            array_push($this->errorArray, Constants::USERNAME_CHARACTERS);
            return;
        }

        $stmt = $this->conn->prepare("SELECT username FROM users WHERE username='$un'");
        $stmt->execute();
        $row = $stmt->rowCount();

        if ($row !== 0) {
            array_push($this->errorArray, Constants::USERNAME_TAKEN);
            return;
        }
    }

    private function validateEmail($em)
    {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::EMAIL_INVALID);
            return;
        }

        $stmt = $this->conn->prepare("SELECT email FROM users WHERE email='$em'");
        $stmt->execute();
        $row = $stmt->rowCount();

        if ($row !== 0) {
            array_push($this->errorArray, Constants::EMAIL_TAKEN);
            return;
        }
    }

    private function validatePasswds($pw, $pw2)
    {
        if ($pw !== $pw2) {
            array_push($this->errorArray, Constants::PASSWORDS_DO_NOT_MATCH);
            return;
        }
        if (strlen($pw) > 30 || strlen($pw) < 5) {
            array_push($this->errorArray, Constants::PASSWORD_CHARACTERS);
            return;
        }
    }
}
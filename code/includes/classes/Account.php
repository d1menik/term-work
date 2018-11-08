<?php

class Account
{
    private $errorArray;

    public function __construct(){
        $this->errorArray = array();
    }

    public function getError($error) {
        if (!in_array($error, $this->errorArray)) {
            $error = '';
        }
        return "<span class='errorMessage'>$error</span>";
    }

    public function validateUser ($un, $em, $pw, $pw2) {
        $this->validateUsername($un);
        $this->validateEmail($em);
        $this->validatePasswds($pw, $pw2);

        if (empty($this->errorArray)){
            return true;
        } else {
            return false;
        }
    }

    private function validateUsername($un) {
        if (strlen($un) > 25 || strlen($un) < 5) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT username FROM users WHERE username='$un'");
        $stmt->execute();
        $row = $stmt->rowCount();


        if ($row !== 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
            return;
        }
    }

    private function validateEmail($em) {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT email FROM users WHERE email='$em'");
        $stmt->execute();
        $row = $stmt->rowCount();

        if ($row !== 0) {
            array_push($this->errorArray, Constants::$emailTaken);
            return;
        }
    }

    private function validatePasswds($pw, $pw2) {
        if ($pw !== $pw2) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }
        if (strlen($pw) > 30 || strlen($pw) < 5) {
            array_push($this->errorArray, Constants::$passwordCharacters);
            return;
        }
    }
}
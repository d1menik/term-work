<?
include("../../config.php");

if (!isset($_POST['username'])) {
    echo "ERROR: Could not set username!";
    exit();
}

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email is invalid!";
        exit();
    }

    validateEmail($email, $username, $conn);

    $stmt = $conn->prepare("UPDATE users SET email=:email WHERE username=:username");
    $stmt->bindParam('username', $username);
    $stmt->bindParam('email', $email);
    $stmt->execute();

    echo "Email was successfully updated!";
} else {
    echo "You must provide an email!";
}

function validateEmail($email, $username, $conn) {
    $stmt = $conn->prepare("SELECT email FROM users WHERE email=:email AND username !=:username");
    $stmt->bindParam('username', $username);
    $stmt->bindParam('email', $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result) {
        echo "Email is already in use!";
        exit();
    }
}
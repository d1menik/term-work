<?php
include("config.php");

include("includes/classes/Account.php");
include ("includes/classes/Constants.php");

$account = new Account();

include("includes/register-handler.php");
?>

<html>
<head>
    <title>Playbox | Login page</title>
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
</head>
<body>

<form id="loginForm" action="register.php" method="POST">
    <h3>Login to your account</h3>
    <p>
        <input type="text" id="loginUsername" name="loginUsername" placeholder="Username" class="inputForm" required>
    </p>
    <p>
        <input type="password" id="loginPasswd" name="loginPasswd" placeholder="Password" class="inputForm" required>
    </p>
    <button class="btn" type="submit" name="loginBtn">Log in</button>
</form>

<form id="registerForm" action="register.php" method="POST">
    <h3>Create your free account</h3>
    <p>
        <?php echo $account->getError(Constants::$usernameCharacters); ?>
        <?php echo $account->getError(Constants::$usernameTaken); ?>
        <input type="text" id="username" name="username" placeholder="Username" class="inputForm" required>
    </p>
    <p>
        <?php echo $account->getError(Constants::$emailInvalid); ?>
        <?php echo $account->getError(Constants::$emailTaken); ?>
    <input type="email" id="email" name="email" placeholder="Email" class="inputForm" required>
    </p>
    <p>
        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
        <?php echo $account->getError(Constants::$passwordCharacters); ?>
        <input type="password" id="passwd" name="passwd" placeholder="Password" class="inputForm" required>
    </p>
    <p>
        <input type="password" id="passwd2" name="passwd2" placeholder="Confirm password" class="inputForm" required>
    </p>
    <button class="btn" type="submit" name="registerBtn">Sign up</button>
</form>
</body>
</html>
<?php
include("config.php");

include("includes/classes/Account.php");
include("includes/classes/Constants.php");
include("includes/classes/Connection.php");

$account = new Account(Connection::getPdoInstance());

include("includes/register-handler.php");
include("includes/login-handler.php");
?>

<html>
<head>
    <title>Playbox | Login page</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/ionicons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>

</head>
<body>

<?php
if (isset($_POST['registerBtn'])) {
    echo '<script>
        $(document).ready(function () {
            $("#loginForm").hide();
            $("#registerForm").show();
    }); </script>';
}
?>

<div id="background">
    <h1>Music for everyone</h1>
    <h2>Millions songs for free</h2>

    <div id="loginContainer">
        <div id="inputContainer">
            <form id="loginForm" action="register.php" method="POST">
                <h3>Login to your account</h3>
                <p>
                    <?php echo $account->getError(Constants::$loginFailed); ?>
                    <input type="text" id="loginUsername" name="loginUsername" placeholder="Username" class="inputForm"
                           required>
                </p>
                <p>
                    <input type="password" id="loginPasswd" name="loginPasswd" placeholder="Password" class="inputForm"
                           required>
                </p>
                <button class="btn" type="submit" name="loginBtn">Log in</button>

                <div class="hasAccountText">
                    <span id="hideLogin">Don't have an account yet? Sing up here.</span>
                </div>
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
                    <input type="password" id="passwd2" name="passwd2" placeholder="Confirm password" class="inputForm"
                           required>
                </p>
                <button class="btn" type="submit" name="registerBtn">Sign up</button>
                <div class="hasAccountText">
                    <span id="hideRegister">Already have an account? Log in here.</span>
                </div>
            </form>
        </div>
    </div>
</div>

<footer>
    <div class="nav">
        <ul class="footer-nav">
            <li><a href="#">About us</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Press</a></li>
            <li><a href="#">iOS App</a></li>
            <li><a href="#">Android App</a></li>
        </ul>
    </div>
    <div class="icons">
        <ul class="social-links">
            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
            <li><a href="#"><i class="ion-social-youtube"></i></a></li>
            <li><a href="#"><i class="ion-social-instagram"></i></a></li>
        </ul>
    </div>

</footer>
</body>
</html>
<?php
include("header.php");

?>

<div class="entityInfo">
    <div class="centerSection">
        <div class="userInfo">
            <h1><?php echo $userLoggedIn->getUsername(); ?></h1>
        </div>
    </div>
    <div class="buttonItems">
        <button class="button" onclick='window.open("userDetails.php", "_self")'>User details</button>
        <button class="button" onclick="logout();">Logout</button>
    </div>

</div>

<?
include("footer.php");

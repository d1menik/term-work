<?php
include("includes/includes.php");
$username = $userLoggedIn->getUsername();
?>
    <script> username = '<?php echo $username;?>';</script>
    <div class="entityInfo">
        <div class="centerSection">
            <div class="userInfo">
                <h2><?php echo $username ?></h2>
            </div>
        </div>
        <div class="buttonItems">
            <button class="button" onclick='openPage("userDetails.php")'>User details</button>
            <button class="button" onclick="logout();">Logout</button>
        </div>
        <div class="premium" onclick="addPremium(username);">
            <div>
                <span>Become Premium User</span>
                <span>Just for 2.99 EUR per month</span>
            </div>
        </div>

    </div>

<?

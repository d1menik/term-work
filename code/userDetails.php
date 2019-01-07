<?php
include("header.php");
?>

<div class="userDetails">
    <div class="container borderBottomLine">
        <h2>Email</h2>
        <input type="text" id="email" name="email" placeholder="Email address.." value="<? echo $userLoggedIn->getEmail(); ?>">
        <span class="message"></span>
        <button class="button" onclick="updateEmail(document.getElementById('email').value)">Save</button>
    </div>

    <div class="container">
        <h2>Password</h2>
        <input type="password" class="oldPassword" name="oldPassword" placeholder="Current password">
        <input type="password" class="newPassword1" name="newPassword1" placeholder="New password">
        <input type="password" class="newPassword2" name="newPassword2" placeholder="Confirm password">
        <span class="message"></span>
        <button class="button" onclick="updatePasswd('oldPassword', 'newPassword1', 'newPassword2')">Save</button>
    </div>
</div>

<?
include("footer.php");
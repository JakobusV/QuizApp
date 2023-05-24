<?php
include 'header.php';

echo GenerateHeader('Landing Page', array('homePage.css'));
?>
<div class="navlinks">
    <a>test 1</a>
    <a>test 2</a>
    <a>test 3</a>
</div>
<div class="body-container">
    <img class="title-img" src="./title.png"/>
    <div class="body-title">
        <h2>Get Started</h2>
        <p>New to Quiztopia? <br> Create a free account below!</p>
        <a href="./createAccount.php">get started</a>
        <p>Already have an account?</p>
        <a href="./login.php">login</a>
    </div>
</div>
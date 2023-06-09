<?php
include_once 'header.php';
GenerateHeader("Landing Page", ['homePage.css']);
?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <img class="title-img" src="./title.png" />
        <div class="body-title">
            <h2>Get Started</h2>
            <p>
                New to Quiztopia? <br /> Create a free account below!
            </p>
            <a href="./createAccount.php" class="redirect-button">Create Account</a>
            <p>Already have an account?</p>
            <a href="./login.php" class="redirect-button">Login</a>
        </div>
    </div>
</body>
<?php

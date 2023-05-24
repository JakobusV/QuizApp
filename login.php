<?php
include_once 'header.php';
GenerateHeader("Login Page", ['login.css']);
?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="login-container">
            <h2>Login</h2>
            <p>Username</p>
            <input class="inputs" />
            <p>Password</p>
            <input class="inputs" />
            <button class="login-btn">Login</button>
        </div>
    </div>
</body>
<?php

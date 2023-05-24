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
            <input id="Username" class="inputs" />
            <p>Password</p>
            <input id="password" class="inputs" />
            <button onclick="Login()" class="login-btn">Login</button>
        </div>
    </div>
</body>

<script>
    function Login()
</script>
<?php

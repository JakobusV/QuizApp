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
            <input id="username" class="inputs" />
            <p>Password</p>
            <input id="password" class="inputs" type="password" />
            <button onclick="Login()" class="login-btn">Login</button>
            <p id="loginMessageBox"></p>
        </div>
    </div>
</body>

<script>
    var request = new XMLHttpRequest();

    function Login() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        var body = '{"username":"' + username + '", "password":"' + password + '"}';
        console.log(body)
        request.open('post', 'ValidateLogin.php');
        request.send(body);
        request.onload = OnLoadJson;
    }

    function OnLoadJson(evt) {
        var response;
        var response = request.responseText;
        console.log(response)

        if (response === "Login Invalid") {
            const loginMessagePTag = document.getElementById('loginMessageBox');
            loginMessagePTag.innerHTML = 'Login Invalid';
        }
        if (response === "Login Validated") {
            window.location.href = "quizzesPage.php";
        } 
    }

</script>
<?php

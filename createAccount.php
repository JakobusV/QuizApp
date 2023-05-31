<?php
include_once 'header.php';
GenerateHeader("Create Account Page", ['createUser.css']);
?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="login-container">
            <h2>Create User</h2>
            <p>Username</p>
            <input id="username" class="inputs" />
            <p>Password</p>
            <input id="password" class="inputs" type="password" />
            <p>Confirm Password</p>
            <input id="confirmPassword" class="inputs" type="password" />
            <button class="create-account-button" onclick="CreateAccount()">Create</button>
            <p id="createMessageBox"></p>
        </div>
    </div>
</body>

<script>
    var request = new XMLHttpRequest();

    function CreateAccount() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        if (password != confirmPassword) {
            var createMessage = document.getElementById('createMessageBox');
            createMessage.innerHTML = 'Passwords Dont Match';
        } else {
            var body = '{"userName":"' + username + '", "userPassword":"' + password + '", "userAdminStatus": 0}';
            request.open('post', '/backend/sqlInsert.php?table=user');
            request.send(body);
            request.onload = OnLoadJson;
        }
    }

    function OnLoadJson(evt) {
        var response = request.responseText;

        if (response == "1 row affected") {
            window.location.href = "login.php"
        } else {
            var createMessage = document.getElementById('createMessageBox');
            createMessage.innerHTML = 'Account Creation Failed';
        }

        //if (response === "Login Invalid") {
        //    const loginMessagePTag = document.getElementById('loginMessageBox');
        //    loginMessagePTag.innerHTML = 'Login Invalid';
        //}
        //if (response === "Login Validated") {
        //    window.location.href = "quizzesPage.php";
        //}
    }
</script>

<?php

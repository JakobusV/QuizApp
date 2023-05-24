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
            <input class="inputs" />
            <p>Password</p>
            <input class="inputs" />
            <button class="login-btn">Create</button>
        </div>
    </div>
</body>
<?php

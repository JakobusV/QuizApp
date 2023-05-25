<?php
include_once 'header.php';
GenerateHeader('User Page', ['userPage.css']);
?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="info-container">
            <div class="gradient-banner"></div>
            <div class="user-container">
                <h2>Fake User</h2>
                <p>Your Quizzes</p>
                <div class="quizzes-container">
                    <a class="quiz-card" href="./editQuiz.php">
                        <div class="quiz-body">
                            <div class="quiz-title">Quiz Name</div>
                            <p>Description</p>
                        </div>
                    </a>
                    <a class="quiz-card">
                        <div class="quiz-body">
                            <div class="quiz-title">Quiz Name</div>
                            <p>Description</p>
                        </div>
                    </a>
                    <a class="quiz-card">
                        <div class="quiz-body">
                            <div class="quiz-title">Quiz Name</div>
                            <p>Description</p>
                        </div>
                    </a>
                    <a class="quiz-card">
                        <div class="quiz-body">
                            <div class="quiz-title">Quiz Name</div>
                            <p>Description</p>
                        </div>
                    </a>
                    <a class="quiz-card">
                        <div class="quiz-body">
                            <div class="quiz-title">Quiz Name</div>
                            <p>Description</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <img class="profile-img"
            src="https://th.bing.com/th/id/R.6e0f2f6bab06c008c79a3b280db49342?rik=jsupiHsPJSF3lA&riu=http%3a%2f%2fassets0.prcdn.com%2fuk%2fpeople%2fdefault-profile.png%3f1406639312&ehk=fgzMewvFjuDc4jTAGFrQAJ%2fhZD3vLHtzxhxb%2bnle3cU%3d&risl=&pid=ImgRaw&r=0" />
    </div>
</body>
<script type="text/javascript">
    var request = new XMLHttpRequest();

</script>
<?php

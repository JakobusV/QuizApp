<?php
include_once 'header.php';
GenerateHeader("Quizzes Page", ['quizzesPage.css']);
?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="info-container">
            <div class="gradient-banner">
                <div>Quiz Wall</div>
            </div>
            <div class="utility-bar">
                <div class="search-bar">
                    <img src="./search.png" />
                    <input placeholder="search quizzes" />
                </div>
            </div>
            <div class="quizzes-container">
                <a class="quiz-card" href="./playQuiz.php">
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
</body>
<?php

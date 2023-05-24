<?php
include 'header.php';

echo GenerateHeader('Quizzes Page', array('quizzesPage.css'));
?>

<div class="navlinks">
    <a>test 1</a>
    <a>test 2</a>
    <a>test 3</a>
</div>
<div class="body-container">
    <div class="info-container">
        <div class="gradient-banner">
            <div>Quiztopia</div>
        </div>
        <div class="utility-bar">
            <div class="search-bar">
                <img src="./search.png"/>
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
<?php
include 'header.php';

echo GenerateHeader('Play Quiz Page', array('playQuiz.css'));
?>
<div class="navlinks">
    <a>test 1</a>
    <a>test 2</a>
    <a>test 3</a>
</div>
<div class="body-container">
    <div class="info-container">
        <div class="question-box">
            <p>Question 1:</p>
            <h2>What is the Capital of Spain?</h2>
        </div>
        <div class="options-container">
            <button class="answer-btn">A. Florince</button>
            <button class="answer-btn">B. Madrid</button>
            <button class="answer-btn">C. Paris</button>
            <button class="answer-btn">D. Mexico City</button>
        </div>
        <button class="option-btn">Submit Answer</button>
    </div>
</div>
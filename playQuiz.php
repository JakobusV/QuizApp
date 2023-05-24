<?php
include_once 'header.php';
GenerateHeader("Play Quiz Page", ['playQuiz.css']);
?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
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
</body>
<?php

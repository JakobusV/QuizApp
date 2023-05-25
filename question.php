<?php
function GenerateQuestionElement($number, $question, $correctAnswer, $incorrectAnswers) {
    $answers = RandomizeOrder($correctAnswer, $incorrectAnswers);
    echo '
        <div class="question-box">
            <p>Question '. $number .':</p>
            <h2>'. $question .'</h2>
        </div>
        <div class="options-container">
            <button class="answer-btn">A. '. $answers[0] .'</button>
            <button class="answer-btn">B. '. $answers[1] .'</button>
            <button class="answer-btn">C. '. $answers[2] .'</button>
            <button class="answer-btn">D. '. $answers[3] .'</button>
        </div>
        <button class="option-btn">Submit Answer</button>';
}

function RandomizeOrder($correctAnswer, $incorrectAnswers) {
    $arr=array($correctAnswer);
    $answers = array_merge($arr, $incorrectAnswers);
    shuffle($answers);
    return $answers;
}
?>
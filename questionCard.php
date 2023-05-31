<?php

function GenerateQuestionBox($number=1, $question='none', $correctAnswer='none', $wrongAnswer1='none', $wrongAnswer2='none', $wrongAnswer3='none'){
    echo '
    <div id="question-card'. $number .'" class="question-card">
        <h3>Question '. $number .'</h3>
        <label for="title">Question</label>
        <input id="title" class="inputs" value="'. $question .'" />
        <div class="answer-box">
            <label for="title">Correct Answer</label>
            <input id="title" class="inputs" value="'. $correctAnswer .'" />
        </div>
        <div class="answer-box">
            <label for="title">Wrong Answer 1</label>
            <input id="title" class="inputs" value="'. $wrongAnswer1 .'"/>
        </div>
        <div class="answer-box">
            <label for="title">Wrong Answer 2</label>
            <input id="title" class="inputs" value="'. $wrongAnswer2 .'"/>
        </div>
        <div class="answer-box">
            <label for="title">Wrong Answer 3</label>
            <input id="title" class="inputs" value="'. $wrongAnswer3 .'"/>
        </div>
    </div>';
}
?>
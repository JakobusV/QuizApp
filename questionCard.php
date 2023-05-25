<?php
function GenerateQuestionBox($number=1, $question='none', $correctAnswer='none', $incorrectAnswers=array('none', 'none', 'none')){
    echo '
    <div class="question-card">
        <h3>Question '. $number .'</h3>
        <label for="title">Question</label>
        <input id="title" class="inputs" value="'. $question .'" />
        <div class="answer-box">
            <label for="title">Correct Answer</label>
            <input id="title" class="inputs" value="'. $correctAnswer .'" />
        </div>
        <div class="answer-box">
            <label for="title">Wrong Answer 1</label>
            <input id="title" class="inputs" value="'. $incorrectAnswers[0] .'"/>
        </div>
        <div class="answer-box">
            <label for="title">Wrong Answer 2</label>
            <input id="title" class="inputs" value="'. $incorrectAnswers[1] .'"/>
        </div>
        <div class="answer-box">
            <label for="title">Wrong Answer 3</label>
            <input id="title" class="inputs" value="'. $incorrectAnswers[2] .'"/>
        </div>
    </div>';
}
?>
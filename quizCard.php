<?php
function GenerateQuizCard($name, $color, $discription){
    return 
    '<a class="quiz-card" style="background-color: "'. $color .' href="./editQuiz.php">
        <div class="quiz-body">
            <div class="quiz-title">' . $name .'</div>
            <p>' . $discription .'</p>
        </div>
    </a>';
}
?>
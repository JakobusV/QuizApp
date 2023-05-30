<?php
if(array_key_exists("quizId", $_GET) && array_key_exists("name", $_GET) && array_key_exists("color", $_GET) && array_key_exists("description", $_GET)){
    echo GenerateQuizCard($_GET["quizId"], $_GET["name"], $_GET["color"], $_GET["description"]);
}
function GenerateQuizCard($quizId, $name, $color="#316bff", $discription="none"){
    return 
    '<a class="quiz-card" style="background-color: "'. $color .' href="./editQuiz.php?quiz_id="' . $quizId .'>
        <div class="quiz-body">
            <div class="quiz-title">' . $name .'</div>
            <p>' . $discription .'</p>
        </div>
    </a>';
}
?>
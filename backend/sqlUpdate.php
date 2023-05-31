<?php
include_once 'models.php';
include_once 'backendUtils.php';

header('Content-Type: application/json');

$json = '';

// Are we reading from a table?
if (array_key_exists("table", $_GET)) {
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    $destination = $_GET["table"];

    // Is it a valid table?
    if (IsValidTable($destination)) {
        // Valid destinations: user, quiz, question
        switch ($destination) {
            case "user":
                $json = userUpdate($data);
                break;
            case "quiz":
                $json = quizUpdate($data);
                break;
            case "question":
                $json = questionUpdate($data);
                break;
            default:
                $json = "Invalid Table";
        }

        // If the data sent was invalid caught by the insert methods
        if ($json == "Not Valid") {
            $json = "Wrong Data Passed";
        }
    } else {
        $json = "Invalid Table";
    }
}
echo $json;

#region Helper Methods
/**
 * Handle update of a user, validates all data is given
 * @param mixed $data Array of data key value pairs
 * @return string Result of update
 */
function userUpdate($data) {
    if (array_key_exists("userId", $data) && array_key_exists("userName", $data) && array_key_exists("userPassword", $data) && 
        array_key_exists("userAdminStatus", $data)) {
        $user = new user();
        $user->id = $data["userId"];
        $user->username = $data["userName"];
        $user->password = $data["userPassword"];
        $user->isAdmin = $data["userAdminStatus"];

        return AffectedRowsExecution($user->UpdateQuery());
    }
    return "Not Valid";
}

/**
 * Handle update of a quiz, validates all data is given
 * @param mixed $data Array of data key value pairs
 * @return string Result of update
 */
function quizUpdate($data) {
    if (array_key_exists("quizId", $data) && array_key_exists('color', $data) && array_key_exists("quizOwner", $data) && array_key_exists("quizTitle", $data)) {
        $quiz = new quiz();
        $quiz->id = $data["quizId"];
        $quiz->color = $data['color'];
        $quiz->userId = $data["quizOwner"];
        $quiz->title = $data["quizTitle"];

        return AffectedRowsExecution($quiz->UpdateQuery());
    }
    return "Not Valid";
}

/**
 * Handle update of a question, validates all data is given
 * @param mixed $data Array of data key value pairs
 * @return string Result of update
 */
function questionUpdate($data) {
    if (array_key_exists("questionId", $data) && array_key_exists("questionContainer", $data) && array_key_exists("question", $data) && 
        array_key_exists("rightAnswer", $data) && array_key_exists("wrongAnswer1", $data) && array_key_exists("wrongAnswer2", $data) && 
        array_key_exists("wrongAnswer3", $data)) {
        $question = new question();
        $question->id = $data["questionId"];
        $question->quizId = $data["questionContainer"];
        $question->content = $data["question"];
        $question->rightAnswer = $data["rightAnswer"];
        $question->wrongAnswer1 = $data["wrongAnswer1"];
        $question->wrongAnswer2 = $data["wrongAnswer2"];
        $question->wrongAnswer3 = $data["wrongAnswer3"];

        return AffectedRowsExecution($question->UpdateQuery());
    }
    return "Not Valid";
}
#endregion
?>
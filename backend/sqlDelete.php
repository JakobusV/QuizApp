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
                $json = userDelete($data);
                break;
            case "quiz":
                $json = quizDelete($data);
                break;
            case "question":
                $json = questionDelete($data);
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
 * Handle delete of a user, validates all data is given
 * @param mixed $data Array of data key value pairs
 * @return string Result of delete
 */
function userDelete($data) {
    if (array_key_exists("userId", $data)) {
        $user = new user();
        $user->id = $data["userId"];

        return AffectedRowsExecution($user->DeleteQuery());
    }
    return "Not Valid";
}

/**
 * Handle delete of a quiz, validates all data is given
 * @param mixed $data Array of data key value pairs
 * @return string Result of delete
 */
function quizDelete($data) {
    if (array_key_exists("quizId", $data)) {
        $quiz = new quiz();
        $quiz->id = $data["quizId"];

        return AffectedRowsExecution($quiz->DeleteQuery());
    }
    return "Not Valid";
}

/**
 * Handle delete of a question, validates all data is given
 * @param mixed $data Array of data key value pairs
 * @return string Result of delete
 */
function questionDelete($data) {
    if (array_key_exists("questionId", $data)) {
        $question = new question();
        $question->id = $data["questionId"];

        return AffectedRowsExecution($question->DeleteQuery());
    }
    return "Not Valid";
}
#endregion
?>
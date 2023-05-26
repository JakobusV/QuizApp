<?php
include_once 'models.php';
include_once 'backendUtils.php';

header('Content-Type: application/json');

$json = '';

// Are we reading from a table?
if (array_key_exists("table", $_GET)) {
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    if ($data == null) $data = array();
    $destination = $_GET["table"];

    // Is it a valid table?
    if (IsValidTable($destination)) {
        // Valid destinations: user, quiz, question
        switch ($destination) {
            case "user":
                $json = userSelect($data);
                break;
            case "quiz":
                $json = quizSelect($data);
                break;
            case "question":
                $json = questionSelect($data);
                break;
            default:
                $json = "Invalid Table";
        }

        // Check if we got data back?
        if ($json == "null" || $json == "")
            $json = "No Data Found";
    } else {
        $json = "Invalid Table";
    }
}
echo $json;

#region Helper Methods
/**
 * Retrieve all users
 * @return string Result of insertion
 */
function userSelect($data) {
    $user = new user();
    if (array_key_exists("userId", $data)) {
        return SelectExecution($user->SelectQuery(columns: array(), filters: array($user->CreateFilterExact("id", $data["userId"]))));
    } else {
        return SelectExecution($user->SelectQuery());
    }
}

/**
 * Retrieve all quizzes
 * @return string Result of insertion
 */
function quizSelect($data) {
    $quiz = new quiz();
    if (array_key_exists("quizId", $data)) {
        return SelectExecution($quiz->SelectQuery(columns: array(), filters: array($quiz->CreateFilterExact("id", $data["quizId"]))));
    } else {
        return SelectExecution($quiz->SelectQuery());
    }
}

/**
 * Retrieve all questions
 * @return string Result of insertion
 */
function questionSelect($data) {
    $question = new question();
    if (array_key_exists("quizId", $data)) {
        return SelectExecution($question->SelectQuery(columns: array(), filters: array($question->CreateFilterExact("quizId", $data["quizId"]))));
    } else if (array_key_exists("questionId", $data)) {
        return SelectExecution($question->SelectQuery(columns: array(), filters: array($question->CreateFilterExact("id", $data["questionId"]))));
    } else {
        return SelectExecution($question->SelectQuery());
    }
}
#endregion
?>
<?php
include_once 'models.php';
include_once 'backendUtils.php';

header('Content-Type: application/json');

$json = '';

// Are we reading from a table?
if (array_key_exists("table", $_GET)) {
    $destination = $_GET["table"];

    // Is it a valid table?
    if (IsValidTable($destination)) {
        // Valid destinations: user, quiz, question
        switch ($destination) {
            case "user":
                $json = userSelect();
                break;
            case "quiz":
                $json = quizSelect();
                break;
            case "question":
                $json = questionSelect();
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
function userSelect() {
    $user = new user();
    return SelectExecution($user->SelectQuery());
}

/**
 * Retrieve all quizzes
 * @return string Result of insertion
 */
function quizSelect() {
    $quiz = new quiz();
    return SelectExecution($quiz->SelectQuery());
}

/**
 * Retrieve all questions
 * @return string Result of insertion
 */
function questionSelect() {
    $question = new question();
    return SelectExecution($question->SelectQuery());
}
#endregion
?>
<?php

include_once 'models.php';
include_once 'backendUtils.php';

header('Content-Type: application/json');

$json = '';

// do we have a proper req param
if (array_key_exists('join', $_GET)) {
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    if ($data == null) $data = array();
    $destination = $_GET["join"];

    // is it a known join req
    switch ($destination) {
        case "profile":
            $json = profileJoin($data);
            break;
        case "questions":
            $json = questionsJoin($data);
            break;
        default:
            $json = '{"error":"invalid request"}';
    }
}

echo $json;

function profileJoin($data) {
    if (array_key_exists('username', $data)) {
        $username = $data['username'];
        // REALLY GROSS STRAIGHT UP SQL BUT USED TO PREVENT MERGE CONFLICS CAN BE GENERATED LATER BY MODEL
        $query = "SELECT JSON_OBJECT('id', q.id, 'userId', q.userId, 'title', q.title) as data FROM user u JOIN quiz q ON u.id=q.userId WHERE u.username='".$username."'";
        return SelectExecution($query);
    }
    else {
        return '[]';
    }
}

function questionsJoin($data) {
    if (array_key_exists('quizId', $data)) {
        $quizId = $data['quizId'];
        // Again gross sql
        $query = "SELECT JSON_OBJECT('id', qtn.id, 'title', q.title, 'content', qtn.content, 'rightAnswer', qtn.rightAnswer, 'wrong1', qtn.wrongAnswer1, 'wrong2', qtn.wrongAnswer2, 'wrong3', qtn.wrongAnswer3) as data FROM quiz q JOIN question qtn ON q.id=qtn.quizId WHERE q.id=".$quizId;
        return SelectExecution($query);
    }
    else {
        return '[]';
    }
}
?>
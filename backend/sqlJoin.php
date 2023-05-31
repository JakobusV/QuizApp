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
?>
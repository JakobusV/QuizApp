<?php
/**
 * Check for a $_POST
 *  Validate creds with sql, does this user exist
 *  if exist
 *      create session
 *      push them to profile page? if possible
 *  else
 *      stay on login
 *      maybe even send back something saying that they're really reaaaally dumb
*/
include_once 'utility.php';
include_once 'backend/models.php';
include_once 'backend/backendUtils.php';

header('Content-Type: application/json');

$json = '';
$body = file_get_contents('php://input');
$data = json_decode($body, true);

if (array_key_exists("username", $data)) {
    $username = $data["username"];
    $password = $data["password"];

    if(isset($username, $password)){
        $user = new user();
        $filters = [$user->CreateFilterExact('username', $username)];
        $filters[] = $user->CreateFilterExact('password', $password);
        $query = $user->SelectQuery(filters:$filters);
        $selectedUser = SelectExecution($query);
    }

    if($selectedUser != "[]"){
        $json = json_decode($selectedUser);
        $username = $json[0]->username;
        $isAdmin = $json[0]->isAdmin;

        include_once "utility.php";
        CreateSession($username, $isAdmin);
        echo "Login Validated";
    } else {
        echo "Login Invalid";
    }
}

?>
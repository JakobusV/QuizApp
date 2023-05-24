<?php
session_start();
function IsNullOrEmptyString($str){
    return ($str === null || trim($str) === '');
}

function DBConnection() {
    include 'personalConnectionDetails.php';

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ("Could not connect to the database server, make sure you've updated personalConnectionDetails.php " . mysqli_connect_error());

    return $con;
}

function GetCookie($name) {
    if (isset($_COOKIE[$name]))
        return $_COOKIE[$name];
    else 
        return null;
}
/*
Creates a new cookie
use for html style preferences
 */
function CreateCookie($name, $value, $lifetime){
    if(!isset($_COOKIE[$name])){
        setcookie($name, $value, time()+$lifetime, '/');
        return true;
    } else if ($_COOKIE[$name] != $value) {
        setcookie($name, $value, time()+$lifetime, '/');
    } else {
        return false;
    }
}
/*
Kills the given cookie
 */
function KillCookie($name){
    if(isset($_COOKIE[$name])){
        setcookie($name, "", time()-36000*10000000000, '/');
        return true;
    } else {
        return false;
    }
}
/**
 * Get all variables from session and return in a associative array
 */
function GetSession($name) {
    if (isset($_SESSION[$name]))
        return $_SESSION[$name];
    else 
        return null;
}
/**
 * Creates a new session
 */
//Use for account details
function CreateSession($name, $value){
    if(!isset($_SESSION[$name])){
        $_SESSION[$name] = $value;
        return true;
    } else {
        return false;
    }
}
/**
 * Destroys the given session */
function DestroySession($name){
    if(isset($_SESSION[$name])){
        unset($_SESSION[$name]);
        return true;
    } else {
        return false;
    }
}

function LoggedInConfirmed($username, $password, $auth) {
    if(!isset($_SESSION['current_user'])){
        CreateSession("current_user", array('username'=>$username, 'password'=>$password, 'auth'=>$auth));
    } else {
        //TODO: Handle re-login
    }
}

function GetUserPreferences($styleFilePath) {
    //TODO: Get user preference style from endpoint
    if(IsNullOrEmptyString($styleFilePath)){
        $styleFilePath = "defaultStyle.php";
    } else {
        CreateCookie("user_style_pref", $styleFilePath, 3600);
    }
}

function LoggedOut(){
    if(isset($_SESSION["current_user"])){
        DestroySession("current_user");
    }

    if(isset($_COOKIE["user_style_pref"])){
        KillCookie("user_style_pref");
    }
}
?>
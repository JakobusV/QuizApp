<?php
include_once 'header.php';
include_once 'utility.php';

CanIBeHere();
DestroySession('current_user');
header('Location: index.php');

?>
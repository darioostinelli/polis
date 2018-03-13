<?php
session_start();
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';
include_once 'components/Things.php';
include_once 'components/User.php';
include_once 'components/Family.php';

if (! isset($_POST['data'])) {
    header("Location: /");
    die();
}
if (! isset($_SESSION['user'])) {
    header("Location: /polis/");
    die('{"status":"error","error":"session is not set"}');
}
$user = new User($_SESSION['user']->username);
$data = json_decode($_POST['data']);
$setupUser = new User($data->username);
if(!$setupUser->exists()){
    die('{"status":"error","error":"User does not exist"}');
}
if($setupUser->getFamily() != $user->getFamily()){
    die('{"status":"error","error":"User does not belong to the same family"}');
}

$family = new Family($user->getFamily());
if($family->getAdminNumber() == 1) //family has only ONE admin. If you try to delete, retrun error
{
    if($setupUser->getUserTypeId() == User::$ADMIN_TYPE){
        die('{"status":"error","error":"Family must have at least one admin"}');
    }
}
if(!$setupUser->deleteUser()){
    die('{"status":"error","error":"Internal error"}');
}
else {
    if($setupUser->getUsername() == $user->getUsername()){
        echo '{"status":"success","logout":true}'; //user is deleting himself. Logout
    }
    else {
        echo '{"status":"success","logout":false}';//user is deleting another user. Do not logout
    }    
}
?>
<?php
    session_start();
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php/";
    ini_set('include_path', $includePath);
    include_once 'components/User.php';
    include_once 'components/Family.php';
    include_once 'components/DatabaseConnection.php';
    
    if(!isset($_POST["data"])){
        header("Location /polis/");
        die();
    } 
    $signupData = json_decode($_POST["data"]);
    $family = new Family($signupData->family);
    if(!$family->exists()){
        die('{"status":"error","error":"Family does not exist","showFamily":true}');
    }
    $user = new User($signupData->user);
    if($user->exists()){
        die('{"status":"error","error":"User already exists"}');
    }
    $db = new Database();
    $result = $db->query("SELECT * FROM users WHERE email='".$signupData->email."'");
    if(count($result) > 0){
        die('{"status":"error","error":"Email is already used"}');
    }
    $sql = "INSERT INTO `users`(`family_tag`, `user_name`, `password`, `user_type`, `email`) VALUES ('".$signupData->family."','".$signupData->user."','".$signupData->pass."', 1 ,'".$signupData->email."')";
    $result = $db->query($sql);
    if($result){
        echo '{"status":"success"}';
        $_SESSION['user'] = $user;
    }
    else{
        die('{"status":"error","error":"Server error, please try later"}');
    }
?>
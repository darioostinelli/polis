<?php  

   session_start();
   
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/User.php';
    if(!isset($_POST["data"])){
        header("Location: /polis/");
        die();
    }
    $loginData = json_decode($_POST["data"]);
    $user = new User($loginData->user);
    if(!$user->exists()){
        die('{"status":"error","error":"user does not exist"}');
    }
   if(!$user->controlValidation($loginData->pass)){
        die('{"status":"error","error":"wrong password "}');
   }
   else{
       echo '{"status":"success"}';
       $_SESSION['user'] = $user->getUser();
   }
?>
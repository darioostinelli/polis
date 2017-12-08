<?php
    use php\components\EmailSender;

session_start();
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php/";
    ini_set('include_path', $includePath);
    include_once 'components/User.php';
    include_once 'components/Family.php';
    include_once 'components/DatabaseConnection.php';
    include_once 'components/EmailSender.php';
    if(!isset($_POST["data"])){
        header("Location /polis/");
        die();
    }
    $signupData = json_decode($_POST["data"]);
    $family = new Family($signupData->family);
    $user = new User($signupData->user);
    if($user->exists()){
        die('{"status":"error","error":"User already exists"}');
    }
    $db = new Database();
    $result = $db->query("SELECT * FROM users WHERE email='".$signupData->email."'");
    if(count($result) > 0){
        die('{"status":"error","error":"Email is already used"}');
    }
    
    $tag = substr(crypt($signupData->family,substr($signupData->family, 0, 2)), 1);
    $sql = "SELECT * FROM families WHERE tag='".$tag."'";
    $result = $db->query($sql);
    while(count($result) != 0){
        $tag = crypt($tag,substr($tag, 0, 2));
        $sql = "SELECT * FROM families WHERE tag='".$tag."'";
        $result = $db->query($sql);
    }
    
    $sql = "INSERT INTO `families`(`name`, `tag`) VALUES ('".$signupData->family."','".$tag."')";
    $result = $db->query($sql);
    
    if(!$result){
        die('{"status":"error","error":"Database error. Try later"}');
    }
    
    $sql = "INSERT INTO `users`(`family_tag`, `user_name`, `password`, `user_type`, `email`) VALUES ('".$tag."','".$signupData->user."','".$signupData->pass."', 1 ,'".$signupData->email."')";
    //default user type is admin
    $result = $db->query($sql);
    if($result){
        echo '{"status":"success"}';
        $_SESSION['user'] = $user->getUser();
        $email = new EmailSender($signupData->email);
        $email->sendFamilyTagEmail("Welcom to Polis", $tag);  
    }
    else{
        die('{"status":"error","error":"Server error, please try later"}');
    }
?>
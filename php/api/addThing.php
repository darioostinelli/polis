<?php 
    session_start();
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/DatabaseConnection.php';
    include_once 'components/Things.php';
    include_once 'components/User.php';
    include_once 'components/Family.php';
    
    if(!isset($_POST['data'])){
        header("Location: /");
        die();
    }
    if(!isset($_SESSION['user'])){
        header("Location: /polis/");
        die('{"status":"error","error":"session is not set"}');
    }
    $user = new User($_SESSION['user']->username);
    $data = json_decode($_POST['data']);
    if($user->getAccessLevel() >=2 ) //user is guest-type
    {
        die('{"status":"error","error":"you cannot create a thing"}');
    }
    $thing = new Thing($data->tag);
    if($thing->exists() || strlen($data->tag) != 12){
        die('{"status":"error","error":"Wrong thing tag. Please check if you have inserted a correct tag"}');
    }
  
    if($thing->createThing($data->name, $data->userType, $user->getFamily(), $data->tag)){
        echo '{"status":"success"}';
    }
    else{
        echo '{"status":"error","error":"internal error"}';
    }
?>
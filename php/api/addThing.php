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
    

    $tag = substr(crypt($data->name,substr($data->name, 0, 2)), 1);
    $thing = new Thing($tag);
    while($thing->exists()){
        $tag = crypt($tag,substr($tag, 0, 2));
        $thing = new Thing($tag);
    }
    if($thing->createThing($data->name, $data->userType, $user->getFamily(), $tag)){
        echo '{"status":"success"}';
    }
    else{
        echo '{"status":"error","error":"internal error"}';
    }
?>
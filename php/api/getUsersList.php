<?php
    session_start();
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/DatabaseConnection.php';
    include_once 'components/Things.php';
    include_once 'components/User.php';
    include_once 'components/Family.php';
    
    if(!isset($_GET['data'])){
        header("Location: /");
        die();
    }
    if(!isset($_SESSION['user'])){
        header("Location: /polis/");
        die('{"status":"error","error":"session is not set"}');
    }
    $family = new Family($_SESSION['user']->family);
    if(!$family->exists()){        
        die('{"status":"error","error":"family does not exist"}');
    }
    $list = $family->getUserList();
    $userList = array();
    
    foreach ($list as $user){
        array_push($userList, $user->getUser());
    }
    echo json_encode($userList);
?>
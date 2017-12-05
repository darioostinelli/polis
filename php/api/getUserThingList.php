<?php
    session_start();
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/DatabaseConnection.php';
    include_once 'components/Things.php';
    include_once 'components/User.php';
   
    if(!isset($_GET['data'])){
        header("Location: /");
        die();
    }
    if(!isset($_SESSION['user'])){
        header("Location: /polis/");
        die();
    }
    $user = new User($_SESSION['user']->username);
    $list = $user->getThingList();
    $thingList = array();
    
    foreach ($list as $thing){
        array_push($thingList, $thing->getThing());
    }
    echo json_encode($thingList);
?>
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
    if(isset($_SESSION['thingList'])){
        //return cached data
        $cacheUser = $_SESSION['thingList']->user;
        $sessionUser = $_SESSION['user']->username;
        if($cacheUser == $sessionUser)
            die(json_encode($_SESSION['thingList']->data));
    }
    $user = new User($_SESSION['user']->username);
    $list = $user->getThingList();
    $thingList = array();
    
    foreach ($list as $thing){
        array_push($thingList, $thing->getThing());
    }
    echo json_encode($thingList);
?>
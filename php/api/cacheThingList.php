<?php
    session_start();
    if(!isset($_POST['data'])){
        die('{"status":"error","error":"no data in POST"}');
    }
    $data = json_decode($_POST['data']);
    $thingList = (object) array();
    $thingList->user = $_SESSION['user']->username;
    $thingList->data = $data;
    $_SESSION['thingList'] = $thingList;

?>
<?php
    
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);    
    include_once 'components/User.php';   
    include_once 'components/Things.php';
    $thing = new Thing("aaaaaaaaaaaa");
    echo json_encode($thing->getThing());
    $user = new User("guest");
    echo json_encode($user->hasAccessTo($thing));
?>
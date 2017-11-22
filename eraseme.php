<?php
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    
    include_once 'components/Family.php';
    $family = new Family("123456789012");
   
     $thingList =   $family->getThingList();
    foreach ($thingList as $thing){
         echo json_encode($thing->getThing());
     }
      echo "<br><br>";
  /*   $userList =   $family->getUserList();
     foreach ($userList as $user){
         echo json_encode($user->getUser());
     }*/
    
     echo "<br><br>";
     //echo json_encode($userList[0]->hasAccessTo($thingList[1]));
    
?>
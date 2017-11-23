<?php
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    
    include_once 'components/Family.php';
    include_once 'components/User.php';
   /* $family = new Family("123456789012");
   
     $thingList =   $family->getThingList();
    foreach ($thingList as $thing){
         echo json_encode($thing->getThing())."<br>";
     }
      echo "<br><br>";
     $userList =   $family->getUserList();
     foreach ($userList as $user){
         echo json_encode($user->getUser());
     }
    
     echo "<br><br>";
     echo "User:  ".$userList[3]->getUsername()." has access to Thing: ".$thingList[1]->getName()." ==> ".json_encode($userList[3]->hasAccessTo($thingList[1]));
    */
    $user = new User("user");
    $thingListUser = $user->getThingList();
    foreach ($thingListUser as $thing){
        echo json_encode($thing->getThing())."<br>";
    }
?>
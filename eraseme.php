<?php
    use php\components\EmailSender;
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);    
    include_once 'components/EmailSender.php';   
    $email = new EmailSender("daostinelli@gmail.com");
    $email->sendFamilyTagEmail("Prova", "abcdefgher");  
    
?>
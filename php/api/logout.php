<?php
    session_start();
    if(!isset($_POST["data"])){        
        die('{"status":"error"}');
    } 
    session_unset();
    session_destroy();
    echo '{"status":"success"}';
?>
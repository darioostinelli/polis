<?php
    use php\components\Metric;
    session_start();
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/DatabaseConnection.php';
    include_once 'components/Things.php';
    include_once 'components/User.php';
    include_once 'components/Metric.php';
   
    if(!isset($_GET['data'])){
        header("Location: /");
        die();
    }
    if(!isset($_SESSION['user'])){
        header("Location: /polis/");
        die();
    }
    $sessionUser = new User($_SESSION['user']->username);
    $data = json_decode($_GET['data']);
    
    if(isset($data->user)){ //get all active alerts
        $user = new User($data->user);
        if($sessionUser->getFamily() == $user->getFamily()){
            echo json_encode($user->getFailureList());
        }
        else{
            echo '{"status":"error","error":"User does not belong to the same family"}';
        }
    }
    else if(isset($data->thingTag)){ //get all active alert bound to the thing
        $thing = new Thing($data->thingTag);
        if($sessionUser->hasAccessTo($thing)){
            echo json_encode($thing->getFailureList());
        }
        else {
            echo '{"status":"error","error":"User has not access to this thing"}';
        }
    }
    else if(isset($data->metricTag)){
        $metric = new Metric($data->metricTag);
        $thing = new Thing($metric->getThingTag());
        if($user->hasAccessTo($thing)){
            echo json_encode($metric->getFailureList());
        }
        else{
            echo '{"status":"error","error":"User has not access to this metric"}';
        }
    }
    else{
        echo '{"status":"error","error":"Error in data"}';
    }
    
?>
<?php 
    use php\components\Metric;

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
    
    $user = new User($_SESSION['user']->username);
    $data = json_decode($_GET['data']);   
    $metric = new Metric($data->metricTag);
    $thing = new Thing($metric->getThingTag());
    if(!$metric->exists()){
        die('{"status":"error","error":"Metric does not exist"}');
    }
    if(!$user->hasAccessTo($thing)){
        die('{"status":"error","error":"You cannot access this thing"}');
    }
    $log = $metric->getLastValue();
    echo json_encode($log);
    
    
?>
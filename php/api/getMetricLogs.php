<?php 
    session_start();
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/DatabaseConnection.php';
    include_once 'components/Things.php';
    include_once 'components/User.php';
    include_once 'components/Family.php';
    
    if(!isset($_POST['data'])){
        header("Location: /");
        die();
    }
    if(!isset($_SESSION['user'])){
        header("Location: /polis/");
        die('{"status":"error","error":"session is not set"}');
    }
    $user = new User($_SESSION['user']->username);
    $data = json_decode($_POST['data']);
    $thing = new Thing($data->thingTag);
    if(!$user->hasAccessTo($thing)){
        die('{"status":"error","error":"you cannot access this thing"}');
    }
    $metricList = $thing->getMetrics();    
    if(count($metricList) == 0){
        die('{"status":"error","error":"thing have no metric"}');
    }
    $metricLogs = $thing->getMetricLogs();
    if(count($metricLogs) == 0){
        die('{"status":"error","error":"thing have no metric log"}');
    }
    $logs = array();   
    foreach($metricList as $metric){
       $temp = new stdClass();
       $temp->metric = $metric->name;
       $temp->unit = $metric->unit;
       $temp->list = $thing->getMetricLogsByMetricDefinition($metric->metric_tag);
      
       array_push($logs, $temp);
    }
    echo json_encode($logs);
?>
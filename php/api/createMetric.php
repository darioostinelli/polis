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
    include_once 'components/Metric.php';
    
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
    if(!$thing->exists()){
        die('{"status":"error","error":"thing does not exist"}');
    }
    if(!$user->hasAccessTo($thing)){
        die('{"status":"error","error":"you have not access to this thing"}');
    }
    if(strlen($data->metricTag) != 12){
        die('{"status":"error","error":"Wrong Tag"}');
    }
    $metric = new Metric(0);
    if($metric->createMetric($data->thingTag, $data->name, $data->unit, $data->metricTag))
        echo '{"status":"success"}';
    else
        echo '{"status":"error","error":"Internal error"}';
?>
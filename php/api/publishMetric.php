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


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
//data: {thingTag:"aaaaaaaaaaaa",metricTag:"bbbbbbbbbbbb",value:5}
$data = json_decode($_POST['data']);
$thing = new Thing($data->thingTag);
if(!$thing->exists()){
    die('{"status":"error","error":"thing does not exist"}');
}
if(!$thing->hasMetric($data->metricTag)){
    die('{"status":"error","error":"thing has not '.$data->metricTag.' metric"}');
}
if(!$thing->publishMetricLog($data->metricTag, $data->value)){
    die('{"status":"error","error":"database error"}');
}
else{
    echo '{"status":"success"}';
}
?>
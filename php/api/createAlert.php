<?php
use php\components\Metric;
use php\components\Alert;
session_start();
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';
include_once 'components/Things.php';
include_once 'components/User.php';
include_once 'components/Family.php';
include_once 'components/Metric.php';

if (! isset($_POST['data'])) {
    header("Location: /");
    die();
}
if (! isset($_SESSION['user'])) {
    header("Location: /polis/");
    die('{"status":"error","error":"session is not set"}');
}
$user = new User($_SESSION['user']->username);
$data = json_decode($_POST['data']);
$metric = new Metric($data->metricTag);
if (! $metric->exists()) {
    die('{"status":"error","error":"Metric does not exist"}');
}
$thingTag = $metric->getThingTag();
$thing = new Thing($thingTag);
if (! $user->hasAccessTo($thing)) {
    die('{"status":"error","error":"You cannot access this thing"}');
}
$alert = new Alert("1");
if ($data->value == "") {
    die('{"status":"error","error":"Invalid Value"}');
}
if (! $alert->createAlert($data->type, $data->rule, $data->value, $data->metricTag)) {
    die('{"status":"error","error":"Internal error"}');
} else {
    die('{"status":"success"}');
}
echo '{"status":"error","error":"Internal error"}';
?>
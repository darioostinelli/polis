<?php
    
    use php\components\Timestamp;
use php\components\Metric;

    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);   
    include_once 'components/Timestamp.php';
     
    include_once 'components/Things.php';
    include_once 'components/Metric.php';
    $thing =  new Thing("aaaaaaaaaaaa");
    
    $metrics = $thing->getMetrics();
    $metricLogs = $thing->getMetricLogs();
    $metric = new Metric($metrics[0]->metric_tag);
    echo json_encode($thing->getMetricLogsByMetricDefinition("baaaaaaaaaaa"));
 
?>
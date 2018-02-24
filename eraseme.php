<?php
    use php\components\Timestamp;
    use php\components\Metric;
    use php\components\Alert;
    
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/Timestamp.php';
    
    include_once 'components/Alert.php';
    include_once 'components/Metric.php';
    $metric = new Metric("aaaaaaaaaaaa");
    $alert = new Alert(2);
    $logs = $metric->getUncheckedMetricLogs();
    echo json_encode($metric->getAllAlerts());
?>
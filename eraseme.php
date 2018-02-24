<?php
    use php\components\Timestamp;
    use php\components\Metric;
    use php\components\Alert;
    
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/Things.php';
    include_once 'components/Alert.php';
    include_once 'components/Metric.php';
    $thing = new Thing("aaaaaaaaaaaa");
    $thing->getAllActiveAlerts();
?>
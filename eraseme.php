<?php
    
    use php\components\Metric;

    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);   
     
    include_once 'components/Things.php';
    include_once 'components/Metric.php';
    $thing = new Thing("aaaaaaaaaaaa");
    echo json_encode($thing->getMetrics());
   
    
  
?>
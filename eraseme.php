<link rel="stylesheet" type="text/css" href="/polis/styles/polis.css">
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<script src="/polis/js/librerie/jquery-3.2.1.js"></script>
<script src="/polis/js/componenti/mainPage.js"></script>
<script src="/polis/js/funzioni/mainPage.js"></script>
<?php
    use php\components\Timestamp;
    use php\components\Metric;
    use php\components\Alert;
use php\components\PageBuilder;
    
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/Things.php';
    include_once 'components/Alert.php';
    include_once 'components/Metric.php';   
    include_once 'components/User.php'; 
    include_once 'components/PageBuilder.php'; 
    $thing = new Thing("aaaaaaaaaaaa");
    $failures = $thing->getFailureList();
    $alerts = $thing->getAllActiveAlerts();    
  
   
    $pb = new PageBuilder("aa");
    echo $pb->buildThingPageFailuresList($failures);
?>
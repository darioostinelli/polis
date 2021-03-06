<?php
use php\components\PageBuilder;

session_start();
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';
include_once 'components/Things.php';
include_once 'components/User.php';
include_once 'components/PageBuilder.php';
if(!isset($_SESSION['user'])){
    header("Location: /");
    die();
}
if(!isset($_GET['tag'])){
    header("Location: /polis/dashboard/mainPage.php");
    die();
}
$user = new User($_SESSION['user']->username);
$thing = new Thing($_GET['tag']);
if(!$thing->exists()){
    header("Location: /polis/dashboard/mainPage.php");
    die();
}
if(!$user->hasAccessTo($thing)){
    header("Location: /polis/dashboard/mainPage.php");
    die();
}
$pageBuilder = new PageBuilder($user);
$menuItems = $pageBuilder->buildMenu("MIAN_PAGE");
$failures = $user->getFailureList();
$activeAlerts = $user->getAllActiveAlerts();
$thingAlerts = $thing->getAllActiveAlerts();
$thingFailures = $thing->getFailureList();
// echo json_encode($_SESSION['user']);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Polis Dashboard</title>
<link rel="stylesheet" type="text/css" href="/polis/styles/polis.css">
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<script src="/polis/js/librerie/jquery-3.2.1.js"></script>
<script src="/polis/js/componenti/mainPage.js"></script>
<script src="/polis/js/funzioni/mainPage.js"></script>
<script src="/polis/js/componenti/thing.js"></script>
<script src="/polis/js/componenti/chart.js"></script>
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="/polis/js/librerie/lodash.js"></script>
<link rel="shortcut icon" href="/polis/logo.ico" />
<script>
var thing;
	$().ready(function(){
	    thing = new thingHandler();
		thing.getLogsByMetrics();
		});
</script>
</head>
<body style="background: #333333">
	<div class="loading-panel" style="display:none"><!-- TODO: remove style -->
		<div class="load-container" > 
			<img src="/polis/src/img/icons/loading.gif"><br>
			<h2>Loading...</h2>
		</div>
	</div>
	<div class="main-page">
		<div class="menu shadow">
			<div class="menu-item header-menu">
				<img src="/polis/src/img/logos/polis-logo.png" />
			</div>
			<div class="menu-item only-mobile-block" onclick="logout()">Logout</div>
			<div class="menu-item selected-menu">Things</div>
			<?php  echo $menuItems; ?>
			
		</div>
		<div class="dashboard">
			<div class="header only-desktop shadow">
				<?php echo $pageBuilder->buildMainPageAlerts($activeAlerts, $failures); ?>
				<div class="header-element logout-button" onclick="logout()">Logout</div>
			</div>
			<div class="notice-board shadow">			
				<h2 class="template-title"><a href="/polis/dashboard/mainPage.php">Things List</a> > <?php echo $thing->getName();?></h2>
				<div class="tab-menu">
					<div class="tab-menu-element" onclick="thing.switchTab(this);">Metrics</div>
					<div class="tab-menu-element" onclick="thing.switchTab(this);">Active Alerts</div>
					<div class="tab-menu-element" onclick="thing.switchTab(this);">Failures</div>
				
				</div>
				<div class="alert" onclick="$(this).hide(100)"></div>
				<!-- Metrics tab -->
				<div class="hidden-tab" style="display:block">
					<h3 class="template-title">Metrics</h3>
    				<?php  echo '<span style="color:white; margin-left:20px">Display:</span> '.$pageBuilder->buildChartDisplayOptionsDropdown();?>
    				<div>    				
        				<div id="metrics-container"></div>
    				</div>
				</div>
				<!-- Alerts tab -->
				<div class="hidden-tab">
					<h3 class="template-title">Alerts</h3>
    				<?php echo $pageBuilder->buildThingPageAlerts($thingAlerts)?>
    				
				</div>
				<!-- Failures tab -->
				<div class="hidden-tab">
					<h3 class="template-title">Failures</h3>
    				<?php echo $pageBuilder->buildThingPageFailuresList($thingFailures)?>
    				
				</div>
			</div>
		</div>
    	
	</div>
		<!-- TODO: add footer-->

</body>
</html>

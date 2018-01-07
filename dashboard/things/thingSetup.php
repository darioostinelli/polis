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
$menuItems = $pageBuilder->buildMenu("THING_SETUP_PAGE");
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
<script src="/polis/js/componenti/thingSetup.js"></script>
<script src="/polis/js/funzioni/mainPage.js"></script>
<link rel="shortcut icon" href="/polis/logo.ico" />
<script>
	var page = new thingSetupHandler();
	$().ready(function(){
			$('#save-thing').click(page.saveThing);
			$("input").on("focus", function() {
				   page.elementModified();
				});
			page.getMetrics();
			
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
			<a href="/polis/dashboard/mainPage.php"><div class="menu-item">Things</div></a>
			<?php  echo $menuItems; ?>
			
		</div>
		<div class="dashboard">
			<div class="header only-desktop shadow">
				<div class="header-element" onclick="logout()">Logout</div>
			</div>
			<div class="notice-board shadow">
				<h2 class="template-title"><a href="/polis/dashboard/things/thingsSetup.php">Thing Setup</a> > <?php echo $thing->getName()?></h2>
				<div class="alert" onclick="$(this).hide(100)"></div>
				<div class="tab-menu">
					<div class="tab-menu-element" onclick="page.switchTab(this)">Thing</div>
					<div class="tab-menu-element" onclick="page.switchTab(this)">Metrics</div>
					<div class="tab-menu-element" onclick="page.switchTab(this)">Add Metric</div>
				</div>
				<!-- Setup tab -->
				<div class="hidden-tab" style="display:block">
					<h3 class="template-title">Thing setup</h3>
    				<table class="table-template">
        				<tr style="background: #dedede; color: black"><th>Thing Tag</th><td id="tag"><?php echo $thing->getTag()?></td></tr>
        				<tr><th>Thing Name</th><td><?php echo '<input id="name" type="text" value="'.$thing->getName().'" placeholder="Thing Name"/>';?></td></tr>
    				</table>
    				<button disabled="disabled"class="save-button" id="save-thing">Save</button>
				</div>
				<!-- Metrics tab -->
				<div class="hidden-tab">
					<h3 class="template-title">Metrics</h3>
    				<table class="table-template" id="metrics-table">  
    					<tr style="background: #dedede; color: black"><th>Metric Name</th><th>Unit</th></tr>      				
        				
    					
    				</table>
    				<button class="save-button" onclick="page.switchTab(this)" >Add</button>
				</div>
				<!-- Add Metrics tab -->
				<div class="hidden-tab">
					<h3 class="template-title">Add Metric</h3>
    				<table class="table-template">        				
        				<tr style="background: #dedede; color: black"><th>Metric Name</th><td><?php echo '<input id="metric-name" type="text" value="" placeholder="Metric Name"/>'?></td></tr>
    					<tr><th>Unit</th><td><?php echo '<input id="metric-unit" type="text" value="" placeholder="Unit"/>'?></td></tr>
    				</table>
    				<button disabled="disabled"class="save-button" id="save-metric">Save</button>
				</div>
			</div>
		</div>
    	
	</div>
		<!-- TODO: add footer-->

</body>
</html>

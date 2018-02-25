<?php
use php\components\PageBuilder;
use php\components\Metric;

session_start();
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';
include_once 'components/Things.php';
include_once 'components/User.php';
include_once 'components/PageBuilder.php';
include_once 'components/Metric.php';
if (! isset($_SESSION['user'])) {
    header("Location: /");
    die();
}
if (! isset($_GET['metric_tag'])) {
    header("Location: /polis/dashboard/mainPage.php");
    die();
}
$user = new User($_SESSION['user']->username);
$metric = new Metric($_GET['metric_tag']);
if (! $metric->exists()) {
    header("Location: /polis/dashboard/mainPage.php");
    die();
}
$thing = new Thing($metric->getThingTag());
if (! $user->hasAccessTo($thing)) {
    header("Location: /polis/dashboard/mainPage.php");
    die();
}
$pageBuilder = new PageBuilder($user);
$pageBuilder->controlAccessLevel(1); // user type: user or above;
$menuItems = $pageBuilder->buildMenu("THING_SETUP_PAGE");
$failures = $user->getFailureList();
$activeAlerts = $user->getAllActiveAlerts();
// echo json_encode($_SESSION['user']);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Polis Dashboard</title>
<link rel="stylesheet" type="text/css" href="/polis/styles/polis.css">
<link href="https://fonts.googleapis.com/css?family=Poppins"
	rel="stylesheet">
<script src="/polis/js/librerie/jquery-3.2.1.js"></script>
<script src="/polis/js/funzioni/mainPage.js"></script>
<script src="/polis/js/componenti/mainPage.js"></script>
<script src="/polis/js/componenti/thingSetup.js"></script>
<script src="/polis/js/funzioni/mainPage.js"></script>
<link rel="shortcut icon" href="/polis/logo.ico" />
<script>
	var page = new thingSetupHandler();
	$().ready(function(){
		$('#save-alert').click(page.saveAlert);
			$("input, select").on("focus", function() {
				   page.elementModified();
				});
			
			
		});
</script>
</head>
<body style="background: #333333">
	<div class="loading-panel" style="display: none">
		<!-- TODO: remove style -->
		<div class="load-container">
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
				<?php echo $pageBuilder->buildMainPageAlerts($activeAlerts, $failures); ?>
				<div class="header-element logout-button" onclick="logout()">Logout</div>
			</div>
			<div class="notice-board shadow">
				<h2 class="template-title">
					<a href="/polis/dashboard/things/thingsSetup.php">Thing Setup</a>   <?php echo " <a href='/polis/dashboard/things/thingSetup.php?tag=".$thing->getTag()."'> >".$thing->getName()." </a>" ?>> <?php echo $metric->getName()?></h2>
				<div class="alert" onclick="$(this).hide(100)"></div>
				<div class="tab-menu">
					<div class="tab-menu-element" onclick="page.switchTab(this)">Alerts
						List</div>
					<div class="tab-menu-element" onclick="page.switchTab(this)">Add
						Alert</div>
					<div class="tab-menu-element" onclick="page.switchTab(this)">Failures
						Log</div>
				</div>
				<!-- Alerts list tab -->
				<div class="hidden-tab" style="display: block">
					<h3 class="template-title">Alerts List</h3>
					<table class="table-template">
						<tr>
							<th>TypeRule
							
							<th>
							
							<th>Value</th>
						</tr>
    					<?php echo $pageBuilder->buildAlertsPageAlertsList($metric->getTag())?>
        			</table>

				</div>
				<!-- add alert tab -->
				<div class="hidden-tab">
					<h3 class="template-title">Add Alert</h3>
					<table class="table-template">
						<tr style="background: #dedede; color: black">
							<th>Type</th>
							<td>
    							<?php echo $pageBuilder->buildAlertTypeDropdown("alert-type")?>
    						</td>
						</tr>
						<tr>
							<th>Rule</th>
							<td>
        						<?php echo $pageBuilder->buildAlertRuleDropDown("alert-rule")?>
        					</td>
						</tr>
						<tr>
							<th>Unit</th>
							<td><input id="alert-value" type="number" value=""
								placeholder="Value" /></td>
						</tr>
					</table>
					<button class="save-button" id="save-alert">Add</button>
				</div>
				<!-- failure log tab -->
				<div class="hidden-tab">
					<h3 class="template-title">Failures Log</h3>
					<table class="table-template">

					</table>

				</div>

			</div>
		</div>

	</div>
	<!-- TODO: add footer-->

</body>
</html>

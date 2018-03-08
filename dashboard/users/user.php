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
if (! isset($_SESSION['user'])) {
    header("Location: /");
    die();
}
if (! isset($_GET['username'])) {
    header("Location: /polis/dashboard/mainPage.php");
    die();
}
$user = new User($_SESSION['user']->username);
$setupUser = new User($_GET['username']);
if (! $setupUser->exists()) {
    header("Location: /polis/dashboard/mainPage.php");
    die();
}
$pageBuilder = new PageBuilder($user);
$pageBuilder->controlAccessLevel(0); // user type: user or above;
$menuItems = $pageBuilder->buildMenu("USER_SETUP_PAGE");
$failures = $user->getFailureList();
$activeAlerts = $user->getAllActiveAlerts();

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
<script src="/polis/js/componenti/userSetup.js"></script>
<script src="/polis/js/funzioni/mainPage.js"></script>
<link rel="shortcut icon" href="/polis/logo.ico" />
<script>
	var page = new userSetupHandler();
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
					<a href="/polis/dashboard/users/userSetup.php">User Setup</a> > <?php echo $setupUser->getUsername();?></h2>
				<div class="alert" onclick="$(this).hide(100)"></div>
				<table class="table-template" id="user-setup">
					<tr style="background: #dedede; color: black">
						<th>Username
						<td><?php echo $setupUser->getUsername();?>
					</tr>
					<tr>
						<th>Access Level</th>
						<td><?php echo $pageBuilder->buildAccessLevelDropdown($setupUser->getUserTypeId());?></td>
					</tr>
				</table>
					<button class="save-button" onclick="page.saveChanges()">Save</button>
					<button class="save-button" onclick="page.deleteUser()">Delete User</button>

			</div>
		</div>

	</div>
	<!-- TODO: add footer-->

</body>
</html>

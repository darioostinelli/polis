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
$user = new User($_SESSION['user']->username);
$pageBuilder = new PageBuilder($user);
$menuItems = $pageBuilder->buildMenu("THING_SETUP_PAGE");
// echo json_encode($_SESSION['user']);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Polis Dashboard - Things Setup</title>
<link rel="stylesheet" type="text/css" href="/polis/styles/polis.css">
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<script src="/polis/js/librerie/jquery-3.2.1.js"></script>
<script src="/polis/js/componenti/mainPage.js"></script>
<script src="/polis/js/funzioni/mainPage.js"></script>
<link rel="shortcut icon" href="/polis/logo.ico" />
<script>
	var page = new mainPageHandler();
	$().ready(function(){		
		page.getThingList();
	});
</script>
</head>
<body style="background: #333333">
	<div class="loading-panel">
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
			<div class="menu-item only-mobile-block logout-button" onclick="logout()">Logout</div>
			<div class="menu-item" onclick="goToPage('mainPage.php')">Things</div>
			<?php  echo $menuItems; ?>
			
		</div>
		<div class="dashboard">
			<div class="header only-desktop shadow">
				<div class="header-element logout-button" onclick="logout()">Logout</div>
			</div>
			<div class="notice-board shadow">
				<h2 class="template-title">Things Setup</h2>
			</div>
		</div>
    	
	</div>
		<!-- TODO: add footer-->

</body>
</html>

<?php
?>
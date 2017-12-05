<?php 
    session_start();
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/DatabaseConnection.php';
    include_once 'components/Things.php';
    include_once 'components/User.php';
    
    if(!isset($_SESSION['user'])){
        header("Location: /");
        die();
    }     
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
<link rel="shortcut icon" href="/polis/logo.ico" />
<script>
	var page = new mainPageHandler();
	$().ready(function(){
		//page.getThingList();
		$(".loading-panel").hide(); //TODO: remove this line
	});
</script>
</head>
<body>
	<div class="loading-panel">
		<div class="load-container">
			<img src="/polis/src/img/icons/loading.gif"><br>
			<h2>Loading...</h2>
		</div>
	</div>
	<div class="main-page">
		<div class="menu shadow">
			<div class="logo-container only-desktop">
				<img src="/polis/src/img/logos/polis-logo.png" />
				
			</div>
			<!--TODO: Menù da generare tramite script PHP -->
			<div class="menu-item only-mobile-block">
				<img src="/polis/src/img/logos/polis-logo.png" />
			</div>
			<div class="menu-item only-mobile-block">Logout</div>
			<div class="menu-item">Elem</div>
			<div class="menu-item">Elem</div>
			<div class="menu-item">Elem</div>
			<div class="menu-item">Elem</div>
		</div>
		<div class="dashboard">
			<div class="header only-desktop shadow">
				<div class="header-element logout">Logout</div>
			</div>
			<div class="notice-board">
				<div class="row">
					<div class="cell thing-template shadow">aaaa</div>
					<div class="cell thing-template shadow">aaaa</div>
				</div>
				<div class="row">
					<div class="cell thing-template shadow">aaaa</div>
					<div class="cell thing-template shadow">aaaa</div>
				</div>
				<div class="row">
					<div class="cell thing-template shadow">aaaa</div>
					
				</div>
			</div>
		</div>
		
	</div>
	<div class="dashboard-footer">
		Polis - IoT Solution<br>
		Dario Ostinelli - 2018
	</div>
</body>
</html>

<?php
?>
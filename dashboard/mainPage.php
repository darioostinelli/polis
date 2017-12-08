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
		//$(".loading-panel").hide();
		page.getThingList();
		//page.addThing("aaaa");
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
			
			<!--TODO: Menù da generare tramite script PHP -->
			<div class="menu-item ">
				<img src="/polis/src/img/logos/polis-logo.png" />
			</div>
			<div class="menu-item only-mobile-block">Logout</div>
			<div class="menu-item selected-menu">Things</div>
			<div class="menu-item">Elem</div>
			<div class="menu-item">Elem</div>
			<div class="menu-item">Elem</div>
		</div>
		<div class="dashboard">
			<div class="header only-desktop shadow">
				<div class="header-element">Logout</div>
			</div>
			<div class="notice-board">
				
			</div>
		</div>
    	
	</div>
		<!-- TODO: add footer-->

</body>
</html>

<?php
?>
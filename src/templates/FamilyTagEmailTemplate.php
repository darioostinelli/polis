<div style="position: fixed;
    top: 0%;
    left: 0;
    right: 0;
    margin: auto;
    padding: 30px;
    background: #41baf4;
    width: fit-content;
    color: white;
    bottom: 0px;
    height: fit-content;">
<?php
    echo "<h1>Benvenuto su Polis!</h1>";
    echo "<p>La tua chiave d'accesso e': <b>";
    echo $_GET["key"];
    echo "</b></p>";
?>
	<button style="width:100%;
	background:  #002cca;
	padding: 10px 20px;
	border: none;
	color: white;
	font-weight: bold;
	margin: 2%;">
		<a target="_blank" style="color: white; text-decoration: none" href="http://polis.com/polis/">Vai alla Login</a>
	</button>
</div>
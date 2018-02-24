<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Log Simulator</title>
<link rel="stylesheet" type="text/css" href="/polis/styles/polis.css">
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<script src="/polis/js/librerie/jquery-3.2.1.js"></script>
<link rel="shortcut icon" href="/polis/logo.ico" />
<script>
	function publish(){
		var data = {};
		data.thingTag = $('#thing').val();
		data.metricTag = $('#metric').val();
		data.value = $('#value').val();
		jsonData = JSON.stringify(data);
		$.ajax({
			type: "POST",
			data: {data : jsonData},
			dataType: 'json',
			url: "/polis/php/api/publishMetric.php"
			}).done(function (data) {
				//decodedData = JSON.parse(data)
				decodedData = data;
        			if(decodedData.status == "error"){
        				$('#alert').text(decodedData.error).show(100);
        			}
        			else{
        				$('#alert').text("OK").show(100);
        			}
			}).fail(function(){
        			$('#alert').text("Server error").show(100);
        		});
	}
</script>

</head>
<body>
	<div style="border:2px solid black">
		Thing Tag: <input type="text" id="thing"/> <br>
		Metric Tag: <input type="text" id="metric"/> <br>
		Value: <input type="number" id="value"/> <br>
		<button onclick="publish();">Pubblica</button>
		<span id="alert"></span>
	</div>
</body>
</html>
function thingSetupHandler () {
    this.logout = $('.logout'); 
    
    this.saveThing = function(){
    	var data = {};
    	data.tag = $('#tag').text(); 
    	data.name = $('#name').val();
    	data.userType = $('#user-type').val();
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/thingSetup.php',
        		{data : jsonData},
        		function(data){
        			var decodedData = JSON.parse(data);
        			if(decodedData.status=="error"){
        				$('.alert').text(decodedData.error).show(100);
        			}
        			else{
        				$('.alert').text("Updated").show(100).delay(2500).hide(100);
        				$('.save-button').attr("disabled","disabled");
        			}
        		})
        		.fail(function(){
        			$('.alert').text("Server error").show(100);
        		});
    }
    this.elementModified = function(){
    	$('.save-button').removeAttr("disabled"); 
    }
    
    this.switchTab = function(tab){
    	var index = $('.tab-menu-element').index($(tab));
    	$('.hidden-tab').hide().eq(index).show();   
    	$('.alert').hide(100);
    }
    this.getMetrics = function(){
    	var data = {};
    	data.thingTag = $('#tag').text(); 
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/getMetrics.php',
        		{data : jsonData},
        		function(data){
        			var decodedData = JSON.parse(data);
        			if(decodedData.status=="error"){
        				$('.alert').text(decodedData.error).show(100);
        			}
        			else{
        				appendMetricToTable(decodedData.metrics);
        			}
        		})
        		.fail(function(){
        			$('.alert').text("Server error").show(100);
        		});
    }
    this.createMetric = function(){
    	var data = {};
    	data.thingTag = $('#tag').text(); 
    	data.name = $('#metric-name').val();
    	data.unit = $('#metric-unit').val();
    	data.metricTag = $('#metric-tag').val();
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/createMetric.php',
        		{data : jsonData},
        		function(data){
        			var decodedData = JSON.parse(data);
        			if(decodedData.status=="error"){
        				$('.alert').text(decodedData.error).show(100);
        			}
        			else{
        				$('.alert').text("Metric created").show(100).delay(2500).hide(100);
        			}
        		})
        		.fail(function(){
        			$('.alert').text("Server error").show(100);
        		});
    }
    this.saveAlert = function(){
    	var url_string = window.location.href;
    	var url = new URL(url_string);
    	var metricTag = url.searchParams.get("metric_tag");
    	var data = {};
    	data.metricTag = metricTag; 
    	data.type = $('#alert-type').val();
    	data.rule = $('#alert-rule').val();
    	data.value = $('#alert-value').val();
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/createAlert.php',
        		{data : jsonData},
        		function(data){
        			var decodedData = JSON.parse(data);
        			if(decodedData.status=="error"){
        				$('.alert').text(decodedData.error).show(100);
        			}
        			else{
        				$('.alert').text("Alert created").show(100).delay(2500).hide(100);
        				location.reload();
        			}
        		})
        		.fail(function(){
        			$('.alert').text("Server error").show(100);
        		});
    }
    
    this.deleteAlert = function(id){    	
    	var data = {};
    	data.alertId = id;    	
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/deleteAlert.php',
        		{data : jsonData},
        		function(data){
        			var decodedData = JSON.parse(data);
        			if(decodedData.status=="error"){
        				$('.alert').text(decodedData.error).show(100);
        			}
        			else{
        				$('.alert').text("Alert deleted").show(100).delay(2500).hide(100);
        				location.reload();
        			}
        		})
        		.fail(function(){
        			$('.alert').text("Server error").show(100);
        		});
    }
    this.deleteFailureLog = function(id){
    	var data = {};
    	data.failureId = id;    	
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/deleteFailureLog.php',
        		{data : jsonData},
        		function(data){
        			var decodedData = JSON.parse(data);
        			if(decodedData.status=="error"){
        				$('.alert').text(decodedData.error).show(100);
        			}
        			else{
        				$('.alert').text("Failure log deleted").show(100).delay(2500).hide(100);
        				location.reload();
        			}
        		})
        		.fail(function(){
        			$('.alert').text("Server error").show(100);
        		});
    }
}

appendMetricToTable = function(list){
	$("#metrics-table").html('<tr><th>Metric Tag</th><th>Metric Name</th><th>Unit</th></tr>');
	for(i = 0; i < list.length; i++){
		var row = createMetricTableRow(list[i].metric_tag, list[i].name, list[i].unit);
		$("#metrics-table").append(row);
	}
}

createMetricTableRow = function(tag, name, unit){
	var r = "<tr onclick=\"loadAlertSetup('" + tag + "')\"><td>";
	r += tag + "<td>";
	r += name + "<td>";
	r += unit + "</td>";
	r += "</tr>";
	return r;
}

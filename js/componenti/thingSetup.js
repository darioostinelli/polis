function thingSetupHandler () {
    this.logout = $('.logout'); 
    
    this.saveThing = function(){
    	var data = {};
    	data.tag = $('#tag').text(); 
    	data.name = $('#name').val();
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
  
}

appendMetricToTable = function(list){
	for(i = 0; i < list.length; i++){
		var row = createMetricTableRow(list[i].name, list[i].unit);
		$("#metrics-table").append(row);
	}
}

createMetricTableRow = function(name, unit){
	var r = "<tr><td>";
	r += name + "<td>";
	r += unit + "</td>";
	r += "</tr>";
	return r;
}

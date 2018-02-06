function thingHandler () {
    this.logout = $('.logout'); 
    
    this.getLogsByMetrics = function(){
    	var data = {};  	
    	data.thingTag = this.getUrlParam("tag");
    	var jsonData = JSON.stringify(data);
    	var callback = this.displayLogs;
    	$.post('/polis/php/api/getMetricLogs.php',
        		{data : jsonData},
        		function(data){
        			decodedData = JSON.parse(data)
        			if(decodedData.status == "error"){
        				$('.alert').text(decodedData.error).show(100);
        			}
        			else{
        				callback(decodedData);
        			}
        		})
        		.fail(function(){
        			$('.alert').text("Server error").show(100);
        		});
    }
    
    this.getUrlParam = function(param){
    	var url_string = window.location.href;
    	var url = new URL(url_string);
    	var c = url.searchParams.get(param);
    	return c;
    }
    this.displayLogs = function(data){
    	var tables = "";
    	for(let i = 0; i < data.length; i++){
    		tables = displayMetric(data[i].metric, data[i].unit, data[i].list);
    		$('#metrics-container').append(tables);
    	}
    	//$('#metrics-container').html(tables);
    }
  
}

displayMetric = function(metric, unit, list){
	var html = "<h2>" + metric + "</h2><table class='table-template'>";
	html += "<tr><th>Date<th>Time<th>Value<th>Unit</th></tr>";
	list.sort(compareTimeStamps);
	for(let i = 0; i < list.length; i++){
		var date = new Date(list[i].time_stamp);
		html += "<tr>";
		html += "<td>" + date.getDate() + "/" + date.getMonth()+1  + "/" + date.getFullYear();
		html += "<td>" + date.getHours() + ":" + date.getMinutes();
		html += "<td>" + list[i].value;
		html += "<td>" + unit + "</td>";
		html += "</tr>";
	}
	html += "</table>";
	return html;
	
}
function compareTimeStamps(a,b) {
	  if (a.time_stamp < b.time_stamp)
	    return 1;
	  if (a.time_stamp > b.time_stamp)
	    return -1;
	  return 0;
	}


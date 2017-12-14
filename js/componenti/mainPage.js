function mainPageHandler () {
    this.logout = $('.logout');
    
    this.getThingList = function(){
    	$("#loading-icon").show();
    	var callback = this.addThingList;
    	var cacheList = this.cacheList;
    	var data = {getThingList:true};
    	var jsonData = JSON.stringify(data);
    	$.get('/polis/php/api/getUserThingList.php',
    		{data : jsonData},
    		function(data){
    			var decodedData = JSON.parse(data);    			
    			$(".loading-panel").hide();
    			callback(decodedData);
    			cacheList(decodedData);
    		})
    		.fail(function(){
    			//TODO: handle fail
    		});
    }
    
  this.cacheList = function(list){
	  var jsonData = JSON.stringify(list);
		$.post('/polis/php/api/cacheThingList.php',
	    		{data : jsonData},
	    		function(data){
	    			//TODO: handle error
	    		})
	    		.fail(function(){
	    			//TODO: handle fail
	    		});
  }
  this.addThingList = function(data){
	  var thingHtml = "<div class='row'>";
	  for(i = 1; i <= data.length; i++){
		  if( (i + 1) % 2 == 0){
			  thingHtml += "</div><div class='row'>";
		  }
		  thingHtml += addThing(data[i-1].name, data[i-1].tag);
	  }
	  thingHtml += "</div>"
	  $(".notice-board").append(thingHtml);
	  
	 
  }
}
addThing = function(thingName, thingTag){
	thingHtml = '<div class="cell thing-template" onclick="loadThingPage(\'%s\',\'%s\')">\
					<table>\
						<td>\
							<img class="thing-icon" src="/polis/src/img/icons/thing-icon.svg">\
						<td>%s\
						</td>\
					</table>\
				</div>';
	thingHtml =  thingHtml.replace("%s",thingTag);  
	thingHtml =  thingHtml.replace("%s",thingName); 
	return thingHtml.replace("%s",thingName);    	
}
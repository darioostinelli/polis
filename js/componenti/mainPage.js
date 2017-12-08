function mainPageHandler () {
    this.logout = $('.logout');
    
    this.getThingList = function(){
    	$("#loading-icon").show();
    	var callback = this.addThingList;
    	var data = {getThingList:true};
    	var jsonData = JSON.stringify(data);
    	$.get('/polis/php/api/getUserThingList.php',
    		{data : jsonData},
    		function(data){
    			var decodedData = JSON.parse(data);    			
    			$(".loading-panel").hide();
    			callback(decodedData);
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
		  thingHtml += addThing(data[i-1].name);
	  }
	  thingHtml += "</div>"
	  $(".notice-board").html(thingHtml);
	  
	 
  }
}
addThing = function(thingName){
	thingHtml = '<div class="cell thing-template shadow">\
					<table>\
						<td>\
							<img class="thing-icon" src="/polis/src/img/icons/thing-icon.svg">\
						<td>%s\
						</td>\
					</table>\
				</div>';
	return thingHtml.replace("%s",thingName);    	
}
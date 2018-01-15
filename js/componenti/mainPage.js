function mainPageHandler () {
    this.logout = $('.logout');
    
    this.getThingList = function(setup = false){
    	$("#loading-icon").show();
    	if(!setup)
    		var callback = this.addThingList;
    	else
    		var callback = this.addThingSetupList;
    	var cacheList = this.cacheThingsList;
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
    
  this.cacheThingsList = function(list){
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
  this.addThingSetupList = function(data){
	  var thingHtml = "<div class='row'>";
	  for(i = 1; i <= data.length; i++){
		  if( (i + 1) % 2 == 0){
			  thingHtml += "</div><div class='row'>";
		  }
		  thingHtml += addThingSetup(data[i-1].name, data[i-1].tag);
	  }
	  thingHtml += "</div>"
	  $(".notice-board").append(thingHtml);
  }
  this.addUsersList = function(data){
	  var userHtml = "<table class='table-template shadow'>";
	  userHtml += "<tr><th>User Type<th>User Name</th></tr>"
	  for(i = 1; i <= data.length; i++){
		 
		  userHtml += addUser(data[i-1]);
	  }
	  userHtml += "</table>"
	  $(".notice-board").append(userHtml);
	  
	 
  }
  this.getUsersList = function(){
  	$("#loading-icon").show();
  	var data = {getUsersList:true};
  	var jsonData = JSON.stringify(data);
  	var callback = this.addUsersList;
  	$.get('/polis/php/api/getUsersList.php',
  		{data : jsonData},
  		function(data){
  			var decodedData = JSON.parse(data);    	
  			if(decodedData.status == "error"){
  				//TODO: handle error
  			}
  			else{
  				decodedData.sort(compareByUserType);
  				callback(decodedData);
  			}
  			$(".loading-panel").hide();
  			
  		})
  		.fail(function(){
  			//TODO: handle fail
  		});
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
addThingSetup = function(thingName, thingTag){
	thingHtml = '<div class="cell thing-template" onclick="loadThingSetupPage(\'%s\',\'%s\')">\
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
addUser = function(user){
	
	userHtml = '<tr onclick="loadUserPage(\'%s\')">\
				<td style="color: %s">%s<td>%s</td>\
			</tr>';	
	var color;
	if(user.accessLevel == 0)
		color = "red";
	if(user.accessLevel == 1)
		color = "blue";
	if(user.accessLevel == 2)
		color = "green";
	userHtml =  userHtml.replace("%s",user.username); 
	userHtml =  userHtml.replace("%s",color); 
	userHtml =  userHtml.replace("%s",user.userTypeName);  
	return userHtml.replace("%s",user.username);	
}
compareByUserType = function(a,b) {
	  if (a.accessLevel < b.accessLevel)
	    return -1;
	  if (a.accessLevel > b.accessLevel)
	    return 1;
	  return 0;
	}



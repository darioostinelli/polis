function mainPageHandler () {
    this.logout = $('.logout');
    
    this.getThingList = function(){
    	$("#loading-icon").show();
    	var data = {getThingList:true};
    	var jsonData = JSON.stringify(data);
    	$.get('/polis/php/api/getUserThingList.php',
    		{data : jsonData},
    		function(data){
    			var decodedData = JSON.parse(data);
    			
    			$(".loading-panel").hide();
    			$(".notice-board").text(data);
    		})
    		.fail(function(){
    			//TODO: handle fail
    		});
    }

}
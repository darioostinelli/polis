function addThingHandler () {
    this.logout = $('.logout'); 
    
    this.saveThing = function(){
    	var data = {};    	
    	data.name = $('#thing-name').val();
    	data.userType = $('#user-type').val();
    	data.tag = $('#thing-tag').val();
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/addThing.php',
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
    
  
}


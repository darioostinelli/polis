function thingSetupHandler () {
    this.logout = $('.logout'); 
    
    this.saveThing = function(){
    	var data = {};
    	data.tag = $('#tag').text(); //TODO: controls user has access to the thing before update
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
    }
    
  
}



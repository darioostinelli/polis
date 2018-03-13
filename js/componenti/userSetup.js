function userSetupHandler () {	
	this.saveChanges = function(){
		var url_string = window.location.href;
    	var url = new URL(url_string);
    	var username = url.searchParams.get("username");
		var data = {};
    	data.username = username;
    	data.userType = $('#user-type').val();
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/userSetup.php',
        		{data : jsonData},
        		function(data){
        			var decodedData = JSON.parse(data);
        			if(decodedData.status=="error"){
        				$('.alert').text(decodedData.error).show(100);
        			}
        			else{
        				$('.alert').text("Updated").show(100).delay(2500).hide(100);
        				
        			}
        		})
        		.fail(function(){
        			$('.alert').text("Server error").show(100);
        		});
	}
	
	this.deleteUser = function(){
		var url_string = window.location.href;
    	var url = new URL(url_string);
    	var username = url.searchParams.get("username");
		var data = {};
    	data.username = username;
    	data.userType = $('#user-type').val();
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/deleteUser.php',
        		{data : jsonData},
        		function(data){
        			var decodedData = JSON.parse(data);
        			if(decodedData.status=="error"){
        				$('.alert').text(decodedData.error).show(100);
        			}
        			else{
        				$('.alert').text("Updated").show(100).delay(2500).hide(100);
        				if(decodedData.logout)
        					window.location.href = "/polis";
        				
        			}
        		})
        		.fail(function(){
        			$('.alert').text("Server error").show(100);
        		});
	}
}

/**
 * Object that handle login client side authentication and api POST request
 * 
 */
function LoginHandler () {
    this.inputUser = $('#user');
    this.inputPass = $('#password');
    this.btnLogin = $('#btn-login');
    this.btnSignup = $('#btn-signup');
    this.loginLog = $('#login-log');
    this.isValid = function(){
    	var valid = true;
    	this.inputUser.css("border","2px solid silver");
    	this.inputPass.css("border","2px solid silver");
    	if(this.inputUser.val() == ""){
    		valid = false;
    		this.inputUser.css("border","2px solid red");
    	}
    	if(this.inputPass.val() == ""){
    		valid = false;
    		this.inputPass.css("border","2px solid red");
    	}
    	
    	return valid;
    }
    this.btnSignup.click(function(){
    	window.location.href = "/polis/signup.html";
    })
    
    this.log = function(message){
    	this.loginLog.text(message);
    }
    this.sendRequest = function(){
    	$("#loading-icon").show();
    	var data = {user : this.inputUser.val(), pass : this.inputPass.val()};
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/login.php',
    		{data : jsonData},
    		function(data){
    			var decodedData = JSON.parse(data);
    			if(decodedData.status == "error"){
    				$('#login-log').text(decodedData.error);
    				$("#loading-icon").hide();
    			}
    			else{
    				window.location.href = "/polis/dashboard/mainPage.php";
    				$("#loading-icon").hide();
    			}
    		})
    		.fail(function(){
    			$('#login-log').text("Server error. Please try later");
    		});
    }

}
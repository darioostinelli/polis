/**
 * Object that handle signup client side and api POST request
 * 
 */
function SignupHandler () {
    this.inputUser = $('#user');
    this.inputPass = $('#password');
    this.inputConfirmPass = $('#confirm-password');
    this.inputEmail = $('#email');
    this.inputFamily = $('#family');
    this.btnLogin = $('#btn-login');
    this.btnSignup = $('#btn-signup');
    this.loginLog = $('#login-log');
    this.familyLoginInfo = $("#family-signup");
    this.closeFamilyInfo = $("#closeInfo");
    this.isValid = function(){
    	var valid = true;
    	this.log("");
    	this.inputUser.css("border","2px solid silver");
    	this.inputPass.css("border","2px solid silver");
    	this.inputConfirmPass.css("border","2px solid silver");
    	this.inputEmail.css("border","2px solid silver");
    	this.inputFamily.css("border","2px solid silver");
    	this.log("");
    	if(this.inputPass.val() != this.inputConfirmPass.val()){
    		valid = false;
    		this.inputPass.css("border","2px solid orange");
    		this.inputConfirmPass.css("border","2px solid orange");
    		this.log("Password and Confirm password don't match")
    	}
    	if(this.inputUser.val() == ""){
    		valid = false;
    		this.inputUser.css("border","2px solid red");
    	}
    	if(this.inputPass.val() == ""){
    		valid = false;
    		this.inputPass.css("border","2px solid red");
    	}
    	if(this.inputConfirmPass.val() == ""){
    		valid = false;
    		this.inputConfirmPass.css("border","2px solid red");
    	}
    	if(this.inputEmail.val() == ""){
    		valid = false;
    		this.inputEmail.css("border","2px solid red");
    	}
    	if(this.inputFamily.val() == ""){
    		valid = false;
    		this.inputFamily.css("border","2px solid red");
    	}
    	if(this.inputPass.val().length < 6){
    		valid = false;
    		this.log("Password must be at least 6 characters")
    	}
    	return valid;
    }
    this.btnLogin.click(function(){
    	window.location.href = "/polis/index.html";
    })
    
    this.log = function(message){
    	this.loginLog.text(message);
    }
    
    this.sendRequest = function(){
    	var data = {};
    	$("#loading-icon").show();
    	$("#family-signup").fadeOut(100);
    	data.user = this.inputUser.val();
    	data.pass = this.inputPass.val();
    	data.email = this.inputEmail.val();
    	data.family = this.inputFamily.val();
    	var jsonData = JSON.stringify(data);
    	$.post('/polis/php/api/signupFamily.php',
    		{data : jsonData},
    		function(data){
    			var decodedData = JSON.parse(data);
    			if(decodedData.status == "error"){
    				$('#login-log').text(decodedData.error);
    				if(decodedData.showFamily)
    					$("#family-signup").fadeIn(100);
    			}
    			else{
    				window.location.href = "/polis/dashboard/mainPage.php";
    			}
    			$("#loading-icon").hide();
    		})
    		.fail(function(){
    			$('#login-log').text("Server error. Please try later");
    			$("#loading-icon").hide();
    		});
    }

}
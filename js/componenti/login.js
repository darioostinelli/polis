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

}
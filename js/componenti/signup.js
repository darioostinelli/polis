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
    
    this.isValid = function(){
    	var valid = true;
    	this.log("");
    	this.inputUser.css("border","2px solid silver");
    	this.inputPass.css("border","2px solid silver");
    	this.inputConfirmPass.css("border","2px solid silver");
    	this.inputEmail.css("border","2px solid silver");
    	this.inputFamily.css("border","2px solid silver");
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
    	
    	return valid;
    }
    this.btnLogin.click(function(){
    	window.location.href = "/polis/index.html";
    })
    
    this.log = function(message){
    	this.loginLog.text(message);
    }

}
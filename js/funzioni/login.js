/**
 * Functions for login page. This file uses methods from login.js component
 */
var login;
$().ready(function(){
	login = new LoginHandler();
	login.btnLogin.click(handleLogin);
});
function handleLogin(){
	if(!login.isValid()){ //login form is not complete
		return;
	}
	else{
		alert("valid");
		//TODO: send POST to server
	}
}
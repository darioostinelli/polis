var signup;
$().ready(function(){
	signup = new SignupHandler();
	signup.btnSignup.click(handleSignup);
});
function handleSignup(){
	if(!signup.isValid()){ //login form is not complete
		return;
	}
	else{
		alert("valid");
		//TODO: send POST to server
	}
}
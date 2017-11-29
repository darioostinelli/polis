var signup;
$().ready(function(){
	signup = new SignupHandler();
	signup.btnSignup.click(handleSignup);
	signup.closeFamilyInfo.click(closeInfo);
});
function handleSignup(){
	if(!signup.isValid()){ //login form is not complete
		return;
	}
	else{
		signup.sendRequest();
	}
}
function closeInfo(){
	signup.familyLoginInfo.fadeOut(100);
}
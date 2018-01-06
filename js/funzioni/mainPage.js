/**
 * 
 */
function loadThingPage(tag, name){
	var path = "/polis/dashboard/things/thing.php?tag=";
	path += tag;
	path += "&name=" + name;
	window.location.href = path;
}

function loadThingSetupPage(tag, name){
	var path = "/polis/dashboard/things/thingSetup.php?tag=";
	path += tag;
	path += "&name=" + name;
	window.location.href = path;
}

function loadUserPage(username){
	var path = "/polis/dashboard/users/user.php?username=";
	path += username;
	
	window.location.href = path;
}
function logout(){
	  $.post('/polis/php/api/logout.php',
	    		{data : true},
	    		function(data){
	    			decodedData = JSON.parse(data);
	    			if(decodedData.status == "success")
	    				window.location.href = "/polis/";
	    		})
	    		.fail(function(){
	    			//TODO: handle fail
	    		});
}

function goToPage(page){
	var path = "/polis/dashboard/" + page;
	window.location.href = path;
}
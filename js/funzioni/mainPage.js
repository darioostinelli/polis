/**
 * 
 */
function loadThingPage(tag, name){
	var path = "/polis/dashboard/things/thing.php?tag=";
	path += tag;
	path += "&name=" + name;
	window.location.href = path;
}
function stringFormatter(string, param) {
   
	for(i = 0; i < param.length; i++){
	   string.replace("%s", param[i]);
   }
    
}
<?php
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';
include_once 'components/Family.php';
include_once 'components/Things.php';
class User{
    private $user;
    function __construct($username){
       $db = new Database();
       $query = "SELECT * FROM users,users_definition WHERE users.user_name='".$username."' AND users.user_type=users_definition.id";
       $result = $db->query($query);
       
       if(!$result || count($result) == 0){ //error during query execution or user does not exist
            $this->user = false;      
       }
       else{
           $this->initUser($result[0]);
       }
       $db->closeConnection();
    }
    function exists(){
        if(!$this->user)
            return false;
        return true;
    }
    function getUser(){
        return $this->user;
    }
    function getUsername(){
        return $this->user->username;
    }
    function getFamily(){
        return $this->user->family;
    }
    function getAccessLevel(){
        return $this->user->accessLevel;
    }
    function controlValidation($pass){
        return strcmp($this->user->password, $pass) == 0;
    }
    function createUser($username, $password, $family, $email){
        $db = new Database();
        $query = "INSERT INTO `users`(`family_tag`, `user_name`, `password`, `user_type`, `email`) VALUES ('".$family."','".$username."','".$password."',3,'".$email."')";
        
        $result = $db->query($query);
        if(!$result)
           return false;
        else
            return true;
    }
    
    function hasAccessTo($thing){
        /* access level 0: root
         * access level 1: only some things
         * ...*/
        if($this->user->accessLevel <= $thing->getAccessLevel() && $this->user->family == $thing->getFamily())
            return true;
        return false;
    }
    function getThingList(){ //TODO: report method in documentation
        $db = new Database();
        $query = 'SELECT things.tag FROM things inner JOIN users_definition on (users_definition.id = things.user_type) WHERE things.family_tag="'.$this->user->family.'" AND access_level >='.$this->user->accessLevel;
    
        $result = $db->query($query);
        if(!$result)
            return false;
        else
            return $this->generateThingList($result); 
    }
    private function generateThingList($result){
        $list = array();
        foreach($result as $thing){
            $thingObj = new Thing($thing->tag);
            array_push($list, $thingObj);
        }
        
        return $list;
    }
    private function initUser($result){
        $this->user = new StdClass;
        $this->user->username = $result->user_name;
        $this->user->family = $result->family_tag;
        $this->user->password = $result->password;
        $this->user->email = $result->email;
        $this->user->accessLevel = $result->access_level;
        $this->user->userType = $result->name;
    }
    
}
?>



<?php
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/DatabaseConnection.php';

class Thing
{
    private $thing;
    public function __construct($tag){
        $db = new Database();
        $query = "SELECT * FROM things WHERE tag='".$tag."'";
        $result = $db->query($query);
        if(!$result || count($result) == 0){ //an error occured while executing the query or thing does not exist
            $this->thing = false;
        }
        else{
            $accessLevel = $this->setAccessLevel($db, $result[0]->user_type);
            $this->thing = $result[0]; //result must have only an element
            $this->thing->access_level =  $accessLevel;
        }
    }
    
    function exists(){
        if(!$this->thing)
            return false;
        else 
            return true;
    }
    function  getThing(){
        return $this->thing;
    }
    function getFamily(){
        return $this->thing->family_tag;
    }
    function getTag(){
        return $this->thing->tag;
    }
    function getAccessLevel(){
        return $this->thing->access_level;
    }
    private function setAccessLevel($db, $id){
        $query = "SELECT access_level FROM users_definition WHERE id='".$id."'";
        $result = $db->query($query);
        if(!$result || count($result) == 0){ //an error occured while executing the query or user_definition does not exist
            $this->thing = false;
            return false;
        }
        else {
            return $result[0]->access_level;
        }
    }
    
    
}


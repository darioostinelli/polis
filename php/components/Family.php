<?php
    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/DatabaseConnection.php';
    include_once 'components/Things.php';
    include_once 'components/User.php';
    
    class Family{
        private  $family;
        function __construct($tag){
            $db = new Database();
            $query = "SELECT * FROM families WHERE tag='".$tag."'";
            $result = $db->query($query);
            if(!$result || count($result) == 0)//error during query execution or family does not exist
            {
                $this->family = false;
            }
            else {
                $this->family = $result[0];
            }
            $db->closeConnection();
        }
        function exists(){
            if(!$this->family)
                return false;
            return true;
        }
        function getThingList(){
           $db = new Database();
           $query = "SELECT * FROM things WHERE family_tag='".$this->family->tag."'";
           $result =  $db->query($query);
           if(!$result)
               return false;
           else{
               return $this->generateThingList($result);
           }
        }
        
        function getUserList(){
            $db = new Database();
            $query = "SELECT * FROM users WHERE family_tag='".$this->family->tag."'";
            $result =  $db->query($query);
            if(!$result)
                return false;
                else{
                    return $this->generateUserList($result);
                }
        }
        private function generateThingList($thingsData){
            $list = array();
           for($i = 0; $i < count($thingsData); $i++){
               
               $thingObj = new Thing($thingsData[$i]->tag);
               array_push($list, $thingObj);
           }
            return $list;
        }
        private function generateUserList($usersData){
            $list = array();
            for($i = 0; $i < count($usersData); $i++){
                
                $userObj = new User($usersData[$i]->user_name);
                array_push($list, $userObj);
            }
            return $list;
        }
    }
?>
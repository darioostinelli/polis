<?php
namespace php\components;

use Database;
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';

class Failure{
    private $failure;
    public function __construct($id)
    {
        $db = new Database();
        $query = "SELECT * FROM failures WHERE id_failure='" . $id . "'";
        
        $result = $db->query($query);
        if (! $result || count($result) == 0) { // an error occured while executing the query or thing does not exist
            $this->failure = false;
        } else {
            $this->failure = $result[0]; // result must have only an element
        }
    }
   
    public function exists()
    {
        if (! $this->failure)
            return false;
            return true;
    }  
    
    public function getId()
    {
        if ($this->failure)
            return $this->failure->id_failure;
            return false;
    }
    
    public function  getAlertId(){
        if ($this->failure)
            return $this->failure->id_alert;
            return false;
    }
    
    public function getMetricTag(){
        if ($this->failure)
            return $this->failure->metric_tag;
            return false;
    }
    
    public function getTimeStamp(){
        if ($this->failure)
            return $this->failure->time_stamp;
            return false;
    }
    public function getValue(){
        if ($this->failure)
            return $this->failure->value;
            return false;
    }
    
    public function deleteFailure(){
        $db = new Database();
        $query = "DELETE FROM failures WHERE id_failure='" . $this->getId() . "'";
        $result = $db->query($query);
        if (! $result ) { 
            return false;
        } else {
            return true;
        }
    }
   
}


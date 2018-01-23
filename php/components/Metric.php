<?php
namespace php\components;
use Database;
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';
class Metric
{

    private $metric;
    public function __construct($id)
    {
        $db = new Database();
        $query = "SELECT * FROM metrics_definition WHERE id='".$id."'";
        $result = $db->query($query);
        if(!$result || count($result) == 0){ //an error occured while executing the query or thing does not exist
            $this->thing = false;
        }
        else{
            $this->metric = $result[0]; //result must have only an element
        }
    }
    public function createMetric($thing, $name, $unit, $tag){
        $db = new Database();
        $query = "INSERT INTO `metrics_definition`( `thing_tag`, `name`, `unit`, `metric_tag`) VALUES ('".$thing."','".$name."','".$unit."','".$tag."')";
        
        $result = $db->query($query);
        if(!$result)
            return false;
        return true;
    }
    public function exists(){
        if(!$this->metric)
            return false;
        return true;
    }
    
    public function getName(){
        if($this->exists()){
            return $this->metric->name;
        }
        return false;
    }
    public function getTag(){
        if($this->exists()){
            return $this->metric->metric_tag;
        }
        return false;
    }
    public function getThingTag(){
        if($this->exists()){
            return $this->metric->thing_tag;
        }
        return false;
    }
    public function getUnit(){
        if($this->exists()){
            return $this->metric->unit;
        }
        return false;
    }
    public function getId(){
        if($this->exists()){
            return $this->metric->id;
        }
        return false;
    }
    public function getMetric(){
        if($this->exists()){
            return $this->metric;
        }
        return false;
    }
    function updateMetric($name, $unit){
        if(!$this->exists())
            return false;
        $query = "UPDATE `metrics_definition` SET `name` = '".$name."', unit='".$unit."' WHERE `id` = '".$this->metric->id."';";
        $db = new Database();
        $result = $db->query($query);
        if($result)
            return true;
            return false;
    }
}


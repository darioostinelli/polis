<?php
    use php\components\Metric;

    $includePath = $_SERVER['DOCUMENT_ROOT'];
    $includePath .= "/polis/php";
    ini_set('include_path', $includePath);
    include_once 'components/DatabaseConnection.php';
    include_once 'components/Metric.php';
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
    function  getName(){
        return $this->thing->name;
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
    function getUserTypeId(){
        return $this->thing->user_type;
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
    function updateThing($name, $userType){
        $query = "UPDATE `things` SET `name` = '".$name."', user_type='".$userType."' WHERE `things`.`tag` = '".$this->thing->tag."';";
        $db = new Database();
        $result = $db->query($query);
        if($result){
            unset($_SESSION['thingList']);
            return true;
        }
        return false;
    }
    
    function createThing($name, $userType, $family, $tag){
        $query = "INSERT INTO `things`(`tag`, `name`, `family_tag`, `user_type`) VALUES ('".$tag."','".$name."','".$family."','".$userType."')";
        $db = new Database();
        $result = $db->query($query);
        if($result){
            unset($_SESSION['thingList']);
            return true;
        }
        return false;
    }
    function getMetrics(){
        $query = "SELECT * FROM metrics_definition WHERE thing_tag='".$this->thing->tag."';";
        $db = new Database();
        $result = $db->query($query);
        if(is_bool($result) && !$result){
            return false;
        }
        else return $result;
    }
    function getMetricLogs(){
        $query = "SELECT * FROM metrics WHERE thing_tag='".$this->thing->tag."';";
        $db = new Database();
        $result = $db->query($query);
        if(is_bool($result) && !$result){
            return false;
        }
        else return $result;
    }
    function hasMetric($metricTag){
        $metricList = $this->getMetrics();
        $found = false;
        foreach($metricList as $metric){
            if($metric->metric_tag == $metricTag){
                $found = true;
                break;
            }
        }
        return $found;
    }
    function publishMetricLog($metricTag, $value){
        if(!$this->hasMetric($metricTag))
            return false;
        $metric = new Metric($metricTag);
        return $metric->publishMetricLog($value);
    }
    
    function getMetricLogsByMetricDefinition($metricTag){
        if(!$this->hasMetric($metricTag))
            return false;
        $metric = new Metric($metricTag);
        return $metric->getMetricLogs();
    }
   
}


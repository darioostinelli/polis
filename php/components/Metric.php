<?php
namespace php\components;

use Database;
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';
include_once 'components/Alert.php';

class Metric
{

    private $metric;

    public function __construct($tag)
    {
        $db = new Database();
        $query = "SELECT * FROM metrics_definition WHERE metric_tag='" . $tag . "'";
        $result = $db->query($query);
        if (! $result || count($result) == 0) { // an error occured while executing the query or thing does not exist
            $this->metric = false;
        } else {
            $this->metric = $result[0]; // result must have only an element
        }
    }

    public function createMetric($thing, $name, $unit, $tag)
    {
        $db = new Database();
        $query = "INSERT INTO `metrics_definition`( `thing_tag`, `name`, `unit`, `metric_tag`) VALUES ('" . $thing . "','" . $name . "','" . $unit . "','" . $tag . "')";
        
        $result = $db->query($query);
        if (! $result)
            return false;
        return true;
    }

    public function exists()
    {
        if (! $this->metric)
            return false;
        return true;
    }

    public function getName()
    {
        if ($this->exists()) {
            return $this->metric->name;
        }
        return false;
    }

    public function getTag()
    {
        if ($this->exists()) {
            return $this->metric->metric_tag;
        }
        return false;
    }

    public function getThingTag()
    {
        if ($this->exists()) {
            return $this->metric->thing_tag;
        }
        return false;
    }

    public function getUnit()
    {
        if ($this->exists()) {
            return $this->metric->unit;
        }
        return false;
    }

    public function getId()
    {
        if ($this->exists()) {
            return $this->metric->id;
        }
        return false;
    }

    public function getMetric()
    {
        if ($this->exists()) {
            return $this->metric;
        }
        return false;
    }

    /**
     * Update metric definition
     *
     * @param string $name
     * @param string $unit
     * @return boolean
     */
    function updateMetric($name, $unit)
    {
        if (! $this->exists())
            return false;
        $query = "UPDATE `metrics_definition` SET `name` = '" . $name . "', unit='" . $unit . "' WHERE `id` = '" . $this->metric->id . "';";
        $db = new Database();
        $result = $db->query($query);
        if ($result)
            return true;
        return false;
    }

    /**
     * Publish a metric log
     *
     * @param float $value
     * @return boolean
     */
    function publishMetricLog($value)
    {
        $metricDefinitionTag = $this->getTag();
        $thingTag = $this->getThingTag();
        if (! $this->exists())
            return false;
        $query = "INSERT INTO `metrics`(`thing_tag`, `metric_definition_tag`, `value`, `checked`) VALUES ('" . $thingTag . "','" . $metricDefinitionTag . "','" . $value . "',0)";
        $db = new Database();
        $result = $db->query($query);
        if ($result)
            return true;
        return false;
    }

    /**
     * Return all logs of the metric
     */
    function getMetricLogs()
    {
        if (! $this->exists())
            return false;
        $metricTag = $this->getTag();
        $query = "SELECT * FROM metrics WHERE metric_definition_tag='" . $metricTag . "';";
        $db = new Database();
        $result = $db->query($query);
        if ($result)
            return $result;
        return false;
    }

    function getUncheckedMetricLogs()
    {
        if (! $this->exists())
            return false;
        $metricTag = $this->getTag();
        $query = "SELECT * FROM metrics WHERE metric_definition_tag='" . $metricTag . "' AND checked=0;";
        $db = new Database();
        $result = $db->query($query);
        if ($result)
            return $result;
        return false;
    }

    /**
     * Register a failure in failures table
     *
     * @param float $value
     * @param string $timestamp
     * @return boolean
     */
    function saveFailureLog($value, $timestamp, $idAlert)
    {
        if (! $this->exists())
            return false;
        $query = "INSERT INTO `failures`(`time_stamp`, `metric_tag`, `value`,`id_alert`) VALUES ('" . $timestamp . "','" . $this->getMetric()->metric_tag . "'," . $value . " , " . $idAlert.")";
       
        $db = new Database();
        $result = $db->query($query);
        if ($result)
            return true;
        return false;
    }

    /**
     * Set checked flag in metric table to true
     */
    function checkAllValue()
    {
        if (! $this->exists())
            return false;
        $query = "UPDATE `metrics` SET `checked`=1 WHERE `checked`=0 AND `metric_definition_tag`='" . $this->getMetric()->metric_tag . "'";
        
        $db = new Database();
        $result = $db->query($query);
        if ($result)
            return true;
        return false;
    }

    /**
     * Returns all alert definitions bound to this metric
     *
     * @return mixed
     *
     */
    function getAllAlerts()
    {
        if (! $this->exists())
            return false;
        $query = "SELECT * FROM alerts WHERE metric_tag='" . $this->getMetric()->metric_tag . "'";
        
        $db = new Database();
        $result = $db->query($query);
        if ($result)
            return $result;
        return false;
    }

    /**
     * Return an array with all the active alerts.
     * If alert does not exist or if no alert is active, return false
     *
     * @return mixed
     */
    function getActiveAlerts()
    {
        $alerts = $this->getAllAlerts();
        $list = array();
        if (! $alerts)
            return false;
        foreach ($alerts as $alert) {
            $a = new Alert($alert->id_alert);
            if ($a->getType() == Alert::$WARNING)
                $logs = $this->getMetricLogs();
            else
                $logs = $this->getUncheckedMetricLogs();
            if ($a->isActive($logs)) {
                array_push($list, $alert);
            }
        }
        if (count($list) == 0)
            return false;
        return $list;
    }
    /**
     * Return an array with all historical failures linked to this metric. If an error occurs return false
     * @return boolean|boolean|array
     */
    function getFailureList()
    {
        if (! $this->exists())
            return false;
        $query = "SELECT * FROM failures WHERE metric_tag='" . $this->getTag() . "'";
        
        $db = new Database();
        $result = $db->query($query);
        if ($result)
            return $result;
        return false;
    }
    
    /**
     * 
     */
    function getLastValue(){
        $sql = "SELECT metrics_definition.name, metrics_definition.unit, metrics.value, metrics.time_stamp
                FROM metrics_definition
                JOIN metrics on metrics_definition.metric_tag = metrics.metric_definition_tag
                WHERE metrics_definition.metric_tag = '".$this->getTag()."'
                AND metrics.time_stamp = (
                    SELECT MAX(metrics.time_stamp)
                    FROM metrics
                    WHERE metrics.metric_definition_tag = '".$this->getTag()."'
                )";
        $db = new Database();
        $result = $db->query($sql);
        if ($result)
            return $result[0];
        return false;
    }
}


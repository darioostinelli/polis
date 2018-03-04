<?php
namespace php\components;

use Database;
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';

class Alert
{

    private $alert;

    // Alert types
    public static $WARNING = "WARNING";

    public static $FAILURE = "FAILURE";

    // Alert rules
    public static $GREATER_THAN = ">";

    public static $LESS_THAN = "<";

    public static $EQUAL_TO = "=";

    public function __construct($id)
    {
        $db = new Database();
        $query = "SELECT * FROM alerts WHERE id_alert='" . $id . "'";
        $result = $db->query($query);
        if (! $result || count($result) == 0) { // an error occured while executing the query or thing does not exist
            $this->alert = false;
        } else {
            $this->alert = $result[0]; // result must have only an element
        }
    }
    public function createAlert($type, $rule, $value, $metricTag){
        $db = new Database();
        $query = "INSERT INTO `alerts`(`metric_tag`, `rule`, `value`, `type`) VALUES ('".$metricTag."','".$rule."','".$value."','".$type."')";
        $result = $db->query($query);
        if (! $result || count($result) == 0) { // an error occured while executing the query or thing does not exist
           return false;
        } else {
            return true;
        }
    }
    public function exists()
    {
        if (! $this->alert)
            return false;
        return true;
    }

    public function getType()
    {
        if ($this->alert)
            return $this->alert->type;
        return false;
    }

    public function getRule()
    {
        if ($this->alert)
            return $this->alert->rule;
        return false;
    }

    public function getId()
    {
        if ($this->alert)
            return $this->alert->id_alert;
        return false;
    }
    /**
     * Return metric tag if alert exists, otherwise return false
     * @return string | boolean
     */
    public function getMetric()
    {
        if ($this->alert)
            return $this->alert->metric_tag;
        return false;
    }

    public function getValue()
    {
        if ($this->alert)
            return $this->alert->value;
        return false;
    }

    /**
     *
     * @return boolean Return true if the alert should be activated, acording to alert's rule and value
     *         Return false if the alert should not be activated, if the alert does not exist
     *         or if $metricLogs' values do not refer to the right metric definition
     */
    public function isActive($metricLogs)
    {
        if (!$metricLogs)
            return false;
        // echo "<br><br>".json_encode($metricLogs);
        if (! $this->alert)
            return false;
        usort($metricLogs, array(
            $this,
            "compareTimeStampDesc"
        )); // Last log is the first element
        if ($metricLogs[0]->metric_definition_tag != $this->alert->metric_tag)
            return false;
        if ($this->getType() == Alert::$WARNING) // check only current value
{
            return $this->checkWarningAlert($metricLogs[0]->value);
        }
        if ($this->getType() == Alert::$FAILURE) // check all unchecked data
{
            $failure = $this->checkFailureAlert($metricLogs);
            $metric = new Metric($this->getMetric());
            $metric->checkAllValue();
            return $failure;
        }
    }

    /**
     *
     * @return number Compare two metric logs in order to ascending sort an array
     */
    private function compareTimeStampAsc($a, $b)
    {
        return strcmp($a->time_stamp, $b->time_stamp);
    }

    /**
     *
     * @return number Compare two metric logs by therir time stamp in order to descending sort an array
     */
    private function compareTimeStampDesc($a, $b)
    {
        return strcmp($b->time_stamp, $a->time_stamp);
    }

    /**
     *
     * @return number Compare two metric logs by their value
     */
    private function compareValue($a, $b)
    {
        if ($a->value > $b->value)
            return 1;
        else if ($a->value < $b->value)
            return - 1;
        return 0;
    }

    /**
     * Check if $value must activate alert's rule
     *
     * @param integer $value
     * @return boolean
     */
    private function checkWarningAlert($value)
    {
        if ($this->getRule() == Alert::$GREATER_THAN) {
            if ($value > $this->getValue())
                return true;
        }
        if ($this->getRule() == Alert::$LESS_THAN) {
            if ($value < $this->getValue())
                return true;
        }
        if ($this->getRule() == Alert::$EQUAL_TO) {
            if ($value == $this->getValue())
                return true;
        }
        return false;
    }

    /**
     * Check all logs in order to find out which of them have caused a failure
     *
     * @return boolean
     */
    private function checkFailureAlert($logs)
    {
        $failure = false;
        $metric = new Metric($this->getMetric());
        foreach ($logs as $log) {
            if ($this->getRule() == Alert::$GREATER_THAN) {
                if ($log->value > $this->getValue()) {
                    $failure = true;
                    $metric->saveFailureLog($log->value, $log->time_stamp, $this->getId());
                }
            }
            if ($this->getRule() == Alert::$LESS_THAN) {
                if ($log->value < $this->getValue()) {
                    $failure = true;
                    $metric->saveFailureLog($log->value, $log->time_stamp, $this->getId());
                }
            }
            if ($this->getRule() == Alert::$EQUAL_TO) {
                if ($log->value == $this->getValue()) {
                    $failure = true;
                    $metric->saveFailureLog($log->value, $log->time_stamp, $this->getId());
                }
            }
        }
        return $failure;
    }
    
    /**
     * Delete alert and all its historical failure logs
     */
    public function deleteAlert(){
        $db = new Database();
        $query1 = "DELETE FROM alerts WHERE id_alert=".$this->getId();
        $query2 = "DELETE FROM failures WHERE id_alert=".$this->getId();
        $result1 = $db->query($query1);
        $result2 = $db->query($query2);
        if (! $result1 || ! $result2) { 
            return false;
        } else {
            return true;
        }
    }
}


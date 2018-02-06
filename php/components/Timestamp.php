<?php
namespace php\components;
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
class Timestamp
{

    private $ts = false;
    public function __construct($timestamp)
    {
        $this->ts = $timestamp;        
    }
    
    public function getDate(){
        if(!$this->ts)
            return false;
        $exp = explode(" ", $this->ts);
        $date = explode("-", $exp[0]);
        $dateObj = (object) array();
        $dateObj->year = $date[0];
        $dateObj->month = $date[1];
        $dateObj->day = $date[2];
        return $dateObj;
    }
    
    public function getTime(){
        if(!$this->ts)
            return false;
        $exp = explode(" ", $this->ts);
        $time = explode(":", $exp[1]);
        $timeObj = (object) array();
        $timeObj->hour = $time[0];
        $timeObj->minute = $time[1];
        $timeObj->second = $time[2];
        return $timeObj;
    }
}


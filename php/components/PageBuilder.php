<?php
namespace php\components;

use Database;
use Thing;
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';
include_once 'components/Family.php';
include_once 'components/Things.php';
include_once 'components/Metric.php';
include_once 'components/Timestamp.php';

class PageBuilder
{

    private $user;

    public static $br = "<br>";

    /**
     *
     * @param \User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function controlAccessLevel($minLevel)
    {
        $level = $this->user->getAccessLevel();
        if ($level > $minLevel) // user shouldn't access the page
            header("Location: /polis/dashboard/mainPage.php");
    }

    public function buildMenu($page)
    {
        $open = '<div class="menu-item" onclick="goToPage(\'%s\')">';
        $openSelected = '<div class="menu-item selected-menu">';
        $close = '</div>';
        $menu = "";
        if ($this->user->getAccessLevel() <= 1) // user type User or above
{
            if ($page == "THING_SETUP_PAGE") {
                $menu .= $openSelected;
            } else {
                $menu .= sprintf($open, "things/thingsSetup.php");
            }
            $menu .= "Things Setup" . $close;
        }
        if ($this->user->getAccessLevel() <= 0) // user type Admin or above
{
            if ($page == "USER_SETUP_PAGE") {
                $menu .= $openSelected;
            } else {
                $menu .= sprintf($open, "users/userSetup.php");
            }
            $menu .= "Users Setup" . $close;
        }
        return $menu;
    }

    public function buildAccessLevelDropdown($currentLevel)
    {
        $db = new Database();
        $query = "SELECT * FROM users_definition";
        $list = $db->query($query);
        if (! $list) {
            header("Location: /polis/dashboard/mainPage.php?error=internal_error");
            die();
        }
        return $this->printAccessLevelDropdown($list, $currentLevel);
    }

    private function printAccessLevelDropdown($list, $currentValue)
    {
        $html = "<select id='user-type'>";
        foreach ($list as $type) {
            if ($type->id == $currentValue)
                $html .= "<option value='" . $type->id . "' selected>" . $type->name . "</option>";
            else
                $html .= "<option value='" . $type->id . "'>" . $type->name . "</option>";
        }
        $html .= "</select>";
        return $html;
    }

    public function buildChartDisplayOptionsDropdown()
    {
        $html = "<select id='chart-options'>";
        $html .= "<option value='today' selected>Today</option>";
        $html .= "<option value='5-val'>Last 5 values</option>";
        $html .= "<option value='10-val'>Last 10 values</option>";
        $html .= "<option value='20-val'>Last 20 values</option>";
        $html .= "<option value='2-days'>Last 2 Days</option>";
        $html .= "<option value='7-days'>Last week</option>";
        $html .= "<option value='14-days'>Last 2 weeks</option>";
        $html .= "<option value='30-days'>Last 30 Days</option>";
        $html .= "<option value='all'>All</option>";
        $html .= "</select>";
        return $html;
    }

    /**
     * Return HTML string with all alerts.
     *
     * @param array $activeAlerts
     *            Array with all active alerts
     * @param array $historicalFailure
     *            Array with all historical failure
     * @return string (HTML)
     */
    public function buildMainPageAlerts($activeAlerts, $historicalFailure)
    {
       // echo json_encode($activeAlerts);
        $failNumber = 0;
        $warningNumber = 0;
        $warningDetails = "Warning<table><tr><th>Thing<th>Metric<th>Rule<th>Value</th></tr>";
        $failureDetails = "Failure<table><tr><th>Thing<th>Metric<th>Date<th>Time<th>Value</th></tr>";
        //echo "ACTIVE ALERTS: <br>";
        foreach ($activeAlerts as $thing) {
           // echo "....|_" . $thing->thing_name . ": <br>";
            foreach ($thing->metrics as $metric) {
                //echo "........|_" . $metric->metric_name . ": <br>";
                foreach ($metric->alerts as $alert) {
                    if ($alert->type == Alert::$WARNING) {
                        $warningNumber ++;
                        $warningDetails .= $this->getWarningDetailString($thing, $metric, $alert);
                    } else if ($alert->type == Alert::$FAILURE) {
                        $failNumber ++;
                        $failureDetails .= $this->getFailureDetailString($thing->thing_tag, $metric->metric_tag, $alert);
                    }
                    //echo "............|_" . $alert->type . " " . $alert->rule . " " . $alert->value . "<br>";
                }
                // echo "<br>";
            }
        }
        $warningDetails .= "</table>";
        foreach ($historicalFailure as $failure) {
            $failNumber ++;
            $failureDetails .= $this->getFailureDetailString($failure->thing_tag, $failure->metric_tag, $failure);
        }
        $failureDetails .= "</table>";
        $html = "<table style='margin:5px'><tr><td class='alert-table'>Warning: <td class='alert-table'><div class='alert-menu warning'>
                    <div>" . $warningNumber . "</div>
                    <div class='alert-details shadow'>" . $warningDetails . "</div>
                </div></td></tr>";
        $html .= "<tr><td class='alert-table'>Failure: <td class='alert-table'><div class='alert-menu failure'>
                    <div>" . $failNumber . "</div>
                    <div class='alert-details shadow'>" . $failureDetails . "</div>
                </div></td></tr></table>";
        return $html;
    }

    /**
     * Return HTML string with all alerts
     *
     * @param array $activeAlerts
     *            Array with all active alerts connected to the thing
     * @param array $historicalFailure
     *            Array with all historical failure connected to the thing
     */
    public function buildThingPageAlerts($activeAlerts, $historicalFailure)
    {}

    /**
     * Return a HTML string with a <tr> element which contains information about tha alert
     *
     * @param \stdClass $thing
     * @param \stdClass $metric
     * @param \stdClass $alert
     * @return string
     */
    private function getWarningDetailString($thing, $metric, $alert)
    {
        $html = "<tr onclick='loadThingPage(\"" . $thing->thing_tag . "\")'><td>";
        $html .= $thing->thing_name . "<td>";
        $html .= $metric->metric_name . "<td>";
        $html .= $alert->rule . "<td>";
        $html .= $alert->value . "</td></tr>";
        return $html;
    }

    private function getFailureDetailString($thing, $metric, $alert)
    {
        $m = new Metric($metric);
        $t = new \Thing($thing);
        $html = "<tr onclick='loadThingPage(\"" . $t->getTag() . "\")'><td>";
        $html .= $t->getName() . "<td>";
        $html .= $m->getName() . "<td>";
        if (isset($alert->time_stamp)) {
            $ts = new Timestamp($alert->time_stamp);
            $d = $ts->getDate();
            $time = $ts->getTime();
            $html .= $d->year . "-" . $d->month . "-" . $d->day . "<td>";
            $html .= $time->hour . ":" . $time->minute . "<td>";
        } else {
            $html .= "Now" . "<td>";
            $html .= "Now" . "<td>";
        }
        $html .= $alert->value . "</td></tr>";
        return $html;
    }

    /**
     * Return HTML string with table *ROWS* containing the information about all alerts bounded to the metric
     *
     * @param string $metricTag
     * @return string (HTML)
     */
    public function buildAlertsPageAlertsList($metricTag)
    {
        $metric = new Metric($metricTag);
        $alerts = $metric->getAllAlerts();
        $html = "";
        if (count($alerts) == 0 || ! $alerts) {
            $html = "<tr><td>-<td>-<td>-</td></tr>";
        } else {
            foreach ($alerts as $alert) {
                $html .= "<tr><td>" . $alert->type;
                $html .= "<td>" . $alert->rule;
                $html .= "<td>" . $alert->value;
                $html .= "<td onclick='page.deleteAlert(\"".$alert->id_alert."\")'> <img title='Delete' src='/polis/src/img/icons/trash-can.svg' style='height:20px'/>";
                $html .= "</td></tr>";
            }
        }
        return $html;
    }

    /**
     * Return the HTML select element with all possible alert types
     * 
     * @param string $id
     *            Id of the html select element
     * @return string (HTML)
     */
    public function buildAlertTypeDropdown($id)
    {
        $html = "<select id='" . $id . "'>";
        $html .= "<option selected value='" . Alert::$WARNING . "' selected>Warning</option>";
        $html .= "<option value='" . Alert::$FAILURE . "' >Failure</option>";
        $html .= "</select>";
        return $html;
    }

    /**
     * Return the HTML select element with all possible alert rules
     * 
     * @param string $id
     *            Id of the html select element
     * @return string (HTML)
     */
    public function buildAlertRuleDropDown($id)
    {
        $html = "<select id='" . $id . "'>";
        $html .= "<option selected value='" . Alert::$GREATER_THAN . "' selected>></option>";
        $html .= "<option value='" . Alert::$LESS_THAN . "' ><</option>";
        $html .= "<option value='" . Alert::$EQUAL_TO . "' >=</option>";
        $html .= "</select>";
        return $html;
    }
    
    /**
     * Return HTML string with *ROWS* of a table which contains all information about historical failure linked to a metric
     * @param array $list
     * @return string
     */
    public function buildAlertsPageFailuresList($list){
        $html = "";
        if(!$list)
            return "<tr><td>-<td>-<td>-<td>-<td>-</td></tr>";
        $metric = new Metric($list[0]->metric_tag);
        $unit = $metric->getUnit();
        foreach($list as $failure){            
            $ts = new Timestamp($failure->time_stamp);
            $date = $ts->getDate();
            $time = $ts->getTime();
            $html .= "<tr><td>". $date->year . "-" . $date->month . "-" . $date->day;
            $html .= "<td>" . $time->hour . ":" . $time->minute;
            $html .= "<td>" . $failure->value;
            $html .= "<td>". $unit;
            $html .= "<td onclick='page.deleteFailureLog(\"".$failure->id_failure."\")'> <img title='Delete' src='/polis/src/img/icons/trash-can.svg' style='height:20px'/></td></tr>";
        }
        return $html;
    }
}


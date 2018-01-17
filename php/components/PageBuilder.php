<?php
namespace php\components;
use Database;
$includePath = $_SERVER['DOCUMENT_ROOT'];
$includePath .= "/polis/php";
ini_set('include_path', $includePath);
include_once 'components/DatabaseConnection.php';
include_once 'components/Family.php';
include_once 'components/Things.php';

class PageBuilder
{

    // TODO - Insert your code here
    private $user;
    public function __construct($user)
    {
        $this->user = $user;
    }
    public function controlAccessLevel($minLevel){
        $level = $this->user->getAccessLevel();
        if($level > $minLevel) //user shouldn't access the page
            header("Location: /polis/dashboard/mainPage.php");
    }
    public function buildMenu($page){
        $open = '<div class="menu-item" onclick="goToPage(\'%s\')">';
        $openSelected = '<div class="menu-item selected-menu">';
        $close = '</div>';
        $menu = "";
        if($this->user->getAccessLevel() <= 1) //user type User or above
        {
            if($page == "THING_SETUP_PAGE"){
                $menu .= $openSelected;
            }
            else{
                $menu .= sprintf($open, "things/thingsSetup.php");
            }
            $menu .= "Things Setup".$close;
        }
        if($this->user->getAccessLevel() <= 0) //user type Admin or above
        {
            if($page == "USER_SETUP_PAGE"){
                $menu .= $openSelected;
            }
            else{
                $menu .= sprintf($open, "users/userSetup.php");
            }
            $menu .= "Users Setup".$close;
        }
        return $menu;
    }
    
    public function buildAccessLevelDropdown($currentLevel){
        $db = new Database();
        $query = "SELECT * FROM users_definition";
        $list = $db->query($query);
        if(!$list){
            header("Location: /polis/dashboard/mainPage.php?error=internal_error");
            die();
        }
        return $this->printAccessLevelDropdown($list, $currentLevel);
    }
    
    private function printAccessLevelDropdown($list, $currentValue){
        $html = "<select id='user-type'>";
        foreach ($list as $type){
            if($type->id == $currentValue)
                $html .= "<option value='".$type->id."' selected>".$type->name."</option>";
            else 
                $html .= "<option value='".$type->id."'>".$type->name."</option>";
        }
        $html .= "</select>";
        return $html;
    }
}


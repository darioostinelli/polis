<?php
namespace php\components;

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
}


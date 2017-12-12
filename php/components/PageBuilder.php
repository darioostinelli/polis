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
    public function buildMenu($page){
        $open = '<div class="menu-item">';
        $openSelected = '<div class="menu-item selected-menu">';
        $close = '</div>';
        $menu = "";
        if($this->user->getAccessLevel() <= 1) //user type User or above
        {
            if($page == "THING_SETUP_PAGE"){
                $menu .= $openSelected;
            }
            else{
                $menu .= $open;
            }
            $menu .= "Things Setup".$close;
        }
        if($this->user->getAccessLevel() <= 0) //user type Admin or above
        {
            if($page == "USER_SETUP_PAGE"){
                $menu .= $openSelected;
            }
            else{
                $menu .= $open;
            }
            $menu .= "Users Setup".$close;
        }
        return $menu;
    }
}


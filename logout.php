<?php

session_start();

if (isset($_POST['logout_session_PHP'])) 
{
    if (isset($_SESSION['username'])) 
    {
        $_SESSION = array();
        session_destroy();
        $logout_ajax = array("logout_msg" => "Successfully logout");
    }
    elseif(!isset($_SESSION['username']))
    {
        $logout_ajax['logout_msg'] = "You've already logged out";
    }

    print json_encode($logout_ajax);

}

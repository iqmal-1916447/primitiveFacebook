<?php

require_once 'dbconfig.php';

session_start();

class Login_Verify
{
    private $login_return = array();
    private $login_username;
    private $signup_password;

    function __construct($db)
    {
        $login_username = mysqli_real_escape_string($db, $_POST['login_username_PHP']) ;
        $login_password = mysqli_real_escape_string($db, $_POST['login_password_PHP']) ;
        $login_query = "SELECT * FROM users WHERE username = '$login_username' AND password = '$login_password';";

        //check username & password from server
        $login_result = mysqli_query($db, $login_query);

        //check num row data
        $num_existing_login_data = mysqli_num_rows($login_result);

        if (isset($_POST['login_submit_PHP']) && $num_existing_login_data != 0) //submit button clicked & record exist
        {
            $_SESSION['username'] = $login_username;
            $login_return['login_msg'] = "Verified username & password.";
        }
        elseif (isset($_POST['login_submit_PHP']) && $num_existing_login_data == 0)
        {
            $login_return['login_msg'] = "Your username & password do not match!";
        }

        print json_encode($login_return);   //convert array as json 
    }


}

$login = new Login_Verify($db);
<?php
require_once 'dbconfig.php';
session_start();

class Signup_Verify
{
    private $signup_return = array();
    private $signup_username;
    private $signup_password;
    private static $valid_username = NULL;
    private static $valid_password = NULL;
  
    function __construct($db)
    {
        $signup_username = mysqli_real_escape_string($db, $_POST['signup_username_PHP']) ;
        $signup_password = mysqli_real_escape_string($db, $_POST['signup_password_PHP']) ;
        $username_query = "SELECT * FROM users WHERE username = '$signup_username';";
        $password_query = "SELECT * FROM users WHERE password = '$signup_password';";
        

        //check username & password from server
        $result_username = mysqli_query($db, $username_query);
        $result_password = mysqli_query($db, $password_query);

        //check num row data
        $num_existing_username = mysqli_num_rows($result_username);
        $num_existing_password = mysqli_num_rows($result_password);

        if (isset($_POST['signup_submit_PHP']) && isset($signup_username) && isset($signup_password))
        {
            //check username
            if ($num_existing_username == 0 && !empty($signup_username)) 
            {
                $signup_return['username_msg'] = "Username OK.";
                self::$valid_username = $signup_username;
            }
            elseif ($num_existing_username != 0 && !empty($signup_username))
            {
                $signup_return['username_msg'] = "Username has been taken!";
            }

            //check password
            if ($num_existing_password == 0 && !empty($signup_password))
            {
                $signup_return['password_msg'] = "Password OK.";
                self::$valid_password = $signup_password;
            }
            elseif ($num_existing_password != 0 && !empty($signup_password))
            {
                $signup_return['password_msg'] = "Password has been taken.";
            }

            //check empty input
            if (empty($signup_username))
            {
                $signup_return['username_msg'] = "Username cannot be blank!";
            }

            if(empty($signup_password))
            {
                $signup_return['password_msg'] = "Password cannot be blank!";
            }
        }

        //only execute if static variables filled with verified input
        if (!empty(self::$valid_username) && !empty(self::$valid_password))
        {
            $uname = self::$valid_username;
            $pwd = self::$valid_password;
            mysqli_query($db, "INSERT INTO users (username, password) VALUES ('$uname', '$pwd');");
            $_SESSION['username'] = $uname;
        }

        print json_encode($signup_return);  //convert array as json 
    }



}

$signup = new Signup_Verify($db);

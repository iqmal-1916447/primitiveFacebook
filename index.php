<?php 
    session_start();
    //if user is yet to log out, redirect to home.php
    if(isset($_SESSION['username']))
    {
        header("location: home.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login or Signup to primitiveFacebook</title>
    <script src="jquery-3.6.0.min.js"></script>

</head>

<body>
    <h1>Welcome to primitiveFacebook (beta)</h1>
    <p>Please Login <b>(with your existing account)</b> or Signup <b>(if you are a new user)</b>. </p>

    <button class="toggle_button toggle_login">(Show / Hide) I wanna login</button>
    <button class="toggle_button toggle_signup">(Show / Hide) I wanna signup</button>

    <hr>
    <form name="login_sect" autocomplete="off">
        <h3>Login</h3>
        <input type="text" name="login_username" placeholder="Username" required> 
        <br>
        <input type="password" name="login_password" placeholder="Password" required> 
        <br>
        <button type="submit" name="login_submit" onclick="return false">Log In</button> <span id="button_login_id"></span>
    </form>

    <form name="signup_sect" autocomplete="off">
        <h3>Signup</h3>
        <input type="text" name="signup_username" placeholder="Username" required> <span id="username_signup_id"></span>
        <br>
        <input type="password" name="signup_password" placeholder="Password" required> <span id="password_signup_id"></span>
        <br>
        <button type="submit" name="signup_submit" onclick="return false">Sign Up</button>
    </form>

    <script src="jquery-3.6.0.min.js"></script>

    <script>
        jQuery(function() {

            jQuery("form[name=login_sect]").hide();
            jQuery("form[name=signup_sect]").hide();

            jQuery(".toggle_login").on("click", function() {
                if (jQuery("form[name=signup_sect]").show()) {
                    jQuery("form[name=signup_sect]").hide();
                }

                jQuery("form[name=login_sect]").toggle();
            });

            jQuery(".toggle_signup").on("click", function() {
                if (jQuery("form[name=login_sect]").show()) {
                    jQuery("form[name=login_sect]").hide();
                }

                jQuery("form[name=signup_sect]").toggle();
            });
        });
/* ---------------------------------------------signup control------------------------------------------------------- */
        
        jQuery("button[name=signup_submit]").on("click", function(){
            //check username using ajax
            jQuery.ajax({
                method: 'POST',
                url: 'validate.signup.php',
                data: {
                    signup_username_PHP: jQuery("input[name=signup_username]").val(),
                    signup_password_PHP: jQuery("input[name=signup_password]").val(),
                    signup_submit_PHP: jQuery("button[name=signup_submit]").val()
                },
                dataType: 'json',
                success: function(returnJSON){
                    jQuery("#username_signup_id").html(returnJSON.username_msg);
                    jQuery("#password_signup_id").html(returnJSON.password_msg);
                    if (returnJSON.username_msg == "Username OK." && returnJSON.password_msg == "Password OK.")
                    {
                        window.location = "home.php";
                    }
                }

            });
        });

        jQuery("input[name=signup_username]").on("input", function(){
            jQuery("#username_signup_id").html("");
        });

        jQuery("input[name=signup_password]").on("input", function(){
            jQuery("#password_signup_id").html("");
        });

/* ---------------------------------------------login control------------------------------------------------------- */

        jQuery("button[name=login_submit]").on("click", function(){
            jQuery.ajax({
                method: 'POST',
                url: 'validate.login.php',
                data: {
                    login_username_PHP: jQuery("input[name=login_username]").val(),
                    login_password_PHP: jQuery("input[name=login_password]").val(),
                    login_submit_PHP: jQuery("button[name=login_submit]").val()
                },
                dataType: 'json',
                success: function(returnJSON){
                    jQuery("#button_login_id").html(returnJSON.login_msg);
                    if (returnJSON.login_msg == "Verified username & password.")
                    {
                        window.location = "home.php";
                    }
                }
            });
        });
    </script>
</body>

</html>
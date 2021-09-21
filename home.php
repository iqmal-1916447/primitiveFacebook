<?php 
    session_start();
    //if user accidentally go to home.php without logging in, redirect to index.php
    if(!isset($_SESSION['username']))
    {
        header("location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <p>Welcome <?php echo $_SESSION['username']; ?> to primitiveFacebook!</p>
    <button name="logout_button">Logout</button> <span id="button_logout_id"></span>

    <script src="jquery-3.6.0.min.js"></script>
    <script>
        jQuery("button[name=logout_button]").on("click", function() {
            jQuery.ajax({
                method: 'POST',
                url: 'logout.php',
                data: {
                    logout_session_PHP: jQuery("button[name=logout_button]").val()
                },
                dataType: 'json',
                success: function(responseJSON) {
                    jQuery("#button_logout_id").html(responseJSON.logout_msg);
                    window.location = "index.php";
                }, 
                error: function(responseJSON) {
                    console.log(responseJSON);
                    jQuery("#button_logout_id").html("Fail logging out.");
                }
            });
        });
    </script>

</body>

</html>
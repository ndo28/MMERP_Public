<?php
    session_start();
?>

<!DOCTYPE html>
<!--
    Guthrie Hayward
    CS 328 - Homework 12

    File: custom-session3.php

    Purpose: Using sessions, creates a dynamic page in which the user can choose to see more information about
    either the drinks menu or the bands that play at Classy Cocktails. Based on the user's choice, a drop-down menu is generated,
    where the user selects the specific drink or band. The next page should be a table containign more info about the chosen item/band.

    Last Edited: 5/5/16

    url: http://nrs-projects.humboldt.edu/~gmh234/hw12/custom-session3.php
-->
<head>
    <title> MMERP </title>
    <meta charset="utf-8" />

    <?php

        require_once("custom-login-9.php");
        require_once("custom-session-admin-user.php");
        require_once("make_report_menu.php");
        require_once("user_reports_menu.php");
        require_once("hsu_conn_sess.php");
        require_once("make_new_report.php");
    ?>

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />
  <!--  <link href="custom.css" type="text/css"
          rel="stylesheet" />
  <script src="custom-session-validate.js" type="text/javascript"> </script> -->

</head>

<body>

  <header class="header">
    <h1>MMERP</h1>
  </header>

    <p>
      You have landed on the MMERP page
    </p>
    <?php
    if((! array_key_exists("username", $_POST)) and
        (! array_key_exists("next_screen", $_SESSION)))
    {
      custom_login_9();
      $_SESSION['next_screen'] = 'user_type';
    }
    elseif (array_key_exists("username", $_POST) and
            ($_SESSION['next_screen'] == 'user_type'))
    {
        $username = strip_tags($_POST['username']);
        $password = $_POST['password'];

        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        custom_session_admin_user();

        if(array_key_exists("user", $_POST))
        {
          $_SESSION['next_screen'] = 'make_report_menu';
        }
        else
        {
          $_SESSION['next_screen'] = 'admin_console';
        }

    }
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists("user", $_POST))
            )
    {
      $username = strip_tags($_SESSION['username']);
      $password = $_SESSION['password'];

      make_report_menu();

      if(array_key_exists("new", $_POST))
      {
        $_SESSION['next_screen'] = 'new_report';
      }
      else
      {
        $_SESSION['next_screen'] = 'user_reports_menu';
      }


     }
     elseif (array_key_exists("username", $_SESSION)
             and (array_key_exists("admin", $_POST))
             and $_SESSION['next_screen'] == 'admin_console')
     {
       $username = strip_tags($_SESSION['username']);
       $password = $_SESSION['password'];
       //admin_console();
      }
      elseif (array_key_exists("username", $_SESSION)
              and (array_key_exists("new", $_POST)))
      {
        $username = strip_tags($_SESSION['username']);
        $password = $_SESSION['password'];

        make_new_report($username, $password);
      }
      elseif (array_key_exists("username", $_SESSION)
              and (array_key_exists("continue", $_POST))
              and $_SESSION['next_screen'] == 'user_reports_menu')
      {
        $username = strip_tags($_SESSION['username']);
        $password = $_SESSION['password'];

        user_reports_menu($username, $password);

        $_SESSION['next_screen'] = 'new_entry';
      }

    else
    {
        custom_login_9();

        session_destroy();
        session_regenerate_id(TRUE);
        session_start();

        $_SESSION['next_screen'] = 'user_type';
    }?>
    <div class='footer'>
    <?php require_once("328footer-better.html"); ?>
   </div>
</body>
</html>

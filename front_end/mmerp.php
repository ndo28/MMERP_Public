<?php
    session_start();
?>

<!DOCTYPE html>
<!--
    MMERP webapp master file

    Guthrie Hayward (gmh234)
    Nathan Ortolan (ndo28)
    Becky Williams (rjw125)
    Abdul Shaikh (ats234)

    File: mmerp.php

    Purpose: A master php file to control the flow of html pages in the
             MMERP webapp.

    Last Edited: 11/15/16 - ndo28

    url: http://nrs-projects.humboldt.edu/~gmh234/hw12/custom-session3.php
    needed (future) url: http://nrs-projects.humboldt.edu/~mmerp/mmerp_app.php


    notes/questions: *Should there be a separate elseif block to test for
                      a second_user? -testing for a beach input before looking
                      at the second_user info seems funky. - Nathan*


-->
<head>
    <title> MMERP </title>
    <meta charset="utf-8" />

    <!-- required module files to launch app -->
    <?php

        require_once("custom-login-9.php");
        require_once("main_menu.php");
        require_once("get_report_id.php");
        require_once("get_user_inits.php");
        require_once("get_second_inits.php");
        require_once("user_reports_menu.php");
        require_once("hsu_conn_sess.php");
        require_once("update_report.php");
        require_once("create_surveyors.php");
        require_once("get_report_info.php");
        require_once("map.php");
        require_once("admin_menu.php");
    ?>

    <!-- css normalization  -->
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


    <?php
    /* if there is currently no username or next_screen variables in
          the SESSION array, then display login module */
    if((! array_key_exists("username", $_POST)) and
        (! array_key_exists("next_screen", $_SESSION)))
    {
      custom_login_9();

      $_SESSION['next_screen'] = 'main_menu';
    }

    /* if username exists in the POST or SESSION array, then store username and
        password as PHP variables (taking their values from the respective
        arrays) and display the main menu */
    elseif ((array_key_exists("username", $_POST) and
            (($_SESSION['next_screen'] == 'main_menu'))) or
             ((array_key_exists('main_menu', $_POST)) and
             (array_key_exists("username", $_SESSION))))
    {

        if(array_key_exists('username', $_SESSION))
        {
          $username = $_SESSION["username"];
          $password = $_SESSION["password"];
        }
        else
        {
          $username = strip_tags($_POST['username']);
          $password = $_POST['password'];
        }

        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        main_menu();

    }

    /* if username exists in the SESSION array and admin exists in the POST
        array, then store username and password as PHP variables and display
        the admin console */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('admin', $_POST)))
    {
       $username = strip_tags($_SESSION['username']);
       $password = $_SESSION['password'];

       admin_console();

    }
    /* if username exists in the SESSION array and map_view exists in the POST
        array, then store username and password as PHP variables and display
        the respective users map module*/
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists("map_view", $_POST)))
    {
      $username = strip_tags($_SESSION['username']);
      $password = $_SESSION['password'];
      create_map($username,$password);
     }

    /* if username exists in the SESSION array and new exists in the POST array,
        then store username and password as PHP variables and begin a new report:
            -- get the first user's initials from DB
            -- get the next sequencial report_id from DB
            -- display the report info input module */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('new', $_POST)))
    {
      $username = strip_tags($_SESSION['username']);
      $password = $_SESSION['password'];
      // CALL THREE FUNCTIONS HERE:
          // first, get current report_id and 1st USER_INITIALS
      get_inits($username, $password);

      $_SESSION["first_user"] = $username;

      // get report_id from database
      get_report_id($username, $password);

       // second display to the user the report options
      get_report_info($username, $password);

    }

    /* if username exists in the SESSION array and continue exists in the POST
        array, then store username and password as PHP variables and display the
        new report info input module */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('continue', $_POST)))
    {
        $username = strip_tags($_SESSION['username']);
        $password = $_SESSION['password'];

        user_reports_menu($username, $password);

    }

    /* if username exists in the SESSION array and report_recap exists in the
        POST array, then store username, password, report_id, and first_user
        variables as PHP variables and :
            if beach_choice exists in the POST array, then............. */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('report_recap', $_POST)))
    {
        $username = strip_tags($_SESSION['username']);
        $report_id = strip_tags($_SESSION['report_id']);
        $first_user = strip_tags($_SESSION['first_user']);
        $password = $_SESSION['password'];

          if(array_key_exists('beach_choice', $_POST))
          {
            $second_user = strip_tags($_POST['user_choice']);
            $beach_abbr = strip_tags($_POST['beach_choice']);
            $_SESSION['second_user'] = $second_user;
            $_SESSION['beach_abbr'] = $beach_abbr;

            //get 2nd USER_INITIALS
            get_second_inits($username, $password, $second_user);

            //update report table with beach, date
            update_report($username, $password, $report_id, $beach_abbr);

            // Echo session variables that were set on previous pages
            echo "Username is " . $_SESSION["username"] . ".<br>";
            echo "beach_choice is " . $_SESSION["beach_abbr"] . ".<br>";
            echo "report_id is " . $_SESSION["report_id"] . ".<br>";
            echo "second_user is " . $_SESSION["second_user"] . ".<br>";
            echo "second_init is " . $_SESSION["second_init"] . ".<br>";
            echo "first_init is " . $_SESSION["first_init"] . ".<br>";
            echo "first_user is " . $_SESSION["first_user"] . ".";

            $first_user = strip_tags($_SESSION['first_user']);
            $second_user = strip_tags($_SESSION['second_user']);

            create_surveyors($username, $password, $report_id, $first_user);
            create_surveyors($username, $password, $report_id, $second_user);

          }
          else
          {
            $username = strip_tags($_POST['username']);
            $report_id = strip_tags($_POST['reports']);
            $password = $_POST['password'];
          }
          echo "you have arrived at report recap";
          //report_recap($username, $password, $report_id);

    }
    /* otherwise... destroy, regenerate, begin a new SESSION, and display
        the login module */
    else
    {
        custom_login_9();

        session_destroy();
        session_regenerate_id(TRUE);
        session_start();

        $_SESSION['next_screen'] = 'main_menu';
    }?>
    <div class='footer'>
    <?php require_once("328footer-better.html"); ?>
   </div>
</body>
</html>

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

    Created by Abdul, Guthrie and Rebecca on 11/5/16

    Modified by: rjw, ats  on: 11/13/16
    Modified by: rjw  on: 11/14/16
    Modified by: ats  on: 11/14/16
    Modified by: ndo  on: 11/16/16
    Modified by: rjw  on: 11/19/16

    File: mmerp.php

    Purpose: A master php file to control the flow of html pages in the
             MMERP webapp.

    needed (future) url: http://nrs-projects.humboldt.edu/~mmerp/mmerp.php


    notes/questions: *Should there be a separate elseif block to test for
                      a second_user? -testing for a beach input before looking
                      at the second_user info seems funky. - Nathan*


-->
<head>
    <title> MMERP </title>
    <meta charset="utf-8" />

    <!-- required module files to launch app -->
    <?php

        require_once("custom_login_9.php");
        require_once("main_menu.php");
        require_once("get_report_id.php");
        require_once("get_user_inits.php");
        require_once("user_reports_dropdown.php");
        require_once("hsu_conn_sess.php");
        require_once("update_report.php");
        require_once("create_surveyors.php");
        require_once("get_report_info.php");
        require_once("map.php");
        require_once("admin_menu.php");
        require_once("report_recap.php");
        require_once("validate_user.php");
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

      $_SESSION['next_screen'] = 'validate_user';

    }

    /* if username exists in the POST array, the users credintials must
       be vaidated in the the database.  The user types is_admin and is_surveyor
       will be added to the SESSION array at this point too if validation occurs
       in the function validate_user */
    elseif (array_key_exists("username", $_POST) and
            (($_SESSION['next_screen'] == 'validate_user')))
    {
      $username = strip_tags($_POST['username']);
      $user_password = $_POST['password'];
      $password = 'Clo\/er1swyd0g';  // this will be hard coded password for Oracle
      $login = 'rjw125';  // this is hard coded username for Oracle

      $_SESSION['login'] = $login;
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
      $_SESSION['user_password'] = $user_password;

      // validate user password with database, store variables for is_surveyor, is_admin
      validate_user($login, $username, $password, $user_password);

      // if vaidation is successful continue to main_menu, else restart session
      if ((array_key_exists('is_surveyor', $_SESSION))
          and (array_key_exists('is_admin', $_SESSION)))
      {
          $username = strip_tags($_SESSION['username']);
          $is_surveyor = strip_tags($_SESSION['is_surveyor']);
          $is_admin = strip_tags($_SESSION['is_admin']);
          $user_password = strip_tags($_SESSION['user_password']);
          $password = $_SESSION["password"];
          echo "session->is_admin is " . $_SESSION["is_admin"] . ".<br>";
          echo "session->is_surveyor is " . $_SESSION["is_surveyor"] . ".<br>";
          //$user_password = $_SESSION['user_password'];

          main_menu();

      }
      else
      {
          echo "Invalid username and/or password " . $_SESSION["is_surveyor"] . ".<br>";
          custom_login_9();

          session_destroy();
          session_regenerate_id(TRUE);
          session_start();

          $_SESSION['next_screen'] = 'validate_user';
      }


    }
    /* if username exists POSR array contains main_menu
       returning to main menu from later screens -->  display the main menu*/
    elseif  ((array_key_exists('main_menu', $_POST)) and
             (array_key_exists("username", $_SESSION)))
    {

        main_menu();

    }

    /* if username exists in the SESSION array and admin exists in the POST
        array, then store username and password as PHP variables and display
        the admin console */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('admin', $_POST))
            and ($_SESSION["is_admin"] == 'Y'))
    {
       $username = strip_tags($_SESSION['username']);
       $password = $_SESSION['password'];
       $login = strip_tags($_SESSION['login']);

       admin_console();

    }
    /* if username exists in the SESSION array and map_view exists in the POST
        array, then store username and password as PHP variables and display
        the respective users map module*/
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists("map_view", $_POST))
            and ($_SESSION["is_admin"] == 'Y'))
    {
      $username = strip_tags($_SESSION['username']);
      $password = $_SESSION['password'];
      $login = strip_tags($_SESSION['login']);

      create_map($login, $password);
     }

    /* if username exists in the SESSION array and new exists in the POST array,
        then store username and password as PHP variables and begin a new report:
            -- get the first user's initials from DB
            -- get the next sequencial report_id from DB
            -- display the report info input module */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('new', $_POST))
            and ($_SESSION["is_surveyor"] == 'Y'))
    {
      $username = strip_tags($_SESSION['username']);
      $password = $_SESSION['password'];
      $login = strip_tags($_SESSION['login']);

      // CALL THREE FUNCTIONS HERE:
          // first, get current report_id and 1st USER_INITIALS
      get_inits($login, $username, $password);

      $_SESSION['first_init'] =   $_SESSION['user_init'];
      $_SESSION["first_user"] = $username;

      // get report_id from database
      get_report_id($login, $password);

       // second display to the user the report options
      get_report_info($login, $username, $password);

    }

    /* if username exists in the SESSION array and continue exists in the POST
        array, then store username and password as PHP variables and display the
        new report info input module */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('continue', $_POST))
            and ($_SESSION["is_surveyor"] == 'Y'))
    {
        $username = strip_tags($_SESSION['username']);
        $password = $_SESSION['password'];
        $login = strip_tags($_SESSION['login']);

        user_reports_dropdown($login, $username, $password);

    }

    /* if username exists in the SESSION array and report_recap exists in the
        POST array, then store username, password, report_id, and first_user
        variables as PHP variables and :
            if beach_choice exists in the POST array, then............. */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('report_recap', $_POST))
            and ($_SESSION["is_surveyor"] == 'Y'))
    {
        $username = strip_tags($_SESSION['username']);
        $first_user = strip_tags($_SESSION['first_user']);
        $password = $_SESSION['password'];
        $login = strip_tags($_SESSION['login']);

          if(array_key_exists('beach_choice', $_POST))
          {
            $second_user = strip_tags($_POST['user_choice']);
            $beach_abbr = strip_tags($_POST['beach_choice']);
            $report_id = strip_tags($_SESSION['report_id']);
            $_SESSION['second_user'] = $second_user;
            $_SESSION['beach_abbr'] = $beach_abbr;

            //get 2nd USER_INITIALS
            get_inits($login, $second_user, $password);
            $_SESSION['second_init'] =   $_SESSION['user_init'];

            //update report table with beach, date
            update_report($login, $password, $report_id, $beach_abbr);

            // Echo session variables that were set on previous pages
            echo "Username is " . $_SESSION["username"] . ".<br>";
            echo "beach_choice is " . $_SESSION["beach_abbr"] . ".<br>";
            echo "report_id is " . $_SESSION["report_id"] . ".<br>";
            echo "second_user is " . $_SESSION["second_user"] . ".<br>";
            echo "second_init is " . $_SESSION["second_init"] . ".<br>";
            echo "first_init is " . $_SESSION["first_init"] . ".<br>";
            echo "first_user is " . $_SESSION["first_user"] . ".<br>";
            echo "user_password is " . $_SESSION["user_password"] . ".<br>";
            echo "password " . $_SESSION["password"] . ".";


            $first_user = strip_tags($_SESSION['first_user']);
            $second_user = strip_tags($_SESSION['second_user']);

            create_surveyors($login, $password, $report_id, $first_user);
            create_surveyors($login, $password, $report_id, $second_user);

          }
          else
          {
            $username = strip_tags($_SESSION['username']);
            $_SESSION['report_id'] = strip_tags($_POST['report_id']);
            $password = $_SESSION['password'];
            $login = strip_tags($_SESSION['login']);

            echo "report_id is " . $_SESSION["report_id"] . ".<br>";

          }
          echo "you have arrived at report recap";
          report_recap($login, $username, $password, $report_id);

    }
    /* otherwise... destroy, regenerate, begin a new SESSION, and display
        the login module */
    else
    {
        custom_login_9();

        session_destroy();
        session_regenerate_id(TRUE);
        session_start();

        $_SESSION['next_screen'] = 'validate_user';
    }?>
    <div class='footer'>
    <?php require_once("328footer-better.html"); ?>
   </div>
</body>
</html>

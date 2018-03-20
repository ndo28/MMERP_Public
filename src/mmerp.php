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
    Modified by: rjw  on: 11/20/16
    Modified by: rjw  on: 11/25/16
    Modified by: gmh  on: 12/3/16

    File: mmerp.php

    Purpose: A master php file to control the flow of html pages in the
             MMERP webapp.

    needed (future) url: http://nrs-projects.humboldt.edu/~mmerp/mmerp.php


-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> MMERP </title>


    <!-- required module files to launch app -->
    <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        require_once("mmerp_login.php");
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
        require_once("get_report_entry_info.php");
        require_once("entry_recap.php");
        require_once("get_PRN.php");
        require_once("get_report_date.php");
        require_once("get_beach_abbr.php");
        require_once("get_second_user.php");
        require_once("fix_date.php");
        require_once ('create_report_entry.php');
        require_once("view_reports.php");
        require_once("view_reports_by_user.php");
        require_once("view_reports_by_beach.php");
        require_once("view_reports_by_species.php");
        require_once("display_existing_report_info.php");
        require_once("report_summary.php");
        require_once("create_report_summary.php");
        require_once ('select_user_dropdown.php');
        require_once ('edit_existing_user.php');
        require_once ('create_new_user_entry.php');
        require_once ('edit_user_create_initials.php');
        require_once ('edit_existing_user_recap.php');
        require_once ('edit_new_user.php');
        require_once('is_new_user.php');
        require_once('display_existing_report_info_user.php');
        require_once('display_existing_report_info_species.php');
        require_once('display_existing_report_info_beach.php');

    ?>

    <!-- css normalization  -->
    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />
    <!-- initial bootstrap -->
    <link href="css_main/bootstrap.css"
          type="text/css" rel="stylesheet" />
    <link href="css_main/bootstrap-theme.css"
          type="text/css" rel="stylesheet" />
    <link href="css_main/mmerp.css"
          type="text/css" rel="stylesheet" />
  <!--  <link href="custom.css" type="text/css"
          rel="stylesheet" />
  <script src="custom-session-validate.js" type="text/javascript"> </script> -->

</head>

<body>

  <div class="container-fluid">

  <header class="header">
    <h1>MMERP</h1>
  </header>


    <?php

    /* if there is currently no username or next_screen variables in
          the SESSION array, then display login module */
    if((! array_key_exists("username", $_POST)) and
        (! array_key_exists("next_screen", $_SESSION) or
         (array_key_exists("logout",$_POST))))
    {
        db_login();
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
        $login = 'mmerp';  // this is hard coded username for Oracle
        $password = 'thebangshow';  // this will be hard coded password for Oracle

        $_SESSION['login'] = $login;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['user_password'] = $user_password;
        $_SESSION['first_user'] = $username;




        // validate user password with database, store variables for is_surveyor, is_admin
        validate_user($login, $username, $password, $user_password);

        // if validation is successful continue to main_menu, else restart session
        if ((array_key_exists('is_surveyor', $_SESSION))
            and (array_key_exists('is_admin', $_SESSION)))
        {
            $username = strip_tags($_SESSION['username']);
            $is_surveyor = strip_tags($_SESSION['is_surveyor']);
            $is_admin = strip_tags($_SESSION['is_admin']);
            $user_password = $_SESSION['user_password'];
            $password = $_SESSION["password"];
            main_menu($is_admin, $is_surveyor);
        }
        else
        {
            echo "Invalid username and/or password.<br>";
            db_login();

            session_destroy();
            session_regenerate_id(TRUE);
            session_start();

            $_SESSION['next_screen'] = 'validate_user';
        }


    }
    /* if username exists POST array contains main_menu
       returning to main menu from later screens -->  display the main menu*/
    elseif  ((array_key_exists('main_menu', $_POST)) and
             (array_key_exists("username", $_SESSION)))
    {
      $username = strip_tags($_SESSION['username']);
      $password = $_SESSION['password'];
      $is_surveyor = strip_tags($_SESSION['is_surveyor']);
      $is_admin = strip_tags($_SESSION['is_admin']);
      main_menu($is_admin, $is_surveyor);

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

         admin_console($login, $password);

    }
    /* if username exists in the SESSION array and map_view exists in the POST
        array and the user is an admin, then store username and password as
        PHP variables and display the admin map module */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists("map_view", $_POST))
            and ($_SESSION["is_admin"] == 'Y'))
    {
        $username = strip_tags($_SESSION['username']);
        $password = $_SESSION['password'];
        $login = strip_tags($_SESSION['login']);

        create_map($login, $password);
     }

     /* if username exists in the SESSION array and modify_user exists in the POST
         array and the user is an admin, then store username and password as
         PHP variables and display the select_user_dropdown */
     elseif (array_key_exists("username", $_SESSION)
             and (array_key_exists("modify_user", $_POST))
             and ($_SESSION["is_admin"] == 'Y'))
     {
         $username = strip_tags($_SESSION['username']);
         $password = $_SESSION['password'];
         $login = strip_tags($_SESSION['login']);

         select_user_dropdown($login, $password);
      }

      /* if username exists in the SESSION array and edit_user exists in the POST
          array and the user is an admin, then store username and password as
          PHP variables and display the edit_existing_user module */
      elseif (array_key_exists("username", $_SESSION)
              and (array_key_exists("edit_user", $_POST))
              and ($_SESSION["is_admin"] == 'Y'))
      {
          $username = strip_tags($_SESSION['username']);
          $password = $_SESSION['password'];
          $login = strip_tags($_SESSION['login']);
          $existing_username = strip_tags($_POST['existing_username']);
          $_SESSION['existing_username'] = $existing_username;

          edit_existing_user($login, $password, $existing_username);
       }
       /* if username exists in the SESSION array and redo_edit_user exists in the POST
           array and the user is an admin, then store username and password as
           PHP variables and display the edit_existing_user module */
       elseif (array_key_exists("username", $_SESSION)
               and (array_key_exists("redo_edit_user", $_POST))
               and ($_SESSION["is_admin"] == 'Y'))
       {
           $username = strip_tags($_SESSION['username']);
           $password = $_SESSION['password'];
           $login = strip_tags($_SESSION['login']);
           $existing_username = strip_tags($_SESSION['existing_username']);
           $_SESSION['existing_username'] = $existing_username;

           edit_existing_user($login, $password, $existing_username);
        }
       /* if username exists in the SESSION array and edit_user_recap exists in the POST
           array and the user is an admin, then store username and password as
           PHP variables and performs the following:
              --- creates the initials from fname, lname
              ---displays the edit_user_recap module */
       elseif (array_key_exists("username", $_SESSION)
               and (array_key_exists("edit_user_recap", $_POST))
               and ($_SESSION["is_admin"] == 'Y'))
       {
           $username = strip_tags($_SESSION['username']);
           $password = $_SESSION['password'];
           $login = strip_tags($_SESSION['login']);
           $edit_lname = strip_tags($_POST['edit_lname']);
           $edit_fname = strip_tags($_POST['edit_fname']);
           $edit_email = strip_tags($_POST['edit_email']);
           $edit_admin = strip_tags($_POST['edit_admin']);
           $edit_surveyor = strip_tags($_POST['edit_surveyor']);
           $edit_new_password = $_POST['edit_new_password'];
           $existing_username = strip_tags($_SESSION['existing_username']);

           edit_user_create_initials($edit_lname, $edit_fname);

           $edit_initials = strip_tags($_SESSION['edit_initials']);

           edit_existing_user_recap($login, $password, $existing_username,
                       $edit_new_password, $edit_lname, $edit_fname, $edit_email,
                       $edit_admin, $edit_surveyor, $edit_initials);
        }

      /* if username exists in the SESSION array and create_new_user exists in the POST
          array and the user is an admin, then store username and password as
          PHP variables and display the create_new_user_entry module */
      elseif (array_key_exists("username", $_SESSION)
              and (array_key_exists("create_new_user", $_POST))
              and ($_SESSION["is_admin"] == 'Y'))
      {
          $username = strip_tags($_SESSION['username']);
          $password = $_SESSION['password'];
          $login = strip_tags($_SESSION['login']);

        create_new_user_entry($login, $password);
       }

       /* if username exists in the SESSION array and new_user exists in the POST
           array and the user is an admin, then store username and password as
           PHP variables and display the create_new_user_entry module */
       elseif (array_key_exists("username", $_SESSION)
               and (array_key_exists("new_user", $_POST))
               and ($_SESSION["is_admin"] == 'Y'))
       {
           $username = strip_tags($_SESSION['username']);
           $password = $_SESSION['password'];
           $login = strip_tags($_SESSION['login']);
           $_SESSION['new_username'] = $_POST['new_username'];

           is_new_user($login, $password, $_SESSION['new_username']);

          edit_new_user($login, $password, $_SESSION['existing_username']);
        }

     /* if username exists in the SESSION array and report_view exists in the POST
         array and the user is an admin, then store username and password as
         PHP variables and display the admin report module */
     elseif (array_key_exists("username", $_SESSION)
             and (array_key_exists("report_view", $_POST))
             and ($_SESSION["is_admin"] == 'Y'))
     {
         $username = strip_tags($_SESSION['username']);
         $password = $_SESSION['password'];
         $login = strip_tags($_SESSION['login']);

         view_reports($login, $password);
      }
      /* if username exists in the SESSION array and get_existing_report_info exists
            in the POST array and the user is an admin, then store username and
            password as PHP variables and display the admin existing report info
            module */
      elseif (array_key_exists("username", $_SESSION)
              and (array_key_exists("get_existing_report_info", $_POST))
              and ($_SESSION["is_admin"] == 'Y'))
      {
          $username = strip_tags($_SESSION['username']);
          $password = $_SESSION['password'];
          $login = strip_tags($_SESSION['login']);
          $report = strip_tags($_POST['report_id']);

          display_existing_report_info($login, $password, $report);

       }
      /* if username exists in the SESSION array and report_view_by_user exists
            in the POST array and the user is an admin, then store username and
            password as PHP variables and display the admin report by user
            module */
      elseif (array_key_exists("username", $_SESSION)
              and (array_key_exists("report_view_by_user", $_POST))
              and ($_SESSION["is_admin"] == 'Y'))
      {
          $username = strip_tags($_SESSION['username']);
          $password = $_SESSION['password'];
          $login = strip_tags($_SESSION['login']);

          if(array_key_exists("hsu_username", $_POST))
          {
            $surveyor = strip_tags($_POST['hsu_username']);
            $_SESSION["surveyor"] = $surveyor;
          }
          else
          {
            $surveyor = strip_tags($_SESSION['surveyor']);
          }

          view_reports_by_user($login, $password, $surveyor);
       }
       /* if username exists in the SESSION array and get_existing_report_info_user exists
             in the POST array and the user is an admin, then store username and
             password as PHP variables and display the admin existing report info
             module */
       elseif (array_key_exists("username", $_SESSION)
               and (array_key_exists("get_existing_report_info_user", $_POST))
               and ($_SESSION["is_admin"] == 'Y'))
       {
           $username = strip_tags($_SESSION['username']);
           $password = $_SESSION['password'];
           $login = strip_tags($_SESSION['login']);
           $report = strip_tags($_POST['report_id']);

           display_existing_report_info_user($login, $password, $report);

        }
       /* if username exists in the SESSION array and report_view_by_beach exists
             in the POST array and the user is an admin, then store username and
             password as PHP variables and display the admin report by beach
             module */
       elseif (array_key_exists("username", $_SESSION)
               and (array_key_exists("report_view_by_beach", $_POST))
               and ($_SESSION["is_admin"] == 'Y'))
       {
           $username = strip_tags($_SESSION['username']);
           $password = $_SESSION['password'];
           $login = strip_tags($_SESSION['login']);

           if(array_key_exists("hsu_username", $_POST))
           {
             $beach = strip_tags($_POST['beach_choice']);
             $_SESSION["beach_choice"] = $beach;
           }
           else
           {
             $beach = strip_tags($_SESSION['beach_choice']);
           }

           view_reports_by_beach($login, $password, $beach);
        }
        /* if username exists in the SESSION array and get_existing_report_info_beach exists
              in the POST array and the user is an admin, then store username and
              password as PHP variables and display the admin existing report info
              module */
        elseif (array_key_exists("username", $_SESSION)
                and (array_key_exists("get_existing_report_info_beach", $_POST))
                and ($_SESSION["is_admin"] == 'Y'))
        {
            $username = strip_tags($_SESSION['username']);
            $password = $_SESSION['password'];
            $login = strip_tags($_SESSION['login']);
            $report = strip_tags($_POST['report_id']);

            display_existing_report_info_beach($login, $password, $report);

         }
        /* if username exists in the SESSION array and report_view_by_species exists
              in the POST array and the user is an admin, then store username and
              password as PHP variables and display the admin report by species
              module */
        elseif (array_key_exists("username", $_SESSION)
                and (array_key_exists("report_view_by_species", $_POST))
                and ($_SESSION["is_admin"] == 'Y'))
        {
            $username = strip_tags($_SESSION['username']);
            $password = $_SESSION['password'];
            $login = strip_tags($_SESSION['login']);

            if(array_key_exists("hsu_username", $_POST))
            {
              $species_choice = strip_tags($_POST['species_choice']);
              $_SESSION["species_choice"] = $species_choice;
            }
            else
            {
              $species_choice = strip_tags($_SESSION['species_choice']);
            }

            view_reports_by_species($login, $password, $species_choice);
         }
         /* if username exists in the SESSION array and get_existing_report_info_species exists
               in the POST array and the user is an admin, then store username and
               password as PHP variables and display the admin existing report info
               module */
         elseif (array_key_exists("username", $_SESSION)
                 and (array_key_exists("get_existing_report_info_species", $_POST))
                 and ($_SESSION["is_admin"] == 'Y'))
         {
             $username = strip_tags($_SESSION['username']);
             $password = $_SESSION['password'];
             $login = strip_tags($_SESSION['login']);
             $report = strip_tags($_POST['report_id']);

             display_existing_report_info_species($login, $password, $report);

          }

    /* if username exists in the SESSION array and new exists in the POST array,
        then store username and password as PHP variables and begin a new report:
            -- get the next sequencial report_id from DB
            -- display the report info input module */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('new', $_POST))
            and ($_SESSION["is_surveyor"] == 'Y'))
    {
        $username = strip_tags($_SESSION['username']);
        $password = $_SESSION['password'];
        $login = strip_tags($_SESSION['login']);

        // CALL TWO FUNCTIONS HERE:

        // get report_id from database
        get_report_id($login, $password);

         // second display to the user the report options for beach and second user
        get_report_info($login, $username, $password);

    }
    /* if username exists in the SESSION array and
         new_reports_update exists in the POST array,
         then store SESSION variable and POST variables
         as PHP variables, then do the following modules:
            -- update the new report with beach_abbr, date
            -- update the surveyor table with new entries for
               each surveyor and report_id  (two calls to function)
            -- get initials for first user
            -- get initials for second user
            -- display report_recap module
            */
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('new_reports_update', $_POST))
            and ($_SESSION["is_surveyor"] == 'Y'))
    {
        $username = strip_tags($_SESSION['username']);
        $password = $_SESSION['password'];
        $login = strip_tags($_SESSION['login']);
        $second_user = strip_tags($_POST['user_choice']);
        $beach_abbr = strip_tags($_POST['beach_choice']);
        $report_id = strip_tags($_SESSION['report_id']);
        $_SESSION['second_user'] = $second_user;
        $_SESSION['beach_abbr'] = $beach_abbr;

        $start_time_hrs = strip_tags($_POST['start_time_hrs']);
        $start_time_mins = strip_tags($_POST['start_time_mins']);

        //update report table with beach, date
        update_report($login, $password, $report_id, $beach_abbr, $start_time_hrs, $start_time_mins);

        // Echo session variables that were set on previous pages
        //echo "Username is " . $_SESSION["username"] . ".<br>";
        //echo "beach_choice is " . $_SESSION["beach_abbr"] . ".<br>";
        //echo "report_id is " . $_SESSION["report_id"] . ".<br>";
        //echo "second_user is " . $_SESSION["second_user"] . ".<br>";
        //echo "second_init is " . $_SESSION["second_init"] . ".<br>";
        //echo "first_init is " . $_SESSION["first_init"] . ".<br>";
        //echo "first_user is " . $_SESSION["first_user"] . ".<br>";
        //echo "user_password is " . $_SESSION["user_password"] . ".<br>";
        //echo "password " . $_SESSION["password"] . ".";


        $first_user = strip_tags($_SESSION['first_user']);
        $second_user = strip_tags($_SESSION['second_user']);

        create_surveyors($login, $password, $report_id, $first_user);
        if($second_user != 'none')
        {
          create_surveyors($login, $password, $report_id, $second_user);
        }

        //$username = strip_tags($_SESSION['username']);
        //$first_user = strip_tags($_SESSION['first_user']);
        //$second_user = strip_tags($_SESSION['second_user']);
        //$password = $_SESSION['password'];
        //$login = strip_tags($_SESSION['login']);
        //$report_id = strip_tags($_SESSION['report_id']);
        //echo "report_id is " . $_SESSION["report_id"] . ".<br>";

        // get initials for both surveyors
        // first, get 1st USER_INITIALS
        get_inits($login, $first_user, $password);
        $_SESSION['first_init'] =   $_SESSION['user_init'];

        //get 2nd USER_INITIALS
        if($second_user != 'none')
        {
          get_inits($login, $second_user, $password);
          $_SESSION['second_init'] =   $_SESSION['user_init'];
        }
        else {
          $_SESSION['second_init'] = 'NONE';
        }

        // Echo session variables that were set on previous pages
        //echo "Username is " . $_SESSION["username"] . ".<br>";
        //echo "beach_choice is " . $_SESSION["beach_abbr"] . ".<br>";
        //echo "report_id is " . $_SESSION["report_id"] . ".<br>";
        //echo "second_user is " . $_SESSION["second_user"] . ".<br>";
        //echo "second_init is " . $_SESSION["second_init"] . ".<br>";
        //echo "first_init is " . $_SESSION["first_init"] . ".<br>";
        //echo "first_user is " . $_SESSION["first_user"] . ".<br>";
        //echo "user_password is " . $_SESSION["user_password"] . ".<br>";
        //echo "password " . $_SESSION["password"] . ".";
        //echo "you have arrived at report recap";

        report_recap($login, $password, $report_id);


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
    /* if username exists in the SESSION array and
         existing_reports exists in the POST array,
         then store SESSION variable and POST variables
         as PHP variables, then do the following modules:
            -- get second user id from surveyors table
               and store in SESSION variable
            -- get beach_abbr from reports table and store
               in SESSION variable
             -- get initials for first user
             -- get initials for second user
             -- display report_recap module
    ----------*/
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists('existing_reports', $_POST))
            and ($_SESSION["is_surveyor"] == 'Y'))
    {
        $username = strip_tags($_SESSION['username']);
        $_SESSION['report_id'] = strip_tags($_POST['report_id']);
        $password = $_SESSION['password'];
        $login = strip_tags($_SESSION['login']);
        $report_id = strip_tags($_SESSION['report_id']);

        //echo "report_id is " . $_SESSION["report_id"] . ".<br>";

        // get second surveyor
        get_second_user($login, $password, $username, $report_id);

        // get beach_abbr
        get_beach_abbr($login, $password, $report_id);

        //echo "beach_abbr is " . $_SESSION["beach_abbr"] . ".<br>";

        //$username = strip_tags($_SESSION['username']);
        $first_user = strip_tags($_SESSION['first_user']);
        $second_user = strip_tags($_SESSION['second_user']);

        //echo "report_id is " . $_SESSION["report_id"] . ".<br>";

        // get initials for both surveyors
        // first, get 1st USER_INITIALS
        get_inits($login, $first_user, $password);
        $_SESSION['first_init'] =   $_SESSION['user_init'];

        //get 2nd USER_INITIALS
        if($second_user != '')
        {
          get_inits($login, $second_user, $password);
          $_SESSION['second_init'] =   $_SESSION['user_init'];
        }
        else {
          $_SESSION['second_init'] = 'NONE';
        }

        //echo "you have arrived at report recap";

        report_recap($login, $password, $report_id);

    }

    /* if username exists in the SESSION array and add_entry in the POST
        array, then strips and stores the login and password variables and then
        displays the get_report_entry_info module*/
    elseif (array_key_exists("username", $_SESSION)
            and (array_key_exists("add_entry", $_POST))
            and ($_SESSION["is_surveyor"] == 'Y'))
    {
          $username = strip_tags($_SESSION['username']);
          $password = $_SESSION['password'];
          $login = strip_tags($_SESSION['login']);
          $first_init = strip_tags($_SESSION['first_init']);
          $second_init = strip_tags($_SESSION['second_init']);

          get_report_entry_info($login, $password, $first_init, $second_init);
     }

     /* if username exists in the SESSION array and entry_recap in the POST
         array, then strips and stores the variables passed from POST and then
         does the following:
         --runs get_report_date to store the report_date to SESSION array
         --runs fix_date to fix the Oracle date to be the PRN format
         --runs get_PRN to create and store the PRN to SESSION array
         --displays the entry_recap module */
     elseif (array_key_exists("username", $_SESSION)
             and (array_key_exists("entry_recap", $_POST))
             and ($_SESSION["is_surveyor"] == 'Y'))
     {
         $username = strip_tags($_SESSION['username']);
         $password = $_SESSION['password'];
         $login = strip_tags($_SESSION['login']);
         $report_id = strip_tags($_SESSION['report_id']);
         $existing_tags = strip_tags($_POST['existing_tags']);
         $photos = $_POST['photos'];
         $post_tag = strip_tags($_POST['post_tag']);
         $spec_abbr = $_POST['spec_abbr'];
         $survey_type = $_POST['survey_type'];
         $latitude = strip_tags($_POST['latitude']);
         $longitude = $_POST['longitude'];
         $surveyor_init = $_POST['surveyor_init'];

         $_SESSION['existing_tags'] = $existing_tags;
         $_SESSION['photos'] = $photos;
         $_SESSION['post_tag'] = $post_tag;
         $_SESSION['spec_abbr'] = $spec_abbr;
         $_SESSION['latitude'] = $latitude;
         $_SESSION['longitude'] = $longitude;
         $_SESSION['survey_type'] = $survey_type;
         $_SESSION['surveyor_init'] = $surveyor_init;


         get_report_date($login, $password, $report_id);

         // Echo session variables that are stored
        //  echo "beach_abbr is " . $_SESSION["beach_abbr"] . ".<br>";
        //  echo "report_id is " . $_SESSION["report_id"] . ".<br>";
        //  echo "second_user is " . $_SESSION["second_user"] . ".<br>";
        //  echo "first_user is " . $_SESSION["first_user"] . ".<br>";
        //  echo "second_init is " . $_SESSION["second_init"] . ".<br>";
        //  echo "first_init is " . $_SESSION["first_init"] . ".<br>";
        //  echo "spec_abbr is " . $_SESSION["spec_abbr"] . ".<br>";
        //  echo "report_date is " . $_SESSION["report_date"] . ".<br>";
        //  echo "post_tag is " . $_SESSION["post_tag"] . ".<br>";
        //  echo "latitude is " . $_SESSION["latitude"] . ".<br>";
        //  echo "longitude is " . $_SESSION["longitude"] . ".<br>";
        //  echo "photos is " . $_SESSION["photos"] . ".<br>";
        //  echo "existing_tags is " . $_SESSION["existing_tags"] . ".<br>";
        //  echo "survey_type is " . $_SESSION["survey_type"] . ".<br>";

         $report_date = $_SESSION['report_date'];

         fix_date($report_date);

         //echo "day is " . $_SESSION["PRN_date"] . ".<br>";

         $PRN_date = $_SESSION['PRN_date'];
         $beach_abbr = $_SESSION["beach_abbr"];

         get_PRN($login, $password, $report_id, $PRN_date, $beach_abbr,
                           $spec_abbr, $surveyor_init, $survey_type);

         //echo "PRN is " . $_SESSION["PRN"] . ".<br>";

         $PRN = $_SESSION['PRN'];

         entry_recap($login, $password, $PRN, $latitude, $longitude, $spec_abbr);
       }
         /* if username exists in the SESSION array and submit_entry exists in the POST array,
             then store login, password and comment (from POST)as PHP
             variables and display the insert report_entry module*/
     elseif (array_key_exists("username", $_SESSION)
             and (array_key_exists('submit_entry', $_POST))
             and ($_SESSION["is_surveyor"] == 'Y'))
     {
         $username = strip_tags($_SESSION['username']);
         $login = strip_tags($_SESSION['login']);
         $password = $_SESSION['password'];

         //echo "you have arrived at report entry submit";

         $comment = $_POST['comment'];
         //$_SESSION['comment'] = $comment;

         //echo "comment is " . $_SESSION["comment"] . ".<br>";
         $report_id = strip_tags($_SESSION['report_id']);
         $username = strip_tags($_SESSION['username']);
         $spec_abbr = strip_tags($_SESSION['spec_abbr']);
         $latitude = strip_tags($_SESSION['latitude']);
         $longitude = strip_tags($_SESSION['longitude']);
         $post_tag = strip_tags($_SESSION['post_tag']);
         $existing_tags = strip_tags($_SESSION['existing_tags']);
         $photos = strip_tags($_SESSION['photos']);
         $no_animals = strip_tags($_SESSION['no_animals']);
         $PRN = strip_tags($_SESSION['PRN']);

         create_report_entry($login, $password, $PRN, $report_id, $username, $spec_abbr,
                             $post_tag, $existing_tags, $photos, $no_animals, $comment, $latitude, $longitude);

     }
     /* if username exists in the SESSION array and submit_entry exists in the POST array,
         then store username and password as PHP variables and begin a new report:
             -- get the next sequencial report_id from DB
             -- display the report info input module */
     elseif (array_key_exists("username", $_SESSION)
             and (array_key_exists('add_photos', $_POST))
             and ($_SESSION["is_surveyor"] == 'Y'))
     {
         $username = strip_tags($_SESSION['username']);
         $login = strip_tags($_SESSION['login']);

          //   add photo capture page here!!
          photo_upload();

     }
         /* if username exists in the SESSION array and report_recap exists in the POST
             array, then store username and password as PHP variables and display the
             report_recap module */
     elseif (array_key_exists("username", $_SESSION)
             and (array_key_exists('report_recap', $_POST))
             and ($_SESSION["is_surveyor"] == 'Y'))
     {
         $report_id = strip_tags($_SESSION['report_id']);
         $password = $_SESSION['password'];
         $login = strip_tags($_SESSION['login']);

         report_recap($login, $password, $report_id);

     }

     /* if username exists in the SESSION array and to_summary exists in the POST
         array, then store username and password as PHP variables and display the
         report_summary module */
       elseif (array_key_exists("username", $_SESSION)
               and (array_key_exists('to_summary', $_POST))
               and ($_SESSION["is_surveyor"] == 'Y'))
       {
           $report_id = strip_tags($_SESSION['report_id']);
           $password = $_SESSION['password'];
           $login = strip_tags($_SESSION['login']);

          report_summary($login, $password, $report_id);
       }

       /* if username exists in the SESSION array and submit_report exists in the POST
           array, then store username and password as PHP variables and display the
           create_report_summary module */
         elseif (array_key_exists("username", $_SESSION)
                 and (array_key_exists('submit_report', $_POST))
                 and ($_SESSION["is_surveyor"] == 'Y'))
         {
             $report_id = strip_tags($_SESSION['report_id']);
             $password = $_SESSION['password'];
             $login = strip_tags($_SESSION['login']);
             $summary = $_POST['summary'];
             $end_time_hrs = $_POST['end_time_hrs'];
             $end_time_mins = $_POST['end_time_mins'];
             $total_time = $_POST['total_time'];

             create_report_summary($login, $password, $summary, $report_id, $end_time_hrs, $end_time_mins, $total_time);
         }


         /* otherwise... destroy, regenerate, begin a new SESSION, and display
        the login module */
    else
    {
        db_login();

        session_destroy();
        session_regenerate_id(TRUE);
        session_start();

        $_SESSION['next_screen'] = 'validate_user';
    }
 ?>
</div>
</body>
</html>

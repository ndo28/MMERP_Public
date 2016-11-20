<?php

      // function:  get_report_id
      // purpose: expects Oracle username and password
      //     returns nothing but stores into session variable
      //     the new report_id and USER_INITIALS
      //     queries the database for user initial and
      //     inserts a report with only a report_id and
      //     time.

      function get_inits($login, $username, $password)
      {
          $conn = hsu_conn_sess($login, $password);

          // here  ive connected

          // this collects 1st user initials and stores to a SESSION variable
          $user_query =  'SELECT USER_INITIALS '.
                         'FROM USERS '.
                         'WHERE HSU_USERNAME = :USERNAME';

          $user_stmt = oci_parse($conn, $user_query);

          oci_bind_by_name($user_stmt,":username",$username);

          oci_execute($user_stmt, OCI_DEFAULT);
          oci_fetch($user_stmt);

          $first_init = oci_result($user_stmt, "USER_INITIALS");

          oci_free_statement($user_stmt);
          oci_close($conn);

          $_SESSION['first_init'] = $first_init;

      }

 ?>

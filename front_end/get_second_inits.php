<?php

      // function:  get_report_id
      // purpose: expects Oracle username and password
      //     returns nothing but stores into session variable
      //     the new report_id and USER_INITIALS
      //     queries the database for user initial and
      //     inserts a report with only a report_id and
      //     time.

      function get_second_inits($username, $password, $second_user)
      {
          $conn = hsu_conn_sess($username, $password);

          // here  ive connected

          // this collects 1st user initials and stores to a SESSION variable
          $user_query =  'SELECT USER_INITIALS '.
                         'FROM USERS '.
                         'WHERE HSU_USERNAME = :USERNAME';

          $user_stmt = oci_parse($conn, $user_query);

          oci_bind_by_name($user_stmt,":username",$second_user);

          oci_execute($user_stmt, OCI_DEFAULT);
          oci_fetch($user_stmt);

          $second_init = oci_result($user_stmt, "USER_INITIALS");

          oci_free_statement($user_stmt);
          oci_close($conn);

      }

 ?>

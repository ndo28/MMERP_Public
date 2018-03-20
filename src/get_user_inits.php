<?php

/*--------
get_user_inits.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Rebecca on 11/16/16

Modified by: rjw  on: 11/20/16

    function: get_inits
    purpose: expects an entered Oracle login and
        password and mmerp username and performs the following:
        --queries the database for the users initials
        --stores the initials in the SESSION array

    uses: hsu_conn_sess
-------*/

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

          $user_init = oci_result($user_stmt, "USER_INITIALS");

          oci_free_statement($user_stmt);
          oci_close($conn);

          $_SESSION['user_init'] = $user_init;

      }

 ?>

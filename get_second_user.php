<?php
  /*--------

  get_second_user.php

  Guthrie Hayward (gmh234)
  Nathan Ortolan (ndo28)
  Becky Williams (rjw125)
  Abdul Shaikh (ats234)

  Created by Rebecca on 11/20/16

  Modified by:   on:

      function: get_second_user
      purpose: expects an entered Oracle login and
          password and report_id
          and performs the following:
          --queries the surveyor table for additional HSU_username
          --stores the second_user in the SESSION array

      uses: hsu_conn_sess
  -------*/

function get_second_user($login, $password, $username, $report_id)
{
      $conn = hsu_conn_sess($login, $password);

      // this collects the report_date from the reports table
      $report_query = 'SELECT HSU_username '.
                    'FROM surveyors '.
                    'WHERE HSU_USERNAME != :username '.
                    'and report_id = :report_id';
      //
      $report_stmt = oci_parse($conn, $report_query);
      //

      oci_bind_by_name($report_stmt, ":report_id", $report_id);
      oci_bind_by_name($report_stmt, ":username", $username);

      oci_execute($report_stmt, OCI_DEFAULT);
      oci_fetch($report_stmt);

      $second_user = oci_result($report_stmt, "HSU_USERNAME");
      oci_free_statement($report_stmt);
      oci_close($conn);

      $_SESSION['second_user'] = $second_user;

}

?>

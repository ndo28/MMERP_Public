<?php
  /*--------

  get_report_date.php

  Guthrie Hayward (gmh234)
  Nathan Ortolan (ndo28)
  Becky Williams (rjw125)
  Abdul Shaikh (ats234)

  Created by Rebecca on 11/20/16

  Modified by:   on:

      function: get_report_date
      purpose: expects an entered Oracle login and
          password and report_id
          and performs the following:
          --queries the reports table for report_date
          --stores the report_date in the SESSION array

      uses: hsu_conn_sess
  -------*/

function get_report_date($login, $password, $report_id)
{
      $conn = hsu_conn_sess($login, $password);

      // this collects the report_date from the reports table
      $report_query = 'SELECT REPORT_DATE '.
                    'FROM REPORTS '.
                    'where report_id = :report_id';
      //
      $report_stmt = oci_parse($conn, $report_query);
      //
      oci_bind_by_name($report_stmt, ":report_id", $report_id);
      
      oci_execute($report_stmt, OCI_DEFAULT);
      oci_fetch($report_stmt);

      $report_date = oci_result($report_stmt, "REPORT_DATE");
      oci_free_statement($report_stmt);
      oci_close($conn);

      $_SESSION['report_date'] = $report_date;

}

?>

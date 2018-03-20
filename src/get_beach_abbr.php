<?php
  /*--------

  get_beach_abbr.php

  Guthrie Hayward (gmh234)
  Nathan Ortolan (ndo28)
  Becky Williams (rjw125)
  Abdul Shaikh (ats234)

  Created by Rebecca on 11/20/16

  Modified by:   on:

      function: get_beach_abbr
      purpose: expects an entered Oracle login and
          password and report_id
          and performs the following:
          --queries the reports table for beach_abbr
          --stores the beach_abbr in the SESSION array

      uses: hsu_conn_sess
  -------*/

function get_beach_abbr($login, $password, $report_id)
{
      $conn = hsu_conn_sess($login, $password);

      // this collects the report_date from the reports table
      $report_query = 'SELECT beach_abbr '.
                    'FROM REPORTS '.
                    'where report_id = :report_id';
      //
      $report_stmt = oci_parse($conn, $report_query);

      oci_bind_by_name($report_stmt, ":report_id", $report_id);
      //
      oci_execute($report_stmt, OCI_DEFAULT);
      oci_fetch($report_stmt);

      $beach_abbr = oci_result($report_stmt, "BEACH_ABBR");
      oci_free_statement($report_stmt);
      oci_close($conn);

      $_SESSION['beach_abbr'] = $beach_abbr;

}

?>

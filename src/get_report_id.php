<?php
/*--------
get_report_id.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Abdul, Guthrie on 11/5/16

Modified by: rjw, ats  on: 11/13/16
Modified by: rjw  on: 11/16/16
Modified by: rjw  on: 11/20/16

      function:  get_report_id
      purpose: expects Oracle login and password
          returns nothing but performs the following:
          --inserts into reports table a new report
          --uses the reports-sequence for report_id
          --queries reports table for current report_id
          --store the report_id in SESSION array

    uses: hsu_conn_sess
-------*/

      function get_report_id($login, $password)
      {
          $conn = hsu_conn_sess($login, $password);

          // here  ive connected
          // this creates a report in the database

          $report_insert = "INSERT INTO REPORTS (REPORT_ID, START_TIME, REPORT_DATE)
                            VALUES (REPORT_ID_SEQ.NEXTVAL, '0.00', sysdate) ";

          $insert_stmt = oci_parse($conn, $report_insert);
          oci_execute($insert_stmt, OCI_DEFAULT);
          oci_commit($conn);


          // this collects the report_id from the current
           $report_query = 'SELECT REPORT_ID_SEQ.CURRVAL '.
                          'FROM REPORTS';
          //
           $report_stmt = oci_parse($conn, $report_query);
          //
           oci_execute($report_stmt, OCI_DEFAULT);
           oci_fetch($report_stmt);
           $report_id = oci_result($report_stmt, "CURRVAL");

          oci_free_statement($insert_stmt);
          oci_free_statement($report_stmt);
          oci_close($conn);

          $_SESSION['report_id'] = $report_id;

      }

 ?>

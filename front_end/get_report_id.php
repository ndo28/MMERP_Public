<?php

      // function:  get_report_id
      // purpose: expects Oracle username and password
      //     returns nothing but stores into session variable
      //     the new report_id and USER_INITIALS
      //     queries the database for user initial and
      //     inserts a report with only a report_id and
      //     time.

      function get_report_id($login, $username, $password)
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

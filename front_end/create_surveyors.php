<?php

      // function:  get_report_id
      // purpose: expects Oracle username and password
      //     returns nothing but stores into session variable
      //     the new report_id and USER_INITIALS
      //     queries the database for user initial and
      //     inserts a report with only a report_id and
      //     time.

      function create_surveyors($login, $username, $password, $report_id, $surveyor)
      {
          $conn = hsu_conn_sess($login, $password);

          // here  ive connected
          // this creates a report in the database

          $insert = "INSERT INTO SURVEYORS (HSU_USERNAME, REPORT_ID)
                            VALUES (:surveyor, :report_id) ";

          $insert_stmt = oci_parse($conn, $insert);

          oci_bind_by_name($insert_stmt, ":surveyor", $surveyor);
          oci_bind_by_name($insert_stmt, ":report_id", $report_id);

          oci_execute($insert_stmt, OCI_DEFAULT);
          oci_commit($conn);
          oci_free_statement($insert_stmt);
          oci_close($conn);

      }

 ?>

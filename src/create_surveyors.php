<?php

/*--------
create_surveyors.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Rebecca on 11/16/16

Modified by: rjw  on: 11/20/16

    function: create_surveyors
    purpose: expects an entered Oracle login and
        password and report_id and surveyor HSU_USERNAME
        and performs the following:
        --inserts the surveyor and report_id into the surveyor table
        --commits the transaction

    uses: hsu_conn_sess
-------*/

      function create_surveyors($login, $password, $report_id, $surveyor)
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

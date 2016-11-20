<?php
  /*--------
      function: update_report
      purpose: expects an entered Oracle username and
          password and a selected beach_abbr and report_id
          updates that report_id with beach, sysdate
          -- commits teh transaction

      uses: hsu_conn_sess
  -------*/

function update_report($login, $username, $password, $report_id, $beach_abbr)
{
    // try to connect to Oracle student database

    $conn = hsu_conn_sess($login, $password);

    $update_call = 'update reports '.
                    'set BEACH_ABBR = :beach_abbr '.
                    'where report_id = :report_id';

    $update_stmt = oci_parse($conn, $update_call);

    // set the bind variables

    // when a bind variable is for input purposes
    //    (input TO the data tier), only NEED 3
    //    arguments


    oci_bind_by_name($update_stmt, ":beach_abbr",
                     $beach_abbr);
    oci_bind_by_name($update_stmt, ":report_id",
                     $report_id);

    // now, executing! (and committing -- changed database,
    //     and want to commit that change;)

    oci_execute($update_stmt, OCI_DEFAULT);
    oci_commit($conn);

    // done with THIS statement

    oci_free_statement($update_stmt);
    oci_close($conn);

}
?>

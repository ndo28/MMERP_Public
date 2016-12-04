<?php
  /*--------

  view_reports_by_user.php


  modified : ndo28 - 11/26/16
             gmh234 - 12/03/16

      function: view_reports_by_user
      purpose: expects an Oracle login and password and hsu_username, returns nothing
          but has the side effect of generating a dropdown of reports in which the
          surveyor has participated.

      uses: hsu_conn_sess
  -------*/
?>


<?php
function view_reports_by_user($login, $password, $surveyor)
{
    // try to connect to Oracle student database

    $conn = hsu_conn_sess($login, $password);

    $report_query = 'SELECT REPORTS.REPORT_ID, REPORT_DATE, BEACH_NAME '.
                  'FROM REPORTS, SURVEYORS, BEACHES '.
                  'WHERE HSU_USERNAME = :SURVEYOR '.
                  'AND REPORTS.BEACH_ABBR = BEACHES.BEACH_ABBR '.
                  'AND REPORTS.REPORT_ID = SURVEYORS.REPORT_ID '.
                  'ORDER BY REPORT_DATE';

    $query_stmt = oci_parse($conn, $report_query);

    oci_bind_by_name($query_stmt, ":surveyor", $surveyor);


    // now, executing! (and committing -- changed database,
    //     and want to commit that change;)

    oci_execute($query_stmt, OCI_DEFAULT);

    ?>

    <form class="form-inline" action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
    <div class="form-group">
     <fieldset>
      <legend> Select a report to view details </legend>

      <label for="reports"> Reports </label>
      <select name = "report_id">
      <?php
        while (oci_fetch($query_stmt))
        {
          $curr_report_id = oci_result($query_stmt, "REPORT_ID");
          $curr_date = oci_result($query_stmt, "REPORT_DATE");
          $curr_beach = oci_result($query_stmt, "BEACH_NAME");
          ?>
          <option value = "<?= $curr_report_id ?>">
            <?= $curr_date ?> .. <?= $curr_beach ?> .. <?= $curr_report_id ?>
          </option>
          <?php
        }
        ?>
      </select>

       <input type="submit" name="admin" value="Go Back" />
       <input type="submit" name="get_existing_report_info" value="Continue" />

    </fieldset>
   </div>
   </form>
   <?php
    // done with THIS statement

    oci_free_statement($query_stmt);
    oci_close($conn);

}
?>

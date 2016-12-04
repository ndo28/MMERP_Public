<?php
  /*--------
  user_reports_dropdown.php

  Guthrie Hayward (gmh234)
  Nathan Ortolan (ndo28)
  Becky Williams (rjw125)
  Abdul Shaikh (ats234)

  Created by Abdul, Guthrie and Rebecca on 11/5/16

  Modified by: rjw, ats  on: 11/13/16
  Modified by: rjw  on: 11/14/16
  Modified by: ats  on: 11/14/16
  Modified by: ndo  on: 11/16/16
  Modified by: rjw  on: 11/20/16
  Modified by: gmh  on: 12/03/16

      function: user_reports_dropdown
      purpose: expects an entered Oracle login and
          password and mmerp username and retrives the
          list of current reports in the database with that
          user.  displays this with the report_date, beach-name and
          report_id from query to the database.
          --stores the selected report_id to the POST array on submit
          --optional go back to main menu on submit

      uses: hsu_conn_sess
  -------*/

function user_reports_dropdown($login, $username, $password)
{
    // Now a query to display results of updated row
    $conn = hsu_conn_sess($login, $password);

    ?>
    <form class="form_block" action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
    <fieldset>
      <legend> Select the report you you like to continue </legend>
      <?PHP

      $report_query = 'SELECT REPORTS.REPORT_ID, REPORT_DATE, BEACH_NAME '.
                    'FROM REPORTS, SURVEYORS, BEACHES '.
                    'WHERE HSU_USERNAME = :USERNAME '.
                    'AND REPORTS.BEACH_ABBR = BEACHES.BEACH_ABBR '.
                    'AND REPORTS.REPORT_ID = SURVEYORS.REPORT_ID';

    $query_stmt = oci_parse($conn, $report_query);

    // bind php variable to Oracle variable

    oci_bind_by_name($query_stmt, ":username",
                     $username);

    // now execute! non-selects, when executed,
    //    return number of rows affected,
    //    (or 0 for statements that don't affect rows)

    oci_execute($query_stmt, OCI_DEFAULT);

    ?>
    <label for="reports"> User Reports </label>
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

    oci_free_statement($query_stmt);
    ?>
    </select>
    <?php

    oci_close($conn);
    ?>
    
      <input type="submit" name="main_menu" value="Go Back" />
      <input type="submit" name="existing_reports" value="Continue" />

  </fieldset>
  </form>

    <?php
  }
    ?>

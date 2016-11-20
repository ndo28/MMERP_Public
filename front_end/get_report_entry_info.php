<?php
  /*--------
  get_report_entry_info.php

  Guthrie Hayward (gmh234)
  Nathan Ortolan (ndo28)
  Becky Williams (rjw125)
  Abdul Shaikh (ats234)

  Created by Rebecca on 11/20/16

  Modified by:   on:

      function: get_report_entry_info
      purpose: expects an Oracle login and password, mmerp
          username and report_id and builds a form for the
          surveyor to report findings on beach walk.
          current quanity on hand for that product
          --stores this into the Session Array for next php function

      uses: hsu_conn_sess
  -------*/

function user_reports_dropdown($login, $username, $password)
{
    // Now a query to display results of updated row
    $conn = hsu_conn_sess($login, $password);

    ?>
    <form action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
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

    <div class="submit">
      <input type="submit" name="report_recap" value="Continue" />
      <input type="submit" name="main_menu" value="Go Back" />
    </div>

  </fieldset>
  </form>

    <?php
  }
    ?>

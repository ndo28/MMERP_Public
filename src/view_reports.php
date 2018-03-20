<?php
  /*--------

  view_reports.php


  modified : ndo28 - 11/26/16
             rjw125 - 12/03/16
             gmh234 - 12/03/16
             gmh234 - 12/04/16

      function: view_reports
      purpose: expects an Oracle login and password and returns nothing
          but has the side effect of generating a table of existing reports

      uses: hsu_conn_sess
  -------*/

function view_reports($login, $password)
{
    // try to connect to Oracle student database

    $conn = hsu_conn_sess($login, $password);

    $report_query = 'SELECT REPORTS.REPORT_ID, REPORT_DATE, BEACH_NAME '.
                  'FROM REPORTS, BEACHES '.
                  'WHERE REPORTS.BEACH_ABBR = BEACHES.BEACH_ABBR '.
                  'ORDER BY REPORT_DATE';

    $query_stmt = oci_parse($conn, $report_query);


    // now, executing! (and committing -- changed database,
    //     and want to commit that change;)

    oci_execute($query_stmt, OCI_DEFAULT);

    ?>

    <form class="form-inline" action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
    <div class="form-group">
     <fieldset>
      <legend> View All Reports </legend>

      <label for="reports"> Reports </label>
      <select name = "report_id" required>
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

       <input type="submit" name="get_existing_report_info" value="Continue" />

    </fieldset>
   </div>
   <?php
    oci_free_statement($query_stmt);
    $user_query = 'SELECT DISTINCT HSU_USERNAME '.
                  'FROM SURVEYORS '.
                  'ORDER BY HSU_USERNAME';


    $user_stmt = oci_parse($conn, $user_query);

    oci_execute($user_stmt, OCI_DEFAULT);
    ?>
        <fieldset>
            <legend> View Reports by Surveyor </legend>
              <label for="surveyors"> Surveyors </label>
              <select name="hsu_username">
                <?php
                  while(oci_fetch($user_stmt))
                  {
                    $curr_surveyor = oci_result($user_stmt, "HSU_USERNAME");
                    ?>
                    <option value="<?= $curr_surveyor ?>" required>
                      <?= $curr_surveyor ?>
                    </option>
                    <?php
                  }
                  ?>
              </select>
              <input type="submit" name="report_view_by_user" value="View Reports"/>

        </fieldset>
    <?php
      oci_free_statement($user_stmt);

      $beach_query = 'SELECT DISTINCT REPORTS.BEACH_ABBR, BEACH_NAME '.
                     'FROM REPORTS, BEACHES '.
                     'WHERE REPORTS.BEACH_ABBR = BEACHES.BEACH_ABBR '.
                     'ORDER BY BEACH_NAME';

      $beach_stmt = oci_parse($conn, $beach_query);

      oci_execute($beach_stmt, OCI_DEFAULT);

    ?>
        <fieldset>
            <legend> View Reports by Beach </legend>
              <label for="surveyors"> Beaches </label>
              <select name="beach_choice">
                <?php
                  while(oci_fetch($beach_stmt))
                  {
                    $curr_beach = oci_result($beach_stmt, "BEACH_NAME");
                    ?>
                    <option value="<?= $curr_beach ?>" required>
                      <?= $curr_beach ?>
                    </option>
                    <?php
                  }
                  ?>
              </select>
              <input type="submit" name="report_view_by_beach" value="View Reports"/>

      </fieldset>

    <?php
    oci_free_statement($beach_stmt);
    $species_query = 'SELECT DISTINCT spec_name '.
                  'FROM SPECIES, reports, report_entries '.
                  'WHERE reports.report_id = report_entries.report_id '.
                  'AND report_entries.species_abbr = species.spec_abbr '.
                  'ORDER BY spec_name';


    $species_stmt = oci_parse($conn, $species_query);

    oci_execute($species_stmt, OCI_DEFAULT);
    ?>
        <fieldset>
            <legend> View Reports by Species </legend>
              <label for="species"> Species </label>
              <select name="species_choice">
                <?php
                  while(oci_fetch($species_stmt))
                  {
                    $curr_species = oci_result($species_stmt, "SPEC_NAME");
                    ?>
                    <option value="<?= $curr_species ?>" required>
                      <?= $curr_species ?>
                    </option>
                    <?php
                  }
                  ?>
              </select>
              <input type="submit" name="report_view_by_species" value="View Reports"/>

      </fieldset>
    </div>
    <input type="submit" name="admin" value="Go Back" />
    </form>
    <?php
      oci_free_statement($species_stmt);
      oci_close($conn);
}
?>

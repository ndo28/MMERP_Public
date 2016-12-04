<?php
  /*--------

  view_reports_by_species.php


  modified : rjw125 - 12/03/16

      function: view_reports_by_species
      purpose: expects an Oracle login and password and species_choice, returns nothing
          but has the side effect of generating a dropdown of reports that have been
          made involving that species

      uses: hsu_conn_sess
  -------*/
?>


<?php
function view_reports_by_species($login, $password, $species)
{
    // try to connect to Oracle student database

    $conn = hsu_conn_sess($login, $password);

    $report_query = 'SELECT DISTINCT REPORTS.REPORT_ID, REPORT_DATE, BEACH_NAME '.
                  'FROM REPORTS, BEACHES, REPORT_ENTRIES, SPECIES '.
                  'WHERE SPEC_NAME = :SPECIES '.
                  'AND REPORTS.BEACH_ABBR = BEACHES.BEACH_ABBR '.
                  'AND REPORTS.REPORT_ID = REPORT_ENTRIES.REPORT_ID '.
                  'AND SPECIES.SPEC_ABBR = REPORT_ENTRIES.SPECIES_ABBR '.
                  'ORDER BY REPORT_DATE';

    $query_stmt = oci_parse($conn, $report_query);

    oci_bind_by_name($query_stmt, ":species", $species);


    // now, executing! (and committing -- changed database,
    //     and want to commit that change;)

    oci_execute($query_stmt, OCI_DEFAULT);

    ?>

    <form action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
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

     <div class="submit">
         <input type="submit" name="admin" value="Go Back" />
         <input type="submit" name="main_menu" value="Main Menu" />

     </div>

    </fieldset>
   </form>
   <?php
    // done with THIS statement

    oci_free_statement($query_stmt);
    oci_close($conn);

}
?>

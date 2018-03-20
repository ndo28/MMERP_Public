<?php
  /*--------

  display_existing_report_info.php


  modified : ndo28 - 11/26/16
             gmh234, rjw125 - 12/04/16

      function: display_existing_report_info
      purpose: expects an Oracle login and password and report id, returns nothing
          but has the side effect of generating a report info display page.

      uses: hsu_conn_sess
  -------*/
?>


<?php
function display_existing_report_info($login, $password, $report)
{
    // try to connect to Oracle student database

    $conn = hsu_conn_sess($login, $password);

    $report_query = 'SELECT REPORT_ID, START_TIME, END_TIME, REPORT_DATE, BEACH_NAME, SURVEY_SUMMARY '.
                  'FROM REPORTS, BEACHES '.
                  'WHERE REPORTS.BEACH_ABBR = BEACHES.BEACH_ABBR '.
                  'AND REPORT_ID = :REPORT';

    $query_stmt = oci_parse($conn, $report_query);

    oci_bind_by_name($query_stmt, ":report", $report);

    oci_execute($query_stmt, OCI_DEFAULT);
    oci_fetch($query_stmt);
    ?>

    <form class="form-inline" action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
    <div class="form-group">
     <fieldset>
      <legend> Report Details </legend>
      <p name="report_details">
          Report ID : <?= oci_result($query_stmt, "REPORT_ID"); ?> <br>
          Beach : <?= oci_result($query_stmt, "BEACH_NAME"); ?> <br>
          Date : <?= oci_result($query_stmt, "REPORT_DATE"); ?> <br>
          Start Time: <?= oci_result($query_stmt, "START_TIME"); ?> <br>
          End Time: <?= oci_result($query_stmt, "END_TIME"); ?> <br>
          Survey Summary: <?= oci_result($query_stmt, "SURVEY_SUMMARY"); ?> <br>
      </p>

     <?php
     oci_free_statement($query_stmt);

     $entries_query = 'SELECT PRN, HSU_USERNAME, SPEC_NAME, POST_SURVEY_TAG, '.
                      'EXISTING_TAGS, PHOTOS, COMMENTS '.
                      'FROM REPORT_ENTRIES, SPECIES '.
                      'WHERE REPORT_ENTRIES.SPECIES_ABBR = SPECIES.SPEC_ABBR '.
                      'AND REPORT_ID = :REPORT';
                      
     /* $entries_query = 'SELECT PRN, HSU_USERNAME, SPECIES_ABBR, COMMENTS '.
                      'FROM REPORT_ENTRIES '.
                      'WHERE REPORT_ID = :REPORT '; */

     $entries_stmt = oci_parse($conn, $entries_query);

     oci_bind_by_name($entries_stmt, ":report", $report);

     oci_execute($entries_stmt, OCI_DEFAULT);
     ?>
     <fieldset>
     <legend> Entries </legend>
     <?php
     $entry_count = 0;
     while(oci_fetch($entries_stmt))
     {
       $entry_count = $entry_count + 1;

       $curr_prn = oci_result($entries_stmt, "PRN");
       $curr_user = oci_result($entries_stmt, "HSU_USERNAME");
       $curr_species = oci_result($entries_stmt, "SPEC_NAME");
       //$curr_species = oci_result($entries_stmt, "SPEC_ABBR");
       $curr_surv_tag = oci_result($entries_stmt, "POST_SURVEY_TAG");
       $curr_exist_tag = oci_result($entries_stmt, "EXISTING_TAGS");
       $curr_photos = oci_result($entries_stmt, "PHOTOS");
       $curr_comments = oci_result($entries_stmt, "COMMENTS");
      ?>
       <label for="entries"> Entry #<?=$entry_count?> </label>
       <p name="entry_details">
          PRN : <?= $curr_prn ?> <br>
          Surveyor : <?= $curr_user ?> <br>
          Species : <?= $curr_species ?> <br>
          Existing Tags? : <?= $curr_exist_tag ?> <br>
          Post Survey Tag? : <?= $curr_surv_tag ?> <br>
          Photos? : <?= $curr_photos ?> <br>
          Comments : <?= $curr_comments ?> <br>
       </p>
     <?php
     }

     oci_free_statement($entries_stmt);
     ?>
     </fieldset>
       <input type="submit" name="report_view" value="Go Back" />
       <input type="submit" name="main_menu" value="Main Menu" />
    </fieldset>
   </div>
   </form>
   <?php


}
?>

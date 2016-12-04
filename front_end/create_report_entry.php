<?php
/*--------
get_report_id.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Rebecca on 11/25/16

Modified by:   on:


      function:  create_report_entry
      purpose: expects Oracle login and password
          returns nothing but performs the following:
          --inserts into report_entries table a new report_entry

    uses: hsu_conn_sess
-------*/

      function create_report_entry($login, $password, $PRN, $report_id, $username, $spec_abbr,
                          $post_tag, $existing_tags, $photos, $no_animals, $comment, $latitude, $longitude)
      {

          $conn = hsu_conn_sess($login, $password);

          $report_insert = "INSERT INTO REPORT_ENTRIES (PRN, HSU_USERNAME, ".
                           "REPORT_ID, SPECIES_ABBR, LATITUDE, LONGITUDE, ".
                           "POST_SURVEY_TAG, EXISTING_TAGS, PHOTOS, COMMENTS, NO_OF_ANIMALS) ".
                           "VALUES (:PRN, :username, :report_id, :spec_abbr, ".
                                    ":latitude, :longitude, :post_tag, :existing_tags, :photos, :summary_comments, :no_animals)";

          $insert_stmt = oci_parse($conn, $report_insert);

          oci_bind_by_name($insert_stmt, ":report_id", $report_id);
          oci_bind_by_name($insert_stmt, ":PRN", $PRN);
          oci_bind_by_name($insert_stmt, ":username", $username);
          oci_bind_by_name($insert_stmt, ":latitude", $latitude);
          oci_bind_by_name($insert_stmt, ":longitude", $longitude);
          oci_bind_by_name($insert_stmt, ":spec_abbr", $spec_abbr);
          oci_bind_by_name($insert_stmt, ":post_tag", $post_tag);
          oci_bind_by_name($insert_stmt, ":existing_tags", $existing_tags);
          oci_bind_by_name($insert_stmt, ":summary_comments", $comment);
          oci_bind_by_name($insert_stmt, ":photos", $photos);
          oci_bind_by_name($insert_stmt, ":no_animals", $no_animals);

          oci_execute($insert_stmt, OCI_DEFAULT);
          oci_commit($conn);

          oci_free_statement($insert_stmt);
          oci_close($conn);
          ?>
          <form action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
          <fieldset>
            <legend> Would you like to submit photos of this finding? </legend>
          <div class="submit">
            <input type="submit" name="add_photos" value="Add Photos" />
            <input type="submit" name="report_recap" value="Finish Entry" />
            <input type="submit" name="main_menu" value="Exit to Main Menu" />
          </div>

        </fieldset>
        </form>
        <?php
      }

 ?>

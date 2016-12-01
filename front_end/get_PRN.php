<?php
  /*--------

  get_PRN.php

  Guthrie Hayward (gmh234)
  Nathan Ortolan (ndo28)
  Becky Williams (rjw125)
  Abdul Shaikh (ats234)

  Created by Rebecca on 11/20/16

  Modified by:   on:

      function: get_PRN
      purpose: expects:
          -- report_id (uses this to count existing entries)
          -- PRN_date
          -- beach_abbr
          -- spec_abbr
          -- surveyor_init
          -- survey_type
          Creates a PRN for the report entry and stores it to
          SESSION array

      uses: hsu_conn_sess
  -------*/

      function get_PRN($login, $password, $report_id, $PRN_date, $beach_abbr,
                        $spec_abbr, $surveyor_init, $survey_type)
      {
            $conn = hsu_conn_sess($login, $password);

            // here  ive connected

            // this collects the number of prior report_entries for this report
            $entries_query =  'select count(report_id)
                            from report_entries
                            where report_id = :report_id';

            $entries_stmt = oci_parse($conn, $entries_query);

            oci_bind_by_name($entries_stmt,":report_id", $report_id);

            oci_execute($entries_stmt, OCI_DEFAULT);
            oci_fetch($entries_stmt);

            $prior_entries = oci_result($entries_stmt, "COUNT(REPORT_ID)");

            oci_free_statement($entries_stmt);
            oci_close($conn);


            $animal = ($prior_entries + 1);

            $PRN = "HSU_".$PRN_date."_".$beach_abbr."_".$spec_abbr.
                   "_".$animal."_".$surveyor_init."_".$survey_type;

            $_SESSION['PRN'] = $PRN;
            $_SESSION['no_animals'] = $animal;


      }

      ?>

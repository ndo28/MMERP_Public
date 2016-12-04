<?php
/*--------
get_report_id.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Rebecca on 11/25/16

Modified by:   on:


      function:  create_report_summary
      purpose: expects Oracle login and password
          returns nothing but performs the following:
          --inserts into reports table the survey_summary

    uses: hsu_conn_sess
-------*/

      function create_report_summary($login, $password, $summary, $report_id)
      {

          //echo "summary is " . $summary . ".<br>";

          $conn = hsu_conn_sess($login, $password);


          $update_call = 'update reports '.
                          'set survey_summary = :summary '.
                          'where report_id = :report_id';

          $update_stmt = oci_parse($conn, $update_call);

          // set the bind variables

          // when a bind variable is for input purposes
          //    (input TO the data tier), only NEED 3
          //    arguments


          oci_bind_by_name($update_stmt, ":summary",
                           $summary);
          oci_bind_by_name($update_stmt, ":report_id",
                           $report_id);

          // now, executing! (and committing -- changed database,
          //     and want to commit that change;)

          oci_execute($update_stmt, OCI_DEFAULT);
          oci_commit($conn);
          oci_free_statement($update_stmt);
          oci_close($conn);

          ?>
          <form class="form-inline" action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
          <div class="form-group">
          <fieldset>
            <legend> Thank you for submitting the report summary. </legend>
            <input type="submit" name="main_menu" value="Exit to Main Menu" />
        </fieldset>
        </div>
        </form>
        <?php
      }

 ?>

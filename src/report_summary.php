<?php
/*------------------------

function:  report_summary
purpose:   display to the use the report sumamry page, including:
          --  textarea for survey_summary
          --  buttons to go the following places
              --  Submit report & Exit
              --  Cancel  & return to Main menu




    Created by:  Rebecca Williams
    Created on:  11/27/16

    Modified By: Guthrie Hayward On: 12/04/16
    ----------------*/
function report_summary($login, $password, $report_id)
{

       $conn = hsu_conn_sess($login, $password);

       // Now a query to display user information
        $report_query = 'SELECT survey_summary '.
                      'FROM reports ' .
                      'where report_id = :report_id';

      $report_stmt = oci_parse($conn, $report_query);

      oci_bind_by_name($report_stmt, ":report_id", $report_id);

      oci_execute($report_stmt, OCI_DEFAULT);
      oci_fetch($report_stmt);

      $survey_summary = oci_result($report_stmt, "SURVEY_SUMMARY");

      oci_free_statement($report_stmt);
      oci_close($conn);
      ?>

          <form class="form-inline" method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
          <div class="form-group">
           <fieldset>

             <label for="end_time"> End time: </label>
             <div name="end_time">
               <input type="number" name="end_time_hrs" value="12" min="1" max="12" required="required"  width="50%"> :
               <input type="number" name="end_time_mins" value="30" min="00" max="59" required="required" width="50%" >
            </div>

            <label for="total_time"> Total time taken in hours: </label>
            <div name="total_time">
              <input type="number" name="total_time"  required="required"  width="50%">
           </div>

           <legend>Report Summary</legend>

              <h2> Would you like to add a survey summary? Include conditions and other general observations.  </h2>
                    <textarea rows="4" cols="50" name="summary" maxlength="256" > <?php echo $survey_summary; ?> </textarea>
                  <input type="submit" name="submit_report" value="Submit Report"/>
                  <input type="submit" name="main_menu" value="Cancel" formnovalidate/>
            </fieldset>
          </div>
          </form>
        <?php
        }
?>

<?php
// function:  report_recap
// purpose: expects Oracle username and password
//     returns nothing but displays to the user
//     the current report number and PRNs associated
//     with that report (via a sql query)
//     inserts a report with only a report_id and
//     includes options to return to main_menu, go on to
//     report_summary or go on to make a stranding report via
//     add_entry

//     Created by:  Guthrie Hayward and Rebecca Williams
//     Created on:  11/16/16
//     Modified By: Rebecca Williams on:  11/19/16
//     Modified by: Guthrie Hayward  on:  12/03/16
function report_recap($login, $password, $report_id)
{
        $conn = hsu_conn_sess($login, $password);
        ?>
          <form class="form_block" method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
         <fieldset>
           <legend>Report Recap</legend>
           <?php

                $report_id = strip_tags($_SESSION['report_id']);

                 $entries_query = 'SELECT PRN '.
                                   'from REPORT_ENTRIES '.
                                   'where REPORT_ID = :report_id';

                 $entries_stmt = oci_parse($conn, $entries_query);

                 oci_bind_by_name($entries_stmt, ":report_id", $report_id);

                 oci_execute($entries_stmt, OCI_DEFAULT);
            ?>
            <h2
            > This is the list of PRN's for <?= $report_id?>, if you've just begun this will be empty.</h2
            >
            <table >

            <tr ><th scope="col"> PRNs </th></tr>

            <?php
            while (oci_fetch($entries_stmt))
            {
                $curr_prn = oci_result($entries_stmt, "PRN");

                ?>
                <tr  > <td  > <?= $curr_prn?> </td>
                </tr>
                <?php
            }
            ?>
            </table>

            <?php
            oci_free_statement($entries_stmt);
            oci_close($conn);
               ?>

            </fieldset>

            <fieldset>
              <h2> Would you like to add a report entry? Would you like to add
                    report summary? </h2>

                  <input type="submit" name="add_entry" value="Add Entries"/>
                  <input type="submit" name="to_summary" value="No Findings"/>
                  <input type="submit" name="main_menu" value="Go Back"/>
                  <input type="submit" name="to_summary" value="Report Summary" />
                  
            </fieldset>
          </form>
        <?php
        }
?>

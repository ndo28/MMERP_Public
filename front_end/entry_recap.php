<?php
/*------------------------

function:  entry_recap
purpose:   this is not done!!!!!

    Created by:  Rebecca Williams
    Created on:  11/20/16
    Modified By:   On:
    ----------------*/
function entry_recap($login, $password)
{
        $conn = hsu_conn_sess($login, $password);
        ?>
        <div class="login-block">
          <form method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
         <fieldset>
           <legend>Entry Recap</legend>
           <?php

                $report_id = strip_tags($_SESSION['report_id']);

                 $entries_query = 'SELECT PRN '.
                                   'from REPORT_ENTRIES '.
                                   'where REPORT_ID = :report_id';

                 $entries_stmt = oci_parse($conn, $entries_query);



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
            oci_free_statement($query_stmt);
            oci_close($conn);
               ?>

            </fieldset>

            <fieldset>
              <h2> Would you like to add a report entry? Would you like to add
                    report summary? </h2>

              <div class="chooseAction">
                  <input type="submit" name="add_entry" value="Add Entries"/>
                  <input type="submit" name="summary" value="No Findings"/>
                  <input type="submit" name="main_menu" value="Go Back"/>
                  <input type="submit" name="summary" value="Report Summary" />
              </div>
            </fieldset>
          </form>
        </div>
        <?php
        }
?>

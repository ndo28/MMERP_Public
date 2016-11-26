<?php
/*------------------------

function:  entry_recap
purpose:   display to the use the report_entry to confirm or go back,
           expects nothing has the side affect of reporting data
           to the user for review, including:
           --PRN
           --Species
           --Latitude
           --Longitude
           The user can enter a comment about this data prior
           to submitting.
           The user can go back optionally to:
             -- get_report_entry_info or
             -- main_menu

    Created by:  Rebecca Williams
    Created on:  11/20/16

    Modified By:   On:
    ----------------*/
function entry_recap($login, $password, $PRN, $latitude, $longitude, $spec_abbr)
{
        $conn = hsu_conn_sess($login, $password);
        ?>
        <div class="entry-block">
          <form method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
         <fieldset>
           <legend>Entry Recap</legend>
           <?php

                 $species_query = 'SELECT SPEC_NAME '.
                                   'from SPECIES '.
                                   'where spec_abbr = :spec_abbr';

                 $species_stmt = oci_parse($conn, $species_query);

                 oci_bind_by_name($species_stmt, ":spec_abbr", $spec_abbr);

                 oci_execute($species_stmt, OCI_DEFAULT);
                 oci_fetch($species_stmt);

                 $spec_name = oci_result($species_stmt, "SPEC_NAME");
                 oci_free_statement($species_stmt);
                 oci_close($conn);
            ?>
            <h2
            > This is the PRN for this finding: <?= $PRN?>. <br>
               The options for this entry are as follows: </h2>
            <p>
              This animal is:  <?= $spec_name ?><br>
              This animal had existing tags?  <?= $_SESSION["existing_tags"]?><br>
              This animal has a post survey tag?  <?= $_SESSION["post_tag"]?><br>
              There are photos?  <?= $_SESSION["photos"]?><br>
              The latitude is  <?= $latitude?>. <br>
              The longitude is <?= $longitude?>.<br>
            </p>
            </fieldset>

            <fieldset>
              <h2> Would you like to add comment to a report entry? Would you like to add
                    report summary? </h2>
                    <textarea rows="4" cols="50" name = "comment">
                    </textarea>
              <div class="chooseAction">
                  <input type="submit" name="submit_entry" value="Submit Entry"/>
                  <input type="submit" name="add_entry" value="Edit Entry"/>
                  <input type="submit" name="main_menu" value="Main Menu"/>
              </div>
            </fieldset>
          </form>
        </div>
        <?php
        }
?>

<?php
/*--------
admin_menu.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Abdul on 11/13/16

Modified by: rjw  on: 11/20/16
Modified by: gmh  on: 12/04/16

    function: admin_console
    purpose: a form containing several submit buttons with the following
    choices:
        --option to go view map
        --option to go back to main menu
        --option to go view existing reports

-------*/

function admin_console($login, $password)
{
        $conn = hsu_conn_sess($login, $password);
        ?>
        <h2>Welcome to the admin console</h2>
        <div class="login-block">
          <form method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
            <fieldset>
              <div class="chooseItem">
                <input type="submit" name="main_menu" value="Go Back "/>
                <input type="submit" name="map_view" value="View Map"/>
                <input type="submit" name="report_view" value="View All Reports"/>
                <input type="submit" name="modify_users" value="Add/Edit Users"/>
              </div>
            </fieldset>
          <?php
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
          </form>
          <?php
            oci_free_statement($species_stmt);
            ?>
        </div>
        <?php

        oci_close($conn);
        }
?>

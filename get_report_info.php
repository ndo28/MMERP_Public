<?php

/*--------
get_report_info.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Abdul, Guthrie and Rebecca on 11/5/16

Modified by: rjw, ats  on: 11/13/16
Modified by: rjw  on: 11/14/16
Modified by: rjw  on: 11/20/16

    function: get_report_info
    purpose: expects an entered Oracle login and
        password and mmerp username performs the following:
        --queries the database for a list of beaches
        --displays beach query to user as a dropdown
        --queries the database for a list of added users (excluding user who
                  logged in)
        --displays added users query to user as a dropdown
        --stores the selected beach_abbr to the POST array on submit
        --stores the selected HSU_USERNAME to the POST array on submit
        --optional go back to main menu on submit

    uses: hsu_conn_sess
-------*/

      function get_report_info($login, $username, $password)
      {
          $conn = hsu_conn_sess($login, $password);

          // here  ive connected
          ?>
          <form class="new_report" action="<?= htmlentities($_SERVER['PHP_SELF'],
                                 ENT_QUOTES) ?>" method="post" id="new_report">
          <fieldset>
            <legend>New Report</legend>
            <?php
                  $beach_query = 'select BEACH_NAME, BEACH_ABBR '.
                                    'from BEACHES';

                  $beach_stmt = oci_parse($conn, $beach_query);

                  oci_execute($beach_stmt, OCI_DEFAULT);
             ?>

             <label for="beach_choice"> Beach Information:  </label>
             <select name="beach_choice" id="beach_choice">
               <?php
                    while (oci_fetch($beach_stmt))
                    {
                        $curr_beach_abbr = oci_result($beach_stmt, "BEACH_ABBR");
                        $curr_beach_name = oci_result($beach_stmt, "BEACH_NAME");
                        ?>
                        <option value = "<?= $curr_beach_abbr ?>">
                          <?= $curr_beach_name ?> </option>

                      <?php

                    }
                oci_free_statement($beach_stmt);
                ?>
              </select>
              <?php


                $user_query = 'select HSU_USERNAME
                               from USERS
                               where HSU_USERNAME != :username';

                $user_stmt = oci_parse($conn, $user_query);

                oci_bind_by_name($user_stmt,":username",$username);

                oci_execute($user_stmt, OCI_DEFAULT);
           ?>

           <label for="user_choice"> Additional Surveyor:  </label>
           <select name="user_choice" id="user_choice">
             <?php
                  while (oci_fetch($user_stmt))
                  {
                      $curr_user_name = oci_result($user_stmt, "HSU_USERNAME");
                      ?>
                      <option value = "<?= $curr_user_name ?>">
                        <?= $curr_user_name ?> </option>

                    <?php

                  }
              oci_free_statement($user_stmt);

                oci_close($conn);
                ?>
             </select><br/>

             <div class="submit">
             <input class="button" type="submit" name="main_menu" value="Go Back">
             <input class="button" type="submit" name="new_reports_update" value="Continue"/>
                </div>
          </fieldset>
        </form>
          <?php
      }

 ?>

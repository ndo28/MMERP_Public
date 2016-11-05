<?php

      // function:  create_beach_dropdown
      // purpose: expects Oracle username and password
      //     returns nothing but builds a dropdorn of current
      //     beach info

      function make_new_report($username, $password)
      {
          $conn = hsu_conn_sess($username, $password)

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


                $user_query = 'select HSU_USERNAME, USER_INITIALS
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
                      $curr_user_initials = oci_result($user_stmt, "USER_INITIALS");
                      $curr_user_name = oci_result($user_stmt, "HSU_USERNAME");
                      ?>
                      <option value = "<?= $curr_user_initials ?>">
                        <?= $curr_user_name ?> </option>

                    <?php

                  }
              oci_free_statement($user_stmt);

                oci_close($conn);
                ?>
             </select><br/>

             <div class="submit">
             <input class="button" type="submit" name="finish_report" value="No Findings">
             <input class="button" type="submit" name="new_entry" value="Continue"/>
                </div>
          </fieldset>
        </form>
          <?php
      }

 ?>

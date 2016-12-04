<?php
/*------------------------

function:  select_create_users
purpose:   expects username and password, returns nothing and
          has the side affect of displaying to the use the list of existing users
          and a text input to add a new users hsu_username, sends the HSU_USERNAME
          to the post array


    Created by:  Rebecca Williams
    Created on:  12/03/16

    Modified By:   On:
    ----------------*/
function select_create_users($login, $password)
{
        $conn = hsu_conn_sess($login, $password);
        ?>
        <div class="entry-block">
          <form method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
         <fieldset>
           <legend>Add or Edit Existing User</legend>
           <p>
              Add a new HSU username or select a user from the dropdown</p><br>
              New HSU Username:
                <input type="text" name="new_username" id = 'new_username'><br>
                Existing Users:
           <?php

                 $users_query = "SELECT USER_FNAME, USER_LNAME, HSU_USERNAME
                                   from USERS
                                   where HSU_USERNAME != 'adm000'
                                   order by USER_LNAME";

                 $users_stmt = oci_parse($conn, $users_query);

                 //oci_bind_by_name($species_stmt, ":spec_abbr", $spec_abbr);

                 oci_execute($users_stmt, OCI_DEFAULT);
                 ?>
                 <select class="form_block" name="existing_username">
                 <?php
                 while (oci_fetch($users_stmt))
                 {
                   $curr_lname = oci_result($users_stmt, "USER_LNAME");
                   $curr_fname = oci_result($users_stmt, "USER_FNAME");
                   $curr_username = oci_result($users_stmt, "HSU_USERNAME");
                   ?>
                   <option value = "<?= $curr_username ?>">
                     <?= $curr_lname ?> ,  <?= $curr_fname  ?> -- <?= $curr_username ?>
                   </option>

                   <?php
                 }
                 ?>
                 </select>
                 <?php

                 oci_free_statement($users_stmt);
                 oci_close($conn);
            ?>
              <div class="chooseAction">
                <input type="submit" name="admin" value="Go Back"/>
                  <input type="submit" name="add_users" value="Add New User"/>
                  <input type="submit" name="edit_users" value="Edit Existing User"/>
              </div>
            </fieldset>
          </form>
        </div>
        <?php
        }
?>

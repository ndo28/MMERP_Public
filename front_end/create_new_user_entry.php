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
function create_new_user_entry($login, $password)
{
        $conn = hsu_conn_sess($login, $password);
        ?>
        <div class="entry-block">
          <form method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
         <fieldset>
           <legend>Enter the HSU username for the new user</legend>

                New User:
                <input type="text" name="new_username" id = "new_username"><br>

              <div class="chooseAction">
                <input type="submit" name="admin" value="Go Back"/>
                  <input type="submit" name="new_user" value="Continue"/>
              </div>
            </fieldset>
          </form>
        </div>
        <?php
        }
?>

<?php
/*--------
admin_menu.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Abdul on 11/13/16

Modified by: rjw  on: 11/20/16

    function: admin_console
    purpose: a form containing several submit buttons with the following
    choices:
        --option to go view map
        --option to go back to main menu

-------*/

function admin_console()
{

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
              </div>
            </fieldset>
          </form>
        </div>
        <?php
        }
?>

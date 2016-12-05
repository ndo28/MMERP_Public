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
        <form class="form-inline" method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'],
                                       ENT_QUOTES) ?>">
        <div class="form-group">
            <fieldset>
              <div class="chooseItem">
                <input type="submit" name="main_menu" value="Go Back "/>
                <input type="submit" name="map_view" value="View Map"/>
                <input type="submit" name="report_view" value="View All Reports"/>
                <input type="submit" name="create_new_user" value="Add New User"/>
                <input type="submit" name="modify_user" value="Edit Existing User"/>
              </div>
            </fieldset>
        <?php
        }
  ?>

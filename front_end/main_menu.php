<?php
/*--------
main_menu.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Abdul, Guthrie and Rebecca on 11/5/16

Modified by: rjw, ats  on: 11/13/16
Modified by: rjw  on: 11/20/16
Modified by: gmh on 12/3/16

    function: main_menu
    purpose: a form containing four submit buttons with the following
    choices:
        --option to go to Admin console
        --option to go to list existing reports for user
        --option to go to create a new report
        --option to change password

-------*/


function main_menu($is_admin, $is_surveyor)
{
        ?>
          <form class="form_block" method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
            <fieldset>
              <h1> Welcome to MMERP! </h1>
              <h2> Would you like to create a new report, or continue an exisiting report? </h2>
              <?php
                if(($is_surveyor == 'Y') and ($is_admin == 'N'))
                {
                  ?>
                  <input type="submit" name="new" value="New Report"/>
                  <input type="submit" name="continue" value="Continue"/>
                <?php
              }
                elseif(($is_surveyor == 'N') and ($is_admin == 'Y'))
                {
                  ?>
                  <input type="submit" name="admin" value="Admin Console"/>
                <?php
              }
              elseif(($is_surveyor == 'Y') and ($is_admin == 'Y'))
                {
                  ?>
                  <input type="submit" name="new" value="New Report"/>
                  <input type="submit" name="continue" value="Continue"/>
                  <input type="submit" name="admin" value="Admin Console"/>
                <?php
              }
              ?>
            </fieldset>
          </form>
        <?php
        }
?>

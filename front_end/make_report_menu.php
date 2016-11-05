<?php
  /*---
  Guthrie Hayward
  CS 328 - Homework 12

  File: custom-session-menu.php
  Purpose: a form containing two radio buttons and a submit,
  for the user to choose either items or bands.
  Last Edited: 5/5/16

  url: http://nrs-projects.humboldt.edu/~gmh234/hw12/custom-session-menu.php

	---*/

function make_report_menu()
{

        ?>
        <div class="login-block">
          <form method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
            <fieldset>
              <h2> Would you like to make a new report, or continue an existing report? </h2>

              <div class="chooseItem">
                  <input type="submit" name="new" value="New Report"/>
                  <input type="submit" name="continue" value="Continue "/>
              </div>
            </fieldset>
          </form>
        </div>
        <?php
        }
?>

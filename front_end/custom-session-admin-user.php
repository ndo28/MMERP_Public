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

function custom_session_admin_user()
{

        ?>
        <div class="login-block">
          <form method="post"
                action="<?= htmlentities($_SERVER['PHP_SELF'],
                                         ENT_QUOTES) ?>">
            <fieldset>
              <h1> Welcome to MMERP! </h1>
              <h2> Are you an admin or a user? </h2>

              <div class="chooseItem">
                  <input type="submit" name="user" value="User"/>
                  <input type="submit" name="admin" value="Admin"/>
              </div>
            </fieldset>
          </form>
        </div>
        <?php
        }
?>

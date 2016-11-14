<?php

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
                <input type="submit" name="back" value="back "/>
                <input type="submit" name="map_view" value="View Map"/>
              </div>
            </fieldset>
          </form>
        </div>
        <?php
        }
?>

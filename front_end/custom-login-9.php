<?php
    /*---
      Guthrie Hayward
      CS 328 - Homework 9

      File: Custom-login-9.php
      Purpose: a login function for custom-session2.php
      Last Edited: 4/17/16

      url: http://nrs-projects.humboldt.edu/~gmh234/hw9/custom-login-9.php

    ---*/

    function custom_login_9()
    {
        ?>
        <form method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'],
                                       ENT_QUOTES) ?>">
        <?php
        require("name-pwd-fieldset.html");
        ?>
        </form>

        <?php
    }
?>

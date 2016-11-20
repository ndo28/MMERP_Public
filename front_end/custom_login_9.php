<?php
/*--------
custom_login_9.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Guthrie and Rebecca on 11/5/16

Modified by: rjw  on: 11/20/16

  function:  custom_login_9
  purpose: expects nothing, returns nothing and makes a form
        for username and password

    uses: name-pwd-fieldset.html
-------*/

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

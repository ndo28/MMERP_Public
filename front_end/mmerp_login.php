<?php
/*--------
mmerp_login.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Guthrie and Rebecca on 11/5/16

Modified by: rjw  on: 11/20/16
Modified by: gmh  on: 12/03/16

  function:  db_login
  purpose: expects nothing, returns nothing and makes a form
        for username and password
-------*/

    function db_login()
    {
        ?>
        <form class="form-inline" method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'],
                                       ENT_QUOTES) ?>">
        <div class="form-group">

          <p> Chrome is not supported, please use Firefox. </p>

         <fieldset>
             <legend> Enter MMERP username/password:
                 </legend>
              <div class="login">
             <label for="name_entry"> Username: </label>
             <input type="text" class="form-control" name="username" id="name_entry"
                    required="required" />

             <label for="pwd_entry"> Password: </label>
             <input type="password" class="form-control" name="password" id="pwd_entry"
                    required="required" />
             </div>
                 <input type="submit" class="btn btn-default" value="Log In" />
         </fieldset>
        </div>
        </form>

        <?php
    }
?>

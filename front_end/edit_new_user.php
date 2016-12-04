<?php
  /*--------
  edit_new_user.php

  Guthrie Hayward (gmh234)
  Nathan Ortolan (ndo28)
  Becky Williams (rjw125)
  Abdul Shaikh (ats234)

  Created by Rebecca on 12/03/16

  Modified by:   on:


      function: edit_new_user
      purpose:

      uses: hsu_conn_sess
  -------*/

function edit_new_user($login, $password, $new_username)
{

    $conn = hsu_conn_sess($login, $password);

    ?>
    <form action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
    <fieldset>
      <legend> All fields are required.</legend>

    <label for="username">User Name: <?php echo $new_username; ?></label><br>
    Last Name:
      <input type="text" name="edit_lname" id = "lname" required="required" ><br>
    First Name:
      <input type="text" name="edit_fname" id = "fname" required="required" ><br>
    Password:
      <input type="text" name="edit_new_password" id = "password" required="required" ><br>
    Email:
      <input type="text" name="edit_email" id = "email" required="required" ><br>


    <label for="post_tag">Give Admin access? </label>
    <input type="radio" name="edit_admin" value="N" required="required" /> No
    <input type="radio" name="edit_admin" value="Y"/> Yes<br>

    <label for="photos">Give Surveyor access? </label>
    <input type="radio" name="edit_surveyor" value="N" required="required" /> No
    <input type="radio" name="edit_surveyor" value="Y"/> Yes<br>

    <div class="submit">
      <input type="submit" name="create_new_user" value="Go Back" />
      <input type="submit" name="edit_user_recap" value="Continue" />
      <input type="submit" name="admin" value="Return to Admin Console" />
    </div>

  </fieldset>
  </form>
    <?php
  }
    ?>

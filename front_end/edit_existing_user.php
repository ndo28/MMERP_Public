<?php
  /*--------
  get_report_entry_info.php

  Guthrie Hayward (gmh234)
  Nathan Ortolan (ndo28)
  Becky Williams (rjw125)
  Abdul Shaikh (ats234)

  Created by Rebecca on 11/20/16

  Modified by:  ats on:  11/20/16


      function: edit_existing_user
      purpose:

      uses: hsu_conn_sess
  -------*/

function edit_existing_user($login, $password, $existing_username)
{

    $conn = hsu_conn_sess($login, $password);

    ?>
    <form action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
    <fieldset>
      <legend> Modify the User as required. Surveyor to "No" to stop access</legend>
      <?PHP
     // Now a query to display user information
      $user_query = 'SELECT * '.
                    'FROM users ' .
                    'where HSU_USERNAME = :username';

    $user_stmt = oci_parse($conn, $user_query);

    oci_bind_by_name($user_stmt, ":username", $existing_username);

    oci_execute($user_stmt, OCI_DEFAULT);
    oci_fetch($user_stmt);

    $initials = oci_result($user_stmt, "USER_INITIALS");
    $lname = oci_result($user_stmt, "USER_LNAME");
    $fname = oci_result($user_stmt, "USER_FNAME");
    $email = oci_result($user_stmt, "USER_EMAIL");
    $password = oci_result($user_stmt, "PASSWORD");
    $admin = oci_result($user_stmt, "IS_ADMIN");
    $surveyor = oci_result($user_stmt, "IS_SURVEYOR");

    oci_free_statement($user_stmt);
    ?>
    <label for="username">User Name:</label><br>
    Last Name:
      <input type="text" name="lname" id = "lname" value="<?php echo $lname; ?>"><br>
    First Name:
      <input type="text" name="fname" id = "fname" value="<?php echo $fname; ?>"><br>
    Password:
      <input type="text" name="new_password" id = "password" value="<?php echo $password; ?>"><br>
    Email:
      <input type="text" name="email" id = "email" value="<?php echo $email; ?>"><br>



    <label for="post_tag">Give Admin access? </label>
    <input type="radio" name="is_admin" value="N"<?php if($admin == "N") { echo " checked"; } ?>/> No
    <input type="radio" name="is_admin" value="Y"<?php if($admin == "Y") { echo " checked"; } ?>/> Yes<br>

    <label for="photos">Surveyor? </label>
    <input type="radio" name="photos" value="y" checked> Yes
    <input type="radio" name="photos" value="n" > No<br>

    <?php




    oci_close($conn);
    ?>

    <div class="submit">
      <input type="submit" name="modify_user" value="Go Back" />
      <input type="submit" name="edit_user_recap" value="Continue" />
      <input type="submit" name="admin" value="Return to Admin Console" />
    </div>

  </fieldset>
  </form>
    <?php
  }
    ?>

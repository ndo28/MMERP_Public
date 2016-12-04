<?php
  /*--------

  edit_existing_user_recap.php

    Guthrie Hayward (gmh234)
    Nathan Ortolan (ndo28)
    Becky Williams (rjw125)
    Abdul Shaikh (ats234)

    Created by Rebecca on 12/03/16


    modified by:   on:

      function: edit_existing_user_recap
      purpose: expects the following:
          -  Oracle login,
          -  Oracle password,
          -  existing_username, ()
          -  edit_new_password,
          -  edit_lname
          -  edit_fname,
          -  edit_email,
          -  edit_admin,
          -  edit_surveyor
          returns nothing, but has the side effect of writing to the database the
          input from the edit_existing_user module and displays them to user for confirmation.
          go back will take them back to edit the user fields, confirm will take them back to
          admin console.

      uses: hsu_conn_sess
  -------*/
?>


<?php
function edit_existing_user_recap($login, $password, $existing_username,
            $edit_new_password, $edit_lname, $edit_fname, $edit_email,
            $edit_admin, $edit_surveyor, $edit_initials)
{
    // try to connect to Oracle student database

    $conn = hsu_conn_sess($login, $password);

    $update_call = 'UPDATE USERS '.
                  'SET USER_INITIALS = :edit_initials, '.
                  'USER_LNAME = :edit_lname, '.
                  'USER_FNAME = :edit_fname, '.
                  'USER_EMAIL = :edit_email, '.
                  'PASSWORD = :password, '.
                  'is_admin = :edit_admin, '.
                  'is_surveyor = :edit_surveyor '.
                  'where HSU_USERNAME = :username';

    $update_stmt = oci_parse($conn, $update_call);

    oci_bind_by_name($update_stmt, ":edit_lname", $edit_lname);
    oci_bind_by_name($update_stmt, ":edit_fname", $edit_fname);
    oci_bind_by_name($update_stmt, ":edit_email", $edit_email);
    oci_bind_by_name($update_stmt, ":edit_surveyor", $edit_surveyor);
    oci_bind_by_name($update_stmt, ":edit_admin", $edit_admin);
    oci_bind_by_name($update_stmt, ":password", $edit_new_password);
    oci_bind_by_name($update_stmt, ":edit_initials", $edit_initials);
    oci_bind_by_name($update_stmt, ":username", $existing_username);

    oci_execute($update_stmt, OCI_DEFAULT);
    oci_commit($conn);
    oci_free_statement($update_stmt);

    ?>

    <form action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
     <fieldset>
      <legend> User Details </legend>
      <p name="report_details">
          HSU USERNAME : <?PHP echo $existing_username; ?> <br>
          Last Name, First Name : <?PHP echo $edit_lname; ?>, <?PHP echo $edit_fname; ?> <br>
          User Initials : <?PHP echo $edit_initials; ?> <br>
          Email : <?PHP echo $edit_email; ?> <br>
          Password: <?PHP echo $edit_new_password; ?> <br>
          Is Admin?: <?PHP echo $edit_admin; ?> <br>
          Is Surveyor?: <?PHP echo $edit_surveyor; ?> <br>
      </p>
     </fieldset>

     <div class="submit">
       <input type="submit" name="redo_edit_user" value="Go Back" />
       <input type="submit" name="admin" value="Confirm Changes" />
     </div>
    </fieldset>
   </form>
   <?php


}
?>

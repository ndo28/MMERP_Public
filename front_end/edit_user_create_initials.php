<?php

/*--------
edit_user_create_initials.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Rebecca on 12/04/16

Modified by: rjw  on:

    function: edit_user_create_initials
    purpose: expects the new_user last name and new_user first name and builds
             the initials for the db,  will store this to a session variable
    uses: hsu_conn_sess
-------*/

      function edit_user_create_initials($edit_lname, $edit_fname)
      {

          $first_init = str_split($edit_fname, 1);
          $last_init = str_split($edit_lname, 1);

          $initials = $first_init[0].$last_init[0];

          $_SESSION['edit_initials'] = $initials;

      }

 ?>

<?php
// function:  validate_user
// purpose: expects Oracle username and password and
//     the password of a user that is stored in the
//     database, as a field,  will query the database
//     to verify the password is correct, and then, if
//     it is correct, it will query the database for
//     the is_admin and is_surveyor fields and store as
//     SESSION variables.
//

//     Created by:  Rebecca Williams
//     Created on:  11/19/16
//     Modified By:
//     On:

//      uses: hsu_conn_sess

function validate_user($login, $username, $password, $user_password)
{
        $conn = hsu_conn_sess($login, $password);

         $password_query = 'SELECT PASSWORD '.
                           'from USERS '.
                           'where HSU_USERNAME = :username';

         $password_stmt = oci_parse($conn, $password_query);

         oci_bind_by_name($password_stmt, ":username", $username);

         oci_execute($password_stmt, OCI_DEFAULT);

         oci_fetch($password_stmt);

         $db_password = oci_result($password_stmt, "PASSWORD");
         //echo "db_password is " . $db_password . ".<br>";
         //echo "user_password is " . $user_password . ".<br>";


         oci_free_statement($password_stmt);



         if ($user_password  == $db_password)  // if valid check for is_admin and is_surveyor
         {
           $user_type_query = 'SELECT IS_ADMIN, IS_SURVEYOR '.
                             'from USERS '.
                             'where HSU_USERNAME = :username';

           $user_type_stmt = oci_parse($conn, $user_type_query);

           oci_bind_by_name($user_type_stmt, ":username", $username);

           oci_execute($user_type_stmt, OCI_DEFAULT);

           oci_fetch($user_type_stmt);

           $is_admin = oci_result($user_type_stmt, "IS_ADMIN");
           $is_surveyor = oci_result($user_type_stmt, "IS_SURVEYOR");
           //echo "is_admin is " . $is_admin . ".<br>";
           //echo "is_surveyor is " . $is_surveyor . ".<br>";
           $_SESSION['is_admin'] = $is_admin;
           $_SESSION['is_surveyor'] = $is_surveyor;
           //echo "session->is_admin is " . $_SESSION["is_admin"] . ".<br>";
           //echo "session->is_surveyor is " . $_SESSION["is_surveyor"] . ".<br>";

           oci_free_statement($user_type_stmt);
         }
        oci_close($conn);

        }
?>

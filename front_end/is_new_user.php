<?php
// function:  is_new_user
// purpose: expects Oracle username and password and
//     a HSU Username, will query the database
//     to verify the user does not already exist
//

//     Created by:  Rebecca Williams
//     Created on:  12/03/16
//     Modified By:
//     On:

//      uses: hsu_conn_sess

function is_new_user($login, $password, $new_username)
{
        $conn = hsu_conn_sess($login, $password);

         $user_query = 'select count (*)
                        FROM USERS
                        WHERE hsu_USERNAME = :new_username' ;

         $user_stmt = oci_parse($conn, $user_query);

         oci_bind_by_name($user_stmt, ":new_username", $new_username);

         oci_execute($user_stmt, OCI_DEFAULT);

         oci_fetch($user_stmt);

         $user_count = oci_result($user_stmt, "COUNT(*)");
         //echo "user_password is " . $user_password . ".<br>";


         oci_free_statement($user_stmt);



         if ($user_count  == 0 )  // if 0 -- user not in db
         {

           $user_insert = "INSERT INTO USERS (HSU_USERNAME, USER_INITIALS,
                              USER_LNAME, USER_FNAME, USER_EMAIL,
                              PASSWORD, IS_ADMIN, IS_SURVEYOR)
                             VALUES (:new_username, 'xx', 'xx', 'xx', 'xx', 'xx',
                                      'N','N') ";

           $insert_stmt = oci_parse($conn, $user_insert);

           oci_bind_by_name($insert_stmt, ":new_username", $new_username);
           oci_execute($insert_stmt, OCI_DEFAULT);
           oci_commit($conn);
           oci_free_statement($insert_stmt);


         }

         $_SESSION['existing_username'] = $new_username;


        oci_close($conn);

        }
?>

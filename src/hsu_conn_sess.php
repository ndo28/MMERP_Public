<?php

    /*-----
        function: hsu_conn_sess: string string -> connection
        purpose: expects an Oracle username and password,
            and has the side-effect of trying to connect to
            HSU's Oracle student database with the given
            username and password;
            returns the resulting connection object if
            successful, and returns false otherwise
            (doesn't it actually exit rather catastrophically
            in unsuccessful-connection case?!
            AND destroys the current session for good measure!)

        uses: 328footer.txt
    -----*/

    function hsu_conn_sess($usr, $pwd)
    {
        // set up db connection string

        $db_conn_str =
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

        // let's try to log on using this string!

        $connctn = oci_connect($usr, $pwd, $db_conn_str);

        // CAN I complain and exit from HERE if fails?

        if (! $connctn)
        {
        ?>
            <p> Could not log into MMERP, sorry. </p>

            <?php
            session_destroy();
            require_once("328footer.txt");
            exit;
        }

        return $connctn;
    }
?>

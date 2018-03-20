<?php

/*--------
fix_date.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Rebecca on 11/20/16

Modified by: rjw  on:

    function: fix_date
    purpose: expects a date in the form of a string
             which comes in as DD-MON-YY,
             will split the string into an array
             then reorder the date for the PRN
             which needs to be DDMONYYYY

    uses: hsu_conn_sess
-------*/

      function fix_date($report_date)
      {

          $day = str_split($report_date, 2);
          $month = str_split($report_date, 3);
          $year = str_split($report_date, 7);

          $PRN_date = $day[0].$month[1]."20".$year[1];

          $_SESSION['PRN_date'] = $PRN_date;

      }

 ?>

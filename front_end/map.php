<script>
  latitudes = [];
  longitudes = [];
  dates = [];
  prns = [];
</script>
<?php

/*--------
map.php

Guthrie Hayward (gmh234)
Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)

Created by Abdul on 11/16/16

Modified by: rjw  on: 11/20/16

    function: create_map
    purpose: expects an entered Oracle login and
        password and retrives from the database the
        list of current LATITUDE and LONGITUDE, PRN and report_date
        from a query of REPORTS joined with REPORT_ENTRIES tables
        --Stores the informaion in arrays.
        --Builds a map with pins with information about each location

    uses: hsu_conn_sess
-------*/

function create_map($login, $password)
{
  $conn = hsu_conn_sess($login, $password);

  $location_query = 'SELECT LATITUDE, LONGITUDE, PRN, REPORT_DATE '.
                    'FROM REPORT_ENTRIES, REPORTS '.
                    'WHERE REPORT_ENTRIES.REPORT_ID = REPORTS.REPORT_ID';

  $query_stmt = oci_parse($conn, $location_query);
  oci_execute($query_stmt, OCI_DEFAULT);

  while (oci_fetch($query_stmt))
  {
    $lat= oci_result($query_stmt, "LATITUDE");
    $long = oci_result($query_stmt, "LONGITUDE");
    $prn= oci_result($query_stmt, "PRN");
    $report_date = oci_result($query_stmt, "REPORT_DATE");
    ?>
      <script>
        latitudes.push(<?= $lat ?>);
        longitudes.push(<?= $long ?>);
        prns.push('<?= $prn ?>');
        dates.push('<?= $report_date ?>');
      </script>
    <?PHP
  }
  ?>


    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      html,body,.container-fluid{
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <form class="form-inline"method="post"
    action="<?= htmlentities($_SERVER['PHP_SELF'],
    ENT_QUOTES) ?>">
    <div class="form-group">
    <fieldset>
    <input type="submit" name="admin" value="Back"/>
    </fieldset>
    </div>
    </form>
    <div id="map" ></div>
    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: {lat: 40.877660, lng: -124.077375}
        });

        var infowindow = new google.maps.InfoWindow();

        for (i = 0; i < latitudes.length; i++) {

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(latitudes[i], longitudes[i]),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent('<b>Date: </b>' + dates[i] + '<br>' + '<b>PRN: </b>' + prns[i]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAauA3pry1_VFzT92pYd7WZBnO3uJHZlBk&callback=initMap"
    async defer></script>
        <?php
        }
?>

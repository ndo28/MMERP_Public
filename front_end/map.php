<script>
  latitudes = [];
  longitudes = [];
  dates = [];
  prns = [];
</script>
<?php

function create_map($login, $username, $password)
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
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
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

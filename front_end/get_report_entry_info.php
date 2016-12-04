<?php
  /*--------
  get_report_entry_info.php

  Guthrie Hayward (gmh234)
  Nathan Ortolan (ndo28)
  Becky Williams (rjw125)
  Abdul Shaikh (ats234)

  Created by Rebecca on 11/20/16

  Modified by:  ats on:  11/20/16


      function: get_report_entry_info
      purpose:

      uses: hsu_conn_sess
  -------*/

function get_report_entry_info($login, $password, $first_init, $second_init)
{

    $conn = hsu_conn_sess($login, $password);

    ?>
    <form class="form-inline" action="<?= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES) ?>" method="post">
    <div class="form-group">
    <fieldset>
      <legend> Select values to report </legend>
      <?PHP
     // Now a query to display species information
      $species_query = 'SELECT SPEC_ABBR, SPEC_NAME '.
                    'FROM SPECIES';

    $species_stmt = oci_parse($conn, $species_query);


    oci_execute($species_stmt, OCI_DEFAULT);

    ?>
    <label for="species">Select Species found </label>
    <select name = "spec_abbr" required>
      <?php
        while (oci_fetch($species_stmt))
        {
          $curr_species_abbr = oci_result($species_stmt, "SPEC_ABBR");
          $curr_species_name = oci_result($species_stmt, "SPEC_NAME");
          ?>
          <option value = "<?= $curr_species_abbr ?>">
             <?= $curr_species_name ?>
          </option>

          <?php
        }

    oci_free_statement($species_stmt);
    ?>
    </select><br>
    <label for="coordinates">Coordinates:</label><br>
    <input type="checkbox" onclick="getLocation()" value="Use Current Location" />Use Current Location <br>
    Latitude:
      <input type="text" name="latitude" id = "latitude" required><br>
    Longitude:
      <input type="text" name="longitude" id="longitude" required><br>



    <label for="post_tag">Post Survey Tag? </label>
    <input type="radio" name="post_tag" value="y" checked> Yes
    <input type="radio" name="post_tag" value="n" > No<br>

    <label for="photos">Photos? </label>
    <input type="radio" name="photos" value="y" checked> Yes
    <input type="radio" name="photos" value="n" > No<br>

    <label for="existing_tags">Existing Tags? </label>
    <input type="radio" name="existing_tags" value="y" > Yes
    <input type="radio" name="existing_tags" value="n" checked> No<br>

    <label for="survey_type">Systematic or Opportunistic Observations? </label>
    <input type="radio" name="survey_type" value="SYS" checked> Systematic
    <input type="radio" name="survey_type" value="OPP" > Opportunistic<br>

    <?php

    if($second_init != 'NONE')
    {
      ?>
      <label for="surveyor_init"> <strong>Which Surveyor initials for <br>
        Personal Reference Number (PRN)</strong></label>
        <label for="first"><input type="radio" name="surveyor_init" value = "<?= $first_init ?>" checked>
          <?php echo $first_init ?> </label>
          <label for="second"><input type="radio" name="surveyor_init" value = "<?= $second_init ?>">
            <?php echo $second_init ?> </label>
    <?PHP
    }
    oci_close($conn);
    ?>

      <input type="submit" name="report_recap" value="Go Back" />
      <input type="submit" name="entry_recap" value="Continue" />
      <input type="submit" name="main_menu" value="Exit to Main Menu" />

  </fieldset>
  </div>
  </form>
  <script>
    var lat = document.getElementById("latitude");
    var long = document.getElementById("longitude");
    function getLocation() {
          if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showPosition);
          } else {
              alert("Geolocation is not supported by this browser.");
          }
      }
      function showPosition(position) {
        lat.value = position.coords.latitude.toFixed(5);
        long.value = position.coords.longitude.toFixed(5);
      }
    </script>

    <?php
  }
    ?>

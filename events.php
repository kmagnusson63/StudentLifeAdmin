<?php
	/*

  	Events display

  	Displays events table and google map

	*/
?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDW4UTz60McvioMshwB3vlk6QwVJiLAh7Q&sensor=false"></script>
	<script type="text/javascript">
    /*
        Initializes mapss
    */ 
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(49.8988502054220600, -97.1394932270050000),
          zoom: 8
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);

       
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>

    <div id="map_wrapper">
      <div id="map_canvas"></div>
      <div id="events_table">


        <?php
        	display_table($db,"events");
        ?>
      </div>

 
	</div>
  

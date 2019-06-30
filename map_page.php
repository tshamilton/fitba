<?php
function mCol ($x) {
	switch($x) {
		case 'a': return "3366FF"; break;
		case 'b': return "0000FF"; break;
		case 'c': return "990044"; break;
		case 'd': return "CC0000"; break;
		case 'e': return "00CC00"; break;
		case 'f': return "77AADD"; break;
		case 'g': return "009900"; break;
		case 'h': return "00AAFF"; break;
		case 'i': return "FF9F9F"; break;
		case 'j': return "AA3388"; break;
		case 'k': return "000000"; break;
		case 'l': return "8866EE"; break;
		case 'm': return "FF00FF"; break;
		case 'n': return "000099"; break;
		case 'o': return "FF9900"; break;
		case 'p': return "660099"; break;
		case 'q': return "880000"; break;
		case 'r': return "FF0000"; break;
		case 's': return "AAAAAA"; break;
		case 't': return "D9AB4B"; break;
		case 'u': return "FFCC00"; break;
		case 'v': return "AA5533"; break;
		case 'w': return "FFFFFF"; break;
		case 'x': return "660033"; break;
		case 'y': return "FFF00C"; break;
		case 'z': return "00FF00"; break;
	}
}

include 'readData.php';
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<style>
			/* Always set the map height explicitly to define the size of the div
			 * element that contains the map. */
			#map {
				height: 95%;
			}
			/* Optional: Makes the sample page fill the window. */
			html, body {
				height: 100%;
				margin: 0;
				padding: 0;
			}
		</style>
	<title>Map of <?php print $_GET['n']; ?></title>
	</head>
	<body>
		<div id="map"></div>
		<script>
			function initMap() {
				var map = new google.maps.Map(document.getElementById('map'), {
					center: new google.maps.LatLng(<?php print $_GET['lat'].",".$_GET['lng']; ?>),
					zoom: <?php print $_GET['z']; ?>
				});
<?php 
	foreach ($MAR[$_GET['t']] as $mk) {
		if (preg_match('/\'/', $mk)) {
			$mk = preg_replace('/\'/', '&quot;', $mk);
		}
		$M = explode("~", $mk);
		$L = explode(",", $M[2]);
		$lat = $L[0];
		$long = $L[1];

		print "\t\t\tvar marker1 = new google.maps.Marker({ position: {lat: ".$lat.", lng: ".$long."}, title: '".$M[0].", ".$M[3]."', icon: 'http://www.googlemapsmarkers.com/v1/".$M[1][0]."/".mCol($M[1][2])."/".mCol($M[1][1])."/".mCol($M[1][3])."/', map: map });\n";
	}
?>
			}
	</script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7hP3y2nf3CfHP9HSKPs9YlfDvCBOU3MY&callback=initMap"></script>
	</body>
</html>
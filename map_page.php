<?php
include 'utility.php';
session_start();
$Team = $_SESSION['T'];
$MAR = Array();

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

//include 'readData.php';
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
	<title>Map of League Teams</title>
	</head>
	<body>
<?php
	if (strlen($_GET['t']) == 3) {
		print "Filter for whole country<br/>\n";
		foreach ($Team as $tm) {
			if ($tm['Tri'] == $_GET['t']) {
				if (isset($tm['Loc'])) {
					$start	= "\t\t\tvar marker1 = new google.maps.Marker({";
					$pos	= "position: {lat: ".$tm['Lat'].", lng: ".$tm['Long']."},";
					$title	= "title: '".$tm['Name'].", ".$tm['Loc']."',";
					$pincol	= "icon: 'http://www.googlemapsmarkers.com/v1/".$tm['Pin'][0]."/".mCol($tm['Pin'][2])."/".mCol($tm['Pin'][1])."/".mCol($tm['Pin'][3])."/', map: map });\n";
					array_push($MAR, $start.$pos.$title.$pincol);
				}
			}
		}
	}
	else {
		if ($_GET['t'][0] == 't') {
			$tr = substr($_GET['t'], 1);
			print "Does ".$tr.$_GET['n'].".lad exist?<br/>\n";
			if (is_readable("./news/ladder/".$tr.$_GET['n'].".lad")) {
				print "<B>Yes</B><br/>\n";
				$ladder	= file("./news/ladder/".$tr.$_GET['n'].".lad", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				foreach($ladder as $line) {
					$tm = explode('|', $line);
					$tm = $tm[0];
					if (isset($Team[$tm]['Loc'])) {
						$start	= "\t\t\tvar marker1 = new google.maps.Marker({";
						$pos	= "position: {lat: ".$Team[$tm]['Lat'].", lng: ".$Team[$tm]['Long']."},";
						$title	= "title: '".$Team[$tm]['Name'].", ".$Team[$tm]['Loc']."',";
						$pincol	= "icon: 'http://www.googlemapsmarkers.com/v1/".$Team[$tm]['Pin'][0]."/".mCol($Team[$tm]['Pin'][2])."/".mCol($Team[$tm]['Pin'][1])."/".mCol($Team[$tm]['Pin'][3])."/', map: map });\n";
						array_push($MAR, $start.$pos.$title.$pincol);
					}
				}
			}
			print "Filter for supplied ladder<br/>\n";
		}
	}
?>
		<div id="map"></div>
		<script>
			function initMap() {
				var map = new google.maps.Map(document.getElementById('map'), {
					center: new google.maps.LatLng(<?php print $_GET['lat'].",".$_GET['lng']; ?>),
					zoom: <?php print $_GET['z']; ?>
				});
<?php 
	foreach ($MAR as $m) {
		print $m;
	}
?>
			}
		</script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7hP3y2nf3CfHP9HSKPs9YlfDvCBOU3MY&callback=initMap"></script>
	</body>
</html>
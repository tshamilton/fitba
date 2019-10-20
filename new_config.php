<?php
include 'utility.php';

function table($in_t, $nC, $context) {
	global $Team;
	global $Stats;
	
	$tCols = Array();
	$tCols = array_pad($tCols, $nC, 0);
	$index = 0;
	$size = sizeof($in_t);
	$tKeys = array_keys($in_t);

	while ($size) {
		$tCols[$index]++;
		$index++;
		if ($index >= $nC) { $index = 0; }
		$size--;
	}
	switch($nC){
		case 12:
			$colW = t(6)."<div class=\"col-sm-1\">\n";
			break;
		case 6:
			$colW = t(6)."<div class=\"col-sm-2\">\n";
			break;
		case 4:
			$colW = t(6)."<div class=\"col-sm-3\">\n";
			break;
		case 3:
			$colW = t(6)."<div class=\"col-sm-4\">\n";
			break;
	}
	
	print t(5)."<div class=\"row\">\n";
	foreach ($tCols as $cL) {
		print $colW;
		for ($cL = $cL; $cL > 0; $cL--) {
			$k = array_shift($tKeys);
			$v = $in_t[$k];
			switch ($context) {
				case "minor":
					$k = strrev($k);
					print t(7)."<div class=\"team mx-1 my-2 ".$k."\">".$k." (".$v.")</div>\n";
					break;
				case "majorX":
					$k = strrev($k);
					print t(7)."<div class=\"team mx-1 my-2 x-".$k."\">x-".$k." (".$v.")</div>\n";
					break;
				case "majorE":
					$k = strrev($k);
					print t(7)."<div class=\"team mx-1 my-2 e-".$k."\">e-".$k." (".$v.")</div>\n";
					break;
				case "majorV":
					$k = strrev($k);
					print t(7)."<div class=\"team mx-1 my-2 v-".$k."\">v-".$k." (".$v.")</div>\n";
					break;
				case "majorB":
					$k = strrev($k);
					print t(7)."<div class=\"team mx-1 my-2 b-".$k."\">b-".$k." (".$v.")</div>\n";
					break;
				case "majorZ":
					$k = strrev($k);
					print t(7)."<div class=\"team mx-1 my-2 z-".$k."\">z-".$k." (".$v.")</div>\n";
					break;
				case "majorE":
					$k = strrev($k);
					print t(7)."<div class=\"team mx-1 my-2 e-".$k."\">e-".$k." (".$v.")</div>\n";
					break;
				case "majorH":
					$k = strrev($k);
					print t(7)."<div class=\"team mx-1 my-2 h-".$k."\">h-".$k." (".$v.")</div>\n";
					break;
				case "majorS":
					$body = substr($k, 0, strlen($k)-1);
					$text = substr($k, strlen($k)-1, 1);
					print t(7)."<div class=\"team mx-1 my-2 s-".$text.$body."\">s-".$text.$body." (".$v.")</div>\n";
					break;
				case "majorO":
					$body = substr($k, 0, strlen($k)-1);
					$text = substr($k, strlen($k)-1, 1);
					print t(7)."<div class=\"team mx-1 my-2 o-".$text.$body."\">o-".$text.$body." (".$v.")</div>\n";
					break;
				case "majorD":
					$body = substr($k, 0, strlen($k)-1);
					$text = substr($k, strlen($k)-1, 1);
					print t(7)."<div class=\"team mx-1 my-2 d-".$text.$body."\">d-".$text.$body." (".$v.")</div>\n";
					break;
				case "nats":
					if ($k == "MKD") {
						$k = "NMK";
					}
					if ($k == "INT") {
						print t(7)."<div class=\"team mx-1 my-2 slate\">International (".$v.")</div>\n";
					}
					else {
						$name = $Stats['countryByTri'][$k];
						if (strlen($Team[$name]["Badge"]) > 0) {
							$style = $Team[$name]["Badge"];
						}
						else {
							$style = $Team[$name]["Mjr"];
						}
						print t(7)."<div class=\"team mx-1 my-2 ".$style."\">".$Team[$name]["Name"]." (".$v.") <img class=\"".substr($Team[$name]["Mnr"], 0, 1)." flag\" src=\"flags/".$k.".png\"></div>\n";
					}
					break;
				case "cNats":
					if ($k == "MKD") {
						$k = "NMK";
					}
					if ($k == "czechoslovakia" || $k == "sovietunion") {
					}
					else {
						$name = $Team[$k]["Name"];
						$tr = $Stats['countryByName'][$k];
						if ($Stats["teamCountByCountry"][$Stats["countryByName"][$k]] > 0) { $tCount = " (".$Stats["teamCountByCountry"][$Stats["countryByName"][$k]].")"; }
						else { $tCount = ""; }
						print t(7)."<div class=\"team mx-1 my-2 ".$Team[$k]["Mjr"]."\"><a href=\"#".$tr."\">".$name." <img class=\"".substr($Team[$k]["Mnr"], 0, 1)." flag\" src=\"flags/".$tr.".png\">".$tCount."</a></div>";
					}
					break;
				case "cNatsBadges":
					$tN = $Team[$k];
#					print t(7)."<div class=\"team mx-1 my-2 ".$Team[$k]["Mjr"]."\"><a href=\"#".$tr."\">".$name." <img class=\"".substr($Team[$k]["Mnr"], 0, 1)." flag\" src=\"flags/".$tr.".png\">".$tCount."</a></div>";
					pretty_var($tN, '77aadd');
					pretty_var($v, 'ffcc00');
					break;
				case "natsTC":
					$name = $Stats['countryByTri'][$k];
					if (strlen($Team[$name]["Badge"]) > 0) {
						$style = $Team[$name]["Badge"];
					}
					else {
						$style = $Team[$name]["Mjr"];
					}
					print t(7)."<div class=\"team mx-1 my-2 ".$style."\">".$Team[$name]["Name"]." (".$v.") <img class=\"".substr($Team[$name]["Mnr"], 0, 1)." flag\" src=\"flags/".$k.".png\"></div>\n";
					break;
				case "tBC":
					print t(7)."<div class=\"team mx-1 my-2 ".$Team[$v]["Mjr"]."\"> ".$Team[$v]["Name"]." </a></div>";
					break;
				case "nB":
					print t(7)."<div class=\"team mx-1 my-2 ".$Team[$k]["Badge"]."\"> ".$Team[$k]["Name"]." </a></div>";
					break;
				default:
					pretty_var($k." => ".$v);
			}
		}
		print t(6)."</div>\n";
	}
	print t(5)."</div>\n";
}

$string = file_get_contents('base.json');
$Stats = json_decode($string, true);
$the_teams	= file("config/teams.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_nats	= file("config/nations.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_missing= file("news/missing.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$Team = Array();
$Nations = Array();

foreach ($the_teams as $in_t) {
	if (preg_match("/^#/", $in_t) || strlen($in_t) < 5) {
		# skip line
	}
	else {
		#arsenal,Arsenal,Awrw,wr,b-wwr,x009,51.555,-0.108611,Highbury,ENG
		$t_line = explode(",", $in_t);
		$idName = explode("~", $t_line[0]);
		$id = $idName[0];
		$Team[$id]["Name"] = $t_line[1];
		$Team[$id]["Pin"] = $t_line[2];
		$Team[$id]["Mnr"] = $t_line[3];
		$Team[$id]["Mjr"] = $t_line[4];
		$Team[$id]["Badge"] = $t_line[5];
		$Team[$id]["Long"] = $t_line[6];
		$Team[$id]["Lat"] = $t_line[7];
		$Team[$id]["Loc"] = $t_line[8];
		$Team[$id]["Tri"] = $t_line[9];
	}
}
foreach ($the_nats as $in_t) {
	if (preg_match("/^#/", $in_t) || strlen($in_t) < 5) {
		# skip line
	}
	else {
		#australia,Australia,gy,x-gy,x049,-25.274398,133.775136,5,AUS
		$t_line = explode(",", $in_t);
		$idName = explode("~", $t_line[0]);
		$id = $idName[0];
		$Team[$id]["Name"] = $t_line[1];
		$Team[$id]["Mnr"] = $t_line[2];
		$Team[$id]["Mjr"] = $t_line[3];
		$Team[$id]["Badge"] = $t_line[4];
		$Team[$id]["Lat"] = $t_line[5];
		$Team[$id]["Long"] = $t_line[6];
		$Team[$id]["Zom"] = $t_line[7];
		$Team[$id]["Tri"] = $t_line[8];
	}
}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Fitba Stats and Config</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- My CSS links -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Montserrat">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/badge.css">
	</head>
	<body>
		<ul class="nav nav-pills nav-fill static-top theTabBody">
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#stats"> Stats </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#colours"> Colours </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#nations"> Nations </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#clubs"> Clubs </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#badges"> Badges </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#champs"> Champs </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#missing"> Missing </a></li>
		</ul>

<!-- Tab panes -->
		<div class="tab-content theBody">
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="stats" name="stats">
			<div class="container-fluid">
				<h1 class="text-center"> Stats </h1>
				<h2 class="text-center"> Colours </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
					<div class="theContent grass p-2">
						<div class="row">
							<div class="col-sm-2">
								<div style="border: 1px solid #0033cc; box-sizing: border-box;" class="team mx-1 my-2 wa"><span> a - azure - 3366ff </span></div>
								<div style="border: 1px solid #3333cc; box-sizing: border-box;" class="team mx-1 my-2 wb"><span> b - blue - 0000ff </span></div>
								<div style="border: 1px solid #660011; box-sizing: border-box;" class="team mx-1 my-2 wc"><span> c - claret - 990044 </span></div>
								<div style="border: 1px solid #330000; box-sizing: border-box;" class="team mx-1 my-2 wd"><span> d - blood - cc0000 </span></div>
							</div>
							<div class="col-sm-2">
								<div style="border: 1px solid #009900; box-sizing: border-box;" class="team mx-1 my-2 ke"><span> e - emerald - 00cc00 </span></div>
								<div style="border: 1px solid #4477aa; box-sizing: border-box;" class="team mx-1 my-2 kf"><span> f - sky - 77aadd </span></div>
								<div style="border: 1px solid #00cc00; box-sizing: border-box;" class="team mx-1 my-2 wg"><span> g - green - 009900 </span></div>
								<div style="border: 1px solid #0077cc; box-sizing: border-box;" class="team mx-1 my-2 kh"><span> h - light blue - 00aaff </span></div>
							</div>
							<div class="col-sm-2">
								<div style="border: 1px solid #cc6c6c; box-sizing: border-box;" class="team mx-1 my-2 ki"><span> i - pink - ff9f9f </span></div>
								<div style="border: 1px solid #770055; box-sizing: border-box;" class="team mx-1 my-2 kj"><span> j - puce - aa3388 </span></div>
								<div style="border: 1px solid #333333; box-sizing: border-box;" class="team mx-1 my-2 wk"><span> k - black - 000000 </span></div>
								<div style="border: 1px solid #5533bb; box-sizing: border-box;" class="team mx-1 my-2 wl"><span> l - lilac - 8866ee </span></div>
								<div style="border: 1px solid #cc00cc; box-sizing: border-box;" class="team mx-1 my-2 wm"><span> m - magenta - ff00ff </span></div>
							</div>
							<div class="col-sm-2">
								<div style="border: 1px solid #3333cc; box-sizing: border-box;" class="team mx-1 my-2 wn"><span> n - navy - 000099 </span></div>
								<div style="border: 1px solid #cc6600; box-sizing: border-box;" class="team mx-1 my-2 ko"><span> o - orange - ff9900 </span></div>
								<div style="border: 1px solid #330066; box-sizing: border-box;" class="team mx-1 my-2 wp"><span> p - purple - 660099 </span></div>
								<div style="border: 1px solid #550000; box-sizing: border-box;" class="team mx-1 my-2 wq"><span> q - maroon - 880000 </span></div>
								<div style="border: 1px solid #cc0000; box-sizing: border-box;" class="team mx-1 my-2 wr"><span> r - red - ff0000 </span></div>
							</div>
							<div class="col-sm-2">
								<div style="border: 1px solid #777777; box-sizing: border-box;" class="team mx-1 my-2 ks"><span> s - silver - aaaaaa </span></div>
								<div style="border: 1px solid #a67818; box-sizing: border-box;" class="team mx-1 my-2 kt"><span> t - beige - d9ab4b </span></div>
								<div style="border: 1px solid #cc9900; box-sizing: border-box;" class="team mx-1 my-2 ku"><span> u - gold - ffcc00 </span></div>
								<div style="border: 1px solid #772200; box-sizing: border-box;" class="team mx-1 my-2 wv"><span> v - brown - aa5533 </span></div>
							</div>
							<div class="col-sm-2">
								<div style="border: 1px solid #cccccc; box-sizing: border-box;" class="team mx-1 my-2 kw"><span> w - white - ffffff </span></div>
								<div style="border: 1px solid #993366; box-sizing: border-box;" class="team mx-1 my-2 wx"><span> x - bordeaux - 660033 </span></div>
								<div style="border: 1px solid #ccbd00; box-sizing: border-box;" class="team mx-1 my-2 ky"><span> y - yellow - fff00c </span></div>
								<div style="border: 1px solid #00cc00; box-sizing: border-box;" class="team mx-1 my-2 kz"><span> z - lime - 00ff00 </span></div>
							</div>
						</div>
					</div>
				</div>
				</div>
				<h2 class="text-center">Info</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
					<div class="theContent slate p-2">
						<p style="margin-top: 1rem;">
							<?php print $Stats["totalTeams"]." teams in the database from ".$Stats["totalCountries"]." countries.<br/>\n"; ?>
						</p>
						<p style="margin-top: 1rem;">
							<?php print sizeof($Stats["countMajor"]["x"])." plain designs.<br/>\n"; ?>
							<?php print sizeof($Stats["countMajor"]["s"])." striped designs.<br/>\n"; ?>
							<?php print sizeof($Stats["countMajor"]["e"])." edged designs.<br/>\n"; ?>
							<?php print sizeof($Stats["countMajor"]["b"])." banded designs.<br/>\n"; ?>
							<?php print sizeof($Stats["countMajor"]["h"])." hooped designs.<br/>\n"; ?>
							<?php print sizeof($Stats["countMajor"]["o"])." offset designs.<br/>\n"; ?>
							<?php print sizeof($Stats["countMajor"]["v"])." halved designs.<br/>\n"; ?>
							<?php print sizeof($Stats["countMajor"]["d"])." sashed designs.<br/>\n"; ?>
							<?php print sizeof($Stats["countMajor"]["z"])." chequered designs.<br/>\n"; ?>
						</p>
						<p style="margin-top: 1rem;">
							<a href="./news/world.orig">See the current raw text.</a><br/>
							<a href="./news/world.txt">See the current news file.</a><br/>
						</p>
					</div>
				</div>
				</div>
				<h2 class="text-center">Errors</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
					<div class="theContent slate p-2">
						<p style="margin-top: 1rem;">
							<?php
								foreach ($Stats["errorList"] as $err) {
									print $err."<br/>\n";
								}
							?>
						</p>
					</div>
				</div>
				</div>
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="colours" name="colours">
			<div class="container-fluid">
				<h1 class="text-center"> Colours </h1>
				<h2 class="text-center"> Minor Styles (<?php print sizeof($Stats["countMinor"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMnS = array();
	foreach ($Stats["countMinor"] as $S => $c) {
		$countMnS[strrev($S)] = $c;
	}
	ksort($countMnS);
	table($countMnS, 12, 'minor');
?>
				</div>
				</div>
				<h2 class="text-center"> Plain Styles (<?php print sizeof($Stats["countMajor"]["x"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMjX = array();
	foreach ($Stats["countMajor"]["x"] as $S => $c) {
		$the_key = strrev(substr($S,2,2));
		$countMjX[$the_key] = $c;
	}
	ksort($countMjX);
	table($countMjX, 12, 'majorX');
?>
				</div>
				</div>
				<h2 class="text-center"> Striped Styles (<?php print sizeof($Stats["countMajor"]["s"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMjX = array();
	foreach ($Stats["countMajor"]["s"] as $S => $c) {
		$text = substr($S, 2, 1);
		$body = substr($S, 3);
		$the_key = $body.$text;
		$countMjX[$the_key] = $c;
	}
	ksort($countMjX);
	table($countMjX, 12, 'majorS');
?>
				</div>
				</div>
				<h2 class="text-center"> Edged Styles (<?php print sizeof($Stats["countMajor"]["e"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMjX = array();
	foreach ($Stats["countMajor"]["e"] as $S => $c) {
		$the_key = strrev(substr($S, 2));
		$countMjX[$the_key] = $c;
	}
	ksort($countMjX);
	table($countMjX, 12, 'majorE');
?>
				</div>
				</div>
				<h2 class="text-center"> Banded Styles (<?php print sizeof($Stats["countMajor"]["b"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMjX = array();
	foreach ($Stats["countMajor"]["b"] as $S => $c) {
		$the_key = strrev(substr($S, 2));
		$countMjX[$the_key] = $c;
	}
	ksort($countMjX);
	table($countMjX, 12, 'majorB');
?>
				</div>
				</div>
				<h2 class="text-center"> Hooped Styles (<?php print sizeof($Stats["countMajor"]["h"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMjX = array();
	foreach ($Stats["countMajor"]["h"] as $S => $c) {
		$the_key = strrev(substr($S, 2));
		$countMjX[$the_key] = $c;
	}
	ksort($countMjX);
	table($countMjX, 12, 'majorH');
?>
				</div>
				</div>
				<h2 class="text-center"> Offset Styles (<?php print sizeof($Stats["countMajor"]["o"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMjX = array();
	foreach ($Stats["countMajor"]["o"] as $S => $c) {
		$text = substr($S, 2, 1);
		$body = substr($S, 3);
		$the_key = $body.$text;
		$countMjX[$the_key] = $c;
	}
	ksort($countMjX);
	table($countMjX, 12, 'majorO');
?>
				</div>
				</div>
				<h2 class="text-center"> Halved Styles (<?php print sizeof($Stats["countMajor"]["v"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMjX = array();
	foreach ($Stats["countMajor"]["v"] as $S => $c) {
		$the_key = strrev(substr($S, 2));
		$countMjX[$the_key] = $c;
	}
	ksort($countMjX);
	table($countMjX, 12, 'majorV');
?>
				</div>
				</div>
				<h2 class="text-center"> Sash Styles (<?php print sizeof($Stats["countMajor"]["d"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMjX = array();
	foreach ($Stats["countMajor"]["d"] as $S => $c) {
		$text = substr($S, 2, 1);
		$body = substr($S, 3);
		$the_key = $body.$text;
		$countMjX[$the_key] = $c;
	}
	ksort($countMjX);
	table($countMjX, 12, 'majorD');
?>
				</div>
				</div>
				<h2 class="text-center"> Checkered Styles (<?php print sizeof($Stats["countMajor"]["z"]); ?> total)</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMjX = array();
	foreach ($Stats["countMajor"]["z"] as $S => $c) {
		$the_key = strrev(substr($S, 2));
		$countMjX[$the_key] = $c;
	}
	ksort($countMjX);
	table($countMjX, 12, 'majorZ');
?>
				</div>
				</div>
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="nations" name="nations">
			<div class="container-fluid">
				<h1 class="text-center"> Nations </h1>
				<h2 class="text-center"> By Competition Preference </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php 
	asort($Stats['monNats']);
	table($Stats['monNats'], 6, 'nats');
?>
				</div>
				</div>
				<h2 class="text-center"> By Count </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	arsort($Stats['teamCountByCountry']);
	table(array_slice($Stats['teamCountByCountry'], 0, 50), 6, 'natsTC');
?>
				</div>
				</div>
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation darkSlate" id="clubs" name="clubs">
			<div class="container-fluid">
				<a name="TOP">
				<h1 class="text-center"> Clubs </h1>
				<h2 class="text-center"> Nations </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	table($Stats['countryByName'], 6, 'cNats');
?>
				</div>
				</div>
<?php
foreach ($Stats["countryByTri"] as $cName) {
	$cTri = $Stats["countryByName"][$cName];
	$tBC_n = $Team[$cName]["Name"];
	$tBC_lt = $Team[$cName]["Lat"];
	$tBC_ln = $Team[$cName]["Long"];
	$tBC_z = $Team[$cName]["Zom"];
	$tBC_s = $Team[$cName]["Mjr"];
	$tBC_n = $Team[$cName]["Name"];
	$tBC_e = substr($Team[$cName]["Mnr"], 0, 1);
	$tBC_f = "<img src=\"flags/large/".$cTri.".png\" class=\"".$tBC_e."\">";
	$to_top = "<a href=\"#top\"><i class=\"material-icons\">arrow_upward</i></a>";
	$to_map = "<a href=\"map_page.php?lat=".$tBC_lt."&lng=".$tBC_ln."&z=".$tBC_z."&t=".$cTri."&n=".$tBC_n."\" target=\"_new\"><i class=\"material-icons\">map</i></a>";
	if ($Stats["teamCountByCountry"][$cTri] == 0) {
		$dataLine = "<div class=\"text-center\">".$to_map." | ".$to_top."</div>\n";
	}
	else {
		$dataLine = "<div class=\"text-center\">".$Stats["teamCountByCountry"][$cTri]."  <i class=\"material-icons\">person</i> | ".$to_map." | ".$to_top."</div>\n";
	}
	print t(5)."<a name=\"".$cTri."\"></a>\n";
	print t(5)."<p>&nbsp;</p>\n";
	print t(5)."<div class=\"theContent ".$tBC_s." p-2 mb-3\">\n";
	print t(6)."<h3> ".$tBC_f." ".$tBC_n." </h3>\n";
	print t(6).$dataLine;
	if ($Stats["teamCountByCountry"][$cTri] > 0) {
		print t(6)."<div class=\"theContent grass ".$tBC_e." p-2 mb-3\" style=\"text-shadow: 0px 0px black\">\n";
		table($Stats['teamByCountry'][$cTri], 6, 'tBC');
		print t(6)."</div>\n";
	}
	print t(5)."</div>\n";
	
}
?>
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="badges" name="badges">
			<div class="container-fluid">
				<h1 class="text-center"> Badges </h1>
				<h2 class="text-center"> Badged Teams by Country </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	ksort($Stats['teamBadgesCountByCountry']);
	table($Stats['teamBadgesCountByCountry'], 6, 'cNatsBadges');
?>
				</div>
				</div>
				<h2 class="text-center"> National Teams </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php					table($Stats["nationalBadges"], 6, 'nB'); ?>
				</div>
				</div>
				<h2 class="text-center"> Teams </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
				</div>
				</div>
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="champs" name="champs">
			<div class="container-fluid">
				<h1 class="text-center"> Champs </h1>
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="missing" name="missing">
			<div class="container-fluid">
				<h1 class="text-center"> Missing </h1>
<?php
$current_date = "";
foreach ($the_missing as $m) {
	if (preg_match("/^20/", $m)) {
		print "<span style=\"color: #990000; font-style: italic;\">".$m."</span><br/>\n";
	}
	elseif (preg_match("/ team /", $m)) {
		$mTeam = explode(" ", $m);
		$mTeam = array_pop($mTeam);
		if (!(isset($Team[$mTeam]))) {
			pretty_var($mTeam, '77aadd');
		}
	}
	else {
		print $m."<br/>\n";
	}
}
?>
			</div>
			</div><!-- End tab panel -->
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>

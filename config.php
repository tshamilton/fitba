<?php
include 'utility.php';
session_start();

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
					if (preg_match("/x/", $tN["Badge"])) {
						print t(7)."<div class=\"team mx-1 my-2 ".$tN["Badge"]."\"><a href=\"#".$Stats["countryByName"][$k]."\">".$tN["Name"]." <img class=\"".substr($tN["Mnr"], 0, 1)." flag\" src=\"flags/".$Stats["countryByName"][$k].".png\"> (".$Stats["teamBadgesCountByCountry"][$k].")</a></div>";
					}
					else {
						print t(7)."<div class=\"team mx-1 my-2 ".$tN["Mjr"]."\"><a href=\"#".$Stats["countryByName"][$k]."\">".$tN["Name"]." <img class=\"".substr($tN["Mnr"], 0, 1)." flag\" src=\"flags/".$Stats["countryByName"][$k].".png\"> (".$Stats["teamBadgesCountByCountry"][$k].")</a></div>";
					}
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
				case "nTB":
					print t(7)."<div class=\"team mx-1 my-2 ".$Team[$v]["Badge"]."\"> ".$Team[$v]["Name"]." </a></div>";
					break;
				case "champs":
					if ($v == "N/A") {
						print t(7)."<div class=\"team mx-1 my-2 slate\" style=\"font-size: 13.5px;\"> ".$k.": N/A </a></div>";
					}
					elseif ($v == "?") {
						print t(7)."<div class=\"team mx-1 my-2 slate\" style=\"font-size: 13.5px;\"> ".$k.": ? </a></div>";
					}
					elseif ($v == "westgermany") {
						print t(7)."<div class=\"team mx-1 my-2 ".$Team["germany"]["Badge"]."\" style=\"font-size: 13.5px;\"> ".$k.": West Germany </a></div>";
					}
					else {
						print t(7)."<div class=\"team mx-1 my-2 ".$Team[$v]["Badge"]."\" style=\"font-size: 13.5px;\"> ".$k.": ".$Team[$v]["Name"]." </a></div>";
					}
					break;
				default:
					pretty_var($k." => ".$v);
			}
		}
		print t(6)."</div>\n";
	}
	print t(5)."</div>\n";
}

$string = file_get_contents('config/base.json');
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
			<li class="nav-item active slate"><a role="nav-link" data-toggle="pill" href="#stats"> Stats </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#colours"> Colours </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#nations"> Nations </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#clubs"> Clubs </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#badges"> Badges </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#champs"> Champs </a></li>
			<li class="nav-item slate"><a role="nav-link" data-toggle="pill" href="#missing"> Missing </a></li>
		</ul>

<!-- Tab panes -->
		<div class="tab-content theBody">
			<div role="tabpanel" class="tab-pane active container-fluid fade theNation slate" id="stats" name="stats">
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
				<h2 class="text-center"> Diacritics </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
					<div class="theContent grass p-2">
						<div class="row">
							<div class="col-sm-3 table-responsive justify-content-center my-3">
								<small>
								<table style="width: 100%;" class="table table-sm table-light align-left">
								<thead>
								<tr><th colspan="3" class="text-center white-text" style="background-color: black; color: white;">A - C</th></tr>
								<tr><th class="text-center">Char</th><th class="text-left">Called</th><th class="text-left">HTML</th></tr>
								</thead>
								<tbody>
								<tr><td class="text-center">&amp;</td><td class="text-left">ampersand</td><td class="text-left">&amp;amp;</td></tr>
								<tr><td class="text-center">&#39;</td><td class="text-left">apostrophe</td><td class="text-left">&amp;#39;</td></tr>
								<tr><td class="text-center">&#44;</td><td class="text-left">comma</td><td class="text-left">&amp;#44;</td></tr>
								<tr><td class="text-center">&deg;</td><td class="text-left">degree</td><td class="text-left">&amp;deg;</td></tr>
								<tr><td class="text-center">&quot;</td><td class="text-left">quote</td><td class="text-left">&amp;quot;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&aacute;</td><td class="text-left">a-acute</td><td class="text-left">&amp;aacute;</td></tr>
								<tr><td class="text-center">&Aacute;</td><td class="text-left">A-acute</td><td class="text-left">&amp;Aacute;</td></tr>
								<tr><td class="text-center">&abreve;</td><td class="text-left">a-breve</td><td class="text-left">&amp;abreve;</td></tr>
								<tr><td class="text-center">&acirc;</td><td class="text-left">a-circumflex</td><td class="text-left">&amp;acirc;</td></tr>
								<tr><td class="text-center">&agrave;</td><td class="text-left">a-grave</td><td class="text-left">&amp;agrave;</td></tr>
								<tr><td class="text-center">&amacr;</td><td class="text-left">a-macron</td><td class="text-left">&amp;amacr;</td></tr>
								<tr><td class="text-center">&aogon;</td><td class="text-left">a-ogon</td><td class="text-left">&amp;aogon;</td></tr>
								<tr><td class="text-center">&aring;</td><td class="text-left">a-ring</td><td class="text-left">&amp;aring;</td></tr>
								<tr><td class="text-center">&Aring;</td><td class="text-left">A-ring</td><td class="text-left">&amp;Aring;</td></tr>
								<tr><td class="text-center">&atilde;</td><td class="text-left">a-tilde</td><td class="text-left">&amp;atilde;</td></tr>
								<tr><td class="text-center">&auml;</td><td class="text-left">a-umlaut</td><td class="text-left">&amp;auml;</td></tr>
								<tr><td class="text-center">&Auml;</td><td class="text-left">A-umlaut</td><td class="text-left">&amp;Auml;</td></tr>
								<tr><td class="text-center">&aelig;</td><td class="text-left">ae-ligature</td><td class="text-left">&amp;aelig;</td></tr>
								<tr><td class="text-center">&AElig;</td><td class="text-left">AE-ligature</td><td class="text-left">&amp;AElig;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&cacute;</td><td class="text-left">c-acute</td><td class="text-left">&amp;cacute;</td></tr>
								<tr><td class="text-center">&ccaron;</td><td class="text-left">c-caron</td><td class="text-left">&amp;ccaron;</td></tr>
								<tr><td class="text-center">&Ccaron;</td><td class="text-left">C-caron</td><td class="text-left">&amp;Ccaron;</td></tr>
								<tr><td class="text-center">&ccedil;</td><td class="text-left">c-cedilla</td><td class="text-left">&amp;ccedil;</td></tr>
								<tr><td class="text-center">&Ccedil;</td><td class="text-left">C-cedilla</td><td class="text-left">&amp;Ccedil;</td></tr>
								</tbody>
								</table>
								</small>
							</div>
							<div class="col-sm-3 table-responsive justify-content-center my-3">
								<small>
								<table style="width: 100%;" class="table table-sm table-light align-left">
								<thead>
								<tr><th colspan="3" class="text-center white-text" style="background-color: black; color: white;">D - K</th></tr>
								<tr><th class="text-center">Char</th><th class="text-left">Called</th><th class="text-left">HTML</th></tr>
								</thead>
								<tbody>
								<tr><td class="text-center">&eth;</td><td class="text-left">eth (lower)</td><td class="text-left">&amp;eth;</td></tr>
								<tr><td class="text-center">&dstrok;</td><td class="text-left">d-stroke</td><td class="text-left">&amp;dstrok;</td></tr>
								<tr><td class="text-center">&Dstrok;</td><td class="text-left">D-stroke</td><td class="text-left">&amp;Dstrok;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&eacute;</td><td class="text-left">e-acute</td><td class="text-left">&amp;eacute;</td></tr>
								<tr><td class="text-center">&Eacute;</td><td class="text-left">E-acute</td><td class="text-left">&amp;Eacute;</td></tr>
								<tr><td class="text-center">&ecaron;</td><td class="text-left">e-caron</td><td class="text-left">&amp;ecaron;</td></tr>
								<tr><td class="text-center">&ecirc;</td><td class="text-left">e-circumflex</td><td class="text-left">&amp;ecirc;</td></tr>
								<tr><td class="text-center">&edot;</td><td class="text-left">e-dot</td><td class="text-left">&amp;edot;</td></tr>
								<tr><td class="text-center">&egrave;</td><td class="text-left">e-grave</td><td class="text-left">&amp;egrave;</td></tr>
								<tr><td class="text-center">&emacr;</td><td class="text-left">e-macron</td><td class="text-left">&amp;emacr;</td></tr>
								<tr><td class="text-center">&eogon;</td><td class="text-left">e-ogon</td><td class="text-left">&amp;eogon;</td></tr>
								<tr><td class="text-center">&euml;</td><td class="text-left">e-umlaut</td><td class="text-left">&amp;euml;</td></tr>
								<tr><td class="text-center">&#601;</td><td class="text-left">schwa</td><td class="text-left">&amp;#601;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&gbreve;</td><td class="text-left">g-breve</td><td class="text-left">&amp;gbreve;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&iacute;</td><td class="text-left">i-acute</td><td class="text-left">&amp;iacute;</td></tr>
								<tr><td class="text-center">&Iacute;</td><td class="text-left">I-acute</td><td class="text-left">&amp;Iacute;</td></tr>
								<tr><td class="text-center">&icirc;</td><td class="text-left">i-circumflex</td><td class="text-left">&amp;icirc;</td></tr>
								<tr><td class="text-center">&Icirc;</td><td class="text-left">I-circumflex</td><td class="text-left">&amp;Icirc;</td></tr>
								<tr><td class="text-center">&igrave;</td><td class="text-left">i-grave</td><td class="text-left">&amp;igrave;</td></tr>
								<tr><td class="text-center">&imacr;</td><td class="text-left">i-macron</td><td class="text-left">&amp;imacr;</td></tr>
								<tr><td class="text-center">&inodot;</td><td class="text-left">i-nodot</td><td class="text-left">&amp;inodot;</td></tr>
								<tr><td class="text-center">&Idot;</td><td class="text-left">I-dot</td><td class="text-left">&amp;Idot;</td></tr>
								<tr><td class="text-center">&itilde;</td><td class="text-left">i-tilde</td><td class="text-left">&amp;itilde;</td></tr>
								<tr><td class="text-center">&iuml;</td><td class="text-left">i-umlaut</td><td class="text-left">&amp;iuml;</td></tr>
								<tr><td class="text-center">&IJlig;</td><td class="text-left">IJ-ligature</td><td class="text-left">&amp;IJlig;</td></tr>
								</tbody>
								</table>
								</small>
							</div>
							<div class="col-sm-3 table-responsive justify-content-center my-3">
								<small>
								<table style="width: 100%;" class="table table-sm table-light align-left">
								<thead>
								<tr><th colspan="3" class="text-center white-text" style="background-color: black; color: white;">L - R</th></tr>
								<tr><th class="text-center">Char</th><th class="text-left">Called</th><th class="text-left">HTML</th></tr>
								</thead>
								<tbody>
								<tr><td class="text-center">&lstrok;</td><td class="text-left">l-stroke</td><td class="text-left">&amp;lstrok;</td></tr>
								<tr><td class="text-center">&Lstrok;</td><td class="text-left">L-stroke</td><td class="text-left">&amp;Lstrok;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&nacute;</td><td class="text-left">n-acute</td><td class="text-left">&amp;nacute;</td></tr>
								<tr><td class="text-center">&ncaron;</td><td class="text-left">n-caron</td><td class="text-left">&amp;ncaron;</td></tr>
								<tr><td class="text-center">&ntilde;</td><td class="text-left">n-tilde</td><td class="text-left">&amp;ntilde;</td></tr>
								<tr><td class="text-center">&Ntilde;</td><td class="text-left">N-tilde</td><td class="text-left">&amp;Ntilde;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&oacute;</td><td class="text-left">o-acute</td><td class="text-left">&amp;oacute;</td></tr>
								<tr><td class="text-center">&Oacute;</td><td class="text-left">O-acute</td><td class="text-left">&amp;Oacute;</td></tr>
								<tr><td class="text-center">&odblac;</td><td class="text-left">o-doubleacute</td><td class="text-left">&amp;odblac;</td></tr>
								<tr><td class="text-center">&ocirc;</td><td class="text-left">o-circumflex</td><td class="text-left">&amp;ocirc;</td></tr>
								<tr><td class="text-center">&ograve;</td><td class="text-left">o-grave</td><td class="text-left">&amp;ograve;</td></tr>
								<tr><td class="text-center">&omacr;</td><td class="text-left">o-macron</td><td class="text-left">&amp;omacr;</td></tr>
								<tr><td class="text-center">&Omacr;</td><td class="text-left">O-macron</td><td class="text-left">&amp;Omacr;</td></tr>
								<tr><td class="text-center">&oslash;</td><td class="text-left">o-slash</td><td class="text-left">&amp;oslash;</td></tr>
								<tr><td class="text-center">&Oslash;</td><td class="text-left">O-slash</td><td class="text-left">&amp;Oslash;</td></tr>
								<tr><td class="text-center">&otilde;</td><td class="text-left">o-tilde</td><td class="text-left">&amp;otilde;</td></tr>
								<tr><td class="text-center">&ouml;</td><td class="text-left">o-umlaut</td><td class="text-left">&amp;ouml;</td></tr>
								<tr><td class="text-center">&Ouml;</td><td class="text-left">O-umlaut</td><td class="text-left">&amp;Ouml;</td></tr>
								<tr><td class="text-center">&oelig;</td><td class="text-left">oe-ligature</td><td class="text-left">&amp;oelig;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&rcaron;</td><td class="text-left">r-caron</td><td class="text-left">&amp;rcaron;</td></tr>
								<tr><td class="text-center">&Rcaron;</td><td class="text-left">R-caron</td><td class="text-left">&amp;Rcaron;</td></tr>
								</tbody>
								</table>
								</small>
							</div>
							<div class="col-sm-3 table-responsive justify-content-center my-3">
								<small>
								<table style="width: 100%;" class="table table-sm table-light align-left">
								<thead>
								<tr><th colspan="3" class="text-center white-text" style="background-color: black; color: white;">S - Z</th></tr>
								<tr><th class="text-center">Char</th><th class="text-left">Called</th><th class="text-left">HTML</th></tr>
								</thead>
								<tbody>
								<tr><td class="text-center">&sacute;</td><td class="text-left">s-acute</td><td class="text-left">&amp;sacute;</td></tr>
								<tr><td class="text-center">&Sacute;</td><td class="text-left">S-acute</td><td class="text-left">&amp;Sacute;</td></tr>
								<tr><td class="text-center">&scaron;</td><td class="text-left">s-caron</td><td class="text-left">&amp;scaron;</td></tr>
								<tr><td class="text-center">&Scaron;</td><td class="text-left">S-caron</td><td class="text-left">&amp;Scaron;</td></tr>
								<tr><td class="text-center">&scedil;</td><td class="text-left">s-cedilla</td><td class="text-left">&amp;scedil;</td></tr>
								<tr><td class="text-center">&Scedil;</td><td class="text-left">S-cedilla</td><td class="text-left">&amp;Scedil;</td></tr>
								<tr><td class="text-center">&scirc;</td><td class="text-left">s-circumflex</td><td class="text-left">&amp;scirc;</td></tr>
								<tr><td class="text-center">&szlig;</td><td class="text-left">sz-ligature</td><td class="text-left">&amp;szlig;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&tcedil;</td><td class="text-left">t-cedilla</td><td class="text-left">&amp;tcedil;</td></tr>
								<tr><td class="text-center">&THORN;</td><td class="text-left">Thorn (upper)</td><td class="text-left">&amp;THORN;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&uacute;</td><td class="text-left">u-acute;</td><td class="text-left">&amp;uacute;</td></tr>
								<tr><td class="text-center">&Uacute;</td><td class="text-left">U-acute</td><td class="text-left">&amp;Uacute;</td></tr>
								<tr><td class="text-center">&ugrave;</td><td class="text-left">u-grave</td><td class="text-left">&amp;ugrave;</td></tr>
								<tr><td class="text-center">&umacr;</td><td class="text-left">u-macron</td><td class="text-left">&amp;umacr;</td></tr>
								<tr><td class="text-center">&uogon;</td><td class="text-left">u-ogon</td><td class="text-left">&amp;uogon;</td></tr>
								<tr><td class="text-center">&uring;</td><td class="text-left">u-ring</td><td class="text-left">&amp;uring;</td></tr>
								<tr><td class="text-center">&uuml;</td><td class="text-left">u-umlaut</td><td class="text-left">&amp;uuml;</td></tr>
								<tr><td class="text-center">&Uuml;</td><td class="text-left">U-umlaut</td><td class="text-left">&amp;Uuml;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&yacute;</td><td class="text-left">y-acute</td><td class="text-left">&amp;yacute;</td></tr>
								<tr><td colspan="3" height="2" style="background-color: black;"></td></tr>
								<tr><td class="text-center">&zacute;</td><td class="text-left">z-acute</td><td class="text-left">&amp;zacute;</td></tr>
								<tr><td class="text-center">&zcaron;</td><td class="text-left">z-caron</td><td class="text-left">&amp;zcaron;</td></tr>
								<tr><td class="text-center">&Zcaron;</td><td class="text-left">Z-caron</td><td class="text-left">&amp;Zcaron;</td></tr>
								<tr><td class="text-center">&zdot;</td><td class="text-left">z-dot</td><td class="text-left">&amp;zdot;</td></tr>
								</table>
								</small>
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
							<?php print sizeof($Stats["countMajor"]["d"])." sashed designs.<br/>\n"; ?>
							<?php print sizeof($Stats["countMajor"]["v"])." halved designs.<br/>\n"; ?>
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
		$_SESSION['T'] = $Team;
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
<?php
	foreach ($Stats["teamBadgesByCountry"] as $cnt => $badges) {
		$cTri = $Stats["countryByName"][$cnt];
		print t(5)."<a name=\"".$cTri."\"><h3><img src=\"flags/large/".$cTri.".png\" class=\"k\"> ".$Team[$cnt]["Name"]." </h3></a>\n";
		print t(5)."<div class=\"container-fluid p-4\">\n";
		table($badges, 6, 'nTB');
		print t(5)."<p>&nbsp;</p>\n";
		print t(5)."</div>\n";
		
	}
?>
				</div>
				</div>
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="champs" name="champs">
			<div class="container-fluid">
				<h1 class="text-center"> Champs </h1>
				<h2 class="text-center"> English Premier League </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["ENG~Premier League"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> English FA Cup </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["ENG~FA Cup"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> Australian A-League </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["AUS~A-League"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> Australian FFA Cup </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["AUS~FFA Cup"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> French Ligue 1 </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["FRA~Ligue 1"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> German 1. Bundesliga </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["GER~Bundesliga"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> Spanish La Liga </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["ESP~La Liga"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> Scottish Premier League </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["SCO~Scottish Premier League"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> Italian Serie A </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["ITA~Serie A"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> Portuguese Primeira Liga </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["POR~Primeira Liga"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> Dutch Eredivisie </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["NED~Eredivisie"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> UEFA Champions League </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["INT~UEFA Champions League"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> UEFA Europa League </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["INT~Europa League"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> AFC Champions League </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["INT~AFC Champions League"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> UEFA European Championship </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["INT~UEFA European Championship"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> AFC Asian Cup </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["INT~AFC Asian Cup"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> Copa Libertadores </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["INT~Copa Libertadores"], 6, 'champs');
?>
				</div>
				<h2 class="text-center"> FIFA World Cup </h2>
				<div class="container-fluid p-4">
<?php
	table($Stats["champs"]["INT~FIFA World Cup"], 6, 'champs');
?>
				</div>
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="missing" name="missing">
			<div class="container-fluid">
				<h1 class="text-center"> Missing </h1>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$current_date = "";
	$seen = Array();
	$perm_list = Array();
	$current_list = Array();

	foreach ($the_missing as $m) {
		if (!(in_array($m, $seen))){
			if (preg_match("/^20/", $m)) {
//				pretty_var("Date-> ".$m, '3366ff');
				$current_date = $m;
				$current_list[$current_date] = Array();
			}
			elseif (preg_match("/^T/", $m)) {
				$this_team = explode(":", $m);
				if (isset($Team[$this_team[2]])) {
//					pretty_var("Known -> ".$this_team[2], '77aadd');
				}
				else {
//					pretty_var("Team-> ".$m, '66ff33');
					array_push($current_list[$current_date], $m);
				}
			}
			elseif (preg_match("/^C/", $m)) {
//				pretty_var("Comp-> ".$m, 'ff3366');
				array_push($current_list[$current_date], $m);
			}
			else {
				pretty_var($m, 'ffffff');
			}
			array_push($seen, $m);
		}
		else {
//			pretty_var("Seen-> ".$m, 'cccccc');
		}
	}
	foreach($current_list as $d => $l) {
		if (sizeof($l) > 0) {
			print "<b>".$d."</b><br/>\n";
			foreach ($l as $e)	{
				if  (preg_match("/^T/", $e)) {
					$this_team = explode(":", $e);
					print "<span style=\"margin-left: 15px;\"><i>".$this_team[2].",Name,Pin,Minor,Major,Badge,L1,L2,Location,".$this_team[1]."</i></span><br/>\n";
				}
				elseif (preg_match("/^C/", $e)) {
					$this_comp = explode(":", $e);
					print "<span style=\"margin-left: 15px;\"><i>LC,".$this_comp[2].",0,Name, (".$this_comp[1].")</i></span><br/>\n";
				}
			}
			print "<br/>&nbsp;<br/>\n";
		}
	}
?>
				</div>
				</div>
			</div>
			</div><!-- End tab panel -->
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>

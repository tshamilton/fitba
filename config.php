<?php
include 'utility.php';

$string = file_get_contents('./config/stats.json');
$Stats = json_decode($string, true);
$the_comps	= file("config/comps.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_teams	= file("config/teams.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_nats	= file("config/nations.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_missing= file("news/missing.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$DEBUG = 0;

foreach ($the_teams as $in_t) {
	#arsenal~thearsenal,Arsenal,Awrw,wr,b-wwr,x009,51.555,-0.108611,Highbury,ENG
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
foreach ($the_nats as $in_t) {
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
		<ul class="nav nav-pills nav-fill fixed-top theTabBody">
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
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="stats" name="stats"><div class="container-fluid">
					<h1 class="text-center"> Stats </h1>
					<h2 class="text-center">Colours</h2>
					<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
					<div class="container-fluid p-4">
						<div class="theContent grass p-2">
						<div class="row">
						<div class="col-sm-2">
							<div class="team mx-1 my-2 wa"><span> a - azure - 3366ff </span></div>
							<div class="team mx-1 my-2 wb"><span> b - blue - 0000ff </span></div>
							<div class="team mx-1 my-2 wc"><span> c - claret - 990044 </span></div>
							<div class="team mx-1 my-2 wd"><span> d - blood - cc0000 </span></div>
						</div>
						<div class="col-sm-2">
							<div class="team mx-1 my-2 ke"><span> e - emerald - 00cc00 </span></div>
							<div class="team mx-1 my-2 kf"><span> f - sky - 77aadd </span></div>
							<div class="team mx-1 my-2 wg"><span> g - green - 009900 </span></div>
							<div class="team mx-1 my-2 kh"><span> h - light blue - 00aaff </span></div>
						</div>
						<div class="col-sm-2">
							<div class="team mx-1 my-2 ki"><span> i - pink - ff9f9f </span></div>
							<div class="team mx-1 my-2 kj"><span> j - puce - aa3388 </span></div>
							<div class="team mx-1 my-2 wk"><span> k - black - 000000 </span></div>
							<div class="team mx-1 my-2 wl"><span> l - lilac - 8866ee </span></div>
							<div class="team mx-1 my-2 wm"><span> m - magenta - ff00ff </span></div>
						</div>
						<div class="col-sm-2">
							<div class="team mx-1 my-2 wn"><span> n - navy - 000099 </span></div>
							<div class="team mx-1 my-2 ko"><span> o - orange - ff9900 </span></div>
							<div class="team mx-1 my-2 wp"><span> p - purple - 660099 </span></div>
							<div class="team mx-1 my-2 wq"><span> q - maroon - 880000 </span></div>
							<div class="team mx-1 my-2 wr"><span> r - red - ff0000 </span></div>
						</div>
						<div class="col-sm-2">
							<div class="team mx-1 my-2 ks"><span> s - silver - aaaaaa </span></div>
							<div class="team mx-1 my-2 kt"><span> t - beige - d9ab4b </span></div>
							<div class="team mx-1 my-2 ku"><span> u - gold - ffcc00 </span></div>
							<div class="team mx-1 my-2 wv"><span> v - brown - aa5533 </span></div>
						</div>
						<div class="col-sm-2">
							<div class="team mx-1 my-2 kw"><span> w - white - ffffff </span></div>
							<div class="team mx-1 my-2 wx"><span> x - bordeaux - 660033 </span></div>
							<div class="team mx-1 my-2 ky"><span> y - yellow - fff00c </span></div>
							<div class="team mx-1 my-2 kz"><span> z - lime - 00ff00 </span></div>
						</div>
						</div>
						</div>
					</div>
					</div>
					<h2 class="text-center">Info</h2> <!-- Competition container -->
					<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
						<div class="container-fluid p-4">
							<?php print $Stats["Teams"]["total"]." teams in the database from ".$Stats["Nations"]["total"]." countries.<br/>\n"; ?>
							<p style="margin-top: 1rem;">
								<?php print $Stats["Colours"]["plain"]["total"]." plain designs.<br/>\n"; ?>
								<?php print $Stats["Colours"]["stripes"]["total"]." striped designs.<br/>\n"; ?>
								<?php print $Stats["Colours"]["edges"]["total"]." edged designs.<br/>\n"; ?>
								<?php print $Stats["Colours"]["bands"]["total"]." banded designs.<br/>\n"; ?>
								<?php print $Stats["Colours"]["hoops"]["total"]." hooped designs.<br/>\n"; ?>
								<?php print $Stats["Colours"]["halves"]["total"]." halved designs.<br/>\n"; ?>
								<?php print $Stats["Colours"]["offsets"]["total"]." offset designs.<br/>\n"; ?>
								<?php print $Stats["Colours"]["others"]["total"]." chequered designs.<br/>\n"; ?>
							</p>
							<p style="margin-top: 1rem;">
								<a href="./news/world.orig">See the current raw text.</a><br/>
								<a href="./news/world.txt">See the current news file.</a><br/>
							</p>
						</div>
					</div>
			</div></div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="colours" name="colours"><div class="container-fluid">
				<h1 class="text-center"> Colours </h1>
				<h2 class="text-center"> Minors (<?php print $Stats["Colours"]["minor"]["total"]; ?>) </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4"><div class="row">
					<div class="col-sm-1">
					<?php
						$the_count = 1;
						$cMn = $Stats["Colours"]["minor"]["sortedby"];
						asort($cMn);

						#=((Size+(nCol-mod))/nCol)
						$size = sizeof($cMn)-1;
						$nCol = 12;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($cMn as $N => $P) {
							print t(6)."<div class=\"team mx-1 my-2 ".$N."\"><span> ".$N." (".$Stats["Colours"]["minor"][$N].") </span></div>\n";
							if ($the_count == $colLength) {
								print t(5)."</div>\n";
								print t(5)."<div class=\"col-sm-1\">\n";
								$the_count = 0;
							}
							$the_count += 1;
						}
					?>
					</div>
				</div></div></div>
				<h2 class="text-center"> Plains (<?php print $Stats["Colours"]["plain"]["total"]; ?>) </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4"><div class="row">
					<div class="col-sm-1">
					<?php
						$the_count = 1;
						$cMn = $Stats["Colours"]["plain"]["sortedby"];
						asort($cMn);

						#=((Size+(nCol-mod))/nCol)
						$size = sizeof($cMn)-1;
						$nCol = 12;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($cMn as $N => $P) {
							print t(6)."<div class=\"team mx-1 my-2 ".$N."\"><span> ".$N." (".$Stats["Colours"]["plain"][$N].") </span></div>\n";
							if ($the_count == $colLength) {
								print t(5)."</div>\n";
								print t(5)."<div class=\"col-sm-1\">\n";
								$the_count = 0;
							}
							$the_count += 1;
						}
					?>
					</div>
				</div></div></div>
				<h2 class="text-center"> Stripes (<?php print $Stats["Colours"]["stripes"]["total"]; ?>) </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4"><div class="row">
					<div class="col-sm-1">
					<?php
						$the_count = 1;
						$cMn = $Stats["Colours"]["stripes"]["sortedby"];
						asort($cMn);

						#=((Size+(nCol-mod))/nCol)
						$size = sizeof($cMn)-1;
						$nCol = 12;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($cMn as $N => $P) {
							print t(6)."<div class=\"team mx-1 my-2 ".$N."\"><span> ".$N." (".$Stats["Colours"]["stripes"][$N].") </span></div>\n";
							if ($the_count == $colLength) {
								print t(5)."</div>\n";
								print t(5)."<div class=\"col-sm-1\">\n";
								$the_count = 0;
							}
							$the_count += 1;
						}
					?>
					</div>
				</div></div></div>
				<h2 class="text-center"> Edges (<?php print $Stats["Colours"]["edges"]["total"]; ?>) </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4"><div class="row">
					<div class="col-sm-1">
					<?php
						$the_count = 1;
						$cMn = $Stats["Colours"]["edges"]["sortedby"];
						asort($cMn);

						#=((Size+(nCol-mod))/nCol)
						$size = sizeof($cMn)-1;
						$nCol = 12;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($cMn as $N => $P) {
							print t(6)."<div class=\"team mx-1 my-2 ".$N."\"><span> ".$N." (".$Stats["Colours"]["edges"][$N].") </span></div>\n";
							if ($the_count == $colLength) {
								print t(5)."</div>\n";
								print t(5)."<div class=\"col-sm-1\">\n";
								$the_count = 0;
							}
							$the_count += 1;
						}
					?>
					</div>
				</div></div></div>
				<h2 class="text-center"> Bands (<?php print $Stats["Colours"]["bands"]["total"]; ?>) </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4"><div class="row">
					<div class="col-sm-1">
					<?php
						$the_count = 1;
						$cMn = $Stats["Colours"]["bands"]["sortedby"];
						asort($cMn);

						#=((Size+(nCol-mod))/nCol)
						$size = sizeof($cMn)-1;
						$nCol = 12;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($cMn as $N => $P) {
							if ($N == "total") {
							}
							else {
								print t(6)."<div class=\"team mx-1 my-2 ".$N."\"><span> ".$N." (".$Stats["Colours"]["bands"][$N].") </span></div>\n";
								if ($the_count == $colLength) {
									print t(5)."</div>\n";
									print t(5)."<div class=\"col-sm-1\">\n";
									$the_count = 0;
								}
								$the_count += 1;
							}
						}
					?>
					</div>
				</div></div></div>
				<h2 class="text-center"> Hoops (<?php print $Stats["Colours"]["hoops"]["total"]; ?>) </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4"><div class="row">
					<div class="col-sm-1">
					<?php
						$the_count = 1;
						$cMn = $Stats["Colours"]["hoops"]["sortedby"];
						asort($cMn);
						
						#=((Size+(nCol-mod))/nCol)
						$size = sizeof($cMn)-1;
						$nCol = 12;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($cMn as $N => $P) {
							if ($N == "total") {
							}
							else {
								print t(6)."<div class=\"team mx-1 my-2 ".$N."\"><span> ".$N." (".$Stats["Colours"]["hoops"][$N].") </span></div>\n";
								if ($the_count == $colLength) {
									print t(5)."</div>\n";
									print t(5)."<div class=\"col-sm-1\">\n";
									$the_count = 0;
								}
								$the_count += 1;
							}
						}
					?>
					</div>
				</div></div></div>
				<h2 class="text-center"> Halves (<?php print $Stats["Colours"]["halves"]["total"]; ?>) </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4"><div class="row">
					<div class="col-sm-1">
					<?php
						$the_count = 1;
						$cMn = $Stats["Colours"]["halves"]["sortedby"];
						asort($cMn);
						
						#=((Size+(nCol-mod))/nCol)
						$size = sizeof($cMn)-1;
						$nCol = 12;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($cMn as $N => $P) {
							if ($N == "total") {
							}
							else {
								print t(6)."<div class=\"team mx-1 my-2 ".$N."\"><span> ".$N." (".$Stats["Colours"]["halves"][$N].") </span></div>\n";
								if ($the_count == $colLength) {
									print t(5)."</div>\n";
									print t(5)."<div class=\"col-sm-1\">\n";
									$the_count = 0;
								}
								$the_count += 1;
							}
						}
					?>
					</div>
				</div></div></div>
				<h2 class="text-center"> Offsets (<?php print $Stats["Colours"]["offsets"]["total"]; ?>) </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4"><div class="row">
					<div class="col-sm-1">
					<?php
						$the_count = 1;
						$cMn = $Stats["Colours"]["offsets"]["sortedby"];
						asort($cMn);

						#=((Size+(nCol-mod))/nCol)
						$size = sizeof($cMn)-1;
						$nCol = 12;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($cMn as $N => $P) {
							if ($N == "total") {
							}
							else {
								print t(9)."<div class=\"team mx-1 my-2 ".$N."\"><span> ".$N." (".$Stats["Colours"]["offsets"][$N].") </span></div>\n";
								if ($the_count == $colLength) {
									print t(8)."</div>\n";
									print t(8)."<div class=\"col-sm-1\">\n";
									$the_count = 0;
								}
								$the_count += 1;
							}
						}
					?>
					</div>
				</div></div></div>
				<h2 class="text-center"> Others (<?php print $Stats["Colours"]["others"]["total"]; ?>) </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4"><div class="row">
					<div class="col-sm-1">
					<?php
						$the_count = 1;
						$cMn = $Stats["Colours"]["others"]["sortedby"];
						asort($cMn);

						#=((Size+(nCol-mod))/nCol)
						$size = sizeof($cMn)-1;
						$nCol = 12;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($cMn as $N => $P) {
							if ($N == "total") {
							}
							else {
								print t(9)."<div class=\"team mx-1 my-2 ".$N."\"><span> ".$N." (".$Stats["Colours"]["others"][$N].") </span></div>\n";
								if ($the_count == $colLength) {
									print t(8)."</div>\n";
									print t(8)."<div class=\"col-sm-1\">\n";
									$the_count = 0;
								}
								$the_count += 1;
							}
						}
					?>
					</div>
				</div></div></div>
			</div></div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="nations" name="nations"><div class="container-fluid">
				<h1 class="text-center"> Nations </h1>
				<h2 class="text-center"> Nations in order of preference </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4">
					<div class="theContent grass p-2"><div class="row">
						<div class="col-sm-2">
						<?php
							$the_count = 1;
							$NbP = $Stats["Nations"]["by_pref"];
							asort($NbP);

							#=((Size+(nCol-mod))/nCol)
							$size = sizeof($NbP);
							$nCol = 6;
							$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
							foreach ($NbP as $N => $P) {
								if ($N == "INT") {
									$TeamName = "International";
									$TeamStyle = "slate";
									$border = "";
									$flag = "";
								}
								else {
									$TeamName = $Team[$Stats["Nations"]["by_tri"][$N]]["Name"];
									$TeamStyle = $Team[$Stats["Nations"]["by_tri"][$N]]["Mjr"];
									$border = substr($Team[$Stats["Nations"]["by_tri"][$N]]["Mnr"], 0, 1);
									$flag = "<img class=\"".$border."\" src=\"flags/".$N.".png\">";
								}
								print t(7)."<div class=\"team mx-1 my-2 ".$TeamStyle."\"><span> ".$flag." ".$TeamName." (".$P.") </span></div>\n";
								if ($the_count == $colLength) {
									print t(6)."</div>\n";
									print t(6)."<div class=\"col-sm-2\">\n";
									$the_count = 0;
								}
								$the_count += 1;
							}
						?>
						</div>
					</div></div>
				</div></div>
				<h2 class="text-center"> Nations by team count </h2> <!-- Competition container -->
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody"><div class="container-fluid p-4">
					<div class="theContent grass p-2"><div class="row">
						<div class="col-sm-2">
						<?php
							$the_count = 1;
							$NbC = $Stats["Teams"];
							$size = sizeof($NbC) - 1;
							$nCol = 6;
							$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
							$cCount = Array();
							foreach ($NbC as $N => $P) {
								if ($N == "total") {
									continue;
								}
								$cCount[$N] = $Stats["Teams"][$N]["total"];
							}
							arsort($cCount);
							foreach ($cCount as $N => $P) {
								if ($N == "total") {
									continue;
								}
								$TeamName = $Team[$Stats["Nations"]["by_tri"][$N]]["Name"];
								$TeamStyle = $Team[$Stats["Nations"]["by_tri"][$N]]["Mjr"];
								$border = substr($Team[$Stats["Nations"]["by_tri"][$N]]["Mnr"], 0, 1);
								$flag = "<img class=\"".$border."\" src=\"flags/".$N.".png\">";
								$C = sizeof($Stats["Teams"][$N]["list"]);
								if ($C == 0) {
									$C = "";
								}
								else {
									$C = "(".$C.") ";
								}
								print t(7)."<div class=\"team mx-1 my-2 ".$TeamStyle."\"><span> ".$flag." ".$TeamName." ".$C."</span></div>\n";
								if ($the_count == $colLength) {
									print t(6)."</div>\n";
									print t(6)."<div class=\"col-sm-2\">\n";
									$the_count = 0;
								}
								$the_count += 1;
							}
						?>
						</div>
					</div></div>
				</div></div>
			</div></div>
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="clubs" name="clubs"><div class="container-fluid">
				<a name="top"></a><h1>Clubs</h1>
				<h2>Nations</h2>
				<div class="theContent grass p-2 mb-3">
					<div class="row">
						<div class="col-sm-2">
						<?php
						#
						# Do the menu here
						#

						$the_count = 1;
						$NbC = $Stats["Teams"];
						$size = sizeof($NbC) - 1;
						$nCol = 6;
						$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
						foreach ($NbC as $N => $P) {
							if ($N == "total") {
								continue;
							}
							$TeamName = $Team[$Stats["Nations"]["by_tri"][$N]]["Name"];
							$TeamStyle = $Team[$Stats["Nations"]["by_tri"][$N]]["Mjr"];
							$Border = substr($Team[$Stats["Nations"]["by_tri"][$N]]["Mnr"], 0, 1);
							$Flag = "<img class=\"".$Border."\" src=\"flags/".$N.".png\">";
							(sizeof($Stats["Teams"][$N]["list"])) ? $C = "(".sizeof($Stats["Teams"][$N]["list"]).")" : $C = "";
							print t(7)."<div class=\"team mx-1 my-2 ".$TeamStyle."\"><a href=\"#".$N."\"> ".$Flag." ".$TeamName." ".$C."</a></div>\n";
							if ($the_count == $colLength) {
								print t(6)."</div>\n";
								print t(6)."<div class=\"col-sm-2\">\n";
								$the_count = 0;
							}
							$the_count += 1;
						}
						?>
						</div>
					</div>
					<?php
						foreach ($NbC as $N => $V) {
							if ($N == "total") {
								continue;
							}
							$tName = $Stats["Nations"]["by_tri"][$N];
							$tLat = $Team[$tName]["Lat"];
							$tLon = $Team[$tName]["Long"];
							$tZoom = $Team[$tName]["Zom"];
							$Edge = substr($Team[$tName]["Mnr"], 0, 1);
							$Flag = "<img src=\"flags/large/".$N.".png\" class=\"".$Edge."\">";
							$TeamStyle = $Team[$tName]["Mjr"];
							$to_top = "<a href=\"#top\"><i class=\"material-icons\">arrow_upward</i></a>";
							$to_map = "<a href=\"map_page.php?lat=".$tLat."&lng=".$tLon."&z=".$tZoom."&t=".$N."&n=".$tName."\" target=\"_new\"><i class=\"material-icons\">map</i></a>";
							print t(5)."<a name=\"".$N."\"></a>\n";
							print t(5)."<p>&nbsp;</p>\n";
							print t(5)."<div class=\"theContent ".$TeamStyle." p-2 mb-3\">\n";
							print t(6)."<h3> ".$Flag." ".$Team[$tName]["Name"]." </h3>\n";
							if (sizeof($V["list"]) == 0) {
								print t(6)."<div style=\"text-align:center;\">".$to_map." | ".$to_top."</div>\n";
							}
							else {
								print t(6)."<div style=\"text-align:center;\">".sizeof($V["list"])."  <i class=\"material-icons\">person</i> | ".$to_map." | ".$to_top."</div>\n";
								print t(6)."<div class=\"theContent grass ".$Edge." p-2 mb-3\" style=\"text-shadow: 0px 0px black\">\n";
								print t(7)."<div class=\"row\">\n";
								print t(8)."<div class=\"col-sm\">\n";
								$the_count = 1;
								$nCol = 6;
								if (sizeof($V["list"]) < 12) {
									while ((sizeof($V["list"]) % $nCol) != 0) {
										array_push($V["list"], "");
									}
								}
								$size = sizeof($V["list"]) - 1;
								$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
								foreach ($V["list"] as $T) {
									if ($T == "") {
										print t(9)."<div class=\"team mx-1 my-2\"></div>\n";
									}
									else {
										$TeamStyle = $Team[$T]["Mjr"];
										$TeamName = $Team[$T]["Name"];
										print t(9)."<div class=\"team mx-1 my-2 ".$TeamStyle."\">".$TeamName."</div>\n";
									}
									if ($the_count == $colLength) {
										print t(8)."</div>\n";
										print t(8)."<div class=\"col-sm-2\">\n";
										$the_count = 0;
									}
									$the_count += 1;
								}
	
								print t(8)."</div>\n";
								print t(7)."</div>\n";
								print t(6)."</div>\n";
							}
							print t(5)."</div>\n";
						}
					?>
				</div>
			</div></div>
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="badges" name="badges"><div class="container-fluid">
				<h1 class="text-center"> Badges </h1>
				<h2 class="text-center"> Count by Nation </h2> <!-- Competition container -->
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
					<div class="container-fluid p-4">
					<div class="row">
						<div class="col-sm-2">
<?php
	$badged_nations = Array();
	foreach ($Stats["Badges"] as $N => $B) {
		if (sizeof($B["list"])) {
			array_push($badged_nations, $N);
		}
	}

	$the_count = 1;
	$size = sizeof($badged_nations);
	$nCol = 6;
	$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
	foreach ($badged_nations as $N) {
		$tRef = $Stats["Nations"]["by_tri"][$N];
		$TeamName = $Team[$tRef]["Name"]." (".sizeof($Stats["Badges"][$N]["list"]).")";
		if (preg_match("/x/", $Team[$tRef]["Badge"])) {
			$TeamStyle = $Team[$tRef]["Badge"];
		}
		else {
			$TeamStyle = $Team[$tRef]["Mjr"];
		}
		$Border = substr($Team[$tRef]["Mnr"], 0, 1);
		$Flag = "<img class=\"".$Border."\" src=\"flags/".$N.".png\">";
		print t(7)."<div class=\"team mx-1 my-2 ".$TeamStyle."\">".$Flag." ".$TeamName."</div>\n";
		if ($the_count == $colLength) {
			print t(6)."</div>\n";
			print t(6)."<div class=\"col-sm-2\">\n";
			$the_count = 0;
		}
		$the_count += 1;
	}
?>
						</div>
					</div>
					</div>
				</div>
				<h2 class="text-center"> Nations </h2> <!-- Competition container -->
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
					<div class="container-fluid p-4">
					<div class="row">
						<div class="col-sm-2">
<?php
	$nations_with_badges = Array();
	foreach ($Stats["Badges"] as $N => $B) {
		if (array_key_exists("ownbadge", $B)) {
			array_push($nations_with_badges, $N);
		}
	}

	$the_count = 1;
	$size = sizeof($nations_with_badges);
	$nCol = 6;
	$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
	foreach ($nations_with_badges as $N) {
		$tRef = $Stats["Nations"]["by_tri"][$N];
		$TeamName = $Team[$tRef]["Name"];
		$TeamStyle = $Team[$tRef]["Badge"];
		$Border = substr($Team[$tRef]["Mnr"], 0, 1);
		$Flag = "<img class=\"".$Border."\" src=\"flags/".$N.".png\">";
		print t(7)."<div class=\"team mx-1 my-2 ".$TeamStyle."\">".$Flag." ".$TeamName."</div>\n";
		if ($the_count == $colLength) {
			print t(6)."</div>\n";
			print t(6)."<div class=\"col-sm-2\">\n";
			$the_count = 0;
		}
		$the_count += 1;
	}
?>
						</div>
					</div>
					</div>
				</div>
				<h2 class="text-center"> Clubs By Nation </h2> <!-- Competition container -->
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
					<div class="container-fluid p-4">
<?php
	$clubs_by_nation = Array();
	foreach ($Stats["Badges"] as $N => $B) {
		if (sizeof($B["list"]) > 0) {
			array_push($clubs_by_nation, $N);
		}
	}

	foreach ($clubs_by_nation as $c) {
		$tRef = $Stats["Nations"]["by_tri"][$c];
		$TeamName = $Team[$tRef]["Name"];
		$TeamStyle = $Team[$tRef]["Badge"];
		$Border = substr($Team[$tRef]["Mnr"], 0, 1);
		$Flag = "<img class=\"".$Border."\" src=\"flags/large/".$c.".png\">";
		print t(7)."<h3> ".$Flag." ".$TeamName." </h3>\n";
		print t(7)."<div class=\"row\">\n";
		print t(8)."<div class=\"col-sm-2\">\n";
		$the_count = 1;
		$nCol = 6;
		if (sizeof($Stats["Badges"][$c]["list"]) < 12) {
			while ((sizeof($Stats["Badges"][$c]["list"]) % $nCol) != 0) {
				array_push($Stats["Badges"][$c]["list"], "");
			}
		}
		$size = sizeof($Stats["Badges"][$c]["list"]) - 1;
		$colLength = ($size+($nCol-($size % $nCol)))/$nCol;
		foreach ($Stats["Badges"][$c]["list"] as $T) {
			if ($T == "") {
				print t(9)."<div class=\"team mx-1 my-2\"></div>\n";
			}
			else {
				$TeamStyle = $Team[$T]["Badge"];
				$TeamName = $Team[$T]["Name"];
				print t(9)."<div class=\"team mx-1 my-2 ".$TeamStyle."\">".$TeamName."</div>\n";
			}
			if ($the_count == $colLength) {
				print t(8)."</div>\n";
				print t(8)."<div class=\"col-sm-2\">\n";
				$the_count = 0;
			}
			$the_count += 1;
		}
		print t(8)."</div>\n";
		print t(7)."</div>\n";
		print t(7)."<p>&nbsp;</p>\n";
		print t(7)."<p>&nbsp;</p>\n";
	}
?>
					</div>
				</div>
			</div></div>
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="champs" name="champs"><div class="container-fluid">
					<h1 class="text-center"> Champs </h1>
					<h2 class="text-center"> World Cup </h2> <!-- Competition container -->
					<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
						<div class="container-fluid p-4">
						</div>
					</div>
					<h2 class="text-center"> England </h2> <!-- Competition container -->
					<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
						<div class="container-fluid p-4">
						</div>
					</div>
					<h2 class="text-center"> Clubs By Nation </h2> <!-- Competition container -->
					<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
						<div class="container-fluid p-4">
						</div>
					</div>
			</div></div>
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="missing" name="missing"><div class="container-fluid">
					<h1 class="text-center"> Missing </h1>
					<h2 class="text-center"> List </h2> <!-- Competition container -->
					<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
						<div class="container-fluid p-4">
							<?php
							foreach ($the_missing as $m) {
								print $m."<br/>";
							}
							?>
						</div>
					</div>
			</div></div>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>
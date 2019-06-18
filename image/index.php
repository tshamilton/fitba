<?php
error_reporting(E_ERROR);

function pretty_var($myArray, $colour = 'ff0000') {
	echo "<div id='debug'>\n";
    print str_replace(array("\n"," "),array("<br>","&nbsp;"), var_export($myArray,true))."<br>";
	echo "</div>";
}

function t($n = 1) {
	$count = 1;
	$tabs = "";
	while ($count <= $n) {
		$tabs .= "\t";
		$count++;
	}
	return $tabs;
}

function createTeam($n, $c, $s) {
	global $Team;
	$td = "<div class=\"".$s."_team ".$Team[$n]['STY']."\">";
	if ($s == "home" && $c == "INT") {
		$td .= "<img src=\"flags/".$Team[$n]['TRI'].".png\"> ";
	}
	$td .= $Team[$n]['NOM'];
	if ($s == "away" && $c == "INT") {
		$td .= " <img src=\"flags/".$Team[$n]['TRI'].".png\">";
	}
	$td .= "</div>";
	
	return $td;
}

$DEBUG = 1;
$Team = Array();
$comp = Array();
$extras = Array();
$extras = array();
$news = array();
$data = file_get_contents("config/clubs.txt");
$c_lines = explode("\n", $data);
$data = file_get_contents("config/comps.txt");
$o_lines = explode("\n", $data);

for ($i=0;$i<count($c_lines);$i++) {
	if (strlen($c_lines[$i]) < 5) {
		continue;
	}
	$c_lines[$i] = rtrim($c_lines[$i]);
	$line = explode("|", $c_lines[$i]);
	if (preg_match("/~/", $line[4])) {
		$name_list = explode("~", $line[4]);
		foreach ($name_list as $n) {
			$Team[$n]["NOM"] = $line[1];
			$Team[$n]["STY"] = $line[2];
			$Team[$n]["TRI"] = $line[3];
		}
	}
	else {
		$n = $line[4];
		$Team[$n]["NOM"] = $line[1];
		$Team[$n]["STY"] = $line[2];
		$Team[$n]["TRI"] = $line[3];
	}
}

for ($i=0;$i<count($o_lines);$i++) {
/*
|ENG|England
INT|114|C|FA Cup|The Sponsor's FA Cup brought to you by Sponsor
INT|825575|L|Premier League|English Sponsor Premier League
 0    1    2       3            4
*/
	$o_lines[$i] = rtrim($o_lines[$i]);
	if (strlen($o_lines[$i]) < 5) {
		continue;
	}
	$line = explode("|", $o_lines[$i]);
	if ($line[0] == '') {
		$Comp[$line[1]]['NAME'] = $line[2];
	}
	else {
		$Comp[$line[0]][$line[3]]['ID'] = $line[1];
		$Comp[$line[0]][$line[3]]['TYPE'] = $line[2];
		$Comp[$line[0]][$line[3]]['NAME'] = $line[4];
	}
}

$incoming = utf8_decode(file_get_contents("http://fotmobenetpulse.s3-external-3.amazonaws.com/live2.fot"));
$page = explode("\n", $incoming);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="/tb/css/bootstrap-responsive.css" rel="stylesheet" />
	<link href="/tb/css/docs.css" rel="stylesheet" />
	<link href="css/fitba.css" rel="stylesheet" />
	<link href="css/colors.css" rel="stylesheet" />
	<link href="/tb/js/google-code-prettify/prettify.css" rel="stylesheet" />
	<link rel="apple-touch-icon" sizes="72x72" href="image/fbicon.png" />
	<link rel="icon" href="image/favicon.ico" />
	<title>Football Scores</title>
</head>
<body>
<?php

foreach ($page as $p) {
	rtrim($p);
	if (strlen($p) < 5) {
		continue;
	}
	if (preg_match("/<league/", $p)) {
		preg_match("/ccode=\"(...)\"/", $p, $mx);
		$cc = $mx[1];
		preg_match("/id=\"(\d+)\"/", $p, $mx);
		$lg_id = $mx[1];
		preg_match("/name=\"(.+?)\"/", $p, $mx);
		$news[$cc][$lg_id]['NAME'] = $mx[1];
		$news[$cc][$lg_id]['MATCHES'] = Array();
		$news[$cc][$lg_id]['LADDER'] = Array();
	}
	if (preg_match("/<match/", $p)) {
		preg_match("/id=\"(\d+)\"/", $p, $mx);		$id = $mx[1];
		preg_match("/hTeam=\"(.+?)\"/", $p, $mx);	$hTeam = $mx[1];
		preg_match("/hScore=\"(.+?)\"/", $p, $mx);	$hScore = $mx[1];
		preg_match("/aScore=\"(.+?)\"/", $p, $mx);	$aScore = $mx[1];
		preg_match("/aTeam=\"(.+?)\"/", $p, $mx);	$aTeam = $mx[1];
		preg_match("/time=\"(.+?)\"/", $p, $mx);	$time = $mx[1];
		preg_match("/sId=\"(.+?)\"/", $p, $mx);		$status2 = $mx[1];
		preg_match("/Status=\"(.+?)\"/", $p, $mx);	$status1 = $mx[1];
		array_push($news[$cc][$lg_id]['MATCHES'], $id."~".$status1."~".$status2."~".$hTeam."~".$hScore."~".$aScore."~".$aTeam."~".$time);
	}
}

?>
<div class="container-fluid"><!-- Start whole body -->
<?php
	foreach ($news as $cc => $n) {
		if (!(array_key_exists($cc, $Comp))) {
			print "<!-- $cc or $Comp[$cc]['NAME'] doesn't exist -->\n";
			array_push($extras, "|".$cc."|?");
			$country_name = $cc." <img src=\"image/alert.gif\">";
			$country_theme = "slate";
		}
		elseif ($cc == "INT") {
			$country_theme = "slate";
			$country_name = $Comp[$cc]['NAME'];
		}
		else {
			$country_name = $Comp[$cc]['NAME'];
			$country_theme = $Team[$country_name]['STY'];
		}
		echo t(1)."<div class=\"col-6\">\n";
		echo t(2)."<div class=\"comp_shell ".$country_theme."\">\n";
		echo t(3)."<h1>".$country_name."</h1>\n";
		foreach ($n as $lg_id => $lg_info) {
			if (!(array_key_exists('NAME', $lg_info))) {
				print "<!-- ".$lg_info['NAME']." or ".$Comp[$cc][$lg_id]['NAME']." doesn't exist -->\n";
				pretty_var($lg_info);
				array_push($extras, $cc."|".$lg_id."|?|".$lg_info['NAME']."|");
				$league_name = $lg_info['NAME']." <img src=\"image/alert.gif\">";
			}
			else {
				$league_name = $lg_info['NAME'];
			}
			print t(3)."<div class=\"comp_inner\">\n";
			print t(4)."<h2>".$league_name."</h2>\n";
			print t(4)."<div class=\"col-3 slate\">\n";
			foreach ($lg_info['MATCHES'] as $this_match) {
				$tm = explode("~", $this_match);
				if (strlen($Team[$tm[3]] < 3)) {
					array_push($extras, "T|||".$cc."|".$tm[3]);
				}
				if (strlen($Team[$tm[6]] < 3)) {
					array_push($extras, "T|||".$cc."|".$tm[6]);
				}
				if 		($tm[1] == "F" && $tm[2] == 6)		{ $status = "Full Time"; }
				elseif	($tm[1] == "F" && $tm[2] == 11)		{ $status = "After Extra Time"; }
				elseif	($tm[1] == "N" && $tm[2] == 1) 		{ $status = "Not started"; }
				elseif	($tm[1] == "P" && $tm[2] == 5)		{ $status = "Postponed"; }
				elseif	($tm[1] == "S" && $tm[2] == 2)		{ $status = "First Half"; }
				elseif	($tm[1] == "S" && $tm[2] == 3)		{ $status = "Second Half"; }
				elseif	($tm[1] == "S" && $tm[2] == 10)		{ $status = "Half Time"; }
				elseif	($tm[1] == "S" && $tm[2] == 13)		{ $status = "After Penalties"; }
				elseif	($tm[1] == "S" && $tm[2] == 106)	{ $status = "Cancelled"; }
				else										{ $status = "Status unknown ".$tm[1]." - ".$tm[2]; }
				print t(5)."<table align=\"center\">\n";
				print t(5)."<tr>\n";
				print t(6)."<td colspan=\"2\" class=\"date\">".$tm[7]."</td>\n";
				print t(6)."<td colspan=\"2\" class=\"state\">".$status."</td>\n";
				print t(5)."</tr>\n";
				print t(5)."<tr>\n";
				print t(6)."<td>".createTeam($tm[3], $cc, 'home')."</td>\n";
				if ($status == "Not started") {
					print t(6)."<td class=\"score\">&mdash;</td>\n";
					print t(6)."<td class=\"score\">&mdash;</td>\n";
				}
				else {
					print t(6)."<td class=\"score\">".$tm[4]."</td>\n";
					print t(6)."<td class=\"score\">".$tm[5]."</td>\n";
				}
				print t(6)."<td>".createTeam($tm[6], $cc, 'away')."</td></tr>\n";
				print t(5)."</table>\n";
			}
			print t(4)."</div>\n";
			pretty_var($Comp[$cc]);
			if ($Comp[$cc][$lg_id]['STYLE'] == "L") {
				print t(4)."<div style=\"col-3\">\n";
				print t(5)."http://fotmobenetpulse.s3-external-3.amazonaws.com/tables.ext.".$lg_id.".fot\n";
				#$in_lad = utf8_decode(file_get_contents("http://fotmobenetpulse.s3-external-3.amazonaws.com/tables.ext.".$lg_id.".fot"));
				print $ladder;
				print t(4)."</div><-- End Ladder-->\n";
			}
			print t(3)."</div>\n";
		}
		print t(3)."</div>\n";
		print t(2)."</div>\n";
		print t(1)."</div>\n";
	}
?>
</body><!--
<?php 
	if (strlen($e[0]) < 2) {
		$u = fopen("./update/".time().".txt", "a");
		foreach ($extras as $e) {
			print $e."\n";
			fwrite($u, $a);
		}
		fclose($u);
	}
?>
-->
</html>
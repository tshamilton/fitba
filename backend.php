<?php
include 'utility.php';
session_start();

function CheckName($n) {
	#pretty_var("Diagnostic: Receiving and checking '<b>".$n."</b>'");
	global $Team;

	if (array_key_exists($n, $Team)) {
		#pretty_var("Diagnostic: '<b>".$n."</b>' passes", 'ffffff');
		return true;
	}
	elseif (preg_match("/w$/", $n)) {
		#pretty_var("Diagnostic: '<b>".$n."</b>' is women's team?");
		$tn = substr($n, 0, -1);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	elseif (preg_match("/q$/", $n)) { 
		#pretty_var("Diagnostic: '<b>".$n."</b>' is women's team (DEN)?");
		$tn = substr($n, 0, -1);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	elseif (preg_match("/qw$/", $n)) { 
		#pretty_var("Diagnostic: '<b>".$n."</b>' is women's team (DEN)?");
		$tn = substr($n, 0, -2);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	elseif (preg_match("/ii$/", $n)) {
		#pretty_var("Diagnostic: '<b>".$n."</b>' is reserve 'ii' team?");
		$tn = substr($n, 0, -2);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	elseif (preg_match("/fc$/", $n)) {
		#pretty_var("Diagnostic: '<b>".$n."</b>' is 'fc' team?");
		$tn = substr($n, 0, -2);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	elseif (preg_match("/^jong/", $n)) {
		#pretty_var("Diagnostic: '<b>".$n."</b>' is youth 'jong' team?");
		$tn = substr($n, 4);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	elseif (preg_match("/academy$/", $n)) {
		#pretty_var("Diagnostic: '<b>".$n."</b>' is youth 'academy' team?");
		$tn = substr($n, 0, -7);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	elseif (preg_match("/primavera$/", $n)) {
		#pretty_var("Diagnostic: '<b>".$n."</b>' is youth 'primavera' team?");
		$tn = substr($n, 0, -9);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	elseif (preg_match("/u(\d{2})$/", $n)) {
		#pretty_var("Diagnostic: '<b>".$n."</b>' is age-limited team?");
		$tn = substr($n, 0, -3);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	elseif (preg_match("/[a|b|2|3]$/", $n)) {
		#pretty_var("Diagnostic: '<b>".$n."</b>' is reserve (ab23) team?", '00ff00');
		$tn = substr($n, 0, -1);
		if (CheckName($tn)) { return true; } else { return false; }
	}
	else {
		#pretty_var("Team: Unknown Team- '<b>".$n."</b>'");
		return false;
	}
}
function doAgg($score, $res, $hS, $aS, $hC, $aC, $hN, $aN) { //agg score, agg result for home team, score, colours, names
	global $Team;

	$S = explode("-", $score);

	if (array_key_exists($hN, $Team)) { $hN = $Team[$hN]["Name"]; }
	if (array_key_exists($aN, $Team)) { $aN = $Team[$aN]["Name"]; }

	$S[0] += 0;
	$S[1] += 0;

	if ($res == "") {
		return "<div class=\"text-center matchAggregate ".$hC."\">Currently ".$score." on aggregate.</div>";
	}
	if ($S[0] > $S[1]) {
		return "<div class=\"text-center matchAggregate ".$hC."\">".$hN." win ".$score." on aggregate.</div>";
	}
	elseif ($S[0] < $S[1]) {
		return "<div class=\"text-center matchAggregate ".$aC."\">".$aN." win ".$score." on aggregate.</div>";
	}
	else {
		// aaaaand so to away goal calculations. A 3(2) v (3)3 B - B wins on away goals. C 0(1) v (1)0 D - C wins on away goals.
		$hAwayGoals = abs($S[0] - $hS);
		$aAwayGoals = $aS+0;

		if (($hAwayGoals-$aAwayGoals) > 0) {
			return "<div class=\"text-center matchAggregate ".$hC."\">".$hN." win ".$score." on away goals (".$hAwayGoals." vs ".$aAwayGoals.").</div>";
		}
		elseif (($hAwayGoals-$aAwayGoals) < 0) {
			return "<div class=\"text-center matchAggregate ".$aC."\">".$aN." win ".$score." on away goals (".$hAwayGoals." vs ".$aAwayGoals.").</div>";
		}
		else {
			return "<div class=\"text-center matchAggregate ".$hC."\">Penalties. Discuss.</div>";
		}
	}
}
function doCompetitions($c, $n) { // Country trigram, News for Country
	global $Comp;
	global $News;
	$oComp = Array();

	foreach ($n[$c] as $cN => $matchList) { // Order individual competitons by 'order' attribute
		if (array_key_exists($cN, $Comp[$c]["Comps"])) {
			$ord = $Comp[$c]["Comps"][$cN]["Order"];
			$oComp[$cN] = $ord;
		}
		else {
			$Comp[$c]["Comps"][$cN]["Type"] = "C";
			$Comp[$c]["Comps"][$cN]["Order"] = 9999;
			$Comp[$c]["Comps"][$cN]["Name"] = "<img src=\"image/alert.gif\"> ".$cN;
			$ord = $Comp[$c]["Comps"][$cN]["Order"];
			$oComp[$cN] = $ord;
		}
	}
	asort ($oComp);

	foreach ($oComp as $name => $orderVal) {
		$cTitle = $Comp[$c]["Comps"][$name]["Name"];
		$cType = $Comp[$c]["Comps"][$name]["Type"];
		print t(5)."<h2 class=\"text-center\">".$cTitle."</h2> <!-- Competition container -->\n";
		print t(5)."<div class=\"d-flex justify-content-center clearfix my-3 darkSlate theCompBody\">\n";
		print t(6)."<div class=\"container-fluid p-4\">\n";
		if ($cType == "L") {
			$lad = doLadder($c, $name);
			print $lad;
		}
		foreach ($News[$c][$name] as $thisC) {
			doMatch($thisC, $c, $cType);
		}
		print t(6)."</div>\n";
		print t(5)."</div>\n";
	}
}
function doDetails($eventList, $subList, $hC, $aC) {
	$tie = 0;

	$eventList = iconv("ISO-8859-1", "utf-8", $eventList);
	$subList   = iconv("ISO-8859-1", "utf-8", $subList);
	if ($eventList == '') { $e = Array(); }
	else { 
		if ((preg_match("/\#$/", $eventList))) { $eventList = substr($eventList, 0, -1); }
		$e = explode("#", $eventList);
	}
	if ($subList == '') { $s = Array(); }
	else {
		if ((preg_match("/\#$/", $subList))) { $subList = substr($subList, 0, -1); }
		$s = explode("#", $subList);
	}
	$safety = sizeof($e) + sizeof($s);

	while ((sizeof($e) + sizeof($s)) > 0) {
		$c_e = Array(); $c_e[0] = 200;
		$c_s = Array(); $c_s[0] = 200;
		if (sizeof($e) > 0) { $c_e = explode("~", $e[0]); }
		if (sizeof($s) > 0) { $c_s = explode("~", $s[0]); }
		if ($c_e[0] < $c_s[0] || empty($s)){
			$this_e = MakeDetails($e[0], $hC, $aC, 'e');
			print t(8)."<tr>".$this_e."</tr>\n";
			array_shift($e);
		}
		if ($c_s[0] < $c_e[0] || empty($e)) {
			if (!empty($s)) {
				$this_s = MakeDetails($s[0], $hC, $aC, 's');
				print t(8)."<tr>".$this_s."</tr>\n";
				array_shift($s);
			}
		}
		if ($c_e[0] == $c_s[0]) {
			if ($c_e[0] == 200) { break; }
			if ($tie == 0) {
				$tie = 1;
				$this_e = MakeDetails($e[0], $hC, $aC, 'e');
				print t(8)."<tr>".$this_e."</tr>\n";
				array_shift($e);
			}
			else {
				$tie = 0;
				$this_s = MakeDetails($s[0], $hC, $aC, 's');
				print t(8)."<tr>".$this_s."</tr>\n";
				array_shift($s);
			}
		}
		$safety--;
		if ($safety < 0) {
			break;
		}
	}
}
function doFlag($s, $c) { // Style (minor), Country (trig)
	return "<img class=\"".$s." flag\" src=\"flags/".$c.".png\">";
}
function doLadder ($c, $n) { // Country trigram, Competition Name
	global $Team;
	global $Comp;
	global $Nations;
	$_SESSION['T'] = $Team;
	
	$table_body = Array();
	$points_Lt = Array();
	$points_Ln = Array();
	$maxLt = 0;
	$maxLn = 0;
	$minLt = 0;
	$minLn = 0;
	$tBC_z = 7;

	if ($c != "INT") {
		$nat = $Nations[$c];
		$tBC_lt = $Team[$nat]["Lat"];
		$tBC_ln = $Team[$nat]["Long"];
	}

	$fileN = "news/ladder/".$c.$n.".lad";

	if (file_exists($fileN)) {
		$ladder	= file($fileN, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach ($ladder as $t) {
			$p = explode("|", $t);
			if ($p[0] == "group") {
				if ($p[1] == "mls")						{	continue;	}
				elseif ($p[1] == "uslchampionship")		{	$p[1] = "USL Championship";		array_push($table_body, t(8)."<tr><th colspan='10' class=\"text-center py-2\">".$p[1]."</th></tr>\n");	}
				elseif ($p[1] == "Eastern")				{	$p[1] = "Eastern Conference";	array_push($table_body, t(8)."<tr><th colspan='10' class=\"text-center py-2\">".$p[1]."</th></tr>\n");	}
				elseif ($p[1] == "Western")				{	$p[1] = "Western Conference";	array_push($table_body, t(8)."<tr><th colspan='10' class=\"text-center py-2\">".$p[1]."</th></tr>\n");	}
				elseif ($p[1] == "SupportersShield")	{	$p[1] = "Supporter's Shield";	array_push($table_body, t(8)."<tr><th colspan='10' class=\"text-center py-2\">".$p[1]."</th></tr>\n");	}
			}
			else {
				array_push($points_Ln, $Team[$p[0]]["Long"]);
				array_push($points_Lt, $Team[$p[0]]["Lat"]);
				#   0   1 2 3 4 5 6 7   8
				#canada|1|0|0|1|0|3|D|QUAL
				$pl = $p[1]+$p[2]+$p[3];
				$gd = $p[4]-$p[5];
				$fate = "";
				if (sizeof($p) == 8) { array_push($p, "X"); }
				switch ($p[8]) {
					case "X":			$fate = "";					$style = "ldrdata";				break;
					case "UCL":			$fate = "UCL";				$style = "ucl ldrdata";			break;
					case "COPALIB":		$fate = "Copa Lib.";		$style = "ucl ldrdata";			break;
					case "UCLQ":		$fate = "UCL Qual.";		$style = "uclqual ldrdata";		break;
					case "COPALIBQ":	$fate = "Copa Lib Q";		$style = "uclqual ldrdata";		break;
					case "EL":			$fate = "UEL";				$style = "eurolg ldrdata";		break;
					case "ELQ":			$fate = "UEL Qual.";		$style = "eurolgqual ldrdata";	break;
					case "COPASUD":		$fate = "Copa Sud. Qual.";	$style = "eurolg ldrdata";		break;
					case "ELQP":		$fate = "UEL Playoffs";		$style = "eurolgqual ldrdata";	break;
					case "PROMOTED":	$fate = "&uarr; ";			$style = "promotion ldrdata";	break;
					case "QUAL":		$fate = "Qualified";		$style = "promotion ldrdata";	break;
					case "FINALS":		$fate = "Finals";			$style = "promotion ldrdata";	break;
					case "NEXTPOS":		$fate = "Playoffs";			$style = "uclqual ldrdata";		break;
					case "RELEGATED":	$fate = "&darr; ";			$style = "relegation ldrdata";	break;
					case "PRPLAYOFF":	$fate = "Prom. Playoff";	$style = "promotion ldrdata";	break;
					case "RLPLAYOFF":	$fate = "Rel. Playoff";		$style = "relegation ldrdata";	break;
					default:			$fate = $p[8];				$style = "unknown ldrdata";		break;
				}
				$team = "<td class=\"ldrTeam\">".doTeam($p[0], $c, 'l')."</td>";
				$games = "<td class=\"".$style."\">".$pl."</td><td class=\"".$style."\">".$p[1]."</td><td class=\"".$style."\">".$p[2]."</td><td class=\"".$style."\">".$p[3]."</td>";
				$goals = "<td class=\"".$style."\">".$p[4]."</td><td class=\"".$style."\">".$p[5]."</td><td class=\"".$style."\">".$gd."</td>";
				$pts_fate = "<td class=\"".$style."\"><b>".$p[6]."</b></td><td class=\"text-center ".$style."\">".$fate."</td>";
				array_push($table_body, t(8)."<tr>".$team.$games.$goals.$pts_fate."</tr>\n");
			}
		}
		$maxLt = max($points_Lt);
		$minLt = min($points_Lt);
		$maxLn = max($points_Ln);
		$minLn = min($points_Ln);
		$tBC_lt = $minLt + (($maxLt - $minLt) / 2);
		$tBC_ln = $minLn + (($maxLn - $minLn) / 2);
		$map_link = "<a href=\"http://tshamilton.com/fitba/map_page.php?lat=".$tBC_lt."&lng=".$tBC_ln."&z=".$tBC_z."&t=t".$c."&n=".$n."\" target=\"_new\"><i class=\"material-icons\">map</i></a>";
		$table_header = t(7)."<div class=\"float-right col-6\">\n";
		$table_header .= t(8)."<table class=\"ladder table table-sm align-middle\"><tbody>\n";
		$table_header .= t(8)."<tr><th>&nbsp;</th><th class=\"lStat\">Pl</th><th class=\"lStat\">W</th><th class=\"lStat\">D</th><th class=\"lStat\">L</th><th class=\"lStat\">GF</th><th class=\"lStat\">GA</th><th class=\"lStat\">GD</th><th class=\"lStat\">Pts</th><th>".$map_link."</th></tr>\n";
		$table_footer = t(8)."</tbody></table>\n".t(7)."</div>\n";
		$table_body_string = join("", $table_body);
		return $table_header.$table_body_string.$table_footer;
	}
	else {
		return "<b><i>NB: Ladder currently unavailable</i></b><br/>\n";
	}
}
function doMatch($match, $c, $t) { //Match, Country, Type
	global $Team;
	#   0         1        2         3         4        5        6       7       8         9        10      11      12      13       14          15        16
	#match_id|homeTeam|homeScore|awayScore|awayTeam|matchDay|timeStamp|status|aggScore|aggHomeRes|penHome|penAway|coaches|venue|matchDetails|substitutes|trivia

	$m = explode("|", $match);
	if ($m[10] > 0 && $m[11]) {
		$hSco = $m[2] - $m[10];
		$aSco = $m[3] - $m[11];
		$m[2] = $hSco." (".$m[10].")";
		$m[3] = "(".$m[11].") ".$aSco;
	}
	list($theHTeam, $hCol) = doTeam($m[1], $c, 'h');
	list($theATeam, $aCol) = doTeam($m[4], $c, 'a');

	print t(7)."<div class=\"col-6 float-left px-3 pb-4 theMatchBody\">\n";
	print t(8)."<table width=\"100%\" class=\"matchFrame\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";

	# Row 1 -> Time, Stage and Status
	$theTime = "<td colspan=\"8\">".doMatchTime($m[6], $hCol)."</td>";
	$theStage = "<td colspan=\"4\">".doMatchStage($m[5], $hCol)."</td>";
	$theStatus = "<td colspan=\"8\">".doMatchStatus($m[7], $hCol)."</div></td>";
	print t(8)."<tr>".$theTime.$theStage.$theStatus."</tr>\n";

	# Row 2 -> Venue
	if ($m[13] != "") {	$theVenue = doMatchVenue($m[13], $hCol);	print t(8)."<tr><td colspan=\"20\">".$theVenue."</td></tr>\n";	}

	# Row 3 -> Teams and score
	$theHScore = doScore($m[2], $hCol);
	$theAScore = doScore($m[3], $aCol);
	$theScore = "<td colspan=\"2\"><div class=\"m-2 score ".$hCol."\">".$theHScore."</div></td><td colspan=\"2\"><div class=\"m-2 score ".$aCol."\">".$theAScore."</div></td>";
	print t(8)."<tr><td colspan=\"8\">".$theHTeam."</td>".$theScore."<td colspan=\"8\">".$theATeam."</td></tr>\n";

	# Row 4 -> Spacer row
	print t(8)."<tr>"; for ($x = 0; $x < 20; $x++) { print "<td width=\"5%\"></td>"; } print "</td></tr>\n";

	# Row 5 -> Match details
	if ($m[14] != "" || $m[15] != "") {
		doDetails($m[14], $m[15], $hCol, $aCol);
	}

	# Row 6 -> Aggregate score
	if ($m[8] != "") {
		print t(8)."<tr><td colspan=\"20\">".doAgg($m[8], $m[9], $m[2], $m[3], $hCol, $aCol, $m[1], $m[4])."</td></tr>\n";
	}

	// # Row 7 -> Coaches
	if ($m[12] != "") {
		list($Ch, $Ca) = doCoaches($m[12], $hCol, $aCol);
		print t(8)."<tr><td colspan=\"10\">".$Ch."</td><td colspan=\"10\">".$Ca."</td></tr>\n";
	}

	# Row 8 -> Facts
	if ($m[16] != "") {
		print t(8)."<tr><td colspan=\"20\">".doTrivia($m[16], $hCol)."</td></tr>";
	}

	# Row 9 -> bottom Spacer
	print t(8)."<tr><td colspan=\"20\" class=\"matchBottom ".$hCol."\"></td></tr>\n";
	print t(8)."</table>\n";
	print t(7)."</div>\n";
}
function doCoaches($mgrs, $h, $a) {
	list($ch, $ca) = explode("~", $mgrs);
	$mh = explode(":", $ch);
	$ma = explode(":", $ca);
	if (strlen($mh[1]) > 2) { $mhf = doFlag(substr($h, 0, 1), $mh[1]); } else { $mhf = ""; }
	if (strlen($ma[1]) > 2) { $maf = doFlag(substr($a, 0, 1), $ma[1]); } else { $maf = ""; }

	$rh = "<div class=\"matchCoach ".$h."\">".$mhf." ".$mh[0]."</div>";
	$ra = "<div class=\"matchCoach ".$a."\">".$ma[0]." ".$maf."</div>";

	return array($rh, $ra);
}
function doMatchStage($stage, $s) { //stage, style

	if		($stage == "1/16")		{	$stage = "Round of 32";			}
	elseif	($stage == "1/8")		{	$stage = "Round of 16";			}
	elseif	($stage == "1/4")		{	$stage = "Quarter Finals";		}
	elseif	($stage == "1/2")		{	$stage = "Semi Finals";			}
	elseif	($stage == "bronze")	{	$stage = "3rd Place Match";		}
	elseif	($stage == "final")		{	$stage = "The Final";			}
	else							{	$stage = "Matchday ".$stage;	}
	return "<div class=\"matchStage ".$s."\">".$stage."</div>";
}
function doMatchStatus($st, $s) { //status, style
	return "<div class=\"pr-2 matchStatus ".$s."\">".MakeStatus($st)."</div>";
}
function doMatchTime($mt, $s) { //match time, home team minor style
	return "<div class=\"pl-2 matchTime ".$s."\">".$mt."</div>";
}
function doMatchVenue($v, $s) { // venue, style
	return "<div class=\"matchVenue ".$s."\">".$v."</div>";
}
function doNations($n) { // news
	global $Team;
	global $Comp;
	global $tablist;

	foreach ($tablist as $c => $v) {
		if ($c == "INT") {
			$cTitle = "International Competitions";
			$cStyle = "slate";
			$flag = "";
		}
		else {
			$cTitle = $Comp[$c]["Name"];
			$cStyle = $Team[$Comp[$c]["ID"]]["Mjr"];
			$flag = " <img class=\"".substr($Team[$Comp[$c]["ID"]]["Mnr"], 0, 1)."\" src=\"flags/large/".$c.".png\">";
		}
		print t(3)."<div role=\"tabpanel\" class=\"tab-pane container-fluid fade theNation ".$cStyle."\" id=\"".$c."\" name=\"".$c."\"> <!--National container -->\n";
		print t(4)."<div class=\"container-fluid\">\n";
		print t(5)."<h1 class=\"text-center\">".$flag." ".$cTitle."</h1>\n";
		doCompetitions($c, $n);
		print t(4)."</div>\n";
		print t(3)."</div>\n";	  
	}
}
function doScore($sc, $s) { // score, style
	return "<div><b> ".$sc." </b></div>";
}
function doTabs($tabs) {
	global $Nations;
	global $missing;
	global $Team;

	foreach ($tabs as $t => $v) {
		if ($t == "INT") {
			print t(4)."<li class=\"nav-item slate\"><a role=\"nav-link\" data-toggle=\"pill\" style=\"color:inherit; text-decoration: inherit;\" href=\"#INT\"> International </a></li>\n";
		}
		else {
			if ($t == "MKD") {
				$t = "NMK";
			}
			print "<!-- ".$t." -->\n";
			$n = $Nations[$t];
			print t(4)."<li class=\"nav-item ".$Team[$n]["Mjr"]."\"><a role=\"nav-link\" data-toggle=\"pill\" href=\"#".$t."\">".doFlag(substr($Team[$n]["Mjr"], 2, 1), $t)." ".$Team[$n]["Name"]."</a></li>\n";
		}
	}
}
function doTeam($t, $c, $s = 'h') { //Team Name, Competition Country (trig, used as test for INT comps), Side (home/away)
	global $Team;

	$tName = "";
	$tStyle = "";
	$tIdent = "";

	if (array_key_exists($t, $Team)) {
		$tIdent = $t;
		$tName = $Team[$tIdent]["Name"];
		$tStyle = $Team[$tIdent]["Badge"] != "" ? $Team[$tIdent]["Badge"] : $Team[$tIdent]["Mjr"];
		$Flag = doFlag(substr($Team[$tIdent]["Mjr"], 2, 1), $Team[$tIdent]["Tri"]);
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/fcw$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		$status = "women";
		$tIdent = substr($t, 0, -3);
		$tStyle = $Team[$tIdent]["Badge"] != "" ? $Team[$tIdent]["Badge"] : $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." <b>&#9792;</b>";
		$Flag = doFlag(substr($Team[$tIdent]["Mjr"], 2, 1), $Team[$tIdent]["Tri"]);
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/qw$/", $t)) && (array_key_exists(substr($t, 0, -2), $Team))) {
		$status = "women";
		$tIdent = substr($t, 0, -2);
		$tStyle = $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." II";
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/w$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		$status = "women";
		$tIdent = substr($t, 0, -1);
		$tStyle = $Team[$tIdent]["Badge"] != "" ? $Team[$tIdent]["Badge"] : $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." <b>&#9792;</b>";
		$Flag = doFlag(substr($Team[$tIdent]["Mjr"], 2, 1), $Team[$tIdent]["Tri"]);
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/q$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		$status = "women";
		$tIdent = substr($t, 0, -1);
		$tStyle = $Team[$tIdent]["Badge"] != "" ? $Team[$tIdent]["Badge"] : $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." <b>&#9792;</b>";
		$Flag = doFlag(substr($Team[$tIdent]["Mjr"], 2, 1), $Team[$tIdent]["Tri"]);
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/a$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		$status = "a-side";
		$tIdent = substr($t, 0, -1);
		$tStyle = $Team[$tIdent]["Badge"] != "" ? $Team[$tIdent]["Badge"] : $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." 'A'";
		$Flag = doFlag(substr($Team[$tIdent]["Mjr"], 2, 1), $Team[$tIdent]["Tri"]);
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/b$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		$status = "b-side";
		$tIdent = substr($t, 0, -1);
		$tStyle = $Team[$tIdent]["Badge"] != "" ? $Team[$tIdent]["Badge"] : $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." 'B'";
		$Flag = doFlag(substr($Team[$tIdent]["Mjr"], 2, 1), $Team[$tIdent]["Tri"]);
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/2$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		$status = "2-side";
		$tIdent = substr($t, 0, -1);
		$tStyle = $Team[$tIdent]["Badge"] != "" ? $Team[$tIdent]["Badge"] : $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." 2";
		$Flag = doFlag(substr($Team[$tIdent]["Mjr"], 2, 1), $Team[$tIdent]["Tri"]);
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/3$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		$status = "3-side";
		$tIdent = substr($t, 0, -1);
		$tStyle = $Team[$tIdent]["Badge"] != "" ? $Team[$tIdent]["Badge"] : $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." 3";
		$Flag = doFlag(substr($Team[$tIdent]["Mjr"], 2, 1), $Team[$tIdent]["Tri"]);
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/ii$/", $t)) && (array_key_exists(substr($t, 0, -2), $Team))) {
		$status = "ii-side";
		$tIdent = substr($t, 0, -2);
		$tStyle = $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." II";
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/fc$/", $t)) && (array_key_exists(substr($t, 0, -2), $Team))) {
		$status = "fc-side";
		$tIdent = substr($t, 0, -2);
		$tStyle = $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." II";
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/^jong/", $t)) && (array_key_exists(substr($t, 4), $Team))) {
		$status = "jong";
		$tIdent = substr($t, 4);
		$tStyle = $Team[$tIdent]["Mjr"];
		$tName = "Jong ".$Team[$tIdent]["Name"];
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/academy$/", $t)) && (array_key_exists(substr($t, 0, -7), $Team))) {
		$status = "academy";
		$tIdent = substr($t, 0, -7);
		$tStyle = $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." Academy";
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/primavera$/", $t)) && (array_key_exists(substr($t, 0, -9), $Team))) {
		$status = "primavera";
		$tIdent = substr($t, 0, -9);
		$tStyle = $Team[$tIdent]["Mjr"];
		$tName = $Team[$tIdent]["Name"]." Primavera";
		$mnr = $Team[$tIdent]["Mnr"];
	}
	elseif ((preg_match("/u(\d{2})$/", $t, $age)) && (array_key_exists(substr($t, 0, -3), $Team))) {
		$status = "agelimit";
		$tIdent = substr($t, 0, -3);
		$tStyle = $Team[$tIdent]["Mjr"];
		$Flag = doFlag(substr($Team[$tIdent]["Mjr"], 2, 1), $Team[$tIdent]["Tri"]);
		$tName = $Team[$tIdent]["Name"]." Under-".$age[1];
		$mnr = $Team[$tIdent]["Mnr"];
	}
	else {
		$tIdent = $t;
		$tName = "<img src=\"image/alert.gif\"> ".$t;
		$tStyle = "";
		$Flag = "";
		$mnr = "darkSlate";
		missing("T:".$c.":".$t);
	}

	if ($c == "INT") {
		$tName = $s == 'h' ? $Flag." ".$tName : $tName." ".$Flag;
	}

	if ($s == "h" || $s == "a") {
		return array("<div class=\"m-2 team ".$tStyle."\">".$tName."</div>", $mnr);
	}
	else {
		return "<div class=\"m-2 team ".$tStyle."\">".$tName."</div>";
	}
}
function doTrivia ($triv, $h) {
	$t = explode("~", $triv);
	if (sizeof($t) > 2) {
		 shuffle($t);
		 iconv("ISO-8859-1", "utf-8", $t[0]);
		 iconv("ISO-8859-1", "utf-8", $t[1]);
		 return "<div class=\"matchTrivia ".$h."\">".$t[0]."<br/>".$t[1]."</div>";
	}
	else {
		return "<div class=\"matchTrivia ".$h."\">".$t[0]."<br/>".$t[1]."</div>";
	}


}
function MakeDetails($e, $h, $a, $s) { //event, hcol, acol, switch (e for event, s for sub)
	$blank = "<td colspan=\"9\">&nbsp;</td>";
	$goal = "<span class=\"goal\">&#9917;</span>";
	$yellow = "<img src=\"image/yellow.gif\">";
	$yellow2 = "<img src=\"image/yellow-red.gif\">";
	$red = "<img src=\"image/red.gif\">";
	$off = "<span class=\"suboff\">&#8603;</span>";
	$on = "<span class=\"subon\">&#8602;</span>";

	$rv = $e;
	$ev = explode("~", $e);
	if ($s == "e"){
		if ($ev[3] != "0" && ($ev[0] == 45 || $ev[0] == 90))	{	$ev[0] .= "(+".$ev[3]."')"; } # minutes into extra time

		if ($ev[4] == "7") 		{	$bleh = 0; } 			# Normal goal - ignore
		elseif ($ev[4] == "8")	{	$ev[1] .= " (P)"; } 	# Penalty
		elseif ($ev[4] == "9")	{	$bleh = 0; } 			# 1st yellow card - ignore
		elseif ($ev[4] == "10")	{	$ev[1] .= " (OG)"; }	# Own goal
		elseif ($ev[4] == "11") {	$bleh = 0; }			# Penalty shootout
		elseif ($ev[4] == "12") {	$bleh = 0; }			# Penalty shootout
		elseif ($ev[4] == "14")	{	$bleh = 0; } 			# Penalty goal - ignore
		elseif ($ev[4] == "15") {	
			if ($ev[2] == "awayred") { $ev[2] == "away2yellow"; }
			elseif ($ev[2] == "homered") { $ev[2] == "home2yellow"; }
		}
		elseif ($ev[4] == "16") { $bleh = 0; } # Straight Red

		elseif ($ev[4] == "18")	{ 	$bleh = 0; } # Normal goal (AET?) - ignore
		else {
			$ev[1] .= "(".$ev[3]."~".$ev[4].")";
		}

		if ($ev[2] == "homegoal") {
			$hEv = "<div class=\"homeevent ".$h."\"><b>".$ev[1]." ".$goal."</b></div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\"><b><div class=\"htimeevent ".$h."\">".$ev[0]."</div></b></td>".$blank."</tr>";
		}
		elseif ($ev[2] == "awaygoal") {
			$aEv = "<b><div class=\"awayevent ".$a."\">".$goal." ".$ev[1]."</div></b>";
			$rv = "<tr>".$blank."<td colspan=\"2\"><b><div class=\"atimeevent ".$a."\">".$ev[0]."</div></b></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "homenogoal") {
			$hEv = "<div class=\"homeevent ".$h."\"><b>".$ev[1]." (Pen Miss)</b></div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\"><b><div class=\"htimeevent ".$h."\">".$ev[0]."</div></b></td>".$blank."</tr>";
		}
		elseif ($ev[2] == "awaynogoal") {
			$aEv = "<b><div class=\"awayevent ".$a."\">(Pen Miss) ".$ev[1]."</div></b>";
			$rv = "<tr>".$blank."<td colspan=\"2\"><b><div class=\"atimeevent ".$a."\">".$ev[0]."</div></b></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "homeyellow") {
			$hEv = "<div class=\"homeevent ".$h."\">".$ev[1]." ".$yellow."</div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\"><b><div class=\"htimeevent ".$h."\">".$ev[0]."</div></b></td>".$blank."</tr>";
		}
		elseif ($ev[2] == "awayyellow") {
			$aEv = "<div class=\"awayevent ".$a."\">".$yellow." ".$ev[1]."</div>";
			$rv = "<tr>".$blank."<td colspan=\"2\"><div class=\"atimeevent ".$a."\">".$ev[0]."</div></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "home2yellow") {
			$hEv = "<div class=\"homeevent ".$h."\">".$ev[1]." ".$yellow2."</div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\"><b><div class=\"htimeevent ".$h."\">".$ev[0]."</div></b></td>".$blank."</tr>";
		}
		elseif ($ev[2] == "away2yellow") {
			$aEv = "<div class=\"awayevent ".$a."\">".$yellow2." ".$ev[1]."</div>";
			$rv = "<tr>".$blank."<td colspan=\"2\"><div class=\"atimeevent ".$a."\">".$ev[0]."</div></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "homered") {
			$hEv = "<div class=\"homeevent ".$h."\">".$ev[1]." ".$red."</div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\"><b><div class=\"htimeevent ".$h."\">".$ev[0]."</div></b></td>".$blank."</tr>";
		}
		elseif ($ev[2] == "awayred") {
			$aEv = "<div class=\"awayevent ".$a."\">".$red." ".$ev[1]."</div>";
			$rv = "<tr>".$blank."<td colspan=\"2\"><div class=\"atimeevent ".$a."\">".$ev[0]."</div></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "homeassist") {	$rv = ""; }
		elseif ($ev[2] == "awayassist") {	$rv = ""; }
		else {	$rv = "<tr><td colspan=\"20\">".$e."</td></tr>"; }
	}
	elseif ($s == "s") {
		if ($ev[1] == "a") {
			$aEv = "<div class=\"px-2 awayevent ".$a."\">".$ev[2]." <span class=\"subon\">&#8602;</span> <div class=\"float-right\"><span class=\"suboff\">&#8603;</span> ".$ev[3]."</div> </div>";
			$rv = $blank."<td colspan=\"2\"><div class=\"atimeevent ".$a."\">".$ev[0]."</div></td><td colspan=\"9\">".$aEv."</td>";
		}
		elseif ($ev[1] == "h") {
			$hEv = "<div class=\"px-2 homeevent ".$h."\"><div class=\"float-left\">".$ev[3]." <span class=\"suboff\">&#8603;</span></div> <span class=\"subon\">&#8602;</span> ".$ev[2]."</div>";
			$rv = "<td colspan=\"9\">".$hEv."</td><td colspan=\"2\"><div class=\"htimeevent ".$h."\">".$ev[0]."</div></td></td>".$blank;
		}
	}

	return $rv;
}
function MakeStatus($s) {
	$st = explode("-", $s);
	if 		($st[0] == "F") {
		if 		($st[1] == 5)	{ return "Postponed"; }
		elseif	($st[1] == 6)	{ return "Full Time"; }
		elseif	($st[1] == 11)	{ return "After Extra Time"; }
		elseif	($st[1] == 13)	{ return "After Penalties"; }
		elseif	($st[1] == 17)	{ return "Abandoned"; }
		elseif	($st[1] == 93)	{ return "Resume Postponed Match"; }
		elseif	($st[1] == 106)	{ return "Cancelled"; }
		else					{ missing("S:".$s); return "Status unknown (".$s.")"; }
	}
	elseif	($st[0] == "N") {
		if 		($st[1] == 1) 	{ return "Not started"; }
		else					{ missing("S:".$s); return "Status unknown (".$s.")"; }
	}
	elseif	($st[0] == "P") {
		if		($st[1] == 5)	{ return "Postponed"; }
		else					{ missing("S:".$s); return "Status unknown (".$s.")"; }
	}
	elseif	($st[0] == "S") {
		if		($st[1] == 2)	{ return "First Half"; }
		elseif	($st[1] == 3)	{ return "Second Half"; }
		elseif	($st[1] == 4)	{ return "Penalty Shootout"; }
		elseif	($st[1] == 8)	{ return "Extra Time Break"; }
		elseif	($st[1] == 9)	{ return "Extra Time"; }
		elseif	($st[1] == 10)	{ return "Half Time"; }
		elseif	($st[1] == 13)	{ return "After Penalties"; }
		elseif	($st[1] == 17)	{ return "Abandoned"; }
		elseif	($st[1] == 18)	{ return "Kick-Off"; }
		elseif	($st[1] == 106)	{ return "Cancelled"; }
		elseif	($st[1] == 190)	{ return "Full Time"; }
		else					{ missing("S:".$s); return "Status unknown ".$st[0]." - ".$st[1]; }
	}
	else {
		missing("S:".$s);
		return "Status unknown ".$st[0]." - ".$st[1];
	}
}
function missing($in) {
	global $missing;
	print "<!-- $in -->\n";
	$outM = "\n".date("Y/m/d H:i")."\n";

	if ($in == "Send") {
		if (sizeof($missing) > 0) {
			$mFile = fopen("./news/missing.txt", "a") or die("Unable to open file!");
			$outM .= join("\n", $missing);
			fwrite($mFile, $outM);
			fclose($mFile);
		}
	}
	else {
		if (strlen($in) > 3) {
			$missing[] = $in;
		}
	}
}

$the_world	= file("news/world.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_comps	= file("config/comps.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_teams	= file("config/teams.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_nats	= file("config/nations.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$DEBUG = 0;

$missing = Array();
$News = Array();
$Comp = Array();
$Team = Array();
$Match = Array();
$Nations = Array();

$tablist = Array();
$MatchCount = 0;
$NationCount = 0;
$LeagueCount = 0;

foreach ($the_comps as $in_c) {
	if (preg_match("/^#/", $in_c) || strlen($in_c) < 5) {
		# skip line
	}
	elseif (preg_match("/^N,/", $in_c)) {
		$t_line = explode(",", $in_c);
		$c_cnt = $t_line[1];
		$Comp[$c_cnt]["Name"] = $t_line[2];
		$Comp[$c_cnt]["Order"] = $t_line[3];
		$Comp[$c_cnt]["ID"] = $t_line[4];
		$Comp[$c_cnt]["Comps"] = Array();
	}
	elseif (preg_match("/^L,/", $in_c)) {
		$t_line = explode(",", $in_c);
		$idName = explode("~", $t_line[1]);
		foreach ($idName as $id) {
			$Comp[$c_cnt]["Comps"][$id]["Type"] = $t_line[0];
			$Comp[$c_cnt]["Comps"][$id]["Order"] = $t_line[2];
			$Comp[$c_cnt]["Comps"][$id]["Name"] = $t_line[3];
		}
	}
	elseif (preg_match("/^C,/", $in_c)) {
		$t_line = explode(",", $in_c);
		$idName = explode("~", $t_line[1]);
		foreach ($idName as $id) {
			$Comp[$c_cnt]["Comps"][$id]["Type"] = $t_line[0];
			$Comp[$c_cnt]["Comps"][$id]["Order"] = $t_line[2];
			$Comp[$c_cnt]["Comps"][$id]["Name"] = $t_line[3];
		}
	}
}
foreach ($the_teams as $in_t) {
	if (preg_match("/^#/", $in_t) || strlen($in_t) < 5) {
		# skip line
	}
	else {
		#arsenal,Arsenal,Awrw,wr,b-wwr,x009,51.555,-0.108611,Highbury,ENG
		$t_line = explode(",", $in_t);
		$idName = explode("~", $t_line[0]);
		foreach ($idName as $id) {
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
}
foreach ($the_nats as $in_t) {
	if (preg_match("/^#/", $in_t) || strlen($in_t) < 5) {
		# skip line
	}
	else {
		#australia,Australia,gy,x-gy,x049,-25.274398,133.775136,5,AUS
		$t_line = explode(",", $in_t);
		$idName = explode("~", $t_line[0]);
		foreach ($idName as $id) {
			$Team[$id]["Name"] = $t_line[1];
			$Team[$id]["Mnr"] = $t_line[2];
			$Team[$id]["Mjr"] = $t_line[3];
			$Team[$id]["Badge"] = $t_line[4];
			$Team[$id]["Long"] = $t_line[5];
			$Team[$id]["Lat"] = $t_line[6];
			$Team[$id]["Tri"] = $t_line[8];
			$Nations[$t_line[8]] = $id;
		}
	}
}
foreach ($the_world as $w) {
	if (preg_match("/^[A-Z][A-Z][A-Z]\|/", $w)) {
		$line = explode("|", $w);
		$curr_cc = $line[0];
		$curr_comp = $line[1];
		# Check that nation exists in the config
		if (!(array_key_exists($curr_cc, $Nations))) {
			if ($curr_cc != "INT") {
				missing("N:".$curr_cc);
			}
		}
		if (!(array_key_exists($curr_cc, $News))) {
			$News[$curr_cc] = Array();
			if (!(array_key_exists($curr_cc, $tablist))) {
				if ($curr_cc == "INT") {
					$tablist["INT"] = 10;
				}
				else {
					$tablist[$curr_cc] = $Comp[$curr_cc]["Order"];
				}
			}
		}
		# Check that competition exists in the config
		if (!(array_key_exists($curr_comp, $Comp[$curr_cc]["Comps"]))) {
			#pretty_var($curr_comp);
			#pretty_var($Comp[$curr_cc], '00aaff');
			missing("C:".$curr_cc.":".$curr_comp);
		}
		if (!(array_key_exists($curr_comp, $News[$curr_cc]))) {
			$News[$curr_cc][$curr_comp] = Array();
		}
	}
	else {
		array_push($News[$curr_cc][$curr_comp], $w);
	}
}
asort($tablist);

if ($_SERVER["PHP_SELF"] == "/fitba/backend.php") {
	print "<html>\n";
	print "<head>\n";
	print "\t<style>\n";
	print "\t\tbody { background-color: #111111; color: #cccccc; font-family: calibri; }\n";
	print "\t</style>\n";
	print "</head>\n";
	print "<body>\n";
	print $_SERVER["PHP_SELF"]."<br/>\n";
	print "<p>Test Comp:<br/>\n";
	pretty_var($Comp["ENG"], '333333');
	print "</p>\n";
	print "<p>Test Team:<br/>\n";
	pretty_var($Team["arsenal"], 'aa0000');
	print "</p>\n";
	print "<p>News Sample:<br/>\n";
	pretty_var($News["INT"]);
	print "</p>\n";
	print "<p>Match sample:<br/>\n";
	pretty_var($Match[13], '00aa00');
	print "</p>\n";
	print "<p>Size of missing file:<br/>\n";
	print count($missing)."<br/>\n";
	print "</body>\n";
	print "</html>\n";
}
?>

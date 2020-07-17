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
		print t(5)."<h2 class=\"text-center display-4\">".$cTitle."</h2> <!-- Competition container -->\n";
		print t(5)."<div class=\"d-flex justify-content-center clearfix my-3 nationFrame\">\n";
		print t(6)."<div class=\"container-fluid p-4 mb-4 grass nationFrame\">\n";
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
	$notes = "";

	if ($c != "INT") {
		$nat = $Nations[$c];
		$tBC_lt = $Team[$nat]["Lat"];
		$tBC_ln = $Team[$nat]["Long"];
	}

	$map_link = "<a href=\"https://tshamilton.com/fitba/map_page.php?lat=".$tBC_lt."&lng=".$tBC_ln."&z=".$tBC_z."&t=t".$c."&n=".$n."\" style=\"color: inherit; text-decoration: inherit;\" target=\"_new\">Map</a>";

	$table_header = t(7)."<div class=\"float-right col-6\">\n";
	$table_header .= t(8)."<table class=\"text-center ladder\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<thead>\n".t(9)."<tr>";
	$table_header .= "<th><div class=\"rounded-tl darkSlate\">&nbsp;</div></th>"; //Team
	$table_header .= "<th><div class=\"ldrHd\">Pl</div></th><th><div class=\"ldrHd\">W</div></th><th><div class=\"ldrHd\">D</div></th><th><div class=\"ldrHd\">L</div></th>"; //P W D L
	$table_header .= "<th><div class=\"ldrHd\">GF</div></th><th><div class=\"ldrHd\">GA</div></th><th><div class=\"ldrHd\">GD</div></th>"; // GF GA GD
	$table_header .= "<th><div class=\"ldrHd\">Pts</div></th><th><div class=\"rounded-tr darkSlate text-center\">".$map_link."</div></th></tr>\n"; // Pts Fate-Map
	$table_header .= t(8)."</thead>\n";
	$table_header .= t(8)."<tbody>\n";

	$table_footer = t(8)."<tr><td><div class=\"rounded-bl darkSlate\">&nbsp;</div><td colspan=\"8\"><div class=\"darkSlate\">&nbsp;</div></td><td><div class=\"rounded-br darkSlate\">&nbsp;</div></td></tr>\n";
	$table_footer .= t(8)."</tbody></table>\n".t(7)."</div>\n";

	$fileN = "news/ladder/".$c.$n.".lad";

	if (file_exists($fileN)) {
		$ladder	= file($fileN, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach ($ladder as $t) {
			$p = explode("|", $t);
			if ($p[0] == "group") {
				if ($p[1] == "mls" || $p[1] == $n)					{	continue;						}
				elseif (preg_match("/^group(.+?)/i", $p[1], $gp))	{	$p[1] = "Group ".$gp[0];		}
				elseif ($p[1] == "uslchampionship")					{	$p[1] = "USL Championship";		}
				elseif ($p[1] == "Eastern")							{	$p[1] = "Eastern Conference";	}
				elseif ($p[1] == "Western")							{	$p[1] = "Western Conference";	}
				elseif ($p[1] == "SupportersShield")				{	$p[1] = "Supporter's Shield";	}
				else 												{	$p[1] = "<i>".$p[1]."</i>";		}
				array_push($table_body, t(8)."<tr><th colspan='10' class=\"darkSlate text-center py-2\"><b>".$p[1]."</b></th></tr>\n");
			}
			else {
				#   0   1 2 3 4 5 6 7   8
				#canada|1|0|0|1|0|3|D|QUAL
				$pl = $p[1]+$p[2]+$p[3];
				$gd = $p[4]-$p[5];
				if ($p[7] != "") {
					$notes .= $Team[$p[0]]["Name"]." deducted ".$p[7]." points.<br/>\n";
					$p[6] = $p[6]."*";
				}
				$fate = "";
				if (sizeof($p) == 8) { array_push($p, "X"); }
				switch ($p[8]) {
					case "X":			$fate = "&nbsp;";			$style = "ldrData";				break;
					case "UCL":			$fate = "UCL";				$style = "ucl ldrData";			break;
					case "COPALIB":		$fate = "Copa Lib.";		$style = "ucl ldrData";			break;
					case "UCLQ":		$fate = "UCL Qual.";		$style = "uclqual ldrData";		break;
					case "COPALIBQ":	$fate = "Copa Lib Q.";		$style = "uclqual ldrData";		break;
					case "EL":			$fate = "UEL";				$style = "eurolg ldrData";		break;
					case "ELQ":			$fate = "UEL Qual.";		$style = "eurolgqual ldrData";	break;
					case "COPASUD":		$fate = "Copa Sud. Qual.";	$style = "eurolg ldrData";		break;
					case "ELQP":		$fate = "UEL Playoffs";		$style = "eurolgqual ldrData";	break;
					case "PROMOTED":	$fate = "&uarr; ";			$style = "promotion ldrData";	break;
					case "QUAL":		$fate = "Qualified";		$style = "promotion ldrData";	break;
					case "FINALS":		$fate = "Finals";			$style = "promotion ldrData";	break;
					case "NEXTPOS":		$fate = "Playoffs";			$style = "uclqual ldrData";		break;
					case "RELEGATED":	$fate = "&darr; ";			$style = "relegation ldrData";	break;
					case "PRPLAYOFF":	$fate = "Prom. Playoff";	$style = "promotion ldrData";	break;
					case "RLPLAYOFF":	$fate = "Rel. Playoff";		$style = "relegation ldrData";	break;
					case "ECQ":			$fate = "UEFA Conf. Q.";	$style = "eurolg ldrData";		break;
					default:			$fate = $p[8];				$style = "unknown ldrData";		break;
				}
				list($tnm, $tm) = makeTeamName($p[0]);
				//pretty_var("OT1 <code>".$tnm."</code> = <code>".$tm."</code>");
				if (preg_match("/alert\.gif/", $tm)) {
					missing("T(L):".$c.":".$tnm);
				}
				else {
				}

				$tm = doTeam($tnm, $tm, $c, 'l');
				//pretty_var("<code>".$tnm."</code> = <code>".$tm."</code>");
				array_push($points_Ln, $Team[$tnm]["Long"]);
				array_push($points_Lt, $Team[$tnm]["Lat"]);
				$team = "<td>".$tm."</td>";
				$games = "<td><div class=\"".$style."\">".$pl."</div></td><td><div class=\"".$style."\">".$p[1]."</div></td><td><div class=\"".$style."\">".$p[2]."</div></td><td><div class=\"".$style."\">".$p[3]."</div></td>";
				$goals = "<td><div class=\"".$style."\">".$p[4]."</div></td><td><div class=\"".$style."\">".$p[5]."</div></td><td><div class=\"".$style."\">".$gd."</div></td>";
				$pts_fate = "<td><div class=\"".$style."\"><b>".$p[6]."</b></div></td><td><div class=\"text-center ".$style."\">".$fate."</div></td>";
				array_push($table_body, t(8)."<tr class=\"darkSlate\">".$team.$games.$goals.$pts_fate."</tr><!-- Fate: ".$p[8]." -->\n");
			}
		}
		$maxLt = max($points_Lt);
		$minLt = min($points_Lt);
		$maxLn = max($points_Ln);
		$minLn = min($points_Ln);
		$tBC_lt = $minLt + (($maxLt - $minLt) / 2);
		$tBC_ln = $minLn + (($maxLn - $minLn) / 2);
		$table_body_string = join("", $table_body);
		if ($notes != "") {
			$table_body_string .= "<tr><td colspan=\"10\"><div class=\"small darkSlate\">".$notes."</div></td></tr>\n";
		}
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
	$homeName = "";
	$homeTitle = "";
	$awayName = "";
	$awayTitle = "";

	$m = explode("|", $match);

	//pretty_var("Start -> <pre>".$m[1]."</pre>");
	//pretty_var("Away -> <pre>".$m[4]."</pre>", '00aaff');

	list($homeName, $homeTitle) = makeTeamName($m[1]);
	if (preg_match("/alert\.gif/", $homeTitle)) {
		missing("T:".$c.":".$homeTitle);
		$hCol = "darkSlate";
	}
	else {
		$hCol = $Team[$homeName]["Mnr"];
	}
	//pretty_var("After makeTeamName (h) -> ".$homeName);
	list($awayName, $awayTitle) = makeTeamName($m[4]);
	if (preg_match("/alert.gif/", $awayTitle)) {
		missing("T:".$c.":".$awayTitle);
		$aCol = "darkSlate";
	}
	else {
		$aCol = $Team[$awayName]["Mnr"];
	}
	//pretty_var("After makeTeamName (a) -> ".$awayName, '00aaff');

	if ($m[10] > 0 && $m[11]) {
		$hSco = $m[2] - $m[10];
		$aSco = $m[3] - $m[11];
		$m[2] = $hSco." (".$m[10].")";
		$m[3] = "(".$m[11].") ".$aSco;
	}
	$theHTeam = doTeam($homeName, $homeTitle, $c, 'h');
	$theATeam = doTeam($awayName, $awayTitle, $c, 'a');

	print t(7)."<div class=\"col-6 float-left px-3 pb-4 theMatchBody\">\n";
	print t(8)."<table width=\"100%\" class=\"matchFrame\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";

	# Row 1 -> Time, Stage and Status
	$theTime = "<td colspan=\"8\">".doMatchTime($m[6], $hCol)."</td>";
	$theStage = "<td colspan=\"4\">".doMatchStatus($m[7], $hCol)."</td>";
	$theStatus = "<td colspan=\"8\">".doMatchStage($m[5], $hCol)."</td>";
	print t(8)."<tr>".$theTime.$theStage.$theStatus."</tr>\n";

	if (preg_match("/unknown/", $theStatus)) {
		missing("Status -> ".$theStatus." : ".$m[1]." vs ".$m[4]);
	}

	# Row 2 -> Venue
	if ($m[13] != "") {
		$theVenue = doMatchVenue($m[13], $hCol);
		print t(8)."<tr><td colspan=\"20\">".$theVenue."</td></tr>\n";
	}

	# Row 3 -> Teams and score
	if ($m[7] != "N-1" && $m[7] != "F-5" && $m[7] != "P-5") {
		$theHScore = doScore($m[2], $hCol);
		$theAScore = doScore($m[3], $aCol);
		$theScore = "
		<td class=\"gz-".substr($hCol, 1, 1)."\" colspan=\"2\"><div class=\"m-2 score ".$hCol."\">".$theHScore."</div></td>
		<td class=\"gz-".substr($aCol, 1, 1)."\" colspan=\"2\"><div class=\"m-2 score ".$aCol."\">".$theAScore."</div></td>";
		print t(8)."
		<tr>
		<td class=\"gz-".substr($hCol, 1, 1)."\" colspan=\"8\">".$theHTeam."</td>
		".$theScore."
		<td class=\"gz-".substr($aCol, 1, 1)."\" colspan=\"8\">".$theATeam."</td></tr>\n";
	}
	else {
		print t(8)."<tr><td class=\"gz-".substr($hCol, 1, 1)."\" colspan=\"10\">".$theHTeam."</td><td class=\"gz-".substr($aCol, 1, 1)."\" colspan=\"10\">".$theATeam."</td><td></td></tr>\n";
	}

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
	if ($m[16] != "" && ($m[7] == "N-1" || $m[7] == "F-5" || $m[7] == "P-5")) { // Only do trivia if game is in "Not started" status.
		print t(8)."<!-- R8 --><tr><td colspan=\"20\">".doTrivia($m[16], $hCol)."</td></tr>";
	}
	else {
		print t(8)."<!-- Juice: ".$m[7]." -->\n";
	}

	# Row 9 -> bottom Spacer
	print t(8)."<tr><td colspan=\"20\" class=\"rounded-bl rounded-br ".$hCol."\"><div class=\"rounded-bl rounded-br\">&nbsp;</div></td></tr>\n";
	print t(8)."</table>\n";
	print t(7)."</div>\n";
}
function doCoaches($mgrs, $h, $a) {
	list($ch, $ca) = explode("~", $mgrs);
	$mh = explode(":", $ch);
	$ma = explode(":", $ca);
	if (strlen($mh[1]) > 2) { $mhf = doFlag(substr($h, 0, 1), $mh[1]); } else { $mhf = ""; }
	if (strlen($ma[1]) > 2) { $maf = doFlag(substr($a, 0, 1), $ma[1]); } else { $maf = ""; }

	$rh = "<div class=\"text-center ".$h."\">".$mhf." ".$mh[0]."</div>";
	$ra = "<div class=\"text-center ".$a."\">".$ma[0]." ".$maf."</div>";

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
	return "<div class=\"matchStage rounded-tr ".$s."\">".$stage."</div>";
}
function doMatchStatus($st, $s) { //status, style
	return "<div class=\"pr-2 text-center matchStatus ".$s."\">".MakeStatus($st)."</div>";
}
function doMatchTime($mt, $s) { //match time, home team minor style
	return "<div class=\"pl-2 text-right rounded-tl matchTime ".$s."\">".$mt."</div>";
}
function doMatchVenue($v, $s) { // venue, style
	return "<div class=\"matchVenue text-center ".$s."\">".$v."</div>";
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
		print t(3)."<div role=\"tabpanel\" class=\"tab-pane container-fluid fade mx-2 px-4 pt-4 nationFrame ".$cStyle."\" id=\"".$c."\" name=\"".$c."\"> <!--National container -->\n";
		print t(4)."<div class=\"container-fluid\">\n";
		print t(5)."<h1 class=\"display-3\">".$flag." ".$cTitle."</h1>\n";
		doCompetitions($c, $n);
		print t(4)."</div>\n";
		print t(3)."</div>\n";	  
	}
}
function doScore($sc, $s) { // score, style
	return "<div class=\"score ".$s." ".substr($s, 0, 1)."\"><b> ".$sc." </b></div>";
}
function doTabs($tabs) {
	global $Nations;
	global $missing;
	global $Team;

	foreach ($tabs as $t => $v) {
		if ($t == "INT") {
			print t(4)."<li class=\"nav-item slate\"><a role=\"nav-link\" class=\"nav-link\" data-toggle=\"pill\" style=\"color:inherit; text-decoration: inherit;\" href=\"#INT\"> International </a></li>\n";
		}
		else {
			if ($t == "MKD") {
				$t = "NMK";
			}
			$n = $Nations[$t];
			print t(4)."<li class=\"nav-item ".$Team[$n]["Mjr"]."\"><a role=\"nav-link\" class=\"nav-link\" data-toggle=\"pill\" href=\"#".$t."\">".doFlag(substr($Team[$n]["Mjr"], 2, 1), $t)." ".$Team[$n]["Name"]."</a></li>\n";
		}
	}
}
function doTeam($name, $title, $c, $s = "h") { // Derived team db name and title, Competition Country (trig, used as test for INT comps), Side (home/away/ladder)
	global $Team;

	//pretty_var("IN <code>".$name."</code> = <code>".$title."</code>");
	//pretty_var("Name -> '".$name."'<br/>Title -> '".$title."'<br/> C -> '".$c."'<br/>S -> '".$s."'<br/>", 'dddddd');
	//pretty_var($Team[$name], '00cccc');

	if (preg_match("/alert.gif/", $title)) {	$tStyle = "darkSlate";	}
	elseif (preg_match("/x/", $Team[$name]["Badge"])) {	$tStyle = $Team[$name]["Badge"]." ".substr($Team[$name]["Mnr"], 0, 1);	}
	else {	$tStyle = $Team[$name]["Mjr"]." ".substr($Team[$name]["Mnr"], 0, 1);	}

	if ($c == "INT") {
		$Flag = doFlag(substr($Team[$name]["Mjr"], 2, 1), $Team[$name]["Tri"]);
		$title = $s == 'h' ? $Flag." ".$title : $title." ".$Flag;
	}

	if ($s == "h" || $s == "a") {	$tStyle = "m-2 team ".$tStyle;	}
	else {	$tStyle = "ldrTeam ".$tStyle;	}

	return "<div class=\"".$tStyle."\">".$title."</div>";
}
function doTrivia ($triv, $h) {
	$tv = explode("~", $triv);

	$trivia = "<ul>\n";
	foreach ($tv as $t) {
		$trivia .= "<li>".$t."</li>\n";
	}
	$trivia .= "</ul>\n";
	return "<div class=\"matchTrivia ".$h."\">".$trivia."</div>";

}
function MakeDetails($e, $h, $a, $s) { //event, hcol, acol, switch (e for event, s for sub)
	$goal = "<span class=\"goal\">&#9917;</span>";
	$yellow = "<span class=\"badge badge-warning\">YC</span>";
	$yellow2 = "<span class=\"badge badge-warning\">YC</span><span class=\"badge badge-warning k\">YC</span>";
	$red = "<span class=\"badge badge-danger\">RC</span>";
	$off = "<span class=\"badge badge-danger\">Off</span>";
	$on = "<span class=\"badge badge-success\">On</span>";

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

		if ($ev[1] == 121) {
			$ev[1] = "PSO";
		}
		
		if ($ev[2] == "homegoal") {
			$hEv = "<div class=\"homeevent ".$h."\"><b>".$ev[1]." ".$goal."</b></div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\" class=\"gz-".substr($a,1,1)."\"><b><div class=\"htimeevent ".$h."\">".$ev[0]."</div></b></td><td colspan=\"9\" class=\"gz-".substr($a,1,1)."\">&nbsp;</td></tr>";
		}
		elseif ($ev[2] == "awaygoal") {
			$aEv = "<b><div class=\"awayevent ".$a."\">".$goal." ".$ev[1]."</div></b>";
			$rv = "<tr><td colspan=\"9\" class=\"gz-".substr($h,1,1)."\">&nbsp;</td><td class=\"gz-".substr($h,1,1)."\" colspan=\"2\"><b><div class=\"atimeevent ".$a." gz-".substr($h,1,1)."\">".$ev[0]."</div></b></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "homenogoal") {
			$hEv = "<div class=\"homeevent ".$h."\">".$ev[1]." (Pen Miss)</div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\" class=\"gz-".substr($a,1,1)."\"><div class=\"htimeevent ".$h."\">".$ev[0]."</div></td><td colspan=\"9\" class=\"gz-".substr($a,1,1)."\">&nbsp;</td></tr>";
		}
		elseif ($ev[2] == "awaynogoal") {
			$aEv = "<div class=\"awayevent ".$a."\">(Pen Miss) ".$ev[1]."</div>";
			$rv = "<tr><td colspan=\"9\" class=\"gz-".substr($h,1,1)."\">&nbsp;</td><td class=\"gz-".substr($h,1,1)."\" colspan=\"2\"><div class=\"atimeevent ".$a."\">".$ev[0]."</div></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "homeyellow") {
			$hEv = "<div class=\"homeevent ".$h."\">".$ev[1]." ".$yellow."</div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\" class=\"gz-".substr($a,1,1)."\"><div class=\"htimeevent ".$h."\">".$ev[0]."</div></td><td colspan=\"9\" class=\"gz-".substr($a,1,1)."\">&nbsp;</td></tr>";
		}
		elseif ($ev[2] == "awayyellow") {
			$aEv = "<div class=\"awayevent ".$a."\">".$yellow." ".$ev[1]."</div>";
			$rv = "<tr><td colspan=\"9\" class=\"gz-".substr($h,1,1)."\">&nbsp;</td><td class=\"gz-".substr($h,1,1)."\" colspan=\"2\"><div class=\"atimeevent ".$a."\">".$ev[0]."</div></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "home2yellow") {
			$hEv = "<div class=\"homeevent ".$h."\">".$ev[1]." ".$yellow2."</div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\" class=\"gz-".substr($a,1,1)."\"><div class=\"htimeevent ".$h."\">".$ev[0]."</div></td><td colspan=\"9\" class=\"gz-".substr($a,1,1)."\">&nbsp;</td></tr>";
		}
		elseif ($ev[2] == "away2yellow") {
			$aEv = "<div class=\"awayevent ".$a."\">".$yellow2." ".$ev[1]."</div>";
			$rv = "<tr><td colspan=\"9\" class=\"gz-".substr($h,1,1)."\">&nbsp;</td><td class=\"gz-".substr($h,1,1)."\" colspan=\"2\"><div class=\"atimeevent ".$a."\">".$ev[0]."</div></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "homered") {
			$hEv = "<div class=\"homeevent ".$h."\">".$ev[1]." ".$red."</div>";
			$rv = "<tr><td colspan=\"9\">".$hEv."</td><td colspan=\"2\" class=\"gz-".substr($a,1,1)."\"><div class=\"htimeevent ".$h."\">".$ev[0]."</div></td><td colspan=\"9\" class=\"gz-".substr($a,1,1)."\">&nbsp;</td></tr>";
		}
		elseif ($ev[2] == "awayred") {
			$aEv = "<div class=\"awayevent ".$a."\">".$red." ".$ev[1]."</div>";
			$rv = "<tr><td colspan=\"9\" class=\"gz-".substr($h,1,1)."\">&nbsp;</td><td class=\"gz-".substr($h,1,1)."\" colspan=\"2\"><div class=\"atimeevent ".$a."\">".$ev[0]."</div></td><td colspan=\"9\">".$aEv."</td></tr>";
		}
		elseif ($ev[2] == "homeassist") {	$rv = ""; }
		elseif ($ev[2] == "awayassist") {	$rv = ""; }
		else {	$rv = "<tr><td colspan=\"20\">".$e."</td></tr>"; }
	}
	elseif ($s == "s") {
		if ($ev[1] == "a") {
			$aEv = "<div class=\"px-2 awayevent ".$a."\">".$ev[2]." ".$on." <div class=\"float-right\">".$off." ".$ev[3]."</div> </div>";
			$rv = "<td colspan=\"9\" class=\"gz-".substr($h,1,1)."\">&nbsp;</td><td class=\"gz-".substr($h,1,1)."\" colspan=\"2\"><div class=\"atimeevent ".$a."\">".$ev[0]."</div></td><td colspan=\"9\">".$aEv."</td>";
		}
		elseif ($ev[1] == "h") {
			$hEv = "<div class=\"px-2 homeevent ".$h."\"><div class=\"float-left\">".$ev[3]." ".$off."</div> ".$on." ".$ev[2]."</div>";
			$rv = "<td colspan=\"9\">".$hEv."</td><td class=\"gz-".substr($a,1,1)."\" colspan=\"2\"><div class=\"htimeevent ".$h."\">".$ev[0]."</div></td></td><td colspan=\"9\" class=\"gz-".substr($a,1,1)."\">&nbsp;</td>";
		}
	}

	return $rv;
}
function MakeStatus($s) {
	$st = explode("-", $s);
	if 		($st[0] == "F") {
		if 		($st[1] == 5)	{ return "Postponed"; }
		elseif	($st[1] == 6)	{ return "<b>Full Time</b>"; }
		elseif	($st[1] == 11)	{ return "<b>After Extra Time</b>"; }
		elseif	($st[1] == 13)	{ return "<b>After Penalties</b>"; }
		elseif	($st[1] == 17)	{ return "<b>Abandoned</b>"; }
		elseif	($st[1] == 93)	{ return "Resuming Postponed Match"; }
		elseif	($st[1] == 106)	{ return "Cancelled"; }
		else					{ return "Status unknown (".$s.")"; }
	}
	elseif	($st[0] == "N") {
		if 		($st[1] == 1) 	{ return "Not started"; }
		else					{ return "Status unknown (".$s.")"; }
	}
	elseif	($st[0] == "P") {
		if		($st[1] == 5)	{ return "Postponed"; }
		else					{ return "Status unknown (".$s.")"; }
	}
	elseif	($st[0] == "S") {
		if		($st[1] == 2)	{ return "First Half"; }
		elseif	($st[1] == 3)	{ return "Second Half"; }
		elseif	($st[1] == 4)	{ return "Penalty Shootout"; }
		elseif	($st[1] == 8)	{ return "Extra Time Break"; }
		elseif	($st[1] == 9)	{ return "Extra Time"; }
		elseif	($st[1] == 10)	{ return "Half Time"; }
		elseif	($st[1] == 13)	{ return "<b>After Penalties</b>"; }
		elseif	($st[1] == 17)	{ return "Abandoned"; }
		elseif	($st[1] == 18)	{ return "Kick-Off"; }
		elseif	($st[1] == 106)	{ return "Cancelled"; }
		elseif	($st[1] == 190)	{ return "<b>Full Time</b>"; }
		elseif	($st[1] == 234) { return "Resuming Postponed Match"; }
		else					{ return "Status unknown ".$st[0]." - ".$st[1]; }
	}
	else {
		missing("S:".$s);
		return "Status unknown ".$st[0]." - ".$st[1];
	}
}
function MakeTeamName($t) {
	global $Team;

	if (array_key_exists($t, $Team)) {
		$tIdent = $t;
		$tName = $Team[$tIdent]["Name"];
	}
	elseif ((preg_match("/fcw$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		/* women */
		$tIdent = substr($t, 0, -3);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." <b>&#9792;</b>"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/qw$/", $t)) && (array_key_exists(substr($t, 0, -2), $Team))) {
		/* women */
		$tIdent = substr($t, 0, -2);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." <b>&#9792;</b>"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/w$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		/* women */
		$tIdent = substr($t, 0, -1);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." <b>&#9792;</b>"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/q$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		/* women */
		$tIdent = substr($t, 0, -1);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." <b>&#9792;</b>"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/a$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		/* reserve side */
		$tIdent = substr($t, 0, -1);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." A"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/b$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		/* reserve side */
		$tIdent = substr($t, 0, -1);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." B"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/2$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		/* reserve side */
		$tIdent = substr($t, 0, -1);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." 2"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/3$/", $t)) && (array_key_exists(substr($t, 0, -1), $Team)))	{
		/* reserve side */
		$tIdent = substr($t, 0, -1);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." 3"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/ii$/", $t) || (preg_match("/ll$/", $t))) && (array_key_exists(substr($t, 0, -2), $Team))) {
		/* reserve side */
		$tIdent = substr($t, 0, -2);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." II"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/fc$/", $t)) && (array_key_exists(substr($t, 0, -2), $Team))) {
		/* abbreviation (NB: liverpool (ENG) and liverpoolfc (ECU) co-exist because a search for liverpoolfc finds the ECU team first) */
		$tIdent = substr($t, 0, -2);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/^jong/", $t)) && (array_key_exists(substr($t, 4), $Team))) {
		/* Youth side (NED) */
		$tIdent = substr($t, 4);
		if (array_key_exists($tIdent, $Team)) { $tName = "Jong ".$Team[$tIdent]["Name"]; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/academy$/", $t)) && (array_key_exists(substr($t, 0, -7), $Team))) {
		/* Youth side */
		$tIdent = substr($t, 0, -7);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." Academy"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/primavera$/", $t)) && (array_key_exists(substr($t, 0, -9), $Team))) {
		/* Youth side (ITA) */
		$tIdent = substr($t, 0, -9);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." Primavera"; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	elseif ((preg_match("/u(\d{2})$/", $t, $age)) && (array_key_exists(substr($t, 0, -3), $Team))) {
		/* Youth side (Age-limited) */
		$tIdent = substr($t, 0, -3);
		if (array_key_exists($tIdent, $Team)) { $tName = $Team[$tIdent]["Name"]." Under-".$age[1]; }
		else { $tIdent = $t; $tName = "<img src=\"image/alert.gif\"> ".$t; }
	}
	else {
		$tIdent = $t;
		$tName = "<img src=\"image/alert.gif\"> ".$t;
	}

	return array($tIdent, $tName);
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

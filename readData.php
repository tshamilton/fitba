<?php
include 'utility.php';

$nation_file = file("config/nations.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$team_file = file("config/teams.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$NAT = Array();
$TEAM = Array();
$COMP = Array();
$MAR = Array();

foreach ($nation_file as $n) {
	if (preg_match("/^#/", $n)) {
		continue;
	}

	$tN = explode(",", $n);
	$alias = Array();

	$count = 1;

	if (preg_match("/~/", $tN[0])) {
		$alias = explode("~", $tN[0]);
	}
	else {
		$alias[0] = $tN[0];
	}

	foreach ($alias as $name) {
		$NAT[$name]["dis"] = $tN[1];
		$NAT[$name]["mnS"] = $tN[2];
		$NAT[$name]["mjS"] = $tN[3];
		$NAT[$name]["grf"] = $tN[4];
		$NAT[$name]["lat"] = $tN[5];
		$NAT[$name]["lng"] = $tN[6];
		$NAT[$name]["zom"] = $tN[7];
		$NAT[$name]["tri"] = $tN[8];
		$MAR[$tN[8]] = Array();
	}
}

foreach ($team_file as $t) {
	if (preg_match("/^#/", $t)) {
		continue;
	}

	$tT = explode(",", $t);

	#1fckoln,1. FC K&ouml;ln,1rww,rw,x-rw,x163,50.933497,6.874997,K&ouml;ln,GER
	#   0        1             2  3  4    5     6          7        8        9

	$thisTeam = html_entity_decode($tT[1])."~".$tT[2]."~".$tT[6].",".$tT[7]."~".html_entity_decode($tT[8]);
	
	if (isset($tT[9])) {
		array_push($MAR[$tT[9]], $thisTeam);
	}
	else {
		print "ERROR! $tT[1] (poss new nation?)<br />\n";
	}
}
?>
<?php
$the_styles = file("css/style.css", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_comps	= file("config/comps.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_teams	= file("config/teams.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_champs = file("config/champs.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_nats	= file("config/nations.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$the_missing =file("news/missing.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$t2c = Array();

$N = Array();
$N["total"] = 0;

$T = Array();
$T["total"] = 0;

$C = Array();
$C["minor"] = Array();

foreach ($the_nats as $n) {
	#scotland,Scotland,yn,x-yn,x050,57.2941727,-4.5668113,7,SCO
	$this_nat = explode(",", $n);

	$N["total"]++;
	$N[$this_nat[8]]["total"] = 0;
	$N[$this_nat[8]]["list"] = Array();
	$T[$this_nat[8]]["total"] = 0;
	$T[$this_nat[8]]["list"] = Array();
	$t2c[$this_nat[8]] = $this_nat[1];
	if (!(array_key_exists($this_nat[2], $C["minor"]))) {
		$C["minor"][$this_nat[2]] = 1;
	}
	else {
		$C["minor"][$this_nat[2]]++;
	}
}
foreach ($the_teams as $t) {
	#adodenhaag,ADO Den Haag,Dygy,gy,s-ggy,,52.0629342,4.3827271,Den Haag,NED
	$T["total"]++;
	$this_team = explode(",", $t);
	$T[$this_team[9]]["total"]++;
	array_push($T[$this_team[9]]["list"], $t);
	if (!(array_key_exists($this_team[3], $C["minor"]))) {
		$C["minor"][$this_team[3]] = 1;
	}
	else {
		$C["minor"][$this_team[3]]++;
	}
}

asort($t2c);

?>
<!doctype html>
<html lang="en">
	<head>
		<title>Fitba Stats & Config</title>
		<link rel="shortcut icon" type="image/png" href="image/favicon.ico"/>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- My CSS links -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Montserrat">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/badge.css">
	</head>
	<body>
		<table>
		<tr>
			<td><div class="m-2 team x-wa">A - Azure - 3366ff</div></td>
			<td><div class="m-2 team x-we">E - Emerald - 009900</div></td>
			<td><div class="m-2 team x-ki">I - Pink - ff9f9f</div></td>
			<td><div class="m-2 team x-wn">N - Navy - 000099</div></td>
			<td><div class="m-2 team x-ks">S - Silver - aaaaaa</div></td>
			<td><div class="m-2 team x-kw">W - White - ffffff</div></td>
		</tr>
		<tr>
			<td><div class="m-2 team x-wb">B - Blue - 0000ff</div></td>
			<td><div class="m-2 team x-kf">F - Sky - 77aadd</div></td>
			<td><div class="m-2 team x-kj">J - Puce - aa3388</div></td>
			<td><div class="m-2 team x-ko">O - Orange - ff9900</div></td>
			<td><div class="m-2 team x-kt">T - Beige - d9ab4b</div></td>
			<td><div class="m-2 team x-wx">X - Bordeaux - 660033</div></td>
		</tr>
		<tr>
			<td><div class="m-2 team x-wc">C - Claret - 990044</div></td>
			<td><div class="m-2 team x-wg">G - Green - 009900</div></td>
			<td><div class="m-2 team x-wk">K - Black - 000000</div></td>
			<td><div class="m-2 team x-wp">P - Purple - 660099</div></td>
			<td><div class="m-2 team x-ku">U - Gold - ffcc00</div></td>
			<td><div class="m-2 team x-ky">Y - Yellow - fff00c</div></td>
		</tr>
		<tr>
			<td><div class="m-2 team x-wd">D - Blood - cc0000</div></td>
			<td><div class="m-2 team x-wh">H - High Blue - 00aaff</div></td>
			<td><div class="m-2 team x-wl">L - Lilac - 8866ee</div></td>
			<td><div class="m-2 team x-wq">Q - Maroon - 880000</div></td>
			<td><div class="m-2 team x-wv">V - Brown - aa5533</div></td>
			<td><div class="m-2 team x-kz">Z - Lime - 00ff00</div></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td><div class="m-2 team x-wm">M - Magenta - ff00ff</div></td>
			<td><div class="m-2 team x-wr">R - Red - ff0000</div></td>
			<td colspan="2">&nbsp;</td>
		</tr>
		</table>
		<?php print $N["total"]; ?> countries.<br/>
		<?php print $T["total"]; ?> teams.<br/>
		<?php
foreach ($t2c as $n => $t) {
	print $t." has ".$T[$n]["total"]." teams.<br/>\n";
}
		?>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>
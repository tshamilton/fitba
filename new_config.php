<?php
include 'utility.php';

function table($in_t, $nC, $type) {
	if ($type == "minor") {
		$ks = array_keys($in_t);
		$size = sizeof($in_t);
		$colLen = ceil($size / $nC);
		$leftOver = $size - ($colLen * ($nC-1));
		#print t(5)."Size=".$size.", Columns=".$nC.", colLen=".$colLen." entries for ".($nC-1)." columns and ".$leftOver." for the last.<br/>\n";
		print t(5)."<div class=\"row\">\n";
		for ($tC = 0; $tC < $nC-1; $tC++) {
			print t(6)."<div class=\"col-sm-1\">\n";
			for ($e = 0; $e < $colLen; $e++) {
				$x = array_shift($ks);
				print t(7)."<div class=\"team mx-1 my-2 ".strrev($x)."\">".strrev($x)." (".$in_t[$x].")</div>\n";
			}
			print t(6)."</div>\n";
		}
		print t(6)."<div class=\"col-sm-1\">\n";
		for ($e = 0; $e < $leftOver; $e++) {
			$x = array_shift($ks);
			print t(7)."<div class=\"team mx-1 my-2 ".strrev($x)."\">".strrev($x)." (".$in_t[$x].")</div>\n";
		}
		print t(6)."</div>\n";
		print t(5)."</div>\n";
	}
	elseif ($type == "majorX") {
		$ks = array_keys($in_t);
		$size = sizeof($in_t);
		$colLen = ceil($size / $nC);
		$leftOver = $size - ($colLen * ($nC-1));
		#print t(5)."Size=".$size.", Columns=".$nC.", colLen=".$colLen." entries for ".($nC-1)." columns and ".$leftOver." for the last.<br/>\n";
		print t(5)."<div class=\"row\">\n";
		for ($tC = 0; $tC < $nC-1; $tC++) {
			print t(6)."<div class=\"col-sm-1\">\n";
			for ($e = 0; $e < $colLen; $e++) {
				$x = array_shift($ks);
				print t(7)."<div class=\"team mx-1 my-2 x-".strrev($x)."\">x-".strrev($x)." (".$in_t[$x].")</div>\n";
			}
			print t(6)."</div>\n";
		}
		print t(6)."<div class=\"col-sm-1\">\n";
		for ($e = 0; $e < $leftOver; $e++) {
			$x = array_shift($ks);
			print t(7)."<div class=\"team mx-1 my-2 ".strrev($x)."\">x-".strrev($x)." (".$in_t[$x].")</div>\n";
		}
		print t(6)."</div>\n";
		print t(5)."</div>\n";
	}
	elseif ($type == "majorS" || $type == "majorB" || $type == "majorE" || $type == "majorH" || $type == "majorD" || $type == "majorO" || $type == "majorV" || $type = "majorZ") {
		#pretty_var($in_t);
		switch ($type) {
			case "majorS":	$sty = "s";	break;
			case "majorB":	$sty = "b"; break;
			case "majorE":	$sty = "e"; break;
			case "majorH":	$sty = "h"; break;
			case "majorD":	$sty = "d"; break;
			case "majorO":	$sty = "o"; break;
			case "majorV":	$sty = "v";	break;
			case "majorZ":	$sty = "z";	break;
		}
		if (sizeof($in_t) <= 12) {
			print t(5)."<div class=\"row\">\n";
			foreach ($in_t as $x => $count) {
				$x = substr($x, -1, 1).substr($x, 0, strlen($x)-1);
				print t(7)."<div class=\"team mx-1 my-2 ".$sty."-".$x."\"> ".$sty."-".$x." (".$count.")</div>\n";
			}
			print t(5)."</div>\n";
		}
		else {
			if ((sizeof($in_t) - (ceil(sizeof($in_t) / $nC) * ($nC-1))) > 0) {
				$ks = array_keys($in_t);
				$size = sizeof($in_t);
				$colLen = ceil($size / $nC);
				$leftOver = $size - ($colLen * ($nC-1));
			}
			else {
				$ks = array_keys($in_t);
				$size = sizeof($in_t);
				$colLen = floor($size / $nC);
				$leftOver = $size - ($colLen * ($nC-1));
			}
			ksort($in_t);
			print t(5)."<p>Size=".$size.", Columns=".$nC.", colLen=".($size/$nC)." or ".$colLen." entries for ".($nC-1)." columns and ".$leftOver." for the last.</p>\n";
			print t(5)."<div class=\"row\">\n";
			for ($tC = 0; $tC < $nC-1; $tC++) {
				print t(6)."<div class=\"col-sm-1\">\n";
				for ($e = 0; $e < $colLen; $e++) {
					$orig = array_shift($ks);
					if (isset($in_t[$orig])) {
						$count = $in_t[$orig];
						$x = substr($orig, -1, 1).substr($orig, 0, strlen($orig)-1);
					}
					else {
						$count = "X?";
						$x = $orig;
					}
					print t(7)."<div class=\"team mx-1 my-2 ".$sty."-".$x."\"> ".$sty."-".$x." (".$count.")</div>\n";
				}
				print t(6)."</div>\n";
			}
			print t(6)."<div class=\"col-sm-1\">\n";
			for ($e = 0; $e < $leftOver; $e++) {
				$orig = array_shift($ks);
				$count = $in_t[$orig];
				$x = substr($orig, -1, 1).substr($orig, 0, strlen($orig)-1);
				print t(7)."<div class=\"team mx-1 my-2 ".$sty."-".$x."\"> ".$sty."-".$x." (".$count.")</div>\n";
			}
			print t(6)."</div>\n";
			print t(5)."</div>\n";
		}
	}
}

$string = file_get_contents('base.json');
$Stats = json_decode($string, true);

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
			<li class="nav-item slate active"><a role="nav-link" data-toggle="pill" href="#stats"> Stats </a></li>
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
				<h2 class="text-center">Info</h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
					<div class="theContent slate p-2">
						<p style="margin-top: 1rem;">
							<?php print $Stats["totalTeams"]." teams in the database from ".$Stats["totalCountries"]." countries.<br/>\n"; ?>
						</p>
						<p style="margin-top: 1rem;">
							<?php #print $Stats["Colours"]["plain"]["total"]." plain designs.<br/>\n"; ?>
							<?php #print $Stats["Colours"]["stripes"]["total"]." striped designs.<br/>\n"; ?>
							<?php #print $Stats["Colours"]["edges"]["total"]." edged designs.<br/>\n"; ?>
							<?php #print $Stats["Colours"]["bands"]["total"]." banded designs.<br/>\n"; ?>
							<?php #print $Stats["Colours"]["hoops"]["total"]." hooped designs.<br/>\n"; ?>
							<?php #print $Stats["Colours"]["halves"]["total"]." halved designs.<br/>\n"; ?>
							<?php #print $Stats["Colours"]["offsets"]["total"]." offset designs.<br/>\n"; ?>
							<?php #print $Stats["Colours"]["sashed"]["total"]." sashed designs.<br/>\n"; ?>
							<?php #print $Stats["Colours"]["others"]["total"]." chequered designs.<br/>\n"; ?>
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
		$the_key = substr($S,3).substr($S,2,1);
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
		$the_key = substr($S,3).substr($S,2,1);
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
		$the_key = substr($S,3).substr($S,2,1);
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
		$the_key = substr($S,3).substr($S,2,1);
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
		$the_key = substr($S,3).substr($S,2,1);
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
		$the_key = substr($S,3).substr($S,2,1);
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
		$the_key = substr($S,3).substr($S,2,1);
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
		$the_key = substr($S,3).substr($S,2,1);
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
			
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="clubs" name="clubs">
			<div class="container-fluid">
				<h1 class="text-center"> Clubs </h1>
			
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="badges" name="badges">
			<div class="container-fluid">
				<h1 class="text-center"> Badges </h1>
			
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
				<?php pretty_var($Stats); ?>
			</div>
			</div><!-- End tab panel -->
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>
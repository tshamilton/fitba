<?php
include 'utility.php';

function table($in_t, $nC, $type) {
	if ($type == "minor") {
		##=((Size+(nCol-mod))/nCol)
		#$the_count = 0;
		#$size = sizeof($in_t)-1;
		#$colLength = ($size+($nC-($size % $nC)))/$nC;
		#print "<p>N => ".sizeof($in_t).", C -> ".$nC." thf. L = ".$colLength."</p>\n";
		#print t(5)."<div class=\"row\">\n";
		#print t(5)."<div class=\"col-sm-1\">\n";
		#foreach ($in_t as $N => $P) {
		#	print t(6)."<div class=\"team mx-1 my-2 ".strrev($N)."\"><span> ".$N." (".$P.") </span></div>\n";
		#	if ($the_count == $colLength) {
		#		print t(5)."</div>\n";
		#		print t(5)."<div class=\"col-sm-1\">\n";
		#		$the_count = 0;
		#	}
		#	$the_count += 1;
		#}
		#print t(5)."</div>\n";
		#print t(5)."</div>\n";
		print "\$in_t has ".sizeof($in_t)." elements across ".$nC." columns.<br/>\n";
		$mC = floor(sizeof($in_t) / $nC);
		print "So, ".$mC." entries for ".($nC-1)." columns and ".(sizeof($in_t) % $nC)." for the last.<br/>\n";
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
								<div style="border: 1px solid #0000ff; box-sizing: border-box;" class="team mx-1 my-2 wa"><span> a - azure - 3366ff </span></div>
								<div style="border: 1px solid #000099; box-sizing: border-box;" class="team mx-1 my-2 wb"><span> b - blue - 0000ff </span></div>
								<div style="border: 1px solid #4c0022; box-sizing: border-box;" class="team mx-1 my-2 wc"><span> c - claret - 990044 </span></div>
								<div style="border: 1px solid #660000; box-sizing: border-box;" class="team mx-1 my-2 wd"><span> d - blood - cc0000 </span></div>
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
								<div style="border: 1px solid #555555;" class="team mx-1 my-2 ks"><span> s - silver - aaaaaa </span></div>
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
			</div>
			</div><!-- End tab panel -->
			<div role="tabpanel" class="tab-pane container-fluid fade theNation slate" id="colours" name="colours">
			<div class="container-fluid">
				<h1 class="text-center"> Colours </h1>
				<h2 class="text-center"> Minor Styles </h2>
				<div class="d-flex justify-content-center clearfix my-3 darkSlate theCompBody">
				<div class="container-fluid p-4">
<?php
	$countMnS = array();
	foreach ($Stats["countByMinor"] as $S => $c) {
		$countMnS[strrev($S)] = $c;
	}
	ksort($countMnS);
	table($countMnS, 12, 'minor');
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
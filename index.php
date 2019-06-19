<?php
	include 'backend.php';
	function aasort (&$array, $key) {
		$sorter=array();
		$ret=array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		asort($sorter);
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		$array=$ret;
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

?>
<!doctype html>
<html lang="en">
	<head>
		<title>Fitba News</title>
		<link rel="shortcut icon" type="image/png" href="image/favicon.ico"/>
		<!-- Required meta tags -->
		<meta name="apple-mobile-web-app-title" content="Fitba">
		<meta name="application-name" content="Fitba">
		<meta name="msapplication-TileColor" content="#2d89ef">
		<meta name="theme-color" content="#ffffff">
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
		<link rel="apple-touch-icon" sizes="180x180" href="image/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="image/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="image/favicon-16x16.png">
		<link rel="manifest" href="image/site.webmanifest">
		<link rel="mask-icon" href="image/safari-pinned-tab.svg" color="#2d89ef">
	</head>
	<body>
		<ul class="nav nav-pills nav-fill fixed-top theTabBody">
<?php
	doTabs($tablist);
?>
		</ul>

<!-- Tab panes -->
		<div class="tab-content theBody">
<?php
	doNations($News);
?>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>
<!doctype html>
<html lang="en">
<head>
	<title>Fitba News</title>
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
<?php

$string = file_get_contents('./config/stats.json');
$Stats = json_decode($string, true);

$json_string = json_encode($Stats, JSON_PRETTY_PRINT);
$json_string = preg_replace("/\n/", "<br/>\n", $json_string);
$json_string = preg_replace("/\s\s\s\s/", "<span style=\"margin-left: 30px;\"></span>", $json_string);
print $json_string;
?>
</body>
</html>
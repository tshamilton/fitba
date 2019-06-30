<?php
include 'readData.php';
$nCount = 0;
$tCount = 0;
$alphaTable = "<div style='width: 100%; float: left;'><table>\n";
#$countTable = "<div style='width: 45%; float: right;'><table>\n";

session_start();
?>
<html>
<head>
	<title>Map Config</title>
</head>
<body>
<?php
//pretty_var($MAR);
$tabCount = 0;

foreach ($NAT as $n) {
	if (count($MAR[$n['tri']]) > 0) { 
		$nCount++;
		$sz = " - (".count($MAR[$n['tri']]).")";
		$tCount += count($MAR[$n['tri']]);
		if ($tabCount == 0) {
			$alphaTable .= "<tr>";
		}
		$alphaTable .= "<td> <a href=\"map_page.php?lat=".$n['lat']."&lng=".$n['lng']."&z=".$n['zom']."&t=".$n['tri']."&n=".$n['dis']."\" target=\"_new\">".$n['dis'].$sz."</a> </td>\n";
		if ($tabCount == 3) {
			$alphaTable .= "</tr>\n";
			$tabCount = 0;
		}
		else {
			$tabCount += 1;
		}
	}
}

if ($tabCount) {
	$alphaTable .= "</tr>\n";
}

$alphaTable .= "</table>\n";

print $alphaTable;
print "<div style='width: 100%; float: clear'>\n";
print $nCount." countries. ".$tCount." teams mapped so far.<br/>\n";
print "</div>\n";
?>
</body>
</html>
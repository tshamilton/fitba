<?php
	function pretty_var($myArray, $colour = 'ff0000', $s = "p") {
		global $tGroup;

		if ($s == "i") {
			$tGroup .= "<div id='debug' style='background-color: #".$colour.";'>\n";
			$tGroup .= str_replace(array("\n"," "),array("<br>","&nbsp;"), var_export($myArray,true))."<br>\n";
			$tGroup .= "</div>\n";
		}
		elseif ($s == "p") {
			print "<div id='debug' style='background-color: #".$colour.";'>\n";
			print utf8_encode(str_replace(array("\n"," "),array("<br>","&nbsp;"), var_export($myArray,true))."<br>\n");
			print "</div>\n";
		}
	}

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

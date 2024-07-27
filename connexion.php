<?php
try {
	//$db = new PDO('mysql:host=localhost;dbname=zulf8960_tbo;charset=UTF8', 'zulf8960_user', 'R@F+24em]A9e');
	$db = new PDO('mysql:host=localhost;dbname=tbo', 'root', '');
} catch (Exception $e) {
	echo "Erreur " . $e->getMessage();
}
$db->query("SET lc_time_names = 'fr_FR';");
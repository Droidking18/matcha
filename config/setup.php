<?php

include ("config.php");
try {
createInitialDatabase();
$conn = getDB();
createTableDatabase($conn);
}
catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
?>

<?php
$fp = fopen("log.html", "r+");
ftruncate($fp, 0);
fclose($fp);
header("Location: index.php?logout=true");
?>

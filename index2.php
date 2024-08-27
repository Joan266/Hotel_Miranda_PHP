<?php
$jsonData = file_get_contents('rooms.json');

$rooms = json_decode($jsonData, true);
?>

<pre><?php print_r($rooms); ?></pre>

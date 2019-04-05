<?php
$db = new PDO('mysql:host=localhost;dbname=programmingcompetition;charset=utf8', 'root', 'GR3bXmtcZm');
//$db = new PDO('mysql:host=localhost;dbname=noobTest;charset=utf8', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
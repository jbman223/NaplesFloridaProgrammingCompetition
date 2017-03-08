<?php
/* CONFIGURE DATABASE SETTINGS */
$db_username = "";
$db_password = "";
$db_host = "";
$db_database_name = "";


/* DB CONNECTION - EDIT IF NEEDED */
$db = new PDO('mysql:host='.$db_host.';dbname='.$db_database_name.';charset=utf8', $db_username, $db_password);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
<?php
require_once "require.php";
$state = $db->prepare("SELECT message FROM alerts WHERE start_time < ? AND end_time > ?");
$state->execute(array(time(), time()));
$alerts = $state->fetchAll(PDO::FETCH_ASSOC);

if (count($alerts) != 0) {
    die(json_encode(array("message" => $alerts[0]['message'])));
} else {
    die(json_encode(array("error" => "No alerts.")));
}
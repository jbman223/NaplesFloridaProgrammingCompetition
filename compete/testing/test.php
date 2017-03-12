<?php
require_once "../content/require.php";

$state = $db->prepare("select * from teams");
$state->execute(array());

$teams = $state->fetchAll(PDO::FETCH_ASSOC);

$state = $db->prepare("update teams set quick_access_code = ? where id = ?");
foreach ($teams as $team) {
    $state->execute(array(md5($team['id'].$team['backendLogin'].$team['backendPassword'].rand(0,9999).uniqid()), $team['id']));
}
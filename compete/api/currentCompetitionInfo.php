<?php
require_once "../content/require.php";

$state = $db->prepare("select * from competition_sections where removed = false and start <= ? and `end` >= ?");
$state->execute(array(time(), time()));

$competitionSections = $state->fetchAll(PDO::FETCH_ASSOC);

if (count($competitionSections) == 0) {
    die(json_encode(array("error" => "No upcoming competitions.")));
}

$currentSection = $competitionSections[0];

$state = $db->prepare("select * from competitions where id = ?");
$state->execute(array($currentSection['competition_id']));

$competition = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($competition) == 0) {
    die(json_encode(array("error" => "No upcoming competitions.")));
}
$competition = $competition[0];

$release = array();
$release['current_competition_name'] = $competition['competition_name'];
$release['current_competition_section'] = $currentSection['section_name'];
$release['time_remaining'] = $currentSection['end']-time();
die(json_encode($release));
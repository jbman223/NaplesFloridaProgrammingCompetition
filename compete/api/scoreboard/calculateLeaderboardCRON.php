<?php
require_once "/var/www/programmingcompetition.org/compete/content/require.php";

$state = $db->prepare("select * from competition_sections where start <= ? and end >= ?");
$state->execute(array(time(), time()));

$currentSections = $state->fetchAll(PDO::FETCH_ASSOC);

foreach ($currentSections as $section) {
    $scoreboard = generateScoreboard($section['id']);
    asort($scoreboard);

    $state = $db->prepare("insert into competition_section_scoreboards (section_id, scoreboard_data) values (?, ?) on duplicate key update scoreboard_data = ?");
    $state->execute(array($section['id'], $scoreboard, $scoreboard));
}
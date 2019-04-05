<?php
require_once "/var/www/programmingcompetition.org/competitionSite/assets/require.php";
$state = $db->prepare("SELECT * FROM admin_scheduled_competitions WHERE end_time < ? OR `delete` = 1");
$state->execute(array(time()));
$oldComps = $state->fetchAll();

foreach ($oldComps as $comp) {
    if ($comp['delete'] == 1) {
        $state = $db->prepare("SELECT * FROM problems WHERE competition_id = ?");
        $state->execute(array($comp['id']));
        $problems = $state->fetchAll();
        $state = $db->prepare("DELETE FROM problems WHERE id = ?");
        foreach ($problems as $problem) {
            system("rm -rf ".escapeshellarg($problem['base_path']));
            $state->execute(array($problem['id']));
        }

        $state = $db->prepare("DELETE FROM admin_scheduled_competitions WHERE id = ?");
        $state->execute(array($comp['id']));
    } else if ($comp['delete'] == -1) {
        //do nothing
    } else {
        $state = $db->prepare("UPDATE admin_scheduled_competitions SET `delete` = ? WHERE id = ?");
        $state->execute(array(1, $comp['id']));
    }
}

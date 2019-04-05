<?php
require_once "/var/www/programmingcompetition.org/competitionSite/assets/require.php";

//calculate number of competing teams
$state = $db->prepare("SELECT * FROM teams WHERE deleted != ? AND admin != ?");
$state->execute(array(1, 1));
$teams = $state->fetchAll();
$teamCount = count($teams);

//get the current competition ID
$state = $db->prepare("SELECT field_value FROM admin_current_competition");
$state->execute();
$fInfo = $state->fetchAll(PDO::FETCH_NUM);
$competitionID = intval($fInfo[3][0]);

if (!filter_var($fInfo[1][0], FILTER_VALIDATE_BOOLEAN)) {
    die();
}

//load all current problems
$state = $db->prepare("SELECT * FROM problems WHERE competition_id = ?");
$state->execute(array($competitionID));
$problems = $state->fetchAll();

#echo "loaded";

$scoreboard = array();

$teamIDs = array();
$teamNames = array();
$problemNames = array();

foreach ($teams as $team) {
    $scoreboard[$team['id']]['team_name'] = $team['team_name'];
    $scoreboard[$team['id']]['problems'] = array();
    array_push($teamIDs, $team['id']);
    array_push($teamNames, $team['team_name']);
}

foreach ($problems as $problem) {
    //load all solves
    array_push($problemNames, $problem['problem_title']);

    $state = $db->prepare("SELECT * FROM solved_problems WHERE competition_id = ? AND problem_id = ? ORDER BY `time` ASC");
    $state->execute(array($competitionID, $problem['id']));
    $solvedProblems = $state->fetchAll();
    $solvedProblemsCount = count($solvedProblems);
    $i = 0;

    foreach ($solvedProblems as $sp) {
        $scoreboard[$sp['team_id']]['problems'][$problem['id']]['points'] = $i;
        $scoreboard[$sp['team_id']]['problems'][$problem['id']]['solved'] = true;
        $i++;
    }

    foreach ($teams as $team) {
        if (!isset($scoreboard[$team['id']]['problems'][$problem['id']])) {
            $scoreboard[$team['id']]['problems'][$problem['id']]['points'] = $solvedProblemsCount + 10;
            $scoreboard[$team['id']]['problems'][$problem['id']]['solved'] = false;
        }
    }
}

//calculate totals
foreach ($teams as $team) {
    $total = 0;
    foreach ($scoreboard[$team['id']]['problems'] as $problem) {
        $total += $problem['points'];
    }

    $scoreboard[$team['id']]['total_points'] = $total;
}

$scoreboard['team_ids'] = $teamIDs;
$scoreboard['team_name'] = $teamNames;
$scoreboard['problem_names'] = $problemNames;

$scoreboard = json_encode($scoreboard);

$state = $db->prepare("INSERT INTO scoreboards (scoreboard_data, competition_id, last_update) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE id = id, scoreboard_data = ?, last_update = ?");
$state->execute(array($scoreboard, $competitionID, time(), $scoreboard, time()));
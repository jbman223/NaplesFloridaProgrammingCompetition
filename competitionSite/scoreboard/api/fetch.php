<?php
require_once "../../assets/require.php";
header('Content-type: application/json');

$state = $db->prepare("SELECT field_value FROM admin_current_competition");
$state->execute();
$fInfo = $state->fetchAll(PDO::FETCH_NUM);
$inComp = filter_var($fInfo[1][0], FILTER_VALIDATE_BOOLEAN);
$competitionID = intval($fInfo[3][0]);

if (isset($_GET['id'])) {
    $inComp = true;
    $competitionID = $_GET['id'];
}


if (!$inComp) {
    die(json_encode(array("error" => "Not currently in a competition.")));
}

if (!isset($competitionID)) {
    $competitionID = intval($fInfo[3][0]);
}

$state = $db->prepare("SELECT scoreboard_data FROM scoreboards WHERE competition_id = ?");
$state->execute(array($competitionID));
echo (json_encode($state->fetchAll()[0]['scoreboard_data']));
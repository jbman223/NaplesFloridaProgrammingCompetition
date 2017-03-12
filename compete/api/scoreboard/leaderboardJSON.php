<?php
require_once "/var/www/programmingcompetition.org/compete/content/require.php";
require_once "calculateLeaderboard.php";

if (isset($_POST['id'])) {
    $sorted = generateScoreboard($_POST['id']);
    asort($sorted);
    die(json_encode($sorted));
} else {
    die(json_encode(array("error" => "Nope.")));
}
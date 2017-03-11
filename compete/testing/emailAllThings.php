<?php
require_once "../content/require.php";

$state = $db->prepare("select c.*, t.backendLogin, t.backendPassword, t.quick_access_code from competitors c inner join teams t on c.team_id = t.id where t.deleted = 0 and c.deleted = 0");
$state->execute(array());

$competitors = $state->fetchAll(PDO::FETCH_ASSOC);

foreach ($competitors as $competitor) {
    echo ucfirst($competitor['f_name'])." ".ucfirst($competitor['l_name'])." ".ucwords($competitor['school'])." ".$competitor['team_name']." ".$competitor['quick_access_code']."<br />";
}
<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}


if (isset($_POST['competition_name'], $_POST['competition_description'])) {
    if (isset($_POST['competition_id'])) {
        $state = $db->prepare("update competitions set competition_name = ?, competition_notes = ? where id = ?");
        $state->execute(array(htmlspecialchars($_POST['competition_name']), htmlspecialchars($_POST['competition_description']), $_POST['competition_id']));
        die(json_encode(array("success" => "Competition updated")));

    } else {
        $state = $db->prepare("insert into competitions (competition_name, competition_notes) values (?, ?)");
        $state->execute(array(htmlspecialchars($_POST['competition_name']), htmlspecialchars($_POST['competition_description'])));
        die(json_encode(array("success" => "Competition created")));
    }
} else if (isset($_GET['id'])) {
    $state = $db->prepare("select * from competitions where id = ?");
    $state->execute(array($_GET['id']));
    $competition = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($competition) == 1) {
        die(json_encode($competition[0]));
    } else {
        die(json_encode(array("error" => "No competition found.")));
    }
} else {
    die(json_encode(array("error" => "All required fields were not received.")));
}

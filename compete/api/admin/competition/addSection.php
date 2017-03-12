<?php
require_once "../../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST['section_name'], $_POST['start'], $_POST['end'], $_POST['competition_id'])) {
    if (($start = strtotime($_POST['start'])) === false) {
        die(json_encode(array("error" => "Invalid start time.")));
    }

    if (($end = strtotime($_POST['end'])) === false) {
        die(json_encode(array("error" => "Invalid end time.")));
    }

    if ($start > $end) {
        die(json_encode(array("error" => "The competition cannot end before it starts.")));
    }

    if (isset($_POST['section_id'])) {
        $state = $db->prepare("update competition_sections set section_name = ?, start = ?, `end` = ? where id = ?");
        $state->execute(array(htmlspecialchars($_POST['section_name']), $start, $end, $_POST['section_id']));
        die(json_encode(array("success" => "Section updated.")));
    } else {
        $state = $db->prepare("insert into competition_sections (section_name, start, `end`, competition_id) values (?, ?, ?, ?)");
        $state->execute(array(htmlspecialchars($_POST['section_name']), $start, $end, $_POST['competition_id']));
        die(json_encode(array("success" => "Section created.")));
    }
}
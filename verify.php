<?php
require_once "includes/require.php";
if (isset($_GET['id'])) {
    $state = $db->prepare("SELECT *, COUNT(*) FROM verification WHERE verify_code = ?");
    $state->execute(array($_GET['id']));
    $ret = $state->fetchAll(PDO::FETCH_ASSOC);
    if ($ret[0]['COUNT(*)'] == 1 && $ret[0]['complete'] == 0) {
        $state = $db->prepare("UPDATE verification SET complete = ? WHERE verify_code = ?");
        $state->execute(array(1, $_GET['id']));
        if ($ret[0]['type'] == 0) {
            $state = $db->prepare("UPDATE users SET email_verified = ? WHERE id = ?");
            $state->execute(array(1, $ret[0]['for_id']));
            header("Location: login.php");
            die();
        } else if ($ret[0]['type'] == 1) {
            $state = $db->prepare("UPDATE competitors SET verified = ? WHERE id = ?");
            $state->execute(array(1, $ret[0]['for_id']));
            header("Location: about.php");
            die();
        }
    } else {
        header("Location: index.php");
        die();
    }
} else {
    header("Location: index.php");
    die();
}
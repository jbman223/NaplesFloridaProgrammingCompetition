<?php
require_once "../../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../../../account/login.php");
}
if (!$user['admin']) {
    header("Location: ../../../account/login.php");
}


?>
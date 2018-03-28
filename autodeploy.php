<?php
echo "hi!";
//autodeploy git repo
$event = $_SERVER['HTTP_X_GITHUB_EVENT'];
$guid = $_SERVER['HTTP_X_GITHUB_DELIVERY'];

if ($event != "push" && $event != "ping") {
    echo $event;
    die("Unsupported event.");
}
ob_start();
var_dump($_POST);
$log = fopen("gitlog.txt", "w+");
fwrite($log, ob_get_clean());
fwrite($log, "\n");
fflush($log);
fclose($log);
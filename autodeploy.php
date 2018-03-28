<?php
echo "hi!";
//autodeploy git repo
$event = $_SERVER['HTTP_X_GITHUB_EVENT'];
$guid = $_SERVER['HTTP_X_GITHUB_DELIVERY'];

if ($event != "push" && $event != "ping") {
    echo $event;
    die("Unsupported event.");
}

$log = fopen("gitlog.txt", "w+");
fwrite($log, var_dump($_POST));
fwrite($log, "\n");
fflush($log);
fclose($log);
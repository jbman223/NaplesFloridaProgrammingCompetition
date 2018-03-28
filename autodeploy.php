<?php
echo "hi!";
//autodeploy git repo
$event = $_SERVER['X-GitHub-Event'];
$guid = $_SERVER['X-GitHub-Delivery'];

if ($event != "push" && $event != "ping") {
    die("Unsupported event.");
}

$log = fopen("gitlog.txt", "w+");
fwrite($log, var_dump($_POST));
fwrite($log, "\n");
fflush($log);
fclose($log);
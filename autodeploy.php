<?php
echo "hi!";
//autodeploy git repo
$event = $_SERVER['HTTP_X_GITHUB_EVENT'];
$guid = $_SERVER['HTTP_X_GITHUB_DELIVERY'];

if ($event != "push" && $event != "ping") {
    die("Unsupported event.");
}

$log = fopen("gitlog.txt", "w+");

$payload = json_decode($_POST['payload']);
if ($payload["ref"] == "refs/heads/master") {
    fwrite($log, "AUTODEPLOY FROM MASTER\n");
}


ob_start();
var_dump($_POST);
fwrite($log, ob_get_clean());
fwrite($log, "\n");
fflush($log);
fclose($log);
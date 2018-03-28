<?php
echo "hi!";
//autodeploy git repo
$event = $_SERVER['HTTP_X_GITHUB_EVENT'];
$guid = $_SERVER['HTTP_X_GITHUB_DELIVERY'];

if ($event != "push" && $event != "ping") {
    die("Unsupported event.");
}

$log = fopen("gitlog.txt", "a");

$payload = json_decode($_POST['payload']);
if ($payload->ref == "refs/heads/master") {
    fwrite($log, "AUTODEPLOY FROM MASTER\n");
    //exec("cd ".__DIR__." && git pull");
}


fwrite($log, json_encode($payload));
fwrite($log, "\n");
fflush($log);
fclose($log);
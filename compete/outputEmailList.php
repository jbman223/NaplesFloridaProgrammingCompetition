<?php

require_once "content/require.php";
require_once "../api/mailAPI.php";

$state = $db->prepare("select email from users");
$state->execute();

$users = $state->fetchAll(PDO::FETCH_COLUMN);

$state = $db->prepare("select email from competitors");
$state->execute();

$competitors = $state->fetchAll(PDO::FETCH_COLUMN);

$teachers = array(
    //"marcfarron@swfrtp.org",
    //"deborahjohnson.naples@gmail.com",
    "RitaEE@LeeSchools.net",
    "PetersAd@collierschools.com",
    "greerc@collierschools.com",
    "MartinRi@collierschools.com",
    "CrowleSt@collierschools.com",
    "beckes@collierschools.com",
    "WilsonKe@collierschools.com",
    "SouzaLi@collierschools.com",
    "stahlc@collierschools.com",
    "AmityAC@LeeSchools.net",
    "DeniseCS@LeeSchools.Net",
    "CrowleSt@collierschools.com",
    "beckes@collierschools.com",
    "WilsonKe@collierschools.com"
);

$diff = array_merge($users, $competitors, $teachers);

$sent = array();

foreach ($diff as $d) {
    if (filter_var($d, FILTER_VALIDATE_EMAIL)) {
        if (!in_array(strtolower($d), $sent)) {
            //sendReminderEmail($d);
            //echo $d." - SENT <br />";
            $sent[] = $d;
        }
    }
}
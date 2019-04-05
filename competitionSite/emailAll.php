<?php
require_once "assets/require.php";
require_once "../mail/sendMail.php";

$state = $db->prepare("SELECT * FROM competitors WHERE deleted = 0");
$state->execute();
$competitors = $state->fetchAll();

foreach ($competitors as $competitor) {
    $name = $competitor['f_name'];
    $email = $competitor['email'];

    //print_r(sendReminder($email, $name));
}
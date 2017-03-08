<?php
require "../includes/require.php";
require_once "../api/mailAPI.php";

if (isset($_GET['code'])) {
    $state = $db->prepare("select * from users where verification_code = ? and verified = 0");
    $state->execute(array(md5($_GET['code'])));
    $user = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($user) == 1) {
        if (time() - $user[0]['verification_email_time'] <= 60*60*24) {
            $state = $db->prepare("update users set verified = 1 where id = ?");
            $state->execute(array($user[0]['id']));

            $_SESSION['result'] = array("success" => "Your email has been verified.");
            header("Location: login.php");
        } else {
            $newCode = generatePassword();
            $state = $db->prepare("update users set verification_code = ? and verification_email_time = ? where id = ?");
            $state->execute(array(md5($newCode), time(), $user[0]['id']));

            sendVerifyEmail($_POST['email'], $newCode);

            $_SESSION['result'] = array("error" => "The verification code is expired. A new verification code has been sent. Please check your email and use the new link.");
            header("Location: login.php");
        }
    } else {
        $_SESSION['result'] = array("error" => "The verification code was not found.");
        header("Location: login.php");
    }
}
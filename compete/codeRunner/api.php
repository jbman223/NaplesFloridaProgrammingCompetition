<?php
require_once "../content/require.php";
require_once "../../library/Requests.php";
ignore_user_abort(true);
Requests::register_autoloader();


$languages = array("java" => "java", "javascript" => "javascript", "c" => "c");

if (isset($_POST['code'], $_POST['input'], $_POST['language'])) {
    $url = "http://159.203.191.58:31337/eval/";
    $code = str_replace("public class", "class", $_POST['code']);
    $language = $languages[$_POST['language']];
    $input = $_POST['input'];

    $header = array('Content-Type' => 'application/json');
    $response = Requests::post($url, $header, json_encode(array("language" => $language, "code" => $code, "stdins" => [$input])));
    die($response->body);
}

die(json_encode(array("error" => "The required parameters were not received.")));

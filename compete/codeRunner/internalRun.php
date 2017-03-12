<?php
require_once "/var/www/programmingcompetition.org/library/Requests.php";
ignore_user_abort(true);
Requests::register_autoloader();

function run($lang, $input, $code)
{
    $languages = array("java" => 8, "c" => 7);

    $url = "http://159.203.168.143/compile";
    $code = str_replace("public class", "class", $code);
    $language = $languages[$lang];

    $header = array('Content-Type' => 'application/json');
    $response = Requests::post($url, $header, json_encode(array("language" => $language, "code" => $code, "stdin" => $input)));

    //$body = json_decode($response->body);
    //$body->errors = preg_replace('/Note:.+/g', '', $body->errors);
    //$response->body = json_encode($body);

    return $response->body;
}
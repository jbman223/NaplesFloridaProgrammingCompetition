<?php
require_once __DIR__."/../../library/Requests.php";
ignore_user_abort(true);
Requests::register_autoloader();

function run($lang, $input, $code)
{
    $languages = array("java" => "java", "javascript" => "javascript", "c" => "c", "python" => "python");

    $url = "http://178.128.144.215:31337/eval/";
    $code = str_replace("public class", "class", $code);
    $language = $languages[$lang];

    $header = array('Content-Type' => 'application/json');
    $response = Requests::post($url, $header, json_encode(array(
        "language" => $language, 
        "code" => $code, 
        "stdins" => [$input])));

    //$body = json_decode($response->body);
    //$body->errors = preg_replace('/Note:.+/g', '', $body->errors);
    //$response->body = json_encode($body);

    return $response->body;
}

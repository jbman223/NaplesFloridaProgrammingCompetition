<?php
$user = 'jbman223';
$pass = '8uddy8260930';

$client = new SoapClient("http://ideone.com/api/1/service.wsdl");

$submissionStatus = array(
    0 => 'Success',
    1 => 'Compiled',
    3 => 'Running',
    11 => 'Compilation Error - The program did not compile.',
    12 => 'Runtime Error - There was an error during the running of your program.',
    13 => 'Time Limit Exceeded - Your program took more than 5 seconds to complete running.',
    15 => 'Success',
    17 => 'Memory Limit Exceeded - Your program used too much memory.',
    19 => 'Illegal System Call',
    20 => 'Internal Error'
);

$languages = array("JAVA7" => 55, "JAVA8" => 10, "C" => 11, "PYTHON2" => 4, "PYTHON3" => 116, "C++4.3" => 41, "C++4.9" => 1);

function submitCode($sourceCode, $languageName, $input) {
    global $languages, $user, $pass;
    $client = new SoapClient("http://ideone.com/api/1/service.wsdl");
    $result = $client->createSubmission($user, $pass, $sourceCode, $languages[$languageName], $input, true, false);
    return $result;
}

function submissionStatus($link) {
    global $user, $pass;
    $client = new SoapClient("http://ideone.com/api/1/service.wsdl");
    $status = $client->getSubmissionStatus($user, $pass, $link);
    return $status;
}

function submissionResult($link) {
    global $user, $pass;
    $client = new SoapClient("http://ideone.com/api/1/service.wsdl");
    $details = $client->getSubmissionDetails($user, $pass, $link, true, true, true, true, true);
    return $details;
}
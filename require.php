<?php
use CSRFLib\CSRF;
session_start();
require_once "db.php";
require_once "CSRFLib/CSRF.php";
$csrf = new CSRF();


$gaCode = "
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58370294-1', 'auto');
  ga('send', 'pageview');

</script>
";

function isUserLoggedIn() {
    return isset($_SESSION['id']);
}

function generateUsername() {
    $restraunts = "arbys chickfila tacobell mcdonalds moes chipotle zaxsbys quidoba carrabas outback target publix walmart";
    $items = "fries drink shake chips napkin straw dinner breakfast lunch";
    $restraunts = explode(" ", $restraunts);
    $items = explode(" ", $items);
    $rand1 = rand(0, count($restraunts)-1);
    $rand2 = rand(0, count($items)-1);
    return $restraunts[$rand1].ucfirst($items[$rand2]).rand(10, 99);
}

function generatePassword() {
    $words = "lolipop barley arugula wheat cereal oats churro salty hot dogs fire salt steak meat burger sweet sour grapes bun bread taco burrito enchilada salsa guacamole empanada";
    $words = explode(" ", $words);
    $rand1 = rand(0, count($words)-1);
    $rand2 = rand(0, count($words)-1);
    return $words[$rand1].ucfirst($words[$rand2]).rand(10, 999);
}
<?php
require_once "db.php";
session_start();

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

function user() {
    global $db;
    $state = $db->prepare("select * from users where id = ?");
    $state->execute(array($_SESSION['id']));
    $user = $state->fetchAll(PDO::FETCH_ASSOC);
    if (count($user) > 0) {
        return $user[0];
    }
    return false;
}

<?php
require_once "../../includes/require.php";
if (!isUserLoggedIn()) {
    header("Location: ../index.php");
    die();
}

$state = $db->prepare("SELECT * FROM users where id = ?");
$state->execute(array($_SESSION['id']));
$user = $state->fetchAll(PDO::FETCH_ASSOC)[0];

if ($user['level'] < 1) {
    header("Location: ../index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Administration</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Account Administration</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <a href="users"><h2>Manage users</h2></a>
                    </div>
                </div>

            </div>
        </div>


    </div>
</body>
</html>
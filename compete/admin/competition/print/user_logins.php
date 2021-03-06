<?php
require_once "../../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../../../account/login.php");
}
if (!$user['admin']) {
    header("Location: ../../../account/login.php");
}

$state = $db->prepare("SELECT team_name, backendLogin, backendPassword FROM `teams` where admin = 0 and deleted = 0");
$state->execute();
$teams = $state->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Competition - <? echo $competition['competition_name'] ?></title>


    <link rel="stylesheet" href="../../../../css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<table class="table">
    <thead>
        <tr>
            <th>Team Name</th>
            <th>Login</th>
            <th>Password</th>
        </tr>
    </thead>
    <tbody>

    <?php
    foreach ($teams as $team) {
        ?>
    <tr>
        <td><?php echo $team["team_name"]; ?></td>
        <td><?php echo $team["backendLogin"]; ?></td>
        <td><?php echo $team["backendPassword"]; ?></td>
    </tr>
        <?php
    }
    ?>

    </tbody>
</table>

</body>
</html>
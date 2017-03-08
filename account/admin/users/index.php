<?php
require_once "../../../includes/require.php";

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

    <title>The Naples Florida Programming Competition - User Administration</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="/account/admin">Administration</a></li>
                            <li class="active">Users</li>
                        </ol>

                        <h1 class="text-center">
                            Manage User Accounts
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-10">
                        <table class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <td>Email Address</td>
                                <td>Name</td>
                                <td>Email Verified</td>
                                <td>Reset Password</td>
                                <td>Send Message</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $state = $db->prepare("select * from users");
                            $state->execute();
                            $users = $state->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($users as $user) {
                                ?>
                                <tr>
                                    <td><? echo $user['email']; ?></td>
                                    <td><? echo $user['username']; ?></td>
                                    <td><? echo ($user['verified'] == 1)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>'; ?></td>
                                    <td><a href="newPassword.php?id=<? echo $user['id']; ?>" class="btn btn-default">Reset</a></td>
                                    <td><a href="message.php?id=<? echo $user['id']; ?>" class="btn btn-default">Message</a></td>
                                </tr>
                                <?
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>


    </div>
</body>
</html>
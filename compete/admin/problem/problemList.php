<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: /compete/account/login.php");
}
if (!$user['admin']) {
    header("Location: /compete/account/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Problem List</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

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
                        <ol class="breadcrumb">
                            <li><a href="../">Administration</a></li>
                            <li><a href="index.php">Problem Center</a></li>
                            <li class="active">Problem List</li>
                        </ol>

                        <h1 class="text-center">
                            Problem Listing
                        </h1>
                    </div>
                </div>

                <table class="table table-bordered table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Problem</th>
                        <th>Remove Problem</th>
                        <th>Problem Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $state = $db->prepare("select * from problem_data where removed = false");
                    $state->execute();

                    $problems = $state->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($problems as $problem) {
                        ?>
                        <tr>
                            <td><a href="problem.php?id=<? echo $problem["id"]; ?>"><? echo $problem["problem_title"]!=""?$problem["problem_title"]:"Unnamed"; ?></a></td>
                            <td><a href="removeProblem.php?id=<? echo $problem["id"]; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                            <td class="<? echo status($problem["problem_status"])[1] ?>"><? echo status($problem["problem_status"])[0]; ?></td>
                        </tr>
                        <?
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</body>
</html>
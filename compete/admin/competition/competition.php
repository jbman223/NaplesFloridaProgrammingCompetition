<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../../account/login.php");
}
if (!$user['admin']) {
    header("Location: ../../account/login.php");
}
if (!isset($_GET['id'])) {
    header("Location: competitionList.php");
}

$state = $db->prepare("select * from competitions where id = ?");
$state->execute(array($_GET['id']));

$competition = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($competition) == 0) {
    header("Location: index.php");
    die();
}
$competition = $competition[0];

$state = $db->prepare("select * from competition_sections where competition_id = ? and removed = false order by start");
$state->execute(array($competition['id']));

$competitionSections = $state->fetchAll(PDO::FETCH_ASSOC);

$state = $db->prepare("select problems.id, problem_data.id as problem_id, problem_data.problem_title, sections.section_name, sections.id as section_id from competition_section_problems problems inner join competition_sections sections on sections.id = problems.section_id inner join problem_data problem_data on problem_data.id = problems.problem_id  where sections.competition_id = ? and problems.removed = false");
$state->execute(array($competition['id']));
$problems = $state->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Competition - <? echo $competition['competition_name'] ?></title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

    <script src="http://159.203.168.143:8080/socket.io/socket.io.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="../">Administration</a></li>
                            <li><a href="index.php">Competition Manager</a></li>
                            <li><a href="competitionList.php">Competition List</a></li>
                            <li class="active"><? echo $competition['competition_name']; ?></li>
                        </ol>

                        <h1 class="pull-left" style="margin-top:0;">
                            <? echo $competition['competition_name']; ?>
                        </h1>

                        <div class="btn-group pull-right" role="group" aria-label="...">
                            <a type="button" href="newCompetition.php?id=<? echo $competition['id']; ?>"
                               class="btn btn-default">Edit Competition</a>
                            <a type="button" href="removeCompetition.php?id=<? echo $competition['id']; ?>"
                               class="btn btn-danger">Delete Competition</a>
                        </div>
                    </div>
                </div>

                <!-- PAGE CONTENT HERE -->

                <div class="row">
                    <div class="col-md-3">

                        <p class="lead">
                            <? echo $competition['competition_notes']; ?>
                        </p>

                        <a href="liveScreen.php?id=<? echo $competition['id']; ?>" class="btn btn-block btn-default">Competition Live Screen</a>
                        <a href="../../forum" class="btn btn-block btn-default">Competition Forum</a>
                        <a href="liveReview.php?id=<? echo $competition['id']; ?>" class="btn btn-block btn-default">Live Problem Review</a>
                        <a href="#" class="refresh btn btn-block btn-default">Refresh All</a>
                        <a href="#" class="play btn btn-block btn-default">Play Video</a>

                        <small>Print Resources</small>

                        <a href="http://programmingcompetition.org/competitionSite/test.php" class="btn btn-block btn-default">User Logins</a>
                        <a href="http://programmingcompetition.org/competitionSite/test2.php" class="btn btn-block btn-default">Registration Sheet</a>

                        <br />

                        <a href="finalReport.php?id1=8&id2=9" class="btn btn-block btn-success">Final Score Sheet</a>

                    </div>

                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Competition Sections</h3>
                            </div>
                            <div class="panel-body">
                                <?
                                if (count($competitionSections) > 0) {
                                    ?>
                                    <table class="table table-bordered">

                                        <thead>
                                        <tr>
                                            <th>Section Name</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Edit</th>
                                            <th>Print</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?
                                        foreach ($competitionSections as $section) {
                                            ?>
                                            <tr data-sectionid="<? echo $section['id']; ?>">
                                                <td class="section-name"><? echo $section['section_name']; ?></td>
                                                <td class="section-start"><? echo date("F jS Y, g:ia", $section['start']); ?></td>
                                                <td class="section-end"><? echo date("F jS Y, g:ia", $section['end']); ?></td>
                                                <td class="button-cell"><a href="#"
                                                                           class="btn btn-sm btn-primary edit-button">Edit</a>
                                                </td>
                                                <td><a href="print.php?id=<? echo $section['id']; ?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-print"></span></a></td>
                                                <td>
                                                    <a href="removeSection.php?id=<? echo $section['id']; ?>&competition_id=<? echo $competition['id']; ?>"
                                                       class="btn btn-sm btn-danger">Delete</a></td>
                                            </tr>
                                            <?
                                        }
                                        ?>
                                        </tbody>

                                    </table>
                                    <?
                                } else {
                                    ?>
                                    <h3>There are no competition sections added yet.</h3>
                                    <?
                                }
                                ?>


                                <div style="margin-top: 15px;border-top:solid #ddd 1px;padding-top:5px;">

                                    <h3 style="margin-top:0;">Add A Section</h3>

                                    <div class="alert alert-danger" style="margin-bottom: 5px;display: none;">

                                    </div>

                                    <form class="form-inline add-section">
                                        <input type="hidden" name="competition_id"
                                               value="<? echo $competition['id'] ?>"/>

                                        <div class="form-group">
                                            <input class="form-control" placeholder="Section Name" type="text"
                                                   name="section_name"/>
                                        </div>

                                        <div class="form-group">
                                            <input class="form-control" placeholder="Start" type="datetime"
                                                   name="start"/>
                                        </div>

                                        <div class="form-group">
                                            <input class="form-control" placeholder="End" type="datetime" name="end"/>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Add Section</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Problems</h3>
                            </div>
                            <div class="panel-body">
                                <?
                                if (count($problems) > 0) {

                                    ?>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Problem Name</th>
                                            <th>Section Name</th>
                                            <th>Remove Problem</th>
                                            <th>Rescore</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?

                                        foreach ($problems as $problem) {
                                            ?>

                                            <tr>
                                                <td><a href="../problem/problem.php?id=<? echo $problem['problem_id']; ?>"><? echo $problem['problem_title']; ?></a></td>
                                                <td><? echo $problem['section_name']; ?></td>
                                                <td><a href="removeProblem.php?id=<? echo $problem['id'] ?>&competition_id=<? echo $competition['id']; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                                                <td><a href="#" data-problemid="<? echo $problem['problem_id']; ?>" data-sectionid="<? echo $problem['section_id']; ?>" class="rescore btn btn-default btn-sm"><span class="glyphicon glyphicon-refresh"></span></a></td>
                                            </tr>

                                            <?
                                        }

                                        ?>
                                        </tbody>
                                    </table>
                                    <?

                                } else {
                                    ?>
                                    <h3>No problems found.</h3>
                                    <?
                                }
                                ?>

                                <div style="margin-top: 15px;border-top:solid #ddd 1px;padding-top:5px;">

                                    <h3 style="margin-top:0;">Add A Problem</h3>

                                    <div class="alert alert-danger" style="margin-bottom: 5px;display: none;">

                                    </div>

                                    <form class="form-inline add-problem">

                                        <div class="form-group">
                                            <label for="section_id">Section</label>
                                            <select class="form-control" name="section_id" id="section_id"
                                                    style="width:200px;">
                                                <?
                                                foreach ($competitionSections as $section) {
                                                    ?>
                                                    <option
                                                        value="<? echo $section['id']; ?>"><? echo $section['section_name']; ?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="problem_id">Problem</label>
                                            <select class="form-control" name="problem_id" id="problem_id"
                                                    style="width:200px;">
                                                <?
                                                $state = $db->prepare("select * from problem_data where removed = false");
                                                $state->execute(array());

                                                $problems = $state->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($problems as $problem) {
                                                    ?>
                                                    <option
                                                        value="<? echo $problem['id']; ?>"><? echo $problem['problem_title']; ?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Add Problem</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


    </div>

    <script src="../../js/admin/competition.js"></script>
    <script src="../../js/liveEvents.js"></script>
</body>
</html>
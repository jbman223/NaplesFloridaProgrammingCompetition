<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

$state = $db->prepare("select t.*, teams.team_name from threads t inner join competition_sections cs on t.section_id = cs.id inner join teams teams on teams.id = t.team_id where cs.start <= ? and cs.end >= ? and t.deleted = false order by t.id desc");
$state->execute(array(time(), time()));

$threads = $state->fetchAll(PDO::FETCH_ASSOC);

$state = $db->prepare("select cs.*, c.competition_name from competition_sections cs inner join competitions c on cs.competition_id = c.id where cs.start <= ? and cs.end >= ?");
$state->execute(array(time(), time()));

$sections = $state->fetchAll(PDO::FETCH_ASSOC);

$problems = array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Submit A Solution</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../js/jquery.timeago.js" type="text/javascript"></script>

    <script src="http://159.203.168.143:8080/socket.io/socket.io.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Clarifications</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Create New Clarification Request</h3>
                            </div>
                            <div class="panel-body">
                                <?
                                if (count($sections) > 0) {
                                    ?>
                                    <form class="problem">
                                        <div class="form-group">
                                            <label for="clarificationType">Clarification Type</label>
                                            <select id="clarificationType" class="form-control"
                                                    name="clarification_type">
                                                <option value="Question Error">Question Clarification</option>
                                                <option value="Computer Error/Question">Computer Error/Question</option>
                                                <option value="Website Error/Question">Website Error/Question</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="competitionSection">Select Competition</label>
                                            <select class="form-control" id="competitionSection"
                                                    name="competition_section">
                                                <?
                                                $state = $db->prepare("select pd.problem_title, pd.id, csp.section_id as section_id from competition_section_problems csp inner join problem_data pd on csp.problem_id = pd.id where csp.section_id = ? ");

                                                foreach ($sections as $section) {
                                                    $state->execute(array($section['id']));
                                                    $problem = $state->fetchAll(PDO::FETCH_ASSOC);
                                                    $problems = array_merge($problems, $problem);

                                                    ?>
                                                    <option
                                                        value="<? echo $section['id']; ?>"><? echo $section['section_name']; ?>
                                                        - <? echo $section['competition_name']; ?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="hidden-question">
                                            <div class="form-group">
                                                <label for="clarificationTitle">
                                                    Title
                                                </label>
                                                <input type="text" class="form-control" id="clarificationTitle"
                                                       name="clarification_title"/>
                                            </div>
                                        </div>

                                        <div class="hidden-non-question">
                                            <div class="form-group">
                                                <label for="problemID">Select Problem</label>
                                                <select class="form-control" id="problemID" name="problem_id">
                                                    <?
                                                    foreach ($problems as $problem) {

                                                        ?>
                                                        <option
                                                            value="<? echo $problem['id']; ?>"
                                                            data-sectionid="<? echo $problem['section_id']; ?>"><? echo $problem['problem_title']; ?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="message">Detail Your Issue</label>
                                            <textarea class="form-control" id="message" name="message"></textarea>

                                            <p class="help-block">
                                                Please do not include any code, or your dispute will be immediately
                                                closed.
                                            </p>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-primary submit" type="submit">Request Clarification
                                            </button>
                                        </div>
                                    </form>
                                    <?
                                } else {
                                    ?>
                                    <h3>There are no ongoing competitions to submit a clarification request for.</h3>
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 threads">

                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade code-display" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body code-area">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <? require_once "../content/footer.php"; ?>
    <script src="../js/forum.js"></script>
    <script src="../js/liveEvents.js"></script>
</body>
</html>
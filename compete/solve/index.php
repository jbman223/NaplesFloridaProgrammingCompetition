<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

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
                        <h1 class="text-center">Submit A Solution</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?
                        if (count($sections) > 0) {
                            ?>
                            <form class="form-horizontal problem">
                                <div class="form-group">
                                    <label for="competitionSection">Select Competition</label>
                                    <select class="form-control" id="competitionSection" name="competition_section">
                                        <?
                                        $state = $db->prepare("select pd.problem_title, pd.id, csp.section_id as section_id from competition_section_problems csp inner join problem_data pd on csp.problem_id = pd.id where csp.section_id = ? ");



                                        foreach ($sections as $section) {
                                            $state->execute(array($section['id']));
                                            $problem = $state->fetchAll(PDO::FETCH_ASSOC);
                                            $problems = array_merge($problems, $problem);

                                            ?>
                                            <option
                                                value="<? echo $section['id']; ?>"><? echo $section['section_name']; ?> - <? echo $section['competition_name']; ?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="problemID">Select Problem - <a href="#" id="competitor_view">View Problem Description</a></label>
                                    <select class="form-control" id="problemID" name="problem_id">
                                        <?
                                        $state = $db->prepare("select * from solved_problems where team_id = ? and problem_id = ? and correct = 1 and section_id <> 7");
                                        foreach ($problems as $problem) {
                                            $state->execute(array($user['id'], $problem['id']));

                                            if (count($state->fetchAll(PDO::FETCH_ASSOC)) == 0) {
                                                ?>
                                                <option
                                                    value="<? echo $problem['id']; ?>" data-sectionid="<? echo $problem['section_id']; ?>"><? echo $problem['problem_title']; ?></option>
                                                <?
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="code">Your Code</label>
                                    <textarea class="form-control" id="code" name="problem_code" rows="10"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <select class="form-control" name="language" id="language">
                                        <option value="java">Java</option>
                                        <option value="javascript">Javascript</option>
                                        <option value="c">C/C++</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary submit" type="submit">Check Solution</button>
                                </div>
                            </form>
                            <?
                        } else {
                            ?>
                            <h2>There are no ongoing competitions to submit a solution for.</h2>
                            <?
                        }
                        ?>
                    </div>
                    <div class="col-md-6 messages">

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
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <? require_once "../content/footer.php"; ?>

    <script src="../js/solve.js"></script>
    <script src="../js/liveEvents.js"></script>
</body>
</html>
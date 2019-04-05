<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
}

$state = $db->prepare("select t.*, teams.team_name from threads t inner join teams teams on teams.id = t.team_id where t.id = ?");
$state->execute(array($_GET['id']));

$thread = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($thread) > 0) {
    $thread = $thread[0];
}

$state = $db->prepare("select r.*, t.team_name from replies r inner join teams t on r.poster_id = t.id where thread_id = ?");
$state->execute(array($thread['id']));

$replies = $state->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><? echo $thread['subject'] ?> - View Thread</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="http://programmingcompetition.org/compete/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../js/jquery.timeago.js" type="text/javascript"></script>

    <script src="http://ws.programmingcompetition.org:8080/socket.io/socket.io.js"></script>

    <? echo $gaCode; ?>
</head>

<body>
<input type="hidden" name="thread_id" value="<? echo $thread['id']; ?>" />
<div class="container-fluid">

    <? require_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="../">Home</a></li>
                            <li><a href="index.php">Clarifications</a></li>
                            <li class="active"><? echo $thread['subject']; ?></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="container-fluid">
                            <div data-id="<? echo $thread['id']; ?>" class="row">
                                <div class="col-md-8">
                                    <h2><? echo $thread['subject']; ?></h2>

                                    <p class="lead">
                                        <? echo $thread['message']; ?>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <p><b>Posted By: </b><? echo $thread['team_name']; ?> (
                                            <time class="timeago"
                                                  datetime="<? echo date(DATE_ISO8601, $thread['post_time']); ?>"><? echo date(DATE_ISO8601, $thread['post_time']); ?></time>
                                            )
                                        </p>

                                        <p><? echo ($thread['title'] == "Question Error") ? "<a href=\"#\" data-id=\"" . $thread['problem_id'] . "\" id=\"competitor_view\">View Question Description</a>" : ""; ?></p>

                                        <? if ($user['admin']) { ?>
                                            <p><a href="#" class="remove btn btn-danger">Remove Thread</a></p>

                                            <? if (!$thread['solved']) { ?>
                                                <p><a href="#" class="solve btn btn-success">Mark Solved</a></p>
                                            <? } else { ?>
                                                <p><a href="#" class="solve btn btn-default">Unsolve</a></p>
                                            <?  } ?>
                                        <? } ?>
                                    </div>

                                </div>
                            </div>

                            <div class="replies">
                            </div>

                            <hr/>

                            <div class="row">
                                <div class="col-md-12">
                                    <h3 style="margin-top: 0;">Write a response</h3>

                                    <form class="reply">
                                        <input name="thread_id" type="hidden" value="<? echo $thread['id']; ?>"/>

                                        <div class="form-group">
                                            <label for="message">
                                                Response
                                            </label>
                                            <textarea id="message" name="message" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary pull-right">Post</button>
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
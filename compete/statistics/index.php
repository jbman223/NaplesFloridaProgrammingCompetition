<?php
require_once "../content/require.php";

if (isset($_GET['access_code'])) {
    session_unset();
    $state = $db->prepare("select * from teams where quick_access_code = ?");
    $state->execute(array($_GET['access_code']));

    $teams = $state->fetchAll(PDO::FETCH_ASSOC);
    if (count($teams) > 0) {
        $teams = $teams[0];
    }

    $_SESSION['competition_site_id'] = $teams['id'];

    header("location: index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Competition Stats</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <script src="http://159.203.168.143:8080/socket.io/socket.io.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>

    <script>hljs.initHighlightingOnLoad();</script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <!-- PAGE CONTENT HERE -->
                        <h1>2018 NFPC Review</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <p class="lead text-justify">
                            Thanks to everybody who came to make the 2018 Naples Florida Programming Competition the
                            best one yet. We are very happy with this year's outcome, and we look forward to helping
                            this event continue and grow in the community for many years to come. If you would like to
                            get in touch with Jacob about the event, please email <a
                                href="mailto:jbuckheit2016@communityschoolofnaples.org">jbuckheit2016@communityschoolofnaples.org</a>.
                            Below, you can find details of all the problems from this year's competition, along with the
                            sample solution code. Sign in to see your code.
                        </p>
                    </div>

                    <div class="col-md-3 hidden-sm hidden-xs text-center">

                        <h3>Press Information</h3>

                        <a href="/downloads/2016/Naples%20Florida%20Programming%20Competition%202016.docx"
                           target="_blank" class="btn btn-default btn-block"><span
                                class="glyphicon glyphicon-download"></span> Press Release</a>
                        <a href="/downloads/2016/Competitors.xlsx" target="_blank"
                           class="btn btn-success btn-block"><span
                                class="glyphicon glyphicon-user"></span> Result Sheet</a>
                        <a href="https://www.dropbox.com/sh/4gchw7i3ax04kv4/AAByyzWdm9KN1b6N9OWzXEU8a?dl=0"
                           target="_blank" class="btn btn-info btn-block"><span
                                class="glyphicon glyphicon-picture"></span> Photo Album</a>
                        <a href="https://youtu.be/HXhp5_1_EuQ" target="_blank" class="btn btn-danger btn-block"><span
                                class="glyphicon glyphicon-play-circle"></span> View Site Tutorial</a>

                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="text-center"
                             style="width: 100%;height: 300px; background: url('/images/index/IMG_8289.jpg') no-repeat left; background-size: auto 300px; border-radius: 10px; color: white;display: flex; justify-content:center; align-content:center; flex-direction:column;">
                            <h1><a href="/2016" style="color: white;text-shadow:1px 1px 3px rgba(0, 0, 0, 0.5);">View
                                    This Year's Story</a></h1>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-12 col-sm-6 hidden-lg hidden-md text-center">

                        <h3>Press Information</h3>

                        <a href="/downloads/2016/Naples%20Florida%20Programming%20Competition%202016.docx"
                           target="_blank" class="btn btn-default btn-block"><span
                                class="glyphicon glyphicon-download"></span> Press Release</a>
                        <a href="/downloads/2016/Competitors.xlsx" target="_blank"
                           class="btn btn-success btn-block"><span
                                class="glyphicon glyphicon-user"></span> Result Sheet & Competitors</a>
                        <a href="https://www.dropbox.com/sh/4gchw7i3ax04kv4/AAByyzWdm9KN1b6N9OWzXEU8a?dl=0"
                           target="_blank" class="btn btn-info btn-block"><span
                                class="glyphicon glyphicon-picture"></span> Photo Album</a>
                        <a href="https://youtu.be/HXhp5_1_EuQ" target="_blank" class="btn btn-danger btn-block"><span
                                class="glyphicon glyphicon-play-circle"></span> View Site Tutorial</a>

                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12">
                        <?
                        $state = $db->prepare("select * from competition_sections where id in (16, 17, 18)");
                        $state->execute();
                        $sections = $state->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($sections as $section) {
                            ?>

                            <h2><? echo $section['section_name']; ?></h2>
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Problem</th>
                                        <th># Correctly Solved</th>
                                        <th>View NFPC Solution</th>
                                        <th>View Your Code & Results</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                    $state = $db->prepare("select pd.*, (select count(*) from solved_problems sp inner join teams t on sp.team_id = t.id where section_id = ? and problem_id = pd.id and correct = 1 and t.admin = 0) as solved_count from competition_section_problems csp inner join problem_data pd on csp.problem_id = pd.id where csp.section_id = ? and pd.removed = 0 and csp.removed = 0");
                                    $state->execute(array($section['id'], $section['id']));
                                    $problems = $state->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($problems as $problem) {
                                        ?>
                                        <tr>
                                            <td><a href="description.php?id=<? echo $problem['id']; ?>"
                                                   class="loadModally"><? echo $problem['problem_title']; ?></a></td>
                                            <td>
                                                <a href="correct.php?pid=<? echo $problem['id']; ?>&sid=<? echo $section['id']; ?>"
                                                   class="loadModally"><? echo $problem['solved_count'] ?></a></td>
                                            <td><a href="description.php?id=<? echo $problem['id']; ?>&solution=yes"
                                                   class="btn btn-sm btn-default loadModally">View Solution</a></td>
                                            <td>
                                                <? if (isUserLoggedIn()) {
                                                    ?>
                                                    <a href="submissions.php?sid=<? echo $section['id']; ?>&pid=<? echo $problem['id']; ?>"
                                                       class="loadModally">View Your Submissions</a>
                                                    <?
                                                } else {
                                                    ?>
                                                    <a href="../account/login.php" class="btn btn-sm btn-default">Log in
                                                        to
                                                        see your solutions</a>
                                                    <?
                                                } ?>
                                            </td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <?
                        }
                        ?>

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

<div class="modal fade ajax-display" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script type="text/javascript">
    $(".loadModally").click(function (e) {
        e.preventDefault();
        var loc = $(this).attr("href");
        $.get(loc, function (data) {
            $(".ajax-display .modal-body").html(data);
            $('pre code').each(function (i, block) {
                hljs.highlightBlock(block);
            });
            $(".ajax-display").modal("show");
        }, "html");
    })
</script>
</body>
</html>
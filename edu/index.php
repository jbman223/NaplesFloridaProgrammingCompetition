<?
require_once "api/require.php";

$currentProblem = null;
$currentProblemData = null;
$progress = null;

if (!isset($_SESSION['id'])) {
    header("location: landingPage.php");
    die();
}

if (isset($_SESSION['currentProblem'])) {
    $state = $db->prepare("select * from edu_problems where id = ?");
    $state->execute(array($_SESSION['currentProblem']));

    $problems = $state->fetchAll(PDO::FETCH_ASSOC);

    $currentProblem = $problems[0];

    $state = $db->prepare("select * from edu_problem_state where user_id = ? and edu_problem_id = ? order by `time` desc");
    $state->execute(array($_SESSION['id'], $_SESSION['currentProblem']));
    $currentProblemData = $state->fetchAll(PDO::FETCH_ASSOC)[0];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The official Naples Florida Programming Competition.">
    <meta name="author" content="Jacob Buckheit">
    <link rel="icon" href="../favicon.ico">

    <title>NFPC EDU</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jb.css" rel="stylesheet">
    <link href="codemirror/lib/codemirror.css" rel="stylesheet">
    <link href="codemirror/addon/hint/show-hint.css" rel="stylesheet">
    <link href="codemirror/theme/ambiance.css" rel="stylesheet">
    <link href="codemirror/theme/ambiance-mobile.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <? echo $gaCode; ?>

    <style>
        .darken {
            filter: brightness(0.2);
            transition: filter 0.3s;
        }

        .blurry {
            filter: blur(3px);
            transition: filter 0.4s;
        }

        .notBlurry {
            filter: blur(0px);
        }

        .compiling {
            background-color: #4a4a4a;
            color: white;
            border-radius: 3px;
            z-index: 999;
            padding: 10px;
            position: absolute;
            top: 40%;
            left: 40%;
            max-width: 200px;
            text-align: center;
            box-shadow: 3px 4px 8px #363636;
        }

        /* necessary part */
        canvas.highlight {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            opacity: 0.7;
            -webkit-transition: opacity 250ms ease;
            transition: opacity 250ms ease;
            -webkit-animation: canvasFade 250ms ease;
            animation: canvasFade 250ms ease;
            z-index: 9999;
        }

        @-webkit-keyframes canvasFade {
            from {
                opacity: 0;
            }
            to {
                opacity: 0.5;
            }
        }

        @keyframes canvasFade {
            from {
                opacity: 0;
            }
            to {
                opacity: 0.5;
            }
        }

        .clear-alert {
            position: absolute;
            top: 60px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 15px;
            margin: 5px;
            border-radius: 5px;
            z-index: 999;
            display: none;
        }

        .loading {
            z-index: 999;
            padding: 10px;

            width: 100%;
            height: 100%;

            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;

            position: absolute;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;

            margin: auto;
        }
    </style>
</head>

<body >
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../index.php">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><? echo ($currentProblem == null) ? "Problems" : $currentProblem["problem_name"]; ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?
                        if ($currentProblem != null) {
                            $state = $db->prepare("select * from edu_problems where id != ?");
                            $state->execute(array($currentProblem["id"]));
                        } else {
                            $state = $db->prepare("select * from edu_problems");
                            $state->execute();
                        }
                        $problems = $state->fetchAll(PDO::FETCH_ASSOC);
                        if (count($problems) == 0) {
                            ?>
                            <li>No other problems found.</li>
                            <?
                        } else {
                            foreach ($problems as $problem) {
                                ?>
                                <li><a href="api/change.php?id=<? echo $problem["id"]; ?>"
                                       class="problem-link"><? echo $problem["problem_name"]; ?></a></li>
                                <?
                            }
                        }
                        ?>
                    </ul>
                </li>
                <? if (!isUserLoggedIn()) {
                    ?>
                    <li class="navbar-text">Welcome, Guest.</li>

                    <li><a href="#" class="stopVideo" data-toggle="modal" data-target="#login-modal">Sign In</a></li>
                    <li><a href="../register.php">Sign Up</a></li>
                    <?
                } else {
                    $user = user();
                    ?>
                    <li class="navbar-text">Welcome, <? echo $user["email"] ?>.</li>

                    <li><a href="../account.php">Account</a></li>
                    <li><a href="../logout.php">Log Out</a></li>
                    <?
                } ?>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
<div class="container-fluid weird">
    <div class="row">
        <div class="col-md-6 col-sm-6" style="padding-left:15px;padding-right:15px;">
            <div class="row">
                <div class="col-md-12">
                    <div id="player">
                    </div>
                </div>
            </div>
            <div class="row" style="background: white;">
                <div class="col-md-6" style="padding:5px;">
                    <p class="text-center">Input</p>
                    <textarea id="input" class="form-control" style="width:100%;height: 25vh;"></textarea>
                </div>
                <div class="col-md-6" style="padding:5px;">
                    <p class="text-center">Output</p>
                    <pre id="output" style="width:100%;height: 25vh;"></pre>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="col-md-12">
                <div class="controls">
                    <div class="row" style="padding: 2px 2px; margin-left: 0; margin-right: 0; background: #3D3D3D;">
                        <div class="col-md-6">
                            <button class="btn btn-info saveCode">Save Code <span class="glyphicon glyphicon-floppy-save"></span>
                            </button>

                            <button class="btn btn-warning viewProblem">View Problem
                            </button>

                            <div class="btn-group" role="group" style="margin-top:3px;margin-bottom:2px;">
                                <button class="btn btn-default sampleCode">Load Sample Code
                                </button>

                                <button class="btn btn-default sampleInput">Load Sample Input
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center help-text" style="color: #ffffff;display:none;"></p>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success pull-right compile">Run Code <span
                                    class="glyphicon glyphicon-play-circle"></span></button>
                        </div>
                    </div>
                </div>
                <div class="editorDIV" style="background: #3D3D3D;">
                    <textarea id="code" style="width: 100%;"><? echo $currentProblemData['code']; ?></textarea>
                </div>

                <div class="compiling" style="display:none;">
                    <img src="../sliderPhotos/spiffygif_32x32.gif" style="padding-bottom: 7px;"/>

                    <p class="lead">Please wait while your code is running...</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h1>Login to Your Account</h1><br>

            <div class="alert alert-danger" style="display: none;"></div>
            <div class="alert alert-success" style="display: none;"></div>
            <form id="loginForm">
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" name="login" class="login loginmodal-submit" value="Login">
            </form>

            <div class="login-help">
                <a href="../register.php">Sign up for a ProgrammingCompetition.org account.</a>
            </div>
        </div>
    </div>
</div>

<div class="clear-alert">
    <p class="lead">This is a little alert that will pop up in the corner bro. Hello source lurker :)</p>
</div>

<div class="modal descriptionModal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="codemirror/lib/codemirror.js"></script>
<script src="codemirror/addon/edit/matchbrackets.js"></script>
<script src="codemirror/addon/edit/closebrackets.js"></script>
<script src="codemirror/addon/hint/show-hint.js"></script>
<script src="codemirror/mode/clike/clike.js"></script>
<script src="https://youtube.com/iframe_api"></script>
<script>
    var padding = 0;
    function openOverlay(elem) {
        var loc = elem.getBoundingClientRect();
        var canvas = document.createElement("canvas");
        canvas.className = "highlight";
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        var ctx = canvas.getContext("2d");
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.clearRect(loc.left - padding, loc.top - padding, loc.width + padding * 2, loc.height + padding * 2);
        document.body.appendChild(canvas);
        window.overlayCanvas = canvas;
        canvas.onclick = closeOverlay;
    }

    function closeOverlay() {
        var self = window.overlayCanvas;
        delete window.overlayCanvas;
        this.style.opacity = 0;
        //var self = this;
        setTimeout(function () {
            self.parentNode.removeChild(self);
        }, 100);
    }
</script>
<script>
    var problemId = <? echo ($currentProblem == null)?0:$currentProblem['id']; ?>;

    var alertCount = 0;
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player("player", {
            videoId: 'UROWSU3NEYQ',
            events: {
                'onReady': playerReady,
                'onStateChange': playerStateChange
            },
            playerVars: {
                'controls': 0,
                'rel': 0,
                'showinfo': 0,
                'loop': 1
            }
        });
    }

    function playerReady(event) {
        player.getIframe().style = "width: 100%; height: 65vh;";

        <? if (isset($currentProblem['youtube_video_link']) && $currentProblem['youtube_video_link'] != "") { ?>
        player.loadVideoById('<? echo $currentProblem['youtube_video_link']; ?>', 0, 'hd720');
        <? } ?>
        event.target.playVideo();
    }

    function playerStateChange(event) {
    }

    $(".stopVideo").click(function () {
        player.target.pauseVideo();
    });

    function closeHelp() {
        setTimeout(function () {
            $(".clear-alert").fadeOut("slow");
        }, 2000);
    }

    $(".clear-alert").on("click", function (e) {
        $(this).fadeOut("slow");
    });

    $(".saveCode").click(function () {
        saveCode();
    });

    function saveCode() {
        var button = $(".saveCode");
        var helpText = $(".clear-alert");

        button.addClass("disabled");
        $.post("api/saveCode.php", {code : editor.getValue()}, function (data) {

            $(".saveCode").removeClass("disabled");

            $(".clear-alert").text("Code saved.");
            $(".clear-alert").fadeIn("slow", function () {
                closeHelp();
            });
        }, "text");
    }

    function autoFormat() {
        var totalLines = editor.lineCount();
        var totalChars = editor.getTextArea().value.length;
        editor.autoFormatRange({line:0, ch:0}, {line:totalLines, ch:totalChars});
    }

    var editor;
    $(function () {
        editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            matchBrackets: true,
            styleActiveLine: true,
            autoCloseBrackets: true,
            lineWrapping: false,
            indentUnit: 4,
            tabSize: 4,
            mode: "text/x-java"

        });
        editor.setOption("theme", "ambiance");
        if (editor.getValue() == "") {
            editor.setValue("public class HelloWorld {\n" +
                "\tpublic static void main(String[] args) {\n" +
                "\t\tSystem.out.println(\"hello world\");\n" +
                "\t}\n" +
                "}");
        }
    });

    $(".viewProblem").click(function (e) {
        var modal = $('.descriptionModal');
        $.get("api/description.php", function (data) {
            var name = data.name;
            var description = data.description;
            modal.find(".modal-title").text(name);
            modal.find(".modal-body").html(description);
            modal.modal();
        }, "json");
    });

    $(".sampleCode").click(function (e) {
        var button = $(this);
        button.addClass("disabled");
        var helpText = $(".clear-alert");

        $.get("api/sampleCode.php", function (data) {
            helpText.text("Loaded sample code and sample input.");
            helpText.fadeIn("slow", function () {
                closeHelp();
            });
            button.removeClass("disabled");
            editor.setValue(data.code);
            $("#input").val(data.input);
        }, "json");
    });

    $(".sampleInput").click(function (e) {
        var button = $(this);
        button.addClass("disabled");
        var helpText = $(".clear-alert");

        $.get("api/sampleCode.php", function (data) {
            helpText.text("Loaded sample code and sample input.");
            helpText.fadeIn("slow", function () {
                closeHelp();
            });
            button.removeClass("disabled");

            $("#input").val(data.input);
        }, "json");
    });

    $(".compile").click(function (e) {
        $(".editorDIV").addClass("darken");
        $(".compiling").fadeIn("slow");

        var code = editor.getValue();
        var language = "java";
        var input = $("#input").val();
        var button = $(this);

        button.addClass("disabled");

        var helpText = $(".clear-alert");

        if (code.length == 0) {
            helpText.text("Please enter some code!");
            helpText.fadeIn("slow", function () {
                closeHelp();
            });
            button.removeClass("disabled");
            $(".compiling").fadeOut("fast");
            $(".editorDIV").removeClass("darken");
            return;
        } else {
            helpText.text("");
        }

        saveCode();

        helpText.text("Compiling and running code...");
        $.post("api/submitCode.php", {code: code, language: language, input: input}, function (data) {
            console.log(data);
            console.log(data.output);
            $("#output").text(data.output).append("<span style='color:red;'>" + data.errors + "</span>");
            button.removeClass("disabled");
            $(".compiling").fadeOut("fast");
            $(".editorDIV").removeClass("darken");

            helpText.text("Code compiled successfully.");
            helpText.fadeIn("slow", function () {
                closeHelp();
            });
        }, "json").fail(function () {
            $("#output").append("<span style='color:red;'>Code timed out.</span>");
            button.removeClass("disabled");
            $(".compiling").fadeOut("fast");
            $(".editorDIV").removeClass("darken");

            helpText.text("Code running timed out.");
            helpText.fadeIn("slow", function () {
                closeHelp();
            });
        });
    });

    $("#loginForm").submit(function (e) {
        e.preventDefault();

        var errorAlert = $(this).parent().children(".alert-danger");
        var successAlert = $(this).parent().children(".alert-success");

        var email = $("input[name=email]").val();
        var password = $("input[name=password]").val();
        $.post("../account/login.php", {email: email, password: password}, function (data) {
            if (data.error) {
                successAlert.hide("fast", function () {
                    errorAlert.text(data.error).show("fast");
                });
            } else {
                errorAlert.hide("fast", function () {
                    successAlert.text(data.success).show("fast", function () {
                        window.location.reload();
                    });
                });
            }
        }, "json");
    });
</script>
</body>
</html>

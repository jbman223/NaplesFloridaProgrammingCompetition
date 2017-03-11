<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: account/login.php");
}
if (!$user['admin']) {
    header("Location: /account/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Create New Problem</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({
            selector: '#problem_description',
            height: 300,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect fontsizeselect | forecolor backcolor bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'preview media | forecolor backcolor emoticons',
            image_advtab: true
        });</script>

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
                            <li class="active">New Problem</li>
                        </ol>

                        <h1 class="text-center">
                            <? echo isset($_GET['id'])?"Create New":"Edit"; ?> Problem
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal create">
                            <fieldset>
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="problem_name">Problem Name</label>

                                    <div class="col-md-10">
                                        <input id="problem_name" name="problem_name" placeholder="Name"
                                               class="form-control input-md" type="text">

                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="problem_description">Problem
                                        Description</label>

                                    <div class="col-md-10">
                            <textarea class="form-control" id="problem_description"
                                      name="problem_description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="problem_sample_input">Problem Correctness
                                        Guidelines</label>

                                    <div class="col-md-10">
                                        <div class="well " style="max-height: 150px;overflow:scroll;">

                                            <ol>
                                                <ol>
                                                    <li dir="ltr">
                                                        <p dir="ltr">
                                                            Ensuring problem correctness
                                                        </p>
                                                    </li>
                                                    <ol>
                                                        <li dir="ltr">
                                                            <p dir="ltr">
                                                                Problems will be produced with only human produced
                                                                inputs.
                                                            </p>
                                                        </li>
                                                        <li dir="ltr">
                                                            <p dir="ltr">
                                                                Problem Inputs and Outputs
                                                            </p>
                                                        </li>
                                                        <ol>
                                                            <li dir="ltr">
                                                                <p dir="ltr">
                                                                    Each problem may have up to 5 sample inputs and
                                                                    outputs. These are shown to the competitors. If
                                                                    there are any &quot;trick cases,&quot; these may
                                                                    not be included in the sample inputs.
                                                                </p>
                                                            </li>
                                                            <li dir="ltr">
                                                                <p dir="ltr">
                                                                    Each problem may have up to 25 human generated
                                                                    official inputs with matching outputs. These are the
                                                                    inputs which will be used to test
                                                                    problems for correctness on the day of the
                                                                    competition.
                                                                </p>
                                                            </li>
                                                            <li dir="ltr">
                                                                <p dir="ltr">
                                                                    Official and sample inputs and outputs must be
                                                                    vetted using the same process as the questions as a
                                                                    whole.
                                                                </p>
                                                            </li>
                                                        </ol>
                                                        <li dir="ltr">
                                                            <p dir="ltr">
                                                                Problems must be submitted to the website, and printed
                                                                on official review forms.
                                                            </p>
                                                        </li>
                                                        <li dir="ltr">
                                                            <p dir="ltr">
                                                                Each problem must be read by at least 5 independent
                                                                reviewers, who will not be competing in the competition,
                                                                in order to ensure there are
                                                                no typos or mistakes.
                                                            </p>
                                                        </li>
                                                        <li dir="ltr">
                                                            <p dir="ltr">
                                                                Each problem must be solved completely and correctly,
                                                                without any assistance, by at least 3 independent
                                                                reviewers.
                                                            </p>
                                                        </li>
                                                        <li dir="ltr">
                                                            <p dir="ltr">
                                                                After all of the above conditions are met, a problem
                                                                will be approved for use in the competition.
                                                            </p>
                                                        </li>
                                                        <li dir="ltr">
                                                            <p dir="ltr">
                                                                All problems must be completed and reviewed at least one
                                                                month prior to the date of the competition.
                                                            </p>
                                                        </li>
                                                    </ol>
                                                    <li dir="ltr">
                                                        <p dir="ltr">
                                                            All problems presented in the competition are considered
                                                            final. The problem inputs and outputs are considered correct
                                                            on the day of the
                                                            competition.
                                                        </p>
                                                    </li>
                                                </ol>
                                            </ol>

                                        </div>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="problem_sample_input">Problem Sample
                                        Input</label>

                                    <div class="col-md-10">
                            <textarea class="form-control" id="problem_sample_input"
                                      name="problem_sample_input"></textarea>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="problem_sample_output">Problem Sample
                                        Output</label>

                                    <div class="col-md-10">
                            <textarea class="form-control" id="problem_sample_output"
                                      name="problem_sample_output"></textarea>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="problem_input">Problem Input</label>

                                    <div class="col-md-10">
                            <textarea class="form-control" id="problem_input"
                                      name="problem_input"></textarea>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="problem_output">Problem Output</label>

                                    <div class="col-md-10">
                            <textarea class="form-control" id="problem_output"
                                      name="problem_output"></textarea>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="code">Problem Solution Code</label>

                                    <div class="col-md-10">
                                        <textarea class="form-control" id="code" name="code"></textarea>
                                    </div>
                                </div>

                                <!-- Multiple Checkboxes -->
                                <div class="form-group">
                                    <div class="col-md-2">

                                    </div>
                                    <div class="col-md-10">
                                        <div class="checkbox">
                                            <label for="checkboxes-0">
                                                <input name="checkboxes" id="checkboxes-0" value="1" type="checkbox">
                                                I confirm that this problem follows the <b>problem correctness
                                                    guidelines</b>.
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <?

                                if (isset($_GET['id'])) {
                                    ?>
                                    <input name="id" type="hidden" value="<? echo $_GET['id']; ?>" />
                                    <?
                                }

                                ?>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="submit"></label>

                                    <div class="col-md-4">
                                        <button id="submit" name="submit" class="btn btn-primary">Create Problem
                                        </button>
                                    </div>
                                </div>


                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="../../js/newProblem.js"></script>
</body>
</html>
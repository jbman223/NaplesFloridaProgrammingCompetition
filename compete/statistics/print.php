<?php
require_once "../content/require.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Print</title>


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

<div class="container-fluid" style="background: white;">

    <?
    if (isset($_GET['id'], $_GET['solution'])) {
        $state = $db->prepare("select * from problem_data where id = ?");
        $state->execute(array($_GET['id']));
        $problem = $state->fetchAll(PDO::FETCH_ASSOC);
        if (count($problem) > 0) {
            $problem = $problem[0];
            ?>
            <pre class=""><code class="java github"><? echo $problem['problem_code']; ?></code></pre>
            <?
        } else {
            ?>
            <pre>Problem ID not found.</pre>
            <?
        }
    } else if (isset($_GET['id'])) {
        $state = $db->prepare("select * from problem_data where id = ?");
        $state->execute(array($_GET['id']));
        $problem = $state->fetchAll(PDO::FETCH_ASSOC);
        if (count($problem) > 0) {
            $problem = $problem[0];
            ?>
            <h1 class="text-center"><? echo $problem['problem_title']; ?></h1>
            <? echo $problem['problem_description']; ?>
            <hr/>
            <h2>SAMPLE INPUT: </h2>
            <pre class="well well-sm"><? echo $problem['problem_sample_input']; ?></pre>

            <h2>SAMPLE OUTPUT: </h2>
            <pre class="well well-sm"><? echo $problem['problem_sample_output']; ?></pre>
            <?
        } else {
            ?>
            <pre>Problem ID not found.</pre>
            <?
        }
    } else {
        ?>
        <pre>Problem ID not found.</pre>
        <?
    }

    ?>

</div>
</body>
</html>
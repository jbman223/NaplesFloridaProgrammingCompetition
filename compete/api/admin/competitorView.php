<?php
require_once "../../content/require.php";

if (!isset($_GET['password'])) {

    if (!isUserLoggedIn()) {
        die();
    }
    if (!$user['admin']) {
        die();
    }
} else {
    $state = $db->prepare("select * from reviewers where problem_id = ? and password = ?");
    $state->execute(array($_GET['id'], md5($_GET['password'])));
    $reviewers = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($reviewers) == 0) {
        die();
    }
}

if (isset($_GET['id'])) {
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
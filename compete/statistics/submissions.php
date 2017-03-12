<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    die("<h1>Must be logged in.</h1>");
}

if (isset($_GET['sid'], $_GET['pid'])) {
    $state = $db->prepare("select sp.correct, sp.id, sp.time, sp.language from solved_problems sp inner join code_results cr on cr.id = sp.code_result where sp.team_id = ? and sp.section_id = ? and sp.problem_id = ? and cr.run_time <> 0");
    $state->execute(array($user['id'], $_GET['sid'], $_GET['pid']));

    $solved = $state->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>View Submission</th>
            <th>Time</th>
            <th>Language</th>
            <th>Correct</th>
        </tr>
        </thead>

        <tbody>
        <?


        if (count($solved) == 0) {
            ?>
            <tr>
                <td colspan="4">No solutions submitted.</td>
            </tr>
            <?
        }

        foreach ($solved as $result) {
            ?>
            <tr>
                <td><a href="submission.php?id=<? echo $result['id']; ?>">View Code & Errors</a></td>
                <td><? echo date("F jS Y, g:ia", $result['time']); ?></td>
                <td><? echo $result['language']; ?></td>
                <td><? echo $result['correct'] == 1 ? "<span style='color:green;'>Correct</span>" : "<span style='color:red;'>Incorrect</span>"; ?></td>
            </tr>
            <?
        }
        ?>
        </tbody>
    </table>
    <?
} else {
    ?>
    <h1>Section id not found.</h1>
    <?
}
<?php
require_once "../content/require.php";

if (isset($_GET['pid'], $_GET['sid'])) {
    $state = $db->prepare("select t.team_name from solved_problems sp inner join teams t on sp.team_id = t.id where sp.section_id = ? and sp.problem_id = ? and correct = 1 and t.admin = 0");
    $state->execute(array($_GET['sid'], $_GET['pid']));

    $solved = $state->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table class="table table-bordered">

        <thead>
        <tr>
            <th>Team Name</th>
        </tr>
        </thead>

        <tbody>
        <?
        foreach ($solved as $result) {
            ?>
            <tr>
                <td><? echo $result['team_name']; ?></td>
            </tr>
            <?
        }
        ?>
        </tbody>

    </table>
    <?
} else {
    ?>
    <h1>NOPE</h1>
    <?
}
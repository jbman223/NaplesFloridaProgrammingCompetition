<?php
require_once "../../content/require.php";
require_once "calculateLeaderboard.php";

$state = $db->prepare("select * from teams where deleted = 0 and admin = 0");
$state->execute();

$teams = $state->fetchAll(PDO::FETCH_ASSOC);

$state = $db->prepare("select pd.problem_title, pd.id from competition_section_problems csp inner join problem_data pd on pd.id = csp.problem_id where csp.section_id = ? and csp.removed = 0");
$state->execute(array($_GET['id']));

$problems = $state->fetchAll(PDO::FETCH_ASSOC);
?>
<table class="table table-bordered">

    <thead>
    <tr>
        <th>Team Name</th>
        <? foreach ($problems as $problem) {
            ?>
            <th><? echo $problem['problem_title'] ?></th>
            <?
        } ?>
    </tr>
    </thead>

    <tbody>

    <?
    $state = $db->prepare("select * from solved_problems where problem_id = ? and section_id = ? and team_id = ? and correct = 1");
    foreach ($teams as $team) {
        ?>
        <tr>
            <th><? echo $team['team_name']; ?></th>

            <?
            foreach ($problems as $problem) {
                $state->execute(array($problem['id'], $_GET['id'], $team['id']));
                if (count($state->fetchAll(PDO::FETCH_ASSOC)) > 0) {
                    ?>
                    <td class="success text-center"><span class="glyphicon glyphicon-ok"></span></td>
                    <?
                } else {
                    ?>
                    <td class="text-center"><span class="glyphicon glyphicon-remove"></span></td>
                    <?
                }

            }
            ?>
        </tr>

        <?
    }

    ?>
    </tbody>
</table>

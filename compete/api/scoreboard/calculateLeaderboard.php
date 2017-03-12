<?php
function generateScoreboard($sectionID)
{
    global $db;

    if ($sectionID == 9)
        $base = 10;
    else
        $base = 10;


    $points = array();

    $state = $db->prepare("select id, team_name from teams where deleted = 0 and admin = 0");
    $state->execute();

    $teams = $state->fetchAll(PDO::FETCH_ASSOC);

    foreach ($teams as $team) {
        $points[$team['team_name']] = 0;
    }

    $state = $db->prepare("select pd.* from competition_section_problems csp inner join problem_data pd on csp.problem_id = pd.id where csp.section_id = ? and csp.removed = 0");
    $state->execute(array($sectionID));

    $problems = $state->fetchAll(PDO::FETCH_ASSOC);

    foreach ($problems as $problem) {
        $state = $db->prepare("select sp.*, t.team_name from solved_problems sp inner join teams t on sp.team_id = t.id where problem_id = ? and section_id = ? and sp.correct = 1 and t.admin = 0 and t.deleted = 0");
        $state->execute(array($problem['id'], $sectionID));

        $solutions = $state->fetchAll(PDO::FETCH_ASSOC);
        $additionals = 0;

        $theseTeams = array();
        foreach ($solutions as $solution) {
            if ($additionals == 0) {
                $additionals++;
            }

            $points[$solution['team_name']] += $additionals;
            $theseTeams[] = $solution['team_name'];

            $additionals = $additionals + 1;

        }

        foreach ($points as $teamName => $pointCount) {
            if (!in_array($teamName, $theseTeams)) {
                $points[$teamName] += $additionals + $base;
            }
        }
    }

    asort($points);

    return $points;
}

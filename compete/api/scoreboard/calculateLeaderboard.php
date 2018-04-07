<?php
function generateScoreboard($sectionID)
{
    global $db;

    if ($sectionID == 18)
        $base = 50;
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

function generateScoreboardQuiz($quizId)
{
    global $db;

    $state = $db->prepare("select * from quizzes where id = ?");
    $state->execute(array($quizId));

    $quiz = $state->fetchAll(PDO::FETCH_ASSOC);
    if (count($quiz) == 0) {
        die('error');
    }
    $quiz = $quiz[0];

    $state = $db->prepare("select * from quiz_questions where quiz_id = ?");
    $state->execute(array($quiz['id']));
    $questions = $state->fetchAll(PDO::FETCH_ASSOC);
    $question_count = count($questions);

    //get teams
    $state = $db->prepare("select * from teams where deleted = 0");
    $state->execute();
    $teams = $state->fetchAll(PDO::FETCH_ASSOC);


    $divisor = 4;
    $base_score = $question_count * (4 / $divisor);

    $correctState = $db->prepare("select * from quiz_answers qa inner join quiz_questions qq on qq.id = qa.quiz_question_id where qq.quiz_id = ? and team_id = ? and status = 1");
    $incorrectState = $db->prepare("select * from quiz_answers qa inner join quiz_questions qq on qq.id = qa.quiz_question_id where qq.quiz_id = ? and team_id = ? and status = -1");
    $points = array();

    foreach ($teams as $team) {
        $correctState->execute(array($quiz['id'], $team['id']));
        $correct = $correctState->fetchAll(PDO::FETCH_ASSOC);
        $correct_count = count($correct);
        $incorrectState->execute(array($quiz['id'], $team['id']));
        $incorrect = $incorrectState->fetchAll(PDO::FETCH_ASSOC);
        $incorrect_count = count($incorrect);

        $points[$team['team_name']] = $base_score - ($correct_count * (4 / $divisor)) + ($incorrect_count / $divisor);
    }

    asort($points);

    return $points;
}

<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die("<h1>Please refresh the page.</h1>");
}

$state = $db->prepare("select t.*, teams.team_name from threads t inner join competition_sections cs on t.section_id = cs.id inner join teams teams on teams.id = t.team_id where cs.start <= ? and cs.end >= ? and t.deleted = false order by t.id desc");
$state->execute(array(time(), time()));

$threads = $state->fetchAll(PDO::FETCH_ASSOC);

if (count($threads) > 0) {
    foreach ($threads as $thread) {
        ?>
        <div data-id="<? echo $thread['id']; ?>" class="panel <? echo ($thread['solved']) ? "panel-success" : "panel-danger"; ?>">
            <div class="panel-heading">
                <a href="thread.php?id=<? echo $thread['id']; ?>"><h3
                        class="panel-title"><? echo $thread['title']; ?></h3></a>
            </div>
            <div class="panel-body" style="padding-bottom:0;">
                <b>Title: </b><? echo $thread['subject']; ?><br/>
                <b>Posted By: </b><? echo $thread['team_name'] ?>
                <hr style="margin-bottom: 5px;" />
                <div style="margin-bottom: 0px;">
                    <p class="pull-left">Posted
                        <time class="timeago"
                              datetime="<? echo date(DATE_ISO8601, $thread['post_time']); ?>"><? echo date(DATE_ISO8601, $thread['post_time']); ?></time>
                    </p>
                    <? if ($user['admin']) {
                        ?>
                        <p class="pull-right">
                            <a href="#" class="remove btn btn-sm btn-danger">Remove</a>
                        </p>
                        <?
                    } ?>
                </div>
            </div>
        </div>
        <?
    }
} else {
    ?>
    <h2>There are no threads for the current competitions.</h2>
    <?
}
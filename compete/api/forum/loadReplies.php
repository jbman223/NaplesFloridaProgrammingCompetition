<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die("<h1>Please refresh the page.</h1>");
}

if (!isset($_GET['id'])) {
    die("<h1>Please refresh the page.</h1>");
}

$state = $db->prepare("select r.*, t.team_name from replies r inner join teams t on r.poster_id = t.id where r.thread_id = ? and r.deleted = false");
$state->execute(array($_GET['id']));

$replies = $state->fetchAll(PDO::FETCH_ASSOC);

foreach ($replies as $reply) {
    ?>

    <hr/>
    <div data-id="<? echo $reply['id']; ?>" class="row">
        <div class="col-md-8">
            <p class="lead">
                <? echo nl2br($reply['message']); ?>
            </p>
        </div>
        <div class="col-md-4">
            <div>
                <p><b>Posted By: </b><? echo $reply['team_name']; ?> (
                    <time class="timeago"
                          datetime="<? echo date(DATE_ISO8601, $reply['post_time']); ?>"><? echo date(DATE_ISO8601, $reply['post_time']); ?></time>
                    )
                </p>

                <? if ($user['admin']) { ?>
                    <p><a href="#" class="remove btn btn-danger">Remove Post</a></p>
                <? } ?>
            </div>
        </div>
    </div>
    <?
}

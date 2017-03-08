<?php
require_once "includes/require.php";
require_once 'mail/Mandrill.php';
require_once "mail/sendMail.php";

$sent = false;
if (!empty($_POST) && isset($_POST['g-recaptcha-response'], $_POST['message'], $_POST['subject'], $_POST['email'])) {
    $captcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfcWgATAAAAADAonZK6qPdQ4mMbqCpaJWJo-Mfj&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $c = json_decode($captcha);
    if ($c->success == true) {
        sendContact($_POST['email'], $_POST['subject'], $_POST['message']);
        $sent = true;
    } else {
        // die();
    }
} else {
    //echo "a";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Contact</title>


    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <div class="starter-template">
                    <h1>Contact</h1>

                    <p class="lead text-center">Contact the competition coordinators with questions and any other information.</p>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h4 class="text-center">Quick Contact Form</h4>
                                <? if ($sent) { ?>
                                    <p class="lead">You have successfully sent your eamil.</p>
                                <? } else { ?>
                                    <form class="form-horizontal" method="post" action="contact.php">
                                        <fieldset>

                                            <!-- Text input-->
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="email">Your Email</label>
                                                <div class="col-md-8">
                                                    <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text">
                                                    <span class="help-block">Enter your email so that we can contact you in response.</span>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>

                                            <!-- Select Basic -->
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="subject">Subject</label>
                                                <div class="col-md-8">
                                                    <select id="subject" name="subject" class="form-control">
                                                        <option value="0">Website Error</option>
                                                        <option value="1">Website Question</option>
                                                        <option value="2">Signup Question</option>
                                                        <option value="3">Forgot Password</option>
                                                        <option value="4">Sponsorship Information</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>

                                            <!-- Textarea -->
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="message">Message</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" id="message" name="message"></textarea>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8"><div class="g-recaptcha" data-sitekey="6LfcWgATAAAAAJmiZ4CHPWPALj1stbZur7jZJhxp"></div></div>
                                                <div class="col-md-2"></div>
                                            </div>


                                            <!-- Button -->
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="send"></label>
                                                <div class="col-md-8">
                                                    <button id="send" name="send" class="btn btn-primary">Send</button>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>

                                        </fieldset>
                                    </form>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</body>
</html>
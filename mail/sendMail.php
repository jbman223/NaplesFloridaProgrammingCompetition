<?php
require_once 'Mandrill.php';
require_once "mandrill_config.php";

function sendRegisterEmail($email, $code)
{
    global $mandrillID;
    try {
        $mandrill = new Mandrill($mandrillID);
        $template_name = 'verifyemail';
        $template_content = array(
            array()
        );
        $message = array(
            'html' => null,
            'text' => null,
            'subject' => null,
            'from_email' => null,
            'from_name' => null,
            'to' => array(
                array(
                    'email' => $email,
                    'name' => $email,
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => 'jacob@programmingcompetition.org'),
            'important' => true,
            'track_opens' => true,
            'track_clicks' => true,
            'url_strip_qs' => true,
            'merge' => true,
            'merge_language' => 'mailchimp',
            'global_merge_vars' => array(),
            'merge_vars' => array(
                array(
                    'rcpt' => $email,
                    'vars' => array(
                        array(
                            'name' => 'VERIFYCODE',
                            'content' => $code
                        ), array(
                            'name' => 'MESSAGE',
                            'content' => 'Thank you for creating your administration account for the Naples Programming Competition. To complete your registration, please follow the below link to verify your email.'
                        )
                    )
                )
            ),
            'tags' => array('verify-email')
        );
        $async = false;
        $ip_pool = null;
        $send_at = null;
        $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
        return $result;
    } catch (Mandrill_Error $e) {
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        throw $e;
    }
}

function sendTeamMemberEmail($email, $code)
{
    global $mandrillID;
    try {
        $mandrill = new Mandrill($mandrillID);
        $template_name = 'verifyemail';
        $template_content = array(
            array()
        );
        $message = array(
            'html' => null,
            'text' => null,
            'subject' => null,
            'from_email' => null,
            'from_name' => null,
            'to' => array(
                array(
                    'email' => $email,
                    'name' => $email,
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => 'jacob@programmingcompetition.org'),
            'important' => true,
            'track_opens' => true,
            'track_clicks' => true,
            'url_strip_qs' => true,
            'merge' => true,
            'merge_language' => 'mailchimp',
            'global_merge_vars' => array(),
            'merge_vars' => array(
                array(
                    'rcpt' => $email,
                    'vars' => array(
                        array(
                            'name' => 'VERIFYCODE',
                            'content' => $code
                        ), array(
                            'name' => 'MESSAGE',
                            'content' => 'Hello! You have been invited to be on a team for the Naples Florida Programming Competition. Please follow the link in this email to accept the invitation, and ignore this email to reject the invitation.'
                        )
                    )
                )
            ),
            'tags' => array('verify-email')
        );
        $async = false;
        $ip_pool = null;
        $send_at = null;
        $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
        return $result;
    } catch (Mandrill_Error $e) {
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        throw $e;
    }
}

function sendReminder($email, $name) {
    global $mandrillID;
    try {
        $mandrill = new Mandrill($mandrillID);
        $template_name = 'reminder-1';
        $template_content = array(
            array()
        );
        $message = array(
            'html' => null,
            'text' => null,
            'subject' => null,
            'from_email' => "jacob@programmingcompetition.org",
            'from_name' => null,
            'to' => array(
                array(
                    'email' => $email,
                    'name' => $email,
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => 'jacob@programmingcompetition.org'),
            'important' => true,
            'track_opens' => true,
            'track_clicks' => true,
            'url_strip_qs' => true,
            'merge' => true,
            'merge_language' => 'mailchimp',
            'global_merge_vars' => array(),
            'merge_vars' => array(
                array(
                    'rcpt' => $email,
                    'vars' => array(
                        array(
                            'name' => 'NAME',
                            'content' => $name
                        )
                    )
                )
            ),
            'tags' => array('verify-email')
        );
        $async = false;
        $ip_pool = null;
        $send_at = null;
        $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
        return $result;
    } catch (Mandrill_Error $e) {
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        throw $e;
    }
}

function sendContact($email, $subject, $message)
{
    global $mandrillID;
    $sub = array("Website Error", "Website Question", "Signup Question", "Forgot Password", "Sponsorship Information");
    //echo $sub[$subject];
    try {
        $mandrill = new Mandrill($mandrillID);
        $template_name = 'contact';
        $template_content = array(
            array()
        );
        $message = array(
            'html' => null,
            'text' => null,
            'subject' => $sub[$subject],
            'from_email' => null,
            'from_name' => null,
            'to' => array(
                array(
                    'email' => "jacob@programmingcompetition.org",
                    'name' => "Programming Competition",
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => $email),
            'important' => true,
            'track_opens' => true,
            'track_clicks' => true,
            'url_strip_qs' => true,
            'merge' => true,
            'merge_language' => 'mailchimp',
            'global_merge_vars' => array(),
            'merge_vars' => array(
                array(
                    'rcpt' => "jacob@programmingcompetition.org",
                    'vars' => array(
                        array(
                            'name' => 'SUBJECT',
                            'content' => $sub[$subject]
                        ), array(
                            'name' => 'MESSAGE',
                            'content' => $message
                        ), array(
                            'name' => 'FROM',
                            'content' => $email
                        )
                    )
                )
            ),
            'tags' => array('contact')
        );
        $async = false;
        $ip_pool = null;
        $send_at = null;
        $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
        return $result;
    } catch (Mandrill_Error $e) {
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        throw $e;
    }
}

if ($mandrillID == "") {
    function sendContact($email, $subject, $message)
    {
        return;
    }

    function sendReminder($email, $name) {
        return;
    }

    function sendTeamMemberEmail($email, $code)
    {
        return;
    }

    function sendRegisterEmail($email, $code)
    {
        return;
    }
}
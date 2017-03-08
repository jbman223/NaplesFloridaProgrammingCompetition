<?php
require_once 'Mandrill.php';

function sendEditLinkEmail($email, $editLink)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'quiz-designer-edit-link';
        $template_content = array(
            array()
        );
        $message = array(
            'to' => array(
                array(
                    'email' => $email,
                    'name' => $email,
                    'type' => 'to'
                )
            ),
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
                            'name' => 'EDIT_LINK',
                            'content' => $editLink
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

function sendOneTimeEmail($email, $oneTimePassword, $editSession)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'quiz-designer-password-link';
        $template_content = array(
            array()
        );
        $message = array(
            'to' => array(
                array(
                    'email' => $email,
                    'name' => $email,
                    'type' => 'to'
                )
            ),
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
                            'name' => 'LINK',
                            'content' => "http://minecraftnoobtest.com/quizDesigner/oneTime.php?code=".$oneTimePassword."&edit_session=".$editSession
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

function sendContact($email, $subject, $message, $verify = true)
{
    $sub = array("Website Error", "Website Question", "Question Error", "Sponsorship Information");
    //echo $sub[$subject];
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'contact-mcnt';
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
                    'email' => "jbman223@gmail.com",
                    'name' => "Jacob Buckheit",
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
                    'rcpt' => "jbman223@gmail.com",
                    'vars' => array(
                        array(
                            'name' => 'SUBJECT',
                            'content' => ($verify ? $sub[$subject] : $subject)
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
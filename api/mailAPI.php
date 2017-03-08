<?php
require_once "mail/Mandrill.php";
$mailAPI = "LOADED";

function sendReminderEmail($email)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'nfpc-reminder';
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
            'headers' => array(
                'Reply-To' => "jbuckheit2016@communityschoolnaples.org"
            ),
            'important' => true,
            'track_opens' => true,
            'track_clicks' => true,
            'url_strip_qs' => true,
            'merge' => true,
            'merge_language' => 'mailchimp',
            'global_merge_vars' => array(),
            'tags' => array('reminder-email')
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

function sendVerifyEmail($email, $verifyCode)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'nfpc-email-verification';
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
                            'content' => "http://programmingcompetition.org/account/verify.php?code=" . $verifyCode
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

function sendResetEamil($email, $verifyCode)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'nfpc-forgot-password';
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
                            'content' => "http://programmingcompetition.org/account/reset.php?code=" . $verifyCode
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

function sendReviewEamil($email, $verifyCode, $problemID)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'nfpc-review-problem';
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
                            'content' => "http://programmingcompetition.org/competitionSiteNew/review/problem.php?password=" . $verifyCode . "&email=" . $email . "&problemId=" . $problemID
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

function sendReportEamil($email, $report)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'mcnt-report';
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
                            'name' => 'MESSAGE',
                            'content' => $report
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

function sendUpdate($email, $messageInfo)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'mcnt-new-account';
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
                            'name' => 'MESSAGE',
                            'content' => $messageInfo
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

function sendReceipt($email, $name, $item_name, $quantity, $item_price, $shipping_price, $total_price, $key)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'mcnt-receipt';
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
                            'name' => 'NAME',
                            'content' => $name
                        ), array(
                            'name' => 'ITEM_NAME',
                            'content' => $item_name
                        ), array(
                            'name' => 'QUANTITY',
                            'content' => $quantity
                        ), array(
                            'name' => 'ITEM_PRICE',
                            'content' => $item_price
                        ), array(
                            'name' => 'SHIPPING_PRICE',
                            'content' => $shipping_price
                        ), array(
                            'name' => 'TOTAL_PRICE',
                            'content' => $total_price
                        ), array(
                            'name' => 'KEY',
                            'content' => $key
                        )
                    )
                )
            ),
            'tags' => array('minecraft')
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

function sendOrderUpdate($email, $status, $key)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'mcnt-order-update';
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
                            'name' => 'ORDER_KEY',
                            'content' => $key
                        ), array(
                            'name' => 'ORDER_STATUS',
                            'content' => $status
                        )
                    )
                )
            ),
            'tags' => array('minecraft')
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

function sendNewOrder($email, $status, $key, $track = true)
{
    try {
        $mandrill = new Mandrill('8olr0jQS9A7bOKq6GjbwNw');
        $template_name = 'mcnt-new-order';
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
            'track_opens' => $track,
            'track_clicks' => $track,
            'url_strip_qs' => true,
            'merge' => true,
            'merge_language' => 'mailchimp',
            'global_merge_vars' => array(),
            'merge_vars' => array(
                array(
                    'rcpt' => $email,
                    'vars' => array(
                        array(
                            'name' => 'ORDER_KEY',
                            'content' => $key
                        ), array(
                            'name' => 'ORDER_STATUS',
                            'content' => $status
                        )
                    )
                )
            ),
            'tags' => array('minecraft')
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
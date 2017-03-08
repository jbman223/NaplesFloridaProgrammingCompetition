<?php
namespace CSRFLib;


class CSRF {
    private function generateCSRFString() {
        return md5(uniqid(mt_rand(), true));
    }

    public function outputPageState() {
        $cookieName = "csrf_"."PAGESTATE";
        $token = self::generateCSRFString();
        $_SESSION[$cookieName] = $token;
        return "<input type=\"hidden\" id=\"pageState\" value=\"$token\">";
    }

    public function getPageStateToken() {
        $cookieName = "csrf_"."PAGESTATE";
        return $_SESSION[$cookieName];
    }

    public function verifyPageState($token) {
        if (self::getPageStateToken() == $token) {
            return true;
        } else {
            return false;
        }
    }

    public function getCSRFStringForForm($formName) {
        $cookieName = "csrf_".$formName;
        return $_SESSION[$cookieName];
    }

    public function outputCSRFForForm($formName) {
        $cookieName = "csrf_".$formName;
        $token = self::generateCSRFString();
        $_SESSION[$cookieName] = $token;
        return "<input type=\"hidden\" name=\"csrf\" value=\"$token\">";
    }

    public function validateCSRF($formName, $token) {
        if (self::getCSRFStringForForm($formName) == $token) {
            return true;
        } else {
            return false;
        }
    }

    public function test() {
        echo "hi";
    }
} 
<?php
require_once "includes/require.php";
require_once "mail/sendMail.php";

if (isset($_POST['type'])) {
    if ($_POST['type'] == "register_account") {
        if (isset($_POST['csrf']) && $csrf->validateCSRF("register", $_POST['csrf'])) {
            if (isset($_POST['email'], $_POST['password'])) {
                $state = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                $state->execute(array($_POST['email']));
                $count = $state->fetchAll()[0][0];
                if ($count > 0) {
                    die(json_encode(array("error" => "An account is already registered with that email address.")));
                } else {
                    $state = $db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                    $state->execute(array(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password'])));
                    $userID = $db->lastInsertId();
                    $email = $_POST['email'];
                    $uniqueID = uniqid(true);
                    $results = sendRegisterEmail($email, $uniqueID)[0];
                    if ($results['status'] == "sent" || $results['status'] == "queued") {
                        if ($results['rejectReason']) {
                            die(json_encode(array("error" => "Please supply a valid email address.")));
                        } else {
                            $state = $db->prepare("INSERT INTO verification (for_id, for_email, verify_code) VALUES (?, ?, ?)");
                            $state->execute(array($userID, $email, $uniqueID));
                            die(json_encode(array("success" => "Your email has been sent! Please check your inbox to complete your account registration.")));
                        }
                    } else {
                        die(json_encode(array("error" => "Please supply a valid email address.")));
                    }
                }
            } else {
                die(json_encode(array("error" => "You must supply an email and a password.")));
            }
        } else {
            die(json_encode(array("error" => "Invalid request.")));
        }
    } else if ($_POST['type'] == "login_account") {
        if (isset($_POST['csrf']) && $csrf->validateCSRF("login", $_POST['csrf'])) {
            if (isset($_POST['email'], $_POST['password'])) {
                if (isUserLoggedIn()) {
                    die(json_encode(array("error" => "You are already logged in.", "code" => 0)));
                }
                $state = $db->prepare("SELECT *, COUNT(*) FROM users WHERE email = ?");
                $state->execute(array(htmlspecialchars($_POST['email'])));
                $ret = $state->fetchAll(PDO::FETCH_ASSOC);
                if ($ret[0]['COUNT(*)'] == 1) {
                    if ($ret[0]['verified'] == 1) {
                        $_SESSION['id'] = $ret[0]['id'];
                        die(json_encode(array("success" => "You have been logged in successfully. Thanks!")));
                    } else {
                        die(json_encode(array("error" => "Please verify your email address and try again!")));
                    }
                } else {
                    die(json_encode(array("error" => "User account could not be found. Please register for an account.")));
                }
            } else {
                die(json_encode(array("error" => "You must supply an email and a password.")));
            }
        } else {
            die(json_encode(array("error" => "Invalid request.")));
        }
    } else if ($_POST['type'] == "login_account_edu") {
        if (isset($_POST['email'], $_POST['password'])) {
            if (isUserLoggedIn()) {
                die(json_encode(array("error" => "You are already logged in.", "code" => 0)));
            }
            $state = $db->prepare("SELECT *, COUNT(*) FROM users WHERE email = ? AND password = ?");
            $state->execute(array(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password'])));
            $ret = $state->fetchAll(PDO::FETCH_ASSOC);
            if ($ret[0]['COUNT(*)'] == 1) {
                if ($ret[0]['email_verified'] == 1) {
                    $_SESSION['id'] = $ret[0]['id'];
                    die(json_encode(array("success" => "You have been logged in successfully. Thanks!")));
                } else {
                    die(json_encode(array("error" => "Please verify your email address and try again!")));
                }
            } else {
                die(json_encode(array("error" => "User account could not be found. Please register for an account.")));
            }
        } else {
            die(json_encode(array("error" => "You must supply an email and a password.")));
        }
    } else if ($_POST['type'] == "register_team") {
        if (isset($_POST['csrf']) && $csrf->validateCSRF("register_team", $_POST['csrf'])) {
            if (isset($_POST['name'])) {
                if (!isUserLoggedIn()) {
                    die(json_encode(array("error" => "You must be logged in.")));
                }
                $state = $db->prepare("SELECT COUNT(*) FROM `teams` WHERE team_name = ? AND deleted = 0");
                $state->execute(array($_POST['name']));
                $ret = $state->fetchAll();
                if ($ret[0][0] == 0) {
                    $state = $db->prepare("INSERT INTO `teams` (`team_name`, `owner_id`, `backendLogin`, `backendPassword`) VALUES (?, ?, ?, ?)");
                    $state->execute(array(htmlspecialchars($_POST['name']), $_SESSION['id'], generateUsername(), generatePassword()));
                    die(json_encode(array("success" => "You have successfully created your team, " . htmlspecialchars($_POST['name']) . "!")));
                } else {
                    die(json_encode(array("error" => "A team already exists with that name.")));
                }
            } else {
                die(json_encode(array("error" => "You must supply a team name.")));
            }
        } else {

        }
    } else if ($_POST['type'] == "register_team_member") {
        if (isset($_POST['csrf']) && $csrf->validateCSRF("register_team_member", $_POST['csrf']) && isset($_SESSION['id'])) {
            if (isset($_POST['email'], $_POST['f_name'], $_POST['l_name'], $_POST['school'], $_POST['grade'], $_POST['shirt'], $_POST['id'])) {
                $state = $db->prepare("SELECT COUNT(*) FROM teams WHERE id = ? AND owner_id = ?");
                $state->execute(array($_POST['id'], $_SESSION['id']));
                $count = $state->fetchAll()[0][0];
                if ($count == 1) {
                    $state = $db->prepare("SELECT COUNT(*) FROM competitors WHERE email = ? AND deleted = 0");
                    $state->execute(array($_POST['email']));
                    $count = $state->fetchAll()[0][0];
                    if ($count > 0) {
                        die(json_encode(array("error" => "Somebody is already competing with that email address.")));
                    } else {
                        $state = $db->prepare("INSERT INTO competitors (team_id, f_name, l_name, email, school, grade, shirt_size) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $state->execute(array($_POST['id'], htmlspecialchars($_POST['f_name']), htmlspecialchars($_POST['l_name']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['school']), htmlspecialchars($_POST['grade']), htmlspecialchars($_POST['shirt'])));
                        $userID = $db->lastInsertId();
                        $email = $_POST['email'];
                        $uniqueID = uniqid(true);
                        $results = sendTeamMemberEmail($email, $uniqueID)[0];
                        if ($results['status'] == "sent" || $results['status'] == "queued") {
                            if ($results['rejectReason']) {
                                die(json_encode(array("error" => "Please supply a valid email address.")));
                            } else {
                                $state = $db->prepare("INSERT INTO verification (for_id, for_email, verify_code, `type`) VALUES (?, ?, ?, ?)");
                                $state->execute(array($userID, $email, $uniqueID, 1));
                                die(json_encode(array("success" => "The member has been registered. Please ask the member to accept this registration using their email.")));
                            }
                        } else {
                            die(json_encode(array("error" => "Please supply a valid email address.")));
                        }
                    }
                } else {
                    die(json_encode(array("error" => "You cannot add a member to that team.")));
                }
            } else {
                die(json_encode(array("error" => "You must complete all forms.")));
            }
        } else {
            die(json_encode(array("error" => "Invalid request.")));
        }
    } else {
        die(json_encode(array("error" => "Invalid request. Please refresh the page and try again!")));
    }
} else {
    die(json_encode(array("error" => "Invalid request.")));
}

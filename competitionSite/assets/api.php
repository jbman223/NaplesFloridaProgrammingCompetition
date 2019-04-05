<?php
require_once "require.php";

if (isset($_POST['type'])) {
    if ($_POST['type'] == "login_account") {
        if (isset($_POST['email'], $_POST['password'])) {
            $state = $db->prepare("SELECT * FROM teams WHERE backendLogin = ? AND backendPassword = ?");
            $state->execute(array($_POST['email'], $_POST['password']));
            $ret = $state->fetchAll(PDO::FETCH_ASSOC);
            if (count($ret) == 1) {
                $_SESSION['team_id'] = $ret[0]['id'];
                die(json_encode(array("success" => "Logged in successfully.")));
            } else {
                die(json_encode(array("error" => "Could not log in. Your username password combination was not found.")));
            }
        } else {
            die(json_encode(array("error" => "Username and password not received.")));
        }
    } else if ($_POST['type'] == "create_competition") {
        if (!isAdmin()) {
            die(json_encode(array("error" => "You must be an administrator to create a competition.")));
        }

        if (isset($_POST['competition_name'], $_POST['graded'], $_POST['start_time'], $_POST['end_time'])) {
            if (!strtotime($_POST['start_time'])) {
                die(json_encode(array("error" => "Please enter a valid start time.")));
            }

            if (!strtotime($_POST['end_time'])) {
                die(json_encode(array("error" => "Please enter a valid end time.")));
            }

            if (strtotime($_POST['end_time']) <= strtotime($_POST['start_time'])) {
                die(json_encode(array("error" => "Please enter a valid start and end time.")));
            }

            $state = $db->prepare("INSERT INTO admin_scheduled_competitions (competition_name, graded, start_time, end_time) VALUES (?, ?, ?, ?)");
            $state->execute(array(htmlspecialchars($_POST['competition_name']), $_POST['graded'], strtotime($_POST['start_time']), strtotime($_POST['end_time'])));
            die(json_encode(array("success" => "Competition " . htmlspecialchars($_POST['competition_name']) . " has been created.")));
        } else {
            die(json_encode(array("error" => "Please fill in all fields.")));
        }
    } else if ($_POST['type'] == "create_alert") {
        if (!isAdmin()) {
            die(json_encode(array("error" => "You must be an administrator to create a competition.")));
        }

        if (isset($_POST['alert_text'])) {


            $state = $db->prepare("INSERT INTO alerts (message, start_time, end_time) VALUES (?, ?, ?)");
            $state->execute(array(htmlspecialchars($_POST['alert_text']), time(), time() + 60));
            die(json_encode(array("success" => "Alert has been created.")));
        } else {
            die(json_encode(array("error" => "Please fill in all fields.")));
        }
    } else if ($_POST['type'] == "toggle_focus") {
        if (!isAdmin()) {
            die(json_encode(array("error" => "You must be an administrator to create a competition.")));
        }

        $state = $db->prepare("SELECT field_value FROM admin_current_competition");
        $state->execute();
        $fInfo = $state->fetchAll(PDO::FETCH_NUM);
        $focus = filter_var($fInfo[6][0], FILTER_VALIDATE_BOOLEAN);

        if ($focus) {
            $state = $db->prepare("UPDATE admin_current_competition SET field_value = ? WHERE id = ?");
            $state->execute(array("false", 7));
            die(json_encode(array("success" => "Focus Mode disabled.")));
        } else {
            $state = $db->prepare("UPDATE admin_current_competition SET field_value = ? WHERE id = ?");
            $state->execute(array("true", 7));
            die(json_encode(array("success" => "Focus Mode enabled.")));
        }
    } else if ($_POST['type'] == "upload_problem") {
        if (!isLoggedIn()) {
            header("Location: ../login.php");
            die();
        }

        $mimeTypes = array("application/zip", "application/octet-stream");
        if (!in_array(mime_content_type($_FILES['file']['tmp_name']), $mimeTypes)) {
            $_SESSION['error_message'] = "Please upload only .ZIP files.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            die();
        }

        $dir = "/var/www/programmingcompetition.org/competitionSite/assets/uploadedProblems/" . md5($_POST['problem_title'] . time() . uniqid());
        $zipPath = $dir . "/zip/" . basename($_FILES['file']['name']);
        if (!file_exists($dir)) {
            mkdir($dir);
            chmod($dir, 0777);
        }

        if (!file_exists($dir . "/zip/")) {
            mkdir($dir . "/zip/");
            chmod($dir . "/zip/", 0777);
        }

        if (!move_uploaded_file($_FILES['file']['tmp_name'], $zipPath)) {
            $_SESSION['error_message'] = "Couldn't move zipped file to new path.";
            system("rm -rf " . escapeshellarg($dir));
            header("Location: " . $_SERVER['HTTP_REFERER']);
            die();
        } else {
            chmod($zipPath, 0777);
        }

        $zip = new ZipArchive;
        $zip->open($zipPath);
        if ($zip) {
            $base = strval($zip->getNameIndex(0));
            $reqFiles = array("input.txt", "output.txt", "description.txt", "sample_input.txt", "sample_output.txt");
            $files = array();

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileName = strval($zip->getNameIndex($i));
                if (substr($fileName, 0, strlen($base)) === $base) {
                    //echo "checking: " . $fileName . "<br>";
                    if (in_array(substr($fileName, strlen($base)), $reqFiles)) {
                        $files[] = $fileName;
                    }
                }
            }

            if (count($files) != count($reqFiles)) {
                $_SESSION['error_message'] = "Not all required files were found in the zip. Here are the required files which were found: <br><pre>" . print_r($files, true) . "</pre><br>Only " . count($files) . " out of " . count($reqFiles) . " required files found.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                system("rm -rf " . escapeshellarg($dir));
                die();
            }

            foreach ($files as $filePathInZip) {
                copy("zip://" . $zipPath . "#" . $filePathInZip, $dir . "/" . substr($filePathInZip, strlen($base)));
            }

            $state = $db->prepare("INSERT INTO problems (problem_title, problem_input_file, problem_description_file, problem_sample_input_file, problem_output_file, problem_sample_output_file, competition_id, output_hash, base_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $state->execute(array(htmlspecialchars($_POST['problem_title']), $dir . "/input.txt", $dir . "/description.txt", $dir . "/sample_input.txt", $dir . "/output.txt", $dir . "/sample_output.txt", $_POST['competition_id'], md5(preg_replace('/\s+/', '', file_get_contents($dir . "/output.txt"))), $dir));
            header("Location: ../admin/index.php");
        } else {
            $_SESSION['error_message'] = "Something went wrong with the ZIP file decompression.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            system("rm -rf " . escapeshellarg($dir));
            die();
        }
    } else if ($_POST['type'] == "delete_competition") {
        if (!isAdmin()) {
            die(json_encode(array("error" => "Not signed in.")));
        }

        if (isset($_POST['id'], $_POST['type'])) {
            if ($_POST['toDelete'] == 0) {
                $state = $db->prepare("UPDATE admin_scheduled_competitions SET `delete` = ? WHERE id = ?");
                $state->execute(array(0, $_POST['id']));
            } else if ($_POST['toDelete'] == 1) {
                $state = $db->prepare("UPDATE admin_scheduled_competitions SET `delete` = ? WHERE id = ?");
                $state->execute(array(1, $_POST['id']));
            }

            die(json_encode(array("success" => "Marked for deletion.")));
        } else {
            die(json_encode(array("error" => "Variables not found.")));
        }
    } else if ($_POST['type'] == "delete_problem") {
        if (!isAdmin()) {
            die(json_encode(array("error" => "Not signed in.")));
        }

        if (isset($_POST['id'], $_POST['type'])) {
            if ($_POST['toDelete'] == 1) {
                $state = $db->prepare("SELECT * FROM problems WHERE id = ?");
                $state->execute(array($_POST['id']));
                $problem = $state->fetchAll();
                if (count($problem) > 0) {
                    system("rm -rf " . escapeshellarg($problem[0]['base_path']));
                    $state = $db->prepare("DELETE FROM problems WHERE id = ?");
                    $state->execute(array($problem[0]['id']));
                    die(json_encode(array("success" => "Deleted.")));
                } else {
                    die(json_encode(array("error" => "Problem not found.")));
                }
            }

            die(json_encode(array("success" => "Marked for deletion.")));
        } else {
            die(json_encode(array("error" => "Variables not found.")));
        }
    } else if ($_POST['type'] == "create_edu_problem") {
        if (!isAdmin()) {
            die(json_encode(array("error" => "Not signed in.")));
        }

        if (isset($_POST["problem_name"], $_POST["problem_description"], $_POST["problem_sample_input"], $_POST["problem_sample_output"], $_POST["youtube_video_link"], $_POST["sample_code"])) {
            if (strlen($_POST['youtube_video_link']) != 11) {
                die(json_encode(array("error" => "The youtube ID you entered was not valid. Please enter the proper 11 character Youtube Video ID.")));
            }

            $state = $db->prepare("insert into edu_problems (problem_name, problem_description, problem_sample_input, problem_sample_output, youtube_video_link, sample_code) values (?, ?, ?, ?, ?, ?)");
            $state->execute(array($_POST["problem_name"], $_POST["problem_description"], $_POST["problem_sample_input"], $_POST["problem_sample_output"], $_POST["youtube_video_link"], $_POST["sample_code"]));
            die(json_encode(array("success" => "Problem successfully added to the database.")));
        } else {
            die(json_encode(array("error" => "All required fields were not received.")));
        }
    } else {
        die(json_encode(array("error" => "Action not found.")));
    }
} else {
    die(json_encode(array("error" => "10")));
}
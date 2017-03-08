<?php
error_reporting(0);

$user = 'jbman223';
$pass = '8uddy8260930';
$code = '
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Scanner;

class iPodProblem {

	public static void main(String[] args) {
		try {
			Scanner s = new Scanner(System.in);
			iPod i = new iPod();
			while (s.hasNextLine()) {
				if (!i.parseCommand(s.nextLine()))
					i = new iPod();
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
}

class iPod {
	String iPodName = "";
	HashMap<String, ArrayList<String>> playlists = new HashMap<String, ArrayList<String>>(
			10);

	public iPod() {

	}

	public boolean parseCommand(String line) {
		if (line.startsWith("IPOD")) {
			this.iPodName = line.replace("IPOD", "").trim();
			return true;
		} else if (line.startsWith("TRACK")) {
			String playlist = line.substring(
					line.indexOf("PLAYLIST") + "PLAYLIST".length()).trim();
			String track = line.substring(
					line.indexOf("TRACK") + "TRACK".length(),
					line.indexOf("PLAYLIST")).trim();
			playlists.get(playlist).add(track);
			return true;
		} else if (line.startsWith("PLAYLIST")) {
			playlists.put(line.replace("PLAYLIST", "").trim(),
					new ArrayList<String>(10));
			return true;
		} else if (line.startsWith("DELETE")) {
			String playlist = line.substring(
					line.indexOf("PLAYLIST") + "PLAYLIST".length()).trim();
			String track = line.substring(
					line.indexOf("DELETE") + "delete".length(),
					line.indexOf("PLAYLIST")).trim();
			playlists.get(playlist).remove(track);
			return true;
		} else if (line.startsWith("PLAY")) {
			String playlist = line.replace("PLAY", "").trim();
			if (playlists.get(playlist).size() > 1) {
				System.out.println("Playing " + playlist + " ("
						+ playlists.get(playlist).size() + " Songs)");
			} else {
				System.out.println("Playing " + playlist + " ("
						+ playlists.get(playlist).size() + " Song)");
			}
			for (String track : playlists.get(playlist)) {
				System.out.println(track);
			}
			return true;
		} else {
			return false;
		}
	}
}

';
$input = '';
$run = true;
$private = false;

$subStatus = array(
    0 => 'Success',
    1 => 'Compiled',
    3 => 'Running',
    11 => 'Compilation Error',
    12 => 'Runtime Error',
    13 => 'Timelimit exceeded',
    15 => 'Success',
    17 => 'memory limit exceeded',
    19 => 'illegal system call',
    20 => 'internal error'
);

$error = array(
    'status' => 'error',
    'output' => 'Something went wrong :('
);

//echo json_encode( array( 'hi', 1 ) ); exit;
//print_r( $_POST ); exit;

$lang = '55';
$input = '';

$client = new SoapClient("http://ideone.com/api/1/service.wsdl");

print_r($client->getSubmissionDetails($user, $pass, "LoZIva", true, true, true, true, true));
die();
//create new submission
$result = $client->createSubmission($user, $pass, $code, $lang, $input, $run, $private);

//if submission is OK, get the status
if ($result['error'] == 'OK') {
    $status = $client->getSubmissionStatus($user, $pass, $result['link']);
    if ($status['error'] == 'OK') {

        //check if the status is 0, otherwise getSubmissionStatus again
        while ($status['status'] != 0) {
            sleep(3); //sleep 3 seconds
            $status = $client->getSubmissionStatus($user, $pass, $result['link']);
        }

        //finally get the submission results
        $details = $client->getSubmissionDetails($user, $pass, $result['link'], true, true, true, true, true);
        if ($details['error'] == 'OK') {
            //print_r( $details );
            if ($details['status'] < 0) {
                $status = 'waiting for compilation';
            } else {
                $status = $subStatus[$details['status']];
            }

            $data = array(
                'status' => 'success',
                'meta' => "Status: $status | Memory: {$details['memory']} | Returned value: {$details['status']} | Time: {$details['time']}s",
                'output' => htmlspecialchars($details['output']),
                'raw' => $details
            );

            if ($details['cmpinfo']) {
                $data['cmpinfo'] = $details['cmpinfo'];
            }

            echo json_encode($data);
        } else {
            //we got some error :(
            //print_r( $details );
            echo json_encode($error);
        }
    } else {
        //we got some error :(
        //print_r( $status );
        echo json_encode($error);
    }
} else {
    //we got some error :(
    print_r( $result );
    echo json_encode($error);
}
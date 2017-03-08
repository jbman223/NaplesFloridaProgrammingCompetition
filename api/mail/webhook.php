<?php
require_once "../../require.php";
require_once "../../api/SendyPHP.php";


if (isset($_POST['mandrill_events'])) {
    $response = json_decode($_POST['mandrill_events'], true);

    foreach ($response as $part) {
        $state = $db->prepare("select * from bad_emails where email = ?");
        $state->execute(array($part['msg']['email']));
        $emails = $state->fetchAll(PDO::FETCH_ASSOC);
        if (count($emails) == 0) {
            $state = $db->prepare("insert into bad_emails (`email`) values (?)");
            $state->execute(array($part['msg']['email']));

            $sendy = new \SendyPHP\SendyPHP(array(
                'api_key' => 'w9IyE3iSADjBhVvtUPBf', //your API key is available in Settings
                'installation_url' => 'http://mail.minecraftnoobtest.com',  //Your Sendy installation
                'list_id' => 'VNCI8O4yzqUUavX4Eo0cOA'
            ));
            $sendy->unsubscribe(
                $part['msg']['email']
            );
        } else {
        }
    }
}

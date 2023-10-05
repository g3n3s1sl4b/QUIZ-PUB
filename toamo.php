<?php

ini_set('display_errors', 1);

$time = date("d.m H:i");
//$data = $_POST;
//file_put_contents("leads.txt", $time." ".print_r($data, true)."".PHP_EOL, FILE_APPEND);

require_once "ebAmocrmClient.php";
$resp_user = '10052958';
$status_id = '60237550';
define('AC_PHONE_CID', '1496205');
define('AC_EMAIL_CID', '1496207');

$config = array(
    'secret_key' => "95xdZtzKqUiPvmdlhSqrkdYZY21af0eQseBNFj8kALxDGVLVzXoxTaEHUqvx9K8F",
    'intagration_id' => "28b403b1-a6a2-47bb-8e96-a71581bb9730",
    'client_domen' => "palmieri",
    'redirect_uri' => "https://leads.digital-corporation.ru/toamo.php",
    'auth_token' => "def50200cea1aeb36f922531830481aee8ffdff18b1b65ed7e347ad63ac795ee6b383c89de66ef4d6e859dd16e95d703c38438d6eae81f6e86169d90feda549f904b8fde790ed3032a4ac127eb7a7a5eff65bcd1af6366ef7d528540cbd7ad5550d43bd363326a14c4039eefda20e217ee2fac0cd0a350f57ed8b34455b9664be7a314e8bded96dc9405be461aae4348b9c2a8a49e06303761292584a59eb9537d5877eac33d27269592af7bdd2637a04ced0fa078ec1ddfb6f607cb645e38d5303792aa06ca598314a54617f43f03a0e4bf105866f12f10ebbf957b03f514a67b36c3cba0cc6c30fabc55c2fee08d48d012b94d8865365c8a2a6cd308ec8713c5964bde87a5d2c5cc371fcdb78461058e0849f6e0d94d380d4cf540d86d9fb86408ee5657ec3d8be57efecbd6198421b94738948f5c98fd6355c9698f556c8db37b17c60bb4516180a5812bf446f60d922222fadc3cc05ca43213780cffc86c22a5483d2975a433407fa14d611af79239280f16157571da954f0764633b8a4403ad258bc81124484e0372f0358f344e971ab26f846930516080deb81df34b637926dba25698e7183feb825472541b54dc4ab4a243566a169f6f25f2a7d3d3b2e536679b143d9a16dfcf3abbd7215c5a9f11466b33f6f6fe18219f2d56c4e2cd92f4a306c4485c9cb4d9e991f2fa0bffeace2b911e31abba0b762b472cd32c2a" //auth токен    
);

$sitename = $_SERVER['HTTP_REFERER'];
if (isset($data['Номер телефона'])) $phone = $data['Номер телефона'];
//$phone = preg_replace("/[^0-9]/", '', $phoneQ);
$name = $data['your-name'] ?? 'Не указано';

if (isset($_GET['test'])) {
    $phone = '351246575335353';
    $email = '232@ds.sd';
    $name = 'test';
}

$amo = new EbClientAmocrm($config['secret_key'], $config['intagration_id'], $config['client_domen'], $config['redirect_uri'], $config['auth_token']);
if ($phone || $email) {

    $contact_config = array(
        'name' => $name,
        'responsible_user_id' => $resp_user,
        'custom_fields' => [
            [
                'id' => AC_PHONE_CID,
                'value' => $phone,
                'enum' => 'WORK'
            ]
        ]
    );
    $c = $amo->create_contact($contact_config);
    $contact_id = $c[1]['_embedded']['items'][0]['id'];

    if ($contact_id) {
        $lead_config = array(
            'contacts_id' => array($contact_id),
            'name' => 'Заявка с сайта ' . $sitename,
            'responsible_user_id' => $resp_user,
            'status_id' => $status_id,
            //  'tags' => '',
            'custom_fields' => [

                ['id' => 289525, 'value' => $utm_source],
                ['id' => 289527, 'value' => $utm_medium],
                ['id' => 289529, 'value' => $utm_campaign],
                ['id' => 330581, 'value' => $utm_content],
                ['id' => 289531, 'value' => $utm_term],
            ]
        );
        $lead = $amo->create_lead($lead_config);
        //    echo $newlead;

        $note['text'] = 'Заявка с сайта: ' . $sitename . "\n";
        $note['text'] .= $telegramMessage . "\n";
        $amo->create_note($lead, $note['text']);
    }

    $tasks['add'] = array(
        #Привязываем к сделке
        array(
            'element_id' => $lead, #ID сделки
            'element_type' => 2, #Показываем, что это - сделка, а не контакт
            'task_type' => 3,
            'text' => 'Связаться'
        )
    );
    //    $amo->create_task($tasks);

}

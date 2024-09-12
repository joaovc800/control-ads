<?php
require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');
require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');

header('Content-Type: application/json');

$json = json_decode(file_get_contents('php://input'), true);

$insert = DB::insert('campaigns_header', [
    'file_path' => $json['file'],
    'file_text' => $json['file'],
]);

if($insert['statement']){

    foreach ($json['data'] as $key => $value) {
        $split = explode(',', $value['LISTKEYWORDS']);
        print_r($split);
        //exit();
        /* $insert = DB::insert('campaigns', [
            'header' => $insert['id'],
            'campaign' => $value['CAMPAIGN'],
            'group_campaign' => $value['GROUP'],
            'budget' => $value['BUDGET'],
            'typecampaign' => $value['TYPECAMPAIGN'],
            'initialcpc' => $value['INITIALCPC'],
            'country' => $value['COUNTRY'],
            'conversiongoal' => $value['CONVERSIONGOAL'],
            'initialdate' => $value['INITIALDATE'],
            'urlnotutm' => $value['URLNOTUTM'],
            'listkeywords' => $value['LISTKEYWORDS'],
            'wordsnotused' => $value['WORDSNOTUSED'],
            'ctaheadline1' => $value['CTAHEADLINE1'],
            'utmcampaign' => $value['UTMCAMPAGIN'],
            'utmmedium' => $value['UTMMEDIUM'],
            'label' => $value['LABEL'],
            'prefixsitelink' => $value['PREFIXSITELINK'],
            'csv_campaigns' => '0'
        ]); */
    }
}
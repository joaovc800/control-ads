<?php

require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');
require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');

header('Content-Type: application/json');

$json = json_decode(file_get_contents('php://input'), true);

foreach ($json as $key => $value) {
    $deleteCampaigns = "DELETE FROM campaigns WHERE id = {$value['campaignId']}";

    $result = DB::statement($deleteCampaigns);

    if($result['statement']){
        $deleteHeaderCampaigns = "DELETE FROM campaigns_header WHERE id = {$value['campaignHeaderId']}";

        $result = DB::statement($deleteHeaderCampaigns);
    }
}

Response::success([], 'Campanha deletada com sucesso!');
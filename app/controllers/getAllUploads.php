<?php

require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');
require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');

header('Content-Type: application/json');

$sql = "SELECT campaigns_header.id AS id
	         , DATE_FORMAT(campaigns_header.created_at, '%d/%m/%Y %H:%i:%s') AS date_upload
             , campaigns.campaign AS campaign
             , campaigns.id AS idcampaign
          FROM campaigns
          JOIN campaigns_header ON campaigns.header = campaigns_header.id";

$result = DB::statement($sql);

if(count($result['fetch']) > 0){
    Response::success($result['fetch'], 'Dados encontrados');
}

Response::fail([], 'Dados não encontrados');
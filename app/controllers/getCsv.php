<?php

require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');
require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');

header('Content-Type: application/json');

$sql = "SELECT csv_campaigns as csv
          FROM campaigns
          WHERE id = {$_GET['campaignId']}";

$result = DB::statement($sql);

if(count($result['fetch']) > 0){
    Response::success($result['fetch'][0], 'CSV Copiado');
}

Response::fail([], 'Dados não encontrados');
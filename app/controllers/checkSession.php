<?php
session_start();

require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

$config = [
    'GET' => function(): void{
        header("Location: ../../public/index.php?error=1&message=Sua sessão foi expirada por favor faça o login");
        die();
    },
    'POST' => function(): void{
        Response::fail(['sessionexpired' => true], 'Sua sessão foi expirada por favor faça o login');
    }
];

if(!isset($_SESSION['auth'])){    
    call_user_func($config[$_SERVER['REQUEST_METHOD']]);
}
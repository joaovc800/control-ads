<?php
session_start();
require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');

$result = DB::statement("SELECT * FROM users WHERE username = :username AND password = :password", [
    ":username" => $_POST['username'],
    ":password" => md5($_POST['password']),
]);

if(count($result["fetch"]) > 0){
    $_SESSION["auth"] = [
        "username" => $result["fetch"][0]["username"],
        "id" => $result["fetch"][0]["id"],
    ];

    header("Location: ../views/dashboard.php?active=dashboard");
    die();
}

header("Location: ../../public/index.php?error=1&message=Usuário ou senha inválido");
die();
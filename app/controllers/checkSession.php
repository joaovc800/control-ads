<?php

session_start();

if(!isset($_SESSION['auth'])){
    header("Location: ../../public/index.php?error=1&message=Sua sessão foi expirada por favor faça o login");
    die();
}
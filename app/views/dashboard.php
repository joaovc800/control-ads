<?php
require_once realpath(dirname(__DIR__, 1) . '/controllers/checkSession.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control ADS - Dashboard</title>
    <link rel="stylesheet" href="../../public/src/assets/css/styles.css">
</head>

<body>
    <?php include './nav.php' ?>
    <div class="container-fluid py-6 px-5 is-flex is-flex-direction-column is-gap-4">
        <div>
            <p class="title mb-2">Uploads realizados</p>
            <p class="subtitle">Aqui está sua lista de campanhas upadas</p></a>
        </div>
        
        <div class="table-container-uploads is-hidden">
            <div class="is-flex is-gap-2 is-align-items-center py-3">
                <label class="is-clickable">
                    <input type="checkbox" class="select-all-checkbox is-clickable">
                    Selecionar Todos
                </label>
                <button id="delete-button" class="button is-danger">Deletar Selecionados</button>
            </div>
            
            <table class="mt-3 table is-fullwidth"></table>
        </div>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script defer src="https://unpkg.com/@popperjs/core@2"></script>
    <script defer src="https://unpkg.com/tippy.js@6"></script>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script defer src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script defer src="https://cdn.datatables.net/2.1.5/js/dataTables.bulma.js"></script>
    <script type="module" src="./assets/js/dashboard.js"></script>
</body>

</html>
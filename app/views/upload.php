<?php
require_once realpath(dirname(__DIR__, 1) . '/controllers/checkSession.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control ADS - Upload</title>
    <link rel="stylesheet" href="../../public/src/assets/css/styles.css">
    <script defer src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
</head>

<body>
    <?php include './nav.php' ?>
    <div class="container-fluid py-6 px-5 is-flex is-flex-direction-column is-gap-4">
        <div>
            <p class="title mb-2">Upload de planilha modelo</p>
            <a href="./assets/files/model.xlsx" download class="subtitle">
                Baixe aqui o modelo
                <i class="fa-solid fa-download"></i>
            </a>
        </div>
        
        <div class="file has-name">
            <label class="file-label">
                <input id="upload-file" class="file-input" type="file" name="resume" accept=".xlsx"/>
                <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label"> Escolha um arquivo .xlxs </span>
                </span>
                <span class="file-name"> Nenhum arquivo selecionado </span>
            </label>
        </div>

        <div class="py-3 table-container"></div>
    </div>
    <script type="module" src="./assets/js/upload.js"></script>
</body>

</html>
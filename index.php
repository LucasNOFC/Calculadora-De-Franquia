<?php

include "functions.php";

$franchiseValue = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FipeValue = trimAndFormatFipeValue($_POST["FipeValue"]);
    $percentageF = trimAndFormatPercentage($_POST["percentageF"]);
    $isCar = parseType($_POST["isCar"]);

    $franchiseValue = fipeCalculator($FipeValue, $percentageF, $isCar);
    $script = scriptOutput($isCar, $franchiseValue, $percentageF, $_POST["FipeValue"]);
    header("Location: " . $_SERVER['PHP_SELF']
        . "?result=" . urlencode($franchiseValue)
        . "&text=" . urlencode($script));
    exit;
}

if (isset($_GET['result'])) {
    $franchiseValue = $_GET['result'];
    $script = $_GET['text'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franquia Calculator</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <main class="calculator-container">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="calculator" id="form">
            <div class="form-input">
                <div class="form-fields">
                    <label for="FipeValue">Valor da Fipe</label>
                    <input id="FipeValue" name="FipeValue" class="inputValues" type="text" inputmode="numeric" autocomplete="off" required>
                </div>
                <div class="form-fields">
                    <label for="percentageF">% do calculo</label>
                    <input id="percentageF" name="percentageF" class="inputValues" type="text" inputmode="numeric" autocomplete="off" required>
                </div>
                <div class="form-fields">
                    <label for="percentageF">Moto</label>
                    <input id="isCar" value="False" name="isCar" class="inputValues" type="radio" required>
                    <label for="percentageF">Carro</label>
                    <input id="isCar" value="True" name="isCar" class="inputValues" type="radio" required>
                </div>
            </div>
            <button>Resultado</button>
        </form>

        <?php if ($franchiseValue !== 0): ?>
            <div class="franchise-container">
                <p>O valor do sinistro é: R$<?= $franchiseValue ?></p>
                <button id="copyButton" data-text="<?= $script ?>">Copiar Texto</button>
            </div>
        <?php endif; ?>

    </main>

    <script src="functions.js"></script>
</body>

</html>
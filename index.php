<?php
session_start();
include "functions.php";

$franchiseValue = null;
$finalValue = null;
$script = null;


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $FipeValue      = trimAndFormatFipeValue($_POST["FipeValue"] ?? "");
    $percentageF    = trimAndFormatPercentage($_POST["percentageF"] ?? "");
    $isCar          = parseType($_POST["isCar"] ?? "");

    $calculatedFranchise = fipeCalculator($FipeValue, $percentageF, $isCar);
    $formattedFranchise = finalValueFormated($calculatedFranchise);

    $_SESSION['result'] = [
        'franchiseValue' => $calculatedFranchise,
        'finalValue' => $formattedFranchise,
        'script' => scriptOutput($isCar, $formattedFranchise, $percentageF, $_POST["FipeValue"])
    ];


    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_SESSION['result'])) {
    $franchiseValue = $_SESSION['result']['franchiseValue'];
    $script = $_SESSION['result']['script'];
    unset($_SESSION['result']);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Franquia</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <main class="calculator-container">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="calculator" id="form">
            <div class="form-header">Calculadora de Franquia</div>
            <div class="form-input">
                <div class="form-fields-container">
                    <div class="form-fields form-input-fields">
                        <label for="FipeValue">Valor da Fipe</label>
                        <input id="FipeValue" pattern="^[R\$0-9,\.]+$" oninput="this.value = this.value.replace(/[^R\$0-9,\.]/g, '')" name="FipeValue" class="inputValues" type="text" inputmode="numeric" autocomplete="off" required>
                    </div>
                    <div class="form-fields form-input-fields">
                        <label for="percentageF">% do calculo</label>
                        <input id="percentageF" pattern="^[\%0-9,\.]+" oninput="this.value = this.value.replace(/[^%\0-9,\.]/g, '')" name="percentageF" class="inputValues" type="text" inputmode="numeric" autocomplete="off" required>
                    </div>
                    <div class="form-fields">
                        <label for="percentageF">Moto</label>
                        <input id="isCar" value="False" name="isCar" class="inputValues" type="radio" required>
                        <label for="percentageF">Carro</label>
                        <input id="isCar" value="True" name="isCar" class="inputValues" type="radio" required>
                    </div>
                </div>
                <button>Resultado</button>
            </div>
        </form>

        <?php if (isset($franchiseValue)): ?>
            <div class="franchise-container" data-container="exists">
                <p>O valor do sinistro é: R$<?= $franchiseValue ?></p>
                <button id="copyButton" data-text="<?= $script ?>">Copiar Texto</button>
            </div>
        <?php endif; ?>

    </main>

    <script src="functions.js"></script>
</body>

</html>
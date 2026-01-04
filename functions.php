<?php

$fipe = "";
$percentage = "";
$script = "";
$isCarVehicle = "";

function fipeCalculator($fipe, $percentage, $isCarVehicle)
{

    $franchiseValue = ($fipe / 100) * $percentage;

    if (!!$isCarVehicle) {
        if ($franchiseValue < 1000.00 && $percentage === 4) {
            $franchiseValue = 1000.00;
        } else if ($franchiseValue < 1200.00 && $percentage === 6) {
            $franchiseValue = 1200.00;
        } else if ($franchiseValue < 1400.00 && $percentage === 7) {
            $franchiseValue = 1400.00;
        }
    } else {
        $rules = [
            [0,      7499.99,  500.00],
            [7500,   12499.99, 625.00],
            [12500,  14999.99, 700.00],
            [15000,  19999.99, 1000.00],
            [20000,  29999.99, 2400.00],
            [30000,  39999.99, 3200.00],
            [40000,  49999.99, 4000.00],
        ];

        foreach ($rules as [$min, $max, $value]) {
            if ($fipe >= $min && $fipe <= $max && $franchiseValue < $value) {
                $franchiseValue = $value;
                break;
            }
        }
    }



    return $franchiseValue;
}

function finalValueFormated($franchise)
{
    $number = preg_replace('/[^\d.]/', '', $franchise);
    $number = floatval($number);
    $formatted = number_format($number, 2, ",", ".");
    return $formatted;
}

function trimAndFormatFipeValue($fipe)
{
    $fipe = str_replace(
        ["R$", " ", ".", ","],
        ["", "", "", "."],
        $fipe
    );

    return (float) $fipe;
}

function trimAndFormatPercentage($percentage)
{
    $percentage = str_replace("%", "", $percentage);
    return (int) $percentage;
}

function parseType($isCarVehicle)
{
    if ($isCarVehicle === "True") return true;
    else return false;
}

function scriptOutput($isCarVehicle, $franchise, $percentage, $fipe)
{

    if (!$isCarVehicle) {
        $script = <<< TEXTO

        A participação individual, também conhecida como “Franquia”, é uma parte do custo que o associado contratante deve pagar. Conforme previsto em contrato, essa cobrança ocorre, somente em casos de acionamentos. Em casos pequenas ou grandes colisões, perca total, roubo e furto.

        A P.I é calculada com base em uma COTA que estar em nosso regulamento, verificamos o valor FIPE do veículo no mês vigente ao do sinistro. O valor FIPE do seu veículo no mês do sinistro é de R$ $fipe sendo assim a P.I para este acionamento será de R$ $franchise e esse é o valor que será pago para cobrir os custos relacionados a este acionamento.

        Porém, este pagamento não é efetuado agora, primeiramente solicitamos algumas documentações, após o envio completo destas documentações serão encaminhadas para análise do processo que tem um prazo de até 72hs úteis para conclusão, concluída e aprovada seguiremos para o pagamento, confirmado o pagamento será iniciado a fase final deste acionamento.

        ➡️ Podemos seguir para documentação necessária ou há alguma dúvida?

        TEXTO;

        return $script;
    } else {
        $script = <<< TEXTO

        A participação individual, também conhecida como “Franquia”, é uma parte do custo que o associado contratante deve pagar. Conforme previsto em contrato, essa cobrança ocorre, somente em casos de acionamentos. Em casos pequenas ou grandes colisões, perca total, roubo e furto.

        A PI é calculada com base em $percentage% do valor FIPE do veículo no mês vigente ao do sinistro. O valor FIPE do seu veículo no mês do sinistro é de R$ $fipe sendo assim a PI para este acionamento será de R$ $franchise e esse é o valor que será pago para cobrir os custos relacionados a este acionamento.

        Porém, este pagamento não é efetuado agora, primeiramente solicitamos algumas documentações, após o envio completo destas documentações serão encaminhadas para análise do processo que tem um prazo de até 72hs úteis para conclusão, concluída e aprovada seguiremos para o pagamento, confirmado o pagamento será iniciado a fase final deste acionamento.

        ➡️ Podemos seguir para documentação necessária ou há alguma dúvida?
       
        TEXTO;

        return $script;
    }
}

function test() {
    return null;
}

$formatedFipe = trimAndFormatFipeValue($fipe);
$formatedPercentage = trimAndFormatPercentage($percentage);
$franchiseValue = fipeCalculator($formatedFipe, $formatedPercentage, false);
$script = scriptOutput($isCarVehicle, $franchiseValue, $formatedPercentage, $fipe);



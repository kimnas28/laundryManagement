<?php
function computeBilling($weightKg, $choice, $kgSize = 8) {
    $rates = [
        'Deluxe Package' => 180,
        'Wash' => 60,
        'Dry' => 65,
        'Full Package' => 160,
        'Wash Dry w/o Soap' => 135,
        'Wash Dry Fold' => 155,
        'Wash Dry w/ Soap' => 125,
        'Spin' => 25,
        'ExtraDry' => 25,
    ];

    $total = ceil($weightKg / $kgSize);
    return isset($rates[$choice]) ? $total * $rates[$choice] : 0;
}

function computeAddons($addons, $quantities) {
    $prices = [
        'Detergent' => 10,
        'Fabcon' => 15,
        'ColorSafe' => 20,
        'ExtraDry' => 25,
        'ExtraSpin' => 25,
    ];

    $total = 0;
    foreach ($addons as $addon) {
        $qty = isset($quantities[$addon]) ? $quantities[$addon] : 1;
        $total += ($prices[$addon] ?? 0) * $qty;
    }
    return $total;
}
?>

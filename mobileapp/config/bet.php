<?php
$aCoefficients = [
        '1.00' => '2元',
        '0.50' => '1元',
        '0.10' => '2角',
        '0.05' => '1角',
        '0.01' => '2分',
];
return [
    'coefficients' => $aCoefficients,
    'coefficientValues' => array_keys($aCoefficients),
    'split_char'    => '|',
    'split_char_lotto_in_area' => ' ',
    'split_char_lotto_area' => '+',
    'possible_split_chars'  => '|, ',
];
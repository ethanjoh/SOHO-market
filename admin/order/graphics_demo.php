<?php
// seed with microseconds
function make_seed() {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}


// Data to show. Each $n index is one　 trace
$a_data = array();
for ($n = 0; $n < 5; $n ++) {
    srand(make_seed());
    $a_data[$n][0] = round(rand(0,100));
    $a_data[$n][1] = round(rand(0,100));
    $a_data[$n][2] = round(rand(0,100));
    $a_data[$n][3] = round(rand(0,100));
    $a_data[$n][4] = round(rand(0,100));
    $a_data[$n][5] = round(rand(0,100));
    $a_data[$n][6] = round(rand(0,100));
    $a_data[$n][7] = round(rand(0,100));
    $a_data[$n][8] = round(rand(0,100));
    $a_data[$n][9] = round(rand(0,100));
    $a_data[$n][10] = round(rand(0,100));
    $a_data[$n][11] = round(rand(0,100));
}

// Horizontal indexes
$a_h_indexes[0] =  "JAN";
$a_h_indexes[1] =  "FEB";
$a_h_indexes[2] =  "MAR";
$a_h_indexes[3] =  "APR";
$a_h_indexes[4] =  "MAY";
$a_h_indexes[5] =  "JUN";
$a_h_indexes[6] =  "JUL";
$a_h_indexes[7] =  "AUG";
$a_h_indexes[8] =  "SEP";
$a_h_indexes[9] =  "OCT";
$a_h_indexes[10] = "NOV";
$a_h_indexes[11] = "DIC";

// Vertical indexes
$a_v_indexes[0] = 0;
$a_v_indexes[1] = 10;
$a_v_indexes[2] = 20;
$a_v_indexes[3] = 30;
$a_v_indexes[4] = 40;
$a_v_indexes[5] = 50;
$a_v_indexes[6] = 60;
$a_v_indexes[7] = 70;
$a_v_indexes[8] = 80;
$a_v_indexes[9] = 90;
$a_v_indexes[10] = 100;

// Colors array
$a_colors[0] = "000000";
$a_colors[1] = "6600FF";
$a_colors[2] = "FF0099";
$a_colors[3] = "33CC00";
$a_colors[4] = "CCCC00";
$a_colors[5] = "0000CC";
$a_colors[6] = "FFFF66";
$a_colors[7] = "006600";
$a_colors[8] = "00FFFF";
$a_colors[9] = "FFFFFF";
$a_colors[10] = "660033";
$a_colors[11] = "66FFCC";

graphic($a_data, $a_v_indexes, $a_h_indexes, $a_colors);
?>
<?php
define('__CATEGORIES__', array('ACCOUNT', 'OTHER', 'RECLAIMS', 'ACCOUNT') );
$main_conn = new mysqli('localhost', 'root', '', 'test');

$__WEBSITES_CHILDREN = '_websites_children';
$__WEBSITES = '_websites';
$__ACCOUNTS = '_accounts';
$__SALES = '_sales';
$__RECLAIMS = '_reclaims';
$__MESSAGES = '_messages';
// $__ = '';

function getScreensCollection(mysqli $conn, string $site_code) : array {
    global $__WEBSITES_CHILDREN;
    $q = "SELECT `CHILDREN` FROM `$__WEBSITES_CHILDREN` WHERE `SITE_CODE` = '$site_code'";
    $result = $conn->query($q);

    while($record = $result->fetch_assoc()) {
        $arr = explode('/', $record['CHILDREN']);
        return $arr;
    }
}

function clean_txt(string $txt) {
    $txt = trim($txt);
    $txt = htmlentities($txt);
    $txt = stripslashes($txt);
    return $txt;
}

function getReclaimID() {
    $dictionary = array(
        0 => '0',
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => 'A',
        11 => 'B',
        12 => 'C',
        13 => 'D',
        14 => 'E',
        15 => 'F',
        );

    $year = date('Y');
    $year = substr($year, 2);

    $two_digits = '';
    $penta_group = '';

    for ($i = 0; $i < 2; $i++) { 
        $random = rand(0,15);
        $two_digits .= $dictionary[$random];
    }

    for ($i = 0; $i < 5; $i++) { 
        $random = rand(0,15);
        $penta_group .= $dictionary[$random];
    }

    return "$year" . "X$two_digits-$penta_group"; 
}



?>
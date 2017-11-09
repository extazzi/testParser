<?php

require_once './ParsingClass.php';
require_once './OPZ.php';
require_once './DBClass.php';
require_once './calcOPZ.php';

$pars = new ParsingClass();
$db = new DBClass();
$opz = new OPZ();
$calc = new calcOPZ();
//parse info
$pars->ParseAll();
//add result to db
$db->SetEquations($pars->ParseAll());
//get rezult from db
$data = $db->GetEquations();
foreach ($data as $dataParse) {
    //OPZ
    $rez = $opz->GetOPZ($dataParse);
    //Calculation opz
    $rezAll[] = $calc->rpn($rez);
}
//add result to db
$db->SetRez($rezAll);
?>
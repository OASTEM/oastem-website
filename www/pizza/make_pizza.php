<?php
$pepo = $sau = $can = $chi = $bac = $anc = $pepr = $jal = $oli = $pin = $tom = $oni = $mus = $whi = $veg false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pep = $_POST["pepo"];
    $sau = $_POST["sau"];
    $can = $_POST["can"];
    $chi = $_POST["chi"];
    $bac = $_POST["bac"];
    $anc = $_POST["anc"];
    
    $pepr = $_POST["pepr"];
    $jal = $_POST["jal"];
    $oli = $_POST["oli"];
    $pin = $_POST["pin"];
    $tom = $_POST["tom"];
    $oni = $_POST["oni"];
    $mus = $_POST["mus"];
    $whi = $_POST["whi"];
    
    $veg = $POST["veg"];
    echo "Form submitted. If it was done successfully I don't actually know";
}
echo "pls work";
?>
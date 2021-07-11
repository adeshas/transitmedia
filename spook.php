<?php

require_once 'PrivateFunctions.php';

$qty = $_GET["quantity"];
$price = $_GET["price_id"];
$html = $_GET['html'];

$output = determine_price($price,$qty,$html);
echo $output;

?>

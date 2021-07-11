<?php

namespace PHPMaker2021\test;

// Page object
$Spook = &$Page;
?>
<?php

require_once 'views/PrivateFunctions.php';

$qty = $_GET["quantity"];
$price = $_GET["price_id"];
$html = $_GET['html'];

$output = determine_price($price,$qty,$html);
echo $output;

?>

<?php
echo GetDebugMessage();
?>

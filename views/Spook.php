<?php

namespace PHPMaker2021\test;

// Page object
$Spook = &$Page;
?>
<?php
if(isset($_GET["price_id"]) && is_numeric($_GET["price_id"]) &&
isset($_GET["quantity"]) && is_numeric($_GET["quantity"])){
	$quantity = (int) $_GET["quantity"];
	$price_id = (int) $_GET["price_id"];
	$sql = "select * FROM public.z_price_settings p where p.id = {$price_id};";
	$price_details = ExecuteRow($sql);
	//$final_price = [ 'cost' => (int)$price * (int) $quantity ];


	
	if($price_details["inventory_id"] == 3){
		// IF BRT TV
	
		if( isset($price_details["min_limit"]) && isset($price_details["max_limit"])){
			// IF BRT TV WITH BUS LIMITS

			$min = $price_details["min_limit"];
			$max = $price_details["max_limit"];

			if($quantity >= $min && $quantity <= $max){
				//FINAL PRICE WITH CORRECT LIMITS
				$final_price = [
					'cost' => $price_details,
					'display_quantity' => $quantity,
					'final_price' => (int)$price_details["price"] * (int) $quantity
				];
			}else{
				//SHOW ERROR FOR BAD LIMITS
				$error = "Please set your quantity between {$min} and {$max}.";
				echo $error;
				exit;
			}
			
		}else{
			//IF BRT TV WITH WHOLE FLEET AND NO LIMITS
			//FINAL PRICE WHOLE FLEET
			$final_price = [
				'cost' => $price_details,
				'display_quantity' => "All available buses in fleet",
				'final_price' => (int)$price_details["price"]
			];
		}

	}else{
		// IF NON BRT TV
		$final_price = [
			'cost' => $price_details ,
			'display_quantity' => $quantity,
			'final_price' => (int) $price_details["price"] * (int) $quantity
		];
	}
	
	$final_price["rate"] = $price_details["price"];
	$final_price["details"] = $price_details["details"];	
	$final_price["quantity"] = $quantity;
	$final_price["display_price"] = "N ".number_format($final_price["final_price"]);
	$final_price["display_rate"] = "N ".number_format($final_price["rate"]);



	if( isset($_GET['html']) && $_GET['html'] == true ){
	$snippet = <<<EOT
<div class="col-sm-10" style="margin-top: 10px;">
<table class="table-bordered table-sm ew-db-table" style="min-width: 60%">
  <tr>
    <th colspan="2">Cost Breakdown (estimated)</th>
  </tr>
  <tr>
    <th>Rate Details</th>
    <td>{$final_price["details"]}</td>
  </tr>
  <tr>
    <th>Number of Buses</th>
    <td>{$final_price["display_quantity"]}</td>
  </tr>
  <tr>
    <th>Rate</th>
    <td>{$final_price["display_rate"]}</td>
  </tr>
  <tr>
    <th>Est. Cost:</th>
    <td>{$final_price["display_price"]}</td>
  </tr>
</table>
</div>
EOT;


	echo $snippet;	
}else{
	echo json_encode($final_price);

}


}



?>

<?php
echo GetDebugMessage();
?>

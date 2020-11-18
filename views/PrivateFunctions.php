<?php

namespace PHPMaker2021\test;

// Page object
$PrivateFunctions = &$Page;
?>
<?php

function debugdump($name ="",$value){
	$out = '';
	if(is_array($value)){$out = json_encode($value);}else{$out = $value;}
	file_put_contents('abc.log', "\n---- ".date('Ymd His')." - $name -----\n".$out."\n---------\n", FILE_APPEND | LOCK_EX);
}

function get_emails($source, $to = "", $cc = "", $bcc = "")
{
	extract($source);

	$final_to = purify_list($to, $to_value);
	$final_cc = purify_list($cc, $cc_value);
	$final_bcc = purify_list($bcc, $bcc_value);

	$output = compact('final_to', 'final_cc', 'final_bcc');
	// var_dump($output);
	return $output;

}

function purify_list($comma_sep_list1, $comma_sep_list2)
{

	$regex = '/[^0-9a-zA-Z\.\-_@,]+/';
	$emaillist1 = explode(",", preg_replace($regex, ',', trim($comma_sep_list1)));
	$emaillist2 = explode(",", preg_replace($regex, ',', trim($comma_sep_list2)));

	$purelist_array = array_unique(array_merge($emaillist1, $emaillist2));

	$purelist_array_cleaned = array_filter($purelist_array);
	$purelist = implode(',', $purelist_array_cleaned);

	return $purelist;
}

function getEmailPayload($name)
{
	$sql = "select * from z_email_settings where name = '" . $name . "';";
	$report_details = 2ExecuteRow($sql);
	return $report_details;
}

function convert_to_xml($input_txt)
{

	#TRIM LINES
	$input_txt_trimmed = preg_replace('#[^A-Za-z0-9/, \\\\]+#', "\n", $input_txt);
	$input_txt_array = explode("\n", trim($input_txt_trimmed));

	$input_txt_array = array_merge(["::ASSIGNED BUS CODES::"],$input_txt_array);
	
	$items = '';
	foreach ($input_txt_array as $key => $value) {
		$items .= '<a:p><a:r><a:rPr lang="fi-FI" sz="1050" dirty="0" /><a:t>' . $value . '</a:t></a:r></a:p>';
	}

	$template = '<p:sp><p:nvSpPr><p:cNvPr id="2" name="TextBox 1" /><p:cNvSpPr txBox="1" /><p:nvPr /></p:nvSpPr><p:spPr><a:xfrm><a:off x="7647708" y="1553461" /><a:ext cx="4083627" cy="3162404" /></a:xfrm><a:prstGeom prst="rect"><a:avLst /></a:prstGeom><a:noFill /></p:spPr><p:txBody><a:bodyPr wrap="square" rtlCol="0"><a:spAutoFit /></a:bodyPr><a:lstStyle /><<<TAGS>>></p:txBody></p:sp>';
	$output_txt = str_replace('<<<TAGS>>>', $items, $template);

	return $output_txt;

}


function determine_price($price,$qty,$html=FALSE){
	if(isset($price) && is_numeric($price) && isset($qty) && is_numeric($qty)){
	$quantity = (int) $qty;
	$price_id = (int) $price;
	$sql = "select * FROM public.view_pricing_all p where p.id = {$price_id};";
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
	
	$final_price["platform"] = $price_details["platform"];
	$final_price["inventory"] = $price_details["inventory"];
	$final_price["bus_size"] = $price_details["bus_size"];
	$final_price["rate"] = $price_details["price"];
	$final_price["details"] = $price_details["details"];	
	$final_price["quantity"] = $quantity;
	$final_price["display_price"] = "N ".number_format($final_price["final_price"]);
	$final_price["display_rate"] = "N ".number_format($final_price["rate"]);



	if( isset($html) && $html == true ){
	$snippet = <<<EOT
<div class="col-sm-10" style="margin-top: 10px;">
<table class="table-bordered table-sm ew-db-table" style="min-width: 60%">
  <tr>
    <th colspan="2" style=" text-transform: uppercase; background-color: #0074b3; color: #FFF;">Cost Breakdown (estimated)</th>
  </tr>
  <tr>
    <th style="text-align:right">Platform</th>
    <td>{$final_price["platform"]}</td>
  </tr>
  <tr>
    <th style="text-align:right">Inventory</th>
    <td>{$final_price["inventory"]}</td>
  </tr>
  <tr>
    <th style="text-align:right">Bus Size</th>
    <td>{$final_price["bus_size"]}</td>
  </tr>
  <tr>
    <th style="text-align:right">Rate Details</th>
    <td>{$final_price["details"]}</td>
  </tr>
  <tr>
    <th style="text-align:right">Number of Buses</th>
    <td>{$final_price["display_quantity"]}</td>
  </tr>
  <tr>
    <th style="text-align:right">Rate</th>
    <td>{$final_price["display_rate"]}</td>
  </tr>
  <tr>
    <th style="text-align:right">Est. Cost:</th>
    <td><b>{$final_price["display_price"]}</b></td>
  </tr>
</table>
</div>
EOT;


	return $snippet;	
}else{
	return json_encode($final_price);

}

}

}





function sendTMmail($from, $to, $subject, $msg, $msgtxt="", $attach = null, $cc = "", $bcc = ""){

		
		$email = new Email();
		
		$testing_mode = false;
        if ($testing_mode === true) {
            $test_mode = 'TESTING: ';
            $email->replaceSender($from, 'Transit Media Admin');
            $email->addRecipient('ademola.shasanya@valuemedia.com.ng', 'Ade Shas');
        } else {
            $test_mode = '';

            //Recipients
            $email->Sender = 'Transit Media Admin <'.$from.'>';

            $to_array = explode(",", $to);
            foreach ($to_array as $to_recipient) {
                // $email->addRecipient($to_recipient, 'Transit Media User'); // Add a recipient
                $email->addRecipient($to_recipient); // Add a recipient
            }

            if ($cc != "" && strlen($cc) > 3) {
                $cc_array = explode(",", $cc);
                foreach ($cc_array as $cc_recipient) {
                    $email->addCC($cc_recipient); // Add a recipient
                }
            }

            if ($bcc != "" && strlen($bcc) > 3) {
                $bcc_array = explode(",", $bcc);
                foreach ($bcc_array as $bcc_recipient) {
                    $email->addBCC($bcc_recipient);
                }
            }

			/*
            $email->addAddress($to, 'Transit Media User'); // Add a recipient

            $email->addAddress('info@transitmedia.com.ng');               // Name is optional
            $email->addReplyTo('info@transitmedia.com.ng', 'Transit Media');
            $email->addCC('test@transitmedia.com.ng');

            $email->addBCC('ope.senbanjo@transitmedia.com.ng');
            $email->addBCC('dotun.falade@transitmedia.com.ng');
            $email->addBCC('johnson.udoeka@transitmedia.com.ng');
            $email->addBCC('toyosi.aramide@transitmedia.com.ng');
            $email->addBCC('dolapo.arowolo@valuemedia.com.ng');
            $email->addBCC('victoria.onuoha@transitmedia.com.ng');
			$email->addBCC('');
			*/
            $email->addBCC('ademola.shasanya@valuemedia.com.ng');
		}
		
		/*
		$email->Sender = 'admin@transitmedia.com.ng'; 
		$email->Recipient = 'adeshas@gmail.com'; 
		$email->Cc = 'ademola.shasanya@valuemedia.com.ng'; 
		$email->Bcc = ''; 
		$email->Subject = 'Test Trial'; 
		$email->Content = $msg; 
		$email->Format = 'HTML'; 
		$email->Charset = '';
		*/

		//Attachments
        if (isset($attach)) {
            $email->addAttachment($attach); // Add attachments
        }


        if(is_array($subject)){
                $email->Subject = $test_mode . '' . $subject[0] . '';
        }else{
                $email->Subject = $test_mode . 'CAMPAIGN NOTICE: ' . $subject . '';
        }

        
        $string = htmlentities($msg, null, 'utf-8');
        $msg = str_replace("&nbsp;", "", $string);
        $msg = html_entity_decode($msg);
		
		$email->Content = $msg;
		$debugme = deubgEmail($email,TRUE);
        $email->Content = beautify_email($msg);
        $email->AltBody = $msgtxt;

        // file_put_contents('abc.log', json_encode($mail) . "\n", FILE_APPEND | LOCK_EX);


		
		// var_dump($email->Recipient);		
		// exit;
        //$email->send();


}



function deubgEmail($email,$send=false){
	$msg = "";
	$msg .= "<table>";
	$msg .= "<tr><td>======================================</td></tr>";
	$msg .= "<tr><td><b><u>TO:</u></b> ".$email->Recipient."</td></tr>";
	$msg .= "<tr><td>--------------------------------------</td></tr>";
	$msg .= "<tr><td><b><u>CC:</u></b> ".$email->Cc."</td></tr>";
	$msg .= "<tr><td>--------------------------------------</td></tr>";
	$msg .= "<tr><td><b><u>BCC:</u></b> ".$email->Bcc."</td></tr>";
	$msg .= "<tr><td>--------------------------------------</td></tr>";
	$msg .= "<tr><td><b><u>Subject:</u></b>".$email->Subject."</td></tr>";
	$msg .= "<tr><td>--------------------------------------</td></tr>";
	$msg .= "<tr><td><b><u>Body: </u></b>".$email->Content."</td></tr>";
	$msg .= "<tr><td>======================================</td></tr>";
	$msg .= "</table>";
	
	if($send){
		$newmail = new Email();
		$newmail->Sender = 'admin@transitmedia.com.ng'; 
		$newmail->Recipient = 'ademola.shasanya@valuemedia.com.ng'; 
		$newmail->Bcc = ''; 
		$newmail->Subject = 'Debugging Email'; 
		$newmail->Content = beautify_email($msg); 
		$newmail->Format = 'HTML'; 
		$newmail->Charset = '';
		if(isset(addAttachment))
        $newmail->addAttachment($email->Attachments[0]['filename']);
		$newmail->send();
	}		
	return $msg;
}



function beautify_email($new_content){
	$template = file_get_contents('template.html');
	$template = str_replace('<!--ENTER CONTENT HERE-->',$new_content,$template);
	return $template;
}


function buttonStyle($ps){

        switch ($ps) {
        case "1":
            $ps_output = "btn btn-block btn-default disabled";
            break;
        case "2":
            $ps_output = "btn btn-block btn-success disabled";
            break;
        case "3":
            $ps_output = "btn btn-block btn-danger disabled";
            break;
        case "4":
            $ps_output = "btn btn-block btn-secondary disabled";
            break;
        case "5":
            $ps_output = "btn btn-block btn-info disabled";
            break;
        default:
            $ps_output = "btn btn-block btn-default disabled";
        }
        return $ps_output;
}

/*
TEXT IN XML TO REPLACE
</p:sp></p:spTree>

REPLACE WITH THIS
<p:sp>
<p:nvSpPr>
<p:cNvPr id="2" name="TextBox 1" />
<p:cNvSpPr txBox="1" />
<p:nvPr />
</p:nvSpPr>
<p:spPr>
<a:xfrm>
<a:off x="7647708" y="1553461" />
<a:ext cx="4083627" cy="3162404" />
</a:xfrm>
<a:prstGeom prst="rect">
<a:avLst />
</a:prstGeom>
<a:noFill />
</p:spPr>
<p:txBody>
<a:bodyPr wrap="square" rtlCol="0">
<a:spAutoFit />
</a:bodyPr>
<a:lstStyle />

<< ------------ AP TAGS ----------------- >>
<a:p>
<a:r>
<a:rPr lang="fi-FI" sz="1050" dirty="0" />
<a:t>OJOTA</a:t>
</a:r>
</a:p>
<< ------------ AP TAGS ----------------- >>

</p:txBody>
</p:sp>

 */


 /*
SAVE
-----------------
filter for Vendor ID on campaign table
((!IsAdmin())? " id = ".Profile()->vendor_id:"   ")









 */

?>

<?php
echo GetDebugMessage();
?>

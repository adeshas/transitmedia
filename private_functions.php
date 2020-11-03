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
	$sql = "select * from email_settings where name = '" . $name . "';";
	$report_details = ew_ExecuteRow($sql);
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

?>

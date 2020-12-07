<?php

if(isset($_GET["id"])){
	// Get parameters
	$file = '/opt/lampp/htdocs/printingandbrandingv3/passes/BRANDERS_PASS_434-'.$_GET["id"].'.pdf';

	// Process download
	if(file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		flush(); // Flush system output buffer
		readfile($file);
		exit;
	}
}

?>

<?php



if (isset($_GET["id"])) {
	// Get parameters
	if ($_GET["v"] = 'v3.1') {
		$file = '/opt/tmscripts/invoices_test3.1/TRANSIT_MEDIA_PURCHASE_ORDER_IPOV3-TM-' . $_GET["id"] . '_' . $_GET["v"] . '.pdf';

	} elseif ($_GET["v"] = 'v3.2') {
		$file = '/opt/tmscripts/invoices_test3.2/TRANSIT_MEDIA_PURCHASE_ORDER_IPOV3-TM-' . $_GET["id"] . '_' . $_GET["v"] . '.pdf';

	}

	if (!file_exists($file)) {
		$file = '/opt/tmscripts/TMDOC_invoices/TRANSIT_MEDIA_PURCHASE_ORDER_IPOV3-TM-' . $_GET["id"] . '.pdf';
	}

	if (!file_exists($file)) {
		$f = glob('/opt/tmscripts/TMDOC_invoices/TRANSIT*-'.$_GET["id"].'.pdf');
		if(count($f) >= 1){
			$file = $f[0];
			if (!file_exists($file)) {
				exit('File not found !');
			}
		}else{
			exit('File not found !');
		}
	}else{
		// exit('File found '.$file);
	}

	// Process download
	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
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

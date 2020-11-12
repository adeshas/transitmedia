<?php

namespace PHPMaker2021\test;

// Page object
$Test = &$Page;
?>
<?php

// echo "Hello";

$email = new Email();
$email->Sender = 'admin@transitmedia.com.ng'; 
$email->Recipient = 'adeshas@gmail.com'; 
$email->Cc = 'ademola.shasanya@valuemedia.com.ng'; 
$email->Bcc = ''; 
$email->Subject = 'Test Trial'; 
$email->Content = '<p>Email works</p>'; 
$email->Format = 'HTML'; 
$email->Charset = '';
//$email->send();



?>

<?php
echo GetDebugMessage();
?>

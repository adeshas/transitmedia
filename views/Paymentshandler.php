<?php

namespace PHPMaker2021\test;

// Page object
$Paymentshandler = &$Page;
?>
<?php
	 $db =& DbHelper(); // Create instance of the database helper class by DbHelper() (for main database) or DbHelper("<dbname>") (for linked databases) where <dbname> is database variable name
 ?>
 <div class="panel panel-default">
	 <div class="panel-heading">Please Confirm Payment below:</div>
 <?php
 $sql = "SELECT 
id, (select name from main_campaigns c where c.id = t.campaign_id) as name, 
start_date, end_date, quantity, 
--(select vendor_id from main_campaigns c where c.id = t.campaign_id) as vendor 
(select (select name from y_vendors v where v.id = c.vendor_id) as vendor from main_campaigns c where c.id = t.campaign_id) as vendor 
FROM main_transactions t
where id =  ".$_GET['id'];
 echo $db->ExecuteHtml($sql, ["fieldcaption" => TRUE, "tablename" => ["main_transactions"]]); // Execute a SQL and show as HTML table
 ?>
 </div>
<div>

<div>
<form action="paymentsaction.php" method="post">
<input type="hidden" name="campaign_id" value="<?php echo $_GET['id']; ?>">
<input type="hidden" name="token" value="<?php echo CurrentPage()->Token ?>">
<input type="submit" name="action" value="Approve"> <input type="submit" name="action" value="Deny">
</form>
</div>

</div>

<?= GetDebugMessage() ?>

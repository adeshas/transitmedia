<?php

namespace PHPMaker2021\test;

// Page object
$SubTransactionDetailsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsub_transaction_detailsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fsub_transaction_detailsview = currentForm = new ew.Form("fsub_transaction_detailsview", "view");
    loadjs.done("fsub_transaction_detailsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsub_transaction_detailsview" id="fsub_transaction_detailsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_transaction_details">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
    <tr id="r_transaction_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_transaction_details_transaction_id"><?= $Page->transaction_id->caption() ?></span></td>
        <td data-name="transaction_id" <?= $Page->transaction_id->cellAttributes() ?>>
<span id="el_sub_transaction_details_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<?= $Page->transaction_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bus_id->Visible) { // bus_id ?>
    <tr id="r_bus_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_transaction_details_bus_id"><?= $Page->bus_id->caption() ?></span></td>
        <td data-name="bus_id" <?= $Page->bus_id->cellAttributes() ?>>
<span id="el_sub_transaction_details_bus_id">
<span<?= $Page->bus_id->viewAttributes() ?>>
<?= $Page->bus_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

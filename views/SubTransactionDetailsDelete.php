<?php

namespace PHPMaker2021\test;

// Page object
$SubTransactionDetailsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsub_transaction_detailsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fsub_transaction_detailsdelete = currentForm = new ew.Form("fsub_transaction_detailsdelete", "delete");
    loadjs.done("fsub_transaction_detailsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsub_transaction_detailsdelete" id="fsub_transaction_detailsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_transaction_details">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <th class="<?= $Page->transaction_id->headerCellClass() ?>"><span id="elh_sub_transaction_details_transaction_id" class="sub_transaction_details_transaction_id"><?= $Page->transaction_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bus_id->Visible) { // bus_id ?>
        <th class="<?= $Page->bus_id->headerCellClass() ?>"><span id="elh_sub_transaction_details_bus_id" class="sub_transaction_details_bus_id"><?= $Page->bus_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <th class="<?= $Page->vendor_id->headerCellClass() ?>"><span id="elh_sub_transaction_details_vendor_id" class="sub_transaction_details_vendor_id"><?= $Page->vendor_id->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <td <?= $Page->transaction_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_transaction_id" class="sub_transaction_details_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<?= $Page->transaction_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bus_id->Visible) { // bus_id ?>
        <td <?= $Page->bus_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_bus_id" class="sub_transaction_details_bus_id">
<span<?= $Page->bus_id->viewAttributes() ?>>
<?= $Page->bus_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td <?= $Page->vendor_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_vendor_id" class="sub_transaction_details_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

<?php

namespace PHPMaker2021\test;

// Page object
$XTransactionStatusDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fx_transaction_statusdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fx_transaction_statusdelete = currentForm = new ew.Form("fx_transaction_statusdelete", "delete");
    loadjs.done("fx_transaction_statusdelete");
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
<form name="fx_transaction_statusdelete" id="fx_transaction_statusdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="x_transaction_status">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_x_transaction_status_id" class="x_transaction_status_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_x_transaction_status_name" class="x_transaction_status_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->admin_name->Visible) { // admin_name ?>
        <th class="<?= $Page->admin_name->headerCellClass() ?>"><span id="elh_x_transaction_status_admin_name" class="x_transaction_status_admin_name"><?= $Page->admin_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->operator_name->Visible) { // operator_name ?>
        <th class="<?= $Page->operator_name->headerCellClass() ?>"><span id="elh_x_transaction_status_operator_name" class="x_transaction_status_operator_name"><?= $Page->operator_name->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_x_transaction_status_id" class="x_transaction_status_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_x_transaction_status_name" class="x_transaction_status_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->admin_name->Visible) { // admin_name ?>
        <td <?= $Page->admin_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_x_transaction_status_admin_name" class="x_transaction_status_admin_name">
<span<?= $Page->admin_name->viewAttributes() ?>>
<?= $Page->admin_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->operator_name->Visible) { // operator_name ?>
        <td <?= $Page->operator_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_x_transaction_status_operator_name" class="x_transaction_status_operator_name">
<span<?= $Page->operator_name->viewAttributes() ?>>
<?= $Page->operator_name->getViewValue() ?></span>
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

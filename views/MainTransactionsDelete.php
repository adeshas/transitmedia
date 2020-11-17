<?php

namespace PHPMaker2021\test;

// Page object
$MainTransactionsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmain_transactionsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fmain_transactionsdelete = currentForm = new ew.Form("fmain_transactionsdelete", "delete");
    loadjs.done("fmain_transactionsdelete");
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
<form name="fmain_transactionsdelete" id="fmain_transactionsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_transactions">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_main_transactions_id" class="main_transactions_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <th class="<?= $Page->campaign_id->headerCellClass() ?>"><span id="elh_main_transactions_campaign_id" class="main_transactions_campaign_id"><?= $Page->campaign_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <th class="<?= $Page->operator_id->headerCellClass() ?>"><span id="elh_main_transactions_operator_id" class="main_transactions_operator_id"><?= $Page->operator_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
        <th class="<?= $Page->payment_date->headerCellClass() ?>"><span id="elh_main_transactions_payment_date" class="main_transactions_payment_date"><?= $Page->payment_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
        <th class="<?= $Page->price_id->headerCellClass() ?>"><span id="elh_main_transactions_price_id" class="main_transactions_price_id"><?= $Page->price_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th class="<?= $Page->quantity->headerCellClass() ?>"><span id="elh_main_transactions_quantity" class="main_transactions_quantity"><?= $Page->quantity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <th class="<?= $Page->start_date->headerCellClass() ?>"><span id="elh_main_transactions_start_date" class="main_transactions_start_date"><?= $Page->start_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <th class="<?= $Page->end_date->headerCellClass() ?>"><span id="elh_main_transactions_end_date" class="main_transactions_end_date"><?= $Page->end_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
        <th class="<?= $Page->visible_status_id->headerCellClass() ?>"><span id="elh_main_transactions_visible_status_id" class="main_transactions_visible_status_id"><?= $Page->visible_status_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <th class="<?= $Page->status_id->headerCellClass() ?>"><span id="elh_main_transactions_status_id" class="main_transactions_status_id"><?= $Page->status_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->print_status_id->Visible) { // print_status_id ?>
        <th class="<?= $Page->print_status_id->headerCellClass() ?>"><span id="elh_main_transactions_print_status_id" class="main_transactions_print_status_id"><?= $Page->print_status_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
        <th class="<?= $Page->payment_status_id->headerCellClass() ?>"><span id="elh_main_transactions_payment_status_id" class="main_transactions_payment_status_id"><?= $Page->payment_status_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th class="<?= $Page->total->headerCellClass() ?>"><span id="elh_main_transactions_total" class="main_transactions_total"><?= $Page->total->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_main_transactions_id" class="main_transactions_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_campaign_id" class="main_transactions_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td <?= $Page->operator_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_operator_id" class="main_transactions_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
        <td <?= $Page->payment_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_payment_date" class="main_transactions_payment_date">
<span<?= $Page->payment_date->viewAttributes() ?>>
<?= $Page->payment_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
        <td <?= $Page->price_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_price_id" class="main_transactions_price_id">
<span<?= $Page->price_id->viewAttributes() ?>>
<?= $Page->price_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <td <?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_quantity" class="main_transactions_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <td <?= $Page->start_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_start_date" class="main_transactions_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <td <?= $Page->end_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_end_date" class="main_transactions_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
        <td <?= $Page->visible_status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_visible_status_id" class="main_transactions_visible_status_id">
<span<?= $Page->visible_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->visible_status_id->getViewValue()) && $Page->visible_status_id->linkAttributes() != "") { ?>
<a<?= $Page->visible_status_id->linkAttributes() ?>><?= $Page->visible_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->visible_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <td <?= $Page->status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_status_id" class="main_transactions_status_id">
<span<?= $Page->status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->status_id->getViewValue()) && $Page->status_id->linkAttributes() != "") { ?>
<a<?= $Page->status_id->linkAttributes() ?>><?= $Page->status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->print_status_id->Visible) { // print_status_id ?>
        <td <?= $Page->print_status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_print_status_id" class="main_transactions_print_status_id">
<span<?= $Page->print_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->print_status_id->getViewValue()) && $Page->print_status_id->linkAttributes() != "") { ?>
<a<?= $Page->print_status_id->linkAttributes() ?>><?= $Page->print_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->print_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
        <td <?= $Page->payment_status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_payment_status_id" class="main_transactions_payment_status_id">
<span<?= $Page->payment_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->payment_status_id->getViewValue()) && $Page->payment_status_id->linkAttributes() != "") { ?>
<a<?= $Page->payment_status_id->linkAttributes() ?>><?= $Page->payment_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->payment_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <td <?= $Page->total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_transactions_total" class="main_transactions_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
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
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= GetUrl($Page->getReturnUrl()) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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

<?php

namespace PHPMaker2021\test;

// Page object
$PrintOrdersDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fprint_ordersdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fprint_ordersdelete = currentForm = new ew.Form("fprint_ordersdelete", "delete");
    loadjs.done("fprint_ordersdelete");
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
<form name="fprint_ordersdelete" id="fprint_ordersdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="print_orders">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_print_orders_id" class="print_orders_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <th class="<?= $Page->campaign_id->headerCellClass() ?>"><span id="elh_print_orders_campaign_id" class="print_orders_campaign_id"><?= $Page->campaign_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->printer_id->Visible) { // printer_id ?>
        <th class="<?= $Page->printer_id->headerCellClass() ?>"><span id="elh_print_orders_printer_id" class="print_orders_printer_id"><?= $Page->printer_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
        <th class="<?= $Page->ts_created->headerCellClass() ?>"><span id="elh_print_orders_ts_created" class="print_orders_ts_created"><?= $Page->ts_created->caption() ?></span></th>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
        <th class="<?= $Page->link->headerCellClass() ?>"><span id="elh_print_orders_link" class="print_orders_link"><?= $Page->link->caption() ?></span></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th class="<?= $Page->quantity->headerCellClass() ?>"><span id="elh_print_orders_quantity" class="print_orders_quantity"><?= $Page->quantity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
        <th class="<?= $Page->approved->headerCellClass() ?>"><span id="elh_print_orders_approved" class="print_orders_approved"><?= $Page->approved->caption() ?></span></th>
<?php } ?>
<?php if ($Page->comments->Visible) { // comments ?>
        <th class="<?= $Page->comments->headerCellClass() ?>"><span id="elh_print_orders_comments" class="print_orders_comments"><?= $Page->comments->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bus_codes->Visible) { // bus_codes ?>
        <th class="<?= $Page->bus_codes->headerCellClass() ?>"><span id="elh_print_orders_bus_codes" class="print_orders_bus_codes"><?= $Page->bus_codes->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_print_orders_id" class="print_orders_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_print_orders_campaign_id" class="print_orders_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->printer_id->Visible) { // printer_id ?>
        <td <?= $Page->printer_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_print_orders_printer_id" class="print_orders_printer_id">
<span<?= $Page->printer_id->viewAttributes() ?>>
<?= $Page->printer_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
        <td <?= $Page->ts_created->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_print_orders_ts_created" class="print_orders_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
        <td <?= $Page->link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_print_orders_link" class="print_orders_link">
<span<?= $Page->link->viewAttributes() ?>>
<?php if (!EmptyString($Page->link->getViewValue()) && $Page->link->linkAttributes() != "") { ?>
<a<?= $Page->link->linkAttributes() ?>><?= $Page->link->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->link->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <td <?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_print_orders_quantity" class="print_orders_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
        <td <?= $Page->approved->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_print_orders_approved" class="print_orders_approved">
<span<?= $Page->approved->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_approved_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->approved->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->approved->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_approved_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->comments->Visible) { // comments ?>
        <td <?= $Page->comments->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_print_orders_comments" class="print_orders_comments">
<span<?= $Page->comments->viewAttributes() ?>>
<?= $Page->comments->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bus_codes->Visible) { // bus_codes ?>
        <td <?= $Page->bus_codes->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_print_orders_bus_codes" class="print_orders_bus_codes">
<span<?= $Page->bus_codes->viewAttributes() ?>>
<?= $Page->bus_codes->getViewValue() ?></span>
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

<?php

namespace PHPMaker2021\test;

// Page object
$MainCampaignsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmain_campaignsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fmain_campaignsdelete = currentForm = new ew.Form("fmain_campaignsdelete", "delete");
    loadjs.done("fmain_campaignsdelete");
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
<form name="fmain_campaignsdelete" id="fmain_campaignsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_campaigns">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_main_campaigns_id" class="main_campaigns_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_main_campaigns_name" class="main_campaigns_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <th class="<?= $Page->inventory_id->headerCellClass() ?>"><span id="elh_main_campaigns_inventory_id" class="main_campaigns_inventory_id"><?= $Page->inventory_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <th class="<?= $Page->platform_id->headerCellClass() ?>"><span id="elh_main_campaigns_platform_id" class="main_campaigns_platform_id"><?= $Page->platform_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <th class="<?= $Page->bus_size_id->headerCellClass() ?>"><span id="elh_main_campaigns_bus_size_id" class="main_campaigns_bus_size_id"><?= $Page->bus_size_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th class="<?= $Page->quantity->headerCellClass() ?>"><span id="elh_main_campaigns_quantity" class="main_campaigns_quantity"><?= $Page->quantity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <th class="<?= $Page->start_date->headerCellClass() ?>"><span id="elh_main_campaigns_start_date" class="main_campaigns_start_date"><?= $Page->start_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <th class="<?= $Page->end_date->headerCellClass() ?>"><span id="elh_main_campaigns_end_date" class="main_campaigns_end_date"><?= $Page->end_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <th class="<?= $Page->vendor_id->headerCellClass() ?>"><span id="elh_main_campaigns_vendor_id" class="main_campaigns_vendor_id"><?= $Page->vendor_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <th class="<?= $Page->renewal_stage_id->headerCellClass() ?>"><span id="elh_main_campaigns_renewal_stage_id" class="main_campaigns_renewal_stage_id"><?= $Page->renewal_stage_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->check_status->Visible) { // check_status ?>
        <th class="<?= $Page->check_status->headerCellClass() ?>"><span id="elh_main_campaigns_check_status" class="main_campaigns_check_status"><?= $Page->check_status->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_main_campaigns_id" class="main_campaigns_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_name" class="main_campaigns_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <td <?= $Page->inventory_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_inventory_id" class="main_campaigns_inventory_id">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<?= $Page->inventory_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td <?= $Page->platform_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_platform_id" class="main_campaigns_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <td <?= $Page->bus_size_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_bus_size_id" class="main_campaigns_bus_size_id">
<span<?= $Page->bus_size_id->viewAttributes() ?>>
<?= $Page->bus_size_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <td <?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_quantity" class="main_campaigns_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <td <?= $Page->start_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_start_date" class="main_campaigns_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <td <?= $Page->end_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_end_date" class="main_campaigns_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td <?= $Page->vendor_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_vendor_id" class="main_campaigns_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <td <?= $Page->renewal_stage_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_renewal_stage_id" class="main_campaigns_renewal_stage_id">
<span<?= $Page->renewal_stage_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->renewal_stage_id->getViewValue()) && $Page->renewal_stage_id->linkAttributes() != "") { ?>
<a<?= $Page->renewal_stage_id->linkAttributes() ?>><?= $Page->renewal_stage_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->renewal_stage_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->check_status->Visible) { // check_status ?>
        <td <?= $Page->check_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_check_status" class="main_campaigns_check_status">
<span<?= $Page->check_status->viewAttributes() ?>>
<?php if (!EmptyString($Page->check_status->getViewValue()) && $Page->check_status->linkAttributes() != "") { ?>
<a<?= $Page->check_status->linkAttributes() ?>><?= $Page->check_status->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->check_status->getViewValue() ?>
<?php } ?>
</span>
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

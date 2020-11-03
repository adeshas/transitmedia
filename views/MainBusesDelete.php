<?php

namespace PHPMaker2021\test;

// Page object
$MainBusesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmain_busesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fmain_busesdelete = currentForm = new ew.Form("fmain_busesdelete", "delete");
    loadjs.done("fmain_busesdelete");
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
<form name="fmain_busesdelete" id="fmain_busesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_buses">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_main_buses_id" class="main_buses_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->number->Visible) { // number ?>
        <th class="<?= $Page->number->headerCellClass() ?>"><span id="elh_main_buses_number" class="main_buses_number"><?= $Page->number->caption() ?></span></th>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <th class="<?= $Page->platform_id->headerCellClass() ?>"><span id="elh_main_buses_platform_id" class="main_buses_platform_id"><?= $Page->platform_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <th class="<?= $Page->operator_id->headerCellClass() ?>"><span id="elh_main_buses_operator_id" class="main_buses_operator_id"><?= $Page->operator_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <th class="<?= $Page->exterior_campaign_id->headerCellClass() ?>"><span id="elh_main_buses_exterior_campaign_id" class="main_buses_exterior_campaign_id"><?= $Page->exterior_campaign_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <th class="<?= $Page->interior_campaign_id->headerCellClass() ?>"><span id="elh_main_buses_interior_campaign_id" class="main_buses_interior_campaign_id"><?= $Page->interior_campaign_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
        <th class="<?= $Page->bus_status_id->headerCellClass() ?>"><span id="elh_main_buses_bus_status_id" class="main_buses_bus_status_id"><?= $Page->bus_status_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bus_depot_id->Visible) { // bus_depot_id ?>
        <th class="<?= $Page->bus_depot_id->headerCellClass() ?>"><span id="elh_main_buses_bus_depot_id" class="main_buses_bus_depot_id"><?= $Page->bus_depot_id->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_main_buses_id" class="main_buses_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->number->Visible) { // number ?>
        <td <?= $Page->number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_buses_number" class="main_buses_number">
<span<?= $Page->number->viewAttributes() ?>>
<?= $Page->number->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td <?= $Page->platform_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_buses_platform_id" class="main_buses_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td <?= $Page->operator_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_buses_operator_id" class="main_buses_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <td <?= $Page->exterior_campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_buses_exterior_campaign_id" class="main_buses_exterior_campaign_id">
<span<?= $Page->exterior_campaign_id->viewAttributes() ?>>
<?= $Page->exterior_campaign_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <td <?= $Page->interior_campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_buses_interior_campaign_id" class="main_buses_interior_campaign_id">
<span<?= $Page->interior_campaign_id->viewAttributes() ?>>
<?= $Page->interior_campaign_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
        <td <?= $Page->bus_status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_buses_bus_status_id" class="main_buses_bus_status_id">
<span<?= $Page->bus_status_id->viewAttributes() ?>>
<?= $Page->bus_status_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bus_depot_id->Visible) { // bus_depot_id ?>
        <td <?= $Page->bus_depot_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_buses_bus_depot_id" class="main_buses_bus_depot_id">
<span<?= $Page->bus_depot_id->viewAttributes() ?>>
<?= $Page->bus_depot_id->getViewValue() ?></span>
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

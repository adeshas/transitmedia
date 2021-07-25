<?php

namespace PHPMaker2021\test;

// Page object
$MainBusesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmain_busesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fmain_busesview = currentForm = new ew.Form("fmain_busesview", "view");
    loadjs.done("fmain_busesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.main_buses) ew.vars.tables.main_buses = <?= JsonEncode(GetClientVar("tables", "main_buses")) ?>;
</script>
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
<form name="fmain_busesview" id="fmain_busesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_buses">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_main_buses_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->number->Visible) { // number ?>
    <tr id="r_number">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_number"><?= $Page->number->caption() ?></span></td>
        <td data-name="number" <?= $Page->number->cellAttributes() ?>>
<span id="el_main_buses_number">
<span<?= $Page->number->viewAttributes() ?>>
<?= $Page->number->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
    <tr id="r_platform_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_platform_id"><?= $Page->platform_id->caption() ?></span></td>
        <td data-name="platform_id" <?= $Page->platform_id->cellAttributes() ?>>
<span id="el_main_buses_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
    <tr id="r_operator_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_operator_id"><?= $Page->operator_id->caption() ?></span></td>
        <td data-name="operator_id" <?= $Page->operator_id->cellAttributes() ?>>
<span id="el_main_buses_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
    <tr id="r_exterior_campaign_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_exterior_campaign_id"><?= $Page->exterior_campaign_id->caption() ?></span></td>
        <td data-name="exterior_campaign_id" <?= $Page->exterior_campaign_id->cellAttributes() ?>>
<span id="el_main_buses_exterior_campaign_id">
<span<?= $Page->exterior_campaign_id->viewAttributes() ?>>
<?= $Page->exterior_campaign_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
    <tr id="r_interior_campaign_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_interior_campaign_id"><?= $Page->interior_campaign_id->caption() ?></span></td>
        <td data-name="interior_campaign_id" <?= $Page->interior_campaign_id->cellAttributes() ?>>
<span id="el_main_buses_interior_campaign_id">
<span<?= $Page->interior_campaign_id->viewAttributes() ?>>
<?= $Page->interior_campaign_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
    <tr id="r_bus_status_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_bus_status_id"><?= $Page->bus_status_id->caption() ?></span></td>
        <td data-name="bus_status_id" <?= $Page->bus_status_id->cellAttributes() ?>>
<span id="el_main_buses_bus_status_id">
<span<?= $Page->bus_status_id->viewAttributes() ?>>
<?= $Page->bus_status_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
    <tr id="r_bus_size_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_bus_size_id"><?= $Page->bus_size_id->caption() ?></span></td>
        <td data-name="bus_size_id" <?= $Page->bus_size_id->cellAttributes() ?>>
<span id="el_main_buses_bus_size_id">
<span<?= $Page->bus_size_id->viewAttributes() ?>>
<?= $Page->bus_size_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bus_depot_id->Visible) { // bus_depot_id ?>
    <tr id="r_bus_depot_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_bus_depot_id"><?= $Page->bus_depot_id->caption() ?></span></td>
        <td data-name="bus_depot_id" <?= $Page->bus_depot_id->cellAttributes() ?>>
<span id="el_main_buses_bus_depot_id">
<span<?= $Page->bus_depot_id->viewAttributes() ?>>
<?= $Page->bus_depot_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <tr id="r_ts_created">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_ts_created"><?= $Page->ts_created->caption() ?></span></td>
        <td data-name="ts_created" <?= $Page->ts_created->cellAttributes() ?>>
<span id="el_main_buses_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
    <tr id="r_ts_last_update">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_buses_ts_last_update"><?= $Page->ts_last_update->caption() ?></span></td>
        <td data-name="ts_last_update" <?= $Page->ts_last_update->cellAttributes() ?>>
<span id="el_main_buses_ts_last_update">
<span<?= $Page->ts_last_update->viewAttributes() ?>>
<?= $Page->ts_last_update->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sub_media_allocation", explode(",", $Page->getCurrentDetailTable())) && $sub_media_allocation->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sub_media_allocation", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubMediaAllocationGrid.php" ?>
<?php } ?>
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

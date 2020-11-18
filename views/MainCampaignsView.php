<?php

namespace PHPMaker2021\test;

// Page object
$MainCampaignsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmain_campaignsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fmain_campaignsview = currentForm = new ew.Form("fmain_campaignsview", "view");
    loadjs.done("fmain_campaignsview");
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
<form name="fmain_campaignsview" id="fmain_campaignsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_campaigns">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_main_campaigns_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_main_campaigns_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
    <tr id="r_inventory_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_inventory_id"><?= $Page->inventory_id->caption() ?></span></td>
        <td data-name="inventory_id" <?= $Page->inventory_id->cellAttributes() ?>>
<span id="el_main_campaigns_inventory_id">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<?= $Page->inventory_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
    <tr id="r_platform_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_platform_id"><?= $Page->platform_id->caption() ?></span></td>
        <td data-name="platform_id" <?= $Page->platform_id->cellAttributes() ?>>
<span id="el_main_campaigns_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
    <tr id="r_bus_size_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_bus_size_id"><?= $Page->bus_size_id->caption() ?></span></td>
        <td data-name="bus_size_id" <?= $Page->bus_size_id->cellAttributes() ?>>
<span id="el_main_campaigns_bus_size_id">
<span<?= $Page->bus_size_id->viewAttributes() ?>>
<?= $Page->bus_size_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
    <tr id="r_price_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_price_id"><?= $Page->price_id->caption() ?></span></td>
        <td data-name="price_id" <?= $Page->price_id->cellAttributes() ?>>
<span id="el_main_campaigns_price_id">
<span<?= $Page->price_id->viewAttributes() ?>>
<?= $Page->price_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <tr id="r_quantity">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_quantity"><?= $Page->quantity->caption() ?></span></td>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el_main_campaigns_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
    <tr id="r_start_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_start_date"><?= $Page->start_date->caption() ?></span></td>
        <td data-name="start_date" <?= $Page->start_date->cellAttributes() ?>>
<span id="el_main_campaigns_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
    <tr id="r_end_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_end_date"><?= $Page->end_date->caption() ?></span></td>
        <td data-name="end_date" <?= $Page->end_date->cellAttributes() ?>>
<span id="el_main_campaigns_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <tr id="r_user_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_user_id"><?= $Page->user_id->caption() ?></span></td>
        <td data-name="user_id" <?= $Page->user_id->cellAttributes() ?>>
<span id="el_main_campaigns_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
    <tr id="r_vendor_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_vendor_id"><?= $Page->vendor_id->caption() ?></span></td>
        <td data-name="vendor_id" <?= $Page->vendor_id->cellAttributes() ?>>
<span id="el_main_campaigns_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
    <tr id="r_ts_last_update">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_ts_last_update"><?= $Page->ts_last_update->caption() ?></span></td>
        <td data-name="ts_last_update" <?= $Page->ts_last_update->cellAttributes() ?>>
<span id="el_main_campaigns_ts_last_update">
<span<?= $Page->ts_last_update->viewAttributes() ?>>
<?= $Page->ts_last_update->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <tr id="r_ts_created">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_ts_created"><?= $Page->ts_created->caption() ?></span></td>
        <td data-name="ts_created" <?= $Page->ts_created->cellAttributes() ?>>
<span id="el_main_campaigns_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->renewal_stage_id->Visible) { // renewal_stage_id ?>
    <tr id="r_renewal_stage_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_campaigns_renewal_stage_id"><?= $Page->renewal_stage_id->caption() ?></span></td>
        <td data-name="renewal_stage_id" <?= $Page->renewal_stage_id->cellAttributes() ?>>
<span id="el_main_campaigns_renewal_stage_id">
<span<?= $Page->renewal_stage_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->renewal_stage_id->getViewValue()) && $Page->renewal_stage_id->linkAttributes() != "") { ?>
<a<?= $Page->renewal_stage_id->linkAttributes() ?>><?= $Page->renewal_stage_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->renewal_stage_id->getViewValue() ?>
<?php } ?>
</span>
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
<?php
    if (in_array("main_transactions", explode(",", $Page->getCurrentDetailTable())) && $main_transactions->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("main_transactions", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MainTransactionsGrid.php" ?>
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

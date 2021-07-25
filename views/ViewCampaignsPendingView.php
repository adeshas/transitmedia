<?php

namespace PHPMaker2021\test;

// Page object
$ViewCampaignsPendingView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fview_campaigns_pendingview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fview_campaigns_pendingview = currentForm = new ew.Form("fview_campaigns_pendingview", "view");
    loadjs.done("fview_campaigns_pendingview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.view_campaigns_pending) ew.vars.tables.view_campaigns_pending = <?= JsonEncode(GetClientVar("tables", "view_campaigns_pending")) ?>;
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
<form name="fview_campaigns_pendingview" id="fview_campaigns_pendingview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_campaigns_pending">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
    <tr id="r_transaction_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_transaction_id"><?= $Page->transaction_id->caption() ?></span></td>
        <td data-name="transaction_id" <?= $Page->transaction_id->cellAttributes() ?>>
<span id="el_view_campaigns_pending_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<?= $Page->transaction_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->campaign->Visible) { // campaign ?>
    <tr id="r_campaign">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_campaign"><?= $Page->campaign->caption() ?></span></td>
        <td data-name="campaign" <?= $Page->campaign->cellAttributes() ?>>
<span id="el_view_campaigns_pending_campaign">
<span<?= $Page->campaign->viewAttributes() ?>>
<?= $Page->campaign->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->transaction_status->Visible) { // transaction_status ?>
    <tr id="r_transaction_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_transaction_status"><?= $Page->transaction_status->caption() ?></span></td>
        <td data-name="transaction_status" <?= $Page->transaction_status->cellAttributes() ?>>
<span id="el_view_campaigns_pending_transaction_status">
<span<?= $Page->transaction_status->viewAttributes() ?>>
<?= $Page->transaction_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->payment_status->Visible) { // payment_status ?>
    <tr id="r_payment_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_payment_status"><?= $Page->payment_status->caption() ?></span></td>
        <td data-name="payment_status" <?= $Page->payment_status->cellAttributes() ?>>
<span id="el_view_campaigns_pending_payment_status">
<span<?= $Page->payment_status->viewAttributes() ?>>
<?= $Page->payment_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
    <tr id="r_payment_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_payment_date"><?= $Page->payment_date->caption() ?></span></td>
        <td data-name="payment_date" <?= $Page->payment_date->cellAttributes() ?>>
<span id="el_view_campaigns_pending_payment_date">
<span<?= $Page->payment_date->viewAttributes() ?>>
<?= $Page->payment_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->inventory->Visible) { // inventory ?>
    <tr id="r_inventory">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_inventory"><?= $Page->inventory->caption() ?></span></td>
        <td data-name="inventory" <?= $Page->inventory->cellAttributes() ?>>
<span id="el_view_campaigns_pending_inventory">
<span<?= $Page->inventory->viewAttributes() ?>>
<?php if (!EmptyString($Page->inventory->TooltipValue) && $Page->inventory->linkAttributes() != "") { ?>
<a<?= $Page->inventory->linkAttributes() ?>><?= $Page->inventory->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->inventory->getViewValue() ?>
<?php } ?>
<span id="tt_view_campaigns_pending_x_inventory" class="d-none">
<?= $Page->inventory->TooltipValue ?>
</span></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bus_size->Visible) { // bus_size ?>
    <tr id="r_bus_size">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_bus_size"><?= $Page->bus_size->caption() ?></span></td>
        <td data-name="bus_size" <?= $Page->bus_size->cellAttributes() ?>>
<span id="el_view_campaigns_pending_bus_size">
<span<?= $Page->bus_size->viewAttributes() ?>>
<?= $Page->bus_size->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vendor->Visible) { // vendor ?>
    <tr id="r_vendor">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_vendor"><?= $Page->vendor->caption() ?></span></td>
        <td data-name="vendor" <?= $Page->vendor->cellAttributes() ?>>
<span id="el_view_campaigns_pending_vendor">
<span<?= $Page->vendor->viewAttributes() ?>>
<?= $Page->vendor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->operator->Visible) { // operator ?>
    <tr id="r_operator">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_operator"><?= $Page->operator->caption() ?></span></td>
        <td data-name="operator" <?= $Page->operator->cellAttributes() ?>>
<span id="el_view_campaigns_pending_operator">
<span<?= $Page->operator->viewAttributes() ?>>
<?= $Page->operator->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->print_stage->Visible) { // print_stage ?>
    <tr id="r_print_stage">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_print_stage"><?= $Page->print_stage->caption() ?></span></td>
        <td data-name="print_stage" <?= $Page->print_stage->cellAttributes() ?>>
<span id="el_view_campaigns_pending_print_stage">
<span<?= $Page->print_stage->viewAttributes() ?>>
<?= $Page->print_stage->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->platform->Visible) { // platform ?>
    <tr id="r_platform">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_platform"><?= $Page->platform->caption() ?></span></td>
        <td data-name="platform" <?= $Page->platform->cellAttributes() ?>>
<span id="el_view_campaigns_pending_platform">
<span<?= $Page->platform->viewAttributes() ?>>
<?= $Page->platform->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <tr id="r_quantity">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_quantity"><?= $Page->quantity->caption() ?></span></td>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el_view_campaigns_pending_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->operator_fee->Visible) { // operator_fee ?>
    <tr id="r_operator_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_operator_fee"><?= $Page->operator_fee->caption() ?></span></td>
        <td data-name="operator_fee" <?= $Page->operator_fee->cellAttributes() ?>>
<span id="el_view_campaigns_pending_operator_fee">
<span<?= $Page->operator_fee->viewAttributes() ?>>
<?= $Page->operator_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
    <tr id="r_price">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_price"><?= $Page->price->caption() ?></span></td>
        <td data-name="price" <?= $Page->price->cellAttributes() ?>>
<span id="el_view_campaigns_pending_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
    <tr id="r_lamata_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_lamata_fee"><?= $Page->lamata_fee->caption() ?></span></td>
        <td data-name="lamata_fee" <?= $Page->lamata_fee->cellAttributes() ?>>
<span id="el_view_campaigns_pending_lamata_fee">
<span<?= $Page->lamata_fee->viewAttributes() ?>>
<?= $Page->lamata_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->agency_fee->Visible) { // agency_fee ?>
    <tr id="r_agency_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_agency_fee"><?= $Page->agency_fee->caption() ?></span></td>
        <td data-name="agency_fee" <?= $Page->agency_fee->cellAttributes() ?>>
<span id="el_view_campaigns_pending_agency_fee">
<span<?= $Page->agency_fee->viewAttributes() ?>>
<?= $Page->agency_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
    <tr id="r_lasaa_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_lasaa_fee"><?= $Page->lasaa_fee->caption() ?></span></td>
        <td data-name="lasaa_fee" <?= $Page->lasaa_fee->cellAttributes() ?>>
<span id="el_view_campaigns_pending_lasaa_fee">
<span<?= $Page->lasaa_fee->viewAttributes() ?>>
<?= $Page->lasaa_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->printers_fee->Visible) { // printers_fee ?>
    <tr id="r_printers_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_printers_fee"><?= $Page->printers_fee->caption() ?></span></td>
        <td data-name="printers_fee" <?= $Page->printers_fee->cellAttributes() ?>>
<span id="el_view_campaigns_pending_printers_fee">
<span<?= $Page->printers_fee->viewAttributes() ?>>
<?= $Page->printers_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
    <tr id="r_payment_status_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_payment_status_id"><?= $Page->payment_status_id->caption() ?></span></td>
        <td data-name="payment_status_id" <?= $Page->payment_status_id->cellAttributes() ?>>
<span id="el_view_campaigns_pending_payment_status_id">
<span<?= $Page->payment_status_id->viewAttributes() ?>>
<?= $Page->payment_status_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <tr id="r_total">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_total"><?= $Page->total->caption() ?></span></td>
        <td data-name="total" <?= $Page->total->cellAttributes() ?>>
<span id="el_view_campaigns_pending_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
    <tr id="r_start_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_start_date"><?= $Page->start_date->caption() ?></span></td>
        <td data-name="start_date" <?= $Page->start_date->cellAttributes() ?>>
<span id="el_view_campaigns_pending_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
    <tr id="r_end_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_campaigns_pending_end_date"><?= $Page->end_date->caption() ?></span></td>
        <td data-name="end_date" <?= $Page->end_date->cellAttributes() ?>>
<span id="el_view_campaigns_pending_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("view_buses_assigned", explode(",", $Page->getCurrentDetailTable())) && $view_buses_assigned->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("view_buses_assigned", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ViewBusesAssignedGrid.php" ?>
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

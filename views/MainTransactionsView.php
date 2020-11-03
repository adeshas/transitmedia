<?php

namespace PHPMaker2021\test;

// Page object
$MainTransactionsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmain_transactionsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fmain_transactionsview = currentForm = new ew.Form("fmain_transactionsview", "view");
    loadjs.done("fmain_transactionsview");
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
<form name="fmain_transactionsview" id="fmain_transactionsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_transactions">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_main_transactions_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <tr id="r_campaign_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_campaign_id"><?= $Page->campaign_id->caption() ?></span></td>
        <td data-name="campaign_id" <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el_main_transactions_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
    <tr id="r_operator_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_operator_id"><?= $Page->operator_id->caption() ?></span></td>
        <td data-name="operator_id" <?= $Page->operator_id->cellAttributes() ?>>
<span id="el_main_transactions_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
    <tr id="r_payment_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_payment_date"><?= $Page->payment_date->caption() ?></span></td>
        <td data-name="payment_date" <?= $Page->payment_date->cellAttributes() ?>>
<span id="el_main_transactions_payment_date">
<span<?= $Page->payment_date->viewAttributes() ?>>
<?= $Page->payment_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
    <tr id="r_price_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_price_id"><?= $Page->price_id->caption() ?></span></td>
        <td data-name="price_id" <?= $Page->price_id->cellAttributes() ?>>
<span id="el_main_transactions_price_id">
<span<?= $Page->price_id->viewAttributes() ?>>
<?= $Page->price_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <tr id="r_quantity">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_quantity"><?= $Page->quantity->caption() ?></span></td>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el_main_transactions_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
    <tr id="r_start_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_start_date"><?= $Page->start_date->caption() ?></span></td>
        <td data-name="start_date" <?= $Page->start_date->cellAttributes() ?>>
<span id="el_main_transactions_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
    <tr id="r_end_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_end_date"><?= $Page->end_date->caption() ?></span></td>
        <td data-name="end_date" <?= $Page->end_date->cellAttributes() ?>>
<span id="el_main_transactions_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
    <tr id="r_status_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_status_id"><?= $Page->status_id->caption() ?></span></td>
        <td data-name="status_id" <?= $Page->status_id->cellAttributes() ?>>
<span id="el_main_transactions_status_id">
<span<?= $Page->status_id->viewAttributes() ?>>
<?= $Page->status_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->print_status_id->Visible) { // print_status_id ?>
    <tr id="r_print_status_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_print_status_id"><?= $Page->print_status_id->caption() ?></span></td>
        <td data-name="print_status_id" <?= $Page->print_status_id->cellAttributes() ?>>
<span id="el_main_transactions_print_status_id">
<span<?= $Page->print_status_id->viewAttributes() ?>>
<?= $Page->print_status_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
    <tr id="r_payment_status_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_payment_status_id"><?= $Page->payment_status_id->caption() ?></span></td>
        <td data-name="payment_status_id" <?= $Page->payment_status_id->cellAttributes() ?>>
<span id="el_main_transactions_payment_status_id">
<span<?= $Page->payment_status_id->viewAttributes() ?>>
<?= $Page->payment_status_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <tr id="r_created_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_created_by"><?= $Page->created_by->caption() ?></span></td>
        <td data-name="created_by" <?= $Page->created_by->cellAttributes() ?>>
<span id="el_main_transactions_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <tr id="r_ts_created">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_ts_created"><?= $Page->ts_created->caption() ?></span></td>
        <td data-name="ts_created" <?= $Page->ts_created->cellAttributes() ?>>
<span id="el_main_transactions_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
    <tr id="r_ts_last_update">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_ts_last_update"><?= $Page->ts_last_update->caption() ?></span></td>
        <td data-name="ts_last_update" <?= $Page->ts_last_update->cellAttributes() ?>>
<span id="el_main_transactions_ts_last_update">
<span<?= $Page->ts_last_update->viewAttributes() ?>>
<?= $Page->ts_last_update->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <tr id="r_total">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_transactions_total"><?= $Page->total->caption() ?></span></td>
        <td data-name="total" <?= $Page->total->cellAttributes() ?>>
<span id="el_main_transactions_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sub_transaction_details", explode(",", $Page->getCurrentDetailTable())) && $sub_transaction_details->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sub_transaction_details", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubTransactionDetailsGrid.php" ?>
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

<?php

namespace PHPMaker2021\test;

// Page object
$PrintOrdersView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fprint_ordersview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fprint_ordersview = currentForm = new ew.Form("fprint_ordersview", "view");
    loadjs.done("fprint_ordersview");
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
<form name="fprint_ordersview" id="fprint_ordersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="print_orders">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_print_orders_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <tr id="r_campaign_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_campaign_id"><?= $Page->campaign_id->caption() ?></span></td>
        <td data-name="campaign_id" <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el_print_orders_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->printer_id->Visible) { // printer_id ?>
    <tr id="r_printer_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_printer_id"><?= $Page->printer_id->caption() ?></span></td>
        <td data-name="printer_id" <?= $Page->printer_id->cellAttributes() ?>>
<span id="el_print_orders_printer_id">
<span<?= $Page->printer_id->viewAttributes() ?>>
<?= $Page->printer_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <tr id="r_ts_created">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_ts_created"><?= $Page->ts_created->caption() ?></span></td>
        <td data-name="ts_created" <?= $Page->ts_created->cellAttributes() ?>>
<span id="el_print_orders_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
    <tr id="r_link">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_link"><?= $Page->link->caption() ?></span></td>
        <td data-name="link" <?= $Page->link->cellAttributes() ?>>
<span id="el_print_orders_link">
<span<?= $Page->link->viewAttributes() ?>>
<?php if (!EmptyString($Page->link->getViewValue()) && $Page->link->linkAttributes() != "") { ?>
<a<?= $Page->link->linkAttributes() ?>><?= $Page->link->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->link->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <tr id="r_quantity">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_quantity"><?= $Page->quantity->caption() ?></span></td>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el_print_orders_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
    <tr id="r_approved">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_approved"><?= $Page->approved->caption() ?></span></td>
        <td data-name="approved" <?= $Page->approved->cellAttributes() ?>>
<span id="el_print_orders_approved">
<span<?= $Page->approved->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_approved_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->approved->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->approved->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_approved_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comments->Visible) { // comments ?>
    <tr id="r_comments">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_comments"><?= $Page->comments->caption() ?></span></td>
        <td data-name="comments" <?= $Page->comments->cellAttributes() ?>>
<span id="el_print_orders_comments">
<span<?= $Page->comments->viewAttributes() ?>>
<?= $Page->comments->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->all_codes_assigned_in_campaign->Visible) { // all_codes_assigned_in_campaign ?>
    <tr id="r_all_codes_assigned_in_campaign">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_all_codes_assigned_in_campaign"><?= $Page->all_codes_assigned_in_campaign->caption() ?></span></td>
        <td data-name="all_codes_assigned_in_campaign" <?= $Page->all_codes_assigned_in_campaign->cellAttributes() ?>>
<span id="el_print_orders_all_codes_assigned_in_campaign">
<span<?= $Page->all_codes_assigned_in_campaign->viewAttributes() ?>>
<?= $Page->all_codes_assigned_in_campaign->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bus_codes->Visible) { // bus_codes ?>
    <tr id="r_bus_codes">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_bus_codes"><?= $Page->bus_codes->caption() ?></span></td>
        <td data-name="bus_codes" <?= $Page->bus_codes->cellAttributes() ?>>
<span id="el_print_orders_bus_codes">
<span<?= $Page->bus_codes->viewAttributes() ?>>
<?= $Page->bus_codes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->available_codes_to_be_assigned->Visible) { // available_codes_to_be_assigned ?>
    <tr id="r_available_codes_to_be_assigned">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_print_orders_available_codes_to_be_assigned"><?= $Page->available_codes_to_be_assigned->caption() ?></span></td>
        <td data-name="available_codes_to_be_assigned" <?= $Page->available_codes_to_be_assigned->cellAttributes() ?>>
<span id="el_print_orders_available_codes_to_be_assigned">
<span<?= $Page->available_codes_to_be_assigned->viewAttributes() ?>>
<?= $Page->available_codes_to_be_assigned->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
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

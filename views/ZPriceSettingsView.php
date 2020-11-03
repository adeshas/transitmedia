<?php

namespace PHPMaker2021\test;

// Page object
$ZPriceSettingsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fz_price_settingsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fz_price_settingsview = currentForm = new ew.Form("fz_price_settingsview", "view");
    loadjs.done("fz_price_settingsview");
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
<form name="fz_price_settingsview" id="fz_price_settingsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="z_price_settings">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_z_price_settings_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
    <tr id="r_platform_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_platform_id"><?= $Page->platform_id->caption() ?></span></td>
        <td data-name="platform_id" <?= $Page->platform_id->cellAttributes() ?>>
<span id="el_z_price_settings_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
    <tr id="r_inventory_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_inventory_id"><?= $Page->inventory_id->caption() ?></span></td>
        <td data-name="inventory_id" <?= $Page->inventory_id->cellAttributes() ?>>
<span id="el_z_price_settings_inventory_id">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<?= $Page->inventory_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->print_stage_id->Visible) { // print_stage_id ?>
    <tr id="r_print_stage_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_print_stage_id"><?= $Page->print_stage_id->caption() ?></span></td>
        <td data-name="print_stage_id" <?= $Page->print_stage_id->cellAttributes() ?>>
<span id="el_z_price_settings_print_stage_id">
<span<?= $Page->print_stage_id->viewAttributes() ?>>
<?= $Page->print_stage_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
    <tr id="r_bus_size_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_bus_size_id"><?= $Page->bus_size_id->caption() ?></span></td>
        <td data-name="bus_size_id" <?= $Page->bus_size_id->cellAttributes() ?>>
<span id="el_z_price_settings_bus_size_id">
<span<?= $Page->bus_size_id->viewAttributes() ?>>
<?= $Page->bus_size_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->details->Visible) { // details ?>
    <tr id="r_details">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_details"><?= $Page->details->caption() ?></span></td>
        <td data-name="details" <?= $Page->details->cellAttributes() ?>>
<span id="el_z_price_settings_details">
<span<?= $Page->details->viewAttributes() ?>>
<?= $Page->details->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->max_limit->Visible) { // max_limit ?>
    <tr id="r_max_limit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_max_limit"><?= $Page->max_limit->caption() ?></span></td>
        <td data-name="max_limit" <?= $Page->max_limit->cellAttributes() ?>>
<span id="el_z_price_settings_max_limit">
<span<?= $Page->max_limit->viewAttributes() ?>>
<?= $Page->max_limit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->min_limit->Visible) { // min_limit ?>
    <tr id="r_min_limit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_min_limit"><?= $Page->min_limit->caption() ?></span></td>
        <td data-name="min_limit" <?= $Page->min_limit->cellAttributes() ?>>
<span id="el_z_price_settings_min_limit">
<span<?= $Page->min_limit->viewAttributes() ?>>
<?= $Page->min_limit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
    <tr id="r_price">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_price"><?= $Page->price->caption() ?></span></td>
        <td data-name="price" <?= $Page->price->cellAttributes() ?>>
<span id="el_z_price_settings_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->operator_fee->Visible) { // operator_fee ?>
    <tr id="r_operator_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_operator_fee"><?= $Page->operator_fee->caption() ?></span></td>
        <td data-name="operator_fee" <?= $Page->operator_fee->cellAttributes() ?>>
<span id="el_z_price_settings_operator_fee">
<span<?= $Page->operator_fee->viewAttributes() ?>>
<?= $Page->operator_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->agency_fee->Visible) { // agency_fee ?>
    <tr id="r_agency_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_agency_fee"><?= $Page->agency_fee->caption() ?></span></td>
        <td data-name="agency_fee" <?= $Page->agency_fee->cellAttributes() ?>>
<span id="el_z_price_settings_agency_fee">
<span<?= $Page->agency_fee->viewAttributes() ?>>
<?= $Page->agency_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
    <tr id="r_lamata_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_lamata_fee"><?= $Page->lamata_fee->caption() ?></span></td>
        <td data-name="lamata_fee" <?= $Page->lamata_fee->cellAttributes() ?>>
<span id="el_z_price_settings_lamata_fee">
<span<?= $Page->lamata_fee->viewAttributes() ?>>
<?= $Page->lamata_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
    <tr id="r_lasaa_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_lasaa_fee"><?= $Page->lasaa_fee->caption() ?></span></td>
        <td data-name="lasaa_fee" <?= $Page->lasaa_fee->cellAttributes() ?>>
<span id="el_z_price_settings_lasaa_fee">
<span<?= $Page->lasaa_fee->viewAttributes() ?>>
<?= $Page->lasaa_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->printers_fee->Visible) { // printers_fee ?>
    <tr id="r_printers_fee">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_price_settings_printers_fee"><?= $Page->printers_fee->caption() ?></span></td>
        <td data-name="printers_fee" <?= $Page->printers_fee->cellAttributes() ?>>
<span id="el_z_price_settings_printers_fee">
<span<?= $Page->printers_fee->viewAttributes() ?>>
<?= $Page->printers_fee->getViewValue() ?></span>
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

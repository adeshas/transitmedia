<?php

namespace PHPMaker2021\test;

// Page object
$ViewTransactionsPerPlatformSearch = &$Page;
?>
<script>
if (!ew.vars.tables.view_transactions_per_platform) ew.vars.tables.view_transactions_per_platform = <?= JsonEncode(GetClientVar("tables", "view_transactions_per_platform")) ?>;
var currentForm, currentPageID;
var fview_transactions_per_platformsearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fview_transactions_per_platformsearch = currentAdvancedSearchForm = new ew.Form("fview_transactions_per_platformsearch", "search");
    <?php } else { ?>
    fview_transactions_per_platformsearch = currentForm = new ew.Form("fview_transactions_per_platformsearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var fields = ew.vars.tables.view_transactions_per_platform.fields;
    fview_transactions_per_platformsearch.addFields([
        ["transaction_id", [ew.Validators.integer], fields.transaction_id.isInvalid],
        ["campaign", [], fields.campaign.isInvalid],
        ["payment_date", [ew.Validators.datetime(0)], fields.payment_date.isInvalid],
        ["inventory", [], fields.inventory.isInvalid],
        ["bus_size", [], fields.bus_size.isInvalid],
        ["print_stage", [], fields.print_stage.isInvalid],
        ["vendor", [], fields.vendor.isInvalid],
        ["operator", [], fields.operator.isInvalid],
        ["transaction_status", [], fields.transaction_status.isInvalid],
        ["start_date", [ew.Validators.datetime(0)], fields.start_date.isInvalid],
        ["end_date", [ew.Validators.datetime(0)], fields.end_date.isInvalid],
        ["platform", [], fields.platform.isInvalid],
        ["status_id", [ew.Validators.integer], fields.status_id.isInvalid],
        ["vendor_id", [ew.Validators.integer], fields.vendor_id.isInvalid],
        ["inventory_id", [ew.Validators.integer], fields.inventory_id.isInvalid],
        ["platform_id", [ew.Validators.integer], fields.platform_id.isInvalid],
        ["operator_id", [ew.Validators.integer], fields.operator_id.isInvalid],
        ["bus_size_id", [ew.Validators.integer], fields.bus_size_id.isInvalid],
        ["vendor_search_id", [ew.Validators.integer], fields.vendor_search_id.isInvalid],
        ["vendor_search_name", [], fields.vendor_search_name.isInvalid],
        ["price", [ew.Validators.integer], fields.price.isInvalid],
        ["quantity", [ew.Validators.integer], fields.quantity.isInvalid],
        ["amount_paid", [ew.Validators.integer], fields.amount_paid.isInvalid],
        ["transitmedia_fee", [ew.Validators.integer], fields.transitmedia_fee.isInvalid],
        ["lasaa_fee", [ew.Validators.integer], fields.lasaa_fee.isInvalid],
        ["operator_fee", [ew.Validators.integer], fields.operator_fee.isInvalid],
        ["lamata_fee", [ew.Validators.integer], fields.lamata_fee.isInvalid],
        ["total", [ew.Validators.integer], fields.total.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fview_transactions_per_platformsearch.setInvalid();
    });

    // Validate form
    fview_transactions_per_platformsearch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fview_transactions_per_platformsearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fview_transactions_per_platformsearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fview_transactions_per_platformsearch");
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
<form name="fview_transactions_per_platformsearch" id="fview_transactions_per_platformsearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_transactions_per_platform">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
    <div id="r_transaction_id" class="form-group row">
        <label for="x_transaction_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_transaction_id"><?= $Page->transaction_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_transaction_id" id="z_transaction_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->transaction_id->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_transaction_id" class="ew-search-field">
<input type="<?= $Page->transaction_id->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_transaction_id" name="x_transaction_id" id="x_transaction_id" size="30" placeholder="<?= HtmlEncode($Page->transaction_id->getPlaceHolder()) ?>" value="<?= $Page->transaction_id->EditValue ?>"<?= $Page->transaction_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->transaction_id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->campaign->Visible) { // campaign ?>
    <div id="r_campaign" class="form-group row">
        <label for="x_campaign" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_campaign"><?= $Page->campaign->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_campaign" id="z_campaign" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_campaign" class="ew-search-field">
<input type="<?= $Page->campaign->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_campaign" name="x_campaign" id="x_campaign" size="35" placeholder="<?= HtmlEncode($Page->campaign->getPlaceHolder()) ?>" value="<?= $Page->campaign->EditValue ?>"<?= $Page->campaign->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->campaign->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
    <div id="r_payment_date" class="form-group row">
        <label for="x_payment_date" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_payment_date"><?= $Page->payment_date->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_payment_date" id="z_payment_date" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->payment_date->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_payment_date" class="ew-search-field">
<input type="<?= $Page->payment_date->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_payment_date" name="x_payment_date" id="x_payment_date" placeholder="<?= HtmlEncode($Page->payment_date->getPlaceHolder()) ?>" value="<?= $Page->payment_date->EditValue ?>"<?= $Page->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->payment_date->getErrorMessage(false) ?></div>
<?php if (!$Page->payment_date->ReadOnly && !$Page->payment_date->Disabled && !isset($Page->payment_date->EditAttrs["readonly"]) && !isset($Page->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_transactions_per_platformsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fview_transactions_per_platformsearch", "x_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->inventory->Visible) { // inventory ?>
    <div id="r_inventory" class="form-group row">
        <label for="x_inventory" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_inventory"><?= $Page->inventory->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_inventory" id="z_inventory" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->inventory->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_inventory" class="ew-search-field">
<input type="<?= $Page->inventory->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_inventory" name="x_inventory" id="x_inventory" size="35" placeholder="<?= HtmlEncode($Page->inventory->getPlaceHolder()) ?>" value="<?= $Page->inventory->EditValue ?>"<?= $Page->inventory->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->inventory->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->bus_size->Visible) { // bus_size ?>
    <div id="r_bus_size" class="form-group row">
        <label for="x_bus_size" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_bus_size"><?= $Page->bus_size->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_bus_size" id="z_bus_size" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bus_size->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_bus_size" class="ew-search-field">
<input type="<?= $Page->bus_size->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_bus_size" name="x_bus_size" id="x_bus_size" size="35" placeholder="<?= HtmlEncode($Page->bus_size->getPlaceHolder()) ?>" value="<?= $Page->bus_size->EditValue ?>"<?= $Page->bus_size->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bus_size->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->print_stage->Visible) { // print_stage ?>
    <div id="r_print_stage" class="form-group row">
        <label for="x_print_stage" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_print_stage"><?= $Page->print_stage->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_print_stage" id="z_print_stage" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->print_stage->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_print_stage" class="ew-search-field">
<input type="<?= $Page->print_stage->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_print_stage" name="x_print_stage" id="x_print_stage" size="35" placeholder="<?= HtmlEncode($Page->print_stage->getPlaceHolder()) ?>" value="<?= $Page->print_stage->EditValue ?>"<?= $Page->print_stage->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->print_stage->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->vendor->Visible) { // vendor ?>
    <div id="r_vendor" class="form-group row">
        <label for="x_vendor" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_vendor"><?= $Page->vendor->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_vendor" id="z_vendor" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->vendor->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_vendor" class="ew-search-field">
<input type="<?= $Page->vendor->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_vendor" name="x_vendor" id="x_vendor" size="30" placeholder="<?= HtmlEncode($Page->vendor->getPlaceHolder()) ?>" value="<?= $Page->vendor->EditValue ?>"<?= $Page->vendor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vendor->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->operator->Visible) { // operator ?>
    <div id="r_operator" class="form-group row">
        <label for="x_operator" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_operator"><?= $Page->operator->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_operator" id="z_operator" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->operator->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_operator" class="ew-search-field">
<input type="<?= $Page->operator->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_operator" name="x_operator" id="x_operator" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->operator->getPlaceHolder()) ?>" value="<?= $Page->operator->EditValue ?>"<?= $Page->operator->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->operator->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->transaction_status->Visible) { // transaction_status ?>
    <div id="r_transaction_status" class="form-group row">
        <label for="x_transaction_status" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_transaction_status"><?= $Page->transaction_status->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_transaction_status" id="z_transaction_status" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->transaction_status->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_transaction_status" class="ew-search-field">
<input type="<?= $Page->transaction_status->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_transaction_status" name="x_transaction_status" id="x_transaction_status" size="30" placeholder="<?= HtmlEncode($Page->transaction_status->getPlaceHolder()) ?>" value="<?= $Page->transaction_status->EditValue ?>"<?= $Page->transaction_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->transaction_status->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
    <div id="r_start_date" class="form-group row">
        <label for="x_start_date" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_start_date"><?= $Page->start_date->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_start_date" id="z_start_date" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->start_date->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_start_date" class="ew-search-field">
<input type="<?= $Page->start_date->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_start_date" name="x_start_date" id="x_start_date" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>" value="<?= $Page->start_date->EditValue ?>"<?= $Page->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage(false) ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_transactions_per_platformsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fview_transactions_per_platformsearch", "x_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
    <div id="r_end_date" class="form-group row">
        <label for="x_end_date" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_end_date"><?= $Page->end_date->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_end_date" id="z_end_date" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->end_date->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_end_date" class="ew-search-field">
<input type="<?= $Page->end_date->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_end_date" name="x_end_date" id="x_end_date" placeholder="<?= HtmlEncode($Page->end_date->getPlaceHolder()) ?>" value="<?= $Page->end_date->EditValue ?>"<?= $Page->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->end_date->getErrorMessage(false) ?></div>
<?php if (!$Page->end_date->ReadOnly && !$Page->end_date->Disabled && !isset($Page->end_date->EditAttrs["readonly"]) && !isset($Page->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_transactions_per_platformsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fview_transactions_per_platformsearch", "x_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->platform->Visible) { // platform ?>
    <div id="r_platform" class="form-group row">
        <label for="x_platform" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_platform"><?= $Page->platform->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_platform" id="z_platform" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->platform->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_platform" class="ew-search-field">
<input type="<?= $Page->platform->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_platform" name="x_platform" id="x_platform" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->platform->getPlaceHolder()) ?>" value="<?= $Page->platform->EditValue ?>"<?= $Page->platform->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->platform->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
    <div id="r_status_id" class="form-group row">
        <label for="x_status_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_status_id"><?= $Page->status_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status_id" id="z_status_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_id->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_status_id" class="ew-search-field">
<input type="<?= $Page->status_id->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_status_id" name="x_status_id" id="x_status_id" size="30" placeholder="<?= HtmlEncode($Page->status_id->getPlaceHolder()) ?>" value="<?= $Page->status_id->EditValue ?>"<?= $Page->status_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->status_id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
    <div id="r_vendor_id" class="form-group row">
        <label for="x_vendor_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_vendor_id"><?= $Page->vendor_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_vendor_id" id="z_vendor_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->vendor_id->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_vendor_id" class="ew-search-field">
<input type="<?= $Page->vendor_id->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_vendor_id" name="x_vendor_id" id="x_vendor_id" size="30" placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>" value="<?= $Page->vendor_id->EditValue ?>"<?= $Page->vendor_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
    <div id="r_inventory_id" class="form-group row">
        <label for="x_inventory_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_inventory_id"><?= $Page->inventory_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_inventory_id" id="z_inventory_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->inventory_id->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_inventory_id" class="ew-search-field">
<input type="<?= $Page->inventory_id->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_inventory_id" name="x_inventory_id" id="x_inventory_id" size="30" placeholder="<?= HtmlEncode($Page->inventory_id->getPlaceHolder()) ?>" value="<?= $Page->inventory_id->EditValue ?>"<?= $Page->inventory_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->inventory_id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
    <div id="r_platform_id" class="form-group row">
        <label for="x_platform_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_platform_id"><?= $Page->platform_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_platform_id" id="z_platform_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->platform_id->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_platform_id" class="ew-search-field">
<input type="<?= $Page->platform_id->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_platform_id" name="x_platform_id" id="x_platform_id" size="30" placeholder="<?= HtmlEncode($Page->platform_id->getPlaceHolder()) ?>" value="<?= $Page->platform_id->EditValue ?>"<?= $Page->platform_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
    <div id="r_operator_id" class="form-group row">
        <label for="x_operator_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_operator_id"><?= $Page->operator_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_operator_id" id="z_operator_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->operator_id->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_operator_id" class="ew-search-field">
<input type="<?= $Page->operator_id->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_operator_id" name="x_operator_id" id="x_operator_id" size="30" placeholder="<?= HtmlEncode($Page->operator_id->getPlaceHolder()) ?>" value="<?= $Page->operator_id->EditValue ?>"<?= $Page->operator_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->operator_id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
    <div id="r_bus_size_id" class="form-group row">
        <label for="x_bus_size_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_bus_size_id"><?= $Page->bus_size_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_bus_size_id" id="z_bus_size_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bus_size_id->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_bus_size_id" class="ew-search-field">
<input type="<?= $Page->bus_size_id->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_bus_size_id" name="x_bus_size_id" id="x_bus_size_id" size="30" placeholder="<?= HtmlEncode($Page->bus_size_id->getPlaceHolder()) ?>" value="<?= $Page->bus_size_id->EditValue ?>"<?= $Page->bus_size_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bus_size_id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->vendor_search_id->Visible) { // vendor_search_id ?>
    <div id="r_vendor_search_id" class="form-group row">
        <label for="x_vendor_search_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_vendor_search_id"><?= $Page->vendor_search_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_vendor_search_id" id="z_vendor_search_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->vendor_search_id->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_vendor_search_id" class="ew-search-field">
<input type="<?= $Page->vendor_search_id->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_vendor_search_id" name="x_vendor_search_id" id="x_vendor_search_id" size="30" placeholder="<?= HtmlEncode($Page->vendor_search_id->getPlaceHolder()) ?>" value="<?= $Page->vendor_search_id->EditValue ?>"<?= $Page->vendor_search_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vendor_search_id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->vendor_search_name->Visible) { // vendor_search_name ?>
    <div id="r_vendor_search_name" class="form-group row">
        <label for="x_vendor_search_name" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_vendor_search_name"><?= $Page->vendor_search_name->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_vendor_search_name" id="z_vendor_search_name" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->vendor_search_name->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_vendor_search_name" class="ew-search-field">
<input type="<?= $Page->vendor_search_name->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_vendor_search_name" name="x_vendor_search_name" id="x_vendor_search_name" size="30" placeholder="<?= HtmlEncode($Page->vendor_search_name->getPlaceHolder()) ?>" value="<?= $Page->vendor_search_name->EditValue ?>"<?= $Page->vendor_search_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vendor_search_name->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
    <div id="r_price" class="form-group row">
        <label for="x_price" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_price"><?= $Page->price->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_price" id="z_price" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->price->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_price" class="ew-search-field">
<input type="<?= $Page->price->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_price" name="x_price" id="x_price" size="30" placeholder="<?= HtmlEncode($Page->price->getPlaceHolder()) ?>" value="<?= $Page->price->EditValue ?>"<?= $Page->price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->price->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <div id="r_quantity" class="form-group row">
        <label for="x_quantity" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_quantity"><?= $Page->quantity->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_quantity" id="z_quantity" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->quantity->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_quantity" class="ew-search-field">
<input type="<?= $Page->quantity->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_quantity" name="x_quantity" id="x_quantity" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>" value="<?= $Page->quantity->EditValue ?>"<?= $Page->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
    <div id="r_amount_paid" class="form-group row">
        <label for="x_amount_paid" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_amount_paid"><?= $Page->amount_paid->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_amount_paid" id="z_amount_paid" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->amount_paid->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_amount_paid" class="ew-search-field">
<input type="<?= $Page->amount_paid->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_amount_paid" name="x_amount_paid" id="x_amount_paid" size="30" placeholder="<?= HtmlEncode($Page->amount_paid->getPlaceHolder()) ?>" value="<?= $Page->amount_paid->EditValue ?>"<?= $Page->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->amount_paid->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->transitmedia_fee->Visible) { // transitmedia_fee ?>
    <div id="r_transitmedia_fee" class="form-group row">
        <label for="x_transitmedia_fee" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_transitmedia_fee"><?= $Page->transitmedia_fee->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_transitmedia_fee" id="z_transitmedia_fee" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->transitmedia_fee->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_transitmedia_fee" class="ew-search-field">
<input type="<?= $Page->transitmedia_fee->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_transitmedia_fee" name="x_transitmedia_fee" id="x_transitmedia_fee" size="30" placeholder="<?= HtmlEncode($Page->transitmedia_fee->getPlaceHolder()) ?>" value="<?= $Page->transitmedia_fee->EditValue ?>"<?= $Page->transitmedia_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->transitmedia_fee->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
    <div id="r_lasaa_fee" class="form-group row">
        <label for="x_lasaa_fee" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_lasaa_fee"><?= $Page->lasaa_fee->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_lasaa_fee" id="z_lasaa_fee" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lasaa_fee->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_lasaa_fee" class="ew-search-field">
<input type="<?= $Page->lasaa_fee->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_lasaa_fee" name="x_lasaa_fee" id="x_lasaa_fee" size="30" placeholder="<?= HtmlEncode($Page->lasaa_fee->getPlaceHolder()) ?>" value="<?= $Page->lasaa_fee->EditValue ?>"<?= $Page->lasaa_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->lasaa_fee->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->operator_fee->Visible) { // operator_fee ?>
    <div id="r_operator_fee" class="form-group row">
        <label for="x_operator_fee" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_operator_fee"><?= $Page->operator_fee->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_operator_fee" id="z_operator_fee" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->operator_fee->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_operator_fee" class="ew-search-field">
<input type="<?= $Page->operator_fee->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_operator_fee" name="x_operator_fee" id="x_operator_fee" size="30" placeholder="<?= HtmlEncode($Page->operator_fee->getPlaceHolder()) ?>" value="<?= $Page->operator_fee->EditValue ?>"<?= $Page->operator_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->operator_fee->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
    <div id="r_lamata_fee" class="form-group row">
        <label for="x_lamata_fee" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_lamata_fee"><?= $Page->lamata_fee->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_lamata_fee" id="z_lamata_fee" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lamata_fee->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_lamata_fee" class="ew-search-field">
<input type="<?= $Page->lamata_fee->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_lamata_fee" name="x_lamata_fee" id="x_lamata_fee" size="30" placeholder="<?= HtmlEncode($Page->lamata_fee->getPlaceHolder()) ?>" value="<?= $Page->lamata_fee->EditValue ?>"<?= $Page->lamata_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->lamata_fee->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <div id="r_total" class="form-group row">
        <label for="x_total" class="<?= $Page->LeftColumnClass ?>"><span id="elh_view_transactions_per_platform_total"><?= $Page->total->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_total" id="z_total" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->total->cellAttributes() ?>>
            <span id="el_view_transactions_per_platform_total" class="ew-search-field">
<input type="<?= $Page->total->getInputTextType() ?>" data-table="view_transactions_per_platform" data-field="x_total" name="x_total" id="x_total" size="30" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" value="<?= $Page->total->EditValue ?>"<?= $Page->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("Search") ?></button>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="location.reload();"><?= $Language->phrase("Reset") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("view_transactions_per_platform");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

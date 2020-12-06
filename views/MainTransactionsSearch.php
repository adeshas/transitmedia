<?php

namespace PHPMaker2021\test;

// Page object
$MainTransactionsSearch = &$Page;
?>
<script>
if (!ew.vars.tables.main_transactions) ew.vars.tables.main_transactions = <?= JsonEncode(GetClientVar("tables", "main_transactions")) ?>;
var currentForm, currentPageID;
var fmain_transactionssearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fmain_transactionssearch = currentAdvancedSearchForm = new ew.Form("fmain_transactionssearch", "search");
    <?php } else { ?>
    fmain_transactionssearch = currentForm = new ew.Form("fmain_transactionssearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var fields = ew.vars.tables.main_transactions.fields;
    fmain_transactionssearch.addFields([
        ["id", [ew.Validators.integer], fields.id.isInvalid],
        ["campaign_id", [], fields.campaign_id.isInvalid],
        ["operator_id", [], fields.operator_id.isInvalid],
        ["payment_date", [ew.Validators.datetime(5)], fields.payment_date.isInvalid],
        ["y_payment_date", [ew.Validators.between], false],
        ["vendor_id", [ew.Validators.integer], fields.vendor_id.isInvalid],
        ["price_id", [], fields.price_id.isInvalid],
        ["quantity", [ew.Validators.integer], fields.quantity.isInvalid],
        ["assigned_buses", [ew.Validators.integer], fields.assigned_buses.isInvalid],
        ["start_date", [ew.Validators.datetime(5)], fields.start_date.isInvalid],
        ["y_start_date", [ew.Validators.between], false],
        ["end_date", [ew.Validators.datetime(5)], fields.end_date.isInvalid],
        ["y_end_date", [ew.Validators.between], false],
        ["visible_status_id", [], fields.visible_status_id.isInvalid],
        ["status_id", [], fields.status_id.isInvalid],
        ["print_status_id", [], fields.print_status_id.isInvalid],
        ["payment_status_id", [], fields.payment_status_id.isInvalid],
        ["created_by", [], fields.created_by.isInvalid],
        ["ts_created", [ew.Validators.datetime(0)], fields.ts_created.isInvalid],
        ["ts_last_update", [ew.Validators.datetime(0)], fields.ts_last_update.isInvalid],
        ["total", [], fields.total.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fmain_transactionssearch.setInvalid();
    });

    // Validate form
    fmain_transactionssearch.validate = function () {
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
    fmain_transactionssearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_transactionssearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_transactionssearch.lists.campaign_id = <?= $Page->campaign_id->toClientList($Page) ?>;
    fmain_transactionssearch.lists.operator_id = <?= $Page->operator_id->toClientList($Page) ?>;
    fmain_transactionssearch.lists.vendor_id = <?= $Page->vendor_id->toClientList($Page) ?>;
    fmain_transactionssearch.lists.price_id = <?= $Page->price_id->toClientList($Page) ?>;
    fmain_transactionssearch.lists.visible_status_id = <?= $Page->visible_status_id->toClientList($Page) ?>;
    fmain_transactionssearch.lists.status_id = <?= $Page->status_id->toClientList($Page) ?>;
    fmain_transactionssearch.lists.print_status_id = <?= $Page->print_status_id->toClientList($Page) ?>;
    fmain_transactionssearch.lists.payment_status_id = <?= $Page->payment_status_id->toClientList($Page) ?>;
    fmain_transactionssearch.lists.created_by = <?= $Page->created_by->toClientList($Page) ?>;
    loadjs.done("fmain_transactionssearch");
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
<form name="fmain_transactionssearch" id="fmain_transactionssearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_transactions">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label for="x_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_id"><?= $Page->id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id" id="z_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
            <span id="el_main_transactions_id" class="ew-search-field">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="main_transactions" data-field="x_id" name="x_id" id="x_id" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <div id="r_campaign_id" class="form-group row">
        <label for="x_campaign_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_campaign_id"><?= $Page->campaign_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_campaign_id" id="z_campaign_id" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign_id->cellAttributes() ?>>
            <span id="el_main_transactions_campaign_id" class="ew-search-field">
<input type="<?= $Page->campaign_id->getInputTextType() ?>" data-table="main_transactions" data-field="x_campaign_id" name="x_campaign_id" id="x_campaign_id" size="30" placeholder="<?= HtmlEncode($Page->campaign_id->getPlaceHolder()) ?>" value="<?= $Page->campaign_id->EditValue ?>"<?= $Page->campaign_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->campaign_id->getErrorMessage(false) ?></div>
<?= $Page->campaign_id->Lookup->getParamTag($Page, "p_x_campaign_id") ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
    <div id="r_operator_id" class="form-group row">
        <label for="x_operator_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_operator_id"><?= $Page->operator_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_operator_id" id="z_operator_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->operator_id->cellAttributes() ?>>
            <span id="el_main_transactions_operator_id" class="ew-search-field">
    <select
        id="x_operator_id"
        name="x_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x_operator_id"
        data-table="main_transactions"
        data-field="x_operator_id"
        data-value-separator="<?= $Page->operator_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->operator_id->getPlaceHolder()) ?>"
        <?= $Page->operator_id->editAttributes() ?>>
        <?= $Page->operator_id->selectOptionListHtml("x_operator_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->operator_id->getErrorMessage(false) ?></div>
<?= $Page->operator_id->Lookup->getParamTag($Page, "p_x_operator_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x_operator_id']"),
        options = { name: "x_operator_id", selectId: "main_transactions_x_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
    <div id="r_payment_date" class="form-group row">
        <label for="x_payment_date" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_payment_date"><?= $Page->payment_date->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_payment_date" id="z_payment_date" value="BETWEEN">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->payment_date->cellAttributes() ?>>
            <span id="el_main_transactions_payment_date" class="ew-search-field">
<input type="<?= $Page->payment_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_date" data-format="5" name="x_payment_date" id="x_payment_date" placeholder="<?= HtmlEncode($Page->payment_date->getPlaceHolder()) ?>" value="<?= $Page->payment_date->EditValue ?>"<?= $Page->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->payment_date->getErrorMessage(false) ?></div>
<?php if (!$Page->payment_date->ReadOnly && !$Page->payment_date->Disabled && !isset($Page->payment_date->EditAttrs["readonly"]) && !isset($Page->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionssearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionssearch", "x_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
            <span class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></span>
            <span id="el2_main_transactions_payment_date" class="ew-search-field2">
<input type="<?= $Page->payment_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_date" data-format="5" name="y_payment_date" id="y_payment_date" placeholder="<?= HtmlEncode($Page->payment_date->getPlaceHolder()) ?>" value="<?= $Page->payment_date->EditValue2 ?>"<?= $Page->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->payment_date->getErrorMessage(false) ?></div>
<?php if (!$Page->payment_date->ReadOnly && !$Page->payment_date->Disabled && !isset($Page->payment_date->EditAttrs["readonly"]) && !isset($Page->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionssearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionssearch", "y_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
    <div id="r_vendor_id" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_vendor_id"><?= $Page->vendor_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_vendor_id" id="z_vendor_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->vendor_id->cellAttributes() ?>>
            <span id="el_main_transactions_vendor_id" class="ew-search-field">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("search")) { // Non system admin ?>
    <select
        id="x_vendor_id"
        name="x_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x_vendor_id"
        data-table="main_transactions"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage(false) ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x_vendor_id']"),
        options = { name: "x_vendor_id", selectId: "main_transactions_x_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } else { ?>
<?php
$onchange = $Page->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Page->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x_vendor_id" id="sv_x_vendor_id" value="<?= RemoveHtml($Page->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"<?= $Page->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_transactions" data-field="x_vendor_id" data-input="sv_x_vendor_id" data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>" name="x_vendor_id" id="x_vendor_id" value="<?= HtmlEncode($Page->vendor_id->AdvancedSearch->SearchValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage(false) ?></div>
<script>
loadjs.ready(["fmain_transactionssearch"], function() {
    fmain_transactionssearch.createAutoSuggest(Object.assign({"id":"x_vendor_id","forceSelect":false}, ew.vars.tables.main_transactions.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x_vendor_id") ?>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
    <div id="r_price_id" class="form-group row">
        <label for="x_price_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_price_id"><?= $Page->price_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_price_id" id="z_price_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->price_id->cellAttributes() ?>>
            <span id="el_main_transactions_price_id" class="ew-search-field">
<input type="<?= $Page->price_id->getInputTextType() ?>" data-table="main_transactions" data-field="x_price_id" name="x_price_id" id="x_price_id" size="30" placeholder="<?= HtmlEncode($Page->price_id->getPlaceHolder()) ?>" value="<?= $Page->price_id->EditValue ?>"<?= $Page->price_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->price_id->getErrorMessage(false) ?></div>
<?= $Page->price_id->Lookup->getParamTag($Page, "p_x_price_id") ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <div id="r_quantity" class="form-group row">
        <label for="x_quantity" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_quantity"><?= $Page->quantity->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_quantity" id="z_quantity" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->quantity->cellAttributes() ?>>
            <span id="el_main_transactions_quantity" class="ew-search-field">
<input type="<?= $Page->quantity->getInputTextType() ?>" data-table="main_transactions" data-field="x_quantity" name="x_quantity" id="x_quantity" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>" value="<?= $Page->quantity->EditValue ?>"<?= $Page->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->assigned_buses->Visible) { // assigned_buses ?>
    <div id="r_assigned_buses" class="form-group row">
        <label for="x_assigned_buses" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_assigned_buses"><?= $Page->assigned_buses->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_assigned_buses" id="z_assigned_buses" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->assigned_buses->cellAttributes() ?>>
            <span id="el_main_transactions_assigned_buses" class="ew-search-field">
<input type="<?= $Page->assigned_buses->getInputTextType() ?>" data-table="main_transactions" data-field="x_assigned_buses" name="x_assigned_buses" id="x_assigned_buses" size="30" placeholder="<?= HtmlEncode($Page->assigned_buses->getPlaceHolder()) ?>" value="<?= $Page->assigned_buses->EditValue ?>"<?= $Page->assigned_buses->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assigned_buses->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
    <div id="r_start_date" class="form-group row">
        <label for="x_start_date" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_start_date"><?= $Page->start_date->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_start_date" id="z_start_date" value="BETWEEN">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->start_date->cellAttributes() ?>>
            <span id="el_main_transactions_start_date" class="ew-search-field">
<input type="<?= $Page->start_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_start_date" data-format="5" name="x_start_date" id="x_start_date" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>" value="<?= $Page->start_date->EditValue ?>"<?= $Page->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage(false) ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionssearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionssearch", "x_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
            <span class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></span>
            <span id="el2_main_transactions_start_date" class="ew-search-field2">
<input type="<?= $Page->start_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_start_date" data-format="5" name="y_start_date" id="y_start_date" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>" value="<?= $Page->start_date->EditValue2 ?>"<?= $Page->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage(false) ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionssearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionssearch", "y_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
    <div id="r_end_date" class="form-group row">
        <label for="x_end_date" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_end_date"><?= $Page->end_date->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_end_date" id="z_end_date" value="BETWEEN">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->end_date->cellAttributes() ?>>
            <span id="el_main_transactions_end_date" class="ew-search-field">
<input type="<?= $Page->end_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_end_date" data-format="5" name="x_end_date" id="x_end_date" placeholder="<?= HtmlEncode($Page->end_date->getPlaceHolder()) ?>" value="<?= $Page->end_date->EditValue ?>"<?= $Page->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->end_date->getErrorMessage(false) ?></div>
<?php if (!$Page->end_date->ReadOnly && !$Page->end_date->Disabled && !isset($Page->end_date->EditAttrs["readonly"]) && !isset($Page->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionssearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionssearch", "x_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
            <span class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></span>
            <span id="el2_main_transactions_end_date" class="ew-search-field2">
<input type="<?= $Page->end_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_end_date" data-format="5" name="y_end_date" id="y_end_date" placeholder="<?= HtmlEncode($Page->end_date->getPlaceHolder()) ?>" value="<?= $Page->end_date->EditValue2 ?>"<?= $Page->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->end_date->getErrorMessage(false) ?></div>
<?php if (!$Page->end_date->ReadOnly && !$Page->end_date->Disabled && !isset($Page->end_date->EditAttrs["readonly"]) && !isset($Page->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionssearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionssearch", "y_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
    <div id="r_visible_status_id" class="form-group row">
        <label for="x_visible_status_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_visible_status_id"><?= $Page->visible_status_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_visible_status_id" id="z_visible_status_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->visible_status_id->cellAttributes() ?>>
            <span id="el_main_transactions_visible_status_id" class="ew-search-field">
    <select
        id="x_visible_status_id"
        name="x_visible_status_id"
        class="form-control ew-select<?= $Page->visible_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x_visible_status_id"
        data-table="main_transactions"
        data-field="x_visible_status_id"
        data-value-separator="<?= $Page->visible_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->visible_status_id->getPlaceHolder()) ?>"
        <?= $Page->visible_status_id->editAttributes() ?>>
        <?= $Page->visible_status_id->selectOptionListHtml("x_visible_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->visible_status_id->getErrorMessage(false) ?></div>
<?= $Page->visible_status_id->Lookup->getParamTag($Page, "p_x_visible_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x_visible_status_id']"),
        options = { name: "x_visible_status_id", selectId: "main_transactions_x_visible_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.visible_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
    <div id="r_status_id" class="form-group row">
        <label for="x_status_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_status_id"><?= $Page->status_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status_id" id="z_status_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_id->cellAttributes() ?>>
            <span id="el_main_transactions_status_id" class="ew-search-field">
<input type="<?= $Page->status_id->getInputTextType() ?>" data-table="main_transactions" data-field="x_status_id" name="x_status_id" id="x_status_id" size="30" placeholder="<?= HtmlEncode($Page->status_id->getPlaceHolder()) ?>" value="<?= $Page->status_id->EditValue ?>"<?= $Page->status_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->status_id->getErrorMessage(false) ?></div>
<?= $Page->status_id->Lookup->getParamTag($Page, "p_x_status_id") ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->print_status_id->Visible) { // print_status_id ?>
    <div id="r_print_status_id" class="form-group row">
        <label for="x_print_status_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_print_status_id"><?= $Page->print_status_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_print_status_id" id="z_print_status_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->print_status_id->cellAttributes() ?>>
            <span id="el_main_transactions_print_status_id" class="ew-search-field">
<input type="<?= $Page->print_status_id->getInputTextType() ?>" data-table="main_transactions" data-field="x_print_status_id" name="x_print_status_id" id="x_print_status_id" size="30" placeholder="<?= HtmlEncode($Page->print_status_id->getPlaceHolder()) ?>" value="<?= $Page->print_status_id->EditValue ?>"<?= $Page->print_status_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->print_status_id->getErrorMessage(false) ?></div>
<?= $Page->print_status_id->Lookup->getParamTag($Page, "p_x_print_status_id") ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
    <div id="r_payment_status_id" class="form-group row">
        <label for="x_payment_status_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_payment_status_id"><?= $Page->payment_status_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_payment_status_id" id="z_payment_status_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->payment_status_id->cellAttributes() ?>>
            <span id="el_main_transactions_payment_status_id" class="ew-search-field">
<input type="<?= $Page->payment_status_id->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_status_id" name="x_payment_status_id" id="x_payment_status_id" size="30" placeholder="<?= HtmlEncode($Page->payment_status_id->getPlaceHolder()) ?>" value="<?= $Page->payment_status_id->EditValue ?>"<?= $Page->payment_status_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->payment_status_id->getErrorMessage(false) ?></div>
<?= $Page->payment_status_id->Lookup->getParamTag($Page, "p_x_payment_status_id") ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <div id="r_created_by" class="form-group row">
        <label for="x_created_by" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_created_by"><?= $Page->created_by->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_created_by" id="z_created_by" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_by->cellAttributes() ?>>
            <span id="el_main_transactions_created_by" class="ew-search-field">
    <select
        id="x_created_by"
        name="x_created_by"
        class="form-control ew-select<?= $Page->created_by->isInvalidClass() ?>"
        data-select2-id="main_transactions_x_created_by"
        data-table="main_transactions"
        data-field="x_created_by"
        data-value-separator="<?= $Page->created_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>"
        <?= $Page->created_by->editAttributes() ?>>
        <?= $Page->created_by->selectOptionListHtml("x_created_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->created_by->getErrorMessage(false) ?></div>
<?= $Page->created_by->Lookup->getParamTag($Page, "p_x_created_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x_created_by']"),
        options = { name: "x_created_by", selectId: "main_transactions_x_created_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.created_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <div id="r_ts_created" class="form-group row">
        <label for="x_ts_created" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_ts_created"><?= $Page->ts_created->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ts_created" id="z_ts_created" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ts_created->cellAttributes() ?>>
            <span id="el_main_transactions_ts_created" class="ew-search-field">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="main_transactions" data-field="x_ts_created" name="x_ts_created" id="x_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage(false) ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionssearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionssearch", "x_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
    <div id="r_ts_last_update" class="form-group row">
        <label for="x_ts_last_update" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_ts_last_update"><?= $Page->ts_last_update->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ts_last_update" id="z_ts_last_update" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ts_last_update->cellAttributes() ?>>
            <span id="el_main_transactions_ts_last_update" class="ew-search-field">
<input type="<?= $Page->ts_last_update->getInputTextType() ?>" data-table="main_transactions" data-field="x_ts_last_update" name="x_ts_last_update" id="x_ts_last_update" placeholder="<?= HtmlEncode($Page->ts_last_update->getPlaceHolder()) ?>" value="<?= $Page->ts_last_update->EditValue ?>"<?= $Page->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_last_update->getErrorMessage(false) ?></div>
<?php if (!$Page->ts_last_update->ReadOnly && !$Page->ts_last_update->Disabled && !isset($Page->ts_last_update->EditAttrs["readonly"]) && !isset($Page->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionssearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionssearch", "x_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <div id="r_total" class="form-group row">
        <label for="x_total" class="<?= $Page->LeftColumnClass ?>"><span id="elh_main_transactions_total"><?= $Page->total->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_total" id="z_total" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->total->cellAttributes() ?>>
            <span id="el_main_transactions_total" class="ew-search-field">
<input type="<?= $Page->total->getInputTextType() ?>" data-table="main_transactions" data-field="x_total" name="x_total" id="x_total" size="30" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" value="<?= $Page->total->EditValue ?>"<?= $Page->total->editAttributes() ?>>
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
    ew.addEventHandlers("main_transactions");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

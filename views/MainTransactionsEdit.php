<?php

namespace PHPMaker2021\test;

// Page object
$MainTransactionsEdit = &$Page;
?>
<script>
if (!ew.vars.tables.main_transactions) ew.vars.tables.main_transactions = <?= JsonEncode(GetClientVar("tables", "main_transactions")) ?>;
var currentForm, currentPageID;
var fmain_transactionsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fmain_transactionsedit = currentForm = new ew.Form("fmain_transactionsedit", "edit");

    // Add fields
    var fields = ew.vars.tables.main_transactions.fields;
    fmain_transactionsedit.addFields([
        ["campaign_id", [fields.campaign_id.required ? ew.Validators.required(fields.campaign_id.caption) : null], fields.campaign_id.isInvalid],
        ["operator_id", [fields.operator_id.required ? ew.Validators.required(fields.operator_id.caption) : null], fields.operator_id.isInvalid],
        ["payment_date", [fields.payment_date.required ? ew.Validators.required(fields.payment_date.caption) : null, ew.Validators.datetime(5)], fields.payment_date.isInvalid],
        ["price_id", [fields.price_id.required ? ew.Validators.required(fields.price_id.caption) : null], fields.price_id.isInvalid],
        ["quantity", [fields.quantity.required ? ew.Validators.required(fields.quantity.caption) : null, ew.Validators.integer], fields.quantity.isInvalid],
        ["start_date", [fields.start_date.required ? ew.Validators.required(fields.start_date.caption) : null, ew.Validators.datetime(5)], fields.start_date.isInvalid],
        ["end_date", [fields.end_date.required ? ew.Validators.required(fields.end_date.caption) : null, ew.Validators.datetime(5)], fields.end_date.isInvalid],
        ["visible_status_id", [fields.visible_status_id.required ? ew.Validators.required(fields.visible_status_id.caption) : null], fields.visible_status_id.isInvalid],
        ["status_id", [fields.status_id.required ? ew.Validators.required(fields.status_id.caption) : null], fields.status_id.isInvalid],
        ["print_status_id", [fields.print_status_id.required ? ew.Validators.required(fields.print_status_id.caption) : null], fields.print_status_id.isInvalid],
        ["payment_status_id", [fields.payment_status_id.required ? ew.Validators.required(fields.payment_status_id.caption) : null], fields.payment_status_id.isInvalid],
        ["total", [fields.total.required ? ew.Validators.required(fields.total.caption) : null], fields.total.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_transactionsedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fmain_transactionsedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fmain_transactionsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_transactionsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_transactionsedit.lists.campaign_id = <?= $Page->campaign_id->toClientList($Page) ?>;
    fmain_transactionsedit.lists.operator_id = <?= $Page->operator_id->toClientList($Page) ?>;
    fmain_transactionsedit.lists.price_id = <?= $Page->price_id->toClientList($Page) ?>;
    fmain_transactionsedit.lists.visible_status_id = <?= $Page->visible_status_id->toClientList($Page) ?>;
    fmain_transactionsedit.lists.status_id = <?= $Page->status_id->toClientList($Page) ?>;
    fmain_transactionsedit.lists.print_status_id = <?= $Page->print_status_id->toClientList($Page) ?>;
    fmain_transactionsedit.lists.payment_status_id = <?= $Page->payment_status_id->toClientList($Page) ?>;
    loadjs.done("fmain_transactionsedit");
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
<form name="fmain_transactionsedit" id="fmain_transactionsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_transactions">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "main_campaigns") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_campaigns">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->campaign_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "y_operators") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="y_operators">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->operator_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <div id="r_campaign_id" class="form-group row">
        <label id="elh_main_transactions_campaign_id" for="x_campaign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->campaign_id->caption() ?><?= $Page->campaign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if ($Page->campaign_id->getSessionValue() != "") { ?>
<span id="el_main_transactions_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_campaign_id" name="x_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_main_transactions_campaign_id">
<?php $Page->campaign_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_campaign_id"
        name="x_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x_campaign_id"
        data-table="main_transactions"
        data-field="x_campaign_id"
        data-value-separator="<?= $Page->campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->campaign_id->getPlaceHolder()) ?>"
        <?= $Page->campaign_id->editAttributes() ?>>
        <?= $Page->campaign_id->selectOptionListHtml("x_campaign_id") ?>
    </select>
    <?= $Page->campaign_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->campaign_id->getErrorMessage() ?></div>
<?= $Page->campaign_id->Lookup->getParamTag($Page, "p_x_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x_campaign_id']"),
        options = { name: "x_campaign_id", selectId: "main_transactions_x_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_main_transactions_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_campaign_id" data-hidden="1" name="x_campaign_id" id="x_campaign_id" value="<?= HtmlEncode($Page->campaign_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
    <div id="r_operator_id" class="form-group row">
        <label id="elh_main_transactions_operator_id" for="x_operator_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->operator_id->caption() ?><?= $Page->operator_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->operator_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if ($Page->operator_id->getSessionValue() != "") { ?>
<span id="el_main_transactions_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->operator_id->getDisplayValue($Page->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_operator_id" name="x_operator_id" value="<?= HtmlEncode($Page->operator_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_main_transactions_operator_id">
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
    <?= $Page->operator_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->operator_id->getErrorMessage() ?></div>
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
<?php } ?>
<?php } else { ?>
<span id="el_main_transactions_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->operator_id->getDisplayValue($Page->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_operator_id" data-hidden="1" name="x_operator_id" id="x_operator_id" value="<?= HtmlEncode($Page->operator_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
    <div id="r_payment_date" class="form-group row">
        <label id="elh_main_transactions_payment_date" for="x_payment_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->payment_date->caption() ?><?= $Page->payment_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->payment_date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_payment_date">
<input type="<?= $Page->payment_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_date" data-format="5" name="x_payment_date" id="x_payment_date" placeholder="<?= HtmlEncode($Page->payment_date->getPlaceHolder()) ?>" value="<?= $Page->payment_date->EditValue ?>"<?= $Page->payment_date->editAttributes() ?> aria-describedby="x_payment_date_help">
<?= $Page->payment_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->payment_date->getErrorMessage() ?></div>
<?php if (!$Page->payment_date->ReadOnly && !$Page->payment_date->Disabled && !isset($Page->payment_date->EditAttrs["readonly"]) && !isset($Page->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsedit", "x_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_main_transactions_payment_date">
<span<?= $Page->payment_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->payment_date->getDisplayValue($Page->payment_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_date" data-hidden="1" name="x_payment_date" id="x_payment_date" value="<?= HtmlEncode($Page->payment_date->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
    <div id="r_price_id" class="form-group row">
        <label id="elh_main_transactions_price_id" for="x_price_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->price_id->caption() ?><?= $Page->price_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->price_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_price_id">
    <select
        id="x_price_id"
        name="x_price_id"
        class="form-control ew-select<?= $Page->price_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x_price_id"
        data-table="main_transactions"
        data-field="x_price_id"
        data-value-separator="<?= $Page->price_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->price_id->getPlaceHolder()) ?>"
        <?= $Page->price_id->editAttributes() ?>>
        <?= $Page->price_id->selectOptionListHtml("x_price_id") ?>
    </select>
    <?= $Page->price_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->price_id->getErrorMessage() ?></div>
<?= $Page->price_id->Lookup->getParamTag($Page, "p_x_price_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x_price_id']"),
        options = { name: "x_price_id", selectId: "main_transactions_x_price_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.price_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_transactions_price_id">
<span<?= $Page->price_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->price_id->getDisplayValue($Page->price_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_price_id" data-hidden="1" name="x_price_id" id="x_price_id" value="<?= HtmlEncode($Page->price_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <div id="r_quantity" class="form-group row">
        <label id="elh_main_transactions_quantity" for="x_quantity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->quantity->caption() ?><?= $Page->quantity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->quantity->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_quantity">
<input type="<?= $Page->quantity->getInputTextType() ?>" data-table="main_transactions" data-field="x_quantity" name="x_quantity" id="x_quantity" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>" value="<?= $Page->quantity->EditValue ?>"<?= $Page->quantity->editAttributes() ?> aria-describedby="x_quantity_help">
<?= $Page->quantity->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_transactions_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->quantity->getDisplayValue($Page->quantity->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_quantity" data-hidden="1" name="x_quantity" id="x_quantity" value="<?= HtmlEncode($Page->quantity->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
    <div id="r_start_date" class="form-group row">
        <label id="elh_main_transactions_start_date" for="x_start_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->start_date->caption() ?><?= $Page->start_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->start_date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_start_date">
<input type="<?= $Page->start_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_start_date" data-format="5" name="x_start_date" id="x_start_date" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>" value="<?= $Page->start_date->EditValue ?>"<?= $Page->start_date->editAttributes() ?> aria-describedby="x_start_date_help">
<?= $Page->start_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage() ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsedit", "x_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_main_transactions_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->start_date->getDisplayValue($Page->start_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_start_date" data-hidden="1" name="x_start_date" id="x_start_date" value="<?= HtmlEncode($Page->start_date->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
    <div id="r_end_date" class="form-group row">
        <label id="elh_main_transactions_end_date" for="x_end_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->end_date->caption() ?><?= $Page->end_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->end_date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_end_date">
<input type="<?= $Page->end_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_end_date" data-format="5" name="x_end_date" id="x_end_date" placeholder="<?= HtmlEncode($Page->end_date->getPlaceHolder()) ?>" value="<?= $Page->end_date->EditValue ?>"<?= $Page->end_date->editAttributes() ?> aria-describedby="x_end_date_help">
<?= $Page->end_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->end_date->getErrorMessage() ?></div>
<?php if (!$Page->end_date->ReadOnly && !$Page->end_date->Disabled && !isset($Page->end_date->EditAttrs["readonly"]) && !isset($Page->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsedit", "x_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_main_transactions_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->end_date->getDisplayValue($Page->end_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_end_date" data-hidden="1" name="x_end_date" id="x_end_date" value="<?= HtmlEncode($Page->end_date->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
    <div id="r_visible_status_id" class="form-group row">
        <label id="elh_main_transactions_visible_status_id" for="x_visible_status_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->visible_status_id->caption() ?><?= $Page->visible_status_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->visible_status_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_visible_status_id">
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
    <?= $Page->visible_status_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->visible_status_id->getErrorMessage() ?></div>
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
<?php } else { ?>
<span id="el_main_transactions_visible_status_id">
<span<?= $Page->visible_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->visible_status_id->ViewValue) && $Page->visible_status_id->linkAttributes() != "") { ?>
<a<?= $Page->visible_status_id->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->visible_status_id->getDisplayValue($Page->visible_status_id->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->visible_status_id->getDisplayValue($Page->visible_status_id->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_visible_status_id" data-hidden="1" name="x_visible_status_id" id="x_visible_status_id" value="<?= HtmlEncode($Page->visible_status_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
    <div id="r_status_id" class="form-group row">
        <label id="elh_main_transactions_status_id" for="x_status_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_id->caption() ?><?= $Page->status_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_status_id">
    <select
        id="x_status_id"
        name="x_status_id"
        class="form-control ew-select<?= $Page->status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x_status_id"
        data-table="main_transactions"
        data-field="x_status_id"
        data-value-separator="<?= $Page->status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_id->getPlaceHolder()) ?>"
        <?= $Page->status_id->editAttributes() ?>>
        <?= $Page->status_id->selectOptionListHtml("x_status_id") ?>
    </select>
    <?= $Page->status_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status_id->getErrorMessage() ?></div>
<?= $Page->status_id->Lookup->getParamTag($Page, "p_x_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x_status_id']"),
        options = { name: "x_status_id", selectId: "main_transactions_x_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_transactions_status_id">
<span<?= $Page->status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->status_id->ViewValue) && $Page->status_id->linkAttributes() != "") { ?>
<a<?= $Page->status_id->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->status_id->getDisplayValue($Page->status_id->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->status_id->getDisplayValue($Page->status_id->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_status_id" data-hidden="1" name="x_status_id" id="x_status_id" value="<?= HtmlEncode($Page->status_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->print_status_id->Visible) { // print_status_id ?>
    <div id="r_print_status_id" class="form-group row">
        <label id="elh_main_transactions_print_status_id" for="x_print_status_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->print_status_id->caption() ?><?= $Page->print_status_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->print_status_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_print_status_id">
    <select
        id="x_print_status_id"
        name="x_print_status_id"
        class="form-control ew-select<?= $Page->print_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x_print_status_id"
        data-table="main_transactions"
        data-field="x_print_status_id"
        data-value-separator="<?= $Page->print_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->print_status_id->getPlaceHolder()) ?>"
        <?= $Page->print_status_id->editAttributes() ?>>
        <?= $Page->print_status_id->selectOptionListHtml("x_print_status_id") ?>
    </select>
    <?= $Page->print_status_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->print_status_id->getErrorMessage() ?></div>
<?= $Page->print_status_id->Lookup->getParamTag($Page, "p_x_print_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x_print_status_id']"),
        options = { name: "x_print_status_id", selectId: "main_transactions_x_print_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.print_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_transactions_print_status_id">
<span<?= $Page->print_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->print_status_id->ViewValue) && $Page->print_status_id->linkAttributes() != "") { ?>
<a<?= $Page->print_status_id->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->print_status_id->getDisplayValue($Page->print_status_id->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->print_status_id->getDisplayValue($Page->print_status_id->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_print_status_id" data-hidden="1" name="x_print_status_id" id="x_print_status_id" value="<?= HtmlEncode($Page->print_status_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
    <div id="r_payment_status_id" class="form-group row">
        <label id="elh_main_transactions_payment_status_id" for="x_payment_status_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->payment_status_id->caption() ?><?= $Page->payment_status_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->payment_status_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_payment_status_id">
    <select
        id="x_payment_status_id"
        name="x_payment_status_id"
        class="form-control ew-select<?= $Page->payment_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x_payment_status_id"
        data-table="main_transactions"
        data-field="x_payment_status_id"
        data-value-separator="<?= $Page->payment_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->payment_status_id->getPlaceHolder()) ?>"
        <?= $Page->payment_status_id->editAttributes() ?>>
        <?= $Page->payment_status_id->selectOptionListHtml("x_payment_status_id") ?>
    </select>
    <?= $Page->payment_status_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->payment_status_id->getErrorMessage() ?></div>
<?= $Page->payment_status_id->Lookup->getParamTag($Page, "p_x_payment_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x_payment_status_id']"),
        options = { name: "x_payment_status_id", selectId: "main_transactions_x_payment_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.payment_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_transactions_payment_status_id">
<span<?= $Page->payment_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->payment_status_id->ViewValue) && $Page->payment_status_id->linkAttributes() != "") { ?>
<a<?= $Page->payment_status_id->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->payment_status_id->getDisplayValue($Page->payment_status_id->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->payment_status_id->getDisplayValue($Page->payment_status_id->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_status_id" data-hidden="1" name="x_payment_status_id" id="x_payment_status_id" value="<?= HtmlEncode($Page->payment_status_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <div id="r_total" class="form-group row">
        <label id="elh_main_transactions_total" for="x_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->total->caption() ?><?= $Page->total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->total->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_transactions_total">
<input type="<?= $Page->total->getInputTextType() ?>" data-table="main_transactions" data-field="x_total" name="x_total" id="x_total" size="30" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" value="<?= $Page->total->EditValue ?>"<?= $Page->total->editAttributes() ?> aria-describedby="x_total_help">
<?= $Page->total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_transactions_total">
<span<?= $Page->total->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->total->getDisplayValue($Page->total->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_total" data-hidden="1" name="x_total" id="x_total" value="<?= HtmlEncode($Page->total->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php
    if (in_array("sub_transaction_details", explode(",", $Page->getCurrentDetailTable())) && $sub_transaction_details->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sub_transaction_details", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubTransactionDetailsGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" onclick="this.form.action.value='cancel';"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
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

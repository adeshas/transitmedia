<?php

namespace PHPMaker2021\test;

// Page object
$SubTransactionDetailsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsub_transaction_detailsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fsub_transaction_detailsedit = currentForm = new ew.Form("fsub_transaction_detailsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sub_transaction_details")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sub_transaction_details)
        ew.vars.tables.sub_transaction_details = currentTable;
    fsub_transaction_detailsedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["transaction_id", [fields.transaction_id.visible && fields.transaction_id.required ? ew.Validators.required(fields.transaction_id.caption) : null], fields.transaction_id.isInvalid],
        ["bus_id", [fields.bus_id.visible && fields.bus_id.required ? ew.Validators.required(fields.bus_id.caption) : null], fields.bus_id.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid],
        ["ts_created", [fields.ts_created.visible && fields.ts_created.required ? ew.Validators.required(fields.ts_created.caption) : null, ew.Validators.datetime(0)], fields.ts_created.isInvalid],
        ["ts_last_update", [fields.ts_last_update.visible && fields.ts_last_update.required ? ew.Validators.required(fields.ts_last_update.caption) : null, ew.Validators.datetime(0)], fields.ts_last_update.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsub_transaction_detailsedit,
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
    fsub_transaction_detailsedit.validate = function () {
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
    fsub_transaction_detailsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_transaction_detailsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsub_transaction_detailsedit.lists.transaction_id = <?= $Page->transaction_id->toClientList($Page) ?>;
    fsub_transaction_detailsedit.lists.bus_id = <?= $Page->bus_id->toClientList($Page) ?>;
    loadjs.done("fsub_transaction_detailsedit");
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
<form name="fsub_transaction_detailsedit" id="fsub_transaction_detailsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_transaction_details">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "main_transactions") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_transactions">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->transaction_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_sub_transaction_details_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_sub_transaction_details_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_sub_transaction_details_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
    <div id="r_transaction_id" class="form-group row">
        <label id="elh_sub_transaction_details_transaction_id" for="x_transaction_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->transaction_id->caption() ?><?= $Page->transaction_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->transaction_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if ($Page->transaction_id->getSessionValue() != "") { ?>
<span id="el_sub_transaction_details_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->transaction_id->getDisplayValue($Page->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_transaction_id" name="x_transaction_id" value="<?= HtmlEncode($Page->transaction_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_sub_transaction_details_transaction_id">
<?php $Page->transaction_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_transaction_id"
        name="x_transaction_id"
        class="form-control ew-select<?= $Page->transaction_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x_transaction_id"
        data-table="sub_transaction_details"
        data-field="x_transaction_id"
        data-value-separator="<?= $Page->transaction_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->transaction_id->getPlaceHolder()) ?>"
        <?= $Page->transaction_id->editAttributes() ?>>
        <?= $Page->transaction_id->selectOptionListHtml("x_transaction_id") ?>
    </select>
    <?= $Page->transaction_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->transaction_id->getErrorMessage() ?></div>
<?= $Page->transaction_id->Lookup->getParamTag($Page, "p_x_transaction_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x_transaction_id']"),
        options = { name: "x_transaction_id", selectId: "sub_transaction_details_x_transaction_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.transaction_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_sub_transaction_details_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->transaction_id->getDisplayValue($Page->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_transaction_id" data-hidden="1" name="x_transaction_id" id="x_transaction_id" value="<?= HtmlEncode($Page->transaction_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bus_id->Visible) { // bus_id ?>
    <div id="r_bus_id" class="form-group row">
        <label id="elh_sub_transaction_details_bus_id" for="x_bus_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bus_id->caption() ?><?= $Page->bus_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bus_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_sub_transaction_details_bus_id">
    <select
        id="x_bus_id"
        name="x_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x_bus_id"
        data-table="sub_transaction_details"
        data-field="x_bus_id"
        data-value-separator="<?= $Page->bus_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_id->getPlaceHolder()) ?>"
        <?= $Page->bus_id->editAttributes() ?>>
        <?= $Page->bus_id->selectOptionListHtml("x_bus_id") ?>
    </select>
    <?= $Page->bus_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->bus_id->getErrorMessage() ?></div>
<?= $Page->bus_id->Lookup->getParamTag($Page, "p_x_bus_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x_bus_id']"),
        options = { name: "x_bus_id", selectId: "sub_transaction_details_x_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_sub_transaction_details_bus_id">
<span<?= $Page->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_id->getDisplayValue($Page->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_bus_id" data-hidden="1" name="x_bus_id" id="x_bus_id" value="<?= HtmlEncode($Page->bus_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <div id="r_ts_created" class="form-group row">
        <label id="elh_sub_transaction_details_ts_created" for="x_ts_created" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ts_created->caption() ?><?= $Page->ts_created->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ts_created->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_sub_transaction_details_ts_created">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="sub_transaction_details" data-field="x_ts_created" name="x_ts_created" id="x_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?> aria-describedby="x_ts_created_help">
<?= $Page->ts_created->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_transaction_detailsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_transaction_detailsedit", "x_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_sub_transaction_details_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ts_created->getDisplayValue($Page->ts_created->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_ts_created" data-hidden="1" name="x_ts_created" id="x_ts_created" value="<?= HtmlEncode($Page->ts_created->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
    <div id="r_ts_last_update" class="form-group row">
        <label id="elh_sub_transaction_details_ts_last_update" for="x_ts_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ts_last_update->caption() ?><?= $Page->ts_last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ts_last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_sub_transaction_details_ts_last_update">
<input type="<?= $Page->ts_last_update->getInputTextType() ?>" data-table="sub_transaction_details" data-field="x_ts_last_update" name="x_ts_last_update" id="x_ts_last_update" placeholder="<?= HtmlEncode($Page->ts_last_update->getPlaceHolder()) ?>" value="<?= $Page->ts_last_update->EditValue ?>"<?= $Page->ts_last_update->editAttributes() ?> aria-describedby="x_ts_last_update_help">
<?= $Page->ts_last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Page->ts_last_update->ReadOnly && !$Page->ts_last_update->Disabled && !isset($Page->ts_last_update->EditAttrs["readonly"]) && !isset($Page->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_transaction_detailsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_transaction_detailsedit", "x_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_sub_transaction_details_ts_last_update">
<span<?= $Page->ts_last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ts_last_update->getDisplayValue($Page->ts_last_update->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_ts_last_update" data-hidden="1" name="x_ts_last_update" id="x_ts_last_update" value="<?= HtmlEncode($Page->ts_last_update->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->isConfirm()) { ?>
<span id="el_sub_transaction_details_created_by">
<input type="hidden" data-table="sub_transaction_details" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
</span>
<?php } else { ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->FormValue) ?>">
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
    ew.addEventHandlers("sub_transaction_details");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

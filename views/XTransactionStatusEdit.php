<?php

namespace PHPMaker2021\test;

// Page object
$XTransactionStatusEdit = &$Page;
?>
<script>
if (!ew.vars.tables.x_transaction_status) ew.vars.tables.x_transaction_status = <?= JsonEncode(GetClientVar("tables", "x_transaction_status")) ?>;
var currentForm, currentPageID;
var fx_transaction_statusedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fx_transaction_statusedit = currentForm = new ew.Form("fx_transaction_statusedit", "edit");

    // Add fields
    var fields = ew.vars.tables.x_transaction_status.fields;
    fx_transaction_statusedit.addFields([
        ["id", [fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["name", [fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["admin_name", [fields.admin_name.required ? ew.Validators.required(fields.admin_name.caption) : null], fields.admin_name.isInvalid],
        ["operator_name", [fields.operator_name.required ? ew.Validators.required(fields.operator_name.caption) : null], fields.operator_name.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fx_transaction_statusedit,
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
    fx_transaction_statusedit.validate = function () {
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
    fx_transaction_statusedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fx_transaction_statusedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fx_transaction_statusedit");
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
<form name="fx_transaction_statusedit" id="fx_transaction_statusedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="x_transaction_status">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_x_transaction_status_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_x_transaction_status_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="x_transaction_status" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_x_transaction_status_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="x_transaction_status" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_x_transaction_status_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_x_transaction_status_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="x_transaction_status" data-field="x_name" name="x_name" id="x_name" size="30" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_x_transaction_status_name">
<span<?= $Page->name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->name->getDisplayValue($Page->name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="x_transaction_status" data-field="x_name" data-hidden="1" name="x_name" id="x_name" value="<?= HtmlEncode($Page->name->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->admin_name->Visible) { // admin_name ?>
    <div id="r_admin_name" class="form-group row">
        <label id="elh_x_transaction_status_admin_name" for="x_admin_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->admin_name->caption() ?><?= $Page->admin_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->admin_name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_x_transaction_status_admin_name">
<input type="<?= $Page->admin_name->getInputTextType() ?>" data-table="x_transaction_status" data-field="x_admin_name" name="x_admin_name" id="x_admin_name" size="30" placeholder="<?= HtmlEncode($Page->admin_name->getPlaceHolder()) ?>" value="<?= $Page->admin_name->EditValue ?>"<?= $Page->admin_name->editAttributes() ?> aria-describedby="x_admin_name_help">
<?= $Page->admin_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->admin_name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_x_transaction_status_admin_name">
<span<?= $Page->admin_name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->admin_name->getDisplayValue($Page->admin_name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="x_transaction_status" data-field="x_admin_name" data-hidden="1" name="x_admin_name" id="x_admin_name" value="<?= HtmlEncode($Page->admin_name->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->operator_name->Visible) { // operator_name ?>
    <div id="r_operator_name" class="form-group row">
        <label id="elh_x_transaction_status_operator_name" for="x_operator_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->operator_name->caption() ?><?= $Page->operator_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->operator_name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_x_transaction_status_operator_name">
<input type="<?= $Page->operator_name->getInputTextType() ?>" data-table="x_transaction_status" data-field="x_operator_name" name="x_operator_name" id="x_operator_name" size="30" placeholder="<?= HtmlEncode($Page->operator_name->getPlaceHolder()) ?>" value="<?= $Page->operator_name->EditValue ?>"<?= $Page->operator_name->editAttributes() ?> aria-describedby="x_operator_name_help">
<?= $Page->operator_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->operator_name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_x_transaction_status_operator_name">
<span<?= $Page->operator_name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->operator_name->getDisplayValue($Page->operator_name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="x_transaction_status" data-field="x_operator_name" data-hidden="1" name="x_operator_name" id="x_operator_name" value="<?= HtmlEncode($Page->operator_name->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("x_transaction_status");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

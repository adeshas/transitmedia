<?php

namespace PHPMaker2021\test;

// Page object
$ZEmailSettingsEdit = &$Page;
?>
<script>
if (!ew.vars.tables.z_email_settings) ew.vars.tables.z_email_settings = <?= JsonEncode(GetClientVar("tables", "z_email_settings")) ?>;
var currentForm, currentPageID;
var fz_email_settingsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fz_email_settingsedit = currentForm = new ew.Form("fz_email_settingsedit", "edit");

    // Add fields
    var fields = ew.vars.tables.z_email_settings.fields;
    fz_email_settingsedit.addFields([
        ["id", [fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["name", [fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["description", [fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["to_value", [fields.to_value.required ? ew.Validators.required(fields.to_value.caption) : null], fields.to_value.isInvalid],
        ["cc_value", [fields.cc_value.required ? ew.Validators.required(fields.cc_value.caption) : null], fields.cc_value.isInvalid],
        ["bcc_value", [fields.bcc_value.required ? ew.Validators.required(fields.bcc_value.caption) : null], fields.bcc_value.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fz_email_settingsedit,
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
    fz_email_settingsedit.validate = function () {
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
    fz_email_settingsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fz_email_settingsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fz_email_settingsedit");
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
<form name="fz_email_settingsedit" id="fz_email_settingsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="z_email_settings">
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
        <label id="elh_z_email_settings_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_z_email_settings_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="z_email_settings" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_z_email_settings_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="z_email_settings" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_z_email_settings_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_z_email_settings_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="z_email_settings" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_z_email_settings_name">
<span<?= $Page->name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->name->getDisplayValue($Page->name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="z_email_settings" data-field="x_name" data-hidden="1" name="x_name" id="x_name" value="<?= HtmlEncode($Page->name->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description" class="form-group row">
        <label id="elh_z_email_settings_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->description->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_z_email_settings_description">
<textarea data-table="z_email_settings" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_z_email_settings_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->ViewValue ?></span>
</span>
<input type="hidden" data-table="z_email_settings" data-field="x_description" data-hidden="1" name="x_description" id="x_description" value="<?= HtmlEncode($Page->description->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->to_value->Visible) { // to_value ?>
    <div id="r_to_value" class="form-group row">
        <label id="elh_z_email_settings_to_value" for="x_to_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->to_value->caption() ?><?= $Page->to_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->to_value->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_z_email_settings_to_value">
<textarea data-table="z_email_settings" data-field="x_to_value" name="x_to_value" id="x_to_value" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->to_value->getPlaceHolder()) ?>"<?= $Page->to_value->editAttributes() ?> aria-describedby="x_to_value_help"><?= $Page->to_value->EditValue ?></textarea>
<?= $Page->to_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->to_value->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_z_email_settings_to_value">
<span<?= $Page->to_value->viewAttributes() ?>>
<?= $Page->to_value->ViewValue ?></span>
</span>
<input type="hidden" data-table="z_email_settings" data-field="x_to_value" data-hidden="1" name="x_to_value" id="x_to_value" value="<?= HtmlEncode($Page->to_value->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cc_value->Visible) { // cc_value ?>
    <div id="r_cc_value" class="form-group row">
        <label id="elh_z_email_settings_cc_value" for="x_cc_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cc_value->caption() ?><?= $Page->cc_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->cc_value->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_z_email_settings_cc_value">
<textarea data-table="z_email_settings" data-field="x_cc_value" name="x_cc_value" id="x_cc_value" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->cc_value->getPlaceHolder()) ?>"<?= $Page->cc_value->editAttributes() ?> aria-describedby="x_cc_value_help"><?= $Page->cc_value->EditValue ?></textarea>
<?= $Page->cc_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cc_value->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_z_email_settings_cc_value">
<span<?= $Page->cc_value->viewAttributes() ?>>
<?= $Page->cc_value->ViewValue ?></span>
</span>
<input type="hidden" data-table="z_email_settings" data-field="x_cc_value" data-hidden="1" name="x_cc_value" id="x_cc_value" value="<?= HtmlEncode($Page->cc_value->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bcc_value->Visible) { // bcc_value ?>
    <div id="r_bcc_value" class="form-group row">
        <label id="elh_z_email_settings_bcc_value" for="x_bcc_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bcc_value->caption() ?><?= $Page->bcc_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bcc_value->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_z_email_settings_bcc_value">
<textarea data-table="z_email_settings" data-field="x_bcc_value" name="x_bcc_value" id="x_bcc_value" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bcc_value->getPlaceHolder()) ?>"<?= $Page->bcc_value->editAttributes() ?> aria-describedby="x_bcc_value_help"><?= $Page->bcc_value->EditValue ?></textarea>
<?= $Page->bcc_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bcc_value->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_z_email_settings_bcc_value">
<span<?= $Page->bcc_value->viewAttributes() ?>>
<?= $Page->bcc_value->ViewValue ?></span>
</span>
<input type="hidden" data-table="z_email_settings" data-field="x_bcc_value" data-hidden="1" name="x_bcc_value" id="x_bcc_value" value="<?= HtmlEncode($Page->bcc_value->FormValue) ?>">
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
    ew.addEventHandlers("z_email_settings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

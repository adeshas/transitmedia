<?php

namespace PHPMaker2021\test;

// Page object
$ZPriceSettingsEdit = &$Page;
?>
<script>
if (!ew.vars.tables.z_price_settings) ew.vars.tables.z_price_settings = <?= JsonEncode(GetClientVar("tables", "z_price_settings")) ?>;
var currentForm, currentPageID;
var fz_price_settingsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fz_price_settingsedit = currentForm = new ew.Form("fz_price_settingsedit", "edit");

    // Add fields
    var fields = ew.vars.tables.z_price_settings.fields;
    fz_price_settingsedit.addFields([
        ["id", [fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["platform_id", [fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid],
        ["inventory_id", [fields.inventory_id.required ? ew.Validators.required(fields.inventory_id.caption) : null], fields.inventory_id.isInvalid],
        ["print_stage_id", [fields.print_stage_id.required ? ew.Validators.required(fields.print_stage_id.caption) : null], fields.print_stage_id.isInvalid],
        ["bus_size_id", [fields.bus_size_id.required ? ew.Validators.required(fields.bus_size_id.caption) : null], fields.bus_size_id.isInvalid],
        ["details", [fields.details.required ? ew.Validators.required(fields.details.caption) : null], fields.details.isInvalid],
        ["max_limit", [fields.max_limit.required ? ew.Validators.required(fields.max_limit.caption) : null, ew.Validators.integer], fields.max_limit.isInvalid],
        ["min_limit", [fields.min_limit.required ? ew.Validators.required(fields.min_limit.caption) : null, ew.Validators.integer], fields.min_limit.isInvalid],
        ["price", [fields.price.required ? ew.Validators.required(fields.price.caption) : null, ew.Validators.integer], fields.price.isInvalid],
        ["operator_fee", [fields.operator_fee.required ? ew.Validators.required(fields.operator_fee.caption) : null, ew.Validators.integer], fields.operator_fee.isInvalid],
        ["agency_fee", [fields.agency_fee.required ? ew.Validators.required(fields.agency_fee.caption) : null, ew.Validators.integer], fields.agency_fee.isInvalid],
        ["lamata_fee", [fields.lamata_fee.required ? ew.Validators.required(fields.lamata_fee.caption) : null, ew.Validators.integer], fields.lamata_fee.isInvalid],
        ["lasaa_fee", [fields.lasaa_fee.required ? ew.Validators.required(fields.lasaa_fee.caption) : null, ew.Validators.integer], fields.lasaa_fee.isInvalid],
        ["printers_fee", [fields.printers_fee.required ? ew.Validators.required(fields.printers_fee.caption) : null, ew.Validators.integer], fields.printers_fee.isInvalid],
        ["active", [fields.active.required ? ew.Validators.required(fields.active.caption) : null], fields.active.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fz_price_settingsedit,
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
    fz_price_settingsedit.validate = function () {
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
    fz_price_settingsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fz_price_settingsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fz_price_settingsedit.lists.platform_id = <?= $Page->platform_id->toClientList($Page) ?>;
    fz_price_settingsedit.lists.inventory_id = <?= $Page->inventory_id->toClientList($Page) ?>;
    fz_price_settingsedit.lists.print_stage_id = <?= $Page->print_stage_id->toClientList($Page) ?>;
    fz_price_settingsedit.lists.bus_size_id = <?= $Page->bus_size_id->toClientList($Page) ?>;
    fz_price_settingsedit.lists.active = <?= $Page->active->toClientList($Page) ?>;
    loadjs.done("fz_price_settingsedit");
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
<form name="fz_price_settingsedit" id="fz_price_settingsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="z_price_settings">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_z_price_settings_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_z_price_settings_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
    <div id="r_platform_id" class="form-group row">
        <label id="elh_z_price_settings_platform_id" for="x_platform_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->platform_id->caption() ?><?= $Page->platform_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->platform_id->cellAttributes() ?>>
<span id="el_z_price_settings_platform_id">
    <select
        id="x_platform_id"
        name="x_platform_id"
        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x_platform_id"
        data-table="z_price_settings"
        data-field="x_platform_id"
        data-value-separator="<?= $Page->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->platform_id->getPlaceHolder()) ?>"
        <?= $Page->platform_id->editAttributes() ?>>
        <?= $Page->platform_id->selectOptionListHtml("x_platform_id") ?>
    </select>
    <?= $Page->platform_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage() ?></div>
<?= $Page->platform_id->Lookup->getParamTag($Page, "p_x_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x_platform_id']"),
        options = { name: "x_platform_id", selectId: "z_price_settings_x_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
    <div id="r_inventory_id" class="form-group row">
        <label id="elh_z_price_settings_inventory_id" for="x_inventory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->inventory_id->caption() ?><?= $Page->inventory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->inventory_id->cellAttributes() ?>>
<span id="el_z_price_settings_inventory_id">
    <select
        id="x_inventory_id"
        name="x_inventory_id"
        class="form-control ew-select<?= $Page->inventory_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x_inventory_id"
        data-table="z_price_settings"
        data-field="x_inventory_id"
        data-value-separator="<?= $Page->inventory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->inventory_id->getPlaceHolder()) ?>"
        <?= $Page->inventory_id->editAttributes() ?>>
        <?= $Page->inventory_id->selectOptionListHtml("x_inventory_id") ?>
    </select>
    <?= $Page->inventory_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->inventory_id->getErrorMessage() ?></div>
<?= $Page->inventory_id->Lookup->getParamTag($Page, "p_x_inventory_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x_inventory_id']"),
        options = { name: "x_inventory_id", selectId: "z_price_settings_x_inventory_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.inventory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->print_stage_id->Visible) { // print_stage_id ?>
    <div id="r_print_stage_id" class="form-group row">
        <label id="elh_z_price_settings_print_stage_id" for="x_print_stage_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->print_stage_id->caption() ?><?= $Page->print_stage_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->print_stage_id->cellAttributes() ?>>
<span id="el_z_price_settings_print_stage_id">
    <select
        id="x_print_stage_id"
        name="x_print_stage_id"
        class="form-control ew-select<?= $Page->print_stage_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x_print_stage_id"
        data-table="z_price_settings"
        data-field="x_print_stage_id"
        data-value-separator="<?= $Page->print_stage_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->print_stage_id->getPlaceHolder()) ?>"
        <?= $Page->print_stage_id->editAttributes() ?>>
        <?= $Page->print_stage_id->selectOptionListHtml("x_print_stage_id") ?>
    </select>
    <?= $Page->print_stage_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->print_stage_id->getErrorMessage() ?></div>
<?= $Page->print_stage_id->Lookup->getParamTag($Page, "p_x_print_stage_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x_print_stage_id']"),
        options = { name: "x_print_stage_id", selectId: "z_price_settings_x_print_stage_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.print_stage_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
    <div id="r_bus_size_id" class="form-group row">
        <label id="elh_z_price_settings_bus_size_id" for="x_bus_size_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bus_size_id->caption() ?><?= $Page->bus_size_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bus_size_id->cellAttributes() ?>>
<span id="el_z_price_settings_bus_size_id">
    <select
        id="x_bus_size_id"
        name="x_bus_size_id"
        class="form-control ew-select<?= $Page->bus_size_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x_bus_size_id"
        data-table="z_price_settings"
        data-field="x_bus_size_id"
        data-value-separator="<?= $Page->bus_size_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_size_id->getPlaceHolder()) ?>"
        <?= $Page->bus_size_id->editAttributes() ?>>
        <?= $Page->bus_size_id->selectOptionListHtml("x_bus_size_id") ?>
    </select>
    <?= $Page->bus_size_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->bus_size_id->getErrorMessage() ?></div>
<?= $Page->bus_size_id->Lookup->getParamTag($Page, "p_x_bus_size_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x_bus_size_id']"),
        options = { name: "x_bus_size_id", selectId: "z_price_settings_x_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->details->Visible) { // details ?>
    <div id="r_details" class="form-group row">
        <label id="elh_z_price_settings_details" for="x_details" class="<?= $Page->LeftColumnClass ?>"><?= $Page->details->caption() ?><?= $Page->details->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->details->cellAttributes() ?>>
<span id="el_z_price_settings_details">
<textarea data-table="z_price_settings" data-field="x_details" name="x_details" id="x_details" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->details->getPlaceHolder()) ?>"<?= $Page->details->editAttributes() ?> aria-describedby="x_details_help"><?= $Page->details->EditValue ?></textarea>
<?= $Page->details->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->details->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->max_limit->Visible) { // max_limit ?>
    <div id="r_max_limit" class="form-group row">
        <label id="elh_z_price_settings_max_limit" for="x_max_limit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->max_limit->caption() ?><?= $Page->max_limit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->max_limit->cellAttributes() ?>>
<span id="el_z_price_settings_max_limit">
<input type="<?= $Page->max_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_max_limit" name="x_max_limit" id="x_max_limit" size="30" placeholder="<?= HtmlEncode($Page->max_limit->getPlaceHolder()) ?>" value="<?= $Page->max_limit->EditValue ?>"<?= $Page->max_limit->editAttributes() ?> aria-describedby="x_max_limit_help">
<?= $Page->max_limit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->max_limit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->min_limit->Visible) { // min_limit ?>
    <div id="r_min_limit" class="form-group row">
        <label id="elh_z_price_settings_min_limit" for="x_min_limit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->min_limit->caption() ?><?= $Page->min_limit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->min_limit->cellAttributes() ?>>
<span id="el_z_price_settings_min_limit">
<input type="<?= $Page->min_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_min_limit" name="x_min_limit" id="x_min_limit" size="30" placeholder="<?= HtmlEncode($Page->min_limit->getPlaceHolder()) ?>" value="<?= $Page->min_limit->EditValue ?>"<?= $Page->min_limit->editAttributes() ?> aria-describedby="x_min_limit_help">
<?= $Page->min_limit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->min_limit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
    <div id="r_price" class="form-group row">
        <label id="elh_z_price_settings_price" for="x_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->price->caption() ?><?= $Page->price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->price->cellAttributes() ?>>
<span id="el_z_price_settings_price">
<input type="<?= $Page->price->getInputTextType() ?>" data-table="z_price_settings" data-field="x_price" name="x_price" id="x_price" size="30" placeholder="<?= HtmlEncode($Page->price->getPlaceHolder()) ?>" value="<?= $Page->price->EditValue ?>"<?= $Page->price->editAttributes() ?> aria-describedby="x_price_help">
<?= $Page->price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->operator_fee->Visible) { // operator_fee ?>
    <div id="r_operator_fee" class="form-group row">
        <label id="elh_z_price_settings_operator_fee" for="x_operator_fee" class="<?= $Page->LeftColumnClass ?>"><?= $Page->operator_fee->caption() ?><?= $Page->operator_fee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->operator_fee->cellAttributes() ?>>
<span id="el_z_price_settings_operator_fee">
<input type="<?= $Page->operator_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_operator_fee" name="x_operator_fee" id="x_operator_fee" size="30" placeholder="<?= HtmlEncode($Page->operator_fee->getPlaceHolder()) ?>" value="<?= $Page->operator_fee->EditValue ?>"<?= $Page->operator_fee->editAttributes() ?> aria-describedby="x_operator_fee_help">
<?= $Page->operator_fee->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->operator_fee->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->agency_fee->Visible) { // agency_fee ?>
    <div id="r_agency_fee" class="form-group row">
        <label id="elh_z_price_settings_agency_fee" for="x_agency_fee" class="<?= $Page->LeftColumnClass ?>"><?= $Page->agency_fee->caption() ?><?= $Page->agency_fee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->agency_fee->cellAttributes() ?>>
<span id="el_z_price_settings_agency_fee">
<input type="<?= $Page->agency_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_agency_fee" name="x_agency_fee" id="x_agency_fee" size="30" placeholder="<?= HtmlEncode($Page->agency_fee->getPlaceHolder()) ?>" value="<?= $Page->agency_fee->EditValue ?>"<?= $Page->agency_fee->editAttributes() ?> aria-describedby="x_agency_fee_help">
<?= $Page->agency_fee->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->agency_fee->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
    <div id="r_lamata_fee" class="form-group row">
        <label id="elh_z_price_settings_lamata_fee" for="x_lamata_fee" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lamata_fee->caption() ?><?= $Page->lamata_fee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lamata_fee->cellAttributes() ?>>
<span id="el_z_price_settings_lamata_fee">
<input type="<?= $Page->lamata_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lamata_fee" name="x_lamata_fee" id="x_lamata_fee" size="30" placeholder="<?= HtmlEncode($Page->lamata_fee->getPlaceHolder()) ?>" value="<?= $Page->lamata_fee->EditValue ?>"<?= $Page->lamata_fee->editAttributes() ?> aria-describedby="x_lamata_fee_help">
<?= $Page->lamata_fee->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lamata_fee->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
    <div id="r_lasaa_fee" class="form-group row">
        <label id="elh_z_price_settings_lasaa_fee" for="x_lasaa_fee" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lasaa_fee->caption() ?><?= $Page->lasaa_fee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lasaa_fee->cellAttributes() ?>>
<span id="el_z_price_settings_lasaa_fee">
<input type="<?= $Page->lasaa_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lasaa_fee" name="x_lasaa_fee" id="x_lasaa_fee" size="30" placeholder="<?= HtmlEncode($Page->lasaa_fee->getPlaceHolder()) ?>" value="<?= $Page->lasaa_fee->EditValue ?>"<?= $Page->lasaa_fee->editAttributes() ?> aria-describedby="x_lasaa_fee_help">
<?= $Page->lasaa_fee->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lasaa_fee->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->printers_fee->Visible) { // printers_fee ?>
    <div id="r_printers_fee" class="form-group row">
        <label id="elh_z_price_settings_printers_fee" for="x_printers_fee" class="<?= $Page->LeftColumnClass ?>"><?= $Page->printers_fee->caption() ?><?= $Page->printers_fee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->printers_fee->cellAttributes() ?>>
<span id="el_z_price_settings_printers_fee">
<input type="<?= $Page->printers_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_printers_fee" name="x_printers_fee" id="x_printers_fee" size="30" placeholder="<?= HtmlEncode($Page->printers_fee->getPlaceHolder()) ?>" value="<?= $Page->printers_fee->EditValue ?>"<?= $Page->printers_fee->editAttributes() ?> aria-describedby="x_printers_fee_help">
<?= $Page->printers_fee->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->printers_fee->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <div id="r_active" class="form-group row">
        <label id="elh_z_price_settings_active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active->caption() ?><?= $Page->active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->active->cellAttributes() ?>>
<span id="el_z_price_settings_active">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->active->isInvalidClass() ?>" data-table="z_price_settings" data-field="x_active" name="x_active[]" id="x_active_520995" value="1"<?= ConvertToBool($Page->active->CurrentValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?> aria-describedby="x_active_help">
    <label class="custom-control-label" for="x_active_520995"></label>
</div>
<?= $Page->active->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= GetUrl($Page->getReturnUrl()) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("z_price_settings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

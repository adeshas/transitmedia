<?php

namespace PHPMaker2021\test;

// Page object
$SubMediaAllocationAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsub_media_allocationadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsub_media_allocationadd = currentForm = new ew.Form("fsub_media_allocationadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sub_media_allocation")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sub_media_allocation)
        ew.vars.tables.sub_media_allocation = currentTable;
    fsub_media_allocationadd.addFields([
        ["bus_id", [fields.bus_id.visible && fields.bus_id.required ? ew.Validators.required(fields.bus_id.caption) : null], fields.bus_id.isInvalid],
        ["campaign_id", [fields.campaign_id.visible && fields.campaign_id.required ? ew.Validators.required(fields.campaign_id.caption) : null], fields.campaign_id.isInvalid],
        ["active", [fields.active.visible && fields.active.required ? ew.Validators.required(fields.active.caption) : null], fields.active.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid],
        ["ts_created", [fields.ts_created.visible && fields.ts_created.required ? ew.Validators.required(fields.ts_created.caption) : null, ew.Validators.datetime(0)], fields.ts_created.isInvalid],
        ["ts_last_update", [fields.ts_last_update.visible && fields.ts_last_update.required ? ew.Validators.required(fields.ts_last_update.caption) : null, ew.Validators.datetime(0)], fields.ts_last_update.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsub_media_allocationadd,
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
    fsub_media_allocationadd.validate = function () {
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
    fsub_media_allocationadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_media_allocationadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsub_media_allocationadd.lists.bus_id = <?= $Page->bus_id->toClientList($Page) ?>;
    fsub_media_allocationadd.lists.campaign_id = <?= $Page->campaign_id->toClientList($Page) ?>;
    fsub_media_allocationadd.lists.active = <?= $Page->active->toClientList($Page) ?>;
    loadjs.done("fsub_media_allocationadd");
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
<form name="fsub_media_allocationadd" id="fsub_media_allocationadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_media_allocation">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "main_campaigns") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_campaigns">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->campaign_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "main_buses") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_buses">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->bus_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->bus_id->Visible) { // bus_id ?>
    <div id="r_bus_id" class="form-group row">
        <label id="elh_sub_media_allocation_bus_id" for="x_bus_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bus_id->caption() ?><?= $Page->bus_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bus_id->cellAttributes() ?>>
<?php if ($Page->bus_id->getSessionValue() != "") { ?>
<span id="el_sub_media_allocation_bus_id">
<span<?= $Page->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_id->getDisplayValue($Page->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_bus_id" name="x_bus_id" value="<?= HtmlEncode($Page->bus_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_sub_media_allocation_bus_id">
    <select
        id="x_bus_id"
        name="x_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x_bus_id"
        data-table="sub_media_allocation"
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
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x_bus_id']"),
        options = { name: "x_bus_id", selectId: "sub_media_allocation_x_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <div id="r_campaign_id" class="form-group row">
        <label id="elh_sub_media_allocation_campaign_id" for="x_campaign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->campaign_id->caption() ?><?= $Page->campaign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign_id->cellAttributes() ?>>
<?php if ($Page->campaign_id->getSessionValue() != "") { ?>
<span id="el_sub_media_allocation_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_campaign_id" name="x_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_sub_media_allocation_campaign_id">
    <select
        id="x_campaign_id"
        name="x_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x_campaign_id"
        data-table="sub_media_allocation"
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
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x_campaign_id']"),
        options = { name: "x_campaign_id", selectId: "sub_media_allocation_x_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <div id="r_active" class="form-group row">
        <label id="elh_sub_media_allocation_active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active->caption() ?><?= $Page->active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->active->cellAttributes() ?>>
<span id="el_sub_media_allocation_active">
    <select
        id="x_active"
        name="x_active"
        class="form-control ew-select<?= $Page->active->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x_active"
        data-table="sub_media_allocation"
        data-field="x_active"
        data-dropdown
        data-value-separator="<?= $Page->active->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->active->getPlaceHolder()) ?>"
        <?= $Page->active->editAttributes() ?>>
        <?= $Page->active->selectOptionListHtml("x_active") ?>
    </select>
    <?= $Page->active->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x_active']"),
        options = { name: "x_active", selectId: "sub_media_allocation_x_active", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.sub_media_allocation.fields.active.lookupOptions;
    options.columns = el.dataset.repeatcolumn || 5;
    options.dropdown = !ew.IS_MOBILE && options.columns > 0; // Use custom dropdown
    if (options.dropdown) {
        options.dropdownAutoWidth = true;
        options.dropdownCssClass = "ew-select-dropdown ew-select-one";
        if (options.columns > 1)
            options.dropdownCssClass += " ew-repeat-column";
    }
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.active.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <div id="r_created_by" class="form-group row">
        <label id="elh_sub_media_allocation_created_by" for="x_created_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_by->caption() ?><?= $Page->created_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_by->cellAttributes() ?>>
<span id="el_sub_media_allocation_created_by">
    <select
        id="x_created_by"
        name="x_created_by"
        class="form-control ew-select<?= $Page->created_by->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x_created_by"
        data-table="sub_media_allocation"
        data-field="x_created_by"
        data-value-separator="<?= $Page->created_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>"
        <?= $Page->created_by->editAttributes() ?>>
        <?= $Page->created_by->selectOptionListHtml("x_created_by") ?>
    </select>
    <?= $Page->created_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->created_by->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x_created_by']"),
        options = { name: "x_created_by", selectId: "sub_media_allocation_x_created_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.created_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <div id="r_ts_created" class="form-group row">
        <label id="elh_sub_media_allocation_ts_created" for="x_ts_created" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ts_created->caption() ?><?= $Page->ts_created->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ts_created->cellAttributes() ?>>
<span id="el_sub_media_allocation_ts_created">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_created" name="x_ts_created" id="x_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?> aria-describedby="x_ts_created_help">
<?= $Page->ts_created->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationadd", "x_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
    <div id="r_ts_last_update" class="form-group row">
        <label id="elh_sub_media_allocation_ts_last_update" for="x_ts_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ts_last_update->caption() ?><?= $Page->ts_last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ts_last_update->cellAttributes() ?>>
<span id="el_sub_media_allocation_ts_last_update">
<input type="<?= $Page->ts_last_update->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_last_update" name="x_ts_last_update" id="x_ts_last_update" placeholder="<?= HtmlEncode($Page->ts_last_update->getPlaceHolder()) ?>" value="<?= $Page->ts_last_update->EditValue ?>"<?= $Page->ts_last_update->editAttributes() ?> aria-describedby="x_ts_last_update_help">
<?= $Page->ts_last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Page->ts_last_update->ReadOnly && !$Page->ts_last_update->Disabled && !isset($Page->ts_last_update->EditAttrs["readonly"]) && !isset($Page->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationadd", "x_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sub_media_allocation");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

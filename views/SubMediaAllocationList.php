<?php

namespace PHPMaker2021\test;

// Page object
$SubMediaAllocationList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsub_media_allocationlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fsub_media_allocationlist = currentForm = new ew.Form("fsub_media_allocationlist", "list");
    fsub_media_allocationlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sub_media_allocation")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sub_media_allocation)
        ew.vars.tables.sub_media_allocation = currentTable;
    fsub_media_allocationlist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["bus_id", [fields.bus_id.visible && fields.bus_id.required ? ew.Validators.required(fields.bus_id.caption) : null], fields.bus_id.isInvalid],
        ["campaign_id", [fields.campaign_id.visible && fields.campaign_id.required ? ew.Validators.required(fields.campaign_id.caption) : null], fields.campaign_id.isInvalid],
        ["active", [fields.active.visible && fields.active.required ? ew.Validators.required(fields.active.caption) : null], fields.active.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid],
        ["ts_created", [fields.ts_created.visible && fields.ts_created.required ? ew.Validators.required(fields.ts_created.caption) : null, ew.Validators.datetime(0)], fields.ts_created.isInvalid],
        ["ts_last_update", [fields.ts_last_update.visible && fields.ts_last_update.required ? ew.Validators.required(fields.ts_last_update.caption) : null, ew.Validators.datetime(0)], fields.ts_last_update.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsub_media_allocationlist,
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
    fsub_media_allocationlist.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        if (gridinsert && addcnt == 0) { // No row added
            ew.alert(ew.language.phrase("NoAddRecord"));
            return false;
        }
        return true;
    }

    // Check empty row
    fsub_media_allocationlist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "bus_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "campaign_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "active", true))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "created_by", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ts_created", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ts_last_update", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsub_media_allocationlist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_media_allocationlist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsub_media_allocationlist.lists.bus_id = <?= $Page->bus_id->toClientList($Page) ?>;
    fsub_media_allocationlist.lists.campaign_id = <?= $Page->campaign_id->toClientList($Page) ?>;
    fsub_media_allocationlist.lists.active = <?= $Page->active->toClientList($Page) ?>;
    loadjs.done("fsub_media_allocationlist");
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
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "main_campaigns") {
    if ($Page->MasterRecordExists) {
        include_once "views/MainCampaignsMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "main_buses") {
    if ($Page->MasterRecordExists) {
        include_once "views/MainBusesMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> sub_media_allocation">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fsub_media_allocationlist" id="fsub_media_allocationlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_media_allocation">
<?php if ($Page->getCurrentMasterTable() == "main_campaigns" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_campaigns">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->campaign_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "main_buses" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_buses">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->bus_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_sub_media_allocation" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_sub_media_allocationlist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_sub_media_allocation_id" class="sub_media_allocation_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->bus_id->Visible) { // bus_id ?>
        <th data-name="bus_id" class="<?= $Page->bus_id->headerCellClass() ?>"><div id="elh_sub_media_allocation_bus_id" class="sub_media_allocation_bus_id"><?= $Page->renderSort($Page->bus_id) ?></div></th>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <th data-name="campaign_id" class="<?= $Page->campaign_id->headerCellClass() ?>"><div id="elh_sub_media_allocation_campaign_id" class="sub_media_allocation_campaign_id"><?= $Page->renderSort($Page->campaign_id) ?></div></th>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <th data-name="active" class="<?= $Page->active->headerCellClass() ?>"><div id="elh_sub_media_allocation_active" class="sub_media_allocation_active"><?= $Page->renderSort($Page->active) ?></div></th>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <th data-name="created_by" class="<?= $Page->created_by->headerCellClass() ?>"><div id="elh_sub_media_allocation_created_by" class="sub_media_allocation_created_by"><?= $Page->renderSort($Page->created_by) ?></div></th>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
        <th data-name="ts_created" class="<?= $Page->ts_created->headerCellClass() ?>"><div id="elh_sub_media_allocation_ts_created" class="sub_media_allocation_ts_created"><?= $Page->renderSort($Page->ts_created) ?></div></th>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
        <th data-name="ts_last_update" class="<?= $Page->ts_last_update->headerCellClass() ?>"><div id="elh_sub_media_allocation_ts_last_update" class="sub_media_allocation_ts_last_update"><?= $Page->renderSort($Page->ts_last_update) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
    if ($Page->isAdd() || $Page->isCopy()) {
        $Page->RowIndex = 0;
        $Page->KeyCount = $Page->RowIndex;
        if ($Page->isCopy() && !$Page->loadRow())
            $Page->CurrentAction = "add";
        if ($Page->isAdd())
            $Page->loadRowValues();
        if ($Page->EventCancelled) // Insert failed
            $Page->restoreFormValues(); // Restore form values

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_sub_media_allocation", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_id" class="form-group sub_media_allocation_id"></span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id">
<?php if ($Page->bus_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_bus_id" class="form-group sub_media_allocation_bus_id">
<span<?= $Page->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_id->getDisplayValue($Page->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_bus_id" name="x<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_bus_id" class="form-group sub_media_allocation_bus_id">
    <select
        id="x<?= $Page->RowIndex ?>_bus_id"
        name="x<?= $Page->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id"
        data-table="sub_media_allocation"
        data-field="x_bus_id"
        data-value-separator="<?= $Page->bus_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_id->getPlaceHolder()) ?>"
        <?= $Page->bus_id->editAttributes() ?>>
        <?= $Page->bus_id->selectOptionListHtml("x{$Page->RowIndex}_bus_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_id->getErrorMessage() ?></div>
<?= $Page->bus_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_id", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_bus_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_id" id="o<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id">
<?php if ($Page->campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_campaign_id" class="form-group sub_media_allocation_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_campaign_id" name="x<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_campaign_id" class="form-group sub_media_allocation_campaign_id">
    <select
        id="x<?= $Page->RowIndex ?>_campaign_id"
        name="x<?= $Page->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id"
        data-table="sub_media_allocation"
        data-field="x_campaign_id"
        data-value-separator="<?= $Page->campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->campaign_id->getPlaceHolder()) ?>"
        <?= $Page->campaign_id->editAttributes() ?>>
        <?= $Page->campaign_id->selectOptionListHtml("x{$Page->RowIndex}_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->campaign_id->getErrorMessage() ?></div>
<?= $Page->campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_campaign_id", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_campaign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_campaign_id" id="o<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->active->Visible) { // active ?>
        <td data-name="active">
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_active" class="form-group sub_media_allocation_active">
    <select
        id="x<?= $Page->RowIndex ?>_active"
        name="x<?= $Page->RowIndex ?>_active"
        class="form-control ew-select<?= $Page->active->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_active"
        data-table="sub_media_allocation"
        data-field="x_active"
        data-dropdown
        data-value-separator="<?= $Page->active->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->active->getPlaceHolder()) ?>"
        <?= $Page->active->editAttributes() ?>>
        <?= $Page->active->selectOptionListHtml("x{$Page->RowIndex}_active") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_active']"),
        options = { name: "x<?= $Page->RowIndex ?>_active", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_active", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
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
<input type="hidden" data-table="sub_media_allocation" data-field="x_active" data-hidden="1" name="o<?= $Page->RowIndex ?>_active" id="o<?= $Page->RowIndex ?>_active" value="<?= HtmlEncode($Page->active->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->created_by->Visible) { // created_by ?>
        <td data-name="created_by">
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_created_by" class="form-group sub_media_allocation_created_by">
    <select
        id="x<?= $Page->RowIndex ?>_created_by"
        name="x<?= $Page->RowIndex ?>_created_by"
        class="form-control ew-select<?= $Page->created_by->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_created_by"
        data-table="sub_media_allocation"
        data-field="x_created_by"
        data-value-separator="<?= $Page->created_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>"
        <?= $Page->created_by->editAttributes() ?>>
        <?= $Page->created_by->selectOptionListHtml("x{$Page->RowIndex}_created_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->created_by->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_created_by']"),
        options = { name: "x<?= $Page->RowIndex ?>_created_by", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_created_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.created_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_created_by" data-hidden="1" name="o<?= $Page->RowIndex ?>_created_by" id="o<?= $Page->RowIndex ?>_created_by" value="<?= HtmlEncode($Page->created_by->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ts_created->Visible) { // ts_created ?>
        <td data-name="ts_created">
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_ts_created" class="form-group sub_media_allocation_ts_created">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_created" name="x<?= $Page->RowIndex ?>_ts_created" id="x<?= $Page->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationlist", "x<?= $Page->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_created" data-hidden="1" name="o<?= $Page->RowIndex ?>_ts_created" id="o<?= $Page->RowIndex ?>_ts_created" value="<?= HtmlEncode($Page->ts_created->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
        <td data-name="ts_last_update">
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_ts_last_update" class="form-group sub_media_allocation_ts_last_update">
<input type="<?= $Page->ts_last_update->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_last_update" name="x<?= $Page->RowIndex ?>_ts_last_update" id="x<?= $Page->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Page->ts_last_update->getPlaceHolder()) ?>" value="<?= $Page->ts_last_update->EditValue ?>"<?= $Page->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Page->ts_last_update->ReadOnly && !$Page->ts_last_update->Disabled && !isset($Page->ts_last_update->EditAttrs["readonly"]) && !isset($Page->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationlist", "x<?= $Page->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_last_update" data-hidden="1" name="o<?= $Page->RowIndex ?>_ts_last_update" id="o<?= $Page->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Page->ts_last_update->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fsub_media_allocationlist","load"], function() {
    fsub_media_allocationlist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
$Page->EditRowCount = 0;
if ($Page->isEdit())
    $Page->RowIndex = 1;
if ($Page->isGridAdd())
    $Page->RowIndex = 0;
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;
        if ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm()) {
            $Page->RowIndex++;
            $CurrentForm->Index = $Page->RowIndex;
            if ($CurrentForm->hasValue($Page->FormActionName) && ($Page->isConfirm() || $Page->EventCancelled)) {
                $Page->RowAction = strval($CurrentForm->getValue($Page->FormActionName));
            } elseif ($Page->isGridAdd()) {
                $Page->RowAction = "insert";
            } else {
                $Page->RowAction = "";
            }
        }

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view
        if ($Page->isGridAdd()) { // Grid add
            $Page->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Page->isGridAdd() && $Page->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->isEdit()) {
            if ($Page->checkInlineEditKey() && $Page->EditRowCount == 0) { // Inline edit
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isEdit() && $Page->RowType == ROWTYPE_EDIT && $Page->EventCancelled) { // Update failed
            $CurrentForm->Index = 1;
            $Page->restoreFormValues(); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_sub_media_allocation", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Page->RowAction != "delete" && $Page->RowAction != "insertdelete" && !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_id" class="form-group"></span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_id" class="form-group">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id" <?= $Page->bus_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->bus_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_bus_id" class="form-group">
<span<?= $Page->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_id->getDisplayValue($Page->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_bus_id" name="x<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_bus_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_id"
        name="x<?= $Page->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id"
        data-table="sub_media_allocation"
        data-field="x_bus_id"
        data-value-separator="<?= $Page->bus_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_id->getPlaceHolder()) ?>"
        <?= $Page->bus_id->editAttributes() ?>>
        <?= $Page->bus_id->selectOptionListHtml("x{$Page->RowIndex}_bus_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_id->getErrorMessage() ?></div>
<?= $Page->bus_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_id", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_bus_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_id" id="o<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->bus_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_bus_id" class="form-group">
<span<?= $Page->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_id->getDisplayValue($Page->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_bus_id" name="x<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_bus_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_id"
        name="x<?= $Page->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id"
        data-table="sub_media_allocation"
        data-field="x_bus_id"
        data-value-separator="<?= $Page->bus_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_id->getPlaceHolder()) ?>"
        <?= $Page->bus_id->editAttributes() ?>>
        <?= $Page->bus_id->selectOptionListHtml("x{$Page->RowIndex}_bus_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_id->getErrorMessage() ?></div>
<?= $Page->bus_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_id", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_bus_id">
<span<?= $Page->bus_id->viewAttributes() ?>>
<?= $Page->bus_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id" <?= $Page->campaign_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_campaign_id" class="form-group">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_campaign_id" name="x<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_campaign_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_campaign_id"
        name="x<?= $Page->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id"
        data-table="sub_media_allocation"
        data-field="x_campaign_id"
        data-value-separator="<?= $Page->campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->campaign_id->getPlaceHolder()) ?>"
        <?= $Page->campaign_id->editAttributes() ?>>
        <?= $Page->campaign_id->selectOptionListHtml("x{$Page->RowIndex}_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->campaign_id->getErrorMessage() ?></div>
<?= $Page->campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_campaign_id", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_campaign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_campaign_id" id="o<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_campaign_id" class="form-group">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_campaign_id" name="x<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_campaign_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_campaign_id"
        name="x<?= $Page->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id"
        data-table="sub_media_allocation"
        data-field="x_campaign_id"
        data-value-separator="<?= $Page->campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->campaign_id->getPlaceHolder()) ?>"
        <?= $Page->campaign_id->editAttributes() ?>>
        <?= $Page->campaign_id->selectOptionListHtml("x{$Page->RowIndex}_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->campaign_id->getErrorMessage() ?></div>
<?= $Page->campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_campaign_id", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->active->Visible) { // active ?>
        <td data-name="active" <?= $Page->active->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_active" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_active"
        name="x<?= $Page->RowIndex ?>_active"
        class="form-control ew-select<?= $Page->active->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_active"
        data-table="sub_media_allocation"
        data-field="x_active"
        data-dropdown
        data-value-separator="<?= $Page->active->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->active->getPlaceHolder()) ?>"
        <?= $Page->active->editAttributes() ?>>
        <?= $Page->active->selectOptionListHtml("x{$Page->RowIndex}_active") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_active']"),
        options = { name: "x<?= $Page->RowIndex ?>_active", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_active", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
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
<input type="hidden" data-table="sub_media_allocation" data-field="x_active" data-hidden="1" name="o<?= $Page->RowIndex ?>_active" id="o<?= $Page->RowIndex ?>_active" value="<?= HtmlEncode($Page->active->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_active" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_active"
        name="x<?= $Page->RowIndex ?>_active"
        class="form-control ew-select<?= $Page->active->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_active"
        data-table="sub_media_allocation"
        data-field="x_active"
        data-dropdown
        data-value-separator="<?= $Page->active->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->active->getPlaceHolder()) ?>"
        <?= $Page->active->editAttributes() ?>>
        <?= $Page->active->selectOptionListHtml("x{$Page->RowIndex}_active") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_active']"),
        options = { name: "x<?= $Page->RowIndex ?>_active", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_active", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
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
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_active">
<span<?= $Page->active->viewAttributes() ?>>
<?= $Page->active->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->created_by->Visible) { // created_by ?>
        <td data-name="created_by" <?= $Page->created_by->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_created_by" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_created_by"
        name="x<?= $Page->RowIndex ?>_created_by"
        class="form-control ew-select<?= $Page->created_by->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_created_by"
        data-table="sub_media_allocation"
        data-field="x_created_by"
        data-value-separator="<?= $Page->created_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>"
        <?= $Page->created_by->editAttributes() ?>>
        <?= $Page->created_by->selectOptionListHtml("x{$Page->RowIndex}_created_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->created_by->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_created_by']"),
        options = { name: "x<?= $Page->RowIndex ?>_created_by", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_created_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.created_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_created_by" data-hidden="1" name="o<?= $Page->RowIndex ?>_created_by" id="o<?= $Page->RowIndex ?>_created_by" value="<?= HtmlEncode($Page->created_by->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_created_by" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_created_by"
        name="x<?= $Page->RowIndex ?>_created_by"
        class="form-control ew-select<?= $Page->created_by->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_created_by"
        data-table="sub_media_allocation"
        data-field="x_created_by"
        data-value-separator="<?= $Page->created_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>"
        <?= $Page->created_by->editAttributes() ?>>
        <?= $Page->created_by->selectOptionListHtml("x{$Page->RowIndex}_created_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->created_by->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_created_by']"),
        options = { name: "x<?= $Page->RowIndex ?>_created_by", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_created_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.created_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ts_created->Visible) { // ts_created ?>
        <td data-name="ts_created" <?= $Page->ts_created->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_ts_created" class="form-group">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_created" name="x<?= $Page->RowIndex ?>_ts_created" id="x<?= $Page->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationlist", "x<?= $Page->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_created" data-hidden="1" name="o<?= $Page->RowIndex ?>_ts_created" id="o<?= $Page->RowIndex ?>_ts_created" value="<?= HtmlEncode($Page->ts_created->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_ts_created" class="form-group">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_created" name="x<?= $Page->RowIndex ?>_ts_created" id="x<?= $Page->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationlist", "x<?= $Page->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
        <td data-name="ts_last_update" <?= $Page->ts_last_update->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_ts_last_update" class="form-group">
<input type="<?= $Page->ts_last_update->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_last_update" name="x<?= $Page->RowIndex ?>_ts_last_update" id="x<?= $Page->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Page->ts_last_update->getPlaceHolder()) ?>" value="<?= $Page->ts_last_update->EditValue ?>"<?= $Page->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Page->ts_last_update->ReadOnly && !$Page->ts_last_update->Disabled && !isset($Page->ts_last_update->EditAttrs["readonly"]) && !isset($Page->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationlist", "x<?= $Page->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_last_update" data-hidden="1" name="o<?= $Page->RowIndex ?>_ts_last_update" id="o<?= $Page->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Page->ts_last_update->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_ts_last_update" class="form-group">
<input type="<?= $Page->ts_last_update->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_last_update" name="x<?= $Page->RowIndex ?>_ts_last_update" id="x<?= $Page->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Page->ts_last_update->getPlaceHolder()) ?>" value="<?= $Page->ts_last_update->EditValue ?>"<?= $Page->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Page->ts_last_update->ReadOnly && !$Page->ts_last_update->Disabled && !isset($Page->ts_last_update->EditAttrs["readonly"]) && !isset($Page->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationlist", "x<?= $Page->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_media_allocation_ts_last_update">
<span<?= $Page->ts_last_update->viewAttributes() ?>>
<?= $Page->ts_last_update->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fsub_media_allocationlist","load"], function () {
    fsub_media_allocationlist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Page->isGridAdd())
        if (!$Page->Recordset->EOF) {
            $Page->Recordset->moveNext();
        }
}
?>
<?php
    if ($Page->isGridAdd() || $Page->isGridEdit()) {
        $Page->RowIndex = '$rowindex$';
        $Page->loadRowValues();

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_sub_media_allocation", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowAttrs->appendClass("ew-template");
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowIndex);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el$rowindex$_sub_media_allocation_id" class="form-group sub_media_allocation_id"></span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id">
<?php if ($Page->bus_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_sub_media_allocation_bus_id" class="form-group sub_media_allocation_bus_id">
<span<?= $Page->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_id->getDisplayValue($Page->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_bus_id" name="x<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_bus_id" class="form-group sub_media_allocation_bus_id">
    <select
        id="x<?= $Page->RowIndex ?>_bus_id"
        name="x<?= $Page->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id"
        data-table="sub_media_allocation"
        data-field="x_bus_id"
        data-value-separator="<?= $Page->bus_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_id->getPlaceHolder()) ?>"
        <?= $Page->bus_id->editAttributes() ?>>
        <?= $Page->bus_id->selectOptionListHtml("x{$Page->RowIndex}_bus_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_id->getErrorMessage() ?></div>
<?= $Page->bus_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_id", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_bus_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_id" id="o<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id">
<?php if ($Page->campaign_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_sub_media_allocation_campaign_id" class="form-group sub_media_allocation_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_campaign_id" name="x<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_campaign_id" class="form-group sub_media_allocation_campaign_id">
    <select
        id="x<?= $Page->RowIndex ?>_campaign_id"
        name="x<?= $Page->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id"
        data-table="sub_media_allocation"
        data-field="x_campaign_id"
        data-value-separator="<?= $Page->campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->campaign_id->getPlaceHolder()) ?>"
        <?= $Page->campaign_id->editAttributes() ?>>
        <?= $Page->campaign_id->selectOptionListHtml("x{$Page->RowIndex}_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->campaign_id->getErrorMessage() ?></div>
<?= $Page->campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_campaign_id", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_campaign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_campaign_id" id="o<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->active->Visible) { // active ?>
        <td data-name="active">
<span id="el$rowindex$_sub_media_allocation_active" class="form-group sub_media_allocation_active">
    <select
        id="x<?= $Page->RowIndex ?>_active"
        name="x<?= $Page->RowIndex ?>_active"
        class="form-control ew-select<?= $Page->active->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_active"
        data-table="sub_media_allocation"
        data-field="x_active"
        data-dropdown
        data-value-separator="<?= $Page->active->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->active->getPlaceHolder()) ?>"
        <?= $Page->active->editAttributes() ?>>
        <?= $Page->active->selectOptionListHtml("x{$Page->RowIndex}_active") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_active']"),
        options = { name: "x<?= $Page->RowIndex ?>_active", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_active", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
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
<input type="hidden" data-table="sub_media_allocation" data-field="x_active" data-hidden="1" name="o<?= $Page->RowIndex ?>_active" id="o<?= $Page->RowIndex ?>_active" value="<?= HtmlEncode($Page->active->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->created_by->Visible) { // created_by ?>
        <td data-name="created_by">
<span id="el$rowindex$_sub_media_allocation_created_by" class="form-group sub_media_allocation_created_by">
    <select
        id="x<?= $Page->RowIndex ?>_created_by"
        name="x<?= $Page->RowIndex ?>_created_by"
        class="form-control ew-select<?= $Page->created_by->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Page->RowIndex ?>_created_by"
        data-table="sub_media_allocation"
        data-field="x_created_by"
        data-value-separator="<?= $Page->created_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>"
        <?= $Page->created_by->editAttributes() ?>>
        <?= $Page->created_by->selectOptionListHtml("x{$Page->RowIndex}_created_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->created_by->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Page->RowIndex ?>_created_by']"),
        options = { name: "x<?= $Page->RowIndex ?>_created_by", selectId: "sub_media_allocation_x<?= $Page->RowIndex ?>_created_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.created_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_created_by" data-hidden="1" name="o<?= $Page->RowIndex ?>_created_by" id="o<?= $Page->RowIndex ?>_created_by" value="<?= HtmlEncode($Page->created_by->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ts_created->Visible) { // ts_created ?>
        <td data-name="ts_created">
<span id="el$rowindex$_sub_media_allocation_ts_created" class="form-group sub_media_allocation_ts_created">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_created" name="x<?= $Page->RowIndex ?>_ts_created" id="x<?= $Page->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationlist", "x<?= $Page->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_created" data-hidden="1" name="o<?= $Page->RowIndex ?>_ts_created" id="o<?= $Page->RowIndex ?>_ts_created" value="<?= HtmlEncode($Page->ts_created->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
        <td data-name="ts_last_update">
<span id="el$rowindex$_sub_media_allocation_ts_last_update" class="form-group sub_media_allocation_ts_last_update">
<input type="<?= $Page->ts_last_update->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_last_update" name="x<?= $Page->RowIndex ?>_ts_last_update" id="x<?= $Page->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Page->ts_last_update->getPlaceHolder()) ?>" value="<?= $Page->ts_last_update->EditValue ?>"<?= $Page->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Page->ts_last_update->ReadOnly && !$Page->ts_last_update->Disabled && !isset($Page->ts_last_update->EditAttrs["readonly"]) && !isset($Page->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationlist", "x<?= $Page->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_last_update" data-hidden="1" name="o<?= $Page->RowIndex ?>_ts_last_update" id="o<?= $Page->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Page->ts_last_update->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fsub_media_allocationlist","load"], function() {
    fsub_media_allocationlist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isAdd() || $Page->isCopy()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isEdit()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
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
<?php } ?>

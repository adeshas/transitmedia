<?php

namespace PHPMaker2021\test;

// Set up and run Grid object
$Grid = Container("MainCampaignsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmain_campaignsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fmain_campaignsgrid = new ew.Form("fmain_campaignsgrid", "grid");
    fmain_campaignsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "main_campaigns")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.main_campaigns)
        ew.vars.tables.main_campaigns = currentTable;
    fmain_campaignsgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["inventory_id", [fields.inventory_id.visible && fields.inventory_id.required ? ew.Validators.required(fields.inventory_id.caption) : null], fields.inventory_id.isInvalid],
        ["platform_id", [fields.platform_id.visible && fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid],
        ["bus_size_id", [fields.bus_size_id.visible && fields.bus_size_id.required ? ew.Validators.required(fields.bus_size_id.caption) : null], fields.bus_size_id.isInvalid],
        ["quantity", [fields.quantity.visible && fields.quantity.required ? ew.Validators.required(fields.quantity.caption) : null, ew.Validators.integer], fields.quantity.isInvalid],
        ["start_date", [fields.start_date.visible && fields.start_date.required ? ew.Validators.required(fields.start_date.caption) : null, ew.Validators.datetime(0)], fields.start_date.isInvalid],
        ["end_date", [fields.end_date.visible && fields.end_date.required ? ew.Validators.required(fields.end_date.caption) : null, ew.Validators.datetime(0)], fields.end_date.isInvalid],
        ["vendor_id", [fields.vendor_id.visible && fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null], fields.vendor_id.isInvalid],
        ["renewal_stage_id", [fields.renewal_stage_id.visible && fields.renewal_stage_id.required ? ew.Validators.required(fields.renewal_stage_id.caption) : null], fields.renewal_stage_id.isInvalid],
        ["check_status", [fields.check_status.visible && fields.check_status.required ? ew.Validators.required(fields.check_status.caption) : null], fields.check_status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_campaignsgrid,
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
    fmain_campaignsgrid.validate = function () {
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
        return true;
    }

    // Check empty row
    fmain_campaignsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "name", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "inventory_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "platform_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bus_size_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "quantity", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "start_date", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "end_date", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "vendor_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "renewal_stage_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "check_status", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fmain_campaignsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_campaignsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_campaignsgrid.lists.name = <?= $Grid->name->toClientList($Grid) ?>;
    fmain_campaignsgrid.lists.inventory_id = <?= $Grid->inventory_id->toClientList($Grid) ?>;
    fmain_campaignsgrid.lists.platform_id = <?= $Grid->platform_id->toClientList($Grid) ?>;
    fmain_campaignsgrid.lists.bus_size_id = <?= $Grid->bus_size_id->toClientList($Grid) ?>;
    fmain_campaignsgrid.lists.vendor_id = <?= $Grid->vendor_id->toClientList($Grid) ?>;
    fmain_campaignsgrid.lists.renewal_stage_id = <?= $Grid->renewal_stage_id->toClientList($Grid) ?>;
    loadjs.done("fmain_campaignsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> main_campaigns">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fmain_campaignsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_main_campaigns" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_main_campaignsgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_main_campaigns_id" class="main_campaigns_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Grid->name->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_campaigns_name" class="main_campaigns_name"><?= $Grid->renderSort($Grid->name) ?></div></th>
<?php } ?>
<?php if ($Grid->inventory_id->Visible) { // inventory_id ?>
        <th data-name="inventory_id" class="<?= $Grid->inventory_id->headerCellClass() ?>"><div id="elh_main_campaigns_inventory_id" class="main_campaigns_inventory_id"><?= $Grid->renderSort($Grid->inventory_id) ?></div></th>
<?php } ?>
<?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <th data-name="platform_id" class="<?= $Grid->platform_id->headerCellClass() ?>"><div id="elh_main_campaigns_platform_id" class="main_campaigns_platform_id"><?= $Grid->renderSort($Grid->platform_id) ?></div></th>
<?php } ?>
<?php if ($Grid->bus_size_id->Visible) { // bus_size_id ?>
        <th data-name="bus_size_id" class="<?= $Grid->bus_size_id->headerCellClass() ?>"><div id="elh_main_campaigns_bus_size_id" class="main_campaigns_bus_size_id"><?= $Grid->renderSort($Grid->bus_size_id) ?></div></th>
<?php } ?>
<?php if ($Grid->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Grid->quantity->headerCellClass() ?>"><div id="elh_main_campaigns_quantity" class="main_campaigns_quantity"><?= $Grid->renderSort($Grid->quantity) ?></div></th>
<?php } ?>
<?php if ($Grid->start_date->Visible) { // start_date ?>
        <th data-name="start_date" class="<?= $Grid->start_date->headerCellClass() ?>"><div id="elh_main_campaigns_start_date" class="main_campaigns_start_date"><?= $Grid->renderSort($Grid->start_date) ?></div></th>
<?php } ?>
<?php if ($Grid->end_date->Visible) { // end_date ?>
        <th data-name="end_date" class="<?= $Grid->end_date->headerCellClass() ?>"><div id="elh_main_campaigns_end_date" class="main_campaigns_end_date"><?= $Grid->renderSort($Grid->end_date) ?></div></th>
<?php } ?>
<?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <th data-name="vendor_id" class="<?= $Grid->vendor_id->headerCellClass() ?>"><div id="elh_main_campaigns_vendor_id" class="main_campaigns_vendor_id"><?= $Grid->renderSort($Grid->vendor_id) ?></div></th>
<?php } ?>
<?php if ($Grid->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <th data-name="renewal_stage_id" class="<?= $Grid->renewal_stage_id->headerCellClass() ?>"><div id="elh_main_campaigns_renewal_stage_id" class="main_campaigns_renewal_stage_id"><?= $Grid->renderSort($Grid->renewal_stage_id) ?></div></th>
<?php } ?>
<?php if ($Grid->check_status->Visible) { // check_status ?>
        <th data-name="check_status" class="<?= $Grid->check_status->headerCellClass() ?>"><div id="elh_main_campaigns_check_status" class="main_campaigns_check_status"><?= $Grid->renderSort($Grid->check_status) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_main_campaigns", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id" <?= $Grid->id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_id" class="form-group"></span>
<input type="hidden" data-table="main_campaigns" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_id" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_id" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_id" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_id" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="main_campaigns" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name" <?= $Grid->name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_name" class="form-group">
<?php
$onchange = $Grid->name->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->name->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_name" class="ew-auto-suggest">
    <input type="<?= $Grid->name->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_name" id="sv_x<?= $Grid->RowIndex ?>_name" value="<?= RemoveHtml($Grid->name->EditValue) ?>" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_campaigns" data-field="x_name" data-input="sv_x<?= $Grid->RowIndex ?>_name" data-value-separator="<?= $Grid->name->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_campaignsgrid"], function() {
    fmain_campaignsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_name","forceSelect":false}, ew.vars.tables.main_campaigns.fields.name.autoSuggestOptions));
});
</script>
<?= $Grid->name->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_name") ?>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_name" class="form-group">
<?php
$onchange = $Grid->name->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->name->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_name" class="ew-auto-suggest">
    <input type="<?= $Grid->name->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_name" id="sv_x<?= $Grid->RowIndex ?>_name" value="<?= RemoveHtml($Grid->name->EditValue) ?>" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_campaigns" data-field="x_name" data-input="sv_x<?= $Grid->RowIndex ?>_name" data-value-separator="<?= $Grid->name->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_campaignsgrid"], function() {
    fmain_campaignsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_name","forceSelect":false}, ew.vars.tables.main_campaigns.fields.name.autoSuggestOptions));
});
</script>
<?= $Grid->name->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_name") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_name">
<span<?= $Grid->name->viewAttributes() ?>>
<?= $Grid->name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_name" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_name" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_name" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_name" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->inventory_id->Visible) { // inventory_id ?>
        <td data-name="inventory_id" <?= $Grid->inventory_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_inventory_id" class="form-group">
<?php $Grid->inventory_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_inventory_id"
        name="x<?= $Grid->RowIndex ?>_inventory_id"
        class="form-control ew-select<?= $Grid->inventory_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_inventory_id"
        data-table="main_campaigns"
        data-field="x_inventory_id"
        data-value-separator="<?= $Grid->inventory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->inventory_id->getPlaceHolder()) ?>"
        <?= $Grid->inventory_id->editAttributes() ?>>
        <?= $Grid->inventory_id->selectOptionListHtml("x{$Grid->RowIndex}_inventory_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->inventory_id->getErrorMessage() ?></div>
<?= $Grid->inventory_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_inventory_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_inventory_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_inventory_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_inventory_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.inventory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_inventory_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_inventory_id" id="o<?= $Grid->RowIndex ?>_inventory_id" value="<?= HtmlEncode($Grid->inventory_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_inventory_id" class="form-group">
<?php $Grid->inventory_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_inventory_id"
        name="x<?= $Grid->RowIndex ?>_inventory_id"
        class="form-control ew-select<?= $Grid->inventory_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_inventory_id"
        data-table="main_campaigns"
        data-field="x_inventory_id"
        data-value-separator="<?= $Grid->inventory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->inventory_id->getPlaceHolder()) ?>"
        <?= $Grid->inventory_id->editAttributes() ?>>
        <?= $Grid->inventory_id->selectOptionListHtml("x{$Grid->RowIndex}_inventory_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->inventory_id->getErrorMessage() ?></div>
<?= $Grid->inventory_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_inventory_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_inventory_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_inventory_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_inventory_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.inventory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_inventory_id">
<span<?= $Grid->inventory_id->viewAttributes() ?>>
<?= $Grid->inventory_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_inventory_id" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_inventory_id" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_inventory_id" value="<?= HtmlEncode($Grid->inventory_id->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_inventory_id" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_inventory_id" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_inventory_id" value="<?= HtmlEncode($Grid->inventory_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id" <?= $Grid->platform_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->platform_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_platform_id" class="form-group">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->platform_id->getDisplayValue($Grid->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_platform_id" name="x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_platform_id" class="form-group">
<?php $Grid->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_platform_id"
        name="x<?= $Grid->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Grid->platform_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_platform_id"
        data-table="main_campaigns"
        data-field="x_platform_id"
        data-value-separator="<?= $Grid->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->platform_id->getPlaceHolder()) ?>"
        <?= $Grid->platform_id->editAttributes() ?>>
        <?= $Grid->platform_id->selectOptionListHtml("x{$Grid->RowIndex}_platform_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->platform_id->getErrorMessage() ?></div>
<?= $Grid->platform_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_platform_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_platform_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_platform_id" id="o<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->platform_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_platform_id" class="form-group">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->platform_id->getDisplayValue($Grid->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_platform_id" name="x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_platform_id" class="form-group">
<?php $Grid->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_platform_id"
        name="x<?= $Grid->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Grid->platform_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_platform_id"
        data-table="main_campaigns"
        data-field="x_platform_id"
        data-value-separator="<?= $Grid->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->platform_id->getPlaceHolder()) ?>"
        <?= $Grid->platform_id->editAttributes() ?>>
        <?= $Grid->platform_id->selectOptionListHtml("x{$Grid->RowIndex}_platform_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->platform_id->getErrorMessage() ?></div>
<?= $Grid->platform_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_platform_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_platform_id">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<?= $Grid->platform_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_platform_id" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_platform_id" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_platform_id" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_platform_id" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bus_size_id->Visible) { // bus_size_id ?>
        <td data-name="bus_size_id" <?= $Grid->bus_size_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_bus_size_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_size_id"
        name="x<?= $Grid->RowIndex ?>_bus_size_id"
        class="form-control ew-select<?= $Grid->bus_size_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_bus_size_id"
        data-table="main_campaigns"
        data-field="x_bus_size_id"
        data-value-separator="<?= $Grid->bus_size_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_size_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_size_id->editAttributes() ?>>
        <?= $Grid->bus_size_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_size_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_size_id->getErrorMessage() ?></div>
<?= $Grid->bus_size_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_size_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_bus_size_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_size_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_bus_size_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_size_id" id="o<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_bus_size_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_size_id"
        name="x<?= $Grid->RowIndex ?>_bus_size_id"
        class="form-control ew-select<?= $Grid->bus_size_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_bus_size_id"
        data-table="main_campaigns"
        data-field="x_bus_size_id"
        data-value-separator="<?= $Grid->bus_size_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_size_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_size_id->editAttributes() ?>>
        <?= $Grid->bus_size_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_size_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_size_id->getErrorMessage() ?></div>
<?= $Grid->bus_size_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_size_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_bus_size_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_size_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_bus_size_id">
<span<?= $Grid->bus_size_id->viewAttributes() ?>>
<?= $Grid->bus_size_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_bus_size_id" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_bus_size_id" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_bus_size_id" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_bus_size_id" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->quantity->Visible) { // quantity ?>
        <td data-name="quantity" <?= $Grid->quantity->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_quantity" class="form-group">
<input type="<?= $Grid->quantity->getInputTextType() ?>" data-table="main_campaigns" data-field="x_quantity" name="x<?= $Grid->RowIndex ?>_quantity" id="x<?= $Grid->RowIndex ?>_quantity" size="30" placeholder="<?= HtmlEncode($Grid->quantity->getPlaceHolder()) ?>" value="<?= $Grid->quantity->EditValue ?>"<?= $Grid->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->quantity->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_quantity" data-hidden="1" name="o<?= $Grid->RowIndex ?>_quantity" id="o<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_quantity" class="form-group">
<input type="<?= $Grid->quantity->getInputTextType() ?>" data-table="main_campaigns" data-field="x_quantity" name="x<?= $Grid->RowIndex ?>_quantity" id="x<?= $Grid->RowIndex ?>_quantity" size="30" placeholder="<?= HtmlEncode($Grid->quantity->getPlaceHolder()) ?>" value="<?= $Grid->quantity->EditValue ?>"<?= $Grid->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->quantity->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_quantity">
<span<?= $Grid->quantity->viewAttributes() ?>>
<?= $Grid->quantity->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_quantity" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_quantity" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_quantity" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_quantity" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->start_date->Visible) { // start_date ?>
        <td data-name="start_date" <?= $Grid->start_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_start_date" class="form-group">
<input type="<?= $Grid->start_date->getInputTextType() ?>" data-table="main_campaigns" data-field="x_start_date" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" placeholder="<?= HtmlEncode($Grid->start_date->getPlaceHolder()) ?>" value="<?= $Grid->start_date->EditValue ?>"<?= $Grid->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->start_date->getErrorMessage() ?></div>
<?php if (!$Grid->start_date->ReadOnly && !$Grid->start_date->Disabled && !isset($Grid->start_date->EditAttrs["readonly"]) && !isset($Grid->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_campaignsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_campaignsgrid", "x<?= $Grid->RowIndex ?>_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_start_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_start_date" id="o<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_start_date" class="form-group">
<input type="<?= $Grid->start_date->getInputTextType() ?>" data-table="main_campaigns" data-field="x_start_date" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" placeholder="<?= HtmlEncode($Grid->start_date->getPlaceHolder()) ?>" value="<?= $Grid->start_date->EditValue ?>"<?= $Grid->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->start_date->getErrorMessage() ?></div>
<?php if (!$Grid->start_date->ReadOnly && !$Grid->start_date->Disabled && !isset($Grid->start_date->EditAttrs["readonly"]) && !isset($Grid->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_campaignsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_campaignsgrid", "x<?= $Grid->RowIndex ?>_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_start_date">
<span<?= $Grid->start_date->viewAttributes() ?>>
<?= $Grid->start_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_start_date" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_start_date" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_start_date" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_start_date" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->end_date->Visible) { // end_date ?>
        <td data-name="end_date" <?= $Grid->end_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_end_date" class="form-group">
<input type="<?= $Grid->end_date->getInputTextType() ?>" data-table="main_campaigns" data-field="x_end_date" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" placeholder="<?= HtmlEncode($Grid->end_date->getPlaceHolder()) ?>" value="<?= $Grid->end_date->EditValue ?>"<?= $Grid->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->end_date->getErrorMessage() ?></div>
<?php if (!$Grid->end_date->ReadOnly && !$Grid->end_date->Disabled && !isset($Grid->end_date->EditAttrs["readonly"]) && !isset($Grid->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_campaignsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_campaignsgrid", "x<?= $Grid->RowIndex ?>_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_end_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_end_date" id="o<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_end_date" class="form-group">
<input type="<?= $Grid->end_date->getInputTextType() ?>" data-table="main_campaigns" data-field="x_end_date" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" placeholder="<?= HtmlEncode($Grid->end_date->getPlaceHolder()) ?>" value="<?= $Grid->end_date->EditValue ?>"<?= $Grid->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->end_date->getErrorMessage() ?></div>
<?php if (!$Grid->end_date->ReadOnly && !$Grid->end_date->Disabled && !isset($Grid->end_date->EditAttrs["readonly"]) && !isset($Grid->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_campaignsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_campaignsgrid", "x<?= $Grid->RowIndex ?>_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_end_date">
<span<?= $Grid->end_date->viewAttributes() ?>>
<?= $Grid->end_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_end_date" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_end_date" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_end_date" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_end_date" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" <?= $Grid->vendor_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->vendor_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_vendor_id" class="form-group">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_vendor_id" name="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_campaigns"
        data-field="x_vendor_id"
        data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"
        <?= $Grid->vendor_id->editAttributes() ?>>
        <?= $Grid->vendor_id->selectOptionListHtml("x{$Grid->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_campaigns"
        data-field="x_vendor_id"
        data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"
        <?= $Grid->vendor_id->editAttributes() ?>>
        <?= $Grid->vendor_id->selectOptionListHtml("x{$Grid->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_vendor_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_vendor_id" id="o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->vendor_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_vendor_id" class="form-group">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_vendor_id" name="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_campaigns"
        data-field="x_vendor_id"
        data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"
        <?= $Grid->vendor_id->editAttributes() ?>>
        <?= $Grid->vendor_id->selectOptionListHtml("x{$Grid->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_campaigns"
        data-field="x_vendor_id"
        data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"
        <?= $Grid->vendor_id->editAttributes() ?>>
        <?= $Grid->vendor_id->selectOptionListHtml("x{$Grid->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<?= $Grid->vendor_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_vendor_id" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_vendor_id" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_vendor_id" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_vendor_id" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <td data-name="renewal_stage_id" <?= $Grid->renewal_stage_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_renewal_stage_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_renewal_stage_id"
        name="x<?= $Grid->RowIndex ?>_renewal_stage_id"
        class="form-control ew-select<?= $Grid->renewal_stage_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_renewal_stage_id"
        data-table="main_campaigns"
        data-field="x_renewal_stage_id"
        data-value-separator="<?= $Grid->renewal_stage_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->renewal_stage_id->getPlaceHolder()) ?>"
        <?= $Grid->renewal_stage_id->editAttributes() ?>>
        <?= $Grid->renewal_stage_id->selectOptionListHtml("x{$Grid->RowIndex}_renewal_stage_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->renewal_stage_id->getErrorMessage() ?></div>
<?= $Grid->renewal_stage_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_renewal_stage_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_renewal_stage_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_renewal_stage_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_renewal_stage_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.renewal_stage_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_renewal_stage_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_renewal_stage_id" id="o<?= $Grid->RowIndex ?>_renewal_stage_id" value="<?= HtmlEncode($Grid->renewal_stage_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_renewal_stage_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_renewal_stage_id"
        name="x<?= $Grid->RowIndex ?>_renewal_stage_id"
        class="form-control ew-select<?= $Grid->renewal_stage_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_renewal_stage_id"
        data-table="main_campaigns"
        data-field="x_renewal_stage_id"
        data-value-separator="<?= $Grid->renewal_stage_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->renewal_stage_id->getPlaceHolder()) ?>"
        <?= $Grid->renewal_stage_id->editAttributes() ?>>
        <?= $Grid->renewal_stage_id->selectOptionListHtml("x{$Grid->RowIndex}_renewal_stage_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->renewal_stage_id->getErrorMessage() ?></div>
<?= $Grid->renewal_stage_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_renewal_stage_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_renewal_stage_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_renewal_stage_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_renewal_stage_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.renewal_stage_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_renewal_stage_id">
<span<?= $Grid->renewal_stage_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->renewal_stage_id->getViewValue()) && $Grid->renewal_stage_id->linkAttributes() != "") { ?>
<a<?= $Grid->renewal_stage_id->linkAttributes() ?>><?= $Grid->renewal_stage_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Grid->renewal_stage_id->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_renewal_stage_id" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_renewal_stage_id" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_renewal_stage_id" value="<?= HtmlEncode($Grid->renewal_stage_id->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_renewal_stage_id" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_renewal_stage_id" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_renewal_stage_id" value="<?= HtmlEncode($Grid->renewal_stage_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->check_status->Visible) { // check_status ?>
        <td data-name="check_status" <?= $Grid->check_status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_check_status" class="form-group">
<textarea data-table="main_campaigns" data-field="x_check_status" name="x<?= $Grid->RowIndex ?>_check_status" id="x<?= $Grid->RowIndex ?>_check_status" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->check_status->getPlaceHolder()) ?>"<?= $Grid->check_status->editAttributes() ?>><?= $Grid->check_status->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->check_status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_check_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_check_status" id="o<?= $Grid->RowIndex ?>_check_status" value="<?= HtmlEncode($Grid->check_status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_check_status" class="form-group">
<textarea data-table="main_campaigns" data-field="x_check_status" name="x<?= $Grid->RowIndex ?>_check_status" id="x<?= $Grid->RowIndex ?>_check_status" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->check_status->getPlaceHolder()) ?>"<?= $Grid->check_status->editAttributes() ?>><?= $Grid->check_status->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->check_status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_campaigns_check_status">
<span<?= $Grid->check_status->viewAttributes() ?>>
<?php if (!EmptyString($Grid->check_status->getViewValue()) && $Grid->check_status->linkAttributes() != "") { ?>
<a<?= $Grid->check_status->linkAttributes() ?>><?= $Grid->check_status->getViewValue() ?></a>
<?php } else { ?>
<?= $Grid->check_status->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_campaigns" data-field="x_check_status" data-hidden="1" name="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_check_status" id="fmain_campaignsgrid$x<?= $Grid->RowIndex ?>_check_status" value="<?= HtmlEncode($Grid->check_status->FormValue) ?>">
<input type="hidden" data-table="main_campaigns" data-field="x_check_status" data-hidden="1" name="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_check_status" id="fmain_campaignsgrid$o<?= $Grid->RowIndex ?>_check_status" value="<?= HtmlEncode($Grid->check_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fmain_campaignsgrid","load"], function () {
    fmain_campaignsgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_main_campaigns", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_campaigns_id" class="form-group main_campaigns_id"></span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_id" class="form-group main_campaigns_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_campaigns_name" class="form-group main_campaigns_name">
<?php
$onchange = $Grid->name->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->name->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_name" class="ew-auto-suggest">
    <input type="<?= $Grid->name->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_name" id="sv_x<?= $Grid->RowIndex ?>_name" value="<?= RemoveHtml($Grid->name->EditValue) ?>" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_campaigns" data-field="x_name" data-input="sv_x<?= $Grid->RowIndex ?>_name" data-value-separator="<?= $Grid->name->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_campaignsgrid"], function() {
    fmain_campaignsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_name","forceSelect":false}, ew.vars.tables.main_campaigns.fields.name.autoSuggestOptions));
});
</script>
<?= $Grid->name->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_name") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_name" class="form-group main_campaigns_name">
<span<?= $Grid->name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->name->getDisplayValue($Grid->name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->inventory_id->Visible) { // inventory_id ?>
        <td data-name="inventory_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_campaigns_inventory_id" class="form-group main_campaigns_inventory_id">
<?php $Grid->inventory_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_inventory_id"
        name="x<?= $Grid->RowIndex ?>_inventory_id"
        class="form-control ew-select<?= $Grid->inventory_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_inventory_id"
        data-table="main_campaigns"
        data-field="x_inventory_id"
        data-value-separator="<?= $Grid->inventory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->inventory_id->getPlaceHolder()) ?>"
        <?= $Grid->inventory_id->editAttributes() ?>>
        <?= $Grid->inventory_id->selectOptionListHtml("x{$Grid->RowIndex}_inventory_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->inventory_id->getErrorMessage() ?></div>
<?= $Grid->inventory_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_inventory_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_inventory_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_inventory_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_inventory_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.inventory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_inventory_id" class="form-group main_campaigns_inventory_id">
<span<?= $Grid->inventory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->inventory_id->getDisplayValue($Grid->inventory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_inventory_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_inventory_id" id="x<?= $Grid->RowIndex ?>_inventory_id" value="<?= HtmlEncode($Grid->inventory_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_inventory_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_inventory_id" id="o<?= $Grid->RowIndex ?>_inventory_id" value="<?= HtmlEncode($Grid->inventory_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->platform_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_campaigns_platform_id" class="form-group main_campaigns_platform_id">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->platform_id->getDisplayValue($Grid->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_platform_id" name="x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_platform_id" class="form-group main_campaigns_platform_id">
<?php $Grid->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_platform_id"
        name="x<?= $Grid->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Grid->platform_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_platform_id"
        data-table="main_campaigns"
        data-field="x_platform_id"
        data-value-separator="<?= $Grid->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->platform_id->getPlaceHolder()) ?>"
        <?= $Grid->platform_id->editAttributes() ?>>
        <?= $Grid->platform_id->selectOptionListHtml("x{$Grid->RowIndex}_platform_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->platform_id->getErrorMessage() ?></div>
<?= $Grid->platform_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_platform_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_platform_id" class="form-group main_campaigns_platform_id">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->platform_id->getDisplayValue($Grid->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_platform_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_platform_id" id="x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_platform_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_platform_id" id="o<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bus_size_id->Visible) { // bus_size_id ?>
        <td data-name="bus_size_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_campaigns_bus_size_id" class="form-group main_campaigns_bus_size_id">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_size_id"
        name="x<?= $Grid->RowIndex ?>_bus_size_id"
        class="form-control ew-select<?= $Grid->bus_size_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_bus_size_id"
        data-table="main_campaigns"
        data-field="x_bus_size_id"
        data-value-separator="<?= $Grid->bus_size_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_size_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_size_id->editAttributes() ?>>
        <?= $Grid->bus_size_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_size_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_size_id->getErrorMessage() ?></div>
<?= $Grid->bus_size_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_size_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_bus_size_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_size_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_bus_size_id" class="form-group main_campaigns_bus_size_id">
<span<?= $Grid->bus_size_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_size_id->getDisplayValue($Grid->bus_size_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_bus_size_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bus_size_id" id="x<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_bus_size_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_size_id" id="o<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->quantity->Visible) { // quantity ?>
        <td data-name="quantity">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_campaigns_quantity" class="form-group main_campaigns_quantity">
<input type="<?= $Grid->quantity->getInputTextType() ?>" data-table="main_campaigns" data-field="x_quantity" name="x<?= $Grid->RowIndex ?>_quantity" id="x<?= $Grid->RowIndex ?>_quantity" size="30" placeholder="<?= HtmlEncode($Grid->quantity->getPlaceHolder()) ?>" value="<?= $Grid->quantity->EditValue ?>"<?= $Grid->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->quantity->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_quantity" class="form-group main_campaigns_quantity">
<span<?= $Grid->quantity->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->quantity->getDisplayValue($Grid->quantity->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_quantity" data-hidden="1" name="x<?= $Grid->RowIndex ?>_quantity" id="x<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_quantity" data-hidden="1" name="o<?= $Grid->RowIndex ?>_quantity" id="o<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->start_date->Visible) { // start_date ?>
        <td data-name="start_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_campaigns_start_date" class="form-group main_campaigns_start_date">
<input type="<?= $Grid->start_date->getInputTextType() ?>" data-table="main_campaigns" data-field="x_start_date" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" placeholder="<?= HtmlEncode($Grid->start_date->getPlaceHolder()) ?>" value="<?= $Grid->start_date->EditValue ?>"<?= $Grid->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->start_date->getErrorMessage() ?></div>
<?php if (!$Grid->start_date->ReadOnly && !$Grid->start_date->Disabled && !isset($Grid->start_date->EditAttrs["readonly"]) && !isset($Grid->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_campaignsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_campaignsgrid", "x<?= $Grid->RowIndex ?>_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_start_date" class="form-group main_campaigns_start_date">
<span<?= $Grid->start_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->start_date->getDisplayValue($Grid->start_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_start_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_start_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_start_date" id="o<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->end_date->Visible) { // end_date ?>
        <td data-name="end_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_campaigns_end_date" class="form-group main_campaigns_end_date">
<input type="<?= $Grid->end_date->getInputTextType() ?>" data-table="main_campaigns" data-field="x_end_date" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" placeholder="<?= HtmlEncode($Grid->end_date->getPlaceHolder()) ?>" value="<?= $Grid->end_date->EditValue ?>"<?= $Grid->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->end_date->getErrorMessage() ?></div>
<?php if (!$Grid->end_date->ReadOnly && !$Grid->end_date->Disabled && !isset($Grid->end_date->EditAttrs["readonly"]) && !isset($Grid->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_campaignsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_campaignsgrid", "x<?= $Grid->RowIndex ?>_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_end_date" class="form-group main_campaigns_end_date">
<span<?= $Grid->end_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->end_date->getDisplayValue($Grid->end_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_end_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_end_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_end_date" id="o<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->vendor_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_campaigns_vendor_id" class="form-group main_campaigns_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_vendor_id" name="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_main_campaigns_vendor_id" class="form-group main_campaigns_vendor_id">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_campaigns"
        data-field="x_vendor_id"
        data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"
        <?= $Grid->vendor_id->editAttributes() ?>>
        <?= $Grid->vendor_id->selectOptionListHtml("x{$Grid->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_vendor_id" class="form-group main_campaigns_vendor_id">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_campaigns"
        data-field="x_vendor_id"
        data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"
        <?= $Grid->vendor_id->editAttributes() ?>>
        <?= $Grid->vendor_id->selectOptionListHtml("x{$Grid->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_vendor_id" class="form-group main_campaigns_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_vendor_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_vendor_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_vendor_id" id="o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <td data-name="renewal_stage_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_campaigns_renewal_stage_id" class="form-group main_campaigns_renewal_stage_id">
    <select
        id="x<?= $Grid->RowIndex ?>_renewal_stage_id"
        name="x<?= $Grid->RowIndex ?>_renewal_stage_id"
        class="form-control ew-select<?= $Grid->renewal_stage_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x<?= $Grid->RowIndex ?>_renewal_stage_id"
        data-table="main_campaigns"
        data-field="x_renewal_stage_id"
        data-value-separator="<?= $Grid->renewal_stage_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->renewal_stage_id->getPlaceHolder()) ?>"
        <?= $Grid->renewal_stage_id->editAttributes() ?>>
        <?= $Grid->renewal_stage_id->selectOptionListHtml("x{$Grid->RowIndex}_renewal_stage_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->renewal_stage_id->getErrorMessage() ?></div>
<?= $Grid->renewal_stage_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_renewal_stage_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_campaigns_x<?= $Grid->RowIndex ?>_renewal_stage_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_renewal_stage_id", selectId: "main_campaigns_x<?= $Grid->RowIndex ?>_renewal_stage_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.renewal_stage_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_renewal_stage_id" class="form-group main_campaigns_renewal_stage_id">
<span<?= $Grid->renewal_stage_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->renewal_stage_id->ViewValue) && $Grid->renewal_stage_id->linkAttributes() != "") { ?>
<a<?= $Grid->renewal_stage_id->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->renewal_stage_id->getDisplayValue($Grid->renewal_stage_id->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->renewal_stage_id->getDisplayValue($Grid->renewal_stage_id->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_renewal_stage_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_renewal_stage_id" id="x<?= $Grid->RowIndex ?>_renewal_stage_id" value="<?= HtmlEncode($Grid->renewal_stage_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_renewal_stage_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_renewal_stage_id" id="o<?= $Grid->RowIndex ?>_renewal_stage_id" value="<?= HtmlEncode($Grid->renewal_stage_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->check_status->Visible) { // check_status ?>
        <td data-name="check_status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_campaigns_check_status" class="form-group main_campaigns_check_status">
<textarea data-table="main_campaigns" data-field="x_check_status" name="x<?= $Grid->RowIndex ?>_check_status" id="x<?= $Grid->RowIndex ?>_check_status" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->check_status->getPlaceHolder()) ?>"<?= $Grid->check_status->editAttributes() ?>><?= $Grid->check_status->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->check_status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_campaigns_check_status" class="form-group main_campaigns_check_status">
<span<?= $Grid->check_status->viewAttributes() ?>>
<?php if (!EmptyString($Grid->check_status->ViewValue) && $Grid->check_status->linkAttributes() != "") { ?>
<a<?= $Grid->check_status->linkAttributes() ?>><?= $Grid->check_status->ViewValue ?></a>
<?php } else { ?>
<?= $Grid->check_status->ViewValue ?>
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_check_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_check_status" id="x<?= $Grid->RowIndex ?>_check_status" value="<?= HtmlEncode($Grid->check_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_campaigns" data-field="x_check_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_check_status" id="o<?= $Grid->RowIndex ?>_check_status" value="<?= HtmlEncode($Grid->check_status->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fmain_campaignsgrid","load"], function() {
    fmain_campaignsgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
<?php
// Render aggregate row
$Grid->RowType = ROWTYPE_AGGREGATE;
$Grid->resetAttributes();
$Grid->renderRow();
?>
<?php if ($Grid->TotalRecords > 0 && $Grid->CurrentMode == "view") { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Grid->renderListOptions();

// Render list options (footer, left)
$Grid->ListOptions->render("footer", "left");
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id" class="<?= $Grid->id->footerCellClass() ?>"><span id="elf_main_campaigns_id" class="main_campaigns_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name" class="<?= $Grid->name->footerCellClass() ?>"><span id="elf_main_campaigns_name" class="main_campaigns_name">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->inventory_id->Visible) { // inventory_id ?>
        <td data-name="inventory_id" class="<?= $Grid->inventory_id->footerCellClass() ?>"><span id="elf_main_campaigns_inventory_id" class="main_campaigns_inventory_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id" class="<?= $Grid->platform_id->footerCellClass() ?>"><span id="elf_main_campaigns_platform_id" class="main_campaigns_platform_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->bus_size_id->Visible) { // bus_size_id ?>
        <td data-name="bus_size_id" class="<?= $Grid->bus_size_id->footerCellClass() ?>"><span id="elf_main_campaigns_bus_size_id" class="main_campaigns_bus_size_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->quantity->Visible) { // quantity ?>
        <td data-name="quantity" class="<?= $Grid->quantity->footerCellClass() ?>"><span id="elf_main_campaigns_quantity" class="main_campaigns_quantity">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->quantity->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->start_date->Visible) { // start_date ?>
        <td data-name="start_date" class="<?= $Grid->start_date->footerCellClass() ?>"><span id="elf_main_campaigns_start_date" class="main_campaigns_start_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->end_date->Visible) { // end_date ?>
        <td data-name="end_date" class="<?= $Grid->end_date->footerCellClass() ?>"><span id="elf_main_campaigns_end_date" class="main_campaigns_end_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" class="<?= $Grid->vendor_id->footerCellClass() ?>"><span id="elf_main_campaigns_vendor_id" class="main_campaigns_vendor_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <td data-name="renewal_stage_id" class="<?= $Grid->renewal_stage_id->footerCellClass() ?>"><span id="elf_main_campaigns_renewal_stage_id" class="main_campaigns_renewal_stage_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->check_status->Visible) { // check_status ?>
        <td data-name="check_status" class="<?= $Grid->check_status->footerCellClass() ?>"><span id="elf_main_campaigns_check_status" class="main_campaigns_check_status">
        &nbsp;
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Grid->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmain_campaignsgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("main_campaigns");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

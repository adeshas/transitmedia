<?php

namespace PHPMaker2021\test;

// Set up and run Grid object
$Grid = Container("SubMediaAllocationGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsub_media_allocationgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fsub_media_allocationgrid = new ew.Form("fsub_media_allocationgrid", "grid");
    fsub_media_allocationgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sub_media_allocation")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sub_media_allocation)
        ew.vars.tables.sub_media_allocation = currentTable;
    fsub_media_allocationgrid.addFields([
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
        var f = fsub_media_allocationgrid,
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
    fsub_media_allocationgrid.validate = function () {
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
    fsub_media_allocationgrid.emptyRow = function (rowIndex) {
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
    fsub_media_allocationgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_media_allocationgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsub_media_allocationgrid.lists.bus_id = <?= $Grid->bus_id->toClientList($Grid) ?>;
    fsub_media_allocationgrid.lists.campaign_id = <?= $Grid->campaign_id->toClientList($Grid) ?>;
    fsub_media_allocationgrid.lists.active = <?= $Grid->active->toClientList($Grid) ?>;
    loadjs.done("fsub_media_allocationgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> sub_media_allocation">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fsub_media_allocationgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_sub_media_allocation" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_sub_media_allocationgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_sub_media_allocation_id" class="sub_media_allocation_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->bus_id->Visible) { // bus_id ?>
        <th data-name="bus_id" class="<?= $Grid->bus_id->headerCellClass() ?>"><div id="elh_sub_media_allocation_bus_id" class="sub_media_allocation_bus_id"><?= $Grid->renderSort($Grid->bus_id) ?></div></th>
<?php } ?>
<?php if ($Grid->campaign_id->Visible) { // campaign_id ?>
        <th data-name="campaign_id" class="<?= $Grid->campaign_id->headerCellClass() ?>"><div id="elh_sub_media_allocation_campaign_id" class="sub_media_allocation_campaign_id"><?= $Grid->renderSort($Grid->campaign_id) ?></div></th>
<?php } ?>
<?php if ($Grid->active->Visible) { // active ?>
        <th data-name="active" class="<?= $Grid->active->headerCellClass() ?>"><div id="elh_sub_media_allocation_active" class="sub_media_allocation_active"><?= $Grid->renderSort($Grid->active) ?></div></th>
<?php } ?>
<?php if ($Grid->created_by->Visible) { // created_by ?>
        <th data-name="created_by" class="<?= $Grid->created_by->headerCellClass() ?>"><div id="elh_sub_media_allocation_created_by" class="sub_media_allocation_created_by"><?= $Grid->renderSort($Grid->created_by) ?></div></th>
<?php } ?>
<?php if ($Grid->ts_created->Visible) { // ts_created ?>
        <th data-name="ts_created" class="<?= $Grid->ts_created->headerCellClass() ?>"><div id="elh_sub_media_allocation_ts_created" class="sub_media_allocation_ts_created"><?= $Grid->renderSort($Grid->ts_created) ?></div></th>
<?php } ?>
<?php if ($Grid->ts_last_update->Visible) { // ts_last_update ?>
        <th data-name="ts_last_update" class="<?= $Grid->ts_last_update->headerCellClass() ?>"><div id="elh_sub_media_allocation_ts_last_update" class="sub_media_allocation_ts_last_update"><?= $Grid->renderSort($Grid->ts_last_update) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_sub_media_allocation", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_id" class="form-group"></span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_id" id="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_id" id="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id" <?= $Grid->bus_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->bus_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_bus_id" class="form-group">
<span<?= $Grid->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_id->getDisplayValue($Grid->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_id" name="x<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_bus_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_id"
        name="x<?= $Grid->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Grid->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_bus_id"
        data-table="sub_media_allocation"
        data-field="x_bus_id"
        data-value-separator="<?= $Grid->bus_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_id->editAttributes() ?>>
        <?= $Grid->bus_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_id->getErrorMessage() ?></div>
<?= $Grid->bus_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_id", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_bus_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_id" id="o<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->bus_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_bus_id" class="form-group">
<span<?= $Grid->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_id->getDisplayValue($Grid->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_id" name="x<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_bus_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_id"
        name="x<?= $Grid->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Grid->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_bus_id"
        data-table="sub_media_allocation"
        data-field="x_bus_id"
        data-value-separator="<?= $Grid->bus_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_id->editAttributes() ?>>
        <?= $Grid->bus_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_id->getErrorMessage() ?></div>
<?= $Grid->bus_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_id", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_bus_id">
<span<?= $Grid->bus_id->viewAttributes() ?>>
<?= $Grid->bus_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_bus_id" data-hidden="1" name="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_bus_id" id="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->FormValue) ?>">
<input type="hidden" data-table="sub_media_allocation" data-field="x_bus_id" data-hidden="1" name="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_bus_id" id="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id" <?= $Grid->campaign_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_campaign_id" class="form-group">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->campaign_id->getDisplayValue($Grid->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_campaign_id" name="x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_campaign_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_campaign_id"
        name="x<?= $Grid->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Grid->campaign_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_campaign_id"
        data-table="sub_media_allocation"
        data-field="x_campaign_id"
        data-value-separator="<?= $Grid->campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->campaign_id->getPlaceHolder()) ?>"
        <?= $Grid->campaign_id->editAttributes() ?>>
        <?= $Grid->campaign_id->selectOptionListHtml("x{$Grid->RowIndex}_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->campaign_id->getErrorMessage() ?></div>
<?= $Grid->campaign_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_campaign_id", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_campaign_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_campaign_id" id="o<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_campaign_id" class="form-group">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->campaign_id->getDisplayValue($Grid->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_campaign_id" name="x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_campaign_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_campaign_id"
        name="x<?= $Grid->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Grid->campaign_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_campaign_id"
        data-table="sub_media_allocation"
        data-field="x_campaign_id"
        data-value-separator="<?= $Grid->campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->campaign_id->getPlaceHolder()) ?>"
        <?= $Grid->campaign_id->editAttributes() ?>>
        <?= $Grid->campaign_id->selectOptionListHtml("x{$Grid->RowIndex}_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->campaign_id->getErrorMessage() ?></div>
<?= $Grid->campaign_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_campaign_id", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_campaign_id">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<?= $Grid->campaign_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_campaign_id" data-hidden="1" name="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_campaign_id" id="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->FormValue) ?>">
<input type="hidden" data-table="sub_media_allocation" data-field="x_campaign_id" data-hidden="1" name="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_campaign_id" id="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->active->Visible) { // active ?>
        <td data-name="active" <?= $Grid->active->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_active" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_active"
        name="x<?= $Grid->RowIndex ?>_active"
        class="form-control ew-select<?= $Grid->active->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_active"
        data-table="sub_media_allocation"
        data-field="x_active"
        data-dropdown
        data-value-separator="<?= $Grid->active->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->active->getPlaceHolder()) ?>"
        <?= $Grid->active->editAttributes() ?>>
        <?= $Grid->active->selectOptionListHtml("x{$Grid->RowIndex}_active") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->active->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_active']"),
        options = { name: "x<?= $Grid->RowIndex ?>_active", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_active", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
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
<input type="hidden" data-table="sub_media_allocation" data-field="x_active" data-hidden="1" name="o<?= $Grid->RowIndex ?>_active" id="o<?= $Grid->RowIndex ?>_active" value="<?= HtmlEncode($Grid->active->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_active" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_active"
        name="x<?= $Grid->RowIndex ?>_active"
        class="form-control ew-select<?= $Grid->active->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_active"
        data-table="sub_media_allocation"
        data-field="x_active"
        data-dropdown
        data-value-separator="<?= $Grid->active->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->active->getPlaceHolder()) ?>"
        <?= $Grid->active->editAttributes() ?>>
        <?= $Grid->active->selectOptionListHtml("x{$Grid->RowIndex}_active") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->active->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_active']"),
        options = { name: "x<?= $Grid->RowIndex ?>_active", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_active", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
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
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_active">
<span<?= $Grid->active->viewAttributes() ?>>
<?= $Grid->active->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_active" data-hidden="1" name="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_active" id="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_active" value="<?= HtmlEncode($Grid->active->FormValue) ?>">
<input type="hidden" data-table="sub_media_allocation" data-field="x_active" data-hidden="1" name="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_active" id="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_active" value="<?= HtmlEncode($Grid->active->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->created_by->Visible) { // created_by ?>
        <td data-name="created_by" <?= $Grid->created_by->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_created_by" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_created_by"
        name="x<?= $Grid->RowIndex ?>_created_by"
        class="form-control ew-select<?= $Grid->created_by->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_created_by"
        data-table="sub_media_allocation"
        data-field="x_created_by"
        data-value-separator="<?= $Grid->created_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->created_by->getPlaceHolder()) ?>"
        <?= $Grid->created_by->editAttributes() ?>>
        <?= $Grid->created_by->selectOptionListHtml("x{$Grid->RowIndex}_created_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->created_by->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_created_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_created_by", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_created_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.created_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_created_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_by" id="o<?= $Grid->RowIndex ?>_created_by" value="<?= HtmlEncode($Grid->created_by->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_created_by" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_created_by"
        name="x<?= $Grid->RowIndex ?>_created_by"
        class="form-control ew-select<?= $Grid->created_by->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_created_by"
        data-table="sub_media_allocation"
        data-field="x_created_by"
        data-value-separator="<?= $Grid->created_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->created_by->getPlaceHolder()) ?>"
        <?= $Grid->created_by->editAttributes() ?>>
        <?= $Grid->created_by->selectOptionListHtml("x{$Grid->RowIndex}_created_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->created_by->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_created_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_created_by", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_created_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.created_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_created_by">
<span<?= $Grid->created_by->viewAttributes() ?>>
<?= $Grid->created_by->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_created_by" data-hidden="1" name="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_created_by" id="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_created_by" value="<?= HtmlEncode($Grid->created_by->FormValue) ?>">
<input type="hidden" data-table="sub_media_allocation" data-field="x_created_by" data-hidden="1" name="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_created_by" id="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_created_by" value="<?= HtmlEncode($Grid->created_by->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ts_created->Visible) { // ts_created ?>
        <td data-name="ts_created" <?= $Grid->ts_created->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_ts_created" class="form-group">
<input type="<?= $Grid->ts_created->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_created" name="x<?= $Grid->RowIndex ?>_ts_created" id="x<?= $Grid->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Grid->ts_created->getPlaceHolder()) ?>" value="<?= $Grid->ts_created->EditValue ?>"<?= $Grid->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ts_created->getErrorMessage() ?></div>
<?php if (!$Grid->ts_created->ReadOnly && !$Grid->ts_created->Disabled && !isset($Grid->ts_created->EditAttrs["readonly"]) && !isset($Grid->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationgrid", "x<?= $Grid->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_created" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ts_created" id="o<?= $Grid->RowIndex ?>_ts_created" value="<?= HtmlEncode($Grid->ts_created->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_ts_created" class="form-group">
<input type="<?= $Grid->ts_created->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_created" name="x<?= $Grid->RowIndex ?>_ts_created" id="x<?= $Grid->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Grid->ts_created->getPlaceHolder()) ?>" value="<?= $Grid->ts_created->EditValue ?>"<?= $Grid->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ts_created->getErrorMessage() ?></div>
<?php if (!$Grid->ts_created->ReadOnly && !$Grid->ts_created->Disabled && !isset($Grid->ts_created->EditAttrs["readonly"]) && !isset($Grid->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationgrid", "x<?= $Grid->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_ts_created">
<span<?= $Grid->ts_created->viewAttributes() ?>>
<?= $Grid->ts_created->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_created" data-hidden="1" name="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_ts_created" id="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_ts_created" value="<?= HtmlEncode($Grid->ts_created->FormValue) ?>">
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_created" data-hidden="1" name="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_ts_created" id="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_ts_created" value="<?= HtmlEncode($Grid->ts_created->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ts_last_update->Visible) { // ts_last_update ?>
        <td data-name="ts_last_update" <?= $Grid->ts_last_update->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_ts_last_update" class="form-group">
<input type="<?= $Grid->ts_last_update->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_last_update" name="x<?= $Grid->RowIndex ?>_ts_last_update" id="x<?= $Grid->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Grid->ts_last_update->getPlaceHolder()) ?>" value="<?= $Grid->ts_last_update->EditValue ?>"<?= $Grid->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Grid->ts_last_update->ReadOnly && !$Grid->ts_last_update->Disabled && !isset($Grid->ts_last_update->EditAttrs["readonly"]) && !isset($Grid->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationgrid", "x<?= $Grid->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_last_update" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ts_last_update" id="o<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_ts_last_update" class="form-group">
<input type="<?= $Grid->ts_last_update->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_last_update" name="x<?= $Grid->RowIndex ?>_ts_last_update" id="x<?= $Grid->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Grid->ts_last_update->getPlaceHolder()) ?>" value="<?= $Grid->ts_last_update->EditValue ?>"<?= $Grid->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Grid->ts_last_update->ReadOnly && !$Grid->ts_last_update->Disabled && !isset($Grid->ts_last_update->EditAttrs["readonly"]) && !isset($Grid->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationgrid", "x<?= $Grid->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_media_allocation_ts_last_update">
<span<?= $Grid->ts_last_update->viewAttributes() ?>>
<?= $Grid->ts_last_update->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_last_update" data-hidden="1" name="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_ts_last_update" id="fsub_media_allocationgrid$x<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->FormValue) ?>">
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_last_update" data-hidden="1" name="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_ts_last_update" id="fsub_media_allocationgrid$o<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->OldValue) ?>">
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
loadjs.ready(["fsub_media_allocationgrid","load"], function () {
    fsub_media_allocationgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_sub_media_allocation", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_sub_media_allocation_id" class="form-group sub_media_allocation_id"></span>
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_id" class="form-group sub_media_allocation_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->bus_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_sub_media_allocation_bus_id" class="form-group sub_media_allocation_bus_id">
<span<?= $Grid->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_id->getDisplayValue($Grid->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_id" name="x<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_bus_id" class="form-group sub_media_allocation_bus_id">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_id"
        name="x<?= $Grid->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Grid->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_bus_id"
        data-table="sub_media_allocation"
        data-field="x_bus_id"
        data-value-separator="<?= $Grid->bus_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_id->editAttributes() ?>>
        <?= $Grid->bus_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_id->getErrorMessage() ?></div>
<?= $Grid->bus_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_id", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_bus_id" class="form-group sub_media_allocation_bus_id">
<span<?= $Grid->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_id->getDisplayValue($Grid->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_bus_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bus_id" id="x<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_bus_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_id" id="o<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->campaign_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_sub_media_allocation_campaign_id" class="form-group sub_media_allocation_campaign_id">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->campaign_id->getDisplayValue($Grid->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_campaign_id" name="x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_campaign_id" class="form-group sub_media_allocation_campaign_id">
    <select
        id="x<?= $Grid->RowIndex ?>_campaign_id"
        name="x<?= $Grid->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Grid->campaign_id->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_campaign_id"
        data-table="sub_media_allocation"
        data-field="x_campaign_id"
        data-value-separator="<?= $Grid->campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->campaign_id->getPlaceHolder()) ?>"
        <?= $Grid->campaign_id->editAttributes() ?>>
        <?= $Grid->campaign_id->selectOptionListHtml("x{$Grid->RowIndex}_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->campaign_id->getErrorMessage() ?></div>
<?= $Grid->campaign_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_campaign_id", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_campaign_id" class="form-group sub_media_allocation_campaign_id">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->campaign_id->getDisplayValue($Grid->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_campaign_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_campaign_id" id="x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_campaign_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_campaign_id" id="o<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->active->Visible) { // active ?>
        <td data-name="active">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sub_media_allocation_active" class="form-group sub_media_allocation_active">
    <select
        id="x<?= $Grid->RowIndex ?>_active"
        name="x<?= $Grid->RowIndex ?>_active"
        class="form-control ew-select<?= $Grid->active->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_active"
        data-table="sub_media_allocation"
        data-field="x_active"
        data-dropdown
        data-value-separator="<?= $Grid->active->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->active->getPlaceHolder()) ?>"
        <?= $Grid->active->editAttributes() ?>>
        <?= $Grid->active->selectOptionListHtml("x{$Grid->RowIndex}_active") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->active->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_active']"),
        options = { name: "x<?= $Grid->RowIndex ?>_active", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_active", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
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
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_active" class="form-group sub_media_allocation_active">
<span<?= $Grid->active->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->active->getDisplayValue($Grid->active->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_active" data-hidden="1" name="x<?= $Grid->RowIndex ?>_active" id="x<?= $Grid->RowIndex ?>_active" value="<?= HtmlEncode($Grid->active->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_active" data-hidden="1" name="o<?= $Grid->RowIndex ?>_active" id="o<?= $Grid->RowIndex ?>_active" value="<?= HtmlEncode($Grid->active->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->created_by->Visible) { // created_by ?>
        <td data-name="created_by">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sub_media_allocation_created_by" class="form-group sub_media_allocation_created_by">
    <select
        id="x<?= $Grid->RowIndex ?>_created_by"
        name="x<?= $Grid->RowIndex ?>_created_by"
        class="form-control ew-select<?= $Grid->created_by->isInvalidClass() ?>"
        data-select2-id="sub_media_allocation_x<?= $Grid->RowIndex ?>_created_by"
        data-table="sub_media_allocation"
        data-field="x_created_by"
        data-value-separator="<?= $Grid->created_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->created_by->getPlaceHolder()) ?>"
        <?= $Grid->created_by->editAttributes() ?>>
        <?= $Grid->created_by->selectOptionListHtml("x{$Grid->RowIndex}_created_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->created_by->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_media_allocation_x<?= $Grid->RowIndex ?>_created_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_created_by", selectId: "sub_media_allocation_x<?= $Grid->RowIndex ?>_created_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_media_allocation.fields.created_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_created_by" class="form-group sub_media_allocation_created_by">
<span<?= $Grid->created_by->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->created_by->getDisplayValue($Grid->created_by->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_created_by" data-hidden="1" name="x<?= $Grid->RowIndex ?>_created_by" id="x<?= $Grid->RowIndex ?>_created_by" value="<?= HtmlEncode($Grid->created_by->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_created_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_by" id="o<?= $Grid->RowIndex ?>_created_by" value="<?= HtmlEncode($Grid->created_by->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ts_created->Visible) { // ts_created ?>
        <td data-name="ts_created">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sub_media_allocation_ts_created" class="form-group sub_media_allocation_ts_created">
<input type="<?= $Grid->ts_created->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_created" name="x<?= $Grid->RowIndex ?>_ts_created" id="x<?= $Grid->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Grid->ts_created->getPlaceHolder()) ?>" value="<?= $Grid->ts_created->EditValue ?>"<?= $Grid->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ts_created->getErrorMessage() ?></div>
<?php if (!$Grid->ts_created->ReadOnly && !$Grid->ts_created->Disabled && !isset($Grid->ts_created->EditAttrs["readonly"]) && !isset($Grid->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationgrid", "x<?= $Grid->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_ts_created" class="form-group sub_media_allocation_ts_created">
<span<?= $Grid->ts_created->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ts_created->getDisplayValue($Grid->ts_created->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_created" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ts_created" id="x<?= $Grid->RowIndex ?>_ts_created" value="<?= HtmlEncode($Grid->ts_created->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_created" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ts_created" id="o<?= $Grid->RowIndex ?>_ts_created" value="<?= HtmlEncode($Grid->ts_created->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ts_last_update->Visible) { // ts_last_update ?>
        <td data-name="ts_last_update">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sub_media_allocation_ts_last_update" class="form-group sub_media_allocation_ts_last_update">
<input type="<?= $Grid->ts_last_update->getInputTextType() ?>" data-table="sub_media_allocation" data-field="x_ts_last_update" name="x<?= $Grid->RowIndex ?>_ts_last_update" id="x<?= $Grid->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Grid->ts_last_update->getPlaceHolder()) ?>" value="<?= $Grid->ts_last_update->EditValue ?>"<?= $Grid->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Grid->ts_last_update->ReadOnly && !$Grid->ts_last_update->Disabled && !isset($Grid->ts_last_update->EditAttrs["readonly"]) && !isset($Grid->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_media_allocationgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_media_allocationgrid", "x<?= $Grid->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_media_allocation_ts_last_update" class="form-group sub_media_allocation_ts_last_update">
<span<?= $Grid->ts_last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ts_last_update->getDisplayValue($Grid->ts_last_update->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_last_update" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ts_last_update" id="x<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_media_allocation" data-field="x_ts_last_update" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ts_last_update" id="o<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fsub_media_allocationgrid","load"], function() {
    fsub_media_allocationgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
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
<input type="hidden" name="detailpage" value="fsub_media_allocationgrid">
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
    ew.addEventHandlers("sub_media_allocation");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

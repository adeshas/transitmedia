<?php

namespace PHPMaker2021\test;

// Set up and run Grid object
$Grid = Container("MainBusesGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmain_busesgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fmain_busesgrid = new ew.Form("fmain_busesgrid", "grid");
    fmain_busesgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "main_buses")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.main_buses)
        ew.vars.tables.main_buses = currentTable;
    fmain_busesgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["number", [fields.number.visible && fields.number.required ? ew.Validators.required(fields.number.caption) : null], fields.number.isInvalid],
        ["platform_id", [fields.platform_id.visible && fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid],
        ["operator_id", [fields.operator_id.visible && fields.operator_id.required ? ew.Validators.required(fields.operator_id.caption) : null], fields.operator_id.isInvalid],
        ["exterior_campaign_id", [fields.exterior_campaign_id.visible && fields.exterior_campaign_id.required ? ew.Validators.required(fields.exterior_campaign_id.caption) : null], fields.exterior_campaign_id.isInvalid],
        ["interior_campaign_id", [fields.interior_campaign_id.visible && fields.interior_campaign_id.required ? ew.Validators.required(fields.interior_campaign_id.caption) : null], fields.interior_campaign_id.isInvalid],
        ["bus_status_id", [fields.bus_status_id.visible && fields.bus_status_id.required ? ew.Validators.required(fields.bus_status_id.caption) : null], fields.bus_status_id.isInvalid],
        ["bus_size_id", [fields.bus_size_id.visible && fields.bus_size_id.required ? ew.Validators.required(fields.bus_size_id.caption) : null], fields.bus_size_id.isInvalid],
        ["bus_depot_id", [fields.bus_depot_id.visible && fields.bus_depot_id.required ? ew.Validators.required(fields.bus_depot_id.caption) : null], fields.bus_depot_id.isInvalid],
        ["ts_last_update", [fields.ts_last_update.visible && fields.ts_last_update.required ? ew.Validators.required(fields.ts_last_update.caption) : null, ew.Validators.datetime(1)], fields.ts_last_update.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_busesgrid,
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
    fmain_busesgrid.validate = function () {
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
    fmain_busesgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "number", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "platform_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "operator_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "exterior_campaign_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "interior_campaign_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bus_status_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bus_size_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bus_depot_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ts_last_update", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fmain_busesgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_busesgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_busesgrid.lists.platform_id = <?= $Grid->platform_id->toClientList($Grid) ?>;
    fmain_busesgrid.lists.operator_id = <?= $Grid->operator_id->toClientList($Grid) ?>;
    fmain_busesgrid.lists.exterior_campaign_id = <?= $Grid->exterior_campaign_id->toClientList($Grid) ?>;
    fmain_busesgrid.lists.interior_campaign_id = <?= $Grid->interior_campaign_id->toClientList($Grid) ?>;
    fmain_busesgrid.lists.bus_status_id = <?= $Grid->bus_status_id->toClientList($Grid) ?>;
    fmain_busesgrid.lists.bus_size_id = <?= $Grid->bus_size_id->toClientList($Grid) ?>;
    fmain_busesgrid.lists.bus_depot_id = <?= $Grid->bus_depot_id->toClientList($Grid) ?>;
    loadjs.done("fmain_busesgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> main_buses">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fmain_busesgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_main_buses" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_main_busesgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_main_buses_id" class="main_buses_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->number->Visible) { // number ?>
        <th data-name="number" class="<?= $Grid->number->headerCellClass() ?>"><div id="elh_main_buses_number" class="main_buses_number"><?= $Grid->renderSort($Grid->number) ?></div></th>
<?php } ?>
<?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <th data-name="platform_id" class="<?= $Grid->platform_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_buses_platform_id" class="main_buses_platform_id"><?= $Grid->renderSort($Grid->platform_id) ?></div></th>
<?php } ?>
<?php if ($Grid->operator_id->Visible) { // operator_id ?>
        <th data-name="operator_id" class="<?= $Grid->operator_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_buses_operator_id" class="main_buses_operator_id"><?= $Grid->renderSort($Grid->operator_id) ?></div></th>
<?php } ?>
<?php if ($Grid->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <th data-name="exterior_campaign_id" class="<?= $Grid->exterior_campaign_id->headerCellClass() ?>"><div id="elh_main_buses_exterior_campaign_id" class="main_buses_exterior_campaign_id"><?= $Grid->renderSort($Grid->exterior_campaign_id) ?></div></th>
<?php } ?>
<?php if ($Grid->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <th data-name="interior_campaign_id" class="<?= $Grid->interior_campaign_id->headerCellClass() ?>"><div id="elh_main_buses_interior_campaign_id" class="main_buses_interior_campaign_id"><?= $Grid->renderSort($Grid->interior_campaign_id) ?></div></th>
<?php } ?>
<?php if ($Grid->bus_status_id->Visible) { // bus_status_id ?>
        <th data-name="bus_status_id" class="<?= $Grid->bus_status_id->headerCellClass() ?>"><div id="elh_main_buses_bus_status_id" class="main_buses_bus_status_id"><?= $Grid->renderSort($Grid->bus_status_id) ?></div></th>
<?php } ?>
<?php if ($Grid->bus_size_id->Visible) { // bus_size_id ?>
        <th data-name="bus_size_id" class="<?= $Grid->bus_size_id->headerCellClass() ?>"><div id="elh_main_buses_bus_size_id" class="main_buses_bus_size_id"><?= $Grid->renderSort($Grid->bus_size_id) ?></div></th>
<?php } ?>
<?php if ($Grid->bus_depot_id->Visible) { // bus_depot_id ?>
        <th data-name="bus_depot_id" class="<?= $Grid->bus_depot_id->headerCellClass() ?>"><div id="elh_main_buses_bus_depot_id" class="main_buses_bus_depot_id"><?= $Grid->renderSort($Grid->bus_depot_id) ?></div></th>
<?php } ?>
<?php if ($Grid->ts_last_update->Visible) { // ts_last_update ?>
        <th data-name="ts_last_update" class="<?= $Grid->ts_last_update->headerCellClass() ?>"><div id="elh_main_buses_ts_last_update" class="main_buses_ts_last_update"><?= $Grid->renderSort($Grid->ts_last_update) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_main_buses", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_main_buses_id" class="form-group"></span>
<input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_id" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_id" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->number->Visible) { // number ?>
        <td data-name="number" <?= $Grid->number->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_number" class="form-group">
<input type="<?= $Grid->number->getInputTextType() ?>" data-table="main_buses" data-field="x_number" name="x<?= $Grid->RowIndex ?>_number" id="x<?= $Grid->RowIndex ?>_number" size="30" placeholder="<?= HtmlEncode($Grid->number->getPlaceHolder()) ?>" value="<?= $Grid->number->EditValue ?>"<?= $Grid->number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->number->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_buses" data-field="x_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_number" id="o<?= $Grid->RowIndex ?>_number" value="<?= HtmlEncode($Grid->number->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_number" class="form-group">
<input type="<?= $Grid->number->getInputTextType() ?>" data-table="main_buses" data-field="x_number" name="x<?= $Grid->RowIndex ?>_number" id="x<?= $Grid->RowIndex ?>_number" size="30" placeholder="<?= HtmlEncode($Grid->number->getPlaceHolder()) ?>" value="<?= $Grid->number->EditValue ?>"<?= $Grid->number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->number->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_number">
<span<?= $Grid->number->viewAttributes() ?>>
<?= $Grid->number->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_number" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_number" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_number" value="<?= HtmlEncode($Grid->number->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_number" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_number" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_number" value="<?= HtmlEncode($Grid->number->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id" <?= $Grid->platform_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_platform_id" class="form-group">
<?php $Grid->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_platform_id"
        name="x<?= $Grid->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Grid->platform_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_platform_id"
        data-table="main_buses"
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
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_platform_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_platform_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_platform_id" id="o<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_platform_id" class="form-group">
<?php $Grid->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_platform_id"
        name="x<?= $Grid->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Grid->platform_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_platform_id"
        data-table="main_buses"
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
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_platform_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_platform_id">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<?= $Grid->platform_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_platform_id" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_platform_id" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_platform_id" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_platform_id" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id" <?= $Grid->operator_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_operator_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_operator_id"
        name="x<?= $Grid->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Grid->operator_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_operator_id"
        data-table="main_buses"
        data-field="x_operator_id"
        data-value-separator="<?= $Grid->operator_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->operator_id->getPlaceHolder()) ?>"
        <?= $Grid->operator_id->editAttributes() ?>>
        <?= $Grid->operator_id->selectOptionListHtml("x{$Grid->RowIndex}_operator_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->operator_id->getErrorMessage() ?></div>
<?= $Grid->operator_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_operator_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_operator_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_operator_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_operator_id" id="o<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_operator_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_operator_id"
        name="x<?= $Grid->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Grid->operator_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_operator_id"
        data-table="main_buses"
        data-field="x_operator_id"
        data-value-separator="<?= $Grid->operator_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->operator_id->getPlaceHolder()) ?>"
        <?= $Grid->operator_id->editAttributes() ?>>
        <?= $Grid->operator_id->selectOptionListHtml("x{$Grid->RowIndex}_operator_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->operator_id->getErrorMessage() ?></div>
<?= $Grid->operator_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_operator_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_operator_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_operator_id">
<span<?= $Grid->operator_id->viewAttributes() ?>>
<?= $Grid->operator_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_operator_id" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_operator_id" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_operator_id" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_operator_id" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <td data-name="exterior_campaign_id" <?= $Grid->exterior_campaign_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_exterior_campaign_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_exterior_campaign_id"
        name="x<?= $Grid->RowIndex ?>_exterior_campaign_id"
        class="form-control ew-select<?= $Grid->exterior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_exterior_campaign_id"
        data-table="main_buses"
        data-field="x_exterior_campaign_id"
        data-value-separator="<?= $Grid->exterior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->exterior_campaign_id->getPlaceHolder()) ?>"
        <?= $Grid->exterior_campaign_id->editAttributes() ?>>
        <?= $Grid->exterior_campaign_id->selectOptionListHtml("x{$Grid->RowIndex}_exterior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->exterior_campaign_id->getErrorMessage() ?></div>
<?= $Grid->exterior_campaign_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_exterior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_exterior_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_exterior_campaign_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_exterior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.exterior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_exterior_campaign_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_exterior_campaign_id" id="o<?= $Grid->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Grid->exterior_campaign_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_exterior_campaign_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_exterior_campaign_id"
        name="x<?= $Grid->RowIndex ?>_exterior_campaign_id"
        class="form-control ew-select<?= $Grid->exterior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_exterior_campaign_id"
        data-table="main_buses"
        data-field="x_exterior_campaign_id"
        data-value-separator="<?= $Grid->exterior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->exterior_campaign_id->getPlaceHolder()) ?>"
        <?= $Grid->exterior_campaign_id->editAttributes() ?>>
        <?= $Grid->exterior_campaign_id->selectOptionListHtml("x{$Grid->RowIndex}_exterior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->exterior_campaign_id->getErrorMessage() ?></div>
<?= $Grid->exterior_campaign_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_exterior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_exterior_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_exterior_campaign_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_exterior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.exterior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_exterior_campaign_id">
<span<?= $Grid->exterior_campaign_id->viewAttributes() ?>>
<?= $Grid->exterior_campaign_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_exterior_campaign_id" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_exterior_campaign_id" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Grid->exterior_campaign_id->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_exterior_campaign_id" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_exterior_campaign_id" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Grid->exterior_campaign_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <td data-name="interior_campaign_id" <?= $Grid->interior_campaign_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_interior_campaign_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_interior_campaign_id"
        name="x<?= $Grid->RowIndex ?>_interior_campaign_id"
        class="form-control ew-select<?= $Grid->interior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_interior_campaign_id"
        data-table="main_buses"
        data-field="x_interior_campaign_id"
        data-value-separator="<?= $Grid->interior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->interior_campaign_id->getPlaceHolder()) ?>"
        <?= $Grid->interior_campaign_id->editAttributes() ?>>
        <?= $Grid->interior_campaign_id->selectOptionListHtml("x{$Grid->RowIndex}_interior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->interior_campaign_id->getErrorMessage() ?></div>
<?= $Grid->interior_campaign_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_interior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_interior_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_interior_campaign_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_interior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.interior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_interior_campaign_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_interior_campaign_id" id="o<?= $Grid->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Grid->interior_campaign_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_interior_campaign_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_interior_campaign_id"
        name="x<?= $Grid->RowIndex ?>_interior_campaign_id"
        class="form-control ew-select<?= $Grid->interior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_interior_campaign_id"
        data-table="main_buses"
        data-field="x_interior_campaign_id"
        data-value-separator="<?= $Grid->interior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->interior_campaign_id->getPlaceHolder()) ?>"
        <?= $Grid->interior_campaign_id->editAttributes() ?>>
        <?= $Grid->interior_campaign_id->selectOptionListHtml("x{$Grid->RowIndex}_interior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->interior_campaign_id->getErrorMessage() ?></div>
<?= $Grid->interior_campaign_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_interior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_interior_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_interior_campaign_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_interior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.interior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_interior_campaign_id">
<span<?= $Grid->interior_campaign_id->viewAttributes() ?>>
<?= $Grid->interior_campaign_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_interior_campaign_id" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_interior_campaign_id" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Grid->interior_campaign_id->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_interior_campaign_id" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_interior_campaign_id" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Grid->interior_campaign_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bus_status_id->Visible) { // bus_status_id ?>
        <td data-name="bus_status_id" <?= $Grid->bus_status_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->bus_status_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_status_id" class="form-group">
<span<?= $Grid->bus_status_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_status_id->getDisplayValue($Grid->bus_status_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_status_id" name="x<?= $Grid->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Grid->bus_status_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_status_id"
        name="x<?= $Grid->RowIndex ?>_bus_status_id"
        class="form-control ew-select<?= $Grid->bus_status_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_bus_status_id"
        data-table="main_buses"
        data-field="x_bus_status_id"
        data-value-separator="<?= $Grid->bus_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_status_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_status_id->editAttributes() ?>>
        <?= $Grid->bus_status_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_status_id->getErrorMessage() ?></div>
<?= $Grid->bus_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_bus_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_status_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_bus_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_bus_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_status_id" id="o<?= $Grid->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Grid->bus_status_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->bus_status_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_status_id" class="form-group">
<span<?= $Grid->bus_status_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_status_id->getDisplayValue($Grid->bus_status_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_status_id" name="x<?= $Grid->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Grid->bus_status_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_status_id"
        name="x<?= $Grid->RowIndex ?>_bus_status_id"
        class="form-control ew-select<?= $Grid->bus_status_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_bus_status_id"
        data-table="main_buses"
        data-field="x_bus_status_id"
        data-value-separator="<?= $Grid->bus_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_status_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_status_id->editAttributes() ?>>
        <?= $Grid->bus_status_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_status_id->getErrorMessage() ?></div>
<?= $Grid->bus_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_bus_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_status_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_bus_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_status_id">
<span<?= $Grid->bus_status_id->viewAttributes() ?>>
<?= $Grid->bus_status_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_bus_status_id" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_bus_status_id" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Grid->bus_status_id->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_bus_status_id" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_bus_status_id" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Grid->bus_status_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bus_size_id->Visible) { // bus_size_id ?>
        <td data-name="bus_size_id" <?= $Grid->bus_size_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->bus_size_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_size_id" class="form-group">
<span<?= $Grid->bus_size_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_size_id->getDisplayValue($Grid->bus_size_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_size_id" name="x<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_size_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_size_id"
        name="x<?= $Grid->RowIndex ?>_bus_size_id"
        class="form-control ew-select<?= $Grid->bus_size_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_bus_size_id"
        data-table="main_buses"
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
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_bus_size_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_size_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_bus_size_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_size_id" id="o<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->bus_size_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_size_id" class="form-group">
<span<?= $Grid->bus_size_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_size_id->getDisplayValue($Grid->bus_size_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_size_id" name="x<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_size_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_size_id"
        name="x<?= $Grid->RowIndex ?>_bus_size_id"
        class="form-control ew-select<?= $Grid->bus_size_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_bus_size_id"
        data-table="main_buses"
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
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_bus_size_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_size_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_size_id">
<span<?= $Grid->bus_size_id->viewAttributes() ?>>
<?= $Grid->bus_size_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_bus_size_id" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_bus_size_id" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_bus_size_id" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_bus_size_id" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bus_depot_id->Visible) { // bus_depot_id ?>
        <td data-name="bus_depot_id" <?= $Grid->bus_depot_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->bus_depot_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_depot_id" class="form-group">
<span<?= $Grid->bus_depot_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_depot_id->getDisplayValue($Grid->bus_depot_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_depot_id" name="x<?= $Grid->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Grid->bus_depot_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_depot_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_depot_id"
        name="x<?= $Grid->RowIndex ?>_bus_depot_id"
        class="form-control ew-select<?= $Grid->bus_depot_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_bus_depot_id"
        data-table="main_buses"
        data-field="x_bus_depot_id"
        data-value-separator="<?= $Grid->bus_depot_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_depot_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_depot_id->editAttributes() ?>>
        <?= $Grid->bus_depot_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_depot_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_depot_id->getErrorMessage() ?></div>
<?= $Grid->bus_depot_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_depot_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_bus_depot_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_depot_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_bus_depot_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_depot_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_bus_depot_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_depot_id" id="o<?= $Grid->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Grid->bus_depot_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->bus_depot_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_depot_id" class="form-group">
<span<?= $Grid->bus_depot_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_depot_id->getDisplayValue($Grid->bus_depot_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_depot_id" name="x<?= $Grid->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Grid->bus_depot_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_depot_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_depot_id"
        name="x<?= $Grid->RowIndex ?>_bus_depot_id"
        class="form-control ew-select<?= $Grid->bus_depot_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_bus_depot_id"
        data-table="main_buses"
        data-field="x_bus_depot_id"
        data-value-separator="<?= $Grid->bus_depot_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_depot_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_depot_id->editAttributes() ?>>
        <?= $Grid->bus_depot_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_depot_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_depot_id->getErrorMessage() ?></div>
<?= $Grid->bus_depot_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_depot_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_bus_depot_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_depot_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_bus_depot_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_depot_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_bus_depot_id">
<span<?= $Grid->bus_depot_id->viewAttributes() ?>>
<?= $Grid->bus_depot_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_bus_depot_id" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_bus_depot_id" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Grid->bus_depot_id->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_bus_depot_id" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_bus_depot_id" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Grid->bus_depot_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ts_last_update->Visible) { // ts_last_update ?>
        <td data-name="ts_last_update" <?= $Grid->ts_last_update->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_ts_last_update" class="form-group">
<input type="<?= $Grid->ts_last_update->getInputTextType() ?>" data-table="main_buses" data-field="x_ts_last_update" data-format="1" name="x<?= $Grid->RowIndex ?>_ts_last_update" id="x<?= $Grid->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Grid->ts_last_update->getPlaceHolder()) ?>" value="<?= $Grid->ts_last_update->EditValue ?>"<?= $Grid->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Grid->ts_last_update->ReadOnly && !$Grid->ts_last_update->Disabled && !isset($Grid->ts_last_update->EditAttrs["readonly"]) && !isset($Grid->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_busesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_busesgrid", "x<?= $Grid->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":1});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_buses" data-field="x_ts_last_update" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ts_last_update" id="o<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_ts_last_update" class="form-group">
<input type="<?= $Grid->ts_last_update->getInputTextType() ?>" data-table="main_buses" data-field="x_ts_last_update" data-format="1" name="x<?= $Grid->RowIndex ?>_ts_last_update" id="x<?= $Grid->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Grid->ts_last_update->getPlaceHolder()) ?>" value="<?= $Grid->ts_last_update->EditValue ?>"<?= $Grid->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Grid->ts_last_update->ReadOnly && !$Grid->ts_last_update->Disabled && !isset($Grid->ts_last_update->EditAttrs["readonly"]) && !isset($Grid->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_busesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_busesgrid", "x<?= $Grid->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":1});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_buses_ts_last_update">
<span<?= $Grid->ts_last_update->viewAttributes() ?>>
<?= $Grid->ts_last_update->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_buses" data-field="x_ts_last_update" data-hidden="1" name="fmain_busesgrid$x<?= $Grid->RowIndex ?>_ts_last_update" id="fmain_busesgrid$x<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->FormValue) ?>">
<input type="hidden" data-table="main_buses" data-field="x_ts_last_update" data-hidden="1" name="fmain_busesgrid$o<?= $Grid->RowIndex ?>_ts_last_update" id="fmain_busesgrid$o<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->OldValue) ?>">
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
loadjs.ready(["fmain_busesgrid","load"], function () {
    fmain_busesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_main_buses", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_main_buses_id" class="form-group main_buses_id"></span>
<?php } else { ?>
<span id="el$rowindex$_main_buses_id" class="form-group main_buses_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->number->Visible) { // number ?>
        <td data-name="number">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_buses_number" class="form-group main_buses_number">
<input type="<?= $Grid->number->getInputTextType() ?>" data-table="main_buses" data-field="x_number" name="x<?= $Grid->RowIndex ?>_number" id="x<?= $Grid->RowIndex ?>_number" size="30" placeholder="<?= HtmlEncode($Grid->number->getPlaceHolder()) ?>" value="<?= $Grid->number->EditValue ?>"<?= $Grid->number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->number->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_buses_number" class="form-group main_buses_number">
<span<?= $Grid->number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->number->getDisplayValue($Grid->number->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_number" data-hidden="1" name="x<?= $Grid->RowIndex ?>_number" id="x<?= $Grid->RowIndex ?>_number" value="<?= HtmlEncode($Grid->number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_number" id="o<?= $Grid->RowIndex ?>_number" value="<?= HtmlEncode($Grid->number->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_buses_platform_id" class="form-group main_buses_platform_id">
<?php $Grid->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_platform_id"
        name="x<?= $Grid->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Grid->platform_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_platform_id"
        data-table="main_buses"
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
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_platform_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_buses_platform_id" class="form-group main_buses_platform_id">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->platform_id->getDisplayValue($Grid->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_platform_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_platform_id" id="x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_platform_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_platform_id" id="o<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_buses_operator_id" class="form-group main_buses_operator_id">
    <select
        id="x<?= $Grid->RowIndex ?>_operator_id"
        name="x<?= $Grid->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Grid->operator_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_operator_id"
        data-table="main_buses"
        data-field="x_operator_id"
        data-value-separator="<?= $Grid->operator_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->operator_id->getPlaceHolder()) ?>"
        <?= $Grid->operator_id->editAttributes() ?>>
        <?= $Grid->operator_id->selectOptionListHtml("x{$Grid->RowIndex}_operator_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->operator_id->getErrorMessage() ?></div>
<?= $Grid->operator_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_operator_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_operator_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_buses_operator_id" class="form-group main_buses_operator_id">
<span<?= $Grid->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->operator_id->getDisplayValue($Grid->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_operator_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_operator_id" id="x<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_operator_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_operator_id" id="o<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <td data-name="exterior_campaign_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_buses_exterior_campaign_id" class="form-group main_buses_exterior_campaign_id">
    <select
        id="x<?= $Grid->RowIndex ?>_exterior_campaign_id"
        name="x<?= $Grid->RowIndex ?>_exterior_campaign_id"
        class="form-control ew-select<?= $Grid->exterior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_exterior_campaign_id"
        data-table="main_buses"
        data-field="x_exterior_campaign_id"
        data-value-separator="<?= $Grid->exterior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->exterior_campaign_id->getPlaceHolder()) ?>"
        <?= $Grid->exterior_campaign_id->editAttributes() ?>>
        <?= $Grid->exterior_campaign_id->selectOptionListHtml("x{$Grid->RowIndex}_exterior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->exterior_campaign_id->getErrorMessage() ?></div>
<?= $Grid->exterior_campaign_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_exterior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_exterior_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_exterior_campaign_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_exterior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.exterior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_buses_exterior_campaign_id" class="form-group main_buses_exterior_campaign_id">
<span<?= $Grid->exterior_campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->exterior_campaign_id->getDisplayValue($Grid->exterior_campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_exterior_campaign_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_exterior_campaign_id" id="x<?= $Grid->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Grid->exterior_campaign_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_exterior_campaign_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_exterior_campaign_id" id="o<?= $Grid->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Grid->exterior_campaign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <td data-name="interior_campaign_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_buses_interior_campaign_id" class="form-group main_buses_interior_campaign_id">
    <select
        id="x<?= $Grid->RowIndex ?>_interior_campaign_id"
        name="x<?= $Grid->RowIndex ?>_interior_campaign_id"
        class="form-control ew-select<?= $Grid->interior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_interior_campaign_id"
        data-table="main_buses"
        data-field="x_interior_campaign_id"
        data-value-separator="<?= $Grid->interior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->interior_campaign_id->getPlaceHolder()) ?>"
        <?= $Grid->interior_campaign_id->editAttributes() ?>>
        <?= $Grid->interior_campaign_id->selectOptionListHtml("x{$Grid->RowIndex}_interior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->interior_campaign_id->getErrorMessage() ?></div>
<?= $Grid->interior_campaign_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_interior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_interior_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_interior_campaign_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_interior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.interior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_buses_interior_campaign_id" class="form-group main_buses_interior_campaign_id">
<span<?= $Grid->interior_campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->interior_campaign_id->getDisplayValue($Grid->interior_campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_interior_campaign_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_interior_campaign_id" id="x<?= $Grid->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Grid->interior_campaign_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_interior_campaign_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_interior_campaign_id" id="o<?= $Grid->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Grid->interior_campaign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bus_status_id->Visible) { // bus_status_id ?>
        <td data-name="bus_status_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->bus_status_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_buses_bus_status_id" class="form-group main_buses_bus_status_id">
<span<?= $Grid->bus_status_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_status_id->getDisplayValue($Grid->bus_status_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_status_id" name="x<?= $Grid->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Grid->bus_status_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_buses_bus_status_id" class="form-group main_buses_bus_status_id">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_status_id"
        name="x<?= $Grid->RowIndex ?>_bus_status_id"
        class="form-control ew-select<?= $Grid->bus_status_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_bus_status_id"
        data-table="main_buses"
        data-field="x_bus_status_id"
        data-value-separator="<?= $Grid->bus_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_status_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_status_id->editAttributes() ?>>
        <?= $Grid->bus_status_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_status_id->getErrorMessage() ?></div>
<?= $Grid->bus_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_bus_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_status_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_bus_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_buses_bus_status_id" class="form-group main_buses_bus_status_id">
<span<?= $Grid->bus_status_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_status_id->getDisplayValue($Grid->bus_status_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_bus_status_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bus_status_id" id="x<?= $Grid->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Grid->bus_status_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_bus_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_status_id" id="o<?= $Grid->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Grid->bus_status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bus_size_id->Visible) { // bus_size_id ?>
        <td data-name="bus_size_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->bus_size_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_buses_bus_size_id" class="form-group main_buses_bus_size_id">
<span<?= $Grid->bus_size_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_size_id->getDisplayValue($Grid->bus_size_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_size_id" name="x<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_buses_bus_size_id" class="form-group main_buses_bus_size_id">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_size_id"
        name="x<?= $Grid->RowIndex ?>_bus_size_id"
        class="form-control ew-select<?= $Grid->bus_size_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_bus_size_id"
        data-table="main_buses"
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
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_bus_size_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_size_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_buses_bus_size_id" class="form-group main_buses_bus_size_id">
<span<?= $Grid->bus_size_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_size_id->getDisplayValue($Grid->bus_size_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_bus_size_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bus_size_id" id="x<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_bus_size_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_size_id" id="o<?= $Grid->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Grid->bus_size_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bus_depot_id->Visible) { // bus_depot_id ?>
        <td data-name="bus_depot_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->bus_depot_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_buses_bus_depot_id" class="form-group main_buses_bus_depot_id">
<span<?= $Grid->bus_depot_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_depot_id->getDisplayValue($Grid->bus_depot_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_bus_depot_id" name="x<?= $Grid->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Grid->bus_depot_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_buses_bus_depot_id" class="form-group main_buses_bus_depot_id">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_depot_id"
        name="x<?= $Grid->RowIndex ?>_bus_depot_id"
        class="form-control ew-select<?= $Grid->bus_depot_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Grid->RowIndex ?>_bus_depot_id"
        data-table="main_buses"
        data-field="x_bus_depot_id"
        data-value-separator="<?= $Grid->bus_depot_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->bus_depot_id->getPlaceHolder()) ?>"
        <?= $Grid->bus_depot_id->editAttributes() ?>>
        <?= $Grid->bus_depot_id->selectOptionListHtml("x{$Grid->RowIndex}_bus_depot_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->bus_depot_id->getErrorMessage() ?></div>
<?= $Grid->bus_depot_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_bus_depot_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Grid->RowIndex ?>_bus_depot_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_depot_id", selectId: "main_buses_x<?= $Grid->RowIndex ?>_bus_depot_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_depot_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_buses_bus_depot_id" class="form-group main_buses_bus_depot_id">
<span<?= $Grid->bus_depot_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_depot_id->getDisplayValue($Grid->bus_depot_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_bus_depot_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bus_depot_id" id="x<?= $Grid->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Grid->bus_depot_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_bus_depot_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_depot_id" id="o<?= $Grid->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Grid->bus_depot_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ts_last_update->Visible) { // ts_last_update ?>
        <td data-name="ts_last_update">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_buses_ts_last_update" class="form-group main_buses_ts_last_update">
<input type="<?= $Grid->ts_last_update->getInputTextType() ?>" data-table="main_buses" data-field="x_ts_last_update" data-format="1" name="x<?= $Grid->RowIndex ?>_ts_last_update" id="x<?= $Grid->RowIndex ?>_ts_last_update" placeholder="<?= HtmlEncode($Grid->ts_last_update->getPlaceHolder()) ?>" value="<?= $Grid->ts_last_update->EditValue ?>"<?= $Grid->ts_last_update->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Grid->ts_last_update->ReadOnly && !$Grid->ts_last_update->Disabled && !isset($Grid->ts_last_update->EditAttrs["readonly"]) && !isset($Grid->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_busesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_busesgrid", "x<?= $Grid->RowIndex ?>_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":1});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_buses_ts_last_update" class="form-group main_buses_ts_last_update">
<span<?= $Grid->ts_last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ts_last_update->getDisplayValue($Grid->ts_last_update->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_ts_last_update" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ts_last_update" id="x<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_ts_last_update" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ts_last_update" id="o<?= $Grid->RowIndex ?>_ts_last_update" value="<?= HtmlEncode($Grid->ts_last_update->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fmain_busesgrid","load"], function() {
    fmain_busesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fmain_busesgrid">
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
    ew.addEventHandlers("main_buses");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

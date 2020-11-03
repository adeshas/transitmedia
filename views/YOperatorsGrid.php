<?php

namespace PHPMaker2021\test;

// Set up and run Grid object
$Grid = Container("YOperatorsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
if (!ew.vars.tables.y_operators) ew.vars.tables.y_operators = <?= JsonEncode(GetClientVar("tables", "y_operators")) ?>;
var currentForm, currentPageID;
var fy_operatorsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fy_operatorsgrid = new ew.Form("fy_operatorsgrid", "grid");
    fy_operatorsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var fields = ew.vars.tables.y_operators.fields;
    fy_operatorsgrid.addFields([
        ["id", [fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["name", [fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["shortname", [fields.shortname.required ? ew.Validators.required(fields.shortname.caption) : null], fields.shortname.isInvalid],
        ["platform_id", [fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fy_operatorsgrid,
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
    fy_operatorsgrid.validate = function () {
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
    fy_operatorsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "name", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "shortname", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "platform_id", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fy_operatorsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fy_operatorsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fy_operatorsgrid.lists.platform_id = <?= $Grid->platform_id->toClientList($Grid) ?>;
    loadjs.done("fy_operatorsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> y_operators">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fy_operatorsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_y_operators" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_y_operatorsgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_y_operators_id" class="y_operators_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Grid->name->headerCellClass() ?>"><div id="elh_y_operators_name" class="y_operators_name"><?= $Grid->renderSort($Grid->name) ?></div></th>
<?php } ?>
<?php if ($Grid->shortname->Visible) { // shortname ?>
        <th data-name="shortname" class="<?= $Grid->shortname->headerCellClass() ?>"><div id="elh_y_operators_shortname" class="y_operators_shortname"><?= $Grid->renderSort($Grid->shortname) ?></div></th>
<?php } ?>
<?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <th data-name="platform_id" class="<?= $Grid->platform_id->headerCellClass() ?>"><div id="elh_y_operators_platform_id" class="y_operators_platform_id"><?= $Grid->renderSort($Grid->platform_id) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_y_operators", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_y_operators_id" class="form-group"></span>
<input type="hidden" data-table="y_operators" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="y_operators" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="y_operators" data-field="x_id" data-hidden="1" name="fy_operatorsgrid$x<?= $Grid->RowIndex ?>_id" id="fy_operatorsgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="y_operators" data-field="x_id" data-hidden="1" name="fy_operatorsgrid$o<?= $Grid->RowIndex ?>_id" id="fy_operatorsgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name" <?= $Grid->name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_name" class="form-group">
<input type="<?= $Grid->name->getInputTextType() ?>" data-table="y_operators" data-field="x_name" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>" value="<?= $Grid->name->EditValue ?>"<?= $Grid->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="y_operators" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_name" class="form-group">
<input type="<?= $Grid->name->getInputTextType() ?>" data-table="y_operators" data-field="x_name" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>" value="<?= $Grid->name->EditValue ?>"<?= $Grid->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_name">
<span<?= $Grid->name->viewAttributes() ?>>
<?= $Grid->name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="y_operators" data-field="x_name" data-hidden="1" name="fy_operatorsgrid$x<?= $Grid->RowIndex ?>_name" id="fy_operatorsgrid$x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
<input type="hidden" data-table="y_operators" data-field="x_name" data-hidden="1" name="fy_operatorsgrid$o<?= $Grid->RowIndex ?>_name" id="fy_operatorsgrid$o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->shortname->Visible) { // shortname ?>
        <td data-name="shortname" <?= $Grid->shortname->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_shortname" class="form-group">
<input type="<?= $Grid->shortname->getInputTextType() ?>" data-table="y_operators" data-field="x_shortname" name="x<?= $Grid->RowIndex ?>_shortname" id="x<?= $Grid->RowIndex ?>_shortname" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->shortname->getPlaceHolder()) ?>" value="<?= $Grid->shortname->EditValue ?>"<?= $Grid->shortname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->shortname->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="y_operators" data-field="x_shortname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_shortname" id="o<?= $Grid->RowIndex ?>_shortname" value="<?= HtmlEncode($Grid->shortname->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_shortname" class="form-group">
<input type="<?= $Grid->shortname->getInputTextType() ?>" data-table="y_operators" data-field="x_shortname" name="x<?= $Grid->RowIndex ?>_shortname" id="x<?= $Grid->RowIndex ?>_shortname" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->shortname->getPlaceHolder()) ?>" value="<?= $Grid->shortname->EditValue ?>"<?= $Grid->shortname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->shortname->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_shortname">
<span<?= $Grid->shortname->viewAttributes() ?>>
<?= $Grid->shortname->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="y_operators" data-field="x_shortname" data-hidden="1" name="fy_operatorsgrid$x<?= $Grid->RowIndex ?>_shortname" id="fy_operatorsgrid$x<?= $Grid->RowIndex ?>_shortname" value="<?= HtmlEncode($Grid->shortname->FormValue) ?>">
<input type="hidden" data-table="y_operators" data-field="x_shortname" data-hidden="1" name="fy_operatorsgrid$o<?= $Grid->RowIndex ?>_shortname" id="fy_operatorsgrid$o<?= $Grid->RowIndex ?>_shortname" value="<?= HtmlEncode($Grid->shortname->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id" <?= $Grid->platform_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->platform_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_platform_id" class="form-group">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->platform_id->getDisplayValue($Grid->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_platform_id" name="x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_platform_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_platform_id"
        name="x<?= $Grid->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Grid->platform_id->isInvalidClass() ?>"
        data-select2-id="y_operators_x<?= $Grid->RowIndex ?>_platform_id"
        data-table="y_operators"
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
    var el = document.querySelector("select[data-select2-id='y_operators_x<?= $Grid->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_platform_id", selectId: "y_operators_x<?= $Grid->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.y_operators.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="y_operators" data-field="x_platform_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_platform_id" id="o<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->platform_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_platform_id" class="form-group">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->platform_id->getDisplayValue($Grid->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_platform_id" name="x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_platform_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_platform_id"
        name="x<?= $Grid->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Grid->platform_id->isInvalidClass() ?>"
        data-select2-id="y_operators_x<?= $Grid->RowIndex ?>_platform_id"
        data-table="y_operators"
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
    var el = document.querySelector("select[data-select2-id='y_operators_x<?= $Grid->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_platform_id", selectId: "y_operators_x<?= $Grid->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.y_operators.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_y_operators_platform_id">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<?= $Grid->platform_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="y_operators" data-field="x_platform_id" data-hidden="1" name="fy_operatorsgrid$x<?= $Grid->RowIndex ?>_platform_id" id="fy_operatorsgrid$x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->FormValue) ?>">
<input type="hidden" data-table="y_operators" data-field="x_platform_id" data-hidden="1" name="fy_operatorsgrid$o<?= $Grid->RowIndex ?>_platform_id" id="fy_operatorsgrid$o<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->OldValue) ?>">
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
loadjs.ready(["fy_operatorsgrid","load"], function () {
    fy_operatorsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_y_operators", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_y_operators_id" class="form-group y_operators_id"></span>
<?php } else { ?>
<span id="el$rowindex$_y_operators_id" class="form-group y_operators_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="y_operators" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="y_operators" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_y_operators_name" class="form-group y_operators_name">
<input type="<?= $Grid->name->getInputTextType() ?>" data-table="y_operators" data-field="x_name" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>" value="<?= $Grid->name->EditValue ?>"<?= $Grid->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_y_operators_name" class="form-group y_operators_name">
<span<?= $Grid->name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->name->getDisplayValue($Grid->name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="y_operators" data-field="x_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="y_operators" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->shortname->Visible) { // shortname ?>
        <td data-name="shortname">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_y_operators_shortname" class="form-group y_operators_shortname">
<input type="<?= $Grid->shortname->getInputTextType() ?>" data-table="y_operators" data-field="x_shortname" name="x<?= $Grid->RowIndex ?>_shortname" id="x<?= $Grid->RowIndex ?>_shortname" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->shortname->getPlaceHolder()) ?>" value="<?= $Grid->shortname->EditValue ?>"<?= $Grid->shortname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->shortname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_y_operators_shortname" class="form-group y_operators_shortname">
<span<?= $Grid->shortname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->shortname->getDisplayValue($Grid->shortname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="y_operators" data-field="x_shortname" data-hidden="1" name="x<?= $Grid->RowIndex ?>_shortname" id="x<?= $Grid->RowIndex ?>_shortname" value="<?= HtmlEncode($Grid->shortname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="y_operators" data-field="x_shortname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_shortname" id="o<?= $Grid->RowIndex ?>_shortname" value="<?= HtmlEncode($Grid->shortname->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->platform_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_y_operators_platform_id" class="form-group y_operators_platform_id">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->platform_id->getDisplayValue($Grid->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_platform_id" name="x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_y_operators_platform_id" class="form-group y_operators_platform_id">
    <select
        id="x<?= $Grid->RowIndex ?>_platform_id"
        name="x<?= $Grid->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Grid->platform_id->isInvalidClass() ?>"
        data-select2-id="y_operators_x<?= $Grid->RowIndex ?>_platform_id"
        data-table="y_operators"
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
    var el = document.querySelector("select[data-select2-id='y_operators_x<?= $Grid->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_platform_id", selectId: "y_operators_x<?= $Grid->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.y_operators.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_y_operators_platform_id" class="form-group y_operators_platform_id">
<span<?= $Grid->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->platform_id->getDisplayValue($Grid->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="y_operators" data-field="x_platform_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_platform_id" id="x<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="y_operators" data-field="x_platform_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_platform_id" id="o<?= $Grid->RowIndex ?>_platform_id" value="<?= HtmlEncode($Grid->platform_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fy_operatorsgrid","load"], function() {
    fy_operatorsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fy_operatorsgrid">
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
    ew.addEventHandlers("y_operators");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

<?php

namespace PHPMaker2021\test;

// Set up and run Grid object
$Grid = Container("SubTransactionDetailsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
if (!ew.vars.tables.sub_transaction_details) ew.vars.tables.sub_transaction_details = <?= JsonEncode(GetClientVar("tables", "sub_transaction_details")) ?>;
var currentForm, currentPageID;
var fsub_transaction_detailsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fsub_transaction_detailsgrid = new ew.Form("fsub_transaction_detailsgrid", "grid");
    fsub_transaction_detailsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var fields = ew.vars.tables.sub_transaction_details.fields;
    fsub_transaction_detailsgrid.addFields([
        ["transaction_id", [fields.transaction_id.required ? ew.Validators.required(fields.transaction_id.caption) : null], fields.transaction_id.isInvalid],
        ["bus_id", [fields.bus_id.required ? ew.Validators.required(fields.bus_id.caption) : null], fields.bus_id.isInvalid],
        ["vendor_id", [fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null, ew.Validators.integer], fields.vendor_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsub_transaction_detailsgrid,
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
    fsub_transaction_detailsgrid.validate = function () {
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
    fsub_transaction_detailsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "transaction_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bus_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "vendor_id", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsub_transaction_detailsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_transaction_detailsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsub_transaction_detailsgrid.lists.transaction_id = <?= $Grid->transaction_id->toClientList($Grid) ?>;
    fsub_transaction_detailsgrid.lists.bus_id = <?= $Grid->bus_id->toClientList($Grid) ?>;
    fsub_transaction_detailsgrid.lists.vendor_id = <?= $Grid->vendor_id->toClientList($Grid) ?>;
    loadjs.done("fsub_transaction_detailsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> sub_transaction_details">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fsub_transaction_detailsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_sub_transaction_details" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_sub_transaction_detailsgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->transaction_id->Visible) { // transaction_id ?>
        <th data-name="transaction_id" class="<?= $Grid->transaction_id->headerCellClass() ?>"><div id="elh_sub_transaction_details_transaction_id" class="sub_transaction_details_transaction_id"><?= $Grid->renderSort($Grid->transaction_id) ?></div></th>
<?php } ?>
<?php if ($Grid->bus_id->Visible) { // bus_id ?>
        <th data-name="bus_id" class="<?= $Grid->bus_id->headerCellClass() ?>"><div id="elh_sub_transaction_details_bus_id" class="sub_transaction_details_bus_id"><?= $Grid->renderSort($Grid->bus_id) ?></div></th>
<?php } ?>
<?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <th data-name="vendor_id" class="<?= $Grid->vendor_id->headerCellClass() ?>"><div id="elh_sub_transaction_details_vendor_id" class="sub_transaction_details_vendor_id"><?= $Grid->renderSort($Grid->vendor_id) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_sub_transaction_details", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->transaction_id->Visible) { // transaction_id ?>
        <td data-name="transaction_id" <?= $Grid->transaction_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->transaction_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_transaction_id" class="form-group">
<span<?= $Grid->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->transaction_id->getDisplayValue($Grid->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_transaction_id" name="x<?= $Grid->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Grid->transaction_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_transaction_id" class="form-group">
<?php $Grid->transaction_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_transaction_id"
        name="x<?= $Grid->RowIndex ?>_transaction_id"
        class="form-control ew-select<?= $Grid->transaction_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Grid->RowIndex ?>_transaction_id"
        data-table="sub_transaction_details"
        data-field="x_transaction_id"
        data-value-separator="<?= $Grid->transaction_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->transaction_id->getPlaceHolder()) ?>"
        <?= $Grid->transaction_id->editAttributes() ?>>
        <?= $Grid->transaction_id->selectOptionListHtml("x{$Grid->RowIndex}_transaction_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->transaction_id->getErrorMessage() ?></div>
<?= $Grid->transaction_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_transaction_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Grid->RowIndex ?>_transaction_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_transaction_id", selectId: "sub_transaction_details_x<?= $Grid->RowIndex ?>_transaction_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.transaction_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_transaction_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_transaction_id" id="o<?= $Grid->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Grid->transaction_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->transaction_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_transaction_id" class="form-group">
<span<?= $Grid->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->transaction_id->getDisplayValue($Grid->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_transaction_id" name="x<?= $Grid->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Grid->transaction_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_transaction_id" class="form-group">
<?php $Grid->transaction_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_transaction_id"
        name="x<?= $Grid->RowIndex ?>_transaction_id"
        class="form-control ew-select<?= $Grid->transaction_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Grid->RowIndex ?>_transaction_id"
        data-table="sub_transaction_details"
        data-field="x_transaction_id"
        data-value-separator="<?= $Grid->transaction_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->transaction_id->getPlaceHolder()) ?>"
        <?= $Grid->transaction_id->editAttributes() ?>>
        <?= $Grid->transaction_id->selectOptionListHtml("x{$Grid->RowIndex}_transaction_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->transaction_id->getErrorMessage() ?></div>
<?= $Grid->transaction_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_transaction_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Grid->RowIndex ?>_transaction_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_transaction_id", selectId: "sub_transaction_details_x<?= $Grid->RowIndex ?>_transaction_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.transaction_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_transaction_id">
<span<?= $Grid->transaction_id->viewAttributes() ?>>
<?= $Grid->transaction_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_transaction_id" data-hidden="1" name="fsub_transaction_detailsgrid$x<?= $Grid->RowIndex ?>_transaction_id" id="fsub_transaction_detailsgrid$x<?= $Grid->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Grid->transaction_id->FormValue) ?>">
<input type="hidden" data-table="sub_transaction_details" data-field="x_transaction_id" data-hidden="1" name="fsub_transaction_detailsgrid$o<?= $Grid->RowIndex ?>_transaction_id" id="fsub_transaction_detailsgrid$o<?= $Grid->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Grid->transaction_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id" <?= $Grid->bus_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_bus_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_id"
        name="x<?= $Grid->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Grid->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Grid->RowIndex ?>_bus_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Grid->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_id", selectId: "sub_transaction_details_x<?= $Grid->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_bus_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_id" id="o<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_bus_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_id"
        name="x<?= $Grid->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Grid->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Grid->RowIndex ?>_bus_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Grid->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_id", selectId: "sub_transaction_details_x<?= $Grid->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_bus_id">
<span<?= $Grid->bus_id->viewAttributes() ?>>
<?= $Grid->bus_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_bus_id" data-hidden="1" name="fsub_transaction_detailsgrid$x<?= $Grid->RowIndex ?>_bus_id" id="fsub_transaction_detailsgrid$x<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->FormValue) ?>">
<input type="hidden" data-table="sub_transaction_details" data-field="x_bus_id" data-hidden="1" name="fsub_transaction_detailsgrid$o<?= $Grid->RowIndex ?>_bus_id" id="fsub_transaction_detailsgrid$o<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" <?= $Grid->vendor_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "sub_transaction_details_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_vendor_id" class="form-group">
<?php
$onchange = $Grid->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Grid->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_vendor_id" id="sv_x<?= $Grid->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Grid->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"<?= $Grid->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="sub_transaction_details" data-field="x_vendor_id" data-input="sv_x<?= $Grid->RowIndex ?>_vendor_id" data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fsub_transaction_detailsgrid"], function() {
    fsub_transaction_detailsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.sub_transaction_details.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_vendor_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_vendor_id" id="o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "sub_transaction_details_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_vendor_id" class="form-group">
<?php
$onchange = $Grid->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Grid->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_vendor_id" id="sv_x<?= $Grid->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Grid->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"<?= $Grid->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="sub_transaction_details" data-field="x_vendor_id" data-input="sv_x<?= $Grid->RowIndex ?>_vendor_id" data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fsub_transaction_detailsgrid"], function() {
    fsub_transaction_detailsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.sub_transaction_details.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_transaction_details_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<?= $Grid->vendor_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_vendor_id" data-hidden="1" name="fsub_transaction_detailsgrid$x<?= $Grid->RowIndex ?>_vendor_id" id="fsub_transaction_detailsgrid$x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->FormValue) ?>">
<input type="hidden" data-table="sub_transaction_details" data-field="x_vendor_id" data-hidden="1" name="fsub_transaction_detailsgrid$o<?= $Grid->RowIndex ?>_vendor_id" id="fsub_transaction_detailsgrid$o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
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
loadjs.ready(["fsub_transaction_detailsgrid","load"], function () {
    fsub_transaction_detailsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_sub_transaction_details", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->transaction_id->Visible) { // transaction_id ?>
        <td data-name="transaction_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->transaction_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_sub_transaction_details_transaction_id" class="form-group sub_transaction_details_transaction_id">
<span<?= $Grid->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->transaction_id->getDisplayValue($Grid->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_transaction_id" name="x<?= $Grid->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Grid->transaction_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_sub_transaction_details_transaction_id" class="form-group sub_transaction_details_transaction_id">
<?php $Grid->transaction_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_transaction_id"
        name="x<?= $Grid->RowIndex ?>_transaction_id"
        class="form-control ew-select<?= $Grid->transaction_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Grid->RowIndex ?>_transaction_id"
        data-table="sub_transaction_details"
        data-field="x_transaction_id"
        data-value-separator="<?= $Grid->transaction_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->transaction_id->getPlaceHolder()) ?>"
        <?= $Grid->transaction_id->editAttributes() ?>>
        <?= $Grid->transaction_id->selectOptionListHtml("x{$Grid->RowIndex}_transaction_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->transaction_id->getErrorMessage() ?></div>
<?= $Grid->transaction_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_transaction_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Grid->RowIndex ?>_transaction_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_transaction_id", selectId: "sub_transaction_details_x<?= $Grid->RowIndex ?>_transaction_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.transaction_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_sub_transaction_details_transaction_id" class="form-group sub_transaction_details_transaction_id">
<span<?= $Grid->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->transaction_id->getDisplayValue($Grid->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_transaction_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_transaction_id" id="x<?= $Grid->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Grid->transaction_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_transaction_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_transaction_id" id="o<?= $Grid->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Grid->transaction_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sub_transaction_details_bus_id" class="form-group sub_transaction_details_bus_id">
    <select
        id="x<?= $Grid->RowIndex ?>_bus_id"
        name="x<?= $Grid->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Grid->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Grid->RowIndex ?>_bus_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Grid->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_bus_id", selectId: "sub_transaction_details_x<?= $Grid->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_transaction_details_bus_id" class="form-group sub_transaction_details_bus_id">
<span<?= $Grid->bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bus_id->getDisplayValue($Grid->bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_bus_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bus_id" id="x<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_bus_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bus_id" id="o<?= $Grid->RowIndex ?>_bus_id" value="<?= HtmlEncode($Grid->bus_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_sub_transaction_details_vendor_id" class="form-group sub_transaction_details_vendor_id">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "sub_transaction_details_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_transaction_details_vendor_id" class="form-group sub_transaction_details_vendor_id">
<?php
$onchange = $Grid->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Grid->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_vendor_id" id="sv_x<?= $Grid->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Grid->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"<?= $Grid->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="sub_transaction_details" data-field="x_vendor_id" data-input="sv_x<?= $Grid->RowIndex ?>_vendor_id" data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fsub_transaction_detailsgrid"], function() {
    fsub_transaction_detailsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.sub_transaction_details.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_sub_transaction_details_vendor_id" class="form-group sub_transaction_details_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_vendor_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_vendor_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_vendor_id" id="o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fsub_transaction_detailsgrid","load"], function() {
    fsub_transaction_detailsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fsub_transaction_detailsgrid">
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
    ew.addEventHandlers("sub_transaction_details");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

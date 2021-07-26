<?php

namespace PHPMaker2021\test;

// Page object
$WVendorsOperatorsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_vendors_operatorslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fw_vendors_operatorslist = currentForm = new ew.Form("fw_vendors_operatorslist", "list");
    fw_vendors_operatorslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_vendors_operators")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_vendors_operators)
        ew.vars.tables.w_vendors_operators = currentTable;
    fw_vendors_operatorslist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["vendor_id", [fields.vendor_id.visible && fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null], fields.vendor_id.isInvalid],
        ["operator_id", [fields.operator_id.visible && fields.operator_id.required ? ew.Validators.required(fields.operator_id.caption) : null], fields.operator_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_vendors_operatorslist,
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
    fw_vendors_operatorslist.validate = function () {
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
    fw_vendors_operatorslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "vendor_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "operator_id", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fw_vendors_operatorslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_vendors_operatorslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_vendors_operatorslist.lists.vendor_id = <?= $Page->vendor_id->toClientList($Page) ?>;
    fw_vendors_operatorslist.lists.operator_id = <?= $Page->operator_id->toClientList($Page) ?>;
    loadjs.done("fw_vendors_operatorslist");
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
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> w_vendors_operators">
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
<form name="fw_vendors_operatorslist" id="fw_vendors_operatorslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_vendors_operators">
<div id="gmp_w_vendors_operators" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_w_vendors_operatorslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_w_vendors_operators_id" class="w_vendors_operators_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <th data-name="vendor_id" class="<?= $Page->vendor_id->headerCellClass() ?>"><div id="elh_w_vendors_operators_vendor_id" class="w_vendors_operators_vendor_id"><?= $Page->renderSort($Page->vendor_id) ?></div></th>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <th data-name="operator_id" class="<?= $Page->operator_id->headerCellClass() ?>"><div id="elh_w_vendors_operators_operator_id" class="w_vendors_operators_operator_id"><?= $Page->renderSort($Page->operator_id) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
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
if ($Page->isGridAdd())
    $Page->RowIndex = 0;
if ($Page->isGridEdit())
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
        if ($Page->isGridEdit()) { // Grid edit
            if ($Page->EventCancelled) {
                $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
            }
            if ($Page->RowAction == "insert") {
                $Page->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isGridEdit() && ($Page->RowType == ROWTYPE_EDIT || $Page->RowType == ROWTYPE_ADD) && $Page->EventCancelled) { // Update failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_w_vendors_operators", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_w_vendors_operators_id" class="form-group"></span>
<input type="hidden" data-table="w_vendors_operators" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_w_vendors_operators_id" class="form-group">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="w_vendors_operators" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_w_vendors_operators_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="w_vendors_operators" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" <?= $Page->vendor_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_w_vendors_operators_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="w_vendors_operators_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="w_vendors_operators"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_vendors_operators_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "w_vendors_operators_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_vendors_operators.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="w_vendors_operators" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_w_vendors_operators_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="w_vendors_operators_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="w_vendors_operators"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_vendors_operators_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "w_vendors_operators_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_vendors_operators.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_w_vendors_operators_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id" <?= $Page->operator_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_w_vendors_operators_operator_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_operator_id"
        name="x<?= $Page->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="w_vendors_operators_x<?= $Page->RowIndex ?>_operator_id"
        data-table="w_vendors_operators"
        data-field="x_operator_id"
        data-value-separator="<?= $Page->operator_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->operator_id->getPlaceHolder()) ?>"
        <?= $Page->operator_id->editAttributes() ?>>
        <?= $Page->operator_id->selectOptionListHtml("x{$Page->RowIndex}_operator_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->operator_id->getErrorMessage() ?></div>
<?= $Page->operator_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_operator_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_vendors_operators_x<?= $Page->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_operator_id", selectId: "w_vendors_operators_x<?= $Page->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_vendors_operators.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="w_vendors_operators" data-field="x_operator_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_operator_id" id="o<?= $Page->RowIndex ?>_operator_id" value="<?= HtmlEncode($Page->operator_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_w_vendors_operators_operator_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_operator_id"
        name="x<?= $Page->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="w_vendors_operators_x<?= $Page->RowIndex ?>_operator_id"
        data-table="w_vendors_operators"
        data-field="x_operator_id"
        data-value-separator="<?= $Page->operator_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->operator_id->getPlaceHolder()) ?>"
        <?= $Page->operator_id->editAttributes() ?>>
        <?= $Page->operator_id->selectOptionListHtml("x{$Page->RowIndex}_operator_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->operator_id->getErrorMessage() ?></div>
<?= $Page->operator_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_operator_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_vendors_operators_x<?= $Page->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_operator_id", selectId: "w_vendors_operators_x<?= $Page->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_vendors_operators.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_w_vendors_operators_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
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
loadjs.ready(["fw_vendors_operatorslist","load"], function () {
    fw_vendors_operatorslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_w_vendors_operators", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_w_vendors_operators_id" class="form-group w_vendors_operators_id"></span>
<input type="hidden" data-table="w_vendors_operators" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<span id="el$rowindex$_w_vendors_operators_vendor_id" class="form-group w_vendors_operators_vendor_id">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="w_vendors_operators_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="w_vendors_operators"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_vendors_operators_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "w_vendors_operators_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_vendors_operators.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="w_vendors_operators" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id">
<span id="el$rowindex$_w_vendors_operators_operator_id" class="form-group w_vendors_operators_operator_id">
    <select
        id="x<?= $Page->RowIndex ?>_operator_id"
        name="x<?= $Page->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="w_vendors_operators_x<?= $Page->RowIndex ?>_operator_id"
        data-table="w_vendors_operators"
        data-field="x_operator_id"
        data-value-separator="<?= $Page->operator_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->operator_id->getPlaceHolder()) ?>"
        <?= $Page->operator_id->editAttributes() ?>>
        <?= $Page->operator_id->selectOptionListHtml("x{$Page->RowIndex}_operator_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->operator_id->getErrorMessage() ?></div>
<?= $Page->operator_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_operator_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_vendors_operators_x<?= $Page->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_operator_id", selectId: "w_vendors_operators_x<?= $Page->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_vendors_operators.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="w_vendors_operators" data-field="x_operator_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_operator_id" id="o<?= $Page->RowIndex ?>_operator_id" value="<?= HtmlEncode($Page->operator_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fw_vendors_operatorslist","load"], function() {
    fw_vendors_operatorslist.updateLists(<?= $Page->RowIndex ?>);
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
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
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
    ew.addEventHandlers("w_vendors_operators");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

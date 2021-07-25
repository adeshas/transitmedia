<?php

namespace PHPMaker2021\test;

// Set up and run Grid object
$Grid = Container("MainTransactionsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmain_transactionsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fmain_transactionsgrid = new ew.Form("fmain_transactionsgrid", "grid");
    fmain_transactionsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "main_transactions")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.main_transactions)
        ew.vars.tables.main_transactions = currentTable;
    fmain_transactionsgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["campaign_id", [fields.campaign_id.visible && fields.campaign_id.required ? ew.Validators.required(fields.campaign_id.caption) : null], fields.campaign_id.isInvalid],
        ["operator_id", [fields.operator_id.visible && fields.operator_id.required ? ew.Validators.required(fields.operator_id.caption) : null], fields.operator_id.isInvalid],
        ["payment_date", [fields.payment_date.visible && fields.payment_date.required ? ew.Validators.required(fields.payment_date.caption) : null, ew.Validators.datetime(5)], fields.payment_date.isInvalid],
        ["vendor_id", [fields.vendor_id.visible && fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null, ew.Validators.integer], fields.vendor_id.isInvalid],
        ["price_id", [fields.price_id.visible && fields.price_id.required ? ew.Validators.required(fields.price_id.caption) : null], fields.price_id.isInvalid],
        ["quantity", [fields.quantity.visible && fields.quantity.required ? ew.Validators.required(fields.quantity.caption) : null, ew.Validators.integer], fields.quantity.isInvalid],
        ["assigned_buses", [fields.assigned_buses.visible && fields.assigned_buses.required ? ew.Validators.required(fields.assigned_buses.caption) : null, ew.Validators.integer], fields.assigned_buses.isInvalid],
        ["start_date", [fields.start_date.visible && fields.start_date.required ? ew.Validators.required(fields.start_date.caption) : null, ew.Validators.datetime(5)], fields.start_date.isInvalid],
        ["end_date", [fields.end_date.visible && fields.end_date.required ? ew.Validators.required(fields.end_date.caption) : null, ew.Validators.datetime(5)], fields.end_date.isInvalid],
        ["visible_status_id", [fields.visible_status_id.visible && fields.visible_status_id.required ? ew.Validators.required(fields.visible_status_id.caption) : null], fields.visible_status_id.isInvalid],
        ["status_id", [fields.status_id.visible && fields.status_id.required ? ew.Validators.required(fields.status_id.caption) : null], fields.status_id.isInvalid],
        ["print_status_id", [fields.print_status_id.visible && fields.print_status_id.required ? ew.Validators.required(fields.print_status_id.caption) : null], fields.print_status_id.isInvalid],
        ["payment_status_id", [fields.payment_status_id.visible && fields.payment_status_id.required ? ew.Validators.required(fields.payment_status_id.caption) : null], fields.payment_status_id.isInvalid],
        ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null], fields.total.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_transactionsgrid,
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
    fmain_transactionsgrid.validate = function () {
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
    fmain_transactionsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "campaign_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "operator_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "payment_date", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "vendor_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "price_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "quantity", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "assigned_buses", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "start_date", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "end_date", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "visible_status_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "status_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "print_status_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "payment_status_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "total", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fmain_transactionsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_transactionsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_transactionsgrid.lists.campaign_id = <?= $Grid->campaign_id->toClientList($Grid) ?>;
    fmain_transactionsgrid.lists.operator_id = <?= $Grid->operator_id->toClientList($Grid) ?>;
    fmain_transactionsgrid.lists.vendor_id = <?= $Grid->vendor_id->toClientList($Grid) ?>;
    fmain_transactionsgrid.lists.price_id = <?= $Grid->price_id->toClientList($Grid) ?>;
    fmain_transactionsgrid.lists.visible_status_id = <?= $Grid->visible_status_id->toClientList($Grid) ?>;
    fmain_transactionsgrid.lists.status_id = <?= $Grid->status_id->toClientList($Grid) ?>;
    fmain_transactionsgrid.lists.print_status_id = <?= $Grid->print_status_id->toClientList($Grid) ?>;
    fmain_transactionsgrid.lists.payment_status_id = <?= $Grid->payment_status_id->toClientList($Grid) ?>;
    loadjs.done("fmain_transactionsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> main_transactions">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fmain_transactionsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_main_transactions" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_main_transactionsgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_main_transactions_id" class="main_transactions_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->campaign_id->Visible) { // campaign_id ?>
        <th data-name="campaign_id" class="<?= $Grid->campaign_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_campaign_id" class="main_transactions_campaign_id"><?= $Grid->renderSort($Grid->campaign_id) ?></div></th>
<?php } ?>
<?php if ($Grid->operator_id->Visible) { // operator_id ?>
        <th data-name="operator_id" class="<?= $Grid->operator_id->headerCellClass() ?>"><div id="elh_main_transactions_operator_id" class="main_transactions_operator_id"><?= $Grid->renderSort($Grid->operator_id) ?></div></th>
<?php } ?>
<?php if ($Grid->payment_date->Visible) { // payment_date ?>
        <th data-name="payment_date" class="<?= $Grid->payment_date->headerCellClass() ?>"><div id="elh_main_transactions_payment_date" class="main_transactions_payment_date"><?= $Grid->renderSort($Grid->payment_date) ?></div></th>
<?php } ?>
<?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <th data-name="vendor_id" class="<?= $Grid->vendor_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_vendor_id" class="main_transactions_vendor_id"><?= $Grid->renderSort($Grid->vendor_id) ?></div></th>
<?php } ?>
<?php if ($Grid->price_id->Visible) { // price_id ?>
        <th data-name="price_id" class="<?= $Grid->price_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_price_id" class="main_transactions_price_id"><?= $Grid->renderSort($Grid->price_id) ?></div></th>
<?php } ?>
<?php if ($Grid->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Grid->quantity->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_quantity" class="main_transactions_quantity"><?= $Grid->renderSort($Grid->quantity) ?></div></th>
<?php } ?>
<?php if ($Grid->assigned_buses->Visible) { // assigned_buses ?>
        <th data-name="assigned_buses" class="<?= $Grid->assigned_buses->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_assigned_buses" class="main_transactions_assigned_buses"><?= $Grid->renderSort($Grid->assigned_buses) ?></div></th>
<?php } ?>
<?php if ($Grid->start_date->Visible) { // start_date ?>
        <th data-name="start_date" class="<?= $Grid->start_date->headerCellClass() ?>"><div id="elh_main_transactions_start_date" class="main_transactions_start_date"><?= $Grid->renderSort($Grid->start_date) ?></div></th>
<?php } ?>
<?php if ($Grid->end_date->Visible) { // end_date ?>
        <th data-name="end_date" class="<?= $Grid->end_date->headerCellClass() ?>"><div id="elh_main_transactions_end_date" class="main_transactions_end_date"><?= $Grid->renderSort($Grid->end_date) ?></div></th>
<?php } ?>
<?php if ($Grid->visible_status_id->Visible) { // visible_status_id ?>
        <th data-name="visible_status_id" class="<?= $Grid->visible_status_id->headerCellClass() ?>"><div id="elh_main_transactions_visible_status_id" class="main_transactions_visible_status_id"><?= $Grid->renderSort($Grid->visible_status_id) ?></div></th>
<?php } ?>
<?php if ($Grid->status_id->Visible) { // status_id ?>
        <th data-name="status_id" class="<?= $Grid->status_id->headerCellClass() ?>"><div id="elh_main_transactions_status_id" class="main_transactions_status_id"><?= $Grid->renderSort($Grid->status_id) ?></div></th>
<?php } ?>
<?php if ($Grid->print_status_id->Visible) { // print_status_id ?>
        <th data-name="print_status_id" class="<?= $Grid->print_status_id->headerCellClass() ?>"><div id="elh_main_transactions_print_status_id" class="main_transactions_print_status_id"><?= $Grid->renderSort($Grid->print_status_id) ?></div></th>
<?php } ?>
<?php if ($Grid->payment_status_id->Visible) { // payment_status_id ?>
        <th data-name="payment_status_id" class="<?= $Grid->payment_status_id->headerCellClass() ?>"><div id="elh_main_transactions_payment_status_id" class="main_transactions_payment_status_id"><?= $Grid->renderSort($Grid->payment_status_id) ?></div></th>
<?php } ?>
<?php if ($Grid->total->Visible) { // total ?>
        <th data-name="total" class="<?= $Grid->total->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_total" class="main_transactions_total"><?= $Grid->renderSort($Grid->total) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_main_transactions", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_main_transactions_id" class="form-group"></span>
<input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_id" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_id" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id" <?= $Grid->campaign_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_campaign_id" class="form-group">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->campaign_id->getDisplayValue($Grid->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_campaign_id" name="x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_campaign_id" class="form-group">
<?php $Grid->campaign_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_campaign_id"
        name="x<?= $Grid->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Grid->campaign_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_campaign_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_campaign_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_campaign_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_campaign_id" id="o<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_campaign_id" class="form-group">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->campaign_id->getDisplayValue($Grid->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_campaign_id" name="x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_campaign_id" class="form-group">
<?php $Grid->campaign_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_campaign_id"
        name="x<?= $Grid->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Grid->campaign_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_campaign_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_campaign_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_campaign_id">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<?= $Grid->campaign_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_campaign_id" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_campaign_id" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_campaign_id" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_campaign_id" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id" <?= $Grid->operator_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->operator_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_operator_id" class="form-group">
<span<?= $Grid->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->operator_id->getDisplayValue($Grid->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_operator_id" name="x<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_operator_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_operator_id"
        name="x<?= $Grid->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Grid->operator_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_operator_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_operator_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_operator_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_operator_id" id="o<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->operator_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_operator_id" class="form-group">
<span<?= $Grid->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->operator_id->getDisplayValue($Grid->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_operator_id" name="x<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_operator_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_operator_id"
        name="x<?= $Grid->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Grid->operator_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_operator_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_operator_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_operator_id">
<span<?= $Grid->operator_id->viewAttributes() ?>>
<?= $Grid->operator_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_operator_id" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_operator_id" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_operator_id" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_operator_id" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date" <?= $Grid->payment_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_payment_date" class="form-group">
<input type="<?= $Grid->payment_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_date" data-format="5" name="x<?= $Grid->RowIndex ?>_payment_date" id="x<?= $Grid->RowIndex ?>_payment_date" placeholder="<?= HtmlEncode($Grid->payment_date->getPlaceHolder()) ?>" value="<?= $Grid->payment_date->EditValue ?>"<?= $Grid->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->payment_date->getErrorMessage() ?></div>
<?php if (!$Grid->payment_date->ReadOnly && !$Grid->payment_date->Disabled && !isset($Grid->payment_date->EditAttrs["readonly"]) && !isset($Grid->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsgrid", "x<?= $Grid->RowIndex ?>_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment_date" id="o<?= $Grid->RowIndex ?>_payment_date" value="<?= HtmlEncode($Grid->payment_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_payment_date" class="form-group">
<input type="<?= $Grid->payment_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_date" data-format="5" name="x<?= $Grid->RowIndex ?>_payment_date" id="x<?= $Grid->RowIndex ?>_payment_date" placeholder="<?= HtmlEncode($Grid->payment_date->getPlaceHolder()) ?>" value="<?= $Grid->payment_date->EditValue ?>"<?= $Grid->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->payment_date->getErrorMessage() ?></div>
<?php if (!$Grid->payment_date->ReadOnly && !$Grid->payment_date->Disabled && !isset($Grid->payment_date->EditAttrs["readonly"]) && !isset($Grid->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsgrid", "x<?= $Grid->RowIndex ?>_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_payment_date">
<span<?= $Grid->payment_date->viewAttributes() ?>>
<?= $Grid->payment_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_payment_date" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_payment_date" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_payment_date" value="<?= HtmlEncode($Grid->payment_date->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_payment_date" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_payment_date" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_payment_date" value="<?= HtmlEncode($Grid->payment_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" <?= $Grid->vendor_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_vendor_id" class="form-group">
<?php
$onchange = $Grid->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Grid->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_vendor_id" id="sv_x<?= $Grid->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Grid->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"<?= $Grid->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_transactions" data-field="x_vendor_id" data-input="sv_x<?= $Grid->RowIndex ?>_vendor_id" data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_transactionsgrid"], function() {
    fmain_transactionsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.main_transactions.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_vendor_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_vendor_id" id="o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_vendor_id" class="form-group">
<?php
$onchange = $Grid->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Grid->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_vendor_id" id="sv_x<?= $Grid->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Grid->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"<?= $Grid->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_transactions" data-field="x_vendor_id" data-input="sv_x<?= $Grid->RowIndex ?>_vendor_id" data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_transactionsgrid"], function() {
    fmain_transactionsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.main_transactions.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<?= $Grid->vendor_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_vendor_id" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_vendor_id" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_vendor_id" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_vendor_id" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->price_id->Visible) { // price_id ?>
        <td data-name="price_id" <?= $Grid->price_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_price_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_price_id"
        name="x<?= $Grid->RowIndex ?>_price_id"
        class="form-control ew-select<?= $Grid->price_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_price_id"
        data-table="main_transactions"
        data-field="x_price_id"
        data-value-separator="<?= $Grid->price_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->price_id->getPlaceHolder()) ?>"
        <?= $Grid->price_id->editAttributes() ?>>
        <?= $Grid->price_id->selectOptionListHtml("x{$Grid->RowIndex}_price_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->price_id->getErrorMessage() ?></div>
<?= $Grid->price_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_price_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_price_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_price_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_price_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.price_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_price_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_price_id" id="o<?= $Grid->RowIndex ?>_price_id" value="<?= HtmlEncode($Grid->price_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_price_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_price_id"
        name="x<?= $Grid->RowIndex ?>_price_id"
        class="form-control ew-select<?= $Grid->price_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_price_id"
        data-table="main_transactions"
        data-field="x_price_id"
        data-value-separator="<?= $Grid->price_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->price_id->getPlaceHolder()) ?>"
        <?= $Grid->price_id->editAttributes() ?>>
        <?= $Grid->price_id->selectOptionListHtml("x{$Grid->RowIndex}_price_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->price_id->getErrorMessage() ?></div>
<?= $Grid->price_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_price_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_price_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_price_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_price_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.price_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_price_id">
<span<?= $Grid->price_id->viewAttributes() ?>>
<?= $Grid->price_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_price_id" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_price_id" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_price_id" value="<?= HtmlEncode($Grid->price_id->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_price_id" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_price_id" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_price_id" value="<?= HtmlEncode($Grid->price_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->quantity->Visible) { // quantity ?>
        <td data-name="quantity" <?= $Grid->quantity->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_quantity" class="form-group">
<input type="<?= $Grid->quantity->getInputTextType() ?>" data-table="main_transactions" data-field="x_quantity" name="x<?= $Grid->RowIndex ?>_quantity" id="x<?= $Grid->RowIndex ?>_quantity" size="30" placeholder="<?= HtmlEncode($Grid->quantity->getPlaceHolder()) ?>" value="<?= $Grid->quantity->EditValue ?>"<?= $Grid->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->quantity->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_quantity" data-hidden="1" name="o<?= $Grid->RowIndex ?>_quantity" id="o<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_quantity" class="form-group">
<input type="<?= $Grid->quantity->getInputTextType() ?>" data-table="main_transactions" data-field="x_quantity" name="x<?= $Grid->RowIndex ?>_quantity" id="x<?= $Grid->RowIndex ?>_quantity" size="30" placeholder="<?= HtmlEncode($Grid->quantity->getPlaceHolder()) ?>" value="<?= $Grid->quantity->EditValue ?>"<?= $Grid->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->quantity->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_quantity">
<span<?= $Grid->quantity->viewAttributes() ?>>
<?= $Grid->quantity->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_quantity" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_quantity" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_quantity" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_quantity" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->assigned_buses->Visible) { // assigned_buses ?>
        <td data-name="assigned_buses" <?= $Grid->assigned_buses->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_assigned_buses" class="form-group">
<input type="<?= $Grid->assigned_buses->getInputTextType() ?>" data-table="main_transactions" data-field="x_assigned_buses" name="x<?= $Grid->RowIndex ?>_assigned_buses" id="x<?= $Grid->RowIndex ?>_assigned_buses" size="30" placeholder="<?= HtmlEncode($Grid->assigned_buses->getPlaceHolder()) ?>" value="<?= $Grid->assigned_buses->EditValue ?>"<?= $Grid->assigned_buses->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->assigned_buses->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_assigned_buses" data-hidden="1" name="o<?= $Grid->RowIndex ?>_assigned_buses" id="o<?= $Grid->RowIndex ?>_assigned_buses" value="<?= HtmlEncode($Grid->assigned_buses->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_assigned_buses" class="form-group">
<input type="<?= $Grid->assigned_buses->getInputTextType() ?>" data-table="main_transactions" data-field="x_assigned_buses" name="x<?= $Grid->RowIndex ?>_assigned_buses" id="x<?= $Grid->RowIndex ?>_assigned_buses" size="30" placeholder="<?= HtmlEncode($Grid->assigned_buses->getPlaceHolder()) ?>" value="<?= $Grid->assigned_buses->EditValue ?>"<?= $Grid->assigned_buses->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->assigned_buses->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_assigned_buses">
<span<?= $Grid->assigned_buses->viewAttributes() ?>>
<?= $Grid->assigned_buses->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_assigned_buses" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_assigned_buses" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_assigned_buses" value="<?= HtmlEncode($Grid->assigned_buses->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_assigned_buses" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_assigned_buses" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_assigned_buses" value="<?= HtmlEncode($Grid->assigned_buses->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->start_date->Visible) { // start_date ?>
        <td data-name="start_date" <?= $Grid->start_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_start_date" class="form-group">
<input type="<?= $Grid->start_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_start_date" data-format="5" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" placeholder="<?= HtmlEncode($Grid->start_date->getPlaceHolder()) ?>" value="<?= $Grid->start_date->EditValue ?>"<?= $Grid->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->start_date->getErrorMessage() ?></div>
<?php if (!$Grid->start_date->ReadOnly && !$Grid->start_date->Disabled && !isset($Grid->start_date->EditAttrs["readonly"]) && !isset($Grid->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsgrid", "x<?= $Grid->RowIndex ?>_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_start_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_start_date" id="o<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_start_date" class="form-group">
<input type="<?= $Grid->start_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_start_date" data-format="5" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" placeholder="<?= HtmlEncode($Grid->start_date->getPlaceHolder()) ?>" value="<?= $Grid->start_date->EditValue ?>"<?= $Grid->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->start_date->getErrorMessage() ?></div>
<?php if (!$Grid->start_date->ReadOnly && !$Grid->start_date->Disabled && !isset($Grid->start_date->EditAttrs["readonly"]) && !isset($Grid->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsgrid", "x<?= $Grid->RowIndex ?>_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_start_date">
<span<?= $Grid->start_date->viewAttributes() ?>>
<?= $Grid->start_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_start_date" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_start_date" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_start_date" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_start_date" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->end_date->Visible) { // end_date ?>
        <td data-name="end_date" <?= $Grid->end_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_end_date" class="form-group">
<input type="<?= $Grid->end_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_end_date" data-format="5" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" placeholder="<?= HtmlEncode($Grid->end_date->getPlaceHolder()) ?>" value="<?= $Grid->end_date->EditValue ?>"<?= $Grid->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->end_date->getErrorMessage() ?></div>
<?php if (!$Grid->end_date->ReadOnly && !$Grid->end_date->Disabled && !isset($Grid->end_date->EditAttrs["readonly"]) && !isset($Grid->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsgrid", "x<?= $Grid->RowIndex ?>_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_end_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_end_date" id="o<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_end_date" class="form-group">
<input type="<?= $Grid->end_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_end_date" data-format="5" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" placeholder="<?= HtmlEncode($Grid->end_date->getPlaceHolder()) ?>" value="<?= $Grid->end_date->EditValue ?>"<?= $Grid->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->end_date->getErrorMessage() ?></div>
<?php if (!$Grid->end_date->ReadOnly && !$Grid->end_date->Disabled && !isset($Grid->end_date->EditAttrs["readonly"]) && !isset($Grid->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsgrid", "x<?= $Grid->RowIndex ?>_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_end_date">
<span<?= $Grid->end_date->viewAttributes() ?>>
<?= $Grid->end_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_end_date" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_end_date" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_end_date" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_end_date" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->visible_status_id->Visible) { // visible_status_id ?>
        <td data-name="visible_status_id" <?= $Grid->visible_status_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_visible_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_visible_status_id"
        name="x<?= $Grid->RowIndex ?>_visible_status_id"
        class="form-control ew-select<?= $Grid->visible_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_visible_status_id"
        data-table="main_transactions"
        data-field="x_visible_status_id"
        data-value-separator="<?= $Grid->visible_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->visible_status_id->getPlaceHolder()) ?>"
        <?= $Grid->visible_status_id->editAttributes() ?>>
        <?= $Grid->visible_status_id->selectOptionListHtml("x{$Grid->RowIndex}_visible_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->visible_status_id->getErrorMessage() ?></div>
<?= $Grid->visible_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_visible_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_visible_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_visible_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_visible_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.visible_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_visible_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_visible_status_id" id="o<?= $Grid->RowIndex ?>_visible_status_id" value="<?= HtmlEncode($Grid->visible_status_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_visible_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_visible_status_id"
        name="x<?= $Grid->RowIndex ?>_visible_status_id"
        class="form-control ew-select<?= $Grid->visible_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_visible_status_id"
        data-table="main_transactions"
        data-field="x_visible_status_id"
        data-value-separator="<?= $Grid->visible_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->visible_status_id->getPlaceHolder()) ?>"
        <?= $Grid->visible_status_id->editAttributes() ?>>
        <?= $Grid->visible_status_id->selectOptionListHtml("x{$Grid->RowIndex}_visible_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->visible_status_id->getErrorMessage() ?></div>
<?= $Grid->visible_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_visible_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_visible_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_visible_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_visible_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.visible_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_visible_status_id">
<span<?= $Grid->visible_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->visible_status_id->getViewValue()) && $Grid->visible_status_id->linkAttributes() != "") { ?>
<a<?= $Grid->visible_status_id->linkAttributes() ?>><?= $Grid->visible_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Grid->visible_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_visible_status_id" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_visible_status_id" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_visible_status_id" value="<?= HtmlEncode($Grid->visible_status_id->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_visible_status_id" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_visible_status_id" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_visible_status_id" value="<?= HtmlEncode($Grid->visible_status_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_id->Visible) { // status_id ?>
        <td data-name="status_id" <?= $Grid->status_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_status_id"
        name="x<?= $Grid->RowIndex ?>_status_id"
        class="form-control ew-select<?= $Grid->status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_status_id"
        data-table="main_transactions"
        data-field="x_status_id"
        data-value-separator="<?= $Grid->status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_id->getPlaceHolder()) ?>"
        <?= $Grid->status_id->editAttributes() ?>>
        <?= $Grid->status_id->selectOptionListHtml("x{$Grid->RowIndex}_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_id->getErrorMessage() ?></div>
<?= $Grid->status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_id" id="o<?= $Grid->RowIndex ?>_status_id" value="<?= HtmlEncode($Grid->status_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_status_id"
        name="x<?= $Grid->RowIndex ?>_status_id"
        class="form-control ew-select<?= $Grid->status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_status_id"
        data-table="main_transactions"
        data-field="x_status_id"
        data-value-separator="<?= $Grid->status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_id->getPlaceHolder()) ?>"
        <?= $Grid->status_id->editAttributes() ?>>
        <?= $Grid->status_id->selectOptionListHtml("x{$Grid->RowIndex}_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_id->getErrorMessage() ?></div>
<?= $Grid->status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_status_id">
<span<?= $Grid->status_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->status_id->getViewValue()) && $Grid->status_id->linkAttributes() != "") { ?>
<a<?= $Grid->status_id->linkAttributes() ?>><?= $Grid->status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Grid->status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_status_id" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_status_id" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_status_id" value="<?= HtmlEncode($Grid->status_id->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_status_id" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_status_id" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_status_id" value="<?= HtmlEncode($Grid->status_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->print_status_id->Visible) { // print_status_id ?>
        <td data-name="print_status_id" <?= $Grid->print_status_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_print_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_print_status_id"
        name="x<?= $Grid->RowIndex ?>_print_status_id"
        class="form-control ew-select<?= $Grid->print_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_print_status_id"
        data-table="main_transactions"
        data-field="x_print_status_id"
        data-value-separator="<?= $Grid->print_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->print_status_id->getPlaceHolder()) ?>"
        <?= $Grid->print_status_id->editAttributes() ?>>
        <?= $Grid->print_status_id->selectOptionListHtml("x{$Grid->RowIndex}_print_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->print_status_id->getErrorMessage() ?></div>
<?= $Grid->print_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_print_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_print_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_print_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_print_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.print_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_print_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_print_status_id" id="o<?= $Grid->RowIndex ?>_print_status_id" value="<?= HtmlEncode($Grid->print_status_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_print_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_print_status_id"
        name="x<?= $Grid->RowIndex ?>_print_status_id"
        class="form-control ew-select<?= $Grid->print_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_print_status_id"
        data-table="main_transactions"
        data-field="x_print_status_id"
        data-value-separator="<?= $Grid->print_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->print_status_id->getPlaceHolder()) ?>"
        <?= $Grid->print_status_id->editAttributes() ?>>
        <?= $Grid->print_status_id->selectOptionListHtml("x{$Grid->RowIndex}_print_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->print_status_id->getErrorMessage() ?></div>
<?= $Grid->print_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_print_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_print_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_print_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_print_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.print_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_print_status_id">
<span<?= $Grid->print_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->print_status_id->getViewValue()) && $Grid->print_status_id->linkAttributes() != "") { ?>
<a<?= $Grid->print_status_id->linkAttributes() ?>><?= $Grid->print_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Grid->print_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_print_status_id" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_print_status_id" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_print_status_id" value="<?= HtmlEncode($Grid->print_status_id->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_print_status_id" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_print_status_id" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_print_status_id" value="<?= HtmlEncode($Grid->print_status_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->payment_status_id->Visible) { // payment_status_id ?>
        <td data-name="payment_status_id" <?= $Grid->payment_status_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_payment_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_payment_status_id"
        name="x<?= $Grid->RowIndex ?>_payment_status_id"
        class="form-control ew-select<?= $Grid->payment_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_payment_status_id"
        data-table="main_transactions"
        data-field="x_payment_status_id"
        data-value-separator="<?= $Grid->payment_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->payment_status_id->getPlaceHolder()) ?>"
        <?= $Grid->payment_status_id->editAttributes() ?>>
        <?= $Grid->payment_status_id->selectOptionListHtml("x{$Grid->RowIndex}_payment_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->payment_status_id->getErrorMessage() ?></div>
<?= $Grid->payment_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_payment_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_payment_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_payment_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_payment_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.payment_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment_status_id" id="o<?= $Grid->RowIndex ?>_payment_status_id" value="<?= HtmlEncode($Grid->payment_status_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_payment_status_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_payment_status_id"
        name="x<?= $Grid->RowIndex ?>_payment_status_id"
        class="form-control ew-select<?= $Grid->payment_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_payment_status_id"
        data-table="main_transactions"
        data-field="x_payment_status_id"
        data-value-separator="<?= $Grid->payment_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->payment_status_id->getPlaceHolder()) ?>"
        <?= $Grid->payment_status_id->editAttributes() ?>>
        <?= $Grid->payment_status_id->selectOptionListHtml("x{$Grid->RowIndex}_payment_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->payment_status_id->getErrorMessage() ?></div>
<?= $Grid->payment_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_payment_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_payment_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_payment_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_payment_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.payment_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_payment_status_id">
<span<?= $Grid->payment_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->payment_status_id->getViewValue()) && $Grid->payment_status_id->linkAttributes() != "") { ?>
<a<?= $Grid->payment_status_id->linkAttributes() ?>><?= $Grid->payment_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Grid->payment_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_payment_status_id" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_payment_status_id" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_payment_status_id" value="<?= HtmlEncode($Grid->payment_status_id->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_payment_status_id" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_payment_status_id" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_payment_status_id" value="<?= HtmlEncode($Grid->payment_status_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->total->Visible) { // total ?>
        <td data-name="total" <?= $Grid->total->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_total" class="form-group">
<input type="<?= $Grid->total->getInputTextType() ?>" data-table="main_transactions" data-field="x_total" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" size="30" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>" value="<?= $Grid->total->EditValue ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total" id="o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_total" class="form-group">
<input type="<?= $Grid->total->getInputTextType() ?>" data-table="main_transactions" data-field="x_total" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" size="30" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>" value="<?= $Grid->total->EditValue ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_transactions_total">
<span<?= $Grid->total->viewAttributes() ?>>
<?= $Grid->total->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_transactions" data-field="x_total" data-hidden="1" name="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_total" id="fmain_transactionsgrid$x<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->FormValue) ?>">
<input type="hidden" data-table="main_transactions" data-field="x_total" data-hidden="1" name="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_total" id="fmain_transactionsgrid$o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
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
loadjs.ready(["fmain_transactionsgrid","load"], function () {
    fmain_transactionsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_main_transactions", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_main_transactions_id" class="form-group main_transactions_id"></span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_id" class="form-group main_transactions_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->campaign_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_transactions_campaign_id" class="form-group main_transactions_campaign_id">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->campaign_id->getDisplayValue($Grid->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_campaign_id" name="x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_transactions_campaign_id" class="form-group main_transactions_campaign_id">
<?php $Grid->campaign_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_campaign_id"
        name="x<?= $Grid->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Grid->campaign_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_campaign_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_campaign_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_campaign_id" class="form-group main_transactions_campaign_id">
<span<?= $Grid->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->campaign_id->getDisplayValue($Grid->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_campaign_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_campaign_id" id="x<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_campaign_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_campaign_id" id="o<?= $Grid->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Grid->campaign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->operator_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_transactions_operator_id" class="form-group main_transactions_operator_id">
<span<?= $Grid->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->operator_id->getDisplayValue($Grid->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_operator_id" name="x<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_transactions_operator_id" class="form-group main_transactions_operator_id">
    <select
        id="x<?= $Grid->RowIndex ?>_operator_id"
        name="x<?= $Grid->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Grid->operator_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_operator_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_operator_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_operator_id" class="form-group main_transactions_operator_id">
<span<?= $Grid->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->operator_id->getDisplayValue($Grid->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_operator_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_operator_id" id="x<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_operator_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_operator_id" id="o<?= $Grid->RowIndex ?>_operator_id" value="<?= HtmlEncode($Grid->operator_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_payment_date" class="form-group main_transactions_payment_date">
<input type="<?= $Grid->payment_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_date" data-format="5" name="x<?= $Grid->RowIndex ?>_payment_date" id="x<?= $Grid->RowIndex ?>_payment_date" placeholder="<?= HtmlEncode($Grid->payment_date->getPlaceHolder()) ?>" value="<?= $Grid->payment_date->EditValue ?>"<?= $Grid->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->payment_date->getErrorMessage() ?></div>
<?php if (!$Grid->payment_date->ReadOnly && !$Grid->payment_date->Disabled && !isset($Grid->payment_date->EditAttrs["readonly"]) && !isset($Grid->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsgrid", "x<?= $Grid->RowIndex ?>_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_payment_date" class="form-group main_transactions_payment_date">
<span<?= $Grid->payment_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->payment_date->getDisplayValue($Grid->payment_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_payment_date" id="x<?= $Grid->RowIndex ?>_payment_date" value="<?= HtmlEncode($Grid->payment_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_payment_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment_date" id="o<?= $Grid->RowIndex ?>_payment_date" value="<?= HtmlEncode($Grid->payment_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_main_transactions_vendor_id" class="form-group main_transactions_vendor_id">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_vendor_id" class="form-group main_transactions_vendor_id">
<?php
$onchange = $Grid->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Grid->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_vendor_id" id="sv_x<?= $Grid->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Grid->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"<?= $Grid->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_transactions" data-field="x_vendor_id" data-input="sv_x<?= $Grid->RowIndex ?>_vendor_id" data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_transactionsgrid"], function() {
    fmain_transactionsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.main_transactions.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_vendor_id" class="form-group main_transactions_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_vendor_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_vendor_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_vendor_id" id="o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->price_id->Visible) { // price_id ?>
        <td data-name="price_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_price_id" class="form-group main_transactions_price_id">
    <select
        id="x<?= $Grid->RowIndex ?>_price_id"
        name="x<?= $Grid->RowIndex ?>_price_id"
        class="form-control ew-select<?= $Grid->price_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_price_id"
        data-table="main_transactions"
        data-field="x_price_id"
        data-value-separator="<?= $Grid->price_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->price_id->getPlaceHolder()) ?>"
        <?= $Grid->price_id->editAttributes() ?>>
        <?= $Grid->price_id->selectOptionListHtml("x{$Grid->RowIndex}_price_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->price_id->getErrorMessage() ?></div>
<?= $Grid->price_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_price_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_price_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_price_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_price_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.price_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_price_id" class="form-group main_transactions_price_id">
<span<?= $Grid->price_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->price_id->getDisplayValue($Grid->price_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_price_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_price_id" id="x<?= $Grid->RowIndex ?>_price_id" value="<?= HtmlEncode($Grid->price_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_price_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_price_id" id="o<?= $Grid->RowIndex ?>_price_id" value="<?= HtmlEncode($Grid->price_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->quantity->Visible) { // quantity ?>
        <td data-name="quantity">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_quantity" class="form-group main_transactions_quantity">
<input type="<?= $Grid->quantity->getInputTextType() ?>" data-table="main_transactions" data-field="x_quantity" name="x<?= $Grid->RowIndex ?>_quantity" id="x<?= $Grid->RowIndex ?>_quantity" size="30" placeholder="<?= HtmlEncode($Grid->quantity->getPlaceHolder()) ?>" value="<?= $Grid->quantity->EditValue ?>"<?= $Grid->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->quantity->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_quantity" class="form-group main_transactions_quantity">
<span<?= $Grid->quantity->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->quantity->getDisplayValue($Grid->quantity->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_quantity" data-hidden="1" name="x<?= $Grid->RowIndex ?>_quantity" id="x<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_quantity" data-hidden="1" name="o<?= $Grid->RowIndex ?>_quantity" id="o<?= $Grid->RowIndex ?>_quantity" value="<?= HtmlEncode($Grid->quantity->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->assigned_buses->Visible) { // assigned_buses ?>
        <td data-name="assigned_buses">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_assigned_buses" class="form-group main_transactions_assigned_buses">
<input type="<?= $Grid->assigned_buses->getInputTextType() ?>" data-table="main_transactions" data-field="x_assigned_buses" name="x<?= $Grid->RowIndex ?>_assigned_buses" id="x<?= $Grid->RowIndex ?>_assigned_buses" size="30" placeholder="<?= HtmlEncode($Grid->assigned_buses->getPlaceHolder()) ?>" value="<?= $Grid->assigned_buses->EditValue ?>"<?= $Grid->assigned_buses->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->assigned_buses->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_assigned_buses" class="form-group main_transactions_assigned_buses">
<span<?= $Grid->assigned_buses->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->assigned_buses->getDisplayValue($Grid->assigned_buses->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_assigned_buses" data-hidden="1" name="x<?= $Grid->RowIndex ?>_assigned_buses" id="x<?= $Grid->RowIndex ?>_assigned_buses" value="<?= HtmlEncode($Grid->assigned_buses->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_assigned_buses" data-hidden="1" name="o<?= $Grid->RowIndex ?>_assigned_buses" id="o<?= $Grid->RowIndex ?>_assigned_buses" value="<?= HtmlEncode($Grid->assigned_buses->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->start_date->Visible) { // start_date ?>
        <td data-name="start_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_start_date" class="form-group main_transactions_start_date">
<input type="<?= $Grid->start_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_start_date" data-format="5" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" placeholder="<?= HtmlEncode($Grid->start_date->getPlaceHolder()) ?>" value="<?= $Grid->start_date->EditValue ?>"<?= $Grid->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->start_date->getErrorMessage() ?></div>
<?php if (!$Grid->start_date->ReadOnly && !$Grid->start_date->Disabled && !isset($Grid->start_date->EditAttrs["readonly"]) && !isset($Grid->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsgrid", "x<?= $Grid->RowIndex ?>_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_start_date" class="form-group main_transactions_start_date">
<span<?= $Grid->start_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->start_date->getDisplayValue($Grid->start_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_start_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_start_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_start_date" id="o<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->end_date->Visible) { // end_date ?>
        <td data-name="end_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_end_date" class="form-group main_transactions_end_date">
<input type="<?= $Grid->end_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_end_date" data-format="5" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" placeholder="<?= HtmlEncode($Grid->end_date->getPlaceHolder()) ?>" value="<?= $Grid->end_date->EditValue ?>"<?= $Grid->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->end_date->getErrorMessage() ?></div>
<?php if (!$Grid->end_date->ReadOnly && !$Grid->end_date->Disabled && !isset($Grid->end_date->EditAttrs["readonly"]) && !isset($Grid->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionsgrid", "x<?= $Grid->RowIndex ?>_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_end_date" class="form-group main_transactions_end_date">
<span<?= $Grid->end_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->end_date->getDisplayValue($Grid->end_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_end_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_end_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_end_date" id="o<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->visible_status_id->Visible) { // visible_status_id ?>
        <td data-name="visible_status_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_visible_status_id" class="form-group main_transactions_visible_status_id">
    <select
        id="x<?= $Grid->RowIndex ?>_visible_status_id"
        name="x<?= $Grid->RowIndex ?>_visible_status_id"
        class="form-control ew-select<?= $Grid->visible_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_visible_status_id"
        data-table="main_transactions"
        data-field="x_visible_status_id"
        data-value-separator="<?= $Grid->visible_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->visible_status_id->getPlaceHolder()) ?>"
        <?= $Grid->visible_status_id->editAttributes() ?>>
        <?= $Grid->visible_status_id->selectOptionListHtml("x{$Grid->RowIndex}_visible_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->visible_status_id->getErrorMessage() ?></div>
<?= $Grid->visible_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_visible_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_visible_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_visible_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_visible_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.visible_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_visible_status_id" class="form-group main_transactions_visible_status_id">
<span<?= $Grid->visible_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->visible_status_id->ViewValue) && $Grid->visible_status_id->linkAttributes() != "") { ?>
<a<?= $Grid->visible_status_id->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->visible_status_id->getDisplayValue($Grid->visible_status_id->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->visible_status_id->getDisplayValue($Grid->visible_status_id->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_visible_status_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_visible_status_id" id="x<?= $Grid->RowIndex ?>_visible_status_id" value="<?= HtmlEncode($Grid->visible_status_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_visible_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_visible_status_id" id="o<?= $Grid->RowIndex ?>_visible_status_id" value="<?= HtmlEncode($Grid->visible_status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_id->Visible) { // status_id ?>
        <td data-name="status_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_status_id" class="form-group main_transactions_status_id">
    <select
        id="x<?= $Grid->RowIndex ?>_status_id"
        name="x<?= $Grid->RowIndex ?>_status_id"
        class="form-control ew-select<?= $Grid->status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_status_id"
        data-table="main_transactions"
        data-field="x_status_id"
        data-value-separator="<?= $Grid->status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_id->getPlaceHolder()) ?>"
        <?= $Grid->status_id->editAttributes() ?>>
        <?= $Grid->status_id->selectOptionListHtml("x{$Grid->RowIndex}_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_id->getErrorMessage() ?></div>
<?= $Grid->status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_status_id" class="form-group main_transactions_status_id">
<span<?= $Grid->status_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->status_id->ViewValue) && $Grid->status_id->linkAttributes() != "") { ?>
<a<?= $Grid->status_id->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_id->getDisplayValue($Grid->status_id->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_id->getDisplayValue($Grid->status_id->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_status_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_id" id="x<?= $Grid->RowIndex ?>_status_id" value="<?= HtmlEncode($Grid->status_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_id" id="o<?= $Grid->RowIndex ?>_status_id" value="<?= HtmlEncode($Grid->status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->print_status_id->Visible) { // print_status_id ?>
        <td data-name="print_status_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_print_status_id" class="form-group main_transactions_print_status_id">
    <select
        id="x<?= $Grid->RowIndex ?>_print_status_id"
        name="x<?= $Grid->RowIndex ?>_print_status_id"
        class="form-control ew-select<?= $Grid->print_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_print_status_id"
        data-table="main_transactions"
        data-field="x_print_status_id"
        data-value-separator="<?= $Grid->print_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->print_status_id->getPlaceHolder()) ?>"
        <?= $Grid->print_status_id->editAttributes() ?>>
        <?= $Grid->print_status_id->selectOptionListHtml("x{$Grid->RowIndex}_print_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->print_status_id->getErrorMessage() ?></div>
<?= $Grid->print_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_print_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_print_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_print_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_print_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.print_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_print_status_id" class="form-group main_transactions_print_status_id">
<span<?= $Grid->print_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->print_status_id->ViewValue) && $Grid->print_status_id->linkAttributes() != "") { ?>
<a<?= $Grid->print_status_id->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->print_status_id->getDisplayValue($Grid->print_status_id->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->print_status_id->getDisplayValue($Grid->print_status_id->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_print_status_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_print_status_id" id="x<?= $Grid->RowIndex ?>_print_status_id" value="<?= HtmlEncode($Grid->print_status_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_print_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_print_status_id" id="o<?= $Grid->RowIndex ?>_print_status_id" value="<?= HtmlEncode($Grid->print_status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->payment_status_id->Visible) { // payment_status_id ?>
        <td data-name="payment_status_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_payment_status_id" class="form-group main_transactions_payment_status_id">
    <select
        id="x<?= $Grid->RowIndex ?>_payment_status_id"
        name="x<?= $Grid->RowIndex ?>_payment_status_id"
        class="form-control ew-select<?= $Grid->payment_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Grid->RowIndex ?>_payment_status_id"
        data-table="main_transactions"
        data-field="x_payment_status_id"
        data-value-separator="<?= $Grid->payment_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->payment_status_id->getPlaceHolder()) ?>"
        <?= $Grid->payment_status_id->editAttributes() ?>>
        <?= $Grid->payment_status_id->selectOptionListHtml("x{$Grid->RowIndex}_payment_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->payment_status_id->getErrorMessage() ?></div>
<?= $Grid->payment_status_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_payment_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Grid->RowIndex ?>_payment_status_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_payment_status_id", selectId: "main_transactions_x<?= $Grid->RowIndex ?>_payment_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.payment_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_payment_status_id" class="form-group main_transactions_payment_status_id">
<span<?= $Grid->payment_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Grid->payment_status_id->ViewValue) && $Grid->payment_status_id->linkAttributes() != "") { ?>
<a<?= $Grid->payment_status_id->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->payment_status_id->getDisplayValue($Grid->payment_status_id->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->payment_status_id->getDisplayValue($Grid->payment_status_id->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_status_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_payment_status_id" id="x<?= $Grid->RowIndex ?>_payment_status_id" value="<?= HtmlEncode($Grid->payment_status_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_payment_status_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment_status_id" id="o<?= $Grid->RowIndex ?>_payment_status_id" value="<?= HtmlEncode($Grid->payment_status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->total->Visible) { // total ?>
        <td data-name="total">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_transactions_total" class="form-group main_transactions_total">
<input type="<?= $Grid->total->getInputTextType() ?>" data-table="main_transactions" data-field="x_total" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" size="30" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>" value="<?= $Grid->total->EditValue ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_total" class="form-group main_transactions_total">
<span<?= $Grid->total->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->total->getDisplayValue($Grid->total->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_total" data-hidden="1" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total" id="o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fmain_transactionsgrid","load"], function() {
    fmain_transactionsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        <td data-name="id" class="<?= $Grid->id->footerCellClass() ?>"><span id="elf_main_transactions_id" class="main_transactions_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id" class="<?= $Grid->campaign_id->footerCellClass() ?>"><span id="elf_main_transactions_campaign_id" class="main_transactions_campaign_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id" class="<?= $Grid->operator_id->footerCellClass() ?>"><span id="elf_main_transactions_operator_id" class="main_transactions_operator_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date" class="<?= $Grid->payment_date->footerCellClass() ?>"><span id="elf_main_transactions_payment_date" class="main_transactions_payment_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" class="<?= $Grid->vendor_id->footerCellClass() ?>"><span id="elf_main_transactions_vendor_id" class="main_transactions_vendor_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->price_id->Visible) { // price_id ?>
        <td data-name="price_id" class="<?= $Grid->price_id->footerCellClass() ?>"><span id="elf_main_transactions_price_id" class="main_transactions_price_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->quantity->Visible) { // quantity ?>
        <td data-name="quantity" class="<?= $Grid->quantity->footerCellClass() ?>"><span id="elf_main_transactions_quantity" class="main_transactions_quantity">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->quantity->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->assigned_buses->Visible) { // assigned_buses ?>
        <td data-name="assigned_buses" class="<?= $Grid->assigned_buses->footerCellClass() ?>"><span id="elf_main_transactions_assigned_buses" class="main_transactions_assigned_buses">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->start_date->Visible) { // start_date ?>
        <td data-name="start_date" class="<?= $Grid->start_date->footerCellClass() ?>"><span id="elf_main_transactions_start_date" class="main_transactions_start_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->end_date->Visible) { // end_date ?>
        <td data-name="end_date" class="<?= $Grid->end_date->footerCellClass() ?>"><span id="elf_main_transactions_end_date" class="main_transactions_end_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->visible_status_id->Visible) { // visible_status_id ?>
        <td data-name="visible_status_id" class="<?= $Grid->visible_status_id->footerCellClass() ?>"><span id="elf_main_transactions_visible_status_id" class="main_transactions_visible_status_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->status_id->Visible) { // status_id ?>
        <td data-name="status_id" class="<?= $Grid->status_id->footerCellClass() ?>"><span id="elf_main_transactions_status_id" class="main_transactions_status_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->print_status_id->Visible) { // print_status_id ?>
        <td data-name="print_status_id" class="<?= $Grid->print_status_id->footerCellClass() ?>"><span id="elf_main_transactions_print_status_id" class="main_transactions_print_status_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->payment_status_id->Visible) { // payment_status_id ?>
        <td data-name="payment_status_id" class="<?= $Grid->payment_status_id->footerCellClass() ?>"><span id="elf_main_transactions_payment_status_id" class="main_transactions_payment_status_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->total->Visible) { // total ?>
        <td data-name="total" class="<?= $Grid->total->footerCellClass() ?>"><span id="elf_main_transactions_total" class="main_transactions_total">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->total->ViewValue ?></span>
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
<input type="hidden" name="detailpage" value="fmain_transactionsgrid">
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
    ew.addEventHandlers("main_transactions");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

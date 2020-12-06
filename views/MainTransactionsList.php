<?php

namespace PHPMaker2021\test;

// Page object
$MainTransactionsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
if (!ew.vars.tables.main_transactions) ew.vars.tables.main_transactions = <?= JsonEncode(GetClientVar("tables", "main_transactions")) ?>;
var currentForm, currentPageID;
var fmain_transactionslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fmain_transactionslist = currentForm = new ew.Form("fmain_transactionslist", "list");
    fmain_transactionslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var fields = ew.vars.tables.main_transactions.fields;
    fmain_transactionslist.addFields([
        ["id", [fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["campaign_id", [fields.campaign_id.required ? ew.Validators.required(fields.campaign_id.caption) : null], fields.campaign_id.isInvalid],
        ["operator_id", [fields.operator_id.required ? ew.Validators.required(fields.operator_id.caption) : null], fields.operator_id.isInvalid],
        ["payment_date", [fields.payment_date.required ? ew.Validators.required(fields.payment_date.caption) : null, ew.Validators.datetime(5)], fields.payment_date.isInvalid],
        ["vendor_id", [fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null, ew.Validators.integer], fields.vendor_id.isInvalid],
        ["price_id", [fields.price_id.required ? ew.Validators.required(fields.price_id.caption) : null], fields.price_id.isInvalid],
        ["quantity", [fields.quantity.required ? ew.Validators.required(fields.quantity.caption) : null, ew.Validators.integer], fields.quantity.isInvalid],
        ["assigned_buses", [fields.assigned_buses.required ? ew.Validators.required(fields.assigned_buses.caption) : null, ew.Validators.integer], fields.assigned_buses.isInvalid],
        ["start_date", [fields.start_date.required ? ew.Validators.required(fields.start_date.caption) : null, ew.Validators.datetime(5)], fields.start_date.isInvalid],
        ["end_date", [fields.end_date.required ? ew.Validators.required(fields.end_date.caption) : null, ew.Validators.datetime(5)], fields.end_date.isInvalid],
        ["visible_status_id", [fields.visible_status_id.required ? ew.Validators.required(fields.visible_status_id.caption) : null], fields.visible_status_id.isInvalid],
        ["status_id", [fields.status_id.required ? ew.Validators.required(fields.status_id.caption) : null], fields.status_id.isInvalid],
        ["print_status_id", [fields.print_status_id.required ? ew.Validators.required(fields.print_status_id.caption) : null], fields.print_status_id.isInvalid],
        ["payment_status_id", [fields.payment_status_id.required ? ew.Validators.required(fields.payment_status_id.caption) : null], fields.payment_status_id.isInvalid],
        ["total", [fields.total.required ? ew.Validators.required(fields.total.caption) : null], fields.total.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_transactionslist,
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
    fmain_transactionslist.validate = function () {
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
    fmain_transactionslist.emptyRow = function (rowIndex) {
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
    fmain_transactionslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_transactionslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_transactionslist.lists.campaign_id = <?= $Page->campaign_id->toClientList($Page) ?>;
    fmain_transactionslist.lists.operator_id = <?= $Page->operator_id->toClientList($Page) ?>;
    fmain_transactionslist.lists.vendor_id = <?= $Page->vendor_id->toClientList($Page) ?>;
    fmain_transactionslist.lists.price_id = <?= $Page->price_id->toClientList($Page) ?>;
    fmain_transactionslist.lists.visible_status_id = <?= $Page->visible_status_id->toClientList($Page) ?>;
    fmain_transactionslist.lists.status_id = <?= $Page->status_id->toClientList($Page) ?>;
    fmain_transactionslist.lists.print_status_id = <?= $Page->print_status_id->toClientList($Page) ?>;
    fmain_transactionslist.lists.payment_status_id = <?= $Page->payment_status_id->toClientList($Page) ?>;
    loadjs.done("fmain_transactionslist");
});
var fmain_transactionslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fmain_transactionslistsrch = currentSearchForm = new ew.Form("fmain_transactionslistsrch");

    // Dynamic selection lists

    // Filters
    fmain_transactionslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fmain_transactionslistsrch");
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "y_operators") {
    if ($Page->MasterRecordExists) {
        include_once "views/YOperatorsMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fmain_transactionslistsrch" id="fmain_transactionslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fmain_transactionslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="main_transactions">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> main_transactions">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fmain_transactionslist" id="fmain_transactionslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_transactions">
<?php if ($Page->getCurrentMasterTable() == "main_campaigns" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_campaigns">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->campaign_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "y_operators" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="y_operators">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->operator_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_main_transactions" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_main_transactionslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_main_transactions_id" class="main_transactions_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <th data-name="campaign_id" class="<?= $Page->campaign_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_campaign_id" class="main_transactions_campaign_id"><?= $Page->renderSort($Page->campaign_id) ?></div></th>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <th data-name="operator_id" class="<?= $Page->operator_id->headerCellClass() ?>"><div id="elh_main_transactions_operator_id" class="main_transactions_operator_id"><?= $Page->renderSort($Page->operator_id) ?></div></th>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
        <th data-name="payment_date" class="<?= $Page->payment_date->headerCellClass() ?>"><div id="elh_main_transactions_payment_date" class="main_transactions_payment_date"><?= $Page->renderSort($Page->payment_date) ?></div></th>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <th data-name="vendor_id" class="<?= $Page->vendor_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_vendor_id" class="main_transactions_vendor_id"><?= $Page->renderSort($Page->vendor_id) ?></div></th>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
        <th data-name="price_id" class="<?= $Page->price_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_price_id" class="main_transactions_price_id"><?= $Page->renderSort($Page->price_id) ?></div></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Page->quantity->headerCellClass() ?>"><div id="elh_main_transactions_quantity" class="main_transactions_quantity"><?= $Page->renderSort($Page->quantity) ?></div></th>
<?php } ?>
<?php if ($Page->assigned_buses->Visible) { // assigned_buses ?>
        <th data-name="assigned_buses" class="<?= $Page->assigned_buses->headerCellClass() ?>"><div id="elh_main_transactions_assigned_buses" class="main_transactions_assigned_buses"><?= $Page->renderSort($Page->assigned_buses) ?></div></th>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <th data-name="start_date" class="<?= $Page->start_date->headerCellClass() ?>"><div id="elh_main_transactions_start_date" class="main_transactions_start_date"><?= $Page->renderSort($Page->start_date) ?></div></th>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <th data-name="end_date" class="<?= $Page->end_date->headerCellClass() ?>"><div id="elh_main_transactions_end_date" class="main_transactions_end_date"><?= $Page->renderSort($Page->end_date) ?></div></th>
<?php } ?>
<?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
        <th data-name="visible_status_id" class="<?= $Page->visible_status_id->headerCellClass() ?>"><div id="elh_main_transactions_visible_status_id" class="main_transactions_visible_status_id"><?= $Page->renderSort($Page->visible_status_id) ?></div></th>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <th data-name="status_id" class="<?= $Page->status_id->headerCellClass() ?>"><div id="elh_main_transactions_status_id" class="main_transactions_status_id"><?= $Page->renderSort($Page->status_id) ?></div></th>
<?php } ?>
<?php if ($Page->print_status_id->Visible) { // print_status_id ?>
        <th data-name="print_status_id" class="<?= $Page->print_status_id->headerCellClass() ?>"><div id="elh_main_transactions_print_status_id" class="main_transactions_print_status_id"><?= $Page->renderSort($Page->print_status_id) ?></div></th>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
        <th data-name="payment_status_id" class="<?= $Page->payment_status_id->headerCellClass() ?>"><div id="elh_main_transactions_payment_status_id" class="main_transactions_payment_status_id"><?= $Page->renderSort($Page->payment_status_id) ?></div></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th data-name="total" class="<?= $Page->total->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_transactions_total" class="main_transactions_total"><?= $Page->renderSort($Page->total) ?></div></th>
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
$Page->EditRowCount = 0;
if ($Page->isEdit())
    $Page->RowIndex = 1;
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
        if ($Page->isEdit()) {
            if ($Page->checkInlineEditKey() && $Page->EditRowCount == 0) { // Inline edit
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
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
        if ($Page->isEdit() && $Page->RowType == ROWTYPE_EDIT && $Page->EventCancelled) { // Update failed
            $CurrentForm->Index = 1;
            $Page->restoreFormValues(); // Restore form values
        }
        if ($Page->isGridEdit() && ($Page->RowType == ROWTYPE_EDIT || $Page->RowType == ROWTYPE_ADD) && $Page->EventCancelled) { // Update failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_main_transactions", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_main_transactions_id" class="form-group"></span>
<input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_id" class="form-group">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id" <?= $Page->campaign_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_campaign_id" class="form-group">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_campaign_id" name="x<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_campaign_id" class="form-group">
<?php $Page->campaign_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_campaign_id"
        name="x<?= $Page->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_campaign_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_campaign_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_campaign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_campaign_id" id="o<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_campaign_id" class="form-group">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_campaign_id" name="x<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_campaign_id" class="form-group">
<?php $Page->campaign_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_campaign_id"
        name="x<?= $Page->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_campaign_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_campaign_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id" <?= $Page->operator_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->operator_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_operator_id" class="form-group">
<span<?= $Page->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->operator_id->getDisplayValue($Page->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_operator_id" name="x<?= $Page->RowIndex ?>_operator_id" value="<?= HtmlEncode($Page->operator_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_operator_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_operator_id"
        name="x<?= $Page->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_operator_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_operator_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_operator_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_operator_id" id="o<?= $Page->RowIndex ?>_operator_id" value="<?= HtmlEncode($Page->operator_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->operator_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_operator_id" class="form-group">
<span<?= $Page->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->operator_id->getDisplayValue($Page->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_operator_id" name="x<?= $Page->RowIndex ?>_operator_id" value="<?= HtmlEncode($Page->operator_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_operator_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_operator_id"
        name="x<?= $Page->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_operator_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_operator_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date" <?= $Page->payment_date->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_payment_date" class="form-group">
<input type="<?= $Page->payment_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_date" data-format="5" name="x<?= $Page->RowIndex ?>_payment_date" id="x<?= $Page->RowIndex ?>_payment_date" placeholder="<?= HtmlEncode($Page->payment_date->getPlaceHolder()) ?>" value="<?= $Page->payment_date->EditValue ?>"<?= $Page->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->payment_date->getErrorMessage() ?></div>
<?php if (!$Page->payment_date->ReadOnly && !$Page->payment_date->Disabled && !isset($Page->payment_date->EditAttrs["readonly"]) && !isset($Page->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionslist", "x<?= $Page->RowIndex ?>_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_date" data-hidden="1" name="o<?= $Page->RowIndex ?>_payment_date" id="o<?= $Page->RowIndex ?>_payment_date" value="<?= HtmlEncode($Page->payment_date->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_payment_date" class="form-group">
<input type="<?= $Page->payment_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_date" data-format="5" name="x<?= $Page->RowIndex ?>_payment_date" id="x<?= $Page->RowIndex ?>_payment_date" placeholder="<?= HtmlEncode($Page->payment_date->getPlaceHolder()) ?>" value="<?= $Page->payment_date->EditValue ?>"<?= $Page->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->payment_date->getErrorMessage() ?></div>
<?php if (!$Page->payment_date->ReadOnly && !$Page->payment_date->Disabled && !isset($Page->payment_date->EditAttrs["readonly"]) && !isset($Page->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionslist", "x<?= $Page->RowIndex ?>_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_payment_date">
<span<?= $Page->payment_date->viewAttributes() ?>>
<?= $Page->payment_date->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" <?= $Page->vendor_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_vendor_id" class="form-group">
<?php
$onchange = $Page->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Page->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_vendor_id" id="sv_x<?= $Page->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Page->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"<?= $Page->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_transactions" data-field="x_vendor_id" data-input="sv_x<?= $Page->RowIndex ?>_vendor_id" data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_vendor_id" id="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_transactionslist"], function() {
    fmain_transactionslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.main_transactions.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_vendor_id" class="form-group">
<?php
$onchange = $Page->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Page->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_vendor_id" id="sv_x<?= $Page->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Page->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"<?= $Page->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_transactions" data-field="x_vendor_id" data-input="sv_x<?= $Page->RowIndex ?>_vendor_id" data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_vendor_id" id="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_transactionslist"], function() {
    fmain_transactionslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.main_transactions.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->price_id->Visible) { // price_id ?>
        <td data-name="price_id" <?= $Page->price_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_price_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_price_id"
        name="x<?= $Page->RowIndex ?>_price_id"
        class="form-control ew-select<?= $Page->price_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_price_id"
        data-table="main_transactions"
        data-field="x_price_id"
        data-value-separator="<?= $Page->price_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->price_id->getPlaceHolder()) ?>"
        <?= $Page->price_id->editAttributes() ?>>
        <?= $Page->price_id->selectOptionListHtml("x{$Page->RowIndex}_price_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->price_id->getErrorMessage() ?></div>
<?= $Page->price_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_price_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_price_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_price_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_price_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.price_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_price_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_price_id" id="o<?= $Page->RowIndex ?>_price_id" value="<?= HtmlEncode($Page->price_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_price_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_price_id"
        name="x<?= $Page->RowIndex ?>_price_id"
        class="form-control ew-select<?= $Page->price_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_price_id"
        data-table="main_transactions"
        data-field="x_price_id"
        data-value-separator="<?= $Page->price_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->price_id->getPlaceHolder()) ?>"
        <?= $Page->price_id->editAttributes() ?>>
        <?= $Page->price_id->selectOptionListHtml("x{$Page->RowIndex}_price_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->price_id->getErrorMessage() ?></div>
<?= $Page->price_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_price_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_price_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_price_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_price_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.price_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_price_id">
<span<?= $Page->price_id->viewAttributes() ?>>
<?= $Page->price_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_quantity" class="form-group">
<input type="<?= $Page->quantity->getInputTextType() ?>" data-table="main_transactions" data-field="x_quantity" name="x<?= $Page->RowIndex ?>_quantity" id="x<?= $Page->RowIndex ?>_quantity" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>" value="<?= $Page->quantity->EditValue ?>"<?= $Page->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_quantity" data-hidden="1" name="o<?= $Page->RowIndex ?>_quantity" id="o<?= $Page->RowIndex ?>_quantity" value="<?= HtmlEncode($Page->quantity->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_quantity" class="form-group">
<input type="<?= $Page->quantity->getInputTextType() ?>" data-table="main_transactions" data-field="x_quantity" name="x<?= $Page->RowIndex ?>_quantity" id="x<?= $Page->RowIndex ?>_quantity" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>" value="<?= $Page->quantity->EditValue ?>"<?= $Page->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->assigned_buses->Visible) { // assigned_buses ?>
        <td data-name="assigned_buses" <?= $Page->assigned_buses->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_assigned_buses" class="form-group">
<input type="<?= $Page->assigned_buses->getInputTextType() ?>" data-table="main_transactions" data-field="x_assigned_buses" name="x<?= $Page->RowIndex ?>_assigned_buses" id="x<?= $Page->RowIndex ?>_assigned_buses" size="30" placeholder="<?= HtmlEncode($Page->assigned_buses->getPlaceHolder()) ?>" value="<?= $Page->assigned_buses->EditValue ?>"<?= $Page->assigned_buses->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assigned_buses->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_assigned_buses" data-hidden="1" name="o<?= $Page->RowIndex ?>_assigned_buses" id="o<?= $Page->RowIndex ?>_assigned_buses" value="<?= HtmlEncode($Page->assigned_buses->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_assigned_buses" class="form-group">
<input type="<?= $Page->assigned_buses->getInputTextType() ?>" data-table="main_transactions" data-field="x_assigned_buses" name="x<?= $Page->RowIndex ?>_assigned_buses" id="x<?= $Page->RowIndex ?>_assigned_buses" size="30" placeholder="<?= HtmlEncode($Page->assigned_buses->getPlaceHolder()) ?>" value="<?= $Page->assigned_buses->EditValue ?>"<?= $Page->assigned_buses->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assigned_buses->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_assigned_buses">
<span<?= $Page->assigned_buses->viewAttributes() ?>>
<?= $Page->assigned_buses->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->start_date->Visible) { // start_date ?>
        <td data-name="start_date" <?= $Page->start_date->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_start_date" class="form-group">
<input type="<?= $Page->start_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_start_date" data-format="5" name="x<?= $Page->RowIndex ?>_start_date" id="x<?= $Page->RowIndex ?>_start_date" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>" value="<?= $Page->start_date->EditValue ?>"<?= $Page->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage() ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionslist", "x<?= $Page->RowIndex ?>_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_start_date" data-hidden="1" name="o<?= $Page->RowIndex ?>_start_date" id="o<?= $Page->RowIndex ?>_start_date" value="<?= HtmlEncode($Page->start_date->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_start_date" class="form-group">
<input type="<?= $Page->start_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_start_date" data-format="5" name="x<?= $Page->RowIndex ?>_start_date" id="x<?= $Page->RowIndex ?>_start_date" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>" value="<?= $Page->start_date->EditValue ?>"<?= $Page->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage() ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionslist", "x<?= $Page->RowIndex ?>_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->end_date->Visible) { // end_date ?>
        <td data-name="end_date" <?= $Page->end_date->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_end_date" class="form-group">
<input type="<?= $Page->end_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_end_date" data-format="5" name="x<?= $Page->RowIndex ?>_end_date" id="x<?= $Page->RowIndex ?>_end_date" placeholder="<?= HtmlEncode($Page->end_date->getPlaceHolder()) ?>" value="<?= $Page->end_date->EditValue ?>"<?= $Page->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->end_date->getErrorMessage() ?></div>
<?php if (!$Page->end_date->ReadOnly && !$Page->end_date->Disabled && !isset($Page->end_date->EditAttrs["readonly"]) && !isset($Page->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionslist", "x<?= $Page->RowIndex ?>_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_end_date" data-hidden="1" name="o<?= $Page->RowIndex ?>_end_date" id="o<?= $Page->RowIndex ?>_end_date" value="<?= HtmlEncode($Page->end_date->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_end_date" class="form-group">
<input type="<?= $Page->end_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_end_date" data-format="5" name="x<?= $Page->RowIndex ?>_end_date" id="x<?= $Page->RowIndex ?>_end_date" placeholder="<?= HtmlEncode($Page->end_date->getPlaceHolder()) ?>" value="<?= $Page->end_date->EditValue ?>"<?= $Page->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->end_date->getErrorMessage() ?></div>
<?php if (!$Page->end_date->ReadOnly && !$Page->end_date->Disabled && !isset($Page->end_date->EditAttrs["readonly"]) && !isset($Page->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionslist", "x<?= $Page->RowIndex ?>_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
        <td data-name="visible_status_id" <?= $Page->visible_status_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_visible_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_visible_status_id"
        name="x<?= $Page->RowIndex ?>_visible_status_id"
        class="form-control ew-select<?= $Page->visible_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_visible_status_id"
        data-table="main_transactions"
        data-field="x_visible_status_id"
        data-value-separator="<?= $Page->visible_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->visible_status_id->getPlaceHolder()) ?>"
        <?= $Page->visible_status_id->editAttributes() ?>>
        <?= $Page->visible_status_id->selectOptionListHtml("x{$Page->RowIndex}_visible_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->visible_status_id->getErrorMessage() ?></div>
<?= $Page->visible_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_visible_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_visible_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_visible_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_visible_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.visible_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_visible_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_visible_status_id" id="o<?= $Page->RowIndex ?>_visible_status_id" value="<?= HtmlEncode($Page->visible_status_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_visible_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_visible_status_id"
        name="x<?= $Page->RowIndex ?>_visible_status_id"
        class="form-control ew-select<?= $Page->visible_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_visible_status_id"
        data-table="main_transactions"
        data-field="x_visible_status_id"
        data-value-separator="<?= $Page->visible_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->visible_status_id->getPlaceHolder()) ?>"
        <?= $Page->visible_status_id->editAttributes() ?>>
        <?= $Page->visible_status_id->selectOptionListHtml("x{$Page->RowIndex}_visible_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->visible_status_id->getErrorMessage() ?></div>
<?= $Page->visible_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_visible_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_visible_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_visible_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_visible_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.visible_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_visible_status_id">
<span<?= $Page->visible_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->visible_status_id->getViewValue()) && $Page->visible_status_id->linkAttributes() != "") { ?>
<a<?= $Page->visible_status_id->linkAttributes() ?>><?= $Page->visible_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->visible_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->status_id->Visible) { // status_id ?>
        <td data-name="status_id" <?= $Page->status_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_status_id"
        name="x<?= $Page->RowIndex ?>_status_id"
        class="form-control ew-select<?= $Page->status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_status_id"
        data-table="main_transactions"
        data-field="x_status_id"
        data-value-separator="<?= $Page->status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_id->getPlaceHolder()) ?>"
        <?= $Page->status_id->editAttributes() ?>>
        <?= $Page->status_id->selectOptionListHtml("x{$Page->RowIndex}_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status_id->getErrorMessage() ?></div>
<?= $Page->status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_status_id" id="o<?= $Page->RowIndex ?>_status_id" value="<?= HtmlEncode($Page->status_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_status_id"
        name="x<?= $Page->RowIndex ?>_status_id"
        class="form-control ew-select<?= $Page->status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_status_id"
        data-table="main_transactions"
        data-field="x_status_id"
        data-value-separator="<?= $Page->status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_id->getPlaceHolder()) ?>"
        <?= $Page->status_id->editAttributes() ?>>
        <?= $Page->status_id->selectOptionListHtml("x{$Page->RowIndex}_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status_id->getErrorMessage() ?></div>
<?= $Page->status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_status_id">
<span<?= $Page->status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->status_id->getViewValue()) && $Page->status_id->linkAttributes() != "") { ?>
<a<?= $Page->status_id->linkAttributes() ?>><?= $Page->status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->print_status_id->Visible) { // print_status_id ?>
        <td data-name="print_status_id" <?= $Page->print_status_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_print_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_print_status_id"
        name="x<?= $Page->RowIndex ?>_print_status_id"
        class="form-control ew-select<?= $Page->print_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_print_status_id"
        data-table="main_transactions"
        data-field="x_print_status_id"
        data-value-separator="<?= $Page->print_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->print_status_id->getPlaceHolder()) ?>"
        <?= $Page->print_status_id->editAttributes() ?>>
        <?= $Page->print_status_id->selectOptionListHtml("x{$Page->RowIndex}_print_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->print_status_id->getErrorMessage() ?></div>
<?= $Page->print_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_print_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_print_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_print_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_print_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.print_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_print_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_print_status_id" id="o<?= $Page->RowIndex ?>_print_status_id" value="<?= HtmlEncode($Page->print_status_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_print_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_print_status_id"
        name="x<?= $Page->RowIndex ?>_print_status_id"
        class="form-control ew-select<?= $Page->print_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_print_status_id"
        data-table="main_transactions"
        data-field="x_print_status_id"
        data-value-separator="<?= $Page->print_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->print_status_id->getPlaceHolder()) ?>"
        <?= $Page->print_status_id->editAttributes() ?>>
        <?= $Page->print_status_id->selectOptionListHtml("x{$Page->RowIndex}_print_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->print_status_id->getErrorMessage() ?></div>
<?= $Page->print_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_print_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_print_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_print_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_print_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.print_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_print_status_id">
<span<?= $Page->print_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->print_status_id->getViewValue()) && $Page->print_status_id->linkAttributes() != "") { ?>
<a<?= $Page->print_status_id->linkAttributes() ?>><?= $Page->print_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->print_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
        <td data-name="payment_status_id" <?= $Page->payment_status_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_payment_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_payment_status_id"
        name="x<?= $Page->RowIndex ?>_payment_status_id"
        class="form-control ew-select<?= $Page->payment_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_payment_status_id"
        data-table="main_transactions"
        data-field="x_payment_status_id"
        data-value-separator="<?= $Page->payment_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->payment_status_id->getPlaceHolder()) ?>"
        <?= $Page->payment_status_id->editAttributes() ?>>
        <?= $Page->payment_status_id->selectOptionListHtml("x{$Page->RowIndex}_payment_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->payment_status_id->getErrorMessage() ?></div>
<?= $Page->payment_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_payment_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_payment_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_payment_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_payment_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.payment_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_payment_status_id" id="o<?= $Page->RowIndex ?>_payment_status_id" value="<?= HtmlEncode($Page->payment_status_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_payment_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_payment_status_id"
        name="x<?= $Page->RowIndex ?>_payment_status_id"
        class="form-control ew-select<?= $Page->payment_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_payment_status_id"
        data-table="main_transactions"
        data-field="x_payment_status_id"
        data-value-separator="<?= $Page->payment_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->payment_status_id->getPlaceHolder()) ?>"
        <?= $Page->payment_status_id->editAttributes() ?>>
        <?= $Page->payment_status_id->selectOptionListHtml("x{$Page->RowIndex}_payment_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->payment_status_id->getErrorMessage() ?></div>
<?= $Page->payment_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_payment_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_payment_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_payment_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_payment_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.payment_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_payment_status_id">
<span<?= $Page->payment_status_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->payment_status_id->getViewValue()) && $Page->payment_status_id->linkAttributes() != "") { ?>
<a<?= $Page->payment_status_id->linkAttributes() ?>><?= $Page->payment_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->payment_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->total->Visible) { // total ?>
        <td data-name="total" <?= $Page->total->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_total" class="form-group">
<input type="<?= $Page->total->getInputTextType() ?>" data-table="main_transactions" data-field="x_total" name="x<?= $Page->RowIndex ?>_total" id="x<?= $Page->RowIndex ?>_total" size="30" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" value="<?= $Page->total->EditValue ?>"<?= $Page->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_total" data-hidden="1" name="o<?= $Page->RowIndex ?>_total" id="o<?= $Page->RowIndex ?>_total" value="<?= HtmlEncode($Page->total->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_total" class="form-group">
<input type="<?= $Page->total->getInputTextType() ?>" data-table="main_transactions" data-field="x_total" name="x<?= $Page->RowIndex ?>_total" id="x<?= $Page->RowIndex ?>_total" size="30" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" value="<?= $Page->total->EditValue ?>"<?= $Page->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_transactions_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
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
loadjs.ready(["fmain_transactionslist","load"], function () {
    fmain_transactionslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_main_transactions", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_main_transactions_id" class="form-group main_transactions_id"></span>
<input type="hidden" data-table="main_transactions" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id">
<?php if ($Page->campaign_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_transactions_campaign_id" class="form-group main_transactions_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_campaign_id" name="x<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_transactions_campaign_id" class="form-group main_transactions_campaign_id">
<?php $Page->campaign_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_campaign_id"
        name="x<?= $Page->RowIndex ?>_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_campaign_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_campaign_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_campaign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_campaign_id" id="o<?= $Page->RowIndex ?>_campaign_id" value="<?= HtmlEncode($Page->campaign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id">
<?php if ($Page->operator_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_transactions_operator_id" class="form-group main_transactions_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->operator_id->getDisplayValue($Page->operator_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_operator_id" name="x<?= $Page->RowIndex ?>_operator_id" value="<?= HtmlEncode($Page->operator_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_transactions_operator_id" class="form-group main_transactions_operator_id">
    <select
        id="x<?= $Page->RowIndex ?>_operator_id"
        name="x<?= $Page->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_operator_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_operator_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_operator_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_operator_id" id="o<?= $Page->RowIndex ?>_operator_id" value="<?= HtmlEncode($Page->operator_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date">
<span id="el$rowindex$_main_transactions_payment_date" class="form-group main_transactions_payment_date">
<input type="<?= $Page->payment_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_payment_date" data-format="5" name="x<?= $Page->RowIndex ?>_payment_date" id="x<?= $Page->RowIndex ?>_payment_date" placeholder="<?= HtmlEncode($Page->payment_date->getPlaceHolder()) ?>" value="<?= $Page->payment_date->EditValue ?>"<?= $Page->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->payment_date->getErrorMessage() ?></div>
<?php if (!$Page->payment_date->ReadOnly && !$Page->payment_date->Disabled && !isset($Page->payment_date->EditAttrs["readonly"]) && !isset($Page->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionslist", "x<?= $Page->RowIndex ?>_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_date" data-hidden="1" name="o<?= $Page->RowIndex ?>_payment_date" id="o<?= $Page->RowIndex ?>_payment_date" value="<?= HtmlEncode($Page->payment_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el$rowindex$_main_transactions_vendor_id" class="form-group main_transactions_vendor_id">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_transactions"
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
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_transactions_vendor_id" class="form-group main_transactions_vendor_id">
<?php
$onchange = $Page->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Page->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_vendor_id" id="sv_x<?= $Page->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Page->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"<?= $Page->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_transactions" data-field="x_vendor_id" data-input="sv_x<?= $Page->RowIndex ?>_vendor_id" data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_vendor_id" id="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_transactionslist"], function() {
    fmain_transactionslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.main_transactions.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<input type="hidden" data-table="main_transactions" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->price_id->Visible) { // price_id ?>
        <td data-name="price_id">
<span id="el$rowindex$_main_transactions_price_id" class="form-group main_transactions_price_id">
    <select
        id="x<?= $Page->RowIndex ?>_price_id"
        name="x<?= $Page->RowIndex ?>_price_id"
        class="form-control ew-select<?= $Page->price_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_price_id"
        data-table="main_transactions"
        data-field="x_price_id"
        data-value-separator="<?= $Page->price_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->price_id->getPlaceHolder()) ?>"
        <?= $Page->price_id->editAttributes() ?>>
        <?= $Page->price_id->selectOptionListHtml("x{$Page->RowIndex}_price_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->price_id->getErrorMessage() ?></div>
<?= $Page->price_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_price_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_price_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_price_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_price_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.price_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_price_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_price_id" id="o<?= $Page->RowIndex ?>_price_id" value="<?= HtmlEncode($Page->price_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity">
<span id="el$rowindex$_main_transactions_quantity" class="form-group main_transactions_quantity">
<input type="<?= $Page->quantity->getInputTextType() ?>" data-table="main_transactions" data-field="x_quantity" name="x<?= $Page->RowIndex ?>_quantity" id="x<?= $Page->RowIndex ?>_quantity" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>" value="<?= $Page->quantity->EditValue ?>"<?= $Page->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_quantity" data-hidden="1" name="o<?= $Page->RowIndex ?>_quantity" id="o<?= $Page->RowIndex ?>_quantity" value="<?= HtmlEncode($Page->quantity->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->assigned_buses->Visible) { // assigned_buses ?>
        <td data-name="assigned_buses">
<span id="el$rowindex$_main_transactions_assigned_buses" class="form-group main_transactions_assigned_buses">
<input type="<?= $Page->assigned_buses->getInputTextType() ?>" data-table="main_transactions" data-field="x_assigned_buses" name="x<?= $Page->RowIndex ?>_assigned_buses" id="x<?= $Page->RowIndex ?>_assigned_buses" size="30" placeholder="<?= HtmlEncode($Page->assigned_buses->getPlaceHolder()) ?>" value="<?= $Page->assigned_buses->EditValue ?>"<?= $Page->assigned_buses->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assigned_buses->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_assigned_buses" data-hidden="1" name="o<?= $Page->RowIndex ?>_assigned_buses" id="o<?= $Page->RowIndex ?>_assigned_buses" value="<?= HtmlEncode($Page->assigned_buses->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->start_date->Visible) { // start_date ?>
        <td data-name="start_date">
<span id="el$rowindex$_main_transactions_start_date" class="form-group main_transactions_start_date">
<input type="<?= $Page->start_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_start_date" data-format="5" name="x<?= $Page->RowIndex ?>_start_date" id="x<?= $Page->RowIndex ?>_start_date" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>" value="<?= $Page->start_date->EditValue ?>"<?= $Page->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage() ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionslist", "x<?= $Page->RowIndex ?>_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_start_date" data-hidden="1" name="o<?= $Page->RowIndex ?>_start_date" id="o<?= $Page->RowIndex ?>_start_date" value="<?= HtmlEncode($Page->start_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->end_date->Visible) { // end_date ?>
        <td data-name="end_date">
<span id="el$rowindex$_main_transactions_end_date" class="form-group main_transactions_end_date">
<input type="<?= $Page->end_date->getInputTextType() ?>" data-table="main_transactions" data-field="x_end_date" data-format="5" name="x<?= $Page->RowIndex ?>_end_date" id="x<?= $Page->RowIndex ?>_end_date" placeholder="<?= HtmlEncode($Page->end_date->getPlaceHolder()) ?>" value="<?= $Page->end_date->EditValue ?>"<?= $Page->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->end_date->getErrorMessage() ?></div>
<?php if (!$Page->end_date->ReadOnly && !$Page->end_date->Disabled && !isset($Page->end_date->EditAttrs["readonly"]) && !isset($Page->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_transactionslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_transactionslist", "x<?= $Page->RowIndex ?>_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_end_date" data-hidden="1" name="o<?= $Page->RowIndex ?>_end_date" id="o<?= $Page->RowIndex ?>_end_date" value="<?= HtmlEncode($Page->end_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
        <td data-name="visible_status_id">
<span id="el$rowindex$_main_transactions_visible_status_id" class="form-group main_transactions_visible_status_id">
    <select
        id="x<?= $Page->RowIndex ?>_visible_status_id"
        name="x<?= $Page->RowIndex ?>_visible_status_id"
        class="form-control ew-select<?= $Page->visible_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_visible_status_id"
        data-table="main_transactions"
        data-field="x_visible_status_id"
        data-value-separator="<?= $Page->visible_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->visible_status_id->getPlaceHolder()) ?>"
        <?= $Page->visible_status_id->editAttributes() ?>>
        <?= $Page->visible_status_id->selectOptionListHtml("x{$Page->RowIndex}_visible_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->visible_status_id->getErrorMessage() ?></div>
<?= $Page->visible_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_visible_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_visible_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_visible_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_visible_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.visible_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_visible_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_visible_status_id" id="o<?= $Page->RowIndex ?>_visible_status_id" value="<?= HtmlEncode($Page->visible_status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->status_id->Visible) { // status_id ?>
        <td data-name="status_id">
<span id="el$rowindex$_main_transactions_status_id" class="form-group main_transactions_status_id">
    <select
        id="x<?= $Page->RowIndex ?>_status_id"
        name="x<?= $Page->RowIndex ?>_status_id"
        class="form-control ew-select<?= $Page->status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_status_id"
        data-table="main_transactions"
        data-field="x_status_id"
        data-value-separator="<?= $Page->status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_id->getPlaceHolder()) ?>"
        <?= $Page->status_id->editAttributes() ?>>
        <?= $Page->status_id->selectOptionListHtml("x{$Page->RowIndex}_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status_id->getErrorMessage() ?></div>
<?= $Page->status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_status_id" id="o<?= $Page->RowIndex ?>_status_id" value="<?= HtmlEncode($Page->status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->print_status_id->Visible) { // print_status_id ?>
        <td data-name="print_status_id">
<span id="el$rowindex$_main_transactions_print_status_id" class="form-group main_transactions_print_status_id">
    <select
        id="x<?= $Page->RowIndex ?>_print_status_id"
        name="x<?= $Page->RowIndex ?>_print_status_id"
        class="form-control ew-select<?= $Page->print_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_print_status_id"
        data-table="main_transactions"
        data-field="x_print_status_id"
        data-value-separator="<?= $Page->print_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->print_status_id->getPlaceHolder()) ?>"
        <?= $Page->print_status_id->editAttributes() ?>>
        <?= $Page->print_status_id->selectOptionListHtml("x{$Page->RowIndex}_print_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->print_status_id->getErrorMessage() ?></div>
<?= $Page->print_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_print_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_print_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_print_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_print_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.print_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_print_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_print_status_id" id="o<?= $Page->RowIndex ?>_print_status_id" value="<?= HtmlEncode($Page->print_status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
        <td data-name="payment_status_id">
<span id="el$rowindex$_main_transactions_payment_status_id" class="form-group main_transactions_payment_status_id">
    <select
        id="x<?= $Page->RowIndex ?>_payment_status_id"
        name="x<?= $Page->RowIndex ?>_payment_status_id"
        class="form-control ew-select<?= $Page->payment_status_id->isInvalidClass() ?>"
        data-select2-id="main_transactions_x<?= $Page->RowIndex ?>_payment_status_id"
        data-table="main_transactions"
        data-field="x_payment_status_id"
        data-value-separator="<?= $Page->payment_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->payment_status_id->getPlaceHolder()) ?>"
        <?= $Page->payment_status_id->editAttributes() ?>>
        <?= $Page->payment_status_id->selectOptionListHtml("x{$Page->RowIndex}_payment_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->payment_status_id->getErrorMessage() ?></div>
<?= $Page->payment_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_payment_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_transactions_x<?= $Page->RowIndex ?>_payment_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_payment_status_id", selectId: "main_transactions_x<?= $Page->RowIndex ?>_payment_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_transactions.fields.payment_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_payment_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_payment_status_id" id="o<?= $Page->RowIndex ?>_payment_status_id" value="<?= HtmlEncode($Page->payment_status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->total->Visible) { // total ?>
        <td data-name="total">
<span id="el$rowindex$_main_transactions_total" class="form-group main_transactions_total">
<input type="<?= $Page->total->getInputTextType() ?>" data-table="main_transactions" data-field="x_total" name="x<?= $Page->RowIndex ?>_total" id="x<?= $Page->RowIndex ?>_total" size="30" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" value="<?= $Page->total->EditValue ?>"<?= $Page->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_transactions" data-field="x_total" data-hidden="1" name="o<?= $Page->RowIndex ?>_total" id="o<?= $Page->RowIndex ?>_total" value="<?= HtmlEncode($Page->total->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fmain_transactionslist","load"], function() {
    fmain_transactionslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
<?php
// Render aggregate row
$Page->RowType = ROWTYPE_AGGREGATE;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->TotalRecords > 0 && !$Page->isGridAdd() && !$Page->isGridEdit()) { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (footer, left)
$Page->ListOptions->render("footer", "left");
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" class="<?= $Page->id->footerCellClass() ?>"><span id="elf_main_transactions_id" class="main_transactions_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id" class="<?= $Page->campaign_id->footerCellClass() ?>"><span id="elf_main_transactions_campaign_id" class="main_transactions_campaign_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id" class="<?= $Page->operator_id->footerCellClass() ?>"><span id="elf_main_transactions_operator_id" class="main_transactions_operator_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date" class="<?= $Page->payment_date->footerCellClass() ?>"><span id="elf_main_transactions_payment_date" class="main_transactions_payment_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" class="<?= $Page->vendor_id->footerCellClass() ?>"><span id="elf_main_transactions_vendor_id" class="main_transactions_vendor_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->price_id->Visible) { // price_id ?>
        <td data-name="price_id" class="<?= $Page->price_id->footerCellClass() ?>"><span id="elf_main_transactions_price_id" class="main_transactions_price_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" class="<?= $Page->quantity->footerCellClass() ?>"><span id="elf_main_transactions_quantity" class="main_transactions_quantity">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->quantity->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->assigned_buses->Visible) { // assigned_buses ?>
        <td data-name="assigned_buses" class="<?= $Page->assigned_buses->footerCellClass() ?>"><span id="elf_main_transactions_assigned_buses" class="main_transactions_assigned_buses">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->start_date->Visible) { // start_date ?>
        <td data-name="start_date" class="<?= $Page->start_date->footerCellClass() ?>"><span id="elf_main_transactions_start_date" class="main_transactions_start_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->end_date->Visible) { // end_date ?>
        <td data-name="end_date" class="<?= $Page->end_date->footerCellClass() ?>"><span id="elf_main_transactions_end_date" class="main_transactions_end_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
        <td data-name="visible_status_id" class="<?= $Page->visible_status_id->footerCellClass() ?>"><span id="elf_main_transactions_visible_status_id" class="main_transactions_visible_status_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->status_id->Visible) { // status_id ?>
        <td data-name="status_id" class="<?= $Page->status_id->footerCellClass() ?>"><span id="elf_main_transactions_status_id" class="main_transactions_status_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->print_status_id->Visible) { // print_status_id ?>
        <td data-name="print_status_id" class="<?= $Page->print_status_id->footerCellClass() ?>"><span id="elf_main_transactions_print_status_id" class="main_transactions_print_status_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
        <td data-name="payment_status_id" class="<?= $Page->payment_status_id->footerCellClass() ?>"><span id="elf_main_transactions_payment_status_id" class="main_transactions_payment_status_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->total->Visible) { // total ?>
        <td data-name="total" class="<?= $Page->total->footerCellClass() ?>"><span id="elf_main_transactions_total" class="main_transactions_total">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->total->ViewValue ?></span>
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Page->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isEdit()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
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
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
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
    ew.addEventHandlers("main_transactions");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

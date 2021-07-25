<?php

namespace PHPMaker2021\test;

// Page object
$SubTransactionDetailsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsub_transaction_detailslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fsub_transaction_detailslist = currentForm = new ew.Form("fsub_transaction_detailslist", "list");
    fsub_transaction_detailslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sub_transaction_details")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sub_transaction_details)
        ew.vars.tables.sub_transaction_details = currentTable;
    fsub_transaction_detailslist.addFields([
        ["transaction_id", [fields.transaction_id.visible && fields.transaction_id.required ? ew.Validators.required(fields.transaction_id.caption) : null], fields.transaction_id.isInvalid],
        ["bus_id", [fields.bus_id.visible && fields.bus_id.required ? ew.Validators.required(fields.bus_id.caption) : null], fields.bus_id.isInvalid],
        ["vendor_id", [fields.vendor_id.visible && fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null, ew.Validators.integer], fields.vendor_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsub_transaction_detailslist,
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
    fsub_transaction_detailslist.validate = function () {
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
    fsub_transaction_detailslist.emptyRow = function (rowIndex) {
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
    fsub_transaction_detailslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_transaction_detailslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsub_transaction_detailslist.lists.transaction_id = <?= $Page->transaction_id->toClientList($Page) ?>;
    fsub_transaction_detailslist.lists.bus_id = <?= $Page->bus_id->toClientList($Page) ?>;
    fsub_transaction_detailslist.lists.vendor_id = <?= $Page->vendor_id->toClientList($Page) ?>;
    loadjs.done("fsub_transaction_detailslist");
});
var fsub_transaction_detailslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fsub_transaction_detailslistsrch = currentSearchForm = new ew.Form("fsub_transaction_detailslistsrch");

    // Dynamic selection lists

    // Filters
    fsub_transaction_detailslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fsub_transaction_detailslistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "main_transactions") {
    if ($Page->MasterRecordExists) {
        include_once "views/MainTransactionsMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fsub_transaction_detailslistsrch" id="fsub_transaction_detailslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fsub_transaction_detailslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="sub_transaction_details">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> sub_transaction_details">
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
<form name="fsub_transaction_detailslist" id="fsub_transaction_detailslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_transaction_details">
<?php if ($Page->getCurrentMasterTable() == "main_transactions" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_transactions">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->transaction_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_sub_transaction_details" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_sub_transaction_detailslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <th data-name="transaction_id" class="<?= $Page->transaction_id->headerCellClass() ?>"><div id="elh_sub_transaction_details_transaction_id" class="sub_transaction_details_transaction_id"><?= $Page->renderSort($Page->transaction_id) ?></div></th>
<?php } ?>
<?php if ($Page->bus_id->Visible) { // bus_id ?>
        <th data-name="bus_id" class="<?= $Page->bus_id->headerCellClass() ?>"><div id="elh_sub_transaction_details_bus_id" class="sub_transaction_details_bus_id"><?= $Page->renderSort($Page->bus_id) ?></div></th>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <th data-name="vendor_id" class="<?= $Page->vendor_id->headerCellClass() ?>"><div id="elh_sub_transaction_details_vendor_id" class="sub_transaction_details_vendor_id"><?= $Page->renderSort($Page->vendor_id) ?></div></th>
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
        if ($Page->isAdd())
            $Page->loadRowValues();
        if ($Page->EventCancelled) // Insert failed
            $Page->restoreFormValues(); // Restore form values

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_sub_transaction_details", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <td data-name="transaction_id">
<?php if ($Page->transaction_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_transaction_id" class="form-group sub_transaction_details_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->transaction_id->getDisplayValue($Page->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_transaction_id" name="x<?= $Page->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Page->transaction_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_transaction_id" class="form-group sub_transaction_details_transaction_id">
<?php $Page->transaction_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_transaction_id"
        name="x<?= $Page->RowIndex ?>_transaction_id"
        class="form-control ew-select<?= $Page->transaction_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id"
        data-table="sub_transaction_details"
        data-field="x_transaction_id"
        data-value-separator="<?= $Page->transaction_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->transaction_id->getPlaceHolder()) ?>"
        <?= $Page->transaction_id->editAttributes() ?>>
        <?= $Page->transaction_id->selectOptionListHtml("x{$Page->RowIndex}_transaction_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->transaction_id->getErrorMessage() ?></div>
<?= $Page->transaction_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_transaction_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_transaction_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.transaction_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_transaction_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_transaction_id" id="o<?= $Page->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Page->transaction_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id">
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_bus_id" class="form-group sub_transaction_details_bus_id">
    <select
        id="x<?= $Page->RowIndex ?>_bus_id"
        name="x<?= $Page->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_bus_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_id" id="o<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_vendor_id" class="form-group sub_transaction_details_vendor_id">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_vendor_id" class="form-group sub_transaction_details_vendor_id">
<?php
$onchange = $Page->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Page->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_vendor_id" id="sv_x<?= $Page->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Page->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"<?= $Page->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="sub_transaction_details" data-field="x_vendor_id" data-input="sv_x<?= $Page->RowIndex ?>_vendor_id" data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_vendor_id" id="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fsub_transaction_detailslist"], function() {
    fsub_transaction_detailslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.sub_transaction_details.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fsub_transaction_detailslist","load"], function() {
    fsub_transaction_detailslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_sub_transaction_details", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <td data-name="transaction_id" <?= $Page->transaction_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->transaction_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_transaction_id" class="form-group">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->transaction_id->getDisplayValue($Page->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_transaction_id" name="x<?= $Page->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Page->transaction_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_transaction_id" class="form-group">
<?php $Page->transaction_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_transaction_id"
        name="x<?= $Page->RowIndex ?>_transaction_id"
        class="form-control ew-select<?= $Page->transaction_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id"
        data-table="sub_transaction_details"
        data-field="x_transaction_id"
        data-value-separator="<?= $Page->transaction_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->transaction_id->getPlaceHolder()) ?>"
        <?= $Page->transaction_id->editAttributes() ?>>
        <?= $Page->transaction_id->selectOptionListHtml("x{$Page->RowIndex}_transaction_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->transaction_id->getErrorMessage() ?></div>
<?= $Page->transaction_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_transaction_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_transaction_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.transaction_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_transaction_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_transaction_id" id="o<?= $Page->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Page->transaction_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->transaction_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_transaction_id" class="form-group">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->transaction_id->getDisplayValue($Page->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_transaction_id" name="x<?= $Page->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Page->transaction_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_transaction_id" class="form-group">
<?php $Page->transaction_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_transaction_id"
        name="x<?= $Page->RowIndex ?>_transaction_id"
        class="form-control ew-select<?= $Page->transaction_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id"
        data-table="sub_transaction_details"
        data-field="x_transaction_id"
        data-value-separator="<?= $Page->transaction_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->transaction_id->getPlaceHolder()) ?>"
        <?= $Page->transaction_id->editAttributes() ?>>
        <?= $Page->transaction_id->selectOptionListHtml("x{$Page->RowIndex}_transaction_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->transaction_id->getErrorMessage() ?></div>
<?= $Page->transaction_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_transaction_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_transaction_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.transaction_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<?= $Page->transaction_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id" <?= $Page->bus_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_bus_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_id"
        name="x<?= $Page->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_bus_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_id" id="o<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_bus_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_id"
        name="x<?= $Page->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_bus_id">
<span<?= $Page->bus_id->viewAttributes() ?>>
<?= $Page->bus_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" <?= $Page->vendor_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_vendor_id" class="form-group">
<?php
$onchange = $Page->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Page->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_vendor_id" id="sv_x<?= $Page->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Page->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"<?= $Page->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="sub_transaction_details" data-field="x_vendor_id" data-input="sv_x<?= $Page->RowIndex ?>_vendor_id" data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_vendor_id" id="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fsub_transaction_detailslist"], function() {
    fsub_transaction_detailslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.sub_transaction_details.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_vendor_id" class="form-group">
<?php
$onchange = $Page->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Page->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_vendor_id" id="sv_x<?= $Page->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Page->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"<?= $Page->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="sub_transaction_details" data-field="x_vendor_id" data-input="sv_x<?= $Page->RowIndex ?>_vendor_id" data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_vendor_id" id="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fsub_transaction_detailslist"], function() {
    fsub_transaction_detailslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.sub_transaction_details.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_transaction_details_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
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
loadjs.ready(["fsub_transaction_detailslist","load"], function () {
    fsub_transaction_detailslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_sub_transaction_details", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <td data-name="transaction_id">
<?php if ($Page->transaction_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_sub_transaction_details_transaction_id" class="form-group sub_transaction_details_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->transaction_id->getDisplayValue($Page->transaction_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_transaction_id" name="x<?= $Page->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Page->transaction_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_sub_transaction_details_transaction_id" class="form-group sub_transaction_details_transaction_id">
<?php $Page->transaction_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_transaction_id"
        name="x<?= $Page->RowIndex ?>_transaction_id"
        class="form-control ew-select<?= $Page->transaction_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id"
        data-table="sub_transaction_details"
        data-field="x_transaction_id"
        data-value-separator="<?= $Page->transaction_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->transaction_id->getPlaceHolder()) ?>"
        <?= $Page->transaction_id->editAttributes() ?>>
        <?= $Page->transaction_id->selectOptionListHtml("x{$Page->RowIndex}_transaction_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->transaction_id->getErrorMessage() ?></div>
<?= $Page->transaction_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_transaction_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_transaction_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_transaction_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.transaction_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_transaction_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_transaction_id" id="o<?= $Page->RowIndex ?>_transaction_id" value="<?= HtmlEncode($Page->transaction_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id">
<span id="el$rowindex$_sub_transaction_details_bus_id" class="form-group sub_transaction_details_bus_id">
    <select
        id="x<?= $Page->RowIndex ?>_bus_id"
        name="x<?= $Page->RowIndex ?>_bus_id"
        class="form-control ew-select<?= $Page->bus_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_bus_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.bus_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="sub_transaction_details" data-field="x_bus_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_id" id="o<?= $Page->RowIndex ?>_bus_id" value="<?= HtmlEncode($Page->bus_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el$rowindex$_sub_transaction_details_vendor_id" class="form-group sub_transaction_details_vendor_id">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="sub_transaction_details"
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
    var el = document.querySelector("select[data-select2-id='sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "sub_transaction_details_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sub_transaction_details.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_transaction_details_vendor_id" class="form-group sub_transaction_details_vendor_id">
<?php
$onchange = $Page->vendor_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->vendor_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_vendor_id" class="ew-auto-suggest">
    <input type="<?= $Page->vendor_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_vendor_id" id="sv_x<?= $Page->RowIndex ?>_vendor_id" value="<?= RemoveHtml($Page->vendor_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"<?= $Page->vendor_id->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="sub_transaction_details" data-field="x_vendor_id" data-input="sv_x<?= $Page->RowIndex ?>_vendor_id" data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_vendor_id" id="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fsub_transaction_detailslist"], function() {
    fsub_transaction_detailslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_vendor_id","forceSelect":false}, ew.vars.tables.sub_transaction_details.fields.vendor_id.autoSuggestOptions));
});
</script>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
</span>
<?php } ?>
<input type="hidden" data-table="sub_transaction_details" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fsub_transaction_detailslist","load"], function() {
    fsub_transaction_detailslist.updateLists(<?= $Page->RowIndex ?>);
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
    ew.addEventHandlers("sub_transaction_details");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

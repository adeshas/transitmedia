<?php

namespace PHPMaker2021\test;

// Page object
$MainBusesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
if (!ew.vars.tables.main_buses) ew.vars.tables.main_buses = <?= JsonEncode(GetClientVar("tables", "main_buses")) ?>;
var currentForm, currentPageID;
var fmain_buseslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fmain_buseslist = currentForm = new ew.Form("fmain_buseslist", "list");
    fmain_buseslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var fields = ew.vars.tables.main_buses.fields;
    fmain_buseslist.addFields([
        ["id", [fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["number", [fields.number.required ? ew.Validators.required(fields.number.caption) : null], fields.number.isInvalid],
        ["platform_id", [fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid],
        ["operator_id", [fields.operator_id.required ? ew.Validators.required(fields.operator_id.caption) : null], fields.operator_id.isInvalid],
        ["exterior_campaign_id", [fields.exterior_campaign_id.required ? ew.Validators.required(fields.exterior_campaign_id.caption) : null], fields.exterior_campaign_id.isInvalid],
        ["interior_campaign_id", [fields.interior_campaign_id.required ? ew.Validators.required(fields.interior_campaign_id.caption) : null], fields.interior_campaign_id.isInvalid],
        ["bus_status_id", [fields.bus_status_id.required ? ew.Validators.required(fields.bus_status_id.caption) : null], fields.bus_status_id.isInvalid],
        ["bus_depot_id", [fields.bus_depot_id.required ? ew.Validators.required(fields.bus_depot_id.caption) : null], fields.bus_depot_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_buseslist,
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
    fmain_buseslist.validate = function () {
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
    fmain_buseslist.emptyRow = function (rowIndex) {
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
        if (ew.valueChanged(fobj, rowIndex, "bus_depot_id", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fmain_buseslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_buseslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_buseslist.lists.platform_id = <?= $Page->platform_id->toClientList($Page) ?>;
    fmain_buseslist.lists.operator_id = <?= $Page->operator_id->toClientList($Page) ?>;
    fmain_buseslist.lists.exterior_campaign_id = <?= $Page->exterior_campaign_id->toClientList($Page) ?>;
    fmain_buseslist.lists.interior_campaign_id = <?= $Page->interior_campaign_id->toClientList($Page) ?>;
    fmain_buseslist.lists.bus_status_id = <?= $Page->bus_status_id->toClientList($Page) ?>;
    fmain_buseslist.lists.bus_depot_id = <?= $Page->bus_depot_id->toClientList($Page) ?>;
    loadjs.done("fmain_buseslist");
});
var fmain_buseslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fmain_buseslistsrch = currentSearchForm = new ew.Form("fmain_buseslistsrch");

    // Dynamic selection lists

    // Filters
    fmain_buseslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fmain_buseslistsrch");
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
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fmain_buseslistsrch" id="fmain_buseslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fmain_buseslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="main_buses">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> main_buses">
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
<form name="fmain_buseslist" id="fmain_buseslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_buses">
<?php if ($Page->getCurrentMasterTable() == "main_campaigns" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_campaigns">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->exterior_campaign_id->getSessionValue()) ?>">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->interior_campaign_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_main_buses" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_main_buseslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_main_buses_id" class="main_buses_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->number->Visible) { // number ?>
        <th data-name="number" class="<?= $Page->number->headerCellClass() ?>"><div id="elh_main_buses_number" class="main_buses_number"><?= $Page->renderSort($Page->number) ?></div></th>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <th data-name="platform_id" class="<?= $Page->platform_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_buses_platform_id" class="main_buses_platform_id"><?= $Page->renderSort($Page->platform_id) ?></div></th>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <th data-name="operator_id" class="<?= $Page->operator_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_buses_operator_id" class="main_buses_operator_id"><?= $Page->renderSort($Page->operator_id) ?></div></th>
<?php } ?>
<?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <th data-name="exterior_campaign_id" class="<?= $Page->exterior_campaign_id->headerCellClass() ?>"><div id="elh_main_buses_exterior_campaign_id" class="main_buses_exterior_campaign_id"><?= $Page->renderSort($Page->exterior_campaign_id) ?></div></th>
<?php } ?>
<?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <th data-name="interior_campaign_id" class="<?= $Page->interior_campaign_id->headerCellClass() ?>"><div id="elh_main_buses_interior_campaign_id" class="main_buses_interior_campaign_id"><?= $Page->renderSort($Page->interior_campaign_id) ?></div></th>
<?php } ?>
<?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
        <th data-name="bus_status_id" class="<?= $Page->bus_status_id->headerCellClass() ?>"><div id="elh_main_buses_bus_status_id" class="main_buses_bus_status_id"><?= $Page->renderSort($Page->bus_status_id) ?></div></th>
<?php } ?>
<?php if ($Page->bus_depot_id->Visible) { // bus_depot_id ?>
        <th data-name="bus_depot_id" class="<?= $Page->bus_depot_id->headerCellClass() ?>"><div id="elh_main_buses_bus_depot_id" class="main_buses_bus_depot_id"><?= $Page->renderSort($Page->bus_depot_id) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_main_buses", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_main_buses_id" class="form-group"></span>
<input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_id" class="form-group">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->number->Visible) { // number ?>
        <td data-name="number" <?= $Page->number->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_number" class="form-group">
<input type="<?= $Page->number->getInputTextType() ?>" data-table="main_buses" data-field="x_number" name="x<?= $Page->RowIndex ?>_number" id="x<?= $Page->RowIndex ?>_number" size="30" placeholder="<?= HtmlEncode($Page->number->getPlaceHolder()) ?>" value="<?= $Page->number->EditValue ?>"<?= $Page->number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->number->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_buses" data-field="x_number" data-hidden="1" name="o<?= $Page->RowIndex ?>_number" id="o<?= $Page->RowIndex ?>_number" value="<?= HtmlEncode($Page->number->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_number" class="form-group">
<input type="<?= $Page->number->getInputTextType() ?>" data-table="main_buses" data-field="x_number" name="x<?= $Page->RowIndex ?>_number" id="x<?= $Page->RowIndex ?>_number" size="30" placeholder="<?= HtmlEncode($Page->number->getPlaceHolder()) ?>" value="<?= $Page->number->EditValue ?>"<?= $Page->number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->number->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_number">
<span<?= $Page->number->viewAttributes() ?>>
<?= $Page->number->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id" <?= $Page->platform_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_platform_id" class="form-group">
<?php $Page->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_platform_id"
        name="x<?= $Page->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_platform_id"
        data-table="main_buses"
        data-field="x_platform_id"
        data-value-separator="<?= $Page->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->platform_id->getPlaceHolder()) ?>"
        <?= $Page->platform_id->editAttributes() ?>>
        <?= $Page->platform_id->selectOptionListHtml("x{$Page->RowIndex}_platform_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage() ?></div>
<?= $Page->platform_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_platform_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_platform_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_platform_id" id="o<?= $Page->RowIndex ?>_platform_id" value="<?= HtmlEncode($Page->platform_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_platform_id" class="form-group">
<?php $Page->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_platform_id"
        name="x<?= $Page->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_platform_id"
        data-table="main_buses"
        data-field="x_platform_id"
        data-value-separator="<?= $Page->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->platform_id->getPlaceHolder()) ?>"
        <?= $Page->platform_id->editAttributes() ?>>
        <?= $Page->platform_id->selectOptionListHtml("x{$Page->RowIndex}_platform_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage() ?></div>
<?= $Page->platform_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_platform_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id" <?= $Page->operator_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_operator_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_operator_id"
        name="x<?= $Page->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_operator_id"
        data-table="main_buses"
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
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_operator_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_operator_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_operator_id" id="o<?= $Page->RowIndex ?>_operator_id" value="<?= HtmlEncode($Page->operator_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_operator_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_operator_id"
        name="x<?= $Page->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_operator_id"
        data-table="main_buses"
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
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_operator_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <td data-name="exterior_campaign_id" <?= $Page->exterior_campaign_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->exterior_campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_buses_exterior_campaign_id" class="form-group">
<span<?= $Page->exterior_campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->exterior_campaign_id->getDisplayValue($Page->exterior_campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_exterior_campaign_id" name="x<?= $Page->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Page->exterior_campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_buses_exterior_campaign_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_exterior_campaign_id"
        name="x<?= $Page->RowIndex ?>_exterior_campaign_id"
        class="form-control ew-select<?= $Page->exterior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_exterior_campaign_id"
        data-table="main_buses"
        data-field="x_exterior_campaign_id"
        data-value-separator="<?= $Page->exterior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->exterior_campaign_id->getPlaceHolder()) ?>"
        <?= $Page->exterior_campaign_id->editAttributes() ?>>
        <?= $Page->exterior_campaign_id->selectOptionListHtml("x{$Page->RowIndex}_exterior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->exterior_campaign_id->getErrorMessage() ?></div>
<?= $Page->exterior_campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_exterior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_exterior_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_exterior_campaign_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_exterior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.exterior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_exterior_campaign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_exterior_campaign_id" id="o<?= $Page->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Page->exterior_campaign_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->exterior_campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_buses_exterior_campaign_id" class="form-group">
<span<?= $Page->exterior_campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->exterior_campaign_id->getDisplayValue($Page->exterior_campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_exterior_campaign_id" name="x<?= $Page->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Page->exterior_campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_buses_exterior_campaign_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_exterior_campaign_id"
        name="x<?= $Page->RowIndex ?>_exterior_campaign_id"
        class="form-control ew-select<?= $Page->exterior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_exterior_campaign_id"
        data-table="main_buses"
        data-field="x_exterior_campaign_id"
        data-value-separator="<?= $Page->exterior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->exterior_campaign_id->getPlaceHolder()) ?>"
        <?= $Page->exterior_campaign_id->editAttributes() ?>>
        <?= $Page->exterior_campaign_id->selectOptionListHtml("x{$Page->RowIndex}_exterior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->exterior_campaign_id->getErrorMessage() ?></div>
<?= $Page->exterior_campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_exterior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_exterior_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_exterior_campaign_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_exterior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.exterior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_exterior_campaign_id">
<span<?= $Page->exterior_campaign_id->viewAttributes() ?>>
<?= $Page->exterior_campaign_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <td data-name="interior_campaign_id" <?= $Page->interior_campaign_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->interior_campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_buses_interior_campaign_id" class="form-group">
<span<?= $Page->interior_campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->interior_campaign_id->getDisplayValue($Page->interior_campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_interior_campaign_id" name="x<?= $Page->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Page->interior_campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_buses_interior_campaign_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_interior_campaign_id"
        name="x<?= $Page->RowIndex ?>_interior_campaign_id"
        class="form-control ew-select<?= $Page->interior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_interior_campaign_id"
        data-table="main_buses"
        data-field="x_interior_campaign_id"
        data-value-separator="<?= $Page->interior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->interior_campaign_id->getPlaceHolder()) ?>"
        <?= $Page->interior_campaign_id->editAttributes() ?>>
        <?= $Page->interior_campaign_id->selectOptionListHtml("x{$Page->RowIndex}_interior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->interior_campaign_id->getErrorMessage() ?></div>
<?= $Page->interior_campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_interior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_interior_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_interior_campaign_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_interior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.interior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_interior_campaign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_interior_campaign_id" id="o<?= $Page->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Page->interior_campaign_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->interior_campaign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_buses_interior_campaign_id" class="form-group">
<span<?= $Page->interior_campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->interior_campaign_id->getDisplayValue($Page->interior_campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_interior_campaign_id" name="x<?= $Page->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Page->interior_campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_buses_interior_campaign_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_interior_campaign_id"
        name="x<?= $Page->RowIndex ?>_interior_campaign_id"
        class="form-control ew-select<?= $Page->interior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_interior_campaign_id"
        data-table="main_buses"
        data-field="x_interior_campaign_id"
        data-value-separator="<?= $Page->interior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->interior_campaign_id->getPlaceHolder()) ?>"
        <?= $Page->interior_campaign_id->editAttributes() ?>>
        <?= $Page->interior_campaign_id->selectOptionListHtml("x{$Page->RowIndex}_interior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->interior_campaign_id->getErrorMessage() ?></div>
<?= $Page->interior_campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_interior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_interior_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_interior_campaign_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_interior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.interior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_interior_campaign_id">
<span<?= $Page->interior_campaign_id->viewAttributes() ?>>
<?= $Page->interior_campaign_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
        <td data-name="bus_status_id" <?= $Page->bus_status_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_bus_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_status_id"
        name="x<?= $Page->RowIndex ?>_bus_status_id"
        class="form-control ew-select<?= $Page->bus_status_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_bus_status_id"
        data-table="main_buses"
        data-field="x_bus_status_id"
        data-value-separator="<?= $Page->bus_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_status_id->getPlaceHolder()) ?>"
        <?= $Page->bus_status_id->editAttributes() ?>>
        <?= $Page->bus_status_id->selectOptionListHtml("x{$Page->RowIndex}_bus_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_status_id->getErrorMessage() ?></div>
<?= $Page->bus_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_bus_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_status_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_bus_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_bus_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_status_id" id="o<?= $Page->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Page->bus_status_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_bus_status_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_status_id"
        name="x<?= $Page->RowIndex ?>_bus_status_id"
        class="form-control ew-select<?= $Page->bus_status_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_bus_status_id"
        data-table="main_buses"
        data-field="x_bus_status_id"
        data-value-separator="<?= $Page->bus_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_status_id->getPlaceHolder()) ?>"
        <?= $Page->bus_status_id->editAttributes() ?>>
        <?= $Page->bus_status_id->selectOptionListHtml("x{$Page->RowIndex}_bus_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_status_id->getErrorMessage() ?></div>
<?= $Page->bus_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_bus_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_status_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_bus_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_bus_status_id">
<span<?= $Page->bus_status_id->viewAttributes() ?>>
<?= $Page->bus_status_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->bus_depot_id->Visible) { // bus_depot_id ?>
        <td data-name="bus_depot_id" <?= $Page->bus_depot_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_bus_depot_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_depot_id"
        name="x<?= $Page->RowIndex ?>_bus_depot_id"
        class="form-control ew-select<?= $Page->bus_depot_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_bus_depot_id"
        data-table="main_buses"
        data-field="x_bus_depot_id"
        data-value-separator="<?= $Page->bus_depot_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_depot_id->getPlaceHolder()) ?>"
        <?= $Page->bus_depot_id->editAttributes() ?>>
        <?= $Page->bus_depot_id->selectOptionListHtml("x{$Page->RowIndex}_bus_depot_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_depot_id->getErrorMessage() ?></div>
<?= $Page->bus_depot_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_depot_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_bus_depot_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_depot_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_bus_depot_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_depot_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_bus_depot_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_depot_id" id="o<?= $Page->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Page->bus_depot_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_bus_depot_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_depot_id"
        name="x<?= $Page->RowIndex ?>_bus_depot_id"
        class="form-control ew-select<?= $Page->bus_depot_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_bus_depot_id"
        data-table="main_buses"
        data-field="x_bus_depot_id"
        data-value-separator="<?= $Page->bus_depot_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_depot_id->getPlaceHolder()) ?>"
        <?= $Page->bus_depot_id->editAttributes() ?>>
        <?= $Page->bus_depot_id->selectOptionListHtml("x{$Page->RowIndex}_bus_depot_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_depot_id->getErrorMessage() ?></div>
<?= $Page->bus_depot_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_depot_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_bus_depot_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_depot_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_bus_depot_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_depot_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_buses_bus_depot_id">
<span<?= $Page->bus_depot_id->viewAttributes() ?>>
<?= $Page->bus_depot_id->getViewValue() ?></span>
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
loadjs.ready(["fmain_buseslist","load"], function () {
    fmain_buseslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_main_buses", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_main_buses_id" class="form-group main_buses_id"></span>
<input type="hidden" data-table="main_buses" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->number->Visible) { // number ?>
        <td data-name="number">
<span id="el$rowindex$_main_buses_number" class="form-group main_buses_number">
<input type="<?= $Page->number->getInputTextType() ?>" data-table="main_buses" data-field="x_number" name="x<?= $Page->RowIndex ?>_number" id="x<?= $Page->RowIndex ?>_number" size="30" placeholder="<?= HtmlEncode($Page->number->getPlaceHolder()) ?>" value="<?= $Page->number->EditValue ?>"<?= $Page->number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->number->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_buses" data-field="x_number" data-hidden="1" name="o<?= $Page->RowIndex ?>_number" id="o<?= $Page->RowIndex ?>_number" value="<?= HtmlEncode($Page->number->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id">
<span id="el$rowindex$_main_buses_platform_id" class="form-group main_buses_platform_id">
<?php $Page->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_platform_id"
        name="x<?= $Page->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_platform_id"
        data-table="main_buses"
        data-field="x_platform_id"
        data-value-separator="<?= $Page->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->platform_id->getPlaceHolder()) ?>"
        <?= $Page->platform_id->editAttributes() ?>>
        <?= $Page->platform_id->selectOptionListHtml("x{$Page->RowIndex}_platform_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage() ?></div>
<?= $Page->platform_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_platform_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_platform_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_platform_id" id="o<?= $Page->RowIndex ?>_platform_id" value="<?= HtmlEncode($Page->platform_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id">
<span id="el$rowindex$_main_buses_operator_id" class="form-group main_buses_operator_id">
    <select
        id="x<?= $Page->RowIndex ?>_operator_id"
        name="x<?= $Page->RowIndex ?>_operator_id"
        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_operator_id"
        data-table="main_buses"
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
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_operator_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_operator_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.operator_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_operator_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_operator_id" id="o<?= $Page->RowIndex ?>_operator_id" value="<?= HtmlEncode($Page->operator_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <td data-name="exterior_campaign_id">
<?php if ($Page->exterior_campaign_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_buses_exterior_campaign_id" class="form-group main_buses_exterior_campaign_id">
<span<?= $Page->exterior_campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->exterior_campaign_id->getDisplayValue($Page->exterior_campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_exterior_campaign_id" name="x<?= $Page->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Page->exterior_campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_buses_exterior_campaign_id" class="form-group main_buses_exterior_campaign_id">
    <select
        id="x<?= $Page->RowIndex ?>_exterior_campaign_id"
        name="x<?= $Page->RowIndex ?>_exterior_campaign_id"
        class="form-control ew-select<?= $Page->exterior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_exterior_campaign_id"
        data-table="main_buses"
        data-field="x_exterior_campaign_id"
        data-value-separator="<?= $Page->exterior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->exterior_campaign_id->getPlaceHolder()) ?>"
        <?= $Page->exterior_campaign_id->editAttributes() ?>>
        <?= $Page->exterior_campaign_id->selectOptionListHtml("x{$Page->RowIndex}_exterior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->exterior_campaign_id->getErrorMessage() ?></div>
<?= $Page->exterior_campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_exterior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_exterior_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_exterior_campaign_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_exterior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.exterior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_exterior_campaign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_exterior_campaign_id" id="o<?= $Page->RowIndex ?>_exterior_campaign_id" value="<?= HtmlEncode($Page->exterior_campaign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <td data-name="interior_campaign_id">
<?php if ($Page->interior_campaign_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_buses_interior_campaign_id" class="form-group main_buses_interior_campaign_id">
<span<?= $Page->interior_campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->interior_campaign_id->getDisplayValue($Page->interior_campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_interior_campaign_id" name="x<?= $Page->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Page->interior_campaign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_main_buses_interior_campaign_id" class="form-group main_buses_interior_campaign_id">
    <select
        id="x<?= $Page->RowIndex ?>_interior_campaign_id"
        name="x<?= $Page->RowIndex ?>_interior_campaign_id"
        class="form-control ew-select<?= $Page->interior_campaign_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_interior_campaign_id"
        data-table="main_buses"
        data-field="x_interior_campaign_id"
        data-value-separator="<?= $Page->interior_campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->interior_campaign_id->getPlaceHolder()) ?>"
        <?= $Page->interior_campaign_id->editAttributes() ?>>
        <?= $Page->interior_campaign_id->selectOptionListHtml("x{$Page->RowIndex}_interior_campaign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->interior_campaign_id->getErrorMessage() ?></div>
<?= $Page->interior_campaign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_interior_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_interior_campaign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_interior_campaign_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_interior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.interior_campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_buses" data-field="x_interior_campaign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_interior_campaign_id" id="o<?= $Page->RowIndex ?>_interior_campaign_id" value="<?= HtmlEncode($Page->interior_campaign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
        <td data-name="bus_status_id">
<span id="el$rowindex$_main_buses_bus_status_id" class="form-group main_buses_bus_status_id">
    <select
        id="x<?= $Page->RowIndex ?>_bus_status_id"
        name="x<?= $Page->RowIndex ?>_bus_status_id"
        class="form-control ew-select<?= $Page->bus_status_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_bus_status_id"
        data-table="main_buses"
        data-field="x_bus_status_id"
        data-value-separator="<?= $Page->bus_status_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_status_id->getPlaceHolder()) ?>"
        <?= $Page->bus_status_id->editAttributes() ?>>
        <?= $Page->bus_status_id->selectOptionListHtml("x{$Page->RowIndex}_bus_status_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_status_id->getErrorMessage() ?></div>
<?= $Page->bus_status_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_status_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_bus_status_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_status_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_bus_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_status_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_bus_status_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_status_id" id="o<?= $Page->RowIndex ?>_bus_status_id" value="<?= HtmlEncode($Page->bus_status_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->bus_depot_id->Visible) { // bus_depot_id ?>
        <td data-name="bus_depot_id">
<span id="el$rowindex$_main_buses_bus_depot_id" class="form-group main_buses_bus_depot_id">
    <select
        id="x<?= $Page->RowIndex ?>_bus_depot_id"
        name="x<?= $Page->RowIndex ?>_bus_depot_id"
        class="form-control ew-select<?= $Page->bus_depot_id->isInvalidClass() ?>"
        data-select2-id="main_buses_x<?= $Page->RowIndex ?>_bus_depot_id"
        data-table="main_buses"
        data-field="x_bus_depot_id"
        data-value-separator="<?= $Page->bus_depot_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_depot_id->getPlaceHolder()) ?>"
        <?= $Page->bus_depot_id->editAttributes() ?>>
        <?= $Page->bus_depot_id->selectOptionListHtml("x{$Page->RowIndex}_bus_depot_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_depot_id->getErrorMessage() ?></div>
<?= $Page->bus_depot_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_depot_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_buses_x<?= $Page->RowIndex ?>_bus_depot_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_depot_id", selectId: "main_buses_x<?= $Page->RowIndex ?>_bus_depot_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_buses.fields.bus_depot_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="main_buses" data-field="x_bus_depot_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_depot_id" id="o<?= $Page->RowIndex ?>_bus_depot_id" value="<?= HtmlEncode($Page->bus_depot_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fmain_buseslist","load"], function() {
    fmain_buseslist.updateLists(<?= $Page->RowIndex ?>);
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
    ew.addEventHandlers("main_buses");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

<?php

namespace PHPMaker2021\test;

// Page object
$ViewTransactionsPerOperatorList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
if (!ew.vars.tables.view_transactions_per_operator) ew.vars.tables.view_transactions_per_operator = <?= JsonEncode(GetClientVar("tables", "view_transactions_per_operator")) ?>;
var currentForm, currentPageID;
var fview_transactions_per_operatorlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fview_transactions_per_operatorlist = currentForm = new ew.Form("fview_transactions_per_operatorlist", "list");
    fview_transactions_per_operatorlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fview_transactions_per_operatorlist");
});
var fview_transactions_per_operatorlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fview_transactions_per_operatorlistsrch = currentSearchForm = new ew.Form("fview_transactions_per_operatorlistsrch");

    // Add fields
    var fields = ew.vars.tables.view_transactions_per_operator.fields;
    fview_transactions_per_operatorlistsrch.addFields([
        ["transaction_id", [], fields.transaction_id.isInvalid],
        ["campaign", [], fields.campaign.isInvalid],
        ["payment_date", [ew.Validators.datetime(0)], fields.payment_date.isInvalid],
        ["inventory", [], fields.inventory.isInvalid],
        ["bus_size", [], fields.bus_size.isInvalid],
        ["vendor", [], fields.vendor.isInvalid],
        ["operator", [], fields.operator.isInvalid],
        ["platform", [], fields.platform.isInvalid],
        ["transaction_status", [], fields.transaction_status.isInvalid],
        ["quantity", [ew.Validators.integer], fields.quantity.isInvalid],
        ["operator_fee", [], fields.operator_fee.isInvalid],
        ["total", [], fields.total.isInvalid],
        ["download", [], fields.download.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fview_transactions_per_operatorlistsrch.setInvalid();
    });

    // Validate form
    fview_transactions_per_operatorlistsrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fview_transactions_per_operatorlistsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fview_transactions_per_operatorlistsrch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists

    // Filters
    fview_transactions_per_operatorlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_transactions_per_operatorlistsrch");
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
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fview_transactions_per_operatorlistsrch" id="fview_transactions_per_operatorlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fview_transactions_per_operatorlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_transactions_per_operator">
    <div class="ew-extended-search">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->campaign->Visible) { // campaign ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_campaign" class="ew-cell form-group">
        <label for="x_campaign" class="ew-search-caption ew-label"><?= $Page->campaign->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_campaign" id="z_campaign" value="LIKE">
</span>
        <span id="el_view_transactions_per_operator_campaign" class="ew-search-field">
<input type="<?= $Page->campaign->getInputTextType() ?>" data-table="view_transactions_per_operator" data-field="x_campaign" name="x_campaign" id="x_campaign" size="35" placeholder="<?= HtmlEncode($Page->campaign->getPlaceHolder()) ?>" value="<?= $Page->campaign->EditValue ?>"<?= $Page->campaign->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->campaign->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_payment_date" class="ew-cell form-group">
        <label for="x_payment_date" class="ew-search-caption ew-label"><?= $Page->payment_date->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_payment_date" id="z_payment_date" value="=">
</span>
        <span id="el_view_transactions_per_operator_payment_date" class="ew-search-field">
<input type="<?= $Page->payment_date->getInputTextType() ?>" data-table="view_transactions_per_operator" data-field="x_payment_date" name="x_payment_date" id="x_payment_date" placeholder="<?= HtmlEncode($Page->payment_date->getPlaceHolder()) ?>" value="<?= $Page->payment_date->EditValue ?>"<?= $Page->payment_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->payment_date->getErrorMessage(false) ?></div>
<?php if (!$Page->payment_date->ReadOnly && !$Page->payment_date->Disabled && !isset($Page->payment_date->EditAttrs["readonly"]) && !isset($Page->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_transactions_per_operatorlistsrch", "datetimepicker"], function() {
    ew.createDateTimePicker("fview_transactions_per_operatorlistsrch", "x_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->inventory->Visible) { // inventory ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_inventory" class="ew-cell form-group">
        <label for="x_inventory" class="ew-search-caption ew-label"><?= $Page->inventory->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_inventory" id="z_inventory" value="LIKE">
</span>
        <span id="el_view_transactions_per_operator_inventory" class="ew-search-field">
<input type="<?= $Page->inventory->getInputTextType() ?>" data-table="view_transactions_per_operator" data-field="x_inventory" name="x_inventory" id="x_inventory" size="35" placeholder="<?= HtmlEncode($Page->inventory->getPlaceHolder()) ?>" value="<?= $Page->inventory->EditValue ?>"<?= $Page->inventory->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->inventory->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->vendor->Visible) { // vendor ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_vendor" class="ew-cell form-group">
        <label for="x_vendor" class="ew-search-caption ew-label"><?= $Page->vendor->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_vendor" id="z_vendor" value="LIKE">
</span>
        <span id="el_view_transactions_per_operator_vendor" class="ew-search-field">
<input type="<?= $Page->vendor->getInputTextType() ?>" data-table="view_transactions_per_operator" data-field="x_vendor" name="x_vendor" id="x_vendor" size="30" placeholder="<?= HtmlEncode($Page->vendor->getPlaceHolder()) ?>" value="<?= $Page->vendor->EditValue ?>"<?= $Page->vendor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vendor->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_quantity" class="ew-cell form-group">
        <label for="x_quantity" class="ew-search-caption ew-label"><?= $Page->quantity->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_quantity" id="z_quantity" value="=">
</span>
        <span id="el_view_transactions_per_operator_quantity" class="ew-search-field">
<input type="<?= $Page->quantity->getInputTextType() ?>" data-table="view_transactions_per_operator" data-field="x_quantity" name="x_quantity" id="x_quantity" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>" value="<?= $Page->quantity->EditValue ?>"<?= $Page->quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow > 0) { ?>
</div>
    <?php } ?>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_transactions_per_operator">
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
<form name="fview_transactions_per_operatorlist" id="fview_transactions_per_operatorlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_transactions_per_operator">
<div id="gmp_view_transactions_per_operator" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_transactions_per_operatorlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="transaction_id" class="<?= $Page->transaction_id->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_transaction_id" class="view_transactions_per_operator_transaction_id"><?= $Page->renderSort($Page->transaction_id) ?></div></th>
<?php } ?>
<?php if ($Page->campaign->Visible) { // campaign ?>
        <th data-name="campaign" class="<?= $Page->campaign->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_campaign" class="view_transactions_per_operator_campaign"><?= $Page->renderSort($Page->campaign) ?></div></th>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
        <th data-name="payment_date" class="<?= $Page->payment_date->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_payment_date" class="view_transactions_per_operator_payment_date"><?= $Page->renderSort($Page->payment_date) ?></div></th>
<?php } ?>
<?php if ($Page->inventory->Visible) { // inventory ?>
        <th data-name="inventory" class="<?= $Page->inventory->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_inventory" class="view_transactions_per_operator_inventory"><?= $Page->renderSort($Page->inventory) ?></div></th>
<?php } ?>
<?php if ($Page->bus_size->Visible) { // bus_size ?>
        <th data-name="bus_size" class="<?= $Page->bus_size->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_bus_size" class="view_transactions_per_operator_bus_size"><?= $Page->renderSort($Page->bus_size) ?></div></th>
<?php } ?>
<?php if ($Page->vendor->Visible) { // vendor ?>
        <th data-name="vendor" class="<?= $Page->vendor->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_vendor" class="view_transactions_per_operator_vendor"><?= $Page->renderSort($Page->vendor) ?></div></th>
<?php } ?>
<?php if ($Page->operator->Visible) { // operator ?>
        <th data-name="operator" class="<?= $Page->operator->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_operator" class="view_transactions_per_operator_operator"><?= $Page->renderSort($Page->operator) ?></div></th>
<?php } ?>
<?php if ($Page->platform->Visible) { // platform ?>
        <th data-name="platform" class="<?= $Page->platform->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_platform" class="view_transactions_per_operator_platform"><?= $Page->renderSort($Page->platform) ?></div></th>
<?php } ?>
<?php if ($Page->transaction_status->Visible) { // transaction_status ?>
        <th data-name="transaction_status" class="<?= $Page->transaction_status->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_transaction_status" class="view_transactions_per_operator_transaction_status"><?= $Page->renderSort($Page->transaction_status) ?></div></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Page->quantity->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_quantity" class="view_transactions_per_operator_quantity"><?= $Page->renderSort($Page->quantity) ?></div></th>
<?php } ?>
<?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <th data-name="operator_fee" class="<?= $Page->operator_fee->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_operator_fee" class="view_transactions_per_operator_operator_fee"><?= $Page->renderSort($Page->operator_fee) ?></div></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th data-name="total" class="<?= $Page->total->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_total" class="view_transactions_per_operator_total"><?= $Page->renderSort($Page->total) ?></div></th>
<?php } ?>
<?php if ($Page->download->Visible) { // download ?>
        <th data-name="download" class="<?= $Page->download->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_operator_download" class="view_transactions_per_operator_download"><?= $Page->renderSort($Page->download) ?></div></th>
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
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

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

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_view_transactions_per_operator", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <td data-name="transaction_id" <?= $Page->transaction_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<?= $Page->transaction_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->campaign->Visible) { // campaign ?>
        <td data-name="campaign" <?= $Page->campaign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_campaign">
<span<?= $Page->campaign->viewAttributes() ?>>
<?= $Page->campaign->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date" <?= $Page->payment_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_payment_date">
<span<?= $Page->payment_date->viewAttributes() ?>>
<?= $Page->payment_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->inventory->Visible) { // inventory ?>
        <td data-name="inventory" <?= $Page->inventory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_inventory">
<span<?= $Page->inventory->viewAttributes() ?>>
<?php if (!EmptyString($Page->inventory->TooltipValue) && $Page->inventory->linkAttributes() != "") { ?>
<a<?= $Page->inventory->linkAttributes() ?>><?= $Page->inventory->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->inventory->getViewValue() ?>
<?php } ?>
<span id="tt_view_transactions_per_operator_x<?= $Page->RowCount ?>_inventory" class="d-none">
<?= $Page->inventory->TooltipValue ?>
</span></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_size->Visible) { // bus_size ?>
        <td data-name="bus_size" <?= $Page->bus_size->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_bus_size">
<span<?= $Page->bus_size->viewAttributes() ?>>
<?= $Page->bus_size->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vendor->Visible) { // vendor ?>
        <td data-name="vendor" <?= $Page->vendor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_vendor">
<span<?= $Page->vendor->viewAttributes() ?>>
<?= $Page->vendor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator->Visible) { // operator ?>
        <td data-name="operator" <?= $Page->operator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_operator">
<span<?= $Page->operator->viewAttributes() ?>>
<?= $Page->operator->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->platform->Visible) { // platform ?>
        <td data-name="platform" <?= $Page->platform->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_platform">
<span<?= $Page->platform->viewAttributes() ?>>
<?= $Page->platform->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transaction_status->Visible) { // transaction_status ?>
        <td data-name="transaction_status" <?= $Page->transaction_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_transaction_status">
<span<?= $Page->transaction_status->viewAttributes() ?>>
<?= $Page->transaction_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <td data-name="operator_fee" <?= $Page->operator_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_operator_fee">
<span<?= $Page->operator_fee->viewAttributes() ?>>
<?= $Page->operator_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->total->Visible) { // total ?>
        <td data-name="total" <?= $Page->total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->download->Visible) { // download ?>
        <td data-name="download" <?= $Page->download->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_operator_download">
<span<?= $Page->download->viewAttributes() ?>>
<?php if (!EmptyString($Page->download->getViewValue()) && $Page->download->linkAttributes() != "") { ?>
<a<?= $Page->download->linkAttributes() ?>><?= $Page->download->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->download->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
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
    <?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <td data-name="transaction_id" class="<?= $Page->transaction_id->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_transaction_id" class="view_transactions_per_operator_transaction_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->campaign->Visible) { // campaign ?>
        <td data-name="campaign" class="<?= $Page->campaign->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_campaign" class="view_transactions_per_operator_campaign">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date" class="<?= $Page->payment_date->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_payment_date" class="view_transactions_per_operator_payment_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->inventory->Visible) { // inventory ?>
        <td data-name="inventory" class="<?= $Page->inventory->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_inventory" class="view_transactions_per_operator_inventory">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->bus_size->Visible) { // bus_size ?>
        <td data-name="bus_size" class="<?= $Page->bus_size->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_bus_size" class="view_transactions_per_operator_bus_size">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->vendor->Visible) { // vendor ?>
        <td data-name="vendor" class="<?= $Page->vendor->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_vendor" class="view_transactions_per_operator_vendor">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->operator->Visible) { // operator ?>
        <td data-name="operator" class="<?= $Page->operator->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_operator" class="view_transactions_per_operator_operator">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->platform->Visible) { // platform ?>
        <td data-name="platform" class="<?= $Page->platform->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_platform" class="view_transactions_per_operator_platform">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->transaction_status->Visible) { // transaction_status ?>
        <td data-name="transaction_status" class="<?= $Page->transaction_status->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_transaction_status" class="view_transactions_per_operator_transaction_status">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" class="<?= $Page->quantity->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_quantity" class="view_transactions_per_operator_quantity">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->quantity->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <td data-name="operator_fee" class="<?= $Page->operator_fee->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_operator_fee" class="view_transactions_per_operator_operator_fee">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->operator_fee->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->total->Visible) { // total ?>
        <td data-name="total" class="<?= $Page->total->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_total" class="view_transactions_per_operator_total">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->total->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->download->Visible) { // download ?>
        <td data-name="download" class="<?= $Page->download->footerCellClass() ?>"><span id="elf_view_transactions_per_operator_download" class="view_transactions_per_operator_download">
        &nbsp;
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
    ew.addEventHandlers("view_transactions_per_operator");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

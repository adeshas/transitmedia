<?php

namespace PHPMaker2021\test;

// Page object
$ViewPricingInitialList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fview_pricing_initiallist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fview_pricing_initiallist = currentForm = new ew.Form("fview_pricing_initiallist", "list");
    fview_pricing_initiallist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fview_pricing_initiallist");
});
var fview_pricing_initiallistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fview_pricing_initiallistsrch = currentSearchForm = new ew.Form("fview_pricing_initiallistsrch");

    // Dynamic selection lists

    // Filters
    fview_pricing_initiallistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_pricing_initiallistsrch");
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
<form name="fview_pricing_initiallistsrch" id="fview_pricing_initiallistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fview_pricing_initiallistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_pricing_initial">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_pricing_initial">
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
<form name="fview_pricing_initiallist" id="fview_pricing_initiallist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_pricing_initial">
<div id="gmp_view_pricing_initial" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_pricing_initiallist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_view_pricing_initial_id" class="view_pricing_initial_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->platform->Visible) { // platform ?>
        <th data-name="platform" class="<?= $Page->platform->headerCellClass() ?>"><div id="elh_view_pricing_initial_platform" class="view_pricing_initial_platform"><?= $Page->renderSort($Page->platform) ?></div></th>
<?php } ?>
<?php if ($Page->inventory->Visible) { // inventory ?>
        <th data-name="inventory" class="<?= $Page->inventory->headerCellClass() ?>"><div id="elh_view_pricing_initial_inventory" class="view_pricing_initial_inventory"><?= $Page->renderSort($Page->inventory) ?></div></th>
<?php } ?>
<?php if ($Page->print_stage->Visible) { // print_stage ?>
        <th data-name="print_stage" class="<?= $Page->print_stage->headerCellClass() ?>"><div id="elh_view_pricing_initial_print_stage" class="view_pricing_initial_print_stage"><?= $Page->renderSort($Page->print_stage) ?></div></th>
<?php } ?>
<?php if ($Page->bus_size->Visible) { // bus_size ?>
        <th data-name="bus_size" class="<?= $Page->bus_size->headerCellClass() ?>"><div id="elh_view_pricing_initial_bus_size" class="view_pricing_initial_bus_size"><?= $Page->renderSort($Page->bus_size) ?></div></th>
<?php } ?>
<?php if ($Page->max_limit->Visible) { // max_limit ?>
        <th data-name="max_limit" class="<?= $Page->max_limit->headerCellClass() ?>"><div id="elh_view_pricing_initial_max_limit" class="view_pricing_initial_max_limit"><?= $Page->renderSort($Page->max_limit) ?></div></th>
<?php } ?>
<?php if ($Page->min_limit->Visible) { // min_limit ?>
        <th data-name="min_limit" class="<?= $Page->min_limit->headerCellClass() ?>"><div id="elh_view_pricing_initial_min_limit" class="view_pricing_initial_min_limit"><?= $Page->renderSort($Page->min_limit) ?></div></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th data-name="price" class="<?= $Page->price->headerCellClass() ?>"><div id="elh_view_pricing_initial_price" class="view_pricing_initial_price"><?= $Page->renderSort($Page->price) ?></div></th>
<?php } ?>
<?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <th data-name="operator_fee" class="<?= $Page->operator_fee->headerCellClass() ?>"><div id="elh_view_pricing_initial_operator_fee" class="view_pricing_initial_operator_fee"><?= $Page->renderSort($Page->operator_fee) ?></div></th>
<?php } ?>
<?php if ($Page->agency_fee->Visible) { // agency_fee ?>
        <th data-name="agency_fee" class="<?= $Page->agency_fee->headerCellClass() ?>"><div id="elh_view_pricing_initial_agency_fee" class="view_pricing_initial_agency_fee"><?= $Page->renderSort($Page->agency_fee) ?></div></th>
<?php } ?>
<?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <th data-name="lamata_fee" class="<?= $Page->lamata_fee->headerCellClass() ?>"><div id="elh_view_pricing_initial_lamata_fee" class="view_pricing_initial_lamata_fee"><?= $Page->renderSort($Page->lamata_fee) ?></div></th>
<?php } ?>
<?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <th data-name="lasaa_fee" class="<?= $Page->lasaa_fee->headerCellClass() ?>"><div id="elh_view_pricing_initial_lasaa_fee" class="view_pricing_initial_lasaa_fee"><?= $Page->renderSort($Page->lasaa_fee) ?></div></th>
<?php } ?>
<?php if ($Page->printers_fee->Visible) { // printers_fee ?>
        <th data-name="printers_fee" class="<?= $Page->printers_fee->headerCellClass() ?>"><div id="elh_view_pricing_initial_printers_fee" class="view_pricing_initial_printers_fee"><?= $Page->renderSort($Page->printers_fee) ?></div></th>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <th data-name="active" class="<?= $Page->active->headerCellClass() ?>"><div id="elh_view_pricing_initial_active" class="view_pricing_initial_active"><?= $Page->renderSort($Page->active) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_view_pricing_initial", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->platform->Visible) { // platform ?>
        <td data-name="platform" <?= $Page->platform->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_platform">
<span<?= $Page->platform->viewAttributes() ?>>
<?= $Page->platform->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->inventory->Visible) { // inventory ?>
        <td data-name="inventory" <?= $Page->inventory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_inventory">
<span<?= $Page->inventory->viewAttributes() ?>>
<?= $Page->inventory->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->print_stage->Visible) { // print_stage ?>
        <td data-name="print_stage" <?= $Page->print_stage->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_print_stage">
<span<?= $Page->print_stage->viewAttributes() ?>>
<?= $Page->print_stage->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_size->Visible) { // bus_size ?>
        <td data-name="bus_size" <?= $Page->bus_size->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_bus_size">
<span<?= $Page->bus_size->viewAttributes() ?>>
<?= $Page->bus_size->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->max_limit->Visible) { // max_limit ?>
        <td data-name="max_limit" <?= $Page->max_limit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_max_limit">
<span<?= $Page->max_limit->viewAttributes() ?>>
<?= $Page->max_limit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->min_limit->Visible) { // min_limit ?>
        <td data-name="min_limit" <?= $Page->min_limit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_min_limit">
<span<?= $Page->min_limit->viewAttributes() ?>>
<?= $Page->min_limit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price" <?= $Page->price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <td data-name="operator_fee" <?= $Page->operator_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_operator_fee">
<span<?= $Page->operator_fee->viewAttributes() ?>>
<?= $Page->operator_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->agency_fee->Visible) { // agency_fee ?>
        <td data-name="agency_fee" <?= $Page->agency_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_agency_fee">
<span<?= $Page->agency_fee->viewAttributes() ?>>
<?= $Page->agency_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <td data-name="lamata_fee" <?= $Page->lamata_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_lamata_fee">
<span<?= $Page->lamata_fee->viewAttributes() ?>>
<?= $Page->lamata_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <td data-name="lasaa_fee" <?= $Page->lasaa_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_lasaa_fee">
<span<?= $Page->lasaa_fee->viewAttributes() ?>>
<?= $Page->lasaa_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->printers_fee->Visible) { // printers_fee ?>
        <td data-name="printers_fee" <?= $Page->printers_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_printers_fee">
<span<?= $Page->printers_fee->viewAttributes() ?>>
<?= $Page->printers_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->active->Visible) { // active ?>
        <td data-name="active" <?= $Page->active->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_pricing_initial_active">
<span<?= $Page->active->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_active_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->active->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->active->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_active_<?= $Page->RowCount ?>"></label>
</div></span>
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
    ew.addEventHandlers("view_pricing_initial");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

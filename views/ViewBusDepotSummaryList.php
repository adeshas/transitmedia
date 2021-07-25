<?php

namespace PHPMaker2021\test;

// Page object
$ViewBusDepotSummaryList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fview_bus_depot_summarylist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fview_bus_depot_summarylist = currentForm = new ew.Form("fview_bus_depot_summarylist", "list");
    fview_bus_depot_summarylist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fview_bus_depot_summarylist");
});
var fview_bus_depot_summarylistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fview_bus_depot_summarylistsrch = currentSearchForm = new ew.Form("fview_bus_depot_summarylistsrch");

    // Dynamic selection lists

    // Filters
    fview_bus_depot_summarylistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_bus_depot_summarylistsrch");
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
<form name="fview_bus_depot_summarylistsrch" id="fview_bus_depot_summarylistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fview_bus_depot_summarylistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_bus_depot_summary">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_bus_depot_summary">
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
<form name="fview_bus_depot_summarylist" id="fview_bus_depot_summarylist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_bus_depot_summary">
<div id="gmp_view_bus_depot_summary" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_bus_depot_summarylist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->depot->Visible) { // depot ?>
        <th data-name="depot" class="<?= $Page->depot->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_bus_depot_summary_depot" class="view_bus_depot_summary_depot"><?= $Page->renderSort($Page->depot) ?></div></th>
<?php } ?>
<?php if ($Page->total_buses->Visible) { // total_buses ?>
        <th data-name="total_buses" class="<?= $Page->total_buses->headerCellClass() ?>"><div id="elh_view_bus_depot_summary_total_buses" class="view_bus_depot_summary_total_buses"><?= $Page->renderSort($Page->total_buses) ?></div></th>
<?php } ?>
<?php if ($Page->bus_codes->Visible) { // bus_codes ?>
        <th data-name="bus_codes" class="<?= $Page->bus_codes->headerCellClass() ?>"><div id="elh_view_bus_depot_summary_bus_codes" class="view_bus_depot_summary_bus_codes"><?= $Page->renderSort($Page->bus_codes) ?></div></th>
<?php } ?>
<?php if ($Page->good_bus_codes->Visible) { // good_bus_codes ?>
        <th data-name="good_bus_codes" class="<?= $Page->good_bus_codes->headerCellClass() ?>"><div id="elh_view_bus_depot_summary_good_bus_codes" class="view_bus_depot_summary_good_bus_codes"><?= $Page->renderSort($Page->good_bus_codes) ?></div></th>
<?php } ?>
<?php if ($Page->bad_bus_codes->Visible) { // bad_bus_codes ?>
        <th data-name="bad_bus_codes" class="<?= $Page->bad_bus_codes->headerCellClass() ?>"><div id="elh_view_bus_depot_summary_bad_bus_codes" class="view_bus_depot_summary_bad_bus_codes"><?= $Page->renderSort($Page->bad_bus_codes) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_view_bus_depot_summary", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->depot->Visible) { // depot ?>
        <td data-name="depot" <?= $Page->depot->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_depot_summary_depot">
<span<?= $Page->depot->viewAttributes() ?>>
<?= $Page->depot->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->total_buses->Visible) { // total_buses ?>
        <td data-name="total_buses" <?= $Page->total_buses->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_depot_summary_total_buses">
<span<?= $Page->total_buses->viewAttributes() ?>>
<?= $Page->total_buses->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_codes->Visible) { // bus_codes ?>
        <td data-name="bus_codes" <?= $Page->bus_codes->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_depot_summary_bus_codes">
<span<?= $Page->bus_codes->viewAttributes() ?>>
<?= $Page->bus_codes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->good_bus_codes->Visible) { // good_bus_codes ?>
        <td data-name="good_bus_codes" <?= $Page->good_bus_codes->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_depot_summary_good_bus_codes">
<span<?= $Page->good_bus_codes->viewAttributes() ?>>
<?= $Page->good_bus_codes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bad_bus_codes->Visible) { // bad_bus_codes ?>
        <td data-name="bad_bus_codes" <?= $Page->bad_bus_codes->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_depot_summary_bad_bus_codes">
<span<?= $Page->bad_bus_codes->viewAttributes() ?>>
<?= $Page->bad_bus_codes->getViewValue() ?></span>
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
    ew.addEventHandlers("view_bus_depot_summary");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

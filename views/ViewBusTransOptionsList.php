<?php

namespace PHPMaker2021\test;

// Page object
$ViewBusTransOptionsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fview_bus_trans_optionslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fview_bus_trans_optionslist = currentForm = new ew.Form("fview_bus_trans_optionslist", "list");
    fview_bus_trans_optionslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fview_bus_trans_optionslist");
});
var fview_bus_trans_optionslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fview_bus_trans_optionslistsrch = currentSearchForm = new ew.Form("fview_bus_trans_optionslistsrch");

    // Dynamic selection lists

    // Filters
    fview_bus_trans_optionslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_bus_trans_optionslistsrch");
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
<form name="fview_bus_trans_optionslistsrch" id="fview_bus_trans_optionslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fview_bus_trans_optionslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_bus_trans_options">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_bus_trans_options">
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
<form name="fview_bus_trans_optionslist" id="fview_bus_trans_optionslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_bus_trans_options">
<div id="gmp_view_bus_trans_options" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_bus_trans_optionslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->bus_id->Visible) { // bus_id ?>
        <th data-name="bus_id" class="<?= $Page->bus_id->headerCellClass() ?>"><div id="elh_view_bus_trans_options_bus_id" class="view_bus_trans_options_bus_id"><?= $Page->renderSort($Page->bus_id) ?></div></th>
<?php } ?>
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <th data-name="transaction_id" class="<?= $Page->transaction_id->headerCellClass() ?>"><div id="elh_view_bus_trans_options_transaction_id" class="view_bus_trans_options_transaction_id"><?= $Page->renderSort($Page->transaction_id) ?></div></th>
<?php } ?>
<?php if ($Page->number->Visible) { // number ?>
        <th data-name="number" class="<?= $Page->number->headerCellClass() ?>"><div id="elh_view_bus_trans_options_number" class="view_bus_trans_options_number"><?= $Page->renderSort($Page->number) ?></div></th>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <th data-name="platform_id" class="<?= $Page->platform_id->headerCellClass() ?>"><div id="elh_view_bus_trans_options_platform_id" class="view_bus_trans_options_platform_id"><?= $Page->renderSort($Page->platform_id) ?></div></th>
<?php } ?>
<?php if ($Page->platform->Visible) { // platform ?>
        <th data-name="platform" class="<?= $Page->platform->headerCellClass() ?>"><div id="elh_view_bus_trans_options_platform" class="view_bus_trans_options_platform"><?= $Page->renderSort($Page->platform) ?></div></th>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <th data-name="operator_id" class="<?= $Page->operator_id->headerCellClass() ?>"><div id="elh_view_bus_trans_options_operator_id" class="view_bus_trans_options_operator_id"><?= $Page->renderSort($Page->operator_id) ?></div></th>
<?php } ?>
<?php if ($Page->operator->Visible) { // operator ?>
        <th data-name="operator" class="<?= $Page->operator->headerCellClass() ?>"><div id="elh_view_bus_trans_options_operator" class="view_bus_trans_options_operator"><?= $Page->renderSort($Page->operator) ?></div></th>
<?php } ?>
<?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
        <th data-name="bus_status_id" class="<?= $Page->bus_status_id->headerCellClass() ?>"><div id="elh_view_bus_trans_options_bus_status_id" class="view_bus_trans_options_bus_status_id"><?= $Page->renderSort($Page->bus_status_id) ?></div></th>
<?php } ?>
<?php if ($Page->bus_status->Visible) { // bus_status ?>
        <th data-name="bus_status" class="<?= $Page->bus_status->headerCellClass() ?>"><div id="elh_view_bus_trans_options_bus_status" class="view_bus_trans_options_bus_status"><?= $Page->renderSort($Page->bus_status) ?></div></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Page->quantity->headerCellClass() ?>"><div id="elh_view_bus_trans_options_quantity" class="view_bus_trans_options_quantity"><?= $Page->renderSort($Page->quantity) ?></div></th>
<?php } ?>
<?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <th data-name="exterior_campaign_id" class="<?= $Page->exterior_campaign_id->headerCellClass() ?>"><div id="elh_view_bus_trans_options_exterior_campaign_id" class="view_bus_trans_options_exterior_campaign_id"><?= $Page->renderSort($Page->exterior_campaign_id) ?></div></th>
<?php } ?>
<?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <th data-name="interior_campaign_id" class="<?= $Page->interior_campaign_id->headerCellClass() ?>"><div id="elh_view_bus_trans_options_interior_campaign_id" class="view_bus_trans_options_interior_campaign_id"><?= $Page->renderSort($Page->interior_campaign_id) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_view_bus_trans_options", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->bus_id->Visible) { // bus_id ?>
        <td data-name="bus_id" <?= $Page->bus_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_bus_id">
<span<?= $Page->bus_id->viewAttributes() ?>>
<?= $Page->bus_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <td data-name="transaction_id" <?= $Page->transaction_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<?= $Page->transaction_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->number->Visible) { // number ?>
        <td data-name="number" <?= $Page->number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_number">
<span<?= $Page->number->viewAttributes() ?>>
<?= $Page->number->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id" <?= $Page->platform_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->platform->Visible) { // platform ?>
        <td data-name="platform" <?= $Page->platform->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_platform">
<span<?= $Page->platform->viewAttributes() ?>>
<?= $Page->platform->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator_id->Visible) { // operator_id ?>
        <td data-name="operator_id" <?= $Page->operator_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator->Visible) { // operator ?>
        <td data-name="operator" <?= $Page->operator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_operator">
<span<?= $Page->operator->viewAttributes() ?>>
<?= $Page->operator->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
        <td data-name="bus_status_id" <?= $Page->bus_status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_bus_status_id">
<span<?= $Page->bus_status_id->viewAttributes() ?>>
<?= $Page->bus_status_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_status->Visible) { // bus_status ?>
        <td data-name="bus_status" <?= $Page->bus_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_bus_status">
<span<?= $Page->bus_status->viewAttributes() ?>>
<?= $Page->bus_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <td data-name="exterior_campaign_id" <?= $Page->exterior_campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_exterior_campaign_id">
<span<?= $Page->exterior_campaign_id->viewAttributes() ?>>
<?= $Page->exterior_campaign_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <td data-name="interior_campaign_id" <?= $Page->interior_campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_bus_trans_options_interior_campaign_id">
<span<?= $Page->interior_campaign_id->viewAttributes() ?>>
<?= $Page->interior_campaign_id->getViewValue() ?></span>
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
    ew.addEventHandlers("view_bus_trans_options");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

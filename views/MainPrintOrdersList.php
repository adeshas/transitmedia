<?php

namespace PHPMaker2021\test;

// Page object
$MainPrintOrdersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmain_print_orderslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fmain_print_orderslist = currentForm = new ew.Form("fmain_print_orderslist", "list");
    fmain_print_orderslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fmain_print_orderslist");
});
var fmain_print_orderslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fmain_print_orderslistsrch = currentSearchForm = new ew.Form("fmain_print_orderslistsrch");

    // Dynamic selection lists

    // Filters
    fmain_print_orderslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fmain_print_orderslistsrch");
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
<form name="fmain_print_orderslistsrch" id="fmain_print_orderslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fmain_print_orderslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="main_print_orders">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> main_print_orders">
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
<form name="fmain_print_orderslist" id="fmain_print_orderslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_print_orders">
<div id="gmp_main_print_orders" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_main_print_orderslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_main_print_orders_id" class="main_print_orders_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <th data-name="campaign_id" class="<?= $Page->campaign_id->headerCellClass() ?>"><div id="elh_main_print_orders_campaign_id" class="main_print_orders_campaign_id"><?= $Page->renderSort($Page->campaign_id) ?></div></th>
<?php } ?>
<?php if ($Page->printer_id->Visible) { // printer_id ?>
        <th data-name="printer_id" class="<?= $Page->printer_id->headerCellClass() ?>"><div id="elh_main_print_orders_printer_id" class="main_print_orders_printer_id"><?= $Page->renderSort($Page->printer_id) ?></div></th>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
        <th data-name="ts_created" class="<?= $Page->ts_created->headerCellClass() ?>"><div id="elh_main_print_orders_ts_created" class="main_print_orders_ts_created"><?= $Page->renderSort($Page->ts_created) ?></div></th>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
        <th data-name="link" class="<?= $Page->link->headerCellClass() ?>"><div id="elh_main_print_orders_link" class="main_print_orders_link"><?= $Page->renderSort($Page->link) ?></div></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Page->quantity->headerCellClass() ?>"><div id="elh_main_print_orders_quantity" class="main_print_orders_quantity"><?= $Page->renderSort($Page->quantity) ?></div></th>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
        <th data-name="approved" class="<?= $Page->approved->headerCellClass() ?>"><div id="elh_main_print_orders_approved" class="main_print_orders_approved"><?= $Page->renderSort($Page->approved) ?></div></th>
<?php } ?>
<?php if ($Page->comments->Visible) { // comments ?>
        <th data-name="comments" class="<?= $Page->comments->headerCellClass() ?>"><div id="elh_main_print_orders_comments" class="main_print_orders_comments"><?= $Page->renderSort($Page->comments) ?></div></th>
<?php } ?>
<?php if ($Page->bus_codes->Visible) { // bus_codes ?>
        <th data-name="bus_codes" class="<?= $Page->bus_codes->headerCellClass() ?>"><div id="elh_main_print_orders_bus_codes" class="main_print_orders_bus_codes"><?= $Page->renderSort($Page->bus_codes) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_main_print_orders", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_main_print_orders_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id" <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_print_orders_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->printer_id->Visible) { // printer_id ?>
        <td data-name="printer_id" <?= $Page->printer_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_print_orders_printer_id">
<span<?= $Page->printer_id->viewAttributes() ?>>
<?= $Page->printer_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ts_created->Visible) { // ts_created ?>
        <td data-name="ts_created" <?= $Page->ts_created->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_print_orders_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->link->Visible) { // link ?>
        <td data-name="link" <?= $Page->link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_print_orders_link">
<span<?= $Page->link->viewAttributes() ?>>
<?php if (!EmptyString($Page->link->getViewValue()) && $Page->link->linkAttributes() != "") { ?>
<a<?= $Page->link->linkAttributes() ?>><?= $Page->link->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->link->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_print_orders_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->approved->Visible) { // approved ?>
        <td data-name="approved" <?= $Page->approved->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_print_orders_approved">
<span<?= $Page->approved->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_approved_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->approved->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->approved->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_approved_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->comments->Visible) { // comments ?>
        <td data-name="comments" <?= $Page->comments->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_print_orders_comments">
<span<?= $Page->comments->viewAttributes() ?>>
<?= $Page->comments->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_codes->Visible) { // bus_codes ?>
        <td data-name="bus_codes" <?= $Page->bus_codes->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_print_orders_bus_codes">
<span<?= $Page->bus_codes->viewAttributes() ?>>
<?= $Page->bus_codes->getViewValue() ?></span>
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
    ew.addEventHandlers("main_print_orders");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

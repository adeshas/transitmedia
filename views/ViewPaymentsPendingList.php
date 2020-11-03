<?php

namespace PHPMaker2021\test;

// Page object
$ViewPaymentsPendingList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fview_payments_pendinglist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fview_payments_pendinglist = currentForm = new ew.Form("fview_payments_pendinglist", "list");
    fview_payments_pendinglist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fview_payments_pendinglist");
});
var fview_payments_pendinglistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fview_payments_pendinglistsrch = currentSearchForm = new ew.Form("fview_payments_pendinglistsrch");

    // Dynamic selection lists

    // Filters
    fview_payments_pendinglistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_payments_pendinglistsrch");
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
<form name="fview_payments_pendinglistsrch" id="fview_payments_pendinglistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fview_payments_pendinglistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_payments_pending">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_payments_pending">
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
<form name="fview_payments_pendinglist" id="fview_payments_pendinglist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_payments_pending">
<div id="gmp_view_payments_pending" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_payments_pendinglist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="transaction_id" class="<?= $Page->transaction_id->headerCellClass() ?>"><div id="elh_view_payments_pending_transaction_id" class="view_payments_pending_transaction_id"><?= $Page->renderSort($Page->transaction_id) ?></div></th>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <th data-name="campaign_id" class="<?= $Page->campaign_id->headerCellClass() ?>"><div id="elh_view_payments_pending_campaign_id" class="view_payments_pending_campaign_id"><?= $Page->renderSort($Page->campaign_id) ?></div></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Page->quantity->headerCellClass() ?>"><div id="elh_view_payments_pending_quantity" class="view_payments_pending_quantity"><?= $Page->renderSort($Page->quantity) ?></div></th>
<?php } ?>
<?php if ($Page->campaign_status->Visible) { // campaign_status ?>
        <th data-name="campaign_status" class="<?= $Page->campaign_status->headerCellClass() ?>"><div id="elh_view_payments_pending_campaign_status" class="view_payments_pending_campaign_status"><?= $Page->renderSort($Page->campaign_status) ?></div></th>
<?php } ?>
<?php if ($Page->print_status->Visible) { // print_status ?>
        <th data-name="print_status" class="<?= $Page->print_status->headerCellClass() ?>"><div id="elh_view_payments_pending_print_status" class="view_payments_pending_print_status"><?= $Page->renderSort($Page->print_status) ?></div></th>
<?php } ?>
<?php if ($Page->payment_status->Visible) { // payment_status ?>
        <th data-name="payment_status" class="<?= $Page->payment_status->headerCellClass() ?>"><div id="elh_view_payments_pending_payment_status" class="view_payments_pending_payment_status"><?= $Page->renderSort($Page->payment_status) ?></div></th>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <th data-name="start_date" class="<?= $Page->start_date->headerCellClass() ?>"><div id="elh_view_payments_pending_start_date" class="view_payments_pending_start_date"><?= $Page->renderSort($Page->start_date) ?></div></th>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <th data-name="end_date" class="<?= $Page->end_date->headerCellClass() ?>"><div id="elh_view_payments_pending_end_date" class="view_payments_pending_end_date"><?= $Page->renderSort($Page->end_date) ?></div></th>
<?php } ?>
<?php if ($Page->vendor->Visible) { // vendor ?>
        <th data-name="vendor" class="<?= $Page->vendor->headerCellClass() ?>"><div id="elh_view_payments_pending_vendor" class="view_payments_pending_vendor"><?= $Page->renderSort($Page->vendor) ?></div></th>
<?php } ?>
<?php if ($Page->operator->Visible) { // operator ?>
        <th data-name="operator" class="<?= $Page->operator->headerCellClass() ?>"><div id="elh_view_payments_pending_operator" class="view_payments_pending_operator"><?= $Page->renderSort($Page->operator) ?></div></th>
<?php } ?>
<?php if ($Page->platform->Visible) { // platform ?>
        <th data-name="platform" class="<?= $Page->platform->headerCellClass() ?>"><div id="elh_view_payments_pending_platform" class="view_payments_pending_platform"><?= $Page->renderSort($Page->platform) ?></div></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th data-name="price" class="<?= $Page->price->headerCellClass() ?>"><div id="elh_view_payments_pending_price" class="view_payments_pending_price"><?= $Page->renderSort($Page->price) ?></div></th>
<?php } ?>
<?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <th data-name="operator_fee" class="<?= $Page->operator_fee->headerCellClass() ?>"><div id="elh_view_payments_pending_operator_fee" class="view_payments_pending_operator_fee"><?= $Page->renderSort($Page->operator_fee) ?></div></th>
<?php } ?>
<?php if ($Page->agency_fee->Visible) { // agency_fee ?>
        <th data-name="agency_fee" class="<?= $Page->agency_fee->headerCellClass() ?>"><div id="elh_view_payments_pending_agency_fee" class="view_payments_pending_agency_fee"><?= $Page->renderSort($Page->agency_fee) ?></div></th>
<?php } ?>
<?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <th data-name="lamata_fee" class="<?= $Page->lamata_fee->headerCellClass() ?>"><div id="elh_view_payments_pending_lamata_fee" class="view_payments_pending_lamata_fee"><?= $Page->renderSort($Page->lamata_fee) ?></div></th>
<?php } ?>
<?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <th data-name="lasaa_fee" class="<?= $Page->lasaa_fee->headerCellClass() ?>"><div id="elh_view_payments_pending_lasaa_fee" class="view_payments_pending_lasaa_fee"><?= $Page->renderSort($Page->lasaa_fee) ?></div></th>
<?php } ?>
<?php if ($Page->printers_fee->Visible) { // printers_fee ?>
        <th data-name="printers_fee" class="<?= $Page->printers_fee->headerCellClass() ?>"><div id="elh_view_payments_pending_printers_fee" class="view_payments_pending_printers_fee"><?= $Page->renderSort($Page->printers_fee) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_view_payments_pending", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_view_payments_pending_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<?= $Page->transaction_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td data-name="campaign_id" <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->campaign_status->Visible) { // campaign_status ?>
        <td data-name="campaign_status" <?= $Page->campaign_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_campaign_status">
<span<?= $Page->campaign_status->viewAttributes() ?>>
<?= $Page->campaign_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->print_status->Visible) { // print_status ?>
        <td data-name="print_status" <?= $Page->print_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_print_status">
<span<?= $Page->print_status->viewAttributes() ?>>
<?= $Page->print_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->payment_status->Visible) { // payment_status ?>
        <td data-name="payment_status" <?= $Page->payment_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_payment_status">
<span<?= $Page->payment_status->viewAttributes() ?>>
<?= $Page->payment_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->start_date->Visible) { // start_date ?>
        <td data-name="start_date" <?= $Page->start_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->end_date->Visible) { // end_date ?>
        <td data-name="end_date" <?= $Page->end_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vendor->Visible) { // vendor ?>
        <td data-name="vendor" <?= $Page->vendor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_vendor">
<span<?= $Page->vendor->viewAttributes() ?>>
<?= $Page->vendor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator->Visible) { // operator ?>
        <td data-name="operator" <?= $Page->operator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_operator">
<span<?= $Page->operator->viewAttributes() ?>>
<?= $Page->operator->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->platform->Visible) { // platform ?>
        <td data-name="platform" <?= $Page->platform->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_platform">
<span<?= $Page->platform->viewAttributes() ?>>
<?= $Page->platform->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price" <?= $Page->price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <td data-name="operator_fee" <?= $Page->operator_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_operator_fee">
<span<?= $Page->operator_fee->viewAttributes() ?>>
<?= $Page->operator_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->agency_fee->Visible) { // agency_fee ?>
        <td data-name="agency_fee" <?= $Page->agency_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_agency_fee">
<span<?= $Page->agency_fee->viewAttributes() ?>>
<?= $Page->agency_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <td data-name="lamata_fee" <?= $Page->lamata_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_lamata_fee">
<span<?= $Page->lamata_fee->viewAttributes() ?>>
<?= $Page->lamata_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <td data-name="lasaa_fee" <?= $Page->lasaa_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_lasaa_fee">
<span<?= $Page->lasaa_fee->viewAttributes() ?>>
<?= $Page->lasaa_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->printers_fee->Visible) { // printers_fee ?>
        <td data-name="printers_fee" <?= $Page->printers_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_payments_pending_printers_fee">
<span<?= $Page->printers_fee->viewAttributes() ?>>
<?= $Page->printers_fee->getViewValue() ?></span>
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
    ew.addEventHandlers("view_payments_pending");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

<?php

namespace PHPMaker2021\test;

// Page object
$ViewTransactionsPerPlatformList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fview_transactions_per_platformlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fview_transactions_per_platformlist = currentForm = new ew.Form("fview_transactions_per_platformlist", "list");
    fview_transactions_per_platformlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fview_transactions_per_platformlist");
});
var fview_transactions_per_platformlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fview_transactions_per_platformlistsrch = currentSearchForm = new ew.Form("fview_transactions_per_platformlistsrch");

    // Dynamic selection lists

    // Filters
    fview_transactions_per_platformlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_transactions_per_platformlistsrch");
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
<form name="fview_transactions_per_platformlistsrch" id="fview_transactions_per_platformlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fview_transactions_per_platformlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_transactions_per_platform">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_transactions_per_platform">
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
<form name="fview_transactions_per_platformlist" id="fview_transactions_per_platformlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_transactions_per_platform">
<div id="gmp_view_transactions_per_platform" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_transactions_per_platformlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="transaction_id" class="<?= $Page->transaction_id->headerCellClass() ?>"><div id="elh_view_transactions_per_platform_transaction_id" class="view_transactions_per_platform_transaction_id"><?= $Page->renderSort($Page->transaction_id) ?></div></th>
<?php } ?>
<?php if ($Page->campaign->Visible) { // campaign ?>
        <th data-name="campaign" class="<?= $Page->campaign->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_platform_campaign" class="view_transactions_per_platform_campaign"><?= $Page->renderSort($Page->campaign) ?></div></th>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
        <th data-name="payment_date" class="<?= $Page->payment_date->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_platform_payment_date" class="view_transactions_per_platform_payment_date"><?= $Page->renderSort($Page->payment_date) ?></div></th>
<?php } ?>
<?php if ($Page->inventory->Visible) { // inventory ?>
        <th data-name="inventory" class="<?= $Page->inventory->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_platform_inventory" class="view_transactions_per_platform_inventory"><?= $Page->renderSort($Page->inventory) ?></div></th>
<?php } ?>
<?php if ($Page->vendor->Visible) { // vendor ?>
        <th data-name="vendor" class="<?= $Page->vendor->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_platform_vendor" class="view_transactions_per_platform_vendor"><?= $Page->renderSort($Page->vendor) ?></div></th>
<?php } ?>
<?php if ($Page->operator->Visible) { // operator ?>
        <th data-name="operator" class="<?= $Page->operator->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_platform_operator" class="view_transactions_per_platform_operator"><?= $Page->renderSort($Page->operator) ?></div></th>
<?php } ?>
<?php if ($Page->transaction_status->Visible) { // transaction_status ?>
        <th data-name="transaction_status" class="<?= $Page->transaction_status->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_platform_transaction_status" class="view_transactions_per_platform_transaction_status"><?= $Page->renderSort($Page->transaction_status) ?></div></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th data-name="price" class="<?= $Page->price->headerCellClass() ?>"><div id="elh_view_transactions_per_platform_price" class="view_transactions_per_platform_price"><?= $Page->renderSort($Page->price) ?></div></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Page->quantity->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_platform_quantity" class="view_transactions_per_platform_quantity"><?= $Page->renderSort($Page->quantity) ?></div></th>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <th data-name="amount_paid" class="<?= $Page->amount_paid->headerCellClass() ?>"><div id="elh_view_transactions_per_platform_amount_paid" class="view_transactions_per_platform_amount_paid"><?= $Page->renderSort($Page->amount_paid) ?></div></th>
<?php } ?>
<?php if ($Page->transitmedia_fee->Visible) { // transitmedia_fee ?>
        <th data-name="transitmedia_fee" class="<?= $Page->transitmedia_fee->headerCellClass() ?>"><div id="elh_view_transactions_per_platform_transitmedia_fee" class="view_transactions_per_platform_transitmedia_fee"><?= $Page->renderSort($Page->transitmedia_fee) ?></div></th>
<?php } ?>
<?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <th data-name="lasaa_fee" class="<?= $Page->lasaa_fee->headerCellClass() ?>"><div id="elh_view_transactions_per_platform_lasaa_fee" class="view_transactions_per_platform_lasaa_fee"><?= $Page->renderSort($Page->lasaa_fee) ?></div></th>
<?php } ?>
<?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <th data-name="operator_fee" class="<?= $Page->operator_fee->headerCellClass() ?>"><div id="elh_view_transactions_per_platform_operator_fee" class="view_transactions_per_platform_operator_fee"><?= $Page->renderSort($Page->operator_fee) ?></div></th>
<?php } ?>
<?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <th data-name="lamata_fee" class="<?= $Page->lamata_fee->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_platform_lamata_fee" class="view_transactions_per_platform_lamata_fee"><?= $Page->renderSort($Page->lamata_fee) ?></div></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th data-name="total" class="<?= $Page->total->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_transactions_per_platform_total" class="view_transactions_per_platform_total"><?= $Page->renderSort($Page->total) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_view_transactions_per_platform", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_transaction_id">
<span<?= $Page->transaction_id->viewAttributes() ?>>
<?= $Page->transaction_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->campaign->Visible) { // campaign ?>
        <td data-name="campaign" <?= $Page->campaign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_campaign">
<span<?= $Page->campaign->viewAttributes() ?>>
<?= $Page->campaign->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date" <?= $Page->payment_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_payment_date">
<span<?= $Page->payment_date->viewAttributes() ?>>
<?= $Page->payment_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->inventory->Visible) { // inventory ?>
        <td data-name="inventory" <?= $Page->inventory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_inventory">
<span<?= $Page->inventory->viewAttributes() ?>>
<?= $Page->inventory->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vendor->Visible) { // vendor ?>
        <td data-name="vendor" <?= $Page->vendor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_vendor">
<span<?= $Page->vendor->viewAttributes() ?>>
<?= $Page->vendor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator->Visible) { // operator ?>
        <td data-name="operator" <?= $Page->operator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_operator">
<span<?= $Page->operator->viewAttributes() ?>>
<?= $Page->operator->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transaction_status->Visible) { // transaction_status ?>
        <td data-name="transaction_status" <?= $Page->transaction_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_transaction_status">
<span<?= $Page->transaction_status->viewAttributes() ?>>
<?= $Page->transaction_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price" <?= $Page->price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" <?= $Page->amount_paid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_amount_paid">
<span<?= $Page->amount_paid->viewAttributes() ?>>
<?= $Page->amount_paid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transitmedia_fee->Visible) { // transitmedia_fee ?>
        <td data-name="transitmedia_fee" <?= $Page->transitmedia_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_transitmedia_fee">
<span<?= $Page->transitmedia_fee->viewAttributes() ?>>
<?= $Page->transitmedia_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <td data-name="lasaa_fee" <?= $Page->lasaa_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_lasaa_fee">
<span<?= $Page->lasaa_fee->viewAttributes() ?>>
<?= $Page->lasaa_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <td data-name="operator_fee" <?= $Page->operator_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_operator_fee">
<span<?= $Page->operator_fee->viewAttributes() ?>>
<?= $Page->operator_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <td data-name="lamata_fee" <?= $Page->lamata_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_lamata_fee">
<span<?= $Page->lamata_fee->viewAttributes() ?>>
<?= $Page->lamata_fee->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->total->Visible) { // total ?>
        <td data-name="total" <?= $Page->total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_transactions_per_platform_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
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
        <td data-name="transaction_id" class="<?= $Page->transaction_id->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_transaction_id" class="view_transactions_per_platform_transaction_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->campaign->Visible) { // campaign ?>
        <td data-name="campaign" class="<?= $Page->campaign->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_campaign" class="view_transactions_per_platform_campaign">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->payment_date->Visible) { // payment_date ?>
        <td data-name="payment_date" class="<?= $Page->payment_date->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_payment_date" class="view_transactions_per_platform_payment_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->inventory->Visible) { // inventory ?>
        <td data-name="inventory" class="<?= $Page->inventory->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_inventory" class="view_transactions_per_platform_inventory">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->vendor->Visible) { // vendor ?>
        <td data-name="vendor" class="<?= $Page->vendor->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_vendor" class="view_transactions_per_platform_vendor">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->operator->Visible) { // operator ?>
        <td data-name="operator" class="<?= $Page->operator->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_operator" class="view_transactions_per_platform_operator">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->transaction_status->Visible) { // transaction_status ?>
        <td data-name="transaction_status" class="<?= $Page->transaction_status->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_transaction_status" class="view_transactions_per_platform_transaction_status">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price" class="<?= $Page->price->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_price" class="view_transactions_per_platform_price">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" class="<?= $Page->quantity->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_quantity" class="view_transactions_per_platform_quantity">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->quantity->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" class="<?= $Page->amount_paid->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_amount_paid" class="view_transactions_per_platform_amount_paid">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->transitmedia_fee->Visible) { // transitmedia_fee ?>
        <td data-name="transitmedia_fee" class="<?= $Page->transitmedia_fee->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_transitmedia_fee" class="view_transactions_per_platform_transitmedia_fee">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <td data-name="lasaa_fee" class="<?= $Page->lasaa_fee->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_lasaa_fee" class="view_transactions_per_platform_lasaa_fee">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <td data-name="operator_fee" class="<?= $Page->operator_fee->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_operator_fee" class="view_transactions_per_platform_operator_fee">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <td data-name="lamata_fee" class="<?= $Page->lamata_fee->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_lamata_fee" class="view_transactions_per_platform_lamata_fee">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->lamata_fee->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->total->Visible) { // total ?>
        <td data-name="total" class="<?= $Page->total->footerCellClass() ?>"><span id="elf_view_transactions_per_platform_total" class="view_transactions_per_platform_total">
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
    ew.addEventHandlers("view_transactions_per_platform");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

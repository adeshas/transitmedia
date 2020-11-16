<?php

namespace PHPMaker2021\test;

// Page object
$MainCampaignsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmain_campaignslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fmain_campaignslist = currentForm = new ew.Form("fmain_campaignslist", "list");
    fmain_campaignslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fmain_campaignslist");
});
var fmain_campaignslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fmain_campaignslistsrch = currentSearchForm = new ew.Form("fmain_campaignslistsrch");

    // Dynamic selection lists

    // Filters
    fmain_campaignslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fmain_campaignslistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "y_vendors") {
    if ($Page->MasterRecordExists) {
        include_once "views/YVendorsMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "main_users") {
    if ($Page->MasterRecordExists) {
        include_once "views/MainUsersMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "y_platforms") {
    if ($Page->MasterRecordExists) {
        include_once "views/YPlatformsMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fmain_campaignslistsrch" id="fmain_campaignslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fmain_campaignslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="main_campaigns">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> main_campaigns">
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
<form name="fmain_campaignslist" id="fmain_campaignslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_campaigns">
<?php if ($Page->getCurrentMasterTable() == "y_vendors" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="y_vendors">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->vendor_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "main_users" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_users">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->user_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "y_platforms" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="y_platforms">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->platform_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_main_campaigns" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_main_campaignslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_main_campaigns_id" class="main_campaigns_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_main_campaigns_name" class="main_campaigns_name"><?= $Page->renderSort($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <th data-name="inventory_id" class="<?= $Page->inventory_id->headerCellClass() ?>"><div id="elh_main_campaigns_inventory_id" class="main_campaigns_inventory_id"><?= $Page->renderSort($Page->inventory_id) ?></div></th>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <th data-name="platform_id" class="<?= $Page->platform_id->headerCellClass() ?>"><div id="elh_main_campaigns_platform_id" class="main_campaigns_platform_id"><?= $Page->renderSort($Page->platform_id) ?></div></th>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <th data-name="bus_size_id" class="<?= $Page->bus_size_id->headerCellClass() ?>"><div id="elh_main_campaigns_bus_size_id" class="main_campaigns_bus_size_id"><?= $Page->renderSort($Page->bus_size_id) ?></div></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Page->quantity->headerCellClass() ?>"><div id="elh_main_campaigns_quantity" class="main_campaigns_quantity"><?= $Page->renderSort($Page->quantity) ?></div></th>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <th data-name="start_date" class="<?= $Page->start_date->headerCellClass() ?>"><div id="elh_main_campaigns_start_date" class="main_campaigns_start_date"><?= $Page->renderSort($Page->start_date) ?></div></th>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <th data-name="end_date" class="<?= $Page->end_date->headerCellClass() ?>"><div id="elh_main_campaigns_end_date" class="main_campaigns_end_date"><?= $Page->renderSort($Page->end_date) ?></div></th>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <th data-name="vendor_id" class="<?= $Page->vendor_id->headerCellClass() ?>"><div id="elh_main_campaigns_vendor_id" class="main_campaigns_vendor_id"><?= $Page->renderSort($Page->vendor_id) ?></div></th>
<?php } ?>
<?php if ($Page->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <th data-name="renewal_stage_id" class="<?= $Page->renewal_stage_id->headerCellClass() ?>"><div id="elh_main_campaigns_renewal_stage_id" class="main_campaigns_renewal_stage_id"><?= $Page->renderSort($Page->renewal_stage_id) ?></div></th>
<?php } ?>
<?php if ($Page->check_status->Visible) { // check_status ?>
        <th data-name="check_status" class="<?= $Page->check_status->headerCellClass() ?>"><div id="elh_main_campaigns_check_status" class="main_campaigns_check_status"><?= $Page->renderSort($Page->check_status) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_main_campaigns", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_main_campaigns_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <td data-name="inventory_id" <?= $Page->inventory_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_inventory_id">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<?= $Page->inventory_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id" <?= $Page->platform_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <td data-name="bus_size_id" <?= $Page->bus_size_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_bus_size_id">
<span<?= $Page->bus_size_id->viewAttributes() ?>>
<?= $Page->bus_size_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" <?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->start_date->Visible) { // start_date ?>
        <td data-name="start_date" <?= $Page->start_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->end_date->Visible) { // end_date ?>
        <td data-name="end_date" <?= $Page->end_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" <?= $Page->vendor_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <td data-name="renewal_stage_id" <?= $Page->renewal_stage_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_renewal_stage_id">
<span<?= $Page->renewal_stage_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->renewal_stage_id->getViewValue()) && $Page->renewal_stage_id->linkAttributes() != "") { ?>
<a<?= $Page->renewal_stage_id->linkAttributes() ?>><?= $Page->renewal_stage_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->renewal_stage_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->check_status->Visible) { // check_status ?>
        <td data-name="check_status" <?= $Page->check_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_campaigns_check_status">
<span<?= $Page->check_status->viewAttributes() ?>>
<?php if (!EmptyString($Page->check_status->getViewValue()) && $Page->check_status->linkAttributes() != "") { ?>
<a<?= $Page->check_status->linkAttributes() ?>><?= $Page->check_status->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->check_status->getViewValue() ?>
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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" class="<?= $Page->id->footerCellClass() ?>"><span id="elf_main_campaigns_id" class="main_campaigns_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name" class="<?= $Page->name->footerCellClass() ?>"><span id="elf_main_campaigns_name" class="main_campaigns_name">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <td data-name="inventory_id" class="<?= $Page->inventory_id->footerCellClass() ?>"><span id="elf_main_campaigns_inventory_id" class="main_campaigns_inventory_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id" class="<?= $Page->platform_id->footerCellClass() ?>"><span id="elf_main_campaigns_platform_id" class="main_campaigns_platform_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <td data-name="bus_size_id" class="<?= $Page->bus_size_id->footerCellClass() ?>"><span id="elf_main_campaigns_bus_size_id" class="main_campaigns_bus_size_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity" class="<?= $Page->quantity->footerCellClass() ?>"><span id="elf_main_campaigns_quantity" class="main_campaigns_quantity">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->quantity->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->start_date->Visible) { // start_date ?>
        <td data-name="start_date" class="<?= $Page->start_date->footerCellClass() ?>"><span id="elf_main_campaigns_start_date" class="main_campaigns_start_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->end_date->Visible) { // end_date ?>
        <td data-name="end_date" class="<?= $Page->end_date->footerCellClass() ?>"><span id="elf_main_campaigns_end_date" class="main_campaigns_end_date">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" class="<?= $Page->vendor_id->footerCellClass() ?>"><span id="elf_main_campaigns_vendor_id" class="main_campaigns_vendor_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <td data-name="renewal_stage_id" class="<?= $Page->renewal_stage_id->footerCellClass() ?>"><span id="elf_main_campaigns_renewal_stage_id" class="main_campaigns_renewal_stage_id">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->check_status->Visible) { // check_status ?>
        <td data-name="check_status" class="<?= $Page->check_status->footerCellClass() ?>"><span id="elf_main_campaigns_check_status" class="main_campaigns_check_status">
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
    ew.addEventHandlers("main_campaigns");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

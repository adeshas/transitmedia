<?php

namespace PHPMaker2021\test;

// Page object
$ViewAllBusesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fview_all_buseslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fview_all_buseslist = currentForm = new ew.Form("fview_all_buseslist", "list");
    fview_all_buseslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fview_all_buseslist");
});
var fview_all_buseslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fview_all_buseslistsrch = currentSearchForm = new ew.Form("fview_all_buseslistsrch");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "view_all_buses")) ?>,
        fields = currentTable.fields;
    fview_all_buseslistsrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["number", [], fields.number.isInvalid],
        ["platform", [], fields.platform.isInvalid],
        ["operator", [], fields.operator.isInvalid],
        ["exterior_campaign", [], fields.exterior_campaign.isInvalid],
        ["exterior_campaign_vendor", [], fields.exterior_campaign_vendor.isInvalid],
        ["interior_campaign", [], fields.interior_campaign.isInvalid],
        ["interior_campaign_vendor", [], fields.interior_campaign_vendor.isInvalid],
        ["bus_status", [], fields.bus_status.isInvalid],
        ["bus_size", [], fields.bus_size.isInvalid],
        ["bus_depot", [], fields.bus_depot.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fview_all_buseslistsrch.setInvalid();
    });

    // Validate form
    fview_all_buseslistsrch.validate = function () {
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
    fview_all_buseslistsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fview_all_buseslistsrch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists

    // Filters
    fview_all_buseslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_all_buseslistsrch");
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
<form name="fview_all_buseslistsrch" id="fview_all_buseslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fview_all_buseslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_all_buses">
    <div class="ew-extended-search">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->number->Visible) { // number ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_number" class="ew-cell form-group">
        <label for="x_number" class="ew-search-caption ew-label"><?= $Page->number->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_number" id="z_number" value="LIKE">
</span>
        <span id="el_view_all_buses_number" class="ew-search-field">
<input type="<?= $Page->number->getInputTextType() ?>" data-table="view_all_buses" data-field="x_number" name="x_number" id="x_number" size="30" placeholder="<?= HtmlEncode($Page->number->getPlaceHolder()) ?>" value="<?= $Page->number->EditValue ?>"<?= $Page->number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->number->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->platform->Visible) { // platform ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_platform" class="ew-cell form-group">
        <label for="x_platform" class="ew-search-caption ew-label"><?= $Page->platform->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_platform" id="z_platform" value="LIKE">
</span>
        <span id="el_view_all_buses_platform" class="ew-search-field">
<input type="<?= $Page->platform->getInputTextType() ?>" data-table="view_all_buses" data-field="x_platform" name="x_platform" id="x_platform" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->platform->getPlaceHolder()) ?>" value="<?= $Page->platform->EditValue ?>"<?= $Page->platform->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->platform->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->operator->Visible) { // operator ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_operator" class="ew-cell form-group">
        <label for="x_operator" class="ew-search-caption ew-label"><?= $Page->operator->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_operator" id="z_operator" value="LIKE">
</span>
        <span id="el_view_all_buses_operator" class="ew-search-field">
<input type="<?= $Page->operator->getInputTextType() ?>" data-table="view_all_buses" data-field="x_operator" name="x_operator" id="x_operator" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->operator->getPlaceHolder()) ?>" value="<?= $Page->operator->EditValue ?>"<?= $Page->operator->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->operator->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->exterior_campaign->Visible) { // exterior_campaign ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_exterior_campaign" class="ew-cell form-group">
        <label for="x_exterior_campaign" class="ew-search-caption ew-label"><?= $Page->exterior_campaign->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_exterior_campaign" id="z_exterior_campaign" value="LIKE">
</span>
        <span id="el_view_all_buses_exterior_campaign" class="ew-search-field">
<input type="<?= $Page->exterior_campaign->getInputTextType() ?>" data-table="view_all_buses" data-field="x_exterior_campaign" name="x_exterior_campaign" id="x_exterior_campaign" size="35" placeholder="<?= HtmlEncode($Page->exterior_campaign->getPlaceHolder()) ?>" value="<?= $Page->exterior_campaign->EditValue ?>"<?= $Page->exterior_campaign->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->exterior_campaign->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->exterior_campaign_vendor->Visible) { // exterior_campaign_vendor ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_exterior_campaign_vendor" class="ew-cell form-group">
        <label for="x_exterior_campaign_vendor" class="ew-search-caption ew-label"><?= $Page->exterior_campaign_vendor->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_exterior_campaign_vendor" id="z_exterior_campaign_vendor" value="LIKE">
</span>
        <span id="el_view_all_buses_exterior_campaign_vendor" class="ew-search-field">
<input type="<?= $Page->exterior_campaign_vendor->getInputTextType() ?>" data-table="view_all_buses" data-field="x_exterior_campaign_vendor" name="x_exterior_campaign_vendor" id="x_exterior_campaign_vendor" size="30" placeholder="<?= HtmlEncode($Page->exterior_campaign_vendor->getPlaceHolder()) ?>" value="<?= $Page->exterior_campaign_vendor->EditValue ?>"<?= $Page->exterior_campaign_vendor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->exterior_campaign_vendor->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->interior_campaign->Visible) { // interior_campaign ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_interior_campaign" class="ew-cell form-group">
        <label for="x_interior_campaign" class="ew-search-caption ew-label"><?= $Page->interior_campaign->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_interior_campaign" id="z_interior_campaign" value="LIKE">
</span>
        <span id="el_view_all_buses_interior_campaign" class="ew-search-field">
<input type="<?= $Page->interior_campaign->getInputTextType() ?>" data-table="view_all_buses" data-field="x_interior_campaign" name="x_interior_campaign" id="x_interior_campaign" size="35" placeholder="<?= HtmlEncode($Page->interior_campaign->getPlaceHolder()) ?>" value="<?= $Page->interior_campaign->EditValue ?>"<?= $Page->interior_campaign->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->interior_campaign->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->interior_campaign_vendor->Visible) { // interior_campaign_vendor ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_interior_campaign_vendor" class="ew-cell form-group">
        <label for="x_interior_campaign_vendor" class="ew-search-caption ew-label"><?= $Page->interior_campaign_vendor->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_interior_campaign_vendor" id="z_interior_campaign_vendor" value="LIKE">
</span>
        <span id="el_view_all_buses_interior_campaign_vendor" class="ew-search-field">
<input type="<?= $Page->interior_campaign_vendor->getInputTextType() ?>" data-table="view_all_buses" data-field="x_interior_campaign_vendor" name="x_interior_campaign_vendor" id="x_interior_campaign_vendor" size="30" placeholder="<?= HtmlEncode($Page->interior_campaign_vendor->getPlaceHolder()) ?>" value="<?= $Page->interior_campaign_vendor->EditValue ?>"<?= $Page->interior_campaign_vendor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->interior_campaign_vendor->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->bus_status->Visible) { // bus_status ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_bus_status" class="ew-cell form-group">
        <label for="x_bus_status" class="ew-search-caption ew-label"><?= $Page->bus_status->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_bus_status" id="z_bus_status" value="LIKE">
</span>
        <span id="el_view_all_buses_bus_status" class="ew-search-field">
<input type="<?= $Page->bus_status->getInputTextType() ?>" data-table="view_all_buses" data-field="x_bus_status" name="x_bus_status" id="x_bus_status" size="30" placeholder="<?= HtmlEncode($Page->bus_status->getPlaceHolder()) ?>" value="<?= $Page->bus_status->EditValue ?>"<?= $Page->bus_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bus_status->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->bus_size->Visible) { // bus_size ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_bus_size" class="ew-cell form-group">
        <label for="x_bus_size" class="ew-search-caption ew-label"><?= $Page->bus_size->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_bus_size" id="z_bus_size" value="LIKE">
</span>
        <span id="el_view_all_buses_bus_size" class="ew-search-field">
<input type="<?= $Page->bus_size->getInputTextType() ?>" data-table="view_all_buses" data-field="x_bus_size" name="x_bus_size" id="x_bus_size" size="35" placeholder="<?= HtmlEncode($Page->bus_size->getPlaceHolder()) ?>" value="<?= $Page->bus_size->EditValue ?>"<?= $Page->bus_size->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bus_size->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->bus_depot->Visible) { // bus_depot ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_bus_depot" class="ew-cell form-group">
        <label for="x_bus_depot" class="ew-search-caption ew-label"><?= $Page->bus_depot->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_bus_depot" id="z_bus_depot" value="LIKE">
</span>
        <span id="el_view_all_buses_bus_depot" class="ew-search-field">
<input type="<?= $Page->bus_depot->getInputTextType() ?>" data-table="view_all_buses" data-field="x_bus_depot" name="x_bus_depot" id="x_bus_depot" size="35" placeholder="<?= HtmlEncode($Page->bus_depot->getPlaceHolder()) ?>" value="<?= $Page->bus_depot->EditValue ?>"<?= $Page->bus_depot->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bus_depot->getErrorMessage(false) ?></div>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_all_buses">
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
<form name="fview_all_buseslist" id="fview_all_buseslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_all_buses">
<div id="gmp_view_all_buses" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_all_buseslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_view_all_buses_id" class="view_all_buses_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->number->Visible) { // number ?>
        <th data-name="number" class="<?= $Page->number->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_number" class="view_all_buses_number"><?= $Page->renderSort($Page->number) ?></div></th>
<?php } ?>
<?php if ($Page->platform->Visible) { // platform ?>
        <th data-name="platform" class="<?= $Page->platform->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_platform" class="view_all_buses_platform"><?= $Page->renderSort($Page->platform) ?></div></th>
<?php } ?>
<?php if ($Page->operator->Visible) { // operator ?>
        <th data-name="operator" class="<?= $Page->operator->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_operator" class="view_all_buses_operator"><?= $Page->renderSort($Page->operator) ?></div></th>
<?php } ?>
<?php if ($Page->exterior_campaign->Visible) { // exterior_campaign ?>
        <th data-name="exterior_campaign" class="<?= $Page->exterior_campaign->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_exterior_campaign" class="view_all_buses_exterior_campaign"><?= $Page->renderSort($Page->exterior_campaign) ?></div></th>
<?php } ?>
<?php if ($Page->exterior_campaign_vendor->Visible) { // exterior_campaign_vendor ?>
        <th data-name="exterior_campaign_vendor" class="<?= $Page->exterior_campaign_vendor->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_exterior_campaign_vendor" class="view_all_buses_exterior_campaign_vendor"><?= $Page->renderSort($Page->exterior_campaign_vendor) ?></div></th>
<?php } ?>
<?php if ($Page->interior_campaign->Visible) { // interior_campaign ?>
        <th data-name="interior_campaign" class="<?= $Page->interior_campaign->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_interior_campaign" class="view_all_buses_interior_campaign"><?= $Page->renderSort($Page->interior_campaign) ?></div></th>
<?php } ?>
<?php if ($Page->interior_campaign_vendor->Visible) { // interior_campaign_vendor ?>
        <th data-name="interior_campaign_vendor" class="<?= $Page->interior_campaign_vendor->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_interior_campaign_vendor" class="view_all_buses_interior_campaign_vendor"><?= $Page->renderSort($Page->interior_campaign_vendor) ?></div></th>
<?php } ?>
<?php if ($Page->bus_status->Visible) { // bus_status ?>
        <th data-name="bus_status" class="<?= $Page->bus_status->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_bus_status" class="view_all_buses_bus_status"><?= $Page->renderSort($Page->bus_status) ?></div></th>
<?php } ?>
<?php if ($Page->bus_size->Visible) { // bus_size ?>
        <th data-name="bus_size" class="<?= $Page->bus_size->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_bus_size" class="view_all_buses_bus_size"><?= $Page->renderSort($Page->bus_size) ?></div></th>
<?php } ?>
<?php if ($Page->bus_depot->Visible) { // bus_depot ?>
        <th data-name="bus_depot" class="<?= $Page->bus_depot->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_all_buses_bus_depot" class="view_all_buses_bus_depot"><?= $Page->renderSort($Page->bus_depot) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_view_all_buses", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_view_all_buses_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->number->Visible) { // number ?>
        <td data-name="number" <?= $Page->number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_number">
<span<?= $Page->number->viewAttributes() ?>>
<?= $Page->number->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->platform->Visible) { // platform ?>
        <td data-name="platform" <?= $Page->platform->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_platform">
<span<?= $Page->platform->viewAttributes() ?>>
<?= $Page->platform->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->operator->Visible) { // operator ?>
        <td data-name="operator" <?= $Page->operator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_operator">
<span<?= $Page->operator->viewAttributes() ?>>
<?= $Page->operator->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->exterior_campaign->Visible) { // exterior_campaign ?>
        <td data-name="exterior_campaign" <?= $Page->exterior_campaign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_exterior_campaign">
<span<?= $Page->exterior_campaign->viewAttributes() ?>>
<?= $Page->exterior_campaign->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->exterior_campaign_vendor->Visible) { // exterior_campaign_vendor ?>
        <td data-name="exterior_campaign_vendor" <?= $Page->exterior_campaign_vendor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_exterior_campaign_vendor">
<span<?= $Page->exterior_campaign_vendor->viewAttributes() ?>>
<?= $Page->exterior_campaign_vendor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->interior_campaign->Visible) { // interior_campaign ?>
        <td data-name="interior_campaign" <?= $Page->interior_campaign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_interior_campaign">
<span<?= $Page->interior_campaign->viewAttributes() ?>>
<?= $Page->interior_campaign->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->interior_campaign_vendor->Visible) { // interior_campaign_vendor ?>
        <td data-name="interior_campaign_vendor" <?= $Page->interior_campaign_vendor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_interior_campaign_vendor">
<span<?= $Page->interior_campaign_vendor->viewAttributes() ?>>
<?= $Page->interior_campaign_vendor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_status->Visible) { // bus_status ?>
        <td data-name="bus_status" <?= $Page->bus_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_bus_status">
<span<?= $Page->bus_status->viewAttributes() ?>>
<?= $Page->bus_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_size->Visible) { // bus_size ?>
        <td data-name="bus_size" <?= $Page->bus_size->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_bus_size">
<span<?= $Page->bus_size->viewAttributes() ?>>
<?= $Page->bus_size->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bus_depot->Visible) { // bus_depot ?>
        <td data-name="bus_depot" <?= $Page->bus_depot->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_all_buses_bus_depot">
<span<?= $Page->bus_depot->viewAttributes() ?>>
<?= $Page->bus_depot->getViewValue() ?></span>
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
        <td data-name="id" class="<?= $Page->id->footerCellClass() ?>"><span id="elf_view_all_buses_id" class="view_all_buses_id">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->id->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->number->Visible) { // number ?>
        <td data-name="number" class="<?= $Page->number->footerCellClass() ?>"><span id="elf_view_all_buses_number" class="view_all_buses_number">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->platform->Visible) { // platform ?>
        <td data-name="platform" class="<?= $Page->platform->footerCellClass() ?>"><span id="elf_view_all_buses_platform" class="view_all_buses_platform">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->operator->Visible) { // operator ?>
        <td data-name="operator" class="<?= $Page->operator->footerCellClass() ?>"><span id="elf_view_all_buses_operator" class="view_all_buses_operator">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->exterior_campaign->Visible) { // exterior_campaign ?>
        <td data-name="exterior_campaign" class="<?= $Page->exterior_campaign->footerCellClass() ?>"><span id="elf_view_all_buses_exterior_campaign" class="view_all_buses_exterior_campaign">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->exterior_campaign_vendor->Visible) { // exterior_campaign_vendor ?>
        <td data-name="exterior_campaign_vendor" class="<?= $Page->exterior_campaign_vendor->footerCellClass() ?>"><span id="elf_view_all_buses_exterior_campaign_vendor" class="view_all_buses_exterior_campaign_vendor">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->interior_campaign->Visible) { // interior_campaign ?>
        <td data-name="interior_campaign" class="<?= $Page->interior_campaign->footerCellClass() ?>"><span id="elf_view_all_buses_interior_campaign" class="view_all_buses_interior_campaign">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->interior_campaign_vendor->Visible) { // interior_campaign_vendor ?>
        <td data-name="interior_campaign_vendor" class="<?= $Page->interior_campaign_vendor->footerCellClass() ?>"><span id="elf_view_all_buses_interior_campaign_vendor" class="view_all_buses_interior_campaign_vendor">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->bus_status->Visible) { // bus_status ?>
        <td data-name="bus_status" class="<?= $Page->bus_status->footerCellClass() ?>"><span id="elf_view_all_buses_bus_status" class="view_all_buses_bus_status">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->bus_size->Visible) { // bus_size ?>
        <td data-name="bus_size" class="<?= $Page->bus_size->footerCellClass() ?>"><span id="elf_view_all_buses_bus_size" class="view_all_buses_bus_size">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->bus_depot->Visible) { // bus_depot ?>
        <td data-name="bus_depot" class="<?= $Page->bus_depot->footerCellClass() ?>"><span id="elf_view_all_buses_bus_depot" class="view_all_buses_bus_depot">
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
    ew.addEventHandlers("view_all_buses");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

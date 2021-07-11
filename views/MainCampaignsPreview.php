<?php

namespace PHPMaker2021\test;

// Page object
$MainCampaignsPreview = &$Page;
?>
<script>
if (!ew.vars.tables.main_campaigns) ew.vars.tables.main_campaigns = <?= JsonEncode(GetClientVar("tables", "main_campaigns")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid main_campaigns"><!-- .card -->
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table ew-table ew-preview-table"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
    <?php if ($Page->SortUrl($Page->id) == "") { ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><?= $Page->id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <?php if ($Page->SortUrl($Page->name) == "") { ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><?= $Page->name->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->name->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->name->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->name->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->name->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
    <?php if ($Page->SortUrl($Page->inventory_id) == "") { ?>
        <th class="<?= $Page->inventory_id->headerCellClass() ?>"><?= $Page->inventory_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->inventory_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->inventory_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->inventory_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->inventory_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->inventory_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
    <?php if ($Page->SortUrl($Page->platform_id) == "") { ?>
        <th class="<?= $Page->platform_id->headerCellClass() ?>"><?= $Page->platform_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->platform_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->platform_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->platform_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->platform_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->platform_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
    <?php if ($Page->SortUrl($Page->bus_size_id) == "") { ?>
        <th class="<?= $Page->bus_size_id->headerCellClass() ?>"><?= $Page->bus_size_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bus_size_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bus_size_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->bus_size_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bus_size_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->bus_size_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <?php if ($Page->SortUrl($Page->quantity) == "") { ?>
        <th class="<?= $Page->quantity->headerCellClass() ?>"><?= $Page->quantity->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->quantity->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->quantity->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->quantity->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->quantity->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->quantity->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
    <?php if ($Page->SortUrl($Page->start_date) == "") { ?>
        <th class="<?= $Page->start_date->headerCellClass() ?>"><?= $Page->start_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->start_date->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->start_date->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->start_date->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->start_date->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->start_date->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
    <?php if ($Page->SortUrl($Page->end_date) == "") { ?>
        <th class="<?= $Page->end_date->headerCellClass() ?>"><?= $Page->end_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->end_date->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->end_date->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->end_date->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->end_date->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->end_date->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
    <?php if ($Page->SortUrl($Page->vendor_id) == "") { ?>
        <th class="<?= $Page->vendor_id->headerCellClass() ?>"><?= $Page->vendor_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->vendor_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->vendor_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->vendor_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->vendor_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->vendor_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->renewal_stage_id->Visible) { // renewal_stage_id ?>
    <?php if ($Page->SortUrl($Page->renewal_stage_id) == "") { ?>
        <th class="<?= $Page->renewal_stage_id->headerCellClass() ?>"><?= $Page->renewal_stage_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->renewal_stage_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->renewal_stage_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->renewal_stage_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->renewal_stage_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->renewal_stage_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->check_status->Visible) { // check_status ?>
    <?php if ($Page->SortUrl($Page->check_status) == "") { ?>
        <th class="<?= $Page->check_status->headerCellClass() ?>"><?= $Page->check_status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->check_status->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->check_status->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->check_status->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->check_status->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->check_status->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);
    $Page->aggregateListRowValues(); // Aggregate row values

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->id->Visible) { // id ?>
        <!-- id -->
        <td<?= $Page->id->cellAttributes() ?>>
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <!-- name -->
        <td<?= $Page->name->cellAttributes() ?>>
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <!-- inventory_id -->
        <td<?= $Page->inventory_id->cellAttributes() ?>>
<span<?= $Page->inventory_id->viewAttributes() ?>>
<?= $Page->inventory_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <!-- platform_id -->
        <td<?= $Page->platform_id->cellAttributes() ?>>
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <!-- bus_size_id -->
        <td<?= $Page->bus_size_id->cellAttributes() ?>>
<span<?= $Page->bus_size_id->viewAttributes() ?>>
<?= $Page->bus_size_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <!-- quantity -->
        <td<?= $Page->quantity->cellAttributes() ?>>
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <!-- start_date -->
        <td<?= $Page->start_date->cellAttributes() ?>>
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <!-- end_date -->
        <td<?= $Page->end_date->cellAttributes() ?>>
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <!-- vendor_id -->
        <td<?= $Page->vendor_id->cellAttributes() ?>>
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <!-- renewal_stage_id -->
        <td<?= $Page->renewal_stage_id->cellAttributes() ?>>
<span<?= $Page->renewal_stage_id->viewAttributes() ?>>
<?php if (!EmptyString($Page->renewal_stage_id->getViewValue()) && $Page->renewal_stage_id->linkAttributes() != "") { ?>
<a<?= $Page->renewal_stage_id->linkAttributes() ?>><?= $Page->renewal_stage_id->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->renewal_stage_id->getViewValue() ?>
<?php } ?>
</span>
</td>
<?php } ?>
<?php if ($Page->check_status->Visible) { // check_status ?>
        <!-- check_status -->
        <td<?= $Page->check_status->cellAttributes() ?>>
<span<?= $Page->check_status->viewAttributes() ?>>
<?php if (!EmptyString($Page->check_status->getViewValue()) && $Page->check_status->linkAttributes() != "") { ?>
<a<?= $Page->check_status->linkAttributes() ?>><?= $Page->check_status->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->check_status->getViewValue() ?>
<?php } ?>
</span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
<?php
    // Render aggregate row
    $Page->RowType = ROWTYPE_AGGREGATE; // Aggregate
    $Page->aggregateListRow(); // Prepare aggregate row

    // Render list options
    $Page->renderListOptions();
?>
    <tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options (footer, left)
$Page->ListOptions->render("footer", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <!-- id -->
        <td class="<?= $Page->id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <!-- name -->
        <td class="<?= $Page->name->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <!-- inventory_id -->
        <td class="<?= $Page->inventory_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <!-- platform_id -->
        <td class="<?= $Page->platform_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <!-- bus_size_id -->
        <td class="<?= $Page->bus_size_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <!-- quantity -->
        <td class="<?= $Page->quantity->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->quantity->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <!-- start_date -->
        <td class="<?= $Page->start_date->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <!-- end_date -->
        <td class="<?= $Page->end_date->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <!-- vendor_id -->
        <td class="<?= $Page->vendor_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <!-- renewal_stage_id -->
        <td class="<?= $Page->renewal_stage_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->check_status->Visible) { // check_status ?>
        <!-- check_status -->
        <td class="<?= $Page->check_status->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php
// Render list options (footer, right)
$Page->ListOptions->render("footer", "right");
?>
    </tr>
    </tfoot>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="clearfix"></div>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>

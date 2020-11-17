<?php

namespace PHPMaker2021\test;

// Page object
$MainBusesPreview = &$Page;
?>
<script>
if (!ew.vars.tables.main_buses) ew.vars.tables.main_buses = <?= JsonEncode(GetClientVar("tables", "main_buses")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid main_buses"><!-- .card -->
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
<?php if ($Page->number->Visible) { // number ?>
    <?php if ($Page->SortUrl($Page->number) == "") { ?>
        <th class="<?= $Page->number->headerCellClass() ?>"><?= $Page->number->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->number->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->number->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->number->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->number->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->number->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->operator_id->Visible) { // operator_id ?>
    <?php if ($Page->SortUrl($Page->operator_id) == "") { ?>
        <th class="<?= $Page->operator_id->headerCellClass() ?>"><?= $Page->operator_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->operator_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->operator_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->operator_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->operator_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->operator_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
    <?php if ($Page->SortUrl($Page->exterior_campaign_id) == "") { ?>
        <th class="<?= $Page->exterior_campaign_id->headerCellClass() ?>"><?= $Page->exterior_campaign_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->exterior_campaign_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->exterior_campaign_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->exterior_campaign_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->exterior_campaign_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->exterior_campaign_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
    <?php if ($Page->SortUrl($Page->interior_campaign_id) == "") { ?>
        <th class="<?= $Page->interior_campaign_id->headerCellClass() ?>"><?= $Page->interior_campaign_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->interior_campaign_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->interior_campaign_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->interior_campaign_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->interior_campaign_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->interior_campaign_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
    <?php if ($Page->SortUrl($Page->bus_status_id) == "") { ?>
        <th class="<?= $Page->bus_status_id->headerCellClass() ?>"><?= $Page->bus_status_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bus_status_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bus_status_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->bus_status_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bus_status_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->bus_status_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bus_depot_id->Visible) { // bus_depot_id ?>
    <?php if ($Page->SortUrl($Page->bus_depot_id) == "") { ?>
        <th class="<?= $Page->bus_depot_id->headerCellClass() ?>"><?= $Page->bus_depot_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bus_depot_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bus_depot_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->bus_depot_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bus_depot_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->bus_depot_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->number->Visible) { // number ?>
        <!-- number -->
        <td<?= $Page->number->cellAttributes() ?>>
<span<?= $Page->number->viewAttributes() ?>>
<?= $Page->number->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <!-- platform_id -->
        <td<?= $Page->platform_id->cellAttributes() ?>>
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <!-- operator_id -->
        <td<?= $Page->operator_id->cellAttributes() ?>>
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <!-- exterior_campaign_id -->
        <td<?= $Page->exterior_campaign_id->cellAttributes() ?>>
<span<?= $Page->exterior_campaign_id->viewAttributes() ?>>
<?= $Page->exterior_campaign_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <!-- interior_campaign_id -->
        <td<?= $Page->interior_campaign_id->cellAttributes() ?>>
<span<?= $Page->interior_campaign_id->viewAttributes() ?>>
<?= $Page->interior_campaign_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bus_status_id->Visible) { // bus_status_id ?>
        <!-- bus_status_id -->
        <td<?= $Page->bus_status_id->cellAttributes() ?>>
<span<?= $Page->bus_status_id->viewAttributes() ?>>
<?= $Page->bus_status_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bus_depot_id->Visible) { // bus_depot_id ?>
        <!-- bus_depot_id -->
        <td<?= $Page->bus_depot_id->cellAttributes() ?>>
<span<?= $Page->bus_depot_id->viewAttributes() ?>>
<?= $Page->bus_depot_id->getViewValue() ?></span>
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

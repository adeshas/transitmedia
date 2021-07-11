<?php

namespace PHPMaker2021\test;

// Page object
$SubMediaAllocationPreview = &$Page;
?>
<script>
if (!ew.vars.tables.sub_media_allocation) ew.vars.tables.sub_media_allocation = <?= JsonEncode(GetClientVar("tables", "sub_media_allocation")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid sub_media_allocation"><!-- .card -->
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
<?php if ($Page->bus_id->Visible) { // bus_id ?>
    <?php if ($Page->SortUrl($Page->bus_id) == "") { ?>
        <th class="<?= $Page->bus_id->headerCellClass() ?>"><?= $Page->bus_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bus_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bus_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->bus_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bus_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->bus_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <?php if ($Page->SortUrl($Page->campaign_id) == "") { ?>
        <th class="<?= $Page->campaign_id->headerCellClass() ?>"><?= $Page->campaign_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->campaign_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->campaign_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->campaign_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->campaign_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->campaign_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <?php if ($Page->SortUrl($Page->active) == "") { ?>
        <th class="<?= $Page->active->headerCellClass() ?>"><?= $Page->active->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->active->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->active->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->active->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->active->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->active->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <?php if ($Page->SortUrl($Page->created_by) == "") { ?>
        <th class="<?= $Page->created_by->headerCellClass() ?>"><?= $Page->created_by->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->created_by->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->created_by->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->created_by->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->created_by->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->created_by->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <?php if ($Page->SortUrl($Page->ts_created) == "") { ?>
        <th class="<?= $Page->ts_created->headerCellClass() ?>"><?= $Page->ts_created->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ts_created->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ts_created->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->ts_created->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ts_created->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->ts_created->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
    <?php if ($Page->SortUrl($Page->ts_last_update) == "") { ?>
        <th class="<?= $Page->ts_last_update->headerCellClass() ?>"><?= $Page->ts_last_update->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ts_last_update->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ts_last_update->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->ts_last_update->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ts_last_update->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->ts_last_update->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->bus_id->Visible) { // bus_id ?>
        <!-- bus_id -->
        <td<?= $Page->bus_id->cellAttributes() ?>>
<span<?= $Page->bus_id->viewAttributes() ?>>
<?= $Page->bus_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <!-- campaign_id -->
        <td<?= $Page->campaign_id->cellAttributes() ?>>
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <!-- active -->
        <td<?= $Page->active->cellAttributes() ?>>
<span<?= $Page->active->viewAttributes() ?>>
<?= $Page->active->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <!-- created_by -->
        <td<?= $Page->created_by->cellAttributes() ?>>
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
        <!-- ts_created -->
        <td<?= $Page->ts_created->cellAttributes() ?>>
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
        <!-- ts_last_update -->
        <td<?= $Page->ts_last_update->cellAttributes() ?>>
<span<?= $Page->ts_last_update->viewAttributes() ?>>
<?= $Page->ts_last_update->getViewValue() ?></span>
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

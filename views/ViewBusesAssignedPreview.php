<?php

namespace PHPMaker2021\test;

// Page object
$ViewBusesAssignedPreview = &$Page;
?>
<script>
if (!ew.vars.tables.view_buses_assigned) ew.vars.tables.view_buses_assigned = <?= JsonEncode(GetClientVar("tables", "view_buses_assigned")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid view_buses_assigned"><!-- .card -->
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
<?php if ($Page->bus->Visible) { // bus ?>
    <?php if ($Page->SortUrl($Page->bus) == "") { ?>
        <th class="<?= $Page->bus->headerCellClass() ?>"><?= $Page->bus->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bus->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bus->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->bus->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bus->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->bus->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
    <?php if ($Page->SortUrl($Page->transaction_id) == "") { ?>
        <th class="<?= $Page->transaction_id->headerCellClass() ?>"><?= $Page->transaction_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->transaction_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->transaction_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->transaction_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->transaction_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->transaction_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->bus->Visible) { // bus ?>
        <!-- bus -->
        <td<?= $Page->bus->cellAttributes() ?>>
<span<?= $Page->bus->viewAttributes() ?>>
<?= $Page->bus->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->transaction_id->Visible) { // transaction_id ?>
        <!-- transaction_id -->
        <td<?= $Page->transaction_id->cellAttributes() ?>>
<span<?= $Page->transaction_id->viewAttributes() ?>>
<?= $Page->transaction_id->getViewValue() ?></span>
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

<?php

namespace PHPMaker2021\test;

// Page object
$MainUsersPreview = &$Page;
?>
<script>
if (!ew.vars.tables.main_users) ew.vars.tables.main_users = <?= JsonEncode(GetClientVar("tables", "main_users")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid main_users"><!-- .card -->
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
<?php if ($Page->_username->Visible) { // username ?>
    <?php if ($Page->SortUrl($Page->_username) == "") { ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><?= $Page->_username->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->_username->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->_username->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->_username->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->_username->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <?php if ($Page->SortUrl($Page->_password) == "") { ?>
        <th class="<?= $Page->_password->headerCellClass() ?>"><?= $Page->_password->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_password->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->_password->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->_password->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->_password->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->_password->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <?php if ($Page->SortUrl($Page->_email) == "") { ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><?= $Page->_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->_email->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->_email->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->_email->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->_email->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->user_type->Visible) { // user_type ?>
    <?php if ($Page->SortUrl($Page->user_type) == "") { ?>
        <th class="<?= $Page->user_type->headerCellClass() ?>"><?= $Page->user_type->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->user_type->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->user_type->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->user_type->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->user_type->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->user_type->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->reportsto->Visible) { // reportsto ?>
    <?php if ($Page->SortUrl($Page->reportsto) == "") { ?>
        <th class="<?= $Page->reportsto->headerCellClass() ?>"><?= $Page->reportsto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->reportsto->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->reportsto->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->reportsto->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->reportsto->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->reportsto->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->name->Visible) { // name ?>
        <!-- name -->
        <td<?= $Page->name->cellAttributes() ?>>
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <!-- username -->
        <td<?= $Page->_username->cellAttributes() ?>>
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <!-- password -->
        <td<?= $Page->_password->cellAttributes() ?>>
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <!-- email -->
        <td<?= $Page->_email->cellAttributes() ?>>
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->user_type->Visible) { // user_type ?>
        <!-- user_type -->
        <td<?= $Page->user_type->cellAttributes() ?>>
<span<?= $Page->user_type->viewAttributes() ?>>
<?= $Page->user_type->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <!-- vendor_id -->
        <td<?= $Page->vendor_id->cellAttributes() ?>>
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->reportsto->Visible) { // reportsto ?>
        <!-- reportsto -->
        <td<?= $Page->reportsto->cellAttributes() ?>>
<span<?= $Page->reportsto->viewAttributes() ?>>
<?= $Page->reportsto->getViewValue() ?></span>
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

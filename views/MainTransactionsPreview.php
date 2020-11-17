<?php

namespace PHPMaker2021\test;

// Page object
$MainTransactionsPreview = &$Page;
?>
<script>
if (!ew.vars.tables.main_transactions) ew.vars.tables.main_transactions = <?= JsonEncode(GetClientVar("tables", "main_transactions")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid main_transactions"><!-- .card -->
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
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <?php if ($Page->SortUrl($Page->campaign_id) == "") { ?>
        <th class="<?= $Page->campaign_id->headerCellClass() ?>"><?= $Page->campaign_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->campaign_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->campaign_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->campaign_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->campaign_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->campaign_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->payment_date->Visible) { // payment_date ?>
    <?php if ($Page->SortUrl($Page->payment_date) == "") { ?>
        <th class="<?= $Page->payment_date->headerCellClass() ?>"><?= $Page->payment_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->payment_date->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->payment_date->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->payment_date->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->payment_date->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->payment_date->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
    <?php if ($Page->SortUrl($Page->price_id) == "") { ?>
        <th class="<?= $Page->price_id->headerCellClass() ?>"><?= $Page->price_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->price_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->price_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->price_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->price_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->price_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
    <?php if ($Page->SortUrl($Page->visible_status_id) == "") { ?>
        <th class="<?= $Page->visible_status_id->headerCellClass() ?>"><?= $Page->visible_status_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->visible_status_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->visible_status_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->visible_status_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->visible_status_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->visible_status_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
    <?php if ($Page->SortUrl($Page->status_id) == "") { ?>
        <th class="<?= $Page->status_id->headerCellClass() ?>"><?= $Page->status_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->status_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->status_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->status_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->status_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->print_status_id->Visible) { // print_status_id ?>
    <?php if ($Page->SortUrl($Page->print_status_id) == "") { ?>
        <th class="<?= $Page->print_status_id->headerCellClass() ?>"><?= $Page->print_status_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->print_status_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->print_status_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->print_status_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->print_status_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->print_status_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
    <?php if ($Page->SortUrl($Page->payment_status_id) == "") { ?>
        <th class="<?= $Page->payment_status_id->headerCellClass() ?>"><?= $Page->payment_status_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->payment_status_id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->payment_status_id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->payment_status_id->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->payment_status_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->payment_status_id->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <?php if ($Page->SortUrl($Page->total) == "") { ?>
        <th class="<?= $Page->total->headerCellClass() ?>"><?= $Page->total->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->total->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->total->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->SortField == $Page->total->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->total->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->total->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <!-- campaign_id -->
        <td<?= $Page->campaign_id->cellAttributes() ?>>
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <!-- operator_id -->
        <td<?= $Page->operator_id->cellAttributes() ?>>
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
        <!-- payment_date -->
        <td<?= $Page->payment_date->cellAttributes() ?>>
<span<?= $Page->payment_date->viewAttributes() ?>>
<?= $Page->payment_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
        <!-- price_id -->
        <td<?= $Page->price_id->cellAttributes() ?>>
<span<?= $Page->price_id->viewAttributes() ?>>
<?= $Page->price_id->getViewValue() ?></span>
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
<?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
        <!-- visible_status_id -->
        <td<?= $Page->visible_status_id->cellAttributes() ?>>
<span<?= $Page->visible_status_id->viewAttributes() ?>>
<?= $Page->visible_status_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <!-- status_id -->
        <td<?= $Page->status_id->cellAttributes() ?>>
<span<?= $Page->status_id->viewAttributes() ?>>
<?= $Page->status_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->print_status_id->Visible) { // print_status_id ?>
        <!-- print_status_id -->
        <td<?= $Page->print_status_id->cellAttributes() ?>>
<span<?= $Page->print_status_id->viewAttributes() ?>>
<?= $Page->print_status_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
        <!-- payment_status_id -->
        <td<?= $Page->payment_status_id->cellAttributes() ?>>
<span<?= $Page->payment_status_id->viewAttributes() ?>>
<?= $Page->payment_status_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <!-- total -->
        <td<?= $Page->total->cellAttributes() ?>>
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
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
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <!-- campaign_id -->
        <td class="<?= $Page->campaign_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
        <!-- operator_id -->
        <td class="<?= $Page->operator_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
        <!-- payment_date -->
        <td class="<?= $Page->payment_date->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
        <!-- price_id -->
        <td class="<?= $Page->price_id->footerCellClass() ?>">
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
<?php if ($Page->visible_status_id->Visible) { // visible_status_id ?>
        <!-- visible_status_id -->
        <td class="<?= $Page->visible_status_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <!-- status_id -->
        <td class="<?= $Page->status_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->print_status_id->Visible) { // print_status_id ?>
        <!-- print_status_id -->
        <td class="<?= $Page->print_status_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->payment_status_id->Visible) { // payment_status_id ?>
        <!-- payment_status_id -->
        <td class="<?= $Page->payment_status_id->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <!-- total -->
        <td class="<?= $Page->total->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->total->ViewValue ?></span>
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

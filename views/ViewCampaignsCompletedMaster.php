<?php

namespace PHPMaker2021\test;

// Table
$view_campaigns_completed = Container("view_campaigns_completed");
?>
<?php if ($view_campaigns_completed->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_view_campaigns_completedmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($view_campaigns_completed->payment_date->Visible) { // payment_date ?>
        <tr id="r_payment_date">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->payment_date->caption() ?></td>
            <td <?= $view_campaigns_completed->payment_date->cellAttributes() ?>>
<span id="el_view_campaigns_completed_payment_date">
<span<?= $view_campaigns_completed->payment_date->viewAttributes() ?>>
<?= $view_campaigns_completed->payment_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->start_date->Visible) { // start_date ?>
        <tr id="r_start_date">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->start_date->caption() ?></td>
            <td <?= $view_campaigns_completed->start_date->cellAttributes() ?>>
<span id="el_view_campaigns_completed_start_date">
<span<?= $view_campaigns_completed->start_date->viewAttributes() ?>>
<?= $view_campaigns_completed->start_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->end_date->Visible) { // end_date ?>
        <tr id="r_end_date">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->end_date->caption() ?></td>
            <td <?= $view_campaigns_completed->end_date->cellAttributes() ?>>
<span id="el_view_campaigns_completed_end_date">
<span<?= $view_campaigns_completed->end_date->viewAttributes() ?>>
<?= $view_campaigns_completed->end_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->inventory->Visible) { // inventory ?>
        <tr id="r_inventory">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->inventory->caption() ?></td>
            <td <?= $view_campaigns_completed->inventory->cellAttributes() ?>>
<span id="el_view_campaigns_completed_inventory">
<span<?= $view_campaigns_completed->inventory->viewAttributes() ?>>
<?php if (!EmptyString($view_campaigns_completed->inventory->TooltipValue) && $view_campaigns_completed->inventory->linkAttributes() != "") { ?>
<a<?= $view_campaigns_completed->inventory->linkAttributes() ?>><?= $view_campaigns_completed->inventory->getViewValue() ?></a>
<?php } else { ?>
<?= $view_campaigns_completed->inventory->getViewValue() ?>
<?php } ?>
<span id="tt_view_campaigns_completed_x_inventory" class="d-none">
<?= $view_campaigns_completed->inventory->TooltipValue ?>
</span></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->platform->Visible) { // platform ?>
        <tr id="r_platform">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->platform->caption() ?></td>
            <td <?= $view_campaigns_completed->platform->cellAttributes() ?>>
<span id="el_view_campaigns_completed_platform">
<span<?= $view_campaigns_completed->platform->viewAttributes() ?>>
<?= $view_campaigns_completed->platform->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->operator->Visible) { // operator ?>
        <tr id="r_operator">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->operator->caption() ?></td>
            <td <?= $view_campaigns_completed->operator->cellAttributes() ?>>
<span id="el_view_campaigns_completed_operator">
<span<?= $view_campaigns_completed->operator->viewAttributes() ?>>
<?= $view_campaigns_completed->operator->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->bus_size->Visible) { // bus_size ?>
        <tr id="r_bus_size">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->bus_size->caption() ?></td>
            <td <?= $view_campaigns_completed->bus_size->cellAttributes() ?>>
<span id="el_view_campaigns_completed_bus_size">
<span<?= $view_campaigns_completed->bus_size->viewAttributes() ?>>
<?= $view_campaigns_completed->bus_size->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->campaign->Visible) { // campaign ?>
        <tr id="r_campaign">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->campaign->caption() ?></td>
            <td <?= $view_campaigns_completed->campaign->cellAttributes() ?>>
<span id="el_view_campaigns_completed_campaign">
<span<?= $view_campaigns_completed->campaign->viewAttributes() ?>>
<?= $view_campaigns_completed->campaign->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->vendor->Visible) { // vendor ?>
        <tr id="r_vendor">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->vendor->caption() ?></td>
            <td <?= $view_campaigns_completed->vendor->cellAttributes() ?>>
<span id="el_view_campaigns_completed_vendor">
<span<?= $view_campaigns_completed->vendor->viewAttributes() ?>>
<?= $view_campaigns_completed->vendor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->quantity->Visible) { // quantity ?>
        <tr id="r_quantity">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->quantity->caption() ?></td>
            <td <?= $view_campaigns_completed->quantity->cellAttributes() ?>>
<span id="el_view_campaigns_completed_quantity">
<span<?= $view_campaigns_completed->quantity->viewAttributes() ?>>
<?= $view_campaigns_completed->quantity->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->operator_fee->Visible) { // operator_fee ?>
        <tr id="r_operator_fee">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->operator_fee->caption() ?></td>
            <td <?= $view_campaigns_completed->operator_fee->cellAttributes() ?>>
<span id="el_view_campaigns_completed_operator_fee">
<span<?= $view_campaigns_completed->operator_fee->viewAttributes() ?>>
<?= $view_campaigns_completed->operator_fee->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_completed->transaction_status->Visible) { // transaction_status ?>
        <tr id="r_transaction_status">
            <td class="<?= $view_campaigns_completed->TableLeftColumnClass ?>"><?= $view_campaigns_completed->transaction_status->caption() ?></td>
            <td <?= $view_campaigns_completed->transaction_status->cellAttributes() ?>>
<span id="el_view_campaigns_completed_transaction_status">
<span<?= $view_campaigns_completed->transaction_status->viewAttributes() ?>>
<?= $view_campaigns_completed->transaction_status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

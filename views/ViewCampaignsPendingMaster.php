<?php

namespace PHPMaker2021\test;

// Table
$view_campaigns_pending = Container("view_campaigns_pending");
?>
<?php if ($view_campaigns_pending->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_view_campaigns_pendingmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($view_campaigns_pending->transaction_id->Visible) { // transaction_id ?>
        <tr id="r_transaction_id">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->transaction_id->caption() ?></td>
            <td <?= $view_campaigns_pending->transaction_id->cellAttributes() ?>>
<span id="el_view_campaigns_pending_transaction_id">
<span<?= $view_campaigns_pending->transaction_id->viewAttributes() ?>>
<?= $view_campaigns_pending->transaction_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->campaign->Visible) { // campaign ?>
        <tr id="r_campaign">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->campaign->caption() ?></td>
            <td <?= $view_campaigns_pending->campaign->cellAttributes() ?>>
<span id="el_view_campaigns_pending_campaign">
<span<?= $view_campaigns_pending->campaign->viewAttributes() ?>>
<?= $view_campaigns_pending->campaign->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->transaction_status->Visible) { // transaction_status ?>
        <tr id="r_transaction_status">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->transaction_status->caption() ?></td>
            <td <?= $view_campaigns_pending->transaction_status->cellAttributes() ?>>
<span id="el_view_campaigns_pending_transaction_status">
<span<?= $view_campaigns_pending->transaction_status->viewAttributes() ?>>
<?= $view_campaigns_pending->transaction_status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->status_id->Visible) { // status_id ?>
        <tr id="r_status_id">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->status_id->caption() ?></td>
            <td <?= $view_campaigns_pending->status_id->cellAttributes() ?>>
<span id="el_view_campaigns_pending_status_id">
<span<?= $view_campaigns_pending->status_id->viewAttributes() ?>>
<?php if (!EmptyString($view_campaigns_pending->status_id->getViewValue()) && $view_campaigns_pending->status_id->linkAttributes() != "") { ?>
<a<?= $view_campaigns_pending->status_id->linkAttributes() ?>><?= $view_campaigns_pending->status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $view_campaigns_pending->status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->payment_date->Visible) { // payment_date ?>
        <tr id="r_payment_date">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->payment_date->caption() ?></td>
            <td <?= $view_campaigns_pending->payment_date->cellAttributes() ?>>
<span id="el_view_campaigns_pending_payment_date">
<span<?= $view_campaigns_pending->payment_date->viewAttributes() ?>>
<?= $view_campaigns_pending->payment_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->inventory->Visible) { // inventory ?>
        <tr id="r_inventory">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->inventory->caption() ?></td>
            <td <?= $view_campaigns_pending->inventory->cellAttributes() ?>>
<span id="el_view_campaigns_pending_inventory">
<span<?= $view_campaigns_pending->inventory->viewAttributes() ?>>
<?php if (!EmptyString($view_campaigns_pending->inventory->TooltipValue) && $view_campaigns_pending->inventory->linkAttributes() != "") { ?>
<a<?= $view_campaigns_pending->inventory->linkAttributes() ?>><?= $view_campaigns_pending->inventory->getViewValue() ?></a>
<?php } else { ?>
<?= $view_campaigns_pending->inventory->getViewValue() ?>
<?php } ?>
<span id="tt_view_campaigns_pending_x_inventory" class="d-none">
<?= $view_campaigns_pending->inventory->TooltipValue ?>
</span></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->bus_size->Visible) { // bus_size ?>
        <tr id="r_bus_size">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->bus_size->caption() ?></td>
            <td <?= $view_campaigns_pending->bus_size->cellAttributes() ?>>
<span id="el_view_campaigns_pending_bus_size">
<span<?= $view_campaigns_pending->bus_size->viewAttributes() ?>>
<?= $view_campaigns_pending->bus_size->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->vendor->Visible) { // vendor ?>
        <tr id="r_vendor">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->vendor->caption() ?></td>
            <td <?= $view_campaigns_pending->vendor->cellAttributes() ?>>
<span id="el_view_campaigns_pending_vendor">
<span<?= $view_campaigns_pending->vendor->viewAttributes() ?>>
<?= $view_campaigns_pending->vendor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->operator->Visible) { // operator ?>
        <tr id="r_operator">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->operator->caption() ?></td>
            <td <?= $view_campaigns_pending->operator->cellAttributes() ?>>
<span id="el_view_campaigns_pending_operator">
<span<?= $view_campaigns_pending->operator->viewAttributes() ?>>
<?= $view_campaigns_pending->operator->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->quantity->Visible) { // quantity ?>
        <tr id="r_quantity">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->quantity->caption() ?></td>
            <td <?= $view_campaigns_pending->quantity->cellAttributes() ?>>
<span id="el_view_campaigns_pending_quantity">
<span<?= $view_campaigns_pending->quantity->viewAttributes() ?>>
<?= $view_campaigns_pending->quantity->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->operator_fee->Visible) { // operator_fee ?>
        <tr id="r_operator_fee">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->operator_fee->caption() ?></td>
            <td <?= $view_campaigns_pending->operator_fee->cellAttributes() ?>>
<span id="el_view_campaigns_pending_operator_fee">
<span<?= $view_campaigns_pending->operator_fee->viewAttributes() ?>>
<?= $view_campaigns_pending->operator_fee->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_campaigns_pending->total->Visible) { // total ?>
        <tr id="r_total">
            <td class="<?= $view_campaigns_pending->TableLeftColumnClass ?>"><?= $view_campaigns_pending->total->caption() ?></td>
            <td <?= $view_campaigns_pending->total->cellAttributes() ?>>
<span id="el_view_campaigns_pending_total">
<span<?= $view_campaigns_pending->total->viewAttributes() ?>>
<?= $view_campaigns_pending->total->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

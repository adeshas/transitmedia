<?php

namespace PHPMaker2021\test;

// Table
$main_transactions = Container("main_transactions");
?>
<?php if ($main_transactions->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_main_transactionsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($main_transactions->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->id->caption() ?></td>
            <td <?= $main_transactions->id->cellAttributes() ?>>
<span id="el_main_transactions_id">
<span<?= $main_transactions->id->viewAttributes() ?>>
<?= $main_transactions->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->campaign_id->Visible) { // campaign_id ?>
        <tr id="r_campaign_id">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->campaign_id->caption() ?></td>
            <td <?= $main_transactions->campaign_id->cellAttributes() ?>>
<span id="el_main_transactions_campaign_id">
<span<?= $main_transactions->campaign_id->viewAttributes() ?>>
<?= $main_transactions->campaign_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->operator_id->Visible) { // operator_id ?>
        <tr id="r_operator_id">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->operator_id->caption() ?></td>
            <td <?= $main_transactions->operator_id->cellAttributes() ?>>
<span id="el_main_transactions_operator_id">
<span<?= $main_transactions->operator_id->viewAttributes() ?>>
<?= $main_transactions->operator_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->payment_date->Visible) { // payment_date ?>
        <tr id="r_payment_date">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->payment_date->caption() ?></td>
            <td <?= $main_transactions->payment_date->cellAttributes() ?>>
<span id="el_main_transactions_payment_date">
<span<?= $main_transactions->payment_date->viewAttributes() ?>>
<?= $main_transactions->payment_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->vendor_id->Visible) { // vendor_id ?>
        <tr id="r_vendor_id">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->vendor_id->caption() ?></td>
            <td <?= $main_transactions->vendor_id->cellAttributes() ?>>
<span id="el_main_transactions_vendor_id">
<span<?= $main_transactions->vendor_id->viewAttributes() ?>>
<?= $main_transactions->vendor_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->price_id->Visible) { // price_id ?>
        <tr id="r_price_id">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->price_id->caption() ?></td>
            <td <?= $main_transactions->price_id->cellAttributes() ?>>
<span id="el_main_transactions_price_id">
<span<?= $main_transactions->price_id->viewAttributes() ?>>
<?= $main_transactions->price_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->quantity->Visible) { // quantity ?>
        <tr id="r_quantity">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->quantity->caption() ?></td>
            <td <?= $main_transactions->quantity->cellAttributes() ?>>
<span id="el_main_transactions_quantity">
<span<?= $main_transactions->quantity->viewAttributes() ?>>
<?= $main_transactions->quantity->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->assigned_buses->Visible) { // assigned_buses ?>
        <tr id="r_assigned_buses">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->assigned_buses->caption() ?></td>
            <td <?= $main_transactions->assigned_buses->cellAttributes() ?>>
<span id="el_main_transactions_assigned_buses">
<span<?= $main_transactions->assigned_buses->viewAttributes() ?>>
<?= $main_transactions->assigned_buses->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->start_date->Visible) { // start_date ?>
        <tr id="r_start_date">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->start_date->caption() ?></td>
            <td <?= $main_transactions->start_date->cellAttributes() ?>>
<span id="el_main_transactions_start_date">
<span<?= $main_transactions->start_date->viewAttributes() ?>>
<?= $main_transactions->start_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->end_date->Visible) { // end_date ?>
        <tr id="r_end_date">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->end_date->caption() ?></td>
            <td <?= $main_transactions->end_date->cellAttributes() ?>>
<span id="el_main_transactions_end_date">
<span<?= $main_transactions->end_date->viewAttributes() ?>>
<?= $main_transactions->end_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->visible_status_id->Visible) { // visible_status_id ?>
        <tr id="r_visible_status_id">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->visible_status_id->caption() ?></td>
            <td <?= $main_transactions->visible_status_id->cellAttributes() ?>>
<span id="el_main_transactions_visible_status_id">
<span<?= $main_transactions->visible_status_id->viewAttributes() ?>>
<?php if (!EmptyString($main_transactions->visible_status_id->getViewValue()) && $main_transactions->visible_status_id->linkAttributes() != "") { ?>
<a<?= $main_transactions->visible_status_id->linkAttributes() ?>><?= $main_transactions->visible_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $main_transactions->visible_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->status_id->Visible) { // status_id ?>
        <tr id="r_status_id">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->status_id->caption() ?></td>
            <td <?= $main_transactions->status_id->cellAttributes() ?>>
<span id="el_main_transactions_status_id">
<span<?= $main_transactions->status_id->viewAttributes() ?>>
<?php if (!EmptyString($main_transactions->status_id->getViewValue()) && $main_transactions->status_id->linkAttributes() != "") { ?>
<a<?= $main_transactions->status_id->linkAttributes() ?>><?= $main_transactions->status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $main_transactions->status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->print_status_id->Visible) { // print_status_id ?>
        <tr id="r_print_status_id">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->print_status_id->caption() ?></td>
            <td <?= $main_transactions->print_status_id->cellAttributes() ?>>
<span id="el_main_transactions_print_status_id">
<span<?= $main_transactions->print_status_id->viewAttributes() ?>>
<?php if (!EmptyString($main_transactions->print_status_id->getViewValue()) && $main_transactions->print_status_id->linkAttributes() != "") { ?>
<a<?= $main_transactions->print_status_id->linkAttributes() ?>><?= $main_transactions->print_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $main_transactions->print_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->payment_status_id->Visible) { // payment_status_id ?>
        <tr id="r_payment_status_id">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->payment_status_id->caption() ?></td>
            <td <?= $main_transactions->payment_status_id->cellAttributes() ?>>
<span id="el_main_transactions_payment_status_id">
<span<?= $main_transactions->payment_status_id->viewAttributes() ?>>
<?php if (!EmptyString($main_transactions->payment_status_id->getViewValue()) && $main_transactions->payment_status_id->linkAttributes() != "") { ?>
<a<?= $main_transactions->payment_status_id->linkAttributes() ?>><?= $main_transactions->payment_status_id->getViewValue() ?></a>
<?php } else { ?>
<?= $main_transactions->payment_status_id->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_transactions->total->Visible) { // total ?>
        <tr id="r_total">
            <td class="<?= $main_transactions->TableLeftColumnClass ?>"><?= $main_transactions->total->caption() ?></td>
            <td <?= $main_transactions->total->cellAttributes() ?>>
<span id="el_main_transactions_total">
<span<?= $main_transactions->total->viewAttributes() ?>>
<?= $main_transactions->total->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

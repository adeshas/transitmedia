<?php

namespace PHPMaker2021\test;

// Table
$main_campaigns = Container("main_campaigns");
?>
<?php if ($main_campaigns->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_main_campaignsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($main_campaigns->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->id->caption() ?></td>
            <td <?= $main_campaigns->id->cellAttributes() ?>>
<span id="el_main_campaigns_id">
<span<?= $main_campaigns->id->viewAttributes() ?>>
<?= $main_campaigns->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->name->caption() ?></td>
            <td <?= $main_campaigns->name->cellAttributes() ?>>
<span id="el_main_campaigns_name">
<span<?= $main_campaigns->name->viewAttributes() ?>>
<?= $main_campaigns->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->inventory_id->Visible) { // inventory_id ?>
        <tr id="r_inventory_id">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->inventory_id->caption() ?></td>
            <td <?= $main_campaigns->inventory_id->cellAttributes() ?>>
<span id="el_main_campaigns_inventory_id">
<span<?= $main_campaigns->inventory_id->viewAttributes() ?>>
<?= $main_campaigns->inventory_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->platform_id->Visible) { // platform_id ?>
        <tr id="r_platform_id">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->platform_id->caption() ?></td>
            <td <?= $main_campaigns->platform_id->cellAttributes() ?>>
<span id="el_main_campaigns_platform_id">
<span<?= $main_campaigns->platform_id->viewAttributes() ?>>
<?= $main_campaigns->platform_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->bus_size_id->Visible) { // bus_size_id ?>
        <tr id="r_bus_size_id">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->bus_size_id->caption() ?></td>
            <td <?= $main_campaigns->bus_size_id->cellAttributes() ?>>
<span id="el_main_campaigns_bus_size_id">
<span<?= $main_campaigns->bus_size_id->viewAttributes() ?>>
<?= $main_campaigns->bus_size_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->quantity->Visible) { // quantity ?>
        <tr id="r_quantity">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->quantity->caption() ?></td>
            <td <?= $main_campaigns->quantity->cellAttributes() ?>>
<span id="el_main_campaigns_quantity">
<span<?= $main_campaigns->quantity->viewAttributes() ?>>
<?= $main_campaigns->quantity->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->start_date->Visible) { // start_date ?>
        <tr id="r_start_date">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->start_date->caption() ?></td>
            <td <?= $main_campaigns->start_date->cellAttributes() ?>>
<span id="el_main_campaigns_start_date">
<span<?= $main_campaigns->start_date->viewAttributes() ?>>
<?= $main_campaigns->start_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->end_date->Visible) { // end_date ?>
        <tr id="r_end_date">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->end_date->caption() ?></td>
            <td <?= $main_campaigns->end_date->cellAttributes() ?>>
<span id="el_main_campaigns_end_date">
<span<?= $main_campaigns->end_date->viewAttributes() ?>>
<?= $main_campaigns->end_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->vendor_id->Visible) { // vendor_id ?>
        <tr id="r_vendor_id">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->vendor_id->caption() ?></td>
            <td <?= $main_campaigns->vendor_id->cellAttributes() ?>>
<span id="el_main_campaigns_vendor_id">
<span<?= $main_campaigns->vendor_id->viewAttributes() ?>>
<?= $main_campaigns->vendor_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->status_id->Visible) { // status_id ?>
        <tr id="r_status_id">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->status_id->caption() ?></td>
            <td <?= $main_campaigns->status_id->cellAttributes() ?>>
<span id="el_main_campaigns_status_id">
<span<?= $main_campaigns->status_id->viewAttributes() ?>>
<?= $main_campaigns->status_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->print_status_id->Visible) { // print_status_id ?>
        <tr id="r_print_status_id">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->print_status_id->caption() ?></td>
            <td <?= $main_campaigns->print_status_id->cellAttributes() ?>>
<span id="el_main_campaigns_print_status_id">
<span<?= $main_campaigns->print_status_id->viewAttributes() ?>>
<?= $main_campaigns->print_status_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->payment_status_id->Visible) { // payment_status_id ?>
        <tr id="r_payment_status_id">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->payment_status_id->caption() ?></td>
            <td <?= $main_campaigns->payment_status_id->cellAttributes() ?>>
<span id="el_main_campaigns_payment_status_id">
<span<?= $main_campaigns->payment_status_id->viewAttributes() ?>>
<?= $main_campaigns->payment_status_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_campaigns->renewal_stage_id->Visible) { // renewal_stage_id ?>
        <tr id="r_renewal_stage_id">
            <td class="<?= $main_campaigns->TableLeftColumnClass ?>"><?= $main_campaigns->renewal_stage_id->caption() ?></td>
            <td <?= $main_campaigns->renewal_stage_id->cellAttributes() ?>>
<span id="el_main_campaigns_renewal_stage_id">
<span<?= $main_campaigns->renewal_stage_id->viewAttributes() ?>>
<?= $main_campaigns->renewal_stage_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

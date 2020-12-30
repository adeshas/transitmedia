<?php

namespace PHPMaker2021\test;

// Table
$main_buses = Container("main_buses");
?>
<?php if ($main_buses->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_main_busesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($main_buses->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->id->caption() ?></td>
            <td <?= $main_buses->id->cellAttributes() ?>>
<span id="el_main_buses_id">
<span<?= $main_buses->id->viewAttributes() ?>>
<?= $main_buses->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_buses->number->Visible) { // number ?>
        <tr id="r_number">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->number->caption() ?></td>
            <td <?= $main_buses->number->cellAttributes() ?>>
<span id="el_main_buses_number">
<span<?= $main_buses->number->viewAttributes() ?>>
<?= $main_buses->number->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_buses->platform_id->Visible) { // platform_id ?>
        <tr id="r_platform_id">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->platform_id->caption() ?></td>
            <td <?= $main_buses->platform_id->cellAttributes() ?>>
<span id="el_main_buses_platform_id">
<span<?= $main_buses->platform_id->viewAttributes() ?>>
<?= $main_buses->platform_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_buses->operator_id->Visible) { // operator_id ?>
        <tr id="r_operator_id">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->operator_id->caption() ?></td>
            <td <?= $main_buses->operator_id->cellAttributes() ?>>
<span id="el_main_buses_operator_id">
<span<?= $main_buses->operator_id->viewAttributes() ?>>
<?= $main_buses->operator_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_buses->exterior_campaign_id->Visible) { // exterior_campaign_id ?>
        <tr id="r_exterior_campaign_id">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->exterior_campaign_id->caption() ?></td>
            <td <?= $main_buses->exterior_campaign_id->cellAttributes() ?>>
<span id="el_main_buses_exterior_campaign_id">
<span<?= $main_buses->exterior_campaign_id->viewAttributes() ?>>
<?= $main_buses->exterior_campaign_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_buses->interior_campaign_id->Visible) { // interior_campaign_id ?>
        <tr id="r_interior_campaign_id">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->interior_campaign_id->caption() ?></td>
            <td <?= $main_buses->interior_campaign_id->cellAttributes() ?>>
<span id="el_main_buses_interior_campaign_id">
<span<?= $main_buses->interior_campaign_id->viewAttributes() ?>>
<?= $main_buses->interior_campaign_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_buses->bus_status_id->Visible) { // bus_status_id ?>
        <tr id="r_bus_status_id">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->bus_status_id->caption() ?></td>
            <td <?= $main_buses->bus_status_id->cellAttributes() ?>>
<span id="el_main_buses_bus_status_id">
<span<?= $main_buses->bus_status_id->viewAttributes() ?>>
<?= $main_buses->bus_status_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_buses->bus_size_id->Visible) { // bus_size_id ?>
        <tr id="r_bus_size_id">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->bus_size_id->caption() ?></td>
            <td <?= $main_buses->bus_size_id->cellAttributes() ?>>
<span id="el_main_buses_bus_size_id">
<span<?= $main_buses->bus_size_id->viewAttributes() ?>>
<?= $main_buses->bus_size_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_buses->bus_depot_id->Visible) { // bus_depot_id ?>
        <tr id="r_bus_depot_id">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->bus_depot_id->caption() ?></td>
            <td <?= $main_buses->bus_depot_id->cellAttributes() ?>>
<span id="el_main_buses_bus_depot_id">
<span<?= $main_buses->bus_depot_id->viewAttributes() ?>>
<?= $main_buses->bus_depot_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_buses->ts_last_update->Visible) { // ts_last_update ?>
        <tr id="r_ts_last_update">
            <td class="<?= $main_buses->TableLeftColumnClass ?>"><?= $main_buses->ts_last_update->caption() ?></td>
            <td <?= $main_buses->ts_last_update->cellAttributes() ?>>
<span id="el_main_buses_ts_last_update">
<span<?= $main_buses->ts_last_update->viewAttributes() ?>>
<?= $main_buses->ts_last_update->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

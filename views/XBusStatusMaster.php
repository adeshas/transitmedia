<?php

namespace PHPMaker2021\test;

// Table
$x_bus_status = Container("x_bus_status");
?>
<?php if ($x_bus_status->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_x_bus_statusmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($x_bus_status->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $x_bus_status->TableLeftColumnClass ?>"><?= $x_bus_status->id->caption() ?></td>
            <td <?= $x_bus_status->id->cellAttributes() ?>>
<span id="el_x_bus_status_id">
<span<?= $x_bus_status->id->viewAttributes() ?>>
<?= $x_bus_status->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($x_bus_status->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $x_bus_status->TableLeftColumnClass ?>"><?= $x_bus_status->name->caption() ?></td>
            <td <?= $x_bus_status->name->cellAttributes() ?>>
<span id="el_x_bus_status_name">
<span<?= $x_bus_status->name->viewAttributes() ?>>
<?= $x_bus_status->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($x_bus_status->availability->Visible) { // availability ?>
        <tr id="r_availability">
            <td class="<?= $x_bus_status->TableLeftColumnClass ?>"><?= $x_bus_status->availability->caption() ?></td>
            <td <?= $x_bus_status->availability->cellAttributes() ?>>
<span id="el_x_bus_status_availability">
<span<?= $x_bus_status->availability->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_availability_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $x_bus_status->availability->getViewValue() ?>" disabled<?php if (ConvertToBool($x_bus_status->availability->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_availability_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

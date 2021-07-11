<?php

namespace PHPMaker2021\test;

// Table
$x_bus_depot = Container("x_bus_depot");
?>
<?php if ($x_bus_depot->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_x_bus_depotmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($x_bus_depot->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $x_bus_depot->TableLeftColumnClass ?>"><?= $x_bus_depot->id->caption() ?></td>
            <td <?= $x_bus_depot->id->cellAttributes() ?>>
<span id="el_x_bus_depot_id">
<span<?= $x_bus_depot->id->viewAttributes() ?>>
<?= $x_bus_depot->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($x_bus_depot->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $x_bus_depot->TableLeftColumnClass ?>"><?= $x_bus_depot->name->caption() ?></td>
            <td <?= $x_bus_depot->name->cellAttributes() ?>>
<span id="el_x_bus_depot_name">
<span<?= $x_bus_depot->name->viewAttributes() ?>>
<?= $x_bus_depot->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

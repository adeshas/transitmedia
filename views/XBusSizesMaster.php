<?php

namespace PHPMaker2021\test;

// Table
$x_bus_sizes = Container("x_bus_sizes");
?>
<?php if ($x_bus_sizes->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_x_bus_sizesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($x_bus_sizes->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $x_bus_sizes->TableLeftColumnClass ?>"><?= $x_bus_sizes->id->caption() ?></td>
            <td <?= $x_bus_sizes->id->cellAttributes() ?>>
<span id="el_x_bus_sizes_id">
<span<?= $x_bus_sizes->id->viewAttributes() ?>>
<?= $x_bus_sizes->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($x_bus_sizes->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $x_bus_sizes->TableLeftColumnClass ?>"><?= $x_bus_sizes->name->caption() ?></td>
            <td <?= $x_bus_sizes->name->cellAttributes() ?>>
<span id="el_x_bus_sizes_name">
<span<?= $x_bus_sizes->name->viewAttributes() ?>>
<?= $x_bus_sizes->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

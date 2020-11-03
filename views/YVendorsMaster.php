<?php

namespace PHPMaker2021\test;

// Table
$y_vendors = Container("y_vendors");
?>
<?php if ($y_vendors->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_y_vendorsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($y_vendors->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $y_vendors->TableLeftColumnClass ?>"><?= $y_vendors->id->caption() ?></td>
            <td <?= $y_vendors->id->cellAttributes() ?>>
<span id="el_y_vendors_id">
<span<?= $y_vendors->id->viewAttributes() ?>>
<?= $y_vendors->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($y_vendors->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $y_vendors->TableLeftColumnClass ?>"><?= $y_vendors->name->caption() ?></td>
            <td <?= $y_vendors->name->cellAttributes() ?>>
<span id="el_y_vendors_name">
<span<?= $y_vendors->name->viewAttributes() ?>>
<?= $y_vendors->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

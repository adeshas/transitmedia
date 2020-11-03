<?php

namespace PHPMaker2021\test;

// Table
$y_operators = Container("y_operators");
?>
<?php if ($y_operators->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_y_operatorsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($y_operators->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $y_operators->TableLeftColumnClass ?>"><?= $y_operators->id->caption() ?></td>
            <td <?= $y_operators->id->cellAttributes() ?>>
<span id="el_y_operators_id">
<span<?= $y_operators->id->viewAttributes() ?>>
<?= $y_operators->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($y_operators->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $y_operators->TableLeftColumnClass ?>"><?= $y_operators->name->caption() ?></td>
            <td <?= $y_operators->name->cellAttributes() ?>>
<span id="el_y_operators_name">
<span<?= $y_operators->name->viewAttributes() ?>>
<?= $y_operators->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($y_operators->shortname->Visible) { // shortname ?>
        <tr id="r_shortname">
            <td class="<?= $y_operators->TableLeftColumnClass ?>"><?= $y_operators->shortname->caption() ?></td>
            <td <?= $y_operators->shortname->cellAttributes() ?>>
<span id="el_y_operators_shortname">
<span<?= $y_operators->shortname->viewAttributes() ?>>
<?= $y_operators->shortname->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($y_operators->platform_id->Visible) { // platform_id ?>
        <tr id="r_platform_id">
            <td class="<?= $y_operators->TableLeftColumnClass ?>"><?= $y_operators->platform_id->caption() ?></td>
            <td <?= $y_operators->platform_id->cellAttributes() ?>>
<span id="el_y_operators_platform_id">
<span<?= $y_operators->platform_id->viewAttributes() ?>>
<?= $y_operators->platform_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

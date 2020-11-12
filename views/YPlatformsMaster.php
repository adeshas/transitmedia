<?php

namespace PHPMaker2021\test;

// Table
$y_platforms = Container("y_platforms");
?>
<?php if ($y_platforms->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_y_platformsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($y_platforms->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $y_platforms->TableLeftColumnClass ?>"><?= $y_platforms->id->caption() ?></td>
            <td <?= $y_platforms->id->cellAttributes() ?>>
<span id="el_y_platforms_id">
<span<?= $y_platforms->id->viewAttributes() ?>>
<?= $y_platforms->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($y_platforms->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $y_platforms->TableLeftColumnClass ?>"><?= $y_platforms->name->caption() ?></td>
            <td <?= $y_platforms->name->cellAttributes() ?>>
<span id="el_y_platforms_name">
<span<?= $y_platforms->name->viewAttributes() ?>>
<?= $y_platforms->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($y_platforms->shortname->Visible) { // shortname ?>
        <tr id="r_shortname">
            <td class="<?= $y_platforms->TableLeftColumnClass ?>"><?= $y_platforms->shortname->caption() ?></td>
            <td <?= $y_platforms->shortname->cellAttributes() ?>>
<span id="el_y_platforms_shortname">
<span<?= $y_platforms->shortname->viewAttributes() ?>>
<?= $y_platforms->shortname->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($y_platforms->_email->Visible) { // email ?>
        <tr id="r__email">
            <td class="<?= $y_platforms->TableLeftColumnClass ?>"><?= $y_platforms->_email->caption() ?></td>
            <td <?= $y_platforms->_email->cellAttributes() ?>>
<span id="el_y_platforms__email">
<span<?= $y_platforms->_email->viewAttributes() ?>>
<?= $y_platforms->_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

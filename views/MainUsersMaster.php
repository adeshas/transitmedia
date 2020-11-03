<?php

namespace PHPMaker2021\test;

// Table
$main_users = Container("main_users");
?>
<?php if ($main_users->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_main_usersmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($main_users->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $main_users->TableLeftColumnClass ?>"><?= $main_users->id->caption() ?></td>
            <td <?= $main_users->id->cellAttributes() ?>>
<span id="el_main_users_id">
<span<?= $main_users->id->viewAttributes() ?>>
<?= $main_users->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_users->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $main_users->TableLeftColumnClass ?>"><?= $main_users->name->caption() ?></td>
            <td <?= $main_users->name->cellAttributes() ?>>
<span id="el_main_users_name">
<span<?= $main_users->name->viewAttributes() ?>>
<?= $main_users->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_users->_username->Visible) { // username ?>
        <tr id="r__username">
            <td class="<?= $main_users->TableLeftColumnClass ?>"><?= $main_users->_username->caption() ?></td>
            <td <?= $main_users->_username->cellAttributes() ?>>
<span id="el_main_users__username">
<span<?= $main_users->_username->viewAttributes() ?>>
<?= $main_users->_username->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_users->_password->Visible) { // password ?>
        <tr id="r__password">
            <td class="<?= $main_users->TableLeftColumnClass ?>"><?= $main_users->_password->caption() ?></td>
            <td <?= $main_users->_password->cellAttributes() ?>>
<span id="el_main_users__password">
<span<?= $main_users->_password->viewAttributes() ?>>
<?= $main_users->_password->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_users->_email->Visible) { // email ?>
        <tr id="r__email">
            <td class="<?= $main_users->TableLeftColumnClass ?>"><?= $main_users->_email->caption() ?></td>
            <td <?= $main_users->_email->cellAttributes() ?>>
<span id="el_main_users__email">
<span<?= $main_users->_email->viewAttributes() ?>>
<?= $main_users->_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_users->user_type->Visible) { // user_type ?>
        <tr id="r_user_type">
            <td class="<?= $main_users->TableLeftColumnClass ?>"><?= $main_users->user_type->caption() ?></td>
            <td <?= $main_users->user_type->cellAttributes() ?>>
<span id="el_main_users_user_type">
<span<?= $main_users->user_type->viewAttributes() ?>>
<?= $main_users->user_type->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_users->vendor_id->Visible) { // vendor_id ?>
        <tr id="r_vendor_id">
            <td class="<?= $main_users->TableLeftColumnClass ?>"><?= $main_users->vendor_id->caption() ?></td>
            <td <?= $main_users->vendor_id->cellAttributes() ?>>
<span id="el_main_users_vendor_id">
<span<?= $main_users->vendor_id->viewAttributes() ?>>
<?= $main_users->vendor_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($main_users->reportsto->Visible) { // reportsto ?>
        <tr id="r_reportsto">
            <td class="<?= $main_users->TableLeftColumnClass ?>"><?= $main_users->reportsto->caption() ?></td>
            <td <?= $main_users->reportsto->cellAttributes() ?>>
<span id="el_main_users_reportsto">
<span<?= $main_users->reportsto->viewAttributes() ?>>
<?= $main_users->reportsto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

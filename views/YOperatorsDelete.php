<?php

namespace PHPMaker2021\test;

// Page object
$YOperatorsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fy_operatorsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fy_operatorsdelete = currentForm = new ew.Form("fy_operatorsdelete", "delete");
    loadjs.done("fy_operatorsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fy_operatorsdelete" id="fy_operatorsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="y_operators">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_y_operators_id" class="y_operators_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_y_operators_name" class="y_operators_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->shortname->Visible) { // shortname ?>
        <th class="<?= $Page->shortname->headerCellClass() ?>"><span id="elh_y_operators_shortname" class="y_operators_shortname"><?= $Page->shortname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <th class="<?= $Page->platform_id->headerCellClass() ?>"><span id="elh_y_operators_platform_id" class="y_operators_platform_id"><?= $Page->platform_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_y_operators__email" class="y_operators__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_name->Visible) { // contact_name ?>
        <th class="<?= $Page->contact_name->headerCellClass() ?>"><span id="elh_y_operators_contact_name" class="y_operators_contact_name"><?= $Page->contact_name->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_y_operators_id" class="y_operators_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_y_operators_name" class="y_operators_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->shortname->Visible) { // shortname ?>
        <td <?= $Page->shortname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_y_operators_shortname" class="y_operators_shortname">
<span<?= $Page->shortname->viewAttributes() ?>>
<?= $Page->shortname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td <?= $Page->platform_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_y_operators_platform_id" class="y_operators_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td <?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_y_operators__email" class="y_operators__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_name->Visible) { // contact_name ?>
        <td <?= $Page->contact_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_y_operators_contact_name" class="y_operators_contact_name">
<span<?= $Page->contact_name->viewAttributes() ?>>
<?= $Page->contact_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

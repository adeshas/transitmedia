<?php

namespace PHPMaker2021\test;

// Page object
$ZEmailSettingsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fz_email_settingsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fz_email_settingsdelete = currentForm = new ew.Form("fz_email_settingsdelete", "delete");
    loadjs.done("fz_email_settingsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.z_email_settings) ew.vars.tables.z_email_settings = <?= JsonEncode(GetClientVar("tables", "z_email_settings")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fz_email_settingsdelete" id="fz_email_settingsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="z_email_settings">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_z_email_settings_id" class="z_email_settings_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_z_email_settings_name" class="z_email_settings_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th class="<?= $Page->description->headerCellClass() ?>"><span id="elh_z_email_settings_description" class="z_email_settings_description"><?= $Page->description->caption() ?></span></th>
<?php } ?>
<?php if ($Page->to_value->Visible) { // to_value ?>
        <th class="<?= $Page->to_value->headerCellClass() ?>"><span id="elh_z_email_settings_to_value" class="z_email_settings_to_value"><?= $Page->to_value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cc_value->Visible) { // cc_value ?>
        <th class="<?= $Page->cc_value->headerCellClass() ?>"><span id="elh_z_email_settings_cc_value" class="z_email_settings_cc_value"><?= $Page->cc_value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bcc_value->Visible) { // bcc_value ?>
        <th class="<?= $Page->bcc_value->headerCellClass() ?>"><span id="elh_z_email_settings_bcc_value" class="z_email_settings_bcc_value"><?= $Page->bcc_value->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_z_email_settings_id" class="z_email_settings_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_z_email_settings_name" class="z_email_settings_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <td <?= $Page->description->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_z_email_settings_description" class="z_email_settings_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->to_value->Visible) { // to_value ?>
        <td <?= $Page->to_value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_z_email_settings_to_value" class="z_email_settings_to_value">
<span<?= $Page->to_value->viewAttributes() ?>>
<?= $Page->to_value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cc_value->Visible) { // cc_value ?>
        <td <?= $Page->cc_value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_z_email_settings_cc_value" class="z_email_settings_cc_value">
<span<?= $Page->cc_value->viewAttributes() ?>>
<?= $Page->cc_value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bcc_value->Visible) { // bcc_value ?>
        <td <?= $Page->bcc_value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_z_email_settings_bcc_value" class="z_email_settings_bcc_value">
<span<?= $Page->bcc_value->viewAttributes() ?>>
<?= $Page->bcc_value->getViewValue() ?></span>
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

<?php

namespace PHPMaker2021\test;

// Page object
$ZEmailSettingsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fz_email_settingsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fz_email_settingsview = currentForm = new ew.Form("fz_email_settingsview", "view");
    loadjs.done("fz_email_settingsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fz_email_settingsview" id="fz_email_settingsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="z_email_settings">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_email_settings_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_z_email_settings_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_email_settings_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_z_email_settings_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_email_settings_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description" <?= $Page->description->cellAttributes() ?>>
<span id="el_z_email_settings_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->to_value->Visible) { // to_value ?>
    <tr id="r_to_value">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_email_settings_to_value"><?= $Page->to_value->caption() ?></span></td>
        <td data-name="to_value" <?= $Page->to_value->cellAttributes() ?>>
<span id="el_z_email_settings_to_value">
<span<?= $Page->to_value->viewAttributes() ?>>
<?= $Page->to_value->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cc_value->Visible) { // cc_value ?>
    <tr id="r_cc_value">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_email_settings_cc_value"><?= $Page->cc_value->caption() ?></span></td>
        <td data-name="cc_value" <?= $Page->cc_value->cellAttributes() ?>>
<span id="el_z_email_settings_cc_value">
<span<?= $Page->cc_value->viewAttributes() ?>>
<?= $Page->cc_value->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bcc_value->Visible) { // bcc_value ?>
    <tr id="r_bcc_value">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_z_email_settings_bcc_value"><?= $Page->bcc_value->caption() ?></span></td>
        <td data-name="bcc_value" <?= $Page->bcc_value->cellAttributes() ?>>
<span id="el_z_email_settings_bcc_value">
<span<?= $Page->bcc_value->viewAttributes() ?>>
<?= $Page->bcc_value->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

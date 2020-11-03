<?php

namespace PHPMaker2021\test;

// Page object
$XCampaignStatusView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fx_campaign_statusview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fx_campaign_statusview = currentForm = new ew.Form("fx_campaign_statusview", "view");
    loadjs.done("fx_campaign_statusview");
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
<form name="fx_campaign_statusview" id="fx_campaign_statusview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="x_campaign_status">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_x_campaign_status_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_x_campaign_status_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_x_campaign_status_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_x_campaign_status_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->admin_name->Visible) { // admin_name ?>
    <tr id="r_admin_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_x_campaign_status_admin_name"><?= $Page->admin_name->caption() ?></span></td>
        <td data-name="admin_name" <?= $Page->admin_name->cellAttributes() ?>>
<span id="el_x_campaign_status_admin_name">
<span<?= $Page->admin_name->viewAttributes() ?>>
<?= $Page->admin_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->operator_name->Visible) { // operator_name ?>
    <tr id="r_operator_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_x_campaign_status_operator_name"><?= $Page->operator_name->caption() ?></span></td>
        <td data-name="operator_name" <?= $Page->operator_name->cellAttributes() ?>>
<span id="el_x_campaign_status_operator_name">
<span<?= $Page->operator_name->viewAttributes() ?>>
<?= $Page->operator_name->getViewValue() ?></span>
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

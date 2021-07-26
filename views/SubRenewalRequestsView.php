<?php

namespace PHPMaker2021\test;

// Page object
$SubRenewalRequestsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsub_renewal_requestsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fsub_renewal_requestsview = currentForm = new ew.Form("fsub_renewal_requestsview", "view");
    loadjs.done("fsub_renewal_requestsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.sub_renewal_requests) ew.vars.tables.sub_renewal_requests = <?= JsonEncode(GetClientVar("tables", "sub_renewal_requests")) ?>;
</script>
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
<form name="fsub_renewal_requestsview" id="fsub_renewal_requestsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_renewal_requests">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_renewal_requests_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_sub_renewal_requests_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <tr id="r_campaign_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_renewal_requests_campaign_id"><?= $Page->campaign_id->caption() ?></span></td>
        <td data-name="campaign_id" <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el_sub_renewal_requests_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <tr id="r_created_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_renewal_requests_created_by"><?= $Page->created_by->caption() ?></span></td>
        <td data-name="created_by" <?= $Page->created_by->cellAttributes() ?>>
<span id="el_sub_renewal_requests_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <tr id="r_ts_created">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_renewal_requests_ts_created"><?= $Page->ts_created->caption() ?></span></td>
        <td data-name="ts_created" <?= $Page->ts_created->cellAttributes() ?>>
<span id="el_sub_renewal_requests_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
    <tr id="r_ts_last_update">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_renewal_requests_ts_last_update"><?= $Page->ts_last_update->caption() ?></span></td>
        <td data-name="ts_last_update" <?= $Page->ts_last_update->cellAttributes() ?>>
<span id="el_sub_renewal_requests_ts_last_update">
<span<?= $Page->ts_last_update->viewAttributes() ?>>
<?= $Page->ts_last_update->getViewValue() ?></span>
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

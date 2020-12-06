<?php

namespace PHPMaker2021\test;

// Page object
$SubRenewalRequestsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsub_renewal_requestsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fsub_renewal_requestsdelete = currentForm = new ew.Form("fsub_renewal_requestsdelete", "delete");
    loadjs.done("fsub_renewal_requestsdelete");
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
<form name="fsub_renewal_requestsdelete" id="fsub_renewal_requestsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_renewal_requests">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_sub_renewal_requests_id" class="sub_renewal_requests_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <th class="<?= $Page->campaign_id->headerCellClass() ?>"><span id="elh_sub_renewal_requests_campaign_id" class="sub_renewal_requests_campaign_id"><?= $Page->campaign_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <th class="<?= $Page->created_by->headerCellClass() ?>"><span id="elh_sub_renewal_requests_created_by" class="sub_renewal_requests_created_by"><?= $Page->created_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
        <th class="<?= $Page->ts_created->headerCellClass() ?>"><span id="elh_sub_renewal_requests_ts_created" class="sub_renewal_requests_ts_created"><?= $Page->ts_created->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
        <th class="<?= $Page->ts_last_update->headerCellClass() ?>"><span id="elh_sub_renewal_requests_ts_last_update" class="sub_renewal_requests_ts_last_update"><?= $Page->ts_last_update->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_sub_renewal_requests_id" class="sub_renewal_requests_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sub_renewal_requests_campaign_id" class="sub_renewal_requests_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <td <?= $Page->created_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sub_renewal_requests_created_by" class="sub_renewal_requests_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
        <td <?= $Page->ts_created->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sub_renewal_requests_ts_created" class="sub_renewal_requests_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
        <td <?= $Page->ts_last_update->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sub_renewal_requests_ts_last_update" class="sub_renewal_requests_ts_last_update">
<span<?= $Page->ts_last_update->viewAttributes() ?>>
<?= $Page->ts_last_update->getViewValue() ?></span>
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

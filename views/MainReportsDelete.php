<?php

namespace PHPMaker2021\test;

// Page object
$MainReportsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmain_reportsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fmain_reportsdelete = currentForm = new ew.Form("fmain_reportsdelete", "delete");
    loadjs.done("fmain_reportsdelete");
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
<form name="fmain_reportsdelete" id="fmain_reportsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_reports">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_main_reports_id" class="main_reports_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th class="<?= $Page->date->headerCellClass() ?>"><span id="elh_main_reports_date" class="main_reports_date"><?= $Page->date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th class="<?= $Page->image->headerCellClass() ?>"><span id="elh_main_reports_image" class="main_reports_image"><?= $Page->image->caption() ?></span></th>
<?php } ?>
<?php if ($Page->video->Visible) { // video ?>
        <th class="<?= $Page->video->headerCellClass() ?>"><span id="elh_main_reports_video" class="main_reports_video"><?= $Page->video->caption() ?></span></th>
<?php } ?>
<?php if ($Page->comments->Visible) { // comments ?>
        <th class="<?= $Page->comments->headerCellClass() ?>"><span id="elh_main_reports_comments" class="main_reports_comments"><?= $Page->comments->caption() ?></span></th>
<?php } ?>
<?php if ($Page->type_id->Visible) { // type_id ?>
        <th class="<?= $Page->type_id->headerCellClass() ?>"><span id="elh_main_reports_type_id" class="main_reports_type_id"><?= $Page->type_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <th class="<?= $Page->campaign_id->headerCellClass() ?>"><span id="elh_main_reports_campaign_id" class="main_reports_campaign_id"><?= $Page->campaign_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ref_bus_id->Visible) { // ref_bus_id ?>
        <th class="<?= $Page->ref_bus_id->headerCellClass() ?>"><span id="elh_main_reports_ref_bus_id" class="main_reports_ref_bus_id"><?= $Page->ref_bus_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <th class="<?= $Page->vendor_id->headerCellClass() ?>"><span id="elh_main_reports_vendor_id" class="main_reports_vendor_id"><?= $Page->vendor_id->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_main_reports_id" class="main_reports_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <td <?= $Page->date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_reports_date" class="main_reports_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <td <?= $Page->image->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_reports_image" class="main_reports_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= $Page->image->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->video->Visible) { // video ?>
        <td <?= $Page->video->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_reports_video" class="main_reports_video">
<span<?= $Page->video->viewAttributes() ?>>
<?= $Page->video->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->comments->Visible) { // comments ?>
        <td <?= $Page->comments->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_reports_comments" class="main_reports_comments">
<span<?= $Page->comments->viewAttributes() ?>>
<?= $Page->comments->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->type_id->Visible) { // type_id ?>
        <td <?= $Page->type_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_reports_type_id" class="main_reports_type_id">
<span<?= $Page->type_id->viewAttributes() ?>>
<?= $Page->type_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
        <td <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_reports_campaign_id" class="main_reports_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ref_bus_id->Visible) { // ref_bus_id ?>
        <td <?= $Page->ref_bus_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_reports_ref_bus_id" class="main_reports_ref_bus_id">
<span<?= $Page->ref_bus_id->viewAttributes() ?>>
<?= $Page->ref_bus_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td <?= $Page->vendor_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_main_reports_vendor_id" class="main_reports_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
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
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= GetUrl($Page->getReturnUrl()) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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

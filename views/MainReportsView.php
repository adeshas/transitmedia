<?php

namespace PHPMaker2021\test;

// Page object
$MainReportsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmain_reportsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fmain_reportsview = currentForm = new ew.Form("fmain_reportsview", "view");
    loadjs.done("fmain_reportsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.main_reports) ew.vars.tables.main_reports = <?= JsonEncode(GetClientVar("tables", "main_reports")) ?>;
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
<form name="fmain_reportsview" id="fmain_reportsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_reports">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_main_reports_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
    <tr id="r_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_date"><?= $Page->date->caption() ?></span></td>
        <td data-name="date" <?= $Page->date->cellAttributes() ?>>
<span id="el_main_reports_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <tr id="r_image">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_image"><?= $Page->image->caption() ?></span></td>
        <td data-name="image" <?= $Page->image->cellAttributes() ?>>
<span id="el_main_reports_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= $Page->image->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->video->Visible) { // video ?>
    <tr id="r_video">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_video"><?= $Page->video->caption() ?></span></td>
        <td data-name="video" <?= $Page->video->cellAttributes() ?>>
<span id="el_main_reports_video">
<span<?= $Page->video->viewAttributes() ?>>
<?= $Page->video->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comments->Visible) { // comments ?>
    <tr id="r_comments">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_comments"><?= $Page->comments->caption() ?></span></td>
        <td data-name="comments" <?= $Page->comments->cellAttributes() ?>>
<span id="el_main_reports_comments">
<span<?= $Page->comments->viewAttributes() ?>>
<?= $Page->comments->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type_id->Visible) { // type_id ?>
    <tr id="r_type_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_type_id"><?= $Page->type_id->caption() ?></span></td>
        <td data-name="type_id" <?= $Page->type_id->cellAttributes() ?>>
<span id="el_main_reports_type_id">
<span<?= $Page->type_id->viewAttributes() ?>>
<?= $Page->type_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <tr id="r_campaign_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_campaign_id"><?= $Page->campaign_id->caption() ?></span></td>
        <td data-name="campaign_id" <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el_main_reports_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<?= $Page->campaign_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ref_bus_id->Visible) { // ref_bus_id ?>
    <tr id="r_ref_bus_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_ref_bus_id"><?= $Page->ref_bus_id->caption() ?></span></td>
        <td data-name="ref_bus_id" <?= $Page->ref_bus_id->cellAttributes() ?>>
<span id="el_main_reports_ref_bus_id">
<span<?= $Page->ref_bus_id->viewAttributes() ?>>
<?= $Page->ref_bus_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <tr id="r_ts_created">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_ts_created"><?= $Page->ts_created->caption() ?></span></td>
        <td data-name="ts_created" <?= $Page->ts_created->cellAttributes() ?>>
<span id="el_main_reports_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
    <tr id="r_vendor_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_main_reports_vendor_id"><?= $Page->vendor_id->caption() ?></span></td>
        <td data-name="vendor_id" <?= $Page->vendor_id->cellAttributes() ?>>
<span id="el_main_reports_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
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

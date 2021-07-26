<?php

namespace PHPMaker2021\test;

// Page object
$YPlatformsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fy_platformsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fy_platformsview = currentForm = new ew.Form("fy_platformsview", "view");
    loadjs.done("fy_platformsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.y_platforms) ew.vars.tables.y_platforms = <?= JsonEncode(GetClientVar("tables", "y_platforms")) ?>;
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
<form name="fy_platformsview" id="fy_platformsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="y_platforms">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_y_platforms_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_y_platforms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_y_platforms_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_y_platforms_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->shortname->Visible) { // shortname ?>
    <tr id="r_shortname">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_y_platforms_shortname"><?= $Page->shortname->caption() ?></span></td>
        <td data-name="shortname" <?= $Page->shortname->cellAttributes() ?>>
<span id="el_y_platforms_shortname">
<span<?= $Page->shortname->viewAttributes() ?>>
<?= $Page->shortname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_y_platforms__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el_y_platforms__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("main_campaigns", explode(",", $Page->getCurrentDetailTable())) && $main_campaigns->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "main_campaigns") {
            $firstActiveDetailTable = "main_campaigns";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("main_campaigns") ?>" href="#tab_main_campaigns" data-toggle="tab"><?= $Language->tablePhrase("main_campaigns", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("y_operators", explode(",", $Page->getCurrentDetailTable())) && $y_operators->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "y_operators") {
            $firstActiveDetailTable = "y_operators";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("y_operators") ?>" href="#tab_y_operators" data-toggle="tab"><?= $Language->tablePhrase("y_operators", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("main_campaigns", explode(",", $Page->getCurrentDetailTable())) && $main_campaigns->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "main_campaigns") {
            $firstActiveDetailTable = "main_campaigns";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("main_campaigns") ?>" id="tab_main_campaigns"><!-- page* -->
<?php include_once "MainCampaignsGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("y_operators", explode(",", $Page->getCurrentDetailTable())) && $y_operators->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "y_operators") {
            $firstActiveDetailTable = "y_operators";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("y_operators") ?>" id="tab_y_operators"><!-- page* -->
<?php include_once "YOperatorsGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
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

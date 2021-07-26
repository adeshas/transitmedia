<?php

namespace PHPMaker2021\test;

// Page object
$WVendorsOperatorsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_vendors_operatorsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fw_vendors_operatorsview = currentForm = new ew.Form("fw_vendors_operatorsview", "view");
    loadjs.done("fw_vendors_operatorsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.w_vendors_operators) ew.vars.tables.w_vendors_operators = <?= JsonEncode(GetClientVar("tables", "w_vendors_operators")) ?>;
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
<form name="fw_vendors_operatorsview" id="fw_vendors_operatorsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_vendors_operators">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_vendors_operators_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_w_vendors_operators_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
    <tr id="r_vendor_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_vendors_operators_vendor_id"><?= $Page->vendor_id->caption() ?></span></td>
        <td data-name="vendor_id" <?= $Page->vendor_id->cellAttributes() ?>>
<span id="el_w_vendors_operators_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->operator_id->Visible) { // operator_id ?>
    <tr id="r_operator_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_vendors_operators_operator_id"><?= $Page->operator_id->caption() ?></span></td>
        <td data-name="operator_id" <?= $Page->operator_id->cellAttributes() ?>>
<span id="el_w_vendors_operators_operator_id">
<span<?= $Page->operator_id->viewAttributes() ?>>
<?= $Page->operator_id->getViewValue() ?></span>
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

<?php

namespace PHPMaker2021\test;

// Page object
$MainPrintOrdersEdit = &$Page;
?>
<script>
if (!ew.vars.tables.main_print_orders) ew.vars.tables.main_print_orders = <?= JsonEncode(GetClientVar("tables", "main_print_orders")) ?>;
var currentForm, currentPageID;
var fmain_print_ordersedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fmain_print_ordersedit = currentForm = new ew.Form("fmain_print_ordersedit", "edit");

    // Add fields
    var fields = ew.vars.tables.main_print_orders.fields;
    fmain_print_ordersedit.addFields([
        ["campaign_id", [fields.campaign_id.required ? ew.Validators.required(fields.campaign_id.caption) : null], fields.campaign_id.isInvalid],
        ["printer_id", [fields.printer_id.required ? ew.Validators.required(fields.printer_id.caption) : null], fields.printer_id.isInvalid],
        ["quantity", [fields.quantity.required ? ew.Validators.required(fields.quantity.caption) : null], fields.quantity.isInvalid],
        ["approved", [fields.approved.required ? ew.Validators.required(fields.approved.caption) : null], fields.approved.isInvalid],
        ["comments", [fields.comments.required ? ew.Validators.required(fields.comments.caption) : null], fields.comments.isInvalid],
        ["all_codes_assigned_in_campaign", [fields.all_codes_assigned_in_campaign.required ? ew.Validators.required(fields.all_codes_assigned_in_campaign.caption) : null], fields.all_codes_assigned_in_campaign.isInvalid],
        ["bus_codes", [fields.bus_codes.required ? ew.Validators.required(fields.bus_codes.caption) : null], fields.bus_codes.isInvalid],
        ["available_codes_to_be_assigned", [fields.available_codes_to_be_assigned.required ? ew.Validators.required(fields.available_codes_to_be_assigned.caption) : null], fields.available_codes_to_be_assigned.isInvalid],
        ["tags", [fields.tags.required ? ew.Validators.required(fields.tags.caption) : null], fields.tags.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_print_ordersedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fmain_print_ordersedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fmain_print_ordersedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_print_ordersedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_print_ordersedit.lists.approved = <?= $Page->approved->toClientList($Page) ?>;
    loadjs.done("fmain_print_ordersedit");
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
<form name="fmain_print_ordersedit" id="fmain_print_ordersedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_print_orders">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <div id="r_campaign_id" class="form-group row">
        <label id="elh_main_print_orders_campaign_id" for="x_campaign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->campaign_id->caption() ?><?= $Page->campaign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el_main_print_orders_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_print_orders" data-field="x_campaign_id" data-hidden="1" name="x_campaign_id" id="x_campaign_id" value="<?= HtmlEncode($Page->campaign_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->printer_id->Visible) { // printer_id ?>
    <div id="r_printer_id" class="form-group row">
        <label id="elh_main_print_orders_printer_id" for="x_printer_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->printer_id->caption() ?><?= $Page->printer_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->printer_id->cellAttributes() ?>>
<span id="el_main_print_orders_printer_id">
<span<?= $Page->printer_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->printer_id->getDisplayValue($Page->printer_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_print_orders" data-field="x_printer_id" data-hidden="1" name="x_printer_id" id="x_printer_id" value="<?= HtmlEncode($Page->printer_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <div id="r_quantity" class="form-group row">
        <label id="elh_main_print_orders_quantity" for="x_quantity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->quantity->caption() ?><?= $Page->quantity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->quantity->cellAttributes() ?>>
<span id="el_main_print_orders_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->quantity->getDisplayValue($Page->quantity->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_print_orders" data-field="x_quantity" data-hidden="1" name="x_quantity" id="x_quantity" value="<?= HtmlEncode($Page->quantity->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
    <div id="r_approved" class="form-group row">
        <label id="elh_main_print_orders_approved" class="<?= $Page->LeftColumnClass ?>"><?= $Page->approved->caption() ?><?= $Page->approved->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approved->cellAttributes() ?>>
<span id="el_main_print_orders_approved">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->approved->isInvalidClass() ?>" data-table="main_print_orders" data-field="x_approved" name="x_approved[]" id="x_approved_277062" value="1"<?= ConvertToBool($Page->approved->CurrentValue) ? " checked" : "" ?><?= $Page->approved->editAttributes() ?> aria-describedby="x_approved_help">
    <label class="custom-control-label" for="x_approved_277062"></label>
</div>
<?= $Page->approved->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->approved->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->comments->Visible) { // comments ?>
    <div id="r_comments" class="form-group row">
        <label id="elh_main_print_orders_comments" for="x_comments" class="<?= $Page->LeftColumnClass ?>"><?= $Page->comments->caption() ?><?= $Page->comments->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->comments->cellAttributes() ?>>
<span id="el_main_print_orders_comments">
<textarea data-table="main_print_orders" data-field="x_comments" name="x_comments" id="x_comments" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->comments->getPlaceHolder()) ?>"<?= $Page->comments->editAttributes() ?> aria-describedby="x_comments_help"><?= $Page->comments->EditValue ?></textarea>
<?= $Page->comments->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->comments->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->all_codes_assigned_in_campaign->Visible) { // all_codes_assigned_in_campaign ?>
    <div id="r_all_codes_assigned_in_campaign" class="form-group row">
        <label id="elh_main_print_orders_all_codes_assigned_in_campaign" for="x_all_codes_assigned_in_campaign" class="<?= $Page->LeftColumnClass ?>"><?= $Page->all_codes_assigned_in_campaign->caption() ?><?= $Page->all_codes_assigned_in_campaign->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->all_codes_assigned_in_campaign->cellAttributes() ?>>
<span id="el_main_print_orders_all_codes_assigned_in_campaign">
<span<?= $Page->all_codes_assigned_in_campaign->viewAttributes() ?>>
<?= $Page->all_codes_assigned_in_campaign->EditValue ?></span>
</span>
<input type="hidden" data-table="main_print_orders" data-field="x_all_codes_assigned_in_campaign" data-hidden="1" name="x_all_codes_assigned_in_campaign" id="x_all_codes_assigned_in_campaign" value="<?= HtmlEncode($Page->all_codes_assigned_in_campaign->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bus_codes->Visible) { // bus_codes ?>
    <div id="r_bus_codes" class="form-group row">
        <label id="elh_main_print_orders_bus_codes" for="x_bus_codes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bus_codes->caption() ?><?= $Page->bus_codes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bus_codes->cellAttributes() ?>>
<span id="el_main_print_orders_bus_codes">
<textarea data-table="main_print_orders" data-field="x_bus_codes" name="x_bus_codes" id="x_bus_codes" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bus_codes->getPlaceHolder()) ?>"<?= $Page->bus_codes->editAttributes() ?> aria-describedby="x_bus_codes_help"><?= $Page->bus_codes->EditValue ?></textarea>
<?= $Page->bus_codes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bus_codes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->available_codes_to_be_assigned->Visible) { // available_codes_to_be_assigned ?>
    <div id="r_available_codes_to_be_assigned" class="form-group row">
        <label id="elh_main_print_orders_available_codes_to_be_assigned" for="x_available_codes_to_be_assigned" class="<?= $Page->LeftColumnClass ?>"><?= $Page->available_codes_to_be_assigned->caption() ?><?= $Page->available_codes_to_be_assigned->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->available_codes_to_be_assigned->cellAttributes() ?>>
<span id="el_main_print_orders_available_codes_to_be_assigned">
<textarea data-table="main_print_orders" data-field="x_available_codes_to_be_assigned" name="x_available_codes_to_be_assigned" id="x_available_codes_to_be_assigned" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->available_codes_to_be_assigned->getPlaceHolder()) ?>"<?= $Page->available_codes_to_be_assigned->editAttributes() ?> aria-describedby="x_available_codes_to_be_assigned_help"><?= $Page->available_codes_to_be_assigned->EditValue ?></textarea>
<?= $Page->available_codes_to_be_assigned->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->available_codes_to_be_assigned->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tags->Visible) { // tags ?>
    <div id="r_tags" class="form-group row">
        <label id="elh_main_print_orders_tags" for="x_tags" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tags->caption() ?><?= $Page->tags->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tags->cellAttributes() ?>>
<span id="el_main_print_orders_tags">
<textarea data-table="main_print_orders" data-field="x_tags" name="x_tags" id="x_tags" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->tags->getPlaceHolder()) ?>"<?= $Page->tags->editAttributes() ?> aria-describedby="x_tags_help"><?= $Page->tags->EditValue ?></textarea>
<?= $Page->tags->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tags->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="main_print_orders" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("main_print_orders");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

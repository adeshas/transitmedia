<?php

namespace PHPMaker2021\test;

// Page object
$MainPrintOrdersAdd = &$Page;
?>
<script>
if (!ew.vars.tables.main_print_orders) ew.vars.tables.main_print_orders = <?= JsonEncode(GetClientVar("tables", "main_print_orders")) ?>;
var currentForm, currentPageID;
var fmain_print_ordersadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fmain_print_ordersadd = currentForm = new ew.Form("fmain_print_ordersadd", "add");

    // Add fields
    var fields = ew.vars.tables.main_print_orders.fields;
    fmain_print_ordersadd.addFields([
        ["campaign_id", [fields.campaign_id.required ? ew.Validators.required(fields.campaign_id.caption) : null], fields.campaign_id.isInvalid],
        ["printer_id", [fields.printer_id.required ? ew.Validators.required(fields.printer_id.caption) : null], fields.printer_id.isInvalid],
        ["quantity", [fields.quantity.required ? ew.Validators.required(fields.quantity.caption) : null, ew.Validators.integer], fields.quantity.isInvalid],
        ["comments", [fields.comments.required ? ew.Validators.required(fields.comments.caption) : null], fields.comments.isInvalid],
        ["available_codes_to_be_assigned", [fields.available_codes_to_be_assigned.required ? ew.Validators.required(fields.available_codes_to_be_assigned.caption) : null], fields.available_codes_to_be_assigned.isInvalid],
        ["tags", [fields.tags.required ? ew.Validators.required(fields.tags.caption) : null], fields.tags.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_print_ordersadd,
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
    fmain_print_ordersadd.validate = function () {
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
    fmain_print_ordersadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_print_ordersadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_print_ordersadd.lists.campaign_id = <?= $Page->campaign_id->toClientList($Page) ?>;
    fmain_print_ordersadd.lists.printer_id = <?= $Page->printer_id->toClientList($Page) ?>;
    loadjs.done("fmain_print_ordersadd");
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
<form name="fmain_print_ordersadd" id="fmain_print_ordersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_print_orders">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <div id="r_campaign_id" class="form-group row">
        <label id="elh_main_print_orders_campaign_id" for="x_campaign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->campaign_id->caption() ?><?= $Page->campaign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el_main_print_orders_campaign_id">
    <select
        id="x_campaign_id"
        name="x_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="main_print_orders_x_campaign_id"
        data-table="main_print_orders"
        data-field="x_campaign_id"
        data-value-separator="<?= $Page->campaign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->campaign_id->getPlaceHolder()) ?>"
        <?= $Page->campaign_id->editAttributes() ?>>
        <?= $Page->campaign_id->selectOptionListHtml("x_campaign_id") ?>
    </select>
    <?= $Page->campaign_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->campaign_id->getErrorMessage() ?></div>
<?= $Page->campaign_id->Lookup->getParamTag($Page, "p_x_campaign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_print_orders_x_campaign_id']"),
        options = { name: "x_campaign_id", selectId: "main_print_orders_x_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_print_orders.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->printer_id->Visible) { // printer_id ?>
    <div id="r_printer_id" class="form-group row">
        <label id="elh_main_print_orders_printer_id" for="x_printer_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->printer_id->caption() ?><?= $Page->printer_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->printer_id->cellAttributes() ?>>
<span id="el_main_print_orders_printer_id">
    <select
        id="x_printer_id"
        name="x_printer_id"
        class="form-control ew-select<?= $Page->printer_id->isInvalidClass() ?>"
        data-select2-id="main_print_orders_x_printer_id"
        data-table="main_print_orders"
        data-field="x_printer_id"
        data-value-separator="<?= $Page->printer_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->printer_id->getPlaceHolder()) ?>"
        <?= $Page->printer_id->editAttributes() ?>>
        <?= $Page->printer_id->selectOptionListHtml("x_printer_id") ?>
    </select>
    <?= $Page->printer_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->printer_id->getErrorMessage() ?></div>
<?= $Page->printer_id->Lookup->getParamTag($Page, "p_x_printer_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_print_orders_x_printer_id']"),
        options = { name: "x_printer_id", selectId: "main_print_orders_x_printer_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_print_orders.fields.printer_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <div id="r_quantity" class="form-group row">
        <label id="elh_main_print_orders_quantity" for="x_quantity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->quantity->caption() ?><?= $Page->quantity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->quantity->cellAttributes() ?>>
<span id="el_main_print_orders_quantity">
<input type="<?= $Page->quantity->getInputTextType() ?>" data-table="main_print_orders" data-field="x_quantity" name="x_quantity" id="x_quantity" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>" value="<?= $Page->quantity->EditValue ?>"<?= $Page->quantity->editAttributes() ?> aria-describedby="x_quantity_help">
<?= $Page->quantity->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage() ?></div>
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
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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

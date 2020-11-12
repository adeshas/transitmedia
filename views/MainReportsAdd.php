<?php

namespace PHPMaker2021\test;

// Page object
$MainReportsAdd = &$Page;
?>
<script>
if (!ew.vars.tables.main_reports) ew.vars.tables.main_reports = <?= JsonEncode(GetClientVar("tables", "main_reports")) ?>;
var currentForm, currentPageID;
var fmain_reportsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fmain_reportsadd = currentForm = new ew.Form("fmain_reportsadd", "add");

    // Add fields
    var fields = ew.vars.tables.main_reports.fields;
    fmain_reportsadd.addFields([
        ["date", [fields.date.required ? ew.Validators.required(fields.date.caption) : null, ew.Validators.datetime(0)], fields.date.isInvalid],
        ["image", [fields.image.required ? ew.Validators.required(fields.image.caption) : null], fields.image.isInvalid],
        ["video", [fields.video.required ? ew.Validators.required(fields.video.caption) : null], fields.video.isInvalid],
        ["comments", [fields.comments.required ? ew.Validators.required(fields.comments.caption) : null], fields.comments.isInvalid],
        ["type_id", [fields.type_id.required ? ew.Validators.required(fields.type_id.caption) : null], fields.type_id.isInvalid],
        ["campaign_id", [fields.campaign_id.required ? ew.Validators.required(fields.campaign_id.caption) : null], fields.campaign_id.isInvalid],
        ["ref_bus_id", [fields.ref_bus_id.required ? ew.Validators.required(fields.ref_bus_id.caption) : null], fields.ref_bus_id.isInvalid],
        ["vendor_id", [fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null], fields.vendor_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_reportsadd,
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
    fmain_reportsadd.validate = function () {
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
    fmain_reportsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_reportsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_reportsadd.lists.type_id = <?= $Page->type_id->toClientList($Page) ?>;
    fmain_reportsadd.lists.campaign_id = <?= $Page->campaign_id->toClientList($Page) ?>;
    fmain_reportsadd.lists.ref_bus_id = <?= $Page->ref_bus_id->toClientList($Page) ?>;
    fmain_reportsadd.lists.vendor_id = <?= $Page->vendor_id->toClientList($Page) ?>;
    loadjs.done("fmain_reportsadd");
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
<form name="fmain_reportsadd" id="fmain_reportsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_reports">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->date->Visible) { // date ?>
    <div id="r_date" class="form-group row">
        <label id="elh_main_reports_date" for="x_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date->caption() ?><?= $Page->date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_reports_date">
<input type="<?= $Page->date->getInputTextType() ?>" data-table="main_reports" data-field="x_date" name="x_date" id="x_date" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>" value="<?= $Page->date->EditValue ?>"<?= $Page->date->editAttributes() ?> aria-describedby="x_date_help">
<?= $Page->date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage() ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_reportsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_reportsadd", "x_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_main_reports_date">
<span<?= $Page->date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->date->getDisplayValue($Page->date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_reports" data-field="x_date" data-hidden="1" name="x_date" id="x_date" value="<?= HtmlEncode($Page->date->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image" class="form-group row">
        <label id="elh_main_reports_image" for="x_image" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image->caption() ?><?= $Page->image->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->image->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_reports_image">
<textarea data-table="main_reports" data-field="x_image" name="x_image" id="x_image" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->image->getPlaceHolder()) ?>"<?= $Page->image->editAttributes() ?> aria-describedby="x_image_help"><?= $Page->image->EditValue ?></textarea>
<?= $Page->image->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->image->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_reports_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= $Page->image->ViewValue ?></span>
</span>
<input type="hidden" data-table="main_reports" data-field="x_image" data-hidden="1" name="x_image" id="x_image" value="<?= HtmlEncode($Page->image->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->video->Visible) { // video ?>
    <div id="r_video" class="form-group row">
        <label id="elh_main_reports_video" for="x_video" class="<?= $Page->LeftColumnClass ?>"><?= $Page->video->caption() ?><?= $Page->video->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->video->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_reports_video">
<textarea data-table="main_reports" data-field="x_video" name="x_video" id="x_video" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->video->getPlaceHolder()) ?>"<?= $Page->video->editAttributes() ?> aria-describedby="x_video_help"><?= $Page->video->EditValue ?></textarea>
<?= $Page->video->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->video->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_reports_video">
<span<?= $Page->video->viewAttributes() ?>>
<?= $Page->video->ViewValue ?></span>
</span>
<input type="hidden" data-table="main_reports" data-field="x_video" data-hidden="1" name="x_video" id="x_video" value="<?= HtmlEncode($Page->video->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->comments->Visible) { // comments ?>
    <div id="r_comments" class="form-group row">
        <label id="elh_main_reports_comments" for="x_comments" class="<?= $Page->LeftColumnClass ?>"><?= $Page->comments->caption() ?><?= $Page->comments->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->comments->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_reports_comments">
<textarea data-table="main_reports" data-field="x_comments" name="x_comments" id="x_comments" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->comments->getPlaceHolder()) ?>"<?= $Page->comments->editAttributes() ?> aria-describedby="x_comments_help"><?= $Page->comments->EditValue ?></textarea>
<?= $Page->comments->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->comments->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_reports_comments">
<span<?= $Page->comments->viewAttributes() ?>>
<?= $Page->comments->ViewValue ?></span>
</span>
<input type="hidden" data-table="main_reports" data-field="x_comments" data-hidden="1" name="x_comments" id="x_comments" value="<?= HtmlEncode($Page->comments->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type_id->Visible) { // type_id ?>
    <div id="r_type_id" class="form-group row">
        <label id="elh_main_reports_type_id" for="x_type_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type_id->caption() ?><?= $Page->type_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->type_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_reports_type_id">
    <select
        id="x_type_id"
        name="x_type_id"
        class="form-control ew-select<?= $Page->type_id->isInvalidClass() ?>"
        data-select2-id="main_reports_x_type_id"
        data-table="main_reports"
        data-field="x_type_id"
        data-value-separator="<?= $Page->type_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->type_id->getPlaceHolder()) ?>"
        <?= $Page->type_id->editAttributes() ?>>
        <?= $Page->type_id->selectOptionListHtml("x_type_id") ?>
    </select>
    <?= $Page->type_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->type_id->getErrorMessage() ?></div>
<?= $Page->type_id->Lookup->getParamTag($Page, "p_x_type_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_reports_x_type_id']"),
        options = { name: "x_type_id", selectId: "main_reports_x_type_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_reports.fields.type_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_reports_type_id">
<span<?= $Page->type_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->type_id->getDisplayValue($Page->type_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_reports" data-field="x_type_id" data-hidden="1" name="x_type_id" id="x_type_id" value="<?= HtmlEncode($Page->type_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <div id="r_campaign_id" class="form-group row">
        <label id="elh_main_reports_campaign_id" for="x_campaign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->campaign_id->caption() ?><?= $Page->campaign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_reports_campaign_id">
    <select
        id="x_campaign_id"
        name="x_campaign_id"
        class="form-control ew-select<?= $Page->campaign_id->isInvalidClass() ?>"
        data-select2-id="main_reports_x_campaign_id"
        data-table="main_reports"
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
    var el = document.querySelector("select[data-select2-id='main_reports_x_campaign_id']"),
        options = { name: "x_campaign_id", selectId: "main_reports_x_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_reports.fields.campaign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_reports_campaign_id">
<span<?= $Page->campaign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->campaign_id->getDisplayValue($Page->campaign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_reports" data-field="x_campaign_id" data-hidden="1" name="x_campaign_id" id="x_campaign_id" value="<?= HtmlEncode($Page->campaign_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ref_bus_id->Visible) { // ref_bus_id ?>
    <div id="r_ref_bus_id" class="form-group row">
        <label id="elh_main_reports_ref_bus_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ref_bus_id->caption() ?><?= $Page->ref_bus_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ref_bus_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_reports_ref_bus_id">
<?php
$onchange = $Page->ref_bus_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->ref_bus_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_ref_bus_id" class="ew-auto-suggest">
    <input type="<?= $Page->ref_bus_id->getInputTextType() ?>" class="form-control" name="sv_x_ref_bus_id" id="sv_x_ref_bus_id" value="<?= RemoveHtml($Page->ref_bus_id->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->ref_bus_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->ref_bus_id->getPlaceHolder()) ?>"<?= $Page->ref_bus_id->editAttributes() ?> aria-describedby="x_ref_bus_id_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_reports" data-field="x_ref_bus_id" data-input="sv_x_ref_bus_id" data-value-separator="<?= $Page->ref_bus_id->displayValueSeparatorAttribute() ?>" name="x_ref_bus_id" id="x_ref_bus_id" value="<?= HtmlEncode($Page->ref_bus_id->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->ref_bus_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ref_bus_id->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_reportsadd"], function() {
    fmain_reportsadd.createAutoSuggest(Object.assign({"id":"x_ref_bus_id","forceSelect":false}, ew.vars.tables.main_reports.fields.ref_bus_id.autoSuggestOptions));
});
</script>
<?= $Page->ref_bus_id->Lookup->getParamTag($Page, "p_x_ref_bus_id") ?>
</span>
<?php } else { ?>
<span id="el_main_reports_ref_bus_id">
<span<?= $Page->ref_bus_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ref_bus_id->getDisplayValue($Page->ref_bus_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_reports" data-field="x_ref_bus_id" data-hidden="1" name="x_ref_bus_id" id="x_ref_bus_id" value="<?= HtmlEncode($Page->ref_bus_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
    <div id="r_vendor_id" class="form-group row">
        <label id="elh_main_reports_vendor_id" for="x_vendor_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vendor_id->caption() ?><?= $Page->vendor_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->vendor_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_main_reports_vendor_id">
    <select
        id="x_vendor_id"
        name="x_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_reports_x_vendor_id"
        data-table="main_reports"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x_vendor_id") ?>
    </select>
    <?= $Page->vendor_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_reports_x_vendor_id']"),
        options = { name: "x_vendor_id", selectId: "main_reports_x_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_reports.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_reports_vendor_id">
    <select
        id="x_vendor_id"
        name="x_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_reports_x_vendor_id"
        data-table="main_reports"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x_vendor_id") ?>
    </select>
    <?= $Page->vendor_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_reports_x_vendor_id']"),
        options = { name: "x_vendor_id", selectId: "main_reports_x_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_reports.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_main_reports_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_reports" data-field="x_vendor_id" data-hidden="1" name="x_vendor_id" id="x_vendor_id" value="<?= HtmlEncode($Page->vendor_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= GetUrl($Page->getReturnUrl()) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" onclick="this.form.action.value='cancel';"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
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
    ew.addEventHandlers("main_reports");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

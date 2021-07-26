<?php

namespace PHPMaker2021\test;

// Page object
$SubRenewalRequestsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsub_renewal_requestsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fsub_renewal_requestsedit = currentForm = new ew.Form("fsub_renewal_requestsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sub_renewal_requests")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sub_renewal_requests)
        ew.vars.tables.sub_renewal_requests = currentTable;
    fsub_renewal_requestsedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["campaign_id", [fields.campaign_id.visible && fields.campaign_id.required ? ew.Validators.required(fields.campaign_id.caption) : null, ew.Validators.integer], fields.campaign_id.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null, ew.Validators.integer], fields.created_by.isInvalid],
        ["ts_created", [fields.ts_created.visible && fields.ts_created.required ? ew.Validators.required(fields.ts_created.caption) : null, ew.Validators.datetime(0)], fields.ts_created.isInvalid],
        ["ts_last_update", [fields.ts_last_update.visible && fields.ts_last_update.required ? ew.Validators.required(fields.ts_last_update.caption) : null, ew.Validators.datetime(0)], fields.ts_last_update.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsub_renewal_requestsedit,
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
    fsub_renewal_requestsedit.validate = function () {
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
    fsub_renewal_requestsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_renewal_requestsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsub_renewal_requestsedit");
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
<form name="fsub_renewal_requestsedit" id="fsub_renewal_requestsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_renewal_requests">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_sub_renewal_requests_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_sub_renewal_requests_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_renewal_requests" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->campaign_id->Visible) { // campaign_id ?>
    <div id="r_campaign_id" class="form-group row">
        <label id="elh_sub_renewal_requests_campaign_id" for="x_campaign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->campaign_id->caption() ?><?= $Page->campaign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign_id->cellAttributes() ?>>
<span id="el_sub_renewal_requests_campaign_id">
<input type="<?= $Page->campaign_id->getInputTextType() ?>" data-table="sub_renewal_requests" data-field="x_campaign_id" name="x_campaign_id" id="x_campaign_id" size="30" placeholder="<?= HtmlEncode($Page->campaign_id->getPlaceHolder()) ?>" value="<?= $Page->campaign_id->EditValue ?>"<?= $Page->campaign_id->editAttributes() ?> aria-describedby="x_campaign_id_help">
<?= $Page->campaign_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->campaign_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <div id="r_created_by" class="form-group row">
        <label id="elh_sub_renewal_requests_created_by" for="x_created_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_by->caption() ?><?= $Page->created_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_by->cellAttributes() ?>>
<span id="el_sub_renewal_requests_created_by">
<input type="<?= $Page->created_by->getInputTextType() ?>" data-table="sub_renewal_requests" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>" value="<?= $Page->created_by->EditValue ?>"<?= $Page->created_by->editAttributes() ?> aria-describedby="x_created_by_help">
<?= $Page->created_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <div id="r_ts_created" class="form-group row">
        <label id="elh_sub_renewal_requests_ts_created" for="x_ts_created" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ts_created->caption() ?><?= $Page->ts_created->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ts_created->cellAttributes() ?>>
<span id="el_sub_renewal_requests_ts_created">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="sub_renewal_requests" data-field="x_ts_created" name="x_ts_created" id="x_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?> aria-describedby="x_ts_created_help">
<?= $Page->ts_created->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_renewal_requestsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_renewal_requestsedit", "x_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ts_last_update->Visible) { // ts_last_update ?>
    <div id="r_ts_last_update" class="form-group row">
        <label id="elh_sub_renewal_requests_ts_last_update" for="x_ts_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ts_last_update->caption() ?><?= $Page->ts_last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ts_last_update->cellAttributes() ?>>
<span id="el_sub_renewal_requests_ts_last_update">
<input type="<?= $Page->ts_last_update->getInputTextType() ?>" data-table="sub_renewal_requests" data-field="x_ts_last_update" name="x_ts_last_update" id="x_ts_last_update" placeholder="<?= HtmlEncode($Page->ts_last_update->getPlaceHolder()) ?>" value="<?= $Page->ts_last_update->EditValue ?>"<?= $Page->ts_last_update->editAttributes() ?> aria-describedby="x_ts_last_update_help">
<?= $Page->ts_last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ts_last_update->getErrorMessage() ?></div>
<?php if (!$Page->ts_last_update->ReadOnly && !$Page->ts_last_update->Disabled && !isset($Page->ts_last_update->EditAttrs["readonly"]) && !isset($Page->ts_last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_renewal_requestsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_renewal_requestsedit", "x_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("sub_renewal_requests");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

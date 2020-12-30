<?php

namespace PHPMaker2021\test;

// Page object
$MainUsersAdd = &$Page;
?>
<script>
if (!ew.vars.tables.main_users) ew.vars.tables.main_users = <?= JsonEncode(GetClientVar("tables", "main_users")) ?>;
var currentForm, currentPageID;
var fmain_usersadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fmain_usersadd = currentForm = new ew.Form("fmain_usersadd", "add");

    // Add fields
    var fields = ew.vars.tables.main_users.fields;
    fmain_usersadd.addFields([
        ["name", [fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["_username", [fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
        ["_password", [fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
        ["_email", [fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
        ["user_type", [fields.user_type.required ? ew.Validators.required(fields.user_type.caption) : null], fields.user_type.isInvalid],
        ["vendor_id", [fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null], fields.vendor_id.isInvalid],
        ["reportsto", [fields.reportsto.required ? ew.Validators.required(fields.reportsto.caption) : null], fields.reportsto.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_usersadd,
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
    fmain_usersadd.validate = function () {
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
    fmain_usersadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_usersadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_usersadd.lists.user_type = <?= $Page->user_type->toClientList($Page) ?>;
    fmain_usersadd.lists.vendor_id = <?= $Page->vendor_id->toClientList($Page) ?>;
    fmain_usersadd.lists.reportsto = <?= $Page->reportsto->toClientList($Page) ?>;
    loadjs.done("fmain_usersadd");
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
<form name="fmain_usersadd" id="fmain_usersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_users">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "y_vendors") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="y_vendors">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->vendor_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_main_users_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_users_name">
<textarea data-table="main_users" data-field="x_name" name="x_name" id="x_name" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help"><?= $Page->name->EditValue ?></textarea>
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_users_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->ViewValue ?></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_name" data-hidden="1" name="x_name" id="x_name" value="<?= HtmlEncode($Page->name->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username" class="form-group row">
        <label id="elh_main_users__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_username->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_users__username">
<textarea data-table="main_users" data-field="x__username" name="x__username" id="x__username" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>"<?= $Page->_username->editAttributes() ?> aria-describedby="x__username_help"><?= $Page->_username->EditValue ?></textarea>
<?= $Page->_username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_users__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->ViewValue ?></span>
</span>
<input type="hidden" data-table="main_users" data-field="x__username" data-hidden="1" name="x__username" id="x__username" value="<?= HtmlEncode($Page->_username->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password" class="form-group row">
        <label id="elh_main_users__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_password->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_users__password">
<div class="input-group">
    <input type="password" name="x__password" id="x__password" autocomplete="new-password" data-field="x__password" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_users__password">
<span<?= $Page->_password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_password->getDisplayValue($Page->_password->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x__password" data-hidden="1" name="x__password" id="x__password" value="<?= HtmlEncode($Page->_password->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label id="elh_main_users__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="main_users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_email->getDisplayValue($Page->_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x__email" data-hidden="1" name="x__email" id="x__email" value="<?= HtmlEncode($Page->_email->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_type->Visible) { // user_type ?>
    <div id="r_user_type" class="form-group row">
        <label id="elh_main_users_user_type" for="x_user_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_type->caption() ?><?= $Page->user_type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_type->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_main_users_user_type">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->user_type->getDisplayValue($Page->user_type->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el_main_users_user_type">
    <select
        id="x_user_type"
        name="x_user_type"
        class="form-control ew-select<?= $Page->user_type->isInvalidClass() ?>"
        data-select2-id="main_users_x_user_type"
        data-table="main_users"
        data-field="x_user_type"
        data-value-separator="<?= $Page->user_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_type->getPlaceHolder()) ?>"
        <?= $Page->user_type->editAttributes() ?>>
        <?= $Page->user_type->selectOptionListHtml("x_user_type") ?>
    </select>
    <?= $Page->user_type->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->user_type->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x_user_type']"),
        options = { name: "x_user_type", selectId: "main_users_x_user_type", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.main_users.fields.user_type.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.user_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_main_users_user_type">
<span<?= $Page->user_type->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->user_type->getDisplayValue($Page->user_type->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_user_type" data-hidden="1" name="x_user_type" id="x_user_type" value="<?= HtmlEncode($Page->user_type->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
    <div id="r_vendor_id" class="form-group row">
        <label id="elh_main_users_vendor_id" for="x_vendor_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vendor_id->caption() ?><?= $Page->vendor_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->vendor_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if ($Page->vendor_id->getSessionValue() != "") { ?>
<span id="el_main_users_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_vendor_id" name="x_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_main_users_vendor_id">
    <select
        id="x_vendor_id"
        name="x_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x_vendor_id"
        data-table="main_users"
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
    var el = document.querySelector("select[data-select2-id='main_users_x_vendor_id']"),
        options = { name: "x_vendor_id", selectId: "main_users_x_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_users_vendor_id">
    <select
        id="x_vendor_id"
        name="x_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x_vendor_id"
        data-table="main_users"
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
    var el = document.querySelector("select[data-select2-id='main_users_x_vendor_id']"),
        options = { name: "x_vendor_id", selectId: "main_users_x_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_main_users_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="x_vendor_id" id="x_vendor_id" value="<?= HtmlEncode($Page->vendor_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->reportsto->Visible) { // reportsto ?>
    <div id="r_reportsto" class="form-group row">
        <label id="elh_main_users_reportsto" for="x_reportsto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->reportsto->caption() ?><?= $Page->reportsto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->reportsto->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_main_users_reportsto">
    <select
        id="x_reportsto"
        name="x_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x_reportsto") ?>
    </select>
    <?= $Page->reportsto->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x_reportsto']"),
        options = { name: "x_reportsto", selectId: "main_users_x_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_users_reportsto">
    <select
        id="x_reportsto"
        name="x_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x_reportsto") ?>
    </select>
    <?= $Page->reportsto->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x_reportsto']"),
        options = { name: "x_reportsto", selectId: "main_users_x_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_main_users_reportsto">
<span<?= $Page->reportsto->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->reportsto->getDisplayValue($Page->reportsto->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="x_reportsto" id="x_reportsto" value="<?= HtmlEncode($Page->reportsto->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("main_campaigns", explode(",", $Page->getCurrentDetailTable())) && $main_campaigns->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("main_campaigns", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MainCampaignsGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("main_users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

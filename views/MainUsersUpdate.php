<?php

namespace PHPMaker2021\test;

// Page object
$MainUsersUpdate = &$Page;
?>
<script>
if (!ew.vars.tables.main_users) ew.vars.tables.main_users = <?= JsonEncode(GetClientVar("tables", "main_users")) ?>;
var currentForm, currentPageID;
var fmain_usersupdate;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "update";
    fmain_usersupdate = currentForm = new ew.Form("fmain_usersupdate", "update");

    // Add fields
    var fields = ew.vars.tables.main_users.fields;
    fmain_usersupdate.addFields([
        ["name", [fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["_username", [fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
        ["_password", [fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
        ["_email", [fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email, ew.Validators.selected], fields._email.isInvalid],
        ["user_type", [fields.user_type.required ? ew.Validators.required(fields.user_type.caption) : null], fields.user_type.isInvalid],
        ["vendor_id", [fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null], fields.vendor_id.isInvalid],
        ["reportsto", [fields.reportsto.required ? ew.Validators.required(fields.reportsto.caption) : null], fields.reportsto.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_usersupdate,
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
    fmain_usersupdate.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        if (!ew.updateSelected(fobj)) {
            ew.alert(ew.language.phrase("NoFieldSelected"));
            return false;
        }
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
        return true;
    }

    // Form_CustomValidate
    fmain_usersupdate.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_usersupdate.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_usersupdate.lists.user_type = <?= $Page->user_type->toClientList($Page) ?>;
    fmain_usersupdate.lists.vendor_id = <?= $Page->vendor_id->toClientList($Page) ?>;
    fmain_usersupdate.lists.reportsto = <?= $Page->reportsto->toClientList($Page) ?>;
    loadjs.done("fmain_usersupdate");
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
<form name="fmain_usersupdate" id="fmain_usersupdate" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_users">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_main_usersupdate" class="ew-update-div"><!-- page -->
    <?php if (!$Page->isConfirm()) { // Confirm page ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" name="u" id="u" onclick="ew.selectAll(this);"<?= $Page->Disabled ?>><label class="custom-control-label" for="u"><?= $Language->phrase("UpdateSelectAll") ?></label>
    </div>
    <?php } ?>
<?php if ($Page->name->Visible && (!$Page->isConfirm() || $Page->name->multiUpdateSelected())) { // name ?>
    <div id="r_name" class="form-group row">
        <label for="x_name" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_name" id="u_name" class="custom-control-input ew-multi-select" value="1"<?= $Page->name->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_name"><?= $Page->name->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_name" id="u_name" value="<?= $Page->name->MultiUpdate ?>">
            <?= $Page->name->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->name->cellAttributes() ?>>
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
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible && (!$Page->isConfirm() || $Page->_username->multiUpdateSelected())) { // username ?>
    <div id="r__username" class="form-group row">
        <label for="x__username" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u__username" id="u__username" class="custom-control-input ew-multi-select" value="1"<?= $Page->_username->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u__username"><?= $Page->_username->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u__username" id="u__username" value="<?= $Page->_username->MultiUpdate ?>">
            <?= $Page->_username->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->_username->cellAttributes() ?>>
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
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible && (!$Page->isConfirm() || $Page->_password->multiUpdateSelected())) { // password ?>
    <div id="r__password" class="form-group row">
        <label for="x__password" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u__password" id="u__password" class="custom-control-input ew-multi-select" value="1"<?= $Page->_password->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u__password"><?= $Page->_password->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u__password" id="u__password" value="<?= $Page->_password->MultiUpdate ?>">
            <?= $Page->_password->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->_password->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_main_users__password">
                <div class="input-group">
                    <input type="password" name="x__password" id="x__password" autocomplete="new-password" data-field="x__password" value="<?= $Page->_password->EditValue ?>" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
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
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible && (!$Page->isConfirm() || $Page->_email->multiUpdateSelected())) { // email ?>
    <div id="r__email" class="form-group row">
        <label for="x__email" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u__email" id="u__email" class="custom-control-input ew-multi-select" value="1"<?= $Page->_email->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u__email"><?= $Page->_email->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u__email" id="u__email" value="<?= $Page->_email->MultiUpdate ?>">
            <?= $Page->_email->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->_email->cellAttributes() ?>>
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
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->user_type->Visible && (!$Page->isConfirm() || $Page->user_type->multiUpdateSelected())) { // user_type ?>
    <div id="r_user_type" class="form-group row">
        <label for="x_user_type" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_user_type" id="u_user_type" class="custom-control-input ew-multi-select" value="1"<?= $Page->user_type->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_user_type"><?= $Page->user_type->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_user_type" id="u_user_type" value="<?= $Page->user_type->MultiUpdate ?>">
            <?= $Page->user_type->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->user_type->cellAttributes() ?>>
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
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->vendor_id->Visible && (!$Page->isConfirm() || $Page->vendor_id->multiUpdateSelected())) { // vendor_id ?>
    <div id="r_vendor_id" class="form-group row">
        <label for="x_vendor_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_vendor_id" id="u_vendor_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->vendor_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_vendor_id"><?= $Page->vendor_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_vendor_id" id="u_vendor_id" value="<?= $Page->vendor_id->MultiUpdate ?>">
            <?= $Page->vendor_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->vendor_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <?php if ($Page->vendor_id->getSessionValue() != "") { ?>
                <span id="el_main_users_vendor_id">
                <span<?= $Page->vendor_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" id="x_vendor_id" name="x_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>" data-hidden="1">
                <?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("update")) { // Non system admin ?>
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
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->reportsto->Visible && (!$Page->isConfirm() || $Page->reportsto->multiUpdateSelected())) { // reportsto ?>
    <div id="r_reportsto" class="form-group row">
        <label for="x_reportsto" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_reportsto" id="u_reportsto" class="custom-control-input ew-multi-select" value="1"<?= $Page->reportsto->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_reportsto"><?= $Page->reportsto->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_reportsto" id="u_reportsto" value="<?= $Page->reportsto->MultiUpdate ?>">
            <?= $Page->reportsto->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->reportsto->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
                <?php if (SameString($Page->vendor_id->CurrentValue, CurrentUserID())) { ?>
                    <span id="el_main_users_reportsto">
                    <span<?= $Page->reportsto->viewAttributes() ?>>
                    <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->reportsto->getDisplayValue($Page->reportsto->EditValue))) ?>"></span>
                    </span>
                    <input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="x_reportsto" id="x_reportsto" value="<?= HtmlEncode($Page->reportsto->CurrentValue) ?>">
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
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page -->
<?php if (!$Page->IsModal) { ?>
    <div class="form-group row"><!-- buttons .form-group -->
        <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?= $Language->phrase("UpdateBtn") ?></button>
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
    ew.addEventHandlers("main_users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

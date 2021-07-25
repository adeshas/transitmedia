<?php

namespace PHPMaker2021\test;

// Page object
$YOperatorsUpdate = &$Page;
?>
<script>
var currentForm, currentPageID;
var fy_operatorsupdate;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "update";
    fy_operatorsupdate = currentForm = new ew.Form("fy_operatorsupdate", "update");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "y_operators")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.y_operators)
        ew.vars.tables.y_operators = currentTable;
    fy_operatorsupdate.addFields([
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["shortname", [fields.shortname.visible && fields.shortname.required ? ew.Validators.required(fields.shortname.caption) : null], fields.shortname.isInvalid],
        ["platform_id", [fields.platform_id.visible && fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["contact_name", [fields.contact_name.visible && fields.contact_name.required ? ew.Validators.required(fields.contact_name.caption) : null], fields.contact_name.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fy_operatorsupdate,
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
    fy_operatorsupdate.validate = function () {
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
    fy_operatorsupdate.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fy_operatorsupdate.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fy_operatorsupdate.lists.platform_id = <?= $Page->platform_id->toClientList($Page) ?>;
    loadjs.done("fy_operatorsupdate");
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
<form name="fy_operatorsupdate" id="fy_operatorsupdate" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="y_operators">
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
<div id="tbl_y_operatorsupdate" class="ew-update-div"><!-- page -->
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
                <span id="el_y_operators_name">
                <input type="<?= $Page->name->getInputTextType() ?>" data-table="y_operators" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
                <?= $Page->name->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_y_operators_name">
                <span<?= $Page->name->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->name->getDisplayValue($Page->name->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="y_operators" data-field="x_name" data-hidden="1" name="x_name" id="x_name" value="<?= HtmlEncode($Page->name->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->shortname->Visible && (!$Page->isConfirm() || $Page->shortname->multiUpdateSelected())) { // shortname ?>
    <div id="r_shortname" class="form-group row">
        <label for="x_shortname" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_shortname" id="u_shortname" class="custom-control-input ew-multi-select" value="1"<?= $Page->shortname->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_shortname"><?= $Page->shortname->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_shortname" id="u_shortname" value="<?= $Page->shortname->MultiUpdate ?>">
            <?= $Page->shortname->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->shortname->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_y_operators_shortname">
                <input type="<?= $Page->shortname->getInputTextType() ?>" data-table="y_operators" data-field="x_shortname" name="x_shortname" id="x_shortname" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->shortname->getPlaceHolder()) ?>" value="<?= $Page->shortname->EditValue ?>"<?= $Page->shortname->editAttributes() ?> aria-describedby="x_shortname_help">
                <?= $Page->shortname->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->shortname->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_y_operators_shortname">
                <span<?= $Page->shortname->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->shortname->getDisplayValue($Page->shortname->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="y_operators" data-field="x_shortname" data-hidden="1" name="x_shortname" id="x_shortname" value="<?= HtmlEncode($Page->shortname->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->platform_id->Visible && (!$Page->isConfirm() || $Page->platform_id->multiUpdateSelected())) { // platform_id ?>
    <div id="r_platform_id" class="form-group row">
        <label for="x_platform_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_platform_id" id="u_platform_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->platform_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_platform_id"><?= $Page->platform_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_platform_id" id="u_platform_id" value="<?= $Page->platform_id->MultiUpdate ?>">
            <?= $Page->platform_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->platform_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <?php if ($Page->platform_id->getSessionValue() != "") { ?>
                <span id="el_y_operators_platform_id">
                <span<?= $Page->platform_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->platform_id->getDisplayValue($Page->platform_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" id="x_platform_id" name="x_platform_id" value="<?= HtmlEncode($Page->platform_id->CurrentValue) ?>" data-hidden="1">
                <?php } else { ?>
                <span id="el_y_operators_platform_id">
                    <select
                        id="x_platform_id"
                        name="x_platform_id"
                        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
                        data-select2-id="y_operators_x_platform_id"
                        data-table="y_operators"
                        data-field="x_platform_id"
                        data-value-separator="<?= $Page->platform_id->displayValueSeparatorAttribute() ?>"
                        data-placeholder="<?= HtmlEncode($Page->platform_id->getPlaceHolder()) ?>"
                        <?= $Page->platform_id->editAttributes() ?>>
                        <?= $Page->platform_id->selectOptionListHtml("x_platform_id") ?>
                    </select>
                    <?= $Page->platform_id->getCustomMessage() ?>
                    <div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage() ?></div>
                <?= $Page->platform_id->Lookup->getParamTag($Page, "p_x_platform_id") ?>
                <script>
                loadjs.ready("head", function() {
                    var el = document.querySelector("select[data-select2-id='y_operators_x_platform_id']"),
                        options = { name: "x_platform_id", selectId: "y_operators_x_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.y_operators.fields.platform_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } ?>
                <?php } else { ?>
                <span id="el_y_operators_platform_id">
                <span<?= $Page->platform_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->platform_id->getDisplayValue($Page->platform_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="y_operators" data-field="x_platform_id" data-hidden="1" name="x_platform_id" id="x_platform_id" value="<?= HtmlEncode($Page->platform_id->FormValue) ?>">
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
                <span id="el_y_operators__email">
                <input type="<?= $Page->_email->getInputTextType() ?>" data-table="y_operators" data-field="x__email" name="x__email" id="x__email" size="30" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
                <?= $Page->_email->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_y_operators__email">
                <span<?= $Page->_email->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_email->getDisplayValue($Page->_email->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="y_operators" data-field="x__email" data-hidden="1" name="x__email" id="x__email" value="<?= HtmlEncode($Page->_email->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->contact_name->Visible && (!$Page->isConfirm() || $Page->contact_name->multiUpdateSelected())) { // contact_name ?>
    <div id="r_contact_name" class="form-group row">
        <label for="x_contact_name" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_contact_name" id="u_contact_name" class="custom-control-input ew-multi-select" value="1"<?= $Page->contact_name->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_contact_name"><?= $Page->contact_name->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_contact_name" id="u_contact_name" value="<?= $Page->contact_name->MultiUpdate ?>">
            <?= $Page->contact_name->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->contact_name->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_y_operators_contact_name">
                <input type="<?= $Page->contact_name->getInputTextType() ?>" data-table="y_operators" data-field="x_contact_name" name="x_contact_name" id="x_contact_name" size="30" placeholder="<?= HtmlEncode($Page->contact_name->getPlaceHolder()) ?>" value="<?= $Page->contact_name->EditValue ?>"<?= $Page->contact_name->editAttributes() ?> aria-describedby="x_contact_name_help">
                <?= $Page->contact_name->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->contact_name->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_y_operators_contact_name">
                <span<?= $Page->contact_name->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->contact_name->getDisplayValue($Page->contact_name->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="y_operators" data-field="x_contact_name" data-hidden="1" name="x_contact_name" id="x_contact_name" value="<?= HtmlEncode($Page->contact_name->FormValue) ?>">
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
    ew.addEventHandlers("y_operators");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

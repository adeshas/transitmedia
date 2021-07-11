<?php

namespace PHPMaker2021\test;

// Page object
$ZPriceSettingsUpdate = &$Page;
?>
<script>
if (!ew.vars.tables.z_price_settings) ew.vars.tables.z_price_settings = <?= JsonEncode(GetClientVar("tables", "z_price_settings")) ?>;
var currentForm, currentPageID;
var fz_price_settingsupdate;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "update";
    fz_price_settingsupdate = currentForm = new ew.Form("fz_price_settingsupdate", "update");

    // Add fields
    var fields = ew.vars.tables.z_price_settings.fields;
    fz_price_settingsupdate.addFields([
        ["platform_id", [fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid],
        ["inventory_id", [fields.inventory_id.required ? ew.Validators.required(fields.inventory_id.caption) : null], fields.inventory_id.isInvalid],
        ["print_stage_id", [fields.print_stage_id.required ? ew.Validators.required(fields.print_stage_id.caption) : null], fields.print_stage_id.isInvalid],
        ["bus_size_id", [fields.bus_size_id.required ? ew.Validators.required(fields.bus_size_id.caption) : null], fields.bus_size_id.isInvalid],
        ["details", [fields.details.required ? ew.Validators.required(fields.details.caption) : null], fields.details.isInvalid],
        ["max_limit", [fields.max_limit.required ? ew.Validators.required(fields.max_limit.caption) : null, ew.Validators.integer, ew.Validators.selected], fields.max_limit.isInvalid],
        ["min_limit", [fields.min_limit.required ? ew.Validators.required(fields.min_limit.caption) : null, ew.Validators.integer, ew.Validators.selected], fields.min_limit.isInvalid],
        ["price", [fields.price.required ? ew.Validators.required(fields.price.caption) : null, ew.Validators.integer, ew.Validators.selected], fields.price.isInvalid],
        ["operator_fee", [fields.operator_fee.required ? ew.Validators.required(fields.operator_fee.caption) : null, ew.Validators.integer, ew.Validators.selected], fields.operator_fee.isInvalid],
        ["agency_fee", [fields.agency_fee.required ? ew.Validators.required(fields.agency_fee.caption) : null, ew.Validators.integer, ew.Validators.selected], fields.agency_fee.isInvalid],
        ["lamata_fee", [fields.lamata_fee.required ? ew.Validators.required(fields.lamata_fee.caption) : null, ew.Validators.integer, ew.Validators.selected], fields.lamata_fee.isInvalid],
        ["lasaa_fee", [fields.lasaa_fee.required ? ew.Validators.required(fields.lasaa_fee.caption) : null, ew.Validators.integer, ew.Validators.selected], fields.lasaa_fee.isInvalid],
        ["printers_fee", [fields.printers_fee.required ? ew.Validators.required(fields.printers_fee.caption) : null, ew.Validators.integer, ew.Validators.selected], fields.printers_fee.isInvalid],
        ["active", [fields.active.required ? ew.Validators.required(fields.active.caption) : null], fields.active.isInvalid],
        ["ts_created", [fields.ts_created.required ? ew.Validators.required(fields.ts_created.caption) : null, ew.Validators.datetime(0), ew.Validators.selected], fields.ts_created.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fz_price_settingsupdate,
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
    fz_price_settingsupdate.validate = function () {
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
    fz_price_settingsupdate.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fz_price_settingsupdate.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fz_price_settingsupdate.lists.platform_id = <?= $Page->platform_id->toClientList($Page) ?>;
    fz_price_settingsupdate.lists.inventory_id = <?= $Page->inventory_id->toClientList($Page) ?>;
    fz_price_settingsupdate.lists.print_stage_id = <?= $Page->print_stage_id->toClientList($Page) ?>;
    fz_price_settingsupdate.lists.bus_size_id = <?= $Page->bus_size_id->toClientList($Page) ?>;
    fz_price_settingsupdate.lists.active = <?= $Page->active->toClientList($Page) ?>;
    loadjs.done("fz_price_settingsupdate");
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
<form name="fz_price_settingsupdate" id="fz_price_settingsupdate" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="z_price_settings">
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
<div id="tbl_z_price_settingsupdate" class="ew-update-div"><!-- page -->
    <?php if (!$Page->isConfirm()) { // Confirm page ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" name="u" id="u" onclick="ew.selectAll(this);"<?= $Page->Disabled ?>><label class="custom-control-label" for="u"><?= $Language->phrase("UpdateSelectAll") ?></label>
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
                <span id="el_z_price_settings_platform_id">
                    <select
                        id="x_platform_id"
                        name="x_platform_id"
                        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
                        data-select2-id="z_price_settings_x_platform_id"
                        data-table="z_price_settings"
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
                    var el = document.querySelector("select[data-select2-id='z_price_settings_x_platform_id']"),
                        options = { name: "x_platform_id", selectId: "z_price_settings_x_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.z_price_settings.fields.platform_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_platform_id">
                <span<?= $Page->platform_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->platform_id->getDisplayValue($Page->platform_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_platform_id" data-hidden="1" name="x_platform_id" id="x_platform_id" value="<?= HtmlEncode($Page->platform_id->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->inventory_id->Visible && (!$Page->isConfirm() || $Page->inventory_id->multiUpdateSelected())) { // inventory_id ?>
    <div id="r_inventory_id" class="form-group row">
        <label for="x_inventory_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_inventory_id" id="u_inventory_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->inventory_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_inventory_id"><?= $Page->inventory_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_inventory_id" id="u_inventory_id" value="<?= $Page->inventory_id->MultiUpdate ?>">
            <?= $Page->inventory_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->inventory_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_inventory_id">
                    <select
                        id="x_inventory_id"
                        name="x_inventory_id"
                        class="form-control ew-select<?= $Page->inventory_id->isInvalidClass() ?>"
                        data-select2-id="z_price_settings_x_inventory_id"
                        data-table="z_price_settings"
                        data-field="x_inventory_id"
                        data-value-separator="<?= $Page->inventory_id->displayValueSeparatorAttribute() ?>"
                        data-placeholder="<?= HtmlEncode($Page->inventory_id->getPlaceHolder()) ?>"
                        <?= $Page->inventory_id->editAttributes() ?>>
                        <?= $Page->inventory_id->selectOptionListHtml("x_inventory_id") ?>
                    </select>
                    <?= $Page->inventory_id->getCustomMessage() ?>
                    <div class="invalid-feedback"><?= $Page->inventory_id->getErrorMessage() ?></div>
                <?= $Page->inventory_id->Lookup->getParamTag($Page, "p_x_inventory_id") ?>
                <script>
                loadjs.ready("head", function() {
                    var el = document.querySelector("select[data-select2-id='z_price_settings_x_inventory_id']"),
                        options = { name: "x_inventory_id", selectId: "z_price_settings_x_inventory_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.z_price_settings.fields.inventory_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_inventory_id">
                <span<?= $Page->inventory_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->inventory_id->getDisplayValue($Page->inventory_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_inventory_id" data-hidden="1" name="x_inventory_id" id="x_inventory_id" value="<?= HtmlEncode($Page->inventory_id->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->print_stage_id->Visible && (!$Page->isConfirm() || $Page->print_stage_id->multiUpdateSelected())) { // print_stage_id ?>
    <div id="r_print_stage_id" class="form-group row">
        <label for="x_print_stage_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_print_stage_id" id="u_print_stage_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->print_stage_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_print_stage_id"><?= $Page->print_stage_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_print_stage_id" id="u_print_stage_id" value="<?= $Page->print_stage_id->MultiUpdate ?>">
            <?= $Page->print_stage_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->print_stage_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_print_stage_id">
                    <select
                        id="x_print_stage_id"
                        name="x_print_stage_id"
                        class="form-control ew-select<?= $Page->print_stage_id->isInvalidClass() ?>"
                        data-select2-id="z_price_settings_x_print_stage_id"
                        data-table="z_price_settings"
                        data-field="x_print_stage_id"
                        data-value-separator="<?= $Page->print_stage_id->displayValueSeparatorAttribute() ?>"
                        data-placeholder="<?= HtmlEncode($Page->print_stage_id->getPlaceHolder()) ?>"
                        <?= $Page->print_stage_id->editAttributes() ?>>
                        <?= $Page->print_stage_id->selectOptionListHtml("x_print_stage_id") ?>
                    </select>
                    <?= $Page->print_stage_id->getCustomMessage() ?>
                    <div class="invalid-feedback"><?= $Page->print_stage_id->getErrorMessage() ?></div>
                <?= $Page->print_stage_id->Lookup->getParamTag($Page, "p_x_print_stage_id") ?>
                <script>
                loadjs.ready("head", function() {
                    var el = document.querySelector("select[data-select2-id='z_price_settings_x_print_stage_id']"),
                        options = { name: "x_print_stage_id", selectId: "z_price_settings_x_print_stage_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.z_price_settings.fields.print_stage_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_print_stage_id">
                <span<?= $Page->print_stage_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->print_stage_id->getDisplayValue($Page->print_stage_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_print_stage_id" data-hidden="1" name="x_print_stage_id" id="x_print_stage_id" value="<?= HtmlEncode($Page->print_stage_id->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->bus_size_id->Visible && (!$Page->isConfirm() || $Page->bus_size_id->multiUpdateSelected())) { // bus_size_id ?>
    <div id="r_bus_size_id" class="form-group row">
        <label for="x_bus_size_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_bus_size_id" id="u_bus_size_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->bus_size_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_bus_size_id"><?= $Page->bus_size_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_bus_size_id" id="u_bus_size_id" value="<?= $Page->bus_size_id->MultiUpdate ?>">
            <?= $Page->bus_size_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->bus_size_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_bus_size_id">
                    <select
                        id="x_bus_size_id"
                        name="x_bus_size_id"
                        class="form-control ew-select<?= $Page->bus_size_id->isInvalidClass() ?>"
                        data-select2-id="z_price_settings_x_bus_size_id"
                        data-table="z_price_settings"
                        data-field="x_bus_size_id"
                        data-value-separator="<?= $Page->bus_size_id->displayValueSeparatorAttribute() ?>"
                        data-placeholder="<?= HtmlEncode($Page->bus_size_id->getPlaceHolder()) ?>"
                        <?= $Page->bus_size_id->editAttributes() ?>>
                        <?= $Page->bus_size_id->selectOptionListHtml("x_bus_size_id") ?>
                    </select>
                    <?= $Page->bus_size_id->getCustomMessage() ?>
                    <div class="invalid-feedback"><?= $Page->bus_size_id->getErrorMessage() ?></div>
                <?= $Page->bus_size_id->Lookup->getParamTag($Page, "p_x_bus_size_id") ?>
                <script>
                loadjs.ready("head", function() {
                    var el = document.querySelector("select[data-select2-id='z_price_settings_x_bus_size_id']"),
                        options = { name: "x_bus_size_id", selectId: "z_price_settings_x_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.z_price_settings.fields.bus_size_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_bus_size_id">
                <span<?= $Page->bus_size_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_size_id->getDisplayValue($Page->bus_size_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_bus_size_id" data-hidden="1" name="x_bus_size_id" id="x_bus_size_id" value="<?= HtmlEncode($Page->bus_size_id->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->details->Visible && (!$Page->isConfirm() || $Page->details->multiUpdateSelected())) { // details ?>
    <div id="r_details" class="form-group row">
        <label for="x_details" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_details" id="u_details" class="custom-control-input ew-multi-select" value="1"<?= $Page->details->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_details"><?= $Page->details->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_details" id="u_details" value="<?= $Page->details->MultiUpdate ?>">
            <?= $Page->details->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->details->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_details">
                <textarea data-table="z_price_settings" data-field="x_details" name="x_details" id="x_details" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->details->getPlaceHolder()) ?>"<?= $Page->details->editAttributes() ?> aria-describedby="x_details_help"><?= $Page->details->EditValue ?></textarea>
                <?= $Page->details->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->details->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_details">
                <span<?= $Page->details->viewAttributes() ?>>
                <?= $Page->details->ViewValue ?></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_details" data-hidden="1" name="x_details" id="x_details" value="<?= HtmlEncode($Page->details->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->max_limit->Visible && (!$Page->isConfirm() || $Page->max_limit->multiUpdateSelected())) { // max_limit ?>
    <div id="r_max_limit" class="form-group row">
        <label for="x_max_limit" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_max_limit" id="u_max_limit" class="custom-control-input ew-multi-select" value="1"<?= $Page->max_limit->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_max_limit"><?= $Page->max_limit->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_max_limit" id="u_max_limit" value="<?= $Page->max_limit->MultiUpdate ?>">
            <?= $Page->max_limit->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->max_limit->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_max_limit">
                <input type="<?= $Page->max_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_max_limit" name="x_max_limit" id="x_max_limit" size="30" placeholder="<?= HtmlEncode($Page->max_limit->getPlaceHolder()) ?>" value="<?= $Page->max_limit->EditValue ?>"<?= $Page->max_limit->editAttributes() ?> aria-describedby="x_max_limit_help">
                <?= $Page->max_limit->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->max_limit->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_max_limit">
                <span<?= $Page->max_limit->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->max_limit->getDisplayValue($Page->max_limit->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_max_limit" data-hidden="1" name="x_max_limit" id="x_max_limit" value="<?= HtmlEncode($Page->max_limit->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->min_limit->Visible && (!$Page->isConfirm() || $Page->min_limit->multiUpdateSelected())) { // min_limit ?>
    <div id="r_min_limit" class="form-group row">
        <label for="x_min_limit" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_min_limit" id="u_min_limit" class="custom-control-input ew-multi-select" value="1"<?= $Page->min_limit->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_min_limit"><?= $Page->min_limit->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_min_limit" id="u_min_limit" value="<?= $Page->min_limit->MultiUpdate ?>">
            <?= $Page->min_limit->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->min_limit->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_min_limit">
                <input type="<?= $Page->min_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_min_limit" name="x_min_limit" id="x_min_limit" size="30" placeholder="<?= HtmlEncode($Page->min_limit->getPlaceHolder()) ?>" value="<?= $Page->min_limit->EditValue ?>"<?= $Page->min_limit->editAttributes() ?> aria-describedby="x_min_limit_help">
                <?= $Page->min_limit->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->min_limit->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_min_limit">
                <span<?= $Page->min_limit->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->min_limit->getDisplayValue($Page->min_limit->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_min_limit" data-hidden="1" name="x_min_limit" id="x_min_limit" value="<?= HtmlEncode($Page->min_limit->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->price->Visible && (!$Page->isConfirm() || $Page->price->multiUpdateSelected())) { // price ?>
    <div id="r_price" class="form-group row">
        <label for="x_price" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_price" id="u_price" class="custom-control-input ew-multi-select" value="1"<?= $Page->price->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_price"><?= $Page->price->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_price" id="u_price" value="<?= $Page->price->MultiUpdate ?>">
            <?= $Page->price->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->price->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_price">
                <input type="<?= $Page->price->getInputTextType() ?>" data-table="z_price_settings" data-field="x_price" name="x_price" id="x_price" size="30" placeholder="<?= HtmlEncode($Page->price->getPlaceHolder()) ?>" value="<?= $Page->price->EditValue ?>"<?= $Page->price->editAttributes() ?> aria-describedby="x_price_help">
                <?= $Page->price->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->price->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_price">
                <span<?= $Page->price->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->price->getDisplayValue($Page->price->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_price" data-hidden="1" name="x_price" id="x_price" value="<?= HtmlEncode($Page->price->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->operator_fee->Visible && (!$Page->isConfirm() || $Page->operator_fee->multiUpdateSelected())) { // operator_fee ?>
    <div id="r_operator_fee" class="form-group row">
        <label for="x_operator_fee" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_operator_fee" id="u_operator_fee" class="custom-control-input ew-multi-select" value="1"<?= $Page->operator_fee->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_operator_fee"><?= $Page->operator_fee->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_operator_fee" id="u_operator_fee" value="<?= $Page->operator_fee->MultiUpdate ?>">
            <?= $Page->operator_fee->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->operator_fee->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_operator_fee">
                <input type="<?= $Page->operator_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_operator_fee" name="x_operator_fee" id="x_operator_fee" size="30" placeholder="<?= HtmlEncode($Page->operator_fee->getPlaceHolder()) ?>" value="<?= $Page->operator_fee->EditValue ?>"<?= $Page->operator_fee->editAttributes() ?> aria-describedby="x_operator_fee_help">
                <?= $Page->operator_fee->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->operator_fee->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_operator_fee">
                <span<?= $Page->operator_fee->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->operator_fee->getDisplayValue($Page->operator_fee->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_operator_fee" data-hidden="1" name="x_operator_fee" id="x_operator_fee" value="<?= HtmlEncode($Page->operator_fee->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->agency_fee->Visible && (!$Page->isConfirm() || $Page->agency_fee->multiUpdateSelected())) { // agency_fee ?>
    <div id="r_agency_fee" class="form-group row">
        <label for="x_agency_fee" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_agency_fee" id="u_agency_fee" class="custom-control-input ew-multi-select" value="1"<?= $Page->agency_fee->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_agency_fee"><?= $Page->agency_fee->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_agency_fee" id="u_agency_fee" value="<?= $Page->agency_fee->MultiUpdate ?>">
            <?= $Page->agency_fee->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->agency_fee->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_agency_fee">
                <input type="<?= $Page->agency_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_agency_fee" name="x_agency_fee" id="x_agency_fee" size="30" placeholder="<?= HtmlEncode($Page->agency_fee->getPlaceHolder()) ?>" value="<?= $Page->agency_fee->EditValue ?>"<?= $Page->agency_fee->editAttributes() ?> aria-describedby="x_agency_fee_help">
                <?= $Page->agency_fee->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->agency_fee->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_agency_fee">
                <span<?= $Page->agency_fee->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->agency_fee->getDisplayValue($Page->agency_fee->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_agency_fee" data-hidden="1" name="x_agency_fee" id="x_agency_fee" value="<?= HtmlEncode($Page->agency_fee->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->lamata_fee->Visible && (!$Page->isConfirm() || $Page->lamata_fee->multiUpdateSelected())) { // lamata_fee ?>
    <div id="r_lamata_fee" class="form-group row">
        <label for="x_lamata_fee" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_lamata_fee" id="u_lamata_fee" class="custom-control-input ew-multi-select" value="1"<?= $Page->lamata_fee->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_lamata_fee"><?= $Page->lamata_fee->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_lamata_fee" id="u_lamata_fee" value="<?= $Page->lamata_fee->MultiUpdate ?>">
            <?= $Page->lamata_fee->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->lamata_fee->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_lamata_fee">
                <input type="<?= $Page->lamata_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lamata_fee" name="x_lamata_fee" id="x_lamata_fee" size="30" placeholder="<?= HtmlEncode($Page->lamata_fee->getPlaceHolder()) ?>" value="<?= $Page->lamata_fee->EditValue ?>"<?= $Page->lamata_fee->editAttributes() ?> aria-describedby="x_lamata_fee_help">
                <?= $Page->lamata_fee->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->lamata_fee->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_lamata_fee">
                <span<?= $Page->lamata_fee->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->lamata_fee->getDisplayValue($Page->lamata_fee->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_lamata_fee" data-hidden="1" name="x_lamata_fee" id="x_lamata_fee" value="<?= HtmlEncode($Page->lamata_fee->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->lasaa_fee->Visible && (!$Page->isConfirm() || $Page->lasaa_fee->multiUpdateSelected())) { // lasaa_fee ?>
    <div id="r_lasaa_fee" class="form-group row">
        <label for="x_lasaa_fee" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_lasaa_fee" id="u_lasaa_fee" class="custom-control-input ew-multi-select" value="1"<?= $Page->lasaa_fee->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_lasaa_fee"><?= $Page->lasaa_fee->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_lasaa_fee" id="u_lasaa_fee" value="<?= $Page->lasaa_fee->MultiUpdate ?>">
            <?= $Page->lasaa_fee->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->lasaa_fee->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_lasaa_fee">
                <input type="<?= $Page->lasaa_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lasaa_fee" name="x_lasaa_fee" id="x_lasaa_fee" size="30" placeholder="<?= HtmlEncode($Page->lasaa_fee->getPlaceHolder()) ?>" value="<?= $Page->lasaa_fee->EditValue ?>"<?= $Page->lasaa_fee->editAttributes() ?> aria-describedby="x_lasaa_fee_help">
                <?= $Page->lasaa_fee->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->lasaa_fee->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_lasaa_fee">
                <span<?= $Page->lasaa_fee->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->lasaa_fee->getDisplayValue($Page->lasaa_fee->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_lasaa_fee" data-hidden="1" name="x_lasaa_fee" id="x_lasaa_fee" value="<?= HtmlEncode($Page->lasaa_fee->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->printers_fee->Visible && (!$Page->isConfirm() || $Page->printers_fee->multiUpdateSelected())) { // printers_fee ?>
    <div id="r_printers_fee" class="form-group row">
        <label for="x_printers_fee" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_printers_fee" id="u_printers_fee" class="custom-control-input ew-multi-select" value="1"<?= $Page->printers_fee->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_printers_fee"><?= $Page->printers_fee->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_printers_fee" id="u_printers_fee" value="<?= $Page->printers_fee->MultiUpdate ?>">
            <?= $Page->printers_fee->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->printers_fee->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_printers_fee">
                <input type="<?= $Page->printers_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_printers_fee" name="x_printers_fee" id="x_printers_fee" size="30" placeholder="<?= HtmlEncode($Page->printers_fee->getPlaceHolder()) ?>" value="<?= $Page->printers_fee->EditValue ?>"<?= $Page->printers_fee->editAttributes() ?> aria-describedby="x_printers_fee_help">
                <?= $Page->printers_fee->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->printers_fee->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_printers_fee">
                <span<?= $Page->printers_fee->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->printers_fee->getDisplayValue($Page->printers_fee->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_printers_fee" data-hidden="1" name="x_printers_fee" id="x_printers_fee" value="<?= HtmlEncode($Page->printers_fee->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->active->Visible && (!$Page->isConfirm() || $Page->active->multiUpdateSelected())) { // active ?>
    <div id="r_active" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_active" id="u_active" class="custom-control-input ew-multi-select" value="1"<?= $Page->active->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_active"><?= $Page->active->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_active" id="u_active" value="<?= $Page->active->MultiUpdate ?>">
            <?= $Page->active->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->active->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_active">
                <div class="custom-control custom-checkbox d-inline-block">
                    <input type="checkbox" class="custom-control-input<?= $Page->active->isInvalidClass() ?>" data-table="z_price_settings" data-field="x_active" name="x_active[]" id="x_active_338245" value="1"<?= ConvertToBool($Page->active->CurrentValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?> aria-describedby="x_active_help">
                    <label class="custom-control-label" for="x_active_338245"></label>
                </div>
                <?= $Page->active->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_active">
                <span<?= $Page->active->viewAttributes() ?>>
                <div class="custom-control custom-checkbox d-inline-block">
                    <input type="checkbox" id="x_active_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->active->ViewValue ?>" disabled<?php if (ConvertToBool($Page->active->CurrentValue)) { ?> checked<?php } ?>>
                    <label class="custom-control-label" for="x_active_<?= $Page->RowCount ?>"></label>
                </div></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_active" data-hidden="1" name="x_active" id="x_active" value="<?= HtmlEncode($Page->active->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->ts_created->Visible && (!$Page->isConfirm() || $Page->ts_created->multiUpdateSelected())) { // ts_created ?>
    <div id="r_ts_created" class="form-group row">
        <label for="x_ts_created" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_ts_created" id="u_ts_created" class="custom-control-input ew-multi-select" value="1"<?= $Page->ts_created->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_ts_created"><?= $Page->ts_created->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_ts_created" id="u_ts_created" value="<?= $Page->ts_created->MultiUpdate ?>">
            <?= $Page->ts_created->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->ts_created->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_z_price_settings_ts_created">
                <input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="z_price_settings" data-field="x_ts_created" name="x_ts_created" id="x_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?> aria-describedby="x_ts_created_help">
                <?= $Page->ts_created->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
                <?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
                <script>
                loadjs.ready(["fz_price_settingsupdate", "datetimepicker"], function() {
                    ew.createDateTimePicker("fz_price_settingsupdate", "x_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
                });
                </script>
                <?php } ?>
                </span>
                <?php } else { ?>
                <span id="el_z_price_settings_ts_created">
                <span<?= $Page->ts_created->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ts_created->getDisplayValue($Page->ts_created->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="z_price_settings" data-field="x_ts_created" data-hidden="1" name="x_ts_created" id="x_ts_created" value="<?= HtmlEncode($Page->ts_created->FormValue) ?>">
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
    ew.addEventHandlers("z_price_settings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

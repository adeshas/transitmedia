<?php

namespace PHPMaker2021\test;

// Page object
$MainBusesUpdate = &$Page;
?>
<script>
if (!ew.vars.tables.main_buses) ew.vars.tables.main_buses = <?= JsonEncode(GetClientVar("tables", "main_buses")) ?>;
var currentForm, currentPageID;
var fmain_busesupdate;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "update";
    fmain_busesupdate = currentForm = new ew.Form("fmain_busesupdate", "update");

    // Add fields
    var fields = ew.vars.tables.main_buses.fields;
    fmain_busesupdate.addFields([
        ["number", [fields.number.required ? ew.Validators.required(fields.number.caption) : null], fields.number.isInvalid],
        ["platform_id", [fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid],
        ["operator_id", [fields.operator_id.required ? ew.Validators.required(fields.operator_id.caption) : null], fields.operator_id.isInvalid],
        ["exterior_campaign_id", [fields.exterior_campaign_id.required ? ew.Validators.required(fields.exterior_campaign_id.caption) : null], fields.exterior_campaign_id.isInvalid],
        ["interior_campaign_id", [fields.interior_campaign_id.required ? ew.Validators.required(fields.interior_campaign_id.caption) : null], fields.interior_campaign_id.isInvalid],
        ["bus_status_id", [fields.bus_status_id.required ? ew.Validators.required(fields.bus_status_id.caption) : null], fields.bus_status_id.isInvalid],
        ["bus_size_id", [fields.bus_size_id.required ? ew.Validators.required(fields.bus_size_id.caption) : null], fields.bus_size_id.isInvalid],
        ["bus_depot_id", [fields.bus_depot_id.required ? ew.Validators.required(fields.bus_depot_id.caption) : null], fields.bus_depot_id.isInvalid],
        ["ts_created", [fields.ts_created.required ? ew.Validators.required(fields.ts_created.caption) : null, ew.Validators.datetime(0), ew.Validators.selected], fields.ts_created.isInvalid],
        ["ts_last_update", [fields.ts_last_update.required ? ew.Validators.required(fields.ts_last_update.caption) : null, ew.Validators.datetime(0), ew.Validators.selected], fields.ts_last_update.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_busesupdate,
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
    fmain_busesupdate.validate = function () {
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
    fmain_busesupdate.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_busesupdate.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_busesupdate.lists.platform_id = <?= $Page->platform_id->toClientList($Page) ?>;
    fmain_busesupdate.lists.operator_id = <?= $Page->operator_id->toClientList($Page) ?>;
    fmain_busesupdate.lists.exterior_campaign_id = <?= $Page->exterior_campaign_id->toClientList($Page) ?>;
    fmain_busesupdate.lists.interior_campaign_id = <?= $Page->interior_campaign_id->toClientList($Page) ?>;
    fmain_busesupdate.lists.bus_status_id = <?= $Page->bus_status_id->toClientList($Page) ?>;
    fmain_busesupdate.lists.bus_size_id = <?= $Page->bus_size_id->toClientList($Page) ?>;
    fmain_busesupdate.lists.bus_depot_id = <?= $Page->bus_depot_id->toClientList($Page) ?>;
    loadjs.done("fmain_busesupdate");
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
<form name="fmain_busesupdate" id="fmain_busesupdate" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_buses">
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
<div id="tbl_main_busesupdate" class="ew-update-div"><!-- page -->
    <?php if (!$Page->isConfirm()) { // Confirm page ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" name="u" id="u" onclick="ew.selectAll(this);"<?= $Page->Disabled ?>><label class="custom-control-label" for="u"><?= $Language->phrase("UpdateSelectAll") ?></label>
    </div>
    <?php } ?>
<?php if ($Page->number->Visible && (!$Page->isConfirm() || $Page->number->multiUpdateSelected())) { // number ?>
    <div id="r_number" class="form-group row">
        <label for="x_number" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_number" id="u_number" class="custom-control-input ew-multi-select" value="1"<?= $Page->number->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_number"><?= $Page->number->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_number" id="u_number" value="<?= $Page->number->MultiUpdate ?>">
            <?= $Page->number->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->number->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_main_buses_number">
                <input type="<?= $Page->number->getInputTextType() ?>" data-table="main_buses" data-field="x_number" name="x_number" id="x_number" size="30" placeholder="<?= HtmlEncode($Page->number->getPlaceHolder()) ?>" value="<?= $Page->number->EditValue ?>"<?= $Page->number->editAttributes() ?> aria-describedby="x_number_help">
                <?= $Page->number->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->number->getErrorMessage() ?></div>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_number">
                <span<?= $Page->number->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->number->getDisplayValue($Page->number->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_number" data-hidden="1" name="x_number" id="x_number" value="<?= HtmlEncode($Page->number->FormValue) ?>">
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
                <span id="el_main_buses_platform_id">
                <?php $Page->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
                    <select
                        id="x_platform_id"
                        name="x_platform_id"
                        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
                        data-select2-id="main_buses_x_platform_id"
                        data-table="main_buses"
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
                    var el = document.querySelector("select[data-select2-id='main_buses_x_platform_id']"),
                        options = { name: "x_platform_id", selectId: "main_buses_x_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.main_buses.fields.platform_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_platform_id">
                <span<?= $Page->platform_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->platform_id->getDisplayValue($Page->platform_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_platform_id" data-hidden="1" name="x_platform_id" id="x_platform_id" value="<?= HtmlEncode($Page->platform_id->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->operator_id->Visible && (!$Page->isConfirm() || $Page->operator_id->multiUpdateSelected())) { // operator_id ?>
    <div id="r_operator_id" class="form-group row">
        <label for="x_operator_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_operator_id" id="u_operator_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->operator_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_operator_id"><?= $Page->operator_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_operator_id" id="u_operator_id" value="<?= $Page->operator_id->MultiUpdate ?>">
            <?= $Page->operator_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->operator_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_main_buses_operator_id">
                    <select
                        id="x_operator_id"
                        name="x_operator_id"
                        class="form-control ew-select<?= $Page->operator_id->isInvalidClass() ?>"
                        data-select2-id="main_buses_x_operator_id"
                        data-table="main_buses"
                        data-field="x_operator_id"
                        data-value-separator="<?= $Page->operator_id->displayValueSeparatorAttribute() ?>"
                        data-placeholder="<?= HtmlEncode($Page->operator_id->getPlaceHolder()) ?>"
                        <?= $Page->operator_id->editAttributes() ?>>
                        <?= $Page->operator_id->selectOptionListHtml("x_operator_id") ?>
                    </select>
                    <?= $Page->operator_id->getCustomMessage() ?>
                    <div class="invalid-feedback"><?= $Page->operator_id->getErrorMessage() ?></div>
                <?= $Page->operator_id->Lookup->getParamTag($Page, "p_x_operator_id") ?>
                <script>
                loadjs.ready("head", function() {
                    var el = document.querySelector("select[data-select2-id='main_buses_x_operator_id']"),
                        options = { name: "x_operator_id", selectId: "main_buses_x_operator_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.main_buses.fields.operator_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_operator_id">
                <span<?= $Page->operator_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->operator_id->getDisplayValue($Page->operator_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_operator_id" data-hidden="1" name="x_operator_id" id="x_operator_id" value="<?= HtmlEncode($Page->operator_id->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->exterior_campaign_id->Visible && (!$Page->isConfirm() || $Page->exterior_campaign_id->multiUpdateSelected())) { // exterior_campaign_id ?>
    <div id="r_exterior_campaign_id" class="form-group row">
        <label for="x_exterior_campaign_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_exterior_campaign_id" id="u_exterior_campaign_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->exterior_campaign_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_exterior_campaign_id"><?= $Page->exterior_campaign_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_exterior_campaign_id" id="u_exterior_campaign_id" value="<?= $Page->exterior_campaign_id->MultiUpdate ?>">
            <?= $Page->exterior_campaign_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->exterior_campaign_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_main_buses_exterior_campaign_id">
                    <select
                        id="x_exterior_campaign_id"
                        name="x_exterior_campaign_id"
                        class="form-control ew-select<?= $Page->exterior_campaign_id->isInvalidClass() ?>"
                        data-select2-id="main_buses_x_exterior_campaign_id"
                        data-table="main_buses"
                        data-field="x_exterior_campaign_id"
                        data-value-separator="<?= $Page->exterior_campaign_id->displayValueSeparatorAttribute() ?>"
                        data-placeholder="<?= HtmlEncode($Page->exterior_campaign_id->getPlaceHolder()) ?>"
                        <?= $Page->exterior_campaign_id->editAttributes() ?>>
                        <?= $Page->exterior_campaign_id->selectOptionListHtml("x_exterior_campaign_id") ?>
                    </select>
                    <?= $Page->exterior_campaign_id->getCustomMessage() ?>
                    <div class="invalid-feedback"><?= $Page->exterior_campaign_id->getErrorMessage() ?></div>
                <?= $Page->exterior_campaign_id->Lookup->getParamTag($Page, "p_x_exterior_campaign_id") ?>
                <script>
                loadjs.ready("head", function() {
                    var el = document.querySelector("select[data-select2-id='main_buses_x_exterior_campaign_id']"),
                        options = { name: "x_exterior_campaign_id", selectId: "main_buses_x_exterior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.main_buses.fields.exterior_campaign_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_exterior_campaign_id">
                <span<?= $Page->exterior_campaign_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->exterior_campaign_id->getDisplayValue($Page->exterior_campaign_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_exterior_campaign_id" data-hidden="1" name="x_exterior_campaign_id" id="x_exterior_campaign_id" value="<?= HtmlEncode($Page->exterior_campaign_id->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->interior_campaign_id->Visible && (!$Page->isConfirm() || $Page->interior_campaign_id->multiUpdateSelected())) { // interior_campaign_id ?>
    <div id="r_interior_campaign_id" class="form-group row">
        <label for="x_interior_campaign_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_interior_campaign_id" id="u_interior_campaign_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->interior_campaign_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_interior_campaign_id"><?= $Page->interior_campaign_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_interior_campaign_id" id="u_interior_campaign_id" value="<?= $Page->interior_campaign_id->MultiUpdate ?>">
            <?= $Page->interior_campaign_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->interior_campaign_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_main_buses_interior_campaign_id">
                    <select
                        id="x_interior_campaign_id"
                        name="x_interior_campaign_id"
                        class="form-control ew-select<?= $Page->interior_campaign_id->isInvalidClass() ?>"
                        data-select2-id="main_buses_x_interior_campaign_id"
                        data-table="main_buses"
                        data-field="x_interior_campaign_id"
                        data-value-separator="<?= $Page->interior_campaign_id->displayValueSeparatorAttribute() ?>"
                        data-placeholder="<?= HtmlEncode($Page->interior_campaign_id->getPlaceHolder()) ?>"
                        <?= $Page->interior_campaign_id->editAttributes() ?>>
                        <?= $Page->interior_campaign_id->selectOptionListHtml("x_interior_campaign_id") ?>
                    </select>
                    <?= $Page->interior_campaign_id->getCustomMessage() ?>
                    <div class="invalid-feedback"><?= $Page->interior_campaign_id->getErrorMessage() ?></div>
                <?= $Page->interior_campaign_id->Lookup->getParamTag($Page, "p_x_interior_campaign_id") ?>
                <script>
                loadjs.ready("head", function() {
                    var el = document.querySelector("select[data-select2-id='main_buses_x_interior_campaign_id']"),
                        options = { name: "x_interior_campaign_id", selectId: "main_buses_x_interior_campaign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.main_buses.fields.interior_campaign_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_interior_campaign_id">
                <span<?= $Page->interior_campaign_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->interior_campaign_id->getDisplayValue($Page->interior_campaign_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_interior_campaign_id" data-hidden="1" name="x_interior_campaign_id" id="x_interior_campaign_id" value="<?= HtmlEncode($Page->interior_campaign_id->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->bus_status_id->Visible && (!$Page->isConfirm() || $Page->bus_status_id->multiUpdateSelected())) { // bus_status_id ?>
    <div id="r_bus_status_id" class="form-group row">
        <label for="x_bus_status_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_bus_status_id" id="u_bus_status_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->bus_status_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_bus_status_id"><?= $Page->bus_status_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_bus_status_id" id="u_bus_status_id" value="<?= $Page->bus_status_id->MultiUpdate ?>">
            <?= $Page->bus_status_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->bus_status_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_main_buses_bus_status_id">
                    <select
                        id="x_bus_status_id"
                        name="x_bus_status_id"
                        class="form-control ew-select<?= $Page->bus_status_id->isInvalidClass() ?>"
                        data-select2-id="main_buses_x_bus_status_id"
                        data-table="main_buses"
                        data-field="x_bus_status_id"
                        data-value-separator="<?= $Page->bus_status_id->displayValueSeparatorAttribute() ?>"
                        data-placeholder="<?= HtmlEncode($Page->bus_status_id->getPlaceHolder()) ?>"
                        <?= $Page->bus_status_id->editAttributes() ?>>
                        <?= $Page->bus_status_id->selectOptionListHtml("x_bus_status_id") ?>
                    </select>
                    <?= $Page->bus_status_id->getCustomMessage() ?>
                    <div class="invalid-feedback"><?= $Page->bus_status_id->getErrorMessage() ?></div>
                <?= $Page->bus_status_id->Lookup->getParamTag($Page, "p_x_bus_status_id") ?>
                <script>
                loadjs.ready("head", function() {
                    var el = document.querySelector("select[data-select2-id='main_buses_x_bus_status_id']"),
                        options = { name: "x_bus_status_id", selectId: "main_buses_x_bus_status_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.main_buses.fields.bus_status_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_bus_status_id">
                <span<?= $Page->bus_status_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_status_id->getDisplayValue($Page->bus_status_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_bus_status_id" data-hidden="1" name="x_bus_status_id" id="x_bus_status_id" value="<?= HtmlEncode($Page->bus_status_id->FormValue) ?>">
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
                <span id="el_main_buses_bus_size_id">
                    <select
                        id="x_bus_size_id"
                        name="x_bus_size_id"
                        class="form-control ew-select<?= $Page->bus_size_id->isInvalidClass() ?>"
                        data-select2-id="main_buses_x_bus_size_id"
                        data-table="main_buses"
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
                    var el = document.querySelector("select[data-select2-id='main_buses_x_bus_size_id']"),
                        options = { name: "x_bus_size_id", selectId: "main_buses_x_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.main_buses.fields.bus_size_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_bus_size_id">
                <span<?= $Page->bus_size_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_size_id->getDisplayValue($Page->bus_size_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_bus_size_id" data-hidden="1" name="x_bus_size_id" id="x_bus_size_id" value="<?= HtmlEncode($Page->bus_size_id->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->bus_depot_id->Visible && (!$Page->isConfirm() || $Page->bus_depot_id->multiUpdateSelected())) { // bus_depot_id ?>
    <div id="r_bus_depot_id" class="form-group row">
        <label for="x_bus_depot_id" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_bus_depot_id" id="u_bus_depot_id" class="custom-control-input ew-multi-select" value="1"<?= $Page->bus_depot_id->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_bus_depot_id"><?= $Page->bus_depot_id->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_bus_depot_id" id="u_bus_depot_id" value="<?= $Page->bus_depot_id->MultiUpdate ?>">
            <?= $Page->bus_depot_id->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->bus_depot_id->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_main_buses_bus_depot_id">
                    <select
                        id="x_bus_depot_id"
                        name="x_bus_depot_id"
                        class="form-control ew-select<?= $Page->bus_depot_id->isInvalidClass() ?>"
                        data-select2-id="main_buses_x_bus_depot_id"
                        data-table="main_buses"
                        data-field="x_bus_depot_id"
                        data-value-separator="<?= $Page->bus_depot_id->displayValueSeparatorAttribute() ?>"
                        data-placeholder="<?= HtmlEncode($Page->bus_depot_id->getPlaceHolder()) ?>"
                        <?= $Page->bus_depot_id->editAttributes() ?>>
                        <?= $Page->bus_depot_id->selectOptionListHtml("x_bus_depot_id") ?>
                    </select>
                    <?= $Page->bus_depot_id->getCustomMessage() ?>
                    <div class="invalid-feedback"><?= $Page->bus_depot_id->getErrorMessage() ?></div>
                <?= $Page->bus_depot_id->Lookup->getParamTag($Page, "p_x_bus_depot_id") ?>
                <script>
                loadjs.ready("head", function() {
                    var el = document.querySelector("select[data-select2-id='main_buses_x_bus_depot_id']"),
                        options = { name: "x_bus_depot_id", selectId: "main_buses_x_bus_depot_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
                    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
                    Object.assign(options, ew.vars.tables.main_buses.fields.bus_depot_id.selectOptions);
                    ew.createSelect(options);
                });
                </script>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_bus_depot_id">
                <span<?= $Page->bus_depot_id->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_depot_id->getDisplayValue($Page->bus_depot_id->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_bus_depot_id" data-hidden="1" name="x_bus_depot_id" id="x_bus_depot_id" value="<?= HtmlEncode($Page->bus_depot_id->FormValue) ?>">
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
                <span id="el_main_buses_ts_created">
                <input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="main_buses" data-field="x_ts_created" name="x_ts_created" id="x_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?> aria-describedby="x_ts_created_help">
                <?= $Page->ts_created->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
                <?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
                <script>
                loadjs.ready(["fmain_busesupdate", "datetimepicker"], function() {
                    ew.createDateTimePicker("fmain_busesupdate", "x_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
                });
                </script>
                <?php } ?>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_ts_created">
                <span<?= $Page->ts_created->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ts_created->getDisplayValue($Page->ts_created->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_ts_created" data-hidden="1" name="x_ts_created" id="x_ts_created" value="<?= HtmlEncode($Page->ts_created->FormValue) ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->ts_last_update->Visible && (!$Page->isConfirm() || $Page->ts_last_update->multiUpdateSelected())) { // ts_last_update ?>
    <div id="r_ts_last_update" class="form-group row">
        <label for="x_ts_last_update" class="<?= $Page->LeftColumnClass ?>">
            <?php if (!$Page->isConfirm()) { ?>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_ts_last_update" id="u_ts_last_update" class="custom-control-input ew-multi-select" value="1"<?= $Page->ts_last_update->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_ts_last_update"><?= $Page->ts_last_update->caption() ?></label>
            </div>
            <?php } else { ?>
            <input type="hidden" name="u_ts_last_update" id="u_ts_last_update" value="<?= $Page->ts_last_update->MultiUpdate ?>">
            <?= $Page->ts_last_update->caption() ?>
            <?php } ?>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->ts_last_update->cellAttributes() ?>>
                <?php if (!$Page->isConfirm()) { ?>
                <span id="el_main_buses_ts_last_update">
                <input type="<?= $Page->ts_last_update->getInputTextType() ?>" data-table="main_buses" data-field="x_ts_last_update" name="x_ts_last_update" id="x_ts_last_update" placeholder="<?= HtmlEncode($Page->ts_last_update->getPlaceHolder()) ?>" value="<?= $Page->ts_last_update->EditValue ?>"<?= $Page->ts_last_update->editAttributes() ?> aria-describedby="x_ts_last_update_help">
                <?= $Page->ts_last_update->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->ts_last_update->getErrorMessage() ?></div>
                <?php if (!$Page->ts_last_update->ReadOnly && !$Page->ts_last_update->Disabled && !isset($Page->ts_last_update->EditAttrs["readonly"]) && !isset($Page->ts_last_update->EditAttrs["disabled"])) { ?>
                <script>
                loadjs.ready(["fmain_busesupdate", "datetimepicker"], function() {
                    ew.createDateTimePicker("fmain_busesupdate", "x_ts_last_update", {"ignoreReadonly":true,"useCurrent":false,"format":0});
                });
                </script>
                <?php } ?>
                </span>
                <?php } else { ?>
                <span id="el_main_buses_ts_last_update">
                <span<?= $Page->ts_last_update->viewAttributes() ?>>
                <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ts_last_update->getDisplayValue($Page->ts_last_update->ViewValue))) ?>"></span>
                </span>
                <input type="hidden" data-table="main_buses" data-field="x_ts_last_update" data-hidden="1" name="x_ts_last_update" id="x_ts_last_update" value="<?= HtmlEncode($Page->ts_last_update->FormValue) ?>">
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
    ew.addEventHandlers("main_buses");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

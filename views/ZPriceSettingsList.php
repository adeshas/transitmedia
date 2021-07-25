<?php

namespace PHPMaker2021\test;

// Page object
$ZPriceSettingsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fz_price_settingslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fz_price_settingslist = currentForm = new ew.Form("fz_price_settingslist", "list");
    fz_price_settingslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "z_price_settings")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.z_price_settings)
        ew.vars.tables.z_price_settings = currentTable;
    fz_price_settingslist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["platform_id", [fields.platform_id.visible && fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid],
        ["inventory_id", [fields.inventory_id.visible && fields.inventory_id.required ? ew.Validators.required(fields.inventory_id.caption) : null], fields.inventory_id.isInvalid],
        ["print_stage_id", [fields.print_stage_id.visible && fields.print_stage_id.required ? ew.Validators.required(fields.print_stage_id.caption) : null], fields.print_stage_id.isInvalid],
        ["bus_size_id", [fields.bus_size_id.visible && fields.bus_size_id.required ? ew.Validators.required(fields.bus_size_id.caption) : null], fields.bus_size_id.isInvalid],
        ["details", [fields.details.visible && fields.details.required ? ew.Validators.required(fields.details.caption) : null], fields.details.isInvalid],
        ["max_limit", [fields.max_limit.visible && fields.max_limit.required ? ew.Validators.required(fields.max_limit.caption) : null, ew.Validators.integer], fields.max_limit.isInvalid],
        ["min_limit", [fields.min_limit.visible && fields.min_limit.required ? ew.Validators.required(fields.min_limit.caption) : null, ew.Validators.integer], fields.min_limit.isInvalid],
        ["price", [fields.price.visible && fields.price.required ? ew.Validators.required(fields.price.caption) : null, ew.Validators.integer], fields.price.isInvalid],
        ["operator_fee", [fields.operator_fee.visible && fields.operator_fee.required ? ew.Validators.required(fields.operator_fee.caption) : null, ew.Validators.integer], fields.operator_fee.isInvalid],
        ["agency_fee", [fields.agency_fee.visible && fields.agency_fee.required ? ew.Validators.required(fields.agency_fee.caption) : null, ew.Validators.integer], fields.agency_fee.isInvalid],
        ["lamata_fee", [fields.lamata_fee.visible && fields.lamata_fee.required ? ew.Validators.required(fields.lamata_fee.caption) : null, ew.Validators.integer], fields.lamata_fee.isInvalid],
        ["lasaa_fee", [fields.lasaa_fee.visible && fields.lasaa_fee.required ? ew.Validators.required(fields.lasaa_fee.caption) : null, ew.Validators.integer], fields.lasaa_fee.isInvalid],
        ["printers_fee", [fields.printers_fee.visible && fields.printers_fee.required ? ew.Validators.required(fields.printers_fee.caption) : null, ew.Validators.integer], fields.printers_fee.isInvalid],
        ["active", [fields.active.visible && fields.active.required ? ew.Validators.required(fields.active.caption) : null], fields.active.isInvalid],
        ["ts_created", [fields.ts_created.visible && fields.ts_created.required ? ew.Validators.required(fields.ts_created.caption) : null, ew.Validators.datetime(0)], fields.ts_created.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fz_price_settingslist,
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
    fz_price_settingslist.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        if (gridinsert && addcnt == 0) { // No row added
            ew.alert(ew.language.phrase("NoAddRecord"));
            return false;
        }
        return true;
    }

    // Check empty row
    fz_price_settingslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "platform_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "inventory_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "print_stage_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bus_size_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "details", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "max_limit", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "min_limit", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "price", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "operator_fee", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "agency_fee", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lamata_fee", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lasaa_fee", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "printers_fee", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "active[]", true))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ts_created", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fz_price_settingslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fz_price_settingslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fz_price_settingslist.lists.platform_id = <?= $Page->platform_id->toClientList($Page) ?>;
    fz_price_settingslist.lists.inventory_id = <?= $Page->inventory_id->toClientList($Page) ?>;
    fz_price_settingslist.lists.print_stage_id = <?= $Page->print_stage_id->toClientList($Page) ?>;
    fz_price_settingslist.lists.bus_size_id = <?= $Page->bus_size_id->toClientList($Page) ?>;
    fz_price_settingslist.lists.active = <?= $Page->active->toClientList($Page) ?>;
    loadjs.done("fz_price_settingslist");
});
var fz_price_settingslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fz_price_settingslistsrch = currentSearchForm = new ew.Form("fz_price_settingslistsrch");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "z_price_settings")) ?>,
        fields = currentTable.fields;
    fz_price_settingslistsrch.addFields([
        ["id", [ew.Validators.integer], fields.id.isInvalid],
        ["platform_id", [], fields.platform_id.isInvalid],
        ["inventory_id", [], fields.inventory_id.isInvalid],
        ["print_stage_id", [], fields.print_stage_id.isInvalid],
        ["bus_size_id", [], fields.bus_size_id.isInvalid],
        ["details", [], fields.details.isInvalid],
        ["max_limit", [], fields.max_limit.isInvalid],
        ["min_limit", [], fields.min_limit.isInvalid],
        ["price", [], fields.price.isInvalid],
        ["operator_fee", [], fields.operator_fee.isInvalid],
        ["agency_fee", [], fields.agency_fee.isInvalid],
        ["lamata_fee", [], fields.lamata_fee.isInvalid],
        ["lasaa_fee", [], fields.lasaa_fee.isInvalid],
        ["printers_fee", [], fields.printers_fee.isInvalid],
        ["active", [], fields.active.isInvalid],
        ["ts_created", [ew.Validators.datetime(0)], fields.ts_created.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fz_price_settingslistsrch.setInvalid();
    });

    // Validate form
    fz_price_settingslistsrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fz_price_settingslistsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fz_price_settingslistsrch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fz_price_settingslistsrch.lists.platform_id = <?= $Page->platform_id->toClientList($Page) ?>;
    fz_price_settingslistsrch.lists.inventory_id = <?= $Page->inventory_id->toClientList($Page) ?>;
    fz_price_settingslistsrch.lists.print_stage_id = <?= $Page->print_stage_id->toClientList($Page) ?>;
    fz_price_settingslistsrch.lists.bus_size_id = <?= $Page->bus_size_id->toClientList($Page) ?>;
    fz_price_settingslistsrch.lists.active = <?= $Page->active->toClientList($Page) ?>;

    // Filters
    fz_price_settingslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fz_price_settingslistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fz_price_settingslistsrch" id="fz_price_settingslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fz_price_settingslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="z_price_settings">
    <div class="ew-extended-search">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->id->Visible) { // id ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_id" class="ew-cell form-group">
        <label for="x_id" class="ew-search-caption ew-label"><?= $Page->id->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id" id="z_id" value="=">
</span>
        <span id="el_z_price_settings_id" class="ew-search-field">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="z_price_settings" data-field="x_id" name="x_id" id="x_id" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_platform_id" class="ew-cell form-group">
        <label for="x_platform_id" class="ew-search-caption ew-label"><?= $Page->platform_id->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_platform_id" id="z_platform_id" value="=">
</span>
        <span id="el_z_price_settings_platform_id" class="ew-search-field">
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
    <div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage(false) ?></div>
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
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_inventory_id" class="ew-cell form-group">
        <label for="x_inventory_id" class="ew-search-caption ew-label"><?= $Page->inventory_id->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_inventory_id" id="z_inventory_id" value="=">
</span>
        <span id="el_z_price_settings_inventory_id" class="ew-search-field">
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
    <div class="invalid-feedback"><?= $Page->inventory_id->getErrorMessage(false) ?></div>
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
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->print_stage_id->Visible) { // print_stage_id ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_print_stage_id" class="ew-cell form-group">
        <label for="x_print_stage_id" class="ew-search-caption ew-label"><?= $Page->print_stage_id->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_print_stage_id" id="z_print_stage_id" value="=">
</span>
        <span id="el_z_price_settings_print_stage_id" class="ew-search-field">
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
    <div class="invalid-feedback"><?= $Page->print_stage_id->getErrorMessage(false) ?></div>
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
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_bus_size_id" class="ew-cell form-group">
        <label for="x_bus_size_id" class="ew-search-caption ew-label"><?= $Page->bus_size_id->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_bus_size_id" id="z_bus_size_id" value="=">
</span>
        <span id="el_z_price_settings_bus_size_id" class="ew-search-field">
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
    <div class="invalid-feedback"><?= $Page->bus_size_id->getErrorMessage(false) ?></div>
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
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_active" class="ew-cell form-group">
        <label class="ew-search-caption ew-label"><?= $Page->active->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_active" id="z_active" value="=">
</span>
        <span id="el_z_price_settings_active" class="ew-search-field">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->active->isInvalidClass() ?>" data-table="z_price_settings" data-field="x_active" name="x_active[]" id="x_active_776967" value="1"<?= ConvertToBool($Page->active->AdvancedSearch->SearchValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?>>
    <label class="custom-control-label" for="x_active_776967"></label>
</div>
<div class="invalid-feedback"><?= $Page->active->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_ts_created" class="ew-cell form-group">
        <label for="x_ts_created" class="ew-search-caption ew-label"><?= $Page->ts_created->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ts_created" id="z_ts_created" value="=">
</span>
        <span id="el_z_price_settings_ts_created" class="ew-search-field">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="z_price_settings" data-field="x_ts_created" name="x_ts_created" id="x_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage(false) ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fz_price_settingslistsrch", "datetimepicker"], function() {
    ew.createDateTimePicker("fz_price_settingslistsrch", "x_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow > 0) { ?>
</div>
    <?php } ?>
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> z_price_settings">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fz_price_settingslist" id="fz_price_settingslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="z_price_settings">
<div id="gmp_z_price_settings" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_z_price_settingslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_z_price_settings_id" class="z_price_settings_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
        <th data-name="platform_id" class="<?= $Page->platform_id->headerCellClass() ?>"><div id="elh_z_price_settings_platform_id" class="z_price_settings_platform_id"><?= $Page->renderSort($Page->platform_id) ?></div></th>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <th data-name="inventory_id" class="<?= $Page->inventory_id->headerCellClass() ?>"><div id="elh_z_price_settings_inventory_id" class="z_price_settings_inventory_id"><?= $Page->renderSort($Page->inventory_id) ?></div></th>
<?php } ?>
<?php if ($Page->print_stage_id->Visible) { // print_stage_id ?>
        <th data-name="print_stage_id" class="<?= $Page->print_stage_id->headerCellClass() ?>"><div id="elh_z_price_settings_print_stage_id" class="z_price_settings_print_stage_id"><?= $Page->renderSort($Page->print_stage_id) ?></div></th>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <th data-name="bus_size_id" class="<?= $Page->bus_size_id->headerCellClass() ?>"><div id="elh_z_price_settings_bus_size_id" class="z_price_settings_bus_size_id"><?= $Page->renderSort($Page->bus_size_id) ?></div></th>
<?php } ?>
<?php if ($Page->details->Visible) { // details ?>
        <th data-name="details" class="<?= $Page->details->headerCellClass() ?>"><div id="elh_z_price_settings_details" class="z_price_settings_details"><?= $Page->renderSort($Page->details) ?></div></th>
<?php } ?>
<?php if ($Page->max_limit->Visible) { // max_limit ?>
        <th data-name="max_limit" class="<?= $Page->max_limit->headerCellClass() ?>"><div id="elh_z_price_settings_max_limit" class="z_price_settings_max_limit"><?= $Page->renderSort($Page->max_limit) ?></div></th>
<?php } ?>
<?php if ($Page->min_limit->Visible) { // min_limit ?>
        <th data-name="min_limit" class="<?= $Page->min_limit->headerCellClass() ?>"><div id="elh_z_price_settings_min_limit" class="z_price_settings_min_limit"><?= $Page->renderSort($Page->min_limit) ?></div></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th data-name="price" class="<?= $Page->price->headerCellClass() ?>"><div id="elh_z_price_settings_price" class="z_price_settings_price"><?= $Page->renderSort($Page->price) ?></div></th>
<?php } ?>
<?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <th data-name="operator_fee" class="<?= $Page->operator_fee->headerCellClass() ?>"><div id="elh_z_price_settings_operator_fee" class="z_price_settings_operator_fee"><?= $Page->renderSort($Page->operator_fee) ?></div></th>
<?php } ?>
<?php if ($Page->agency_fee->Visible) { // agency_fee ?>
        <th data-name="agency_fee" class="<?= $Page->agency_fee->headerCellClass() ?>"><div id="elh_z_price_settings_agency_fee" class="z_price_settings_agency_fee"><?= $Page->renderSort($Page->agency_fee) ?></div></th>
<?php } ?>
<?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <th data-name="lamata_fee" class="<?= $Page->lamata_fee->headerCellClass() ?>"><div id="elh_z_price_settings_lamata_fee" class="z_price_settings_lamata_fee"><?= $Page->renderSort($Page->lamata_fee) ?></div></th>
<?php } ?>
<?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <th data-name="lasaa_fee" class="<?= $Page->lasaa_fee->headerCellClass() ?>"><div id="elh_z_price_settings_lasaa_fee" class="z_price_settings_lasaa_fee"><?= $Page->renderSort($Page->lasaa_fee) ?></div></th>
<?php } ?>
<?php if ($Page->printers_fee->Visible) { // printers_fee ?>
        <th data-name="printers_fee" class="<?= $Page->printers_fee->headerCellClass() ?>"><div id="elh_z_price_settings_printers_fee" class="z_price_settings_printers_fee"><?= $Page->renderSort($Page->printers_fee) ?></div></th>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <th data-name="active" class="<?= $Page->active->headerCellClass() ?>"><div id="elh_z_price_settings_active" class="z_price_settings_active"><?= $Page->renderSort($Page->active) ?></div></th>
<?php } ?>
<?php if ($Page->ts_created->Visible) { // ts_created ?>
        <th data-name="ts_created" class="<?= $Page->ts_created->headerCellClass() ?>"><div id="elh_z_price_settings_ts_created" class="z_price_settings_ts_created"><?= $Page->renderSort($Page->ts_created) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
$Page->EditRowCount = 0;
if ($Page->isEdit())
    $Page->RowIndex = 1;
if ($Page->isGridAdd())
    $Page->RowIndex = 0;
if ($Page->isGridEdit())
    $Page->RowIndex = 0;
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;
        if ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm()) {
            $Page->RowIndex++;
            $CurrentForm->Index = $Page->RowIndex;
            if ($CurrentForm->hasValue($Page->FormActionName) && ($Page->isConfirm() || $Page->EventCancelled)) {
                $Page->RowAction = strval($CurrentForm->getValue($Page->FormActionName));
            } elseif ($Page->isGridAdd()) {
                $Page->RowAction = "insert";
            } else {
                $Page->RowAction = "";
            }
        }

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view
        if ($Page->isGridAdd()) { // Grid add
            $Page->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Page->isGridAdd() && $Page->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->isEdit()) {
            if ($Page->checkInlineEditKey() && $Page->EditRowCount == 0) { // Inline edit
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isGridEdit()) { // Grid edit
            if ($Page->EventCancelled) {
                $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
            }
            if ($Page->RowAction == "insert") {
                $Page->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isEdit() && $Page->RowType == ROWTYPE_EDIT && $Page->EventCancelled) { // Update failed
            $CurrentForm->Index = 1;
            $Page->restoreFormValues(); // Restore form values
        }
        if ($Page->isGridEdit() && ($Page->RowType == ROWTYPE_EDIT || $Page->RowType == ROWTYPE_ADD) && $Page->EventCancelled) { // Update failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_z_price_settings", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Page->RowAction != "delete" && $Page->RowAction != "insertdelete" && !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_id" class="form-group"></span>
<input type="hidden" data-table="z_price_settings" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_id" class="form-group">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="z_price_settings" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id" <?= $Page->platform_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_platform_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_platform_id"
        name="x<?= $Page->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_platform_id"
        data-table="z_price_settings"
        data-field="x_platform_id"
        data-value-separator="<?= $Page->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->platform_id->getPlaceHolder()) ?>"
        <?= $Page->platform_id->editAttributes() ?>>
        <?= $Page->platform_id->selectOptionListHtml("x{$Page->RowIndex}_platform_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage() ?></div>
<?= $Page->platform_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_platform_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_platform_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_platform_id" id="o<?= $Page->RowIndex ?>_platform_id" value="<?= HtmlEncode($Page->platform_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_platform_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_platform_id"
        name="x<?= $Page->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_platform_id"
        data-table="z_price_settings"
        data-field="x_platform_id"
        data-value-separator="<?= $Page->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->platform_id->getPlaceHolder()) ?>"
        <?= $Page->platform_id->editAttributes() ?>>
        <?= $Page->platform_id->selectOptionListHtml("x{$Page->RowIndex}_platform_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage() ?></div>
<?= $Page->platform_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_platform_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<?= $Page->platform_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <td data-name="inventory_id" <?= $Page->inventory_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_inventory_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_inventory_id"
        name="x<?= $Page->RowIndex ?>_inventory_id"
        class="form-control ew-select<?= $Page->inventory_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_inventory_id"
        data-table="z_price_settings"
        data-field="x_inventory_id"
        data-value-separator="<?= $Page->inventory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->inventory_id->getPlaceHolder()) ?>"
        <?= $Page->inventory_id->editAttributes() ?>>
        <?= $Page->inventory_id->selectOptionListHtml("x{$Page->RowIndex}_inventory_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->inventory_id->getErrorMessage() ?></div>
<?= $Page->inventory_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_inventory_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_inventory_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_inventory_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_inventory_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.inventory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_inventory_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_inventory_id" id="o<?= $Page->RowIndex ?>_inventory_id" value="<?= HtmlEncode($Page->inventory_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_inventory_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_inventory_id"
        name="x<?= $Page->RowIndex ?>_inventory_id"
        class="form-control ew-select<?= $Page->inventory_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_inventory_id"
        data-table="z_price_settings"
        data-field="x_inventory_id"
        data-value-separator="<?= $Page->inventory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->inventory_id->getPlaceHolder()) ?>"
        <?= $Page->inventory_id->editAttributes() ?>>
        <?= $Page->inventory_id->selectOptionListHtml("x{$Page->RowIndex}_inventory_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->inventory_id->getErrorMessage() ?></div>
<?= $Page->inventory_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_inventory_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_inventory_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_inventory_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_inventory_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.inventory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_inventory_id">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<?= $Page->inventory_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->print_stage_id->Visible) { // print_stage_id ?>
        <td data-name="print_stage_id" <?= $Page->print_stage_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_print_stage_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_print_stage_id"
        name="x<?= $Page->RowIndex ?>_print_stage_id"
        class="form-control ew-select<?= $Page->print_stage_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_print_stage_id"
        data-table="z_price_settings"
        data-field="x_print_stage_id"
        data-value-separator="<?= $Page->print_stage_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->print_stage_id->getPlaceHolder()) ?>"
        <?= $Page->print_stage_id->editAttributes() ?>>
        <?= $Page->print_stage_id->selectOptionListHtml("x{$Page->RowIndex}_print_stage_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->print_stage_id->getErrorMessage() ?></div>
<?= $Page->print_stage_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_print_stage_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_print_stage_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_print_stage_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_print_stage_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.print_stage_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_print_stage_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_print_stage_id" id="o<?= $Page->RowIndex ?>_print_stage_id" value="<?= HtmlEncode($Page->print_stage_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_print_stage_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_print_stage_id"
        name="x<?= $Page->RowIndex ?>_print_stage_id"
        class="form-control ew-select<?= $Page->print_stage_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_print_stage_id"
        data-table="z_price_settings"
        data-field="x_print_stage_id"
        data-value-separator="<?= $Page->print_stage_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->print_stage_id->getPlaceHolder()) ?>"
        <?= $Page->print_stage_id->editAttributes() ?>>
        <?= $Page->print_stage_id->selectOptionListHtml("x{$Page->RowIndex}_print_stage_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->print_stage_id->getErrorMessage() ?></div>
<?= $Page->print_stage_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_print_stage_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_print_stage_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_print_stage_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_print_stage_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.print_stage_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_print_stage_id">
<span<?= $Page->print_stage_id->viewAttributes() ?>>
<?= $Page->print_stage_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <td data-name="bus_size_id" <?= $Page->bus_size_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_bus_size_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_size_id"
        name="x<?= $Page->RowIndex ?>_bus_size_id"
        class="form-control ew-select<?= $Page->bus_size_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_bus_size_id"
        data-table="z_price_settings"
        data-field="x_bus_size_id"
        data-value-separator="<?= $Page->bus_size_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_size_id->getPlaceHolder()) ?>"
        <?= $Page->bus_size_id->editAttributes() ?>>
        <?= $Page->bus_size_id->selectOptionListHtml("x{$Page->RowIndex}_bus_size_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_size_id->getErrorMessage() ?></div>
<?= $Page->bus_size_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_size_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_bus_size_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_size_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_bus_size_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_size_id" id="o<?= $Page->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Page->bus_size_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_bus_size_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_bus_size_id"
        name="x<?= $Page->RowIndex ?>_bus_size_id"
        class="form-control ew-select<?= $Page->bus_size_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_bus_size_id"
        data-table="z_price_settings"
        data-field="x_bus_size_id"
        data-value-separator="<?= $Page->bus_size_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_size_id->getPlaceHolder()) ?>"
        <?= $Page->bus_size_id->editAttributes() ?>>
        <?= $Page->bus_size_id->selectOptionListHtml("x{$Page->RowIndex}_bus_size_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_size_id->getErrorMessage() ?></div>
<?= $Page->bus_size_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_size_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_bus_size_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_size_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_bus_size_id">
<span<?= $Page->bus_size_id->viewAttributes() ?>>
<?= $Page->bus_size_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->details->Visible) { // details ?>
        <td data-name="details" <?= $Page->details->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_details" class="form-group">
<textarea data-table="z_price_settings" data-field="x_details" name="x<?= $Page->RowIndex ?>_details" id="x<?= $Page->RowIndex ?>_details" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->details->getPlaceHolder()) ?>"<?= $Page->details->editAttributes() ?>><?= $Page->details->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->details->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_details" data-hidden="1" name="o<?= $Page->RowIndex ?>_details" id="o<?= $Page->RowIndex ?>_details" value="<?= HtmlEncode($Page->details->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_details" class="form-group">
<textarea data-table="z_price_settings" data-field="x_details" name="x<?= $Page->RowIndex ?>_details" id="x<?= $Page->RowIndex ?>_details" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->details->getPlaceHolder()) ?>"<?= $Page->details->editAttributes() ?>><?= $Page->details->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->details->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_details">
<span<?= $Page->details->viewAttributes() ?>>
<?= $Page->details->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->max_limit->Visible) { // max_limit ?>
        <td data-name="max_limit" <?= $Page->max_limit->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_max_limit" class="form-group">
<input type="<?= $Page->max_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_max_limit" name="x<?= $Page->RowIndex ?>_max_limit" id="x<?= $Page->RowIndex ?>_max_limit" size="30" placeholder="<?= HtmlEncode($Page->max_limit->getPlaceHolder()) ?>" value="<?= $Page->max_limit->EditValue ?>"<?= $Page->max_limit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->max_limit->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_max_limit" data-hidden="1" name="o<?= $Page->RowIndex ?>_max_limit" id="o<?= $Page->RowIndex ?>_max_limit" value="<?= HtmlEncode($Page->max_limit->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_max_limit" class="form-group">
<input type="<?= $Page->max_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_max_limit" name="x<?= $Page->RowIndex ?>_max_limit" id="x<?= $Page->RowIndex ?>_max_limit" size="30" placeholder="<?= HtmlEncode($Page->max_limit->getPlaceHolder()) ?>" value="<?= $Page->max_limit->EditValue ?>"<?= $Page->max_limit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->max_limit->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_max_limit">
<span<?= $Page->max_limit->viewAttributes() ?>>
<?= $Page->max_limit->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->min_limit->Visible) { // min_limit ?>
        <td data-name="min_limit" <?= $Page->min_limit->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_min_limit" class="form-group">
<input type="<?= $Page->min_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_min_limit" name="x<?= $Page->RowIndex ?>_min_limit" id="x<?= $Page->RowIndex ?>_min_limit" size="30" placeholder="<?= HtmlEncode($Page->min_limit->getPlaceHolder()) ?>" value="<?= $Page->min_limit->EditValue ?>"<?= $Page->min_limit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->min_limit->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_min_limit" data-hidden="1" name="o<?= $Page->RowIndex ?>_min_limit" id="o<?= $Page->RowIndex ?>_min_limit" value="<?= HtmlEncode($Page->min_limit->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_min_limit" class="form-group">
<input type="<?= $Page->min_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_min_limit" name="x<?= $Page->RowIndex ?>_min_limit" id="x<?= $Page->RowIndex ?>_min_limit" size="30" placeholder="<?= HtmlEncode($Page->min_limit->getPlaceHolder()) ?>" value="<?= $Page->min_limit->EditValue ?>"<?= $Page->min_limit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->min_limit->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_min_limit">
<span<?= $Page->min_limit->viewAttributes() ?>>
<?= $Page->min_limit->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price" <?= $Page->price->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_price" class="form-group">
<input type="<?= $Page->price->getInputTextType() ?>" data-table="z_price_settings" data-field="x_price" name="x<?= $Page->RowIndex ?>_price" id="x<?= $Page->RowIndex ?>_price" size="30" placeholder="<?= HtmlEncode($Page->price->getPlaceHolder()) ?>" value="<?= $Page->price->EditValue ?>"<?= $Page->price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_price" data-hidden="1" name="o<?= $Page->RowIndex ?>_price" id="o<?= $Page->RowIndex ?>_price" value="<?= HtmlEncode($Page->price->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_price" class="form-group">
<input type="<?= $Page->price->getInputTextType() ?>" data-table="z_price_settings" data-field="x_price" name="x<?= $Page->RowIndex ?>_price" id="x<?= $Page->RowIndex ?>_price" size="30" placeholder="<?= HtmlEncode($Page->price->getPlaceHolder()) ?>" value="<?= $Page->price->EditValue ?>"<?= $Page->price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <td data-name="operator_fee" <?= $Page->operator_fee->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_operator_fee" class="form-group">
<input type="<?= $Page->operator_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_operator_fee" name="x<?= $Page->RowIndex ?>_operator_fee" id="x<?= $Page->RowIndex ?>_operator_fee" size="30" placeholder="<?= HtmlEncode($Page->operator_fee->getPlaceHolder()) ?>" value="<?= $Page->operator_fee->EditValue ?>"<?= $Page->operator_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->operator_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_operator_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_operator_fee" id="o<?= $Page->RowIndex ?>_operator_fee" value="<?= HtmlEncode($Page->operator_fee->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_operator_fee" class="form-group">
<input type="<?= $Page->operator_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_operator_fee" name="x<?= $Page->RowIndex ?>_operator_fee" id="x<?= $Page->RowIndex ?>_operator_fee" size="30" placeholder="<?= HtmlEncode($Page->operator_fee->getPlaceHolder()) ?>" value="<?= $Page->operator_fee->EditValue ?>"<?= $Page->operator_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->operator_fee->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_operator_fee">
<span<?= $Page->operator_fee->viewAttributes() ?>>
<?= $Page->operator_fee->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->agency_fee->Visible) { // agency_fee ?>
        <td data-name="agency_fee" <?= $Page->agency_fee->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_agency_fee" class="form-group">
<input type="<?= $Page->agency_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_agency_fee" name="x<?= $Page->RowIndex ?>_agency_fee" id="x<?= $Page->RowIndex ?>_agency_fee" size="30" placeholder="<?= HtmlEncode($Page->agency_fee->getPlaceHolder()) ?>" value="<?= $Page->agency_fee->EditValue ?>"<?= $Page->agency_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->agency_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_agency_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_agency_fee" id="o<?= $Page->RowIndex ?>_agency_fee" value="<?= HtmlEncode($Page->agency_fee->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_agency_fee" class="form-group">
<input type="<?= $Page->agency_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_agency_fee" name="x<?= $Page->RowIndex ?>_agency_fee" id="x<?= $Page->RowIndex ?>_agency_fee" size="30" placeholder="<?= HtmlEncode($Page->agency_fee->getPlaceHolder()) ?>" value="<?= $Page->agency_fee->EditValue ?>"<?= $Page->agency_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->agency_fee->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_agency_fee">
<span<?= $Page->agency_fee->viewAttributes() ?>>
<?= $Page->agency_fee->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <td data-name="lamata_fee" <?= $Page->lamata_fee->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_lamata_fee" class="form-group">
<input type="<?= $Page->lamata_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lamata_fee" name="x<?= $Page->RowIndex ?>_lamata_fee" id="x<?= $Page->RowIndex ?>_lamata_fee" size="30" placeholder="<?= HtmlEncode($Page->lamata_fee->getPlaceHolder()) ?>" value="<?= $Page->lamata_fee->EditValue ?>"<?= $Page->lamata_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->lamata_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_lamata_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_lamata_fee" id="o<?= $Page->RowIndex ?>_lamata_fee" value="<?= HtmlEncode($Page->lamata_fee->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_lamata_fee" class="form-group">
<input type="<?= $Page->lamata_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lamata_fee" name="x<?= $Page->RowIndex ?>_lamata_fee" id="x<?= $Page->RowIndex ?>_lamata_fee" size="30" placeholder="<?= HtmlEncode($Page->lamata_fee->getPlaceHolder()) ?>" value="<?= $Page->lamata_fee->EditValue ?>"<?= $Page->lamata_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->lamata_fee->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_lamata_fee">
<span<?= $Page->lamata_fee->viewAttributes() ?>>
<?= $Page->lamata_fee->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <td data-name="lasaa_fee" <?= $Page->lasaa_fee->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_lasaa_fee" class="form-group">
<input type="<?= $Page->lasaa_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lasaa_fee" name="x<?= $Page->RowIndex ?>_lasaa_fee" id="x<?= $Page->RowIndex ?>_lasaa_fee" size="30" placeholder="<?= HtmlEncode($Page->lasaa_fee->getPlaceHolder()) ?>" value="<?= $Page->lasaa_fee->EditValue ?>"<?= $Page->lasaa_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->lasaa_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_lasaa_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_lasaa_fee" id="o<?= $Page->RowIndex ?>_lasaa_fee" value="<?= HtmlEncode($Page->lasaa_fee->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_lasaa_fee" class="form-group">
<input type="<?= $Page->lasaa_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lasaa_fee" name="x<?= $Page->RowIndex ?>_lasaa_fee" id="x<?= $Page->RowIndex ?>_lasaa_fee" size="30" placeholder="<?= HtmlEncode($Page->lasaa_fee->getPlaceHolder()) ?>" value="<?= $Page->lasaa_fee->EditValue ?>"<?= $Page->lasaa_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->lasaa_fee->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_lasaa_fee">
<span<?= $Page->lasaa_fee->viewAttributes() ?>>
<?= $Page->lasaa_fee->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->printers_fee->Visible) { // printers_fee ?>
        <td data-name="printers_fee" <?= $Page->printers_fee->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_printers_fee" class="form-group">
<input type="<?= $Page->printers_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_printers_fee" name="x<?= $Page->RowIndex ?>_printers_fee" id="x<?= $Page->RowIndex ?>_printers_fee" size="30" placeholder="<?= HtmlEncode($Page->printers_fee->getPlaceHolder()) ?>" value="<?= $Page->printers_fee->EditValue ?>"<?= $Page->printers_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->printers_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_printers_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_printers_fee" id="o<?= $Page->RowIndex ?>_printers_fee" value="<?= HtmlEncode($Page->printers_fee->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_printers_fee" class="form-group">
<input type="<?= $Page->printers_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_printers_fee" name="x<?= $Page->RowIndex ?>_printers_fee" id="x<?= $Page->RowIndex ?>_printers_fee" size="30" placeholder="<?= HtmlEncode($Page->printers_fee->getPlaceHolder()) ?>" value="<?= $Page->printers_fee->EditValue ?>"<?= $Page->printers_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->printers_fee->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_printers_fee">
<span<?= $Page->printers_fee->viewAttributes() ?>>
<?= $Page->printers_fee->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->active->Visible) { // active ?>
        <td data-name="active" <?= $Page->active->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_active" class="form-group">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->active->isInvalidClass() ?>" data-table="z_price_settings" data-field="x_active" name="x<?= $Page->RowIndex ?>_active[]" id="x<?= $Page->RowIndex ?>_active_947320" value="1"<?= ConvertToBool($Page->active->CurrentValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?>>
    <label class="custom-control-label" for="x<?= $Page->RowIndex ?>_active_947320"></label>
</div>
<div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_active" data-hidden="1" name="o<?= $Page->RowIndex ?>_active[]" id="o<?= $Page->RowIndex ?>_active[]" value="<?= HtmlEncode($Page->active->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_active" class="form-group">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->active->isInvalidClass() ?>" data-table="z_price_settings" data-field="x_active" name="x<?= $Page->RowIndex ?>_active[]" id="x<?= $Page->RowIndex ?>_active_166459" value="1"<?= ConvertToBool($Page->active->CurrentValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?>>
    <label class="custom-control-label" for="x<?= $Page->RowIndex ?>_active_166459"></label>
</div>
<div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_active">
<span<?= $Page->active->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_active_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->active->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->active->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_active_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ts_created->Visible) { // ts_created ?>
        <td data-name="ts_created" <?= $Page->ts_created->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_ts_created" class="form-group">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="z_price_settings" data-field="x_ts_created" name="x<?= $Page->RowIndex ?>_ts_created" id="x<?= $Page->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fz_price_settingslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fz_price_settingslist", "x<?= $Page->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_ts_created" data-hidden="1" name="o<?= $Page->RowIndex ?>_ts_created" id="o<?= $Page->RowIndex ?>_ts_created" value="<?= HtmlEncode($Page->ts_created->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_ts_created" class="form-group">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="z_price_settings" data-field="x_ts_created" name="x<?= $Page->RowIndex ?>_ts_created" id="x<?= $Page->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fz_price_settingslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fz_price_settingslist", "x<?= $Page->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_z_price_settings_ts_created">
<span<?= $Page->ts_created->viewAttributes() ?>>
<?= $Page->ts_created->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fz_price_settingslist","load"], function () {
    fz_price_settingslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Page->isGridAdd())
        if (!$Page->Recordset->EOF) {
            $Page->Recordset->moveNext();
        }
}
?>
<?php
    if ($Page->isGridAdd() || $Page->isGridEdit()) {
        $Page->RowIndex = '$rowindex$';
        $Page->loadRowValues();

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_z_price_settings", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowAttrs->appendClass("ew-template");
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowIndex);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el$rowindex$_z_price_settings_id" class="form-group z_price_settings_id"></span>
<input type="hidden" data-table="z_price_settings" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->platform_id->Visible) { // platform_id ?>
        <td data-name="platform_id">
<span id="el$rowindex$_z_price_settings_platform_id" class="form-group z_price_settings_platform_id">
    <select
        id="x<?= $Page->RowIndex ?>_platform_id"
        name="x<?= $Page->RowIndex ?>_platform_id"
        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_platform_id"
        data-table="z_price_settings"
        data-field="x_platform_id"
        data-value-separator="<?= $Page->platform_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->platform_id->getPlaceHolder()) ?>"
        <?= $Page->platform_id->editAttributes() ?>>
        <?= $Page->platform_id->selectOptionListHtml("x{$Page->RowIndex}_platform_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->platform_id->getErrorMessage() ?></div>
<?= $Page->platform_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_platform_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_platform_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_platform_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_platform_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_platform_id" id="o<?= $Page->RowIndex ?>_platform_id" value="<?= HtmlEncode($Page->platform_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <td data-name="inventory_id">
<span id="el$rowindex$_z_price_settings_inventory_id" class="form-group z_price_settings_inventory_id">
    <select
        id="x<?= $Page->RowIndex ?>_inventory_id"
        name="x<?= $Page->RowIndex ?>_inventory_id"
        class="form-control ew-select<?= $Page->inventory_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_inventory_id"
        data-table="z_price_settings"
        data-field="x_inventory_id"
        data-value-separator="<?= $Page->inventory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->inventory_id->getPlaceHolder()) ?>"
        <?= $Page->inventory_id->editAttributes() ?>>
        <?= $Page->inventory_id->selectOptionListHtml("x{$Page->RowIndex}_inventory_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->inventory_id->getErrorMessage() ?></div>
<?= $Page->inventory_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_inventory_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_inventory_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_inventory_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_inventory_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.inventory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_inventory_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_inventory_id" id="o<?= $Page->RowIndex ?>_inventory_id" value="<?= HtmlEncode($Page->inventory_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->print_stage_id->Visible) { // print_stage_id ?>
        <td data-name="print_stage_id">
<span id="el$rowindex$_z_price_settings_print_stage_id" class="form-group z_price_settings_print_stage_id">
    <select
        id="x<?= $Page->RowIndex ?>_print_stage_id"
        name="x<?= $Page->RowIndex ?>_print_stage_id"
        class="form-control ew-select<?= $Page->print_stage_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_print_stage_id"
        data-table="z_price_settings"
        data-field="x_print_stage_id"
        data-value-separator="<?= $Page->print_stage_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->print_stage_id->getPlaceHolder()) ?>"
        <?= $Page->print_stage_id->editAttributes() ?>>
        <?= $Page->print_stage_id->selectOptionListHtml("x{$Page->RowIndex}_print_stage_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->print_stage_id->getErrorMessage() ?></div>
<?= $Page->print_stage_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_print_stage_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_print_stage_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_print_stage_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_print_stage_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.print_stage_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_print_stage_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_print_stage_id" id="o<?= $Page->RowIndex ?>_print_stage_id" value="<?= HtmlEncode($Page->print_stage_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
        <td data-name="bus_size_id">
<span id="el$rowindex$_z_price_settings_bus_size_id" class="form-group z_price_settings_bus_size_id">
    <select
        id="x<?= $Page->RowIndex ?>_bus_size_id"
        name="x<?= $Page->RowIndex ?>_bus_size_id"
        class="form-control ew-select<?= $Page->bus_size_id->isInvalidClass() ?>"
        data-select2-id="z_price_settings_x<?= $Page->RowIndex ?>_bus_size_id"
        data-table="z_price_settings"
        data-field="x_bus_size_id"
        data-value-separator="<?= $Page->bus_size_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bus_size_id->getPlaceHolder()) ?>"
        <?= $Page->bus_size_id->editAttributes() ?>>
        <?= $Page->bus_size_id->selectOptionListHtml("x{$Page->RowIndex}_bus_size_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->bus_size_id->getErrorMessage() ?></div>
<?= $Page->bus_size_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_bus_size_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='z_price_settings_x<?= $Page->RowIndex ?>_bus_size_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_bus_size_id", selectId: "z_price_settings_x<?= $Page->RowIndex ?>_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.z_price_settings.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_bus_size_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_bus_size_id" id="o<?= $Page->RowIndex ?>_bus_size_id" value="<?= HtmlEncode($Page->bus_size_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->details->Visible) { // details ?>
        <td data-name="details">
<span id="el$rowindex$_z_price_settings_details" class="form-group z_price_settings_details">
<textarea data-table="z_price_settings" data-field="x_details" name="x<?= $Page->RowIndex ?>_details" id="x<?= $Page->RowIndex ?>_details" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->details->getPlaceHolder()) ?>"<?= $Page->details->editAttributes() ?>><?= $Page->details->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->details->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_details" data-hidden="1" name="o<?= $Page->RowIndex ?>_details" id="o<?= $Page->RowIndex ?>_details" value="<?= HtmlEncode($Page->details->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->max_limit->Visible) { // max_limit ?>
        <td data-name="max_limit">
<span id="el$rowindex$_z_price_settings_max_limit" class="form-group z_price_settings_max_limit">
<input type="<?= $Page->max_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_max_limit" name="x<?= $Page->RowIndex ?>_max_limit" id="x<?= $Page->RowIndex ?>_max_limit" size="30" placeholder="<?= HtmlEncode($Page->max_limit->getPlaceHolder()) ?>" value="<?= $Page->max_limit->EditValue ?>"<?= $Page->max_limit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->max_limit->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_max_limit" data-hidden="1" name="o<?= $Page->RowIndex ?>_max_limit" id="o<?= $Page->RowIndex ?>_max_limit" value="<?= HtmlEncode($Page->max_limit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->min_limit->Visible) { // min_limit ?>
        <td data-name="min_limit">
<span id="el$rowindex$_z_price_settings_min_limit" class="form-group z_price_settings_min_limit">
<input type="<?= $Page->min_limit->getInputTextType() ?>" data-table="z_price_settings" data-field="x_min_limit" name="x<?= $Page->RowIndex ?>_min_limit" id="x<?= $Page->RowIndex ?>_min_limit" size="30" placeholder="<?= HtmlEncode($Page->min_limit->getPlaceHolder()) ?>" value="<?= $Page->min_limit->EditValue ?>"<?= $Page->min_limit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->min_limit->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_min_limit" data-hidden="1" name="o<?= $Page->RowIndex ?>_min_limit" id="o<?= $Page->RowIndex ?>_min_limit" value="<?= HtmlEncode($Page->min_limit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price">
<span id="el$rowindex$_z_price_settings_price" class="form-group z_price_settings_price">
<input type="<?= $Page->price->getInputTextType() ?>" data-table="z_price_settings" data-field="x_price" name="x<?= $Page->RowIndex ?>_price" id="x<?= $Page->RowIndex ?>_price" size="30" placeholder="<?= HtmlEncode($Page->price->getPlaceHolder()) ?>" value="<?= $Page->price->EditValue ?>"<?= $Page->price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_price" data-hidden="1" name="o<?= $Page->RowIndex ?>_price" id="o<?= $Page->RowIndex ?>_price" value="<?= HtmlEncode($Page->price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->operator_fee->Visible) { // operator_fee ?>
        <td data-name="operator_fee">
<span id="el$rowindex$_z_price_settings_operator_fee" class="form-group z_price_settings_operator_fee">
<input type="<?= $Page->operator_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_operator_fee" name="x<?= $Page->RowIndex ?>_operator_fee" id="x<?= $Page->RowIndex ?>_operator_fee" size="30" placeholder="<?= HtmlEncode($Page->operator_fee->getPlaceHolder()) ?>" value="<?= $Page->operator_fee->EditValue ?>"<?= $Page->operator_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->operator_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_operator_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_operator_fee" id="o<?= $Page->RowIndex ?>_operator_fee" value="<?= HtmlEncode($Page->operator_fee->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->agency_fee->Visible) { // agency_fee ?>
        <td data-name="agency_fee">
<span id="el$rowindex$_z_price_settings_agency_fee" class="form-group z_price_settings_agency_fee">
<input type="<?= $Page->agency_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_agency_fee" name="x<?= $Page->RowIndex ?>_agency_fee" id="x<?= $Page->RowIndex ?>_agency_fee" size="30" placeholder="<?= HtmlEncode($Page->agency_fee->getPlaceHolder()) ?>" value="<?= $Page->agency_fee->EditValue ?>"<?= $Page->agency_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->agency_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_agency_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_agency_fee" id="o<?= $Page->RowIndex ?>_agency_fee" value="<?= HtmlEncode($Page->agency_fee->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->lamata_fee->Visible) { // lamata_fee ?>
        <td data-name="lamata_fee">
<span id="el$rowindex$_z_price_settings_lamata_fee" class="form-group z_price_settings_lamata_fee">
<input type="<?= $Page->lamata_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lamata_fee" name="x<?= $Page->RowIndex ?>_lamata_fee" id="x<?= $Page->RowIndex ?>_lamata_fee" size="30" placeholder="<?= HtmlEncode($Page->lamata_fee->getPlaceHolder()) ?>" value="<?= $Page->lamata_fee->EditValue ?>"<?= $Page->lamata_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->lamata_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_lamata_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_lamata_fee" id="o<?= $Page->RowIndex ?>_lamata_fee" value="<?= HtmlEncode($Page->lamata_fee->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->lasaa_fee->Visible) { // lasaa_fee ?>
        <td data-name="lasaa_fee">
<span id="el$rowindex$_z_price_settings_lasaa_fee" class="form-group z_price_settings_lasaa_fee">
<input type="<?= $Page->lasaa_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_lasaa_fee" name="x<?= $Page->RowIndex ?>_lasaa_fee" id="x<?= $Page->RowIndex ?>_lasaa_fee" size="30" placeholder="<?= HtmlEncode($Page->lasaa_fee->getPlaceHolder()) ?>" value="<?= $Page->lasaa_fee->EditValue ?>"<?= $Page->lasaa_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->lasaa_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_lasaa_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_lasaa_fee" id="o<?= $Page->RowIndex ?>_lasaa_fee" value="<?= HtmlEncode($Page->lasaa_fee->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->printers_fee->Visible) { // printers_fee ?>
        <td data-name="printers_fee">
<span id="el$rowindex$_z_price_settings_printers_fee" class="form-group z_price_settings_printers_fee">
<input type="<?= $Page->printers_fee->getInputTextType() ?>" data-table="z_price_settings" data-field="x_printers_fee" name="x<?= $Page->RowIndex ?>_printers_fee" id="x<?= $Page->RowIndex ?>_printers_fee" size="30" placeholder="<?= HtmlEncode($Page->printers_fee->getPlaceHolder()) ?>" value="<?= $Page->printers_fee->EditValue ?>"<?= $Page->printers_fee->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->printers_fee->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_printers_fee" data-hidden="1" name="o<?= $Page->RowIndex ?>_printers_fee" id="o<?= $Page->RowIndex ?>_printers_fee" value="<?= HtmlEncode($Page->printers_fee->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->active->Visible) { // active ?>
        <td data-name="active">
<span id="el$rowindex$_z_price_settings_active" class="form-group z_price_settings_active">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->active->isInvalidClass() ?>" data-table="z_price_settings" data-field="x_active" name="x<?= $Page->RowIndex ?>_active[]" id="x<?= $Page->RowIndex ?>_active_867139" value="1"<?= ConvertToBool($Page->active->CurrentValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?>>
    <label class="custom-control-label" for="x<?= $Page->RowIndex ?>_active_867139"></label>
</div>
<div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_active" data-hidden="1" name="o<?= $Page->RowIndex ?>_active[]" id="o<?= $Page->RowIndex ?>_active[]" value="<?= HtmlEncode($Page->active->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ts_created->Visible) { // ts_created ?>
        <td data-name="ts_created">
<span id="el$rowindex$_z_price_settings_ts_created" class="form-group z_price_settings_ts_created">
<input type="<?= $Page->ts_created->getInputTextType() ?>" data-table="z_price_settings" data-field="x_ts_created" name="x<?= $Page->RowIndex ?>_ts_created" id="x<?= $Page->RowIndex ?>_ts_created" placeholder="<?= HtmlEncode($Page->ts_created->getPlaceHolder()) ?>" value="<?= $Page->ts_created->EditValue ?>"<?= $Page->ts_created->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ts_created->getErrorMessage() ?></div>
<?php if (!$Page->ts_created->ReadOnly && !$Page->ts_created->Disabled && !isset($Page->ts_created->EditAttrs["readonly"]) && !isset($Page->ts_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fz_price_settingslist", "datetimepicker"], function() {
    ew.createDateTimePicker("fz_price_settingslist", "x<?= $Page->RowIndex ?>_ts_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="z_price_settings" data-field="x_ts_created" data-hidden="1" name="o<?= $Page->RowIndex ?>_ts_created" id="o<?= $Page->RowIndex ?>_ts_created" value="<?= HtmlEncode($Page->ts_created->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fz_price_settingslist","load"], function() {
    fz_price_settingslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isEdit()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
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
<?php } ?>

<?php

namespace PHPMaker2021\test;

// Page object
$MainCampaignsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmain_campaignsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fmain_campaignsadd = currentForm = new ew.Form("fmain_campaignsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "main_campaigns")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.main_campaigns)
        ew.vars.tables.main_campaigns = currentTable;
    fmain_campaignsadd.addFields([
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["inventory_id", [fields.inventory_id.visible && fields.inventory_id.required ? ew.Validators.required(fields.inventory_id.caption) : null], fields.inventory_id.isInvalid],
        ["platform_id", [fields.platform_id.visible && fields.platform_id.required ? ew.Validators.required(fields.platform_id.caption) : null], fields.platform_id.isInvalid],
        ["bus_size_id", [fields.bus_size_id.visible && fields.bus_size_id.required ? ew.Validators.required(fields.bus_size_id.caption) : null], fields.bus_size_id.isInvalid],
        ["price_id", [fields.price_id.visible && fields.price_id.required ? ew.Validators.required(fields.price_id.caption) : null], fields.price_id.isInvalid],
        ["quantity", [fields.quantity.visible && fields.quantity.required ? ew.Validators.required(fields.quantity.caption) : null, ew.Validators.integer], fields.quantity.isInvalid],
        ["start_date", [fields.start_date.visible && fields.start_date.required ? ew.Validators.required(fields.start_date.caption) : null, ew.Validators.datetime(0)], fields.start_date.isInvalid],
        ["end_date", [fields.end_date.visible && fields.end_date.required ? ew.Validators.required(fields.end_date.caption) : null, ew.Validators.datetime(0)], fields.end_date.isInvalid],
        ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
        ["vendor_id", [fields.vendor_id.visible && fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null], fields.vendor_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_campaignsadd,
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
    fmain_campaignsadd.validate = function () {
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
    fmain_campaignsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_campaignsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_campaignsadd.lists.name = <?= $Page->name->toClientList($Page) ?>;
    fmain_campaignsadd.lists.inventory_id = <?= $Page->inventory_id->toClientList($Page) ?>;
    fmain_campaignsadd.lists.platform_id = <?= $Page->platform_id->toClientList($Page) ?>;
    fmain_campaignsadd.lists.bus_size_id = <?= $Page->bus_size_id->toClientList($Page) ?>;
    fmain_campaignsadd.lists.price_id = <?= $Page->price_id->toClientList($Page) ?>;
    fmain_campaignsadd.lists.vendor_id = <?= $Page->vendor_id->toClientList($Page) ?>;
    loadjs.done("fmain_campaignsadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    var ext;$("#x_end_date").parent().on("change.datetimepicker",(function({date:e,oldDate:t}){var a=$("#x_start_date").parent().datetimepicker("date"),i=e;if(moment.isMoment(a)&&moment.isMoment(i)&&i.isAfter(a)){var r=i.diff(a,"days");$("#x_end_date_help").text(r+" days")}else $("#x_end_date_help").text("Please correct the dates")})),$("#x_start_date").parent().on("change.datetimepicker",(function({date:e,oldDate:t}){ext=e,console.log(e,ext),moment.isMoment(e)&&$("#x_end_date").parent().datetimepicker("date",e.add(30,"days"))})),$("#x_quantity").on("keyup keypress blur change",(function(){var e=parseInt($("#x_quantity").val()),t=parseInt($("#x_price_id").val());if(e&&t){var a="<iframe id='price-preview2' title='price-preview2' width='300' height='300' frameborder='0' hspace='0' vspace='0' marginheight='0' marginwidth='0' scrolling='no' height='230' src='"+("spook?price_id="+t+"&quantity="+e+"&html=1")+"'></iframe>";$(".price-preview").html(a)}else $(".price-preview").html("<div></div>")}));
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fmain_campaignsadd" id="fmain_campaignsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_campaigns">
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
<?php if ($Page->getCurrentMasterTable() == "main_users") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="main_users">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->user_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "y_platforms") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="y_platforms">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->platform_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_main_campaigns_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_campaigns_name">
<?php
$onchange = $Page->name->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->name->EditAttrs["onchange"] = "";
?>
<span id="as_x_name" class="ew-auto-suggest">
    <input type="<?= $Page->name->getInputTextType() ?>" class="form-control" name="sv_x_name" id="sv_x_name" value="<?= RemoveHtml($Page->name->EditValue) ?>" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_campaigns" data-field="x_name" data-input="sv_x_name" data-value-separator="<?= $Page->name->displayValueSeparatorAttribute() ?>" name="x_name" id="x_name" value="<?= HtmlEncode($Page->name->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_campaignsadd"], function() {
    fmain_campaignsadd.createAutoSuggest(Object.assign({"id":"x_name","forceSelect":false}, ew.vars.tables.main_campaigns.fields.name.autoSuggestOptions));
});
</script>
<?= $Page->name->Lookup->getParamTag($Page, "p_x_name") ?>
</span>
<?php } else { ?>
<span id="el_main_campaigns_name">
<span<?= $Page->name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->name->getDisplayValue($Page->name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_name" data-hidden="1" name="x_name" id="x_name" value="<?= HtmlEncode($Page->name->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
    <div id="r_inventory_id" class="form-group row">
        <label id="elh_main_campaigns_inventory_id" for="x_inventory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->inventory_id->caption() ?><?= $Page->inventory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->inventory_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_campaigns_inventory_id">
<?php $Page->inventory_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_inventory_id"
        name="x_inventory_id"
        class="form-control ew-select<?= $Page->inventory_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x_inventory_id"
        data-table="main_campaigns"
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
    var el = document.querySelector("select[data-select2-id='main_campaigns_x_inventory_id']"),
        options = { name: "x_inventory_id", selectId: "main_campaigns_x_inventory_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.inventory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_campaigns_inventory_id">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->inventory_id->getDisplayValue($Page->inventory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_inventory_id" data-hidden="1" name="x_inventory_id" id="x_inventory_id" value="<?= HtmlEncode($Page->inventory_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->platform_id->Visible) { // platform_id ?>
    <div id="r_platform_id" class="form-group row">
        <label id="elh_main_campaigns_platform_id" for="x_platform_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->platform_id->caption() ?><?= $Page->platform_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->platform_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if ($Page->platform_id->getSessionValue() != "") { ?>
<span id="el_main_campaigns_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->platform_id->getDisplayValue($Page->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_platform_id" name="x_platform_id" value="<?= HtmlEncode($Page->platform_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_main_campaigns_platform_id">
<?php $Page->platform_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_platform_id"
        name="x_platform_id"
        class="form-control ew-select<?= $Page->platform_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x_platform_id"
        data-table="main_campaigns"
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
    var el = document.querySelector("select[data-select2-id='main_campaigns_x_platform_id']"),
        options = { name: "x_platform_id", selectId: "main_campaigns_x_platform_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.platform_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_main_campaigns_platform_id">
<span<?= $Page->platform_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->platform_id->getDisplayValue($Page->platform_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_platform_id" data-hidden="1" name="x_platform_id" id="x_platform_id" value="<?= HtmlEncode($Page->platform_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bus_size_id->Visible) { // bus_size_id ?>
    <div id="r_bus_size_id" class="form-group row">
        <label id="elh_main_campaigns_bus_size_id" for="x_bus_size_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bus_size_id->caption() ?><?= $Page->bus_size_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bus_size_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_campaigns_bus_size_id">
<?php $Page->bus_size_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_bus_size_id"
        name="x_bus_size_id"
        class="form-control ew-select<?= $Page->bus_size_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x_bus_size_id"
        data-table="main_campaigns"
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
    var el = document.querySelector("select[data-select2-id='main_campaigns_x_bus_size_id']"),
        options = { name: "x_bus_size_id", selectId: "main_campaigns_x_bus_size_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.bus_size_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_campaigns_bus_size_id">
<span<?= $Page->bus_size_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->bus_size_id->getDisplayValue($Page->bus_size_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_bus_size_id" data-hidden="1" name="x_bus_size_id" id="x_bus_size_id" value="<?= HtmlEncode($Page->bus_size_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->price_id->Visible) { // price_id ?>
    <div id="r_price_id" class="form-group row">
        <label id="elh_main_campaigns_price_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->price_id->caption() ?><?= $Page->price_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->price_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_campaigns_price_id">
<template id="tp_x_price_id">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="main_campaigns" data-field="x_price_id" name="x_price_id" id="x_price_id"<?= $Page->price_id->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_price_id" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_price_id"
    name="x_price_id"
    value="<?= HtmlEncode($Page->price_id->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_price_id"
    data-target="dsl_x_price_id"
    data-repeatcolumn="1"
    class="form-control<?= $Page->price_id->isInvalidClass() ?>"
    data-table="main_campaigns"
    data-field="x_price_id"
    data-value-separator="<?= $Page->price_id->displayValueSeparatorAttribute() ?>"
    <?= $Page->price_id->editAttributes() ?>>
<?= $Page->price_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->price_id->getErrorMessage() ?></div>
<?= $Page->price_id->Lookup->getParamTag($Page, "p_x_price_id") ?>
</span>
<?php } else { ?>
<span id="el_main_campaigns_price_id">
<span<?= $Page->price_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->price_id->getDisplayValue($Page->price_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_price_id" data-hidden="1" name="x_price_id" id="x_price_id" value="<?= HtmlEncode($Page->price_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <div id="r_quantity" class="form-group row">
        <label id="elh_main_campaigns_quantity" for="x_quantity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->quantity->caption() ?><?= $Page->quantity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->quantity->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_campaigns_quantity">
<input type="<?= $Page->quantity->getInputTextType() ?>" data-table="main_campaigns" data-field="x_quantity" name="x_quantity" id="x_quantity" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>" value="<?= $Page->quantity->EditValue ?>"<?= $Page->quantity->editAttributes() ?> aria-describedby="x_quantity_help">
<?= $Page->quantity->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_main_campaigns_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->quantity->getDisplayValue($Page->quantity->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_quantity" data-hidden="1" name="x_quantity" id="x_quantity" value="<?= HtmlEncode($Page->quantity->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
    <div id="r_start_date" class="form-group row">
        <label id="elh_main_campaigns_start_date" for="x_start_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->start_date->caption() ?><?= $Page->start_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->start_date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_campaigns_start_date">
<input type="<?= $Page->start_date->getInputTextType() ?>" data-table="main_campaigns" data-field="x_start_date" name="x_start_date" id="x_start_date" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>" value="<?= $Page->start_date->EditValue ?>"<?= $Page->start_date->editAttributes() ?> aria-describedby="x_start_date_help">
<?= $Page->start_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage() ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_campaignsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_campaignsadd", "x_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_main_campaigns_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->start_date->getDisplayValue($Page->start_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_start_date" data-hidden="1" name="x_start_date" id="x_start_date" value="<?= HtmlEncode($Page->start_date->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
    <div id="r_end_date" class="form-group row">
        <label id="elh_main_campaigns_end_date" for="x_end_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->end_date->caption() ?><?= $Page->end_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->end_date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_main_campaigns_end_date">
<input type="<?= $Page->end_date->getInputTextType() ?>" data-table="main_campaigns" data-field="x_end_date" name="x_end_date" id="x_end_date" placeholder="<?= HtmlEncode($Page->end_date->getPlaceHolder()) ?>" value="<?= $Page->end_date->EditValue ?>"<?= $Page->end_date->editAttributes() ?> aria-describedby="x_end_date_help">
<?= $Page->end_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->end_date->getErrorMessage() ?></div>
<?php if (!$Page->end_date->ReadOnly && !$Page->end_date->Disabled && !isset($Page->end_date->EditAttrs["readonly"]) && !isset($Page->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmain_campaignsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fmain_campaignsadd", "x_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_main_campaigns_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->end_date->getDisplayValue($Page->end_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_end_date" data-hidden="1" name="x_end_date" id="x_end_date" value="<?= HtmlEncode($Page->end_date->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
    <?php if (!$Page->isConfirm()) { ?>
    <?php if ($Page->user_id->getSessionValue() != "") { ?>
    <input type="hidden" id="x_user_id" name="x_user_id" value="<?= HtmlEncode($Page->user_id->CurrentValue) ?>" data-hidden="1">
    <?php } else { ?>
    <span id="el_main_campaigns_user_id">
    <input type="hidden" data-table="main_campaigns" data-field="x_user_id" data-hidden="1" name="x_user_id" id="x_user_id" value="<?= HtmlEncode($Page->user_id->CurrentValue) ?>">
    </span>
    <?php } ?>
    <?php } else { ?>
    <input type="hidden" data-table="main_campaigns" data-field="x_user_id" data-hidden="1" name="x_user_id" id="x_user_id" value="<?= HtmlEncode($Page->user_id->FormValue) ?>">
    <?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
    <div id="r_vendor_id" class="form-group row">
        <label id="elh_main_campaigns_vendor_id" for="x_vendor_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vendor_id->caption() ?><?= $Page->vendor_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->vendor_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if ($Page->vendor_id->getSessionValue() != "") { ?>
<span id="el_main_campaigns_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_vendor_id" name="x_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_main_campaigns_vendor_id">
    <select
        id="x_vendor_id"
        name="x_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x_vendor_id"
        data-table="main_campaigns"
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
    var el = document.querySelector("select[data-select2-id='main_campaigns_x_vendor_id']"),
        options = { name: "x_vendor_id", selectId: "main_campaigns_x_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_main_campaigns_vendor_id">
    <select
        id="x_vendor_id"
        name="x_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_campaigns_x_vendor_id"
        data-table="main_campaigns"
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
    var el = document.querySelector("select[data-select2-id='main_campaigns_x_vendor_id']"),
        options = { name: "x_vendor_id", selectId: "main_campaigns_x_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_campaigns.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_main_campaigns_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_campaigns" data-field="x_vendor_id" data-hidden="1" name="x_vendor_id" id="x_vendor_id" value="<?= HtmlEncode($Page->vendor_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("sub_media_allocation", explode(",", $Page->getCurrentDetailTable())) && $sub_media_allocation->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sub_media_allocation", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubMediaAllocationGrid.php" ?>
<?php } ?>
<?php
    if (in_array("main_transactions", explode(",", $Page->getCurrentDetailTable())) && $main_transactions->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("main_transactions", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MainTransactionsGrid.php" ?>
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
    ew.addEventHandlers("main_campaigns");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

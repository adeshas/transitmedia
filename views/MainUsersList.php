<?php

namespace PHPMaker2021\test;

// Page object
$MainUsersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
if (!ew.vars.tables.main_users) ew.vars.tables.main_users = <?= JsonEncode(GetClientVar("tables", "main_users")) ?>;
var currentForm, currentPageID;
var fmain_userslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fmain_userslist = currentForm = new ew.Form("fmain_userslist", "list");
    fmain_userslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var fields = ew.vars.tables.main_users.fields;
    fmain_userslist.addFields([
        ["id", [fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
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
        var f = fmain_userslist,
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
    fmain_userslist.validate = function () {
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
    fmain_userslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "name", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "_username", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "_password", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "_email", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "user_type", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "vendor_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "reportsto", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fmain_userslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_userslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_userslist.lists.user_type = <?= $Page->user_type->toClientList($Page) ?>;
    fmain_userslist.lists.vendor_id = <?= $Page->vendor_id->toClientList($Page) ?>;
    fmain_userslist.lists.reportsto = <?= $Page->reportsto->toClientList($Page) ?>;
    loadjs.done("fmain_userslist");
});
var fmain_userslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fmain_userslistsrch = currentSearchForm = new ew.Form("fmain_userslistsrch");

    // Dynamic selection lists

    // Filters
    fmain_userslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fmain_userslistsrch");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "y_vendors") {
    if ($Page->MasterRecordExists) {
        include_once "views/YVendorsMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fmain_userslistsrch" id="fmain_userslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fmain_userslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="main_users">
    <div class="ew-extended-search">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> main_users">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fmain_userslist" id="fmain_userslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="main_users">
<?php if ($Page->getCurrentMasterTable() == "y_vendors" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="y_vendors">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->vendor_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_main_users" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_main_userslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_main_users_id" class="main_users_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div id="elh_main_users_name" class="main_users_name"><?= $Page->renderSort($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Page->_username->headerCellClass() ?>"><div id="elh_main_users__username" class="main_users__username"><?= $Page->renderSort($Page->_username) ?></div></th>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <th data-name="_password" class="<?= $Page->_password->headerCellClass() ?>"><div id="elh_main_users__password" class="main_users__password"><?= $Page->renderSort($Page->_password) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_main_users__email" class="main_users__email"><?= $Page->renderSort($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->user_type->Visible) { // user_type ?>
        <th data-name="user_type" class="<?= $Page->user_type->headerCellClass() ?>"><div id="elh_main_users_user_type" class="main_users_user_type"><?= $Page->renderSort($Page->user_type) ?></div></th>
<?php } ?>
<?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <th data-name="vendor_id" class="<?= $Page->vendor_id->headerCellClass() ?>"><div id="elh_main_users_vendor_id" class="main_users_vendor_id"><?= $Page->renderSort($Page->vendor_id) ?></div></th>
<?php } ?>
<?php if ($Page->reportsto->Visible) { // reportsto ?>
        <th data-name="reportsto" class="<?= $Page->reportsto->headerCellClass() ?>"><div id="elh_main_users_reportsto" class="main_users_reportsto"><?= $Page->renderSort($Page->reportsto) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
    if ($Page->isAdd() || $Page->isCopy()) {
        $Page->RowIndex = 0;
        $Page->KeyCount = $Page->RowIndex;
        if ($Page->isAdd())
            $Page->loadRowValues();
        if ($Page->EventCancelled) // Insert failed
            $Page->restoreFormValues(); // Restore form values

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_main_users", "data-rowtype" => ROWTYPE_ADD]);
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
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el<?= $Page->RowCount ?>_main_users_id" class="form-group main_users_id"></span>
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name">
<span id="el<?= $Page->RowCount ?>_main_users_name" class="form-group main_users_name">
<textarea data-table="main_users" data-field="x_name" name="x<?= $Page->RowIndex ?>_name" id="x<?= $Page->RowIndex ?>_name" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?>><?= $Page->name->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x_name" data-hidden="1" name="o<?= $Page->RowIndex ?>_name" id="o<?= $Page->RowIndex ?>_name" value="<?= HtmlEncode($Page->name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_username->Visible) { // username ?>
        <td data-name="_username">
<span id="el<?= $Page->RowCount ?>_main_users__username" class="form-group main_users__username">
<textarea data-table="main_users" data-field="x__username" name="x<?= $Page->RowIndex ?>__username" id="x<?= $Page->RowIndex ?>__username" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>"<?= $Page->_username->editAttributes() ?>><?= $Page->_username->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__username" data-hidden="1" name="o<?= $Page->RowIndex ?>__username" id="o<?= $Page->RowIndex ?>__username" value="<?= HtmlEncode($Page->_username->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_password->Visible) { // password ?>
        <td data-name="_password">
<span id="el<?= $Page->RowCount ?>_main_users__password" class="form-group main_users__password">
<div class="input-group">
    <input type="password" name="x<?= $Page->RowIndex ?>__password" id="x<?= $Page->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?>>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__password" data-hidden="1" name="o<?= $Page->RowIndex ?>__password" id="o<?= $Page->RowIndex ?>__password" value="<?= HtmlEncode($Page->_password->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email">
<span id="el<?= $Page->RowCount ?>_main_users__email" class="form-group main_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="main_users" data-field="x__email" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__email" data-hidden="1" name="o<?= $Page->RowIndex ?>__email" id="o<?= $Page->RowIndex ?>__email" value="<?= HtmlEncode($Page->_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->user_type->Visible) { // user_type ?>
        <td data-name="user_type">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_users_user_type" class="form-group main_users_user_type">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->user_type->getDisplayValue($Page->user_type->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_user_type" class="form-group main_users_user_type">
    <select
        id="x<?= $Page->RowIndex ?>_user_type"
        name="x<?= $Page->RowIndex ?>_user_type"
        class="form-control ew-select<?= $Page->user_type->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_user_type"
        data-table="main_users"
        data-field="x_user_type"
        data-value-separator="<?= $Page->user_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_type->getPlaceHolder()) ?>"
        <?= $Page->user_type->editAttributes() ?>>
        <?= $Page->user_type->selectOptionListHtml("x{$Page->RowIndex}_user_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->user_type->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_user_type']"),
        options = { name: "x<?= $Page->RowIndex ?>_user_type", selectId: "main_users_x<?= $Page->RowIndex ?>_user_type", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.main_users.fields.user_type.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.user_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_user_type" data-hidden="1" name="o<?= $Page->RowIndex ?>_user_type" id="o<?= $Page->RowIndex ?>_user_type" value="<?= HtmlEncode($Page->user_type->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<?php if ($Page->vendor_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id" class="form-group main_users_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_vendor_id" name="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id" class="form-group main_users_vendor_id">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id" class="form-group main_users_vendor_id">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->reportsto->Visible) { // reportsto ?>
        <td data-name="reportsto">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_users_reportsto" class="form-group main_users_reportsto">
    <select
        id="x<?= $Page->RowIndex ?>_reportsto"
        name="x<?= $Page->RowIndex ?>_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x{$Page->RowIndex}_reportsto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_reportsto']"),
        options = { name: "x<?= $Page->RowIndex ?>_reportsto", selectId: "main_users_x<?= $Page->RowIndex ?>_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_reportsto" class="form-group main_users_reportsto">
    <select
        id="x<?= $Page->RowIndex ?>_reportsto"
        name="x<?= $Page->RowIndex ?>_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x{$Page->RowIndex}_reportsto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_reportsto']"),
        options = { name: "x<?= $Page->RowIndex ?>_reportsto", selectId: "main_users_x<?= $Page->RowIndex ?>_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="o<?= $Page->RowIndex ?>_reportsto" id="o<?= $Page->RowIndex ?>_reportsto" value="<?= HtmlEncode($Page->reportsto->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fmain_userslist","load"], function() {
    fmain_userslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
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
        if ($Page->isGridEdit() && ($Page->RowType == ROWTYPE_EDIT || $Page->RowType == ROWTYPE_ADD) && $Page->EventCancelled) { // Update failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_main_users", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_main_users_id" class="form-group"></span>
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_users_id" class="form-group">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_users_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_users_name" class="form-group">
<textarea data-table="main_users" data-field="x_name" name="x<?= $Page->RowIndex ?>_name" id="x<?= $Page->RowIndex ?>_name" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?>><?= $Page->name->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x_name" data-hidden="1" name="o<?= $Page->RowIndex ?>_name" id="o<?= $Page->RowIndex ?>_name" value="<?= HtmlEncode($Page->name->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_users_name" class="form-group">
<textarea data-table="main_users" data-field="x_name" name="x<?= $Page->RowIndex ?>_name" id="x<?= $Page->RowIndex ?>_name" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?>><?= $Page->name->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_users_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_username->Visible) { // username ?>
        <td data-name="_username" <?= $Page->_username->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_users__username" class="form-group">
<textarea data-table="main_users" data-field="x__username" name="x<?= $Page->RowIndex ?>__username" id="x<?= $Page->RowIndex ?>__username" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>"<?= $Page->_username->editAttributes() ?>><?= $Page->_username->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__username" data-hidden="1" name="o<?= $Page->RowIndex ?>__username" id="o<?= $Page->RowIndex ?>__username" value="<?= HtmlEncode($Page->_username->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_users__username" class="form-group">
<textarea data-table="main_users" data-field="x__username" name="x<?= $Page->RowIndex ?>__username" id="x<?= $Page->RowIndex ?>__username" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>"<?= $Page->_username->editAttributes() ?>><?= $Page->_username->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_users__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_password->Visible) { // password ?>
        <td data-name="_password" <?= $Page->_password->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_users__password" class="form-group">
<div class="input-group">
    <input type="password" name="x<?= $Page->RowIndex ?>__password" id="x<?= $Page->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?>>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__password" data-hidden="1" name="o<?= $Page->RowIndex ?>__password" id="o<?= $Page->RowIndex ?>__password" value="<?= HtmlEncode($Page->_password->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_users__password" class="form-group">
<div class="input-group">
    <input type="password" name="x<?= $Page->RowIndex ?>__password" id="x<?= $Page->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" value="<?= $Page->_password->EditValue ?>" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?>>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_users__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_main_users__email" class="form-group">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="main_users" data-field="x__email" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__email" data-hidden="1" name="o<?= $Page->RowIndex ?>__email" id="o<?= $Page->RowIndex ?>__email" value="<?= HtmlEncode($Page->_email->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_main_users__email" class="form-group">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="main_users" data-field="x__email" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->user_type->Visible) { // user_type ?>
        <td data-name="user_type" <?= $Page->user_type->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_users_user_type" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->user_type->getDisplayValue($Page->user_type->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_user_type" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_user_type"
        name="x<?= $Page->RowIndex ?>_user_type"
        class="form-control ew-select<?= $Page->user_type->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_user_type"
        data-table="main_users"
        data-field="x_user_type"
        data-value-separator="<?= $Page->user_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_type->getPlaceHolder()) ?>"
        <?= $Page->user_type->editAttributes() ?>>
        <?= $Page->user_type->selectOptionListHtml("x{$Page->RowIndex}_user_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->user_type->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_user_type']"),
        options = { name: "x<?= $Page->RowIndex ?>_user_type", selectId: "main_users_x<?= $Page->RowIndex ?>_user_type", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.main_users.fields.user_type.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.user_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_user_type" data-hidden="1" name="o<?= $Page->RowIndex ?>_user_type" id="o<?= $Page->RowIndex ?>_user_type" value="<?= HtmlEncode($Page->user_type->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_users_user_type" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->user_type->getDisplayValue($Page->user_type->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_user_type" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_user_type"
        name="x<?= $Page->RowIndex ?>_user_type"
        class="form-control ew-select<?= $Page->user_type->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_user_type"
        data-table="main_users"
        data-field="x_user_type"
        data-value-separator="<?= $Page->user_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_type->getPlaceHolder()) ?>"
        <?= $Page->user_type->editAttributes() ?>>
        <?= $Page->user_type->selectOptionListHtml("x{$Page->RowIndex}_user_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->user_type->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_user_type']"),
        options = { name: "x<?= $Page->RowIndex ?>_user_type", selectId: "main_users_x<?= $Page->RowIndex ?>_user_type", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.main_users.fields.user_type.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.user_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_users_user_type">
<span<?= $Page->user_type->viewAttributes() ?>>
<?= $Page->user_type->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" <?= $Page->vendor_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->vendor_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id" class="form-group">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_vendor_id" name="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->vendor_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id" class="form-group">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_vendor_id" name="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_users_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<?= $Page->vendor_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->reportsto->Visible) { // reportsto ?>
        <td data-name="reportsto" <?= $Page->reportsto->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_main_users_reportsto" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_reportsto"
        name="x<?= $Page->RowIndex ?>_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x{$Page->RowIndex}_reportsto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_reportsto']"),
        options = { name: "x<?= $Page->RowIndex ?>_reportsto", selectId: "main_users_x<?= $Page->RowIndex ?>_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_reportsto" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_reportsto"
        name="x<?= $Page->RowIndex ?>_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x{$Page->RowIndex}_reportsto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_reportsto']"),
        options = { name: "x<?= $Page->RowIndex ?>_reportsto", selectId: "main_users_x<?= $Page->RowIndex ?>_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="o<?= $Page->RowIndex ?>_reportsto" id="o<?= $Page->RowIndex ?>_reportsto" value="<?= HtmlEncode($Page->reportsto->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<?php if (SameString($Page->vendor_id->CurrentValue, CurrentUserID())) { ?>
    <span id="el<?= $Page->RowCount ?>_main_users_reportsto" class="form-group">
    <span<?= $Page->reportsto->viewAttributes() ?>>
    <input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->reportsto->getDisplayValue($Page->reportsto->EditValue))) ?>"></span>
    </span>
    <input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="x<?= $Page->RowIndex ?>_reportsto" id="x<?= $Page->RowIndex ?>_reportsto" value="<?= HtmlEncode($Page->reportsto->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_reportsto" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_reportsto"
        name="x<?= $Page->RowIndex ?>_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x{$Page->RowIndex}_reportsto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_reportsto']"),
        options = { name: "x<?= $Page->RowIndex ?>_reportsto", selectId: "main_users_x<?= $Page->RowIndex ?>_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_main_users_reportsto" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_reportsto"
        name="x<?= $Page->RowIndex ?>_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x{$Page->RowIndex}_reportsto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_reportsto']"),
        options = { name: "x<?= $Page->RowIndex ?>_reportsto", selectId: "main_users_x<?= $Page->RowIndex ?>_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_main_users_reportsto">
<span<?= $Page->reportsto->viewAttributes() ?>>
<?= $Page->reportsto->getViewValue() ?></span>
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
loadjs.ready(["fmain_userslist","load"], function () {
    fmain_userslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_main_users", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_main_users_id" class="form-group main_users_id"></span>
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name">
<span id="el$rowindex$_main_users_name" class="form-group main_users_name">
<textarea data-table="main_users" data-field="x_name" name="x<?= $Page->RowIndex ?>_name" id="x<?= $Page->RowIndex ?>_name" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?>><?= $Page->name->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x_name" data-hidden="1" name="o<?= $Page->RowIndex ?>_name" id="o<?= $Page->RowIndex ?>_name" value="<?= HtmlEncode($Page->name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_username->Visible) { // username ?>
        <td data-name="_username">
<span id="el$rowindex$_main_users__username" class="form-group main_users__username">
<textarea data-table="main_users" data-field="x__username" name="x<?= $Page->RowIndex ?>__username" id="x<?= $Page->RowIndex ?>__username" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>"<?= $Page->_username->editAttributes() ?>><?= $Page->_username->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__username" data-hidden="1" name="o<?= $Page->RowIndex ?>__username" id="o<?= $Page->RowIndex ?>__username" value="<?= HtmlEncode($Page->_username->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_password->Visible) { // password ?>
        <td data-name="_password">
<span id="el$rowindex$_main_users__password" class="form-group main_users__password">
<div class="input-group">
    <input type="password" name="x<?= $Page->RowIndex ?>__password" id="x<?= $Page->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?>>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__password" data-hidden="1" name="o<?= $Page->RowIndex ?>__password" id="o<?= $Page->RowIndex ?>__password" value="<?= HtmlEncode($Page->_password->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email">
<span id="el$rowindex$_main_users__email" class="form-group main_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="main_users" data-field="x__email" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__email" data-hidden="1" name="o<?= $Page->RowIndex ?>__email" id="o<?= $Page->RowIndex ?>__email" value="<?= HtmlEncode($Page->_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->user_type->Visible) { // user_type ?>
        <td data-name="user_type">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_main_users_user_type" class="form-group main_users_user_type">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->user_type->getDisplayValue($Page->user_type->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_main_users_user_type" class="form-group main_users_user_type">
    <select
        id="x<?= $Page->RowIndex ?>_user_type"
        name="x<?= $Page->RowIndex ?>_user_type"
        class="form-control ew-select<?= $Page->user_type->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_user_type"
        data-table="main_users"
        data-field="x_user_type"
        data-value-separator="<?= $Page->user_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_type->getPlaceHolder()) ?>"
        <?= $Page->user_type->editAttributes() ?>>
        <?= $Page->user_type->selectOptionListHtml("x{$Page->RowIndex}_user_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->user_type->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_user_type']"),
        options = { name: "x<?= $Page->RowIndex ?>_user_type", selectId: "main_users_x<?= $Page->RowIndex ?>_user_type", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.main_users.fields.user_type.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.user_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_user_type" data-hidden="1" name="o<?= $Page->RowIndex ?>_user_type" id="o<?= $Page->RowIndex ?>_user_type" value="<?= HtmlEncode($Page->user_type->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<?php if ($Page->vendor_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_users_vendor_id" class="form-group main_users_vendor_id">
<span<?= $Page->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendor_id->getDisplayValue($Page->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_vendor_id" name="x<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow($Page->CurrentAction)) { // Non system admin ?>
<span id="el$rowindex$_main_users_vendor_id" class="form-group main_users_vendor_id">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_users_vendor_id" class="form-group main_users_vendor_id">
    <select
        id="x<?= $Page->RowIndex ?>_vendor_id"
        name="x<?= $Page->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Page->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Page->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->vendor_id->getPlaceHolder()) ?>"
        <?= $Page->vendor_id->editAttributes() ?>>
        <?= $Page->vendor_id->selectOptionListHtml("x{$Page->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->vendor_id->getErrorMessage() ?></div>
<?= $Page->vendor_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Page->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_vendor_id" id="o<?= $Page->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Page->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->reportsto->Visible) { // reportsto ?>
        <td data-name="reportsto">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_main_users_reportsto" class="form-group main_users_reportsto">
    <select
        id="x<?= $Page->RowIndex ?>_reportsto"
        name="x<?= $Page->RowIndex ?>_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x{$Page->RowIndex}_reportsto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_reportsto']"),
        options = { name: "x<?= $Page->RowIndex ?>_reportsto", selectId: "main_users_x<?= $Page->RowIndex ?>_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_users_reportsto" class="form-group main_users_reportsto">
    <select
        id="x<?= $Page->RowIndex ?>_reportsto"
        name="x<?= $Page->RowIndex ?>_reportsto"
        class="form-control ew-select<?= $Page->reportsto->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Page->RowIndex ?>_reportsto"
        data-table="main_users"
        data-field="x_reportsto"
        data-value-separator="<?= $Page->reportsto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reportsto->getPlaceHolder()) ?>"
        <?= $Page->reportsto->editAttributes() ?>>
        <?= $Page->reportsto->selectOptionListHtml("x{$Page->RowIndex}_reportsto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->reportsto->getErrorMessage() ?></div>
<?= $Page->reportsto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_reportsto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Page->RowIndex ?>_reportsto']"),
        options = { name: "x<?= $Page->RowIndex ?>_reportsto", selectId: "main_users_x<?= $Page->RowIndex ?>_reportsto", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.reportsto.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="o<?= $Page->RowIndex ?>_reportsto" id="o<?= $Page->RowIndex ?>_reportsto" value="<?= HtmlEncode($Page->reportsto->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fmain_userslist","load"], function() {
    fmain_userslist.updateLists(<?= $Page->RowIndex ?>);
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
<?php if ($Page->isAdd() || $Page->isCopy()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
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
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
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
    ew.addEventHandlers("main_users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

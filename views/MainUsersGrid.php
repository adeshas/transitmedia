<?php

namespace PHPMaker2021\test;

// Set up and run Grid object
$Grid = Container("MainUsersGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
if (!ew.vars.tables.main_users) ew.vars.tables.main_users = <?= JsonEncode(GetClientVar("tables", "main_users")) ?>;
var currentForm, currentPageID;
var fmain_usersgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fmain_usersgrid = new ew.Form("fmain_usersgrid", "grid");
    fmain_usersgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var fields = ew.vars.tables.main_users.fields;
    fmain_usersgrid.addFields([
        ["id", [fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["name", [fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["_username", [fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
        ["_password", [fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
        ["_email", [fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
        ["user_type", [fields.user_type.required ? ew.Validators.required(fields.user_type.caption) : null], fields.user_type.isInvalid],
        ["vendor_id", [fields.vendor_id.required ? ew.Validators.required(fields.vendor_id.caption) : null], fields.vendor_id.isInvalid],
        ["reportsto", [fields.reportsto.required ? ew.Validators.required(fields.reportsto.caption) : null, ew.Validators.integer], fields.reportsto.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmain_usersgrid,
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
    fmain_usersgrid.validate = function () {
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
        return true;
    }

    // Check empty row
    fmain_usersgrid.emptyRow = function (rowIndex) {
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
    fmain_usersgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmain_usersgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmain_usersgrid.lists.user_type = <?= $Grid->user_type->toClientList($Grid) ?>;
    fmain_usersgrid.lists.vendor_id = <?= $Grid->vendor_id->toClientList($Grid) ?>;
    fmain_usersgrid.lists.reportsto = <?= $Grid->reportsto->toClientList($Grid) ?>;
    loadjs.done("fmain_usersgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> main_users">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fmain_usersgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_main_users" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_main_usersgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_main_users_id" class="main_users_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Grid->name->headerCellClass() ?>"><div id="elh_main_users_name" class="main_users_name"><?= $Grid->renderSort($Grid->name) ?></div></th>
<?php } ?>
<?php if ($Grid->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Grid->_username->headerCellClass() ?>"><div id="elh_main_users__username" class="main_users__username"><?= $Grid->renderSort($Grid->_username) ?></div></th>
<?php } ?>
<?php if ($Grid->_password->Visible) { // password ?>
        <th data-name="_password" class="<?= $Grid->_password->headerCellClass() ?>"><div id="elh_main_users__password" class="main_users__password"><?= $Grid->renderSort($Grid->_password) ?></div></th>
<?php } ?>
<?php if ($Grid->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Grid->_email->headerCellClass() ?>"><div id="elh_main_users__email" class="main_users__email"><?= $Grid->renderSort($Grid->_email) ?></div></th>
<?php } ?>
<?php if ($Grid->user_type->Visible) { // user_type ?>
        <th data-name="user_type" class="<?= $Grid->user_type->headerCellClass() ?>"><div id="elh_main_users_user_type" class="main_users_user_type"><?= $Grid->renderSort($Grid->user_type) ?></div></th>
<?php } ?>
<?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <th data-name="vendor_id" class="<?= $Grid->vendor_id->headerCellClass() ?>"><div id="elh_main_users_vendor_id" class="main_users_vendor_id"><?= $Grid->renderSort($Grid->vendor_id) ?></div></th>
<?php } ?>
<?php if ($Grid->reportsto->Visible) { // reportsto ?>
        <th data-name="reportsto" class="<?= $Grid->reportsto->headerCellClass() ?>"><div id="elh_main_users_reportsto" class="main_users_reportsto"><?= $Grid->renderSort($Grid->reportsto) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_main_users", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id" <?= $Grid->id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_id" class="form-group"></span>
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="fmain_usersgrid$x<?= $Grid->RowIndex ?>_id" id="fmain_usersgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="fmain_usersgrid$o<?= $Grid->RowIndex ?>_id" id="fmain_usersgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name" <?= $Grid->name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_name" class="form-group">
<textarea data-table="main_users" data-field="x_name" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>><?= $Grid->name->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_name" class="form-group">
<textarea data-table="main_users" data-field="x_name" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>><?= $Grid->name->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_name">
<span<?= $Grid->name->viewAttributes() ?>>
<?= $Grid->name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_users" data-field="x_name" data-hidden="1" name="fmain_usersgrid$x<?= $Grid->RowIndex ?>_name" id="fmain_usersgrid$x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
<input type="hidden" data-table="main_users" data-field="x_name" data-hidden="1" name="fmain_usersgrid$o<?= $Grid->RowIndex ?>_name" id="fmain_usersgrid$o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_username->Visible) { // username ?>
        <td data-name="_username" <?= $Grid->_username->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_users__username" class="form-group">
<textarea data-table="main_users" data-field="x__username" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>"<?= $Grid->_username->editAttributes() ?>><?= $Grid->_username->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__username" data-hidden="1" name="o<?= $Grid->RowIndex ?>__username" id="o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_users__username" class="form-group">
<textarea data-table="main_users" data-field="x__username" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>"<?= $Grid->_username->editAttributes() ?>><?= $Grid->_username->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_users__username">
<span<?= $Grid->_username->viewAttributes() ?>>
<?= $Grid->_username->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_users" data-field="x__username" data-hidden="1" name="fmain_usersgrid$x<?= $Grid->RowIndex ?>__username" id="fmain_usersgrid$x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->FormValue) ?>">
<input type="hidden" data-table="main_users" data-field="x__username" data-hidden="1" name="fmain_usersgrid$o<?= $Grid->RowIndex ?>__username" id="fmain_usersgrid$o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_password->Visible) { // password ?>
        <td data-name="_password" <?= $Grid->_password->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_users__password" class="form-group">
<div class="input-group">
    <input type="password" name="x<?= $Grid->RowIndex ?>__password" id="x<?= $Grid->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" placeholder="<?= HtmlEncode($Grid->_password->getPlaceHolder()) ?>"<?= $Grid->_password->editAttributes() ?>>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<div class="invalid-feedback"><?= $Grid->_password->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__password" data-hidden="1" name="o<?= $Grid->RowIndex ?>__password" id="o<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_users__password" class="form-group">
<div class="input-group">
    <input type="password" name="x<?= $Grid->RowIndex ?>__password" id="x<?= $Grid->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" value="<?= $Grid->_password->EditValue ?>" placeholder="<?= HtmlEncode($Grid->_password->getPlaceHolder()) ?>"<?= $Grid->_password->editAttributes() ?>>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<div class="invalid-feedback"><?= $Grid->_password->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_users__password">
<span<?= $Grid->_password->viewAttributes() ?>>
<?= $Grid->_password->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_users" data-field="x__password" data-hidden="1" name="fmain_usersgrid$x<?= $Grid->RowIndex ?>__password" id="fmain_usersgrid$x<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->FormValue) ?>">
<input type="hidden" data-table="main_users" data-field="x__password" data-hidden="1" name="fmain_usersgrid$o<?= $Grid->RowIndex ?>__password" id="fmain_usersgrid$o<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_email->Visible) { // email ?>
        <td data-name="_email" <?= $Grid->_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_users__email" class="form-group">
<input type="<?= $Grid->_email->getInputTextType() ?>" data-table="main_users" data-field="x__email" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>" value="<?= $Grid->_email->EditValue ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="main_users" data-field="x__email" data-hidden="1" name="o<?= $Grid->RowIndex ?>__email" id="o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_users__email" class="form-group">
<input type="<?= $Grid->_email->getInputTextType() ?>" data-table="main_users" data-field="x__email" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>" value="<?= $Grid->_email->EditValue ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_users__email">
<span<?= $Grid->_email->viewAttributes() ?>>
<?= $Grid->_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_users" data-field="x__email" data-hidden="1" name="fmain_usersgrid$x<?= $Grid->RowIndex ?>__email" id="fmain_usersgrid$x<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->FormValue) ?>">
<input type="hidden" data-table="main_users" data-field="x__email" data-hidden="1" name="fmain_usersgrid$o<?= $Grid->RowIndex ?>__email" id="fmain_usersgrid$o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->user_type->Visible) { // user_type ?>
        <td data-name="user_type" <?= $Grid->user_type->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_main_users_user_type" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->user_type->getDisplayValue($Grid->user_type->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_users_user_type" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_user_type"
        name="x<?= $Grid->RowIndex ?>_user_type"
        class="form-control ew-select<?= $Grid->user_type->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Grid->RowIndex ?>_user_type"
        data-table="main_users"
        data-field="x_user_type"
        data-value-separator="<?= $Grid->user_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->user_type->getPlaceHolder()) ?>"
        <?= $Grid->user_type->editAttributes() ?>>
        <?= $Grid->user_type->selectOptionListHtml("x{$Grid->RowIndex}_user_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->user_type->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Grid->RowIndex ?>_user_type']"),
        options = { name: "x<?= $Grid->RowIndex ?>_user_type", selectId: "main_users_x<?= $Grid->RowIndex ?>_user_type", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.main_users.fields.user_type.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.user_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_user_type" data-hidden="1" name="o<?= $Grid->RowIndex ?>_user_type" id="o<?= $Grid->RowIndex ?>_user_type" value="<?= HtmlEncode($Grid->user_type->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_main_users_user_type" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->user_type->getDisplayValue($Grid->user_type->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_users_user_type" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_user_type"
        name="x<?= $Grid->RowIndex ?>_user_type"
        class="form-control ew-select<?= $Grid->user_type->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Grid->RowIndex ?>_user_type"
        data-table="main_users"
        data-field="x_user_type"
        data-value-separator="<?= $Grid->user_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->user_type->getPlaceHolder()) ?>"
        <?= $Grid->user_type->editAttributes() ?>>
        <?= $Grid->user_type->selectOptionListHtml("x{$Grid->RowIndex}_user_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->user_type->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Grid->RowIndex ?>_user_type']"),
        options = { name: "x<?= $Grid->RowIndex ?>_user_type", selectId: "main_users_x<?= $Grid->RowIndex ?>_user_type", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.main_users.fields.user_type.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.user_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_user_type">
<span<?= $Grid->user_type->viewAttributes() ?>>
<?= $Grid->user_type->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_users" data-field="x_user_type" data-hidden="1" name="fmain_usersgrid$x<?= $Grid->RowIndex ?>_user_type" id="fmain_usersgrid$x<?= $Grid->RowIndex ?>_user_type" value="<?= HtmlEncode($Grid->user_type->FormValue) ?>">
<input type="hidden" data-table="main_users" data-field="x_user_type" data-hidden="1" name="fmain_usersgrid$o<?= $Grid->RowIndex ?>_user_type" id="fmain_usersgrid$o<?= $Grid->RowIndex ?>_user_type" value="<?= HtmlEncode($Grid->user_type->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id" <?= $Grid->vendor_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->vendor_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_users_vendor_id" class="form-group">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_vendor_id" name="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_main_users_vendor_id" class="form-group">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_users_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"
        <?= $Grid->vendor_id->editAttributes() ?>>
        <?= $Grid->vendor_id->selectOptionListHtml("x{$Grid->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_vendor_id" id="o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->vendor_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_main_users_vendor_id" class="form-group">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_vendor_id" name="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_main_users_vendor_id" class="form-group">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_main_users_vendor_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"
        <?= $Grid->vendor_id->editAttributes() ?>>
        <?= $Grid->vendor_id->selectOptionListHtml("x{$Grid->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<?= $Grid->vendor_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="fmain_usersgrid$x<?= $Grid->RowIndex ?>_vendor_id" id="fmain_usersgrid$x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->FormValue) ?>">
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="fmain_usersgrid$o<?= $Grid->RowIndex ?>_vendor_id" id="fmain_usersgrid$o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->reportsto->Visible) { // reportsto ?>
        <td data-name="reportsto" <?= $Grid->reportsto->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_reportsto" class="form-group">
<?php
$onchange = $Grid->reportsto->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->reportsto->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_reportsto" class="ew-auto-suggest">
    <input type="<?= $Grid->reportsto->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_reportsto" id="sv_x<?= $Grid->RowIndex ?>_reportsto" value="<?= RemoveHtml($Grid->reportsto->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->reportsto->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->reportsto->getPlaceHolder()) ?>"<?= $Grid->reportsto->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_users" data-field="x_reportsto" data-input="sv_x<?= $Grid->RowIndex ?>_reportsto" data-value-separator="<?= $Grid->reportsto->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_reportsto" id="x<?= $Grid->RowIndex ?>_reportsto" value="<?= HtmlEncode($Grid->reportsto->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->reportsto->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_usersgrid"], function() {
    fmain_usersgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_reportsto","forceSelect":false}, ew.vars.tables.main_users.fields.reportsto.autoSuggestOptions));
});
</script>
<?= $Grid->reportsto->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_reportsto") ?>
</span>
<input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_reportsto" id="o<?= $Grid->RowIndex ?>_reportsto" value="<?= HtmlEncode($Grid->reportsto->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_reportsto" class="form-group">
<?php
$onchange = $Grid->reportsto->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->reportsto->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_reportsto" class="ew-auto-suggest">
    <input type="<?= $Grid->reportsto->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_reportsto" id="sv_x<?= $Grid->RowIndex ?>_reportsto" value="<?= RemoveHtml($Grid->reportsto->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->reportsto->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->reportsto->getPlaceHolder()) ?>"<?= $Grid->reportsto->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_users" data-field="x_reportsto" data-input="sv_x<?= $Grid->RowIndex ?>_reportsto" data-value-separator="<?= $Grid->reportsto->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_reportsto" id="x<?= $Grid->RowIndex ?>_reportsto" value="<?= HtmlEncode($Grid->reportsto->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->reportsto->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_usersgrid"], function() {
    fmain_usersgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_reportsto","forceSelect":false}, ew.vars.tables.main_users.fields.reportsto.autoSuggestOptions));
});
</script>
<?= $Grid->reportsto->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_reportsto") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_main_users_reportsto">
<span<?= $Grid->reportsto->viewAttributes() ?>>
<?= $Grid->reportsto->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="fmain_usersgrid$x<?= $Grid->RowIndex ?>_reportsto" id="fmain_usersgrid$x<?= $Grid->RowIndex ?>_reportsto" value="<?= HtmlEncode($Grid->reportsto->FormValue) ?>">
<input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="fmain_usersgrid$o<?= $Grid->RowIndex ?>_reportsto" id="fmain_usersgrid$o<?= $Grid->RowIndex ?>_reportsto" value="<?= HtmlEncode($Grid->reportsto->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fmain_usersgrid","load"], function () {
    fmain_usersgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_main_users", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_users_id" class="form-group main_users_id"></span>
<?php } else { ?>
<span id="el$rowindex$_main_users_id" class="form-group main_users_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_users_name" class="form-group main_users_name">
<textarea data-table="main_users" data-field="x_name" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>><?= $Grid->name->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_users_name" class="form-group main_users_name">
<span<?= $Grid->name->viewAttributes() ?>>
<?= $Grid->name->ViewValue ?></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->_username->Visible) { // username ?>
        <td data-name="_username">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_users__username" class="form-group main_users__username">
<textarea data-table="main_users" data-field="x__username" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>"<?= $Grid->_username->editAttributes() ?>><?= $Grid->_username->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_users__username" class="form-group main_users__username">
<span<?= $Grid->_username->viewAttributes() ?>>
<?= $Grid->_username->ViewValue ?></span>
</span>
<input type="hidden" data-table="main_users" data-field="x__username" data-hidden="1" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x__username" data-hidden="1" name="o<?= $Grid->RowIndex ?>__username" id="o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->_password->Visible) { // password ?>
        <td data-name="_password">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_users__password" class="form-group main_users__password">
<div class="input-group">
    <input type="password" name="x<?= $Grid->RowIndex ?>__password" id="x<?= $Grid->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" placeholder="<?= HtmlEncode($Grid->_password->getPlaceHolder()) ?>"<?= $Grid->_password->editAttributes() ?>>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<div class="invalid-feedback"><?= $Grid->_password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_users__password" class="form-group main_users__password">
<span<?= $Grid->_password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_password->getDisplayValue($Grid->_password->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x__password" data-hidden="1" name="x<?= $Grid->RowIndex ?>__password" id="x<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x__password" data-hidden="1" name="o<?= $Grid->RowIndex ?>__password" id="o<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->_email->Visible) { // email ?>
        <td data-name="_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_users__email" class="form-group main_users__email">
<input type="<?= $Grid->_email->getInputTextType() ?>" data-table="main_users" data-field="x__email" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>" value="<?= $Grid->_email->EditValue ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_users__email" class="form-group main_users__email">
<span<?= $Grid->_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_email->getDisplayValue($Grid->_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x__email" data-hidden="1" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x__email" data-hidden="1" name="o<?= $Grid->RowIndex ?>__email" id="o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->user_type->Visible) { // user_type ?>
        <td data-name="user_type">
<?php if (!$Grid->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_main_users_user_type" class="form-group main_users_user_type">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->user_type->getDisplayValue($Grid->user_type->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_main_users_user_type" class="form-group main_users_user_type">
    <select
        id="x<?= $Grid->RowIndex ?>_user_type"
        name="x<?= $Grid->RowIndex ?>_user_type"
        class="form-control ew-select<?= $Grid->user_type->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Grid->RowIndex ?>_user_type"
        data-table="main_users"
        data-field="x_user_type"
        data-value-separator="<?= $Grid->user_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->user_type->getPlaceHolder()) ?>"
        <?= $Grid->user_type->editAttributes() ?>>
        <?= $Grid->user_type->selectOptionListHtml("x{$Grid->RowIndex}_user_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->user_type->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Grid->RowIndex ?>_user_type']"),
        options = { name: "x<?= $Grid->RowIndex ?>_user_type", selectId: "main_users_x<?= $Grid->RowIndex ?>_user_type", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.main_users.fields.user_type.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.user_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_users_user_type" class="form-group main_users_user_type">
<span<?= $Grid->user_type->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->user_type->getDisplayValue($Grid->user_type->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_user_type" data-hidden="1" name="x<?= $Grid->RowIndex ?>_user_type" id="x<?= $Grid->RowIndex ?>_user_type" value="<?= HtmlEncode($Grid->user_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_user_type" data-hidden="1" name="o<?= $Grid->RowIndex ?>_user_type" id="o<?= $Grid->RowIndex ?>_user_type" value="<?= HtmlEncode($Grid->user_type->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->vendor_id->Visible) { // vendor_id ?>
        <td data-name="vendor_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->vendor_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_main_users_vendor_id" class="form-group main_users_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_vendor_id" name="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_main_users_vendor_id" class="form-group main_users_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_main_users_vendor_id" class="form-group main_users_vendor_id">
    <select
        id="x<?= $Grid->RowIndex ?>_vendor_id"
        name="x<?= $Grid->RowIndex ?>_vendor_id"
        class="form-control ew-select<?= $Grid->vendor_id->isInvalidClass() ?>"
        data-select2-id="main_users_x<?= $Grid->RowIndex ?>_vendor_id"
        data-table="main_users"
        data-field="x_vendor_id"
        data-value-separator="<?= $Grid->vendor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->vendor_id->getPlaceHolder()) ?>"
        <?= $Grid->vendor_id->editAttributes() ?>>
        <?= $Grid->vendor_id->selectOptionListHtml("x{$Grid->RowIndex}_vendor_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->vendor_id->getErrorMessage() ?></div>
<?= $Grid->vendor_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_vendor_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='main_users_x<?= $Grid->RowIndex ?>_vendor_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_vendor_id", selectId: "main_users_x<?= $Grid->RowIndex ?>_vendor_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.main_users.fields.vendor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_users_vendor_id" class="form-group main_users_vendor_id">
<span<?= $Grid->vendor_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vendor_id->getDisplayValue($Grid->vendor_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_vendor_id" id="x<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_vendor_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_vendor_id" id="o<?= $Grid->RowIndex ?>_vendor_id" value="<?= HtmlEncode($Grid->vendor_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->reportsto->Visible) { // reportsto ?>
        <td data-name="reportsto">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_main_users_reportsto" class="form-group main_users_reportsto">
<?php
$onchange = $Grid->reportsto->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->reportsto->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_reportsto" class="ew-auto-suggest">
    <input type="<?= $Grid->reportsto->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_reportsto" id="sv_x<?= $Grid->RowIndex ?>_reportsto" value="<?= RemoveHtml($Grid->reportsto->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->reportsto->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->reportsto->getPlaceHolder()) ?>"<?= $Grid->reportsto->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="main_users" data-field="x_reportsto" data-input="sv_x<?= $Grid->RowIndex ?>_reportsto" data-value-separator="<?= $Grid->reportsto->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_reportsto" id="x<?= $Grid->RowIndex ?>_reportsto" value="<?= HtmlEncode($Grid->reportsto->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->reportsto->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmain_usersgrid"], function() {
    fmain_usersgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_reportsto","forceSelect":false}, ew.vars.tables.main_users.fields.reportsto.autoSuggestOptions));
});
</script>
<?= $Grid->reportsto->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_reportsto") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_users_reportsto" class="form-group main_users_reportsto">
<span<?= $Grid->reportsto->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->reportsto->getDisplayValue($Grid->reportsto->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="x<?= $Grid->RowIndex ?>_reportsto" id="x<?= $Grid->RowIndex ?>_reportsto" value="<?= HtmlEncode($Grid->reportsto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_users" data-field="x_reportsto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_reportsto" id="o<?= $Grid->RowIndex ?>_reportsto" value="<?= HtmlEncode($Grid->reportsto->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fmain_usersgrid","load"], function() {
    fmain_usersgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmain_usersgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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

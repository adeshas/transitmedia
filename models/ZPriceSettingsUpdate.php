<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ZPriceSettingsUpdate extends ZPriceSettings
{
    use MessagesTrait;

    // Page ID
    public $PageID = "update";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'z_price_settings';

    // Page object name
    public $PageObjName = "ZPriceSettingsUpdate";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;
        $this->TokenTimeout = SessionTimeoutTime();

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (z_price_settings)
        if (!isset($GLOBALS["z_price_settings"]) || get_class($GLOBALS["z_price_settings"]) == PROJECT_NAMESPACE . "z_price_settings") {
            $GLOBALS["z_price_settings"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'z_price_settings');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("z_price_settings"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "ZPriceSettingsView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-update-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $RecKeys;
    public $Disabled;
    public $UpdateCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->platform_id->setVisibility();
        $this->inventory_id->setVisibility();
        $this->print_stage_id->setVisibility();
        $this->bus_size_id->setVisibility();
        $this->details->setVisibility();
        $this->max_limit->setVisibility();
        $this->min_limit->setVisibility();
        $this->price->setVisibility();
        $this->operator_fee->setVisibility();
        $this->agency_fee->setVisibility();
        $this->lamata_fee->setVisibility();
        $this->lasaa_fee->setVisibility();
        $this->printers_fee->setVisibility();
        $this->active->setVisibility();
        $this->ts_created->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->platform_id);
        $this->setupLookupOptions($this->inventory_id);
        $this->setupLookupOptions($this->print_stage_id);
        $this->setupLookupOptions($this->bus_size_id);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-update-form ew-horizontal";

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Try to load keys from list form
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        if (Post("action") !== null && Post("action") !== "") {
            // Get action
            $this->CurrentAction = Post("action");
            $this->loadFormValues(); // Get form values

            // Validate form
            if (!$this->validateForm()) {
                $this->CurrentAction = "show"; // Form error, reset action
                if (!$this->hasInvalidFields()) { // No fields selected
                    $this->setFailureMessage($Language->phrase("NoFieldSelected"));
                }
            }
        } else {
            $this->loadMultiUpdateValues(); // Load initial values to form
        }
        if (count($this->RecKeys) <= 0) {
            $this->terminate("ZPriceSettingsList"); // No records selected, return to list
            return;
        }
        if ($this->isUpdate()) {
                if ($this->updateRows()) { // Update Records based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
                    }
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                } else {
                    $this->restoreFormValues(); // Restore form values
                }
        }

        // Render row
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = ROWTYPE_VIEW; // Render view
            $this->Disabled = " disabled";
        } else {
            $this->RowType = ROWTYPE_EDIT; // Render edit
            $this->Disabled = "";
        }
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Rendering event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Load initial values to form if field values are identical in all selected records
    protected function loadMultiUpdateValues()
    {
        $this->CurrentFilter = $this->getFilterFromRecordKeys();

        // Load recordset
        if ($rs = $this->loadRecordset()) {
            $i = 1;
            while (!$rs->EOF) {
                if ($i == 1) {
                    $this->platform_id->setDbValue($rs->fields['platform_id']);
                    $this->inventory_id->setDbValue($rs->fields['inventory_id']);
                    $this->print_stage_id->setDbValue($rs->fields['print_stage_id']);
                    $this->bus_size_id->setDbValue($rs->fields['bus_size_id']);
                    $this->details->setDbValue($rs->fields['details']);
                    $this->max_limit->setDbValue($rs->fields['max_limit']);
                    $this->min_limit->setDbValue($rs->fields['min_limit']);
                    $this->price->setDbValue($rs->fields['price']);
                    $this->operator_fee->setDbValue($rs->fields['operator_fee']);
                    $this->agency_fee->setDbValue($rs->fields['agency_fee']);
                    $this->lamata_fee->setDbValue($rs->fields['lamata_fee']);
                    $this->lasaa_fee->setDbValue($rs->fields['lasaa_fee']);
                    $this->printers_fee->setDbValue($rs->fields['printers_fee']);
                    $this->active->setDbValue($rs->fields['active']);
                    $this->ts_created->setDbValue($rs->fields['ts_created']);
                } else {
                    if (!CompareValue($this->platform_id->DbValue, $rs->fields['platform_id'])) {
                        $this->platform_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->inventory_id->DbValue, $rs->fields['inventory_id'])) {
                        $this->inventory_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->print_stage_id->DbValue, $rs->fields['print_stage_id'])) {
                        $this->print_stage_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->bus_size_id->DbValue, $rs->fields['bus_size_id'])) {
                        $this->bus_size_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->details->DbValue, $rs->fields['details'])) {
                        $this->details->CurrentValue = null;
                    }
                    if (!CompareValue($this->max_limit->DbValue, $rs->fields['max_limit'])) {
                        $this->max_limit->CurrentValue = null;
                    }
                    if (!CompareValue($this->min_limit->DbValue, $rs->fields['min_limit'])) {
                        $this->min_limit->CurrentValue = null;
                    }
                    if (!CompareValue($this->price->DbValue, $rs->fields['price'])) {
                        $this->price->CurrentValue = null;
                    }
                    if (!CompareValue($this->operator_fee->DbValue, $rs->fields['operator_fee'])) {
                        $this->operator_fee->CurrentValue = null;
                    }
                    if (!CompareValue($this->agency_fee->DbValue, $rs->fields['agency_fee'])) {
                        $this->agency_fee->CurrentValue = null;
                    }
                    if (!CompareValue($this->lamata_fee->DbValue, $rs->fields['lamata_fee'])) {
                        $this->lamata_fee->CurrentValue = null;
                    }
                    if (!CompareValue($this->lasaa_fee->DbValue, $rs->fields['lasaa_fee'])) {
                        $this->lasaa_fee->CurrentValue = null;
                    }
                    if (!CompareValue($this->printers_fee->DbValue, $rs->fields['printers_fee'])) {
                        $this->printers_fee->CurrentValue = null;
                    }
                    if (!CompareValue($this->active->DbValue, $rs->fields['active'])) {
                        $this->active->CurrentValue = null;
                    }
                    if (!CompareValue($this->ts_created->DbValue, $rs->fields['ts_created'])) {
                        $this->ts_created->CurrentValue = null;
                    }
                }
                $i++;
                $rs->moveNext();
            }
            $rs->close();
        }
    }

    // Set up key value
    protected function setupKeyValues($key)
    {
        $keyFld = $key;
        if (!is_numeric($keyFld)) {
            return false;
        }
        $this->id->OldValue = $keyFld;
        return true;
    }

    // Update all selected rows
    protected function updateRows()
    {
        global $Language;
        $conn = $this->getConnection();
        $conn->beginTransaction();

        // Get old records
        $this->CurrentFilter = $this->getFilterFromRecordKeys(false);
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAll($sql);

        // Update all rows
        $key = "";
        foreach ($this->RecKeys as $reckey) {
            if ($this->setupKeyValues($reckey)) {
                $thisKey = $reckey;
                $this->SendEmail = false; // Do not send email on update success
                $this->UpdateCount += 1; // Update record count for records being updated
                $updateRows = $this->editRow(); // Update this row
            } else {
                $updateRows = false;
            }
            if (!$updateRows) {
                break; // Update failed
            }
            if ($key != "") {
                $key .= ", ";
            }
            $key .= $thisKey;
        }

        // Check if all rows updated
        if ($updateRows) {
            $conn->commit(); // Commit transaction

            // Get new records
            $rsnew = $conn->fetchAll($sql);
        } else {
            $conn->rollback(); // Rollback transaction
        }
        return $updateRows;
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'platform_id' first before field var 'x_platform_id'
        $val = $CurrentForm->hasValue("platform_id") ? $CurrentForm->getValue("platform_id") : $CurrentForm->getValue("x_platform_id");
        if (!$this->platform_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->platform_id->Visible = false; // Disable update for API request
            } else {
                $this->platform_id->setFormValue($val);
            }
        }
        $this->platform_id->MultiUpdate = $CurrentForm->getValue("u_platform_id");

        // Check field name 'inventory_id' first before field var 'x_inventory_id'
        $val = $CurrentForm->hasValue("inventory_id") ? $CurrentForm->getValue("inventory_id") : $CurrentForm->getValue("x_inventory_id");
        if (!$this->inventory_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->inventory_id->Visible = false; // Disable update for API request
            } else {
                $this->inventory_id->setFormValue($val);
            }
        }
        $this->inventory_id->MultiUpdate = $CurrentForm->getValue("u_inventory_id");

        // Check field name 'print_stage_id' first before field var 'x_print_stage_id'
        $val = $CurrentForm->hasValue("print_stage_id") ? $CurrentForm->getValue("print_stage_id") : $CurrentForm->getValue("x_print_stage_id");
        if (!$this->print_stage_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->print_stage_id->Visible = false; // Disable update for API request
            } else {
                $this->print_stage_id->setFormValue($val);
            }
        }
        $this->print_stage_id->MultiUpdate = $CurrentForm->getValue("u_print_stage_id");

        // Check field name 'bus_size_id' first before field var 'x_bus_size_id'
        $val = $CurrentForm->hasValue("bus_size_id") ? $CurrentForm->getValue("bus_size_id") : $CurrentForm->getValue("x_bus_size_id");
        if (!$this->bus_size_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bus_size_id->Visible = false; // Disable update for API request
            } else {
                $this->bus_size_id->setFormValue($val);
            }
        }
        $this->bus_size_id->MultiUpdate = $CurrentForm->getValue("u_bus_size_id");

        // Check field name 'details' first before field var 'x_details'
        $val = $CurrentForm->hasValue("details") ? $CurrentForm->getValue("details") : $CurrentForm->getValue("x_details");
        if (!$this->details->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->details->Visible = false; // Disable update for API request
            } else {
                $this->details->setFormValue($val);
            }
        }
        $this->details->MultiUpdate = $CurrentForm->getValue("u_details");

        // Check field name 'max_limit' first before field var 'x_max_limit'
        $val = $CurrentForm->hasValue("max_limit") ? $CurrentForm->getValue("max_limit") : $CurrentForm->getValue("x_max_limit");
        if (!$this->max_limit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->max_limit->Visible = false; // Disable update for API request
            } else {
                $this->max_limit->setFormValue($val);
            }
        }
        $this->max_limit->MultiUpdate = $CurrentForm->getValue("u_max_limit");

        // Check field name 'min_limit' first before field var 'x_min_limit'
        $val = $CurrentForm->hasValue("min_limit") ? $CurrentForm->getValue("min_limit") : $CurrentForm->getValue("x_min_limit");
        if (!$this->min_limit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->min_limit->Visible = false; // Disable update for API request
            } else {
                $this->min_limit->setFormValue($val);
            }
        }
        $this->min_limit->MultiUpdate = $CurrentForm->getValue("u_min_limit");

        // Check field name 'price' first before field var 'x_price'
        $val = $CurrentForm->hasValue("price") ? $CurrentForm->getValue("price") : $CurrentForm->getValue("x_price");
        if (!$this->price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price->Visible = false; // Disable update for API request
            } else {
                $this->price->setFormValue($val);
            }
        }
        $this->price->MultiUpdate = $CurrentForm->getValue("u_price");

        // Check field name 'operator_fee' first before field var 'x_operator_fee'
        $val = $CurrentForm->hasValue("operator_fee") ? $CurrentForm->getValue("operator_fee") : $CurrentForm->getValue("x_operator_fee");
        if (!$this->operator_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->operator_fee->Visible = false; // Disable update for API request
            } else {
                $this->operator_fee->setFormValue($val);
            }
        }
        $this->operator_fee->MultiUpdate = $CurrentForm->getValue("u_operator_fee");

        // Check field name 'agency_fee' first before field var 'x_agency_fee'
        $val = $CurrentForm->hasValue("agency_fee") ? $CurrentForm->getValue("agency_fee") : $CurrentForm->getValue("x_agency_fee");
        if (!$this->agency_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->agency_fee->Visible = false; // Disable update for API request
            } else {
                $this->agency_fee->setFormValue($val);
            }
        }
        $this->agency_fee->MultiUpdate = $CurrentForm->getValue("u_agency_fee");

        // Check field name 'lamata_fee' first before field var 'x_lamata_fee'
        $val = $CurrentForm->hasValue("lamata_fee") ? $CurrentForm->getValue("lamata_fee") : $CurrentForm->getValue("x_lamata_fee");
        if (!$this->lamata_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lamata_fee->Visible = false; // Disable update for API request
            } else {
                $this->lamata_fee->setFormValue($val);
            }
        }
        $this->lamata_fee->MultiUpdate = $CurrentForm->getValue("u_lamata_fee");

        // Check field name 'lasaa_fee' first before field var 'x_lasaa_fee'
        $val = $CurrentForm->hasValue("lasaa_fee") ? $CurrentForm->getValue("lasaa_fee") : $CurrentForm->getValue("x_lasaa_fee");
        if (!$this->lasaa_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lasaa_fee->Visible = false; // Disable update for API request
            } else {
                $this->lasaa_fee->setFormValue($val);
            }
        }
        $this->lasaa_fee->MultiUpdate = $CurrentForm->getValue("u_lasaa_fee");

        // Check field name 'printers_fee' first before field var 'x_printers_fee'
        $val = $CurrentForm->hasValue("printers_fee") ? $CurrentForm->getValue("printers_fee") : $CurrentForm->getValue("x_printers_fee");
        if (!$this->printers_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->printers_fee->Visible = false; // Disable update for API request
            } else {
                $this->printers_fee->setFormValue($val);
            }
        }
        $this->printers_fee->MultiUpdate = $CurrentForm->getValue("u_printers_fee");

        // Check field name 'active' first before field var 'x_active'
        $val = $CurrentForm->hasValue("active") ? $CurrentForm->getValue("active") : $CurrentForm->getValue("x_active");
        if (!$this->active->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->active->Visible = false; // Disable update for API request
            } else {
                $this->active->setFormValue($val);
            }
        }
        $this->active->MultiUpdate = $CurrentForm->getValue("u_active");

        // Check field name 'ts_created' first before field var 'x_ts_created'
        $val = $CurrentForm->hasValue("ts_created") ? $CurrentForm->getValue("ts_created") : $CurrentForm->getValue("x_ts_created");
        if (!$this->ts_created->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ts_created->Visible = false; // Disable update for API request
            } else {
                $this->ts_created->setFormValue($val);
            }
            $this->ts_created->CurrentValue = UnFormatDateTime($this->ts_created->CurrentValue, 0);
        }
        $this->ts_created->MultiUpdate = $CurrentForm->getValue("u_ts_created");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->platform_id->CurrentValue = $this->platform_id->FormValue;
        $this->inventory_id->CurrentValue = $this->inventory_id->FormValue;
        $this->print_stage_id->CurrentValue = $this->print_stage_id->FormValue;
        $this->bus_size_id->CurrentValue = $this->bus_size_id->FormValue;
        $this->details->CurrentValue = $this->details->FormValue;
        $this->max_limit->CurrentValue = $this->max_limit->FormValue;
        $this->min_limit->CurrentValue = $this->min_limit->FormValue;
        $this->price->CurrentValue = $this->price->FormValue;
        $this->operator_fee->CurrentValue = $this->operator_fee->FormValue;
        $this->agency_fee->CurrentValue = $this->agency_fee->FormValue;
        $this->lamata_fee->CurrentValue = $this->lamata_fee->FormValue;
        $this->lasaa_fee->CurrentValue = $this->lasaa_fee->FormValue;
        $this->printers_fee->CurrentValue = $this->printers_fee->FormValue;
        $this->active->CurrentValue = $this->active->FormValue;
        $this->ts_created->CurrentValue = $this->ts_created->FormValue;
        $this->ts_created->CurrentValue = UnFormatDateTime($this->ts_created->CurrentValue, 0);
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->platform_id->setDbValue($row['platform_id']);
        $this->inventory_id->setDbValue($row['inventory_id']);
        $this->print_stage_id->setDbValue($row['print_stage_id']);
        $this->bus_size_id->setDbValue($row['bus_size_id']);
        $this->details->setDbValue($row['details']);
        $this->max_limit->setDbValue($row['max_limit']);
        $this->min_limit->setDbValue($row['min_limit']);
        $this->price->setDbValue($row['price']);
        $this->operator_fee->setDbValue($row['operator_fee']);
        $this->agency_fee->setDbValue($row['agency_fee']);
        $this->lamata_fee->setDbValue($row['lamata_fee']);
        $this->lasaa_fee->setDbValue($row['lasaa_fee']);
        $this->printers_fee->setDbValue($row['printers_fee']);
        $this->active->setDbValue((ConvertToBool($row['active']) ? "1" : "0"));
        $this->ts_created->setDbValue($row['ts_created']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['platform_id'] = null;
        $row['inventory_id'] = null;
        $row['print_stage_id'] = null;
        $row['bus_size_id'] = null;
        $row['details'] = null;
        $row['max_limit'] = null;
        $row['min_limit'] = null;
        $row['price'] = null;
        $row['operator_fee'] = null;
        $row['agency_fee'] = null;
        $row['lamata_fee'] = null;
        $row['lasaa_fee'] = null;
        $row['printers_fee'] = null;
        $row['active'] = null;
        $row['ts_created'] = null;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // platform_id

        // inventory_id

        // print_stage_id

        // bus_size_id

        // details

        // max_limit

        // min_limit

        // price

        // operator_fee

        // agency_fee

        // lamata_fee

        // lasaa_fee

        // printers_fee

        // active

        // ts_created
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // platform_id
            $curVal = strval($this->platform_id->CurrentValue);
            if ($curVal != "") {
                $this->platform_id->ViewValue = $this->platform_id->lookupCacheOption($curVal);
                if ($this->platform_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->platform_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->platform_id->Lookup->renderViewRow($rswrk[0]);
                        $this->platform_id->ViewValue = $this->platform_id->displayValue($arwrk);
                    } else {
                        $this->platform_id->ViewValue = $this->platform_id->CurrentValue;
                    }
                }
            } else {
                $this->platform_id->ViewValue = null;
            }
            $this->platform_id->ViewCustomAttributes = "";

            // inventory_id
            $curVal = strval($this->inventory_id->CurrentValue);
            if ($curVal != "") {
                $this->inventory_id->ViewValue = $this->inventory_id->lookupCacheOption($curVal);
                if ($this->inventory_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->inventory_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->inventory_id->Lookup->renderViewRow($rswrk[0]);
                        $this->inventory_id->ViewValue = $this->inventory_id->displayValue($arwrk);
                    } else {
                        $this->inventory_id->ViewValue = $this->inventory_id->CurrentValue;
                    }
                }
            } else {
                $this->inventory_id->ViewValue = null;
            }
            $this->inventory_id->ViewCustomAttributes = "";

            // print_stage_id
            $curVal = strval($this->print_stage_id->CurrentValue);
            if ($curVal != "") {
                $this->print_stage_id->ViewValue = $this->print_stage_id->lookupCacheOption($curVal);
                if ($this->print_stage_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->print_stage_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->print_stage_id->Lookup->renderViewRow($rswrk[0]);
                        $this->print_stage_id->ViewValue = $this->print_stage_id->displayValue($arwrk);
                    } else {
                        $this->print_stage_id->ViewValue = $this->print_stage_id->CurrentValue;
                    }
                }
            } else {
                $this->print_stage_id->ViewValue = null;
            }
            $this->print_stage_id->ViewCustomAttributes = "";

            // bus_size_id
            $curVal = strval($this->bus_size_id->CurrentValue);
            if ($curVal != "") {
                $this->bus_size_id->ViewValue = $this->bus_size_id->lookupCacheOption($curVal);
                if ($this->bus_size_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->bus_size_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->bus_size_id->Lookup->renderViewRow($rswrk[0]);
                        $this->bus_size_id->ViewValue = $this->bus_size_id->displayValue($arwrk);
                    } else {
                        $this->bus_size_id->ViewValue = $this->bus_size_id->CurrentValue;
                    }
                }
            } else {
                $this->bus_size_id->ViewValue = null;
            }
            $this->bus_size_id->ViewCustomAttributes = "";

            // details
            $this->details->ViewValue = $this->details->CurrentValue;
            $this->details->ViewCustomAttributes = "";

            // max_limit
            $this->max_limit->ViewValue = $this->max_limit->CurrentValue;
            $this->max_limit->ViewValue = FormatNumber($this->max_limit->ViewValue, 0, -2, -2, -2);
            $this->max_limit->ViewCustomAttributes = "";

            // min_limit
            $this->min_limit->ViewValue = $this->min_limit->CurrentValue;
            $this->min_limit->ViewValue = FormatNumber($this->min_limit->ViewValue, 0, -2, -2, -2);
            $this->min_limit->ViewCustomAttributes = "";

            // price
            $this->price->ViewValue = $this->price->CurrentValue;
            $this->price->ViewValue = FormatNumber($this->price->ViewValue, 0, -2, -2, -2);
            $this->price->ViewCustomAttributes = "";

            // operator_fee
            $this->operator_fee->ViewValue = $this->operator_fee->CurrentValue;
            $this->operator_fee->ViewValue = FormatNumber($this->operator_fee->ViewValue, 0, -2, -2, -2);
            $this->operator_fee->ViewCustomAttributes = "";

            // agency_fee
            $this->agency_fee->ViewValue = $this->agency_fee->CurrentValue;
            $this->agency_fee->ViewValue = FormatNumber($this->agency_fee->ViewValue, 0, -2, -2, -2);
            $this->agency_fee->ViewCustomAttributes = "";

            // lamata_fee
            $this->lamata_fee->ViewValue = $this->lamata_fee->CurrentValue;
            $this->lamata_fee->ViewValue = FormatNumber($this->lamata_fee->ViewValue, 0, -2, -2, -2);
            $this->lamata_fee->ViewCustomAttributes = "";

            // lasaa_fee
            $this->lasaa_fee->ViewValue = $this->lasaa_fee->CurrentValue;
            $this->lasaa_fee->ViewValue = FormatNumber($this->lasaa_fee->ViewValue, 0, -2, -2, -2);
            $this->lasaa_fee->ViewCustomAttributes = "";

            // printers_fee
            $this->printers_fee->ViewValue = $this->printers_fee->CurrentValue;
            $this->printers_fee->ViewValue = FormatNumber($this->printers_fee->ViewValue, 0, -2, -2, -2);
            $this->printers_fee->ViewCustomAttributes = "";

            // active
            if (ConvertToBool($this->active->CurrentValue)) {
                $this->active->ViewValue = $this->active->tagCaption(1) != "" ? $this->active->tagCaption(1) : "Yes";
            } else {
                $this->active->ViewValue = $this->active->tagCaption(2) != "" ? $this->active->tagCaption(2) : "No";
            }
            $this->active->ViewCustomAttributes = "";

            // ts_created
            $this->ts_created->ViewValue = $this->ts_created->CurrentValue;
            $this->ts_created->ViewValue = FormatDateTime($this->ts_created->ViewValue, 0);
            $this->ts_created->ViewCustomAttributes = "";

            // platform_id
            $this->platform_id->LinkCustomAttributes = "";
            $this->platform_id->HrefValue = "";
            $this->platform_id->TooltipValue = "";

            // inventory_id
            $this->inventory_id->LinkCustomAttributes = "";
            $this->inventory_id->HrefValue = "";
            $this->inventory_id->TooltipValue = "";

            // print_stage_id
            $this->print_stage_id->LinkCustomAttributes = "";
            $this->print_stage_id->HrefValue = "";
            $this->print_stage_id->TooltipValue = "";

            // bus_size_id
            $this->bus_size_id->LinkCustomAttributes = "";
            $this->bus_size_id->HrefValue = "";
            $this->bus_size_id->TooltipValue = "";

            // details
            $this->details->LinkCustomAttributes = "";
            $this->details->HrefValue = "";
            $this->details->TooltipValue = "";

            // max_limit
            $this->max_limit->LinkCustomAttributes = "";
            $this->max_limit->HrefValue = "";
            $this->max_limit->TooltipValue = "";

            // min_limit
            $this->min_limit->LinkCustomAttributes = "";
            $this->min_limit->HrefValue = "";
            $this->min_limit->TooltipValue = "";

            // price
            $this->price->LinkCustomAttributes = "";
            $this->price->HrefValue = "";
            $this->price->TooltipValue = "";

            // operator_fee
            $this->operator_fee->LinkCustomAttributes = "";
            $this->operator_fee->HrefValue = "";
            $this->operator_fee->TooltipValue = "";

            // agency_fee
            $this->agency_fee->LinkCustomAttributes = "";
            $this->agency_fee->HrefValue = "";
            $this->agency_fee->TooltipValue = "";

            // lamata_fee
            $this->lamata_fee->LinkCustomAttributes = "";
            $this->lamata_fee->HrefValue = "";
            $this->lamata_fee->TooltipValue = "";

            // lasaa_fee
            $this->lasaa_fee->LinkCustomAttributes = "";
            $this->lasaa_fee->HrefValue = "";
            $this->lasaa_fee->TooltipValue = "";

            // printers_fee
            $this->printers_fee->LinkCustomAttributes = "";
            $this->printers_fee->HrefValue = "";
            $this->printers_fee->TooltipValue = "";

            // active
            $this->active->LinkCustomAttributes = "";
            $this->active->HrefValue = "";
            $this->active->TooltipValue = "";

            // ts_created
            $this->ts_created->LinkCustomAttributes = "";
            $this->ts_created->HrefValue = "";
            $this->ts_created->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // platform_id
            $this->platform_id->EditAttrs["class"] = "form-control";
            $this->platform_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->platform_id->CurrentValue));
            if ($curVal != "") {
                $this->platform_id->ViewValue = $this->platform_id->lookupCacheOption($curVal);
            } else {
                $this->platform_id->ViewValue = $this->platform_id->Lookup !== null && is_array($this->platform_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->platform_id->ViewValue !== null) { // Load from cache
                $this->platform_id->EditValue = array_values($this->platform_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->platform_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->platform_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->platform_id->EditValue = $arwrk;
            }
            $this->platform_id->PlaceHolder = RemoveHtml($this->platform_id->caption());

            // inventory_id
            $this->inventory_id->EditAttrs["class"] = "form-control";
            $this->inventory_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->inventory_id->CurrentValue));
            if ($curVal != "") {
                $this->inventory_id->ViewValue = $this->inventory_id->lookupCacheOption($curVal);
            } else {
                $this->inventory_id->ViewValue = $this->inventory_id->Lookup !== null && is_array($this->inventory_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->inventory_id->ViewValue !== null) { // Load from cache
                $this->inventory_id->EditValue = array_values($this->inventory_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->inventory_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->inventory_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->inventory_id->EditValue = $arwrk;
            }
            $this->inventory_id->PlaceHolder = RemoveHtml($this->inventory_id->caption());

            // print_stage_id
            $this->print_stage_id->EditAttrs["class"] = "form-control";
            $this->print_stage_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->print_stage_id->CurrentValue));
            if ($curVal != "") {
                $this->print_stage_id->ViewValue = $this->print_stage_id->lookupCacheOption($curVal);
            } else {
                $this->print_stage_id->ViewValue = $this->print_stage_id->Lookup !== null && is_array($this->print_stage_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->print_stage_id->ViewValue !== null) { // Load from cache
                $this->print_stage_id->EditValue = array_values($this->print_stage_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->print_stage_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->print_stage_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->print_stage_id->EditValue = $arwrk;
            }
            $this->print_stage_id->PlaceHolder = RemoveHtml($this->print_stage_id->caption());

            // bus_size_id
            $this->bus_size_id->EditAttrs["class"] = "form-control";
            $this->bus_size_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->bus_size_id->CurrentValue));
            if ($curVal != "") {
                $this->bus_size_id->ViewValue = $this->bus_size_id->lookupCacheOption($curVal);
            } else {
                $this->bus_size_id->ViewValue = $this->bus_size_id->Lookup !== null && is_array($this->bus_size_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->bus_size_id->ViewValue !== null) { // Load from cache
                $this->bus_size_id->EditValue = array_values($this->bus_size_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->bus_size_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->bus_size_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->bus_size_id->EditValue = $arwrk;
            }
            $this->bus_size_id->PlaceHolder = RemoveHtml($this->bus_size_id->caption());

            // details
            $this->details->EditAttrs["class"] = "form-control";
            $this->details->EditCustomAttributes = "";
            $this->details->EditValue = HtmlEncode($this->details->CurrentValue);
            $this->details->PlaceHolder = RemoveHtml($this->details->caption());

            // max_limit
            $this->max_limit->EditAttrs["class"] = "form-control";
            $this->max_limit->EditCustomAttributes = "";
            $this->max_limit->EditValue = HtmlEncode($this->max_limit->CurrentValue);
            $this->max_limit->PlaceHolder = RemoveHtml($this->max_limit->caption());

            // min_limit
            $this->min_limit->EditAttrs["class"] = "form-control";
            $this->min_limit->EditCustomAttributes = "";
            $this->min_limit->EditValue = HtmlEncode($this->min_limit->CurrentValue);
            $this->min_limit->PlaceHolder = RemoveHtml($this->min_limit->caption());

            // price
            $this->price->EditAttrs["class"] = "form-control";
            $this->price->EditCustomAttributes = "";
            $this->price->EditValue = HtmlEncode($this->price->CurrentValue);
            $this->price->PlaceHolder = RemoveHtml($this->price->caption());

            // operator_fee
            $this->operator_fee->EditAttrs["class"] = "form-control";
            $this->operator_fee->EditCustomAttributes = "";
            $this->operator_fee->EditValue = HtmlEncode($this->operator_fee->CurrentValue);
            $this->operator_fee->PlaceHolder = RemoveHtml($this->operator_fee->caption());

            // agency_fee
            $this->agency_fee->EditAttrs["class"] = "form-control";
            $this->agency_fee->EditCustomAttributes = "";
            $this->agency_fee->EditValue = HtmlEncode($this->agency_fee->CurrentValue);
            $this->agency_fee->PlaceHolder = RemoveHtml($this->agency_fee->caption());

            // lamata_fee
            $this->lamata_fee->EditAttrs["class"] = "form-control";
            $this->lamata_fee->EditCustomAttributes = "";
            $this->lamata_fee->EditValue = HtmlEncode($this->lamata_fee->CurrentValue);
            $this->lamata_fee->PlaceHolder = RemoveHtml($this->lamata_fee->caption());

            // lasaa_fee
            $this->lasaa_fee->EditAttrs["class"] = "form-control";
            $this->lasaa_fee->EditCustomAttributes = "";
            $this->lasaa_fee->EditValue = HtmlEncode($this->lasaa_fee->CurrentValue);
            $this->lasaa_fee->PlaceHolder = RemoveHtml($this->lasaa_fee->caption());

            // printers_fee
            $this->printers_fee->EditAttrs["class"] = "form-control";
            $this->printers_fee->EditCustomAttributes = "";
            $this->printers_fee->EditValue = HtmlEncode($this->printers_fee->CurrentValue);
            $this->printers_fee->PlaceHolder = RemoveHtml($this->printers_fee->caption());

            // active
            $this->active->EditCustomAttributes = "";
            $this->active->EditValue = $this->active->options(false);
            $this->active->PlaceHolder = RemoveHtml($this->active->caption());

            // ts_created
            $this->ts_created->EditAttrs["class"] = "form-control";
            $this->ts_created->EditCustomAttributes = "";
            $this->ts_created->EditValue = HtmlEncode(FormatDateTime($this->ts_created->CurrentValue, 8));
            $this->ts_created->PlaceHolder = RemoveHtml($this->ts_created->caption());

            // Edit refer script

            // platform_id
            $this->platform_id->LinkCustomAttributes = "";
            $this->platform_id->HrefValue = "";

            // inventory_id
            $this->inventory_id->LinkCustomAttributes = "";
            $this->inventory_id->HrefValue = "";

            // print_stage_id
            $this->print_stage_id->LinkCustomAttributes = "";
            $this->print_stage_id->HrefValue = "";

            // bus_size_id
            $this->bus_size_id->LinkCustomAttributes = "";
            $this->bus_size_id->HrefValue = "";

            // details
            $this->details->LinkCustomAttributes = "";
            $this->details->HrefValue = "";

            // max_limit
            $this->max_limit->LinkCustomAttributes = "";
            $this->max_limit->HrefValue = "";

            // min_limit
            $this->min_limit->LinkCustomAttributes = "";
            $this->min_limit->HrefValue = "";

            // price
            $this->price->LinkCustomAttributes = "";
            $this->price->HrefValue = "";

            // operator_fee
            $this->operator_fee->LinkCustomAttributes = "";
            $this->operator_fee->HrefValue = "";

            // agency_fee
            $this->agency_fee->LinkCustomAttributes = "";
            $this->agency_fee->HrefValue = "";

            // lamata_fee
            $this->lamata_fee->LinkCustomAttributes = "";
            $this->lamata_fee->HrefValue = "";

            // lasaa_fee
            $this->lasaa_fee->LinkCustomAttributes = "";
            $this->lasaa_fee->HrefValue = "";

            // printers_fee
            $this->printers_fee->LinkCustomAttributes = "";
            $this->printers_fee->HrefValue = "";

            // active
            $this->active->LinkCustomAttributes = "";
            $this->active->HrefValue = "";

            // ts_created
            $this->ts_created->LinkCustomAttributes = "";
            $this->ts_created->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;
        $updateCnt = 0;
        if ($this->platform_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->inventory_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->print_stage_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->bus_size_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->details->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->max_limit->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->min_limit->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->price->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->operator_fee->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->agency_fee->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->lamata_fee->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->lasaa_fee->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->printers_fee->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->active->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ts_created->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($updateCnt == 0) {
            return false;
        }

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->platform_id->Required) {
            if ($this->platform_id->MultiUpdate != "" && !$this->platform_id->IsDetailKey && EmptyValue($this->platform_id->FormValue)) {
                $this->platform_id->addErrorMessage(str_replace("%s", $this->platform_id->caption(), $this->platform_id->RequiredErrorMessage));
            }
        }
        if ($this->inventory_id->Required) {
            if ($this->inventory_id->MultiUpdate != "" && !$this->inventory_id->IsDetailKey && EmptyValue($this->inventory_id->FormValue)) {
                $this->inventory_id->addErrorMessage(str_replace("%s", $this->inventory_id->caption(), $this->inventory_id->RequiredErrorMessage));
            }
        }
        if ($this->print_stage_id->Required) {
            if ($this->print_stage_id->MultiUpdate != "" && !$this->print_stage_id->IsDetailKey && EmptyValue($this->print_stage_id->FormValue)) {
                $this->print_stage_id->addErrorMessage(str_replace("%s", $this->print_stage_id->caption(), $this->print_stage_id->RequiredErrorMessage));
            }
        }
        if ($this->bus_size_id->Required) {
            if ($this->bus_size_id->MultiUpdate != "" && !$this->bus_size_id->IsDetailKey && EmptyValue($this->bus_size_id->FormValue)) {
                $this->bus_size_id->addErrorMessage(str_replace("%s", $this->bus_size_id->caption(), $this->bus_size_id->RequiredErrorMessage));
            }
        }
        if ($this->details->Required) {
            if ($this->details->MultiUpdate != "" && !$this->details->IsDetailKey && EmptyValue($this->details->FormValue)) {
                $this->details->addErrorMessage(str_replace("%s", $this->details->caption(), $this->details->RequiredErrorMessage));
            }
        }
        if ($this->max_limit->Required) {
            if ($this->max_limit->MultiUpdate != "" && !$this->max_limit->IsDetailKey && EmptyValue($this->max_limit->FormValue)) {
                $this->max_limit->addErrorMessage(str_replace("%s", $this->max_limit->caption(), $this->max_limit->RequiredErrorMessage));
            }
        }
        if ($this->max_limit->MultiUpdate != "") {
            if (!CheckInteger($this->max_limit->FormValue)) {
                $this->max_limit->addErrorMessage($this->max_limit->getErrorMessage(false));
            }
        }
        if ($this->min_limit->Required) {
            if ($this->min_limit->MultiUpdate != "" && !$this->min_limit->IsDetailKey && EmptyValue($this->min_limit->FormValue)) {
                $this->min_limit->addErrorMessage(str_replace("%s", $this->min_limit->caption(), $this->min_limit->RequiredErrorMessage));
            }
        }
        if ($this->min_limit->MultiUpdate != "") {
            if (!CheckInteger($this->min_limit->FormValue)) {
                $this->min_limit->addErrorMessage($this->min_limit->getErrorMessage(false));
            }
        }
        if ($this->price->Required) {
            if ($this->price->MultiUpdate != "" && !$this->price->IsDetailKey && EmptyValue($this->price->FormValue)) {
                $this->price->addErrorMessage(str_replace("%s", $this->price->caption(), $this->price->RequiredErrorMessage));
            }
        }
        if ($this->price->MultiUpdate != "") {
            if (!CheckInteger($this->price->FormValue)) {
                $this->price->addErrorMessage($this->price->getErrorMessage(false));
            }
        }
        if ($this->operator_fee->Required) {
            if ($this->operator_fee->MultiUpdate != "" && !$this->operator_fee->IsDetailKey && EmptyValue($this->operator_fee->FormValue)) {
                $this->operator_fee->addErrorMessage(str_replace("%s", $this->operator_fee->caption(), $this->operator_fee->RequiredErrorMessage));
            }
        }
        if ($this->operator_fee->MultiUpdate != "") {
            if (!CheckInteger($this->operator_fee->FormValue)) {
                $this->operator_fee->addErrorMessage($this->operator_fee->getErrorMessage(false));
            }
        }
        if ($this->agency_fee->Required) {
            if ($this->agency_fee->MultiUpdate != "" && !$this->agency_fee->IsDetailKey && EmptyValue($this->agency_fee->FormValue)) {
                $this->agency_fee->addErrorMessage(str_replace("%s", $this->agency_fee->caption(), $this->agency_fee->RequiredErrorMessage));
            }
        }
        if ($this->agency_fee->MultiUpdate != "") {
            if (!CheckInteger($this->agency_fee->FormValue)) {
                $this->agency_fee->addErrorMessage($this->agency_fee->getErrorMessage(false));
            }
        }
        if ($this->lamata_fee->Required) {
            if ($this->lamata_fee->MultiUpdate != "" && !$this->lamata_fee->IsDetailKey && EmptyValue($this->lamata_fee->FormValue)) {
                $this->lamata_fee->addErrorMessage(str_replace("%s", $this->lamata_fee->caption(), $this->lamata_fee->RequiredErrorMessage));
            }
        }
        if ($this->lamata_fee->MultiUpdate != "") {
            if (!CheckInteger($this->lamata_fee->FormValue)) {
                $this->lamata_fee->addErrorMessage($this->lamata_fee->getErrorMessage(false));
            }
        }
        if ($this->lasaa_fee->Required) {
            if ($this->lasaa_fee->MultiUpdate != "" && !$this->lasaa_fee->IsDetailKey && EmptyValue($this->lasaa_fee->FormValue)) {
                $this->lasaa_fee->addErrorMessage(str_replace("%s", $this->lasaa_fee->caption(), $this->lasaa_fee->RequiredErrorMessage));
            }
        }
        if ($this->lasaa_fee->MultiUpdate != "") {
            if (!CheckInteger($this->lasaa_fee->FormValue)) {
                $this->lasaa_fee->addErrorMessage($this->lasaa_fee->getErrorMessage(false));
            }
        }
        if ($this->printers_fee->Required) {
            if ($this->printers_fee->MultiUpdate != "" && !$this->printers_fee->IsDetailKey && EmptyValue($this->printers_fee->FormValue)) {
                $this->printers_fee->addErrorMessage(str_replace("%s", $this->printers_fee->caption(), $this->printers_fee->RequiredErrorMessage));
            }
        }
        if ($this->printers_fee->MultiUpdate != "") {
            if (!CheckInteger($this->printers_fee->FormValue)) {
                $this->printers_fee->addErrorMessage($this->printers_fee->getErrorMessage(false));
            }
        }
        if ($this->active->Required) {
            if ($this->active->MultiUpdate != "" && $this->active->FormValue == "") {
                $this->active->addErrorMessage(str_replace("%s", $this->active->caption(), $this->active->RequiredErrorMessage));
            }
        }
        if ($this->ts_created->Required) {
            if ($this->ts_created->MultiUpdate != "" && !$this->ts_created->IsDetailKey && EmptyValue($this->ts_created->FormValue)) {
                $this->ts_created->addErrorMessage(str_replace("%s", $this->ts_created->caption(), $this->ts_created->RequiredErrorMessage));
            }
        }
        if ($this->ts_created->MultiUpdate != "") {
            if (!CheckDate($this->ts_created->FormValue)) {
                $this->ts_created->addErrorMessage($this->ts_created->getErrorMessage(false));
            }
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // platform_id
            $this->platform_id->setDbValueDef($rsnew, $this->platform_id->CurrentValue, 0, $this->platform_id->ReadOnly || $this->platform_id->MultiUpdate != "1");

            // inventory_id
            $this->inventory_id->setDbValueDef($rsnew, $this->inventory_id->CurrentValue, 0, $this->inventory_id->ReadOnly || $this->inventory_id->MultiUpdate != "1");

            // print_stage_id
            $this->print_stage_id->setDbValueDef($rsnew, $this->print_stage_id->CurrentValue, null, $this->print_stage_id->ReadOnly || $this->print_stage_id->MultiUpdate != "1");

            // bus_size_id
            $this->bus_size_id->setDbValueDef($rsnew, $this->bus_size_id->CurrentValue, null, $this->bus_size_id->ReadOnly || $this->bus_size_id->MultiUpdate != "1");

            // details
            $this->details->setDbValueDef($rsnew, $this->details->CurrentValue, null, $this->details->ReadOnly || $this->details->MultiUpdate != "1");

            // max_limit
            $this->max_limit->setDbValueDef($rsnew, $this->max_limit->CurrentValue, null, $this->max_limit->ReadOnly || $this->max_limit->MultiUpdate != "1");

            // min_limit
            $this->min_limit->setDbValueDef($rsnew, $this->min_limit->CurrentValue, null, $this->min_limit->ReadOnly || $this->min_limit->MultiUpdate != "1");

            // price
            $this->price->setDbValueDef($rsnew, $this->price->CurrentValue, null, $this->price->ReadOnly || $this->price->MultiUpdate != "1");

            // operator_fee
            $this->operator_fee->setDbValueDef($rsnew, $this->operator_fee->CurrentValue, null, $this->operator_fee->ReadOnly || $this->operator_fee->MultiUpdate != "1");

            // agency_fee
            $this->agency_fee->setDbValueDef($rsnew, $this->agency_fee->CurrentValue, null, $this->agency_fee->ReadOnly || $this->agency_fee->MultiUpdate != "1");

            // lamata_fee
            $this->lamata_fee->setDbValueDef($rsnew, $this->lamata_fee->CurrentValue, null, $this->lamata_fee->ReadOnly || $this->lamata_fee->MultiUpdate != "1");

            // lasaa_fee
            $this->lasaa_fee->setDbValueDef($rsnew, $this->lasaa_fee->CurrentValue, null, $this->lasaa_fee->ReadOnly || $this->lasaa_fee->MultiUpdate != "1");

            // printers_fee
            $this->printers_fee->setDbValueDef($rsnew, $this->printers_fee->CurrentValue, null, $this->printers_fee->ReadOnly || $this->printers_fee->MultiUpdate != "1");

            // active
            $tmpBool = $this->active->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->active->setDbValueDef($rsnew, $tmpBool, 0, $this->active->ReadOnly || $this->active->MultiUpdate != "1");

            // ts_created
            $this->ts_created->setDbValueDef($rsnew, UnFormatDateTime($this->ts_created->CurrentValue, 0), CurrentDate(), $this->ts_created->ReadOnly || $this->ts_created->MultiUpdate != "1");

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    $editRow = $this->update($rsnew, "", $rsold);
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ZPriceSettingsList"), "", $this->TableVar, true);
        $pageId = "update";
        $Breadcrumb->add("update", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_platform_id":
                    break;
                case "x_inventory_id":
                    break;
                case "x_print_stage_id":
                    break;
                case "x_bus_size_id":
                    break;
                case "x_active":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}

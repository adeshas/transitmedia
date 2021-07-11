<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainBusesUpdate extends MainBuses
{
    use MessagesTrait;

    // Page ID
    public $PageID = "update";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_buses';

    // Page object name
    public $PageObjName = "MainBusesUpdate";

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

        // Table object (main_buses)
        if (!isset($GLOBALS["main_buses"]) || get_class($GLOBALS["main_buses"]) == PROJECT_NAMESPACE . "main_buses") {
            $GLOBALS["main_buses"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'main_buses');
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
                $doc = new $class(Container("main_buses"));
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
                    if ($pageName == "mainbusesview") {
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
        $this->number->setVisibility();
        $this->platform_id->setVisibility();
        $this->operator_id->setVisibility();
        $this->exterior_campaign_id->setVisibility();
        $this->interior_campaign_id->setVisibility();
        $this->bus_status_id->setVisibility();
        $this->bus_size_id->setVisibility();
        $this->bus_depot_id->setVisibility();
        $this->ts_created->setVisibility();
        $this->ts_last_update->setVisibility();
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
        $this->setupLookupOptions($this->operator_id);
        $this->setupLookupOptions($this->exterior_campaign_id);
        $this->setupLookupOptions($this->interior_campaign_id);
        $this->setupLookupOptions($this->bus_status_id);
        $this->setupLookupOptions($this->bus_size_id);
        $this->setupLookupOptions($this->bus_depot_id);

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
            $this->terminate("mainbuseslist"); // No records selected, return to list
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
                    $this->number->setDbValue($rs->fields['number']);
                    $this->platform_id->setDbValue($rs->fields['platform_id']);
                    $this->operator_id->setDbValue($rs->fields['operator_id']);
                    $this->exterior_campaign_id->setDbValue($rs->fields['exterior_campaign_id']);
                    $this->interior_campaign_id->setDbValue($rs->fields['interior_campaign_id']);
                    $this->bus_status_id->setDbValue($rs->fields['bus_status_id']);
                    $this->bus_size_id->setDbValue($rs->fields['bus_size_id']);
                    $this->bus_depot_id->setDbValue($rs->fields['bus_depot_id']);
                    $this->ts_created->setDbValue($rs->fields['ts_created']);
                    $this->ts_last_update->setDbValue($rs->fields['ts_last_update']);
                } else {
                    if (!CompareValue($this->number->DbValue, $rs->fields['number'])) {
                        $this->number->CurrentValue = null;
                    }
                    if (!CompareValue($this->platform_id->DbValue, $rs->fields['platform_id'])) {
                        $this->platform_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->operator_id->DbValue, $rs->fields['operator_id'])) {
                        $this->operator_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->exterior_campaign_id->DbValue, $rs->fields['exterior_campaign_id'])) {
                        $this->exterior_campaign_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->interior_campaign_id->DbValue, $rs->fields['interior_campaign_id'])) {
                        $this->interior_campaign_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->bus_status_id->DbValue, $rs->fields['bus_status_id'])) {
                        $this->bus_status_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->bus_size_id->DbValue, $rs->fields['bus_size_id'])) {
                        $this->bus_size_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->bus_depot_id->DbValue, $rs->fields['bus_depot_id'])) {
                        $this->bus_depot_id->CurrentValue = null;
                    }
                    if (!CompareValue($this->ts_created->DbValue, $rs->fields['ts_created'])) {
                        $this->ts_created->CurrentValue = null;
                    }
                    if (!CompareValue($this->ts_last_update->DbValue, $rs->fields['ts_last_update'])) {
                        $this->ts_last_update->CurrentValue = null;
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

        // Check field name 'number' first before field var 'x_number'
        $val = $CurrentForm->hasValue("number") ? $CurrentForm->getValue("number") : $CurrentForm->getValue("x_number");
        if (!$this->number->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->number->Visible = false; // Disable update for API request
            } else {
                $this->number->setFormValue($val);
            }
        }
        $this->number->MultiUpdate = $CurrentForm->getValue("u_number");

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

        // Check field name 'operator_id' first before field var 'x_operator_id'
        $val = $CurrentForm->hasValue("operator_id") ? $CurrentForm->getValue("operator_id") : $CurrentForm->getValue("x_operator_id");
        if (!$this->operator_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->operator_id->Visible = false; // Disable update for API request
            } else {
                $this->operator_id->setFormValue($val);
            }
        }
        $this->operator_id->MultiUpdate = $CurrentForm->getValue("u_operator_id");

        // Check field name 'exterior_campaign_id' first before field var 'x_exterior_campaign_id'
        $val = $CurrentForm->hasValue("exterior_campaign_id") ? $CurrentForm->getValue("exterior_campaign_id") : $CurrentForm->getValue("x_exterior_campaign_id");
        if (!$this->exterior_campaign_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->exterior_campaign_id->Visible = false; // Disable update for API request
            } else {
                $this->exterior_campaign_id->setFormValue($val);
            }
        }
        $this->exterior_campaign_id->MultiUpdate = $CurrentForm->getValue("u_exterior_campaign_id");

        // Check field name 'interior_campaign_id' first before field var 'x_interior_campaign_id'
        $val = $CurrentForm->hasValue("interior_campaign_id") ? $CurrentForm->getValue("interior_campaign_id") : $CurrentForm->getValue("x_interior_campaign_id");
        if (!$this->interior_campaign_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->interior_campaign_id->Visible = false; // Disable update for API request
            } else {
                $this->interior_campaign_id->setFormValue($val);
            }
        }
        $this->interior_campaign_id->MultiUpdate = $CurrentForm->getValue("u_interior_campaign_id");

        // Check field name 'bus_status_id' first before field var 'x_bus_status_id'
        $val = $CurrentForm->hasValue("bus_status_id") ? $CurrentForm->getValue("bus_status_id") : $CurrentForm->getValue("x_bus_status_id");
        if (!$this->bus_status_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bus_status_id->Visible = false; // Disable update for API request
            } else {
                $this->bus_status_id->setFormValue($val);
            }
        }
        $this->bus_status_id->MultiUpdate = $CurrentForm->getValue("u_bus_status_id");

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

        // Check field name 'bus_depot_id' first before field var 'x_bus_depot_id'
        $val = $CurrentForm->hasValue("bus_depot_id") ? $CurrentForm->getValue("bus_depot_id") : $CurrentForm->getValue("x_bus_depot_id");
        if (!$this->bus_depot_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bus_depot_id->Visible = false; // Disable update for API request
            } else {
                $this->bus_depot_id->setFormValue($val);
            }
        }
        $this->bus_depot_id->MultiUpdate = $CurrentForm->getValue("u_bus_depot_id");

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

        // Check field name 'ts_last_update' first before field var 'x_ts_last_update'
        $val = $CurrentForm->hasValue("ts_last_update") ? $CurrentForm->getValue("ts_last_update") : $CurrentForm->getValue("x_ts_last_update");
        if (!$this->ts_last_update->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ts_last_update->Visible = false; // Disable update for API request
            } else {
                $this->ts_last_update->setFormValue($val);
            }
            $this->ts_last_update->CurrentValue = UnFormatDateTime($this->ts_last_update->CurrentValue, 1);
        }
        $this->ts_last_update->MultiUpdate = $CurrentForm->getValue("u_ts_last_update");

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
        $this->number->CurrentValue = $this->number->FormValue;
        $this->platform_id->CurrentValue = $this->platform_id->FormValue;
        $this->operator_id->CurrentValue = $this->operator_id->FormValue;
        $this->exterior_campaign_id->CurrentValue = $this->exterior_campaign_id->FormValue;
        $this->interior_campaign_id->CurrentValue = $this->interior_campaign_id->FormValue;
        $this->bus_status_id->CurrentValue = $this->bus_status_id->FormValue;
        $this->bus_size_id->CurrentValue = $this->bus_size_id->FormValue;
        $this->bus_depot_id->CurrentValue = $this->bus_depot_id->FormValue;
        $this->ts_created->CurrentValue = $this->ts_created->FormValue;
        $this->ts_created->CurrentValue = UnFormatDateTime($this->ts_created->CurrentValue, 0);
        $this->ts_last_update->CurrentValue = $this->ts_last_update->FormValue;
        $this->ts_last_update->CurrentValue = UnFormatDateTime($this->ts_last_update->CurrentValue, 1);
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
        $this->number->setDbValue($row['number']);
        $this->platform_id->setDbValue($row['platform_id']);
        $this->operator_id->setDbValue($row['operator_id']);
        $this->exterior_campaign_id->setDbValue($row['exterior_campaign_id']);
        $this->interior_campaign_id->setDbValue($row['interior_campaign_id']);
        $this->bus_status_id->setDbValue($row['bus_status_id']);
        $this->bus_size_id->setDbValue($row['bus_size_id']);
        $this->bus_depot_id->setDbValue($row['bus_depot_id']);
        $this->ts_created->setDbValue($row['ts_created']);
        $this->ts_last_update->setDbValue($row['ts_last_update']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['number'] = null;
        $row['platform_id'] = null;
        $row['operator_id'] = null;
        $row['exterior_campaign_id'] = null;
        $row['interior_campaign_id'] = null;
        $row['bus_status_id'] = null;
        $row['bus_size_id'] = null;
        $row['bus_depot_id'] = null;
        $row['ts_created'] = null;
        $row['ts_last_update'] = null;
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

        // number

        // platform_id

        // operator_id

        // exterior_campaign_id

        // interior_campaign_id

        // bus_status_id

        // bus_size_id

        // bus_depot_id

        // ts_created

        // ts_last_update
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // number
            $this->number->ViewValue = $this->number->CurrentValue;
            $this->number->ViewCustomAttributes = "";

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

            // operator_id
            $curVal = strval($this->operator_id->CurrentValue);
            if ($curVal != "") {
                $this->operator_id->ViewValue = $this->operator_id->lookupCacheOption($curVal);
                if ($this->operator_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->operator_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->operator_id->Lookup->renderViewRow($rswrk[0]);
                        $this->operator_id->ViewValue = $this->operator_id->displayValue($arwrk);
                    } else {
                        $this->operator_id->ViewValue = $this->operator_id->CurrentValue;
                    }
                }
            } else {
                $this->operator_id->ViewValue = null;
            }
            $this->operator_id->ViewCustomAttributes = "";

            // exterior_campaign_id
            $curVal = strval($this->exterior_campaign_id->CurrentValue);
            if ($curVal != "") {
                $this->exterior_campaign_id->ViewValue = $this->exterior_campaign_id->lookupCacheOption($curVal);
                if ($this->exterior_campaign_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "\"inventory_id\" = (SELECT ID FROM y_inventory WHERE name = 'Exterior Branding')";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->exterior_campaign_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->exterior_campaign_id->Lookup->renderViewRow($rswrk[0]);
                        $this->exterior_campaign_id->ViewValue = $this->exterior_campaign_id->displayValue($arwrk);
                    } else {
                        $this->exterior_campaign_id->ViewValue = $this->exterior_campaign_id->CurrentValue;
                    }
                }
            } else {
                $this->exterior_campaign_id->ViewValue = null;
            }
            $this->exterior_campaign_id->ViewCustomAttributes = "";

            // interior_campaign_id
            $curVal = strval($this->interior_campaign_id->CurrentValue);
            if ($curVal != "") {
                $this->interior_campaign_id->ViewValue = $this->interior_campaign_id->lookupCacheOption($curVal);
                if ($this->interior_campaign_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "\"inventory_id\" = (SELECT ID FROM y_inventory WHERE name = 'Interior Branding')";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->interior_campaign_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->interior_campaign_id->Lookup->renderViewRow($rswrk[0]);
                        $this->interior_campaign_id->ViewValue = $this->interior_campaign_id->displayValue($arwrk);
                    } else {
                        $this->interior_campaign_id->ViewValue = $this->interior_campaign_id->CurrentValue;
                    }
                }
            } else {
                $this->interior_campaign_id->ViewValue = null;
            }
            $this->interior_campaign_id->ViewCustomAttributes = "";

            // bus_status_id
            $curVal = strval($this->bus_status_id->CurrentValue);
            if ($curVal != "") {
                $this->bus_status_id->ViewValue = $this->bus_status_id->lookupCacheOption($curVal);
                if ($this->bus_status_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->bus_status_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->bus_status_id->Lookup->renderViewRow($rswrk[0]);
                        $this->bus_status_id->ViewValue = $this->bus_status_id->displayValue($arwrk);
                    } else {
                        $this->bus_status_id->ViewValue = $this->bus_status_id->CurrentValue;
                    }
                }
            } else {
                $this->bus_status_id->ViewValue = null;
            }
            $this->bus_status_id->ViewCustomAttributes = "";

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

            // bus_depot_id
            $curVal = strval($this->bus_depot_id->CurrentValue);
            if ($curVal != "") {
                $this->bus_depot_id->ViewValue = $this->bus_depot_id->lookupCacheOption($curVal);
                if ($this->bus_depot_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->bus_depot_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->bus_depot_id->Lookup->renderViewRow($rswrk[0]);
                        $this->bus_depot_id->ViewValue = $this->bus_depot_id->displayValue($arwrk);
                    } else {
                        $this->bus_depot_id->ViewValue = $this->bus_depot_id->CurrentValue;
                    }
                }
            } else {
                $this->bus_depot_id->ViewValue = null;
            }
            $this->bus_depot_id->ViewCustomAttributes = "";

            // ts_created
            $this->ts_created->ViewValue = $this->ts_created->CurrentValue;
            $this->ts_created->ViewValue = FormatDateTime($this->ts_created->ViewValue, 0);
            $this->ts_created->ViewCustomAttributes = "";

            // ts_last_update
            $this->ts_last_update->ViewValue = $this->ts_last_update->CurrentValue;
            $this->ts_last_update->ViewValue = FormatDateTime($this->ts_last_update->ViewValue, 1);
            $this->ts_last_update->ViewCustomAttributes = "";

            // number
            $this->number->LinkCustomAttributes = "";
            $this->number->HrefValue = "";
            $this->number->TooltipValue = "";

            // platform_id
            $this->platform_id->LinkCustomAttributes = "";
            $this->platform_id->HrefValue = "";
            $this->platform_id->TooltipValue = "";

            // operator_id
            $this->operator_id->LinkCustomAttributes = "";
            $this->operator_id->HrefValue = "";
            $this->operator_id->TooltipValue = "";

            // exterior_campaign_id
            $this->exterior_campaign_id->LinkCustomAttributes = "";
            $this->exterior_campaign_id->HrefValue = "";
            $this->exterior_campaign_id->TooltipValue = "";

            // interior_campaign_id
            $this->interior_campaign_id->LinkCustomAttributes = "";
            $this->interior_campaign_id->HrefValue = "";
            $this->interior_campaign_id->TooltipValue = "";

            // bus_status_id
            $this->bus_status_id->LinkCustomAttributes = "";
            $this->bus_status_id->HrefValue = "";
            $this->bus_status_id->TooltipValue = "";

            // bus_size_id
            $this->bus_size_id->LinkCustomAttributes = "";
            $this->bus_size_id->HrefValue = "";
            $this->bus_size_id->TooltipValue = "";

            // bus_depot_id
            $this->bus_depot_id->LinkCustomAttributes = "";
            $this->bus_depot_id->HrefValue = "";
            $this->bus_depot_id->TooltipValue = "";

            // ts_created
            $this->ts_created->LinkCustomAttributes = "";
            $this->ts_created->HrefValue = "";
            $this->ts_created->TooltipValue = "";

            // ts_last_update
            $this->ts_last_update->LinkCustomAttributes = "";
            $this->ts_last_update->HrefValue = "";
            $this->ts_last_update->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // number
            $this->number->EditAttrs["class"] = "form-control";
            $this->number->EditCustomAttributes = "";
            if (!$this->number->Raw) {
                $this->number->CurrentValue = HtmlDecode($this->number->CurrentValue);
            }
            $this->number->EditValue = HtmlEncode($this->number->CurrentValue);
            $this->number->PlaceHolder = RemoveHtml($this->number->caption());

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

            // operator_id
            $this->operator_id->EditAttrs["class"] = "form-control";
            $this->operator_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->operator_id->CurrentValue));
            if ($curVal != "") {
                $this->operator_id->ViewValue = $this->operator_id->lookupCacheOption($curVal);
            } else {
                $this->operator_id->ViewValue = $this->operator_id->Lookup !== null && is_array($this->operator_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->operator_id->ViewValue !== null) { // Load from cache
                $this->operator_id->EditValue = array_values($this->operator_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->operator_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->operator_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->operator_id->Lookup->renderViewRow($row);
                $this->operator_id->EditValue = $arwrk;
            }
            $this->operator_id->PlaceHolder = RemoveHtml($this->operator_id->caption());

            // exterior_campaign_id
            $this->exterior_campaign_id->EditAttrs["class"] = "form-control";
            $this->exterior_campaign_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->exterior_campaign_id->CurrentValue));
            if ($curVal != "") {
                $this->exterior_campaign_id->ViewValue = $this->exterior_campaign_id->lookupCacheOption($curVal);
            } else {
                $this->exterior_campaign_id->ViewValue = $this->exterior_campaign_id->Lookup !== null && is_array($this->exterior_campaign_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->exterior_campaign_id->ViewValue !== null) { // Load from cache
                $this->exterior_campaign_id->EditValue = array_values($this->exterior_campaign_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->exterior_campaign_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "\"inventory_id\" = (SELECT ID FROM y_inventory WHERE name = 'Exterior Branding')";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->exterior_campaign_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->exterior_campaign_id->Lookup->renderViewRow($row);
                $this->exterior_campaign_id->EditValue = $arwrk;
            }
            $this->exterior_campaign_id->PlaceHolder = RemoveHtml($this->exterior_campaign_id->caption());

            // interior_campaign_id
            $this->interior_campaign_id->EditAttrs["class"] = "form-control";
            $this->interior_campaign_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->interior_campaign_id->CurrentValue));
            if ($curVal != "") {
                $this->interior_campaign_id->ViewValue = $this->interior_campaign_id->lookupCacheOption($curVal);
            } else {
                $this->interior_campaign_id->ViewValue = $this->interior_campaign_id->Lookup !== null && is_array($this->interior_campaign_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->interior_campaign_id->ViewValue !== null) { // Load from cache
                $this->interior_campaign_id->EditValue = array_values($this->interior_campaign_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->interior_campaign_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "\"inventory_id\" = (SELECT ID FROM y_inventory WHERE name = 'Interior Branding')";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->interior_campaign_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->interior_campaign_id->Lookup->renderViewRow($row);
                $this->interior_campaign_id->EditValue = $arwrk;
            }
            $this->interior_campaign_id->PlaceHolder = RemoveHtml($this->interior_campaign_id->caption());

            // bus_status_id
            $this->bus_status_id->EditAttrs["class"] = "form-control";
            $this->bus_status_id->EditCustomAttributes = "";
            if ($this->bus_status_id->getSessionValue() != "") {
                $this->bus_status_id->CurrentValue = GetForeignKeyValue($this->bus_status_id->getSessionValue());
                $curVal = strval($this->bus_status_id->CurrentValue);
                if ($curVal != "") {
                    $this->bus_status_id->ViewValue = $this->bus_status_id->lookupCacheOption($curVal);
                    if ($this->bus_status_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->bus_status_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->bus_status_id->Lookup->renderViewRow($rswrk[0]);
                            $this->bus_status_id->ViewValue = $this->bus_status_id->displayValue($arwrk);
                        } else {
                            $this->bus_status_id->ViewValue = $this->bus_status_id->CurrentValue;
                        }
                    }
                } else {
                    $this->bus_status_id->ViewValue = null;
                }
                $this->bus_status_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->bus_status_id->CurrentValue));
                if ($curVal != "") {
                    $this->bus_status_id->ViewValue = $this->bus_status_id->lookupCacheOption($curVal);
                } else {
                    $this->bus_status_id->ViewValue = $this->bus_status_id->Lookup !== null && is_array($this->bus_status_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->bus_status_id->ViewValue !== null) { // Load from cache
                    $this->bus_status_id->EditValue = array_values($this->bus_status_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "\"id\"" . SearchString("=", $this->bus_status_id->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->bus_status_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->bus_status_id->EditValue = $arwrk;
                }
                $this->bus_status_id->PlaceHolder = RemoveHtml($this->bus_status_id->caption());
            }

            // bus_size_id
            $this->bus_size_id->EditAttrs["class"] = "form-control";
            $this->bus_size_id->EditCustomAttributes = "";
            if ($this->bus_size_id->getSessionValue() != "") {
                $this->bus_size_id->CurrentValue = GetForeignKeyValue($this->bus_size_id->getSessionValue());
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
            } else {
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
            }

            // bus_depot_id
            $this->bus_depot_id->EditAttrs["class"] = "form-control";
            $this->bus_depot_id->EditCustomAttributes = "";
            if ($this->bus_depot_id->getSessionValue() != "") {
                $this->bus_depot_id->CurrentValue = GetForeignKeyValue($this->bus_depot_id->getSessionValue());
                $curVal = strval($this->bus_depot_id->CurrentValue);
                if ($curVal != "") {
                    $this->bus_depot_id->ViewValue = $this->bus_depot_id->lookupCacheOption($curVal);
                    if ($this->bus_depot_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->bus_depot_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->bus_depot_id->Lookup->renderViewRow($rswrk[0]);
                            $this->bus_depot_id->ViewValue = $this->bus_depot_id->displayValue($arwrk);
                        } else {
                            $this->bus_depot_id->ViewValue = $this->bus_depot_id->CurrentValue;
                        }
                    }
                } else {
                    $this->bus_depot_id->ViewValue = null;
                }
                $this->bus_depot_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->bus_depot_id->CurrentValue));
                if ($curVal != "") {
                    $this->bus_depot_id->ViewValue = $this->bus_depot_id->lookupCacheOption($curVal);
                } else {
                    $this->bus_depot_id->ViewValue = $this->bus_depot_id->Lookup !== null && is_array($this->bus_depot_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->bus_depot_id->ViewValue !== null) { // Load from cache
                    $this->bus_depot_id->EditValue = array_values($this->bus_depot_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "\"id\"" . SearchString("=", $this->bus_depot_id->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->bus_depot_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->bus_depot_id->EditValue = $arwrk;
                }
                $this->bus_depot_id->PlaceHolder = RemoveHtml($this->bus_depot_id->caption());
            }

            // ts_created
            $this->ts_created->EditAttrs["class"] = "form-control";
            $this->ts_created->EditCustomAttributes = "";
            $this->ts_created->EditValue = HtmlEncode(FormatDateTime($this->ts_created->CurrentValue, 8));
            $this->ts_created->PlaceHolder = RemoveHtml($this->ts_created->caption());

            // ts_last_update
            $this->ts_last_update->EditAttrs["class"] = "form-control";
            $this->ts_last_update->EditCustomAttributes = "";
            $this->ts_last_update->EditValue = HtmlEncode(FormatDateTime($this->ts_last_update->CurrentValue, 8));
            $this->ts_last_update->PlaceHolder = RemoveHtml($this->ts_last_update->caption());

            // Edit refer script

            // number
            $this->number->LinkCustomAttributes = "";
            $this->number->HrefValue = "";

            // platform_id
            $this->platform_id->LinkCustomAttributes = "";
            $this->platform_id->HrefValue = "";

            // operator_id
            $this->operator_id->LinkCustomAttributes = "";
            $this->operator_id->HrefValue = "";

            // exterior_campaign_id
            $this->exterior_campaign_id->LinkCustomAttributes = "";
            $this->exterior_campaign_id->HrefValue = "";

            // interior_campaign_id
            $this->interior_campaign_id->LinkCustomAttributes = "";
            $this->interior_campaign_id->HrefValue = "";

            // bus_status_id
            $this->bus_status_id->LinkCustomAttributes = "";
            $this->bus_status_id->HrefValue = "";

            // bus_size_id
            $this->bus_size_id->LinkCustomAttributes = "";
            $this->bus_size_id->HrefValue = "";

            // bus_depot_id
            $this->bus_depot_id->LinkCustomAttributes = "";
            $this->bus_depot_id->HrefValue = "";

            // ts_created
            $this->ts_created->LinkCustomAttributes = "";
            $this->ts_created->HrefValue = "";

            // ts_last_update
            $this->ts_last_update->LinkCustomAttributes = "";
            $this->ts_last_update->HrefValue = "";
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
        if ($this->number->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->platform_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->operator_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->exterior_campaign_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->interior_campaign_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->bus_status_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->bus_size_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->bus_depot_id->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ts_created->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ts_last_update->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($updateCnt == 0) {
            return false;
        }

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->number->Required) {
            if ($this->number->MultiUpdate != "" && !$this->number->IsDetailKey && EmptyValue($this->number->FormValue)) {
                $this->number->addErrorMessage(str_replace("%s", $this->number->caption(), $this->number->RequiredErrorMessage));
            }
        }
        if ($this->platform_id->Required) {
            if ($this->platform_id->MultiUpdate != "" && !$this->platform_id->IsDetailKey && EmptyValue($this->platform_id->FormValue)) {
                $this->platform_id->addErrorMessage(str_replace("%s", $this->platform_id->caption(), $this->platform_id->RequiredErrorMessage));
            }
        }
        if ($this->operator_id->Required) {
            if ($this->operator_id->MultiUpdate != "" && !$this->operator_id->IsDetailKey && EmptyValue($this->operator_id->FormValue)) {
                $this->operator_id->addErrorMessage(str_replace("%s", $this->operator_id->caption(), $this->operator_id->RequiredErrorMessage));
            }
        }
        if ($this->exterior_campaign_id->Required) {
            if ($this->exterior_campaign_id->MultiUpdate != "" && !$this->exterior_campaign_id->IsDetailKey && EmptyValue($this->exterior_campaign_id->FormValue)) {
                $this->exterior_campaign_id->addErrorMessage(str_replace("%s", $this->exterior_campaign_id->caption(), $this->exterior_campaign_id->RequiredErrorMessage));
            }
        }
        if ($this->interior_campaign_id->Required) {
            if ($this->interior_campaign_id->MultiUpdate != "" && !$this->interior_campaign_id->IsDetailKey && EmptyValue($this->interior_campaign_id->FormValue)) {
                $this->interior_campaign_id->addErrorMessage(str_replace("%s", $this->interior_campaign_id->caption(), $this->interior_campaign_id->RequiredErrorMessage));
            }
        }
        if ($this->bus_status_id->Required) {
            if ($this->bus_status_id->MultiUpdate != "" && !$this->bus_status_id->IsDetailKey && EmptyValue($this->bus_status_id->FormValue)) {
                $this->bus_status_id->addErrorMessage(str_replace("%s", $this->bus_status_id->caption(), $this->bus_status_id->RequiredErrorMessage));
            }
        }
        if ($this->bus_size_id->Required) {
            if ($this->bus_size_id->MultiUpdate != "" && !$this->bus_size_id->IsDetailKey && EmptyValue($this->bus_size_id->FormValue)) {
                $this->bus_size_id->addErrorMessage(str_replace("%s", $this->bus_size_id->caption(), $this->bus_size_id->RequiredErrorMessage));
            }
        }
        if ($this->bus_depot_id->Required) {
            if ($this->bus_depot_id->MultiUpdate != "" && !$this->bus_depot_id->IsDetailKey && EmptyValue($this->bus_depot_id->FormValue)) {
                $this->bus_depot_id->addErrorMessage(str_replace("%s", $this->bus_depot_id->caption(), $this->bus_depot_id->RequiredErrorMessage));
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
        if ($this->ts_last_update->Required) {
            if ($this->ts_last_update->MultiUpdate != "" && !$this->ts_last_update->IsDetailKey && EmptyValue($this->ts_last_update->FormValue)) {
                $this->ts_last_update->addErrorMessage(str_replace("%s", $this->ts_last_update->caption(), $this->ts_last_update->RequiredErrorMessage));
            }
        }
        if ($this->ts_last_update->MultiUpdate != "") {
            if (!CheckDate($this->ts_last_update->FormValue)) {
                $this->ts_last_update->addErrorMessage($this->ts_last_update->getErrorMessage(false));
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
        if ($this->number->CurrentValue != "") { // Check field with unique index
            $filterChk = "(\"number\" = '" . AdjustSql($this->number->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->number->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->number->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                $rsChk->closeCursor();
                return false;
            }
        }
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

            // number
            $this->number->setDbValueDef($rsnew, $this->number->CurrentValue, "", $this->number->ReadOnly || $this->number->MultiUpdate != "1");

            // platform_id
            $this->platform_id->setDbValueDef($rsnew, $this->platform_id->CurrentValue, null, $this->platform_id->ReadOnly || $this->platform_id->MultiUpdate != "1");

            // operator_id
            $this->operator_id->setDbValueDef($rsnew, $this->operator_id->CurrentValue, null, $this->operator_id->ReadOnly || $this->operator_id->MultiUpdate != "1");

            // exterior_campaign_id
            $this->exterior_campaign_id->setDbValueDef($rsnew, $this->exterior_campaign_id->CurrentValue, null, $this->exterior_campaign_id->ReadOnly || $this->exterior_campaign_id->MultiUpdate != "1");

            // interior_campaign_id
            $this->interior_campaign_id->setDbValueDef($rsnew, $this->interior_campaign_id->CurrentValue, null, $this->interior_campaign_id->ReadOnly || $this->interior_campaign_id->MultiUpdate != "1");

            // bus_status_id
            if ($this->bus_status_id->getSessionValue() != "") {
                $this->bus_status_id->ReadOnly = true;
            }
            $this->bus_status_id->setDbValueDef($rsnew, $this->bus_status_id->CurrentValue, 0, $this->bus_status_id->ReadOnly || $this->bus_status_id->MultiUpdate != "1");

            // bus_size_id
            if ($this->bus_size_id->getSessionValue() != "") {
                $this->bus_size_id->ReadOnly = true;
            }
            $this->bus_size_id->setDbValueDef($rsnew, $this->bus_size_id->CurrentValue, null, $this->bus_size_id->ReadOnly || $this->bus_size_id->MultiUpdate != "1");

            // bus_depot_id
            if ($this->bus_depot_id->getSessionValue() != "") {
                $this->bus_depot_id->ReadOnly = true;
            }
            $this->bus_depot_id->setDbValueDef($rsnew, $this->bus_depot_id->CurrentValue, null, $this->bus_depot_id->ReadOnly || $this->bus_depot_id->MultiUpdate != "1");

            // ts_created
            $this->ts_created->setDbValueDef($rsnew, UnFormatDateTime($this->ts_created->CurrentValue, 0), CurrentDate(), $this->ts_created->ReadOnly || $this->ts_created->MultiUpdate != "1");

            // ts_last_update
            $this->ts_last_update->setDbValueDef($rsnew, UnFormatDateTime($this->ts_last_update->CurrentValue, 1), CurrentDate(), $this->ts_last_update->ReadOnly || $this->ts_last_update->MultiUpdate != "1");

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("mainbuseslist"), "", $this->TableVar, true);
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
                case "x_operator_id":
                    break;
                case "x_exterior_campaign_id":
                    $lookupFilter = function () {
                        return "\"inventory_id\" = (SELECT ID FROM y_inventory WHERE name = 'Exterior Branding')";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_interior_campaign_id":
                    $lookupFilter = function () {
                        return "\"inventory_id\" = (SELECT ID FROM y_inventory WHERE name = 'Interior Branding')";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_bus_status_id":
                    break;
                case "x_bus_size_id":
                    break;
                case "x_bus_depot_id":
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

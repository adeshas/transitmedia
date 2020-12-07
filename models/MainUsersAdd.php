<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainUsersAdd extends MainUsers
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_users';

    // Page object name
    public $PageObjName = "MainUsersAdd";

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

        // Table object (main_users)
        if (!isset($GLOBALS["main_users"]) || get_class($GLOBALS["main_users"]) == PROJECT_NAMESPACE . "main_users") {
            $GLOBALS["main_users"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'main_users');
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
                $doc = new $class(Container("main_users"));
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
                    if ($pageName == "MainUsersView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->name->setVisibility();
        $this->_username->setVisibility();
        $this->_password->setVisibility();
        $this->_email->setVisibility();
        $this->user_type->setVisibility();
        $this->vendor_id->setVisibility();
        $this->reportsto->setVisibility();
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
        $this->setupLookupOptions($this->vendor_id);
        $this->setupLookupOptions($this->reportsto);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("MainUsersList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "MainUsersList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "MainUsersView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = ROWTYPE_VIEW; // Render view type
        } else {
            $this->RowType = ROWTYPE_ADD; // Render add type
        }

        // Render row
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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->name->CurrentValue = null;
        $this->name->OldValue = $this->name->CurrentValue;
        $this->_username->CurrentValue = null;
        $this->_username->OldValue = $this->_username->CurrentValue;
        $this->_password->CurrentValue = null;
        $this->_password->OldValue = $this->_password->CurrentValue;
        $this->_email->CurrentValue = null;
        $this->_email->OldValue = $this->_email->CurrentValue;
        $this->user_type->CurrentValue = null;
        $this->user_type->OldValue = $this->user_type->CurrentValue;
        $this->vendor_id->CurrentValue = null;
        $this->vendor_id->OldValue = $this->vendor_id->CurrentValue;
        $this->reportsto->CurrentValue = null;
        $this->reportsto->OldValue = $this->reportsto->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'name' first before field var 'x_name'
        $val = $CurrentForm->hasValue("name") ? $CurrentForm->getValue("name") : $CurrentForm->getValue("x_name");
        if (!$this->name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->name->Visible = false; // Disable update for API request
            } else {
                $this->name->setFormValue($val);
            }
        }

        // Check field name 'username' first before field var 'x__username'
        $val = $CurrentForm->hasValue("username") ? $CurrentForm->getValue("username") : $CurrentForm->getValue("x__username");
        if (!$this->_username->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_username->Visible = false; // Disable update for API request
            } else {
                $this->_username->setFormValue($val);
            }
        }

        // Check field name 'password' first before field var 'x__password'
        $val = $CurrentForm->hasValue("password") ? $CurrentForm->getValue("password") : $CurrentForm->getValue("x__password");
        if (!$this->_password->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_password->Visible = false; // Disable update for API request
            } else {
                $this->_password->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'user_type' first before field var 'x_user_type'
        $val = $CurrentForm->hasValue("user_type") ? $CurrentForm->getValue("user_type") : $CurrentForm->getValue("x_user_type");
        if (!$this->user_type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_type->Visible = false; // Disable update for API request
            } else {
                $this->user_type->setFormValue($val);
            }
        }

        // Check field name 'vendor_id' first before field var 'x_vendor_id'
        $val = $CurrentForm->hasValue("vendor_id") ? $CurrentForm->getValue("vendor_id") : $CurrentForm->getValue("x_vendor_id");
        if (!$this->vendor_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vendor_id->Visible = false; // Disable update for API request
            } else {
                $this->vendor_id->setFormValue($val);
            }
        }

        // Check field name 'reportsto' first before field var 'x_reportsto'
        $val = $CurrentForm->hasValue("reportsto") ? $CurrentForm->getValue("reportsto") : $CurrentForm->getValue("x_reportsto");
        if (!$this->reportsto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->reportsto->Visible = false; // Disable update for API request
            } else {
                $this->reportsto->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->name->CurrentValue = $this->name->FormValue;
        $this->_username->CurrentValue = $this->_username->FormValue;
        $this->_password->CurrentValue = $this->_password->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->user_type->CurrentValue = $this->user_type->FormValue;
        $this->vendor_id->CurrentValue = $this->vendor_id->FormValue;
        $this->reportsto->CurrentValue = $this->reportsto->FormValue;
        $this->resetDetailParms();
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("add");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $this->name->setDbValue($row['name']);
        $this->_username->setDbValue($row['username']);
        $this->_password->setDbValue($row['password']);
        $this->_email->setDbValue($row['email']);
        $this->user_type->setDbValue($row['user_type']);
        $this->vendor_id->setDbValue($row['vendor_id']);
        $this->reportsto->setDbValue($row['reportsto']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['name'] = $this->name->CurrentValue;
        $row['username'] = $this->_username->CurrentValue;
        $row['password'] = $this->_password->CurrentValue;
        $row['email'] = $this->_email->CurrentValue;
        $row['user_type'] = $this->user_type->CurrentValue;
        $row['vendor_id'] = $this->vendor_id->CurrentValue;
        $row['reportsto'] = $this->reportsto->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
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

        // name

        // username

        // password

        // email

        // user_type

        // vendor_id

        // reportsto
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // name
            $this->name->ViewValue = $this->name->CurrentValue;
            $this->name->ViewCustomAttributes = "";

            // username
            $this->_username->ViewValue = $this->_username->CurrentValue;
            $this->_username->ViewCustomAttributes = "";

            // password
            $this->_password->ViewValue = $Language->phrase("PasswordMask");
            $this->_password->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // user_type
            if ($Security->canAdmin()) { // System admin
                if (strval($this->user_type->CurrentValue) != "") {
                    $this->user_type->ViewValue = $this->user_type->optionCaption($this->user_type->CurrentValue);
                } else {
                    $this->user_type->ViewValue = null;
                }
            } else {
                $this->user_type->ViewValue = $Language->phrase("PasswordMask");
            }
            $this->user_type->ViewCustomAttributes = "";

            // vendor_id
            $curVal = strval($this->vendor_id->CurrentValue);
            if ($curVal != "") {
                $this->vendor_id->ViewValue = $this->vendor_id->lookupCacheOption($curVal);
                if ($this->vendor_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->vendor_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->vendor_id->Lookup->renderViewRow($rswrk[0]);
                        $this->vendor_id->ViewValue = $this->vendor_id->displayValue($arwrk);
                    } else {
                        $this->vendor_id->ViewValue = $this->vendor_id->CurrentValue;
                    }
                }
            } else {
                $this->vendor_id->ViewValue = null;
            }
            $this->vendor_id->ViewCustomAttributes = "";

            // reportsto
            $curVal = strval($this->reportsto->CurrentValue);
            if ($curVal != "") {
                $this->reportsto->ViewValue = $this->reportsto->lookupCacheOption($curVal);
                if ($this->reportsto->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->reportsto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->reportsto->Lookup->renderViewRow($rswrk[0]);
                        $this->reportsto->ViewValue = $this->reportsto->displayValue($arwrk);
                    } else {
                        $this->reportsto->ViewValue = $this->reportsto->CurrentValue;
                    }
                }
            } else {
                $this->reportsto->ViewValue = null;
            }
            $this->reportsto->ViewCustomAttributes = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";
            $this->name->TooltipValue = "";

            // username
            $this->_username->LinkCustomAttributes = "";
            $this->_username->HrefValue = "";
            $this->_username->TooltipValue = "";

            // password
            $this->_password->LinkCustomAttributes = "";
            $this->_password->HrefValue = "";
            $this->_password->TooltipValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // user_type
            $this->user_type->LinkCustomAttributes = "";
            $this->user_type->HrefValue = "";
            $this->user_type->TooltipValue = "";

            // vendor_id
            $this->vendor_id->LinkCustomAttributes = "";
            $this->vendor_id->HrefValue = "";
            $this->vendor_id->TooltipValue = "";

            // reportsto
            $this->reportsto->LinkCustomAttributes = "";
            $this->reportsto->HrefValue = "";
            $this->reportsto->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // name
            $this->name->EditAttrs["class"] = "form-control";
            $this->name->EditCustomAttributes = "";
            $this->name->EditValue = HtmlEncode($this->name->CurrentValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // username
            $this->_username->EditAttrs["class"] = "form-control";
            $this->_username->EditCustomAttributes = "";
            $this->_username->EditValue = HtmlEncode($this->_username->CurrentValue);
            $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

            // password
            $this->_password->EditAttrs["class"] = "form-control";
            $this->_password->EditCustomAttributes = "";
            $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

            // email
            $this->_email->EditAttrs["class"] = "form-control";
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // user_type
            $this->user_type->EditAttrs["class"] = "form-control";
            $this->user_type->EditCustomAttributes = "";
            if (!$Security->canAdmin()) { // System admin
                $this->user_type->EditValue = $Language->phrase("PasswordMask");
            } else {
                $this->user_type->EditValue = $this->user_type->options(true);
                $this->user_type->PlaceHolder = RemoveHtml($this->user_type->caption());
            }

            // vendor_id
            $this->vendor_id->EditAttrs["class"] = "form-control";
            $this->vendor_id->EditCustomAttributes = "";
            if ($this->vendor_id->getSessionValue() != "") {
                $this->vendor_id->CurrentValue = GetForeignKeyValue($this->vendor_id->getSessionValue());
                $curVal = strval($this->vendor_id->CurrentValue);
                if ($curVal != "") {
                    $this->vendor_id->ViewValue = $this->vendor_id->lookupCacheOption($curVal);
                    if ($this->vendor_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->vendor_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->vendor_id->Lookup->renderViewRow($rswrk[0]);
                            $this->vendor_id->ViewValue = $this->vendor_id->displayValue($arwrk);
                        } else {
                            $this->vendor_id->ViewValue = $this->vendor_id->CurrentValue;
                        }
                    }
                } else {
                    $this->vendor_id->ViewValue = null;
                }
                $this->vendor_id->ViewCustomAttributes = "";
            } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("add")) { // Non system admin
            } else {
                $curVal = trim(strval($this->vendor_id->CurrentValue));
                if ($curVal != "") {
                    $this->vendor_id->ViewValue = $this->vendor_id->lookupCacheOption($curVal);
                } else {
                    $this->vendor_id->ViewValue = $this->vendor_id->Lookup !== null && is_array($this->vendor_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->vendor_id->ViewValue !== null) { // Load from cache
                    $this->vendor_id->EditValue = array_values($this->vendor_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "\"id\"" . SearchString("=", $this->vendor_id->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->vendor_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->vendor_id->EditValue = $arwrk;
                }
                $this->vendor_id->PlaceHolder = RemoveHtml($this->vendor_id->caption());
            }

            // reportsto
            $this->reportsto->EditAttrs["class"] = "form-control";
            $this->reportsto->EditCustomAttributes = "";
            if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
                if (trim(strval($this->reportsto->CurrentValue)) == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->reportsto->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->reportsto->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $arwrk = $rswrk;
                $this->reportsto->EditValue = $arwrk;
            } else {
                $curVal = trim(strval($this->reportsto->CurrentValue));
                if ($curVal != "") {
                    $this->reportsto->ViewValue = $this->reportsto->lookupCacheOption($curVal);
                } else {
                    $this->reportsto->ViewValue = $this->reportsto->Lookup !== null && is_array($this->reportsto->Lookup->Options) ? $curVal : null;
                }
                if ($this->reportsto->ViewValue !== null) { // Load from cache
                    $this->reportsto->EditValue = array_values($this->reportsto->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "\"id\"" . SearchString("=", $this->reportsto->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->reportsto->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->reportsto->EditValue = $arwrk;
                }
                $this->reportsto->PlaceHolder = RemoveHtml($this->reportsto->caption());
            }

            // Add refer script

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // username
            $this->_username->LinkCustomAttributes = "";
            $this->_username->HrefValue = "";

            // password
            $this->_password->LinkCustomAttributes = "";
            $this->_password->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // user_type
            $this->user_type->LinkCustomAttributes = "";
            $this->user_type->HrefValue = "";

            // vendor_id
            $this->vendor_id->LinkCustomAttributes = "";
            $this->vendor_id->HrefValue = "";

            // reportsto
            $this->reportsto->LinkCustomAttributes = "";
            $this->reportsto->HrefValue = "";
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

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->name->Required) {
            if (!$this->name->IsDetailKey && EmptyValue($this->name->FormValue)) {
                $this->name->addErrorMessage(str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
            }
        }
        if ($this->_username->Required) {
            if (!$this->_username->IsDetailKey && EmptyValue($this->_username->FormValue)) {
                $this->_username->addErrorMessage(str_replace("%s", $this->_username->caption(), $this->_username->RequiredErrorMessage));
            }
        }
        if ($this->_password->Required) {
            if (!$this->_password->IsDetailKey && EmptyValue($this->_password->FormValue)) {
                $this->_password->addErrorMessage(str_replace("%s", $this->_password->caption(), $this->_password->RequiredErrorMessage));
            }
        }
        if (!$this->_password->Raw && Config("REMOVE_XSS") && CheckPassword($this->_password->FormValue)) {
            $this->_password->addErrorMessage($Language->phrase("InvalidPasswordChars"));
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->_email->FormValue)) {
            $this->_email->addErrorMessage($this->_email->getErrorMessage(false));
        }
        if ($this->user_type->Required) {
            if (!$this->user_type->IsDetailKey && EmptyValue($this->user_type->FormValue)) {
                $this->user_type->addErrorMessage(str_replace("%s", $this->user_type->caption(), $this->user_type->RequiredErrorMessage));
            }
        }
        if ($this->vendor_id->Required) {
            if (!$this->vendor_id->IsDetailKey && EmptyValue($this->vendor_id->FormValue)) {
                $this->vendor_id->addErrorMessage(str_replace("%s", $this->vendor_id->caption(), $this->vendor_id->RequiredErrorMessage));
            }
        }
        if ($this->reportsto->Required) {
            if (!$this->reportsto->IsDetailKey && EmptyValue($this->reportsto->FormValue)) {
                $this->reportsto->addErrorMessage(str_replace("%s", $this->reportsto->caption(), $this->reportsto->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("MainCampaignsGrid");
        if (in_array("main_campaigns", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->vendor_id->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->vendor_id->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->vendor_id->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }

        // Check if valid Parent User ID
        $validParentUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->reportsto->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validParentUser = $Security->isValidUserID($this->reportsto->CurrentValue);
            if (!$validParentUser) {
                $parentUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedParentUserID"));
                $parentUserIdMsg = str_replace("%p", $this->reportsto->CurrentValue, $parentUserIdMsg);
                $this->setFailureMessage($parentUserIdMsg);
                return false;
            }
        }

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $masterFilter = $this->sqlMasterFilter_y_vendors();
            if (strval($this->vendor_id->CurrentValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($this->vendor_id->CurrentValue, "DB"), $masterFilter);
            } else {
                $masterFilter = "";
            }
            if ($masterFilter != "") {
                $rsmaster = Container("y_vendors")->loadRs($masterFilter)->fetch(\PDO::FETCH_ASSOC);
                $this->MasterRecordExists = $rsmaster !== false;
                $validMasterKey = true;
                if ($this->MasterRecordExists) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['id']);
                } elseif ($this->getCurrentMasterTable() == "y_vendors") {
                    $validMasterKey = false;
                }
                if (!$validMasterKey) {
                    $masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
                    $masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
                    $this->setFailureMessage($masterUserIdMsg);
                    return false;
                }
            }
        }
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, "", false);

        // username
        $this->_username->setDbValueDef($rsnew, $this->_username->CurrentValue, "", false);

        // password
        if (!IsMaskedPassword($this->_password->CurrentValue)) {
            $this->_password->setDbValueDef($rsnew, $this->_password->CurrentValue, "", false);
        }

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, false);

        // user_type
        if ($Security->canAdmin()) { // System admin
            $this->user_type->setDbValueDef($rsnew, $this->user_type->CurrentValue, null, false);
        }

        // vendor_id
        $this->vendor_id->setDbValueDef($rsnew, $this->vendor_id->CurrentValue, null, false);

        // reportsto
        $this->reportsto->setDbValueDef($rsnew, $this->reportsto->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("MainCampaignsGrid");
            if (in_array("main_campaigns", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->user_id->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "main_campaigns"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->user_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->vendor_id->CurrentValue);
        }
        return true;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "y_vendors") {
                $validMaster = true;
                $masterTbl = Container("y_vendors");
                if (($parm = Get("fk_id", Get("vendor_id"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->vendor_id->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->vendor_id->setSessionValue($this->vendor_id->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "y_vendors") {
                $validMaster = true;
                $masterTbl = Container("y_vendors");
                if (($parm = Post("fk_id", Post("vendor_id"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->vendor_id->setFormValue($masterTbl->id->FormValue);
                    $this->vendor_id->setSessionValue($this->vendor_id->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "y_vendors") {
                if ($this->vendor_id->CurrentValue == "") {
                    $this->vendor_id->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("main_campaigns", $detailTblVar)) {
                $detailPageObj = Container("MainCampaignsGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    if ($this->isConfirm()) {
                        $detailPageObj->CurrentAction = "confirm";
                    } else {
                        $detailPageObj->CurrentAction = "gridadd";
                    }
                    if ($this->isCancel()) {
                        $detailPageObj->EventCancelled = true;
                    }

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->user_id->IsDetailKey = true;
                    $detailPageObj->user_id->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->user_id->setSessionValue($detailPageObj->user_id->CurrentValue);
                    $detailPageObj->vendor_id->setSessionValue(""); // Clear session key
                    $detailPageObj->platform_id->setSessionValue(""); // Clear session key
                }
            }
        }
    }

        // Reset detail parms
    protected function resetDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("main_campaigns", $detailTblVar)) {
                $detailPageObj = Container("MainCampaignsGrid");
                if ($detailPageObj->DetailAdd) {
                    $detailPageObj->CurrentAction = "gridadd";
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("MainUsersList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_user_type":
                    break;
                case "x_vendor_id":
                    break;
                case "x_reportsto":
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

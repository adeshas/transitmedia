<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainBusesEdit extends MainBuses
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_buses';

    // Page object name
    public $PageObjName = "MainBusesEdit";

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

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
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
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

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
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->id->setVisibility();
        $this->number->setVisibility();
        $this->platform_id->setVisibility();
        $this->operator_id->setVisibility();
        $this->exterior_campaign_id->setVisibility();
        $this->interior_campaign_id->setVisibility();
        $this->bus_status_id->setVisibility();
        $this->bus_size_id->setVisibility();
        $this->bus_depot_id->setVisibility();
        $this->ts_created->Visible = false;
        $this->ts_last_update->Visible = false;
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
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("mainbuseslist"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "mainbuseslist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = ROWTYPE_VIEW; // Render as View
        } else {
            $this->RowType = ROWTYPE_EDIT; // Render as Edit
        }
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'number' first before field var 'x_number'
        $val = $CurrentForm->hasValue("number") ? $CurrentForm->getValue("number") : $CurrentForm->getValue("x_number");
        if (!$this->number->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->number->Visible = false; // Disable update for API request
            } else {
                $this->number->setFormValue($val);
            }
        }

        // Check field name 'platform_id' first before field var 'x_platform_id'
        $val = $CurrentForm->hasValue("platform_id") ? $CurrentForm->getValue("platform_id") : $CurrentForm->getValue("x_platform_id");
        if (!$this->platform_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->platform_id->Visible = false; // Disable update for API request
            } else {
                $this->platform_id->setFormValue($val);
            }
        }

        // Check field name 'operator_id' first before field var 'x_operator_id'
        $val = $CurrentForm->hasValue("operator_id") ? $CurrentForm->getValue("operator_id") : $CurrentForm->getValue("x_operator_id");
        if (!$this->operator_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->operator_id->Visible = false; // Disable update for API request
            } else {
                $this->operator_id->setFormValue($val);
            }
        }

        // Check field name 'exterior_campaign_id' first before field var 'x_exterior_campaign_id'
        $val = $CurrentForm->hasValue("exterior_campaign_id") ? $CurrentForm->getValue("exterior_campaign_id") : $CurrentForm->getValue("x_exterior_campaign_id");
        if (!$this->exterior_campaign_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->exterior_campaign_id->Visible = false; // Disable update for API request
            } else {
                $this->exterior_campaign_id->setFormValue($val);
            }
        }

        // Check field name 'interior_campaign_id' first before field var 'x_interior_campaign_id'
        $val = $CurrentForm->hasValue("interior_campaign_id") ? $CurrentForm->getValue("interior_campaign_id") : $CurrentForm->getValue("x_interior_campaign_id");
        if (!$this->interior_campaign_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->interior_campaign_id->Visible = false; // Disable update for API request
            } else {
                $this->interior_campaign_id->setFormValue($val);
            }
        }

        // Check field name 'bus_status_id' first before field var 'x_bus_status_id'
        $val = $CurrentForm->hasValue("bus_status_id") ? $CurrentForm->getValue("bus_status_id") : $CurrentForm->getValue("x_bus_status_id");
        if (!$this->bus_status_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bus_status_id->Visible = false; // Disable update for API request
            } else {
                $this->bus_status_id->setFormValue($val);
            }
        }

        // Check field name 'bus_size_id' first before field var 'x_bus_size_id'
        $val = $CurrentForm->hasValue("bus_size_id") ? $CurrentForm->getValue("bus_size_id") : $CurrentForm->getValue("x_bus_size_id");
        if (!$this->bus_size_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bus_size_id->Visible = false; // Disable update for API request
            } else {
                $this->bus_size_id->setFormValue($val);
            }
        }

        // Check field name 'bus_depot_id' first before field var 'x_bus_depot_id'
        $val = $CurrentForm->hasValue("bus_depot_id") ? $CurrentForm->getValue("bus_depot_id") : $CurrentForm->getValue("x_bus_depot_id");
        if (!$this->bus_depot_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bus_depot_id->Visible = false; // Disable update for API request
            } else {
                $this->bus_depot_id->setFormValue($val);
            }
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
            $curVal = trim(strval($this->platform_id->CurrentValue));
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
            $curVal = trim(strval($this->operator_id->CurrentValue));
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
            $curVal = trim(strval($this->exterior_campaign_id->CurrentValue));
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
            $curVal = trim(strval($this->interior_campaign_id->CurrentValue));
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
            $curVal = trim(strval($this->bus_status_id->CurrentValue));
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
            $curVal = trim(strval($this->bus_size_id->CurrentValue));
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
            $curVal = trim(strval($this->bus_depot_id->CurrentValue));
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

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

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
                $curVal = trim(strval($this->bus_status_id->CurrentValue));
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
                $curVal = trim(strval($this->bus_size_id->CurrentValue));
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
                $curVal = trim(strval($this->bus_depot_id->CurrentValue));
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

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->number->Required) {
            if (!$this->number->IsDetailKey && EmptyValue($this->number->FormValue)) {
                $this->number->addErrorMessage(str_replace("%s", $this->number->caption(), $this->number->RequiredErrorMessage));
            }
        }
        if ($this->platform_id->Required) {
            if (!$this->platform_id->IsDetailKey && EmptyValue($this->platform_id->FormValue)) {
                $this->platform_id->addErrorMessage(str_replace("%s", $this->platform_id->caption(), $this->platform_id->RequiredErrorMessage));
            }
        }
        if ($this->operator_id->Required) {
            if (!$this->operator_id->IsDetailKey && EmptyValue($this->operator_id->FormValue)) {
                $this->operator_id->addErrorMessage(str_replace("%s", $this->operator_id->caption(), $this->operator_id->RequiredErrorMessage));
            }
        }
        if ($this->exterior_campaign_id->Required) {
            if (!$this->exterior_campaign_id->IsDetailKey && EmptyValue($this->exterior_campaign_id->FormValue)) {
                $this->exterior_campaign_id->addErrorMessage(str_replace("%s", $this->exterior_campaign_id->caption(), $this->exterior_campaign_id->RequiredErrorMessage));
            }
        }
        if ($this->interior_campaign_id->Required) {
            if (!$this->interior_campaign_id->IsDetailKey && EmptyValue($this->interior_campaign_id->FormValue)) {
                $this->interior_campaign_id->addErrorMessage(str_replace("%s", $this->interior_campaign_id->caption(), $this->interior_campaign_id->RequiredErrorMessage));
            }
        }
        if ($this->bus_status_id->Required) {
            if (!$this->bus_status_id->IsDetailKey && EmptyValue($this->bus_status_id->FormValue)) {
                $this->bus_status_id->addErrorMessage(str_replace("%s", $this->bus_status_id->caption(), $this->bus_status_id->RequiredErrorMessage));
            }
        }
        if ($this->bus_size_id->Required) {
            if (!$this->bus_size_id->IsDetailKey && EmptyValue($this->bus_size_id->FormValue)) {
                $this->bus_size_id->addErrorMessage(str_replace("%s", $this->bus_size_id->caption(), $this->bus_size_id->RequiredErrorMessage));
            }
        }
        if ($this->bus_depot_id->Required) {
            if (!$this->bus_depot_id->IsDetailKey && EmptyValue($this->bus_depot_id->FormValue)) {
                $this->bus_depot_id->addErrorMessage(str_replace("%s", $this->bus_depot_id->caption(), $this->bus_depot_id->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("SubMediaAllocationGrid");
        if (in_array("sub_media_allocation", $detailTblVar) && $detailPage->DetailEdit) {
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
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Begin transaction
            if ($this->getCurrentDetailTable() != "") {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // number
            $this->number->setDbValueDef($rsnew, $this->number->CurrentValue, "", $this->number->ReadOnly);

            // platform_id
            $this->platform_id->setDbValueDef($rsnew, $this->platform_id->CurrentValue, null, $this->platform_id->ReadOnly);

            // operator_id
            $this->operator_id->setDbValueDef($rsnew, $this->operator_id->CurrentValue, null, $this->operator_id->ReadOnly);

            // exterior_campaign_id
            $this->exterior_campaign_id->setDbValueDef($rsnew, $this->exterior_campaign_id->CurrentValue, null, $this->exterior_campaign_id->ReadOnly);

            // interior_campaign_id
            $this->interior_campaign_id->setDbValueDef($rsnew, $this->interior_campaign_id->CurrentValue, null, $this->interior_campaign_id->ReadOnly);

            // bus_status_id
            if ($this->bus_status_id->getSessionValue() != "") {
                $this->bus_status_id->ReadOnly = true;
            }
            $this->bus_status_id->setDbValueDef($rsnew, $this->bus_status_id->CurrentValue, 0, $this->bus_status_id->ReadOnly);

            // bus_size_id
            if ($this->bus_size_id->getSessionValue() != "") {
                $this->bus_size_id->ReadOnly = true;
            }
            $this->bus_size_id->setDbValueDef($rsnew, $this->bus_size_id->CurrentValue, null, $this->bus_size_id->ReadOnly);

            // bus_depot_id
            if ($this->bus_depot_id->getSessionValue() != "") {
                $this->bus_depot_id->ReadOnly = true;
            }
            $this->bus_depot_id->setDbValueDef($rsnew, $this->bus_depot_id->CurrentValue, null, $this->bus_depot_id->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("SubMediaAllocationGrid");
                    if (in_array("sub_media_allocation", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "sub_media_allocation"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        $conn->commit(); // Commit transaction
                    } else {
                        $conn->rollback(); // Rollback transaction
                    }
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
            if ($masterTblVar == "x_bus_status") {
                $validMaster = true;
                $masterTbl = Container("x_bus_status");
                if (($parm = Get("fk_id", Get("bus_status_id"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->bus_status_id->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->bus_status_id->setSessionValue($this->bus_status_id->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "x_bus_sizes") {
                $validMaster = true;
                $masterTbl = Container("x_bus_sizes");
                if (($parm = Get("fk_id", Get("bus_size_id"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->bus_size_id->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->bus_size_id->setSessionValue($this->bus_size_id->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "x_bus_depot") {
                $validMaster = true;
                $masterTbl = Container("x_bus_depot");
                if (($parm = Get("fk_id", Get("bus_depot_id"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->bus_depot_id->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->bus_depot_id->setSessionValue($this->bus_depot_id->QueryStringValue);
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
            if ($masterTblVar == "x_bus_status") {
                $validMaster = true;
                $masterTbl = Container("x_bus_status");
                if (($parm = Post("fk_id", Post("bus_status_id"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->bus_status_id->setFormValue($masterTbl->id->FormValue);
                    $this->bus_status_id->setSessionValue($this->bus_status_id->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "x_bus_sizes") {
                $validMaster = true;
                $masterTbl = Container("x_bus_sizes");
                if (($parm = Post("fk_id", Post("bus_size_id"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->bus_size_id->setFormValue($masterTbl->id->FormValue);
                    $this->bus_size_id->setSessionValue($this->bus_size_id->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "x_bus_depot") {
                $validMaster = true;
                $masterTbl = Container("x_bus_depot");
                if (($parm = Post("fk_id", Post("bus_depot_id"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->bus_depot_id->setFormValue($masterTbl->id->FormValue);
                    $this->bus_depot_id->setSessionValue($this->bus_depot_id->FormValue);
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
            $this->setSessionWhere($this->getDetailFilter());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "x_bus_status") {
                if ($this->bus_status_id->CurrentValue == "") {
                    $this->bus_status_id->setSessionValue("");
                }
            }
            if ($masterTblVar != "x_bus_sizes") {
                if ($this->bus_size_id->CurrentValue == "") {
                    $this->bus_size_id->setSessionValue("");
                }
            }
            if ($masterTblVar != "x_bus_depot") {
                if ($this->bus_depot_id->CurrentValue == "") {
                    $this->bus_depot_id->setSessionValue("");
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
            if (in_array("sub_media_allocation", $detailTblVar)) {
                $detailPageObj = Container("SubMediaAllocationGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    if ($this->isConfirm()) {
                        $detailPageObj->CurrentAction = "confirm";
                    } else {
                        $detailPageObj->CurrentAction = "gridedit";
                    }
                    if ($this->isCancel()) {
                        $detailPageObj->EventCancelled = true;
                    }

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->bus_id->IsDetailKey = true;
                    $detailPageObj->bus_id->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->bus_id->setSessionValue($detailPageObj->bus_id->CurrentValue);
                    $detailPageObj->campaign_id->setSessionValue(""); // Clear session key
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
            if (in_array("sub_media_allocation", $detailTblVar)) {
                $detailPageObj = Container("SubMediaAllocationGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentAction = "gridedit";
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("mainbuseslist"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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

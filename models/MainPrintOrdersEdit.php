<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainPrintOrdersEdit extends MainPrintOrders
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_print_orders';

    // Page object name
    public $PageObjName = "MainPrintOrdersEdit";

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

        // Table object (main_print_orders)
        if (!isset($GLOBALS["main_print_orders"]) || get_class($GLOBALS["main_print_orders"]) == PROJECT_NAMESPACE . "main_print_orders") {
            $GLOBALS["main_print_orders"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'main_print_orders');
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
                $doc = new $class(Container("main_print_orders"));
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
                    if ($pageName == "mainprintordersview") {
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
        $this->campaign_id->setVisibility();
        $this->printer_id->setVisibility();
        $this->ts_created->Visible = false;
        $this->link->Visible = false;
        $this->quantity->setVisibility();
        $this->approved->setVisibility();
        $this->comments->setVisibility();
        $this->all_codes_assigned_in_campaign->setVisibility();
        $this->bus_codes->setVisibility();
        $this->available_codes_to_be_assigned->Visible = false;
        $this->tags->setVisibility();
        $this->hideFieldsForAddEdit();
        $this->quantity->Required = false;

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->campaign_id);
        $this->setupLookupOptions($this->printer_id);

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
                $this->setKey(Post($this->OldKeyName));
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
                    $this->terminate("mainprintorderslist"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "mainprintorderslist") {
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
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'campaign_id' first before field var 'x_campaign_id'
        $val = $CurrentForm->hasValue("campaign_id") ? $CurrentForm->getValue("campaign_id") : $CurrentForm->getValue("x_campaign_id");
        if (!$this->campaign_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->campaign_id->Visible = false; // Disable update for API request
            } else {
                $this->campaign_id->setFormValue($val);
            }
        }

        // Check field name 'printer_id' first before field var 'x_printer_id'
        $val = $CurrentForm->hasValue("printer_id") ? $CurrentForm->getValue("printer_id") : $CurrentForm->getValue("x_printer_id");
        if (!$this->printer_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->printer_id->Visible = false; // Disable update for API request
            } else {
                $this->printer_id->setFormValue($val);
            }
        }

        // Check field name 'quantity' first before field var 'x_quantity'
        $val = $CurrentForm->hasValue("quantity") ? $CurrentForm->getValue("quantity") : $CurrentForm->getValue("x_quantity");
        if (!$this->quantity->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->quantity->Visible = false; // Disable update for API request
            } else {
                $this->quantity->setFormValue($val);
            }
        }

        // Check field name 'approved' first before field var 'x_approved'
        $val = $CurrentForm->hasValue("approved") ? $CurrentForm->getValue("approved") : $CurrentForm->getValue("x_approved");
        if (!$this->approved->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->approved->Visible = false; // Disable update for API request
            } else {
                $this->approved->setFormValue($val);
            }
        }

        // Check field name 'comments' first before field var 'x_comments'
        $val = $CurrentForm->hasValue("comments") ? $CurrentForm->getValue("comments") : $CurrentForm->getValue("x_comments");
        if (!$this->comments->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->comments->Visible = false; // Disable update for API request
            } else {
                $this->comments->setFormValue($val);
            }
        }

        // Check field name 'all_codes_assigned_in_campaign' first before field var 'x_all_codes_assigned_in_campaign'
        $val = $CurrentForm->hasValue("all_codes_assigned_in_campaign") ? $CurrentForm->getValue("all_codes_assigned_in_campaign") : $CurrentForm->getValue("x_all_codes_assigned_in_campaign");
        if (!$this->all_codes_assigned_in_campaign->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->all_codes_assigned_in_campaign->Visible = false; // Disable update for API request
            } else {
                $this->all_codes_assigned_in_campaign->setFormValue($val);
            }
        }

        // Check field name 'bus_codes' first before field var 'x_bus_codes'
        $val = $CurrentForm->hasValue("bus_codes") ? $CurrentForm->getValue("bus_codes") : $CurrentForm->getValue("x_bus_codes");
        if (!$this->bus_codes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bus_codes->Visible = false; // Disable update for API request
            } else {
                $this->bus_codes->setFormValue($val);
            }
        }

        // Check field name 'tags' first before field var 'x_tags'
        $val = $CurrentForm->hasValue("tags") ? $CurrentForm->getValue("tags") : $CurrentForm->getValue("x_tags");
        if (!$this->tags->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tags->Visible = false; // Disable update for API request
            } else {
                $this->tags->setFormValue($val);
            }
        }

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
        $this->campaign_id->CurrentValue = $this->campaign_id->FormValue;
        $this->printer_id->CurrentValue = $this->printer_id->FormValue;
        $this->quantity->CurrentValue = $this->quantity->FormValue;
        $this->approved->CurrentValue = $this->approved->FormValue;
        $this->comments->CurrentValue = $this->comments->FormValue;
        $this->all_codes_assigned_in_campaign->CurrentValue = $this->all_codes_assigned_in_campaign->FormValue;
        $this->bus_codes->CurrentValue = $this->bus_codes->FormValue;
        $this->tags->CurrentValue = $this->tags->FormValue;
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
        $this->campaign_id->setDbValue($row['campaign_id']);
        $this->printer_id->setDbValue($row['printer_id']);
        $this->ts_created->setDbValue($row['ts_created']);
        $this->link->setDbValue($row['link']);
        $this->quantity->setDbValue($row['quantity']);
        $this->approved->setDbValue((ConvertToBool($row['approved']) ? "1" : "0"));
        $this->comments->setDbValue($row['comments']);
        $this->all_codes_assigned_in_campaign->setDbValue($row['all_codes_assigned_in_campaign']);
        $this->bus_codes->setDbValue($row['bus_codes']);
        $this->available_codes_to_be_assigned->setDbValue($row['available_codes_to_be_assigned']);
        $this->tags->setDbValue($row['tags']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['campaign_id'] = null;
        $row['printer_id'] = null;
        $row['ts_created'] = null;
        $row['link'] = null;
        $row['quantity'] = null;
        $row['approved'] = null;
        $row['comments'] = null;
        $row['all_codes_assigned_in_campaign'] = null;
        $row['bus_codes'] = null;
        $row['available_codes_to_be_assigned'] = null;
        $row['tags'] = null;
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

        // campaign_id

        // printer_id

        // ts_created

        // link

        // quantity

        // approved

        // comments

        // all_codes_assigned_in_campaign

        // bus_codes

        // available_codes_to_be_assigned

        // tags
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // campaign_id
            $curVal = strval($this->campaign_id->CurrentValue);
            if ($curVal != "") {
                $this->campaign_id->ViewValue = $this->campaign_id->lookupCacheOption($curVal);
                if ($this->campaign_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "ts_created between  now()-'30 days'::interval AND now()";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->campaign_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->campaign_id->Lookup->renderViewRow($rswrk[0]);
                        $this->campaign_id->ViewValue = $this->campaign_id->displayValue($arwrk);
                    } else {
                        $this->campaign_id->ViewValue = $this->campaign_id->CurrentValue;
                    }
                }
            } else {
                $this->campaign_id->ViewValue = null;
            }
            $this->campaign_id->ViewCustomAttributes = "";

            // printer_id
            $curVal = strval($this->printer_id->CurrentValue);
            if ($curVal != "") {
                $this->printer_id->ViewValue = $this->printer_id->lookupCacheOption($curVal);
                if ($this->printer_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->printer_id->Lookup->getSql(false, $filterWrk, '', $this, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->printer_id->Lookup->renderViewRow($rswrk[0]);
                        $this->printer_id->ViewValue = $this->printer_id->displayValue($arwrk);
                    } else {
                        $this->printer_id->ViewValue = $this->printer_id->CurrentValue;
                    }
                }
            } else {
                $this->printer_id->ViewValue = null;
            }
            $this->printer_id->ViewCustomAttributes = "";

            // ts_created
            $this->ts_created->ViewValue = $this->ts_created->CurrentValue;
            $this->ts_created->ViewValue = FormatDateTime($this->ts_created->ViewValue, 0);
            $this->ts_created->ViewCustomAttributes = "";

            // quantity
            $this->quantity->ViewValue = $this->quantity->CurrentValue;
            $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
            $this->quantity->ViewCustomAttributes = "";

            // approved
            if (ConvertToBool($this->approved->CurrentValue)) {
                $this->approved->ViewValue = $this->approved->tagCaption(1) != "" ? $this->approved->tagCaption(1) : "Yes";
            } else {
                $this->approved->ViewValue = $this->approved->tagCaption(2) != "" ? $this->approved->tagCaption(2) : "No";
            }
            $this->approved->ViewCustomAttributes = "";

            // comments
            $this->comments->ViewValue = $this->comments->CurrentValue;
            $this->comments->ViewCustomAttributes = "";

            // all_codes_assigned_in_campaign
            $this->all_codes_assigned_in_campaign->ViewValue = $this->all_codes_assigned_in_campaign->CurrentValue;
            $this->all_codes_assigned_in_campaign->ViewCustomAttributes = "";

            // bus_codes
            $this->bus_codes->ViewValue = $this->bus_codes->CurrentValue;
            $this->bus_codes->ViewCustomAttributes = "";

            // tags
            $this->tags->ViewValue = $this->tags->CurrentValue;
            $this->tags->ViewCustomAttributes = "";

            // campaign_id
            $this->campaign_id->LinkCustomAttributes = "";
            $this->campaign_id->HrefValue = "";
            $this->campaign_id->TooltipValue = "";

            // printer_id
            $this->printer_id->LinkCustomAttributes = "";
            $this->printer_id->HrefValue = "";
            $this->printer_id->TooltipValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";
            $this->quantity->TooltipValue = "";

            // approved
            $this->approved->LinkCustomAttributes = "";
            $this->approved->HrefValue = "";
            $this->approved->TooltipValue = "";

            // comments
            $this->comments->LinkCustomAttributes = "";
            $this->comments->HrefValue = "";
            $this->comments->TooltipValue = "";

            // all_codes_assigned_in_campaign
            $this->all_codes_assigned_in_campaign->LinkCustomAttributes = "";
            $this->all_codes_assigned_in_campaign->HrefValue = "";
            $this->all_codes_assigned_in_campaign->TooltipValue = "";

            // bus_codes
            $this->bus_codes->LinkCustomAttributes = "";
            $this->bus_codes->HrefValue = "";
            $this->bus_codes->TooltipValue = "";

            // tags
            $this->tags->LinkCustomAttributes = "";
            $this->tags->HrefValue = "";
            $this->tags->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // campaign_id
            $this->campaign_id->EditAttrs["class"] = "form-control";
            $this->campaign_id->EditCustomAttributes = "";
            $curVal = strval($this->campaign_id->CurrentValue);
            if ($curVal != "") {
                $this->campaign_id->EditValue = $this->campaign_id->lookupCacheOption($curVal);
                if ($this->campaign_id->EditValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "ts_created between  now()-'30 days'::interval AND now()";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->campaign_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->campaign_id->Lookup->renderViewRow($rswrk[0]);
                        $this->campaign_id->EditValue = $this->campaign_id->displayValue($arwrk);
                    } else {
                        $this->campaign_id->EditValue = $this->campaign_id->CurrentValue;
                    }
                }
            } else {
                $this->campaign_id->EditValue = null;
            }
            $this->campaign_id->ViewCustomAttributes = "";

            // printer_id
            $this->printer_id->EditAttrs["class"] = "form-control";
            $this->printer_id->EditCustomAttributes = "";
            $curVal = strval($this->printer_id->CurrentValue);
            if ($curVal != "") {
                $this->printer_id->EditValue = $this->printer_id->lookupCacheOption($curVal);
                if ($this->printer_id->EditValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->printer_id->Lookup->getSql(false, $filterWrk, '', $this, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->printer_id->Lookup->renderViewRow($rswrk[0]);
                        $this->printer_id->EditValue = $this->printer_id->displayValue($arwrk);
                    } else {
                        $this->printer_id->EditValue = $this->printer_id->CurrentValue;
                    }
                }
            } else {
                $this->printer_id->EditValue = null;
            }
            $this->printer_id->ViewCustomAttributes = "";

            // quantity
            $this->quantity->EditAttrs["class"] = "form-control";
            $this->quantity->EditCustomAttributes = "";
            $this->quantity->EditValue = $this->quantity->CurrentValue;
            $this->quantity->EditValue = FormatNumber($this->quantity->EditValue, 0, -2, -2, -2);
            $this->quantity->ViewCustomAttributes = "";

            // approved
            $this->approved->EditCustomAttributes = "";
            $this->approved->EditValue = $this->approved->options(false);
            $this->approved->PlaceHolder = RemoveHtml($this->approved->caption());

            // comments
            $this->comments->EditAttrs["class"] = "form-control";
            $this->comments->EditCustomAttributes = "";
            $this->comments->EditValue = HtmlEncode($this->comments->CurrentValue);
            $this->comments->PlaceHolder = RemoveHtml($this->comments->caption());

            // all_codes_assigned_in_campaign
            $this->all_codes_assigned_in_campaign->EditAttrs["class"] = "form-control";
            $this->all_codes_assigned_in_campaign->EditCustomAttributes = "";
            $this->all_codes_assigned_in_campaign->EditValue = $this->all_codes_assigned_in_campaign->CurrentValue;
            $this->all_codes_assigned_in_campaign->ViewCustomAttributes = "";

            // bus_codes
            $this->bus_codes->EditAttrs["class"] = "form-control";
            $this->bus_codes->EditCustomAttributes = "";
            $this->bus_codes->EditValue = HtmlEncode($this->bus_codes->CurrentValue);
            $this->bus_codes->PlaceHolder = RemoveHtml($this->bus_codes->caption());

            // tags
            $this->tags->EditAttrs["class"] = "form-control";
            $this->tags->EditCustomAttributes = "";
            $this->tags->EditValue = HtmlEncode($this->tags->CurrentValue);
            $this->tags->PlaceHolder = RemoveHtml($this->tags->caption());

            // Edit refer script

            // campaign_id
            $this->campaign_id->LinkCustomAttributes = "";
            $this->campaign_id->HrefValue = "";
            $this->campaign_id->TooltipValue = "";

            // printer_id
            $this->printer_id->LinkCustomAttributes = "";
            $this->printer_id->HrefValue = "";
            $this->printer_id->TooltipValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";
            $this->quantity->TooltipValue = "";

            // approved
            $this->approved->LinkCustomAttributes = "";
            $this->approved->HrefValue = "";

            // comments
            $this->comments->LinkCustomAttributes = "";
            $this->comments->HrefValue = "";

            // all_codes_assigned_in_campaign
            $this->all_codes_assigned_in_campaign->LinkCustomAttributes = "";
            $this->all_codes_assigned_in_campaign->HrefValue = "";
            $this->all_codes_assigned_in_campaign->TooltipValue = "";

            // bus_codes
            $this->bus_codes->LinkCustomAttributes = "";
            $this->bus_codes->HrefValue = "";

            // tags
            $this->tags->LinkCustomAttributes = "";
            $this->tags->HrefValue = "";
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
        if ($this->campaign_id->Required) {
            if (!$this->campaign_id->IsDetailKey && EmptyValue($this->campaign_id->FormValue)) {
                $this->campaign_id->addErrorMessage(str_replace("%s", $this->campaign_id->caption(), $this->campaign_id->RequiredErrorMessage));
            }
        }
        if ($this->printer_id->Required) {
            if (!$this->printer_id->IsDetailKey && EmptyValue($this->printer_id->FormValue)) {
                $this->printer_id->addErrorMessage(str_replace("%s", $this->printer_id->caption(), $this->printer_id->RequiredErrorMessage));
            }
        }
        if ($this->quantity->Required) {
            if (!$this->quantity->IsDetailKey && EmptyValue($this->quantity->FormValue)) {
                $this->quantity->addErrorMessage(str_replace("%s", $this->quantity->caption(), $this->quantity->RequiredErrorMessage));
            }
        }
        if ($this->approved->Required) {
            if ($this->approved->FormValue == "") {
                $this->approved->addErrorMessage(str_replace("%s", $this->approved->caption(), $this->approved->RequiredErrorMessage));
            }
        }
        if ($this->comments->Required) {
            if (!$this->comments->IsDetailKey && EmptyValue($this->comments->FormValue)) {
                $this->comments->addErrorMessage(str_replace("%s", $this->comments->caption(), $this->comments->RequiredErrorMessage));
            }
        }
        if ($this->all_codes_assigned_in_campaign->Required) {
            if (!$this->all_codes_assigned_in_campaign->IsDetailKey && EmptyValue($this->all_codes_assigned_in_campaign->FormValue)) {
                $this->all_codes_assigned_in_campaign->addErrorMessage(str_replace("%s", $this->all_codes_assigned_in_campaign->caption(), $this->all_codes_assigned_in_campaign->RequiredErrorMessage));
            }
        }
        if ($this->bus_codes->Required) {
            if (!$this->bus_codes->IsDetailKey && EmptyValue($this->bus_codes->FormValue)) {
                $this->bus_codes->addErrorMessage(str_replace("%s", $this->bus_codes->caption(), $this->bus_codes->RequiredErrorMessage));
            }
        }
        if ($this->tags->Required) {
            if (!$this->tags->IsDetailKey && EmptyValue($this->tags->FormValue)) {
                $this->tags->addErrorMessage(str_replace("%s", $this->tags->caption(), $this->tags->RequiredErrorMessage));
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

            // approved
            $tmpBool = $this->approved->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->approved->setDbValueDef($rsnew, $tmpBool, null, $this->approved->ReadOnly);

            // comments
            $this->comments->setDbValueDef($rsnew, $this->comments->CurrentValue, null, $this->comments->ReadOnly);

            // bus_codes
            $this->bus_codes->setDbValueDef($rsnew, $this->bus_codes->CurrentValue, null, $this->bus_codes->ReadOnly);

            // tags
            $this->tags->setDbValueDef($rsnew, $this->tags->CurrentValue, null, $this->tags->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("mainprintorderslist"), "", $this->TableVar, true);
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
                case "x_campaign_id":
                    $lookupFilter = function () {
                        return "ts_created between  now()-'30 days'::interval AND now()";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_printer_id":
                    break;
                case "x_approved":
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

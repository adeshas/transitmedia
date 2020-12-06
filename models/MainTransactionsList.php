<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainTransactionsList extends MainTransactions
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_transactions';

    // Page object name
    public $PageObjName = "MainTransactionsList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fmain_transactionslist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Table object (main_transactions)
        if (!isset($GLOBALS["main_transactions"]) || get_class($GLOBALS["main_transactions"]) == PROJECT_NAMESPACE . "main_transactions") {
            $GLOBALS["main_transactions"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "maintransactionsadd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "maintransactionsdelete";
        $this->MultiUpdateUrl = "maintransactionsupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'main_transactions');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Import options
        $this->ImportOptions = new ListOptions("div");
        $this->ImportOptions->TagClassName = "ew-import-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fmain_transactionslistsrch";

        // List actions
        $this->ListActions = new ListActions();
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
                $doc = new $class(Container("main_transactions"));
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Create form object
        $CurrentForm = new HttpForm();

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } elseif (IsPost()) {
            if (Post("exporttype") !== null) {
                $this->Export = Post("exporttype");
            }
            $custom = Post("custom", "");
        } elseif (Get("cmd") == "json") {
            $this->Export = Get("cmd");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportFileName = $this->TableVar; // Get export file, used in header

        // Get custom export parameters
        if ($this->isExport() && $custom != "") {
            $this->CustomExport = $this->Export;
            $this->Export = "print";
        }
        $CustomExportType = $this->CustomExport;
        $ExportType = $this->Export; // Get export parameter, used in header

        // Update Export URLs
        if (Config("USE_PHPEXCEL")) {
            $this->ExportExcelCustom = false;
        }
        if (Config("USE_PHPWORD")) {
            $this->ExportWordCustom = false;
        }
        if ($this->ExportExcelCustom) {
            $this->ExportExcelUrl .= "&amp;custom=1";
        }
        if ($this->ExportWordCustom) {
            $this->ExportWordUrl .= "&amp;custom=1";
        }
        if ($this->ExportPdfCustom) {
            $this->ExportPdfUrl .= "&amp;custom=1";
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();

        // Setup export options
        $this->setupExportOptions();
        $this->id->setVisibility();
        $this->campaign_id->setVisibility();
        $this->operator_id->setVisibility();
        $this->payment_date->setVisibility();
        $this->vendor_id->setVisibility();
        $this->price_id->setVisibility();
        $this->quantity->setVisibility();
        $this->assigned_buses->setVisibility();
        $this->start_date->setVisibility();
        $this->end_date->setVisibility();
        $this->visible_status_id->setVisibility();
        $this->status_id->setVisibility();
        $this->print_status_id->setVisibility();
        $this->payment_status_id->setVisibility();
        $this->created_by->Visible = false;
        $this->ts_created->Visible = false;
        $this->ts_last_update->Visible = false;
        $this->total->setVisibility();
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Show checkbox column if multiple action
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
                $this->ListOptions["checkbox"]->Visible = true;
                break;
            }
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->campaign_id);
        $this->setupLookupOptions($this->operator_id);
        $this->setupLookupOptions($this->vendor_id);
        $this->setupLookupOptions($this->price_id);
        $this->setupLookupOptions($this->visible_status_id);
        $this->setupLookupOptions($this->status_id);
        $this->setupLookupOptions($this->print_status_id);
        $this->setupLookupOptions($this->payment_status_id);
        $this->setupLookupOptions($this->created_by);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Check QueryString parameters
            if (Get("action") !== null) {
                $this->CurrentAction = Get("action");

                // Clear inline mode
                if ($this->isCancel()) {
                    $this->clearInlineMode();
                }

                // Switch to grid edit mode
                if ($this->isGridEdit()) {
                    $this->gridEditMode();
                }

                // Switch to inline edit mode
                if ($this->isEdit()) {
                    $this->inlineEditMode();
                }

                // Switch to grid add mode
                if ($this->isGridAdd()) {
                    $this->gridAddMode();
                }
            } else {
                if (Post("action") !== null) {
                    $this->CurrentAction = Post("action"); // Get action

                    // Grid Update
                    if (($this->isGridUpdate() || $this->isGridOverwrite()) && Session(SESSION_INLINE_MODE) == "gridedit") {
                        if ($this->validateGridForm()) {
                            $gridUpdate = $this->gridUpdate();
                        } else {
                            $gridUpdate = false;
                        }
                        if ($gridUpdate) {
                        } else {
                            $this->EventCancelled = true;
                            $this->gridEditMode(); // Stay in Grid edit mode
                        }
                    }

                    // Inline Update
                    if (($this->isUpdate() || $this->isOverwrite()) && Session(SESSION_INLINE_MODE) == "edit") {
                        $this->setKey(Post($this->OldKeyName));
                        $this->inlineUpdate();
                    }

                    // Grid Insert
                    if ($this->isGridInsert() && Session(SESSION_INLINE_MODE) == "gridadd") {
                        if ($this->validateGridForm()) {
                            $gridInsert = $this->gridInsert();
                        } else {
                            $gridInsert = false;
                        }
                        if ($gridInsert) {
                        } else {
                            $this->EventCancelled = true;
                            $this->gridAddMode(); // Stay in Grid add mode
                        }
                    }
                } elseif (Session(SESSION_INLINE_MODE) == "gridedit") { // Previously in grid edit mode
                    if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NO")) !== null) { // Stay in grid edit mode if paging
                        $this->gridEditMode();
                    } else { // Reset grid edit
                        $this->clearInlineMode();
                    }
                }
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Get and validate search values for advanced search
            $this->loadSearchValues(); // Get search values

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }
            if (!$this->validateSearch()) {
                // Nothing to do
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }

            // Get search criteria for advanced search
            if (!$this->hasInvalidFields()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }

            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter
        $this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter

        // Add master User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
                if ($this->getCurrentMasterTable() == "main_campaigns") {
                    $this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "main_campaigns"); // Add master User ID filter
                }
                if ($this->getCurrentMasterTable() == "y_operators") {
                    $this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "y_operators"); // Add master User ID filter
                }
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "main_campaigns") {
            $masterTbl = Container("main_campaigns");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("maincampaignslist"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "y_operators") {
            $masterTbl = Container("y_operators");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("yoperatorslist"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }

        // Export data only
        if (!$this->CustomExport && in_array($this->Export, array_keys(Config("EXPORT_CLASSES")))) {
            $this->exportData();
            $this->terminate();
            return;
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Search/sort options
        $this->setupSearchSortOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Inline Edit mode
    protected function inlineEditMode()
    {
        global $Security, $Language;
        if (!$Security->canEdit()) {
            return false; // Edit not allowed
        }
        $inlineEdit = true;
        if (($keyValue = Get("id") ?? Route("id")) !== null) {
            $this->id->setQueryStringValue($keyValue);
        } else {
            $inlineEdit = false;
        }
        if ($inlineEdit) {
            if ($this->loadRow()) {
                    // Check if valid User ID
                    if (!$this->showOptionLink("edit")) {
                        $userIdMsg = $Language->phrase("NoEditPermission");
                        $this->setFailureMessage($userIdMsg);
                        $this->clearInlineMode(); // Clear inline edit mode
                        return false;
                    }
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
                $this->setKey($this->OldKey); // Set to OldValue
                $_SESSION[SESSION_INLINE_MODE] = "edit"; // Enable inline edit
            }
        }
        return true;
    }

    // Perform update to Inline Edit record
    protected function inlineUpdate()
    {
        global $Language, $CurrentForm;
        $CurrentForm->Index = 1;
        $this->loadFormValues(); // Get form values

        // Validate form
        $inlineUpdate = true;
        if (!$this->validateForm()) {
            $inlineUpdate = false; // Form error, reset action
        } else {
            $inlineUpdate = false;
            $this->SendEmail = true; // Send email on update success
            $inlineUpdate = $this->editRow(); // Update record
        }
        if ($inlineUpdate) { // Update success
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
            $this->EventCancelled = true; // Cancel event
            $this->CurrentAction = "edit"; // Stay in edit mode
        }
    }

    // Check Inline Edit key
    public function checkInlineEditKey()
    {
        if (!SameString($this->id->OldValue, $this->id->CurrentValue)) {
            return false;
        }
        return true;
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAll();
            $rs->closeCursor();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }

        // Begin transaction
        $conn->beginTransaction();
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            $conn->commit(); // Commit transaction

            // Get new records
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            $conn->rollback(); // Rollback transaction
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Begin transaction
        $conn->beginTransaction();

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->id->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->setFailureMessage($Language->phrase("NoAddRecord"));
            $gridInsert = false;
        }
        if ($gridInsert) {
            $conn->commit(); // Commit transaction

            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("InsertSuccess")); // Set up insert success message
            }
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            $conn->rollback(); // Rollback transaction
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_campaign_id") && $CurrentForm->hasValue("o_campaign_id") && $this->campaign_id->CurrentValue != $this->campaign_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_operator_id") && $CurrentForm->hasValue("o_operator_id") && $this->operator_id->CurrentValue != $this->operator_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_payment_date") && $CurrentForm->hasValue("o_payment_date") && $this->payment_date->CurrentValue != $this->payment_date->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_vendor_id") && $CurrentForm->hasValue("o_vendor_id") && $this->vendor_id->CurrentValue != $this->vendor_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_price_id") && $CurrentForm->hasValue("o_price_id") && $this->price_id->CurrentValue != $this->price_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_quantity") && $CurrentForm->hasValue("o_quantity") && $this->quantity->CurrentValue != $this->quantity->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_assigned_buses") && $CurrentForm->hasValue("o_assigned_buses") && $this->assigned_buses->CurrentValue != $this->assigned_buses->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_start_date") && $CurrentForm->hasValue("o_start_date") && $this->start_date->CurrentValue != $this->start_date->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_end_date") && $CurrentForm->hasValue("o_end_date") && $this->end_date->CurrentValue != $this->end_date->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_visible_status_id") && $CurrentForm->hasValue("o_visible_status_id") && $this->visible_status_id->CurrentValue != $this->visible_status_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_status_id") && $CurrentForm->hasValue("o_status_id") && $this->status_id->CurrentValue != $this->status_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_print_status_id") && $CurrentForm->hasValue("o_print_status_id") && $this->print_status_id->CurrentValue != $this->print_status_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_payment_status_id") && $CurrentForm->hasValue("o_payment_status_id") && $this->payment_status_id->CurrentValue != $this->payment_status_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_total") && $CurrentForm->hasValue("o_total") && $this->total->CurrentValue != $this->total->OldValue) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->id->clearErrorMessage();
        $this->campaign_id->clearErrorMessage();
        $this->operator_id->clearErrorMessage();
        $this->payment_date->clearErrorMessage();
        $this->vendor_id->clearErrorMessage();
        $this->price_id->clearErrorMessage();
        $this->quantity->clearErrorMessage();
        $this->assigned_buses->clearErrorMessage();
        $this->start_date->clearErrorMessage();
        $this->end_date->clearErrorMessage();
        $this->visible_status_id->clearErrorMessage();
        $this->status_id->clearErrorMessage();
        $this->print_status_id->clearErrorMessage();
        $this->payment_status_id->clearErrorMessage();
        $this->total->clearErrorMessage();
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->campaign_id->AdvancedSearch->toJson(), ","); // Field campaign_id
        $filterList = Concat($filterList, $this->operator_id->AdvancedSearch->toJson(), ","); // Field operator_id
        $filterList = Concat($filterList, $this->payment_date->AdvancedSearch->toJson(), ","); // Field payment_date
        $filterList = Concat($filterList, $this->vendor_id->AdvancedSearch->toJson(), ","); // Field vendor_id
        $filterList = Concat($filterList, $this->price_id->AdvancedSearch->toJson(), ","); // Field price_id
        $filterList = Concat($filterList, $this->quantity->AdvancedSearch->toJson(), ","); // Field quantity
        $filterList = Concat($filterList, $this->assigned_buses->AdvancedSearch->toJson(), ","); // Field assigned_buses
        $filterList = Concat($filterList, $this->start_date->AdvancedSearch->toJson(), ","); // Field start_date
        $filterList = Concat($filterList, $this->end_date->AdvancedSearch->toJson(), ","); // Field end_date
        $filterList = Concat($filterList, $this->visible_status_id->AdvancedSearch->toJson(), ","); // Field visible_status_id
        $filterList = Concat($filterList, $this->status_id->AdvancedSearch->toJson(), ","); // Field status_id
        $filterList = Concat($filterList, $this->print_status_id->AdvancedSearch->toJson(), ","); // Field print_status_id
        $filterList = Concat($filterList, $this->payment_status_id->AdvancedSearch->toJson(), ","); // Field payment_status_id
        $filterList = Concat($filterList, $this->created_by->AdvancedSearch->toJson(), ","); // Field created_by
        $filterList = Concat($filterList, $this->ts_created->AdvancedSearch->toJson(), ","); // Field ts_created
        $filterList = Concat($filterList, $this->ts_last_update->AdvancedSearch->toJson(), ","); // Field ts_last_update
        $filterList = Concat($filterList, $this->total->AdvancedSearch->toJson(), ","); // Field total
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fmain_transactionslistsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field id
        $this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
        $this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
        $this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
        $this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
        $this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
        $this->id->AdvancedSearch->save();

        // Field campaign_id
        $this->campaign_id->AdvancedSearch->SearchValue = @$filter["x_campaign_id"];
        $this->campaign_id->AdvancedSearch->SearchOperator = @$filter["z_campaign_id"];
        $this->campaign_id->AdvancedSearch->SearchCondition = @$filter["v_campaign_id"];
        $this->campaign_id->AdvancedSearch->SearchValue2 = @$filter["y_campaign_id"];
        $this->campaign_id->AdvancedSearch->SearchOperator2 = @$filter["w_campaign_id"];
        $this->campaign_id->AdvancedSearch->save();

        // Field operator_id
        $this->operator_id->AdvancedSearch->SearchValue = @$filter["x_operator_id"];
        $this->operator_id->AdvancedSearch->SearchOperator = @$filter["z_operator_id"];
        $this->operator_id->AdvancedSearch->SearchCondition = @$filter["v_operator_id"];
        $this->operator_id->AdvancedSearch->SearchValue2 = @$filter["y_operator_id"];
        $this->operator_id->AdvancedSearch->SearchOperator2 = @$filter["w_operator_id"];
        $this->operator_id->AdvancedSearch->save();

        // Field payment_date
        $this->payment_date->AdvancedSearch->SearchValue = @$filter["x_payment_date"];
        $this->payment_date->AdvancedSearch->SearchOperator = @$filter["z_payment_date"];
        $this->payment_date->AdvancedSearch->SearchCondition = @$filter["v_payment_date"];
        $this->payment_date->AdvancedSearch->SearchValue2 = @$filter["y_payment_date"];
        $this->payment_date->AdvancedSearch->SearchOperator2 = @$filter["w_payment_date"];
        $this->payment_date->AdvancedSearch->save();

        // Field vendor_id
        $this->vendor_id->AdvancedSearch->SearchValue = @$filter["x_vendor_id"];
        $this->vendor_id->AdvancedSearch->SearchOperator = @$filter["z_vendor_id"];
        $this->vendor_id->AdvancedSearch->SearchCondition = @$filter["v_vendor_id"];
        $this->vendor_id->AdvancedSearch->SearchValue2 = @$filter["y_vendor_id"];
        $this->vendor_id->AdvancedSearch->SearchOperator2 = @$filter["w_vendor_id"];
        $this->vendor_id->AdvancedSearch->save();

        // Field price_id
        $this->price_id->AdvancedSearch->SearchValue = @$filter["x_price_id"];
        $this->price_id->AdvancedSearch->SearchOperator = @$filter["z_price_id"];
        $this->price_id->AdvancedSearch->SearchCondition = @$filter["v_price_id"];
        $this->price_id->AdvancedSearch->SearchValue2 = @$filter["y_price_id"];
        $this->price_id->AdvancedSearch->SearchOperator2 = @$filter["w_price_id"];
        $this->price_id->AdvancedSearch->save();

        // Field quantity
        $this->quantity->AdvancedSearch->SearchValue = @$filter["x_quantity"];
        $this->quantity->AdvancedSearch->SearchOperator = @$filter["z_quantity"];
        $this->quantity->AdvancedSearch->SearchCondition = @$filter["v_quantity"];
        $this->quantity->AdvancedSearch->SearchValue2 = @$filter["y_quantity"];
        $this->quantity->AdvancedSearch->SearchOperator2 = @$filter["w_quantity"];
        $this->quantity->AdvancedSearch->save();

        // Field assigned_buses
        $this->assigned_buses->AdvancedSearch->SearchValue = @$filter["x_assigned_buses"];
        $this->assigned_buses->AdvancedSearch->SearchOperator = @$filter["z_assigned_buses"];
        $this->assigned_buses->AdvancedSearch->SearchCondition = @$filter["v_assigned_buses"];
        $this->assigned_buses->AdvancedSearch->SearchValue2 = @$filter["y_assigned_buses"];
        $this->assigned_buses->AdvancedSearch->SearchOperator2 = @$filter["w_assigned_buses"];
        $this->assigned_buses->AdvancedSearch->save();

        // Field start_date
        $this->start_date->AdvancedSearch->SearchValue = @$filter["x_start_date"];
        $this->start_date->AdvancedSearch->SearchOperator = @$filter["z_start_date"];
        $this->start_date->AdvancedSearch->SearchCondition = @$filter["v_start_date"];
        $this->start_date->AdvancedSearch->SearchValue2 = @$filter["y_start_date"];
        $this->start_date->AdvancedSearch->SearchOperator2 = @$filter["w_start_date"];
        $this->start_date->AdvancedSearch->save();

        // Field end_date
        $this->end_date->AdvancedSearch->SearchValue = @$filter["x_end_date"];
        $this->end_date->AdvancedSearch->SearchOperator = @$filter["z_end_date"];
        $this->end_date->AdvancedSearch->SearchCondition = @$filter["v_end_date"];
        $this->end_date->AdvancedSearch->SearchValue2 = @$filter["y_end_date"];
        $this->end_date->AdvancedSearch->SearchOperator2 = @$filter["w_end_date"];
        $this->end_date->AdvancedSearch->save();

        // Field visible_status_id
        $this->visible_status_id->AdvancedSearch->SearchValue = @$filter["x_visible_status_id"];
        $this->visible_status_id->AdvancedSearch->SearchOperator = @$filter["z_visible_status_id"];
        $this->visible_status_id->AdvancedSearch->SearchCondition = @$filter["v_visible_status_id"];
        $this->visible_status_id->AdvancedSearch->SearchValue2 = @$filter["y_visible_status_id"];
        $this->visible_status_id->AdvancedSearch->SearchOperator2 = @$filter["w_visible_status_id"];
        $this->visible_status_id->AdvancedSearch->save();

        // Field status_id
        $this->status_id->AdvancedSearch->SearchValue = @$filter["x_status_id"];
        $this->status_id->AdvancedSearch->SearchOperator = @$filter["z_status_id"];
        $this->status_id->AdvancedSearch->SearchCondition = @$filter["v_status_id"];
        $this->status_id->AdvancedSearch->SearchValue2 = @$filter["y_status_id"];
        $this->status_id->AdvancedSearch->SearchOperator2 = @$filter["w_status_id"];
        $this->status_id->AdvancedSearch->save();

        // Field print_status_id
        $this->print_status_id->AdvancedSearch->SearchValue = @$filter["x_print_status_id"];
        $this->print_status_id->AdvancedSearch->SearchOperator = @$filter["z_print_status_id"];
        $this->print_status_id->AdvancedSearch->SearchCondition = @$filter["v_print_status_id"];
        $this->print_status_id->AdvancedSearch->SearchValue2 = @$filter["y_print_status_id"];
        $this->print_status_id->AdvancedSearch->SearchOperator2 = @$filter["w_print_status_id"];
        $this->print_status_id->AdvancedSearch->save();

        // Field payment_status_id
        $this->payment_status_id->AdvancedSearch->SearchValue = @$filter["x_payment_status_id"];
        $this->payment_status_id->AdvancedSearch->SearchOperator = @$filter["z_payment_status_id"];
        $this->payment_status_id->AdvancedSearch->SearchCondition = @$filter["v_payment_status_id"];
        $this->payment_status_id->AdvancedSearch->SearchValue2 = @$filter["y_payment_status_id"];
        $this->payment_status_id->AdvancedSearch->SearchOperator2 = @$filter["w_payment_status_id"];
        $this->payment_status_id->AdvancedSearch->save();

        // Field created_by
        $this->created_by->AdvancedSearch->SearchValue = @$filter["x_created_by"];
        $this->created_by->AdvancedSearch->SearchOperator = @$filter["z_created_by"];
        $this->created_by->AdvancedSearch->SearchCondition = @$filter["v_created_by"];
        $this->created_by->AdvancedSearch->SearchValue2 = @$filter["y_created_by"];
        $this->created_by->AdvancedSearch->SearchOperator2 = @$filter["w_created_by"];
        $this->created_by->AdvancedSearch->save();

        // Field ts_created
        $this->ts_created->AdvancedSearch->SearchValue = @$filter["x_ts_created"];
        $this->ts_created->AdvancedSearch->SearchOperator = @$filter["z_ts_created"];
        $this->ts_created->AdvancedSearch->SearchCondition = @$filter["v_ts_created"];
        $this->ts_created->AdvancedSearch->SearchValue2 = @$filter["y_ts_created"];
        $this->ts_created->AdvancedSearch->SearchOperator2 = @$filter["w_ts_created"];
        $this->ts_created->AdvancedSearch->save();

        // Field ts_last_update
        $this->ts_last_update->AdvancedSearch->SearchValue = @$filter["x_ts_last_update"];
        $this->ts_last_update->AdvancedSearch->SearchOperator = @$filter["z_ts_last_update"];
        $this->ts_last_update->AdvancedSearch->SearchCondition = @$filter["v_ts_last_update"];
        $this->ts_last_update->AdvancedSearch->SearchValue2 = @$filter["y_ts_last_update"];
        $this->ts_last_update->AdvancedSearch->SearchOperator2 = @$filter["w_ts_last_update"];
        $this->ts_last_update->AdvancedSearch->save();

        // Field total
        $this->total->AdvancedSearch->SearchValue = @$filter["x_total"];
        $this->total->AdvancedSearch->SearchOperator = @$filter["z_total"];
        $this->total->AdvancedSearch->SearchCondition = @$filter["v_total"];
        $this->total->AdvancedSearch->SearchValue2 = @$filter["y_total"];
        $this->total->AdvancedSearch->SearchOperator2 = @$filter["w_total"];
        $this->total->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Advanced search WHERE clause based on QueryString
    protected function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->id, $default, false); // id
        $this->buildSearchSql($where, $this->campaign_id, $default, false); // campaign_id
        $this->buildSearchSql($where, $this->operator_id, $default, false); // operator_id
        $this->buildSearchSql($where, $this->payment_date, $default, false); // payment_date
        $this->buildSearchSql($where, $this->vendor_id, $default, false); // vendor_id
        $this->buildSearchSql($where, $this->price_id, $default, false); // price_id
        $this->buildSearchSql($where, $this->quantity, $default, false); // quantity
        $this->buildSearchSql($where, $this->assigned_buses, $default, false); // assigned_buses
        $this->buildSearchSql($where, $this->start_date, $default, false); // start_date
        $this->buildSearchSql($where, $this->end_date, $default, false); // end_date
        $this->buildSearchSql($where, $this->visible_status_id, $default, false); // visible_status_id
        $this->buildSearchSql($where, $this->status_id, $default, false); // status_id
        $this->buildSearchSql($where, $this->print_status_id, $default, false); // print_status_id
        $this->buildSearchSql($where, $this->payment_status_id, $default, false); // payment_status_id
        $this->buildSearchSql($where, $this->created_by, $default, false); // created_by
        $this->buildSearchSql($where, $this->ts_created, $default, false); // ts_created
        $this->buildSearchSql($where, $this->ts_last_update, $default, false); // ts_last_update
        $this->buildSearchSql($where, $this->total, $default, false); // total

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->id->AdvancedSearch->save(); // id
            $this->campaign_id->AdvancedSearch->save(); // campaign_id
            $this->operator_id->AdvancedSearch->save(); // operator_id
            $this->payment_date->AdvancedSearch->save(); // payment_date
            $this->vendor_id->AdvancedSearch->save(); // vendor_id
            $this->price_id->AdvancedSearch->save(); // price_id
            $this->quantity->AdvancedSearch->save(); // quantity
            $this->assigned_buses->AdvancedSearch->save(); // assigned_buses
            $this->start_date->AdvancedSearch->save(); // start_date
            $this->end_date->AdvancedSearch->save(); // end_date
            $this->visible_status_id->AdvancedSearch->save(); // visible_status_id
            $this->status_id->AdvancedSearch->save(); // status_id
            $this->print_status_id->AdvancedSearch->save(); // print_status_id
            $this->payment_status_id->AdvancedSearch->save(); // payment_status_id
            $this->created_by->AdvancedSearch->save(); // created_by
            $this->ts_created->AdvancedSearch->save(); // ts_created
            $this->ts_last_update->AdvancedSearch->save(); // ts_last_update
            $this->total->AdvancedSearch->save(); // total
        }
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, &$fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = ($default) ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = ($default) ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = ($default) ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = ($default) ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = ($default) ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $wrk = "";
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        if ($fldOpr == "") {
            $fldOpr = "=";
        }
        $fldOpr2 = strtoupper(trim($fldOpr2));
        if ($fldOpr2 == "") {
            $fldOpr2 = "=";
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk1 = ($fldVal != "") ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = ($fldVal2 != "") ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            $wrk = $wrk1; // Build final SQL
            if ($wrk2 != "") {
                $wrk = ($wrk != "") ? "($wrk) $fldCond ($wrk2)" : $wrk2;
            }
        } else {
            $fldVal = $this->convertSearchValue($fld, $fldVal);
            $fldVal2 = $this->convertSearchValue($fld, $fldVal2);
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        AddFilter($where, $wrk);
    }

    // Convert search value
    protected function convertSearchValue(&$fld, $fldVal)
    {
        if ($fldVal == Config("NULL_VALUE") || $fldVal == Config("NOT_NULL_VALUE")) {
            return $fldVal;
        }
        $value = $fldVal;
        if ($fld->isBoolean()) {
            if ($fldVal != "") {
                $value = (SameText($fldVal, "1") || SameText($fldVal, "y") || SameText($fldVal, "t")) ? $fld->TrueValue : $fld->FalseValue;
            }
        } elseif ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME) {
            if ($fldVal != "") {
                $value = UnFormatDateTime($fldVal, $fld->DateTimeFormat);
            }
        }
        return $value;
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->vendor_id, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->price_id, $arKeywords, $type);
        return $where;
    }

    // Build basic search SQL
    protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
    {
        $defCond = ($type == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($arKeywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $arKeywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $ar = explode("\\", $keyword);
            } else {
                $ar = [$keyword];
            }
            foreach ($ar as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $type == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } elseif ($keyword == Config("NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NULL";
                    } elseif ($keyword == Config("NOT_NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NOT NULL";
                    } elseif ($fld->IsVirtual && $fld->Visible) {
                        $wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    } elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
                        $wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            // Search keyword in any fields
            if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        if ($searchStr != "") {
                            $searchStr .= " " . $searchType . " ";
                        }
                        $searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
                    }
                }
            } else {
                $searchStr = $this->basicSearchSql($ar, $searchType);
            }
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        if ($this->id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->campaign_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->operator_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->payment_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->vendor_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->quantity->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->assigned_buses->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->start_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->end_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->visible_status_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->print_status_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->payment_status_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->created_by->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ts_created->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ts_last_update->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->total->AdvancedSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
                $this->id->AdvancedSearch->unsetSession();
                $this->campaign_id->AdvancedSearch->unsetSession();
                $this->operator_id->AdvancedSearch->unsetSession();
                $this->payment_date->AdvancedSearch->unsetSession();
                $this->vendor_id->AdvancedSearch->unsetSession();
                $this->price_id->AdvancedSearch->unsetSession();
                $this->quantity->AdvancedSearch->unsetSession();
                $this->assigned_buses->AdvancedSearch->unsetSession();
                $this->start_date->AdvancedSearch->unsetSession();
                $this->end_date->AdvancedSearch->unsetSession();
                $this->visible_status_id->AdvancedSearch->unsetSession();
                $this->status_id->AdvancedSearch->unsetSession();
                $this->print_status_id->AdvancedSearch->unsetSession();
                $this->payment_status_id->AdvancedSearch->unsetSession();
                $this->created_by->AdvancedSearch->unsetSession();
                $this->ts_created->AdvancedSearch->unsetSession();
                $this->ts_last_update->AdvancedSearch->unsetSession();
                $this->total->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
                $this->id->AdvancedSearch->load();
                $this->campaign_id->AdvancedSearch->load();
                $this->operator_id->AdvancedSearch->load();
                $this->payment_date->AdvancedSearch->load();
                $this->vendor_id->AdvancedSearch->load();
                $this->price_id->AdvancedSearch->load();
                $this->quantity->AdvancedSearch->load();
                $this->assigned_buses->AdvancedSearch->load();
                $this->start_date->AdvancedSearch->load();
                $this->end_date->AdvancedSearch->load();
                $this->visible_status_id->AdvancedSearch->load();
                $this->status_id->AdvancedSearch->load();
                $this->print_status_id->AdvancedSearch->load();
                $this->payment_status_id->AdvancedSearch->load();
                $this->created_by->AdvancedSearch->load();
                $this->ts_created->AdvancedSearch->load();
                $this->ts_last_update->AdvancedSearch->load();
                $this->total->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id); // id
            $this->updateSort($this->campaign_id); // campaign_id
            $this->updateSort($this->operator_id); // operator_id
            $this->updateSort($this->payment_date); // payment_date
            $this->updateSort($this->vendor_id); // vendor_id
            $this->updateSort($this->price_id); // price_id
            $this->updateSort($this->quantity); // quantity
            $this->updateSort($this->assigned_buses); // assigned_buses
            $this->updateSort($this->start_date); // start_date
            $this->updateSort($this->end_date); // end_date
            $this->updateSort($this->visible_status_id); // visible_status_id
            $this->updateSort($this->status_id); // status_id
            $this->updateSort($this->print_status_id); // print_status_id
            $this->updateSort($this->payment_status_id); // payment_status_id
            $this->updateSort($this->total); // total
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "\"id\" DESC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->id->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->id->setSort("DESC");
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->campaign_id->setSessionValue("");
                        $this->operator_id->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->setSessionOrderByList($orderBy);
                $this->id->setSort("");
                $this->campaign_id->setSort("");
                $this->operator_id->setSort("");
                $this->payment_date->setSort("");
                $this->vendor_id->setSort("");
                $this->price_id->setSort("");
                $this->quantity->setSort("");
                $this->assigned_buses->setSort("");
                $this->start_date->setSort("");
                $this->end_date->setSort("");
                $this->visible_status_id->setSort("");
                $this->status_id->setSort("");
                $this->print_status_id->setSort("");
                $this->payment_status_id->setSort("");
                $this->created_by->setSort("");
                $this->ts_created->setSort("");
                $this->ts_last_update->setSort("");
                $this->total->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = false;
            $item->Visible = false; // Default hidden
        }

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

        // "detail_sub_transaction_details"
        $item = &$this->ListOptions->add("detail_sub_transaction_details");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sub_transaction_details') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$this->ListOptions->add("details");
            $item->CssClass = "text-nowrap";
            $item->Visible = $this->ShowMultipleDetails;
            $item->OnLeft = false;
            $item->ShowInButtonGroup = false;
        }

        // Set up detail pages
        $pages = new SubPages();
        $pages->add("sub_transaction_details");
        $this->DetailPages = $pages;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = false;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;
        $item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        $pageUrl = $this->pageUrl();

        // "edit"
        $opt = $this->ListOptions["edit"];
        if ($this->isInlineEditRow()) { // Inline-Edit
            $this->ListOptions->CustomItem = "edit"; // Show edit column only
            $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                $opt->Body = "<div" . (($opt->OnLeft) ? " class=\"text-right\"" : "") . ">" .
                "<a class=\"ew-grid-link ew-inline-update\" title=\"" . HtmlTitle($Language->phrase("UpdateLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("UpdateLink")) . "\" href=\"#\" onclick=\"return ew.forms.get(this).submit(event, '" . UrlAddHash($this->pageName(), "r" . $this->RowCount . "_" . $this->TableVar) . "');\">" . $Language->phrase("UpdateLink") . "</a>&nbsp;" .
                "<a class=\"ew-grid-link ew-inline-cancel\" title=\"" . HtmlTitle($Language->phrase("CancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("CancelLink") . "</a>" .
                "<input type=\"hidden\" name=\"action\" id=\"action\" value=\"update\"></div>";
            $opt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . HtmlEncode($this->id->CurrentValue) . "\">";
            return;
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView() && $this->showOptionLink("view")) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit() && $this->showOptionLink("edit")) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
                $opt->Body .= "<a class=\"ew-row-link ew-inline-edit\" title=\"" . HtmlTitle($Language->phrase("InlineEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("InlineEditLink")) . "\" href=\"" . HtmlEncode(UrlAddHash(GetUrl($this->InlineEditUrl), "r" . $this->RowCount . "_" . $this->TableVar)) . "\">" . $Language->phrase("InlineEditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete() && $this->showOptionLink("delete")) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . "" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
                    $action = $listaction->Action;
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a></li>";
                    if (count($links) == 1) { // Single button
                        $body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
                $opt->Visible = true;
            }
        }
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_sub_transaction_details"
        $opt = $this->ListOptions["detail_sub_transaction_details"];
        if ($Security->allowList(CurrentProjectID() . 'sub_transaction_details') && $this->showOptionLink()) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("sub_transaction_details", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("subtransactiondetailslist?" . Config("TABLE_SHOW_MASTER") . "=main_transactions&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("SubTransactionDetailsGrid");
            if ($detailPage->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'main_transactions')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sub_transaction_details");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sub_transaction_details";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'main_transactions')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sub_transaction_details");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sub_transaction_details";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailCopyLink")) . "\" href=\"" . HtmlEncode($this->GetCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailCopyLink")) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlTitle($Language->phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $opt = $this->ListOptions["details"];
            $opt->Body = $body;
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $item = &$option->add("gridadd");
        $item->Body = "<a class=\"ew-add-edit ew-grid-add\" title=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridAddUrl)) . "\">" . $Language->phrase("GridAddLink") . "</a>";
        $item->Visible = $this->GridAddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
                $item = &$option->add("detailadd_sub_transaction_details");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sub_transaction_details");
                $detailPage = Container("SubTransactionDetailsGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'main_transactions') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "sub_transaction_details";
                }

        // Add multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$option->add("detailsadd");
            $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailTableLink);
            $caption = $Language->phrase("AddMasterDetailLink");
            $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
            $item->Visible = $detailTableLink != "" && $Security->canAdd();
            // Hide single master/detail items
            $ar = explode(",", $detailTableLink);
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                if ($item = $option["detailadd_" . $ar[$i]]) {
                    $item->Visible = false;
                }
            }
        }

        // Add grid edit
        $option = $options["addedit"];
        $item = &$option->add("gridedit");
        $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        $item->Visible = $this->GridEditUrl != "" && $Security->canEdit();
        $option = $options["action"];

        // Add multi update
        $item = &$option->add("multiupdate");
        $item->Body = "<a class=\"ew-action ew-multi-update\" title=\"" . HtmlTitle($Language->phrase("UpdateSelectedLink")) . "\" data-table=\"main_transactions\" data-caption=\"" . HtmlTitle($Language->phrase("UpdateSelectedLink")) . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'UpdateBtn',f:document.fmain_transactionslist,url:'" . GetUrl($this->MultiUpdateUrl) . "'});return false;\">" . $Language->phrase("UpdateSelectedLink") . "</a>";
        $item->Visible = $Security->canEdit();

        // Set up options default
        foreach ($options as $option) {
            $option->UseDropDownButton = false;
            $option->UseButtonGroup = true;
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->add($option->GroupOptionName);
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fmain_transactionslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fmain_transactionslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (!$this->isGridAdd() && !$this->isGridEdit()) { // Not grid add/edit mode
            $option = $options["action"];
            // Set up list action buttons
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_MULTIPLE) {
                    $item = &$option->add("custom_" . $listaction->Action);
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                    $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fmain_transactionslist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
                    $item->Visible = $listaction->Allow;
                }
            }

            // Hide grid edit and other options
            if ($this->TotalRecords <= 0) {
                $option = $options["addedit"];
                $item = $option["gridedit"];
                if ($item) {
                    $item->Visible = false;
                }
                $option = $options["action"];
                $option->hideAllOptions();
            }
        } else { // Grid add/edit mode
            // Hide all options first
            foreach ($options as $option) {
                $option->hideAllOptions();
            }
            $pageUrl = $this->pageUrl();

            // Grid-Add
            if ($this->isGridAdd()) {
                if ($this->AllowAddDeleteRow) {
                    // Add add blank row
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                }
                $option = $options["action"];
                $option->UseDropDownButton = false;
                // Add grid insert
                $item = &$option->add("gridinsert");
                $item->Body = "<a class=\"ew-action ew-grid-insert\" title=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" href=\"#\" onclick=\"return ew.forms.get(this).submit(event, '" . $this->pageName() . "');\">" . $Language->phrase("GridInsertLink") . "</a>";
                // Add grid cancel
                $item = &$option->add("gridcancel");
                $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
            }

            // Grid-Edit
            if ($this->isGridEdit()) {
                if ($this->AllowAddDeleteRow) {
                    // Add add blank row
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                }
                $option = $options["action"];
                $option->UseDropDownButton = false;
                    $item = &$option->add("gridsave");
                    $item->Body = "<a class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" href=\"#\" onclick=\"return ew.forms.get(this).submit(event, '" . $this->pageName() . "');\">" . $Language->phrase("GridSaveLink") . "</a>";
                    $item = &$option->add("gridcancel");
                    $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                    $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
            }
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn, \PDO::FETCH_ASSOC);
            $this->CurrentAction = $userAction;

            // Call row action event
            if ($rs) {
                $conn->beginTransaction();
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    $conn->commit(); // Commit the changes
                    if ($this->getSuccessMessage() == "" && !ob_get_length()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    $conn->rollback(); // Rollback changes

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            $this->CurrentAction = ""; // Clear action
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->campaign_id->CurrentValue = null;
        $this->campaign_id->OldValue = $this->campaign_id->CurrentValue;
        $this->operator_id->CurrentValue = null;
        $this->operator_id->OldValue = $this->operator_id->CurrentValue;
        $this->payment_date->CurrentValue = null;
        $this->payment_date->OldValue = $this->payment_date->CurrentValue;
        $this->vendor_id->CurrentValue = CurrentUserID();
        $this->vendor_id->OldValue = $this->vendor_id->CurrentValue;
        $this->price_id->CurrentValue = null;
        $this->price_id->OldValue = $this->price_id->CurrentValue;
        $this->quantity->CurrentValue = null;
        $this->quantity->OldValue = $this->quantity->CurrentValue;
        $this->assigned_buses->CurrentValue = null;
        $this->assigned_buses->OldValue = $this->assigned_buses->CurrentValue;
        $this->start_date->CurrentValue = null;
        $this->start_date->OldValue = $this->start_date->CurrentValue;
        $this->end_date->CurrentValue = null;
        $this->end_date->OldValue = $this->end_date->CurrentValue;
        $this->visible_status_id->CurrentValue = null;
        $this->visible_status_id->OldValue = $this->visible_status_id->CurrentValue;
        $this->status_id->CurrentValue = null;
        $this->status_id->OldValue = $this->status_id->CurrentValue;
        $this->print_status_id->CurrentValue = null;
        $this->print_status_id->OldValue = $this->print_status_id->CurrentValue;
        $this->payment_status_id->CurrentValue = null;
        $this->payment_status_id->OldValue = $this->payment_status_id->CurrentValue;
        $this->created_by->CurrentValue = null;
        $this->created_by->OldValue = $this->created_by->CurrentValue;
        $this->ts_created->CurrentValue = null;
        $this->ts_created->OldValue = $this->ts_created->CurrentValue;
        $this->ts_last_update->CurrentValue = null;
        $this->ts_last_update->OldValue = $this->ts_last_update->CurrentValue;
        $this->total->CurrentValue = null;
        $this->total->OldValue = $this->total->CurrentValue;
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // id
        if (!$this->isAddOrEdit() && $this->id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->id->AdvancedSearch->SearchValue != "" || $this->id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // campaign_id
        if (!$this->isAddOrEdit() && $this->campaign_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->campaign_id->AdvancedSearch->SearchValue != "" || $this->campaign_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // operator_id
        if (!$this->isAddOrEdit() && $this->operator_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->operator_id->AdvancedSearch->SearchValue != "" || $this->operator_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // payment_date
        if (!$this->isAddOrEdit() && $this->payment_date->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->payment_date->AdvancedSearch->SearchValue != "" || $this->payment_date->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // vendor_id
        if (!$this->isAddOrEdit() && $this->vendor_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->vendor_id->AdvancedSearch->SearchValue != "" || $this->vendor_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // price_id
        if (!$this->isAddOrEdit() && $this->price_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price_id->AdvancedSearch->SearchValue != "" || $this->price_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // quantity
        if (!$this->isAddOrEdit() && $this->quantity->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->quantity->AdvancedSearch->SearchValue != "" || $this->quantity->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // assigned_buses
        if (!$this->isAddOrEdit() && $this->assigned_buses->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->assigned_buses->AdvancedSearch->SearchValue != "" || $this->assigned_buses->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // start_date
        if (!$this->isAddOrEdit() && $this->start_date->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->start_date->AdvancedSearch->SearchValue != "" || $this->start_date->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // end_date
        if (!$this->isAddOrEdit() && $this->end_date->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->end_date->AdvancedSearch->SearchValue != "" || $this->end_date->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // visible_status_id
        if (!$this->isAddOrEdit() && $this->visible_status_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->visible_status_id->AdvancedSearch->SearchValue != "" || $this->visible_status_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // status_id
        if (!$this->isAddOrEdit() && $this->status_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->status_id->AdvancedSearch->SearchValue != "" || $this->status_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // print_status_id
        if (!$this->isAddOrEdit() && $this->print_status_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->print_status_id->AdvancedSearch->SearchValue != "" || $this->print_status_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // payment_status_id
        if (!$this->isAddOrEdit() && $this->payment_status_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->payment_status_id->AdvancedSearch->SearchValue != "" || $this->payment_status_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // created_by
        if (!$this->isAddOrEdit() && $this->created_by->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->created_by->AdvancedSearch->SearchValue != "" || $this->created_by->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ts_created
        if (!$this->isAddOrEdit() && $this->ts_created->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ts_created->AdvancedSearch->SearchValue != "" || $this->ts_created->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ts_last_update
        if (!$this->isAddOrEdit() && $this->ts_last_update->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ts_last_update->AdvancedSearch->SearchValue != "" || $this->ts_last_update->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // total
        if (!$this->isAddOrEdit() && $this->total->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->total->AdvancedSearch->SearchValue != "" || $this->total->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->id->setFormValue($val);
        }

        // Check field name 'campaign_id' first before field var 'x_campaign_id'
        $val = $CurrentForm->hasValue("campaign_id") ? $CurrentForm->getValue("campaign_id") : $CurrentForm->getValue("x_campaign_id");
        if (!$this->campaign_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->campaign_id->Visible = false; // Disable update for API request
            } else {
                $this->campaign_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_campaign_id")) {
            $this->campaign_id->setOldValue($CurrentForm->getValue("o_campaign_id"));
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
        if ($CurrentForm->hasValue("o_operator_id")) {
            $this->operator_id->setOldValue($CurrentForm->getValue("o_operator_id"));
        }

        // Check field name 'payment_date' first before field var 'x_payment_date'
        $val = $CurrentForm->hasValue("payment_date") ? $CurrentForm->getValue("payment_date") : $CurrentForm->getValue("x_payment_date");
        if (!$this->payment_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->payment_date->Visible = false; // Disable update for API request
            } else {
                $this->payment_date->setFormValue($val);
            }
            $this->payment_date->CurrentValue = UnFormatDateTime($this->payment_date->CurrentValue, 5);
        }
        if ($CurrentForm->hasValue("o_payment_date")) {
            $this->payment_date->setOldValue($CurrentForm->getValue("o_payment_date"));
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
        if ($CurrentForm->hasValue("o_vendor_id")) {
            $this->vendor_id->setOldValue($CurrentForm->getValue("o_vendor_id"));
        }

        // Check field name 'price_id' first before field var 'x_price_id'
        $val = $CurrentForm->hasValue("price_id") ? $CurrentForm->getValue("price_id") : $CurrentForm->getValue("x_price_id");
        if (!$this->price_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_id->Visible = false; // Disable update for API request
            } else {
                $this->price_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_price_id")) {
            $this->price_id->setOldValue($CurrentForm->getValue("o_price_id"));
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
        if ($CurrentForm->hasValue("o_quantity")) {
            $this->quantity->setOldValue($CurrentForm->getValue("o_quantity"));
        }

        // Check field name 'assigned_buses' first before field var 'x_assigned_buses'
        $val = $CurrentForm->hasValue("assigned_buses") ? $CurrentForm->getValue("assigned_buses") : $CurrentForm->getValue("x_assigned_buses");
        if (!$this->assigned_buses->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->assigned_buses->Visible = false; // Disable update for API request
            } else {
                $this->assigned_buses->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_assigned_buses")) {
            $this->assigned_buses->setOldValue($CurrentForm->getValue("o_assigned_buses"));
        }

        // Check field name 'start_date' first before field var 'x_start_date'
        $val = $CurrentForm->hasValue("start_date") ? $CurrentForm->getValue("start_date") : $CurrentForm->getValue("x_start_date");
        if (!$this->start_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->start_date->Visible = false; // Disable update for API request
            } else {
                $this->start_date->setFormValue($val);
            }
            $this->start_date->CurrentValue = UnFormatDateTime($this->start_date->CurrentValue, 5);
        }
        if ($CurrentForm->hasValue("o_start_date")) {
            $this->start_date->setOldValue($CurrentForm->getValue("o_start_date"));
        }

        // Check field name 'end_date' first before field var 'x_end_date'
        $val = $CurrentForm->hasValue("end_date") ? $CurrentForm->getValue("end_date") : $CurrentForm->getValue("x_end_date");
        if (!$this->end_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->end_date->Visible = false; // Disable update for API request
            } else {
                $this->end_date->setFormValue($val);
            }
            $this->end_date->CurrentValue = UnFormatDateTime($this->end_date->CurrentValue, 5);
        }
        if ($CurrentForm->hasValue("o_end_date")) {
            $this->end_date->setOldValue($CurrentForm->getValue("o_end_date"));
        }

        // Check field name 'visible_status_id' first before field var 'x_visible_status_id'
        $val = $CurrentForm->hasValue("visible_status_id") ? $CurrentForm->getValue("visible_status_id") : $CurrentForm->getValue("x_visible_status_id");
        if (!$this->visible_status_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->visible_status_id->Visible = false; // Disable update for API request
            } else {
                $this->visible_status_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_visible_status_id")) {
            $this->visible_status_id->setOldValue($CurrentForm->getValue("o_visible_status_id"));
        }

        // Check field name 'status_id' first before field var 'x_status_id'
        $val = $CurrentForm->hasValue("status_id") ? $CurrentForm->getValue("status_id") : $CurrentForm->getValue("x_status_id");
        if (!$this->status_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_id->Visible = false; // Disable update for API request
            } else {
                $this->status_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_status_id")) {
            $this->status_id->setOldValue($CurrentForm->getValue("o_status_id"));
        }

        // Check field name 'print_status_id' first before field var 'x_print_status_id'
        $val = $CurrentForm->hasValue("print_status_id") ? $CurrentForm->getValue("print_status_id") : $CurrentForm->getValue("x_print_status_id");
        if (!$this->print_status_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->print_status_id->Visible = false; // Disable update for API request
            } else {
                $this->print_status_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_print_status_id")) {
            $this->print_status_id->setOldValue($CurrentForm->getValue("o_print_status_id"));
        }

        // Check field name 'payment_status_id' first before field var 'x_payment_status_id'
        $val = $CurrentForm->hasValue("payment_status_id") ? $CurrentForm->getValue("payment_status_id") : $CurrentForm->getValue("x_payment_status_id");
        if (!$this->payment_status_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->payment_status_id->Visible = false; // Disable update for API request
            } else {
                $this->payment_status_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_payment_status_id")) {
            $this->payment_status_id->setOldValue($CurrentForm->getValue("o_payment_status_id"));
        }

        // Check field name 'total' first before field var 'x_total'
        $val = $CurrentForm->hasValue("total") ? $CurrentForm->getValue("total") : $CurrentForm->getValue("x_total");
        if (!$this->total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->total->Visible = false; // Disable update for API request
            } else {
                $this->total->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_total")) {
            $this->total->setOldValue($CurrentForm->getValue("o_total"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
        $this->campaign_id->CurrentValue = $this->campaign_id->FormValue;
        $this->operator_id->CurrentValue = $this->operator_id->FormValue;
        $this->payment_date->CurrentValue = $this->payment_date->FormValue;
        $this->payment_date->CurrentValue = UnFormatDateTime($this->payment_date->CurrentValue, 5);
        $this->vendor_id->CurrentValue = $this->vendor_id->FormValue;
        $this->price_id->CurrentValue = $this->price_id->FormValue;
        $this->quantity->CurrentValue = $this->quantity->FormValue;
        $this->assigned_buses->CurrentValue = $this->assigned_buses->FormValue;
        $this->start_date->CurrentValue = $this->start_date->FormValue;
        $this->start_date->CurrentValue = UnFormatDateTime($this->start_date->CurrentValue, 5);
        $this->end_date->CurrentValue = $this->end_date->FormValue;
        $this->end_date->CurrentValue = UnFormatDateTime($this->end_date->CurrentValue, 5);
        $this->visible_status_id->CurrentValue = $this->visible_status_id->FormValue;
        $this->status_id->CurrentValue = $this->status_id->FormValue;
        $this->print_status_id->CurrentValue = $this->print_status_id->FormValue;
        $this->payment_status_id->CurrentValue = $this->payment_status_id->FormValue;
        $this->total->CurrentValue = $this->total->FormValue;
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
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
        $this->campaign_id->setDbValue($row['campaign_id']);
        if (array_key_exists('EV__campaign_id', $row)) {
            $this->campaign_id->VirtualValue = $row['EV__campaign_id']; // Set up virtual field value
        } else {
            $this->campaign_id->VirtualValue = ""; // Clear value
        }
        $this->operator_id->setDbValue($row['operator_id']);
        $this->payment_date->setDbValue($row['payment_date']);
        $this->vendor_id->setDbValue($row['vendor_id']);
        $this->price_id->setDbValue($row['price_id']);
        if (array_key_exists('EV__price_id', $row)) {
            $this->price_id->VirtualValue = $row['EV__price_id']; // Set up virtual field value
        } else {
            $this->price_id->VirtualValue = ""; // Clear value
        }
        $this->quantity->setDbValue($row['quantity']);
        $this->assigned_buses->setDbValue($row['assigned_buses']);
        $this->start_date->setDbValue($row['start_date']);
        $this->end_date->setDbValue($row['end_date']);
        $this->visible_status_id->setDbValue($row['visible_status_id']);
        $this->status_id->setDbValue($row['status_id']);
        if (array_key_exists('EV__status_id', $row)) {
            $this->status_id->VirtualValue = $row['EV__status_id']; // Set up virtual field value
        } else {
            $this->status_id->VirtualValue = ""; // Clear value
        }
        $this->print_status_id->setDbValue($row['print_status_id']);
        if (array_key_exists('EV__print_status_id', $row)) {
            $this->print_status_id->VirtualValue = $row['EV__print_status_id']; // Set up virtual field value
        } else {
            $this->print_status_id->VirtualValue = ""; // Clear value
        }
        $this->payment_status_id->setDbValue($row['payment_status_id']);
        if (array_key_exists('EV__payment_status_id', $row)) {
            $this->payment_status_id->VirtualValue = $row['EV__payment_status_id']; // Set up virtual field value
        } else {
            $this->payment_status_id->VirtualValue = ""; // Clear value
        }
        $this->created_by->setDbValue($row['created_by']);
        $this->ts_created->setDbValue($row['ts_created']);
        $this->ts_last_update->setDbValue($row['ts_last_update']);
        $this->total->setDbValue($row['total']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['campaign_id'] = $this->campaign_id->CurrentValue;
        $row['operator_id'] = $this->operator_id->CurrentValue;
        $row['payment_date'] = $this->payment_date->CurrentValue;
        $row['vendor_id'] = $this->vendor_id->CurrentValue;
        $row['price_id'] = $this->price_id->CurrentValue;
        $row['quantity'] = $this->quantity->CurrentValue;
        $row['assigned_buses'] = $this->assigned_buses->CurrentValue;
        $row['start_date'] = $this->start_date->CurrentValue;
        $row['end_date'] = $this->end_date->CurrentValue;
        $row['visible_status_id'] = $this->visible_status_id->CurrentValue;
        $row['status_id'] = $this->status_id->CurrentValue;
        $row['print_status_id'] = $this->print_status_id->CurrentValue;
        $row['payment_status_id'] = $this->payment_status_id->CurrentValue;
        $row['created_by'] = $this->created_by->CurrentValue;
        $row['ts_created'] = $this->ts_created->CurrentValue;
        $row['ts_last_update'] = $this->ts_last_update->CurrentValue;
        $row['total'] = $this->total->CurrentValue;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // campaign_id
        $this->campaign_id->CellCssStyle = "white-space: nowrap;";

        // operator_id

        // payment_date

        // vendor_id
        $this->vendor_id->CellCssStyle = "white-space: nowrap;";

        // price_id
        $this->price_id->CellCssStyle = "white-space: nowrap;";

        // quantity

        // assigned_buses

        // start_date

        // end_date

        // visible_status_id

        // status_id

        // print_status_id

        // payment_status_id

        // created_by

        // ts_created

        // ts_last_update

        // total
        $this->total->CellCssStyle = "white-space: nowrap;";

        // Accumulate aggregate value
        if ($this->RowType != ROWTYPE_AGGREGATEINIT && $this->RowType != ROWTYPE_AGGREGATE) {
            if (is_numeric($this->quantity->CurrentValue)) {
                $this->quantity->Total += $this->quantity->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->total->CurrentValue)) {
                $this->total->Total += $this->total->CurrentValue; // Accumulate total
            }
        }
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
            $this->id->ViewCustomAttributes = "";

            // campaign_id
            if ($this->campaign_id->VirtualValue != "") {
                $this->campaign_id->ViewValue = $this->campaign_id->VirtualValue;
            } else {
                $curVal = strval($this->campaign_id->CurrentValue);
                if ($curVal != "") {
                    $this->campaign_id->ViewValue = $this->campaign_id->lookupCacheOption($curVal);
                    if ($this->campaign_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->campaign_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
            }
            $this->campaign_id->ViewCustomAttributes = "";

            // operator_id
            $curVal = strval($this->operator_id->CurrentValue);
            if ($curVal != "") {
                $this->operator_id->ViewValue = $this->operator_id->lookupCacheOption($curVal);
                if ($this->operator_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"operator_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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

            // payment_date
            $this->payment_date->ViewValue = $this->payment_date->CurrentValue;
            $this->payment_date->ViewValue = FormatDateTime($this->payment_date->ViewValue, 5);
            $this->payment_date->ViewCustomAttributes = "";

            // vendor_id
            $this->vendor_id->ViewValue = $this->vendor_id->CurrentValue;
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

            // price_id
            if ($this->price_id->VirtualValue != "") {
                $this->price_id->ViewValue = $this->price_id->VirtualValue;
            } else {
                $curVal = strval($this->price_id->CurrentValue);
                if ($curVal != "") {
                    $this->price_id->ViewValue = $this->price_id->lookupCacheOption($curVal);
                    if ($this->price_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"price_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->price_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->price_id->Lookup->renderViewRow($rswrk[0]);
                            $this->price_id->ViewValue = $this->price_id->displayValue($arwrk);
                        } else {
                            $this->price_id->ViewValue = $this->price_id->CurrentValue;
                        }
                    }
                } else {
                    $this->price_id->ViewValue = null;
                }
            }
            $this->price_id->ViewCustomAttributes = "";

            // quantity
            $this->quantity->ViewValue = $this->quantity->CurrentValue;
            $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
            $this->quantity->CssClass = "font-weight-bold";
            $this->quantity->CellCssStyle .= "text-align: right;";
            $this->quantity->ViewCustomAttributes = "";

            // assigned_buses
            $this->assigned_buses->ViewValue = $this->assigned_buses->CurrentValue;
            $this->assigned_buses->ViewValue = FormatNumber($this->assigned_buses->ViewValue, 0, -2, -2, -2);
            $this->assigned_buses->ViewCustomAttributes = "";

            // start_date
            $this->start_date->ViewValue = $this->start_date->CurrentValue;
            $this->start_date->ViewValue = FormatDateTime($this->start_date->ViewValue, 5);
            $this->start_date->ViewCustomAttributes = "";

            // end_date
            $this->end_date->ViewValue = $this->end_date->CurrentValue;
            $this->end_date->ViewValue = FormatDateTime($this->end_date->ViewValue, 5);
            $this->end_date->ViewCustomAttributes = "";

            // visible_status_id
            $curVal = strval($this->visible_status_id->CurrentValue);
            if ($curVal != "") {
                $this->visible_status_id->ViewValue = $this->visible_status_id->lookupCacheOption($curVal);
                if ($this->visible_status_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->visible_status_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->visible_status_id->Lookup->renderViewRow($rswrk[0]);
                        $this->visible_status_id->ViewValue = $this->visible_status_id->displayValue($arwrk);
                    } else {
                        $this->visible_status_id->ViewValue = $this->visible_status_id->CurrentValue;
                    }
                }
            } else {
                $this->visible_status_id->ViewValue = null;
            }
            $this->visible_status_id->ViewCustomAttributes = "";

            // status_id
            if ($this->status_id->VirtualValue != "") {
                $this->status_id->ViewValue = $this->status_id->VirtualValue;
            } else {
                $curVal = strval($this->status_id->CurrentValue);
                if ($curVal != "") {
                    $this->status_id->ViewValue = $this->status_id->lookupCacheOption($curVal);
                    if ($this->status_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->status_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->status_id->Lookup->renderViewRow($rswrk[0]);
                            $this->status_id->ViewValue = $this->status_id->displayValue($arwrk);
                        } else {
                            $this->status_id->ViewValue = $this->status_id->CurrentValue;
                        }
                    }
                } else {
                    $this->status_id->ViewValue = null;
                }
            }
            $this->status_id->CellCssStyle .= "text-align: center;";
            $this->status_id->ViewCustomAttributes = "";

            // print_status_id
            if ($this->print_status_id->VirtualValue != "") {
                $this->print_status_id->ViewValue = $this->print_status_id->VirtualValue;
            } else {
                $curVal = strval($this->print_status_id->CurrentValue);
                if ($curVal != "") {
                    $this->print_status_id->ViewValue = $this->print_status_id->lookupCacheOption($curVal);
                    if ($this->print_status_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->print_status_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->print_status_id->Lookup->renderViewRow($rswrk[0]);
                            $this->print_status_id->ViewValue = $this->print_status_id->displayValue($arwrk);
                        } else {
                            $this->print_status_id->ViewValue = $this->print_status_id->CurrentValue;
                        }
                    }
                } else {
                    $this->print_status_id->ViewValue = null;
                }
            }
            $this->print_status_id->CellCssStyle .= "text-align: center;";
            $this->print_status_id->ViewCustomAttributes = "";

            // payment_status_id
            if ($this->payment_status_id->VirtualValue != "") {
                $this->payment_status_id->ViewValue = $this->payment_status_id->VirtualValue;
            } else {
                $curVal = strval($this->payment_status_id->CurrentValue);
                if ($curVal != "") {
                    $this->payment_status_id->ViewValue = $this->payment_status_id->lookupCacheOption($curVal);
                    if ($this->payment_status_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->payment_status_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->payment_status_id->Lookup->renderViewRow($rswrk[0]);
                            $this->payment_status_id->ViewValue = $this->payment_status_id->displayValue($arwrk);
                        } else {
                            $this->payment_status_id->ViewValue = $this->payment_status_id->CurrentValue;
                        }
                    }
                } else {
                    $this->payment_status_id->ViewValue = null;
                }
            }
            $this->payment_status_id->CellCssStyle .= "text-align: center;";
            $this->payment_status_id->ViewCustomAttributes = "";

            // created_by
            $curVal = strval($this->created_by->CurrentValue);
            if ($curVal != "") {
                $this->created_by->ViewValue = $this->created_by->lookupCacheOption($curVal);
                if ($this->created_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->created_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->created_by->Lookup->renderViewRow($rswrk[0]);
                        $this->created_by->ViewValue = $this->created_by->displayValue($arwrk);
                    } else {
                        $this->created_by->ViewValue = $this->created_by->CurrentValue;
                    }
                }
            } else {
                $this->created_by->ViewValue = null;
            }
            $this->created_by->ViewCustomAttributes = "";

            // ts_created
            $this->ts_created->ViewValue = $this->ts_created->CurrentValue;
            $this->ts_created->ViewValue = FormatDateTime($this->ts_created->ViewValue, 0);
            $this->ts_created->ViewCustomAttributes = "";

            // ts_last_update
            $this->ts_last_update->ViewValue = $this->ts_last_update->CurrentValue;
            $this->ts_last_update->ViewValue = FormatDateTime($this->ts_last_update->ViewValue, 0);
            $this->ts_last_update->ViewCustomAttributes = "";

            // total
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatNumber($this->total->ViewValue, 0, -2, -2, -2);
            $this->total->CssClass = "font-weight-bold";
            $this->total->CellCssStyle .= "text-align: right;";
            $this->total->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // campaign_id
            $this->campaign_id->LinkCustomAttributes = "";
            $this->campaign_id->HrefValue = "";
            $this->campaign_id->TooltipValue = "";

            // operator_id
            $this->operator_id->LinkCustomAttributes = "";
            $this->operator_id->HrefValue = "";
            $this->operator_id->TooltipValue = "";

            // payment_date
            $this->payment_date->LinkCustomAttributes = "";
            $this->payment_date->HrefValue = "";
            $this->payment_date->TooltipValue = "";

            // vendor_id
            $this->vendor_id->LinkCustomAttributes = "";
            $this->vendor_id->HrefValue = "";
            $this->vendor_id->TooltipValue = "";

            // price_id
            $this->price_id->LinkCustomAttributes = "";
            $this->price_id->HrefValue = "";
            $this->price_id->TooltipValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";
            $this->quantity->TooltipValue = "";

            // assigned_buses
            $this->assigned_buses->LinkCustomAttributes = "";
            $this->assigned_buses->HrefValue = "";
            $this->assigned_buses->TooltipValue = "";

            // start_date
            $this->start_date->LinkCustomAttributes = "";
            $this->start_date->HrefValue = "";
            $this->start_date->TooltipValue = "";

            // end_date
            $this->end_date->LinkCustomAttributes = "";
            $this->end_date->HrefValue = "";
            $this->end_date->TooltipValue = "";

            // visible_status_id
            $this->visible_status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->visible_status_id->CurrentValue)) {
                $this->visible_status_id->HrefValue = "#" . (!empty($this->visible_status_id->ViewValue) && !is_array($this->visible_status_id->ViewValue) ? RemoveHtml($this->visible_status_id->ViewValue) : $this->visible_status_id->CurrentValue); // Add prefix/suffix
                $this->visible_status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->visible_status_id->HrefValue = FullUrl($this->visible_status_id->HrefValue, "href");
                }
            } else {
                $this->visible_status_id->HrefValue = "";
            }
            $this->visible_status_id->TooltipValue = "";

            // status_id
            $this->status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->status_id->CurrentValue)) {
                $this->status_id->HrefValue = "#" . (!empty($this->status_id->ViewValue) && !is_array($this->status_id->ViewValue) ? RemoveHtml($this->status_id->ViewValue) : $this->status_id->CurrentValue); // Add prefix/suffix
                $this->status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->status_id->HrefValue = FullUrl($this->status_id->HrefValue, "href");
                }
            } else {
                $this->status_id->HrefValue = "";
            }
            $this->status_id->TooltipValue = "";

            // print_status_id
            $this->print_status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->print_status_id->CurrentValue)) {
                $this->print_status_id->HrefValue = "#" . (!empty($this->print_status_id->ViewValue) && !is_array($this->print_status_id->ViewValue) ? RemoveHtml($this->print_status_id->ViewValue) : $this->print_status_id->CurrentValue); // Add prefix/suffix
                $this->print_status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->print_status_id->HrefValue = FullUrl($this->print_status_id->HrefValue, "href");
                }
            } else {
                $this->print_status_id->HrefValue = "";
            }
            $this->print_status_id->TooltipValue = "";

            // payment_status_id
            $this->payment_status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->payment_status_id->CurrentValue)) {
                $this->payment_status_id->HrefValue = "#" . (!empty($this->payment_status_id->ViewValue) && !is_array($this->payment_status_id->ViewValue) ? RemoveHtml($this->payment_status_id->ViewValue) : $this->payment_status_id->CurrentValue); // Add prefix/suffix
                $this->payment_status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->payment_status_id->HrefValue = FullUrl($this->payment_status_id->HrefValue, "href");
                }
            } else {
                $this->payment_status_id->HrefValue = "";
            }
            $this->payment_status_id->TooltipValue = "";

            // total
            $this->total->LinkCustomAttributes = "";
            $this->total->HrefValue = "";
            $this->total->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id

            // campaign_id
            $this->campaign_id->EditAttrs["class"] = "form-control";
            $this->campaign_id->EditCustomAttributes = "";
            if ($this->campaign_id->getSessionValue() != "") {
                $this->campaign_id->CurrentValue = GetForeignKeyValue($this->campaign_id->getSessionValue());
                $this->campaign_id->OldValue = $this->campaign_id->CurrentValue;
                if ($this->campaign_id->VirtualValue != "") {
                    $this->campaign_id->ViewValue = $this->campaign_id->VirtualValue;
                } else {
                    $curVal = strval($this->campaign_id->CurrentValue);
                    if ($curVal != "") {
                        $this->campaign_id->ViewValue = $this->campaign_id->lookupCacheOption($curVal);
                        if ($this->campaign_id->ViewValue === null) { // Lookup from database
                            $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                            $sqlWrk = $this->campaign_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
                }
                $this->campaign_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->campaign_id->CurrentValue));
                if ($curVal != "") {
                    $this->campaign_id->ViewValue = $this->campaign_id->lookupCacheOption($curVal);
                } else {
                    $this->campaign_id->ViewValue = $this->campaign_id->Lookup !== null && is_array($this->campaign_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->campaign_id->ViewValue !== null) { // Load from cache
                    $this->campaign_id->EditValue = array_values($this->campaign_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "\"id\"" . SearchString("=", $this->campaign_id->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->campaign_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    foreach ($arwrk as &$row)
                        $row = $this->campaign_id->Lookup->renderViewRow($row);
                    $this->campaign_id->EditValue = $arwrk;
                }
                $this->campaign_id->PlaceHolder = RemoveHtml($this->campaign_id->caption());
            }

            // operator_id
            $this->operator_id->EditAttrs["class"] = "form-control";
            $this->operator_id->EditCustomAttributes = "";
            if ($this->operator_id->getSessionValue() != "") {
                $this->operator_id->CurrentValue = GetForeignKeyValue($this->operator_id->getSessionValue());
                $this->operator_id->OldValue = $this->operator_id->CurrentValue;
                $curVal = strval($this->operator_id->CurrentValue);
                if ($curVal != "") {
                    $this->operator_id->ViewValue = $this->operator_id->lookupCacheOption($curVal);
                    if ($this->operator_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"operator_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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
            } else {
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
                        $filterWrk = "\"operator_id\"" . SearchString("=", $this->operator_id->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->operator_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->operator_id->EditValue = $arwrk;
                }
                $this->operator_id->PlaceHolder = RemoveHtml($this->operator_id->caption());
            }

            // payment_date
            $this->payment_date->EditAttrs["class"] = "form-control";
            $this->payment_date->EditCustomAttributes = "";
            $this->payment_date->EditValue = HtmlEncode(FormatDateTime($this->payment_date->CurrentValue, 5));
            $this->payment_date->PlaceHolder = RemoveHtml($this->payment_date->caption());

            // vendor_id
            $this->vendor_id->EditAttrs["class"] = "form-control";
            $this->vendor_id->EditCustomAttributes = "";
            if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow($this->CurrentAction)) { // Non system admin
                if (trim(strval($this->vendor_id->CurrentValue)) == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->vendor_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->vendor_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $arwrk = $rswrk;
                $this->vendor_id->EditValue = $arwrk;
            } else {
                $this->vendor_id->EditValue = HtmlEncode($this->vendor_id->CurrentValue);
                $curVal = strval($this->vendor_id->CurrentValue);
                if ($curVal != "") {
                    $this->vendor_id->EditValue = $this->vendor_id->lookupCacheOption($curVal);
                    if ($this->vendor_id->EditValue === null) { // Lookup from database
                        $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->vendor_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->vendor_id->Lookup->renderViewRow($rswrk[0]);
                            $this->vendor_id->EditValue = $this->vendor_id->displayValue($arwrk);
                        } else {
                            $this->vendor_id->EditValue = HtmlEncode($this->vendor_id->CurrentValue);
                        }
                    }
                } else {
                    $this->vendor_id->EditValue = null;
                }
                $this->vendor_id->PlaceHolder = RemoveHtml($this->vendor_id->caption());
            }

            // price_id
            $this->price_id->EditAttrs["class"] = "form-control";
            $this->price_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->price_id->CurrentValue));
            if ($curVal != "") {
                $this->price_id->ViewValue = $this->price_id->lookupCacheOption($curVal);
            } else {
                $this->price_id->ViewValue = $this->price_id->Lookup !== null && is_array($this->price_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->price_id->ViewValue !== null) { // Load from cache
                $this->price_id->EditValue = array_values($this->price_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"price_id\"" . SearchString("=", $this->price_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->price_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->price_id->EditValue = $arwrk;
            }
            $this->price_id->PlaceHolder = RemoveHtml($this->price_id->caption());

            // quantity
            $this->quantity->EditAttrs["class"] = "form-control";
            $this->quantity->EditCustomAttributes = "";
            $this->quantity->EditValue = HtmlEncode($this->quantity->CurrentValue);
            $this->quantity->PlaceHolder = RemoveHtml($this->quantity->caption());

            // assigned_buses
            $this->assigned_buses->EditAttrs["class"] = "form-control";
            $this->assigned_buses->EditCustomAttributes = "";
            $this->assigned_buses->EditValue = HtmlEncode($this->assigned_buses->CurrentValue);
            $this->assigned_buses->PlaceHolder = RemoveHtml($this->assigned_buses->caption());

            // start_date
            $this->start_date->EditAttrs["class"] = "form-control";
            $this->start_date->EditCustomAttributes = 'readonly="readonly"';
            $this->start_date->EditValue = HtmlEncode(FormatDateTime($this->start_date->CurrentValue, 5));
            $this->start_date->PlaceHolder = RemoveHtml($this->start_date->caption());

            // end_date
            $this->end_date->EditAttrs["class"] = "form-control";
            $this->end_date->EditCustomAttributes = 'readonly="readonly"';
            $this->end_date->EditValue = HtmlEncode(FormatDateTime($this->end_date->CurrentValue, 5));
            $this->end_date->PlaceHolder = RemoveHtml($this->end_date->caption());

            // visible_status_id
            $this->visible_status_id->EditAttrs["class"] = "form-control";
            $this->visible_status_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->visible_status_id->CurrentValue));
            if ($curVal != "") {
                $this->visible_status_id->ViewValue = $this->visible_status_id->lookupCacheOption($curVal);
            } else {
                $this->visible_status_id->ViewValue = $this->visible_status_id->Lookup !== null && is_array($this->visible_status_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->visible_status_id->ViewValue !== null) { // Load from cache
                $this->visible_status_id->EditValue = array_values($this->visible_status_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->visible_status_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->visible_status_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->visible_status_id->EditValue = $arwrk;
            }
            $this->visible_status_id->PlaceHolder = RemoveHtml($this->visible_status_id->caption());

            // status_id
            $this->status_id->EditAttrs["class"] = "form-control";
            $this->status_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->status_id->CurrentValue));
            if ($curVal != "") {
                $this->status_id->ViewValue = $this->status_id->lookupCacheOption($curVal);
            } else {
                $this->status_id->ViewValue = $this->status_id->Lookup !== null && is_array($this->status_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->status_id->ViewValue !== null) { // Load from cache
                $this->status_id->EditValue = array_values($this->status_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->status_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->status_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->status_id->EditValue = $arwrk;
            }
            $this->status_id->PlaceHolder = RemoveHtml($this->status_id->caption());

            // print_status_id
            $this->print_status_id->EditAttrs["class"] = "form-control";
            $this->print_status_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->print_status_id->CurrentValue));
            if ($curVal != "") {
                $this->print_status_id->ViewValue = $this->print_status_id->lookupCacheOption($curVal);
            } else {
                $this->print_status_id->ViewValue = $this->print_status_id->Lookup !== null && is_array($this->print_status_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->print_status_id->ViewValue !== null) { // Load from cache
                $this->print_status_id->EditValue = array_values($this->print_status_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->print_status_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->print_status_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->print_status_id->EditValue = $arwrk;
            }
            $this->print_status_id->PlaceHolder = RemoveHtml($this->print_status_id->caption());

            // payment_status_id
            $this->payment_status_id->EditAttrs["class"] = "form-control";
            $this->payment_status_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->payment_status_id->CurrentValue));
            if ($curVal != "") {
                $this->payment_status_id->ViewValue = $this->payment_status_id->lookupCacheOption($curVal);
            } else {
                $this->payment_status_id->ViewValue = $this->payment_status_id->Lookup !== null && is_array($this->payment_status_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->payment_status_id->ViewValue !== null) { // Load from cache
                $this->payment_status_id->EditValue = array_values($this->payment_status_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->payment_status_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->payment_status_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->payment_status_id->EditValue = $arwrk;
            }
            $this->payment_status_id->PlaceHolder = RemoveHtml($this->payment_status_id->caption());

            // total
            $this->total->EditAttrs["class"] = "form-control";
            $this->total->EditCustomAttributes = "";
            $this->total->EditValue = HtmlEncode($this->total->CurrentValue);
            $this->total->PlaceHolder = RemoveHtml($this->total->caption());

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // campaign_id
            $this->campaign_id->LinkCustomAttributes = "";
            $this->campaign_id->HrefValue = "";

            // operator_id
            $this->operator_id->LinkCustomAttributes = "";
            $this->operator_id->HrefValue = "";

            // payment_date
            $this->payment_date->LinkCustomAttributes = "";
            $this->payment_date->HrefValue = "";

            // vendor_id
            $this->vendor_id->LinkCustomAttributes = "";
            $this->vendor_id->HrefValue = "";

            // price_id
            $this->price_id->LinkCustomAttributes = "";
            $this->price_id->HrefValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";

            // assigned_buses
            $this->assigned_buses->LinkCustomAttributes = "";
            $this->assigned_buses->HrefValue = "";

            // start_date
            $this->start_date->LinkCustomAttributes = "";
            $this->start_date->HrefValue = "";

            // end_date
            $this->end_date->LinkCustomAttributes = "";
            $this->end_date->HrefValue = "";

            // visible_status_id
            $this->visible_status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->visible_status_id->CurrentValue)) {
                $this->visible_status_id->HrefValue = "#" . (!empty($this->visible_status_id->EditValue) && !is_array($this->visible_status_id->EditValue) ? RemoveHtml($this->visible_status_id->EditValue) : $this->visible_status_id->CurrentValue); // Add prefix/suffix
                $this->visible_status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->visible_status_id->HrefValue = FullUrl($this->visible_status_id->HrefValue, "href");
                }
            } else {
                $this->visible_status_id->HrefValue = "";
            }

            // status_id
            $this->status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->status_id->CurrentValue)) {
                $this->status_id->HrefValue = "#" . (!empty($this->status_id->EditValue) && !is_array($this->status_id->EditValue) ? RemoveHtml($this->status_id->EditValue) : $this->status_id->CurrentValue); // Add prefix/suffix
                $this->status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->status_id->HrefValue = FullUrl($this->status_id->HrefValue, "href");
                }
            } else {
                $this->status_id->HrefValue = "";
            }

            // print_status_id
            $this->print_status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->print_status_id->CurrentValue)) {
                $this->print_status_id->HrefValue = "#" . (!empty($this->print_status_id->EditValue) && !is_array($this->print_status_id->EditValue) ? RemoveHtml($this->print_status_id->EditValue) : $this->print_status_id->CurrentValue); // Add prefix/suffix
                $this->print_status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->print_status_id->HrefValue = FullUrl($this->print_status_id->HrefValue, "href");
                }
            } else {
                $this->print_status_id->HrefValue = "";
            }

            // payment_status_id
            $this->payment_status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->payment_status_id->CurrentValue)) {
                $this->payment_status_id->HrefValue = "#" . (!empty($this->payment_status_id->EditValue) && !is_array($this->payment_status_id->EditValue) ? RemoveHtml($this->payment_status_id->EditValue) : $this->payment_status_id->CurrentValue); // Add prefix/suffix
                $this->payment_status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->payment_status_id->HrefValue = FullUrl($this->payment_status_id->HrefValue, "href");
                }
            } else {
                $this->payment_status_id->HrefValue = "";
            }

            // total
            $this->total->LinkCustomAttributes = "";
            $this->total->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->EditValue = FormatNumber($this->id->EditValue, 0, -2, -2, -2);
            $this->id->ViewCustomAttributes = "";

            // campaign_id
            $this->campaign_id->EditAttrs["class"] = "form-control";
            $this->campaign_id->EditCustomAttributes = "";
            if ($this->campaign_id->getSessionValue() != "") {
                $this->campaign_id->CurrentValue = GetForeignKeyValue($this->campaign_id->getSessionValue());
                $this->campaign_id->OldValue = $this->campaign_id->CurrentValue;
                if ($this->campaign_id->VirtualValue != "") {
                    $this->campaign_id->ViewValue = $this->campaign_id->VirtualValue;
                } else {
                    $curVal = strval($this->campaign_id->CurrentValue);
                    if ($curVal != "") {
                        $this->campaign_id->ViewValue = $this->campaign_id->lookupCacheOption($curVal);
                        if ($this->campaign_id->ViewValue === null) { // Lookup from database
                            $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                            $sqlWrk = $this->campaign_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
                }
                $this->campaign_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->campaign_id->CurrentValue));
                if ($curVal != "") {
                    $this->campaign_id->ViewValue = $this->campaign_id->lookupCacheOption($curVal);
                } else {
                    $this->campaign_id->ViewValue = $this->campaign_id->Lookup !== null && is_array($this->campaign_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->campaign_id->ViewValue !== null) { // Load from cache
                    $this->campaign_id->EditValue = array_values($this->campaign_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "\"id\"" . SearchString("=", $this->campaign_id->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->campaign_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    foreach ($arwrk as &$row)
                        $row = $this->campaign_id->Lookup->renderViewRow($row);
                    $this->campaign_id->EditValue = $arwrk;
                }
                $this->campaign_id->PlaceHolder = RemoveHtml($this->campaign_id->caption());
            }

            // operator_id
            $this->operator_id->EditAttrs["class"] = "form-control";
            $this->operator_id->EditCustomAttributes = "";
            if ($this->operator_id->getSessionValue() != "") {
                $this->operator_id->CurrentValue = GetForeignKeyValue($this->operator_id->getSessionValue());
                $this->operator_id->OldValue = $this->operator_id->CurrentValue;
                $curVal = strval($this->operator_id->CurrentValue);
                if ($curVal != "") {
                    $this->operator_id->ViewValue = $this->operator_id->lookupCacheOption($curVal);
                    if ($this->operator_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"operator_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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
            } else {
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
                        $filterWrk = "\"operator_id\"" . SearchString("=", $this->operator_id->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->operator_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->operator_id->EditValue = $arwrk;
                }
                $this->operator_id->PlaceHolder = RemoveHtml($this->operator_id->caption());
            }

            // payment_date
            $this->payment_date->EditAttrs["class"] = "form-control";
            $this->payment_date->EditCustomAttributes = "";
            $this->payment_date->EditValue = HtmlEncode(FormatDateTime($this->payment_date->CurrentValue, 5));
            $this->payment_date->PlaceHolder = RemoveHtml($this->payment_date->caption());

            // vendor_id
            $this->vendor_id->EditAttrs["class"] = "form-control";
            $this->vendor_id->EditCustomAttributes = "";
            if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow($this->CurrentAction)) { // Non system admin
                if (trim(strval($this->vendor_id->CurrentValue)) == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->vendor_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->vendor_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $arwrk = $rswrk;
                $this->vendor_id->EditValue = $arwrk;
            } else {
                $this->vendor_id->EditValue = HtmlEncode($this->vendor_id->CurrentValue);
                $curVal = strval($this->vendor_id->CurrentValue);
                if ($curVal != "") {
                    $this->vendor_id->EditValue = $this->vendor_id->lookupCacheOption($curVal);
                    if ($this->vendor_id->EditValue === null) { // Lookup from database
                        $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->vendor_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->vendor_id->Lookup->renderViewRow($rswrk[0]);
                            $this->vendor_id->EditValue = $this->vendor_id->displayValue($arwrk);
                        } else {
                            $this->vendor_id->EditValue = HtmlEncode($this->vendor_id->CurrentValue);
                        }
                    }
                } else {
                    $this->vendor_id->EditValue = null;
                }
                $this->vendor_id->PlaceHolder = RemoveHtml($this->vendor_id->caption());
            }

            // price_id
            $this->price_id->EditAttrs["class"] = "form-control";
            $this->price_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->price_id->CurrentValue));
            if ($curVal != "") {
                $this->price_id->ViewValue = $this->price_id->lookupCacheOption($curVal);
            } else {
                $this->price_id->ViewValue = $this->price_id->Lookup !== null && is_array($this->price_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->price_id->ViewValue !== null) { // Load from cache
                $this->price_id->EditValue = array_values($this->price_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"price_id\"" . SearchString("=", $this->price_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->price_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->price_id->EditValue = $arwrk;
            }
            $this->price_id->PlaceHolder = RemoveHtml($this->price_id->caption());

            // quantity
            $this->quantity->EditAttrs["class"] = "form-control";
            $this->quantity->EditCustomAttributes = "";
            $this->quantity->EditValue = HtmlEncode($this->quantity->CurrentValue);
            $this->quantity->PlaceHolder = RemoveHtml($this->quantity->caption());

            // assigned_buses
            $this->assigned_buses->EditAttrs["class"] = "form-control";
            $this->assigned_buses->EditCustomAttributes = "";
            $this->assigned_buses->EditValue = HtmlEncode($this->assigned_buses->CurrentValue);
            $this->assigned_buses->PlaceHolder = RemoveHtml($this->assigned_buses->caption());

            // start_date
            $this->start_date->EditAttrs["class"] = "form-control";
            $this->start_date->EditCustomAttributes = 'readonly="readonly"';
            $this->start_date->EditValue = HtmlEncode(FormatDateTime($this->start_date->CurrentValue, 5));
            $this->start_date->PlaceHolder = RemoveHtml($this->start_date->caption());

            // end_date
            $this->end_date->EditAttrs["class"] = "form-control";
            $this->end_date->EditCustomAttributes = 'readonly="readonly"';
            $this->end_date->EditValue = HtmlEncode(FormatDateTime($this->end_date->CurrentValue, 5));
            $this->end_date->PlaceHolder = RemoveHtml($this->end_date->caption());

            // visible_status_id
            $this->visible_status_id->EditAttrs["class"] = "form-control";
            $this->visible_status_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->visible_status_id->CurrentValue));
            if ($curVal != "") {
                $this->visible_status_id->ViewValue = $this->visible_status_id->lookupCacheOption($curVal);
            } else {
                $this->visible_status_id->ViewValue = $this->visible_status_id->Lookup !== null && is_array($this->visible_status_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->visible_status_id->ViewValue !== null) { // Load from cache
                $this->visible_status_id->EditValue = array_values($this->visible_status_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->visible_status_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->visible_status_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->visible_status_id->EditValue = $arwrk;
            }
            $this->visible_status_id->PlaceHolder = RemoveHtml($this->visible_status_id->caption());

            // status_id
            $this->status_id->EditAttrs["class"] = "form-control";
            $this->status_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->status_id->CurrentValue));
            if ($curVal != "") {
                $this->status_id->ViewValue = $this->status_id->lookupCacheOption($curVal);
            } else {
                $this->status_id->ViewValue = $this->status_id->Lookup !== null && is_array($this->status_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->status_id->ViewValue !== null) { // Load from cache
                $this->status_id->EditValue = array_values($this->status_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->status_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->status_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->status_id->EditValue = $arwrk;
            }
            $this->status_id->PlaceHolder = RemoveHtml($this->status_id->caption());

            // print_status_id
            $this->print_status_id->EditAttrs["class"] = "form-control";
            $this->print_status_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->print_status_id->CurrentValue));
            if ($curVal != "") {
                $this->print_status_id->ViewValue = $this->print_status_id->lookupCacheOption($curVal);
            } else {
                $this->print_status_id->ViewValue = $this->print_status_id->Lookup !== null && is_array($this->print_status_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->print_status_id->ViewValue !== null) { // Load from cache
                $this->print_status_id->EditValue = array_values($this->print_status_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->print_status_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->print_status_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->print_status_id->EditValue = $arwrk;
            }
            $this->print_status_id->PlaceHolder = RemoveHtml($this->print_status_id->caption());

            // payment_status_id
            $this->payment_status_id->EditAttrs["class"] = "form-control";
            $this->payment_status_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->payment_status_id->CurrentValue));
            if ($curVal != "") {
                $this->payment_status_id->ViewValue = $this->payment_status_id->lookupCacheOption($curVal);
            } else {
                $this->payment_status_id->ViewValue = $this->payment_status_id->Lookup !== null && is_array($this->payment_status_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->payment_status_id->ViewValue !== null) { // Load from cache
                $this->payment_status_id->EditValue = array_values($this->payment_status_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->payment_status_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->payment_status_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->payment_status_id->EditValue = $arwrk;
            }
            $this->payment_status_id->PlaceHolder = RemoveHtml($this->payment_status_id->caption());

            // total
            $this->total->EditAttrs["class"] = "form-control";
            $this->total->EditCustomAttributes = "";
            $this->total->EditValue = HtmlEncode($this->total->CurrentValue);
            $this->total->PlaceHolder = RemoveHtml($this->total->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // campaign_id
            $this->campaign_id->LinkCustomAttributes = "";
            $this->campaign_id->HrefValue = "";

            // operator_id
            $this->operator_id->LinkCustomAttributes = "";
            $this->operator_id->HrefValue = "";

            // payment_date
            $this->payment_date->LinkCustomAttributes = "";
            $this->payment_date->HrefValue = "";

            // vendor_id
            $this->vendor_id->LinkCustomAttributes = "";
            $this->vendor_id->HrefValue = "";

            // price_id
            $this->price_id->LinkCustomAttributes = "";
            $this->price_id->HrefValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";

            // assigned_buses
            $this->assigned_buses->LinkCustomAttributes = "";
            $this->assigned_buses->HrefValue = "";

            // start_date
            $this->start_date->LinkCustomAttributes = "";
            $this->start_date->HrefValue = "";

            // end_date
            $this->end_date->LinkCustomAttributes = "";
            $this->end_date->HrefValue = "";

            // visible_status_id
            $this->visible_status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->visible_status_id->CurrentValue)) {
                $this->visible_status_id->HrefValue = "#" . (!empty($this->visible_status_id->EditValue) && !is_array($this->visible_status_id->EditValue) ? RemoveHtml($this->visible_status_id->EditValue) : $this->visible_status_id->CurrentValue); // Add prefix/suffix
                $this->visible_status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->visible_status_id->HrefValue = FullUrl($this->visible_status_id->HrefValue, "href");
                }
            } else {
                $this->visible_status_id->HrefValue = "";
            }

            // status_id
            $this->status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->status_id->CurrentValue)) {
                $this->status_id->HrefValue = "#" . (!empty($this->status_id->EditValue) && !is_array($this->status_id->EditValue) ? RemoveHtml($this->status_id->EditValue) : $this->status_id->CurrentValue); // Add prefix/suffix
                $this->status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->status_id->HrefValue = FullUrl($this->status_id->HrefValue, "href");
                }
            } else {
                $this->status_id->HrefValue = "";
            }

            // print_status_id
            $this->print_status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->print_status_id->CurrentValue)) {
                $this->print_status_id->HrefValue = "#" . (!empty($this->print_status_id->EditValue) && !is_array($this->print_status_id->EditValue) ? RemoveHtml($this->print_status_id->EditValue) : $this->print_status_id->CurrentValue); // Add prefix/suffix
                $this->print_status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->print_status_id->HrefValue = FullUrl($this->print_status_id->HrefValue, "href");
                }
            } else {
                $this->print_status_id->HrefValue = "";
            }

            // payment_status_id
            $this->payment_status_id->LinkCustomAttributes = "";
            if (!EmptyValue($this->payment_status_id->CurrentValue)) {
                $this->payment_status_id->HrefValue = "#" . (!empty($this->payment_status_id->EditValue) && !is_array($this->payment_status_id->EditValue) ? RemoveHtml($this->payment_status_id->EditValue) : $this->payment_status_id->CurrentValue); // Add prefix/suffix
                $this->payment_status_id->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->payment_status_id->HrefValue = FullUrl($this->payment_status_id->HrefValue, "href");
                }
            } else {
                $this->payment_status_id->HrefValue = "";
            }

            // total
            $this->total->LinkCustomAttributes = "";
            $this->total->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
                    $this->quantity->Total = 0; // Initialize total
                    $this->total->Total = 0; // Initialize total
        } elseif ($this->RowType == ROWTYPE_AGGREGATE) { // Aggregate row
            $this->quantity->CurrentValue = $this->quantity->Total;
            $this->quantity->ViewValue = $this->quantity->CurrentValue;
            $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
            $this->quantity->CssClass = "font-weight-bold";
            $this->quantity->CellCssStyle .= "text-align: right;";
            $this->quantity->ViewCustomAttributes = "";
            $this->quantity->HrefValue = ""; // Clear href value
            $this->total->CurrentValue = $this->total->Total;
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatNumber($this->total->ViewValue, 0, -2, -2, -2);
            $this->total->CssClass = "font-weight-bold";
            $this->total->CellCssStyle .= "text-align: right;";
            $this->total->ViewCustomAttributes = "";
            $this->total->HrefValue = ""; // Clear href value
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
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
        if ($this->campaign_id->Required) {
            if (!$this->campaign_id->IsDetailKey && EmptyValue($this->campaign_id->FormValue)) {
                $this->campaign_id->addErrorMessage(str_replace("%s", $this->campaign_id->caption(), $this->campaign_id->RequiredErrorMessage));
            }
        }
        if ($this->operator_id->Required) {
            if (!$this->operator_id->IsDetailKey && EmptyValue($this->operator_id->FormValue)) {
                $this->operator_id->addErrorMessage(str_replace("%s", $this->operator_id->caption(), $this->operator_id->RequiredErrorMessage));
            }
        }
        if ($this->payment_date->Required) {
            if (!$this->payment_date->IsDetailKey && EmptyValue($this->payment_date->FormValue)) {
                $this->payment_date->addErrorMessage(str_replace("%s", $this->payment_date->caption(), $this->payment_date->RequiredErrorMessage));
            }
        }
        if (!CheckStdDate($this->payment_date->FormValue)) {
            $this->payment_date->addErrorMessage($this->payment_date->getErrorMessage(false));
        }
        if ($this->vendor_id->Required) {
            if (!$this->vendor_id->IsDetailKey && EmptyValue($this->vendor_id->FormValue)) {
                $this->vendor_id->addErrorMessage(str_replace("%s", $this->vendor_id->caption(), $this->vendor_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->vendor_id->FormValue)) {
            $this->vendor_id->addErrorMessage($this->vendor_id->getErrorMessage(false));
        }
        if ($this->price_id->Required) {
            if (!$this->price_id->IsDetailKey && EmptyValue($this->price_id->FormValue)) {
                $this->price_id->addErrorMessage(str_replace("%s", $this->price_id->caption(), $this->price_id->RequiredErrorMessage));
            }
        }
        if ($this->quantity->Required) {
            if (!$this->quantity->IsDetailKey && EmptyValue($this->quantity->FormValue)) {
                $this->quantity->addErrorMessage(str_replace("%s", $this->quantity->caption(), $this->quantity->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->quantity->FormValue)) {
            $this->quantity->addErrorMessage($this->quantity->getErrorMessage(false));
        }
        if ($this->assigned_buses->Required) {
            if (!$this->assigned_buses->IsDetailKey && EmptyValue($this->assigned_buses->FormValue)) {
                $this->assigned_buses->addErrorMessage(str_replace("%s", $this->assigned_buses->caption(), $this->assigned_buses->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->assigned_buses->FormValue)) {
            $this->assigned_buses->addErrorMessage($this->assigned_buses->getErrorMessage(false));
        }
        if ($this->start_date->Required) {
            if (!$this->start_date->IsDetailKey && EmptyValue($this->start_date->FormValue)) {
                $this->start_date->addErrorMessage(str_replace("%s", $this->start_date->caption(), $this->start_date->RequiredErrorMessage));
            }
        }
        if (!CheckStdDate($this->start_date->FormValue)) {
            $this->start_date->addErrorMessage($this->start_date->getErrorMessage(false));
        }
        if ($this->end_date->Required) {
            if (!$this->end_date->IsDetailKey && EmptyValue($this->end_date->FormValue)) {
                $this->end_date->addErrorMessage(str_replace("%s", $this->end_date->caption(), $this->end_date->RequiredErrorMessage));
            }
        }
        if (!CheckStdDate($this->end_date->FormValue)) {
            $this->end_date->addErrorMessage($this->end_date->getErrorMessage(false));
        }
        if ($this->visible_status_id->Required) {
            if (!$this->visible_status_id->IsDetailKey && EmptyValue($this->visible_status_id->FormValue)) {
                $this->visible_status_id->addErrorMessage(str_replace("%s", $this->visible_status_id->caption(), $this->visible_status_id->RequiredErrorMessage));
            }
        }
        if ($this->status_id->Required) {
            if (!$this->status_id->IsDetailKey && EmptyValue($this->status_id->FormValue)) {
                $this->status_id->addErrorMessage(str_replace("%s", $this->status_id->caption(), $this->status_id->RequiredErrorMessage));
            }
        }
        if ($this->print_status_id->Required) {
            if (!$this->print_status_id->IsDetailKey && EmptyValue($this->print_status_id->FormValue)) {
                $this->print_status_id->addErrorMessage(str_replace("%s", $this->print_status_id->caption(), $this->print_status_id->RequiredErrorMessage));
            }
        }
        if ($this->payment_status_id->Required) {
            if (!$this->payment_status_id->IsDetailKey && EmptyValue($this->payment_status_id->FormValue)) {
                $this->payment_status_id->addErrorMessage(str_replace("%s", $this->payment_status_id->caption(), $this->payment_status_id->RequiredErrorMessage));
            }
        }
        if ($this->total->Required) {
            if (!$this->total->IsDetailKey && EmptyValue($this->total->FormValue)) {
                $this->total->addErrorMessage(str_replace("%s", $this->total->caption(), $this->total->RequiredErrorMessage));
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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['id'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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

            // campaign_id
            if ($this->campaign_id->getSessionValue() != "") {
                $this->campaign_id->ReadOnly = true;
            }
            $this->campaign_id->setDbValueDef($rsnew, $this->campaign_id->CurrentValue, 0, $this->campaign_id->ReadOnly);

            // operator_id
            if ($this->operator_id->getSessionValue() != "") {
                $this->operator_id->ReadOnly = true;
            }
            $this->operator_id->setDbValueDef($rsnew, $this->operator_id->CurrentValue, 0, $this->operator_id->ReadOnly);

            // payment_date
            $this->payment_date->setDbValueDef($rsnew, UnFormatDateTime($this->payment_date->CurrentValue, 5), null, $this->payment_date->ReadOnly);

            // vendor_id
            $this->vendor_id->setDbValueDef($rsnew, $this->vendor_id->CurrentValue, null, $this->vendor_id->ReadOnly);

            // price_id
            $this->price_id->setDbValueDef($rsnew, $this->price_id->CurrentValue, null, $this->price_id->ReadOnly);

            // quantity
            $this->quantity->setDbValueDef($rsnew, $this->quantity->CurrentValue, 0, $this->quantity->ReadOnly);

            // assigned_buses
            $this->assigned_buses->setDbValueDef($rsnew, $this->assigned_buses->CurrentValue, null, $this->assigned_buses->ReadOnly);

            // start_date
            $this->start_date->setDbValueDef($rsnew, UnFormatDateTime($this->start_date->CurrentValue, 5), null, $this->start_date->ReadOnly);

            // end_date
            $this->end_date->setDbValueDef($rsnew, UnFormatDateTime($this->end_date->CurrentValue, 5), null, $this->end_date->ReadOnly);

            // visible_status_id
            $this->visible_status_id->setDbValueDef($rsnew, $this->visible_status_id->CurrentValue, 0, $this->visible_status_id->ReadOnly);

            // status_id
            $this->status_id->setDbValueDef($rsnew, $this->status_id->CurrentValue, 0, $this->status_id->ReadOnly);

            // print_status_id
            $this->print_status_id->setDbValueDef($rsnew, $this->print_status_id->CurrentValue, 0, $this->print_status_id->ReadOnly);

            // payment_status_id
            $this->payment_status_id->setDbValueDef($rsnew, $this->payment_status_id->CurrentValue, 0, $this->payment_status_id->ReadOnly);

            // total
            $this->total->setDbValueDef($rsnew, $this->total->CurrentValue, null, $this->total->ReadOnly);

            // Check referential integrity for master table 'y_operators'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_y_operators();
            $keyValue = $rsnew['operator_id'] ?? $rsold['operator_id'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($keyValue), $masterFilter);
            } else {
                $validMasterRecord = false;
            }
            if ($validMasterRecord) {
                $rsmaster = Container("y_operators")->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "y_operators", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
            }

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

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssoc($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash(&$rs)
    {
        if (!$rs) {
            return "";
        }
        $row = ($rs instanceof Recordset) ? $rs->fields : $rs;
        $hash = "";
        $hash .= GetFieldHash($row['campaign_id']); // campaign_id
        $hash .= GetFieldHash($row['operator_id']); // operator_id
        $hash .= GetFieldHash($row['payment_date']); // payment_date
        $hash .= GetFieldHash($row['vendor_id']); // vendor_id
        $hash .= GetFieldHash($row['price_id']); // price_id
        $hash .= GetFieldHash($row['quantity']); // quantity
        $hash .= GetFieldHash($row['assigned_buses']); // assigned_buses
        $hash .= GetFieldHash($row['start_date']); // start_date
        $hash .= GetFieldHash($row['end_date']); // end_date
        $hash .= GetFieldHash($row['visible_status_id']); // visible_status_id
        $hash .= GetFieldHash($row['status_id']); // status_id
        $hash .= GetFieldHash($row['print_status_id']); // print_status_id
        $hash .= GetFieldHash($row['payment_status_id']); // payment_status_id
        $hash .= GetFieldHash($row['total']); // total
        return md5($hash);
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

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $masterFilter = $this->sqlMasterFilter_main_campaigns();
            if (strval($this->campaign_id->CurrentValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($this->campaign_id->CurrentValue, "DB"), $masterFilter);
            } else {
                $masterFilter = "";
            }
            if ($masterFilter != "") {
                $rsmaster = Container("main_campaigns")->loadRs($masterFilter)->fetch(\PDO::FETCH_ASSOC);
                $this->MasterRecordExists = $rsmaster !== false;
                $validMasterKey = true;
                if ($this->MasterRecordExists) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['vendor_id']);
                } elseif ($this->getCurrentMasterTable() == "main_campaigns") {
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

        // Check referential integrity for master table 'main_transactions'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_y_operators();
        if (strval($this->operator_id->CurrentValue) != "") {
            $masterFilter = str_replace("@id@", AdjustSql($this->operator_id->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("y_operators")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "y_operators", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // campaign_id
        $this->campaign_id->setDbValueDef($rsnew, $this->campaign_id->CurrentValue, 0, false);

        // operator_id
        $this->operator_id->setDbValueDef($rsnew, $this->operator_id->CurrentValue, 0, false);

        // payment_date
        $this->payment_date->setDbValueDef($rsnew, UnFormatDateTime($this->payment_date->CurrentValue, 5), null, false);

        // vendor_id
        $this->vendor_id->setDbValueDef($rsnew, $this->vendor_id->CurrentValue, null, false);

        // price_id
        $this->price_id->setDbValueDef($rsnew, $this->price_id->CurrentValue, null, false);

        // quantity
        $this->quantity->setDbValueDef($rsnew, $this->quantity->CurrentValue, 0, false);

        // assigned_buses
        $this->assigned_buses->setDbValueDef($rsnew, $this->assigned_buses->CurrentValue, null, false);

        // start_date
        $this->start_date->setDbValueDef($rsnew, UnFormatDateTime($this->start_date->CurrentValue, 5), null, false);

        // end_date
        $this->end_date->setDbValueDef($rsnew, UnFormatDateTime($this->end_date->CurrentValue, 5), null, false);

        // visible_status_id
        $this->visible_status_id->setDbValueDef($rsnew, $this->visible_status_id->CurrentValue, 0, false);

        // status_id
        $this->status_id->setDbValueDef($rsnew, $this->status_id->CurrentValue, 0, strval($this->status_id->CurrentValue) == "");

        // print_status_id
        $this->print_status_id->setDbValueDef($rsnew, $this->print_status_id->CurrentValue, 0, strval($this->print_status_id->CurrentValue) == "");

        // payment_status_id
        $this->payment_status_id->setDbValueDef($rsnew, $this->payment_status_id->CurrentValue, 0, strval($this->payment_status_id->CurrentValue) == "");

        // total
        $this->total->setDbValueDef($rsnew, $this->total->CurrentValue, null, false);

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

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->id->AdvancedSearch->load();
        $this->campaign_id->AdvancedSearch->load();
        $this->operator_id->AdvancedSearch->load();
        $this->payment_date->AdvancedSearch->load();
        $this->vendor_id->AdvancedSearch->load();
        $this->price_id->AdvancedSearch->load();
        $this->quantity->AdvancedSearch->load();
        $this->assigned_buses->AdvancedSearch->load();
        $this->start_date->AdvancedSearch->load();
        $this->end_date->AdvancedSearch->load();
        $this->visible_status_id->AdvancedSearch->load();
        $this->status_id->AdvancedSearch->load();
        $this->print_status_id->AdvancedSearch->load();
        $this->payment_status_id->AdvancedSearch->load();
        $this->created_by->AdvancedSearch->load();
        $this->ts_created->AdvancedSearch->load();
        $this->ts_last_update->AdvancedSearch->load();
        $this->total->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fmain_transactionslist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fmain_transactionslist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fmain_transactionslist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\">" . $Language->phrase("ExportToPDF") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ",url:'" . $pageUrl . "export=email&amp;custom=1'" : "";
            return '<button id="emf_main_transactions" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_main_transactions\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fmain_transactionslist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = true;

        // Export to Html
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = true;

        // Export to Xml
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = false;

        // Export to Csv
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = true;

        // Export to Pdf
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = true;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->add($this->ExportOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up search/sort options
    protected function setupSearchSortOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fmain_transactionslistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Advanced search button
        $item = &$this->SearchOptions->add("advancedsearch");
        $item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->phrase("AdvancedSearch") . "\" href=\"maintransactionssearch\">" . $Language->phrase("AdvancedSearchBtn") . "</a>";
        $item->Visible = true;

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param boolean $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($return = false)
    {
        global $Language;
        $utf8 = SameText(Config("PROJECT_CHARSET"), "utf-8");

        // Load recordset
        $this->TotalRecords = $this->listRecordCount();
        $this->StartRecord = 1;

        // Export all
        if ($this->ExportAll) {
            set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            $this->DisplayRecords = $this->TotalRecords;
            $this->StopRecord = $this->TotalRecords;
        } else { // Export one page only
            $this->setupStartRecord(); // Set up start record position
            // Set the last record to display
            if ($this->DisplayRecords <= 0) {
                $this->StopRecord = $this->TotalRecords;
            } else {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            }
        }
        $rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
        $this->ExportDoc = GetExportDocument($this, "h");
        $doc = &$this->ExportDoc;
        if (!$doc) {
            $this->setFailureMessage($Language->phrase("ExportClassNotFound")); // Export class not found
        }
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $this->ExportDoc->ExportCustom = !$this->pageExporting();

        // Export master record
        if (Config("EXPORT_MASTER_RECORD") && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "main_campaigns") {
            $main_campaigns = Container("main_campaigns");
            $rsmaster = $main_campaigns->loadRs($this->DbMasterFilter); // Load master record
            if ($rsmaster) {
                $exportStyle = $doc->Style;
                $doc->setStyle("v"); // Change to vertical
                if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
                    $doc->Table = $main_campaigns;
                    $main_campaigns->exportDocument($doc, new Recordset($rsmaster));
                    $doc->exportEmptyRow();
                    $doc->Table = &$this;
                }
                $doc->setStyle($exportStyle); // Restore
                $rsmaster->closeCursor();
            }
        }

        // Export master record
        if (Config("EXPORT_MASTER_RECORD") && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "y_operators") {
            $y_operators = Container("y_operators");
            $rsmaster = $y_operators->loadRs($this->DbMasterFilter); // Load master record
            if ($rsmaster) {
                $exportStyle = $doc->Style;
                $doc->setStyle("v"); // Change to vertical
                if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
                    $doc->Table = $y_operators;
                    $y_operators->exportDocument($doc, new Recordset($rsmaster));
                    $doc->exportEmptyRow();
                    $doc->Table = &$this;
                }
                $doc->setStyle($exportStyle); // Restore
                $rsmaster->closeCursor();
            }
        }
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Close recordset
        $rs->close();

        // Call Page Exported server event
        $this->pageExported();

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Clean output buffer (without destroying output buffer)
        $buffer = ob_get_contents(); // Save the output buffer
        if (!Config("DEBUG") && $buffer) {
            ob_clean();
        }

        // Write debug message if enabled
        if (Config("DEBUG") && !$this->isExport("pdf")) {
            echo GetDebugMessage();
        }

        // Output data
        if ($this->isExport("email")) {
            // Export-to-email disabled
        } else {
            $doc->export();
            if ($return) {
                RemoveHeader("Content-Type"); // Remove header
                RemoveHeader("Content-Disposition");
                $content = ob_get_contents();
                if ($content) {
                    ob_clean();
                }
                if ($buffer) {
                    echo $buffer; // Resume the output buffer
                }
                return $content;
            }
        }
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
            if ($masterTblVar == "main_campaigns") {
                $validMaster = true;
                $masterTbl = Container("main_campaigns");
                if (($parm = Get("fk_id", Get("campaign_id"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->campaign_id->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->campaign_id->setSessionValue($this->campaign_id->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "y_operators") {
                $validMaster = true;
                $masterTbl = Container("y_operators");
                if (($parm = Get("fk_id", Get("operator_id"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->operator_id->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->operator_id->setSessionValue($this->operator_id->QueryStringValue);
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
            if ($masterTblVar == "main_campaigns") {
                $validMaster = true;
                $masterTbl = Container("main_campaigns");
                if (($parm = Post("fk_id", Post("campaign_id"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->campaign_id->setFormValue($masterTbl->id->FormValue);
                    $this->campaign_id->setSessionValue($this->campaign_id->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "y_operators") {
                $validMaster = true;
                $masterTbl = Container("y_operators");
                if (($parm = Post("fk_id", Post("operator_id"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->operator_id->setFormValue($masterTbl->id->FormValue);
                    $this->operator_id->setSessionValue($this->operator_id->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Update URL
            $this->AddUrl = $this->addMasterUrl($this->AddUrl);
            $this->InlineAddUrl = $this->addMasterUrl($this->InlineAddUrl);
            $this->GridAddUrl = $this->addMasterUrl($this->GridAddUrl);
            $this->GridEditUrl = $this->addMasterUrl($this->GridEditUrl);

            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "main_campaigns") {
                if ($this->campaign_id->CurrentValue == "") {
                    $this->campaign_id->setSessionValue("");
                }
            }
            if ($masterTblVar != "y_operators") {
                if ($this->operator_id->CurrentValue == "") {
                    $this->operator_id->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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
                    break;
                case "x_operator_id":
                    break;
                case "x_vendor_id":
                    break;
                case "x_price_id":
                    break;
                case "x_visible_status_id":
                    break;
                case "x_status_id":
                    break;
                case "x_print_status_id":
                    break;
                case "x_payment_status_id":
                    break;
                case "x_created_by":
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
        $this->total->ReadOnly = TRUE;
        $levelid = CurrentUserLevel();
        if(IsAdmin()){
    			//ADMIN
    			$this->visible_status_id->Visible = FALSE;
    	}else{
    			if($levelid > 0 ){
    				// MANAGER
    				$this->visible_status_id->Visible = FALSE;
    				if($levelid == 1){
    					//$this->price_id->Visible = FALSE;
    				}elseif($levelid == 2){
    					//$this->price_id->Visible = FALSE;
    				}elseif($levelid == 3){
    					$this->price_id->Visible = FALSE;
    					$this->total->Visible = FALSE;
    				}elseif($levelid == 4){
    					$this->price_id->Visible = FALSE;
    					$this->total->Visible = FALSE;
    				}elseif($levelid == 7){
    					//echo "aaaaaaaaaaaaaaaaaaa<br><br><br><br>";
    					$this->price_id->Visible = FALSE;
    					$this->total->Visible = FALSE;
    				}
    			}else{
    				// DEFAULT
    				$this->status_id->Visible = FALSE;
    				$this->operator_id->Visible = FALSE;
    			}
    	}	
        //var_dump($this->status_id);
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

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}

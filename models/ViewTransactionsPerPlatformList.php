<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ViewTransactionsPerPlatformList extends ViewTransactionsPerPlatform
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'view_transactions_per_platform';

    // Page object name
    public $PageObjName = "ViewTransactionsPerPlatformList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fview_transactions_per_platformlist";
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

        // Table object (view_transactions_per_platform)
        if (!isset($GLOBALS["view_transactions_per_platform"]) || get_class($GLOBALS["view_transactions_per_platform"]) == PROJECT_NAMESPACE . "view_transactions_per_platform") {
            $GLOBALS["view_transactions_per_platform"] = &$this;
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
        $this->AddUrl = "viewtransactionsperplatformadd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "viewtransactionsperplatformdelete";
        $this->MultiUpdateUrl = "viewtransactionsperplatformupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_transactions_per_platform');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fview_transactions_per_platformlistsrch";

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
                $doc = new $class(Container("view_transactions_per_platform"));
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
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->transaction_id->setVisibility();
        $this->campaign->setVisibility();
        $this->payment_date->setVisibility();
        $this->inventory->setVisibility();
        $this->bus_size->Visible = false;
        $this->print_stage->Visible = false;
        $this->vendor->setVisibility();
        $this->operator->setVisibility();
        $this->transaction_status->setVisibility();
        $this->quantity->setVisibility();
        $this->lamata_fee->setVisibility();
        $this->total->setVisibility();
        $this->start_date->Visible = false;
        $this->end_date->Visible = false;
        $this->platform->Visible = false;
        $this->status_id->Visible = false;
        $this->vendor_id->Visible = false;
        $this->inventory_id->Visible = false;
        $this->platform_id->Visible = false;
        $this->operator_id->Visible = false;
        $this->bus_size_id->Visible = false;
        $this->vendor_search_id->Visible = false;
        $this->vendor_search_name->Visible = false;
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

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
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
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

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->transaction_id->AdvancedSearch->toJson(), ","); // Field transaction_id
        $filterList = Concat($filterList, $this->campaign->AdvancedSearch->toJson(), ","); // Field campaign
        $filterList = Concat($filterList, $this->payment_date->AdvancedSearch->toJson(), ","); // Field payment_date
        $filterList = Concat($filterList, $this->inventory->AdvancedSearch->toJson(), ","); // Field inventory
        $filterList = Concat($filterList, $this->bus_size->AdvancedSearch->toJson(), ","); // Field bus_size
        $filterList = Concat($filterList, $this->print_stage->AdvancedSearch->toJson(), ","); // Field print_stage
        $filterList = Concat($filterList, $this->vendor->AdvancedSearch->toJson(), ","); // Field vendor
        $filterList = Concat($filterList, $this->operator->AdvancedSearch->toJson(), ","); // Field operator
        $filterList = Concat($filterList, $this->transaction_status->AdvancedSearch->toJson(), ","); // Field transaction_status
        $filterList = Concat($filterList, $this->quantity->AdvancedSearch->toJson(), ","); // Field quantity
        $filterList = Concat($filterList, $this->lamata_fee->AdvancedSearch->toJson(), ","); // Field lamata_fee
        $filterList = Concat($filterList, $this->total->AdvancedSearch->toJson(), ","); // Field total
        $filterList = Concat($filterList, $this->start_date->AdvancedSearch->toJson(), ","); // Field start_date
        $filterList = Concat($filterList, $this->end_date->AdvancedSearch->toJson(), ","); // Field end_date
        $filterList = Concat($filterList, $this->platform->AdvancedSearch->toJson(), ","); // Field platform
        $filterList = Concat($filterList, $this->status_id->AdvancedSearch->toJson(), ","); // Field status_id
        $filterList = Concat($filterList, $this->vendor_id->AdvancedSearch->toJson(), ","); // Field vendor_id
        $filterList = Concat($filterList, $this->inventory_id->AdvancedSearch->toJson(), ","); // Field inventory_id
        $filterList = Concat($filterList, $this->platform_id->AdvancedSearch->toJson(), ","); // Field platform_id
        $filterList = Concat($filterList, $this->operator_id->AdvancedSearch->toJson(), ","); // Field operator_id
        $filterList = Concat($filterList, $this->bus_size_id->AdvancedSearch->toJson(), ","); // Field bus_size_id
        $filterList = Concat($filterList, $this->vendor_search_id->AdvancedSearch->toJson(), ","); // Field vendor_search_id
        $filterList = Concat($filterList, $this->vendor_search_name->AdvancedSearch->toJson(), ","); // Field vendor_search_name
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fview_transactions_per_platformlistsrch", $filters);
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

        // Field transaction_id
        $this->transaction_id->AdvancedSearch->SearchValue = @$filter["x_transaction_id"];
        $this->transaction_id->AdvancedSearch->SearchOperator = @$filter["z_transaction_id"];
        $this->transaction_id->AdvancedSearch->SearchCondition = @$filter["v_transaction_id"];
        $this->transaction_id->AdvancedSearch->SearchValue2 = @$filter["y_transaction_id"];
        $this->transaction_id->AdvancedSearch->SearchOperator2 = @$filter["w_transaction_id"];
        $this->transaction_id->AdvancedSearch->save();

        // Field campaign
        $this->campaign->AdvancedSearch->SearchValue = @$filter["x_campaign"];
        $this->campaign->AdvancedSearch->SearchOperator = @$filter["z_campaign"];
        $this->campaign->AdvancedSearch->SearchCondition = @$filter["v_campaign"];
        $this->campaign->AdvancedSearch->SearchValue2 = @$filter["y_campaign"];
        $this->campaign->AdvancedSearch->SearchOperator2 = @$filter["w_campaign"];
        $this->campaign->AdvancedSearch->save();

        // Field payment_date
        $this->payment_date->AdvancedSearch->SearchValue = @$filter["x_payment_date"];
        $this->payment_date->AdvancedSearch->SearchOperator = @$filter["z_payment_date"];
        $this->payment_date->AdvancedSearch->SearchCondition = @$filter["v_payment_date"];
        $this->payment_date->AdvancedSearch->SearchValue2 = @$filter["y_payment_date"];
        $this->payment_date->AdvancedSearch->SearchOperator2 = @$filter["w_payment_date"];
        $this->payment_date->AdvancedSearch->save();

        // Field inventory
        $this->inventory->AdvancedSearch->SearchValue = @$filter["x_inventory"];
        $this->inventory->AdvancedSearch->SearchOperator = @$filter["z_inventory"];
        $this->inventory->AdvancedSearch->SearchCondition = @$filter["v_inventory"];
        $this->inventory->AdvancedSearch->SearchValue2 = @$filter["y_inventory"];
        $this->inventory->AdvancedSearch->SearchOperator2 = @$filter["w_inventory"];
        $this->inventory->AdvancedSearch->save();

        // Field bus_size
        $this->bus_size->AdvancedSearch->SearchValue = @$filter["x_bus_size"];
        $this->bus_size->AdvancedSearch->SearchOperator = @$filter["z_bus_size"];
        $this->bus_size->AdvancedSearch->SearchCondition = @$filter["v_bus_size"];
        $this->bus_size->AdvancedSearch->SearchValue2 = @$filter["y_bus_size"];
        $this->bus_size->AdvancedSearch->SearchOperator2 = @$filter["w_bus_size"];
        $this->bus_size->AdvancedSearch->save();

        // Field print_stage
        $this->print_stage->AdvancedSearch->SearchValue = @$filter["x_print_stage"];
        $this->print_stage->AdvancedSearch->SearchOperator = @$filter["z_print_stage"];
        $this->print_stage->AdvancedSearch->SearchCondition = @$filter["v_print_stage"];
        $this->print_stage->AdvancedSearch->SearchValue2 = @$filter["y_print_stage"];
        $this->print_stage->AdvancedSearch->SearchOperator2 = @$filter["w_print_stage"];
        $this->print_stage->AdvancedSearch->save();

        // Field vendor
        $this->vendor->AdvancedSearch->SearchValue = @$filter["x_vendor"];
        $this->vendor->AdvancedSearch->SearchOperator = @$filter["z_vendor"];
        $this->vendor->AdvancedSearch->SearchCondition = @$filter["v_vendor"];
        $this->vendor->AdvancedSearch->SearchValue2 = @$filter["y_vendor"];
        $this->vendor->AdvancedSearch->SearchOperator2 = @$filter["w_vendor"];
        $this->vendor->AdvancedSearch->save();

        // Field operator
        $this->operator->AdvancedSearch->SearchValue = @$filter["x_operator"];
        $this->operator->AdvancedSearch->SearchOperator = @$filter["z_operator"];
        $this->operator->AdvancedSearch->SearchCondition = @$filter["v_operator"];
        $this->operator->AdvancedSearch->SearchValue2 = @$filter["y_operator"];
        $this->operator->AdvancedSearch->SearchOperator2 = @$filter["w_operator"];
        $this->operator->AdvancedSearch->save();

        // Field transaction_status
        $this->transaction_status->AdvancedSearch->SearchValue = @$filter["x_transaction_status"];
        $this->transaction_status->AdvancedSearch->SearchOperator = @$filter["z_transaction_status"];
        $this->transaction_status->AdvancedSearch->SearchCondition = @$filter["v_transaction_status"];
        $this->transaction_status->AdvancedSearch->SearchValue2 = @$filter["y_transaction_status"];
        $this->transaction_status->AdvancedSearch->SearchOperator2 = @$filter["w_transaction_status"];
        $this->transaction_status->AdvancedSearch->save();

        // Field quantity
        $this->quantity->AdvancedSearch->SearchValue = @$filter["x_quantity"];
        $this->quantity->AdvancedSearch->SearchOperator = @$filter["z_quantity"];
        $this->quantity->AdvancedSearch->SearchCondition = @$filter["v_quantity"];
        $this->quantity->AdvancedSearch->SearchValue2 = @$filter["y_quantity"];
        $this->quantity->AdvancedSearch->SearchOperator2 = @$filter["w_quantity"];
        $this->quantity->AdvancedSearch->save();

        // Field lamata_fee
        $this->lamata_fee->AdvancedSearch->SearchValue = @$filter["x_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->SearchOperator = @$filter["z_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->SearchCondition = @$filter["v_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->SearchValue2 = @$filter["y_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->SearchOperator2 = @$filter["w_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->save();

        // Field total
        $this->total->AdvancedSearch->SearchValue = @$filter["x_total"];
        $this->total->AdvancedSearch->SearchOperator = @$filter["z_total"];
        $this->total->AdvancedSearch->SearchCondition = @$filter["v_total"];
        $this->total->AdvancedSearch->SearchValue2 = @$filter["y_total"];
        $this->total->AdvancedSearch->SearchOperator2 = @$filter["w_total"];
        $this->total->AdvancedSearch->save();

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

        // Field platform
        $this->platform->AdvancedSearch->SearchValue = @$filter["x_platform"];
        $this->platform->AdvancedSearch->SearchOperator = @$filter["z_platform"];
        $this->platform->AdvancedSearch->SearchCondition = @$filter["v_platform"];
        $this->platform->AdvancedSearch->SearchValue2 = @$filter["y_platform"];
        $this->platform->AdvancedSearch->SearchOperator2 = @$filter["w_platform"];
        $this->platform->AdvancedSearch->save();

        // Field status_id
        $this->status_id->AdvancedSearch->SearchValue = @$filter["x_status_id"];
        $this->status_id->AdvancedSearch->SearchOperator = @$filter["z_status_id"];
        $this->status_id->AdvancedSearch->SearchCondition = @$filter["v_status_id"];
        $this->status_id->AdvancedSearch->SearchValue2 = @$filter["y_status_id"];
        $this->status_id->AdvancedSearch->SearchOperator2 = @$filter["w_status_id"];
        $this->status_id->AdvancedSearch->save();

        // Field vendor_id
        $this->vendor_id->AdvancedSearch->SearchValue = @$filter["x_vendor_id"];
        $this->vendor_id->AdvancedSearch->SearchOperator = @$filter["z_vendor_id"];
        $this->vendor_id->AdvancedSearch->SearchCondition = @$filter["v_vendor_id"];
        $this->vendor_id->AdvancedSearch->SearchValue2 = @$filter["y_vendor_id"];
        $this->vendor_id->AdvancedSearch->SearchOperator2 = @$filter["w_vendor_id"];
        $this->vendor_id->AdvancedSearch->save();

        // Field inventory_id
        $this->inventory_id->AdvancedSearch->SearchValue = @$filter["x_inventory_id"];
        $this->inventory_id->AdvancedSearch->SearchOperator = @$filter["z_inventory_id"];
        $this->inventory_id->AdvancedSearch->SearchCondition = @$filter["v_inventory_id"];
        $this->inventory_id->AdvancedSearch->SearchValue2 = @$filter["y_inventory_id"];
        $this->inventory_id->AdvancedSearch->SearchOperator2 = @$filter["w_inventory_id"];
        $this->inventory_id->AdvancedSearch->save();

        // Field platform_id
        $this->platform_id->AdvancedSearch->SearchValue = @$filter["x_platform_id"];
        $this->platform_id->AdvancedSearch->SearchOperator = @$filter["z_platform_id"];
        $this->platform_id->AdvancedSearch->SearchCondition = @$filter["v_platform_id"];
        $this->platform_id->AdvancedSearch->SearchValue2 = @$filter["y_platform_id"];
        $this->platform_id->AdvancedSearch->SearchOperator2 = @$filter["w_platform_id"];
        $this->platform_id->AdvancedSearch->save();

        // Field operator_id
        $this->operator_id->AdvancedSearch->SearchValue = @$filter["x_operator_id"];
        $this->operator_id->AdvancedSearch->SearchOperator = @$filter["z_operator_id"];
        $this->operator_id->AdvancedSearch->SearchCondition = @$filter["v_operator_id"];
        $this->operator_id->AdvancedSearch->SearchValue2 = @$filter["y_operator_id"];
        $this->operator_id->AdvancedSearch->SearchOperator2 = @$filter["w_operator_id"];
        $this->operator_id->AdvancedSearch->save();

        // Field bus_size_id
        $this->bus_size_id->AdvancedSearch->SearchValue = @$filter["x_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchOperator = @$filter["z_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchCondition = @$filter["v_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchValue2 = @$filter["y_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchOperator2 = @$filter["w_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->save();

        // Field vendor_search_id
        $this->vendor_search_id->AdvancedSearch->SearchValue = @$filter["x_vendor_search_id"];
        $this->vendor_search_id->AdvancedSearch->SearchOperator = @$filter["z_vendor_search_id"];
        $this->vendor_search_id->AdvancedSearch->SearchCondition = @$filter["v_vendor_search_id"];
        $this->vendor_search_id->AdvancedSearch->SearchValue2 = @$filter["y_vendor_search_id"];
        $this->vendor_search_id->AdvancedSearch->SearchOperator2 = @$filter["w_vendor_search_id"];
        $this->vendor_search_id->AdvancedSearch->save();

        // Field vendor_search_name
        $this->vendor_search_name->AdvancedSearch->SearchValue = @$filter["x_vendor_search_name"];
        $this->vendor_search_name->AdvancedSearch->SearchOperator = @$filter["z_vendor_search_name"];
        $this->vendor_search_name->AdvancedSearch->SearchCondition = @$filter["v_vendor_search_name"];
        $this->vendor_search_name->AdvancedSearch->SearchValue2 = @$filter["y_vendor_search_name"];
        $this->vendor_search_name->AdvancedSearch->SearchOperator2 = @$filter["w_vendor_search_name"];
        $this->vendor_search_name->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->transaction_id, $default, false); // transaction_id
        $this->buildSearchSql($where, $this->campaign, $default, false); // campaign
        $this->buildSearchSql($where, $this->payment_date, $default, false); // payment_date
        $this->buildSearchSql($where, $this->inventory, $default, false); // inventory
        $this->buildSearchSql($where, $this->bus_size, $default, false); // bus_size
        $this->buildSearchSql($where, $this->print_stage, $default, false); // print_stage
        $this->buildSearchSql($where, $this->vendor, $default, false); // vendor
        $this->buildSearchSql($where, $this->operator, $default, false); // operator
        $this->buildSearchSql($where, $this->transaction_status, $default, false); // transaction_status
        $this->buildSearchSql($where, $this->quantity, $default, false); // quantity
        $this->buildSearchSql($where, $this->lamata_fee, $default, false); // lamata_fee
        $this->buildSearchSql($where, $this->total, $default, false); // total
        $this->buildSearchSql($where, $this->start_date, $default, false); // start_date
        $this->buildSearchSql($where, $this->end_date, $default, false); // end_date
        $this->buildSearchSql($where, $this->platform, $default, false); // platform
        $this->buildSearchSql($where, $this->status_id, $default, false); // status_id
        $this->buildSearchSql($where, $this->vendor_id, $default, false); // vendor_id
        $this->buildSearchSql($where, $this->inventory_id, $default, false); // inventory_id
        $this->buildSearchSql($where, $this->platform_id, $default, false); // platform_id
        $this->buildSearchSql($where, $this->operator_id, $default, false); // operator_id
        $this->buildSearchSql($where, $this->bus_size_id, $default, false); // bus_size_id
        $this->buildSearchSql($where, $this->vendor_search_id, $default, false); // vendor_search_id
        $this->buildSearchSql($where, $this->vendor_search_name, $default, false); // vendor_search_name

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->transaction_id->AdvancedSearch->save(); // transaction_id
            $this->campaign->AdvancedSearch->save(); // campaign
            $this->payment_date->AdvancedSearch->save(); // payment_date
            $this->inventory->AdvancedSearch->save(); // inventory
            $this->bus_size->AdvancedSearch->save(); // bus_size
            $this->print_stage->AdvancedSearch->save(); // print_stage
            $this->vendor->AdvancedSearch->save(); // vendor
            $this->operator->AdvancedSearch->save(); // operator
            $this->transaction_status->AdvancedSearch->save(); // transaction_status
            $this->quantity->AdvancedSearch->save(); // quantity
            $this->lamata_fee->AdvancedSearch->save(); // lamata_fee
            $this->total->AdvancedSearch->save(); // total
            $this->start_date->AdvancedSearch->save(); // start_date
            $this->end_date->AdvancedSearch->save(); // end_date
            $this->platform->AdvancedSearch->save(); // platform
            $this->status_id->AdvancedSearch->save(); // status_id
            $this->vendor_id->AdvancedSearch->save(); // vendor_id
            $this->inventory_id->AdvancedSearch->save(); // inventory_id
            $this->platform_id->AdvancedSearch->save(); // platform_id
            $this->operator_id->AdvancedSearch->save(); // operator_id
            $this->bus_size_id->AdvancedSearch->save(); // bus_size_id
            $this->vendor_search_id->AdvancedSearch->save(); // vendor_search_id
            $this->vendor_search_name->AdvancedSearch->save(); // vendor_search_name
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
        $this->buildBasicSearchSql($where, $this->campaign, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->inventory, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bus_size, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->print_stage, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->vendor, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->operator, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->transaction_status, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->platform, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->vendor_search_name, $arKeywords, $type);
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
        if ($this->transaction_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->campaign->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->payment_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->inventory->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->bus_size->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->print_stage->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->vendor->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->operator->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->transaction_status->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->quantity->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lamata_fee->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->total->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->start_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->end_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->platform->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->vendor_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->inventory_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->platform_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->operator_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->bus_size_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->vendor_search_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->vendor_search_name->AdvancedSearch->issetSession()) {
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
                $this->transaction_id->AdvancedSearch->unsetSession();
                $this->campaign->AdvancedSearch->unsetSession();
                $this->payment_date->AdvancedSearch->unsetSession();
                $this->inventory->AdvancedSearch->unsetSession();
                $this->bus_size->AdvancedSearch->unsetSession();
                $this->print_stage->AdvancedSearch->unsetSession();
                $this->vendor->AdvancedSearch->unsetSession();
                $this->operator->AdvancedSearch->unsetSession();
                $this->transaction_status->AdvancedSearch->unsetSession();
                $this->quantity->AdvancedSearch->unsetSession();
                $this->lamata_fee->AdvancedSearch->unsetSession();
                $this->total->AdvancedSearch->unsetSession();
                $this->start_date->AdvancedSearch->unsetSession();
                $this->end_date->AdvancedSearch->unsetSession();
                $this->platform->AdvancedSearch->unsetSession();
                $this->status_id->AdvancedSearch->unsetSession();
                $this->vendor_id->AdvancedSearch->unsetSession();
                $this->inventory_id->AdvancedSearch->unsetSession();
                $this->platform_id->AdvancedSearch->unsetSession();
                $this->operator_id->AdvancedSearch->unsetSession();
                $this->bus_size_id->AdvancedSearch->unsetSession();
                $this->vendor_search_id->AdvancedSearch->unsetSession();
                $this->vendor_search_name->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
                $this->transaction_id->AdvancedSearch->load();
                $this->campaign->AdvancedSearch->load();
                $this->payment_date->AdvancedSearch->load();
                $this->inventory->AdvancedSearch->load();
                $this->bus_size->AdvancedSearch->load();
                $this->print_stage->AdvancedSearch->load();
                $this->vendor->AdvancedSearch->load();
                $this->operator->AdvancedSearch->load();
                $this->transaction_status->AdvancedSearch->load();
                $this->quantity->AdvancedSearch->load();
                $this->lamata_fee->AdvancedSearch->load();
                $this->total->AdvancedSearch->load();
                $this->start_date->AdvancedSearch->load();
                $this->end_date->AdvancedSearch->load();
                $this->platform->AdvancedSearch->load();
                $this->status_id->AdvancedSearch->load();
                $this->vendor_id->AdvancedSearch->load();
                $this->inventory_id->AdvancedSearch->load();
                $this->platform_id->AdvancedSearch->load();
                $this->operator_id->AdvancedSearch->load();
                $this->bus_size_id->AdvancedSearch->load();
                $this->vendor_search_id->AdvancedSearch->load();
                $this->vendor_search_name->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->transaction_id); // transaction_id
            $this->updateSort($this->campaign); // campaign
            $this->updateSort($this->payment_date); // payment_date
            $this->updateSort($this->inventory); // inventory
            $this->updateSort($this->vendor); // vendor
            $this->updateSort($this->operator); // operator
            $this->updateSort($this->transaction_status); // transaction_status
            $this->updateSort($this->quantity); // quantity
            $this->updateSort($this->lamata_fee); // lamata_fee
            $this->updateSort($this->total); // total
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "\"transaction_id\" DESC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->transaction_id->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->transaction_id->setSort("DESC");
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

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->transaction_id->setSort("");
                $this->campaign->setSort("");
                $this->payment_date->setSort("");
                $this->inventory->setSort("");
                $this->bus_size->setSort("");
                $this->print_stage->setSort("");
                $this->vendor->setSort("");
                $this->operator->setSort("");
                $this->transaction_status->setSort("");
                $this->quantity->setSort("");
                $this->lamata_fee->setSort("");
                $this->total->setSort("");
                $this->start_date->setSort("");
                $this->end_date->setSort("");
                $this->platform->setSort("");
                $this->status_id->setSort("");
                $this->vendor_id->setSort("");
                $this->inventory_id->setSort("");
                $this->platform_id->setSort("");
                $this->operator_id->setSort("");
                $this->bus_size_id->setSort("");
                $this->vendor_search_id->setSort("");
                $this->vendor_search_name->setSort("");
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

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = false;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
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
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") { // View mode
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

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fview_transactions_per_platformlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fview_transactions_per_platformlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fview_transactions_per_platformlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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

        // transaction_id
        if (!$this->isAddOrEdit() && $this->transaction_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->transaction_id->AdvancedSearch->SearchValue != "" || $this->transaction_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // campaign
        if (!$this->isAddOrEdit() && $this->campaign->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->campaign->AdvancedSearch->SearchValue != "" || $this->campaign->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // inventory
        if (!$this->isAddOrEdit() && $this->inventory->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->inventory->AdvancedSearch->SearchValue != "" || $this->inventory->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // bus_size
        if (!$this->isAddOrEdit() && $this->bus_size->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->bus_size->AdvancedSearch->SearchValue != "" || $this->bus_size->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // print_stage
        if (!$this->isAddOrEdit() && $this->print_stage->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->print_stage->AdvancedSearch->SearchValue != "" || $this->print_stage->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // vendor
        if (!$this->isAddOrEdit() && $this->vendor->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->vendor->AdvancedSearch->SearchValue != "" || $this->vendor->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // operator
        if (!$this->isAddOrEdit() && $this->operator->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->operator->AdvancedSearch->SearchValue != "" || $this->operator->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // transaction_status
        if (!$this->isAddOrEdit() && $this->transaction_status->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->transaction_status->AdvancedSearch->SearchValue != "" || $this->transaction_status->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // lamata_fee
        if (!$this->isAddOrEdit() && $this->lamata_fee->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->lamata_fee->AdvancedSearch->SearchValue != "" || $this->lamata_fee->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // platform
        if (!$this->isAddOrEdit() && $this->platform->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->platform->AdvancedSearch->SearchValue != "" || $this->platform->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // vendor_id
        if (!$this->isAddOrEdit() && $this->vendor_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->vendor_id->AdvancedSearch->SearchValue != "" || $this->vendor_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // inventory_id
        if (!$this->isAddOrEdit() && $this->inventory_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->inventory_id->AdvancedSearch->SearchValue != "" || $this->inventory_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // platform_id
        if (!$this->isAddOrEdit() && $this->platform_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->platform_id->AdvancedSearch->SearchValue != "" || $this->platform_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // bus_size_id
        if (!$this->isAddOrEdit() && $this->bus_size_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->bus_size_id->AdvancedSearch->SearchValue != "" || $this->bus_size_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // vendor_search_id
        if (!$this->isAddOrEdit() && $this->vendor_search_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->vendor_search_id->AdvancedSearch->SearchValue != "" || $this->vendor_search_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // vendor_search_name
        if (!$this->isAddOrEdit() && $this->vendor_search_name->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->vendor_search_name->AdvancedSearch->SearchValue != "" || $this->vendor_search_name->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
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
        $this->transaction_id->setDbValue($row['transaction_id']);
        $this->campaign->setDbValue($row['campaign']);
        $this->payment_date->setDbValue($row['payment_date']);
        $this->inventory->setDbValue($row['inventory']);
        $this->bus_size->setDbValue($row['bus_size']);
        $this->print_stage->setDbValue($row['print_stage']);
        $this->vendor->setDbValue($row['vendor']);
        $this->operator->setDbValue($row['operator']);
        $this->transaction_status->setDbValue($row['transaction_status']);
        $this->quantity->setDbValue($row['quantity']);
        $this->lamata_fee->setDbValue($row['lamata_fee']);
        $this->total->setDbValue($row['total']);
        $this->start_date->setDbValue($row['start_date']);
        $this->end_date->setDbValue($row['end_date']);
        $this->platform->setDbValue($row['platform']);
        $this->status_id->setDbValue($row['status_id']);
        $this->vendor_id->setDbValue($row['vendor_id']);
        $this->inventory_id->setDbValue($row['inventory_id']);
        $this->platform_id->setDbValue($row['platform_id']);
        $this->operator_id->setDbValue($row['operator_id']);
        $this->bus_size_id->setDbValue($row['bus_size_id']);
        $this->vendor_search_id->setDbValue($row['vendor_search_id']);
        $this->vendor_search_name->setDbValue($row['vendor_search_name']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['transaction_id'] = null;
        $row['campaign'] = null;
        $row['payment_date'] = null;
        $row['inventory'] = null;
        $row['bus_size'] = null;
        $row['print_stage'] = null;
        $row['vendor'] = null;
        $row['operator'] = null;
        $row['transaction_status'] = null;
        $row['quantity'] = null;
        $row['lamata_fee'] = null;
        $row['total'] = null;
        $row['start_date'] = null;
        $row['end_date'] = null;
        $row['platform'] = null;
        $row['status_id'] = null;
        $row['vendor_id'] = null;
        $row['inventory_id'] = null;
        $row['platform_id'] = null;
        $row['operator_id'] = null;
        $row['bus_size_id'] = null;
        $row['vendor_search_id'] = null;
        $row['vendor_search_name'] = null;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        return false;
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

        // transaction_id

        // campaign
        $this->campaign->CellCssStyle = "white-space: nowrap;";

        // payment_date
        $this->payment_date->CellCssStyle = "white-space: nowrap;";

        // inventory
        $this->inventory->CellCssStyle = "white-space: nowrap;";

        // bus_size
        $this->bus_size->CellCssStyle = "white-space: nowrap;";

        // print_stage
        $this->print_stage->CellCssStyle = "white-space: nowrap;";

        // vendor
        $this->vendor->CellCssStyle = "white-space: nowrap;";

        // operator
        $this->operator->CellCssStyle = "white-space: nowrap;";

        // transaction_status
        $this->transaction_status->CellCssStyle = "white-space: nowrap;";

        // quantity
        $this->quantity->CellCssStyle = "white-space: nowrap;";

        // lamata_fee
        $this->lamata_fee->CellCssStyle = "white-space: nowrap;";

        // total
        $this->total->CellCssStyle = "white-space: nowrap;";

        // start_date
        $this->start_date->CellCssStyle = "white-space: nowrap;";

        // end_date

        // platform

        // status_id
        $this->status_id->CellCssStyle = "white-space: nowrap;";

        // vendor_id
        $this->vendor_id->CellCssStyle = "white-space: nowrap;";

        // inventory_id
        $this->inventory_id->CellCssStyle = "white-space: nowrap;";

        // platform_id
        $this->platform_id->CellCssStyle = "white-space: nowrap;";

        // operator_id
        $this->operator_id->CellCssStyle = "white-space: nowrap;";

        // bus_size_id
        $this->bus_size_id->CellCssStyle = "white-space: nowrap;";

        // vendor_search_id
        $this->vendor_search_id->CellCssStyle = "white-space: nowrap;";

        // vendor_search_name
        $this->vendor_search_name->CellCssStyle = "white-space: nowrap;";

        // Accumulate aggregate value
        if ($this->RowType != ROWTYPE_AGGREGATEINIT && $this->RowType != ROWTYPE_AGGREGATE) {
            if (is_numeric($this->quantity->CurrentValue)) {
                $this->quantity->Total += $this->quantity->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->lamata_fee->CurrentValue)) {
                $this->lamata_fee->Total += $this->lamata_fee->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->total->CurrentValue)) {
                $this->total->Total += $this->total->CurrentValue; // Accumulate total
            }
        }
        if ($this->RowType == ROWTYPE_VIEW) {
            // transaction_id
            $this->transaction_id->ViewValue = $this->transaction_id->CurrentValue;
            $this->transaction_id->ViewValue = FormatNumber($this->transaction_id->ViewValue, 0, -2, -2, -2);
            $this->transaction_id->ViewCustomAttributes = "";

            // campaign
            $this->campaign->ViewValue = $this->campaign->CurrentValue;
            $this->campaign->CssClass = "font-weight-bold";
            $this->campaign->ViewCustomAttributes = "";

            // payment_date
            $this->payment_date->ViewValue = $this->payment_date->CurrentValue;
            $this->payment_date->ViewValue = FormatDateTime($this->payment_date->ViewValue, 0);
            $this->payment_date->ViewCustomAttributes = "";

            // inventory
            $this->inventory->ViewValue = $this->inventory->CurrentValue;
            $this->inventory->ViewCustomAttributes = "";

            // vendor
            $this->vendor->ViewValue = $this->vendor->CurrentValue;
            $this->vendor->ViewCustomAttributes = "";

            // operator
            $this->operator->ViewValue = $this->operator->CurrentValue;
            $this->operator->ViewCustomAttributes = "";

            // transaction_status
            $this->transaction_status->ViewValue = $this->transaction_status->CurrentValue;
            $this->transaction_status->ViewCustomAttributes = 'class="badge bg-success"';

            // quantity
            $this->quantity->ViewValue = $this->quantity->CurrentValue;
            $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
            $this->quantity->CellCssStyle .= "text-align: right;";
            $this->quantity->ViewCustomAttributes = "";

            // lamata_fee
            $this->lamata_fee->ViewValue = $this->lamata_fee->CurrentValue;
            $this->lamata_fee->ViewValue = FormatNumber($this->lamata_fee->ViewValue, 0, -2, -2, -2);
            $this->lamata_fee->CellCssStyle .= "text-align: right;";
            $this->lamata_fee->ViewCustomAttributes = "";

            // total
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatNumber($this->total->ViewValue, 0, -2, -2, -2);
            $this->total->CssClass = "font-weight-bold";
            $this->total->CellCssStyle .= "text-align: right;";
            $this->total->ViewCustomAttributes = "";

            // start_date
            $this->start_date->ViewValue = $this->start_date->CurrentValue;
            $this->start_date->ViewValue = FormatDateTime($this->start_date->ViewValue, 0);
            $this->start_date->ViewCustomAttributes = "";

            // end_date
            $this->end_date->ViewValue = $this->end_date->CurrentValue;
            $this->end_date->ViewValue = FormatDateTime($this->end_date->ViewValue, 0);
            $this->end_date->ViewCustomAttributes = "";

            // platform
            $this->platform->ViewValue = $this->platform->CurrentValue;
            $this->platform->ViewCustomAttributes = "";

            // transaction_id
            $this->transaction_id->LinkCustomAttributes = "";
            $this->transaction_id->HrefValue = "";
            $this->transaction_id->TooltipValue = "";

            // campaign
            $this->campaign->LinkCustomAttributes = "";
            $this->campaign->HrefValue = "";
            $this->campaign->TooltipValue = "";

            // payment_date
            $this->payment_date->LinkCustomAttributes = "";
            $this->payment_date->HrefValue = "";
            $this->payment_date->TooltipValue = "";

            // inventory
            $this->inventory->LinkCustomAttributes = "";
            $this->inventory->HrefValue = "";
            $this->inventory->TooltipValue = "";

            // vendor
            $this->vendor->LinkCustomAttributes = "";
            $this->vendor->HrefValue = "";
            $this->vendor->TooltipValue = "";

            // operator
            $this->operator->LinkCustomAttributes = "";
            $this->operator->HrefValue = "";
            $this->operator->TooltipValue = "";

            // transaction_status
            $this->transaction_status->LinkCustomAttributes = "";
            $this->transaction_status->HrefValue = "";
            $this->transaction_status->TooltipValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";
            $this->quantity->TooltipValue = "";

            // lamata_fee
            $this->lamata_fee->LinkCustomAttributes = "";
            $this->lamata_fee->HrefValue = "";
            $this->lamata_fee->TooltipValue = "";

            // total
            $this->total->LinkCustomAttributes = "";
            $this->total->HrefValue = "";
            $this->total->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
                    $this->quantity->Total = 0; // Initialize total
                    $this->lamata_fee->Total = 0; // Initialize total
                    $this->total->Total = 0; // Initialize total
        } elseif ($this->RowType == ROWTYPE_AGGREGATE) { // Aggregate row
            $this->quantity->CurrentValue = $this->quantity->Total;
            $this->quantity->ViewValue = $this->quantity->CurrentValue;
            $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
            $this->quantity->CellCssStyle .= "text-align: right;";
            $this->quantity->ViewCustomAttributes = "";
            $this->quantity->HrefValue = ""; // Clear href value
            $this->lamata_fee->CurrentValue = $this->lamata_fee->Total;
            $this->lamata_fee->ViewValue = $this->lamata_fee->CurrentValue;
            $this->lamata_fee->ViewValue = FormatNumber($this->lamata_fee->ViewValue, 0, -2, -2, -2);
            $this->lamata_fee->CellCssStyle .= "text-align: right;";
            $this->lamata_fee->ViewCustomAttributes = "";
            $this->lamata_fee->HrefValue = ""; // Clear href value
            $this->total->CurrentValue = $this->total->Total;
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatNumber($this->total->ViewValue, 0, -2, -2, -2);
            $this->total->CssClass = "font-weight-bold";
            $this->total->CellCssStyle .= "text-align: right;";
            $this->total->ViewCustomAttributes = "";
            $this->total->HrefValue = ""; // Clear href value
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

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->transaction_id->AdvancedSearch->load();
        $this->campaign->AdvancedSearch->load();
        $this->payment_date->AdvancedSearch->load();
        $this->inventory->AdvancedSearch->load();
        $this->bus_size->AdvancedSearch->load();
        $this->print_stage->AdvancedSearch->load();
        $this->vendor->AdvancedSearch->load();
        $this->operator->AdvancedSearch->load();
        $this->transaction_status->AdvancedSearch->load();
        $this->quantity->AdvancedSearch->load();
        $this->lamata_fee->AdvancedSearch->load();
        $this->total->AdvancedSearch->load();
        $this->start_date->AdvancedSearch->load();
        $this->end_date->AdvancedSearch->load();
        $this->platform->AdvancedSearch->load();
        $this->status_id->AdvancedSearch->load();
        $this->vendor_id->AdvancedSearch->load();
        $this->inventory_id->AdvancedSearch->load();
        $this->platform_id->AdvancedSearch->load();
        $this->operator_id->AdvancedSearch->load();
        $this->bus_size_id->AdvancedSearch->load();
        $this->vendor_search_id->AdvancedSearch->load();
        $this->vendor_search_name->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fview_transactions_per_platformlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Advanced search button
        $item = &$this->SearchOptions->add("advancedsearch");
        $item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->phrase("AdvancedSearch") . "\" href=\"viewtransactionsperplatformsearch\">" . $Language->phrase("AdvancedSearchBtn") . "</a>";
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

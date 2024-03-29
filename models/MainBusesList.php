<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainBusesList extends MainBuses
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_buses';

    // Page object name
    public $PageObjName = "MainBusesList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fmain_buseslist";
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

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "mainbusesadd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "mainbusesdelete";
        $this->MultiUpdateUrl = "mainbusesupdate";

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
        $this->FilterOptions->TagClassName = "ew-filter-option fmain_buseslistsrch";

        // List actions
        $this->ListActions = new ListActions();
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
    public $SearchFieldsPerRow = 2; // For extended search
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
    public $HashValue; // Hash value
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

        // Setup import options
        $this->setupImportOptions();
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
        $this->ts_last_update->setVisibility();
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
        $this->setupLookupOptions($this->platform_id);
        $this->setupLookupOptions($this->operator_id);
        $this->setupLookupOptions($this->exterior_campaign_id);
        $this->setupLookupOptions($this->interior_campaign_id);
        $this->setupLookupOptions($this->bus_status_id);
        $this->setupLookupOptions($this->bus_size_id);
        $this->setupLookupOptions($this->bus_depot_id);

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

                // Switch to grid add mode
                if ($this->isGridAdd()) {
                    $this->gridAddMode();
                }
            } else {
                if (Post("action") !== null) {
                    $this->CurrentAction = Post("action"); // Get action

                    // Process import
                    if ($this->isImport()) {
                        $this->import(Post(Config("API_FILE_TOKEN_NAME")));
                        $this->terminate();
                        return;
                    }

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

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
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
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "x_bus_status") {
            $masterTbl = Container("x_bus_status");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("xbusstatuslist"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "x_bus_sizes") {
            $masterTbl = Container("x_bus_sizes");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("xbussizeslist"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "x_bus_depot") {
            $masterTbl = Container("x_bus_depot");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("xbusdepotlist"); // Return to master page
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

        // Search options
        $this->setupSearchOptions();

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
        if ($CurrentForm->hasValue("x_number") && $CurrentForm->hasValue("o_number") && $this->number->CurrentValue != $this->number->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_platform_id") && $CurrentForm->hasValue("o_platform_id") && $this->platform_id->CurrentValue != $this->platform_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_operator_id") && $CurrentForm->hasValue("o_operator_id") && $this->operator_id->CurrentValue != $this->operator_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_exterior_campaign_id") && $CurrentForm->hasValue("o_exterior_campaign_id") && $this->exterior_campaign_id->CurrentValue != $this->exterior_campaign_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_interior_campaign_id") && $CurrentForm->hasValue("o_interior_campaign_id") && $this->interior_campaign_id->CurrentValue != $this->interior_campaign_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_bus_status_id") && $CurrentForm->hasValue("o_bus_status_id") && $this->bus_status_id->CurrentValue != $this->bus_status_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_bus_size_id") && $CurrentForm->hasValue("o_bus_size_id") && $this->bus_size_id->CurrentValue != $this->bus_size_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_bus_depot_id") && $CurrentForm->hasValue("o_bus_depot_id") && $this->bus_depot_id->CurrentValue != $this->bus_depot_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_ts_last_update") && $CurrentForm->hasValue("o_ts_last_update") && $this->ts_last_update->CurrentValue != $this->ts_last_update->OldValue) {
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
        $this->number->clearErrorMessage();
        $this->platform_id->clearErrorMessage();
        $this->operator_id->clearErrorMessage();
        $this->exterior_campaign_id->clearErrorMessage();
        $this->interior_campaign_id->clearErrorMessage();
        $this->bus_status_id->clearErrorMessage();
        $this->bus_size_id->clearErrorMessage();
        $this->bus_depot_id->clearErrorMessage();
        $this->ts_last_update->clearErrorMessage();
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->number->AdvancedSearch->toJson(), ","); // Field number
        $filterList = Concat($filterList, $this->platform_id->AdvancedSearch->toJson(), ","); // Field platform_id
        $filterList = Concat($filterList, $this->operator_id->AdvancedSearch->toJson(), ","); // Field operator_id
        $filterList = Concat($filterList, $this->exterior_campaign_id->AdvancedSearch->toJson(), ","); // Field exterior_campaign_id
        $filterList = Concat($filterList, $this->interior_campaign_id->AdvancedSearch->toJson(), ","); // Field interior_campaign_id
        $filterList = Concat($filterList, $this->bus_status_id->AdvancedSearch->toJson(), ","); // Field bus_status_id
        $filterList = Concat($filterList, $this->bus_size_id->AdvancedSearch->toJson(), ","); // Field bus_size_id
        $filterList = Concat($filterList, $this->bus_depot_id->AdvancedSearch->toJson(), ","); // Field bus_depot_id
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fmain_buseslistsrch", $filters);
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

        // Field number
        $this->number->AdvancedSearch->SearchValue = @$filter["x_number"];
        $this->number->AdvancedSearch->SearchOperator = @$filter["z_number"];
        $this->number->AdvancedSearch->SearchCondition = @$filter["v_number"];
        $this->number->AdvancedSearch->SearchValue2 = @$filter["y_number"];
        $this->number->AdvancedSearch->SearchOperator2 = @$filter["w_number"];
        $this->number->AdvancedSearch->save();

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

        // Field exterior_campaign_id
        $this->exterior_campaign_id->AdvancedSearch->SearchValue = @$filter["x_exterior_campaign_id"];
        $this->exterior_campaign_id->AdvancedSearch->SearchOperator = @$filter["z_exterior_campaign_id"];
        $this->exterior_campaign_id->AdvancedSearch->SearchCondition = @$filter["v_exterior_campaign_id"];
        $this->exterior_campaign_id->AdvancedSearch->SearchValue2 = @$filter["y_exterior_campaign_id"];
        $this->exterior_campaign_id->AdvancedSearch->SearchOperator2 = @$filter["w_exterior_campaign_id"];
        $this->exterior_campaign_id->AdvancedSearch->save();

        // Field interior_campaign_id
        $this->interior_campaign_id->AdvancedSearch->SearchValue = @$filter["x_interior_campaign_id"];
        $this->interior_campaign_id->AdvancedSearch->SearchOperator = @$filter["z_interior_campaign_id"];
        $this->interior_campaign_id->AdvancedSearch->SearchCondition = @$filter["v_interior_campaign_id"];
        $this->interior_campaign_id->AdvancedSearch->SearchValue2 = @$filter["y_interior_campaign_id"];
        $this->interior_campaign_id->AdvancedSearch->SearchOperator2 = @$filter["w_interior_campaign_id"];
        $this->interior_campaign_id->AdvancedSearch->save();

        // Field bus_status_id
        $this->bus_status_id->AdvancedSearch->SearchValue = @$filter["x_bus_status_id"];
        $this->bus_status_id->AdvancedSearch->SearchOperator = @$filter["z_bus_status_id"];
        $this->bus_status_id->AdvancedSearch->SearchCondition = @$filter["v_bus_status_id"];
        $this->bus_status_id->AdvancedSearch->SearchValue2 = @$filter["y_bus_status_id"];
        $this->bus_status_id->AdvancedSearch->SearchOperator2 = @$filter["w_bus_status_id"];
        $this->bus_status_id->AdvancedSearch->save();

        // Field bus_size_id
        $this->bus_size_id->AdvancedSearch->SearchValue = @$filter["x_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchOperator = @$filter["z_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchCondition = @$filter["v_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchValue2 = @$filter["y_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchOperator2 = @$filter["w_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->save();

        // Field bus_depot_id
        $this->bus_depot_id->AdvancedSearch->SearchValue = @$filter["x_bus_depot_id"];
        $this->bus_depot_id->AdvancedSearch->SearchOperator = @$filter["z_bus_depot_id"];
        $this->bus_depot_id->AdvancedSearch->SearchCondition = @$filter["v_bus_depot_id"];
        $this->bus_depot_id->AdvancedSearch->SearchValue2 = @$filter["y_bus_depot_id"];
        $this->bus_depot_id->AdvancedSearch->SearchOperator2 = @$filter["w_bus_depot_id"];
        $this->bus_depot_id->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->number, $arKeywords, $type);
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

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id); // id
            $this->updateSort($this->number); // number
            $this->updateSort($this->platform_id); // platform_id
            $this->updateSort($this->operator_id); // operator_id
            $this->updateSort($this->exterior_campaign_id); // exterior_campaign_id
            $this->updateSort($this->interior_campaign_id); // interior_campaign_id
            $this->updateSort($this->bus_status_id); // bus_status_id
            $this->updateSort($this->bus_size_id); // bus_size_id
            $this->updateSort($this->bus_depot_id); // bus_depot_id
            $this->updateSort($this->ts_last_update); // ts_last_update
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "\"number\" ASC,\"id\" ASC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->number->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($this->id->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->number->setSort("ASC");
                    $this->id->setSort("ASC");
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
                        $this->bus_status_id->setSessionValue("");
                        $this->bus_size_id->setSessionValue("");
                        $this->bus_depot_id->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->id->setSort("");
                $this->number->setSort("");
                $this->platform_id->setSort("");
                $this->operator_id->setSort("");
                $this->exterior_campaign_id->setSort("");
                $this->interior_campaign_id->setSort("");
                $this->bus_status_id->setSort("");
                $this->bus_size_id->setSort("");
                $this->bus_depot_id->setSort("");
                $this->ts_created->setSort("");
                $this->ts_last_update->setSort("");
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

        // "detail_sub_media_allocation"
        $item = &$this->ListOptions->add("detail_sub_media_allocation");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sub_media_allocation') && !$this->ShowMultipleDetails;
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
        $pages->add("sub_media_allocation");
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
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
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

        // "detail_sub_media_allocation"
        $opt = $this->ListOptions["detail_sub_media_allocation"];
        if ($Security->allowList(CurrentProjectID() . 'sub_media_allocation')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("sub_media_allocation", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("submediaallocationlist?" . Config("TABLE_SHOW_MASTER") . "=main_buses&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("SubMediaAllocationGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'main_buses')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sub_media_allocation");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sub_media_allocation";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'main_buses')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sub_media_allocation");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sub_media_allocation";
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
                $item = &$option->add("detailadd_sub_media_allocation");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sub_media_allocation");
                $detailPage = Container("SubMediaAllocationGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'main_buses') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "sub_media_allocation";
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
        $item->Body = "<a class=\"ew-action ew-multi-update\" title=\"" . HtmlTitle($Language->phrase("UpdateSelectedLink")) . "\" data-table=\"main_buses\" data-caption=\"" . HtmlTitle($Language->phrase("UpdateSelectedLink")) . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'UpdateBtn',f:document.fmain_buseslist,url:'" . GetUrl($this->MultiUpdateUrl) . "'});return false;\">" . $Language->phrase("UpdateSelectedLink") . "</a>";
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fmain_buseslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fmain_buseslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                    $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fmain_buseslist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
                $item->Body = "<a class=\"ew-action ew-grid-insert\" title=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" href=\"#\" onclick=\"ew.forms.get(this).submit(event, '" . $this->pageName() . "'); return false;\">" . $Language->phrase("GridInsertLink") . "</a>";
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
                    $item->Body = "<a class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" href=\"#\" onclick=\"ew.forms.get(this).submit(event, '" . $this->pageName() . "'); return false;\">" . $Language->phrase("GridSaveLink") . "</a>";
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
        $this->number->CurrentValue = null;
        $this->number->OldValue = $this->number->CurrentValue;
        $this->platform_id->CurrentValue = null;
        $this->platform_id->OldValue = $this->platform_id->CurrentValue;
        $this->operator_id->CurrentValue = null;
        $this->operator_id->OldValue = $this->operator_id->CurrentValue;
        $this->exterior_campaign_id->CurrentValue = null;
        $this->exterior_campaign_id->OldValue = $this->exterior_campaign_id->CurrentValue;
        $this->interior_campaign_id->CurrentValue = null;
        $this->interior_campaign_id->OldValue = $this->interior_campaign_id->CurrentValue;
        $this->bus_status_id->CurrentValue = 1;
        $this->bus_status_id->OldValue = $this->bus_status_id->CurrentValue;
        $this->bus_size_id->CurrentValue = null;
        $this->bus_size_id->OldValue = $this->bus_size_id->CurrentValue;
        $this->bus_depot_id->CurrentValue = null;
        $this->bus_depot_id->OldValue = $this->bus_depot_id->CurrentValue;
        $this->ts_created->CurrentValue = null;
        $this->ts_created->OldValue = $this->ts_created->CurrentValue;
        $this->ts_last_update->CurrentValue = null;
        $this->ts_last_update->OldValue = $this->ts_last_update->CurrentValue;
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

        // Check field name 'number' first before field var 'x_number'
        $val = $CurrentForm->hasValue("number") ? $CurrentForm->getValue("number") : $CurrentForm->getValue("x_number");
        if (!$this->number->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->number->Visible = false; // Disable update for API request
            } else {
                $this->number->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_number")) {
            $this->number->setOldValue($CurrentForm->getValue("o_number"));
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
        if ($CurrentForm->hasValue("o_platform_id")) {
            $this->platform_id->setOldValue($CurrentForm->getValue("o_platform_id"));
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

        // Check field name 'exterior_campaign_id' first before field var 'x_exterior_campaign_id'
        $val = $CurrentForm->hasValue("exterior_campaign_id") ? $CurrentForm->getValue("exterior_campaign_id") : $CurrentForm->getValue("x_exterior_campaign_id");
        if (!$this->exterior_campaign_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->exterior_campaign_id->Visible = false; // Disable update for API request
            } else {
                $this->exterior_campaign_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_exterior_campaign_id")) {
            $this->exterior_campaign_id->setOldValue($CurrentForm->getValue("o_exterior_campaign_id"));
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
        if ($CurrentForm->hasValue("o_interior_campaign_id")) {
            $this->interior_campaign_id->setOldValue($CurrentForm->getValue("o_interior_campaign_id"));
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
        if ($CurrentForm->hasValue("o_bus_status_id")) {
            $this->bus_status_id->setOldValue($CurrentForm->getValue("o_bus_status_id"));
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
        if ($CurrentForm->hasValue("o_bus_size_id")) {
            $this->bus_size_id->setOldValue($CurrentForm->getValue("o_bus_size_id"));
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
        if ($CurrentForm->hasValue("o_bus_depot_id")) {
            $this->bus_depot_id->setOldValue($CurrentForm->getValue("o_bus_depot_id"));
        }

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
        if ($CurrentForm->hasValue("o_ts_last_update")) {
            $this->ts_last_update->setOldValue($CurrentForm->getValue("o_ts_last_update"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
        $this->number->CurrentValue = $this->number->FormValue;
        $this->platform_id->CurrentValue = $this->platform_id->FormValue;
        $this->operator_id->CurrentValue = $this->operator_id->FormValue;
        $this->exterior_campaign_id->CurrentValue = $this->exterior_campaign_id->FormValue;
        $this->interior_campaign_id->CurrentValue = $this->interior_campaign_id->FormValue;
        $this->bus_status_id->CurrentValue = $this->bus_status_id->FormValue;
        $this->bus_size_id->CurrentValue = $this->bus_size_id->FormValue;
        $this->bus_depot_id->CurrentValue = $this->bus_depot_id->FormValue;
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
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['number'] = $this->number->CurrentValue;
        $row['platform_id'] = $this->platform_id->CurrentValue;
        $row['operator_id'] = $this->operator_id->CurrentValue;
        $row['exterior_campaign_id'] = $this->exterior_campaign_id->CurrentValue;
        $row['interior_campaign_id'] = $this->interior_campaign_id->CurrentValue;
        $row['bus_status_id'] = $this->bus_status_id->CurrentValue;
        $row['bus_size_id'] = $this->bus_size_id->CurrentValue;
        $row['bus_depot_id'] = $this->bus_depot_id->CurrentValue;
        $row['ts_created'] = $this->ts_created->CurrentValue;
        $row['ts_last_update'] = $this->ts_last_update->CurrentValue;
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

        // number

        // platform_id
        $this->platform_id->CellCssStyle = "white-space: nowrap;";

        // operator_id
        $this->operator_id->CellCssStyle = "white-space: nowrap;";

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
            if (!$this->isExport()) {
                $this->number->ViewValue = $this->highlightValue($this->number);
            }

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

            // ts_last_update
            $this->ts_last_update->LinkCustomAttributes = "";
            $this->ts_last_update->HrefValue = "";
            $this->ts_last_update->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id

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
                $this->bus_status_id->OldValue = $this->bus_status_id->CurrentValue;
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
                $this->bus_size_id->OldValue = $this->bus_size_id->CurrentValue;
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
                $this->bus_depot_id->OldValue = $this->bus_depot_id->CurrentValue;
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

            // ts_last_update
            $this->ts_last_update->EditAttrs["class"] = "form-control";
            $this->ts_last_update->EditCustomAttributes = "";
            $this->ts_last_update->EditValue = HtmlEncode(FormatDateTime($this->ts_last_update->CurrentValue, 8));
            $this->ts_last_update->PlaceHolder = RemoveHtml($this->ts_last_update->caption());

            // Add refer script

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

            // ts_last_update
            $this->ts_last_update->LinkCustomAttributes = "";
            $this->ts_last_update->HrefValue = "";
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
                $this->bus_status_id->OldValue = $this->bus_status_id->CurrentValue;
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
                $this->bus_size_id->OldValue = $this->bus_size_id->CurrentValue;
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
                $this->bus_depot_id->OldValue = $this->bus_depot_id->CurrentValue;
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

            // ts_last_update
            $this->ts_last_update->EditAttrs["class"] = "form-control";
            $this->ts_last_update->EditCustomAttributes = "";
            $this->ts_last_update->EditValue = HtmlEncode(FormatDateTime($this->ts_last_update->CurrentValue, 8));
            $this->ts_last_update->PlaceHolder = RemoveHtml($this->ts_last_update->caption());

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
        if ($this->ts_last_update->Required) {
            if (!$this->ts_last_update->IsDetailKey && EmptyValue($this->ts_last_update->FormValue)) {
                $this->ts_last_update->addErrorMessage(str_replace("%s", $this->ts_last_update->caption(), $this->ts_last_update->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ts_last_update->FormValue)) {
            $this->ts_last_update->addErrorMessage($this->ts_last_update->getErrorMessage(false));
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

            // ts_last_update
            $this->ts_last_update->setDbValueDef($rsnew, UnFormatDateTime($this->ts_last_update->CurrentValue, 1), CurrentDate(), $this->ts_last_update->ReadOnly);

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

    /**
     * Import file
     *
     * @param string $filetoken File token to locate the uploaded import file
     * @return bool
     */
    public function import($filetoken)
    {
        global $Security, $Language;
        if (!$Security->canImport()) {
            return false; // Import not allowed
        }

        // Check if valid token
        if (EmptyValue($filetoken)) {
            return false;
        }

        // Get uploaded files by token
        $files = GetUploadedFileNames($filetoken);
        $exts = explode(",", Config("IMPORT_FILE_ALLOWED_EXT"));
        $totCnt = 0;
        $totSuccessCnt = 0;
        $totFailCnt = 0;
        $result = [Config("API_FILE_TOKEN_NAME") => $filetoken, "files" => [], "success" => false];

        // Import records
        foreach ($files as $file) {
            $res = [Config("API_FILE_TOKEN_NAME") => $filetoken, "file" => basename($file)];
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            // Ignore log file
            if ($ext == "txt") {
                continue;
            }
            if (!in_array($ext, $exts)) {
                $res = array_merge($res, ["error" => str_replace("%e", $ext, $Language->phrase("ImportMessageInvalidFileExtension"))]);
                WriteJson($res);
                return false;
            }

            // Set up options for Page Importing event

            // Get optional data from $_POST first
            $ar = array_keys($_POST);
            $options = [];
            foreach ($ar as $key) {
                if (!in_array($key, ["action", "filetoken"])) {
                    $options[$key] = $_POST[$key];
                }
            }

            // Merge default options
            $options = array_merge(["maxExecutionTime" => $this->ImportMaxExecutionTime, "file" => $file, "activeSheet" => 0, "headerRowNumber" => 0, "headers" => [], "offset" => 0, "limit" => 0], $options);
            if ($ext == "csv") {
                $options = array_merge(["inputEncoding" => $this->ImportCsvEncoding, "delimiter" => $this->ImportCsvDelimiter, "enclosure" => $this->ImportCsvQuoteCharacter], $options);
            }
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst($ext));

            // Call Page Importing server event
            if (!$this->pageImporting($reader, $options)) {
                WriteJson($res);
                return false;
            }

            // Set max execution time
            if ($options["maxExecutionTime"] > 0) {
                ini_set("max_execution_time", $options["maxExecutionTime"]);
            }
            try {
                if ($ext == "csv") {
                    if ($options["inputEncoding"] != '') {
                        $reader->setInputEncoding($options["inputEncoding"]);
                    }
                    if ($options["delimiter"] != '') {
                        $reader->setDelimiter($options["delimiter"]);
                    }
                    if ($options["enclosure"] != '') {
                        $reader->setEnclosure($options["enclosure"]);
                    }
                }
                $spreadsheet = @$reader->load($file);
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $res = array_merge($res, ["error" => $e->getMessage()]);
                WriteJson($res);
                return false;
            }

            // Get active worksheet
            $spreadsheet->setActiveSheetIndex($options["activeSheet"]);
            $worksheet = $spreadsheet->getActiveSheet();

            // Get row and column indexes
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            // Get column headers
            $headers = $options["headers"];
            $headerRow = 0;
            if (count($headers) == 0) { // Undetermined, load from header row
                $headerRow = $options["headerRowNumber"] + 1;
                $headers = $this->getImportHeaders($worksheet, $headerRow, $highestColumn);
            }
            if (count($headers) == 0) { // Unable to load header
                $res["error"] = $Language->phrase("ImportMessageNoHeaderRow");
                WriteJson($res);
                return false;
            }
            $checkValue = true; // Clear blank header values at end
            $headers = array_reverse(array_reduce(array_reverse($headers), function ($res, $name) use ($checkValue) {
                if (!EmptyValue($name) || !$checkValue) {
                    $res[] = $name;
                    $checkValue = false; // Skip further checking
                }
                return $res;
            }, []));
            foreach ($headers as $name) {
                if (!array_key_exists($name, $this->Fields)) { // Unidentified field, not header row
                    $res["error"] = str_replace('%f', $name, $Language->phrase("ImportMessageInvalidFieldName"));
                    WriteJson($res);
                    return false;
                }
            }
            $startRow = $headerRow + 1;
            $endRow = $highestRow;
            if ($options["offset"] > 0) {
                $startRow += $options["offset"];
            }
            if ($options["limit"] > 0) {
                $endRow = $startRow + $options["limit"] - 1;
                if ($endRow > $highestRow) {
                    $endRow = $highestRow;
                }
            }
            if ($endRow >= $startRow) {
                $records = $this->getImportRecords($worksheet, $startRow, $endRow, $highestColumn);
            } else {
                $records = [];
            }
            $recordCnt = count($records);
            $cnt = 0;
            $successCnt = 0;
            $failCnt = 0;
            $failList = [];
            $relLogFile = IncludeTrailingDelimiter(UploadPath(false) . Config("UPLOAD_TEMP_FOLDER_PREFIX") . $filetoken, false) . $filetoken . ".txt";
            $res = array_merge($res, ["totalCount" => $recordCnt, "count" => $cnt, "successCount" => $successCnt, "failCount" => 0]);

            // Begin transaction
            if ($this->ImportUseTransaction) {
                $conn = $this->getConnection();
                $conn->beginTransaction();
            }

            // Process records
            foreach ($records as $values) {
                $importSuccess = false;
                try {
                    if (count($values) > count($headers)) { // Make sure headers / values count matched
                        array_splice($values, count($headers));
                    }
                    $row = array_combine($headers, $values);
                    $cnt++;
                    $res["count"] = $cnt;
                    if ($this->importRow($row, $cnt)) {
                        $successCnt++;
                        $importSuccess = true;
                    } else {
                        $failCnt++;
                        $failList["row" . $cnt] = $this->getFailureMessage();
                        $this->clearFailureMessage(); // Clear error message
                    }
                } catch (\Throwable $e) {
                    $failCnt++;
                    if ($failList["row" . $cnt] == "") {
                        $failList["row" . $cnt] = $e->getMessage();
                    }
                }

                // Reset count if import fail + use transaction
                if (!$importSuccess && $this->ImportUseTransaction) {
                    $successCnt = 0;
                    $failCnt = $cnt;
                }

                // Save progress to cache
                $res["successCount"] = $successCnt;
                $res["failCount"] = $failCnt;
                SetCache($filetoken, $res);

                // No need to process further if import fail + use transaction
                if (!$importSuccess && $this->ImportUseTransaction) {
                    break;
                }
            }
            $res["failList"] = $failList;

            // Commit/Rollback transaction
            if ($this->ImportUseTransaction) {
                $conn = $this->getConnection();
                if ($failCnt > 0) { // Rollback
                    $conn->rollback();
                } else { // Commit
                    $conn->commit();
                }
            }
            $totCnt += $cnt;
            $totSuccessCnt += $successCnt;
            $totFailCnt += $failCnt;

            // Call Page Imported server event
            $this->pageImported($reader, $res);
            if ($totCnt > 0 && $totFailCnt == 0) { // Clean up if all records imported
                $res["success"] = true;
                $result["success"] = true;
            } else {
                $res["log"] = $relLogFile;
                $result["success"] = false;
            }
            $result["files"][] = $res;
        }
        if ($result["success"]) {
            CleanUploadTempPaths($filetoken);
        }
        WriteJson($result);
        return $result["success"];
    }

    /**
     * Get import header
     *
     * @param object $ws PhpSpreadsheet worksheet
     * @param int $rowIdx Row index for header row (1-based)
     * @param string $endColName End column Name (e.g. "F")
     * @return array
     */
    protected function getImportHeaders($ws, $rowIdx, $endColName)
    {
        $ar = $ws->rangeToArray("A" . $rowIdx . ":" . $endColName . $rowIdx);
        return $ar[0];
    }

    /**
     * Get import records
     *
     * @param object $ws PhpSpreadsheet worksheet
     * @param int $startRowIdx Start row index
     * @param int $endRowIdx End row index
     * @param string $endColName End column Name (e.g. "F")
     * @return array
     */
    protected function getImportRecords($ws, $startRowIdx, $endRowIdx, $endColName)
    {
        $ar = $ws->rangeToArray("A" . $startRowIdx . ":" . $endColName . $endRowIdx);
        return $ar;
    }

    /**
     * Import a row
     *
     * @param array $row
     * @param int $cnt
     * @return bool
     */
    protected function importRow($row, $cnt)
    {
        global $Language;

        // Call Row Import server event
        if (!$this->rowImport($row, $cnt)) {
            return false;
        }

        // Check field values
        foreach ($row as $name => $value) {
            $fld = $this->Fields[$name];
            if (!$this->checkValue($fld, $value)) {
                $this->setFailureMessage(str_replace(["%f", "%v"], [$fld->Name, $value], $Language->phrase("ImportMessageInvalidFieldValue")));
                return false;
            }
        }

        // Insert/Update to database
        if (!$this->ImportInsertOnly && $oldrow = $this->load($row)) {
            $res = $this->update($row, "", $oldrow);
        } else {
            $res = $this->insert($row);
        }
        return $res;
    }

    /**
     * Check field value
     *
     * @param object $fld Field object
     * @param object $value
     * @return bool
     */
    protected function checkValue($fld, $value)
    {
        if ($fld->DataType == DATATYPE_NUMBER && !is_numeric($value)) {
            return false;
        } elseif ($fld->DataType == DATATYPE_DATE && !CheckDate($value)) {
            return false;
        }
        return true;
    }

    // Load row
    protected function load($row)
    {
        $filter = $this->getRecordFilter($row);
        if (!$filter) {
            return null;
        }
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        return $conn->fetchAssoc($sql);
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
        $hash .= GetFieldHash($row['number']); // number
        $hash .= GetFieldHash($row['platform_id']); // platform_id
        $hash .= GetFieldHash($row['operator_id']); // operator_id
        $hash .= GetFieldHash($row['exterior_campaign_id']); // exterior_campaign_id
        $hash .= GetFieldHash($row['interior_campaign_id']); // interior_campaign_id
        $hash .= GetFieldHash($row['bus_status_id']); // bus_status_id
        $hash .= GetFieldHash($row['bus_size_id']); // bus_size_id
        $hash .= GetFieldHash($row['bus_depot_id']); // bus_depot_id
        $hash .= GetFieldHash($row['ts_last_update']); // ts_last_update
        return md5($hash);
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        if ($this->number->CurrentValue != "") { // Check field with unique index
            $filter = "(\"number\" = '" . AdjustSql($this->number->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->number->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->number->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // number
        $this->number->setDbValueDef($rsnew, $this->number->CurrentValue, "", false);

        // platform_id
        $this->platform_id->setDbValueDef($rsnew, $this->platform_id->CurrentValue, null, false);

        // operator_id
        $this->operator_id->setDbValueDef($rsnew, $this->operator_id->CurrentValue, null, false);

        // exterior_campaign_id
        $this->exterior_campaign_id->setDbValueDef($rsnew, $this->exterior_campaign_id->CurrentValue, null, false);

        // interior_campaign_id
        $this->interior_campaign_id->setDbValueDef($rsnew, $this->interior_campaign_id->CurrentValue, null, false);

        // bus_status_id
        $this->bus_status_id->setDbValueDef($rsnew, $this->bus_status_id->CurrentValue, 0, strval($this->bus_status_id->CurrentValue) == "");

        // bus_size_id
        $this->bus_size_id->setDbValueDef($rsnew, $this->bus_size_id->CurrentValue, null, false);

        // bus_depot_id
        $this->bus_depot_id->setDbValueDef($rsnew, $this->bus_depot_id->CurrentValue, null, false);

        // ts_last_update
        $this->ts_last_update->setDbValueDef($rsnew, UnFormatDateTime($this->ts_last_update->CurrentValue, 1), CurrentDate(), false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
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

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fmain_buseslist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fmain_buseslist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fmain_buseslist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
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
            return '<button id="emf_main_buses" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_main_buses\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fmain_buseslist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
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

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fmain_buseslistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Search highlight button
        $item = &$this->SearchOptions->add("searchhighlight");
        $item->Body = "<a class=\"btn btn-default ew-highlight active\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("Highlight") . "\" data-caption=\"" . $Language->phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"fmain_buseslistsrch\" data-name=\"" . $this->highlightName() . "\">" . $Language->phrase("HighlightBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != "" && $this->TotalRecords > 0);

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

    // Set up import options
    protected function setupImportOptions()
    {
        global $Security, $Language;

        // Import
        $item = &$this->ImportOptions->add("import");
        $item->Body = "<a class=\"ew-import-link ew-import\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("ImportText") . "\" data-caption=\"" . $Language->phrase("ImportText") . "\" onclick=\"return ew.importDialogShow({lnk:this,hdr:ew.language.phrase('ImportText')});\">" . $Language->phrase("Import") . "</a>";
        $item->Visible = $Security->canImport();
        $this->ImportOptions->UseButtonGroup = true;
        $this->ImportOptions->UseDropDownButton = false;
        $this->ImportOptions->DropDownButtonPhrase = $Language->phrase("ButtonImport");

        // Add group option item
        $item = &$this->ImportOptions->add($this->ImportOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
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
            if (Config("EXPORT_ALL_TIME_LIMIT") >= 0) {
                @set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            }
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
        if (Config("EXPORT_MASTER_RECORD") && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "x_bus_status") {
            $x_bus_status = Container("x_bus_status");
            $rsmaster = $x_bus_status->loadRs($this->DbMasterFilter); // Load master record
            if ($rsmaster) {
                $exportStyle = $doc->Style;
                $doc->setStyle("v"); // Change to vertical
                if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
                    $doc->Table = $x_bus_status;
                    $x_bus_status->exportDocument($doc, new Recordset($rsmaster));
                    $doc->exportEmptyRow();
                    $doc->Table = &$this;
                }
                $doc->setStyle($exportStyle); // Restore
                $rsmaster->closeCursor();
            }
        }

        // Export master record
        if (Config("EXPORT_MASTER_RECORD") && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "x_bus_sizes") {
            $x_bus_sizes = Container("x_bus_sizes");
            $rsmaster = $x_bus_sizes->loadRs($this->DbMasterFilter); // Load master record
            if ($rsmaster) {
                $exportStyle = $doc->Style;
                $doc->setStyle("v"); // Change to vertical
                if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
                    $doc->Table = $x_bus_sizes;
                    $x_bus_sizes->exportDocument($doc, new Recordset($rsmaster));
                    $doc->exportEmptyRow();
                    $doc->Table = &$this;
                }
                $doc->setStyle($exportStyle); // Restore
                $rsmaster->closeCursor();
            }
        }

        // Export master record
        if (Config("EXPORT_MASTER_RECORD") && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "x_bus_depot") {
            $x_bus_depot = Container("x_bus_depot");
            $rsmaster = $x_bus_depot->loadRs($this->DbMasterFilter); // Load master record
            if ($rsmaster) {
                $exportStyle = $doc->Style;
                $doc->setStyle("v"); // Change to vertical
                if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
                    $doc->Table = $x_bus_depot;
                    $x_bus_depot->exportDocument($doc, new Recordset($rsmaster));
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

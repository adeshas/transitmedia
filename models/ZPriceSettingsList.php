<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ZPriceSettingsList extends ZPriceSettings
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'z_price_settings';

    // Page object name
    public $PageObjName = "ZPriceSettingsList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fz_price_settingslist";
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

        // Table object (z_price_settings)
        if (!isset($GLOBALS["z_price_settings"]) || get_class($GLOBALS["z_price_settings"]) == PROJECT_NAMESPACE . "z_price_settings") {
            $GLOBALS["z_price_settings"] = &$this;
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
        $this->AddUrl = "ZPriceSettingsAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "ZPriceSettingsDelete";
        $this->MultiUpdateUrl = "ZPriceSettingsUpdate";

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
        $this->FilterOptions->TagClassName = "ew-filter-option fz_price_settingslistsrch";

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
        $this->setupLookupOptions($this->platform_id);
        $this->setupLookupOptions($this->inventory_id);
        $this->setupLookupOptions($this->print_stage_id);
        $this->setupLookupOptions($this->bus_size_id);

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
        if ($CurrentForm->hasValue("x_platform_id") && $CurrentForm->hasValue("o_platform_id") && $this->platform_id->CurrentValue != $this->platform_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_inventory_id") && $CurrentForm->hasValue("o_inventory_id") && $this->inventory_id->CurrentValue != $this->inventory_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_print_stage_id") && $CurrentForm->hasValue("o_print_stage_id") && $this->print_stage_id->CurrentValue != $this->print_stage_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_bus_size_id") && $CurrentForm->hasValue("o_bus_size_id") && $this->bus_size_id->CurrentValue != $this->bus_size_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_details") && $CurrentForm->hasValue("o_details") && $this->details->CurrentValue != $this->details->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_max_limit") && $CurrentForm->hasValue("o_max_limit") && $this->max_limit->CurrentValue != $this->max_limit->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_min_limit") && $CurrentForm->hasValue("o_min_limit") && $this->min_limit->CurrentValue != $this->min_limit->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_price") && $CurrentForm->hasValue("o_price") && $this->price->CurrentValue != $this->price->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_operator_fee") && $CurrentForm->hasValue("o_operator_fee") && $this->operator_fee->CurrentValue != $this->operator_fee->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_agency_fee") && $CurrentForm->hasValue("o_agency_fee") && $this->agency_fee->CurrentValue != $this->agency_fee->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lamata_fee") && $CurrentForm->hasValue("o_lamata_fee") && $this->lamata_fee->CurrentValue != $this->lamata_fee->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lasaa_fee") && $CurrentForm->hasValue("o_lasaa_fee") && $this->lasaa_fee->CurrentValue != $this->lasaa_fee->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_printers_fee") && $CurrentForm->hasValue("o_printers_fee") && $this->printers_fee->CurrentValue != $this->printers_fee->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_active") && $CurrentForm->hasValue("o_active") && ConvertToBool($this->active->CurrentValue) != ConvertToBool($this->active->OldValue)) {
            return false;
        }
        if ($CurrentForm->hasValue("x_ts_created") && $CurrentForm->hasValue("o_ts_created") && $this->ts_created->CurrentValue != $this->ts_created->OldValue) {
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
        $this->platform_id->clearErrorMessage();
        $this->inventory_id->clearErrorMessage();
        $this->print_stage_id->clearErrorMessage();
        $this->bus_size_id->clearErrorMessage();
        $this->details->clearErrorMessage();
        $this->max_limit->clearErrorMessage();
        $this->min_limit->clearErrorMessage();
        $this->price->clearErrorMessage();
        $this->operator_fee->clearErrorMessage();
        $this->agency_fee->clearErrorMessage();
        $this->lamata_fee->clearErrorMessage();
        $this->lasaa_fee->clearErrorMessage();
        $this->printers_fee->clearErrorMessage();
        $this->active->clearErrorMessage();
        $this->ts_created->clearErrorMessage();
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->platform_id->AdvancedSearch->toJson(), ","); // Field platform_id
        $filterList = Concat($filterList, $this->inventory_id->AdvancedSearch->toJson(), ","); // Field inventory_id
        $filterList = Concat($filterList, $this->print_stage_id->AdvancedSearch->toJson(), ","); // Field print_stage_id
        $filterList = Concat($filterList, $this->bus_size_id->AdvancedSearch->toJson(), ","); // Field bus_size_id
        $filterList = Concat($filterList, $this->details->AdvancedSearch->toJson(), ","); // Field details
        $filterList = Concat($filterList, $this->max_limit->AdvancedSearch->toJson(), ","); // Field max_limit
        $filterList = Concat($filterList, $this->min_limit->AdvancedSearch->toJson(), ","); // Field min_limit
        $filterList = Concat($filterList, $this->price->AdvancedSearch->toJson(), ","); // Field price
        $filterList = Concat($filterList, $this->operator_fee->AdvancedSearch->toJson(), ","); // Field operator_fee
        $filterList = Concat($filterList, $this->agency_fee->AdvancedSearch->toJson(), ","); // Field agency_fee
        $filterList = Concat($filterList, $this->lamata_fee->AdvancedSearch->toJson(), ","); // Field lamata_fee
        $filterList = Concat($filterList, $this->lasaa_fee->AdvancedSearch->toJson(), ","); // Field lasaa_fee
        $filterList = Concat($filterList, $this->printers_fee->AdvancedSearch->toJson(), ","); // Field printers_fee
        $filterList = Concat($filterList, $this->active->AdvancedSearch->toJson(), ","); // Field active
        $filterList = Concat($filterList, $this->ts_created->AdvancedSearch->toJson(), ","); // Field ts_created
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fz_price_settingslistsrch", $filters);
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

        // Field platform_id
        $this->platform_id->AdvancedSearch->SearchValue = @$filter["x_platform_id"];
        $this->platform_id->AdvancedSearch->SearchOperator = @$filter["z_platform_id"];
        $this->platform_id->AdvancedSearch->SearchCondition = @$filter["v_platform_id"];
        $this->platform_id->AdvancedSearch->SearchValue2 = @$filter["y_platform_id"];
        $this->platform_id->AdvancedSearch->SearchOperator2 = @$filter["w_platform_id"];
        $this->platform_id->AdvancedSearch->save();

        // Field inventory_id
        $this->inventory_id->AdvancedSearch->SearchValue = @$filter["x_inventory_id"];
        $this->inventory_id->AdvancedSearch->SearchOperator = @$filter["z_inventory_id"];
        $this->inventory_id->AdvancedSearch->SearchCondition = @$filter["v_inventory_id"];
        $this->inventory_id->AdvancedSearch->SearchValue2 = @$filter["y_inventory_id"];
        $this->inventory_id->AdvancedSearch->SearchOperator2 = @$filter["w_inventory_id"];
        $this->inventory_id->AdvancedSearch->save();

        // Field print_stage_id
        $this->print_stage_id->AdvancedSearch->SearchValue = @$filter["x_print_stage_id"];
        $this->print_stage_id->AdvancedSearch->SearchOperator = @$filter["z_print_stage_id"];
        $this->print_stage_id->AdvancedSearch->SearchCondition = @$filter["v_print_stage_id"];
        $this->print_stage_id->AdvancedSearch->SearchValue2 = @$filter["y_print_stage_id"];
        $this->print_stage_id->AdvancedSearch->SearchOperator2 = @$filter["w_print_stage_id"];
        $this->print_stage_id->AdvancedSearch->save();

        // Field bus_size_id
        $this->bus_size_id->AdvancedSearch->SearchValue = @$filter["x_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchOperator = @$filter["z_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchCondition = @$filter["v_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchValue2 = @$filter["y_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->SearchOperator2 = @$filter["w_bus_size_id"];
        $this->bus_size_id->AdvancedSearch->save();

        // Field details
        $this->details->AdvancedSearch->SearchValue = @$filter["x_details"];
        $this->details->AdvancedSearch->SearchOperator = @$filter["z_details"];
        $this->details->AdvancedSearch->SearchCondition = @$filter["v_details"];
        $this->details->AdvancedSearch->SearchValue2 = @$filter["y_details"];
        $this->details->AdvancedSearch->SearchOperator2 = @$filter["w_details"];
        $this->details->AdvancedSearch->save();

        // Field max_limit
        $this->max_limit->AdvancedSearch->SearchValue = @$filter["x_max_limit"];
        $this->max_limit->AdvancedSearch->SearchOperator = @$filter["z_max_limit"];
        $this->max_limit->AdvancedSearch->SearchCondition = @$filter["v_max_limit"];
        $this->max_limit->AdvancedSearch->SearchValue2 = @$filter["y_max_limit"];
        $this->max_limit->AdvancedSearch->SearchOperator2 = @$filter["w_max_limit"];
        $this->max_limit->AdvancedSearch->save();

        // Field min_limit
        $this->min_limit->AdvancedSearch->SearchValue = @$filter["x_min_limit"];
        $this->min_limit->AdvancedSearch->SearchOperator = @$filter["z_min_limit"];
        $this->min_limit->AdvancedSearch->SearchCondition = @$filter["v_min_limit"];
        $this->min_limit->AdvancedSearch->SearchValue2 = @$filter["y_min_limit"];
        $this->min_limit->AdvancedSearch->SearchOperator2 = @$filter["w_min_limit"];
        $this->min_limit->AdvancedSearch->save();

        // Field price
        $this->price->AdvancedSearch->SearchValue = @$filter["x_price"];
        $this->price->AdvancedSearch->SearchOperator = @$filter["z_price"];
        $this->price->AdvancedSearch->SearchCondition = @$filter["v_price"];
        $this->price->AdvancedSearch->SearchValue2 = @$filter["y_price"];
        $this->price->AdvancedSearch->SearchOperator2 = @$filter["w_price"];
        $this->price->AdvancedSearch->save();

        // Field operator_fee
        $this->operator_fee->AdvancedSearch->SearchValue = @$filter["x_operator_fee"];
        $this->operator_fee->AdvancedSearch->SearchOperator = @$filter["z_operator_fee"];
        $this->operator_fee->AdvancedSearch->SearchCondition = @$filter["v_operator_fee"];
        $this->operator_fee->AdvancedSearch->SearchValue2 = @$filter["y_operator_fee"];
        $this->operator_fee->AdvancedSearch->SearchOperator2 = @$filter["w_operator_fee"];
        $this->operator_fee->AdvancedSearch->save();

        // Field agency_fee
        $this->agency_fee->AdvancedSearch->SearchValue = @$filter["x_agency_fee"];
        $this->agency_fee->AdvancedSearch->SearchOperator = @$filter["z_agency_fee"];
        $this->agency_fee->AdvancedSearch->SearchCondition = @$filter["v_agency_fee"];
        $this->agency_fee->AdvancedSearch->SearchValue2 = @$filter["y_agency_fee"];
        $this->agency_fee->AdvancedSearch->SearchOperator2 = @$filter["w_agency_fee"];
        $this->agency_fee->AdvancedSearch->save();

        // Field lamata_fee
        $this->lamata_fee->AdvancedSearch->SearchValue = @$filter["x_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->SearchOperator = @$filter["z_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->SearchCondition = @$filter["v_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->SearchValue2 = @$filter["y_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->SearchOperator2 = @$filter["w_lamata_fee"];
        $this->lamata_fee->AdvancedSearch->save();

        // Field lasaa_fee
        $this->lasaa_fee->AdvancedSearch->SearchValue = @$filter["x_lasaa_fee"];
        $this->lasaa_fee->AdvancedSearch->SearchOperator = @$filter["z_lasaa_fee"];
        $this->lasaa_fee->AdvancedSearch->SearchCondition = @$filter["v_lasaa_fee"];
        $this->lasaa_fee->AdvancedSearch->SearchValue2 = @$filter["y_lasaa_fee"];
        $this->lasaa_fee->AdvancedSearch->SearchOperator2 = @$filter["w_lasaa_fee"];
        $this->lasaa_fee->AdvancedSearch->save();

        // Field printers_fee
        $this->printers_fee->AdvancedSearch->SearchValue = @$filter["x_printers_fee"];
        $this->printers_fee->AdvancedSearch->SearchOperator = @$filter["z_printers_fee"];
        $this->printers_fee->AdvancedSearch->SearchCondition = @$filter["v_printers_fee"];
        $this->printers_fee->AdvancedSearch->SearchValue2 = @$filter["y_printers_fee"];
        $this->printers_fee->AdvancedSearch->SearchOperator2 = @$filter["w_printers_fee"];
        $this->printers_fee->AdvancedSearch->save();

        // Field active
        $this->active->AdvancedSearch->SearchValue = @$filter["x_active"];
        $this->active->AdvancedSearch->SearchOperator = @$filter["z_active"];
        $this->active->AdvancedSearch->SearchCondition = @$filter["v_active"];
        $this->active->AdvancedSearch->SearchValue2 = @$filter["y_active"];
        $this->active->AdvancedSearch->SearchOperator2 = @$filter["w_active"];
        $this->active->AdvancedSearch->save();

        // Field ts_created
        $this->ts_created->AdvancedSearch->SearchValue = @$filter["x_ts_created"];
        $this->ts_created->AdvancedSearch->SearchOperator = @$filter["z_ts_created"];
        $this->ts_created->AdvancedSearch->SearchCondition = @$filter["v_ts_created"];
        $this->ts_created->AdvancedSearch->SearchValue2 = @$filter["y_ts_created"];
        $this->ts_created->AdvancedSearch->SearchOperator2 = @$filter["w_ts_created"];
        $this->ts_created->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->platform_id, $default, false); // platform_id
        $this->buildSearchSql($where, $this->inventory_id, $default, false); // inventory_id
        $this->buildSearchSql($where, $this->print_stage_id, $default, false); // print_stage_id
        $this->buildSearchSql($where, $this->bus_size_id, $default, false); // bus_size_id
        $this->buildSearchSql($where, $this->details, $default, false); // details
        $this->buildSearchSql($where, $this->max_limit, $default, false); // max_limit
        $this->buildSearchSql($where, $this->min_limit, $default, false); // min_limit
        $this->buildSearchSql($where, $this->price, $default, false); // price
        $this->buildSearchSql($where, $this->operator_fee, $default, false); // operator_fee
        $this->buildSearchSql($where, $this->agency_fee, $default, false); // agency_fee
        $this->buildSearchSql($where, $this->lamata_fee, $default, false); // lamata_fee
        $this->buildSearchSql($where, $this->lasaa_fee, $default, false); // lasaa_fee
        $this->buildSearchSql($where, $this->printers_fee, $default, false); // printers_fee
        $this->buildSearchSql($where, $this->active, $default, false); // active
        $this->buildSearchSql($where, $this->ts_created, $default, false); // ts_created

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->id->AdvancedSearch->save(); // id
            $this->platform_id->AdvancedSearch->save(); // platform_id
            $this->inventory_id->AdvancedSearch->save(); // inventory_id
            $this->print_stage_id->AdvancedSearch->save(); // print_stage_id
            $this->bus_size_id->AdvancedSearch->save(); // bus_size_id
            $this->details->AdvancedSearch->save(); // details
            $this->max_limit->AdvancedSearch->save(); // max_limit
            $this->min_limit->AdvancedSearch->save(); // min_limit
            $this->price->AdvancedSearch->save(); // price
            $this->operator_fee->AdvancedSearch->save(); // operator_fee
            $this->agency_fee->AdvancedSearch->save(); // agency_fee
            $this->lamata_fee->AdvancedSearch->save(); // lamata_fee
            $this->lasaa_fee->AdvancedSearch->save(); // lasaa_fee
            $this->printers_fee->AdvancedSearch->save(); // printers_fee
            $this->active->AdvancedSearch->save(); // active
            $this->ts_created->AdvancedSearch->save(); // ts_created
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
        $this->buildBasicSearchSql($where, $this->details, $arKeywords, $type);
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
        if ($this->platform_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->inventory_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->print_stage_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->bus_size_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->details->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->max_limit->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->min_limit->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->operator_fee->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->agency_fee->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lamata_fee->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lasaa_fee->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->printers_fee->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->active->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ts_created->AdvancedSearch->issetSession()) {
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
                $this->platform_id->AdvancedSearch->unsetSession();
                $this->inventory_id->AdvancedSearch->unsetSession();
                $this->print_stage_id->AdvancedSearch->unsetSession();
                $this->bus_size_id->AdvancedSearch->unsetSession();
                $this->details->AdvancedSearch->unsetSession();
                $this->max_limit->AdvancedSearch->unsetSession();
                $this->min_limit->AdvancedSearch->unsetSession();
                $this->price->AdvancedSearch->unsetSession();
                $this->operator_fee->AdvancedSearch->unsetSession();
                $this->agency_fee->AdvancedSearch->unsetSession();
                $this->lamata_fee->AdvancedSearch->unsetSession();
                $this->lasaa_fee->AdvancedSearch->unsetSession();
                $this->printers_fee->AdvancedSearch->unsetSession();
                $this->active->AdvancedSearch->unsetSession();
                $this->ts_created->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
                $this->id->AdvancedSearch->load();
                $this->platform_id->AdvancedSearch->load();
                $this->inventory_id->AdvancedSearch->load();
                $this->print_stage_id->AdvancedSearch->load();
                $this->bus_size_id->AdvancedSearch->load();
                $this->details->AdvancedSearch->load();
                $this->max_limit->AdvancedSearch->load();
                $this->min_limit->AdvancedSearch->load();
                $this->price->AdvancedSearch->load();
                $this->operator_fee->AdvancedSearch->load();
                $this->agency_fee->AdvancedSearch->load();
                $this->lamata_fee->AdvancedSearch->load();
                $this->lasaa_fee->AdvancedSearch->load();
                $this->printers_fee->AdvancedSearch->load();
                $this->active->AdvancedSearch->load();
                $this->ts_created->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id); // id
            $this->updateSort($this->platform_id); // platform_id
            $this->updateSort($this->inventory_id); // inventory_id
            $this->updateSort($this->print_stage_id); // print_stage_id
            $this->updateSort($this->bus_size_id); // bus_size_id
            $this->updateSort($this->details); // details
            $this->updateSort($this->max_limit); // max_limit
            $this->updateSort($this->min_limit); // min_limit
            $this->updateSort($this->price); // price
            $this->updateSort($this->operator_fee); // operator_fee
            $this->updateSort($this->agency_fee); // agency_fee
            $this->updateSort($this->lamata_fee); // lamata_fee
            $this->updateSort($this->lasaa_fee); // lasaa_fee
            $this->updateSort($this->printers_fee); // printers_fee
            $this->updateSort($this->active); // active
            $this->updateSort($this->ts_created); // ts_created
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "\"platform_id\" ASC,\"inventory_id\" ASC,\"bus_size_id\" ASC,\"print_stage_id\" ASC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->platform_id->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($this->inventory_id->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($this->bus_size_id->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($this->print_stage_id->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->platform_id->setSort("ASC");
                    $this->inventory_id->setSort("ASC");
                    $this->bus_size_id->setSort("ASC");
                    $this->print_stage_id->setSort("ASC");
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
                $this->id->setSort("");
                $this->platform_id->setSort("");
                $this->inventory_id->setSort("");
                $this->print_stage_id->setSort("");
                $this->bus_size_id->setSort("");
                $this->details->setSort("");
                $this->max_limit->setSort("");
                $this->min_limit->setSort("");
                $this->price->setSort("");
                $this->operator_fee->setSort("");
                $this->agency_fee->setSort("");
                $this->lamata_fee->setSort("");
                $this->lasaa_fee->setSort("");
                $this->printers_fee->setSort("");
                $this->active->setSort("");
                $this->ts_created->setSort("");
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
                if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
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
                $opt->Body .= "<a class=\"ew-row-link ew-inline-edit\" title=\"" . HtmlTitle($Language->phrase("InlineEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("InlineEditLink")) . "\" href=\"" . HtmlEncode(UrlAddHash(GetUrl($this->InlineEditUrl), "r" . $this->RowCount . "_" . $this->TableVar)) . "\">" . $Language->phrase("InlineEditLink") . "</a>";
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
        $item = &$option->add("gridadd");
        $item->Body = "<a class=\"ew-add-edit ew-grid-add\" title=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridAddUrl)) . "\">" . $Language->phrase("GridAddLink") . "</a>";
        $item->Visible = $this->GridAddUrl != "" && $Security->canAdd();

        // Add grid edit
        $option = $options["addedit"];
        $item = &$option->add("gridedit");
        $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        $item->Visible = $this->GridEditUrl != "" && $Security->canEdit();
        $option = $options["action"];

        // Add multi update
        $item = &$option->add("multiupdate");
        $item->Body = "<a class=\"ew-action ew-multi-update\" title=\"" . HtmlTitle($Language->phrase("UpdateSelectedLink")) . "\" data-table=\"z_price_settings\" data-caption=\"" . HtmlTitle($Language->phrase("UpdateSelectedLink")) . "\" href=\"#\" onclick=\"return ew.submitAction(event, {f:document.fz_price_settingslist,url:'" . GetUrl($this->MultiUpdateUrl) . "'});return false;\">" . $Language->phrase("UpdateSelectedLink") . "</a>";
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fz_price_settingslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fz_price_settingslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                    $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fz_price_settingslist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
                    $item->Visible = false;
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
                    $item->Visible = false;
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
        $this->platform_id->CurrentValue = null;
        $this->platform_id->OldValue = $this->platform_id->CurrentValue;
        $this->inventory_id->CurrentValue = null;
        $this->inventory_id->OldValue = $this->inventory_id->CurrentValue;
        $this->print_stage_id->CurrentValue = null;
        $this->print_stage_id->OldValue = $this->print_stage_id->CurrentValue;
        $this->bus_size_id->CurrentValue = null;
        $this->bus_size_id->OldValue = $this->bus_size_id->CurrentValue;
        $this->details->CurrentValue = null;
        $this->details->OldValue = $this->details->CurrentValue;
        $this->max_limit->CurrentValue = null;
        $this->max_limit->OldValue = $this->max_limit->CurrentValue;
        $this->min_limit->CurrentValue = null;
        $this->min_limit->OldValue = $this->min_limit->CurrentValue;
        $this->price->CurrentValue = null;
        $this->price->OldValue = $this->price->CurrentValue;
        $this->operator_fee->CurrentValue = null;
        $this->operator_fee->OldValue = $this->operator_fee->CurrentValue;
        $this->agency_fee->CurrentValue = null;
        $this->agency_fee->OldValue = $this->agency_fee->CurrentValue;
        $this->lamata_fee->CurrentValue = null;
        $this->lamata_fee->OldValue = $this->lamata_fee->CurrentValue;
        $this->lasaa_fee->CurrentValue = null;
        $this->lasaa_fee->OldValue = $this->lasaa_fee->CurrentValue;
        $this->printers_fee->CurrentValue = null;
        $this->printers_fee->OldValue = $this->printers_fee->CurrentValue;
        $this->active->CurrentValue = false;
        $this->active->OldValue = $this->active->CurrentValue;
        $this->ts_created->CurrentValue = null;
        $this->ts_created->OldValue = $this->ts_created->CurrentValue;
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

        // platform_id
        if (!$this->isAddOrEdit() && $this->platform_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->platform_id->AdvancedSearch->SearchValue != "" || $this->platform_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // print_stage_id
        if (!$this->isAddOrEdit() && $this->print_stage_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->print_stage_id->AdvancedSearch->SearchValue != "" || $this->print_stage_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // details
        if (!$this->isAddOrEdit() && $this->details->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->details->AdvancedSearch->SearchValue != "" || $this->details->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // max_limit
        if (!$this->isAddOrEdit() && $this->max_limit->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->max_limit->AdvancedSearch->SearchValue != "" || $this->max_limit->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // min_limit
        if (!$this->isAddOrEdit() && $this->min_limit->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->min_limit->AdvancedSearch->SearchValue != "" || $this->min_limit->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // price
        if (!$this->isAddOrEdit() && $this->price->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price->AdvancedSearch->SearchValue != "" || $this->price->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // operator_fee
        if (!$this->isAddOrEdit() && $this->operator_fee->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->operator_fee->AdvancedSearch->SearchValue != "" || $this->operator_fee->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // agency_fee
        if (!$this->isAddOrEdit() && $this->agency_fee->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->agency_fee->AdvancedSearch->SearchValue != "" || $this->agency_fee->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // lasaa_fee
        if (!$this->isAddOrEdit() && $this->lasaa_fee->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->lasaa_fee->AdvancedSearch->SearchValue != "" || $this->lasaa_fee->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // printers_fee
        if (!$this->isAddOrEdit() && $this->printers_fee->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->printers_fee->AdvancedSearch->SearchValue != "" || $this->printers_fee->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // active
        if (!$this->isAddOrEdit() && $this->active->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->active->AdvancedSearch->SearchValue != "" || $this->active->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->active->AdvancedSearch->SearchValue)) {
            $this->active->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->active->AdvancedSearch->SearchValue);
        }
        if (is_array($this->active->AdvancedSearch->SearchValue2)) {
            $this->active->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->active->AdvancedSearch->SearchValue2);
        }

        // ts_created
        if (!$this->isAddOrEdit() && $this->ts_created->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ts_created->AdvancedSearch->SearchValue != "" || $this->ts_created->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // Check field name 'inventory_id' first before field var 'x_inventory_id'
        $val = $CurrentForm->hasValue("inventory_id") ? $CurrentForm->getValue("inventory_id") : $CurrentForm->getValue("x_inventory_id");
        if (!$this->inventory_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->inventory_id->Visible = false; // Disable update for API request
            } else {
                $this->inventory_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_inventory_id")) {
            $this->inventory_id->setOldValue($CurrentForm->getValue("o_inventory_id"));
        }

        // Check field name 'print_stage_id' first before field var 'x_print_stage_id'
        $val = $CurrentForm->hasValue("print_stage_id") ? $CurrentForm->getValue("print_stage_id") : $CurrentForm->getValue("x_print_stage_id");
        if (!$this->print_stage_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->print_stage_id->Visible = false; // Disable update for API request
            } else {
                $this->print_stage_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_print_stage_id")) {
            $this->print_stage_id->setOldValue($CurrentForm->getValue("o_print_stage_id"));
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

        // Check field name 'details' first before field var 'x_details'
        $val = $CurrentForm->hasValue("details") ? $CurrentForm->getValue("details") : $CurrentForm->getValue("x_details");
        if (!$this->details->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->details->Visible = false; // Disable update for API request
            } else {
                $this->details->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_details")) {
            $this->details->setOldValue($CurrentForm->getValue("o_details"));
        }

        // Check field name 'max_limit' first before field var 'x_max_limit'
        $val = $CurrentForm->hasValue("max_limit") ? $CurrentForm->getValue("max_limit") : $CurrentForm->getValue("x_max_limit");
        if (!$this->max_limit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->max_limit->Visible = false; // Disable update for API request
            } else {
                $this->max_limit->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_max_limit")) {
            $this->max_limit->setOldValue($CurrentForm->getValue("o_max_limit"));
        }

        // Check field name 'min_limit' first before field var 'x_min_limit'
        $val = $CurrentForm->hasValue("min_limit") ? $CurrentForm->getValue("min_limit") : $CurrentForm->getValue("x_min_limit");
        if (!$this->min_limit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->min_limit->Visible = false; // Disable update for API request
            } else {
                $this->min_limit->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_min_limit")) {
            $this->min_limit->setOldValue($CurrentForm->getValue("o_min_limit"));
        }

        // Check field name 'price' first before field var 'x_price'
        $val = $CurrentForm->hasValue("price") ? $CurrentForm->getValue("price") : $CurrentForm->getValue("x_price");
        if (!$this->price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price->Visible = false; // Disable update for API request
            } else {
                $this->price->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_price")) {
            $this->price->setOldValue($CurrentForm->getValue("o_price"));
        }

        // Check field name 'operator_fee' first before field var 'x_operator_fee'
        $val = $CurrentForm->hasValue("operator_fee") ? $CurrentForm->getValue("operator_fee") : $CurrentForm->getValue("x_operator_fee");
        if (!$this->operator_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->operator_fee->Visible = false; // Disable update for API request
            } else {
                $this->operator_fee->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_operator_fee")) {
            $this->operator_fee->setOldValue($CurrentForm->getValue("o_operator_fee"));
        }

        // Check field name 'agency_fee' first before field var 'x_agency_fee'
        $val = $CurrentForm->hasValue("agency_fee") ? $CurrentForm->getValue("agency_fee") : $CurrentForm->getValue("x_agency_fee");
        if (!$this->agency_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->agency_fee->Visible = false; // Disable update for API request
            } else {
                $this->agency_fee->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_agency_fee")) {
            $this->agency_fee->setOldValue($CurrentForm->getValue("o_agency_fee"));
        }

        // Check field name 'lamata_fee' first before field var 'x_lamata_fee'
        $val = $CurrentForm->hasValue("lamata_fee") ? $CurrentForm->getValue("lamata_fee") : $CurrentForm->getValue("x_lamata_fee");
        if (!$this->lamata_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lamata_fee->Visible = false; // Disable update for API request
            } else {
                $this->lamata_fee->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lamata_fee")) {
            $this->lamata_fee->setOldValue($CurrentForm->getValue("o_lamata_fee"));
        }

        // Check field name 'lasaa_fee' first before field var 'x_lasaa_fee'
        $val = $CurrentForm->hasValue("lasaa_fee") ? $CurrentForm->getValue("lasaa_fee") : $CurrentForm->getValue("x_lasaa_fee");
        if (!$this->lasaa_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lasaa_fee->Visible = false; // Disable update for API request
            } else {
                $this->lasaa_fee->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lasaa_fee")) {
            $this->lasaa_fee->setOldValue($CurrentForm->getValue("o_lasaa_fee"));
        }

        // Check field name 'printers_fee' first before field var 'x_printers_fee'
        $val = $CurrentForm->hasValue("printers_fee") ? $CurrentForm->getValue("printers_fee") : $CurrentForm->getValue("x_printers_fee");
        if (!$this->printers_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->printers_fee->Visible = false; // Disable update for API request
            } else {
                $this->printers_fee->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_printers_fee")) {
            $this->printers_fee->setOldValue($CurrentForm->getValue("o_printers_fee"));
        }

        // Check field name 'active' first before field var 'x_active'
        $val = $CurrentForm->hasValue("active") ? $CurrentForm->getValue("active") : $CurrentForm->getValue("x_active");
        if (!$this->active->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->active->Visible = false; // Disable update for API request
            } else {
                $this->active->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_active")) {
            $this->active->setOldValue($CurrentForm->getValue("o_active"));
        }

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
        if ($CurrentForm->hasValue("o_ts_created")) {
            $this->ts_created->setOldValue($CurrentForm->getValue("o_ts_created"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
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
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['platform_id'] = $this->platform_id->CurrentValue;
        $row['inventory_id'] = $this->inventory_id->CurrentValue;
        $row['print_stage_id'] = $this->print_stage_id->CurrentValue;
        $row['bus_size_id'] = $this->bus_size_id->CurrentValue;
        $row['details'] = $this->details->CurrentValue;
        $row['max_limit'] = $this->max_limit->CurrentValue;
        $row['min_limit'] = $this->min_limit->CurrentValue;
        $row['price'] = $this->price->CurrentValue;
        $row['operator_fee'] = $this->operator_fee->CurrentValue;
        $row['agency_fee'] = $this->agency_fee->CurrentValue;
        $row['lamata_fee'] = $this->lamata_fee->CurrentValue;
        $row['lasaa_fee'] = $this->lasaa_fee->CurrentValue;
        $row['printers_fee'] = $this->printers_fee->CurrentValue;
        $row['active'] = $this->active->CurrentValue;
        $row['ts_created'] = $this->ts_created->CurrentValue;
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

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id

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

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

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

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

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
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->AdvancedSearch->SearchValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // platform_id
            $this->platform_id->EditAttrs["class"] = "form-control";
            $this->platform_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->platform_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->platform_id->AdvancedSearch->ViewValue = $this->platform_id->lookupCacheOption($curVal);
            } else {
                $this->platform_id->AdvancedSearch->ViewValue = $this->platform_id->Lookup !== null && is_array($this->platform_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->platform_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->platform_id->EditValue = array_values($this->platform_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->platform_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
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
            $curVal = trim(strval($this->inventory_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->inventory_id->AdvancedSearch->ViewValue = $this->inventory_id->lookupCacheOption($curVal);
            } else {
                $this->inventory_id->AdvancedSearch->ViewValue = $this->inventory_id->Lookup !== null && is_array($this->inventory_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->inventory_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->inventory_id->EditValue = array_values($this->inventory_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->inventory_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
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
            $curVal = trim(strval($this->print_stage_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->print_stage_id->AdvancedSearch->ViewValue = $this->print_stage_id->lookupCacheOption($curVal);
            } else {
                $this->print_stage_id->AdvancedSearch->ViewValue = $this->print_stage_id->Lookup !== null && is_array($this->print_stage_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->print_stage_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->print_stage_id->EditValue = array_values($this->print_stage_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->print_stage_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
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
            $curVal = trim(strval($this->bus_size_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->bus_size_id->AdvancedSearch->ViewValue = $this->bus_size_id->lookupCacheOption($curVal);
            } else {
                $this->bus_size_id->AdvancedSearch->ViewValue = $this->bus_size_id->Lookup !== null && is_array($this->bus_size_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->bus_size_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->bus_size_id->EditValue = array_values($this->bus_size_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "\"id\"" . SearchString("=", $this->bus_size_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
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
            $this->details->EditValue = HtmlEncode($this->details->AdvancedSearch->SearchValue);
            $this->details->PlaceHolder = RemoveHtml($this->details->caption());

            // max_limit
            $this->max_limit->EditAttrs["class"] = "form-control";
            $this->max_limit->EditCustomAttributes = "";
            $this->max_limit->EditValue = HtmlEncode($this->max_limit->AdvancedSearch->SearchValue);
            $this->max_limit->PlaceHolder = RemoveHtml($this->max_limit->caption());

            // min_limit
            $this->min_limit->EditAttrs["class"] = "form-control";
            $this->min_limit->EditCustomAttributes = "";
            $this->min_limit->EditValue = HtmlEncode($this->min_limit->AdvancedSearch->SearchValue);
            $this->min_limit->PlaceHolder = RemoveHtml($this->min_limit->caption());

            // price
            $this->price->EditAttrs["class"] = "form-control";
            $this->price->EditCustomAttributes = "";
            $this->price->EditValue = HtmlEncode($this->price->AdvancedSearch->SearchValue);
            $this->price->PlaceHolder = RemoveHtml($this->price->caption());

            // operator_fee
            $this->operator_fee->EditAttrs["class"] = "form-control";
            $this->operator_fee->EditCustomAttributes = "";
            $this->operator_fee->EditValue = HtmlEncode($this->operator_fee->AdvancedSearch->SearchValue);
            $this->operator_fee->PlaceHolder = RemoveHtml($this->operator_fee->caption());

            // agency_fee
            $this->agency_fee->EditAttrs["class"] = "form-control";
            $this->agency_fee->EditCustomAttributes = "";
            $this->agency_fee->EditValue = HtmlEncode($this->agency_fee->AdvancedSearch->SearchValue);
            $this->agency_fee->PlaceHolder = RemoveHtml($this->agency_fee->caption());

            // lamata_fee
            $this->lamata_fee->EditAttrs["class"] = "form-control";
            $this->lamata_fee->EditCustomAttributes = "";
            $this->lamata_fee->EditValue = HtmlEncode($this->lamata_fee->AdvancedSearch->SearchValue);
            $this->lamata_fee->PlaceHolder = RemoveHtml($this->lamata_fee->caption());

            // lasaa_fee
            $this->lasaa_fee->EditAttrs["class"] = "form-control";
            $this->lasaa_fee->EditCustomAttributes = "";
            $this->lasaa_fee->EditValue = HtmlEncode($this->lasaa_fee->AdvancedSearch->SearchValue);
            $this->lasaa_fee->PlaceHolder = RemoveHtml($this->lasaa_fee->caption());

            // printers_fee
            $this->printers_fee->EditAttrs["class"] = "form-control";
            $this->printers_fee->EditCustomAttributes = "";
            $this->printers_fee->EditValue = HtmlEncode($this->printers_fee->AdvancedSearch->SearchValue);
            $this->printers_fee->PlaceHolder = RemoveHtml($this->printers_fee->caption());

            // active
            $this->active->EditCustomAttributes = "";
            $this->active->EditValue = $this->active->options(false);
            $this->active->PlaceHolder = RemoveHtml($this->active->caption());

            // ts_created
            $this->ts_created->EditAttrs["class"] = "form-control";
            $this->ts_created->EditCustomAttributes = "";
            $this->ts_created->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->ts_created->AdvancedSearch->SearchValue, 0), 8));
            $this->ts_created->PlaceHolder = RemoveHtml($this->ts_created->caption());
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
        if (!CheckInteger($this->id->AdvancedSearch->SearchValue)) {
            $this->id->addErrorMessage($this->id->getErrorMessage(false));
        }
        if (!CheckDate($this->ts_created->AdvancedSearch->SearchValue)) {
            $this->ts_created->addErrorMessage($this->ts_created->getErrorMessage(false));
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
        if ($this->platform_id->Required) {
            if (!$this->platform_id->IsDetailKey && EmptyValue($this->platform_id->FormValue)) {
                $this->platform_id->addErrorMessage(str_replace("%s", $this->platform_id->caption(), $this->platform_id->RequiredErrorMessage));
            }
        }
        if ($this->inventory_id->Required) {
            if (!$this->inventory_id->IsDetailKey && EmptyValue($this->inventory_id->FormValue)) {
                $this->inventory_id->addErrorMessage(str_replace("%s", $this->inventory_id->caption(), $this->inventory_id->RequiredErrorMessage));
            }
        }
        if ($this->print_stage_id->Required) {
            if (!$this->print_stage_id->IsDetailKey && EmptyValue($this->print_stage_id->FormValue)) {
                $this->print_stage_id->addErrorMessage(str_replace("%s", $this->print_stage_id->caption(), $this->print_stage_id->RequiredErrorMessage));
            }
        }
        if ($this->bus_size_id->Required) {
            if (!$this->bus_size_id->IsDetailKey && EmptyValue($this->bus_size_id->FormValue)) {
                $this->bus_size_id->addErrorMessage(str_replace("%s", $this->bus_size_id->caption(), $this->bus_size_id->RequiredErrorMessage));
            }
        }
        if ($this->details->Required) {
            if (!$this->details->IsDetailKey && EmptyValue($this->details->FormValue)) {
                $this->details->addErrorMessage(str_replace("%s", $this->details->caption(), $this->details->RequiredErrorMessage));
            }
        }
        if ($this->max_limit->Required) {
            if (!$this->max_limit->IsDetailKey && EmptyValue($this->max_limit->FormValue)) {
                $this->max_limit->addErrorMessage(str_replace("%s", $this->max_limit->caption(), $this->max_limit->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->max_limit->FormValue)) {
            $this->max_limit->addErrorMessage($this->max_limit->getErrorMessage(false));
        }
        if ($this->min_limit->Required) {
            if (!$this->min_limit->IsDetailKey && EmptyValue($this->min_limit->FormValue)) {
                $this->min_limit->addErrorMessage(str_replace("%s", $this->min_limit->caption(), $this->min_limit->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->min_limit->FormValue)) {
            $this->min_limit->addErrorMessage($this->min_limit->getErrorMessage(false));
        }
        if ($this->price->Required) {
            if (!$this->price->IsDetailKey && EmptyValue($this->price->FormValue)) {
                $this->price->addErrorMessage(str_replace("%s", $this->price->caption(), $this->price->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->price->FormValue)) {
            $this->price->addErrorMessage($this->price->getErrorMessage(false));
        }
        if ($this->operator_fee->Required) {
            if (!$this->operator_fee->IsDetailKey && EmptyValue($this->operator_fee->FormValue)) {
                $this->operator_fee->addErrorMessage(str_replace("%s", $this->operator_fee->caption(), $this->operator_fee->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->operator_fee->FormValue)) {
            $this->operator_fee->addErrorMessage($this->operator_fee->getErrorMessage(false));
        }
        if ($this->agency_fee->Required) {
            if (!$this->agency_fee->IsDetailKey && EmptyValue($this->agency_fee->FormValue)) {
                $this->agency_fee->addErrorMessage(str_replace("%s", $this->agency_fee->caption(), $this->agency_fee->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->agency_fee->FormValue)) {
            $this->agency_fee->addErrorMessage($this->agency_fee->getErrorMessage(false));
        }
        if ($this->lamata_fee->Required) {
            if (!$this->lamata_fee->IsDetailKey && EmptyValue($this->lamata_fee->FormValue)) {
                $this->lamata_fee->addErrorMessage(str_replace("%s", $this->lamata_fee->caption(), $this->lamata_fee->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lamata_fee->FormValue)) {
            $this->lamata_fee->addErrorMessage($this->lamata_fee->getErrorMessage(false));
        }
        if ($this->lasaa_fee->Required) {
            if (!$this->lasaa_fee->IsDetailKey && EmptyValue($this->lasaa_fee->FormValue)) {
                $this->lasaa_fee->addErrorMessage(str_replace("%s", $this->lasaa_fee->caption(), $this->lasaa_fee->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lasaa_fee->FormValue)) {
            $this->lasaa_fee->addErrorMessage($this->lasaa_fee->getErrorMessage(false));
        }
        if ($this->printers_fee->Required) {
            if (!$this->printers_fee->IsDetailKey && EmptyValue($this->printers_fee->FormValue)) {
                $this->printers_fee->addErrorMessage(str_replace("%s", $this->printers_fee->caption(), $this->printers_fee->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->printers_fee->FormValue)) {
            $this->printers_fee->addErrorMessage($this->printers_fee->getErrorMessage(false));
        }
        if ($this->active->Required) {
            if ($this->active->FormValue == "") {
                $this->active->addErrorMessage(str_replace("%s", $this->active->caption(), $this->active->RequiredErrorMessage));
            }
        }
        if ($this->ts_created->Required) {
            if (!$this->ts_created->IsDetailKey && EmptyValue($this->ts_created->FormValue)) {
                $this->ts_created->addErrorMessage(str_replace("%s", $this->ts_created->caption(), $this->ts_created->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ts_created->FormValue)) {
            $this->ts_created->addErrorMessage($this->ts_created->getErrorMessage(false));
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

            // platform_id
            $this->platform_id->setDbValueDef($rsnew, $this->platform_id->CurrentValue, 0, $this->platform_id->ReadOnly);

            // inventory_id
            $this->inventory_id->setDbValueDef($rsnew, $this->inventory_id->CurrentValue, 0, $this->inventory_id->ReadOnly);

            // print_stage_id
            $this->print_stage_id->setDbValueDef($rsnew, $this->print_stage_id->CurrentValue, null, $this->print_stage_id->ReadOnly);

            // bus_size_id
            $this->bus_size_id->setDbValueDef($rsnew, $this->bus_size_id->CurrentValue, null, $this->bus_size_id->ReadOnly);

            // details
            $this->details->setDbValueDef($rsnew, $this->details->CurrentValue, null, $this->details->ReadOnly);

            // max_limit
            $this->max_limit->setDbValueDef($rsnew, $this->max_limit->CurrentValue, null, $this->max_limit->ReadOnly);

            // min_limit
            $this->min_limit->setDbValueDef($rsnew, $this->min_limit->CurrentValue, null, $this->min_limit->ReadOnly);

            // price
            $this->price->setDbValueDef($rsnew, $this->price->CurrentValue, null, $this->price->ReadOnly);

            // operator_fee
            $this->operator_fee->setDbValueDef($rsnew, $this->operator_fee->CurrentValue, null, $this->operator_fee->ReadOnly);

            // agency_fee
            $this->agency_fee->setDbValueDef($rsnew, $this->agency_fee->CurrentValue, null, $this->agency_fee->ReadOnly);

            // lamata_fee
            $this->lamata_fee->setDbValueDef($rsnew, $this->lamata_fee->CurrentValue, null, $this->lamata_fee->ReadOnly);

            // lasaa_fee
            $this->lasaa_fee->setDbValueDef($rsnew, $this->lasaa_fee->CurrentValue, null, $this->lasaa_fee->ReadOnly);

            // printers_fee
            $this->printers_fee->setDbValueDef($rsnew, $this->printers_fee->CurrentValue, null, $this->printers_fee->ReadOnly);

            // active
            $tmpBool = $this->active->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->active->setDbValueDef($rsnew, $tmpBool, 0, $this->active->ReadOnly);

            // ts_created
            $this->ts_created->setDbValueDef($rsnew, UnFormatDateTime($this->ts_created->CurrentValue, 0), CurrentDate(), $this->ts_created->ReadOnly);

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
        $hash .= GetFieldHash($row['platform_id']); // platform_id
        $hash .= GetFieldHash($row['inventory_id']); // inventory_id
        $hash .= GetFieldHash($row['print_stage_id']); // print_stage_id
        $hash .= GetFieldHash($row['bus_size_id']); // bus_size_id
        $hash .= GetFieldHash($row['details']); // details
        $hash .= GetFieldHash($row['max_limit']); // max_limit
        $hash .= GetFieldHash($row['min_limit']); // min_limit
        $hash .= GetFieldHash($row['price']); // price
        $hash .= GetFieldHash($row['operator_fee']); // operator_fee
        $hash .= GetFieldHash($row['agency_fee']); // agency_fee
        $hash .= GetFieldHash($row['lamata_fee']); // lamata_fee
        $hash .= GetFieldHash($row['lasaa_fee']); // lasaa_fee
        $hash .= GetFieldHash($row['printers_fee']); // printers_fee
        $hash .= GetFieldHash($row['active']); // active
        $hash .= GetFieldHash($row['ts_created']); // ts_created
        return md5($hash);
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // platform_id
        $this->platform_id->setDbValueDef($rsnew, $this->platform_id->CurrentValue, 0, false);

        // inventory_id
        $this->inventory_id->setDbValueDef($rsnew, $this->inventory_id->CurrentValue, 0, false);

        // print_stage_id
        $this->print_stage_id->setDbValueDef($rsnew, $this->print_stage_id->CurrentValue, null, false);

        // bus_size_id
        $this->bus_size_id->setDbValueDef($rsnew, $this->bus_size_id->CurrentValue, null, false);

        // details
        $this->details->setDbValueDef($rsnew, $this->details->CurrentValue, null, false);

        // max_limit
        $this->max_limit->setDbValueDef($rsnew, $this->max_limit->CurrentValue, null, false);

        // min_limit
        $this->min_limit->setDbValueDef($rsnew, $this->min_limit->CurrentValue, null, false);

        // price
        $this->price->setDbValueDef($rsnew, $this->price->CurrentValue, null, false);

        // operator_fee
        $this->operator_fee->setDbValueDef($rsnew, $this->operator_fee->CurrentValue, null, false);

        // agency_fee
        $this->agency_fee->setDbValueDef($rsnew, $this->agency_fee->CurrentValue, null, false);

        // lamata_fee
        $this->lamata_fee->setDbValueDef($rsnew, $this->lamata_fee->CurrentValue, null, false);

        // lasaa_fee
        $this->lasaa_fee->setDbValueDef($rsnew, $this->lasaa_fee->CurrentValue, null, false);

        // printers_fee
        $this->printers_fee->setDbValueDef($rsnew, $this->printers_fee->CurrentValue, null, false);

        // active
        $tmpBool = $this->active->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->active->setDbValueDef($rsnew, $tmpBool, 0, strval($this->active->CurrentValue) == "");

        // ts_created
        $this->ts_created->setDbValueDef($rsnew, UnFormatDateTime($this->ts_created->CurrentValue, 0), CurrentDate(), false);

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
        $this->platform_id->AdvancedSearch->load();
        $this->inventory_id->AdvancedSearch->load();
        $this->print_stage_id->AdvancedSearch->load();
        $this->bus_size_id->AdvancedSearch->load();
        $this->details->AdvancedSearch->load();
        $this->max_limit->AdvancedSearch->load();
        $this->min_limit->AdvancedSearch->load();
        $this->price->AdvancedSearch->load();
        $this->operator_fee->AdvancedSearch->load();
        $this->agency_fee->AdvancedSearch->load();
        $this->lamata_fee->AdvancedSearch->load();
        $this->lasaa_fee->AdvancedSearch->load();
        $this->printers_fee->AdvancedSearch->load();
        $this->active->AdvancedSearch->load();
        $this->ts_created->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fz_price_settingslist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fz_price_settingslist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fz_price_settingslist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
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
            return '<button id="emf_z_price_settings" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_z_price_settings\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fz_price_settingslist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fz_price_settingslistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

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

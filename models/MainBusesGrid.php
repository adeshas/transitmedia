<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainBusesGrid extends MainBuses
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_buses';

    // Page object name
    public $PageObjName = "MainBusesGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fmain_busesgrid";
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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;
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
        $this->AddUrl = "mainbusesadd";

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

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
    public $ShowOtherOptions = false;
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

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
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
            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

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

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Set up sorting order
            $this->setupSortOrder();
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
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
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
            // Get new records
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
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
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
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

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
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
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
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
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $option = $this->OtherOptions["addedit"];
        $option->UseDropDownButton = false;
        $option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $option->UseButtonGroup = true;
        //$option->ButtonClass = ""; // Class for button group
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
            if ($this->AllowAddDeleteRow) {
                $option = $options["addedit"];
                $option->UseDropDownButton = false;
                $item = &$option->add("addblankrow");
                $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                $item->Visible = $Security->canAdd();
                $this->ShowOtherOptions = $item->Visible;
            }
        }
        if ($this->CurrentMode == "view") { // Check view mode
            $option = $options["addedit"];
            $item = $option["add"];
            $this->ShowOtherOptions = $item && $item->Visible;
        }
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;

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
        $this->CopyUrl = $this->getCopyUrl();
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
                $this->bus_size_id->OldValue = $this->bus_size_id->CurrentValue;
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
                $this->bus_depot_id->OldValue = $this->bus_depot_id->CurrentValue;
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
                $this->bus_size_id->OldValue = $this->bus_size_id->CurrentValue;
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
                $this->bus_depot_id->OldValue = $this->bus_depot_id->CurrentValue;
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "x_bus_status") {
            $this->bus_status_id->CurrentValue = $this->bus_status_id->getSessionValue();
        }
        if ($this->getCurrentMasterTable() == "x_bus_sizes") {
            $this->bus_size_id->CurrentValue = $this->bus_size_id->getSessionValue();
        }
        if ($this->getCurrentMasterTable() == "x_bus_depot") {
            $this->bus_depot_id->CurrentValue = $this->bus_depot_id->getSessionValue();
        }
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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "x_bus_status") {
            $masterTbl = Container("x_bus_status");
            $this->bus_status_id->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        if ($masterTblVar == "x_bus_sizes") {
            $masterTbl = Container("x_bus_sizes");
            $this->bus_size_id->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        if ($masterTblVar == "x_bus_depot") {
            $masterTbl = Container("x_bus_depot");
            $this->bus_depot_id->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
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
}

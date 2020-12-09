<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainTransactionsGrid extends MainTransactions
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_transactions';

    // Page object name
    public $PageObjName = "MainTransactionsGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fmain_transactionsgrid";
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

        // Table object (main_transactions)
        if (!isset($GLOBALS["main_transactions"]) || get_class($GLOBALS["main_transactions"]) == PROJECT_NAMESPACE . "main_transactions") {
            $GLOBALS["main_transactions"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        $this->AddUrl = "maintransactionsadd";

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

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
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
        $this->CopyUrl = $this->getCopyUrl();
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
        $this->quantity->CellCssStyle = "white-space: nowrap;";

        // assigned_buses
        $this->assigned_buses->CellCssStyle = "white-space: nowrap;";

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
            $this->campaign_id->CssClass = "font-weight-bold";
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
            $this->assigned_buses->CssClass = "font-weight-bold";
            $this->assigned_buses->CellCssStyle .= "text-align: right;";
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
                $this->campaign_id->CssClass = "font-weight-bold";
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
            if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("grid")) { // Non system admin
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
                $this->campaign_id->CssClass = "font-weight-bold";
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
            if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("grid")) { // Non system admin
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

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "main_campaigns") {
            $this->campaign_id->CurrentValue = $this->campaign_id->getSessionValue();
        }
        if ($this->getCurrentMasterTable() == "y_operators") {
            $this->operator_id->CurrentValue = $this->operator_id->getSessionValue();
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
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "main_campaigns") {
            $masterTbl = Container("main_campaigns");
            $this->campaign_id->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        if ($masterTblVar == "y_operators") {
            $masterTbl = Container("y_operators");
            $this->operator_id->Visible = false;
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
}

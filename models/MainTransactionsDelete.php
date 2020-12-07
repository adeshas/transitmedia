<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainTransactionsDelete extends MainTransactions
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_transactions';

    // Page object name
    public $PageObjName = "MainTransactionsDelete";

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

        // Table object (main_transactions)
        if (!isset($GLOBALS["main_transactions"]) || get_class($GLOBALS["main_transactions"]) == PROJECT_NAMESPACE . "main_transactions") {
            $GLOBALS["main_transactions"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action
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
        $this->setupLookupOptions($this->operator_id);
        $this->setupLookupOptions($this->vendor_id);
        $this->setupLookupOptions($this->price_id);
        $this->setupLookupOptions($this->visible_status_id);
        $this->setupLookupOptions($this->status_id);
        $this->setupLookupOptions($this->print_status_id);
        $this->setupLookupOptions($this->payment_status_id);
        $this->setupLookupOptions($this->created_by);

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("MainTransactionsList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Check if valid User ID
        $conn = $this->getConnection();
        $sql = $this->getSql($this->CurrentFilter);
        $rows = $conn->fetchAll($sql);
        $res = true;
        foreach ($rows as $row) {
            $this->loadRowValues($row);
            if (!$this->showOptionLink("delete")) {
                $userIdMsg = $Language->phrase("NoDeletePermission");
                $this->setFailureMessage($userIdMsg);
                $res = false;
                break;
            }
        }
        if (!$res) {
            $this->terminate("MainTransactionsList"); // Return to list
            return;
        }

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("MainTransactionsList"); // Return to list
                return;
            }
        }

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
        $row = [];
        $row['id'] = null;
        $row['campaign_id'] = null;
        $row['operator_id'] = null;
        $row['payment_date'] = null;
        $row['vendor_id'] = null;
        $row['price_id'] = null;
        $row['quantity'] = null;
        $row['assigned_buses'] = null;
        $row['start_date'] = null;
        $row['end_date'] = null;
        $row['visible_status_id'] = null;
        $row['status_id'] = null;
        $row['print_status_id'] = null;
        $row['payment_status_id'] = null;
        $row['created_by'] = null;
        $row['ts_created'] = null;
        $row['ts_last_update'] = null;
        $row['total'] = null;
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
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
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
        $conn->beginTransaction();

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
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("MainTransactionsList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}

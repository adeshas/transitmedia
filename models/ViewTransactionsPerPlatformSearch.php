<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ViewTransactionsPerPlatformSearch extends ViewTransactionsPerPlatform
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'view_transactions_per_platform';

    // Page object name
    public $PageObjName = "ViewTransactionsPerPlatformSearch";

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

        // Table object (view_transactions_per_platform)
        if (!isset($GLOBALS["view_transactions_per_platform"]) || get_class($GLOBALS["view_transactions_per_platform"]) == PROJECT_NAMESPACE . "view_transactions_per_platform") {
            $GLOBALS["view_transactions_per_platform"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "viewtransactionsperplatformview") {
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
    public $FormClassName = "ew-horizontal ew-form ew-search-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

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
        $this->transaction_id->setVisibility();
        $this->campaign->setVisibility();
        $this->payment_date->setVisibility();
        $this->inventory->setVisibility();
        $this->bus_size->setVisibility();
        $this->print_stage->setVisibility();
        $this->vendor->setVisibility();
        $this->operator->setVisibility();
        $this->transaction_status->setVisibility();
        $this->start_date->setVisibility();
        $this->end_date->setVisibility();
        $this->platform->setVisibility();
        $this->status_id->setVisibility();
        $this->vendor_id->setVisibility();
        $this->inventory_id->setVisibility();
        $this->platform_id->setVisibility();
        $this->operator_id->setVisibility();
        $this->bus_size_id->setVisibility();
        $this->vendor_search_id->setVisibility();
        $this->vendor_search_name->setVisibility();
        $this->price->setVisibility();
        $this->quantity->setVisibility();
        $this->amount_paid->setVisibility();
        $this->transitmedia_fee->setVisibility();
        $this->lasaa_fee->setVisibility();
        $this->operator_fee->setVisibility();
        $this->lamata_fee->setVisibility();
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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        if ($this->isPageRequest()) {
            // Get action
            $this->CurrentAction = Post("action");
            if ($this->isSearch()) {
                // Build search string for advanced search, remove blank field
                $this->loadSearchValues(); // Get search values
                if ($this->validateSearch()) {
                    $srchStr = $this->buildAdvancedSearch();
                } else {
                    $srchStr = "";
                }
                if ($srchStr != "") {
                    $srchStr = $this->getUrlParm($srchStr);
                    $srchStr = "viewtransactionsperplatformlist" . "?" . $srchStr;
                    $this->terminate($srchStr); // Go to list page
                    return;
                }
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Render row for search
        $this->RowType = ROWTYPE_SEARCH;
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

    // Build advanced search
    protected function buildAdvancedSearch()
    {
        $srchUrl = "";
        $this->buildSearchUrl($srchUrl, $this->transaction_id); // transaction_id
        $this->buildSearchUrl($srchUrl, $this->campaign); // campaign
        $this->buildSearchUrl($srchUrl, $this->payment_date); // payment_date
        $this->buildSearchUrl($srchUrl, $this->inventory); // inventory
        $this->buildSearchUrl($srchUrl, $this->bus_size); // bus_size
        $this->buildSearchUrl($srchUrl, $this->print_stage); // print_stage
        $this->buildSearchUrl($srchUrl, $this->vendor); // vendor
        $this->buildSearchUrl($srchUrl, $this->operator); // operator
        $this->buildSearchUrl($srchUrl, $this->transaction_status); // transaction_status
        $this->buildSearchUrl($srchUrl, $this->start_date); // start_date
        $this->buildSearchUrl($srchUrl, $this->end_date); // end_date
        $this->buildSearchUrl($srchUrl, $this->platform); // platform
        $this->buildSearchUrl($srchUrl, $this->status_id); // status_id
        $this->buildSearchUrl($srchUrl, $this->vendor_id); // vendor_id
        $this->buildSearchUrl($srchUrl, $this->inventory_id); // inventory_id
        $this->buildSearchUrl($srchUrl, $this->platform_id); // platform_id
        $this->buildSearchUrl($srchUrl, $this->operator_id); // operator_id
        $this->buildSearchUrl($srchUrl, $this->bus_size_id); // bus_size_id
        $this->buildSearchUrl($srchUrl, $this->vendor_search_id); // vendor_search_id
        $this->buildSearchUrl($srchUrl, $this->vendor_search_name); // vendor_search_name
        $this->buildSearchUrl($srchUrl, $this->price); // price
        $this->buildSearchUrl($srchUrl, $this->quantity); // quantity
        $this->buildSearchUrl($srchUrl, $this->amount_paid); // amount_paid
        $this->buildSearchUrl($srchUrl, $this->transitmedia_fee); // transitmedia_fee
        $this->buildSearchUrl($srchUrl, $this->lasaa_fee); // lasaa_fee
        $this->buildSearchUrl($srchUrl, $this->operator_fee); // operator_fee
        $this->buildSearchUrl($srchUrl, $this->lamata_fee); // lamata_fee
        if ($srchUrl != "") {
            $srchUrl .= "&";
        }
        $srchUrl .= "cmd=search";
        return $srchUrl;
    }

    // Build search URL
    protected function buildSearchUrl(&$url, &$fld, $oprOnly = false)
    {
        global $CurrentForm;
        $wrk = "";
        $fldParm = $fld->Param;
        $fldVal = $CurrentForm->getValue("x_$fldParm");
        $fldOpr = $CurrentForm->getValue("z_$fldParm");
        $fldCond = $CurrentForm->getValue("v_$fldParm");
        $fldVal2 = $CurrentForm->getValue("y_$fldParm");
        $fldOpr2 = $CurrentForm->getValue("w_$fldParm");
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        $fldDataType = ($fld->IsVirtual) ? DATATYPE_STRING : $fld->DataType;
        if ($fldOpr == "BETWEEN") {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal) && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            }
        } else {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal));
            if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr, $fldDataType)) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            } elseif ($fldOpr == "IS NULL" || $fldOpr == "IS NOT NULL" || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr, $fldDataType))) {
                $wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
            }
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2, $fldDataType)) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&w_" . $fldParm . "=" . urlencode($fldOpr2);
            } elseif ($fldOpr2 == "IS NULL" || $fldOpr2 == "IS NOT NULL" || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2, $fldDataType))) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
            }
        }
        if ($wrk != "") {
            if ($url != "") {
                $url .= "&";
            }
            $url .= $wrk;
        }
    }

    // Check if search value is numeric
    protected function searchValueIsNumeric($fld, $value)
    {
        if (IsFloatFormat($fld->Type)) {
            $value = ConvertToFloatString($value);
        }
        return is_numeric($value);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;
        if ($this->transaction_id->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->campaign->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->payment_date->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->inventory->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->bus_size->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->print_stage->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->vendor->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->operator->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->transaction_status->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->start_date->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->end_date->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->platform->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->status_id->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->vendor_id->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->inventory_id->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->platform_id->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->operator_id->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->bus_size_id->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->vendor_search_id->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->vendor_search_name->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->price->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->quantity->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->amount_paid->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->transitmedia_fee->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->lasaa_fee->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->operator_fee->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->lamata_fee->AdvancedSearch->post()) {
            $hasValue = true;
        }
        return $hasValue;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // transaction_id

        // campaign

        // payment_date

        // inventory

        // bus_size

        // print_stage

        // vendor

        // operator

        // transaction_status

        // start_date

        // end_date

        // platform

        // status_id

        // vendor_id

        // inventory_id

        // platform_id

        // operator_id

        // bus_size_id

        // vendor_search_id

        // vendor_search_name

        // price

        // quantity

        // amount_paid

        // transitmedia_fee

        // lasaa_fee

        // operator_fee

        // lamata_fee
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

            // bus_size
            $this->bus_size->ViewValue = $this->bus_size->CurrentValue;
            $this->bus_size->ViewCustomAttributes = "";

            // print_stage
            $this->print_stage->ViewValue = $this->print_stage->CurrentValue;
            $this->print_stage->ViewCustomAttributes = "";

            // vendor
            $this->vendor->ViewValue = $this->vendor->CurrentValue;
            $this->vendor->ViewCustomAttributes = "";

            // operator
            $this->operator->ViewValue = $this->operator->CurrentValue;
            $this->operator->ViewCustomAttributes = "";

            // transaction_status
            $this->transaction_status->ViewValue = $this->transaction_status->CurrentValue;
            $this->transaction_status->ViewCustomAttributes = 'class="badge bg-success"';

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

            // status_id
            $this->status_id->ViewValue = $this->status_id->CurrentValue;
            $this->status_id->ViewValue = FormatNumber($this->status_id->ViewValue, 0, -2, -2, -2);
            $this->status_id->ViewCustomAttributes = "";

            // vendor_id
            $this->vendor_id->ViewValue = $this->vendor_id->CurrentValue;
            $this->vendor_id->ViewValue = FormatNumber($this->vendor_id->ViewValue, 0, -2, -2, -2);
            $this->vendor_id->ViewCustomAttributes = "";

            // inventory_id
            $this->inventory_id->ViewValue = $this->inventory_id->CurrentValue;
            $this->inventory_id->ViewValue = FormatNumber($this->inventory_id->ViewValue, 0, -2, -2, -2);
            $this->inventory_id->ViewCustomAttributes = "";

            // platform_id
            $this->platform_id->ViewValue = $this->platform_id->CurrentValue;
            $this->platform_id->ViewValue = FormatNumber($this->platform_id->ViewValue, 0, -2, -2, -2);
            $this->platform_id->ViewCustomAttributes = "";

            // operator_id
            $this->operator_id->ViewValue = $this->operator_id->CurrentValue;
            $this->operator_id->ViewValue = FormatNumber($this->operator_id->ViewValue, 0, -2, -2, -2);
            $this->operator_id->ViewCustomAttributes = "";

            // bus_size_id
            $this->bus_size_id->ViewValue = $this->bus_size_id->CurrentValue;
            $this->bus_size_id->ViewValue = FormatNumber($this->bus_size_id->ViewValue, 0, -2, -2, -2);
            $this->bus_size_id->ViewCustomAttributes = "";

            // vendor_search_id
            $this->vendor_search_id->ViewValue = $this->vendor_search_id->CurrentValue;
            $this->vendor_search_id->ViewValue = FormatNumber($this->vendor_search_id->ViewValue, 0, -2, -2, -2);
            $this->vendor_search_id->ViewCustomAttributes = "";

            // vendor_search_name
            $this->vendor_search_name->ViewValue = $this->vendor_search_name->CurrentValue;
            $this->vendor_search_name->ViewCustomAttributes = "";

            // price
            $this->price->ViewValue = $this->price->CurrentValue;
            $this->price->ViewValue = FormatNumber($this->price->ViewValue, 0, -2, -2, -2);
            $this->price->CellCssStyle .= "text-align: right;";
            $this->price->ViewCustomAttributes = "";

            // quantity
            $this->quantity->ViewValue = $this->quantity->CurrentValue;
            $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
            $this->quantity->CellCssStyle .= "text-align: right;";
            $this->quantity->ViewCustomAttributes = "";

            // amount_paid
            $this->amount_paid->ViewValue = $this->amount_paid->CurrentValue;
            $this->amount_paid->ViewValue = FormatNumber($this->amount_paid->ViewValue, 0, -2, -2, -2);
            $this->amount_paid->CellCssStyle .= "text-align: right;";
            $this->amount_paid->ViewCustomAttributes = "";

            // transitmedia_fee
            $this->transitmedia_fee->ViewValue = $this->transitmedia_fee->CurrentValue;
            $this->transitmedia_fee->ViewValue = FormatNumber($this->transitmedia_fee->ViewValue, 0, -2, -2, -2);
            $this->transitmedia_fee->CellCssStyle .= "text-align: right;";
            $this->transitmedia_fee->ViewCustomAttributes = "";

            // lasaa_fee
            $this->lasaa_fee->ViewValue = $this->lasaa_fee->CurrentValue;
            $this->lasaa_fee->ViewValue = FormatNumber($this->lasaa_fee->ViewValue, 0, -2, -2, -2);
            $this->lasaa_fee->CellCssStyle .= "text-align: right;";
            $this->lasaa_fee->ViewCustomAttributes = "";

            // operator_fee
            $this->operator_fee->ViewValue = $this->operator_fee->CurrentValue;
            $this->operator_fee->ViewValue = FormatNumber($this->operator_fee->ViewValue, 0, -2, -2, -2);
            $this->operator_fee->CellCssStyle .= "text-align: right;";
            $this->operator_fee->ViewCustomAttributes = "";

            // lamata_fee
            $this->lamata_fee->ViewValue = $this->lamata_fee->CurrentValue;
            $this->lamata_fee->ViewValue = FormatNumber($this->lamata_fee->ViewValue, 0, -2, -2, -2);
            $this->lamata_fee->CssClass = "font-weight-bold";
            $this->lamata_fee->CellCssStyle .= "text-align: right;";
            $this->lamata_fee->ViewCustomAttributes = "";

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

            // bus_size
            $this->bus_size->LinkCustomAttributes = "";
            $this->bus_size->HrefValue = "";
            $this->bus_size->TooltipValue = "";

            // print_stage
            $this->print_stage->LinkCustomAttributes = "";
            $this->print_stage->HrefValue = "";
            $this->print_stage->TooltipValue = "";

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

            // start_date
            $this->start_date->LinkCustomAttributes = "";
            $this->start_date->HrefValue = "";
            $this->start_date->TooltipValue = "";

            // end_date
            $this->end_date->LinkCustomAttributes = "";
            $this->end_date->HrefValue = "";
            $this->end_date->TooltipValue = "";

            // platform
            $this->platform->LinkCustomAttributes = "";
            $this->platform->HrefValue = "";
            $this->platform->TooltipValue = "";

            // status_id
            $this->status_id->LinkCustomAttributes = "";
            $this->status_id->HrefValue = "";
            $this->status_id->TooltipValue = "";

            // vendor_id
            $this->vendor_id->LinkCustomAttributes = "";
            $this->vendor_id->HrefValue = "";
            $this->vendor_id->TooltipValue = "";

            // inventory_id
            $this->inventory_id->LinkCustomAttributes = "";
            $this->inventory_id->HrefValue = "";
            $this->inventory_id->TooltipValue = "";

            // platform_id
            $this->platform_id->LinkCustomAttributes = "";
            $this->platform_id->HrefValue = "";
            $this->platform_id->TooltipValue = "";

            // operator_id
            $this->operator_id->LinkCustomAttributes = "";
            $this->operator_id->HrefValue = "";
            $this->operator_id->TooltipValue = "";

            // bus_size_id
            $this->bus_size_id->LinkCustomAttributes = "";
            $this->bus_size_id->HrefValue = "";
            $this->bus_size_id->TooltipValue = "";

            // vendor_search_id
            $this->vendor_search_id->LinkCustomAttributes = "";
            $this->vendor_search_id->HrefValue = "";
            $this->vendor_search_id->TooltipValue = "";

            // vendor_search_name
            $this->vendor_search_name->LinkCustomAttributes = "";
            $this->vendor_search_name->HrefValue = "";
            $this->vendor_search_name->TooltipValue = "";

            // price
            $this->price->LinkCustomAttributes = "";
            $this->price->HrefValue = "";
            $this->price->TooltipValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";
            $this->quantity->TooltipValue = "";

            // amount_paid
            $this->amount_paid->LinkCustomAttributes = "";
            $this->amount_paid->HrefValue = "";
            $this->amount_paid->TooltipValue = "";

            // transitmedia_fee
            $this->transitmedia_fee->LinkCustomAttributes = "";
            $this->transitmedia_fee->HrefValue = "";
            $this->transitmedia_fee->TooltipValue = "";

            // lasaa_fee
            $this->lasaa_fee->LinkCustomAttributes = "";
            $this->lasaa_fee->HrefValue = "";
            $this->lasaa_fee->TooltipValue = "";

            // operator_fee
            $this->operator_fee->LinkCustomAttributes = "";
            $this->operator_fee->HrefValue = "";
            $this->operator_fee->TooltipValue = "";

            // lamata_fee
            $this->lamata_fee->LinkCustomAttributes = "";
            $this->lamata_fee->HrefValue = "";
            $this->lamata_fee->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // transaction_id
            $this->transaction_id->EditAttrs["class"] = "form-control";
            $this->transaction_id->EditCustomAttributes = "";
            $this->transaction_id->EditValue = HtmlEncode($this->transaction_id->AdvancedSearch->SearchValue);
            $this->transaction_id->PlaceHolder = RemoveHtml($this->transaction_id->caption());

            // campaign
            $this->campaign->EditAttrs["class"] = "form-control";
            $this->campaign->EditCustomAttributes = "";
            $this->campaign->EditValue = HtmlEncode($this->campaign->AdvancedSearch->SearchValue);
            $this->campaign->PlaceHolder = RemoveHtml($this->campaign->caption());

            // payment_date
            $this->payment_date->EditAttrs["class"] = "form-control";
            $this->payment_date->EditCustomAttributes = "";
            $this->payment_date->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->payment_date->AdvancedSearch->SearchValue, 0), 8));
            $this->payment_date->PlaceHolder = RemoveHtml($this->payment_date->caption());

            // inventory
            $this->inventory->EditAttrs["class"] = "form-control";
            $this->inventory->EditCustomAttributes = "";
            $this->inventory->EditValue = HtmlEncode($this->inventory->AdvancedSearch->SearchValue);
            $this->inventory->PlaceHolder = RemoveHtml($this->inventory->caption());

            // bus_size
            $this->bus_size->EditAttrs["class"] = "form-control";
            $this->bus_size->EditCustomAttributes = "";
            $this->bus_size->EditValue = HtmlEncode($this->bus_size->AdvancedSearch->SearchValue);
            $this->bus_size->PlaceHolder = RemoveHtml($this->bus_size->caption());

            // print_stage
            $this->print_stage->EditAttrs["class"] = "form-control";
            $this->print_stage->EditCustomAttributes = "";
            $this->print_stage->EditValue = HtmlEncode($this->print_stage->AdvancedSearch->SearchValue);
            $this->print_stage->PlaceHolder = RemoveHtml($this->print_stage->caption());

            // vendor
            $this->vendor->EditAttrs["class"] = "form-control";
            $this->vendor->EditCustomAttributes = "";
            if (!$this->vendor->Raw) {
                $this->vendor->AdvancedSearch->SearchValue = HtmlDecode($this->vendor->AdvancedSearch->SearchValue);
            }
            $this->vendor->EditValue = HtmlEncode($this->vendor->AdvancedSearch->SearchValue);
            $this->vendor->PlaceHolder = RemoveHtml($this->vendor->caption());

            // operator
            $this->operator->EditAttrs["class"] = "form-control";
            $this->operator->EditCustomAttributes = "";
            if (!$this->operator->Raw) {
                $this->operator->AdvancedSearch->SearchValue = HtmlDecode($this->operator->AdvancedSearch->SearchValue);
            }
            $this->operator->EditValue = HtmlEncode($this->operator->AdvancedSearch->SearchValue);
            $this->operator->PlaceHolder = RemoveHtml($this->operator->caption());

            // transaction_status
            $this->transaction_status->EditAttrs["class"] = "form-control";
            $this->transaction_status->EditCustomAttributes = "";
            if (!$this->transaction_status->Raw) {
                $this->transaction_status->AdvancedSearch->SearchValue = HtmlDecode($this->transaction_status->AdvancedSearch->SearchValue);
            }
            $this->transaction_status->EditValue = HtmlEncode($this->transaction_status->AdvancedSearch->SearchValue);
            $this->transaction_status->PlaceHolder = RemoveHtml($this->transaction_status->caption());

            // start_date
            $this->start_date->EditAttrs["class"] = "form-control";
            $this->start_date->EditCustomAttributes = "";
            $this->start_date->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->start_date->AdvancedSearch->SearchValue, 0), 8));
            $this->start_date->PlaceHolder = RemoveHtml($this->start_date->caption());

            // end_date
            $this->end_date->EditAttrs["class"] = "form-control";
            $this->end_date->EditCustomAttributes = "";
            $this->end_date->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->end_date->AdvancedSearch->SearchValue, 0), 8));
            $this->end_date->PlaceHolder = RemoveHtml($this->end_date->caption());

            // platform
            $this->platform->EditAttrs["class"] = "form-control";
            $this->platform->EditCustomAttributes = "";
            if (!$this->platform->Raw) {
                $this->platform->AdvancedSearch->SearchValue = HtmlDecode($this->platform->AdvancedSearch->SearchValue);
            }
            $this->platform->EditValue = HtmlEncode($this->platform->AdvancedSearch->SearchValue);
            $this->platform->PlaceHolder = RemoveHtml($this->platform->caption());

            // status_id
            $this->status_id->EditAttrs["class"] = "form-control";
            $this->status_id->EditCustomAttributes = "";
            $this->status_id->EditValue = HtmlEncode($this->status_id->AdvancedSearch->SearchValue);
            $this->status_id->PlaceHolder = RemoveHtml($this->status_id->caption());

            // vendor_id
            $this->vendor_id->EditAttrs["class"] = "form-control";
            $this->vendor_id->EditCustomAttributes = "";
            $this->vendor_id->EditValue = HtmlEncode($this->vendor_id->AdvancedSearch->SearchValue);
            $this->vendor_id->PlaceHolder = RemoveHtml($this->vendor_id->caption());

            // inventory_id
            $this->inventory_id->EditAttrs["class"] = "form-control";
            $this->inventory_id->EditCustomAttributes = "";
            $this->inventory_id->EditValue = HtmlEncode($this->inventory_id->AdvancedSearch->SearchValue);
            $this->inventory_id->PlaceHolder = RemoveHtml($this->inventory_id->caption());

            // platform_id
            $this->platform_id->EditAttrs["class"] = "form-control";
            $this->platform_id->EditCustomAttributes = "";
            $this->platform_id->EditValue = HtmlEncode($this->platform_id->AdvancedSearch->SearchValue);
            $this->platform_id->PlaceHolder = RemoveHtml($this->platform_id->caption());

            // operator_id
            $this->operator_id->EditAttrs["class"] = "form-control";
            $this->operator_id->EditCustomAttributes = "";
            $this->operator_id->EditValue = HtmlEncode($this->operator_id->AdvancedSearch->SearchValue);
            $this->operator_id->PlaceHolder = RemoveHtml($this->operator_id->caption());

            // bus_size_id
            $this->bus_size_id->EditAttrs["class"] = "form-control";
            $this->bus_size_id->EditCustomAttributes = "";
            $this->bus_size_id->EditValue = HtmlEncode($this->bus_size_id->AdvancedSearch->SearchValue);
            $this->bus_size_id->PlaceHolder = RemoveHtml($this->bus_size_id->caption());

            // vendor_search_id
            $this->vendor_search_id->EditAttrs["class"] = "form-control";
            $this->vendor_search_id->EditCustomAttributes = "";
            $this->vendor_search_id->EditValue = HtmlEncode($this->vendor_search_id->AdvancedSearch->SearchValue);
            $this->vendor_search_id->PlaceHolder = RemoveHtml($this->vendor_search_id->caption());

            // vendor_search_name
            $this->vendor_search_name->EditAttrs["class"] = "form-control";
            $this->vendor_search_name->EditCustomAttributes = "";
            if (!$this->vendor_search_name->Raw) {
                $this->vendor_search_name->AdvancedSearch->SearchValue = HtmlDecode($this->vendor_search_name->AdvancedSearch->SearchValue);
            }
            $this->vendor_search_name->EditValue = HtmlEncode($this->vendor_search_name->AdvancedSearch->SearchValue);
            $this->vendor_search_name->PlaceHolder = RemoveHtml($this->vendor_search_name->caption());

            // price
            $this->price->EditAttrs["class"] = "form-control";
            $this->price->EditCustomAttributes = "";
            $this->price->EditValue = HtmlEncode($this->price->AdvancedSearch->SearchValue);
            $this->price->PlaceHolder = RemoveHtml($this->price->caption());

            // quantity
            $this->quantity->EditAttrs["class"] = "form-control";
            $this->quantity->EditCustomAttributes = "";
            $this->quantity->EditValue = HtmlEncode($this->quantity->AdvancedSearch->SearchValue);
            $this->quantity->PlaceHolder = RemoveHtml($this->quantity->caption());

            // amount_paid
            $this->amount_paid->EditAttrs["class"] = "form-control";
            $this->amount_paid->EditCustomAttributes = "";
            $this->amount_paid->EditValue = HtmlEncode($this->amount_paid->AdvancedSearch->SearchValue);
            $this->amount_paid->PlaceHolder = RemoveHtml($this->amount_paid->caption());

            // transitmedia_fee
            $this->transitmedia_fee->EditAttrs["class"] = "form-control";
            $this->transitmedia_fee->EditCustomAttributes = "";
            $this->transitmedia_fee->EditValue = HtmlEncode($this->transitmedia_fee->AdvancedSearch->SearchValue);
            $this->transitmedia_fee->PlaceHolder = RemoveHtml($this->transitmedia_fee->caption());

            // lasaa_fee
            $this->lasaa_fee->EditAttrs["class"] = "form-control";
            $this->lasaa_fee->EditCustomAttributes = "";
            $this->lasaa_fee->EditValue = HtmlEncode($this->lasaa_fee->AdvancedSearch->SearchValue);
            $this->lasaa_fee->PlaceHolder = RemoveHtml($this->lasaa_fee->caption());

            // operator_fee
            $this->operator_fee->EditAttrs["class"] = "form-control";
            $this->operator_fee->EditCustomAttributes = "";
            $this->operator_fee->EditValue = HtmlEncode($this->operator_fee->AdvancedSearch->SearchValue);
            $this->operator_fee->PlaceHolder = RemoveHtml($this->operator_fee->caption());

            // lamata_fee
            $this->lamata_fee->EditAttrs["class"] = "form-control";
            $this->lamata_fee->EditCustomAttributes = "";
            $this->lamata_fee->EditValue = HtmlEncode($this->lamata_fee->AdvancedSearch->SearchValue);
            $this->lamata_fee->PlaceHolder = RemoveHtml($this->lamata_fee->caption());
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
        if (!CheckInteger($this->transaction_id->AdvancedSearch->SearchValue)) {
            $this->transaction_id->addErrorMessage($this->transaction_id->getErrorMessage(false));
        }
        if (!CheckDate($this->payment_date->AdvancedSearch->SearchValue)) {
            $this->payment_date->addErrorMessage($this->payment_date->getErrorMessage(false));
        }
        if (!CheckDate($this->start_date->AdvancedSearch->SearchValue)) {
            $this->start_date->addErrorMessage($this->start_date->getErrorMessage(false));
        }
        if (!CheckDate($this->end_date->AdvancedSearch->SearchValue)) {
            $this->end_date->addErrorMessage($this->end_date->getErrorMessage(false));
        }
        if (!CheckInteger($this->status_id->AdvancedSearch->SearchValue)) {
            $this->status_id->addErrorMessage($this->status_id->getErrorMessage(false));
        }
        if (!CheckInteger($this->vendor_id->AdvancedSearch->SearchValue)) {
            $this->vendor_id->addErrorMessage($this->vendor_id->getErrorMessage(false));
        }
        if (!CheckInteger($this->inventory_id->AdvancedSearch->SearchValue)) {
            $this->inventory_id->addErrorMessage($this->inventory_id->getErrorMessage(false));
        }
        if (!CheckInteger($this->platform_id->AdvancedSearch->SearchValue)) {
            $this->platform_id->addErrorMessage($this->platform_id->getErrorMessage(false));
        }
        if (!CheckInteger($this->operator_id->AdvancedSearch->SearchValue)) {
            $this->operator_id->addErrorMessage($this->operator_id->getErrorMessage(false));
        }
        if (!CheckInteger($this->bus_size_id->AdvancedSearch->SearchValue)) {
            $this->bus_size_id->addErrorMessage($this->bus_size_id->getErrorMessage(false));
        }
        if (!CheckInteger($this->vendor_search_id->AdvancedSearch->SearchValue)) {
            $this->vendor_search_id->addErrorMessage($this->vendor_search_id->getErrorMessage(false));
        }
        if (!CheckInteger($this->price->AdvancedSearch->SearchValue)) {
            $this->price->addErrorMessage($this->price->getErrorMessage(false));
        }
        if (!CheckInteger($this->quantity->AdvancedSearch->SearchValue)) {
            $this->quantity->addErrorMessage($this->quantity->getErrorMessage(false));
        }
        if (!CheckInteger($this->amount_paid->AdvancedSearch->SearchValue)) {
            $this->amount_paid->addErrorMessage($this->amount_paid->getErrorMessage(false));
        }
        if (!CheckInteger($this->transitmedia_fee->AdvancedSearch->SearchValue)) {
            $this->transitmedia_fee->addErrorMessage($this->transitmedia_fee->getErrorMessage(false));
        }
        if (!CheckInteger($this->lasaa_fee->AdvancedSearch->SearchValue)) {
            $this->lasaa_fee->addErrorMessage($this->lasaa_fee->getErrorMessage(false));
        }
        if (!CheckInteger($this->operator_fee->AdvancedSearch->SearchValue)) {
            $this->operator_fee->addErrorMessage($this->operator_fee->getErrorMessage(false));
        }
        if (!CheckInteger($this->lamata_fee->AdvancedSearch->SearchValue)) {
            $this->lamata_fee->addErrorMessage($this->lamata_fee->getErrorMessage(false));
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
        $this->price->AdvancedSearch->load();
        $this->quantity->AdvancedSearch->load();
        $this->amount_paid->AdvancedSearch->load();
        $this->transitmedia_fee->AdvancedSearch->load();
        $this->lasaa_fee->AdvancedSearch->load();
        $this->operator_fee->AdvancedSearch->load();
        $this->lamata_fee->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("viewtransactionsperplatformlist"), "", $this->TableVar, true);
        $pageId = "search";
        $Breadcrumb->add("search", $pageId, $url);
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

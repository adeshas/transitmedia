<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MainTransactionsEdit extends MainTransactions
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'main_transactions';

    // Page object name
    public $PageObjName = "MainTransactionsEdit";

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "maintransactionsview") {
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
        $this->operator_id->setVisibility();
        $this->payment_date->setVisibility();
        $this->price_id->setVisibility();
        $this->quantity->setVisibility();
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
        $this->setupLookupOptions($this->price_id);
        $this->setupLookupOptions($this->visible_status_id);
        $this->setupLookupOptions($this->status_id);
        $this->setupLookupOptions($this->print_status_id);
        $this->setupLookupOptions($this->payment_status_id);
        $this->setupLookupOptions($this->created_by);

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
                    $this->terminate("maintransactionslist"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "maintransactionslist") {
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

        // Check field name 'operator_id' first before field var 'x_operator_id'
        $val = $CurrentForm->hasValue("operator_id") ? $CurrentForm->getValue("operator_id") : $CurrentForm->getValue("x_operator_id");
        if (!$this->operator_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->operator_id->Visible = false; // Disable update for API request
            } else {
                $this->operator_id->setFormValue($val);
            }
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

        // Check field name 'price_id' first before field var 'x_price_id'
        $val = $CurrentForm->hasValue("price_id") ? $CurrentForm->getValue("price_id") : $CurrentForm->getValue("x_price_id");
        if (!$this->price_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_id->Visible = false; // Disable update for API request
            } else {
                $this->price_id->setFormValue($val);
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

        // Check field name 'visible_status_id' first before field var 'x_visible_status_id'
        $val = $CurrentForm->hasValue("visible_status_id") ? $CurrentForm->getValue("visible_status_id") : $CurrentForm->getValue("x_visible_status_id");
        if (!$this->visible_status_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->visible_status_id->Visible = false; // Disable update for API request
            } else {
                $this->visible_status_id->setFormValue($val);
            }
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

        // Check field name 'print_status_id' first before field var 'x_print_status_id'
        $val = $CurrentForm->hasValue("print_status_id") ? $CurrentForm->getValue("print_status_id") : $CurrentForm->getValue("x_print_status_id");
        if (!$this->print_status_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->print_status_id->Visible = false; // Disable update for API request
            } else {
                $this->print_status_id->setFormValue($val);
            }
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

        // Check field name 'total' first before field var 'x_total'
        $val = $CurrentForm->hasValue("total") ? $CurrentForm->getValue("total") : $CurrentForm->getValue("x_total");
        if (!$this->total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->total->Visible = false; // Disable update for API request
            } else {
                $this->total->setFormValue($val);
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
        $this->operator_id->CurrentValue = $this->operator_id->FormValue;
        $this->payment_date->CurrentValue = $this->payment_date->FormValue;
        $this->payment_date->CurrentValue = UnFormatDateTime($this->payment_date->CurrentValue, 5);
        $this->price_id->CurrentValue = $this->price_id->FormValue;
        $this->quantity->CurrentValue = $this->quantity->FormValue;
        $this->start_date->CurrentValue = $this->start_date->FormValue;
        $this->start_date->CurrentValue = UnFormatDateTime($this->start_date->CurrentValue, 5);
        $this->end_date->CurrentValue = $this->end_date->FormValue;
        $this->end_date->CurrentValue = UnFormatDateTime($this->end_date->CurrentValue, 5);
        $this->visible_status_id->CurrentValue = $this->visible_status_id->FormValue;
        $this->status_id->CurrentValue = $this->status_id->FormValue;
        $this->print_status_id->CurrentValue = $this->print_status_id->FormValue;
        $this->payment_status_id->CurrentValue = $this->payment_status_id->FormValue;
        $this->total->CurrentValue = $this->total->FormValue;
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
        $this->campaign_id->setDbValue($row['campaign_id']);
        if (array_key_exists('EV__campaign_id', $row)) {
            $this->campaign_id->VirtualValue = $row['EV__campaign_id']; // Set up virtual field value
        } else {
            $this->campaign_id->VirtualValue = ""; // Clear value
        }
        $this->operator_id->setDbValue($row['operator_id']);
        $this->payment_date->setDbValue($row['payment_date']);
        $this->price_id->setDbValue($row['price_id']);
        if (array_key_exists('EV__price_id', $row)) {
            $this->price_id->VirtualValue = $row['EV__price_id']; // Set up virtual field value
        } else {
            $this->price_id->VirtualValue = ""; // Clear value
        }
        $this->quantity->setDbValue($row['quantity']);
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
        $row['price_id'] = null;
        $row['quantity'] = null;
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

        // operator_id

        // payment_date

        // price_id

        // quantity

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
                        $sqlWrk = $this->campaign_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
                    $sqlWrk = $this->operator_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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

            // price_id
            if ($this->price_id->VirtualValue != "") {
                $this->price_id->ViewValue = $this->price_id->VirtualValue;
            } else {
                $curVal = strval($this->price_id->CurrentValue);
                if ($curVal != "") {
                    $this->price_id->ViewValue = $this->price_id->lookupCacheOption($curVal);
                    if ($this->price_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"price_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->price_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
                    $sqlWrk = $this->visible_status_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
                        $sqlWrk = $this->status_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
                        $sqlWrk = $this->print_status_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
                        $sqlWrk = $this->payment_status_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
                    $sqlWrk = $this->created_by->Lookup->getSql(false, $filterWrk, '', $this, true);
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

            // price_id
            $this->price_id->LinkCustomAttributes = "";
            $this->price_id->HrefValue = "";
            $this->price_id->TooltipValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";
            $this->quantity->TooltipValue = "";

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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // campaign_id
            $this->campaign_id->EditAttrs["class"] = "form-control";
            $this->campaign_id->EditCustomAttributes = "";
            if ($this->campaign_id->getSessionValue() != "") {
                $this->campaign_id->CurrentValue = GetForeignKeyValue($this->campaign_id->getSessionValue());
                if ($this->campaign_id->VirtualValue != "") {
                    $this->campaign_id->ViewValue = $this->campaign_id->VirtualValue;
                } else {
                    $curVal = strval($this->campaign_id->CurrentValue);
                    if ($curVal != "") {
                        $this->campaign_id->ViewValue = $this->campaign_id->lookupCacheOption($curVal);
                        if ($this->campaign_id->ViewValue === null) { // Lookup from database
                            $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                            $sqlWrk = $this->campaign_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
                    $sqlWrk = $this->campaign_id->Lookup->getSql(true, $filterWrk, '', $this);
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
                $curVal = strval($this->operator_id->CurrentValue);
                if ($curVal != "") {
                    $this->operator_id->ViewValue = $this->operator_id->lookupCacheOption($curVal);
                    if ($this->operator_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "\"operator_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->operator_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
                    $sqlWrk = $this->operator_id->Lookup->getSql(true, $filterWrk, '', $this);
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
                $sqlWrk = $this->price_id->Lookup->getSql(true, $filterWrk, '', $this);
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
                $sqlWrk = $this->visible_status_id->Lookup->getSql(true, $filterWrk, '', $this);
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
                $sqlWrk = $this->status_id->Lookup->getSql(true, $filterWrk, '', $this);
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
                $sqlWrk = $this->print_status_id->Lookup->getSql(true, $filterWrk, '', $this);
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
                $sqlWrk = $this->payment_status_id->Lookup->getSql(true, $filterWrk, '', $this);
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

            // campaign_id
            $this->campaign_id->LinkCustomAttributes = "";
            $this->campaign_id->HrefValue = "";

            // operator_id
            $this->operator_id->LinkCustomAttributes = "";
            $this->operator_id->HrefValue = "";

            // payment_date
            $this->payment_date->LinkCustomAttributes = "";
            $this->payment_date->HrefValue = "";

            // price_id
            $this->price_id->LinkCustomAttributes = "";
            $this->price_id->HrefValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";

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

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("SubTransactionDetailsGrid");
        if (in_array("sub_transaction_details", $detailTblVar) && $detailPage->DetailEdit) {
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
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
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

            // campaign_id
            $this->campaign_id->setDbValueDef($rsnew, $this->campaign_id->CurrentValue, 0, $this->campaign_id->ReadOnly);

            // operator_id
            $this->operator_id->setDbValueDef($rsnew, $this->operator_id->CurrentValue, 0, $this->operator_id->ReadOnly);

            // payment_date
            $this->payment_date->setDbValueDef($rsnew, UnFormatDateTime($this->payment_date->CurrentValue, 5), null, $this->payment_date->ReadOnly);

            // price_id
            $this->price_id->setDbValueDef($rsnew, $this->price_id->CurrentValue, null, $this->price_id->ReadOnly);

            // quantity
            $this->quantity->setDbValueDef($rsnew, $this->quantity->CurrentValue, 0, $this->quantity->ReadOnly);

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

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("SubTransactionDetailsGrid");
                    if (in_array("sub_transaction_details", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "sub_transaction_details"); // Load user level of detail table
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
            $this->setSessionWhere($this->getDetailFilter());

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
            if (in_array("sub_transaction_details", $detailTblVar)) {
                $detailPageObj = Container("SubTransactionDetailsGrid");
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
                    $detailPageObj->transaction_id->IsDetailKey = true;
                    $detailPageObj->transaction_id->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->transaction_id->setSessionValue($detailPageObj->transaction_id->CurrentValue);
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
            if (in_array("sub_transaction_details", $detailTblVar)) {
                $detailPageObj = Container("SubTransactionDetailsGrid");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("maintransactionslist"), "", $this->TableVar, true);
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
                    break;
                case "x_operator_id":
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
    					$this->total->Visible = FALSE;
    				}
    			}else{
    				// DEFAULT
    				$this->status_id->Visible = FALSE;
    			}
    	}

    	// CAMPAIGN MANAGER
    	if(CurrentUserLevel() == 1){
    		$this->status_id->Visible = FALSE;
    		$this->payment_status_id->Visible = FALSE;
    		//$this->print_status_id->Visible = FALSE;
    	}else

    	// ACCOUNTS / FINANCE
    	if(CurrentUserLevel() == 2){
    		$this->status_id->Visible = FALSE;
    		//$this->payment_status_id->Visible = FALSE;
    		$this->print_status_id->Visible = FALSE;
    	}else{
    		$this->status_id->Visible = FALSE;
    		$this->payment_status_id->Visible = FALSE;
    		$this->print_status_id->Visible = FALSE;
    	}
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

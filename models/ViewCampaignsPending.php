<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for view_campaigns_pending
 */
class ViewCampaignsPending extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $transaction_id;
    public $campaign;
    public $transaction_status;
    public $status_id;
    public $payment_status;
    public $payment_date;
    public $inventory;
    public $bus_size;
    public $vendor;
    public $operator;
    public $print_stage;
    public $platform;
    public $quantity;
    public $operator_fee;
    public $price;
    public $lamata_fee;
    public $agency_fee;
    public $lasaa_fee;
    public $printers_fee;
    public $payment_status_id;
    public $vendor_id;
    public $inventory_id;
    public $platform_id;
    public $operator_id;
    public $bus_size_id;
    public $total;
    public $start_date;
    public $end_date;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'view_campaigns_pending';
        $this->TableName = 'view_campaigns_pending';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "\"view_campaigns_pending\"";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // transaction_id
        $this->transaction_id = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_transaction_id', 'transaction_id', '"transaction_id"', 'CAST("transaction_id" AS varchar(255))', 3, 4, -1, false, '"transaction_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->transaction_id->IsPrimaryKey = true; // Primary key field
        $this->transaction_id->IsForeignKey = true; // Foreign key field
        $this->transaction_id->Sortable = true; // Allow sort
        $this->transaction_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['transaction_id'] = &$this->transaction_id;

        // campaign
        $this->campaign = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_campaign', 'campaign', '"campaign"', '"campaign"', 201, 0, -1, false, '"campaign"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->campaign->Sortable = true; // Allow sort
        $this->Fields['campaign'] = &$this->campaign;

        // transaction_status
        $this->transaction_status = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_transaction_status', 'transaction_status', '"transaction_status"', '"transaction_status"', 200, 0, -1, false, '"transaction_status"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->transaction_status->Sortable = true; // Allow sort
        $this->Fields['transaction_status'] = &$this->transaction_status;

        // status_id
        $this->status_id = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_status_id', 'status_id', '"status_id"', 'CAST("status_id" AS varchar(255))', 3, 4, -1, false, '"status_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->status_id->Sortable = true; // Allow sort
        $this->status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status_id->Lookup = new Lookup('status_id', 'x_transaction_status', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_id'] = &$this->status_id;

        // payment_status
        $this->payment_status = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_payment_status', 'payment_status', '"payment_status"', '"payment_status"', 200, 0, -1, false, '"payment_status"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->payment_status->Sortable = true; // Allow sort
        $this->Fields['payment_status'] = &$this->payment_status;

        // payment_date
        $this->payment_date = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_payment_date', 'payment_date', '"payment_date"', CastDateFieldForLike("\"payment_date\"", 0, "DB"), 133, 4, 0, false, '"payment_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->payment_date->Sortable = true; // Allow sort
        $this->payment_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['payment_date'] = &$this->payment_date;

        // inventory
        $this->inventory = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_inventory', 'inventory', '"inventory"', '"inventory"', 201, 0, -1, false, '"inventory"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->inventory->Sortable = true; // Allow sort
        $this->Fields['inventory'] = &$this->inventory;

        // bus_size
        $this->bus_size = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_bus_size', 'bus_size', '"bus_size"', '"bus_size"', 201, 0, -1, false, '"bus_size"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bus_size->Sortable = true; // Allow sort
        $this->Fields['bus_size'] = &$this->bus_size;

        // vendor
        $this->vendor = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_vendor', 'vendor', '"vendor"', '"vendor"', 200, 0, -1, false, '"vendor"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->vendor->Sortable = true; // Allow sort
        $this->Fields['vendor'] = &$this->vendor;

        // operator
        $this->operator = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_operator', 'operator', '"operator"', '"operator"', 200, 50, -1, false, '"operator"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->operator->Sortable = true; // Allow sort
        $this->Fields['operator'] = &$this->operator;

        // print_stage
        $this->print_stage = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_print_stage', 'print_stage', '"print_stage"', '"print_stage"', 201, 0, -1, false, '"print_stage"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->print_stage->Sortable = true; // Allow sort
        $this->Fields['print_stage'] = &$this->print_stage;

        // platform
        $this->platform = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_platform', 'platform', '"platform"', '"platform"', 200, 50, -1, false, '"platform"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->platform->Sortable = true; // Allow sort
        $this->Fields['platform'] = &$this->platform;

        // quantity
        $this->quantity = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_quantity', 'quantity', '"quantity"', 'CAST("quantity" AS varchar(255))', 3, 4, -1, false, '"quantity"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->quantity->Sortable = true; // Allow sort
        $this->quantity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['quantity'] = &$this->quantity;

        // operator_fee
        $this->operator_fee = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_operator_fee', 'operator_fee', '"operator_fee"', 'CAST("operator_fee" AS varchar(255))', 20, 8, -1, false, '"operator_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->operator_fee->Sortable = true; // Allow sort
        $this->operator_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['operator_fee'] = &$this->operator_fee;

        // price
        $this->price = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_price', 'price', '"price"', 'CAST("price" AS varchar(255))', 20, 8, -1, false, '"price"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->price->Sortable = true; // Allow sort
        $this->price->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['price'] = &$this->price;

        // lamata_fee
        $this->lamata_fee = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_lamata_fee', 'lamata_fee', '"lamata_fee"', 'CAST("lamata_fee" AS varchar(255))', 20, 8, -1, false, '"lamata_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lamata_fee->Sortable = true; // Allow sort
        $this->lamata_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['lamata_fee'] = &$this->lamata_fee;

        // agency_fee
        $this->agency_fee = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_agency_fee', 'agency_fee', '"agency_fee"', 'CAST("agency_fee" AS varchar(255))', 20, 8, -1, false, '"agency_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->agency_fee->Sortable = true; // Allow sort
        $this->agency_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['agency_fee'] = &$this->agency_fee;

        // lasaa_fee
        $this->lasaa_fee = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_lasaa_fee', 'lasaa_fee', '"lasaa_fee"', 'CAST("lasaa_fee" AS varchar(255))', 20, 8, -1, false, '"lasaa_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lasaa_fee->Sortable = true; // Allow sort
        $this->lasaa_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['lasaa_fee'] = &$this->lasaa_fee;

        // printers_fee
        $this->printers_fee = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_printers_fee', 'printers_fee', '"printers_fee"', 'CAST("printers_fee" AS varchar(255))', 20, 8, -1, false, '"printers_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->printers_fee->Sortable = true; // Allow sort
        $this->printers_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['printers_fee'] = &$this->printers_fee;

        // payment_status_id
        $this->payment_status_id = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_payment_status_id', 'payment_status_id', '"payment_status_id"', 'CAST("payment_status_id" AS varchar(255))', 3, 4, -1, false, '"payment_status_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->payment_status_id->Sortable = true; // Allow sort
        $this->payment_status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['payment_status_id'] = &$this->payment_status_id;

        // vendor_id
        $this->vendor_id = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_vendor_id', 'vendor_id', '"vendor_id"', 'CAST("vendor_id" AS varchar(255))', 3, 4, -1, false, '"vendor_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->vendor_id->Sortable = true; // Allow sort
        $this->vendor_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['vendor_id'] = &$this->vendor_id;

        // inventory_id
        $this->inventory_id = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_inventory_id', 'inventory_id', '"inventory_id"', 'CAST("inventory_id" AS varchar(255))', 3, 4, -1, false, '"inventory_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->inventory_id->Sortable = true; // Allow sort
        $this->inventory_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['inventory_id'] = &$this->inventory_id;

        // platform_id
        $this->platform_id = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_platform_id', 'platform_id', '"platform_id"', 'CAST("platform_id" AS varchar(255))', 3, 4, -1, false, '"platform_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->platform_id->Sortable = true; // Allow sort
        $this->platform_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['platform_id'] = &$this->platform_id;

        // operator_id
        $this->operator_id = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_operator_id', 'operator_id', '"operator_id"', 'CAST("operator_id" AS varchar(255))', 3, 4, -1, false, '"operator_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->operator_id->Sortable = true; // Allow sort
        $this->operator_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['operator_id'] = &$this->operator_id;

        // bus_size_id
        $this->bus_size_id = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_bus_size_id', 'bus_size_id', '"bus_size_id"', 'CAST("bus_size_id" AS varchar(255))', 3, 4, -1, false, '"bus_size_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bus_size_id->Sortable = true; // Allow sort
        $this->bus_size_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['bus_size_id'] = &$this->bus_size_id;

        // total
        $this->total = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_total', 'total', 'quantity * operator_fee', 'CAST(quantity * operator_fee AS varchar(255))', 20, 8, -1, false, 'quantity * operator_fee', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->total->IsCustom = true; // Custom field
        $this->total->Sortable = true; // Allow sort
        $this->total->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['total'] = &$this->total;

        // start_date
        $this->start_date = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_start_date', 'start_date', '"start_date"', CastDateFieldForLike("\"start_date\"", 0, "DB"), 133, 4, 0, false, '"start_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->start_date->Sortable = true; // Allow sort
        $this->start_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['start_date'] = &$this->start_date;

        // end_date
        $this->end_date = new DbField('view_campaigns_pending', 'view_campaigns_pending', 'x_end_date', 'end_date', '"end_date"', CastDateFieldForLike("\"end_date\"", 0, "DB"), 133, 4, 0, false, '"end_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->end_date->Sortable = true; // Allow sort
        $this->end_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['end_date'] = &$this->end_date;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")];
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "view_buses_assigned") {
            $detailUrl = Container("view_buses_assigned")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_transaction_id", $this->transaction_id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "viewcampaignspendinglist";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"view_campaigns_pending\"";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*, quantity * operator_fee AS \"total\"");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "operator_id in (select operator_id from w_vendors_operators where vendor_id = ".Profile()->vendor_id.")";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sql = $sql->resetQueryPart("orderBy")->getSQL();
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sql) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sql) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sql) && !preg_match('/\s+order\s+by\s+/i', $sql)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('transaction_id', $rs)) {
                AddFilter($where, QuotedName('transaction_id', $this->Dbid) . '=' . QuotedValue($rs['transaction_id'], $this->transaction_id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->transaction_id->DbValue = $row['transaction_id'];
        $this->campaign->DbValue = $row['campaign'];
        $this->transaction_status->DbValue = $row['transaction_status'];
        $this->status_id->DbValue = $row['status_id'];
        $this->payment_status->DbValue = $row['payment_status'];
        $this->payment_date->DbValue = $row['payment_date'];
        $this->inventory->DbValue = $row['inventory'];
        $this->bus_size->DbValue = $row['bus_size'];
        $this->vendor->DbValue = $row['vendor'];
        $this->operator->DbValue = $row['operator'];
        $this->print_stage->DbValue = $row['print_stage'];
        $this->platform->DbValue = $row['platform'];
        $this->quantity->DbValue = $row['quantity'];
        $this->operator_fee->DbValue = $row['operator_fee'];
        $this->price->DbValue = $row['price'];
        $this->lamata_fee->DbValue = $row['lamata_fee'];
        $this->agency_fee->DbValue = $row['agency_fee'];
        $this->lasaa_fee->DbValue = $row['lasaa_fee'];
        $this->printers_fee->DbValue = $row['printers_fee'];
        $this->payment_status_id->DbValue = $row['payment_status_id'];
        $this->vendor_id->DbValue = $row['vendor_id'];
        $this->inventory_id->DbValue = $row['inventory_id'];
        $this->platform_id->DbValue = $row['platform_id'];
        $this->operator_id->DbValue = $row['operator_id'];
        $this->bus_size_id->DbValue = $row['bus_size_id'];
        $this->total->DbValue = $row['total'];
        $this->start_date->DbValue = $row['start_date'];
        $this->end_date->DbValue = $row['end_date'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "\"transaction_id\" = @transaction_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->transaction_id->CurrentValue : $this->transaction_id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->transaction_id->CurrentValue = $keys[0];
            } else {
                $this->transaction_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('transaction_id', $row) ? $row['transaction_id'] : null;
        } else {
            $val = $this->transaction_id->OldValue !== null ? $this->transaction_id->OldValue : $this->transaction_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@transaction_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if (ReferUrl() != "" && ReferPageName() != CurrentPageName() && ReferPageName() != "login") { // Referer not same page or login page
            $_SESSION[$name] = ReferUrl(); // Save to Session
        }
        if (@$_SESSION[$name] != "") {
            return $_SESSION[$name];
        } else {
            return GetUrl("viewcampaignspendinglist");
        }
    }

    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "viewcampaignspendingview") {
            return $Language->phrase("View");
        } elseif ($pageName == "viewcampaignspendingedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "viewcampaignspendingadd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "ViewCampaignsPendingView";
            case Config("API_ADD_ACTION"):
                return "ViewCampaignsPendingAdd";
            case Config("API_EDIT_ACTION"):
                return "ViewCampaignsPendingEdit";
            case Config("API_DELETE_ACTION"):
                return "ViewCampaignsPendingDelete";
            case Config("API_LIST_ACTION"):
                return "ViewCampaignsPendingList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "viewcampaignspendinglist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("viewcampaignspendingview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("viewcampaignspendingview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "viewcampaignspendingadd?" . $this->getUrlParm($parm);
        } else {
            $url = "viewcampaignspendingadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("viewcampaignspendingedit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("viewcampaignspendingedit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("viewcampaignspendingadd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("viewcampaignspendingadd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("viewcampaignspendingdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "transaction_id:" . JsonEncode($this->transaction_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->transaction_id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->transaction_id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("transaction_id") ?? Route("transaction_id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->transaction_id->CurrentValue = $key;
            } else {
                $this->transaction_id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->transaction_id->setDbValue($row['transaction_id']);
        $this->campaign->setDbValue($row['campaign']);
        $this->transaction_status->setDbValue($row['transaction_status']);
        $this->status_id->setDbValue($row['status_id']);
        $this->payment_status->setDbValue($row['payment_status']);
        $this->payment_date->setDbValue($row['payment_date']);
        $this->inventory->setDbValue($row['inventory']);
        $this->bus_size->setDbValue($row['bus_size']);
        $this->vendor->setDbValue($row['vendor']);
        $this->operator->setDbValue($row['operator']);
        $this->print_stage->setDbValue($row['print_stage']);
        $this->platform->setDbValue($row['platform']);
        $this->quantity->setDbValue($row['quantity']);
        $this->operator_fee->setDbValue($row['operator_fee']);
        $this->price->setDbValue($row['price']);
        $this->lamata_fee->setDbValue($row['lamata_fee']);
        $this->agency_fee->setDbValue($row['agency_fee']);
        $this->lasaa_fee->setDbValue($row['lasaa_fee']);
        $this->printers_fee->setDbValue($row['printers_fee']);
        $this->payment_status_id->setDbValue($row['payment_status_id']);
        $this->vendor_id->setDbValue($row['vendor_id']);
        $this->inventory_id->setDbValue($row['inventory_id']);
        $this->platform_id->setDbValue($row['platform_id']);
        $this->operator_id->setDbValue($row['operator_id']);
        $this->bus_size_id->setDbValue($row['bus_size_id']);
        $this->total->setDbValue($row['total']);
        $this->start_date->setDbValue($row['start_date']);
        $this->end_date->setDbValue($row['end_date']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // transaction_id
        $this->transaction_id->CellCssStyle = "white-space: nowrap;";

        // campaign
        $this->campaign->CellCssStyle = "white-space: nowrap;";

        // transaction_status
        $this->transaction_status->CellCssStyle = "white-space: nowrap;";

        // status_id
        $this->status_id->CellCssStyle = "white-space: nowrap;";

        // payment_status
        $this->payment_status->CellCssStyle = "white-space: nowrap;";

        // payment_date
        $this->payment_date->CellCssStyle = "white-space: nowrap;";

        // inventory
        $this->inventory->CellCssStyle = "white-space: nowrap;";

        // bus_size
        $this->bus_size->CellCssStyle = "white-space: nowrap;";

        // vendor
        $this->vendor->CellCssStyle = "white-space: nowrap;";

        // operator
        $this->operator->CellCssStyle = "white-space: nowrap;";

        // print_stage
        $this->print_stage->CellCssStyle = "white-space: nowrap;";

        // platform
        $this->platform->CellCssStyle = "white-space: nowrap;";

        // quantity
        $this->quantity->CellCssStyle = "white-space: nowrap;";

        // operator_fee
        $this->operator_fee->CellCssStyle = "white-space: nowrap;";

        // price
        $this->price->CellCssStyle = "white-space: nowrap;";

        // lamata_fee
        $this->lamata_fee->CellCssStyle = "white-space: nowrap;";

        // agency_fee
        $this->agency_fee->CellCssStyle = "white-space: nowrap;";

        // lasaa_fee
        $this->lasaa_fee->CellCssStyle = "white-space: nowrap;";

        // printers_fee
        $this->printers_fee->CellCssStyle = "white-space: nowrap;";

        // payment_status_id
        $this->payment_status_id->CellCssStyle = "white-space: nowrap;";

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

        // total
        $this->total->CellCssStyle = "white-space: nowrap;";

        // start_date
        $this->start_date->CellCssStyle = "white-space: nowrap;";

        // end_date
        $this->end_date->CellCssStyle = "white-space: nowrap;";

        // transaction_id
        $this->transaction_id->ViewValue = $this->transaction_id->CurrentValue;
        $this->transaction_id->ViewValue = FormatNumber($this->transaction_id->ViewValue, 0, -2, -2, -2);
        $this->transaction_id->ViewCustomAttributes = "";

        // campaign
        $this->campaign->ViewValue = $this->campaign->CurrentValue;
        $this->campaign->CssClass = "font-weight-bold";
        $this->campaign->ViewCustomAttributes = "";

        // transaction_status
        $this->transaction_status->ViewValue = $this->transaction_status->CurrentValue;
        $this->transaction_status->CellCssStyle .= "text-align: center;";
        $this->transaction_status->ViewCustomAttributes = "";

        // status_id
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
        $this->status_id->CellCssStyle .= "text-align: center;";
        $this->status_id->ViewCustomAttributes = "";

        // payment_status
        $this->payment_status->ViewValue = $this->payment_status->CurrentValue;
        $this->payment_status->CellCssStyle .= "text-align: center;";
        $this->payment_status->ViewCustomAttributes = 'class="badge bg-success"';

        // payment_date
        $this->payment_date->ViewValue = $this->payment_date->CurrentValue;
        $this->payment_date->ViewValue = FormatDateTime($this->payment_date->ViewValue, 0);
        $this->payment_date->CellCssStyle .= "text-align: center;";
        $this->payment_date->ViewCustomAttributes = "";

        // inventory
        $this->inventory->ViewValue = $this->inventory->CurrentValue;
        $this->inventory->ViewCustomAttributes = "";

        // bus_size
        $this->bus_size->ViewValue = $this->bus_size->CurrentValue;
        $this->bus_size->ViewCustomAttributes = "";

        // vendor
        $this->vendor->ViewValue = $this->vendor->CurrentValue;
        $this->vendor->ViewCustomAttributes = "";

        // operator
        $this->operator->ViewValue = $this->operator->CurrentValue;
        $this->operator->ViewCustomAttributes = "";

        // print_stage
        $this->print_stage->ViewValue = $this->print_stage->CurrentValue;
        $this->print_stage->ViewCustomAttributes = "";

        // platform
        $this->platform->ViewValue = $this->platform->CurrentValue;
        $this->platform->ViewCustomAttributes = "";

        // quantity
        $this->quantity->ViewValue = $this->quantity->CurrentValue;
        $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
        $this->quantity->CellCssStyle .= "text-align: right;";
        $this->quantity->ViewCustomAttributes = "";

        // operator_fee
        $this->operator_fee->ViewValue = $this->operator_fee->CurrentValue;
        $this->operator_fee->ViewValue = FormatNumber($this->operator_fee->ViewValue, 0, -2, -2, -2);
        $this->operator_fee->CellCssStyle .= "text-align: right;";
        $this->operator_fee->ViewCustomAttributes = "";

        // price
        $this->price->ViewValue = $this->price->CurrentValue;
        $this->price->ViewValue = FormatNumber($this->price->ViewValue, 0, -2, -2, -2);
        $this->price->ViewCustomAttributes = "";

        // lamata_fee
        $this->lamata_fee->ViewValue = $this->lamata_fee->CurrentValue;
        $this->lamata_fee->ViewValue = FormatNumber($this->lamata_fee->ViewValue, 0, -2, -2, -2);
        $this->lamata_fee->ViewCustomAttributes = "";

        // agency_fee
        $this->agency_fee->ViewValue = $this->agency_fee->CurrentValue;
        $this->agency_fee->ViewValue = FormatNumber($this->agency_fee->ViewValue, 0, -2, -2, -2);
        $this->agency_fee->ViewCustomAttributes = "";

        // lasaa_fee
        $this->lasaa_fee->ViewValue = $this->lasaa_fee->CurrentValue;
        $this->lasaa_fee->ViewValue = FormatNumber($this->lasaa_fee->ViewValue, 0, -2, -2, -2);
        $this->lasaa_fee->ViewCustomAttributes = "";

        // printers_fee
        $this->printers_fee->ViewValue = $this->printers_fee->CurrentValue;
        $this->printers_fee->ViewValue = FormatNumber($this->printers_fee->ViewValue, 0, -2, -2, -2);
        $this->printers_fee->ViewCustomAttributes = "";

        // payment_status_id
        $this->payment_status_id->ViewValue = $this->payment_status_id->CurrentValue;
        $this->payment_status_id->ViewValue = FormatNumber($this->payment_status_id->ViewValue, 0, -2, -2, -2);
        $this->payment_status_id->ViewCustomAttributes = "";

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

        // transaction_id
        $this->transaction_id->LinkCustomAttributes = "";
        $this->transaction_id->HrefValue = "";
        $this->transaction_id->TooltipValue = "";

        // campaign
        $this->campaign->LinkCustomAttributes = "";
        $this->campaign->HrefValue = "";
        $this->campaign->TooltipValue = "";

        // transaction_status
        $this->transaction_status->LinkCustomAttributes = "";
        $this->transaction_status->HrefValue = "";
        $this->transaction_status->TooltipValue = "";

        // status_id
        $this->status_id->LinkCustomAttributes = "";
        if (!EmptyValue($this->transaction_id->CurrentValue)) {
            $this->status_id->HrefValue = (!empty($this->transaction_id->ViewValue) && !is_array($this->transaction_id->ViewValue) ? RemoveHtml($this->transaction_id->ViewValue) : $this->transaction_id->CurrentValue); // Add prefix/suffix
            $this->status_id->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->status_id->HrefValue = FullUrl($this->status_id->HrefValue, "href");
            }
        } else {
            $this->status_id->HrefValue = "";
        }
        $this->status_id->TooltipValue = "";

        // payment_status
        $this->payment_status->LinkCustomAttributes = "";
        $this->payment_status->HrefValue = "";
        $this->payment_status->TooltipValue = "";

        // payment_date
        $this->payment_date->LinkCustomAttributes = "";
        $this->payment_date->HrefValue = "";
        $this->payment_date->TooltipValue = "";

        // inventory
        $this->inventory->LinkCustomAttributes = "";
        $this->inventory->HrefValue = "";
        if (!$this->isExport()) {
            $this->inventory->TooltipValue = strval($this->print_stage->CurrentValue);
            if ($this->inventory->HrefValue == "") {
                $this->inventory->HrefValue = "javascript:void(0);";
            }
            $this->inventory->LinkAttrs->appendClass("ew-tooltip-link");
            $this->inventory->LinkAttrs["data-tooltip-id"] = "tt_view_campaigns_pending_x" . (($this->RowType != ROWTYPE_MASTER) ? @$this->RowCount : "") . "_inventory";
            $this->inventory->LinkAttrs["data-tooltip-width"] = $this->inventory->TooltipWidth;
            $this->inventory->LinkAttrs["data-placement"] = Config("CSS_FLIP") ? "left" : "right";
        }

        // bus_size
        $this->bus_size->LinkCustomAttributes = "";
        $this->bus_size->HrefValue = "";
        $this->bus_size->TooltipValue = "";

        // vendor
        $this->vendor->LinkCustomAttributes = "";
        $this->vendor->HrefValue = "";
        $this->vendor->TooltipValue = "";

        // operator
        $this->operator->LinkCustomAttributes = "";
        $this->operator->HrefValue = "";
        $this->operator->TooltipValue = "";

        // print_stage
        $this->print_stage->LinkCustomAttributes = "";
        $this->print_stage->HrefValue = "";
        $this->print_stage->TooltipValue = "";

        // platform
        $this->platform->LinkCustomAttributes = "";
        $this->platform->HrefValue = "";
        $this->platform->TooltipValue = "";

        // quantity
        $this->quantity->LinkCustomAttributes = "";
        $this->quantity->HrefValue = "";
        $this->quantity->TooltipValue = "";

        // operator_fee
        $this->operator_fee->LinkCustomAttributes = "";
        $this->operator_fee->HrefValue = "";
        $this->operator_fee->TooltipValue = "";

        // price
        $this->price->LinkCustomAttributes = "";
        $this->price->HrefValue = "";
        $this->price->TooltipValue = "";

        // lamata_fee
        $this->lamata_fee->LinkCustomAttributes = "";
        $this->lamata_fee->HrefValue = "";
        $this->lamata_fee->TooltipValue = "";

        // agency_fee
        $this->agency_fee->LinkCustomAttributes = "";
        $this->agency_fee->HrefValue = "";
        $this->agency_fee->TooltipValue = "";

        // lasaa_fee
        $this->lasaa_fee->LinkCustomAttributes = "";
        $this->lasaa_fee->HrefValue = "";
        $this->lasaa_fee->TooltipValue = "";

        // printers_fee
        $this->printers_fee->LinkCustomAttributes = "";
        $this->printers_fee->HrefValue = "";
        $this->printers_fee->TooltipValue = "";

        // payment_status_id
        $this->payment_status_id->LinkCustomAttributes = "";
        $this->payment_status_id->HrefValue = "";
        $this->payment_status_id->TooltipValue = "";

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

        // total
        $this->total->LinkCustomAttributes = "";
        $this->total->HrefValue = "";
        $this->total->TooltipValue = "";

        // start_date
        $this->start_date->LinkCustomAttributes = "";
        $this->start_date->HrefValue = "";
        $this->start_date->TooltipValue = "";

        // end_date
        $this->end_date->LinkCustomAttributes = "";
        $this->end_date->HrefValue = "";
        $this->end_date->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // transaction_id
        $this->transaction_id->EditAttrs["class"] = "form-control";
        $this->transaction_id->EditCustomAttributes = "";
        $this->transaction_id->EditValue = $this->transaction_id->CurrentValue;
        $this->transaction_id->PlaceHolder = RemoveHtml($this->transaction_id->caption());

        // campaign
        $this->campaign->EditAttrs["class"] = "form-control";
        $this->campaign->EditCustomAttributes = "";
        $this->campaign->EditValue = $this->campaign->CurrentValue;
        $this->campaign->PlaceHolder = RemoveHtml($this->campaign->caption());

        // transaction_status
        $this->transaction_status->EditAttrs["class"] = "form-control";
        $this->transaction_status->EditCustomAttributes = "";
        if (!$this->transaction_status->Raw) {
            $this->transaction_status->CurrentValue = HtmlDecode($this->transaction_status->CurrentValue);
        }
        $this->transaction_status->EditValue = $this->transaction_status->CurrentValue;
        $this->transaction_status->PlaceHolder = RemoveHtml($this->transaction_status->caption());

        // status_id
        $this->status_id->EditAttrs["class"] = "form-control";
        $this->status_id->EditCustomAttributes = "";
        $this->status_id->PlaceHolder = RemoveHtml($this->status_id->caption());

        // payment_status
        $this->payment_status->EditAttrs["class"] = "form-control";
        $this->payment_status->EditCustomAttributes = "";
        if (!$this->payment_status->Raw) {
            $this->payment_status->CurrentValue = HtmlDecode($this->payment_status->CurrentValue);
        }
        $this->payment_status->EditValue = $this->payment_status->CurrentValue;
        $this->payment_status->PlaceHolder = RemoveHtml($this->payment_status->caption());

        // payment_date
        $this->payment_date->EditAttrs["class"] = "form-control";
        $this->payment_date->EditCustomAttributes = "";
        $this->payment_date->EditValue = FormatDateTime($this->payment_date->CurrentValue, 8);
        $this->payment_date->PlaceHolder = RemoveHtml($this->payment_date->caption());

        // inventory
        $this->inventory->EditAttrs["class"] = "form-control";
        $this->inventory->EditCustomAttributes = "";
        $this->inventory->EditValue = $this->inventory->CurrentValue;
        $this->inventory->PlaceHolder = RemoveHtml($this->inventory->caption());

        // bus_size
        $this->bus_size->EditAttrs["class"] = "form-control";
        $this->bus_size->EditCustomAttributes = "";
        $this->bus_size->EditValue = $this->bus_size->CurrentValue;
        $this->bus_size->PlaceHolder = RemoveHtml($this->bus_size->caption());

        // vendor
        $this->vendor->EditAttrs["class"] = "form-control";
        $this->vendor->EditCustomAttributes = "";
        if (!$this->vendor->Raw) {
            $this->vendor->CurrentValue = HtmlDecode($this->vendor->CurrentValue);
        }
        $this->vendor->EditValue = $this->vendor->CurrentValue;
        $this->vendor->PlaceHolder = RemoveHtml($this->vendor->caption());

        // operator
        $this->operator->EditAttrs["class"] = "form-control";
        $this->operator->EditCustomAttributes = "";
        if (!$this->operator->Raw) {
            $this->operator->CurrentValue = HtmlDecode($this->operator->CurrentValue);
        }
        $this->operator->EditValue = $this->operator->CurrentValue;
        $this->operator->PlaceHolder = RemoveHtml($this->operator->caption());

        // print_stage
        $this->print_stage->EditAttrs["class"] = "form-control";
        $this->print_stage->EditCustomAttributes = "";
        $this->print_stage->EditValue = $this->print_stage->CurrentValue;
        $this->print_stage->PlaceHolder = RemoveHtml($this->print_stage->caption());

        // platform
        $this->platform->EditAttrs["class"] = "form-control";
        $this->platform->EditCustomAttributes = "";
        if (!$this->platform->Raw) {
            $this->platform->CurrentValue = HtmlDecode($this->platform->CurrentValue);
        }
        $this->platform->EditValue = $this->platform->CurrentValue;
        $this->platform->PlaceHolder = RemoveHtml($this->platform->caption());

        // quantity
        $this->quantity->EditAttrs["class"] = "form-control";
        $this->quantity->EditCustomAttributes = "";
        $this->quantity->EditValue = $this->quantity->CurrentValue;
        $this->quantity->PlaceHolder = RemoveHtml($this->quantity->caption());

        // operator_fee
        $this->operator_fee->EditAttrs["class"] = "form-control";
        $this->operator_fee->EditCustomAttributes = "";
        $this->operator_fee->EditValue = $this->operator_fee->CurrentValue;
        $this->operator_fee->PlaceHolder = RemoveHtml($this->operator_fee->caption());

        // price
        $this->price->EditAttrs["class"] = "form-control";
        $this->price->EditCustomAttributes = "";
        $this->price->EditValue = $this->price->CurrentValue;
        $this->price->PlaceHolder = RemoveHtml($this->price->caption());

        // lamata_fee
        $this->lamata_fee->EditAttrs["class"] = "form-control";
        $this->lamata_fee->EditCustomAttributes = "";
        $this->lamata_fee->EditValue = $this->lamata_fee->CurrentValue;
        $this->lamata_fee->PlaceHolder = RemoveHtml($this->lamata_fee->caption());

        // agency_fee
        $this->agency_fee->EditAttrs["class"] = "form-control";
        $this->agency_fee->EditCustomAttributes = "";
        $this->agency_fee->EditValue = $this->agency_fee->CurrentValue;
        $this->agency_fee->PlaceHolder = RemoveHtml($this->agency_fee->caption());

        // lasaa_fee
        $this->lasaa_fee->EditAttrs["class"] = "form-control";
        $this->lasaa_fee->EditCustomAttributes = "";
        $this->lasaa_fee->EditValue = $this->lasaa_fee->CurrentValue;
        $this->lasaa_fee->PlaceHolder = RemoveHtml($this->lasaa_fee->caption());

        // printers_fee
        $this->printers_fee->EditAttrs["class"] = "form-control";
        $this->printers_fee->EditCustomAttributes = "";
        $this->printers_fee->EditValue = $this->printers_fee->CurrentValue;
        $this->printers_fee->PlaceHolder = RemoveHtml($this->printers_fee->caption());

        // payment_status_id
        $this->payment_status_id->EditAttrs["class"] = "form-control";
        $this->payment_status_id->EditCustomAttributes = "";
        $this->payment_status_id->EditValue = $this->payment_status_id->CurrentValue;
        $this->payment_status_id->PlaceHolder = RemoveHtml($this->payment_status_id->caption());

        // vendor_id
        $this->vendor_id->EditAttrs["class"] = "form-control";
        $this->vendor_id->EditCustomAttributes = "";
        $this->vendor_id->EditValue = $this->vendor_id->CurrentValue;
        $this->vendor_id->PlaceHolder = RemoveHtml($this->vendor_id->caption());

        // inventory_id
        $this->inventory_id->EditAttrs["class"] = "form-control";
        $this->inventory_id->EditCustomAttributes = "";
        $this->inventory_id->EditValue = $this->inventory_id->CurrentValue;
        $this->inventory_id->PlaceHolder = RemoveHtml($this->inventory_id->caption());

        // platform_id
        $this->platform_id->EditAttrs["class"] = "form-control";
        $this->platform_id->EditCustomAttributes = "";
        $this->platform_id->EditValue = $this->platform_id->CurrentValue;
        $this->platform_id->PlaceHolder = RemoveHtml($this->platform_id->caption());

        // operator_id
        $this->operator_id->EditAttrs["class"] = "form-control";
        $this->operator_id->EditCustomAttributes = "";
        $this->operator_id->EditValue = $this->operator_id->CurrentValue;
        $this->operator_id->PlaceHolder = RemoveHtml($this->operator_id->caption());

        // bus_size_id
        $this->bus_size_id->EditAttrs["class"] = "form-control";
        $this->bus_size_id->EditCustomAttributes = "";
        $this->bus_size_id->EditValue = $this->bus_size_id->CurrentValue;
        $this->bus_size_id->PlaceHolder = RemoveHtml($this->bus_size_id->caption());

        // total
        $this->total->EditAttrs["class"] = "form-control";
        $this->total->EditCustomAttributes = "";
        $this->total->EditValue = $this->total->CurrentValue;
        $this->total->PlaceHolder = RemoveHtml($this->total->caption());

        // start_date
        $this->start_date->EditAttrs["class"] = "form-control";
        $this->start_date->EditCustomAttributes = "";
        $this->start_date->EditValue = FormatDateTime($this->start_date->CurrentValue, 8);
        $this->start_date->PlaceHolder = RemoveHtml($this->start_date->caption());

        // end_date
        $this->end_date->EditAttrs["class"] = "form-control";
        $this->end_date->EditCustomAttributes = "";
        $this->end_date->EditValue = FormatDateTime($this->end_date->CurrentValue, 8);
        $this->end_date->PlaceHolder = RemoveHtml($this->end_date->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            if (is_numeric($this->quantity->CurrentValue)) {
                $this->quantity->Total += $this->quantity->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->operator_fee->CurrentValue)) {
                $this->operator_fee->Total += $this->operator_fee->CurrentValue; // Accumulate total
            }
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->quantity->CurrentValue = $this->quantity->Total;
            $this->quantity->ViewValue = $this->quantity->CurrentValue;
            $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
            $this->quantity->CellCssStyle .= "text-align: right;";
            $this->quantity->ViewCustomAttributes = "";
            $this->quantity->HrefValue = ""; // Clear href value
            $this->operator_fee->CurrentValue = $this->operator_fee->Total;
            $this->operator_fee->ViewValue = $this->operator_fee->CurrentValue;
            $this->operator_fee->ViewValue = FormatNumber($this->operator_fee->ViewValue, 0, -2, -2, -2);
            $this->operator_fee->CellCssStyle .= "text-align: right;";
            $this->operator_fee->ViewCustomAttributes = "";
            $this->operator_fee->HrefValue = ""; // Clear href value

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->transaction_id);
                    $doc->exportCaption($this->campaign);
                    $doc->exportCaption($this->transaction_status);
                    $doc->exportCaption($this->payment_status);
                    $doc->exportCaption($this->payment_date);
                    $doc->exportCaption($this->inventory);
                    $doc->exportCaption($this->bus_size);
                    $doc->exportCaption($this->vendor);
                    $doc->exportCaption($this->operator);
                    $doc->exportCaption($this->print_stage);
                    $doc->exportCaption($this->platform);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->operator_fee);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->lamata_fee);
                    $doc->exportCaption($this->agency_fee);
                    $doc->exportCaption($this->lasaa_fee);
                    $doc->exportCaption($this->printers_fee);
                    $doc->exportCaption($this->payment_status_id);
                    $doc->exportCaption($this->total);
                    $doc->exportCaption($this->start_date);
                    $doc->exportCaption($this->end_date);
                } else {
                    $doc->exportCaption($this->transaction_id);
                    $doc->exportCaption($this->transaction_status);
                    $doc->exportCaption($this->payment_status);
                    $doc->exportCaption($this->payment_date);
                    $doc->exportCaption($this->inventory);
                    $doc->exportCaption($this->vendor);
                    $doc->exportCaption($this->operator);
                    $doc->exportCaption($this->print_stage);
                    $doc->exportCaption($this->platform);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->operator_fee);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->lamata_fee);
                    $doc->exportCaption($this->agency_fee);
                    $doc->exportCaption($this->lasaa_fee);
                    $doc->exportCaption($this->printers_fee);
                    $doc->exportCaption($this->payment_status_id);
                    $doc->exportCaption($this->total);
                    $doc->exportCaption($this->start_date);
                    $doc->exportCaption($this->end_date);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);
                $this->aggregateListRowValues(); // Aggregate row values

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->transaction_id);
                        $doc->exportField($this->campaign);
                        $doc->exportField($this->transaction_status);
                        $doc->exportField($this->payment_status);
                        $doc->exportField($this->payment_date);
                        $doc->exportField($this->inventory);
                        $doc->exportField($this->bus_size);
                        $doc->exportField($this->vendor);
                        $doc->exportField($this->operator);
                        $doc->exportField($this->print_stage);
                        $doc->exportField($this->platform);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->operator_fee);
                        $doc->exportField($this->price);
                        $doc->exportField($this->lamata_fee);
                        $doc->exportField($this->agency_fee);
                        $doc->exportField($this->lasaa_fee);
                        $doc->exportField($this->printers_fee);
                        $doc->exportField($this->payment_status_id);
                        $doc->exportField($this->total);
                        $doc->exportField($this->start_date);
                        $doc->exportField($this->end_date);
                    } else {
                        $doc->exportField($this->transaction_id);
                        $doc->exportField($this->transaction_status);
                        $doc->exportField($this->payment_status);
                        $doc->exportField($this->payment_date);
                        $doc->exportField($this->inventory);
                        $doc->exportField($this->vendor);
                        $doc->exportField($this->operator);
                        $doc->exportField($this->print_stage);
                        $doc->exportField($this->platform);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->operator_fee);
                        $doc->exportField($this->price);
                        $doc->exportField($this->lamata_fee);
                        $doc->exportField($this->agency_fee);
                        $doc->exportField($this->lasaa_fee);
                        $doc->exportField($this->printers_fee);
                        $doc->exportField($this->payment_status_id);
                        $doc->exportField($this->total);
                        $doc->exportField($this->start_date);
                        $doc->exportField($this->end_date);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }

        // Export aggregates (horizontal format only)
        if ($doc->Horizontal) {
            $this->RowType = ROWTYPE_AGGREGATE;
            $this->resetAttributes();
            $this->aggregateListRow();
            if (!$doc->ExportCustom) {
                $doc->beginExportRow(-1);
                $doc->exportAggregate($this->transaction_id, '');
                $doc->exportAggregate($this->transaction_status, '');
                $doc->exportAggregate($this->payment_status, '');
                $doc->exportAggregate($this->payment_date, '');
                $doc->exportAggregate($this->inventory, '');
                $doc->exportAggregate($this->vendor, '');
                $doc->exportAggregate($this->operator, '');
                $doc->exportAggregate($this->print_stage, '');
                $doc->exportAggregate($this->platform, '');
                $doc->exportAggregate($this->quantity, 'TOTAL');
                $doc->exportAggregate($this->operator_fee, 'TOTAL');
                $doc->exportAggregate($this->price, '');
                $doc->exportAggregate($this->lamata_fee, '');
                $doc->exportAggregate($this->agency_fee, '');
                $doc->exportAggregate($this->lasaa_fee, '');
                $doc->exportAggregate($this->printers_fee, '');
                $doc->exportAggregate($this->payment_status_id, '');
                $doc->exportAggregate($this->total, '');
                $doc->exportAggregate($this->start_date, '');
                $doc->exportAggregate($this->end_date, '');
                $doc->endExportRow();
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
          if($this->status_id->DbValue == 4){
                // APPROVE / DENY TRANSACTIONS
                $ws = 'style="white-space: nowrap;"';
                $this->status_id->LinkCustomAttributes = "class='btn-group' ";
                $onclick_approve = "onclick=\"return ew.submitAction(event, {action: 'approve', method: 'post', msg: 'Approve Campaign (".$this->campaign->ViewValue.") ?', key: " . $this->keyToJson(true) . "});\"";
                $onclick_deny = "onclick=\"return ew.submitAction(event, {action: 'deny', method: 'post', msg: 'Deny Campaign (".$this->campaign->ViewValue.") ?', key: " . $this->keyToJson(true) . "});\"";
                $btn_text = '<button type="button" '.$onclick_approve.' '.$ws.' class="btn btn-success">APPROVE</button>';
                $btn_text .= '<button type="button" '.$onclick_deny.' '.$ws.' class="btn btn-danger">DENY</button>';
                $this->status_id->ViewValue =  $btn_text;
                $this->status_id->HrefValue = "#";
            }
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}

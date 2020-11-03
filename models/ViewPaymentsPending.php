<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for view_payments_pending
 */
class ViewPaymentsPending extends DbTable
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
    public $campaign_id;
    public $campaign_name;
    public $quantity;
    public $campaign_status;
    public $print_status;
    public $payment_status;
    public $start_date;
    public $end_date;
    public $vendor;
    public $operator;
    public $platform;
    public $inventory;
    public $bus_size;
    public $print_stage;
    public $price;
    public $operator_fee;
    public $agency_fee;
    public $lamata_fee;
    public $lasaa_fee;
    public $printers_fee;
    public $price_details;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'view_payments_pending';
        $this->TableName = 'view_payments_pending';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "\"view_payments_pending\"";
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
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // transaction_id
        $this->transaction_id = new DbField('view_payments_pending', 'view_payments_pending', 'x_transaction_id', 'transaction_id', '"transaction_id"', 'CAST("transaction_id" AS varchar(255))', 3, 4, -1, false, '"transaction_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->transaction_id->Sortable = true; // Allow sort
        $this->transaction_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['transaction_id'] = &$this->transaction_id;

        // campaign_id
        $this->campaign_id = new DbField('view_payments_pending', 'view_payments_pending', 'x_campaign_id', 'campaign_id', '"campaign_id"', 'CAST("campaign_id" AS varchar(255))', 3, 4, -1, false, '"campaign_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->campaign_id->Sortable = true; // Allow sort
        $this->campaign_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['campaign_id'] = &$this->campaign_id;

        // campaign_name
        $this->campaign_name = new DbField('view_payments_pending', 'view_payments_pending', 'x_campaign_name', 'campaign_name', '"campaign_name"', '"campaign_name"', 201, 0, -1, false, '"campaign_name"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->campaign_name->Sortable = true; // Allow sort
        $this->Fields['campaign_name'] = &$this->campaign_name;

        // quantity
        $this->quantity = new DbField('view_payments_pending', 'view_payments_pending', 'x_quantity', 'quantity', '"quantity"', 'CAST("quantity" AS varchar(255))', 3, 4, -1, false, '"quantity"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->quantity->Sortable = true; // Allow sort
        $this->quantity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['quantity'] = &$this->quantity;

        // campaign_status
        $this->campaign_status = new DbField('view_payments_pending', 'view_payments_pending', 'x_campaign_status', 'campaign_status', '"campaign_status"', '"campaign_status"', 200, 0, -1, false, '"campaign_status"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->campaign_status->Sortable = true; // Allow sort
        $this->Fields['campaign_status'] = &$this->campaign_status;

        // print_status
        $this->print_status = new DbField('view_payments_pending', 'view_payments_pending', 'x_print_status', 'print_status', '"print_status"', '"print_status"', 200, 0, -1, false, '"print_status"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->print_status->Sortable = true; // Allow sort
        $this->Fields['print_status'] = &$this->print_status;

        // payment_status
        $this->payment_status = new DbField('view_payments_pending', 'view_payments_pending', 'x_payment_status', 'payment_status', '"payment_status"', '"payment_status"', 200, 0, -1, false, '"payment_status"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->payment_status->Sortable = true; // Allow sort
        $this->Fields['payment_status'] = &$this->payment_status;

        // start_date
        $this->start_date = new DbField('view_payments_pending', 'view_payments_pending', 'x_start_date', 'start_date', '"start_date"', CastDateFieldForLike("\"start_date\"", 0, "DB"), 133, 4, 0, false, '"start_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->start_date->Sortable = true; // Allow sort
        $this->start_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['start_date'] = &$this->start_date;

        // end_date
        $this->end_date = new DbField('view_payments_pending', 'view_payments_pending', 'x_end_date', 'end_date', '"end_date"', CastDateFieldForLike("\"end_date\"", 0, "DB"), 133, 4, 0, false, '"end_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->end_date->Sortable = true; // Allow sort
        $this->end_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['end_date'] = &$this->end_date;

        // vendor
        $this->vendor = new DbField('view_payments_pending', 'view_payments_pending', 'x_vendor', 'vendor', '"vendor"', '"vendor"', 200, 0, -1, false, '"vendor"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->vendor->Sortable = true; // Allow sort
        $this->Fields['vendor'] = &$this->vendor;

        // operator
        $this->operator = new DbField('view_payments_pending', 'view_payments_pending', 'x_operator', 'operator', '"operator"', '"operator"', 200, 50, -1, false, '"operator"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->operator->Sortable = true; // Allow sort
        $this->Fields['operator'] = &$this->operator;

        // platform
        $this->platform = new DbField('view_payments_pending', 'view_payments_pending', 'x_platform', 'platform', '"platform"', '"platform"', 200, 50, -1, false, '"platform"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->platform->Sortable = true; // Allow sort
        $this->Fields['platform'] = &$this->platform;

        // inventory
        $this->inventory = new DbField('view_payments_pending', 'view_payments_pending', 'x_inventory', 'inventory', '"inventory"', '"inventory"', 201, 0, -1, false, '"inventory"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->inventory->Sortable = true; // Allow sort
        $this->Fields['inventory'] = &$this->inventory;

        // bus_size
        $this->bus_size = new DbField('view_payments_pending', 'view_payments_pending', 'x_bus_size', 'bus_size', '"bus_size"', '"bus_size"', 201, 0, -1, false, '"bus_size"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bus_size->Sortable = true; // Allow sort
        $this->Fields['bus_size'] = &$this->bus_size;

        // print_stage
        $this->print_stage = new DbField('view_payments_pending', 'view_payments_pending', 'x_print_stage', 'print_stage', '"print_stage"', '"print_stage"', 201, 0, -1, false, '"print_stage"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->print_stage->Sortable = true; // Allow sort
        $this->Fields['print_stage'] = &$this->print_stage;

        // price
        $this->price = new DbField('view_payments_pending', 'view_payments_pending', 'x_price', 'price', '"price"', 'CAST("price" AS varchar(255))', 20, 8, -1, false, '"price"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->price->Sortable = true; // Allow sort
        $this->price->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['price'] = &$this->price;

        // operator_fee
        $this->operator_fee = new DbField('view_payments_pending', 'view_payments_pending', 'x_operator_fee', 'operator_fee', '"operator_fee"', 'CAST("operator_fee" AS varchar(255))', 20, 8, -1, false, '"operator_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->operator_fee->Sortable = true; // Allow sort
        $this->operator_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['operator_fee'] = &$this->operator_fee;

        // agency_fee
        $this->agency_fee = new DbField('view_payments_pending', 'view_payments_pending', 'x_agency_fee', 'agency_fee', '"agency_fee"', 'CAST("agency_fee" AS varchar(255))', 20, 8, -1, false, '"agency_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->agency_fee->Sortable = true; // Allow sort
        $this->agency_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['agency_fee'] = &$this->agency_fee;

        // lamata_fee
        $this->lamata_fee = new DbField('view_payments_pending', 'view_payments_pending', 'x_lamata_fee', 'lamata_fee', '"lamata_fee"', 'CAST("lamata_fee" AS varchar(255))', 20, 8, -1, false, '"lamata_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lamata_fee->Sortable = true; // Allow sort
        $this->lamata_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['lamata_fee'] = &$this->lamata_fee;

        // lasaa_fee
        $this->lasaa_fee = new DbField('view_payments_pending', 'view_payments_pending', 'x_lasaa_fee', 'lasaa_fee', '"lasaa_fee"', 'CAST("lasaa_fee" AS varchar(255))', 20, 8, -1, false, '"lasaa_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lasaa_fee->Sortable = true; // Allow sort
        $this->lasaa_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['lasaa_fee'] = &$this->lasaa_fee;

        // printers_fee
        $this->printers_fee = new DbField('view_payments_pending', 'view_payments_pending', 'x_printers_fee', 'printers_fee', '"printers_fee"', 'CAST("printers_fee" AS varchar(255))', 20, 8, -1, false, '"printers_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->printers_fee->Sortable = true; // Allow sort
        $this->printers_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['printers_fee'] = &$this->printers_fee;

        // price_details
        $this->price_details = new DbField('view_payments_pending', 'view_payments_pending', 'x_price_details', 'price_details', '"price_details"', '"price_details"', 201, 0, -1, false, '"price_details"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->price_details->Sortable = true; // Allow sort
        $this->Fields['price_details'] = &$this->price_details;
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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"view_payments_pending\"";
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
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
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
        $this->DefaultFilter = "";
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
        $this->campaign_id->DbValue = $row['campaign_id'];
        $this->campaign_name->DbValue = $row['campaign_name'];
        $this->quantity->DbValue = $row['quantity'];
        $this->campaign_status->DbValue = $row['campaign_status'];
        $this->print_status->DbValue = $row['print_status'];
        $this->payment_status->DbValue = $row['payment_status'];
        $this->start_date->DbValue = $row['start_date'];
        $this->end_date->DbValue = $row['end_date'];
        $this->vendor->DbValue = $row['vendor'];
        $this->operator->DbValue = $row['operator'];
        $this->platform->DbValue = $row['platform'];
        $this->inventory->DbValue = $row['inventory'];
        $this->bus_size->DbValue = $row['bus_size'];
        $this->print_stage->DbValue = $row['print_stage'];
        $this->price->DbValue = $row['price'];
        $this->operator_fee->DbValue = $row['operator_fee'];
        $this->agency_fee->DbValue = $row['agency_fee'];
        $this->lamata_fee->DbValue = $row['lamata_fee'];
        $this->lasaa_fee->DbValue = $row['lasaa_fee'];
        $this->printers_fee->DbValue = $row['printers_fee'];
        $this->price_details->DbValue = $row['price_details'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 0) {
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
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
            return GetUrl("viewpaymentspendinglist");
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
        if ($pageName == "viewpaymentspendingview") {
            return $Language->phrase("View");
        } elseif ($pageName == "viewpaymentspendingedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "viewpaymentspendingadd") {
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
                return "ViewPaymentsPendingView";
            case Config("API_ADD_ACTION"):
                return "ViewPaymentsPendingAdd";
            case Config("API_EDIT_ACTION"):
                return "ViewPaymentsPendingEdit";
            case Config("API_DELETE_ACTION"):
                return "ViewPaymentsPendingDelete";
            case Config("API_LIST_ACTION"):
                return "ViewPaymentsPendingList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "viewpaymentspendinglist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("viewpaymentspendingview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("viewpaymentspendingview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "viewpaymentspendingadd?" . $this->getUrlParm($parm);
        } else {
            $url = "viewpaymentspendingadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("viewpaymentspendingedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("viewpaymentspendingadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("viewpaymentspendingdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
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
            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
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
        $this->campaign_id->setDbValue($row['campaign_id']);
        $this->campaign_name->setDbValue($row['campaign_name']);
        $this->quantity->setDbValue($row['quantity']);
        $this->campaign_status->setDbValue($row['campaign_status']);
        $this->print_status->setDbValue($row['print_status']);
        $this->payment_status->setDbValue($row['payment_status']);
        $this->start_date->setDbValue($row['start_date']);
        $this->end_date->setDbValue($row['end_date']);
        $this->vendor->setDbValue($row['vendor']);
        $this->operator->setDbValue($row['operator']);
        $this->platform->setDbValue($row['platform']);
        $this->inventory->setDbValue($row['inventory']);
        $this->bus_size->setDbValue($row['bus_size']);
        $this->print_stage->setDbValue($row['print_stage']);
        $this->price->setDbValue($row['price']);
        $this->operator_fee->setDbValue($row['operator_fee']);
        $this->agency_fee->setDbValue($row['agency_fee']);
        $this->lamata_fee->setDbValue($row['lamata_fee']);
        $this->lasaa_fee->setDbValue($row['lasaa_fee']);
        $this->printers_fee->setDbValue($row['printers_fee']);
        $this->price_details->setDbValue($row['price_details']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // transaction_id

        // campaign_id

        // campaign_name

        // quantity

        // campaign_status

        // print_status

        // payment_status

        // start_date

        // end_date

        // vendor

        // operator

        // platform

        // inventory

        // bus_size

        // print_stage

        // price

        // operator_fee

        // agency_fee

        // lamata_fee

        // lasaa_fee

        // printers_fee

        // price_details

        // transaction_id
        $this->transaction_id->ViewValue = $this->transaction_id->CurrentValue;
        $this->transaction_id->ViewValue = FormatNumber($this->transaction_id->ViewValue, 0, -2, -2, -2);
        $this->transaction_id->ViewCustomAttributes = "";

        // campaign_id
        $this->campaign_id->ViewValue = $this->campaign_id->CurrentValue;
        $this->campaign_id->ViewValue = FormatNumber($this->campaign_id->ViewValue, 0, -2, -2, -2);
        $this->campaign_id->ViewCustomAttributes = "";

        // campaign_name
        $this->campaign_name->ViewValue = $this->campaign_name->CurrentValue;
        $this->campaign_name->ViewCustomAttributes = "";

        // quantity
        $this->quantity->ViewValue = $this->quantity->CurrentValue;
        $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
        $this->quantity->ViewCustomAttributes = "";

        // campaign_status
        $this->campaign_status->ViewValue = $this->campaign_status->CurrentValue;
        $this->campaign_status->ViewCustomAttributes = "";

        // print_status
        $this->print_status->ViewValue = $this->print_status->CurrentValue;
        $this->print_status->ViewCustomAttributes = "";

        // payment_status
        $this->payment_status->ViewValue = $this->payment_status->CurrentValue;
        $this->payment_status->ViewCustomAttributes = "";

        // start_date
        $this->start_date->ViewValue = $this->start_date->CurrentValue;
        $this->start_date->ViewValue = FormatDateTime($this->start_date->ViewValue, 0);
        $this->start_date->ViewCustomAttributes = "";

        // end_date
        $this->end_date->ViewValue = $this->end_date->CurrentValue;
        $this->end_date->ViewValue = FormatDateTime($this->end_date->ViewValue, 0);
        $this->end_date->ViewCustomAttributes = "";

        // vendor
        $this->vendor->ViewValue = $this->vendor->CurrentValue;
        $this->vendor->ViewCustomAttributes = "";

        // operator
        $this->operator->ViewValue = $this->operator->CurrentValue;
        $this->operator->ViewCustomAttributes = "";

        // platform
        $this->platform->ViewValue = $this->platform->CurrentValue;
        $this->platform->ViewCustomAttributes = "";

        // inventory
        $this->inventory->ViewValue = $this->inventory->CurrentValue;
        $this->inventory->ViewCustomAttributes = "";

        // bus_size
        $this->bus_size->ViewValue = $this->bus_size->CurrentValue;
        $this->bus_size->ViewCustomAttributes = "";

        // print_stage
        $this->print_stage->ViewValue = $this->print_stage->CurrentValue;
        $this->print_stage->ViewCustomAttributes = "";

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

        // price_details
        $this->price_details->ViewValue = $this->price_details->CurrentValue;
        $this->price_details->ViewCustomAttributes = "";

        // transaction_id
        $this->transaction_id->LinkCustomAttributes = "";
        $this->transaction_id->HrefValue = "";
        $this->transaction_id->TooltipValue = "";

        // campaign_id
        $this->campaign_id->LinkCustomAttributes = "";
        $this->campaign_id->HrefValue = "";
        $this->campaign_id->TooltipValue = "";

        // campaign_name
        $this->campaign_name->LinkCustomAttributes = "";
        $this->campaign_name->HrefValue = "";
        $this->campaign_name->TooltipValue = "";

        // quantity
        $this->quantity->LinkCustomAttributes = "";
        $this->quantity->HrefValue = "";
        $this->quantity->TooltipValue = "";

        // campaign_status
        $this->campaign_status->LinkCustomAttributes = "";
        $this->campaign_status->HrefValue = "";
        $this->campaign_status->TooltipValue = "";

        // print_status
        $this->print_status->LinkCustomAttributes = "";
        $this->print_status->HrefValue = "";
        $this->print_status->TooltipValue = "";

        // payment_status
        $this->payment_status->LinkCustomAttributes = "";
        $this->payment_status->HrefValue = "";
        $this->payment_status->TooltipValue = "";

        // start_date
        $this->start_date->LinkCustomAttributes = "";
        $this->start_date->HrefValue = "";
        $this->start_date->TooltipValue = "";

        // end_date
        $this->end_date->LinkCustomAttributes = "";
        $this->end_date->HrefValue = "";
        $this->end_date->TooltipValue = "";

        // vendor
        $this->vendor->LinkCustomAttributes = "";
        $this->vendor->HrefValue = "";
        $this->vendor->TooltipValue = "";

        // operator
        $this->operator->LinkCustomAttributes = "";
        $this->operator->HrefValue = "";
        $this->operator->TooltipValue = "";

        // platform
        $this->platform->LinkCustomAttributes = "";
        $this->platform->HrefValue = "";
        $this->platform->TooltipValue = "";

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

        // price_details
        $this->price_details->LinkCustomAttributes = "";
        $this->price_details->HrefValue = "";
        $this->price_details->TooltipValue = "";

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

        // campaign_id
        $this->campaign_id->EditAttrs["class"] = "form-control";
        $this->campaign_id->EditCustomAttributes = "";
        $this->campaign_id->EditValue = $this->campaign_id->CurrentValue;
        $this->campaign_id->PlaceHolder = RemoveHtml($this->campaign_id->caption());

        // campaign_name
        $this->campaign_name->EditAttrs["class"] = "form-control";
        $this->campaign_name->EditCustomAttributes = "";
        $this->campaign_name->EditValue = $this->campaign_name->CurrentValue;
        $this->campaign_name->PlaceHolder = RemoveHtml($this->campaign_name->caption());

        // quantity
        $this->quantity->EditAttrs["class"] = "form-control";
        $this->quantity->EditCustomAttributes = "";
        $this->quantity->EditValue = $this->quantity->CurrentValue;
        $this->quantity->PlaceHolder = RemoveHtml($this->quantity->caption());

        // campaign_status
        $this->campaign_status->EditAttrs["class"] = "form-control";
        $this->campaign_status->EditCustomAttributes = "";
        if (!$this->campaign_status->Raw) {
            $this->campaign_status->CurrentValue = HtmlDecode($this->campaign_status->CurrentValue);
        }
        $this->campaign_status->EditValue = $this->campaign_status->CurrentValue;
        $this->campaign_status->PlaceHolder = RemoveHtml($this->campaign_status->caption());

        // print_status
        $this->print_status->EditAttrs["class"] = "form-control";
        $this->print_status->EditCustomAttributes = "";
        if (!$this->print_status->Raw) {
            $this->print_status->CurrentValue = HtmlDecode($this->print_status->CurrentValue);
        }
        $this->print_status->EditValue = $this->print_status->CurrentValue;
        $this->print_status->PlaceHolder = RemoveHtml($this->print_status->caption());

        // payment_status
        $this->payment_status->EditAttrs["class"] = "form-control";
        $this->payment_status->EditCustomAttributes = "";
        if (!$this->payment_status->Raw) {
            $this->payment_status->CurrentValue = HtmlDecode($this->payment_status->CurrentValue);
        }
        $this->payment_status->EditValue = $this->payment_status->CurrentValue;
        $this->payment_status->PlaceHolder = RemoveHtml($this->payment_status->caption());

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

        // platform
        $this->platform->EditAttrs["class"] = "form-control";
        $this->platform->EditCustomAttributes = "";
        if (!$this->platform->Raw) {
            $this->platform->CurrentValue = HtmlDecode($this->platform->CurrentValue);
        }
        $this->platform->EditValue = $this->platform->CurrentValue;
        $this->platform->PlaceHolder = RemoveHtml($this->platform->caption());

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

        // print_stage
        $this->print_stage->EditAttrs["class"] = "form-control";
        $this->print_stage->EditCustomAttributes = "";
        $this->print_stage->EditValue = $this->print_stage->CurrentValue;
        $this->print_stage->PlaceHolder = RemoveHtml($this->print_stage->caption());

        // price
        $this->price->EditAttrs["class"] = "form-control";
        $this->price->EditCustomAttributes = "";
        $this->price->EditValue = $this->price->CurrentValue;
        $this->price->PlaceHolder = RemoveHtml($this->price->caption());

        // operator_fee
        $this->operator_fee->EditAttrs["class"] = "form-control";
        $this->operator_fee->EditCustomAttributes = "";
        $this->operator_fee->EditValue = $this->operator_fee->CurrentValue;
        $this->operator_fee->PlaceHolder = RemoveHtml($this->operator_fee->caption());

        // agency_fee
        $this->agency_fee->EditAttrs["class"] = "form-control";
        $this->agency_fee->EditCustomAttributes = "";
        $this->agency_fee->EditValue = $this->agency_fee->CurrentValue;
        $this->agency_fee->PlaceHolder = RemoveHtml($this->agency_fee->caption());

        // lamata_fee
        $this->lamata_fee->EditAttrs["class"] = "form-control";
        $this->lamata_fee->EditCustomAttributes = "";
        $this->lamata_fee->EditValue = $this->lamata_fee->CurrentValue;
        $this->lamata_fee->PlaceHolder = RemoveHtml($this->lamata_fee->caption());

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

        // price_details
        $this->price_details->EditAttrs["class"] = "form-control";
        $this->price_details->EditCustomAttributes = "";
        $this->price_details->EditValue = $this->price_details->CurrentValue;
        $this->price_details->PlaceHolder = RemoveHtml($this->price_details->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
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
                    $doc->exportCaption($this->campaign_id);
                    $doc->exportCaption($this->campaign_name);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->campaign_status);
                    $doc->exportCaption($this->print_status);
                    $doc->exportCaption($this->payment_status);
                    $doc->exportCaption($this->start_date);
                    $doc->exportCaption($this->end_date);
                    $doc->exportCaption($this->vendor);
                    $doc->exportCaption($this->operator);
                    $doc->exportCaption($this->platform);
                    $doc->exportCaption($this->inventory);
                    $doc->exportCaption($this->bus_size);
                    $doc->exportCaption($this->print_stage);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->operator_fee);
                    $doc->exportCaption($this->agency_fee);
                    $doc->exportCaption($this->lamata_fee);
                    $doc->exportCaption($this->lasaa_fee);
                    $doc->exportCaption($this->printers_fee);
                    $doc->exportCaption($this->price_details);
                } else {
                    $doc->exportCaption($this->transaction_id);
                    $doc->exportCaption($this->campaign_id);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->campaign_status);
                    $doc->exportCaption($this->print_status);
                    $doc->exportCaption($this->payment_status);
                    $doc->exportCaption($this->start_date);
                    $doc->exportCaption($this->end_date);
                    $doc->exportCaption($this->vendor);
                    $doc->exportCaption($this->operator);
                    $doc->exportCaption($this->platform);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->operator_fee);
                    $doc->exportCaption($this->agency_fee);
                    $doc->exportCaption($this->lamata_fee);
                    $doc->exportCaption($this->lasaa_fee);
                    $doc->exportCaption($this->printers_fee);
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

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->transaction_id);
                        $doc->exportField($this->campaign_id);
                        $doc->exportField($this->campaign_name);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->campaign_status);
                        $doc->exportField($this->print_status);
                        $doc->exportField($this->payment_status);
                        $doc->exportField($this->start_date);
                        $doc->exportField($this->end_date);
                        $doc->exportField($this->vendor);
                        $doc->exportField($this->operator);
                        $doc->exportField($this->platform);
                        $doc->exportField($this->inventory);
                        $doc->exportField($this->bus_size);
                        $doc->exportField($this->print_stage);
                        $doc->exportField($this->price);
                        $doc->exportField($this->operator_fee);
                        $doc->exportField($this->agency_fee);
                        $doc->exportField($this->lamata_fee);
                        $doc->exportField($this->lasaa_fee);
                        $doc->exportField($this->printers_fee);
                        $doc->exportField($this->price_details);
                    } else {
                        $doc->exportField($this->transaction_id);
                        $doc->exportField($this->campaign_id);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->campaign_status);
                        $doc->exportField($this->print_status);
                        $doc->exportField($this->payment_status);
                        $doc->exportField($this->start_date);
                        $doc->exportField($this->end_date);
                        $doc->exportField($this->vendor);
                        $doc->exportField($this->operator);
                        $doc->exportField($this->platform);
                        $doc->exportField($this->price);
                        $doc->exportField($this->operator_fee);
                        $doc->exportField($this->agency_fee);
                        $doc->exportField($this->lamata_fee);
                        $doc->exportField($this->lasaa_fee);
                        $doc->exportField($this->printers_fee);
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
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}

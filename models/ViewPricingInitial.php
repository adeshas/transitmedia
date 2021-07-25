<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for view_pricing_initial
 */
class ViewPricingInitial extends DbTable
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
    public $id;
    public $platform_id;
    public $inventory_id;
    public $print_stage_id;
    public $bus_size_id;
    public $platform;
    public $inventory;
    public $print_stage;
    public $bus_size;
    public $details;
    public $max_limit;
    public $min_limit;
    public $price;
    public $operator_fee;
    public $agency_fee;
    public $lamata_fee;
    public $lasaa_fee;
    public $printers_fee;
    public $active;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'view_pricing_initial';
        $this->TableName = 'view_pricing_initial';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "\"view_pricing_initial\"";
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

        // id
        $this->id = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_id', 'id', '"id"', 'CAST("id" AS varchar(255))', 3, 4, -1, false, '"id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // platform_id
        $this->platform_id = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_platform_id', 'platform_id', '"platform_id"', 'CAST("platform_id" AS varchar(255))', 3, 4, -1, false, '"platform_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->platform_id->Sortable = true; // Allow sort
        $this->platform_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->platform_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->platform_id->Param, "CustomMsg");
        $this->Fields['platform_id'] = &$this->platform_id;

        // inventory_id
        $this->inventory_id = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_inventory_id', 'inventory_id', '"inventory_id"', 'CAST("inventory_id" AS varchar(255))', 3, 4, -1, false, '"inventory_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->inventory_id->Sortable = true; // Allow sort
        $this->inventory_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->inventory_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->inventory_id->Param, "CustomMsg");
        $this->Fields['inventory_id'] = &$this->inventory_id;

        // print_stage_id
        $this->print_stage_id = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_print_stage_id', 'print_stage_id', '"print_stage_id"', 'CAST("print_stage_id" AS varchar(255))', 3, 4, -1, false, '"print_stage_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->print_stage_id->Sortable = true; // Allow sort
        $this->print_stage_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->print_stage_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->print_stage_id->Param, "CustomMsg");
        $this->Fields['print_stage_id'] = &$this->print_stage_id;

        // bus_size_id
        $this->bus_size_id = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_bus_size_id', 'bus_size_id', '"bus_size_id"', 'CAST("bus_size_id" AS varchar(255))', 3, 4, -1, false, '"bus_size_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bus_size_id->Sortable = true; // Allow sort
        $this->bus_size_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->bus_size_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bus_size_id->Param, "CustomMsg");
        $this->Fields['bus_size_id'] = &$this->bus_size_id;

        // platform
        $this->platform = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_platform', 'platform', '"platform"', '"platform"', 200, 50, -1, false, '"platform"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->platform->Sortable = true; // Allow sort
        $this->platform->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->platform->Param, "CustomMsg");
        $this->Fields['platform'] = &$this->platform;

        // inventory
        $this->inventory = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_inventory', 'inventory', '"inventory"', '"inventory"', 201, 0, -1, false, '"inventory"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->inventory->Sortable = true; // Allow sort
        $this->inventory->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->inventory->Param, "CustomMsg");
        $this->Fields['inventory'] = &$this->inventory;

        // print_stage
        $this->print_stage = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_print_stage', 'print_stage', '"print_stage"', '"print_stage"', 201, 0, -1, false, '"print_stage"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->print_stage->Sortable = true; // Allow sort
        $this->print_stage->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->print_stage->Param, "CustomMsg");
        $this->Fields['print_stage'] = &$this->print_stage;

        // bus_size
        $this->bus_size = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_bus_size', 'bus_size', '"bus_size"', '"bus_size"', 201, 0, -1, false, '"bus_size"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bus_size->Sortable = true; // Allow sort
        $this->bus_size->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bus_size->Param, "CustomMsg");
        $this->Fields['bus_size'] = &$this->bus_size;

        // details
        $this->details = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_details', 'details', '"details"', '"details"', 201, 0, -1, false, '"details"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->details->Sortable = true; // Allow sort
        $this->details->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->details->Param, "CustomMsg");
        $this->Fields['details'] = &$this->details;

        // max_limit
        $this->max_limit = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_max_limit', 'max_limit', '"max_limit"', 'CAST("max_limit" AS varchar(255))', 3, 4, -1, false, '"max_limit"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->max_limit->Sortable = true; // Allow sort
        $this->max_limit->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->max_limit->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->max_limit->Param, "CustomMsg");
        $this->Fields['max_limit'] = &$this->max_limit;

        // min_limit
        $this->min_limit = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_min_limit', 'min_limit', '"min_limit"', 'CAST("min_limit" AS varchar(255))', 3, 4, -1, false, '"min_limit"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->min_limit->Sortable = true; // Allow sort
        $this->min_limit->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->min_limit->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->min_limit->Param, "CustomMsg");
        $this->Fields['min_limit'] = &$this->min_limit;

        // price
        $this->price = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_price', 'price', '"price"', 'CAST("price" AS varchar(255))', 20, 8, -1, false, '"price"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->price->Sortable = true; // Allow sort
        $this->price->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->price->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->price->Param, "CustomMsg");
        $this->Fields['price'] = &$this->price;

        // operator_fee
        $this->operator_fee = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_operator_fee', 'operator_fee', '"operator_fee"', 'CAST("operator_fee" AS varchar(255))', 20, 8, -1, false, '"operator_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->operator_fee->Sortable = true; // Allow sort
        $this->operator_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->operator_fee->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->operator_fee->Param, "CustomMsg");
        $this->Fields['operator_fee'] = &$this->operator_fee;

        // agency_fee
        $this->agency_fee = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_agency_fee', 'agency_fee', '"agency_fee"', 'CAST("agency_fee" AS varchar(255))', 20, 8, -1, false, '"agency_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->agency_fee->Sortable = true; // Allow sort
        $this->agency_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->agency_fee->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->agency_fee->Param, "CustomMsg");
        $this->Fields['agency_fee'] = &$this->agency_fee;

        // lamata_fee
        $this->lamata_fee = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_lamata_fee', 'lamata_fee', '"lamata_fee"', 'CAST("lamata_fee" AS varchar(255))', 20, 8, -1, false, '"lamata_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lamata_fee->Sortable = true; // Allow sort
        $this->lamata_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lamata_fee->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lamata_fee->Param, "CustomMsg");
        $this->Fields['lamata_fee'] = &$this->lamata_fee;

        // lasaa_fee
        $this->lasaa_fee = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_lasaa_fee', 'lasaa_fee', '"lasaa_fee"', 'CAST("lasaa_fee" AS varchar(255))', 20, 8, -1, false, '"lasaa_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lasaa_fee->Sortable = true; // Allow sort
        $this->lasaa_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lasaa_fee->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lasaa_fee->Param, "CustomMsg");
        $this->Fields['lasaa_fee'] = &$this->lasaa_fee;

        // printers_fee
        $this->printers_fee = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_printers_fee', 'printers_fee', '"printers_fee"', 'CAST("printers_fee" AS varchar(255))', 20, 8, -1, false, '"printers_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->printers_fee->Sortable = true; // Allow sort
        $this->printers_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->printers_fee->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->printers_fee->Param, "CustomMsg");
        $this->Fields['printers_fee'] = &$this->printers_fee;

        // active
        $this->active = new DbField('view_pricing_initial', 'view_pricing_initial', 'x_active', 'active', '"active"', 'CAST("active" AS varchar(255))', 11, 1, -1, false, '"active"', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->active->Sortable = true; // Allow sort
        $this->active->DataType = DATATYPE_BOOLEAN;
        $this->active->Lookup = new Lookup('active', 'view_pricing_initial', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->active->OptionCount = 2;
        $this->active->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->active->Param, "CustomMsg");
        $this->Fields['active'] = &$this->active;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"view_pricing_initial\"";
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
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
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
        $this->id->DbValue = $row['id'];
        $this->platform_id->DbValue = $row['platform_id'];
        $this->inventory_id->DbValue = $row['inventory_id'];
        $this->print_stage_id->DbValue = $row['print_stage_id'];
        $this->bus_size_id->DbValue = $row['bus_size_id'];
        $this->platform->DbValue = $row['platform'];
        $this->inventory->DbValue = $row['inventory'];
        $this->print_stage->DbValue = $row['print_stage'];
        $this->bus_size->DbValue = $row['bus_size'];
        $this->details->DbValue = $row['details'];
        $this->max_limit->DbValue = $row['max_limit'];
        $this->min_limit->DbValue = $row['min_limit'];
        $this->price->DbValue = $row['price'];
        $this->operator_fee->DbValue = $row['operator_fee'];
        $this->agency_fee->DbValue = $row['agency_fee'];
        $this->lamata_fee->DbValue = $row['lamata_fee'];
        $this->lasaa_fee->DbValue = $row['lasaa_fee'];
        $this->printers_fee->DbValue = $row['printers_fee'];
        $this->active->DbValue = (ConvertToBool($row['active']) ? "1" : "0");
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
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("viewpricinginitiallist");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "viewpricinginitialview") {
            return $Language->phrase("View");
        } elseif ($pageName == "viewpricinginitialedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "viewpricinginitialadd") {
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
                return "ViewPricingInitialView";
            case Config("API_ADD_ACTION"):
                return "ViewPricingInitialAdd";
            case Config("API_EDIT_ACTION"):
                return "ViewPricingInitialEdit";
            case Config("API_DELETE_ACTION"):
                return "ViewPricingInitialDelete";
            case Config("API_LIST_ACTION"):
                return "ViewPricingInitialList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "viewpricinginitiallist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("viewpricinginitialview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("viewpricinginitialview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "viewpricinginitialadd?" . $this->getUrlParm($parm);
        } else {
            $url = "viewpricinginitialadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("viewpricinginitialedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("viewpricinginitialadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("viewpricinginitialdelete", $this->getUrlParm());
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
        $this->id->setDbValue($row['id']);
        $this->platform_id->setDbValue($row['platform_id']);
        $this->inventory_id->setDbValue($row['inventory_id']);
        $this->print_stage_id->setDbValue($row['print_stage_id']);
        $this->bus_size_id->setDbValue($row['bus_size_id']);
        $this->platform->setDbValue($row['platform']);
        $this->inventory->setDbValue($row['inventory']);
        $this->print_stage->setDbValue($row['print_stage']);
        $this->bus_size->setDbValue($row['bus_size']);
        $this->details->setDbValue($row['details']);
        $this->max_limit->setDbValue($row['max_limit']);
        $this->min_limit->setDbValue($row['min_limit']);
        $this->price->setDbValue($row['price']);
        $this->operator_fee->setDbValue($row['operator_fee']);
        $this->agency_fee->setDbValue($row['agency_fee']);
        $this->lamata_fee->setDbValue($row['lamata_fee']);
        $this->lasaa_fee->setDbValue($row['lasaa_fee']);
        $this->printers_fee->setDbValue($row['printers_fee']);
        $this->active->setDbValue(ConvertToBool($row['active']) ? "1" : "0");
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // platform_id

        // inventory_id

        // print_stage_id

        // bus_size_id

        // platform

        // inventory

        // print_stage

        // bus_size

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

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
        $this->id->ViewCustomAttributes = "";

        // platform_id
        $this->platform_id->ViewValue = $this->platform_id->CurrentValue;
        $this->platform_id->ViewValue = FormatNumber($this->platform_id->ViewValue, 0, -2, -2, -2);
        $this->platform_id->ViewCustomAttributes = "";

        // inventory_id
        $this->inventory_id->ViewValue = $this->inventory_id->CurrentValue;
        $this->inventory_id->ViewValue = FormatNumber($this->inventory_id->ViewValue, 0, -2, -2, -2);
        $this->inventory_id->ViewCustomAttributes = "";

        // print_stage_id
        $this->print_stage_id->ViewValue = $this->print_stage_id->CurrentValue;
        $this->print_stage_id->ViewValue = FormatNumber($this->print_stage_id->ViewValue, 0, -2, -2, -2);
        $this->print_stage_id->ViewCustomAttributes = "";

        // bus_size_id
        $this->bus_size_id->ViewValue = $this->bus_size_id->CurrentValue;
        $this->bus_size_id->ViewValue = FormatNumber($this->bus_size_id->ViewValue, 0, -2, -2, -2);
        $this->bus_size_id->ViewCustomAttributes = "";

        // platform
        $this->platform->ViewValue = $this->platform->CurrentValue;
        $this->platform->ViewCustomAttributes = "";

        // inventory
        $this->inventory->ViewValue = $this->inventory->CurrentValue;
        $this->inventory->ViewCustomAttributes = "";

        // print_stage
        $this->print_stage->ViewValue = $this->print_stage->CurrentValue;
        $this->print_stage->ViewCustomAttributes = "";

        // bus_size
        $this->bus_size->ViewValue = $this->bus_size->CurrentValue;
        $this->bus_size->ViewCustomAttributes = "";

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

        // platform
        $this->platform->LinkCustomAttributes = "";
        $this->platform->HrefValue = "";
        $this->platform->TooltipValue = "";

        // inventory
        $this->inventory->LinkCustomAttributes = "";
        $this->inventory->HrefValue = "";
        $this->inventory->TooltipValue = "";

        // print_stage
        $this->print_stage->LinkCustomAttributes = "";
        $this->print_stage->HrefValue = "";
        $this->print_stage->TooltipValue = "";

        // bus_size
        $this->bus_size->LinkCustomAttributes = "";
        $this->bus_size->HrefValue = "";
        $this->bus_size->TooltipValue = "";

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

        // id
        $this->id->EditAttrs["class"] = "form-control";
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->PlaceHolder = RemoveHtml($this->id->caption());

        // platform_id
        $this->platform_id->EditAttrs["class"] = "form-control";
        $this->platform_id->EditCustomAttributes = "";
        $this->platform_id->EditValue = $this->platform_id->CurrentValue;
        $this->platform_id->PlaceHolder = RemoveHtml($this->platform_id->caption());

        // inventory_id
        $this->inventory_id->EditAttrs["class"] = "form-control";
        $this->inventory_id->EditCustomAttributes = "";
        $this->inventory_id->EditValue = $this->inventory_id->CurrentValue;
        $this->inventory_id->PlaceHolder = RemoveHtml($this->inventory_id->caption());

        // print_stage_id
        $this->print_stage_id->EditAttrs["class"] = "form-control";
        $this->print_stage_id->EditCustomAttributes = "";
        $this->print_stage_id->EditValue = $this->print_stage_id->CurrentValue;
        $this->print_stage_id->PlaceHolder = RemoveHtml($this->print_stage_id->caption());

        // bus_size_id
        $this->bus_size_id->EditAttrs["class"] = "form-control";
        $this->bus_size_id->EditCustomAttributes = "";
        $this->bus_size_id->EditValue = $this->bus_size_id->CurrentValue;
        $this->bus_size_id->PlaceHolder = RemoveHtml($this->bus_size_id->caption());

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

        // print_stage
        $this->print_stage->EditAttrs["class"] = "form-control";
        $this->print_stage->EditCustomAttributes = "";
        $this->print_stage->EditValue = $this->print_stage->CurrentValue;
        $this->print_stage->PlaceHolder = RemoveHtml($this->print_stage->caption());

        // bus_size
        $this->bus_size->EditAttrs["class"] = "form-control";
        $this->bus_size->EditCustomAttributes = "";
        $this->bus_size->EditValue = $this->bus_size->CurrentValue;
        $this->bus_size->PlaceHolder = RemoveHtml($this->bus_size->caption());

        // details
        $this->details->EditAttrs["class"] = "form-control";
        $this->details->EditCustomAttributes = "";
        $this->details->EditValue = $this->details->CurrentValue;
        $this->details->PlaceHolder = RemoveHtml($this->details->caption());

        // max_limit
        $this->max_limit->EditAttrs["class"] = "form-control";
        $this->max_limit->EditCustomAttributes = "";
        $this->max_limit->EditValue = $this->max_limit->CurrentValue;
        $this->max_limit->PlaceHolder = RemoveHtml($this->max_limit->caption());

        // min_limit
        $this->min_limit->EditAttrs["class"] = "form-control";
        $this->min_limit->EditCustomAttributes = "";
        $this->min_limit->EditValue = $this->min_limit->CurrentValue;
        $this->min_limit->PlaceHolder = RemoveHtml($this->min_limit->caption());

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

        // active
        $this->active->EditCustomAttributes = "";
        $this->active->EditValue = $this->active->options(false);
        $this->active->PlaceHolder = RemoveHtml($this->active->caption());

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
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->platform_id);
                    $doc->exportCaption($this->inventory_id);
                    $doc->exportCaption($this->print_stage_id);
                    $doc->exportCaption($this->bus_size_id);
                    $doc->exportCaption($this->platform);
                    $doc->exportCaption($this->inventory);
                    $doc->exportCaption($this->print_stage);
                    $doc->exportCaption($this->bus_size);
                    $doc->exportCaption($this->details);
                    $doc->exportCaption($this->max_limit);
                    $doc->exportCaption($this->min_limit);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->operator_fee);
                    $doc->exportCaption($this->agency_fee);
                    $doc->exportCaption($this->lamata_fee);
                    $doc->exportCaption($this->lasaa_fee);
                    $doc->exportCaption($this->printers_fee);
                    $doc->exportCaption($this->active);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->platform_id);
                    $doc->exportCaption($this->inventory_id);
                    $doc->exportCaption($this->print_stage_id);
                    $doc->exportCaption($this->bus_size_id);
                    $doc->exportCaption($this->platform);
                    $doc->exportCaption($this->max_limit);
                    $doc->exportCaption($this->min_limit);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->operator_fee);
                    $doc->exportCaption($this->agency_fee);
                    $doc->exportCaption($this->lamata_fee);
                    $doc->exportCaption($this->lasaa_fee);
                    $doc->exportCaption($this->printers_fee);
                    $doc->exportCaption($this->active);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->platform_id);
                        $doc->exportField($this->inventory_id);
                        $doc->exportField($this->print_stage_id);
                        $doc->exportField($this->bus_size_id);
                        $doc->exportField($this->platform);
                        $doc->exportField($this->inventory);
                        $doc->exportField($this->print_stage);
                        $doc->exportField($this->bus_size);
                        $doc->exportField($this->details);
                        $doc->exportField($this->max_limit);
                        $doc->exportField($this->min_limit);
                        $doc->exportField($this->price);
                        $doc->exportField($this->operator_fee);
                        $doc->exportField($this->agency_fee);
                        $doc->exportField($this->lamata_fee);
                        $doc->exportField($this->lasaa_fee);
                        $doc->exportField($this->printers_fee);
                        $doc->exportField($this->active);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->platform_id);
                        $doc->exportField($this->inventory_id);
                        $doc->exportField($this->print_stage_id);
                        $doc->exportField($this->bus_size_id);
                        $doc->exportField($this->platform);
                        $doc->exportField($this->max_limit);
                        $doc->exportField($this->min_limit);
                        $doc->exportField($this->price);
                        $doc->exportField($this->operator_fee);
                        $doc->exportField($this->agency_fee);
                        $doc->exportField($this->lamata_fee);
                        $doc->exportField($this->lasaa_fee);
                        $doc->exportField($this->printers_fee);
                        $doc->exportField($this->active);
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

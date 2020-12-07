<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for z_price_settings
 */
class ZPriceSettings extends DbTable
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
    public $ts_created;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'z_price_settings';
        $this->TableName = 'z_price_settings';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "\"z_price_settings\"";
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
        $this->id = new DbField('z_price_settings', 'z_price_settings', 'x_id', 'id', '"id"', 'CAST("id" AS varchar(255))', 3, 4, -1, false, '"id"', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Nullable = false; // NOT NULL field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // platform_id
        $this->platform_id = new DbField('z_price_settings', 'z_price_settings', 'x_platform_id', 'platform_id', '"platform_id"', 'CAST("platform_id" AS varchar(255))', 3, 4, -1, false, '"platform_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->platform_id->Nullable = false; // NOT NULL field
        $this->platform_id->Required = true; // Required field
        $this->platform_id->Sortable = true; // Allow sort
        $this->platform_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->platform_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->platform_id->Lookup = new Lookup('platform_id', 'y_platforms', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->platform_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['platform_id'] = &$this->platform_id;

        // inventory_id
        $this->inventory_id = new DbField('z_price_settings', 'z_price_settings', 'x_inventory_id', 'inventory_id', '"inventory_id"', 'CAST("inventory_id" AS varchar(255))', 3, 4, -1, false, '"inventory_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->inventory_id->Nullable = false; // NOT NULL field
        $this->inventory_id->Required = true; // Required field
        $this->inventory_id->Sortable = true; // Allow sort
        $this->inventory_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->inventory_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->inventory_id->Lookup = new Lookup('inventory_id', 'y_inventory', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->inventory_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['inventory_id'] = &$this->inventory_id;

        // print_stage_id
        $this->print_stage_id = new DbField('z_price_settings', 'z_price_settings', 'x_print_stage_id', 'print_stage_id', '"print_stage_id"', 'CAST("print_stage_id" AS varchar(255))', 3, 4, -1, false, '"print_stage_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->print_stage_id->Sortable = true; // Allow sort
        $this->print_stage_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->print_stage_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->print_stage_id->Lookup = new Lookup('print_stage_id', 'x_print_stage', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->print_stage_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['print_stage_id'] = &$this->print_stage_id;

        // bus_size_id
        $this->bus_size_id = new DbField('z_price_settings', 'z_price_settings', 'x_bus_size_id', 'bus_size_id', '"bus_size_id"', 'CAST("bus_size_id" AS varchar(255))', 3, 4, -1, false, '"bus_size_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->bus_size_id->Sortable = true; // Allow sort
        $this->bus_size_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->bus_size_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->bus_size_id->Lookup = new Lookup('bus_size_id', 'x_bus_sizes', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->bus_size_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['bus_size_id'] = &$this->bus_size_id;

        // details
        $this->details = new DbField('z_price_settings', 'z_price_settings', 'x_details', 'details', '"details"', '"details"', 201, 0, -1, false, '"details"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->details->Sortable = true; // Allow sort
        $this->Fields['details'] = &$this->details;

        // max_limit
        $this->max_limit = new DbField('z_price_settings', 'z_price_settings', 'x_max_limit', 'max_limit', '"max_limit"', 'CAST("max_limit" AS varchar(255))', 3, 4, -1, false, '"max_limit"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->max_limit->Sortable = true; // Allow sort
        $this->max_limit->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['max_limit'] = &$this->max_limit;

        // min_limit
        $this->min_limit = new DbField('z_price_settings', 'z_price_settings', 'x_min_limit', 'min_limit', '"min_limit"', 'CAST("min_limit" AS varchar(255))', 3, 4, -1, false, '"min_limit"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->min_limit->Sortable = true; // Allow sort
        $this->min_limit->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['min_limit'] = &$this->min_limit;

        // price
        $this->price = new DbField('z_price_settings', 'z_price_settings', 'x_price', 'price', '"price"', 'CAST("price" AS varchar(255))', 20, 8, -1, false, '"price"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->price->Sortable = true; // Allow sort
        $this->price->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['price'] = &$this->price;

        // operator_fee
        $this->operator_fee = new DbField('z_price_settings', 'z_price_settings', 'x_operator_fee', 'operator_fee', '"operator_fee"', 'CAST("operator_fee" AS varchar(255))', 20, 8, -1, false, '"operator_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->operator_fee->Sortable = true; // Allow sort
        $this->operator_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['operator_fee'] = &$this->operator_fee;

        // agency_fee
        $this->agency_fee = new DbField('z_price_settings', 'z_price_settings', 'x_agency_fee', 'agency_fee', '"agency_fee"', 'CAST("agency_fee" AS varchar(255))', 20, 8, -1, false, '"agency_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->agency_fee->Sortable = true; // Allow sort
        $this->agency_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['agency_fee'] = &$this->agency_fee;

        // lamata_fee
        $this->lamata_fee = new DbField('z_price_settings', 'z_price_settings', 'x_lamata_fee', 'lamata_fee', '"lamata_fee"', 'CAST("lamata_fee" AS varchar(255))', 20, 8, -1, false, '"lamata_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lamata_fee->Sortable = true; // Allow sort
        $this->lamata_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['lamata_fee'] = &$this->lamata_fee;

        // lasaa_fee
        $this->lasaa_fee = new DbField('z_price_settings', 'z_price_settings', 'x_lasaa_fee', 'lasaa_fee', '"lasaa_fee"', 'CAST("lasaa_fee" AS varchar(255))', 20, 8, -1, false, '"lasaa_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lasaa_fee->Sortable = true; // Allow sort
        $this->lasaa_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['lasaa_fee'] = &$this->lasaa_fee;

        // printers_fee
        $this->printers_fee = new DbField('z_price_settings', 'z_price_settings', 'x_printers_fee', 'printers_fee', '"printers_fee"', 'CAST("printers_fee" AS varchar(255))', 20, 8, -1, false, '"printers_fee"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->printers_fee->Sortable = true; // Allow sort
        $this->printers_fee->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['printers_fee'] = &$this->printers_fee;

        // active
        $this->active = new DbField('z_price_settings', 'z_price_settings', 'x_active', 'active', '"active"', 'CAST("active" AS varchar(255))', 11, 1, -1, false, '"active"', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->active->Nullable = false; // NOT NULL field
        $this->active->Sortable = true; // Allow sort
        $this->active->DataType = DATATYPE_BOOLEAN;
        $this->active->Lookup = new Lookup('active', 'z_price_settings', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->active->OptionCount = 2;
        $this->Fields['active'] = &$this->active;

        // ts_created
        $this->ts_created = new DbField('z_price_settings', 'z_price_settings', 'x_ts_created', 'ts_created', '"ts_created"', CastDateFieldForLike("\"ts_created\"", 0, "DB"), 135, 8, 0, false, '"ts_created"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_created->Nullable = false; // NOT NULL field
        $this->ts_created->Required = true; // Required field
        $this->ts_created->Sortable = true; // Allow sort
        $this->ts_created->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ts_created'] = &$this->ts_created;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"z_price_settings\"";
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
            // Get insert id if necessary
            $this->id->setDbValue($conn->fetchColumn("SELECT currval('pricing_id_seq'::regclass)"));
            $rs['id'] = $this->id->DbValue;
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
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
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
        $this->id->DbValue = $row['id'];
        $this->platform_id->DbValue = $row['platform_id'];
        $this->inventory_id->DbValue = $row['inventory_id'];
        $this->print_stage_id->DbValue = $row['print_stage_id'];
        $this->bus_size_id->DbValue = $row['bus_size_id'];
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
        $this->ts_created->DbValue = $row['ts_created'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "\"id\" = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
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
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
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
        return $_SESSION[$name] ?? GetUrl("zpricesettingslist");
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
        if ($pageName == "zpricesettingsview") {
            return $Language->phrase("View");
        } elseif ($pageName == "zpricesettingsedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "zpricesettingsadd") {
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
                return "ZPriceSettingsView";
            case Config("API_ADD_ACTION"):
                return "ZPriceSettingsAdd";
            case Config("API_EDIT_ACTION"):
                return "ZPriceSettingsEdit";
            case Config("API_DELETE_ACTION"):
                return "ZPriceSettingsDelete";
            case Config("API_LIST_ACTION"):
                return "ZPriceSettingsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "zpricesettingslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("zpricesettingsview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("zpricesettingsview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "zpricesettingsadd?" . $this->getUrlParm($parm);
        } else {
            $url = "zpricesettingsadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("zpricesettingsedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("zpricesettingsadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("zpricesettingsdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id:" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id->CurrentValue);
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
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
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
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
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
        $this->ts_created->setDbValue($row['ts_created']);
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
        $this->id->ViewCustomAttributes = "";

        // platform_id
        $this->platform_id->EditAttrs["class"] = "form-control";
        $this->platform_id->EditCustomAttributes = "";
        $this->platform_id->PlaceHolder = RemoveHtml($this->platform_id->caption());

        // inventory_id
        $this->inventory_id->EditAttrs["class"] = "form-control";
        $this->inventory_id->EditCustomAttributes = "";
        $this->inventory_id->PlaceHolder = RemoveHtml($this->inventory_id->caption());

        // print_stage_id
        $this->print_stage_id->EditAttrs["class"] = "form-control";
        $this->print_stage_id->EditCustomAttributes = "";
        $this->print_stage_id->PlaceHolder = RemoveHtml($this->print_stage_id->caption());

        // bus_size_id
        $this->bus_size_id->EditAttrs["class"] = "form-control";
        $this->bus_size_id->EditCustomAttributes = "";
        $this->bus_size_id->PlaceHolder = RemoveHtml($this->bus_size_id->caption());

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

        // ts_created
        $this->ts_created->EditAttrs["class"] = "form-control";
        $this->ts_created->EditCustomAttributes = "";
        $this->ts_created->EditValue = FormatDateTime($this->ts_created->CurrentValue, 8);
        $this->ts_created->PlaceHolder = RemoveHtml($this->ts_created->caption());

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
                    $doc->exportCaption($this->ts_created);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->platform_id);
                    $doc->exportCaption($this->inventory_id);
                    $doc->exportCaption($this->print_stage_id);
                    $doc->exportCaption($this->bus_size_id);
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
                    $doc->exportCaption($this->ts_created);
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
                        $doc->exportField($this->ts_created);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->platform_id);
                        $doc->exportField($this->inventory_id);
                        $doc->exportField($this->print_stage_id);
                        $doc->exportField($this->bus_size_id);
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
                        $doc->exportField($this->ts_created);
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

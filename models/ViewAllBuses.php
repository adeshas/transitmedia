<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for view_all_buses
 */
class ViewAllBuses extends DbTable
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
    public $number;
    public $platform;
    public $operator;
    public $exterior_campaign;
    public $exterior_campaign_vendor;
    public $interior_campaign;
    public $interior_campaign_vendor;
    public $bus_status;
    public $bus_size;
    public $bus_depot;
    public $ts_created;
    public $ts_last_update;
    public $bus_status_id;
    public $bus_size_id;
    public $bus_depot_id;
    public $platform_id;
    public $operator_id;
    public $exterior_campaign_id;
    public $interior_campaign_id;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'view_all_buses';
        $this->TableName = 'view_all_buses';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "\"view_all_buses\"";
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
        $this->id = new DbField('view_all_buses', 'view_all_buses', 'x_id', 'id', '"id"', 'CAST("id" AS varchar(255))', 3, 4, -1, false, '"id"', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // number
        $this->number = new DbField('view_all_buses', 'view_all_buses', 'x_number', 'number', '"number"', '"number"', 200, 0, -1, false, '"number"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->number->Sortable = true; // Allow sort
        $this->Fields['number'] = &$this->number;

        // platform
        $this->platform = new DbField('view_all_buses', 'view_all_buses', 'x_platform', 'platform', '"platform"', '"platform"', 200, 50, -1, false, '"platform"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->platform->Sortable = true; // Allow sort
        $this->Fields['platform'] = &$this->platform;

        // operator
        $this->operator = new DbField('view_all_buses', 'view_all_buses', 'x_operator', 'operator', '"operator"', '"operator"', 200, 50, -1, false, '"operator"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->operator->Sortable = true; // Allow sort
        $this->Fields['operator'] = &$this->operator;

        // exterior_campaign
        $this->exterior_campaign = new DbField('view_all_buses', 'view_all_buses', 'x_exterior_campaign', 'exterior_campaign', '"exterior_campaign"', '"exterior_campaign"', 201, 0, -1, false, '"exterior_campaign"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->exterior_campaign->Sortable = true; // Allow sort
        $this->Fields['exterior_campaign'] = &$this->exterior_campaign;

        // exterior_campaign_vendor
        $this->exterior_campaign_vendor = new DbField('view_all_buses', 'view_all_buses', 'x_exterior_campaign_vendor', 'exterior_campaign_vendor', '"exterior_campaign_vendor"', '"exterior_campaign_vendor"', 200, 0, -1, false, '"exterior_campaign_vendor"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->exterior_campaign_vendor->Sortable = true; // Allow sort
        $this->Fields['exterior_campaign_vendor'] = &$this->exterior_campaign_vendor;

        // interior_campaign
        $this->interior_campaign = new DbField('view_all_buses', 'view_all_buses', 'x_interior_campaign', 'interior_campaign', '"interior_campaign"', '"interior_campaign"', 201, 0, -1, false, '"interior_campaign"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->interior_campaign->Sortable = true; // Allow sort
        $this->Fields['interior_campaign'] = &$this->interior_campaign;

        // interior_campaign_vendor
        $this->interior_campaign_vendor = new DbField('view_all_buses', 'view_all_buses', 'x_interior_campaign_vendor', 'interior_campaign_vendor', '"interior_campaign_vendor"', '"interior_campaign_vendor"', 200, 0, -1, false, '"interior_campaign_vendor"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->interior_campaign_vendor->Sortable = true; // Allow sort
        $this->Fields['interior_campaign_vendor'] = &$this->interior_campaign_vendor;

        // bus_status
        $this->bus_status = new DbField('view_all_buses', 'view_all_buses', 'x_bus_status', 'bus_status', '"bus_status"', '"bus_status"', 200, 0, -1, false, '"bus_status"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bus_status->Sortable = true; // Allow sort
        $this->Fields['bus_status'] = &$this->bus_status;

        // bus_size
        $this->bus_size = new DbField('view_all_buses', 'view_all_buses', 'x_bus_size', 'bus_size', '"bus_size"', '"bus_size"', 201, 0, -1, false, '"bus_size"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bus_size->Sortable = true; // Allow sort
        $this->Fields['bus_size'] = &$this->bus_size;

        // bus_depot
        $this->bus_depot = new DbField('view_all_buses', 'view_all_buses', 'x_bus_depot', 'bus_depot', '"bus_depot"', '"bus_depot"', 201, 0, -1, false, '"bus_depot"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bus_depot->Sortable = true; // Allow sort
        $this->Fields['bus_depot'] = &$this->bus_depot;

        // ts_created
        $this->ts_created = new DbField('view_all_buses', 'view_all_buses', 'x_ts_created', 'ts_created', '"ts_created"', CastDateFieldForLike("\"ts_created\"", 0, "DB"), 135, 8, 0, false, '"ts_created"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_created->Sortable = true; // Allow sort
        $this->ts_created->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ts_created'] = &$this->ts_created;

        // ts_last_update
        $this->ts_last_update = new DbField('view_all_buses', 'view_all_buses', 'x_ts_last_update', 'ts_last_update', '"ts_last_update"', CastDateFieldForLike("\"ts_last_update\"", 0, "DB"), 135, 8, 0, false, '"ts_last_update"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_last_update->Sortable = true; // Allow sort
        $this->ts_last_update->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ts_last_update'] = &$this->ts_last_update;

        // bus_status_id
        $this->bus_status_id = new DbField('view_all_buses', 'view_all_buses', 'x_bus_status_id', 'bus_status_id', '"bus_status_id"', 'CAST("bus_status_id" AS varchar(255))', 3, 4, -1, false, '"bus_status_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->bus_status_id->Sortable = true; // Allow sort
        $this->bus_status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->bus_status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->bus_status_id->Lookup = new Lookup('bus_status_id', 'x_bus_status', false, 'id', ["name","availability","",""], [], [], [], [], [], [], '', '');
        $this->bus_status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['bus_status_id'] = &$this->bus_status_id;

        // bus_size_id
        $this->bus_size_id = new DbField('view_all_buses', 'view_all_buses', 'x_bus_size_id', 'bus_size_id', '"bus_size_id"', 'CAST("bus_size_id" AS varchar(255))', 3, 4, -1, false, '"bus_size_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->bus_size_id->Sortable = true; // Allow sort
        $this->bus_size_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->bus_size_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->bus_size_id->Lookup = new Lookup('bus_size_id', 'x_bus_sizes', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->bus_size_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['bus_size_id'] = &$this->bus_size_id;

        // bus_depot_id
        $this->bus_depot_id = new DbField('view_all_buses', 'view_all_buses', 'x_bus_depot_id', 'bus_depot_id', '"bus_depot_id"', 'CAST("bus_depot_id" AS varchar(255))', 3, 4, -1, false, '"bus_depot_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->bus_depot_id->Sortable = true; // Allow sort
        $this->bus_depot_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->bus_depot_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->bus_depot_id->Lookup = new Lookup('bus_depot_id', 'x_bus_depot', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->bus_depot_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['bus_depot_id'] = &$this->bus_depot_id;

        // platform_id
        $this->platform_id = new DbField('view_all_buses', 'view_all_buses', 'x_platform_id', 'platform_id', '"platform_id"', 'CAST("platform_id" AS varchar(255))', 3, 4, -1, false, '"platform_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->platform_id->Sortable = true; // Allow sort
        $this->platform_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->platform_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->platform_id->Lookup = new Lookup('platform_id', 'y_platforms', false, 'id', ["name","","",""], [], ["x_operator_id"], [], [], [], [], '', '');
        $this->platform_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['platform_id'] = &$this->platform_id;

        // operator_id
        $this->operator_id = new DbField('view_all_buses', 'view_all_buses', 'x_operator_id', 'operator_id', '"operator_id"', 'CAST("operator_id" AS varchar(255))', 3, 4, -1, false, '"operator_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->operator_id->Sortable = true; // Allow sort
        $this->operator_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->operator_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->operator_id->Lookup = new Lookup('operator_id', 'y_operators', false, 'id', ["name","platform_id","",""], ["x_platform_id"], [], ["platform_id"], ["x_platform_id"], [], [], '', '');
        $this->operator_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['operator_id'] = &$this->operator_id;

        // exterior_campaign_id
        $this->exterior_campaign_id = new DbField('view_all_buses', 'view_all_buses', 'x_exterior_campaign_id', 'exterior_campaign_id', '"exterior_campaign_id"', 'CAST("exterior_campaign_id" AS varchar(255))', 3, 4, -1, false, '"exterior_campaign_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->exterior_campaign_id->Sortable = true; // Allow sort
        $this->exterior_campaign_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->exterior_campaign_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->exterior_campaign_id->Lookup = new Lookup('exterior_campaign_id', 'main_campaigns', false, 'id', ["name","quantity","vendor_id",""], ["main_buses x_platform_id"], [], ["platform_id"], ["x_platform_id"], [], [], '"id" DESC', '');
        $this->exterior_campaign_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['exterior_campaign_id'] = &$this->exterior_campaign_id;

        // interior_campaign_id
        $this->interior_campaign_id = new DbField('view_all_buses', 'view_all_buses', 'x_interior_campaign_id', 'interior_campaign_id', '"interior_campaign_id"', 'CAST("interior_campaign_id" AS varchar(255))', 3, 4, -1, false, '"interior_campaign_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->interior_campaign_id->Sortable = true; // Allow sort
        $this->interior_campaign_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->interior_campaign_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->interior_campaign_id->Lookup = new Lookup('interior_campaign_id', 'main_campaigns', false, 'id', ["name","inventory_id","vendor_id",""], ["main_buses x_platform_id"], [], ["platform_id"], ["x_platform_id"], [], [], '', '');
        $this->interior_campaign_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['interior_campaign_id'] = &$this->interior_campaign_id;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"view_all_buses\"";
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
        $this->DefaultFilter = ((CurrentUserLevel() == 5) ? "\"operator_id\" = (select o.id from y_vendors v, y_operators o where v.name ILIKE o.shortname and v.id = ".Profile()->vendor_id.")":"");
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
        $this->number->DbValue = $row['number'];
        $this->platform->DbValue = $row['platform'];
        $this->operator->DbValue = $row['operator'];
        $this->exterior_campaign->DbValue = $row['exterior_campaign'];
        $this->exterior_campaign_vendor->DbValue = $row['exterior_campaign_vendor'];
        $this->interior_campaign->DbValue = $row['interior_campaign'];
        $this->interior_campaign_vendor->DbValue = $row['interior_campaign_vendor'];
        $this->bus_status->DbValue = $row['bus_status'];
        $this->bus_size->DbValue = $row['bus_size'];
        $this->bus_depot->DbValue = $row['bus_depot'];
        $this->ts_created->DbValue = $row['ts_created'];
        $this->ts_last_update->DbValue = $row['ts_last_update'];
        $this->bus_status_id->DbValue = $row['bus_status_id'];
        $this->bus_size_id->DbValue = $row['bus_size_id'];
        $this->bus_depot_id->DbValue = $row['bus_depot_id'];
        $this->platform_id->DbValue = $row['platform_id'];
        $this->operator_id->DbValue = $row['operator_id'];
        $this->exterior_campaign_id->DbValue = $row['exterior_campaign_id'];
        $this->interior_campaign_id->DbValue = $row['interior_campaign_id'];
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
        return $_SESSION[$name] ?? GetUrl("viewallbuseslist");
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
        if ($pageName == "viewallbusesview") {
            return $Language->phrase("View");
        } elseif ($pageName == "viewallbusesedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "viewallbusesadd") {
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
                return "ViewAllBusesView";
            case Config("API_ADD_ACTION"):
                return "ViewAllBusesAdd";
            case Config("API_EDIT_ACTION"):
                return "ViewAllBusesEdit";
            case Config("API_DELETE_ACTION"):
                return "ViewAllBusesDelete";
            case Config("API_LIST_ACTION"):
                return "ViewAllBusesList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "viewallbuseslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("viewallbusesview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("viewallbusesview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "viewallbusesadd?" . $this->getUrlParm($parm);
        } else {
            $url = "viewallbusesadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("viewallbusesedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("viewallbusesadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("viewallbusesdelete", $this->getUrlParm());
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
        $this->number->setDbValue($row['number']);
        $this->platform->setDbValue($row['platform']);
        $this->operator->setDbValue($row['operator']);
        $this->exterior_campaign->setDbValue($row['exterior_campaign']);
        $this->exterior_campaign_vendor->setDbValue($row['exterior_campaign_vendor']);
        $this->interior_campaign->setDbValue($row['interior_campaign']);
        $this->interior_campaign_vendor->setDbValue($row['interior_campaign_vendor']);
        $this->bus_status->setDbValue($row['bus_status']);
        $this->bus_size->setDbValue($row['bus_size']);
        $this->bus_depot->setDbValue($row['bus_depot']);
        $this->ts_created->setDbValue($row['ts_created']);
        $this->ts_last_update->setDbValue($row['ts_last_update']);
        $this->bus_status_id->setDbValue($row['bus_status_id']);
        $this->bus_size_id->setDbValue($row['bus_size_id']);
        $this->bus_depot_id->setDbValue($row['bus_depot_id']);
        $this->platform_id->setDbValue($row['platform_id']);
        $this->operator_id->setDbValue($row['operator_id']);
        $this->exterior_campaign_id->setDbValue($row['exterior_campaign_id']);
        $this->interior_campaign_id->setDbValue($row['interior_campaign_id']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // number
        $this->number->CellCssStyle = "white-space: nowrap;";

        // platform
        $this->platform->CellCssStyle = "white-space: nowrap;";

        // operator
        $this->operator->CellCssStyle = "white-space: nowrap;";

        // exterior_campaign
        $this->exterior_campaign->CellCssStyle = "white-space: nowrap;";

        // exterior_campaign_vendor
        $this->exterior_campaign_vendor->CellCssStyle = "white-space: nowrap;";

        // interior_campaign
        $this->interior_campaign->CellCssStyle = "white-space: nowrap;";

        // interior_campaign_vendor
        $this->interior_campaign_vendor->CellCssStyle = "white-space: nowrap;";

        // bus_status
        $this->bus_status->CellCssStyle = "white-space: nowrap;";

        // bus_size
        $this->bus_size->CellCssStyle = "white-space: nowrap;";

        // bus_depot
        $this->bus_depot->CellCssStyle = "white-space: nowrap;";

        // ts_created
        $this->ts_created->CellCssStyle = "white-space: nowrap;";

        // ts_last_update
        $this->ts_last_update->CellCssStyle = "white-space: nowrap;";

        // bus_status_id
        $this->bus_status_id->CellCssStyle = "white-space: nowrap;";

        // bus_size_id
        $this->bus_size_id->CellCssStyle = "white-space: nowrap;";

        // bus_depot_id
        $this->bus_depot_id->CellCssStyle = "white-space: nowrap;";

        // platform_id
        $this->platform_id->CellCssStyle = "white-space: nowrap;";

        // operator_id
        $this->operator_id->CellCssStyle = "white-space: nowrap;";

        // exterior_campaign_id
        $this->exterior_campaign_id->CellCssStyle = "white-space: nowrap;";

        // interior_campaign_id
        $this->interior_campaign_id->CellCssStyle = "white-space: nowrap;";

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // number
        $this->number->ViewValue = $this->number->CurrentValue;
        $this->number->ViewCustomAttributes = "";

        // platform
        $this->platform->ViewValue = $this->platform->CurrentValue;
        $this->platform->ViewCustomAttributes = "";

        // operator
        $this->operator->ViewValue = $this->operator->CurrentValue;
        $this->operator->ViewCustomAttributes = "";

        // exterior_campaign
        $this->exterior_campaign->ViewValue = $this->exterior_campaign->CurrentValue;
        $this->exterior_campaign->ViewCustomAttributes = "";

        // exterior_campaign_vendor
        $this->exterior_campaign_vendor->ViewValue = $this->exterior_campaign_vendor->CurrentValue;
        $this->exterior_campaign_vendor->ViewCustomAttributes = "";

        // interior_campaign
        $this->interior_campaign->ViewValue = $this->interior_campaign->CurrentValue;
        $this->interior_campaign->ViewCustomAttributes = "";

        // interior_campaign_vendor
        $this->interior_campaign_vendor->ViewValue = $this->interior_campaign_vendor->CurrentValue;
        $this->interior_campaign_vendor->ViewCustomAttributes = "";

        // bus_status
        $this->bus_status->ViewValue = $this->bus_status->CurrentValue;
        $this->bus_status->ViewCustomAttributes = "";

        // bus_size
        $this->bus_size->ViewValue = $this->bus_size->CurrentValue;
        $this->bus_size->ViewCustomAttributes = "";

        // bus_depot
        $this->bus_depot->ViewValue = $this->bus_depot->CurrentValue;
        $this->bus_depot->ViewCustomAttributes = "";

        // ts_created
        $this->ts_created->ViewValue = $this->ts_created->CurrentValue;
        $this->ts_created->ViewValue = FormatDateTime($this->ts_created->ViewValue, 0);
        $this->ts_created->ViewCustomAttributes = "";

        // ts_last_update
        $this->ts_last_update->ViewValue = $this->ts_last_update->CurrentValue;
        $this->ts_last_update->ViewValue = FormatDateTime($this->ts_last_update->ViewValue, 0);
        $this->ts_last_update->ViewCustomAttributes = "";

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

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // number
        $this->number->LinkCustomAttributes = "";
        $this->number->HrefValue = "";
        $this->number->TooltipValue = "";

        // platform
        $this->platform->LinkCustomAttributes = "";
        $this->platform->HrefValue = "";
        $this->platform->TooltipValue = "";

        // operator
        $this->operator->LinkCustomAttributes = "";
        $this->operator->HrefValue = "";
        $this->operator->TooltipValue = "";

        // exterior_campaign
        $this->exterior_campaign->LinkCustomAttributes = "";
        $this->exterior_campaign->HrefValue = "";
        $this->exterior_campaign->TooltipValue = "";

        // exterior_campaign_vendor
        $this->exterior_campaign_vendor->LinkCustomAttributes = "";
        $this->exterior_campaign_vendor->HrefValue = "";
        $this->exterior_campaign_vendor->TooltipValue = "";

        // interior_campaign
        $this->interior_campaign->LinkCustomAttributes = "";
        $this->interior_campaign->HrefValue = "";
        $this->interior_campaign->TooltipValue = "";

        // interior_campaign_vendor
        $this->interior_campaign_vendor->LinkCustomAttributes = "";
        $this->interior_campaign_vendor->HrefValue = "";
        $this->interior_campaign_vendor->TooltipValue = "";

        // bus_status
        $this->bus_status->LinkCustomAttributes = "";
        $this->bus_status->HrefValue = "";
        $this->bus_status->TooltipValue = "";

        // bus_size
        $this->bus_size->LinkCustomAttributes = "";
        $this->bus_size->HrefValue = "";
        $this->bus_size->TooltipValue = "";

        // bus_depot
        $this->bus_depot->LinkCustomAttributes = "";
        $this->bus_depot->HrefValue = "";
        $this->bus_depot->TooltipValue = "";

        // ts_created
        $this->ts_created->LinkCustomAttributes = "";
        $this->ts_created->HrefValue = "";
        $this->ts_created->TooltipValue = "";

        // ts_last_update
        $this->ts_last_update->LinkCustomAttributes = "";
        $this->ts_last_update->HrefValue = "";
        $this->ts_last_update->TooltipValue = "";

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

        // number
        $this->number->EditAttrs["class"] = "form-control";
        $this->number->EditCustomAttributes = "";
        if (!$this->number->Raw) {
            $this->number->CurrentValue = HtmlDecode($this->number->CurrentValue);
        }
        $this->number->EditValue = $this->number->CurrentValue;
        $this->number->PlaceHolder = RemoveHtml($this->number->caption());

        // platform
        $this->platform->EditAttrs["class"] = "form-control";
        $this->platform->EditCustomAttributes = "";
        if (!$this->platform->Raw) {
            $this->platform->CurrentValue = HtmlDecode($this->platform->CurrentValue);
        }
        $this->platform->EditValue = $this->platform->CurrentValue;
        $this->platform->PlaceHolder = RemoveHtml($this->platform->caption());

        // operator
        $this->operator->EditAttrs["class"] = "form-control";
        $this->operator->EditCustomAttributes = "";
        if (!$this->operator->Raw) {
            $this->operator->CurrentValue = HtmlDecode($this->operator->CurrentValue);
        }
        $this->operator->EditValue = $this->operator->CurrentValue;
        $this->operator->PlaceHolder = RemoveHtml($this->operator->caption());

        // exterior_campaign
        $this->exterior_campaign->EditAttrs["class"] = "form-control";
        $this->exterior_campaign->EditCustomAttributes = "";
        $this->exterior_campaign->EditValue = $this->exterior_campaign->CurrentValue;
        $this->exterior_campaign->PlaceHolder = RemoveHtml($this->exterior_campaign->caption());

        // exterior_campaign_vendor
        $this->exterior_campaign_vendor->EditAttrs["class"] = "form-control";
        $this->exterior_campaign_vendor->EditCustomAttributes = "";
        if (!$this->exterior_campaign_vendor->Raw) {
            $this->exterior_campaign_vendor->CurrentValue = HtmlDecode($this->exterior_campaign_vendor->CurrentValue);
        }
        $this->exterior_campaign_vendor->EditValue = $this->exterior_campaign_vendor->CurrentValue;
        $this->exterior_campaign_vendor->PlaceHolder = RemoveHtml($this->exterior_campaign_vendor->caption());

        // interior_campaign
        $this->interior_campaign->EditAttrs["class"] = "form-control";
        $this->interior_campaign->EditCustomAttributes = "";
        $this->interior_campaign->EditValue = $this->interior_campaign->CurrentValue;
        $this->interior_campaign->PlaceHolder = RemoveHtml($this->interior_campaign->caption());

        // interior_campaign_vendor
        $this->interior_campaign_vendor->EditAttrs["class"] = "form-control";
        $this->interior_campaign_vendor->EditCustomAttributes = "";
        if (!$this->interior_campaign_vendor->Raw) {
            $this->interior_campaign_vendor->CurrentValue = HtmlDecode($this->interior_campaign_vendor->CurrentValue);
        }
        $this->interior_campaign_vendor->EditValue = $this->interior_campaign_vendor->CurrentValue;
        $this->interior_campaign_vendor->PlaceHolder = RemoveHtml($this->interior_campaign_vendor->caption());

        // bus_status
        $this->bus_status->EditAttrs["class"] = "form-control";
        $this->bus_status->EditCustomAttributes = "";
        if (!$this->bus_status->Raw) {
            $this->bus_status->CurrentValue = HtmlDecode($this->bus_status->CurrentValue);
        }
        $this->bus_status->EditValue = $this->bus_status->CurrentValue;
        $this->bus_status->PlaceHolder = RemoveHtml($this->bus_status->caption());

        // bus_size
        $this->bus_size->EditAttrs["class"] = "form-control";
        $this->bus_size->EditCustomAttributes = "";
        $this->bus_size->EditValue = $this->bus_size->CurrentValue;
        $this->bus_size->PlaceHolder = RemoveHtml($this->bus_size->caption());

        // bus_depot
        $this->bus_depot->EditAttrs["class"] = "form-control";
        $this->bus_depot->EditCustomAttributes = "";
        $this->bus_depot->EditValue = $this->bus_depot->CurrentValue;
        $this->bus_depot->PlaceHolder = RemoveHtml($this->bus_depot->caption());

        // ts_created
        $this->ts_created->EditAttrs["class"] = "form-control";
        $this->ts_created->EditCustomAttributes = "";
        $this->ts_created->EditValue = FormatDateTime($this->ts_created->CurrentValue, 8);
        $this->ts_created->PlaceHolder = RemoveHtml($this->ts_created->caption());

        // ts_last_update
        $this->ts_last_update->EditAttrs["class"] = "form-control";
        $this->ts_last_update->EditCustomAttributes = "";
        $this->ts_last_update->EditValue = FormatDateTime($this->ts_last_update->CurrentValue, 8);
        $this->ts_last_update->PlaceHolder = RemoveHtml($this->ts_last_update->caption());

        // bus_status_id
        $this->bus_status_id->EditAttrs["class"] = "form-control";
        $this->bus_status_id->EditCustomAttributes = "";
        $this->bus_status_id->PlaceHolder = RemoveHtml($this->bus_status_id->caption());

        // bus_size_id
        $this->bus_size_id->EditAttrs["class"] = "form-control";
        $this->bus_size_id->EditCustomAttributes = "";
        $this->bus_size_id->PlaceHolder = RemoveHtml($this->bus_size_id->caption());

        // bus_depot_id
        $this->bus_depot_id->EditAttrs["class"] = "form-control";
        $this->bus_depot_id->EditCustomAttributes = "";
        $this->bus_depot_id->PlaceHolder = RemoveHtml($this->bus_depot_id->caption());

        // platform_id
        $this->platform_id->EditAttrs["class"] = "form-control";
        $this->platform_id->EditCustomAttributes = "";
        $this->platform_id->PlaceHolder = RemoveHtml($this->platform_id->caption());

        // operator_id
        $this->operator_id->EditAttrs["class"] = "form-control";
        $this->operator_id->EditCustomAttributes = "";
        $this->operator_id->PlaceHolder = RemoveHtml($this->operator_id->caption());

        // exterior_campaign_id
        $this->exterior_campaign_id->EditAttrs["class"] = "form-control";
        $this->exterior_campaign_id->EditCustomAttributes = "";
        $this->exterior_campaign_id->PlaceHolder = RemoveHtml($this->exterior_campaign_id->caption());

        // interior_campaign_id
        $this->interior_campaign_id->EditAttrs["class"] = "form-control";
        $this->interior_campaign_id->EditCustomAttributes = "";
        $this->interior_campaign_id->PlaceHolder = RemoveHtml($this->interior_campaign_id->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            $this->id->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->id->CurrentValue = $this->id->Count;
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";
            $this->id->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->number);
                    $doc->exportCaption($this->platform);
                    $doc->exportCaption($this->operator);
                    $doc->exportCaption($this->exterior_campaign);
                    $doc->exportCaption($this->exterior_campaign_vendor);
                    $doc->exportCaption($this->interior_campaign);
                    $doc->exportCaption($this->interior_campaign_vendor);
                    $doc->exportCaption($this->bus_status);
                    $doc->exportCaption($this->bus_size);
                    $doc->exportCaption($this->bus_depot);
                    $doc->exportCaption($this->ts_created);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->number);
                    $doc->exportCaption($this->platform);
                    $doc->exportCaption($this->operator);
                    $doc->exportCaption($this->exterior_campaign_vendor);
                    $doc->exportCaption($this->interior_campaign_vendor);
                    $doc->exportCaption($this->bus_status);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->ts_last_update);
                    $doc->exportCaption($this->bus_status_id);
                    $doc->exportCaption($this->bus_size_id);
                    $doc->exportCaption($this->bus_depot_id);
                    $doc->exportCaption($this->platform_id);
                    $doc->exportCaption($this->operator_id);
                    $doc->exportCaption($this->exterior_campaign_id);
                    $doc->exportCaption($this->interior_campaign_id);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->number);
                        $doc->exportField($this->platform);
                        $doc->exportField($this->operator);
                        $doc->exportField($this->exterior_campaign);
                        $doc->exportField($this->exterior_campaign_vendor);
                        $doc->exportField($this->interior_campaign);
                        $doc->exportField($this->interior_campaign_vendor);
                        $doc->exportField($this->bus_status);
                        $doc->exportField($this->bus_size);
                        $doc->exportField($this->bus_depot);
                        $doc->exportField($this->ts_created);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->number);
                        $doc->exportField($this->platform);
                        $doc->exportField($this->operator);
                        $doc->exportField($this->exterior_campaign_vendor);
                        $doc->exportField($this->interior_campaign_vendor);
                        $doc->exportField($this->bus_status);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->ts_last_update);
                        $doc->exportField($this->bus_status_id);
                        $doc->exportField($this->bus_size_id);
                        $doc->exportField($this->bus_depot_id);
                        $doc->exportField($this->platform_id);
                        $doc->exportField($this->operator_id);
                        $doc->exportField($this->exterior_campaign_id);
                        $doc->exportField($this->interior_campaign_id);
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
                $doc->exportAggregate($this->id, 'COUNT');
                $doc->exportAggregate($this->number, '');
                $doc->exportAggregate($this->platform, '');
                $doc->exportAggregate($this->operator, '');
                $doc->exportAggregate($this->exterior_campaign_vendor, '');
                $doc->exportAggregate($this->interior_campaign_vendor, '');
                $doc->exportAggregate($this->bus_status, '');
                $doc->exportAggregate($this->ts_created, '');
                $doc->exportAggregate($this->ts_last_update, '');
                $doc->exportAggregate($this->bus_status_id, '');
                $doc->exportAggregate($this->bus_size_id, '');
                $doc->exportAggregate($this->bus_depot_id, '');
                $doc->exportAggregate($this->platform_id, '');
                $doc->exportAggregate($this->operator_id, '');
                $doc->exportAggregate($this->exterior_campaign_id, '');
                $doc->exportAggregate($this->interior_campaign_id, '');
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
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}

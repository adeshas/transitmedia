<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for view_buses_exterior
 */
class ViewBusesExterior extends DbTable
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
    public $platform_id;
    public $operator_id;
    public $exterior_campaign_id;
    public $bus_status_id;
    public $bus_depot_id;
    public $ts_created;
    public $ts_last_update;
    public $vendor_id;
    public $campaign_id;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'view_buses_exterior';
        $this->TableName = 'view_buses_exterior';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "\"view_buses_exterior\"";
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
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_id', 'id', '"id"', 'CAST("id" AS varchar(255))', 3, 4, -1, false, '"id"', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // number
        $this->number = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_number', 'number', '"number"', '"number"', 200, 0, -1, false, '"number"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->number->Sortable = true; // Allow sort
        $this->number->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->number->Param, "CustomMsg");
        $this->Fields['number'] = &$this->number;

        // platform_id
        $this->platform_id = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_platform_id', 'platform_id', '"platform_id"', 'CAST("platform_id" AS varchar(255))', 3, 4, -1, false, '"platform_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->platform_id->Sortable = true; // Allow sort
        $this->platform_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->platform_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->platform_id->Lookup = new Lookup('platform_id', 'y_platforms', false, 'id', ["name","","",""], [], ["x_operator_id"], [], [], [], [], '', '');
        $this->platform_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->platform_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->platform_id->Param, "CustomMsg");
        $this->Fields['platform_id'] = &$this->platform_id;

        // operator_id
        $this->operator_id = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_operator_id', 'operator_id', '"operator_id"', 'CAST("operator_id" AS varchar(255))', 3, 4, -1, false, '"operator_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->operator_id->Sortable = true; // Allow sort
        $this->operator_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->operator_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->operator_id->Lookup = new Lookup('operator_id', 'y_operators', false, 'id', ["name","platform_id","",""], ["x_platform_id"], [], ["platform_id"], ["x_platform_id"], [], [], '', '');
        $this->operator_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->operator_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->operator_id->Param, "CustomMsg");
        $this->Fields['operator_id'] = &$this->operator_id;

        // exterior_campaign_id
        $this->exterior_campaign_id = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_exterior_campaign_id', 'exterior_campaign_id', '"exterior_campaign_id"', 'CAST("exterior_campaign_id" AS varchar(255))', 3, 4, -1, false, '"exterior_campaign_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->exterior_campaign_id->Sortable = true; // Allow sort
        $this->exterior_campaign_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->exterior_campaign_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->exterior_campaign_id->Lookup = new Lookup('exterior_campaign_id', 'main_campaigns', false, 'id', ["name","quantity","vendor_id",""], ["main_buses x_platform_id"], [], ["platform_id"], ["x_platform_id"], [], [], '"id" DESC', '');
        $this->exterior_campaign_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->exterior_campaign_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->exterior_campaign_id->Param, "CustomMsg");
        $this->Fields['exterior_campaign_id'] = &$this->exterior_campaign_id;

        // bus_status_id
        $this->bus_status_id = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_bus_status_id', 'bus_status_id', '"bus_status_id"', 'CAST("bus_status_id" AS varchar(255))', 3, 4, -1, false, '"bus_status_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->bus_status_id->Sortable = true; // Allow sort
        $this->bus_status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->bus_status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->bus_status_id->Lookup = new Lookup('bus_status_id', 'x_bus_status', false, 'id', ["name","availability","",""], [], [], [], [], [], [], '', '');
        $this->bus_status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->bus_status_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bus_status_id->Param, "CustomMsg");
        $this->Fields['bus_status_id'] = &$this->bus_status_id;

        // bus_depot_id
        $this->bus_depot_id = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_bus_depot_id', 'bus_depot_id', '"bus_depot_id"', 'CAST("bus_depot_id" AS varchar(255))', 3, 4, -1, false, '"bus_depot_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->bus_depot_id->Sortable = true; // Allow sort
        $this->bus_depot_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->bus_depot_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->bus_depot_id->Lookup = new Lookup('bus_depot_id', 'x_bus_depot', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->bus_depot_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->bus_depot_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bus_depot_id->Param, "CustomMsg");
        $this->Fields['bus_depot_id'] = &$this->bus_depot_id;

        // ts_created
        $this->ts_created = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_ts_created', 'ts_created', '"ts_created"', CastDateFieldForLike("\"ts_created\"", 0, "DB"), 135, 8, 0, false, '"ts_created"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_created->Sortable = true; // Allow sort
        $this->ts_created->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->ts_created->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ts_created->Param, "CustomMsg");
        $this->Fields['ts_created'] = &$this->ts_created;

        // ts_last_update
        $this->ts_last_update = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_ts_last_update', 'ts_last_update', '"ts_last_update"', CastDateFieldForLike("\"ts_last_update\"", 0, "DB"), 135, 8, 0, false, '"ts_last_update"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_last_update->Sortable = true; // Allow sort
        $this->ts_last_update->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->ts_last_update->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ts_last_update->Param, "CustomMsg");
        $this->Fields['ts_last_update'] = &$this->ts_last_update;

        // vendor_id
        $this->vendor_id = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_vendor_id', 'vendor_id', '"vendor_id"', 'CAST("vendor_id" AS varchar(255))', 3, 4, -1, false, '"vendor_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->vendor_id->Sortable = true; // Allow sort
        $this->vendor_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->vendor_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->vendor_id->Lookup = new Lookup('vendor_id', 'y_vendors', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->vendor_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->vendor_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->vendor_id->Param, "CustomMsg");
        $this->Fields['vendor_id'] = &$this->vendor_id;

        // campaign_id
        $this->campaign_id = new DbField('view_buses_exterior', 'view_buses_exterior', 'x_campaign_id', 'campaign_id', '"campaign_id"', 'CAST("campaign_id" AS varchar(255))', 3, 4, -1, false, '"campaign_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->campaign_id->Sortable = true; // Allow sort
        $this->campaign_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->campaign_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->campaign_id->Param, "CustomMsg");
        $this->Fields['campaign_id'] = &$this->campaign_id;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"view_buses_exterior\"";
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
        global $Security;
        // Add User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $filter = $this->addUserIDFilter($filter);
        }
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
        $this->number->DbValue = $row['number'];
        $this->platform_id->DbValue = $row['platform_id'];
        $this->operator_id->DbValue = $row['operator_id'];
        $this->exterior_campaign_id->DbValue = $row['exterior_campaign_id'];
        $this->bus_status_id->DbValue = $row['bus_status_id'];
        $this->bus_depot_id->DbValue = $row['bus_depot_id'];
        $this->ts_created->DbValue = $row['ts_created'];
        $this->ts_last_update->DbValue = $row['ts_last_update'];
        $this->vendor_id->DbValue = $row['vendor_id'];
        $this->campaign_id->DbValue = $row['campaign_id'];
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
        return $_SESSION[$name] ?? GetUrl("viewbusesexteriorlist");
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
        if ($pageName == "viewbusesexteriorview") {
            return $Language->phrase("View");
        } elseif ($pageName == "viewbusesexterioredit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "viewbusesexterioradd") {
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
                return "ViewBusesExteriorView";
            case Config("API_ADD_ACTION"):
                return "ViewBusesExteriorAdd";
            case Config("API_EDIT_ACTION"):
                return "ViewBusesExteriorEdit";
            case Config("API_DELETE_ACTION"):
                return "ViewBusesExteriorDelete";
            case Config("API_LIST_ACTION"):
                return "ViewBusesExteriorList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "viewbusesexteriorlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("viewbusesexteriorview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("viewbusesexteriorview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "viewbusesexterioradd?" . $this->getUrlParm($parm);
        } else {
            $url = "viewbusesexterioradd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("viewbusesexterioredit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("viewbusesexterioradd", $this->getUrlParm($parm));
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
        return $this->keyUrl("viewbusesexteriordelete", $this->getUrlParm());
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
        $this->number->setDbValue($row['number']);
        $this->platform_id->setDbValue($row['platform_id']);
        $this->operator_id->setDbValue($row['operator_id']);
        $this->exterior_campaign_id->setDbValue($row['exterior_campaign_id']);
        $this->bus_status_id->setDbValue($row['bus_status_id']);
        $this->bus_depot_id->setDbValue($row['bus_depot_id']);
        $this->ts_created->setDbValue($row['ts_created']);
        $this->ts_last_update->setDbValue($row['ts_last_update']);
        $this->vendor_id->setDbValue($row['vendor_id']);
        $this->campaign_id->setDbValue($row['campaign_id']);
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

        // platform_id

        // operator_id

        // exterior_campaign_id

        // bus_status_id

        // bus_depot_id

        // ts_created

        // ts_last_update

        // vendor_id

        // campaign_id

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // number
        $this->number->ViewValue = $this->number->CurrentValue;
        $this->number->CssClass = "font-weight-bold";
        $this->number->ViewCustomAttributes = "";

        // platform_id
        $curVal = trim(strval($this->platform_id->CurrentValue));
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
        $curVal = trim(strval($this->operator_id->CurrentValue));
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
        $curVal = trim(strval($this->exterior_campaign_id->CurrentValue));
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
        $this->exterior_campaign_id->CssClass = "font-weight-bold";
        $this->exterior_campaign_id->ViewCustomAttributes = "";

        // bus_status_id
        $curVal = trim(strval($this->bus_status_id->CurrentValue));
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

        // bus_depot_id
        $curVal = trim(strval($this->bus_depot_id->CurrentValue));
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
        $this->ts_last_update->ViewValue = FormatDateTime($this->ts_last_update->ViewValue, 0);
        $this->ts_last_update->ViewCustomAttributes = "";

        // vendor_id
        $curVal = trim(strval($this->vendor_id->CurrentValue));
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

        // campaign_id
        $this->campaign_id->ViewValue = $this->campaign_id->CurrentValue;
        $this->campaign_id->ViewValue = FormatNumber($this->campaign_id->ViewValue, 0, -2, -2, -2);
        $this->campaign_id->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // number
        $this->number->LinkCustomAttributes = "";
        $this->number->HrefValue = "";
        $this->number->TooltipValue = "";

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

        // bus_status_id
        $this->bus_status_id->LinkCustomAttributes = "";
        $this->bus_status_id->HrefValue = "";
        $this->bus_status_id->TooltipValue = "";

        // bus_depot_id
        $this->bus_depot_id->LinkCustomAttributes = "";
        $this->bus_depot_id->HrefValue = "";
        $this->bus_depot_id->TooltipValue = "";

        // ts_created
        $this->ts_created->LinkCustomAttributes = "";
        $this->ts_created->HrefValue = "";
        $this->ts_created->TooltipValue = "";

        // ts_last_update
        $this->ts_last_update->LinkCustomAttributes = "";
        $this->ts_last_update->HrefValue = "";
        $this->ts_last_update->TooltipValue = "";

        // vendor_id
        $this->vendor_id->LinkCustomAttributes = "";
        $this->vendor_id->HrefValue = "";
        $this->vendor_id->TooltipValue = "";

        // campaign_id
        $this->campaign_id->LinkCustomAttributes = "";
        $this->campaign_id->HrefValue = "";
        $this->campaign_id->TooltipValue = "";

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

        // bus_status_id
        $this->bus_status_id->EditAttrs["class"] = "form-control";
        $this->bus_status_id->EditCustomAttributes = "";
        $this->bus_status_id->PlaceHolder = RemoveHtml($this->bus_status_id->caption());

        // bus_depot_id
        $this->bus_depot_id->EditAttrs["class"] = "form-control";
        $this->bus_depot_id->EditCustomAttributes = "";
        $this->bus_depot_id->PlaceHolder = RemoveHtml($this->bus_depot_id->caption());

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

        // vendor_id
        $this->vendor_id->EditAttrs["class"] = "form-control";
        $this->vendor_id->EditCustomAttributes = "";
        if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
        } else {
            $this->vendor_id->PlaceHolder = RemoveHtml($this->vendor_id->caption());
        }

        // campaign_id
        $this->campaign_id->EditAttrs["class"] = "form-control";
        $this->campaign_id->EditCustomAttributes = "";
        $this->campaign_id->EditValue = $this->campaign_id->CurrentValue;
        $this->campaign_id->PlaceHolder = RemoveHtml($this->campaign_id->caption());

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
                    $doc->exportCaption($this->number);
                    $doc->exportCaption($this->platform_id);
                    $doc->exportCaption($this->operator_id);
                    $doc->exportCaption($this->exterior_campaign_id);
                    $doc->exportCaption($this->bus_status_id);
                    $doc->exportCaption($this->bus_depot_id);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->ts_last_update);
                    $doc->exportCaption($this->vendor_id);
                    $doc->exportCaption($this->campaign_id);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->number);
                    $doc->exportCaption($this->platform_id);
                    $doc->exportCaption($this->operator_id);
                    $doc->exportCaption($this->exterior_campaign_id);
                    $doc->exportCaption($this->bus_status_id);
                    $doc->exportCaption($this->bus_depot_id);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->ts_last_update);
                    $doc->exportCaption($this->vendor_id);
                    $doc->exportCaption($this->campaign_id);
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
                        $doc->exportField($this->number);
                        $doc->exportField($this->platform_id);
                        $doc->exportField($this->operator_id);
                        $doc->exportField($this->exterior_campaign_id);
                        $doc->exportField($this->bus_status_id);
                        $doc->exportField($this->bus_depot_id);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->ts_last_update);
                        $doc->exportField($this->vendor_id);
                        $doc->exportField($this->campaign_id);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->number);
                        $doc->exportField($this->platform_id);
                        $doc->exportField($this->operator_id);
                        $doc->exportField($this->exterior_campaign_id);
                        $doc->exportField($this->bus_status_id);
                        $doc->exportField($this->bus_depot_id);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->ts_last_update);
                        $doc->exportField($this->vendor_id);
                        $doc->exportField($this->campaign_id);
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

    // Add User ID filter
    public function addUserIDFilter($filter = "")
    {
        global $Security;
        $filterWrk = "";
        $id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
        if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
            $filterWrk = $Security->userIdList();
            if ($filterWrk != "") {
                $filterWrk = '"vendor_id" IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM \"view_buses_exterior\"";
        $filter = $this->addUserIDFilter("");
        if ($filter != "") {
            $sql .= " WHERE " . $filter;
        }

        // List all values
        if ($rs = Conn($UserTable->Dbid)->executeQuery($sql)->fetchAll(\PDO::FETCH_NUM)) {
            foreach ($rs as $row) {
                if ($wrk != "") {
                    $wrk .= ",";
                }
                $wrk .= QuotedValue($row[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
            }
        }
        if ($wrk != "") {
            $wrk = $fld->Expression . " IN (" . $wrk . ")";
        } else { // No User ID value found
            $wrk = "0=1";
        }
        return $wrk;
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

<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for main_reports
 */
class MainReports extends DbTable
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
    public $date;
    public $image;
    public $video;
    public $comments;
    public $type_id;
    public $campaign_id;
    public $ref_bus_id;
    public $ts_created;
    public $vendor_id;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'main_reports';
        $this->TableName = 'main_reports';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "\"main_reports\"";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = true; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('main_reports', 'main_reports', 'x_id', 'id', '"id"', 'CAST("id" AS varchar(255))', 3, 4, -1, false, '"id"', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Nullable = false; // NOT NULL field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // date
        $this->date = new DbField('main_reports', 'main_reports', 'x_date', 'date', '"date"', CastDateFieldForLike("\"date\"", 0, "DB"), 133, 4, 0, false, '"date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->date->Nullable = false; // NOT NULL field
        $this->date->Required = true; // Required field
        $this->date->Sortable = true; // Allow sort
        $this->date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->date->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->date->Param, "CustomMsg");
        $this->Fields['date'] = &$this->date;

        // image
        $this->image = new DbField('main_reports', 'main_reports', 'x_image', 'image', '"image"', '"image"', 201, 0, -1, false, '"image"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->image->Sortable = true; // Allow sort
        $this->image->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->image->Param, "CustomMsg");
        $this->Fields['image'] = &$this->image;

        // video
        $this->video = new DbField('main_reports', 'main_reports', 'x_video', 'video', '"video"', '"video"', 201, 0, -1, false, '"video"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->video->Sortable = true; // Allow sort
        $this->video->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->video->Param, "CustomMsg");
        $this->Fields['video'] = &$this->video;

        // comments
        $this->comments = new DbField('main_reports', 'main_reports', 'x_comments', 'comments', '"comments"', '"comments"', 201, 0, -1, false, '"comments"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->comments->Sortable = true; // Allow sort
        $this->comments->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->comments->Param, "CustomMsg");
        $this->Fields['comments'] = &$this->comments;

        // type_id
        $this->type_id = new DbField('main_reports', 'main_reports', 'x_type_id', 'type_id', '"type_id"', 'CAST("type_id" AS varchar(255))', 3, 4, -1, false, '"type_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->type_id->Sortable = true; // Allow sort
        $this->type_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->type_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->type_id->Lookup = new Lookup('type_id', 'x_report_types', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->type_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->type_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->type_id->Param, "CustomMsg");
        $this->Fields['type_id'] = &$this->type_id;

        // campaign_id
        $this->campaign_id = new DbField('main_reports', 'main_reports', 'x_campaign_id', 'campaign_id', '"campaign_id"', 'CAST("campaign_id" AS varchar(255))', 3, 4, -1, false, '"campaign_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->campaign_id->Nullable = false; // NOT NULL field
        $this->campaign_id->Required = true; // Required field
        $this->campaign_id->Sortable = true; // Allow sort
        $this->campaign_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->campaign_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->campaign_id->Lookup = new Lookup('campaign_id', 'main_campaigns', false, 'id', ["name","","",""], [], [], [], [], [], [], '"id" DESC', '');
        $this->campaign_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->campaign_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->campaign_id->Param, "CustomMsg");
        $this->Fields['campaign_id'] = &$this->campaign_id;

        // ref_bus_id
        $this->ref_bus_id = new DbField('main_reports', 'main_reports', 'x_ref_bus_id', 'ref_bus_id', '"ref_bus_id"', 'CAST("ref_bus_id" AS varchar(255))', 3, 4, -1, false, '"EV__ref_bus_id"', true, false, true, 'FORMATTED TEXT', 'TEXT');
        $this->ref_bus_id->Sortable = true; // Allow sort
        $this->ref_bus_id->Lookup = new Lookup('ref_bus_id', 'main_buses', false, 'id', ["number","","",""], [], [], [], [], [], [], '', '');
        $this->ref_bus_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ref_bus_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ref_bus_id->Param, "CustomMsg");
        $this->Fields['ref_bus_id'] = &$this->ref_bus_id;

        // ts_created
        $this->ts_created = new DbField('main_reports', 'main_reports', 'x_ts_created', 'ts_created', '"ts_created"', CastDateFieldForLike("\"ts_created\"", 0, "DB"), 135, 8, 0, false, '"ts_created"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_created->Nullable = false; // NOT NULL field
        $this->ts_created->Required = true; // Required field
        $this->ts_created->Sortable = true; // Allow sort
        $this->ts_created->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->ts_created->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ts_created->Param, "CustomMsg");
        $this->Fields['ts_created'] = &$this->ts_created;

        // vendor_id
        $this->vendor_id = new DbField('main_reports', 'main_reports', 'x_vendor_id', 'vendor_id', '"vendor_id"', 'CAST("vendor_id" AS varchar(255))', 3, 4, -1, false, '"vendor_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->vendor_id->Nullable = false; // NOT NULL field
        $this->vendor_id->Required = true; // Required field
        $this->vendor_id->Sortable = true; // Allow sort
        $this->vendor_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->vendor_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->vendor_id->Lookup = new Lookup('vendor_id', 'y_vendors', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->vendor_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->vendor_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->vendor_id->Param, "CustomMsg");
        $this->Fields['vendor_id'] = &$this->vendor_id;
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
            $sortFieldList = ($fld->VirtualExpression != "") ? $fld->VirtualExpression : $sortField;
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortFieldList . " " . $curSort : "";
            $this->setSessionOrderByList($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Session ORDER BY for List page
    public function getSessionOrderByList()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST"));
    }

    public function setSessionOrderByList($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST")] = $v;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"main_reports\"";
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

    public function getSqlSelectList() // Select for List page
    {
        if ($this->SqlSelectList) {
            return $this->SqlSelectList;
        }
        $from = "(SELECT *, (SELECT \"number\" FROM \"main_buses\" \"TMP_LOOKUPTABLE\" WHERE \"TMP_LOOKUPTABLE\".\"id\" = \"main_reports\".\"ref_bus_id\" LIMIT 1) AS \"EV__ref_bus_id\" FROM \"main_reports\")";
        return $from . " \"TMP_TABLE\"";
    }

    public function sqlSelectList() // For backward compatibility
    {
        return $this->getSqlSelectList();
    }

    public function setSqlSelectList($v)
    {
        $this->SqlSelectList = $v;
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
        if ($this->useVirtualFields()) {
            $select = "*";
            $from = $this->getSqlSelectList();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        } else {
            $select = $this->getSqlSelect();
            $from = $this->getSqlFrom();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        }
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
        $sort = ($this->useVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Check if virtual fields is used in SQL
    protected function useVirtualFields()
    {
        $where = $this->UseSessionForListSql ? $this->getSessionWhere() : $this->CurrentFilter;
        $orderBy = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        if ($where != "") {
            $where = " " . str_replace(["(", ")"], ["", ""], $where) . " ";
        }
        if ($orderBy != "") {
            $orderBy = " " . str_replace(["(", ")"], ["", ""], $orderBy) . " ";
        }
        if (
            $this->ref_bus_id->AdvancedSearch->SearchValue != "" ||
            $this->ref_bus_id->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->ref_bus_id->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->ref_bus_id->VirtualExpression . " ")) {
            return true;
        }
        return false;
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
        if ($this->useVirtualFields()) {
            $sql = $this->buildSelectSql("*", $this->getSqlSelectList(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        } else {
            $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        }
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
            $this->id->setDbValue($conn->fetchColumn("SELECT currval('public.main_reports_id_seq'::regclass)"));
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
        $this->date->DbValue = $row['date'];
        $this->image->DbValue = $row['image'];
        $this->video->DbValue = $row['video'];
        $this->comments->DbValue = $row['comments'];
        $this->type_id->DbValue = $row['type_id'];
        $this->campaign_id->DbValue = $row['campaign_id'];
        $this->ref_bus_id->DbValue = $row['ref_bus_id'];
        $this->ts_created->DbValue = $row['ts_created'];
        $this->vendor_id->DbValue = $row['vendor_id'];
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
        return $_SESSION[$name] ?? GetUrl("mainreportslist");
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
        if ($pageName == "mainreportsview") {
            return $Language->phrase("View");
        } elseif ($pageName == "mainreportsedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "mainreportsadd") {
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
                return "MainReportsView";
            case Config("API_ADD_ACTION"):
                return "MainReportsAdd";
            case Config("API_EDIT_ACTION"):
                return "MainReportsEdit";
            case Config("API_DELETE_ACTION"):
                return "MainReportsDelete";
            case Config("API_LIST_ACTION"):
                return "MainReportsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "mainreportslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("mainreportsview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("mainreportsview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "mainreportsadd?" . $this->getUrlParm($parm);
        } else {
            $url = "mainreportsadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("mainreportsedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("mainreportsadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("mainreportsdelete", $this->getUrlParm());
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
        $this->date->setDbValue($row['date']);
        $this->image->setDbValue($row['image']);
        $this->video->setDbValue($row['video']);
        $this->comments->setDbValue($row['comments']);
        $this->type_id->setDbValue($row['type_id']);
        $this->campaign_id->setDbValue($row['campaign_id']);
        $this->ref_bus_id->setDbValue($row['ref_bus_id']);
        $this->ts_created->setDbValue($row['ts_created']);
        $this->vendor_id->setDbValue($row['vendor_id']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // date

        // image

        // video

        // comments

        // type_id

        // campaign_id

        // ref_bus_id

        // ts_created

        // vendor_id

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // date
        $this->date->ViewValue = $this->date->CurrentValue;
        $this->date->ViewValue = FormatDateTime($this->date->ViewValue, 0);
        $this->date->ViewCustomAttributes = "";

        // image
        $this->image->ViewValue = $this->image->CurrentValue;
        $this->image->ViewCustomAttributes = "";

        // video
        $this->video->ViewValue = $this->video->CurrentValue;
        $this->video->ViewCustomAttributes = "";

        // comments
        $this->comments->ViewValue = $this->comments->CurrentValue;
        $this->comments->ViewCustomAttributes = "";

        // type_id
        $curVal = trim(strval($this->type_id->CurrentValue));
        if ($curVal != "") {
            $this->type_id->ViewValue = $this->type_id->lookupCacheOption($curVal);
            if ($this->type_id->ViewValue === null) { // Lookup from database
                $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->type_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->type_id->Lookup->renderViewRow($rswrk[0]);
                    $this->type_id->ViewValue = $this->type_id->displayValue($arwrk);
                } else {
                    $this->type_id->ViewValue = $this->type_id->CurrentValue;
                }
            }
        } else {
            $this->type_id->ViewValue = null;
        }
        $this->type_id->ViewCustomAttributes = "";

        // campaign_id
        $curVal = trim(strval($this->campaign_id->CurrentValue));
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
        $this->campaign_id->ViewCustomAttributes = "";

        // ref_bus_id
        if ($this->ref_bus_id->VirtualValue != "") {
            $this->ref_bus_id->ViewValue = $this->ref_bus_id->VirtualValue;
        } else {
            $this->ref_bus_id->ViewValue = $this->ref_bus_id->CurrentValue;
            $curVal = trim(strval($this->ref_bus_id->CurrentValue));
            if ($curVal != "") {
                $this->ref_bus_id->ViewValue = $this->ref_bus_id->lookupCacheOption($curVal);
                if ($this->ref_bus_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ref_bus_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ref_bus_id->Lookup->renderViewRow($rswrk[0]);
                        $this->ref_bus_id->ViewValue = $this->ref_bus_id->displayValue($arwrk);
                    } else {
                        $this->ref_bus_id->ViewValue = $this->ref_bus_id->CurrentValue;
                    }
                }
            } else {
                $this->ref_bus_id->ViewValue = null;
            }
        }
        $this->ref_bus_id->ViewCustomAttributes = "";

        // ts_created
        $this->ts_created->ViewValue = $this->ts_created->CurrentValue;
        $this->ts_created->ViewValue = FormatDateTime($this->ts_created->ViewValue, 0);
        $this->ts_created->ViewCustomAttributes = "";

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

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // date
        $this->date->LinkCustomAttributes = "";
        $this->date->HrefValue = "";
        $this->date->TooltipValue = "";

        // image
        $this->image->LinkCustomAttributes = "";
        $this->image->HrefValue = "";
        $this->image->TooltipValue = "";

        // video
        $this->video->LinkCustomAttributes = "";
        $this->video->HrefValue = "";
        $this->video->TooltipValue = "";

        // comments
        $this->comments->LinkCustomAttributes = "";
        $this->comments->HrefValue = "";
        $this->comments->TooltipValue = "";

        // type_id
        $this->type_id->LinkCustomAttributes = "";
        $this->type_id->HrefValue = "";
        $this->type_id->TooltipValue = "";

        // campaign_id
        $this->campaign_id->LinkCustomAttributes = "";
        $this->campaign_id->HrefValue = "";
        $this->campaign_id->TooltipValue = "";

        // ref_bus_id
        $this->ref_bus_id->LinkCustomAttributes = "";
        $this->ref_bus_id->HrefValue = "";
        $this->ref_bus_id->TooltipValue = "";

        // ts_created
        $this->ts_created->LinkCustomAttributes = "";
        $this->ts_created->HrefValue = "";
        $this->ts_created->TooltipValue = "";

        // vendor_id
        $this->vendor_id->LinkCustomAttributes = "";
        $this->vendor_id->HrefValue = "";
        $this->vendor_id->TooltipValue = "";

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

        // date
        $this->date->EditAttrs["class"] = "form-control";
        $this->date->EditCustomAttributes = "";
        $this->date->EditValue = FormatDateTime($this->date->CurrentValue, 8);
        $this->date->PlaceHolder = RemoveHtml($this->date->caption());

        // image
        $this->image->EditAttrs["class"] = "form-control";
        $this->image->EditCustomAttributes = "";
        $this->image->EditValue = $this->image->CurrentValue;
        $this->image->PlaceHolder = RemoveHtml($this->image->caption());

        // video
        $this->video->EditAttrs["class"] = "form-control";
        $this->video->EditCustomAttributes = "";
        $this->video->EditValue = $this->video->CurrentValue;
        $this->video->PlaceHolder = RemoveHtml($this->video->caption());

        // comments
        $this->comments->EditAttrs["class"] = "form-control";
        $this->comments->EditCustomAttributes = "";
        $this->comments->EditValue = $this->comments->CurrentValue;
        $this->comments->PlaceHolder = RemoveHtml($this->comments->caption());

        // type_id
        $this->type_id->EditAttrs["class"] = "form-control";
        $this->type_id->EditCustomAttributes = "";
        $this->type_id->PlaceHolder = RemoveHtml($this->type_id->caption());

        // campaign_id
        $this->campaign_id->EditAttrs["class"] = "form-control";
        $this->campaign_id->EditCustomAttributes = "";
        $this->campaign_id->PlaceHolder = RemoveHtml($this->campaign_id->caption());

        // ref_bus_id
        $this->ref_bus_id->EditAttrs["class"] = "form-control";
        $this->ref_bus_id->EditCustomAttributes = "";
        $this->ref_bus_id->EditValue = $this->ref_bus_id->CurrentValue;
        $this->ref_bus_id->PlaceHolder = RemoveHtml($this->ref_bus_id->caption());

        // ts_created
        $this->ts_created->EditAttrs["class"] = "form-control";
        $this->ts_created->EditCustomAttributes = "";
        $this->ts_created->EditValue = $this->ts_created->CurrentValue;
        $this->ts_created->EditValue = FormatDateTime($this->ts_created->EditValue, 0);
        $this->ts_created->ViewCustomAttributes = "";

        // vendor_id
        $this->vendor_id->EditAttrs["class"] = "form-control";
        $this->vendor_id->EditCustomAttributes = "";
        $curVal = trim(strval($this->vendor_id->CurrentValue));
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
                    $this->vendor_id->EditValue = $this->vendor_id->CurrentValue;
                }
            }
        } else {
            $this->vendor_id->EditValue = null;
        }
        $this->vendor_id->ViewCustomAttributes = "";

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
                    $doc->exportCaption($this->date);
                    $doc->exportCaption($this->image);
                    $doc->exportCaption($this->video);
                    $doc->exportCaption($this->comments);
                    $doc->exportCaption($this->type_id);
                    $doc->exportCaption($this->campaign_id);
                    $doc->exportCaption($this->ref_bus_id);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->vendor_id);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->date);
                    $doc->exportCaption($this->type_id);
                    $doc->exportCaption($this->campaign_id);
                    $doc->exportCaption($this->ref_bus_id);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->vendor_id);
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
                        $doc->exportField($this->date);
                        $doc->exportField($this->image);
                        $doc->exportField($this->video);
                        $doc->exportField($this->comments);
                        $doc->exportField($this->type_id);
                        $doc->exportField($this->campaign_id);
                        $doc->exportField($this->ref_bus_id);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->vendor_id);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->date);
                        $doc->exportField($this->type_id);
                        $doc->exportField($this->campaign_id);
                        $doc->exportField($this->ref_bus_id);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->vendor_id);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM \"main_reports\"";
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

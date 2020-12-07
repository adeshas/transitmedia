<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for view_bus_summary
 */
class ViewBusSummary extends DbTable
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
    public $exterior_campaign_id;
    public $campaign_name;
    public $period;
    public $buses;
    public $active_working;
    public $requires_maintenance;
    public $issues;
    public $good_bus_codes;
    public $bad_bus_codes;
    public $bus_codes;
    public $last_updated_at;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'view_bus_summary';
        $this->TableName = 'view_bus_summary';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "\"view_bus_summary\"";
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

        // exterior_campaign_id
        $this->exterior_campaign_id = new DbField('view_bus_summary', 'view_bus_summary', 'x_exterior_campaign_id', 'exterior_campaign_id', '"exterior_campaign_id"', 'CAST("exterior_campaign_id" AS varchar(255))', 3, 4, -1, false, '"exterior_campaign_id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->exterior_campaign_id->Sortable = true; // Allow sort
        $this->exterior_campaign_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['exterior_campaign_id'] = &$this->exterior_campaign_id;

        // campaign_name
        $this->campaign_name = new DbField('view_bus_summary', 'view_bus_summary', 'x_campaign_name', 'campaign_name', '"campaign_name"', '"campaign_name"', 201, 0, -1, false, '"campaign_name"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->campaign_name->Sortable = true; // Allow sort
        $this->Fields['campaign_name'] = &$this->campaign_name;

        // period
        $this->period = new DbField('view_bus_summary', 'view_bus_summary', 'x_period', 'period', '"period"', '"period"', 201, 0, -1, false, '"period"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->period->Sortable = true; // Allow sort
        $this->Fields['period'] = &$this->period;

        // buses
        $this->buses = new DbField('view_bus_summary', 'view_bus_summary', 'x_buses', 'buses', '"buses"', 'CAST("buses" AS varchar(255))', 20, 8, -1, false, '"buses"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->buses->Sortable = true; // Allow sort
        $this->buses->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['buses'] = &$this->buses;

        // active_working
        $this->active_working = new DbField('view_bus_summary', 'view_bus_summary', 'x_active_working', 'active_working', '"active_working"', 'CAST("active_working" AS varchar(255))', 20, 8, -1, false, '"active_working"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->active_working->Sortable = true; // Allow sort
        $this->active_working->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['active_working'] = &$this->active_working;

        // requires_maintenance
        $this->requires_maintenance = new DbField('view_bus_summary', 'view_bus_summary', 'x_requires_maintenance', 'requires_maintenance', '"requires_maintenance"', 'CAST("requires_maintenance" AS varchar(255))', 20, 8, -1, false, '"requires_maintenance"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->requires_maintenance->Sortable = true; // Allow sort
        $this->requires_maintenance->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['requires_maintenance'] = &$this->requires_maintenance;

        // issues
        $this->issues = new DbField('view_bus_summary', 'view_bus_summary', 'x_issues', 'issues', '"issues"', '"issues"', 201, 0, -1, false, '"issues"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->issues->Sortable = true; // Allow sort
        $this->Fields['issues'] = &$this->issues;

        // good_bus_codes
        $this->good_bus_codes = new DbField('view_bus_summary', 'view_bus_summary', 'x_good_bus_codes', 'good_bus_codes', '"good_bus_codes"', '"good_bus_codes"', 201, 0, -1, false, '"good_bus_codes"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->good_bus_codes->Sortable = true; // Allow sort
        $this->Fields['good_bus_codes'] = &$this->good_bus_codes;

        // bad_bus_codes
        $this->bad_bus_codes = new DbField('view_bus_summary', 'view_bus_summary', 'x_bad_bus_codes', 'bad_bus_codes', '"bad_bus_codes"', '"bad_bus_codes"', 201, 0, -1, false, '"bad_bus_codes"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bad_bus_codes->Sortable = true; // Allow sort
        $this->Fields['bad_bus_codes'] = &$this->bad_bus_codes;

        // bus_codes
        $this->bus_codes = new DbField('view_bus_summary', 'view_bus_summary', 'x_bus_codes', 'bus_codes', '"bus_codes"', '"bus_codes"', 201, 0, -1, false, '"bus_codes"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bus_codes->Sortable = true; // Allow sort
        $this->Fields['bus_codes'] = &$this->bus_codes;

        // last_updated_at
        $this->last_updated_at = new DbField('view_bus_summary', 'view_bus_summary', 'x_last_updated_at', 'last_updated_at', '"last_updated_at"', '"last_updated_at"', 201, 0, -1, false, '"last_updated_at"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->last_updated_at->Sortable = true; // Allow sort
        $this->Fields['last_updated_at'] = &$this->last_updated_at;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"view_bus_summary\"";
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
        $this->exterior_campaign_id->DbValue = $row['exterior_campaign_id'];
        $this->campaign_name->DbValue = $row['campaign_name'];
        $this->period->DbValue = $row['period'];
        $this->buses->DbValue = $row['buses'];
        $this->active_working->DbValue = $row['active_working'];
        $this->requires_maintenance->DbValue = $row['requires_maintenance'];
        $this->issues->DbValue = $row['issues'];
        $this->good_bus_codes->DbValue = $row['good_bus_codes'];
        $this->bad_bus_codes->DbValue = $row['bad_bus_codes'];
        $this->bus_codes->DbValue = $row['bus_codes'];
        $this->last_updated_at->DbValue = $row['last_updated_at'];
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
        return $_SESSION[$name] ?? GetUrl("ViewBusSummaryList");
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
        if ($pageName == "ViewBusSummaryView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ViewBusSummaryEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ViewBusSummaryAdd") {
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
                return "ViewBusSummaryView";
            case Config("API_ADD_ACTION"):
                return "ViewBusSummaryAdd";
            case Config("API_EDIT_ACTION"):
                return "ViewBusSummaryEdit";
            case Config("API_DELETE_ACTION"):
                return "ViewBusSummaryDelete";
            case Config("API_LIST_ACTION"):
                return "ViewBusSummaryList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ViewBusSummaryList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewBusSummaryView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ViewBusSummaryView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewBusSummaryAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ViewBusSummaryAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewBusSummaryEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("ViewBusSummaryAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("ViewBusSummaryDelete", $this->getUrlParm());
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
        $this->exterior_campaign_id->setDbValue($row['exterior_campaign_id']);
        $this->campaign_name->setDbValue($row['campaign_name']);
        $this->period->setDbValue($row['period']);
        $this->buses->setDbValue($row['buses']);
        $this->active_working->setDbValue($row['active_working']);
        $this->requires_maintenance->setDbValue($row['requires_maintenance']);
        $this->issues->setDbValue($row['issues']);
        $this->good_bus_codes->setDbValue($row['good_bus_codes']);
        $this->bad_bus_codes->setDbValue($row['bad_bus_codes']);
        $this->bus_codes->setDbValue($row['bus_codes']);
        $this->last_updated_at->setDbValue($row['last_updated_at']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // exterior_campaign_id

        // campaign_name

        // period

        // buses

        // active_working

        // requires_maintenance

        // issues

        // good_bus_codes

        // bad_bus_codes

        // bus_codes

        // last_updated_at

        // exterior_campaign_id
        $this->exterior_campaign_id->ViewValue = $this->exterior_campaign_id->CurrentValue;
        $this->exterior_campaign_id->ViewValue = FormatNumber($this->exterior_campaign_id->ViewValue, 0, -2, -2, -2);
        $this->exterior_campaign_id->ViewCustomAttributes = "";

        // campaign_name
        $this->campaign_name->ViewValue = $this->campaign_name->CurrentValue;
        $this->campaign_name->ViewCustomAttributes = "";

        // period
        $this->period->ViewValue = $this->period->CurrentValue;
        $this->period->ViewCustomAttributes = "";

        // buses
        $this->buses->ViewValue = $this->buses->CurrentValue;
        $this->buses->ViewValue = FormatNumber($this->buses->ViewValue, 0, -2, -2, -2);
        $this->buses->ViewCustomAttributes = "";

        // active_working
        $this->active_working->ViewValue = $this->active_working->CurrentValue;
        $this->active_working->ViewValue = FormatNumber($this->active_working->ViewValue, 0, -2, -2, -2);
        $this->active_working->ViewCustomAttributes = "";

        // requires_maintenance
        $this->requires_maintenance->ViewValue = $this->requires_maintenance->CurrentValue;
        $this->requires_maintenance->ViewValue = FormatNumber($this->requires_maintenance->ViewValue, 0, -2, -2, -2);
        $this->requires_maintenance->ViewCustomAttributes = "";

        // issues
        $this->issues->ViewValue = $this->issues->CurrentValue;
        $this->issues->ViewCustomAttributes = "";

        // good_bus_codes
        $this->good_bus_codes->ViewValue = $this->good_bus_codes->CurrentValue;
        $this->good_bus_codes->ViewCustomAttributes = "";

        // bad_bus_codes
        $this->bad_bus_codes->ViewValue = $this->bad_bus_codes->CurrentValue;
        $this->bad_bus_codes->ViewCustomAttributes = "";

        // bus_codes
        $this->bus_codes->ViewValue = $this->bus_codes->CurrentValue;
        $this->bus_codes->ViewCustomAttributes = "";

        // last_updated_at
        $this->last_updated_at->ViewValue = $this->last_updated_at->CurrentValue;
        $this->last_updated_at->ViewCustomAttributes = "";

        // exterior_campaign_id
        $this->exterior_campaign_id->LinkCustomAttributes = "";
        $this->exterior_campaign_id->HrefValue = "";
        $this->exterior_campaign_id->TooltipValue = "";

        // campaign_name
        $this->campaign_name->LinkCustomAttributes = "";
        $this->campaign_name->HrefValue = "";
        $this->campaign_name->TooltipValue = "";

        // period
        $this->period->LinkCustomAttributes = "";
        $this->period->HrefValue = "";
        $this->period->TooltipValue = "";

        // buses
        $this->buses->LinkCustomAttributes = "";
        $this->buses->HrefValue = "";
        $this->buses->TooltipValue = "";

        // active_working
        $this->active_working->LinkCustomAttributes = "";
        $this->active_working->HrefValue = "";
        $this->active_working->TooltipValue = "";

        // requires_maintenance
        $this->requires_maintenance->LinkCustomAttributes = "";
        $this->requires_maintenance->HrefValue = "";
        $this->requires_maintenance->TooltipValue = "";

        // issues
        $this->issues->LinkCustomAttributes = "";
        $this->issues->HrefValue = "";
        $this->issues->TooltipValue = "";

        // good_bus_codes
        $this->good_bus_codes->LinkCustomAttributes = "";
        $this->good_bus_codes->HrefValue = "";
        $this->good_bus_codes->TooltipValue = "";

        // bad_bus_codes
        $this->bad_bus_codes->LinkCustomAttributes = "";
        $this->bad_bus_codes->HrefValue = "";
        $this->bad_bus_codes->TooltipValue = "";

        // bus_codes
        $this->bus_codes->LinkCustomAttributes = "";
        $this->bus_codes->HrefValue = "";
        $this->bus_codes->TooltipValue = "";

        // last_updated_at
        $this->last_updated_at->LinkCustomAttributes = "";
        $this->last_updated_at->HrefValue = "";
        $this->last_updated_at->TooltipValue = "";

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

        // exterior_campaign_id
        $this->exterior_campaign_id->EditAttrs["class"] = "form-control";
        $this->exterior_campaign_id->EditCustomAttributes = "";
        $this->exterior_campaign_id->EditValue = $this->exterior_campaign_id->CurrentValue;
        $this->exterior_campaign_id->PlaceHolder = RemoveHtml($this->exterior_campaign_id->caption());

        // campaign_name
        $this->campaign_name->EditAttrs["class"] = "form-control";
        $this->campaign_name->EditCustomAttributes = "";
        $this->campaign_name->EditValue = $this->campaign_name->CurrentValue;
        $this->campaign_name->PlaceHolder = RemoveHtml($this->campaign_name->caption());

        // period
        $this->period->EditAttrs["class"] = "form-control";
        $this->period->EditCustomAttributes = "";
        $this->period->EditValue = $this->period->CurrentValue;
        $this->period->PlaceHolder = RemoveHtml($this->period->caption());

        // buses
        $this->buses->EditAttrs["class"] = "form-control";
        $this->buses->EditCustomAttributes = "";
        $this->buses->EditValue = $this->buses->CurrentValue;
        $this->buses->PlaceHolder = RemoveHtml($this->buses->caption());

        // active_working
        $this->active_working->EditAttrs["class"] = "form-control";
        $this->active_working->EditCustomAttributes = "";
        $this->active_working->EditValue = $this->active_working->CurrentValue;
        $this->active_working->PlaceHolder = RemoveHtml($this->active_working->caption());

        // requires_maintenance
        $this->requires_maintenance->EditAttrs["class"] = "form-control";
        $this->requires_maintenance->EditCustomAttributes = "";
        $this->requires_maintenance->EditValue = $this->requires_maintenance->CurrentValue;
        $this->requires_maintenance->PlaceHolder = RemoveHtml($this->requires_maintenance->caption());

        // issues
        $this->issues->EditAttrs["class"] = "form-control";
        $this->issues->EditCustomAttributes = "";
        $this->issues->EditValue = $this->issues->CurrentValue;
        $this->issues->PlaceHolder = RemoveHtml($this->issues->caption());

        // good_bus_codes
        $this->good_bus_codes->EditAttrs["class"] = "form-control";
        $this->good_bus_codes->EditCustomAttributes = "";
        $this->good_bus_codes->EditValue = $this->good_bus_codes->CurrentValue;
        $this->good_bus_codes->PlaceHolder = RemoveHtml($this->good_bus_codes->caption());

        // bad_bus_codes
        $this->bad_bus_codes->EditAttrs["class"] = "form-control";
        $this->bad_bus_codes->EditCustomAttributes = "";
        $this->bad_bus_codes->EditValue = $this->bad_bus_codes->CurrentValue;
        $this->bad_bus_codes->PlaceHolder = RemoveHtml($this->bad_bus_codes->caption());

        // bus_codes
        $this->bus_codes->EditAttrs["class"] = "form-control";
        $this->bus_codes->EditCustomAttributes = "";
        $this->bus_codes->EditValue = $this->bus_codes->CurrentValue;
        $this->bus_codes->PlaceHolder = RemoveHtml($this->bus_codes->caption());

        // last_updated_at
        $this->last_updated_at->EditAttrs["class"] = "form-control";
        $this->last_updated_at->EditCustomAttributes = "";
        $this->last_updated_at->EditValue = $this->last_updated_at->CurrentValue;
        $this->last_updated_at->PlaceHolder = RemoveHtml($this->last_updated_at->caption());

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
                    $doc->exportCaption($this->exterior_campaign_id);
                    $doc->exportCaption($this->campaign_name);
                    $doc->exportCaption($this->period);
                    $doc->exportCaption($this->buses);
                    $doc->exportCaption($this->active_working);
                    $doc->exportCaption($this->requires_maintenance);
                    $doc->exportCaption($this->issues);
                    $doc->exportCaption($this->good_bus_codes);
                    $doc->exportCaption($this->bad_bus_codes);
                    $doc->exportCaption($this->bus_codes);
                    $doc->exportCaption($this->last_updated_at);
                } else {
                    $doc->exportCaption($this->exterior_campaign_id);
                    $doc->exportCaption($this->buses);
                    $doc->exportCaption($this->active_working);
                    $doc->exportCaption($this->requires_maintenance);
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
                        $doc->exportField($this->exterior_campaign_id);
                        $doc->exportField($this->campaign_name);
                        $doc->exportField($this->period);
                        $doc->exportField($this->buses);
                        $doc->exportField($this->active_working);
                        $doc->exportField($this->requires_maintenance);
                        $doc->exportField($this->issues);
                        $doc->exportField($this->good_bus_codes);
                        $doc->exportField($this->bad_bus_codes);
                        $doc->exportField($this->bus_codes);
                        $doc->exportField($this->last_updated_at);
                    } else {
                        $doc->exportField($this->exterior_campaign_id);
                        $doc->exportField($this->buses);
                        $doc->exportField($this->active_working);
                        $doc->exportField($this->requires_maintenance);
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

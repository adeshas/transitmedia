<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for main_print_orders
 */
class MainPrintOrders extends DbTable
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
    public $campaign_id;
    public $printer_id;
    public $ts_created;
    public $link;
    public $quantity;
    public $approved;
    public $comments;
    public $all_codes_assigned_in_campaign;
    public $bus_codes;
    public $available_codes_to_be_assigned;
    public $tags;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'main_print_orders';
        $this->TableName = 'main_print_orders';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "\"main_print_orders\"";
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
        $this->id = new DbField('main_print_orders', 'main_print_orders', 'x_id', 'id', '"id"', 'CAST("id" AS varchar(255))', 3, 4, -1, false, '"id"', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Nullable = false; // NOT NULL field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // campaign_id
        $this->campaign_id = new DbField('main_print_orders', 'main_print_orders', 'x_campaign_id', 'campaign_id', '"campaign_id"', 'CAST("campaign_id" AS varchar(255))', 3, 4, -1, false, '"campaign_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->campaign_id->Sortable = true; // Allow sort
        $this->campaign_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->campaign_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->campaign_id->Lookup = new Lookup('campaign_id', 'main_campaigns', false, 'id', ["name","quantity","inventory_id","platform_id"], [], [], [], [], [], [], '"ts_created" DESC', '');
        $this->campaign_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['campaign_id'] = &$this->campaign_id;

        // printer_id
        $this->printer_id = new DbField('main_print_orders', 'main_print_orders', 'x_printer_id', 'printer_id', '"printer_id"', 'CAST("printer_id" AS varchar(255))', 3, 4, -1, false, '"printer_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->printer_id->Sortable = true; // Allow sort
        $this->printer_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->printer_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->printer_id->Lookup = new Lookup('printer_id', 'y_printers', false, 'id', ["name","","",""], [], [], [], [], [], [], '"id" DESC', '');
        $this->printer_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['printer_id'] = &$this->printer_id;

        // ts_created
        $this->ts_created = new DbField('main_print_orders', 'main_print_orders', 'x_ts_created', 'ts_created', '"ts_created"', CastDateFieldForLike("\"ts_created\"", 0, "DB"), 135, 8, 0, false, '"ts_created"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_created->Nullable = false; // NOT NULL field
        $this->ts_created->Required = true; // Required field
        $this->ts_created->Sortable = true; // Allow sort
        $this->ts_created->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ts_created'] = &$this->ts_created;

        // link
        $this->link = new DbField('main_print_orders', 'main_print_orders', 'x_link', 'link', '"link"', '"link"', 201, 0, -1, false, '"link"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->link->Sortable = true; // Allow sort
        $this->Fields['link'] = &$this->link;

        // quantity
        $this->quantity = new DbField('main_print_orders', 'main_print_orders', 'x_quantity', 'quantity', '"quantity"', 'CAST("quantity" AS varchar(255))', 3, 4, -1, false, '"quantity"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->quantity->Nullable = false; // NOT NULL field
        $this->quantity->Required = true; // Required field
        $this->quantity->Sortable = true; // Allow sort
        $this->quantity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['quantity'] = &$this->quantity;

        // approved
        $this->approved = new DbField('main_print_orders', 'main_print_orders', 'x_approved', 'approved', '"approved"', 'CAST("approved" AS varchar(255))', 11, 1, -1, false, '"approved"', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->approved->Sortable = true; // Allow sort
        $this->approved->DataType = DATATYPE_BOOLEAN;
        $this->approved->Lookup = new Lookup('approved', 'main_print_orders', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->approved->OptionCount = 2;
        $this->Fields['approved'] = &$this->approved;

        // comments
        $this->comments = new DbField('main_print_orders', 'main_print_orders', 'x_comments', 'comments', '"comments"', '"comments"', 201, 0, -1, false, '"comments"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->comments->Sortable = true; // Allow sort
        $this->Fields['comments'] = &$this->comments;

        // all_codes_assigned_in_campaign
        $this->all_codes_assigned_in_campaign = new DbField('main_print_orders', 'main_print_orders', 'x_all_codes_assigned_in_campaign', 'all_codes_assigned_in_campaign', '(select string_agg(cols,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot   where id = bus_depot_id),\'NO BUS ASSIGNED\') ||  chr(10) || string_agg(number,\',\') from main_buses  where exterior_campaign_id = campaign_id group by  (select name from x_bus_depot where id = bus_depot_id) ) rows(cols))', '(select string_agg(cols,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot   where id = bus_depot_id),\'NO BUS ASSIGNED\') ||  chr(10) || string_agg(number,\',\') from main_buses  where exterior_campaign_id = campaign_id group by  (select name from x_bus_depot where id = bus_depot_id) ) rows(cols))', 201, 0, -1, false, '(select string_agg(cols,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot   where id = bus_depot_id),\'NO BUS ASSIGNED\') ||  chr(10) || string_agg(number,\',\') from main_buses  where exterior_campaign_id = campaign_id group by  (select name from x_bus_depot where id = bus_depot_id) ) rows(cols))', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->all_codes_assigned_in_campaign->IsCustom = true; // Custom field
        $this->all_codes_assigned_in_campaign->Sortable = true; // Allow sort
        $this->Fields['all_codes_assigned_in_campaign'] = &$this->all_codes_assigned_in_campaign;

        // bus_codes
        $this->bus_codes = new DbField('main_print_orders', 'main_print_orders', 'x_bus_codes', 'bus_codes', '"bus_codes"', '"bus_codes"', 201, 0, -1, false, '"bus_codes"', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bus_codes->Sortable = true; // Allow sort
        $this->Fields['bus_codes'] = &$this->bus_codes;

        // available_codes_to_be_assigned
        $this->available_codes_to_be_assigned = new DbField('main_print_orders', 'main_print_orders', 'x_available_codes_to_be_assigned', 'available_codes_to_be_assigned', '( select string_agg(col4,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot where id = bus_depot_id),\'NO BUS ASSIGNED\') || chr(10) || string_agg(number,\',\') from main_buses where number in ( ( select col3::text from ( ( ( select col1 from unnest(regexp_split_to_array( ( select regexp_replace( ( select string_agg(cols,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot where id = bus_depot_id),\'NO BUS ASSIGNED\') || chr(10) || string_agg(number,\',\') from main_buses where exterior_campaign_id = campaign_id group by (select name from x_bus_depot where id = bus_depot_id) ) rows(cols) ) ,\'^([A-Za-z][A-Za-z /,0-9]+)$\',\'\',\'mg\') ),\'[^0-9]+\') ) rows1(col1) where ascii(col1) <> 0) ) except ( ( select col2 from unnest(regexp_split_to_array( ( select regexp_replace( (select string_agg(bus_codes,\',\') from main_print_orders pp where pp.campaign_id = main_print_orders.campaign_id) ,\'^([A-Za-z][A-Za-z /,0-9]+)$\',\'\',\'mg\') ),\'[^0-9]+\') ) rows2(col2) where ascii(col2) <> 0 ) ) ) rows3(col3) ) ) group by (select name from x_bus_depot where id = bus_depot_id) ) rows(col4) )', '( select string_agg(col4,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot where id = bus_depot_id),\'NO BUS ASSIGNED\') || chr(10) || string_agg(number,\',\') from main_buses where number in ( ( select col3::text from ( ( ( select col1 from unnest(regexp_split_to_array( ( select regexp_replace( ( select string_agg(cols,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot where id = bus_depot_id),\'NO BUS ASSIGNED\') || chr(10) || string_agg(number,\',\') from main_buses where exterior_campaign_id = campaign_id group by (select name from x_bus_depot where id = bus_depot_id) ) rows(cols) ) ,\'^([A-Za-z][A-Za-z /,0-9]+)$\',\'\',\'mg\') ),\'[^0-9]+\') ) rows1(col1) where ascii(col1) <> 0) ) except ( ( select col2 from unnest(regexp_split_to_array( ( select regexp_replace( (select string_agg(bus_codes,\',\') from main_print_orders pp where pp.campaign_id = main_print_orders.campaign_id) ,\'^([A-Za-z][A-Za-z /,0-9]+)$\',\'\',\'mg\') ),\'[^0-9]+\') ) rows2(col2) where ascii(col2) <> 0 ) ) ) rows3(col3) ) ) group by (select name from x_bus_depot where id = bus_depot_id) ) rows(col4) )', 201, 0, -1, false, '( select string_agg(col4,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot where id = bus_depot_id),\'NO BUS ASSIGNED\') || chr(10) || string_agg(number,\',\') from main_buses where number in ( ( select col3::text from ( ( ( select col1 from unnest(regexp_split_to_array( ( select regexp_replace( ( select string_agg(cols,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot where id = bus_depot_id),\'NO BUS ASSIGNED\') || chr(10) || string_agg(number,\',\') from main_buses where exterior_campaign_id = campaign_id group by (select name from x_bus_depot where id = bus_depot_id) ) rows(cols) ) ,\'^([A-Za-z][A-Za-z /,0-9]+)$\',\'\',\'mg\') ),\'[^0-9]+\') ) rows1(col1) where ascii(col1) <> 0) ) except ( ( select col2 from unnest(regexp_split_to_array( ( select regexp_replace( (select string_agg(bus_codes,\',\') from main_print_orders pp where pp.campaign_id = main_print_orders.campaign_id) ,\'^([A-Za-z][A-Za-z /,0-9]+)$\',\'\',\'mg\') ),\'[^0-9]+\') ) rows2(col2) where ascii(col2) <> 0 ) ) ) rows3(col3) ) ) group by (select name from x_bus_depot where id = bus_depot_id) ) rows(col4) )', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->available_codes_to_be_assigned->IsCustom = true; // Custom field
        $this->available_codes_to_be_assigned->Sortable = true; // Allow sort
        $this->Fields['available_codes_to_be_assigned'] = &$this->available_codes_to_be_assigned;

        // tags
        $this->tags = new DbField('main_print_orders', 'main_print_orders', 'x_tags', 'tags', '((select name from main_campaigns where id = campaign_id) || \' | \' || (select name from y_printers where id = printer_id))', '((select name from main_campaigns where id = campaign_id) || \' | \' || (select name from y_printers where id = printer_id))', 201, 0, -1, false, '((select name from main_campaigns where id = campaign_id) || \' | \' || (select name from y_printers where id = printer_id))', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->tags->IsCustom = true; // Custom field
        $this->tags->Sortable = true; // Allow sort
        $this->Fields['tags'] = &$this->tags;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"main_print_orders\"";
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
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*, (select string_agg(cols,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot   where id = bus_depot_id),'NO BUS ASSIGNED') ||  chr(10) || string_agg(number,',') from main_buses  where exterior_campaign_id = campaign_id group by  (select name from x_bus_depot where id = bus_depot_id) ) rows(cols)) AS \"all_codes_assigned_in_campaign\", ( select string_agg(col4,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot where id = bus_depot_id),'NO BUS ASSIGNED') || chr(10) || string_agg(number,',') from main_buses where number in ( ( select col3::text from ( ( ( select col1 from unnest(regexp_split_to_array( ( select regexp_replace( ( select string_agg(cols,chr(10)||chr(10)) from ( select COALESCE((select name from x_bus_depot where id = bus_depot_id),'NO BUS ASSIGNED') || chr(10) || string_agg(number,',') from main_buses where exterior_campaign_id = campaign_id group by (select name from x_bus_depot where id = bus_depot_id) ) rows(cols) ) ,'^([A-Za-z][A-Za-z /,0-9]+)\$','','mg') ),'[^0-9]+') ) rows1(col1) where ascii(col1) <> 0) ) except ( ( select col2 from unnest(regexp_split_to_array( ( select regexp_replace( (select string_agg(bus_codes,',') from main_print_orders pp where pp.campaign_id = main_print_orders.campaign_id) ,'^([A-Za-z][A-Za-z /,0-9]+)\$','','mg') ),'[^0-9]+') ) rows2(col2) where ascii(col2) <> 0 ) ) ) rows3(col3) ) ) group by (select name from x_bus_depot where id = bus_depot_id) ) rows(col4) ) AS \"available_codes_to_be_assigned\", ((select name from main_campaigns where id = campaign_id) || ' | ' || (select name from y_printers where id = printer_id)) AS \"tags\"");
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
            $this->id->setDbValue($conn->fetchColumn("SELECT currval('public.main_print_orders_id_seq'::regclass)"));
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
        $this->campaign_id->DbValue = $row['campaign_id'];
        $this->printer_id->DbValue = $row['printer_id'];
        $this->ts_created->DbValue = $row['ts_created'];
        $this->link->DbValue = $row['link'];
        $this->quantity->DbValue = $row['quantity'];
        $this->approved->DbValue = (ConvertToBool($row['approved']) ? "1" : "0");
        $this->comments->DbValue = $row['comments'];
        $this->all_codes_assigned_in_campaign->DbValue = $row['all_codes_assigned_in_campaign'];
        $this->bus_codes->DbValue = $row['bus_codes'];
        $this->available_codes_to_be_assigned->DbValue = $row['available_codes_to_be_assigned'];
        $this->tags->DbValue = $row['tags'];
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
        return $_SESSION[$name] ?? GetUrl("mainprintorderslist");
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
        if ($pageName == "mainprintordersview") {
            return $Language->phrase("View");
        } elseif ($pageName == "mainprintordersedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "mainprintordersadd") {
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
                return "MainPrintOrdersView";
            case Config("API_ADD_ACTION"):
                return "MainPrintOrdersAdd";
            case Config("API_EDIT_ACTION"):
                return "MainPrintOrdersEdit";
            case Config("API_DELETE_ACTION"):
                return "MainPrintOrdersDelete";
            case Config("API_LIST_ACTION"):
                return "MainPrintOrdersList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "mainprintorderslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("mainprintordersview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("mainprintordersview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "mainprintordersadd?" . $this->getUrlParm($parm);
        } else {
            $url = "mainprintordersadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("mainprintordersedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("mainprintordersadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("mainprintordersdelete", $this->getUrlParm());
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
        $this->campaign_id->setDbValue($row['campaign_id']);
        $this->printer_id->setDbValue($row['printer_id']);
        $this->ts_created->setDbValue($row['ts_created']);
        $this->link->setDbValue($row['link']);
        $this->quantity->setDbValue($row['quantity']);
        $this->approved->setDbValue(ConvertToBool($row['approved']) ? "1" : "0");
        $this->comments->setDbValue($row['comments']);
        $this->all_codes_assigned_in_campaign->setDbValue($row['all_codes_assigned_in_campaign']);
        $this->bus_codes->setDbValue($row['bus_codes']);
        $this->available_codes_to_be_assigned->setDbValue($row['available_codes_to_be_assigned']);
        $this->tags->setDbValue($row['tags']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // campaign_id

        // printer_id

        // ts_created

        // link

        // quantity

        // approved

        // comments

        // all_codes_assigned_in_campaign

        // bus_codes

        // available_codes_to_be_assigned

        // tags

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // campaign_id
        $curVal = strval($this->campaign_id->CurrentValue);
        if ($curVal != "") {
            $this->campaign_id->ViewValue = $this->campaign_id->lookupCacheOption($curVal);
            if ($this->campaign_id->ViewValue === null) { // Lookup from database
                $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "ts_created between  now()-'30 days'::interval AND now()";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->campaign_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

        // printer_id
        $curVal = strval($this->printer_id->CurrentValue);
        if ($curVal != "") {
            $this->printer_id->ViewValue = $this->printer_id->lookupCacheOption($curVal);
            if ($this->printer_id->ViewValue === null) { // Lookup from database
                $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->printer_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->printer_id->Lookup->renderViewRow($rswrk[0]);
                    $this->printer_id->ViewValue = $this->printer_id->displayValue($arwrk);
                } else {
                    $this->printer_id->ViewValue = $this->printer_id->CurrentValue;
                }
            }
        } else {
            $this->printer_id->ViewValue = null;
        }
        $this->printer_id->ViewCustomAttributes = "";

        // ts_created
        $this->ts_created->ViewValue = $this->ts_created->CurrentValue;
        $this->ts_created->ViewValue = FormatDateTime($this->ts_created->ViewValue, 0);
        $this->ts_created->ViewCustomAttributes = "";

        // link
        $this->link->ViewValue = $this->link->CurrentValue;
        $this->link->ViewCustomAttributes = "";

        // quantity
        $this->quantity->ViewValue = $this->quantity->CurrentValue;
        $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
        $this->quantity->ViewCustomAttributes = "";

        // approved
        if (ConvertToBool($this->approved->CurrentValue)) {
            $this->approved->ViewValue = $this->approved->tagCaption(1) != "" ? $this->approved->tagCaption(1) : "Yes";
        } else {
            $this->approved->ViewValue = $this->approved->tagCaption(2) != "" ? $this->approved->tagCaption(2) : "No";
        }
        $this->approved->ViewCustomAttributes = "";

        // comments
        $this->comments->ViewValue = $this->comments->CurrentValue;
        $this->comments->ViewCustomAttributes = "";

        // all_codes_assigned_in_campaign
        $this->all_codes_assigned_in_campaign->ViewValue = $this->all_codes_assigned_in_campaign->CurrentValue;
        $this->all_codes_assigned_in_campaign->ViewCustomAttributes = "";

        // bus_codes
        $this->bus_codes->ViewValue = $this->bus_codes->CurrentValue;
        $this->bus_codes->ViewCustomAttributes = "";

        // available_codes_to_be_assigned
        $this->available_codes_to_be_assigned->ViewValue = $this->available_codes_to_be_assigned->CurrentValue;
        $this->available_codes_to_be_assigned->ViewCustomAttributes = "";

        // tags
        $this->tags->ViewValue = $this->tags->CurrentValue;
        $this->tags->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // campaign_id
        $this->campaign_id->LinkCustomAttributes = "";
        $this->campaign_id->HrefValue = "";
        $this->campaign_id->TooltipValue = "";

        // printer_id
        $this->printer_id->LinkCustomAttributes = "";
        $this->printer_id->HrefValue = "";
        $this->printer_id->TooltipValue = "";

        // ts_created
        $this->ts_created->LinkCustomAttributes = "";
        $this->ts_created->HrefValue = "";
        $this->ts_created->TooltipValue = "";

        // link
        $this->link->LinkCustomAttributes = "";
        if (!EmptyValue($this->id->CurrentValue)) {
            $this->link->HrefValue = "downloadbp.php?id=" . (!empty($this->id->ViewValue) && !is_array($this->id->ViewValue) ? RemoveHtml($this->id->ViewValue) : $this->id->CurrentValue); // Add prefix/suffix
            $this->link->LinkAttrs["target"] = "_blank"; // Add target
            if ($this->isExport()) {
                $this->link->HrefValue = FullUrl($this->link->HrefValue, "href");
            }
        } else {
            $this->link->HrefValue = "";
        }
        $this->link->TooltipValue = "";

        // quantity
        $this->quantity->LinkCustomAttributes = "";
        $this->quantity->HrefValue = "";
        $this->quantity->TooltipValue = "";

        // approved
        $this->approved->LinkCustomAttributes = "";
        $this->approved->HrefValue = "";
        $this->approved->TooltipValue = "";

        // comments
        $this->comments->LinkCustomAttributes = "";
        $this->comments->HrefValue = "";
        $this->comments->TooltipValue = "";

        // all_codes_assigned_in_campaign
        $this->all_codes_assigned_in_campaign->LinkCustomAttributes = "";
        $this->all_codes_assigned_in_campaign->HrefValue = "";
        $this->all_codes_assigned_in_campaign->TooltipValue = "";

        // bus_codes
        $this->bus_codes->LinkCustomAttributes = "";
        $this->bus_codes->HrefValue = "";
        $this->bus_codes->TooltipValue = "";

        // available_codes_to_be_assigned
        $this->available_codes_to_be_assigned->LinkCustomAttributes = "";
        $this->available_codes_to_be_assigned->HrefValue = "";
        $this->available_codes_to_be_assigned->TooltipValue = "";

        // tags
        $this->tags->LinkCustomAttributes = "";
        $this->tags->HrefValue = "";
        $this->tags->TooltipValue = "";

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

        // campaign_id
        $this->campaign_id->EditAttrs["class"] = "form-control";
        $this->campaign_id->EditCustomAttributes = "";
        $curVal = strval($this->campaign_id->CurrentValue);
        if ($curVal != "") {
            $this->campaign_id->EditValue = $this->campaign_id->lookupCacheOption($curVal);
            if ($this->campaign_id->EditValue === null) { // Lookup from database
                $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "ts_created between  now()-'30 days'::interval AND now()";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->campaign_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->campaign_id->Lookup->renderViewRow($rswrk[0]);
                    $this->campaign_id->EditValue = $this->campaign_id->displayValue($arwrk);
                } else {
                    $this->campaign_id->EditValue = $this->campaign_id->CurrentValue;
                }
            }
        } else {
            $this->campaign_id->EditValue = null;
        }
        $this->campaign_id->ViewCustomAttributes = "";

        // printer_id
        $this->printer_id->EditAttrs["class"] = "form-control";
        $this->printer_id->EditCustomAttributes = "";
        $curVal = strval($this->printer_id->CurrentValue);
        if ($curVal != "") {
            $this->printer_id->EditValue = $this->printer_id->lookupCacheOption($curVal);
            if ($this->printer_id->EditValue === null) { // Lookup from database
                $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->printer_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->printer_id->Lookup->renderViewRow($rswrk[0]);
                    $this->printer_id->EditValue = $this->printer_id->displayValue($arwrk);
                } else {
                    $this->printer_id->EditValue = $this->printer_id->CurrentValue;
                }
            }
        } else {
            $this->printer_id->EditValue = null;
        }
        $this->printer_id->ViewCustomAttributes = "";

        // ts_created
        $this->ts_created->EditAttrs["class"] = "form-control";
        $this->ts_created->EditCustomAttributes = "";
        $this->ts_created->EditValue = FormatDateTime($this->ts_created->CurrentValue, 8);
        $this->ts_created->PlaceHolder = RemoveHtml($this->ts_created->caption());

        // link
        $this->link->EditAttrs["class"] = "form-control";
        $this->link->EditCustomAttributes = "";
        if (!$this->link->Raw) {
            $this->link->CurrentValue = HtmlDecode($this->link->CurrentValue);
        }
        $this->link->EditValue = $this->link->CurrentValue;
        $this->link->PlaceHolder = RemoveHtml($this->link->caption());

        // quantity
        $this->quantity->EditAttrs["class"] = "form-control";
        $this->quantity->EditCustomAttributes = "";
        $this->quantity->EditValue = $this->quantity->CurrentValue;
        $this->quantity->EditValue = FormatNumber($this->quantity->EditValue, 0, -2, -2, -2);
        $this->quantity->ViewCustomAttributes = "";

        // approved
        $this->approved->EditCustomAttributes = "";
        $this->approved->EditValue = $this->approved->options(false);
        $this->approved->PlaceHolder = RemoveHtml($this->approved->caption());

        // comments
        $this->comments->EditAttrs["class"] = "form-control";
        $this->comments->EditCustomAttributes = "";
        $this->comments->EditValue = $this->comments->CurrentValue;
        $this->comments->PlaceHolder = RemoveHtml($this->comments->caption());

        // all_codes_assigned_in_campaign
        $this->all_codes_assigned_in_campaign->EditAttrs["class"] = "form-control";
        $this->all_codes_assigned_in_campaign->EditCustomAttributes = "";
        $this->all_codes_assigned_in_campaign->EditValue = $this->all_codes_assigned_in_campaign->CurrentValue;
        $this->all_codes_assigned_in_campaign->ViewCustomAttributes = "";

        // bus_codes
        $this->bus_codes->EditAttrs["class"] = "form-control";
        $this->bus_codes->EditCustomAttributes = "";
        $this->bus_codes->EditValue = $this->bus_codes->CurrentValue;
        $this->bus_codes->PlaceHolder = RemoveHtml($this->bus_codes->caption());

        // available_codes_to_be_assigned
        $this->available_codes_to_be_assigned->EditAttrs["class"] = "form-control";
        $this->available_codes_to_be_assigned->EditCustomAttributes = "";
        $this->available_codes_to_be_assigned->EditValue = $this->available_codes_to_be_assigned->CurrentValue;
        $this->available_codes_to_be_assigned->PlaceHolder = RemoveHtml($this->available_codes_to_be_assigned->caption());

        // tags
        $this->tags->EditAttrs["class"] = "form-control";
        $this->tags->EditCustomAttributes = "";
        $this->tags->EditValue = $this->tags->CurrentValue;
        $this->tags->PlaceHolder = RemoveHtml($this->tags->caption());

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
                    $doc->exportCaption($this->campaign_id);
                    $doc->exportCaption($this->printer_id);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->link);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->approved);
                    $doc->exportCaption($this->comments);
                    $doc->exportCaption($this->all_codes_assigned_in_campaign);
                    $doc->exportCaption($this->bus_codes);
                    $doc->exportCaption($this->available_codes_to_be_assigned);
                    $doc->exportCaption($this->tags);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->campaign_id);
                    $doc->exportCaption($this->printer_id);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->approved);
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
                        $doc->exportField($this->campaign_id);
                        $doc->exportField($this->printer_id);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->link);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->approved);
                        $doc->exportField($this->comments);
                        $doc->exportField($this->all_codes_assigned_in_campaign);
                        $doc->exportField($this->bus_codes);
                        $doc->exportField($this->available_codes_to_be_assigned);
                        $doc->exportField($this->tags);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->campaign_id);
                        $doc->exportField($this->printer_id);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->approved);
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
    	//echo "Row Updated";
    	require_once 'views/PrivateFunctions.php';

    	//if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    	//	require_once 'emailrun.php';
    	//}
    	if ($rsold["approved"] === false && $rsnew["approved"] === '1') {
    		// Email to TM
    		$editfile = '/opt/lampp/htdocs/printingandbrandingv3/passes_source/ppt/slides/slide1.xml';
    		$immutabletemplate = '/opt/lampp/htdocs/printingandbrandingv3/passes_run/template.xml';
    		$id = $rsold["id"];
    		$sql = <<<EOT
    SELECT id, campaign_id,
    (select name from main_campaigns where id = campaign_id) as campaign,
    (select name from y_printers where id = printer_id) as brander,
    (select passcode from y_printers where id = printer_id) as passcode,
    (select email from y_printers where id = printer_id) as email,
    ts_created, link, approved, quantity, bus_codes
    	FROM main_print_orders where id = {$id};
    EOT;
    		$details = ExecuteRow($sql);
    		$replacements = [
    			'X0XBRANDERX0X' => $details['brander'],
    			'X0XCAMPAIGNX0X' => $details['campaign'],
    			'X0XQUANTITYX0X' => $details['quantity'],
    			'X0XCODEX0X' => '434-' . $details['passcode'] . 'X-' . $details['id'],
    			'X0XPRINTCODEX0X' => '434-' . $details['id'],
    			'X0XDATEX0X' => date('l jS M Y'),
    		];
    		if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    // STEP 0
    			// RESET FILE
    			file_put_contents($editfile, file_get_contents($immutabletemplate));

    // STEP 1
    			// Read template.xml into memory and replace the values
    			$content = file_get_contents($immutabletemplate);
    			foreach ($replacements as $key => $value) {
    				$content = str_replace($key, $value, $content);
    			}
    			$bus_codes_added_xml = convert_to_xml($details['bus_codes']);
    			$content = str_replace('</p:sp></p:spTree>', '</p:sp>' . $bus_codes_added_xml . '</p:spTree>', $content);
    			file_put_contents($editfile, $content);

    // STEP 2
    			// Zip file
    			$zipfile = '/opt/lampp/htdocs/printingandbrandingv3/passes_run/file.pptx';
    			$rootPath = realpath('/opt/lampp/htdocs/printingandbrandingv3/passes_source');
    			// print_r($rootPath);
    			// exit;
    			// Initialize archive object
    			$zip = new \ZipArchive();
    			$zip->open($zipfile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

    			// Create recursive directory iterator
    			/** @var SplFileInfo[] $files */
    			$files = new \RecursiveIteratorIterator(
    				new \RecursiveDirectoryIterator($rootPath),
    				\RecursiveIteratorIterator::LEAVES_ONLY
    			);
    			foreach ($files as $name => $file) {
    				// Skip directories (they would be added automatically)
    				if (!$file->isDir()) {
    					// Get real and relative path for current file
    					$filePath = $file->getRealPath();
    					$relativePath = substr($filePath, strlen($rootPath) + 1);

    					// Add current file to archive
    					$zip->addFile($filePath, $relativePath);
    				}
    			}

    			// Zip archive will be created only after closing object
    			$zip->close();
    		}

    // STEP 3
    		if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    			// Copy file to temp folder for conversion
    			$final_file = '/opt/lampp/htdocs/printingandbrandingv3/passes_temp/BRANDERS_PASS_' . $replacements['X0XPRINTCODEX0X'] . '.pptx';
    			if (file_exists($final_file)) {
    				unlink($final_file);
    			}
    			copy($zipfile, $final_file);
    			unlink($zipfile);
    		}
    // STEP X
    		// OVERWRITE EDIT FILE WITH IMMUTABLE TO REVERT ALL
    		if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    			file_put_contents($editfile, file_get_contents($immutabletemplate));
    		}
    		//echo "COMPLETED!\n";
    		sleep(3);
    		#===============================================================
    		$emailpayload = getEmailPayload('branders_pass');
    		$exposed_emails = get_emails($emailpayload, $details['email']);
    		extract($exposed_emails);
    		$email = $final_to;
    		$cc = $final_cc;
    		$bcc = $final_bcc;
    		debugdump("BRANDERS PASS exposed_emails",$exposed_emails);
    		#===============================================================
    		$attachment = '/opt/lampp/htdocs/printingandbrandingv3/passes/BRANDERS_PASS_434-' . $id . '.pdf';
    		$subject = "BRANDERS PASS";
    		$msg = "Please find branders pass attached.";
    		$msgtxt = "Please find branders pass attached.";
    		sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, $attachment, $cc, $bcc);
    		//if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    		//	sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, $attachment, $cc, $bcc);
    		//}
    	}
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

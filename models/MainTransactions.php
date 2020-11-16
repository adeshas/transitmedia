<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for main_transactions
 */
class MainTransactions extends DbTable
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
    public $operator_id;
    public $payment_date;
    public $price_id;
    public $quantity;
    public $start_date;
    public $end_date;
    public $visible_status_id;
    public $status_id;
    public $print_status_id;
    public $payment_status_id;
    public $created_by;
    public $ts_created;
    public $ts_last_update;
    public $total;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'main_transactions';
        $this->TableName = 'main_transactions';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "\"main_transactions\"";
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
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('main_transactions', 'main_transactions', 'x_id', 'id', '"id"', 'CAST("id" AS varchar(255))', 3, 4, -1, false, '"id"', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Nullable = false; // NOT NULL field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // campaign_id
        $this->campaign_id = new DbField('main_transactions', 'main_transactions', 'x_campaign_id', 'campaign_id', '"campaign_id"', 'CAST("campaign_id" AS varchar(255))', 3, 4, -1, false, '"EV__campaign_id"', true, true, true, 'FORMATTED TEXT', 'SELECT');
        $this->campaign_id->IsForeignKey = true; // Foreign key field
        $this->campaign_id->Nullable = false; // NOT NULL field
        $this->campaign_id->Required = true; // Required field
        $this->campaign_id->Sortable = true; // Allow sort
        $this->campaign_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->campaign_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->campaign_id->Lookup = new Lookup('campaign_id', 'main_campaigns', false, 'id', ["name","quantity","bus_size_id","end_date"], [], ["x_operator_id","x_price_id"], [], [], [], [], '"id" DESC', '');
        $this->campaign_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['campaign_id'] = &$this->campaign_id;

        // operator_id
        $this->operator_id = new DbField('main_transactions', 'main_transactions', 'x_operator_id', 'operator_id', '"operator_id"', 'CAST("operator_id" AS varchar(255))', 3, 4, -1, false, '"operator_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->operator_id->IsForeignKey = true; // Foreign key field
        $this->operator_id->Nullable = false; // NOT NULL field
        $this->operator_id->Required = true; // Required field
        $this->operator_id->Sortable = true; // Allow sort
        $this->operator_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->operator_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->operator_id->Lookup = new Lookup('operator_id', 'view_operators_platforms', false, 'operator_id', ["operator_name","","",""], ["x_campaign_id"], [], ["campaign_id"], ["x_campaign_id"], [], [], '', '');
        $this->operator_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['operator_id'] = &$this->operator_id;

        // payment_date
        $this->payment_date = new DbField('main_transactions', 'main_transactions', 'x_payment_date', 'payment_date', '"payment_date"', CastDateFieldForLike("\"payment_date\"", 5, "DB"), 133, 4, 5, false, '"payment_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->payment_date->Sortable = true; // Allow sort
        $this->payment_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->Fields['payment_date'] = &$this->payment_date;

        // price_id
        $this->price_id = new DbField('main_transactions', 'main_transactions', 'x_price_id', 'price_id', '"price_id"', 'CAST("price_id" AS varchar(255))', 3, 4, -1, false, '"EV__price_id"', true, true, true, 'FORMATTED TEXT', 'SELECT');
        $this->price_id->Required = true; // Required field
        $this->price_id->Sortable = true; // Allow sort
        $this->price_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->price_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->price_id->Lookup = new Lookup('price_id', 'view_pricing_options', false, 'price_id', ["price_details","platform_inventory","",""], ["x_campaign_id"], [], ["campaign_id"], ["x_campaign_id"], [], [], '', '');
        $this->price_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['price_id'] = &$this->price_id;

        // quantity
        $this->quantity = new DbField('main_transactions', 'main_transactions', 'x_quantity', 'quantity', '"quantity"', 'CAST("quantity" AS varchar(255))', 3, 4, -1, false, '"quantity"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->quantity->Nullable = false; // NOT NULL field
        $this->quantity->Required = true; // Required field
        $this->quantity->Sortable = true; // Allow sort
        $this->quantity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['quantity'] = &$this->quantity;

        // start_date
        $this->start_date = new DbField('main_transactions', 'main_transactions', 'x_start_date', 'start_date', '"start_date"', CastDateFieldForLike("\"start_date\"", 5, "DB"), 133, 4, 5, false, '"start_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->start_date->Sortable = true; // Allow sort
        $this->start_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->Fields['start_date'] = &$this->start_date;

        // end_date
        $this->end_date = new DbField('main_transactions', 'main_transactions', 'x_end_date', 'end_date', '"end_date"', CastDateFieldForLike("\"end_date\"", 5, "DB"), 133, 4, 5, false, '"end_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->end_date->Sortable = true; // Allow sort
        $this->end_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->end_date->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->end_date->Param, "CustomMsg");
        $this->Fields['end_date'] = &$this->end_date;

        // visible_status_id
        $this->visible_status_id = new DbField('main_transactions', 'main_transactions', 'x_visible_status_id', 'visible_status_id', 'status_id', 'CAST(status_id AS varchar(255))', 3, 4, -1, false, 'status_id', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->visible_status_id->IsCustom = true; // Custom field
        $this->visible_status_id->Sortable = true; // Allow sort
        $this->visible_status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->visible_status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->visible_status_id->Lookup = new Lookup('visible_status_id', 'x_transaction_status', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->visible_status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['visible_status_id'] = &$this->visible_status_id;

        // status_id
        $this->status_id = new DbField('main_transactions', 'main_transactions', 'x_status_id', 'status_id', '"status_id"', 'CAST("status_id" AS varchar(255))', 3, 4, -1, false, '"EV__status_id"', true, true, true, 'FORMATTED TEXT', 'SELECT');
        $this->status_id->Nullable = false; // NOT NULL field
        $this->status_id->Sortable = true; // Allow sort
        $this->status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status_id->Lookup = new Lookup('status_id', 'x_transaction_status', false, 'id', ["admin_name","","",""], [], [], [], [], [], [], '', '');
        $this->status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_id'] = &$this->status_id;

        // print_status_id
        $this->print_status_id = new DbField('main_transactions', 'main_transactions', 'x_print_status_id', 'print_status_id', '"print_status_id"', 'CAST("print_status_id" AS varchar(255))', 3, 4, -1, false, '"EV__print_status_id"', true, true, true, 'FORMATTED TEXT', 'SELECT');
        $this->print_status_id->Nullable = false; // NOT NULL field
        $this->print_status_id->Sortable = true; // Allow sort
        $this->print_status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->print_status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->print_status_id->Lookup = new Lookup('print_status_id', 'x_print_status', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->print_status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['print_status_id'] = &$this->print_status_id;

        // payment_status_id
        $this->payment_status_id = new DbField('main_transactions', 'main_transactions', 'x_payment_status_id', 'payment_status_id', '"payment_status_id"', 'CAST("payment_status_id" AS varchar(255))', 3, 4, -1, false, '"EV__payment_status_id"', true, true, true, 'FORMATTED TEXT', 'SELECT');
        $this->payment_status_id->Nullable = false; // NOT NULL field
        $this->payment_status_id->Sortable = true; // Allow sort
        $this->payment_status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->payment_status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->payment_status_id->Lookup = new Lookup('payment_status_id', 'x_payment_status', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->payment_status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['payment_status_id'] = &$this->payment_status_id;

        // created_by
        $this->created_by = new DbField('main_transactions', 'main_transactions', 'x_created_by', 'created_by', '"created_by"', 'CAST("created_by" AS varchar(255))', 3, 4, -1, false, '"created_by"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->created_by->Nullable = false; // NOT NULL field
        $this->created_by->Required = true; // Required field
        $this->created_by->Sortable = true; // Allow sort
        $this->created_by->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->created_by->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->created_by->Lookup = new Lookup('created_by', 'main_users', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->created_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['created_by'] = &$this->created_by;

        // ts_created
        $this->ts_created = new DbField('main_transactions', 'main_transactions', 'x_ts_created', 'ts_created', '"ts_created"', CastDateFieldForLike("\"ts_created\"", 0, "DB"), 135, 8, 0, false, '"ts_created"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_created->Nullable = false; // NOT NULL field
        $this->ts_created->Required = true; // Required field
        $this->ts_created->Sortable = true; // Allow sort
        $this->ts_created->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ts_created'] = &$this->ts_created;

        // ts_last_update
        $this->ts_last_update = new DbField('main_transactions', 'main_transactions', 'x_ts_last_update', 'ts_last_update', '"ts_last_update"', CastDateFieldForLike("\"ts_last_update\"", 0, "DB"), 135, 8, 0, false, '"ts_last_update"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_last_update->Nullable = false; // NOT NULL field
        $this->ts_last_update->Required = true; // Required field
        $this->ts_last_update->Sortable = true; // Allow sort
        $this->ts_last_update->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ts_last_update'] = &$this->ts_last_update;

        // total
        $this->total = new DbField('main_transactions', 'main_transactions', 'x_total', 'total', 'quantity * (select v.price from view_pricing_all v where v.id = price_id)', 'CAST(quantity * (select v.price from view_pricing_all v where v.id = price_id) AS varchar(255))', 20, 8, -1, false, 'quantity * (select v.price from view_pricing_all v where v.id = price_id)', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->total->IsCustom = true; // Custom field
        $this->total->Sortable = true; // Allow sort
        $this->Fields['total'] = &$this->total;
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
        return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST")];
    }

    public function setSessionOrderByList($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST")] = $v;
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")];
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "main_campaigns") {
            if ($this->campaign_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("\"id\"", $this->campaign_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "y_operators") {
            if ($this->operator_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("\"id\"", $this->operator_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "main_campaigns") {
            if ($this->campaign_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("\"campaign_id\"", $this->campaign_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "y_operators") {
            if ($this->operator_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("\"operator_id\"", $this->operator_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_main_campaigns()
    {
        return "\"id\"=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_main_campaigns()
    {
        return "\"campaign_id\"=@campaign_id@";
    }

    // Master filter
    public function sqlMasterFilter_y_operators()
    {
        return "\"id\"=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_y_operators()
    {
        return "\"operator_id\"=@operator_id@";
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
        if ($this->getCurrentDetailTable() == "sub_transaction_details") {
            $detailUrl = Container("sub_transaction_details")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "maintransactionslist";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"main_transactions\"";
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
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*, status_id AS \"visible_status_id\", quantity * (select v.price from view_pricing_all v where v.id = price_id) AS \"total\"");
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
        $from = "(SELECT *, status_id AS \"visible_status_id\", quantity * (select v.price from view_pricing_all v where v.id = price_id) AS \"total\", (SELECT \"name\" || '" . ValueSeparator(1, $this->campaign_id) . "' || \"quantity\" || '" . ValueSeparator(2, $this->campaign_id) . "' || \"bus_size_id\" || '" . ValueSeparator(3, $this->campaign_id) . "' || \"end_date\" FROM \"main_campaigns\" \"TMP_LOOKUPTABLE\" WHERE \"TMP_LOOKUPTABLE\".\"id\" = \"main_transactions\".\"campaign_id\" LIMIT 1) AS \"EV__campaign_id\", (SELECT \"price_details\" || '" . ValueSeparator(1, $this->price_id) . "' || \"platform_inventory\" FROM \"view_pricing_options\" \"TMP_LOOKUPTABLE\" WHERE \"TMP_LOOKUPTABLE\".\"price_id\" = \"main_transactions\".\"price_id\" LIMIT 1) AS \"EV__price_id\", (SELECT \"admin_name\" FROM \"x_transaction_status\" \"TMP_LOOKUPTABLE\" WHERE \"TMP_LOOKUPTABLE\".\"id\" = \"main_transactions\".\"status_id\" LIMIT 1) AS \"EV__status_id\", (SELECT \"name\" FROM \"x_print_status\" \"TMP_LOOKUPTABLE\" WHERE \"TMP_LOOKUPTABLE\".\"id\" = \"main_transactions\".\"print_status_id\" LIMIT 1) AS \"EV__print_status_id\", (SELECT \"name\" FROM \"x_payment_status\" \"TMP_LOOKUPTABLE\" WHERE \"TMP_LOOKUPTABLE\".\"id\" = \"main_transactions\".\"payment_status_id\" LIMIT 1) AS \"EV__payment_status_id\" FROM \"main_transactions\")";
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
            if ($this->getCurrentMasterTable() == "main_campaigns" || $this->getCurrentMasterTable() == "") {
                $filter = $this->addDetailUserIDFilter($filter, "main_campaigns"); // Add detail User ID filter
            }
            if ($this->getCurrentMasterTable() == "y_operators" || $this->getCurrentMasterTable() == "") {
                $filter = $this->addDetailUserIDFilter($filter, "y_operators"); // Add detail User ID filter
            }
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
            $this->campaign_id->AdvancedSearch->SearchValue != "" ||
            $this->campaign_id->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->campaign_id->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->campaign_id->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->price_id->AdvancedSearch->SearchValue != "" ||
            $this->price_id->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->price_id->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->price_id->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->status_id->AdvancedSearch->SearchValue != "" ||
            $this->status_id->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->status_id->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->status_id->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->print_status_id->AdvancedSearch->SearchValue != "" ||
            $this->print_status_id->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->print_status_id->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->print_status_id->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->payment_status_id->AdvancedSearch->SearchValue != "" ||
            $this->payment_status_id->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->payment_status_id->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->payment_status_id->VirtualExpression . " ")) {
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
            $this->id->setDbValue($conn->fetchColumn("SELECT currval('transactions_id_seq'::regclass)"));
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
        $this->operator_id->DbValue = $row['operator_id'];
        $this->payment_date->DbValue = $row['payment_date'];
        $this->price_id->DbValue = $row['price_id'];
        $this->quantity->DbValue = $row['quantity'];
        $this->start_date->DbValue = $row['start_date'];
        $this->end_date->DbValue = $row['end_date'];
        $this->visible_status_id->DbValue = $row['visible_status_id'];
        $this->status_id->DbValue = $row['status_id'];
        $this->print_status_id->DbValue = $row['print_status_id'];
        $this->payment_status_id->DbValue = $row['payment_status_id'];
        $this->created_by->DbValue = $row['created_by'];
        $this->ts_created->DbValue = $row['ts_created'];
        $this->ts_last_update->DbValue = $row['ts_last_update'];
        $this->total->DbValue = $row['total'];
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
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if (ReferUrl() != "" && ReferPageName() != CurrentPageName() && ReferPageName() != "login") { // Referer not same page or login page
            $_SESSION[$name] = ReferUrl(); // Save to Session
        }
        if (@$_SESSION[$name] != "") {
            return $_SESSION[$name];
        } else {
            return GetUrl("maintransactionslist");
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
        if ($pageName == "maintransactionsview") {
            return $Language->phrase("View");
        } elseif ($pageName == "maintransactionsedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "maintransactionsadd") {
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
                return "MainTransactionsView";
            case Config("API_ADD_ACTION"):
                return "MainTransactionsAdd";
            case Config("API_EDIT_ACTION"):
                return "MainTransactionsEdit";
            case Config("API_DELETE_ACTION"):
                return "MainTransactionsDelete";
            case Config("API_LIST_ACTION"):
                return "MainTransactionsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "maintransactionslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("maintransactionsview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("maintransactionsview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "maintransactionsadd?" . $this->getUrlParm($parm);
        } else {
            $url = "maintransactionsadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("maintransactionsedit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("maintransactionsedit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("maintransactionsadd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("maintransactionsadd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("maintransactionsdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "main_campaigns" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->campaign_id->CurrentValue);
        }
        if ($this->getCurrentMasterTable() == "y_operators" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->operator_id->CurrentValue);
        }
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
        $this->operator_id->setDbValue($row['operator_id']);
        $this->payment_date->setDbValue($row['payment_date']);
        $this->price_id->setDbValue($row['price_id']);
        $this->quantity->setDbValue($row['quantity']);
        $this->start_date->setDbValue($row['start_date']);
        $this->end_date->setDbValue($row['end_date']);
        $this->visible_status_id->setDbValue($row['visible_status_id']);
        $this->status_id->setDbValue($row['status_id']);
        $this->print_status_id->setDbValue($row['print_status_id']);
        $this->payment_status_id->setDbValue($row['payment_status_id']);
        $this->created_by->setDbValue($row['created_by']);
        $this->ts_created->setDbValue($row['ts_created']);
        $this->ts_last_update->setDbValue($row['ts_last_update']);
        $this->total->setDbValue($row['total']);
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
        $this->total->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

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
        $this->visible_status_id->HrefValue = "";
        $this->visible_status_id->TooltipValue = "";

        // status_id
        $this->status_id->LinkCustomAttributes = "";
        $this->status_id->HrefValue = "";
        $this->status_id->TooltipValue = "";

        // print_status_id
        $this->print_status_id->LinkCustomAttributes = "";
        $this->print_status_id->HrefValue = "";
        $this->print_status_id->TooltipValue = "";

        // payment_status_id
        $this->payment_status_id->LinkCustomAttributes = "";
        $this->payment_status_id->HrefValue = "";
        $this->payment_status_id->TooltipValue = "";

        // created_by
        $this->created_by->LinkCustomAttributes = "";
        $this->created_by->HrefValue = "";
        $this->created_by->TooltipValue = "";

        // ts_created
        $this->ts_created->LinkCustomAttributes = "";
        $this->ts_created->HrefValue = "";
        $this->ts_created->TooltipValue = "";

        // ts_last_update
        $this->ts_last_update->LinkCustomAttributes = "";
        $this->ts_last_update->HrefValue = "";
        $this->ts_last_update->TooltipValue = "";

        // total
        $this->total->LinkCustomAttributes = "";
        $this->total->HrefValue = "";
        $this->total->TooltipValue = "";

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
        $this->id->EditValue = FormatNumber($this->id->EditValue, 0, -2, -2, -2);
        $this->id->ViewCustomAttributes = "";

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
            $this->operator_id->PlaceHolder = RemoveHtml($this->operator_id->caption());
        }

        // payment_date
        $this->payment_date->EditAttrs["class"] = "form-control";
        $this->payment_date->EditCustomAttributes = "";
        $this->payment_date->EditValue = FormatDateTime($this->payment_date->CurrentValue, 5);
        $this->payment_date->PlaceHolder = RemoveHtml($this->payment_date->caption());

        // price_id
        $this->price_id->EditAttrs["class"] = "form-control";
        $this->price_id->EditCustomAttributes = "";
        $this->price_id->PlaceHolder = RemoveHtml($this->price_id->caption());

        // quantity
        $this->quantity->EditAttrs["class"] = "form-control";
        $this->quantity->EditCustomAttributes = "";
        $this->quantity->EditValue = $this->quantity->CurrentValue;
        $this->quantity->PlaceHolder = RemoveHtml($this->quantity->caption());

        // start_date
        $this->start_date->EditAttrs["class"] = "form-control";
        $this->start_date->EditCustomAttributes = 'readonly="readonly"';
        $this->start_date->EditValue = FormatDateTime($this->start_date->CurrentValue, 5);
        $this->start_date->PlaceHolder = RemoveHtml($this->start_date->caption());

        // end_date
        $this->end_date->EditAttrs["class"] = "form-control";
        $this->end_date->EditCustomAttributes = 'readonly="readonly"';
        $this->end_date->EditValue = FormatDateTime($this->end_date->CurrentValue, 5);
        $this->end_date->PlaceHolder = RemoveHtml($this->end_date->caption());

        // visible_status_id
        $this->visible_status_id->EditAttrs["class"] = "form-control";
        $this->visible_status_id->EditCustomAttributes = "";
        $this->visible_status_id->PlaceHolder = RemoveHtml($this->visible_status_id->caption());

        // status_id
        $this->status_id->EditAttrs["class"] = "form-control";
        $this->status_id->EditCustomAttributes = "";
        $this->status_id->PlaceHolder = RemoveHtml($this->status_id->caption());

        // print_status_id
        $this->print_status_id->EditAttrs["class"] = "form-control";
        $this->print_status_id->EditCustomAttributes = "";
        $this->print_status_id->PlaceHolder = RemoveHtml($this->print_status_id->caption());

        // payment_status_id
        $this->payment_status_id->EditAttrs["class"] = "form-control";
        $this->payment_status_id->EditCustomAttributes = "";
        $this->payment_status_id->PlaceHolder = RemoveHtml($this->payment_status_id->caption());

        // created_by
        $this->created_by->EditAttrs["class"] = "form-control";
        $this->created_by->EditCustomAttributes = "";
        $this->created_by->PlaceHolder = RemoveHtml($this->created_by->caption());

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

        // total
        $this->total->EditAttrs["class"] = "form-control";
        $this->total->EditCustomAttributes = "";
        $this->total->EditValue = $this->total->CurrentValue;
        $this->total->PlaceHolder = RemoveHtml($this->total->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            if (is_numeric($this->quantity->CurrentValue)) {
                $this->quantity->Total += $this->quantity->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->total->CurrentValue)) {
                $this->total->Total += $this->total->CurrentValue; // Accumulate total
            }
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->quantity->CurrentValue = $this->quantity->Total;
            $this->quantity->ViewValue = $this->quantity->CurrentValue;
            $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
            $this->quantity->ViewCustomAttributes = "";
            $this->quantity->HrefValue = ""; // Clear href value
            $this->total->CurrentValue = $this->total->Total;
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatNumber($this->total->ViewValue, 0, -2, -2, -2);
            $this->total->ViewCustomAttributes = "";
            $this->total->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->operator_id);
                    $doc->exportCaption($this->payment_date);
                    $doc->exportCaption($this->price_id);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->start_date);
                    $doc->exportCaption($this->end_date);
                    $doc->exportCaption($this->visible_status_id);
                    $doc->exportCaption($this->status_id);
                    $doc->exportCaption($this->print_status_id);
                    $doc->exportCaption($this->payment_status_id);
                    $doc->exportCaption($this->created_by);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->ts_last_update);
                    $doc->exportCaption($this->total);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->campaign_id);
                    $doc->exportCaption($this->operator_id);
                    $doc->exportCaption($this->payment_date);
                    $doc->exportCaption($this->price_id);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->start_date);
                    $doc->exportCaption($this->end_date);
                    $doc->exportCaption($this->visible_status_id);
                    $doc->exportCaption($this->status_id);
                    $doc->exportCaption($this->print_status_id);
                    $doc->exportCaption($this->payment_status_id);
                    $doc->exportCaption($this->created_by);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->ts_last_update);
                    $doc->exportCaption($this->total);
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
                        $doc->exportField($this->campaign_id);
                        $doc->exportField($this->operator_id);
                        $doc->exportField($this->payment_date);
                        $doc->exportField($this->price_id);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->start_date);
                        $doc->exportField($this->end_date);
                        $doc->exportField($this->visible_status_id);
                        $doc->exportField($this->status_id);
                        $doc->exportField($this->print_status_id);
                        $doc->exportField($this->payment_status_id);
                        $doc->exportField($this->created_by);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->ts_last_update);
                        $doc->exportField($this->total);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->campaign_id);
                        $doc->exportField($this->operator_id);
                        $doc->exportField($this->payment_date);
                        $doc->exportField($this->price_id);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->start_date);
                        $doc->exportField($this->end_date);
                        $doc->exportField($this->visible_status_id);
                        $doc->exportField($this->status_id);
                        $doc->exportField($this->print_status_id);
                        $doc->exportField($this->payment_status_id);
                        $doc->exportField($this->created_by);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->ts_last_update);
                        $doc->exportField($this->total);
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
                $doc->exportAggregate($this->id, '');
                $doc->exportAggregate($this->campaign_id, '');
                $doc->exportAggregate($this->operator_id, '');
                $doc->exportAggregate($this->payment_date, '');
                $doc->exportAggregate($this->price_id, '');
                $doc->exportAggregate($this->quantity, 'TOTAL');
                $doc->exportAggregate($this->start_date, '');
                $doc->exportAggregate($this->end_date, '');
                $doc->exportAggregate($this->visible_status_id, '');
                $doc->exportAggregate($this->status_id, '');
                $doc->exportAggregate($this->print_status_id, '');
                $doc->exportAggregate($this->payment_status_id, '');
                $doc->exportAggregate($this->created_by, '');
                $doc->exportAggregate($this->ts_created, '');
                $doc->exportAggregate($this->ts_last_update, '');
                $doc->exportAggregate($this->total, 'TOTAL');
                $doc->endExportRow();
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Add master User ID filter
    public function addMasterUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "main_campaigns") {
            $filterWrk = Container("main_campaigns")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "main_campaigns") {
            $mastertable = Container("main_campaigns");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->campaign_id, $mastertable->id);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        return $filterWrk;
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
        $rsnew["created_by"] = IsAdmin() ? CurrentUserID():Profile()->id;
        //Log(IsAdmin() ? CurrentUserID():Profile()->id);
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
    	$username = "Transit Media Vendor";
    	$email = "";
    	$msg = "";
    	$msgtxt = "";
    	$subject = "";
    	$camp_id = $rsold["id"];
    	$sql = "select
        c.name, name, t.start_date, t.end_date,
        (t.end_date::timestamp - t.start_date::timestamp) as duration,
        t.quantity,
        to_char(
        t.quantity * (select price FROM public.z_price_settings p where p.id = c.price_id)
        , 'N999,999,999,990'::text) as amount,
        (select value from z_core_settings where name = 'ext_account_details' ) as account_details,
        (select name from y_vendors v where v.id = vendor_id) as vendor,
    	(select name from y_operators o where o.id = t.operator_id) as operator,
    	(select email from y_operators o where o.id = t.operator_id) as operator_email,
    	(select contact_name from y_operators o where o.id = t.operator_id) as operator_contact_name
        from main_campaigns c, main_transactions t 
    	where 
    	t.campaign_id = c.id and
    	t.id = {$camp_id} ;";
    	$camp_details = ExecuteRow($sql);
    	$operator = $camp_details["operator"];
    	$operator_email = $camp_details["operator_email"];
    	$operator_contact_name =  $camp_details["operator_contact_name"];
    	$rowssql = "select email from main_users where vendor_id in ";
    	$rowssql .= "(select vendor_id from main_campaigns where id in (select campaign_id from main_transactions where id = " . $camp_id . "));";
    	$rows = ExecuteRows($rowssql);
    	$emailslist_array = [];
    	foreach ($rows as $v) {
    		if(strlen($v['email']) > 2 ){
    			$emailslist_array[] = $v['email'];
    		}
    	}
    	$emailslist = implode(',', $emailslist_array);

    	// $email = $val['email'];
    	$email = $emailslist;
    	$vendor = $camp_details['vendor'];
    	$username = $vendor;
    	$search_replace = [
    		'[x_campaign]' => $camp_details['name'],
    		'[x_quantity]' => $camp_details['quantity'],
    		'[x_vendor]' => $vendor,
    		'[x_supportemail] ' => 'info@transitmedia.com.ng',
    	];
    	$search = array_keys($search_replace);
    	$replace = array_values($search_replace);
    	$x_camp_name = $camp_details['name'];
    	if ($rsold["status_id"] != 3 && $rsnew["status_id"] == 3) {
    		//Campaign Denied
    		$sql_msg = "select value from z_core_settings where name = 'campaign_denied';";
    		$editmsg = ExecuteScalar($sql_msg);
    		$msg = str_replace($search, $replace, $editmsg);
    		$msgtxt = strip_tags($msg);
    		$subject = "DENIED CAMPAIGN REQUEST ({$vendor}) - TRANSIT MEDIA ADMIN";
    		$subject = "{$x_camp_name} - ({$vendor}) - TRANSIT MEDIA ADMIN";
    		#===============================================================
    		$emailpayload = getEmailPayload('updates_to_campaign_vendor');
    		$exposed_emails = get_emails($emailpayload, $email);
    		extract($exposed_emails);
    		$email = $final_to;
    		$cc = $final_cc;
    		$bcc = $final_bcc;
    		#===============================================================
    		if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    		} else {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    			echo "\n<br>====================================<br>\n";
    			echo "sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt,NULL,$cc,$bcc);";
    			echo "\n<br>====================================<br>\n";
    		}
    	}
    	if ($rsold["print_status_id"] != 2 && $rsnew["print_status_id"] == 2) {
    		//Print Approved
    		$sql_msg = "select value from z_core_settings where name = 'print_approved';";
    		$editmsg = ExecuteScalar($sql_msg);
    		$msg = str_replace($search, $replace, $editmsg);
    		$msgtxt = strip_tags($msg);
    		$subject = "PRINT APPROVAL ({$vendor}) - TRANSIT MEDIA ADMIN";
    		$subject = "{$x_camp_name} - ({$vendor}) - TRANSIT MEDIA ADMIN";
    		#===============================================================
    		$emailpayload = getEmailPayload('updates_to_campaign_vendor');
    		$exposed_emails = get_emails($emailpayload, $email);
    		extract($exposed_emails);
    		$email = $final_to;
    		$cc = $final_cc;
    		$bcc = $final_bcc;
    		#===============================================================
    		if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    		} else {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    			echo "\n<br>====================================<br>\n";
    			echo "sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt,NULL,$cc,$bcc);";
    			echo "\n<br>====================================<br>\n";
    		}
    	}
    	if ($rsold["print_status_id"] != 3 && $rsnew["print_status_id"] == 3) {
    		//Print Denied
    		$sql_msg = "select value from z_core_settings where name = 'print_denied';";
    		$editmsg = ExecuteScalar($sql_msg);
    		$msg = str_replace($search, $replace, $editmsg);
    		$msgtxt = strip_tags($msg);
    		$subject = "PRINT REFUSAL ({$vendor}) - TRANSIT MEDIA ADMIN";
    		$subject = "{$x_camp_name} - ({$vendor}) - TRANSIT MEDIA ADMIN";
    		#===============================================================
    		$emailpayload = getEmailPayload('updates_to_campaign_vendor');
    		$exposed_emails = get_emails($emailpayload, $email);
    		extract($exposed_emails);
    		$email = $final_to;
    		$cc = $final_cc;
    		$bcc = $final_bcc;
    		#===============================================================
    		if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    		} else {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    			echo "\n<br>====================================<br>\n";
    			echo "sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt,NULL,$cc,$bcc);";
    			echo "\n<br>====================================<br>\n";
    		}
    	}
    	if ($rsold["payment_status_id"] != 2 && $rsnew["payment_status_id"] == 2) {
    		//Payment Approved
    		$sql_msg = "select value from z_core_settings where name = 'payment_approved';";
    		$editmsg = ExecuteScalar($sql_msg);
    		$msg = str_replace($search, $replace, $editmsg);
    		$msgtxt = strip_tags($msg);
    		$subject = "PAYMENT CONFIRMATION ({$vendor}) - TRANSIT MEDIA ADMIN";
    		#===============================================================
    		$emailpayload = getEmailPayload('updates_to_campaign_vendor');
    		$exposed_emails = get_emails($emailpayload, $email);
    		extract($exposed_emails);
    		$email = $final_to;
    		$cc = $final_cc;
    		$bcc = $final_bcc;
    		#===============================================================
    		if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    		} else {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    			echo "\n<br>====================================<br>\n";
    			echo "sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt,NULL,$cc,$bcc);";
    			echo "\n<br>====================================<br>\n";
    		}
    	}

    	//if (($rsnew["payment_status_id"] == 2 && $rsnew["print_status_id"] == 2) && ($rsold["payment_status_id"] != 2 || $rsold["print_status_id"] != 2)) {
    	if (($rsnew["payment_status_id"] == 2) && ($rsold["payment_status_id"] != 2)) {
    		//Print & Payment Approved. Send mail to operator
    		$msg = "Your request has been sent to the Operator for Approval. You will be notified by email once a decision is made.";	
    		$this->setSuccessMessage($msg);
    		$sql_msg = "select value from z_core_settings where name = 'print_and_payment_approved_primero';";
    		$editmsg = ExecuteScalar($sql_msg);
    		$msg = str_replace($search, $replace, $editmsg);
    		$msgtxt = strip_tags($msg);
    		$subject = "PENDING APPROVAL - PRINT & PAYMENT CONFIRMATION ({$vendor}) - TRANSIT MEDIA ADMIN - {$operator}";
    		$subject = "{$x_camp_name} - ({$vendor}) - TRANSIT MEDIA ADMIN - {$operator}";

    		// GET OPERATOR EMAIL
    		$sqloperator = "select o.name, o.email from main_transactions t, y_operators o where o.id = t.operator_id and t.id = {$camp_id} LIMIT 1;";
    		$operator_vals = ExecuteRow($sqloperator);
    		#===============================================================
    		$emailpayload = getEmailPayload('updates_to_campaign_operator');
    		$exposed_emails = get_emails($emailpayload);
    		extract($exposed_emails);
    		$email = $operator_vals['name'] . " <" . $operator_vals['email'] .">";
    		$cc = $final_cc;
    		$bcc = $final_bcc;
    		#===============================================================

    		// UPDATE STATUS to PENDING OPERATOR APPROVAL
    		$updatesql = "UPDATE main_transactions SET status_id = 4 WHERE id = {$camp_id}";
    		ExecuteUpdate($updatesql);
    		if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false) {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    		} else {
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt, null, $cc, $bcc);
    			echo "\n<br>====================================<br>\n";
    			echo "sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt,NULL,$cc,$bcc);";
    			echo "\n<br>====================================<br>\n";
    		}
    	}

    //exit;
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

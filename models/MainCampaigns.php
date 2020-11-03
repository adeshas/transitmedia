<?php

namespace PHPMaker2021\test;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for main_campaigns
 */
class MainCampaigns extends DbTable
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
    public $name;
    public $inventory_id;
    public $platform_id;
    public $bus_size_id;
    public $price_id;
    public $quantity;
    public $start_date;
    public $end_date;
    public $user_id;
    public $vendor_id;
    public $status_id;
    public $print_status_id;
    public $payment_status_id;
    public $ts_last_update;
    public $ts_created;
    public $renewal_stage_id;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'main_campaigns';
        $this->TableName = 'main_campaigns';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "\"main_campaigns\"";
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
        $this->ShowMultipleDetails = true; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('main_campaigns', 'main_campaigns', 'x_id', 'id', '"id"', 'CAST("id" AS varchar(255))', 3, 4, -1, false, '"id"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Nullable = false; // NOT NULL field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // name
        $this->name = new DbField('main_campaigns', 'main_campaigns', 'x_name', 'name', '"name"', '"name"', 201, 0, -1, false, '"name"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->name->Sortable = true; // Allow sort
        $this->name->Lookup = new Lookup('name', 'main_campaigns', false, 'name', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->Fields['name'] = &$this->name;

        // inventory_id
        $this->inventory_id = new DbField('main_campaigns', 'main_campaigns', 'x_inventory_id', 'inventory_id', '"inventory_id"', 'CAST("inventory_id" AS varchar(255))', 3, 4, -1, false, '"inventory_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->inventory_id->Required = true; // Required field
        $this->inventory_id->Sortable = true; // Allow sort
        $this->inventory_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->inventory_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->inventory_id->Lookup = new Lookup('inventory_id', 'view_pricing_initial', true, 'inventory_id', ["inventory","","",""], [], ["x_platform_id","x_bus_size_id","x_price_id"], [], [], [], [], '', '');
        $this->inventory_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['inventory_id'] = &$this->inventory_id;

        // platform_id
        $this->platform_id = new DbField('main_campaigns', 'main_campaigns', 'x_platform_id', 'platform_id', '"platform_id"', 'CAST("platform_id" AS varchar(255))', 3, 4, -1, false, '"platform_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->platform_id->IsForeignKey = true; // Foreign key field
        $this->platform_id->Required = true; // Required field
        $this->platform_id->Sortable = true; // Allow sort
        $this->platform_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->platform_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->platform_id->Lookup = new Lookup('platform_id', 'view_pricing_initial', true, 'platform_id', ["platform","","",""], ["x_inventory_id"], ["x_bus_size_id","x_price_id"], ["inventory_id"], ["x_inventory_id"], [], [], '', '');
        $this->platform_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['platform_id'] = &$this->platform_id;

        // bus_size_id
        $this->bus_size_id = new DbField('main_campaigns', 'main_campaigns', 'x_bus_size_id', 'bus_size_id', '"bus_size_id"', 'CAST("bus_size_id" AS varchar(255))', 3, 4, -1, false, '"bus_size_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->bus_size_id->Required = true; // Required field
        $this->bus_size_id->Sortable = true; // Allow sort
        $this->bus_size_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->bus_size_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->bus_size_id->Lookup = new Lookup('bus_size_id', 'view_pricing_initial', true, 'bus_size_id', ["bus_size","","",""], ["x_inventory_id","x_platform_id"], ["x_price_id"], ["inventory_id","platform_id"], ["x_inventory_id","x_platform_id"], [], [], '', '');
        $this->bus_size_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['bus_size_id'] = &$this->bus_size_id;

        // price_id
        $this->price_id = new DbField('main_campaigns', 'main_campaigns', 'x_price_id', 'price_id', '"price_id"', 'CAST("price_id" AS varchar(255))', 3, 4, -1, false, '"price_id"', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->price_id->Required = true; // Required field
        $this->price_id->Sortable = true; // Allow sort
        $this->price_id->Lookup = new Lookup('price_id', 'view_pricing_initial', false, 'id', ["price","details","",""], ["x_inventory_id","x_platform_id","x_bus_size_id"], [], ["inventory_id","platform_id","bus_size_id"], ["x_inventory_id","x_platform_id","x_bus_size_id"], [], [], '', '');
        $this->price_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->price_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->price_id->Param, "CustomMsg");
        $this->Fields['price_id'] = &$this->price_id;

        // quantity
        $this->quantity = new DbField('main_campaigns', 'main_campaigns', 'x_quantity', 'quantity', '"quantity"', 'CAST("quantity" AS varchar(255))', 3, 4, -1, false, '"quantity"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->quantity->Sortable = true; // Allow sort
        $this->quantity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->quantity->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->quantity->Param, "CustomMsg");
        $this->Fields['quantity'] = &$this->quantity;

        // start_date
        $this->start_date = new DbField('main_campaigns', 'main_campaigns', 'x_start_date', 'start_date', '"start_date"', CastDateFieldForLike("\"start_date\"", 0, "DB"), 133, 4, 0, false, '"start_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->start_date->Nullable = false; // NOT NULL field
        $this->start_date->Required = true; // Required field
        $this->start_date->Sortable = true; // Allow sort
        $this->start_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['start_date'] = &$this->start_date;

        // end_date
        $this->end_date = new DbField('main_campaigns', 'main_campaigns', 'x_end_date', 'end_date', '"end_date"', CastDateFieldForLike("\"end_date\"", 0, "DB"), 133, 4, 0, false, '"end_date"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->end_date->Nullable = false; // NOT NULL field
        $this->end_date->Required = true; // Required field
        $this->end_date->Sortable = true; // Allow sort
        $this->end_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->end_date->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->end_date->Param, "CustomMsg");
        $this->Fields['end_date'] = &$this->end_date;

        // user_id
        $this->user_id = new DbField('main_campaigns', 'main_campaigns', 'x_user_id', 'user_id', '"user_id"', 'CAST("user_id" AS varchar(255))', 3, 4, -1, false, '"user_id"', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->user_id->IsForeignKey = true; // Foreign key field
        $this->user_id->Nullable = false; // NOT NULL field
        $this->user_id->Sortable = true; // Allow sort
        $this->user_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['user_id'] = &$this->user_id;

        // vendor_id
        $this->vendor_id = new DbField('main_campaigns', 'main_campaigns', 'x_vendor_id', 'vendor_id', '"vendor_id"', 'CAST("vendor_id" AS varchar(255))', 3, 4, -1, false, '"vendor_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->vendor_id->IsForeignKey = true; // Foreign key field
        $this->vendor_id->Sortable = true; // Allow sort
        $this->vendor_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->vendor_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->vendor_id->Lookup = new Lookup('vendor_id', 'y_vendors', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->vendor_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['vendor_id'] = &$this->vendor_id;

        // status_id
        $this->status_id = new DbField('main_campaigns', 'main_campaigns', 'x_status_id', 'status_id', '"status_id"', 'CAST("status_id" AS varchar(255))', 3, 4, -1, false, '"status_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->status_id->Nullable = false; // NOT NULL field
        $this->status_id->Sortable = true; // Allow sort
        $this->status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status_id->Lookup = new Lookup('status_id', 'x_campaign_status', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_id'] = &$this->status_id;

        // print_status_id
        $this->print_status_id = new DbField('main_campaigns', 'main_campaigns', 'x_print_status_id', 'print_status_id', '"print_status_id"', 'CAST("print_status_id" AS varchar(255))', 3, 4, -1, false, '"print_status_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->print_status_id->Nullable = false; // NOT NULL field
        $this->print_status_id->Sortable = true; // Allow sort
        $this->print_status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->print_status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->print_status_id->Lookup = new Lookup('print_status_id', 'x_print_status', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->print_status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['print_status_id'] = &$this->print_status_id;

        // payment_status_id
        $this->payment_status_id = new DbField('main_campaigns', 'main_campaigns', 'x_payment_status_id', 'payment_status_id', '"payment_status_id"', 'CAST("payment_status_id" AS varchar(255))', 3, 4, -1, false, '"payment_status_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->payment_status_id->Nullable = false; // NOT NULL field
        $this->payment_status_id->Sortable = true; // Allow sort
        $this->payment_status_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->payment_status_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->payment_status_id->Lookup = new Lookup('payment_status_id', 'x_payment_status', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->payment_status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['payment_status_id'] = &$this->payment_status_id;

        // ts_last_update
        $this->ts_last_update = new DbField('main_campaigns', 'main_campaigns', 'x_ts_last_update', 'ts_last_update', '"ts_last_update"', CastDateFieldForLike("\"ts_last_update\"", 0, "DB"), 135, 8, 0, false, '"ts_last_update"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_last_update->Nullable = false; // NOT NULL field
        $this->ts_last_update->Required = true; // Required field
        $this->ts_last_update->Sortable = true; // Allow sort
        $this->ts_last_update->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ts_last_update'] = &$this->ts_last_update;

        // ts_created
        $this->ts_created = new DbField('main_campaigns', 'main_campaigns', 'x_ts_created', 'ts_created', '"ts_created"', CastDateFieldForLike("\"ts_created\"", 0, "DB"), 135, 8, 0, false, '"ts_created"', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ts_created->Nullable = false; // NOT NULL field
        $this->ts_created->Required = true; // Required field
        $this->ts_created->Sortable = true; // Allow sort
        $this->ts_created->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ts_created'] = &$this->ts_created;

        // renewal_stage_id
        $this->renewal_stage_id = new DbField('main_campaigns', 'main_campaigns', 'x_renewal_stage_id', 'renewal_stage_id', '"renewal_stage_id"', 'CAST("renewal_stage_id" AS varchar(255))', 3, 4, -1, false, '"renewal_stage_id"', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->renewal_stage_id->Sortable = true; // Allow sort
        $this->renewal_stage_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->renewal_stage_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->renewal_stage_id->Lookup = new Lookup('renewal_stage_id', 'x_renewal_stage', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->renewal_stage_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['renewal_stage_id'] = &$this->renewal_stage_id;
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
        if ($this->getCurrentMasterTable() == "y_vendors") {
            if ($this->vendor_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("\"id\"", $this->vendor_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "main_users") {
            if ($this->user_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("\"id\"", $this->user_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "y_platforms") {
            if ($this->platform_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("\"id\"", $this->platform_id->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "y_vendors") {
            if ($this->vendor_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("\"vendor_id\"", $this->vendor_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "main_users") {
            if ($this->user_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("\"user_id\"", $this->user_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "y_platforms") {
            if ($this->platform_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("\"platform_id\"", $this->platform_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_y_vendors()
    {
        return "\"id\"=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_y_vendors()
    {
        return "\"vendor_id\"=@vendor_id@";
    }

    // Master filter
    public function sqlMasterFilter_main_users()
    {
        return "\"id\"=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_main_users()
    {
        return "\"user_id\"=@user_id@";
    }

    // Master filter
    public function sqlMasterFilter_y_platforms()
    {
        return "\"id\"=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_y_platforms()
    {
        return "\"platform_id\"=@platform_id@";
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
        if ($this->getCurrentDetailTable() == "sub_media_allocation") {
            $detailUrl = Container("sub_media_allocation")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "main_buses") {
            $detailUrl = Container("main_buses")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "main_transactions") {
            $detailUrl = Container("main_transactions")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "maincampaignslist";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "\"main_campaigns\"";
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
            $this->id->setDbValue($conn->fetchColumn("SELECT currval('new_campaign_id_seq'::regclass)"));
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
        // Cascade Update detail table 'main_buses'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'exterior_campaign_id'
            $cascadeUpdate = true;
            $rscascade['exterior_campaign_id'] = $rs['id'];
        }
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'interior_campaign_id'
            $cascadeUpdate = true;
            $rscascade['interior_campaign_id'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("main_buses")->loadRs("\"exterior_campaign_id\" = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB') . " AND " . "\"interior_campaign_id\" = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("main_buses")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("main_buses")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("main_buses")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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
        $this->name->DbValue = $row['name'];
        $this->inventory_id->DbValue = $row['inventory_id'];
        $this->platform_id->DbValue = $row['platform_id'];
        $this->bus_size_id->DbValue = $row['bus_size_id'];
        $this->price_id->DbValue = $row['price_id'];
        $this->quantity->DbValue = $row['quantity'];
        $this->start_date->DbValue = $row['start_date'];
        $this->end_date->DbValue = $row['end_date'];
        $this->user_id->DbValue = $row['user_id'];
        $this->vendor_id->DbValue = $row['vendor_id'];
        $this->status_id->DbValue = $row['status_id'];
        $this->print_status_id->DbValue = $row['print_status_id'];
        $this->payment_status_id->DbValue = $row['payment_status_id'];
        $this->ts_last_update->DbValue = $row['ts_last_update'];
        $this->ts_created->DbValue = $row['ts_created'];
        $this->renewal_stage_id->DbValue = $row['renewal_stage_id'];
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
            return GetUrl("maincampaignslist");
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
        if ($pageName == "maincampaignsview") {
            return $Language->phrase("View");
        } elseif ($pageName == "maincampaignsedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "maincampaignsadd") {
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
                return "MainCampaignsView";
            case Config("API_ADD_ACTION"):
                return "MainCampaignsAdd";
            case Config("API_EDIT_ACTION"):
                return "MainCampaignsEdit";
            case Config("API_DELETE_ACTION"):
                return "MainCampaignsDelete";
            case Config("API_LIST_ACTION"):
                return "MainCampaignsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "maincampaignslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("maincampaignsview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("maincampaignsview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "maincampaignsadd?" . $this->getUrlParm($parm);
        } else {
            $url = "maincampaignsadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("maincampaignsedit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("maincampaignsedit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("maincampaignsadd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("maincampaignsadd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("maincampaignsdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "y_vendors" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->vendor_id->CurrentValue);
        }
        if ($this->getCurrentMasterTable() == "main_users" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->user_id->CurrentValue);
        }
        if ($this->getCurrentMasterTable() == "y_platforms" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->platform_id->CurrentValue);
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
        $this->name->setDbValue($row['name']);
        $this->inventory_id->setDbValue($row['inventory_id']);
        $this->platform_id->setDbValue($row['platform_id']);
        $this->bus_size_id->setDbValue($row['bus_size_id']);
        $this->price_id->setDbValue($row['price_id']);
        $this->quantity->setDbValue($row['quantity']);
        $this->start_date->setDbValue($row['start_date']);
        $this->end_date->setDbValue($row['end_date']);
        $this->user_id->setDbValue($row['user_id']);
        $this->vendor_id->setDbValue($row['vendor_id']);
        $this->status_id->setDbValue($row['status_id']);
        $this->print_status_id->setDbValue($row['print_status_id']);
        $this->payment_status_id->setDbValue($row['payment_status_id']);
        $this->ts_last_update->setDbValue($row['ts_last_update']);
        $this->ts_created->setDbValue($row['ts_created']);
        $this->renewal_stage_id->setDbValue($row['renewal_stage_id']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // name

        // inventory_id

        // platform_id

        // bus_size_id

        // price_id

        // quantity

        // start_date

        // end_date

        // user_id

        // vendor_id

        // status_id

        // print_status_id

        // payment_status_id

        // ts_last_update

        // ts_created

        // renewal_stage_id

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // name
        $this->name->ViewValue = $this->name->CurrentValue;
        $arwrk = [];
        $arwrk["df"] = $this->name->CurrentValue;
        $arwrk = $this->name->Lookup->renderViewRow($arwrk, $this);
        $dispVal = $this->name->displayValue($arwrk);
        if ($dispVal != "") {
            $this->name->ViewValue = $dispVal;
        }
        $this->name->ViewCustomAttributes = "";

        // inventory_id
        $curVal = strval($this->inventory_id->CurrentValue);
        if ($curVal != "") {
            $this->inventory_id->ViewValue = $this->inventory_id->lookupCacheOption($curVal);
            if ($this->inventory_id->ViewValue === null) { // Lookup from database
                $filterWrk = "\"inventory_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->inventory_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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

        // platform_id
        $curVal = strval($this->platform_id->CurrentValue);
        if ($curVal != "") {
            $this->platform_id->ViewValue = $this->platform_id->lookupCacheOption($curVal);
            if ($this->platform_id->ViewValue === null) { // Lookup from database
                $filterWrk = "\"platform_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->platform_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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

        // bus_size_id
        $curVal = strval($this->bus_size_id->CurrentValue);
        if ($curVal != "") {
            $this->bus_size_id->ViewValue = $this->bus_size_id->lookupCacheOption($curVal);
            if ($this->bus_size_id->ViewValue === null) { // Lookup from database
                $filterWrk = "\"bus_size_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->bus_size_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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

        // price_id
        $curVal = strval($this->price_id->CurrentValue);
        if ($curVal != "") {
            $this->price_id->ViewValue = $this->price_id->lookupCacheOption($curVal);
            if ($this->price_id->ViewValue === null) { // Lookup from database
                $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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
        $this->price_id->ViewCustomAttributes = "";

        // quantity
        $this->quantity->ViewValue = $this->quantity->CurrentValue;
        $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, 0, -2, -2, -2);
        $this->quantity->ViewCustomAttributes = "";

        // start_date
        $this->start_date->ViewValue = $this->start_date->CurrentValue;
        $this->start_date->ViewValue = FormatDateTime($this->start_date->ViewValue, 0);
        $this->start_date->ViewCustomAttributes = "";

        // end_date
        $this->end_date->ViewValue = $this->end_date->CurrentValue;
        $this->end_date->ViewValue = FormatDateTime($this->end_date->ViewValue, 0);
        $this->end_date->ViewCustomAttributes = "";

        // user_id
        $this->user_id->ViewValue = $this->user_id->CurrentValue;
        $this->user_id->ViewValue = FormatNumber($this->user_id->ViewValue, 0, -2, -2, -2);
        $this->user_id->ViewCustomAttributes = "";

        // vendor_id
        $curVal = strval($this->vendor_id->CurrentValue);
        if ($curVal != "") {
            $this->vendor_id->ViewValue = $this->vendor_id->lookupCacheOption($curVal);
            if ($this->vendor_id->ViewValue === null) { // Lookup from database
                $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->vendor_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
        $this->status_id->ViewCustomAttributes = "";

        // print_status_id
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
        $this->print_status_id->ViewCustomAttributes = "";

        // payment_status_id
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
        $this->payment_status_id->ViewCustomAttributes = "";

        // ts_last_update
        $this->ts_last_update->ViewValue = $this->ts_last_update->CurrentValue;
        $this->ts_last_update->ViewValue = FormatDateTime($this->ts_last_update->ViewValue, 0);
        $this->ts_last_update->ViewCustomAttributes = "";

        // ts_created
        $this->ts_created->ViewValue = $this->ts_created->CurrentValue;
        $this->ts_created->ViewValue = FormatDateTime($this->ts_created->ViewValue, 0);
        $this->ts_created->ViewCustomAttributes = "";

        // renewal_stage_id
        $curVal = strval($this->renewal_stage_id->CurrentValue);
        if ($curVal != "") {
            $this->renewal_stage_id->ViewValue = $this->renewal_stage_id->lookupCacheOption($curVal);
            if ($this->renewal_stage_id->ViewValue === null) { // Lookup from database
                $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->renewal_stage_id->Lookup->getSql(false, $filterWrk, '', $this, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->renewal_stage_id->Lookup->renderViewRow($rswrk[0]);
                    $this->renewal_stage_id->ViewValue = $this->renewal_stage_id->displayValue($arwrk);
                } else {
                    $this->renewal_stage_id->ViewValue = $this->renewal_stage_id->CurrentValue;
                }
            }
        } else {
            $this->renewal_stage_id->ViewValue = null;
        }
        $this->renewal_stage_id->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // name
        $this->name->LinkCustomAttributes = "";
        $this->name->HrefValue = "";
        $this->name->TooltipValue = "";

        // inventory_id
        $this->inventory_id->LinkCustomAttributes = "";
        $this->inventory_id->HrefValue = "";
        $this->inventory_id->TooltipValue = "";

        // platform_id
        $this->platform_id->LinkCustomAttributes = "";
        $this->platform_id->HrefValue = "";
        $this->platform_id->TooltipValue = "";

        // bus_size_id
        $this->bus_size_id->LinkCustomAttributes = "";
        $this->bus_size_id->HrefValue = "";
        $this->bus_size_id->TooltipValue = "";

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

        // user_id
        $this->user_id->LinkCustomAttributes = "";
        $this->user_id->HrefValue = "";
        $this->user_id->TooltipValue = "";

        // vendor_id
        $this->vendor_id->LinkCustomAttributes = "";
        $this->vendor_id->HrefValue = "";
        $this->vendor_id->TooltipValue = "";

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

        // ts_last_update
        $this->ts_last_update->LinkCustomAttributes = "";
        $this->ts_last_update->HrefValue = "";
        $this->ts_last_update->TooltipValue = "";

        // ts_created
        $this->ts_created->LinkCustomAttributes = "";
        $this->ts_created->HrefValue = "";
        $this->ts_created->TooltipValue = "";

        // renewal_stage_id
        $this->renewal_stage_id->LinkCustomAttributes = "";
        $this->renewal_stage_id->HrefValue = "";
        $this->renewal_stage_id->TooltipValue = "";

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

        // name
        $this->name->EditAttrs["class"] = "form-control";
        $this->name->EditCustomAttributes = "";
        if (!$this->name->Raw) {
            $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
        }
        $this->name->EditValue = $this->name->CurrentValue;
        $this->name->PlaceHolder = RemoveHtml($this->name->caption());

        // inventory_id
        $this->inventory_id->EditAttrs["class"] = "form-control";
        $this->inventory_id->EditCustomAttributes = "";
        $this->inventory_id->PlaceHolder = RemoveHtml($this->inventory_id->caption());

        // platform_id
        $this->platform_id->EditAttrs["class"] = "form-control";
        $this->platform_id->EditCustomAttributes = "";
        if ($this->platform_id->getSessionValue() != "") {
            $this->platform_id->CurrentValue = GetForeignKeyValue($this->platform_id->getSessionValue());
            $curVal = strval($this->platform_id->CurrentValue);
            if ($curVal != "") {
                $this->platform_id->ViewValue = $this->platform_id->lookupCacheOption($curVal);
                if ($this->platform_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"platform_id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->platform_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
        } else {
            $this->platform_id->PlaceHolder = RemoveHtml($this->platform_id->caption());
        }

        // bus_size_id
        $this->bus_size_id->EditAttrs["class"] = "form-control";
        $this->bus_size_id->EditCustomAttributes = "";
        $this->bus_size_id->PlaceHolder = RemoveHtml($this->bus_size_id->caption());

        // price_id
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
        $this->start_date->EditValue = FormatDateTime($this->start_date->CurrentValue, 8);
        $this->start_date->PlaceHolder = RemoveHtml($this->start_date->caption());

        // end_date
        $this->end_date->EditAttrs["class"] = "form-control";
        $this->end_date->EditCustomAttributes = 'readonly="readonly"';
        $this->end_date->EditValue = FormatDateTime($this->end_date->CurrentValue, 8);
        $this->end_date->PlaceHolder = RemoveHtml($this->end_date->caption());

        // user_id
        $this->user_id->EditAttrs["class"] = "form-control";
        $this->user_id->EditCustomAttributes = 'readonly="readonly"';
        if ($this->user_id->getSessionValue() != "") {
            $this->user_id->CurrentValue = GetForeignKeyValue($this->user_id->getSessionValue());
            $this->user_id->ViewValue = $this->user_id->CurrentValue;
            $this->user_id->ViewValue = FormatNumber($this->user_id->ViewValue, 0, -2, -2, -2);
            $this->user_id->ViewCustomAttributes = "";
        } else {
        }

        // vendor_id
        $this->vendor_id->EditAttrs["class"] = "form-control";
        $this->vendor_id->EditCustomAttributes = "";
        if ($this->vendor_id->getSessionValue() != "") {
            $this->vendor_id->CurrentValue = GetForeignKeyValue($this->vendor_id->getSessionValue());
            $curVal = strval($this->vendor_id->CurrentValue);
            if ($curVal != "") {
                $this->vendor_id->ViewValue = $this->vendor_id->lookupCacheOption($curVal);
                if ($this->vendor_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->vendor_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
        } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
            $this->vendor_id->CurrentValue = CurrentUserID();
            $curVal = strval($this->vendor_id->CurrentValue);
            if ($curVal != "") {
                $this->vendor_id->EditValue = $this->vendor_id->lookupCacheOption($curVal);
                if ($this->vendor_id->EditValue === null) { // Lookup from database
                    $filterWrk = "\"id\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->vendor_id->Lookup->getSql(false, $filterWrk, '', $this, true);
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
        } else {
            $this->vendor_id->PlaceHolder = RemoveHtml($this->vendor_id->caption());
        }

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

        // ts_last_update
        $this->ts_last_update->EditAttrs["class"] = "form-control";
        $this->ts_last_update->EditCustomAttributes = "";
        $this->ts_last_update->EditValue = FormatDateTime($this->ts_last_update->CurrentValue, 8);
        $this->ts_last_update->PlaceHolder = RemoveHtml($this->ts_last_update->caption());

        // ts_created
        $this->ts_created->EditAttrs["class"] = "form-control";
        $this->ts_created->EditCustomAttributes = "";
        $this->ts_created->EditValue = FormatDateTime($this->ts_created->CurrentValue, 8);
        $this->ts_created->PlaceHolder = RemoveHtml($this->ts_created->caption());

        // renewal_stage_id
        $this->renewal_stage_id->EditAttrs["class"] = "form-control";
        $this->renewal_stage_id->EditCustomAttributes = "";
        $this->renewal_stage_id->PlaceHolder = RemoveHtml($this->renewal_stage_id->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            if (is_numeric($this->quantity->CurrentValue)) {
                $this->quantity->Total += $this->quantity->CurrentValue; // Accumulate total
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
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->inventory_id);
                    $doc->exportCaption($this->platform_id);
                    $doc->exportCaption($this->bus_size_id);
                    $doc->exportCaption($this->price_id);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->start_date);
                    $doc->exportCaption($this->end_date);
                    $doc->exportCaption($this->user_id);
                    $doc->exportCaption($this->vendor_id);
                    $doc->exportCaption($this->status_id);
                    $doc->exportCaption($this->print_status_id);
                    $doc->exportCaption($this->payment_status_id);
                    $doc->exportCaption($this->ts_last_update);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->renewal_stage_id);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->inventory_id);
                    $doc->exportCaption($this->platform_id);
                    $doc->exportCaption($this->bus_size_id);
                    $doc->exportCaption($this->price_id);
                    $doc->exportCaption($this->quantity);
                    $doc->exportCaption($this->start_date);
                    $doc->exportCaption($this->end_date);
                    $doc->exportCaption($this->user_id);
                    $doc->exportCaption($this->vendor_id);
                    $doc->exportCaption($this->status_id);
                    $doc->exportCaption($this->print_status_id);
                    $doc->exportCaption($this->payment_status_id);
                    $doc->exportCaption($this->ts_last_update);
                    $doc->exportCaption($this->ts_created);
                    $doc->exportCaption($this->renewal_stage_id);
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
                        $doc->exportField($this->name);
                        $doc->exportField($this->inventory_id);
                        $doc->exportField($this->platform_id);
                        $doc->exportField($this->bus_size_id);
                        $doc->exportField($this->price_id);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->start_date);
                        $doc->exportField($this->end_date);
                        $doc->exportField($this->user_id);
                        $doc->exportField($this->vendor_id);
                        $doc->exportField($this->status_id);
                        $doc->exportField($this->print_status_id);
                        $doc->exportField($this->payment_status_id);
                        $doc->exportField($this->ts_last_update);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->renewal_stage_id);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->name);
                        $doc->exportField($this->inventory_id);
                        $doc->exportField($this->platform_id);
                        $doc->exportField($this->bus_size_id);
                        $doc->exportField($this->price_id);
                        $doc->exportField($this->quantity);
                        $doc->exportField($this->start_date);
                        $doc->exportField($this->end_date);
                        $doc->exportField($this->user_id);
                        $doc->exportField($this->vendor_id);
                        $doc->exportField($this->status_id);
                        $doc->exportField($this->print_status_id);
                        $doc->exportField($this->payment_status_id);
                        $doc->exportField($this->ts_last_update);
                        $doc->exportField($this->ts_created);
                        $doc->exportField($this->renewal_stage_id);
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
                $doc->exportAggregate($this->name, '');
                $doc->exportAggregate($this->inventory_id, '');
                $doc->exportAggregate($this->platform_id, '');
                $doc->exportAggregate($this->bus_size_id, '');
                $doc->exportAggregate($this->price_id, '');
                $doc->exportAggregate($this->quantity, 'TOTAL');
                $doc->exportAggregate($this->start_date, '');
                $doc->exportAggregate($this->end_date, '');
                $doc->exportAggregate($this->user_id, '');
                $doc->exportAggregate($this->vendor_id, '');
                $doc->exportAggregate($this->status_id, '');
                $doc->exportAggregate($this->print_status_id, '');
                $doc->exportAggregate($this->payment_status_id, '');
                $doc->exportAggregate($this->ts_last_update, '');
                $doc->exportAggregate($this->ts_created, '');
                $doc->exportAggregate($this->renewal_stage_id, '');
                $doc->endExportRow();
            }
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
        $this->userIDFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM \"main_campaigns\"";
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

    // Add master User ID filter
    public function addMasterUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "y_vendors") {
            $filterWrk = Container("y_vendors")->addUserIDFilter($filterWrk);
        }
        if ($currentMasterTable == "main_users") {
            $filterWrk = Container("main_users")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "y_vendors") {
            $mastertable = Container("y_vendors");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->vendor_id, $mastertable->id);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        if ($currentMasterTable == "main_users") {
            $mastertable = Container("main_users");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->user_id, $mastertable->id);
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
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew) {
    	/*
    	 require_once 'emailrun.php';
    	 $file = 'emailpeople.txt';
    	 $sql = "select value from core_settings where name = 'new_campaign';";
    	 $msg = ExecuteScalar($sql);
    	 $sql1 = "select u.email, u.name, username, v.name as vendor from users u, vendors v where u.vendor_id = v.id and vendor_id = (
    select vendor_id from users where username = '".CurrentUserName()."'
    )";
    	$rows = ExecuteRows($sql1);
    	foreach ($rows as $val) {
    		$email = $val['email'];
    		$vendor = $val['vendor'];
    		$details = <<<EOT
    <strong>Campaign Name</strong>: {$rsnew[name]} ({$vendor})<br />
    <strong>Email</strong>: {$email}<br />
    <strong>Start Date</strong>: {$rsnew[start_date]}<br />
    <strong>End Date</strong>: {$rsnew[end_date]}<br />
    <strong>Buses</strong>: {$rsnew[quantity]}<br />
    <strong>IP</strong>: {$_SERVER['REMOTE_ADDR']}<br />
    EOT;
    $msg = str_replace('[x_details]',$details,$msg);

    	 //CurrentUserName()

    	 //Vendor and email

    	 //Replace
    	 $subject = "New Exterior Campaign {$rsnew[name]} - ({$vendor})";
    	 $msgtxt = strip_tags($msg);
    	 $cmd = "sendTMmail(\"admin@transitmedia.com.ng\", \"$email\", \"$subject\", \"$msg\", \"$msgtxt\");";

    //file_put_contents($file, $msg, FILE_APPEND | LOCK_EX);
    //file_put_contents($file, date("Y-m-d H:i:s")."\n".CurrentUserName()."\n".$cmd, FILE_APPEND | LOCK_EX);
    	 sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt);
    	 }
    	 */
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew) {
    /*
    	//echo "Row Updated";
    	require_once 'emailrun.php';
    	$username = "Transit Media Vendor";
    	$email = "";
    	$msg = "";
    	$msgtxt = "";
    	$subject = "";
    	$camp_id = $rsold["id"];
    	$sql = "select name, quantity, start_date, end_date, (end_date::timestamp - start_date::timestamp) as duration, 
    to_char(
    (quantity * (select substring(value from '[0-9]+') from core_settings where name = 'exterior_campaign_price')::int ) 
    , 'N999,999,999,990'::text) as amount,
    (select value from core_settings where name = 'ext_account_details' ) as account_details,
    (select name from vendors v where v.id = vendor_id) as vendor
    from exterior_campaigns where id = {$camp_id};
    ";
    	$camp_details = ExecuteRow($sql);
    	$rows = ExecuteRows("select email from users where vendor_id = (select vendor_id from exterior_campaigns where id = " . $camp_id . ");");
    	foreach ($rows as $val) {
    		$email = $val['email'];
    		$vendor = $camp_details['vendor'];
    		$username = $vendor;
    		if ($rsold["status_id"] != 2 && $rsnew["status_id"] == 2) {
    //Campaign Approved
    			$msg = "Hello {$vendor},<br/><br/>Your Campaign Request has been <b>approved</b>.<br/><br/>";
    			$msg .= "Your request for " . $camp_details['quantity'] . " Buses (Exterior Campaign / Bus Wraps) [" . $camp_details['name'] . "] has been approved for " . $camp_details['duration'] . ". <br/><br/>Kindly make payment of " . $camp_details['amount'] . " to [" . $camp_details['account_details'] . "].
    <br/><br/>Please send payment notification once payment has been made to info@transitmedia.com.ng";
    			$msgtxt = "Hello {$vendor},\n\nYour Campaign Request has been approved.";
    			$msgtxt .= "Your request for " . $camp_details['quantity'] . " Buses (Exterior Campaign / Bus Wraps) [" . $camp_details['name'] . "] has been approved for " . $camp_details['duration'] . ". \n\nKindly make payment of " . $camp_details['amount'] . " to [" . $camp_details['account_details'] . "].
    \n\nPlease send payment notification once payment has been made to info@transitmedia.com.ng";
    			$subject = "APPROVED CAMPAIGN REQUEST ({$vendor}) - TRANSIT MEDIA ADMIN";
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt);
    		}
    		if ($rsold["status_id"] != 3 && $rsnew["status_id"] == 3) {
    //Campaign Denied
    			$msg = "Hello {$vendor},<br/>Unfortunately, Your Campaign Request has been <b>Denied</b>.";
    			$msgtxt = "Hello {$vendor},\nUnfortunately, Your Campaign Request has been Denied.";
    			$subject = "DENIED CAMPAIGN REQUEST ({$vendor}) - TRANSIT MEDIA ADMIN";
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt);
    		}
    		if ($rsold["print_status_id"] != 2 && $rsnew["print_status_id"] == 2) {
    //Print Approved
    			$msg = "Hello {$vendor},<br/>Your Print Request has been <b>Approved</b>.";
    			$msgtxt = "Hello {$vendor},\nYour Print Request has been Approved.";
    			$subject = "PRINT APPROVAL ({$vendor}) - TRANSIT MEDIA ADMIN";
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt);
    		}
    		if ($rsold["print_status_id"] != 3 && $rsnew["print_status_id"] == 3) {
    //Print Denied
    			$msg = "Hello {$vendor},<br/>Unfortunately, Your Print Request has been <b>Denied</b>.";
    			$msgtxt = "Hello {$vendor},\nUnfortunately, Your Print Request has been Denied.";
    			$subject = "PRINT REFUSAL ({$vendor}) - TRANSIT MEDIA ADMIN";
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt);
    		}
    		if ($rsold["payment_status_id"] != 2 && $rsnew["payment_status_id"] == 2) {
    //Payment Approved
    			$msg = "Hello {$vendor},<br/> Payment for your Campaign has been <b>Confirmed</b>. <br /><br />Your campaign is scheduled to start within 48hrs of your payment confirmation and print approval. <br /><br /><b>Note: Proof of posting would be sent to you once the buses have been branded</b>.";
    			$msgtxt = "Hello {$vendor},\nPayment for your Campaign has been Confirmed. \n\nYour campaign is scheduled to start within 48hrs of your payment confirmation and print approval. \n\n<b>Note: Proof of posting would be sent to you once the buses have been branded</b>.";
    			$subject = "PAYMENT CONFIRMATION ({$vendor}) - TRANSIT MEDIA ADMIN";
    			sendTMmail('admin@transitmedia.com.ng', $email, $subject, $msg, $msgtxt);
    		}
    	}
    	*/
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

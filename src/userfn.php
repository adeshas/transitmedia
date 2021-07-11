<?php

namespace PHPMaker2021\test;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions

// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    /*
{"id":4,"name":"mi_x_bus_sizes","text":"Bus Sizes","parentId":97,"level":2,"href":"/xbussizeslist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false}],"open":false}],"open":false},
{"id":10,"name":"mi_main_campaigns","text":"Manage Campaigns","parentId":32,"level":1,"href":"/maincampaignslist?cmd=resetall","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false}],"open":false},
{"id":13,"name":"mi_main_buses","text":"Buses","parentId":33,"level":1,"href":"/mainbuseslist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":15,"name":"mi_x_bus_status","text":"Bus Status","parentId":97,"level":2,"href":"/xbusstatuslist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":16,"name":"mi_x_bus_depot","text":"Bus Depot","parentId":97,"level":2,"href":"/xbusdepotlist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":32,"name":"mci_Campaigns","text":"Campaigns","parentId":-1,"level":0,"href":"#","attrs":" onclick=\"return false;\"","target":"","isHeader":false,"active":false,"icon":"fa-ad fas","label":"","isNavbarItem":false,"items":[
{"id":33,"name":"mci_Buses","text":"Buses","parentId":-1,"level":0,"href":"#","attrs":" onclick=\"return false;\"","target":"","isHeader":false,"active":false,"icon":"fa-bus fas","label":"","isNavbarItem":false,"items":[
{"id":34,"name":"mci_Reports","text":"Reports","parentId":-1,"level":0,"href":"#","attrs":" onclick=\"return false;\"","target":"","isHeader":false,"active":false,"icon":"fa-chart-pie fas","label":"","isNavbarItem":false,"items":[
{"id":56,"name":"mci_Settings","text":"Settings","parentId":-1,"level":0,"href":"#","attrs":" onclick=\"return false;\"","target":"","isHeader":false,"active":false,"icon":"fa-cog fas","label":"","isNavbarItem":false,"items":[
{"id":60,"name":"mi_main_reports","text":"Reports","parentId":34,"level":1,"href":"/mainreportslist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-chart-line fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":63,"name":"mi_main_transactions","text":"Manage Transactions","parentId":98,"level":1,"href":"/maintransactionslist?cmd=resetall","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":65,"name":"mi_sub_transaction_details","text":"Assigned Buses","parentId":98,"level":1,"href":"/subtransactiondetailslist?cmd=resetall","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":95,"name":"mci_Others","text":"Others","parentId":-1,"level":0,"href":"#","attrs":" onclick=\"return false;\"","target":"","isHeader":false,"active":false,"icon":"fa-adjust fas","label":"","isNavbarItem":false,"items":[
{"id":97,"name":"mci_Sub_Config","text":"Sub Config","parentId":56,"level":1,"href":"#","attrs":" onclick=\"return false;\"","target":"","isHeader":false,"active":false,"icon":"","label":"","isNavbarItem":false,"items":[
{"id":98,"name":"mci_Transactions","text":"Transactions","parentId":-1,"level":0,"href":"#","attrs":" onclick=\"return false;\"","target":"","isHeader":false,"active":false,"icon":"fa-search-dollar fas","label":"","isNavbarItem":false,"items":[
{"id":129,"name":"mci_Home","text":"Home","parentId":-1,"level":0,"href":"/welcome","attrs":"","target":"","isHeader":false,"active":false,"icon":"","label":"","isNavbarItem":true,"items":null,"open":false},
{"id":132,"name":"mci_Order_Buses","text":"Order Buses","parentId":-1,"level":0,"href":"/maincampaignsadd?showdetail=","attrs":"","target":"","isHeader":false,"active":false,"icon":"","label":"","isNavbarItem":true,"items":null,"open":false}],"accordion":true};
{"id":174,"name":"mci_New_Transaction","text":"New Transaction","parentId":98,"level":1,"href":"/maintransactionsadd","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":177,"name":"mi_view_buses_interior","text":"Buses (Interior)","parentId":33,"level":1,"href":"/viewbusesinteriorlist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":178,"name":"mi_view_buses_exterior","text":"Buses (Exterior)","parentId":33,"level":1,"href":"/viewbusesexteriorlist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":179,"name":"mi_view_bus_depot_summary","text":"Bus Depot Summary","parentId":34,"level":1,"href":"/viewbusdepotsummarylist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false}],"open":false},
{"id":180,"name":"mi_view_bus_int_summary_at_a_glance","text":"Bus Summary (Int)","parentId":34,"level":1,"href":"/viewbusintsummaryataglancelist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":181,"name":"mi_view_bus_ext_summary_at_a_glance","text":"Bus Summary (Ext)","parentId":34,"level":1,"href":"/viewbusextsummaryataglancelist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":182,"name":"mi_view_bus_summary","text":"Bus Summary","parentId":34,"level":1,"href":"/viewbussummarylist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":194,"name":"mi_w_vendors_operators","text":"Vendors/Operators","parentId":95,"level":1,"href":"/wvendorsoperatorslist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false}],"open":false},
{"id":195,"name":"mi_view_transactions_per_operator","text":"Payments (Operator)","parentId":98,"level":1,"href":"/viewtransactionsperoperatorlist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false}],"open":false},
{"id":197,"name":"mi_view_transactions_per_platform","text":"Payments (Platform)","parentId":98,"level":1,"href":"/viewtransactionsperplatformlist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":200,"name":"mi_y_printers","text":"Printers","parentId":95,"level":1,"href":"/yprinterslist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":201,"name":"mi_main_print_orders","text":"Print Orders","parentId":98,"level":1,"href":"/mainprintorderslist","attrs":"","target":"","isHeader":false,"active":false,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false},
{"id":203,"name":"mi_view_all_buses","text":"View All Buses","parentId":33,"level":1,"href":"/#","attrs":" onclick=\"return false;\"","target":"","isHeader":false,"active":true,"icon":"fa-angle-double-right fas","label":"","isNavbarItem":false,"items":null,"open":false}],"open":true},
    */
    //var_dump($item);
    // Return false if menu item not allowed

    // IF OPERATOR REMOVE SOME TOP MENU's
    if(CurrentUserLevel() == 5){
        if( in_array($item->id, [
        174, // New Transaction
        35,  // New Campaign
        133	 // Campaigns / Platform
        ])){
            return false;
        }
    }
    //IF PLATFORMREMOVE SOME
    if(CurrentUserLevel() == 6){
        if( in_array($item->id, [32, 132,129,174])){
            return false;
        }
    }

    // MANAGER
    if(CurrentUserLevel() >= 1 && CurrentUserLevel() <= 4 || CurrentUserLevel() == 7){
        if(CurrentUserLevel() >= 1 && CurrentUserLevel() <= 4){
            if( in_array($item->id, [195,197,198,133,201])){
                return false;
            }
        }
        if(CurrentUserLevel() == 1){
        	//CAMPAIGN MAN
            if( in_array($item->id, [201])){
            	//return false;
            }
        }
        if(CurrentUserLevel() == 2){
        	//ACCOUNTS MAN
        	if( in_array($item->id, [198,133,32,33,95,132,174])){
            	return false;
            }
        }
        if(CurrentUserLevel() == 3){
        	//FLEET MAN
        	if( in_array($item->id, [
        	177, //
        	178,
        	35, // New Campaign
        	98, // Transactions
        	//34, // Reports
        	95, // Others
        	//56, // Settings
        	133, // Campaigns / Platform
        	203 //view_all_buses
        	])){
            	return false;
            }
        }
        if(CurrentUserLevel() == 4){
        	//REPORT MAN
        	if( in_array($item->id, [35,33,98])){
            	return false;
            }
        }
        if(CurrentUserLevel() == 7){
        	//PRINT MAN
        	if( in_array($item->id, [20,35,33,174,35,133])){
            	return false;
            }
        }
    }

    // 32, -> 35 133
    //98 -> 174

    // MAIN USER
    if(CurrentUserLevel() == 0){
        if( in_array($item->id, [174,95])){
            return false;
        }
    }
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

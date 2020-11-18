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
    //var_dump($item);
    // Return false if menu item not allowed

    // IF OPERATOR REMOVE SOME TOP MENU's
    if(CurrentUserLevel() == 5){
        if( in_array($item->id, [174, 35,133])){
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
                //return false;
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
        	if( in_array($item->id, [198,133])){
            	return false;
            }
        }
        if(CurrentUserLevel() == 3){
        	//FLEET MAN
        	if( in_array($item->id, [177,178,35,98,34,95,56])){
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

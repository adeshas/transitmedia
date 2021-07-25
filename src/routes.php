<?php

namespace PHPMaker2021\test;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // main_buses
    $app->any('/mainbuseslist[/{id}]', MainBusesController::class . ':list')->add(PermissionMiddleware::class)->setName('mainbuseslist-main_buses-list'); // list
    $app->any('/mainbusesadd[/{id}]', MainBusesController::class . ':add')->add(PermissionMiddleware::class)->setName('mainbusesadd-main_buses-add'); // add
    $app->any('/mainbusesview[/{id}]', MainBusesController::class . ':view')->add(PermissionMiddleware::class)->setName('mainbusesview-main_buses-view'); // view
    $app->any('/mainbusesedit[/{id}]', MainBusesController::class . ':edit')->add(PermissionMiddleware::class)->setName('mainbusesedit-main_buses-edit'); // edit
    $app->any('/mainbusesupdate', MainBusesController::class . ':update')->add(PermissionMiddleware::class)->setName('mainbusesupdate-main_buses-update'); // update
    $app->any('/mainbusesdelete[/{id}]', MainBusesController::class . ':delete')->add(PermissionMiddleware::class)->setName('mainbusesdelete-main_buses-delete'); // delete
    $app->group(
        '/main_buses',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MainBusesController::class . ':list')->add(PermissionMiddleware::class)->setName('main_buses/list-main_buses-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MainBusesController::class . ':add')->add(PermissionMiddleware::class)->setName('main_buses/add-main_buses-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MainBusesController::class . ':view')->add(PermissionMiddleware::class)->setName('main_buses/view-main_buses-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MainBusesController::class . ':edit')->add(PermissionMiddleware::class)->setName('main_buses/edit-main_buses-edit-2'); // edit
            $group->any('/' . Config("UPDATE_ACTION") . '', MainBusesController::class . ':update')->add(PermissionMiddleware::class)->setName('main_buses/update-main_buses-update-2'); // update
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MainBusesController::class . ':delete')->add(PermissionMiddleware::class)->setName('main_buses/delete-main_buses-delete-2'); // delete
        }
    );

    // main_campaigns
    $app->any('/maincampaignslist[/{id}]', MainCampaignsController::class . ':list')->add(PermissionMiddleware::class)->setName('maincampaignslist-main_campaigns-list'); // list
    $app->any('/maincampaignsadd[/{id}]', MainCampaignsController::class . ':add')->add(PermissionMiddleware::class)->setName('maincampaignsadd-main_campaigns-add'); // add
    $app->any('/maincampaignsview[/{id}]', MainCampaignsController::class . ':view')->add(PermissionMiddleware::class)->setName('maincampaignsview-main_campaigns-view'); // view
    $app->any('/maincampaignsedit[/{id}]', MainCampaignsController::class . ':edit')->add(PermissionMiddleware::class)->setName('maincampaignsedit-main_campaigns-edit'); // edit
    $app->any('/maincampaignsdelete[/{id}]', MainCampaignsController::class . ':delete')->add(PermissionMiddleware::class)->setName('maincampaignsdelete-main_campaigns-delete'); // delete
    $app->group(
        '/main_campaigns',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MainCampaignsController::class . ':list')->add(PermissionMiddleware::class)->setName('main_campaigns/list-main_campaigns-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MainCampaignsController::class . ':add')->add(PermissionMiddleware::class)->setName('main_campaigns/add-main_campaigns-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MainCampaignsController::class . ':view')->add(PermissionMiddleware::class)->setName('main_campaigns/view-main_campaigns-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MainCampaignsController::class . ':edit')->add(PermissionMiddleware::class)->setName('main_campaigns/edit-main_campaigns-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MainCampaignsController::class . ':delete')->add(PermissionMiddleware::class)->setName('main_campaigns/delete-main_campaigns-delete-2'); // delete
        }
    );

    // main_reports
    $app->any('/mainreportslist[/{id}]', MainReportsController::class . ':list')->add(PermissionMiddleware::class)->setName('mainreportslist-main_reports-list'); // list
    $app->any('/mainreportsadd[/{id}]', MainReportsController::class . ':add')->add(PermissionMiddleware::class)->setName('mainreportsadd-main_reports-add'); // add
    $app->any('/mainreportsview[/{id}]', MainReportsController::class . ':view')->add(PermissionMiddleware::class)->setName('mainreportsview-main_reports-view'); // view
    $app->any('/mainreportsedit[/{id}]', MainReportsController::class . ':edit')->add(PermissionMiddleware::class)->setName('mainreportsedit-main_reports-edit'); // edit
    $app->any('/mainreportsdelete[/{id}]', MainReportsController::class . ':delete')->add(PermissionMiddleware::class)->setName('mainreportsdelete-main_reports-delete'); // delete
    $app->group(
        '/main_reports',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MainReportsController::class . ':list')->add(PermissionMiddleware::class)->setName('main_reports/list-main_reports-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MainReportsController::class . ':add')->add(PermissionMiddleware::class)->setName('main_reports/add-main_reports-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MainReportsController::class . ':view')->add(PermissionMiddleware::class)->setName('main_reports/view-main_reports-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MainReportsController::class . ':edit')->add(PermissionMiddleware::class)->setName('main_reports/edit-main_reports-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MainReportsController::class . ':delete')->add(PermissionMiddleware::class)->setName('main_reports/delete-main_reports-delete-2'); // delete
        }
    );

    // main_transactions
    $app->any('/maintransactionslist[/{id}]', MainTransactionsController::class . ':list')->add(PermissionMiddleware::class)->setName('maintransactionslist-main_transactions-list'); // list
    $app->any('/maintransactionsadd[/{id}]', MainTransactionsController::class . ':add')->add(PermissionMiddleware::class)->setName('maintransactionsadd-main_transactions-add'); // add
    $app->any('/maintransactionsview[/{id}]', MainTransactionsController::class . ':view')->add(PermissionMiddleware::class)->setName('maintransactionsview-main_transactions-view'); // view
    $app->any('/maintransactionsedit[/{id}]', MainTransactionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('maintransactionsedit-main_transactions-edit'); // edit
    $app->any('/maintransactionsupdate', MainTransactionsController::class . ':update')->add(PermissionMiddleware::class)->setName('maintransactionsupdate-main_transactions-update'); // update
    $app->any('/maintransactionsdelete[/{id}]', MainTransactionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('maintransactionsdelete-main_transactions-delete'); // delete
    $app->any('/maintransactionssearch', MainTransactionsController::class . ':search')->add(PermissionMiddleware::class)->setName('maintransactionssearch-main_transactions-search'); // search
    $app->group(
        '/main_transactions',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MainTransactionsController::class . ':list')->add(PermissionMiddleware::class)->setName('main_transactions/list-main_transactions-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MainTransactionsController::class . ':add')->add(PermissionMiddleware::class)->setName('main_transactions/add-main_transactions-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MainTransactionsController::class . ':view')->add(PermissionMiddleware::class)->setName('main_transactions/view-main_transactions-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MainTransactionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('main_transactions/edit-main_transactions-edit-2'); // edit
            $group->any('/' . Config("UPDATE_ACTION") . '', MainTransactionsController::class . ':update')->add(PermissionMiddleware::class)->setName('main_transactions/update-main_transactions-update-2'); // update
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MainTransactionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('main_transactions/delete-main_transactions-delete-2'); // delete
            $group->any('/' . Config("SEARCH_ACTION") . '', MainTransactionsController::class . ':search')->add(PermissionMiddleware::class)->setName('main_transactions/search-main_transactions-search-2'); // search
        }
    );

    // main_users
    $app->any('/mainuserslist[/{id}]', MainUsersController::class . ':list')->add(PermissionMiddleware::class)->setName('mainuserslist-main_users-list'); // list
    $app->any('/mainusersadd[/{id}]', MainUsersController::class . ':add')->add(PermissionMiddleware::class)->setName('mainusersadd-main_users-add'); // add
    $app->any('/mainusersview[/{id}]', MainUsersController::class . ':view')->add(PermissionMiddleware::class)->setName('mainusersview-main_users-view'); // view
    $app->any('/mainusersedit[/{id}]', MainUsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('mainusersedit-main_users-edit'); // edit
    $app->any('/mainusersupdate', MainUsersController::class . ':update')->add(PermissionMiddleware::class)->setName('mainusersupdate-main_users-update'); // update
    $app->any('/mainusersdelete[/{id}]', MainUsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('mainusersdelete-main_users-delete'); // delete
    $app->group(
        '/main_users',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MainUsersController::class . ':list')->add(PermissionMiddleware::class)->setName('main_users/list-main_users-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MainUsersController::class . ':add')->add(PermissionMiddleware::class)->setName('main_users/add-main_users-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MainUsersController::class . ':view')->add(PermissionMiddleware::class)->setName('main_users/view-main_users-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MainUsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('main_users/edit-main_users-edit-2'); // edit
            $group->any('/' . Config("UPDATE_ACTION") . '', MainUsersController::class . ':update')->add(PermissionMiddleware::class)->setName('main_users/update-main_users-update-2'); // update
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MainUsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('main_users/delete-main_users-delete-2'); // delete
        }
    );

    // spook
    $app->any('/spook[/{params:.*}]', SpookController::class)->add(PermissionMiddleware::class)->setName('spook-spook-custom'); // custom

    // main_print_orders
    $app->any('/mainprintorderslist[/{id}]', MainPrintOrdersController::class . ':list')->add(PermissionMiddleware::class)->setName('mainprintorderslist-main_print_orders-list'); // list
    $app->any('/mainprintordersadd[/{id}]', MainPrintOrdersController::class . ':add')->add(PermissionMiddleware::class)->setName('mainprintordersadd-main_print_orders-add'); // add
    $app->any('/mainprintordersview[/{id}]', MainPrintOrdersController::class . ':view')->add(PermissionMiddleware::class)->setName('mainprintordersview-main_print_orders-view'); // view
    $app->any('/mainprintordersedit[/{id}]', MainPrintOrdersController::class . ':edit')->add(PermissionMiddleware::class)->setName('mainprintordersedit-main_print_orders-edit'); // edit
    $app->any('/mainprintordersdelete[/{id}]', MainPrintOrdersController::class . ':delete')->add(PermissionMiddleware::class)->setName('mainprintordersdelete-main_print_orders-delete'); // delete
    $app->group(
        '/main_print_orders',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MainPrintOrdersController::class . ':list')->add(PermissionMiddleware::class)->setName('main_print_orders/list-main_print_orders-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MainPrintOrdersController::class . ':add')->add(PermissionMiddleware::class)->setName('main_print_orders/add-main_print_orders-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MainPrintOrdersController::class . ':view')->add(PermissionMiddleware::class)->setName('main_print_orders/view-main_print_orders-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MainPrintOrdersController::class . ':edit')->add(PermissionMiddleware::class)->setName('main_print_orders/edit-main_print_orders-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MainPrintOrdersController::class . ':delete')->add(PermissionMiddleware::class)->setName('main_print_orders/delete-main_print_orders-delete-2'); // delete
        }
    );

    // sub_media_allocation
    $app->any('/submediaallocationlist[/{id}]', SubMediaAllocationController::class . ':list')->add(PermissionMiddleware::class)->setName('submediaallocationlist-sub_media_allocation-list'); // list
    $app->any('/submediaallocationadd[/{id}]', SubMediaAllocationController::class . ':add')->add(PermissionMiddleware::class)->setName('submediaallocationadd-sub_media_allocation-add'); // add
    $app->any('/submediaallocationview[/{id}]', SubMediaAllocationController::class . ':view')->add(PermissionMiddleware::class)->setName('submediaallocationview-sub_media_allocation-view'); // view
    $app->any('/submediaallocationupdate', SubMediaAllocationController::class . ':update')->add(PermissionMiddleware::class)->setName('submediaallocationupdate-sub_media_allocation-update'); // update
    $app->group(
        '/sub_media_allocation',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SubMediaAllocationController::class . ':list')->add(PermissionMiddleware::class)->setName('sub_media_allocation/list-sub_media_allocation-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SubMediaAllocationController::class . ':add')->add(PermissionMiddleware::class)->setName('sub_media_allocation/add-sub_media_allocation-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SubMediaAllocationController::class . ':view')->add(PermissionMiddleware::class)->setName('sub_media_allocation/view-sub_media_allocation-view-2'); // view
            $group->any('/' . Config("UPDATE_ACTION") . '', SubMediaAllocationController::class . ':update')->add(PermissionMiddleware::class)->setName('sub_media_allocation/update-sub_media_allocation-update-2'); // update
        }
    );

    // sub_renewal_requests
    $app->any('/subrenewalrequestslist[/{id}]', SubRenewalRequestsController::class . ':list')->add(PermissionMiddleware::class)->setName('subrenewalrequestslist-sub_renewal_requests-list'); // list
    $app->any('/subrenewalrequestsadd[/{id}]', SubRenewalRequestsController::class . ':add')->add(PermissionMiddleware::class)->setName('subrenewalrequestsadd-sub_renewal_requests-add'); // add
    $app->any('/subrenewalrequestsview[/{id}]', SubRenewalRequestsController::class . ':view')->add(PermissionMiddleware::class)->setName('subrenewalrequestsview-sub_renewal_requests-view'); // view
    $app->any('/subrenewalrequestsedit[/{id}]', SubRenewalRequestsController::class . ':edit')->add(PermissionMiddleware::class)->setName('subrenewalrequestsedit-sub_renewal_requests-edit'); // edit
    $app->any('/subrenewalrequestsdelete[/{id}]', SubRenewalRequestsController::class . ':delete')->add(PermissionMiddleware::class)->setName('subrenewalrequestsdelete-sub_renewal_requests-delete'); // delete
    $app->group(
        '/sub_renewal_requests',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SubRenewalRequestsController::class . ':list')->add(PermissionMiddleware::class)->setName('sub_renewal_requests/list-sub_renewal_requests-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SubRenewalRequestsController::class . ':add')->add(PermissionMiddleware::class)->setName('sub_renewal_requests/add-sub_renewal_requests-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SubRenewalRequestsController::class . ':view')->add(PermissionMiddleware::class)->setName('sub_renewal_requests/view-sub_renewal_requests-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SubRenewalRequestsController::class . ':edit')->add(PermissionMiddleware::class)->setName('sub_renewal_requests/edit-sub_renewal_requests-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SubRenewalRequestsController::class . ':delete')->add(PermissionMiddleware::class)->setName('sub_renewal_requests/delete-sub_renewal_requests-delete-2'); // delete
        }
    );

    // view_pricing_initial
    $app->any('/viewpricinginitiallist', ViewPricingInitialController::class . ':list')->add(PermissionMiddleware::class)->setName('viewpricinginitiallist-view_pricing_initial-list'); // list
    $app->group(
        '/view_pricing_initial',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewPricingInitialController::class . ':list')->add(PermissionMiddleware::class)->setName('view_pricing_initial/list-view_pricing_initial-list-2'); // list
        }
    );

    // welcome
    $app->any('/welcome[/{params:.*}]', WelcomeController::class)->add(PermissionMiddleware::class)->setName('welcome-welcome-custom'); // custom

    // sub_transaction_details
    $app->any('/subtransactiondetailslist[/{id}]', SubTransactionDetailsController::class . ':list')->add(PermissionMiddleware::class)->setName('subtransactiondetailslist-sub_transaction_details-list'); // list
    $app->any('/subtransactiondetailsadd[/{id}]', SubTransactionDetailsController::class . ':add')->add(PermissionMiddleware::class)->setName('subtransactiondetailsadd-sub_transaction_details-add'); // add
    $app->any('/subtransactiondetailsview[/{id}]', SubTransactionDetailsController::class . ':view')->add(PermissionMiddleware::class)->setName('subtransactiondetailsview-sub_transaction_details-view'); // view
    $app->any('/subtransactiondetailsedit[/{id}]', SubTransactionDetailsController::class . ':edit')->add(PermissionMiddleware::class)->setName('subtransactiondetailsedit-sub_transaction_details-edit'); // edit
    $app->any('/subtransactiondetailsdelete[/{id}]', SubTransactionDetailsController::class . ':delete')->add(PermissionMiddleware::class)->setName('subtransactiondetailsdelete-sub_transaction_details-delete'); // delete
    $app->group(
        '/sub_transaction_details',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SubTransactionDetailsController::class . ':list')->add(PermissionMiddleware::class)->setName('sub_transaction_details/list-sub_transaction_details-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SubTransactionDetailsController::class . ':add')->add(PermissionMiddleware::class)->setName('sub_transaction_details/add-sub_transaction_details-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SubTransactionDetailsController::class . ':view')->add(PermissionMiddleware::class)->setName('sub_transaction_details/view-sub_transaction_details-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SubTransactionDetailsController::class . ':edit')->add(PermissionMiddleware::class)->setName('sub_transaction_details/edit-sub_transaction_details-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SubTransactionDetailsController::class . ':delete')->add(PermissionMiddleware::class)->setName('sub_transaction_details/delete-sub_transaction_details-delete-2'); // delete
        }
    );

    // x_bus_depot
    $app->any('/xbusdepotlist[/{id}]', XBusDepotController::class . ':list')->add(PermissionMiddleware::class)->setName('xbusdepotlist-x_bus_depot-list'); // list
    $app->any('/xbusdepotview[/{id}]', XBusDepotController::class . ':view')->add(PermissionMiddleware::class)->setName('xbusdepotview-x_bus_depot-view'); // view
    $app->group(
        '/x_bus_depot',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XBusDepotController::class . ':list')->add(PermissionMiddleware::class)->setName('x_bus_depot/list-x_bus_depot-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XBusDepotController::class . ':view')->add(PermissionMiddleware::class)->setName('x_bus_depot/view-x_bus_depot-view-2'); // view
        }
    );

    // x_bus_sizes
    $app->any('/xbussizeslist[/{id}]', XBusSizesController::class . ':list')->add(PermissionMiddleware::class)->setName('xbussizeslist-x_bus_sizes-list'); // list
    $app->any('/xbussizesview[/{id}]', XBusSizesController::class . ':view')->add(PermissionMiddleware::class)->setName('xbussizesview-x_bus_sizes-view'); // view
    $app->group(
        '/x_bus_sizes',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XBusSizesController::class . ':list')->add(PermissionMiddleware::class)->setName('x_bus_sizes/list-x_bus_sizes-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XBusSizesController::class . ':view')->add(PermissionMiddleware::class)->setName('x_bus_sizes/view-x_bus_sizes-view-2'); // view
        }
    );

    // x_bus_status
    $app->any('/xbusstatuslist[/{id}]', XBusStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('xbusstatuslist-x_bus_status-list'); // list
    $app->any('/xbusstatusview[/{id}]', XBusStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('xbusstatusview-x_bus_status-view'); // view
    $app->group(
        '/x_bus_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XBusStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('x_bus_status/list-x_bus_status-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XBusStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('x_bus_status/view-x_bus_status-view-2'); // view
        }
    );

    // x_transaction_status
    $app->any('/xtransactionstatuslist[/{id}]', XTransactionStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('xtransactionstatuslist-x_transaction_status-list'); // list
    $app->any('/xtransactionstatusadd[/{id}]', XTransactionStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('xtransactionstatusadd-x_transaction_status-add'); // add
    $app->any('/xtransactionstatusview[/{id}]', XTransactionStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('xtransactionstatusview-x_transaction_status-view'); // view
    $app->any('/xtransactionstatusedit[/{id}]', XTransactionStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('xtransactionstatusedit-x_transaction_status-edit'); // edit
    $app->any('/xtransactionstatusdelete[/{id}]', XTransactionStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('xtransactionstatusdelete-x_transaction_status-delete'); // delete
    $app->group(
        '/x_transaction_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XTransactionStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('x_transaction_status/list-x_transaction_status-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', XTransactionStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('x_transaction_status/add-x_transaction_status-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XTransactionStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('x_transaction_status/view-x_transaction_status-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', XTransactionStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('x_transaction_status/edit-x_transaction_status-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', XTransactionStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('x_transaction_status/delete-x_transaction_status-delete-2'); // delete
        }
    );

    // x_payment_status
    $app->any('/xpaymentstatuslist[/{id}]', XPaymentStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('xpaymentstatuslist-x_payment_status-list'); // list
    $app->any('/xpaymentstatusview[/{id}]', XPaymentStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('xpaymentstatusview-x_payment_status-view'); // view
    $app->group(
        '/x_payment_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XPaymentStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('x_payment_status/list-x_payment_status-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XPaymentStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('x_payment_status/view-x_payment_status-view-2'); // view
        }
    );

    // x_print_stage
    $app->any('/xprintstagelist[/{id}]', XPrintStageController::class . ':list')->add(PermissionMiddleware::class)->setName('xprintstagelist-x_print_stage-list'); // list
    $app->any('/xprintstageview[/{id}]', XPrintStageController::class . ':view')->add(PermissionMiddleware::class)->setName('xprintstageview-x_print_stage-view'); // view
    $app->group(
        '/x_print_stage',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XPrintStageController::class . ':list')->add(PermissionMiddleware::class)->setName('x_print_stage/list-x_print_stage-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XPrintStageController::class . ':view')->add(PermissionMiddleware::class)->setName('x_print_stage/view-x_print_stage-view-2'); // view
        }
    );

    // x_print_status
    $app->any('/xprintstatuslist[/{id}]', XPrintStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('xprintstatuslist-x_print_status-list'); // list
    $app->any('/xprintstatusview[/{id}]', XPrintStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('xprintstatusview-x_print_status-view'); // view
    $app->group(
        '/x_print_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XPrintStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('x_print_status/list-x_print_status-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XPrintStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('x_print_status/view-x_print_status-view-2'); // view
        }
    );

    // x_renewal_stage
    $app->any('/xrenewalstagelist[/{id}]', XRenewalStageController::class . ':list')->add(PermissionMiddleware::class)->setName('xrenewalstagelist-x_renewal_stage-list'); // list
    $app->any('/xrenewalstageadd[/{id}]', XRenewalStageController::class . ':add')->add(PermissionMiddleware::class)->setName('xrenewalstageadd-x_renewal_stage-add'); // add
    $app->any('/xrenewalstageedit[/{id}]', XRenewalStageController::class . ':edit')->add(PermissionMiddleware::class)->setName('xrenewalstageedit-x_renewal_stage-edit'); // edit
    $app->any('/xrenewalstagedelete[/{id}]', XRenewalStageController::class . ':delete')->add(PermissionMiddleware::class)->setName('xrenewalstagedelete-x_renewal_stage-delete'); // delete
    $app->group(
        '/x_renewal_stage',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XRenewalStageController::class . ':list')->add(PermissionMiddleware::class)->setName('x_renewal_stage/list-x_renewal_stage-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', XRenewalStageController::class . ':add')->add(PermissionMiddleware::class)->setName('x_renewal_stage/add-x_renewal_stage-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', XRenewalStageController::class . ':edit')->add(PermissionMiddleware::class)->setName('x_renewal_stage/edit-x_renewal_stage-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', XRenewalStageController::class . ':delete')->add(PermissionMiddleware::class)->setName('x_renewal_stage/delete-x_renewal_stage-delete-2'); // delete
        }
    );

    // x_report_types
    $app->any('/xreporttypeslist[/{id}]', XReportTypesController::class . ':list')->add(PermissionMiddleware::class)->setName('xreporttypeslist-x_report_types-list'); // list
    $app->group(
        '/x_report_types',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XReportTypesController::class . ':list')->add(PermissionMiddleware::class)->setName('x_report_types/list-x_report_types-list-2'); // list
        }
    );

    // x_user_types
    $app->any('/xusertypeslist[/{id}]', XUserTypesController::class . ':list')->add(PermissionMiddleware::class)->setName('xusertypeslist-x_user_types-list'); // list
    $app->any('/xusertypesadd[/{id}]', XUserTypesController::class . ':add')->add(PermissionMiddleware::class)->setName('xusertypesadd-x_user_types-add'); // add
    $app->any('/xusertypesedit[/{id}]', XUserTypesController::class . ':edit')->add(PermissionMiddleware::class)->setName('xusertypesedit-x_user_types-edit'); // edit
    $app->any('/xusertypesdelete[/{id}]', XUserTypesController::class . ':delete')->add(PermissionMiddleware::class)->setName('xusertypesdelete-x_user_types-delete'); // delete
    $app->group(
        '/x_user_types',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XUserTypesController::class . ':list')->add(PermissionMiddleware::class)->setName('x_user_types/list-x_user_types-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', XUserTypesController::class . ':add')->add(PermissionMiddleware::class)->setName('x_user_types/add-x_user_types-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', XUserTypesController::class . ':edit')->add(PermissionMiddleware::class)->setName('x_user_types/edit-x_user_types-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', XUserTypesController::class . ':delete')->add(PermissionMiddleware::class)->setName('x_user_types/delete-x_user_types-delete-2'); // delete
        }
    );

    // y_inventory
    $app->any('/yinventorylist[/{id}]', YInventoryController::class . ':list')->add(PermissionMiddleware::class)->setName('yinventorylist-y_inventory-list'); // list
    $app->any('/yinventoryview[/{id}]', YInventoryController::class . ':view')->add(PermissionMiddleware::class)->setName('yinventoryview-y_inventory-view'); // view
    $app->group(
        '/y_inventory',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', YInventoryController::class . ':list')->add(PermissionMiddleware::class)->setName('y_inventory/list-y_inventory-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', YInventoryController::class . ':view')->add(PermissionMiddleware::class)->setName('y_inventory/view-y_inventory-view-2'); // view
        }
    );

    // y_operators
    $app->any('/yoperatorslist[/{id}]', YOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('yoperatorslist-y_operators-list'); // list
    $app->any('/yoperatorsadd[/{id}]', YOperatorsController::class . ':add')->add(PermissionMiddleware::class)->setName('yoperatorsadd-y_operators-add'); // add
    $app->any('/yoperatorsview[/{id}]', YOperatorsController::class . ':view')->add(PermissionMiddleware::class)->setName('yoperatorsview-y_operators-view'); // view
    $app->any('/yoperatorsedit[/{id}]', YOperatorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('yoperatorsedit-y_operators-edit'); // edit
    $app->any('/yoperatorsupdate', YOperatorsController::class . ':update')->add(PermissionMiddleware::class)->setName('yoperatorsupdate-y_operators-update'); // update
    $app->any('/yoperatorsdelete[/{id}]', YOperatorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('yoperatorsdelete-y_operators-delete'); // delete
    $app->group(
        '/y_operators',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', YOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('y_operators/list-y_operators-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', YOperatorsController::class . ':add')->add(PermissionMiddleware::class)->setName('y_operators/add-y_operators-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', YOperatorsController::class . ':view')->add(PermissionMiddleware::class)->setName('y_operators/view-y_operators-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', YOperatorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('y_operators/edit-y_operators-edit-2'); // edit
            $group->any('/' . Config("UPDATE_ACTION") . '', YOperatorsController::class . ':update')->add(PermissionMiddleware::class)->setName('y_operators/update-y_operators-update-2'); // update
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', YOperatorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('y_operators/delete-y_operators-delete-2'); // delete
        }
    );

    // y_printers
    $app->any('/yprinterslist[/{id}]', YPrintersController::class . ':list')->add(PermissionMiddleware::class)->setName('yprinterslist-y_printers-list'); // list
    $app->any('/yprintersadd[/{id}]', YPrintersController::class . ':add')->add(PermissionMiddleware::class)->setName('yprintersadd-y_printers-add'); // add
    $app->any('/yprintersview[/{id}]', YPrintersController::class . ':view')->add(PermissionMiddleware::class)->setName('yprintersview-y_printers-view'); // view
    $app->any('/yprintersedit[/{id}]', YPrintersController::class . ':edit')->add(PermissionMiddleware::class)->setName('yprintersedit-y_printers-edit'); // edit
    $app->any('/yprintersdelete[/{id}]', YPrintersController::class . ':delete')->add(PermissionMiddleware::class)->setName('yprintersdelete-y_printers-delete'); // delete
    $app->group(
        '/y_printers',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', YPrintersController::class . ':list')->add(PermissionMiddleware::class)->setName('y_printers/list-y_printers-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', YPrintersController::class . ':add')->add(PermissionMiddleware::class)->setName('y_printers/add-y_printers-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', YPrintersController::class . ':view')->add(PermissionMiddleware::class)->setName('y_printers/view-y_printers-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', YPrintersController::class . ':edit')->add(PermissionMiddleware::class)->setName('y_printers/edit-y_printers-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', YPrintersController::class . ':delete')->add(PermissionMiddleware::class)->setName('y_printers/delete-y_printers-delete-2'); // delete
        }
    );

    // y_platforms
    $app->any('/yplatformslist[/{id}]', YPlatformsController::class . ':list')->add(PermissionMiddleware::class)->setName('yplatformslist-y_platforms-list'); // list
    $app->any('/yplatformsadd[/{id}]', YPlatformsController::class . ':add')->add(PermissionMiddleware::class)->setName('yplatformsadd-y_platforms-add'); // add
    $app->any('/yplatformsview[/{id}]', YPlatformsController::class . ':view')->add(PermissionMiddleware::class)->setName('yplatformsview-y_platforms-view'); // view
    $app->any('/yplatformsedit[/{id}]', YPlatformsController::class . ':edit')->add(PermissionMiddleware::class)->setName('yplatformsedit-y_platforms-edit'); // edit
    $app->any('/yplatformsdelete[/{id}]', YPlatformsController::class . ':delete')->add(PermissionMiddleware::class)->setName('yplatformsdelete-y_platforms-delete'); // delete
    $app->group(
        '/y_platforms',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', YPlatformsController::class . ':list')->add(PermissionMiddleware::class)->setName('y_platforms/list-y_platforms-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', YPlatformsController::class . ':add')->add(PermissionMiddleware::class)->setName('y_platforms/add-y_platforms-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', YPlatformsController::class . ':view')->add(PermissionMiddleware::class)->setName('y_platforms/view-y_platforms-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', YPlatformsController::class . ':edit')->add(PermissionMiddleware::class)->setName('y_platforms/edit-y_platforms-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', YPlatformsController::class . ':delete')->add(PermissionMiddleware::class)->setName('y_platforms/delete-y_platforms-delete-2'); // delete
        }
    );

    // y_vendors
    $app->any('/yvendorslist[/{id}]', YVendorsController::class . ':list')->add(PermissionMiddleware::class)->setName('yvendorslist-y_vendors-list'); // list
    $app->any('/yvendorsadd[/{id}]', YVendorsController::class . ':add')->add(PermissionMiddleware::class)->setName('yvendorsadd-y_vendors-add'); // add
    $app->any('/yvendorsedit[/{id}]', YVendorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('yvendorsedit-y_vendors-edit'); // edit
    $app->any('/yvendorsdelete[/{id}]', YVendorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('yvendorsdelete-y_vendors-delete'); // delete
    $app->group(
        '/y_vendors',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', YVendorsController::class . ':list')->add(PermissionMiddleware::class)->setName('y_vendors/list-y_vendors-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', YVendorsController::class . ':add')->add(PermissionMiddleware::class)->setName('y_vendors/add-y_vendors-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', YVendorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('y_vendors/edit-y_vendors-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', YVendorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('y_vendors/delete-y_vendors-delete-2'); // delete
        }
    );

    // z_core_settings
    $app->any('/zcoresettingslist[/{id}]', ZCoreSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('zcoresettingslist-z_core_settings-list'); // list
    $app->any('/zcoresettingsadd[/{id}]', ZCoreSettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('zcoresettingsadd-z_core_settings-add'); // add
    $app->any('/zcoresettingsedit[/{id}]', ZCoreSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('zcoresettingsedit-z_core_settings-edit'); // edit
    $app->group(
        '/z_core_settings',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ZCoreSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('z_core_settings/list-z_core_settings-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ZCoreSettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('z_core_settings/add-z_core_settings-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ZCoreSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('z_core_settings/edit-z_core_settings-edit-2'); // edit
        }
    );

    // view_pricing_all
    $app->any('/viewpricingalllist', ViewPricingAllController::class . ':list')->add(PermissionMiddleware::class)->setName('viewpricingalllist-view_pricing_all-list'); // list
    $app->group(
        '/view_pricing_all',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewPricingAllController::class . ':list')->add(PermissionMiddleware::class)->setName('view_pricing_all/list-view_pricing_all-list-2'); // list
        }
    );

    // view_operators_platforms
    $app->any('/viewoperatorsplatformslist', ViewOperatorsPlatformsController::class . ':list')->add(PermissionMiddleware::class)->setName('viewoperatorsplatformslist-view_operators_platforms-list'); // list
    $app->group(
        '/view_operators_platforms',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewOperatorsPlatformsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_operators_platforms/list-view_operators_platforms-list-2'); // list
        }
    );

    // view_pricing_options
    $app->any('/viewpricingoptionslist', ViewPricingOptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('viewpricingoptionslist-view_pricing_options-list'); // list
    $app->group(
        '/view_pricing_options',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewPricingOptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_pricing_options/list-view_pricing_options-list-2'); // list
        }
    );

    // view_bus_trans_options
    $app->any('/viewbustransoptionslist', ViewBusTransOptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('viewbustransoptionslist-view_bus_trans_options-list'); // list
    $app->group(
        '/view_bus_trans_options',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusTransOptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_trans_options/list-view_bus_trans_options-list-2'); // list
        }
    );

    // view_buses_interior
    $app->any('/viewbusesinteriorlist', ViewBusesInteriorController::class . ':list')->add(PermissionMiddleware::class)->setName('viewbusesinteriorlist-view_buses_interior-list'); // list
    $app->group(
        '/view_buses_interior',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusesInteriorController::class . ':list')->add(PermissionMiddleware::class)->setName('view_buses_interior/list-view_buses_interior-list-2'); // list
        }
    );

    // view_buses_exterior
    $app->any('/viewbusesexteriorlist', ViewBusesExteriorController::class . ':list')->add(PermissionMiddleware::class)->setName('viewbusesexteriorlist-view_buses_exterior-list'); // list
    $app->group(
        '/view_buses_exterior',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusesExteriorController::class . ':list')->add(PermissionMiddleware::class)->setName('view_buses_exterior/list-view_buses_exterior-list-2'); // list
        }
    );

    // view_bus_depot_summary
    $app->any('/viewbusdepotsummarylist', ViewBusDepotSummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('viewbusdepotsummarylist-view_bus_depot_summary-list'); // list
    $app->group(
        '/view_bus_depot_summary',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusDepotSummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_depot_summary/list-view_bus_depot_summary-list-2'); // list
        }
    );

    // view_bus_int_summary_at_a_glance
    $app->any('/viewbusintsummaryataglancelist', ViewBusIntSummaryAtAGlanceController::class . ':list')->add(PermissionMiddleware::class)->setName('viewbusintsummaryataglancelist-view_bus_int_summary_at_a_glance-list'); // list
    $app->group(
        '/view_bus_int_summary_at_a_glance',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusIntSummaryAtAGlanceController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_int_summary_at_a_glance/list-view_bus_int_summary_at_a_glance-list-2'); // list
        }
    );

    // view_bus_ext_summary_at_a_glance
    $app->any('/viewbusextsummaryataglancelist', ViewBusExtSummaryAtAGlanceController::class . ':list')->add(PermissionMiddleware::class)->setName('viewbusextsummaryataglancelist-view_bus_ext_summary_at_a_glance-list'); // list
    $app->group(
        '/view_bus_ext_summary_at_a_glance',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusExtSummaryAtAGlanceController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_ext_summary_at_a_glance/list-view_bus_ext_summary_at_a_glance-list-2'); // list
        }
    );

    // view_bus_summary
    $app->any('/viewbussummarylist', ViewBusSummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('viewbussummarylist-view_bus_summary-list'); // list
    $app->group(
        '/view_bus_summary',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusSummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_summary/list-view_bus_summary-list-2'); // list
        }
    );

    // private_functions
    $app->any('/privatefunctions[/{params:.*}]', PrivateFunctionsController::class)->add(PermissionMiddleware::class)->setName('privatefunctions-private_functions-custom'); // custom

    // test
    $app->any('/test[/{params:.*}]', TestController::class)->add(PermissionMiddleware::class)->setName('test-test-custom'); // custom

    // view_campaign_status
    $app->any('/viewcampaignstatuslist', ViewCampaignStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('viewcampaignstatuslist-view_campaign_status-list'); // list
    $app->group(
        '/view_campaign_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewCampaignStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('view_campaign_status/list-view_campaign_status-list-2'); // list
        }
    );

    // view_payments_pending
    $app->any('/viewpaymentspendinglist', ViewPaymentsPendingController::class . ':list')->add(PermissionMiddleware::class)->setName('viewpaymentspendinglist-view_payments_pending-list'); // list
    $app->group(
        '/view_payments_pending',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewPaymentsPendingController::class . ':list')->add(PermissionMiddleware::class)->setName('view_payments_pending/list-view_payments_pending-list-2'); // list
        }
    );

    // view_transactions_all
    $app->any('/viewtransactionsalllist', ViewTransactionsAllController::class . ':list')->add(PermissionMiddleware::class)->setName('viewtransactionsalllist-view_transactions_all-list'); // list
    $app->group(
        '/view_transactions_all',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewTransactionsAllController::class . ':list')->add(PermissionMiddleware::class)->setName('view_transactions_all/list-view_transactions_all-list-2'); // list
        }
    );

    // view_operators
    $app->any('/viewoperatorslist', ViewOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('viewoperatorslist-view_operators-list'); // list
    $app->group(
        '/view_operators',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_operators/list-view_operators-list-2'); // list
        }
    );

    // z_email_settings
    $app->any('/zemailsettingslist[/{id}]', ZEmailSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('zemailsettingslist-z_email_settings-list'); // list
    $app->any('/zemailsettingsadd[/{id}]', ZEmailSettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('zemailsettingsadd-z_email_settings-add'); // add
    $app->any('/zemailsettingsview[/{id}]', ZEmailSettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('zemailsettingsview-z_email_settings-view'); // view
    $app->any('/zemailsettingsedit[/{id}]', ZEmailSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('zemailsettingsedit-z_email_settings-edit'); // edit
    $app->any('/zemailsettingsdelete[/{id}]', ZEmailSettingsController::class . ':delete')->add(PermissionMiddleware::class)->setName('zemailsettingsdelete-z_email_settings-delete'); // delete
    $app->group(
        '/z_email_settings',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ZEmailSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('z_email_settings/list-z_email_settings-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ZEmailSettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('z_email_settings/add-z_email_settings-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ZEmailSettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('z_email_settings/view-z_email_settings-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ZEmailSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('z_email_settings/edit-z_email_settings-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ZEmailSettingsController::class . ':delete')->add(PermissionMiddleware::class)->setName('z_email_settings/delete-z_email_settings-delete-2'); // delete
        }
    );

    // view_transactions_per_operator
    $app->any('/viewtransactionsperoperatorlist', ViewTransactionsPerOperatorController::class . ':list')->add(PermissionMiddleware::class)->setName('viewtransactionsperoperatorlist-view_transactions_per_operator-list'); // list
    $app->any('/viewtransactionsperoperatorsearch', ViewTransactionsPerOperatorController::class . ':search')->add(PermissionMiddleware::class)->setName('viewtransactionsperoperatorsearch-view_transactions_per_operator-search'); // search
    $app->group(
        '/view_transactions_per_operator',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewTransactionsPerOperatorController::class . ':list')->add(PermissionMiddleware::class)->setName('view_transactions_per_operator/list-view_transactions_per_operator-list-2'); // list
            $group->any('/' . Config("SEARCH_ACTION") . '', ViewTransactionsPerOperatorController::class . ':search')->add(PermissionMiddleware::class)->setName('view_transactions_per_operator/search-view_transactions_per_operator-search-2'); // search
        }
    );

    // view_transactions_per_platform
    $app->any('/viewtransactionsperplatformlist', ViewTransactionsPerPlatformController::class . ':list')->add(PermissionMiddleware::class)->setName('viewtransactionsperplatformlist-view_transactions_per_platform-list'); // list
    $app->any('/viewtransactionsperplatformsearch', ViewTransactionsPerPlatformController::class . ':search')->add(PermissionMiddleware::class)->setName('viewtransactionsperplatformsearch-view_transactions_per_platform-search'); // search
    $app->group(
        '/view_transactions_per_platform',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewTransactionsPerPlatformController::class . ':list')->add(PermissionMiddleware::class)->setName('view_transactions_per_platform/list-view_transactions_per_platform-list-2'); // list
            $group->any('/' . Config("SEARCH_ACTION") . '', ViewTransactionsPerPlatformController::class . ':search')->add(PermissionMiddleware::class)->setName('view_transactions_per_platform/search-view_transactions_per_platform-search-2'); // search
        }
    );

    // view_vendors_operators
    $app->any('/viewvendorsoperatorslist', ViewVendorsOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('viewvendorsoperatorslist-view_vendors_operators-list'); // list
    $app->group(
        '/view_vendors_operators',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewVendorsOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_vendors_operators/list-view_vendors_operators-list-2'); // list
        }
    );

    // view_campaigns_pending
    $app->any('/viewcampaignspendinglist[/{transaction_id}]', ViewCampaignsPendingController::class . ':list')->add(PermissionMiddleware::class)->setName('viewcampaignspendinglist-view_campaigns_pending-list'); // list
    $app->any('/viewcampaignspendingview[/{transaction_id}]', ViewCampaignsPendingController::class . ':view')->add(PermissionMiddleware::class)->setName('viewcampaignspendingview-view_campaigns_pending-view'); // view
    $app->group(
        '/view_campaigns_pending',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{transaction_id}]', ViewCampaignsPendingController::class . ':list')->add(PermissionMiddleware::class)->setName('view_campaigns_pending/list-view_campaigns_pending-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{transaction_id}]', ViewCampaignsPendingController::class . ':view')->add(PermissionMiddleware::class)->setName('view_campaigns_pending/view-view_campaigns_pending-view-2'); // view
        }
    );

    // view_buses_assigned
    $app->any('/viewbusesassignedlist', ViewBusesAssignedController::class . ':list')->add(PermissionMiddleware::class)->setName('viewbusesassignedlist-view_buses_assigned-list'); // list
    $app->group(
        '/view_buses_assigned',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusesAssignedController::class . ':list')->add(PermissionMiddleware::class)->setName('view_buses_assigned/list-view_buses_assigned-list-2'); // list
        }
    );

    // z_price_settings
    $app->any('/zpricesettingslist[/{id}]', ZPriceSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('zpricesettingslist-z_price_settings-list'); // list
    $app->any('/zpricesettingsview[/{id}]', ZPriceSettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('zpricesettingsview-z_price_settings-view'); // view
    $app->any('/zpricesettingsedit[/{id}]', ZPriceSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('zpricesettingsedit-z_price_settings-edit'); // edit
    $app->any('/zpricesettingsupdate', ZPriceSettingsController::class . ':update')->add(PermissionMiddleware::class)->setName('zpricesettingsupdate-z_price_settings-update'); // update
    $app->group(
        '/z_price_settings',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ZPriceSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('z_price_settings/list-z_price_settings-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ZPriceSettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('z_price_settings/view-z_price_settings-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ZPriceSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('z_price_settings/edit-z_price_settings-edit-2'); // edit
            $group->any('/' . Config("UPDATE_ACTION") . '', ZPriceSettingsController::class . ':update')->add(PermissionMiddleware::class)->setName('z_price_settings/update-z_price_settings-update-2'); // update
        }
    );

    // w_vendors_operators
    $app->any('/wvendorsoperatorslist[/{id}]', WVendorsOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('wvendorsoperatorslist-w_vendors_operators-list'); // list
    $app->any('/wvendorsoperatorsadd[/{id}]', WVendorsOperatorsController::class . ':add')->add(PermissionMiddleware::class)->setName('wvendorsoperatorsadd-w_vendors_operators-add'); // add
    $app->any('/wvendorsoperatorsview[/{id}]', WVendorsOperatorsController::class . ':view')->add(PermissionMiddleware::class)->setName('wvendorsoperatorsview-w_vendors_operators-view'); // view
    $app->any('/wvendorsoperatorsedit[/{id}]', WVendorsOperatorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('wvendorsoperatorsedit-w_vendors_operators-edit'); // edit
    $app->any('/wvendorsoperatorsdelete[/{id}]', WVendorsOperatorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('wvendorsoperatorsdelete-w_vendors_operators-delete'); // delete
    $app->group(
        '/w_vendors_operators',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', WVendorsOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('w_vendors_operators/list-w_vendors_operators-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', WVendorsOperatorsController::class . ':add')->add(PermissionMiddleware::class)->setName('w_vendors_operators/add-w_vendors_operators-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', WVendorsOperatorsController::class . ':view')->add(PermissionMiddleware::class)->setName('w_vendors_operators/view-w_vendors_operators-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', WVendorsOperatorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_vendors_operators/edit-w_vendors_operators-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', WVendorsOperatorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('w_vendors_operators/delete-w_vendors_operators-delete-2'); // delete
        }
    );

    // view_all_buses
    $app->any('/viewallbuseslist[/{id}]', ViewAllBusesController::class . ':list')->add(PermissionMiddleware::class)->setName('viewallbuseslist-view_all_buses-list'); // list
    $app->group(
        '/view_all_buses',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ViewAllBusesController::class . ':list')->add(PermissionMiddleware::class)->setName('view_all_buses/list-view_all_buses-list-2'); // list
        }
    );

    // w_managers_platform
    $app->any('/wmanagersplatformlist[/{id}]', WManagersPlatformController::class . ':list')->add(PermissionMiddleware::class)->setName('wmanagersplatformlist-w_managers_platform-list'); // list
    $app->any('/wmanagersplatformadd[/{id}]', WManagersPlatformController::class . ':add')->add(PermissionMiddleware::class)->setName('wmanagersplatformadd-w_managers_platform-add'); // add
    $app->any('/wmanagersplatformview[/{id}]', WManagersPlatformController::class . ':view')->add(PermissionMiddleware::class)->setName('wmanagersplatformview-w_managers_platform-view'); // view
    $app->any('/wmanagersplatformedit[/{id}]', WManagersPlatformController::class . ':edit')->add(PermissionMiddleware::class)->setName('wmanagersplatformedit-w_managers_platform-edit'); // edit
    $app->any('/wmanagersplatformdelete[/{id}]', WManagersPlatformController::class . ':delete')->add(PermissionMiddleware::class)->setName('wmanagersplatformdelete-w_managers_platform-delete'); // delete
    $app->group(
        '/w_managers_platform',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', WManagersPlatformController::class . ':list')->add(PermissionMiddleware::class)->setName('w_managers_platform/list-w_managers_platform-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', WManagersPlatformController::class . ':add')->add(PermissionMiddleware::class)->setName('w_managers_platform/add-w_managers_platform-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', WManagersPlatformController::class . ':view')->add(PermissionMiddleware::class)->setName('w_managers_platform/view-w_managers_platform-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', WManagersPlatformController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_managers_platform/edit-w_managers_platform-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', WManagersPlatformController::class . ':delete')->add(PermissionMiddleware::class)->setName('w_managers_platform/delete-w_managers_platform-delete-2'); // delete
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // reset_password
    $app->any('/resetpassword', OthersController::class . ':resetpassword')->add(PermissionMiddleware::class)->setName('resetpassword');

    // change_password
    $app->any('/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // register
    $app->any('/register', OthersController::class . ':register')->add(PermissionMiddleware::class)->setName('register');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};

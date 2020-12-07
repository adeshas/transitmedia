<?php

namespace PHPMaker2021\test;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // main_buses
    $app->any('/MainBusesList[/{id}]', MainBusesController::class . ':list')->add(PermissionMiddleware::class)->setName('MainBusesList-main_buses-list'); // list
    $app->any('/MainBusesAdd[/{id}]', MainBusesController::class . ':add')->add(PermissionMiddleware::class)->setName('MainBusesAdd-main_buses-add'); // add
    $app->any('/MainBusesView[/{id}]', MainBusesController::class . ':view')->add(PermissionMiddleware::class)->setName('MainBusesView-main_buses-view'); // view
    $app->any('/MainBusesEdit[/{id}]', MainBusesController::class . ':edit')->add(PermissionMiddleware::class)->setName('MainBusesEdit-main_buses-edit'); // edit
    $app->any('/MainBusesUpdate', MainBusesController::class . ':update')->add(PermissionMiddleware::class)->setName('MainBusesUpdate-main_buses-update'); // update
    $app->any('/MainBusesDelete[/{id}]', MainBusesController::class . ':delete')->add(PermissionMiddleware::class)->setName('MainBusesDelete-main_buses-delete'); // delete
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
    $app->any('/MainCampaignsList[/{id}]', MainCampaignsController::class . ':list')->add(PermissionMiddleware::class)->setName('MainCampaignsList-main_campaigns-list'); // list
    $app->any('/MainCampaignsAdd[/{id}]', MainCampaignsController::class . ':add')->add(PermissionMiddleware::class)->setName('MainCampaignsAdd-main_campaigns-add'); // add
    $app->any('/MainCampaignsView[/{id}]', MainCampaignsController::class . ':view')->add(PermissionMiddleware::class)->setName('MainCampaignsView-main_campaigns-view'); // view
    $app->any('/MainCampaignsEdit[/{id}]', MainCampaignsController::class . ':edit')->add(PermissionMiddleware::class)->setName('MainCampaignsEdit-main_campaigns-edit'); // edit
    $app->any('/MainCampaignsDelete[/{id}]', MainCampaignsController::class . ':delete')->add(PermissionMiddleware::class)->setName('MainCampaignsDelete-main_campaigns-delete'); // delete
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
    $app->any('/MainReportsList[/{id}]', MainReportsController::class . ':list')->add(PermissionMiddleware::class)->setName('MainReportsList-main_reports-list'); // list
    $app->any('/MainReportsAdd[/{id}]', MainReportsController::class . ':add')->add(PermissionMiddleware::class)->setName('MainReportsAdd-main_reports-add'); // add
    $app->any('/MainReportsView[/{id}]', MainReportsController::class . ':view')->add(PermissionMiddleware::class)->setName('MainReportsView-main_reports-view'); // view
    $app->any('/MainReportsEdit[/{id}]', MainReportsController::class . ':edit')->add(PermissionMiddleware::class)->setName('MainReportsEdit-main_reports-edit'); // edit
    $app->any('/MainReportsDelete[/{id}]', MainReportsController::class . ':delete')->add(PermissionMiddleware::class)->setName('MainReportsDelete-main_reports-delete'); // delete
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
    $app->any('/MainTransactionsList[/{id}]', MainTransactionsController::class . ':list')->add(PermissionMiddleware::class)->setName('MainTransactionsList-main_transactions-list'); // list
    $app->any('/MainTransactionsAdd[/{id}]', MainTransactionsController::class . ':add')->add(PermissionMiddleware::class)->setName('MainTransactionsAdd-main_transactions-add'); // add
    $app->any('/MainTransactionsView[/{id}]', MainTransactionsController::class . ':view')->add(PermissionMiddleware::class)->setName('MainTransactionsView-main_transactions-view'); // view
    $app->any('/MainTransactionsEdit[/{id}]', MainTransactionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('MainTransactionsEdit-main_transactions-edit'); // edit
    $app->any('/MainTransactionsUpdate', MainTransactionsController::class . ':update')->add(PermissionMiddleware::class)->setName('MainTransactionsUpdate-main_transactions-update'); // update
    $app->any('/MainTransactionsDelete[/{id}]', MainTransactionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('MainTransactionsDelete-main_transactions-delete'); // delete
    $app->any('/MainTransactionsSearch', MainTransactionsController::class . ':search')->add(PermissionMiddleware::class)->setName('MainTransactionsSearch-main_transactions-search'); // search
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
    $app->any('/MainUsersList[/{id}]', MainUsersController::class . ':list')->add(PermissionMiddleware::class)->setName('MainUsersList-main_users-list'); // list
    $app->any('/MainUsersAdd[/{id}]', MainUsersController::class . ':add')->add(PermissionMiddleware::class)->setName('MainUsersAdd-main_users-add'); // add
    $app->any('/MainUsersView[/{id}]', MainUsersController::class . ':view')->add(PermissionMiddleware::class)->setName('MainUsersView-main_users-view'); // view
    $app->any('/MainUsersEdit[/{id}]', MainUsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('MainUsersEdit-main_users-edit'); // edit
    $app->any('/MainUsersUpdate', MainUsersController::class . ':update')->add(PermissionMiddleware::class)->setName('MainUsersUpdate-main_users-update'); // update
    $app->any('/MainUsersDelete[/{id}]', MainUsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('MainUsersDelete-main_users-delete'); // delete
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
    $app->any('/Spook', SpookController::class)->add(PermissionMiddleware::class)->setName('Spook-spook-custom'); // custom

    // main_print_orders
    $app->any('/MainPrintOrdersList[/{id}]', MainPrintOrdersController::class . ':list')->add(PermissionMiddleware::class)->setName('MainPrintOrdersList-main_print_orders-list'); // list
    $app->any('/MainPrintOrdersAdd[/{id}]', MainPrintOrdersController::class . ':add')->add(PermissionMiddleware::class)->setName('MainPrintOrdersAdd-main_print_orders-add'); // add
    $app->any('/MainPrintOrdersView[/{id}]', MainPrintOrdersController::class . ':view')->add(PermissionMiddleware::class)->setName('MainPrintOrdersView-main_print_orders-view'); // view
    $app->any('/MainPrintOrdersEdit[/{id}]', MainPrintOrdersController::class . ':edit')->add(PermissionMiddleware::class)->setName('MainPrintOrdersEdit-main_print_orders-edit'); // edit
    $app->any('/MainPrintOrdersDelete[/{id}]', MainPrintOrdersController::class . ':delete')->add(PermissionMiddleware::class)->setName('MainPrintOrdersDelete-main_print_orders-delete'); // delete
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
    $app->any('/SubMediaAllocationList[/{id}]', SubMediaAllocationController::class . ':list')->add(PermissionMiddleware::class)->setName('SubMediaAllocationList-sub_media_allocation-list'); // list
    $app->any('/SubMediaAllocationAdd[/{id}]', SubMediaAllocationController::class . ':add')->add(PermissionMiddleware::class)->setName('SubMediaAllocationAdd-sub_media_allocation-add'); // add
    $app->any('/SubMediaAllocationView[/{id}]', SubMediaAllocationController::class . ':view')->add(PermissionMiddleware::class)->setName('SubMediaAllocationView-sub_media_allocation-view'); // view
    $app->any('/SubMediaAllocationUpdate', SubMediaAllocationController::class . ':update')->add(PermissionMiddleware::class)->setName('SubMediaAllocationUpdate-sub_media_allocation-update'); // update
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
    $app->any('/SubRenewalRequestsList[/{id}]', SubRenewalRequestsController::class . ':list')->add(PermissionMiddleware::class)->setName('SubRenewalRequestsList-sub_renewal_requests-list'); // list
    $app->any('/SubRenewalRequestsAdd[/{id}]', SubRenewalRequestsController::class . ':add')->add(PermissionMiddleware::class)->setName('SubRenewalRequestsAdd-sub_renewal_requests-add'); // add
    $app->any('/SubRenewalRequestsView[/{id}]', SubRenewalRequestsController::class . ':view')->add(PermissionMiddleware::class)->setName('SubRenewalRequestsView-sub_renewal_requests-view'); // view
    $app->any('/SubRenewalRequestsEdit[/{id}]', SubRenewalRequestsController::class . ':edit')->add(PermissionMiddleware::class)->setName('SubRenewalRequestsEdit-sub_renewal_requests-edit'); // edit
    $app->any('/SubRenewalRequestsDelete[/{id}]', SubRenewalRequestsController::class . ':delete')->add(PermissionMiddleware::class)->setName('SubRenewalRequestsDelete-sub_renewal_requests-delete'); // delete
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
    $app->any('/ViewPricingInitialList', ViewPricingInitialController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewPricingInitialList-view_pricing_initial-list'); // list
    $app->group(
        '/view_pricing_initial',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewPricingInitialController::class . ':list')->add(PermissionMiddleware::class)->setName('view_pricing_initial/list-view_pricing_initial-list-2'); // list
        }
    );

    // welcome
    $app->any('/Welcome', WelcomeController::class)->add(PermissionMiddleware::class)->setName('Welcome-welcome-custom'); // custom

    // sub_transaction_details
    $app->any('/SubTransactionDetailsList[/{id}]', SubTransactionDetailsController::class . ':list')->add(PermissionMiddleware::class)->setName('SubTransactionDetailsList-sub_transaction_details-list'); // list
    $app->any('/SubTransactionDetailsAdd[/{id}]', SubTransactionDetailsController::class . ':add')->add(PermissionMiddleware::class)->setName('SubTransactionDetailsAdd-sub_transaction_details-add'); // add
    $app->any('/SubTransactionDetailsView[/{id}]', SubTransactionDetailsController::class . ':view')->add(PermissionMiddleware::class)->setName('SubTransactionDetailsView-sub_transaction_details-view'); // view
    $app->any('/SubTransactionDetailsEdit[/{id}]', SubTransactionDetailsController::class . ':edit')->add(PermissionMiddleware::class)->setName('SubTransactionDetailsEdit-sub_transaction_details-edit'); // edit
    $app->any('/SubTransactionDetailsDelete[/{id}]', SubTransactionDetailsController::class . ':delete')->add(PermissionMiddleware::class)->setName('SubTransactionDetailsDelete-sub_transaction_details-delete'); // delete
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
    $app->any('/XBusDepotList[/{id}]', XBusDepotController::class . ':list')->add(PermissionMiddleware::class)->setName('XBusDepotList-x_bus_depot-list'); // list
    $app->any('/XBusDepotView[/{id}]', XBusDepotController::class . ':view')->add(PermissionMiddleware::class)->setName('XBusDepotView-x_bus_depot-view'); // view
    $app->group(
        '/x_bus_depot',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XBusDepotController::class . ':list')->add(PermissionMiddleware::class)->setName('x_bus_depot/list-x_bus_depot-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XBusDepotController::class . ':view')->add(PermissionMiddleware::class)->setName('x_bus_depot/view-x_bus_depot-view-2'); // view
        }
    );

    // x_bus_sizes
    $app->any('/XBusSizesList[/{id}]', XBusSizesController::class . ':list')->add(PermissionMiddleware::class)->setName('XBusSizesList-x_bus_sizes-list'); // list
    $app->any('/XBusSizesView[/{id}]', XBusSizesController::class . ':view')->add(PermissionMiddleware::class)->setName('XBusSizesView-x_bus_sizes-view'); // view
    $app->group(
        '/x_bus_sizes',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XBusSizesController::class . ':list')->add(PermissionMiddleware::class)->setName('x_bus_sizes/list-x_bus_sizes-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XBusSizesController::class . ':view')->add(PermissionMiddleware::class)->setName('x_bus_sizes/view-x_bus_sizes-view-2'); // view
        }
    );

    // x_bus_status
    $app->any('/XBusStatusList[/{id}]', XBusStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('XBusStatusList-x_bus_status-list'); // list
    $app->any('/XBusStatusView[/{id}]', XBusStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('XBusStatusView-x_bus_status-view'); // view
    $app->group(
        '/x_bus_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XBusStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('x_bus_status/list-x_bus_status-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XBusStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('x_bus_status/view-x_bus_status-view-2'); // view
        }
    );

    // x_transaction_status
    $app->any('/XTransactionStatusList[/{id}]', XTransactionStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('XTransactionStatusList-x_transaction_status-list'); // list
    $app->any('/XTransactionStatusAdd[/{id}]', XTransactionStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('XTransactionStatusAdd-x_transaction_status-add'); // add
    $app->any('/XTransactionStatusView[/{id}]', XTransactionStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('XTransactionStatusView-x_transaction_status-view'); // view
    $app->any('/XTransactionStatusEdit[/{id}]', XTransactionStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('XTransactionStatusEdit-x_transaction_status-edit'); // edit
    $app->any('/XTransactionStatusDelete[/{id}]', XTransactionStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('XTransactionStatusDelete-x_transaction_status-delete'); // delete
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
    $app->any('/XPaymentStatusList[/{id}]', XPaymentStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('XPaymentStatusList-x_payment_status-list'); // list
    $app->any('/XPaymentStatusView[/{id}]', XPaymentStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('XPaymentStatusView-x_payment_status-view'); // view
    $app->group(
        '/x_payment_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XPaymentStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('x_payment_status/list-x_payment_status-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XPaymentStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('x_payment_status/view-x_payment_status-view-2'); // view
        }
    );

    // x_print_stage
    $app->any('/XPrintStageList[/{id}]', XPrintStageController::class . ':list')->add(PermissionMiddleware::class)->setName('XPrintStageList-x_print_stage-list'); // list
    $app->any('/XPrintStageView[/{id}]', XPrintStageController::class . ':view')->add(PermissionMiddleware::class)->setName('XPrintStageView-x_print_stage-view'); // view
    $app->group(
        '/x_print_stage',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XPrintStageController::class . ':list')->add(PermissionMiddleware::class)->setName('x_print_stage/list-x_print_stage-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XPrintStageController::class . ':view')->add(PermissionMiddleware::class)->setName('x_print_stage/view-x_print_stage-view-2'); // view
        }
    );

    // x_print_status
    $app->any('/XPrintStatusList[/{id}]', XPrintStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('XPrintStatusList-x_print_status-list'); // list
    $app->any('/XPrintStatusView[/{id}]', XPrintStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('XPrintStatusView-x_print_status-view'); // view
    $app->group(
        '/x_print_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XPrintStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('x_print_status/list-x_print_status-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', XPrintStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('x_print_status/view-x_print_status-view-2'); // view
        }
    );

    // x_renewal_stage
    $app->any('/XRenewalStageList[/{id}]', XRenewalStageController::class . ':list')->add(PermissionMiddleware::class)->setName('XRenewalStageList-x_renewal_stage-list'); // list
    $app->any('/XRenewalStageAdd[/{id}]', XRenewalStageController::class . ':add')->add(PermissionMiddleware::class)->setName('XRenewalStageAdd-x_renewal_stage-add'); // add
    $app->any('/XRenewalStageEdit[/{id}]', XRenewalStageController::class . ':edit')->add(PermissionMiddleware::class)->setName('XRenewalStageEdit-x_renewal_stage-edit'); // edit
    $app->any('/XRenewalStageDelete[/{id}]', XRenewalStageController::class . ':delete')->add(PermissionMiddleware::class)->setName('XRenewalStageDelete-x_renewal_stage-delete'); // delete
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
    $app->any('/XReportTypesList[/{id}]', XReportTypesController::class . ':list')->add(PermissionMiddleware::class)->setName('XReportTypesList-x_report_types-list'); // list
    $app->group(
        '/x_report_types',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', XReportTypesController::class . ':list')->add(PermissionMiddleware::class)->setName('x_report_types/list-x_report_types-list-2'); // list
        }
    );

    // x_user_types
    $app->any('/XUserTypesList[/{id}]', XUserTypesController::class . ':list')->add(PermissionMiddleware::class)->setName('XUserTypesList-x_user_types-list'); // list
    $app->any('/XUserTypesAdd[/{id}]', XUserTypesController::class . ':add')->add(PermissionMiddleware::class)->setName('XUserTypesAdd-x_user_types-add'); // add
    $app->any('/XUserTypesEdit[/{id}]', XUserTypesController::class . ':edit')->add(PermissionMiddleware::class)->setName('XUserTypesEdit-x_user_types-edit'); // edit
    $app->any('/XUserTypesDelete[/{id}]', XUserTypesController::class . ':delete')->add(PermissionMiddleware::class)->setName('XUserTypesDelete-x_user_types-delete'); // delete
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
    $app->any('/YInventoryList[/{id}]', YInventoryController::class . ':list')->add(PermissionMiddleware::class)->setName('YInventoryList-y_inventory-list'); // list
    $app->any('/YInventoryView[/{id}]', YInventoryController::class . ':view')->add(PermissionMiddleware::class)->setName('YInventoryView-y_inventory-view'); // view
    $app->group(
        '/y_inventory',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', YInventoryController::class . ':list')->add(PermissionMiddleware::class)->setName('y_inventory/list-y_inventory-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', YInventoryController::class . ':view')->add(PermissionMiddleware::class)->setName('y_inventory/view-y_inventory-view-2'); // view
        }
    );

    // y_operators
    $app->any('/YOperatorsList[/{id}]', YOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('YOperatorsList-y_operators-list'); // list
    $app->any('/YOperatorsAdd[/{id}]', YOperatorsController::class . ':add')->add(PermissionMiddleware::class)->setName('YOperatorsAdd-y_operators-add'); // add
    $app->any('/YOperatorsView[/{id}]', YOperatorsController::class . ':view')->add(PermissionMiddleware::class)->setName('YOperatorsView-y_operators-view'); // view
    $app->any('/YOperatorsEdit[/{id}]', YOperatorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('YOperatorsEdit-y_operators-edit'); // edit
    $app->any('/YOperatorsUpdate', YOperatorsController::class . ':update')->add(PermissionMiddleware::class)->setName('YOperatorsUpdate-y_operators-update'); // update
    $app->any('/YOperatorsDelete[/{id}]', YOperatorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('YOperatorsDelete-y_operators-delete'); // delete
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
    $app->any('/YPrintersList[/{id}]', YPrintersController::class . ':list')->add(PermissionMiddleware::class)->setName('YPrintersList-y_printers-list'); // list
    $app->any('/YPrintersAdd[/{id}]', YPrintersController::class . ':add')->add(PermissionMiddleware::class)->setName('YPrintersAdd-y_printers-add'); // add
    $app->any('/YPrintersView[/{id}]', YPrintersController::class . ':view')->add(PermissionMiddleware::class)->setName('YPrintersView-y_printers-view'); // view
    $app->any('/YPrintersEdit[/{id}]', YPrintersController::class . ':edit')->add(PermissionMiddleware::class)->setName('YPrintersEdit-y_printers-edit'); // edit
    $app->any('/YPrintersDelete[/{id}]', YPrintersController::class . ':delete')->add(PermissionMiddleware::class)->setName('YPrintersDelete-y_printers-delete'); // delete
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
    $app->any('/YPlatformsList[/{id}]', YPlatformsController::class . ':list')->add(PermissionMiddleware::class)->setName('YPlatformsList-y_platforms-list'); // list
    $app->any('/YPlatformsAdd[/{id}]', YPlatformsController::class . ':add')->add(PermissionMiddleware::class)->setName('YPlatformsAdd-y_platforms-add'); // add
    $app->any('/YPlatformsView[/{id}]', YPlatformsController::class . ':view')->add(PermissionMiddleware::class)->setName('YPlatformsView-y_platforms-view'); // view
    $app->any('/YPlatformsEdit[/{id}]', YPlatformsController::class . ':edit')->add(PermissionMiddleware::class)->setName('YPlatformsEdit-y_platforms-edit'); // edit
    $app->any('/YPlatformsDelete[/{id}]', YPlatformsController::class . ':delete')->add(PermissionMiddleware::class)->setName('YPlatformsDelete-y_platforms-delete'); // delete
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
    $app->any('/YVendorsList[/{id}]', YVendorsController::class . ':list')->add(PermissionMiddleware::class)->setName('YVendorsList-y_vendors-list'); // list
    $app->any('/YVendorsAdd[/{id}]', YVendorsController::class . ':add')->add(PermissionMiddleware::class)->setName('YVendorsAdd-y_vendors-add'); // add
    $app->any('/YVendorsEdit[/{id}]', YVendorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('YVendorsEdit-y_vendors-edit'); // edit
    $app->any('/YVendorsDelete[/{id}]', YVendorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('YVendorsDelete-y_vendors-delete'); // delete
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
    $app->any('/ZCoreSettingsList[/{id}]', ZCoreSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('ZCoreSettingsList-z_core_settings-list'); // list
    $app->any('/ZCoreSettingsAdd[/{id}]', ZCoreSettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('ZCoreSettingsAdd-z_core_settings-add'); // add
    $app->any('/ZCoreSettingsEdit[/{id}]', ZCoreSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ZCoreSettingsEdit-z_core_settings-edit'); // edit
    $app->group(
        '/z_core_settings',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ZCoreSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('z_core_settings/list-z_core_settings-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ZCoreSettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('z_core_settings/add-z_core_settings-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ZCoreSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('z_core_settings/edit-z_core_settings-edit-2'); // edit
        }
    );

    // view_pricing_all
    $app->any('/ViewPricingAllList', ViewPricingAllController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewPricingAllList-view_pricing_all-list'); // list
    $app->group(
        '/view_pricing_all',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewPricingAllController::class . ':list')->add(PermissionMiddleware::class)->setName('view_pricing_all/list-view_pricing_all-list-2'); // list
        }
    );

    // view_operators_platforms
    $app->any('/ViewOperatorsPlatformsList', ViewOperatorsPlatformsController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewOperatorsPlatformsList-view_operators_platforms-list'); // list
    $app->group(
        '/view_operators_platforms',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewOperatorsPlatformsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_operators_platforms/list-view_operators_platforms-list-2'); // list
        }
    );

    // view_pricing_options
    $app->any('/ViewPricingOptionsList', ViewPricingOptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewPricingOptionsList-view_pricing_options-list'); // list
    $app->group(
        '/view_pricing_options',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewPricingOptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_pricing_options/list-view_pricing_options-list-2'); // list
        }
    );

    // view_bus_trans_options
    $app->any('/ViewBusTransOptionsList', ViewBusTransOptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewBusTransOptionsList-view_bus_trans_options-list'); // list
    $app->group(
        '/view_bus_trans_options',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusTransOptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_trans_options/list-view_bus_trans_options-list-2'); // list
        }
    );

    // view_buses_interior
    $app->any('/ViewBusesInteriorList', ViewBusesInteriorController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewBusesInteriorList-view_buses_interior-list'); // list
    $app->group(
        '/view_buses_interior',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusesInteriorController::class . ':list')->add(PermissionMiddleware::class)->setName('view_buses_interior/list-view_buses_interior-list-2'); // list
        }
    );

    // view_buses_exterior
    $app->any('/ViewBusesExteriorList', ViewBusesExteriorController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewBusesExteriorList-view_buses_exterior-list'); // list
    $app->group(
        '/view_buses_exterior',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusesExteriorController::class . ':list')->add(PermissionMiddleware::class)->setName('view_buses_exterior/list-view_buses_exterior-list-2'); // list
        }
    );

    // view_bus_depot_summary
    $app->any('/ViewBusDepotSummaryList', ViewBusDepotSummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewBusDepotSummaryList-view_bus_depot_summary-list'); // list
    $app->group(
        '/view_bus_depot_summary',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusDepotSummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_depot_summary/list-view_bus_depot_summary-list-2'); // list
        }
    );

    // view_bus_int_summary_at_a_glance
    $app->any('/ViewBusIntSummaryAtAGlanceList', ViewBusIntSummaryAtAGlanceController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewBusIntSummaryAtAGlanceList-view_bus_int_summary_at_a_glance-list'); // list
    $app->group(
        '/view_bus_int_summary_at_a_glance',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusIntSummaryAtAGlanceController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_int_summary_at_a_glance/list-view_bus_int_summary_at_a_glance-list-2'); // list
        }
    );

    // view_bus_ext_summary_at_a_glance
    $app->any('/ViewBusExtSummaryAtAGlanceList', ViewBusExtSummaryAtAGlanceController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewBusExtSummaryAtAGlanceList-view_bus_ext_summary_at_a_glance-list'); // list
    $app->group(
        '/view_bus_ext_summary_at_a_glance',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusExtSummaryAtAGlanceController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_ext_summary_at_a_glance/list-view_bus_ext_summary_at_a_glance-list-2'); // list
        }
    );

    // view_bus_summary
    $app->any('/ViewBusSummaryList', ViewBusSummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewBusSummaryList-view_bus_summary-list'); // list
    $app->group(
        '/view_bus_summary',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusSummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('view_bus_summary/list-view_bus_summary-list-2'); // list
        }
    );

    // private_functions
    $app->any('/PrivateFunctions', PrivateFunctionsController::class)->add(PermissionMiddleware::class)->setName('PrivateFunctions-private_functions-custom'); // custom

    // view_campaign_status
    $app->any('/ViewCampaignStatusList', ViewCampaignStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewCampaignStatusList-view_campaign_status-list'); // list
    $app->group(
        '/view_campaign_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewCampaignStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('view_campaign_status/list-view_campaign_status-list-2'); // list
        }
    );

    // view_payments_pending
    $app->any('/ViewPaymentsPendingList', ViewPaymentsPendingController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewPaymentsPendingList-view_payments_pending-list'); // list
    $app->group(
        '/view_payments_pending',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewPaymentsPendingController::class . ':list')->add(PermissionMiddleware::class)->setName('view_payments_pending/list-view_payments_pending-list-2'); // list
        }
    );

    // view_transactions_all
    $app->any('/ViewTransactionsAllList', ViewTransactionsAllController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewTransactionsAllList-view_transactions_all-list'); // list
    $app->group(
        '/view_transactions_all',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewTransactionsAllController::class . ':list')->add(PermissionMiddleware::class)->setName('view_transactions_all/list-view_transactions_all-list-2'); // list
        }
    );

    // view_operators
    $app->any('/ViewOperatorsList', ViewOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewOperatorsList-view_operators-list'); // list
    $app->group(
        '/view_operators',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_operators/list-view_operators-list-2'); // list
        }
    );

    // z_email_settings
    $app->any('/ZEmailSettingsList[/{id}]', ZEmailSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('ZEmailSettingsList-z_email_settings-list'); // list
    $app->any('/ZEmailSettingsAdd[/{id}]', ZEmailSettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('ZEmailSettingsAdd-z_email_settings-add'); // add
    $app->any('/ZEmailSettingsView[/{id}]', ZEmailSettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('ZEmailSettingsView-z_email_settings-view'); // view
    $app->any('/ZEmailSettingsEdit[/{id}]', ZEmailSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ZEmailSettingsEdit-z_email_settings-edit'); // edit
    $app->any('/ZEmailSettingsDelete[/{id}]', ZEmailSettingsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ZEmailSettingsDelete-z_email_settings-delete'); // delete
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
    $app->any('/ViewTransactionsPerOperatorList', ViewTransactionsPerOperatorController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewTransactionsPerOperatorList-view_transactions_per_operator-list'); // list
    $app->any('/ViewTransactionsPerOperatorSearch', ViewTransactionsPerOperatorController::class . ':search')->add(PermissionMiddleware::class)->setName('ViewTransactionsPerOperatorSearch-view_transactions_per_operator-search'); // search
    $app->group(
        '/view_transactions_per_operator',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewTransactionsPerOperatorController::class . ':list')->add(PermissionMiddleware::class)->setName('view_transactions_per_operator/list-view_transactions_per_operator-list-2'); // list
            $group->any('/' . Config("SEARCH_ACTION") . '', ViewTransactionsPerOperatorController::class . ':search')->add(PermissionMiddleware::class)->setName('view_transactions_per_operator/search-view_transactions_per_operator-search-2'); // search
        }
    );

    // view_transactions_per_platform
    $app->any('/ViewTransactionsPerPlatformList', ViewTransactionsPerPlatformController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewTransactionsPerPlatformList-view_transactions_per_platform-list'); // list
    $app->any('/ViewTransactionsPerPlatformSearch', ViewTransactionsPerPlatformController::class . ':search')->add(PermissionMiddleware::class)->setName('ViewTransactionsPerPlatformSearch-view_transactions_per_platform-search'); // search
    $app->group(
        '/view_transactions_per_platform',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewTransactionsPerPlatformController::class . ':list')->add(PermissionMiddleware::class)->setName('view_transactions_per_platform/list-view_transactions_per_platform-list-2'); // list
            $group->any('/' . Config("SEARCH_ACTION") . '', ViewTransactionsPerPlatformController::class . ':search')->add(PermissionMiddleware::class)->setName('view_transactions_per_platform/search-view_transactions_per_platform-search-2'); // search
        }
    );

    // view_vendors_operators
    $app->any('/ViewVendorsOperatorsList', ViewVendorsOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewVendorsOperatorsList-view_vendors_operators-list'); // list
    $app->group(
        '/view_vendors_operators',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewVendorsOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_vendors_operators/list-view_vendors_operators-list-2'); // list
        }
    );

    // view_campaigns_pending
    $app->any('/ViewCampaignsPendingList[/{transaction_id}]', ViewCampaignsPendingController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewCampaignsPendingList-view_campaigns_pending-list'); // list
    $app->any('/ViewCampaignsPendingView[/{transaction_id}]', ViewCampaignsPendingController::class . ':view')->add(PermissionMiddleware::class)->setName('ViewCampaignsPendingView-view_campaigns_pending-view'); // view
    $app->group(
        '/view_campaigns_pending',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{transaction_id}]', ViewCampaignsPendingController::class . ':list')->add(PermissionMiddleware::class)->setName('view_campaigns_pending/list-view_campaigns_pending-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{transaction_id}]', ViewCampaignsPendingController::class . ':view')->add(PermissionMiddleware::class)->setName('view_campaigns_pending/view-view_campaigns_pending-view-2'); // view
        }
    );

    // view_buses_assigned
    $app->any('/ViewBusesAssignedList', ViewBusesAssignedController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewBusesAssignedList-view_buses_assigned-list'); // list
    $app->group(
        '/view_buses_assigned',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewBusesAssignedController::class . ':list')->add(PermissionMiddleware::class)->setName('view_buses_assigned/list-view_buses_assigned-list-2'); // list
        }
    );

    // z_price_settings
    $app->any('/ZPriceSettingsList[/{id}]', ZPriceSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('ZPriceSettingsList-z_price_settings-list'); // list
    $app->any('/ZPriceSettingsView[/{id}]', ZPriceSettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('ZPriceSettingsView-z_price_settings-view'); // view
    $app->any('/ZPriceSettingsEdit[/{id}]', ZPriceSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ZPriceSettingsEdit-z_price_settings-edit'); // edit
    $app->any('/ZPriceSettingsUpdate', ZPriceSettingsController::class . ':update')->add(PermissionMiddleware::class)->setName('ZPriceSettingsUpdate-z_price_settings-update'); // update
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
    $app->any('/WVendorsOperatorsList[/{id}]', WVendorsOperatorsController::class . ':list')->add(PermissionMiddleware::class)->setName('WVendorsOperatorsList-w_vendors_operators-list'); // list
    $app->any('/WVendorsOperatorsAdd[/{id}]', WVendorsOperatorsController::class . ':add')->add(PermissionMiddleware::class)->setName('WVendorsOperatorsAdd-w_vendors_operators-add'); // add
    $app->any('/WVendorsOperatorsView[/{id}]', WVendorsOperatorsController::class . ':view')->add(PermissionMiddleware::class)->setName('WVendorsOperatorsView-w_vendors_operators-view'); // view
    $app->any('/WVendorsOperatorsEdit[/{id}]', WVendorsOperatorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('WVendorsOperatorsEdit-w_vendors_operators-edit'); // edit
    $app->any('/WVendorsOperatorsDelete[/{id}]', WVendorsOperatorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('WVendorsOperatorsDelete-w_vendors_operators-delete'); // delete
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
    $app->any('/ViewAllBusesList[/{id}]', ViewAllBusesController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewAllBusesList-view_all_buses-list'); // list
    $app->group(
        '/view_all_buses',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ViewAllBusesController::class . ':list')->add(PermissionMiddleware::class)->setName('view_all_buses/list-view_all_buses-list-2'); // list
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
    $app->any('/[index]', OthersController::class . ':index')->setName('index');
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

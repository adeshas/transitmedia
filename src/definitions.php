<?php

namespace PHPMaker2021\test;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("log/audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler("log/log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),

    // Tables
    "main_buses" => \DI\create(MainBuses::class),
    "main_campaigns" => \DI\create(MainCampaigns::class),
    "main_reports" => \DI\create(MainReports::class),
    "main_transactions" => \DI\create(MainTransactions::class),
    "main_users" => \DI\create(MainUsers::class),
    "spook" => \DI\create(Spook::class),
    "sub_media_allocation" => \DI\create(SubMediaAllocation::class),
    "sub_renewal_requests" => \DI\create(SubRenewalRequests::class),
    "sub_transaction_details" => \DI\create(SubTransactionDetails::class),
    "view_pricing_initial" => \DI\create(ViewPricingInitial::class),
    "welcome" => \DI\create(Welcome::class),
    "x_bus_depot" => \DI\create(XBusDepot::class),
    "x_bus_sizes" => \DI\create(XBusSizes::class),
    "x_bus_status" => \DI\create(XBusStatus::class),
    "x_transaction_status" => \DI\create(XTransactionStatus::class),
    "x_payment_status" => \DI\create(XPaymentStatus::class),
    "x_print_stage" => \DI\create(XPrintStage::class),
    "x_print_status" => \DI\create(XPrintStatus::class),
    "x_renewal_stage" => \DI\create(XRenewalStage::class),
    "x_report_types" => \DI\create(XReportTypes::class),
    "x_user_types" => \DI\create(XUserTypes::class),
    "y_inventory" => \DI\create(YInventory::class),
    "y_operators" => \DI\create(YOperators::class),
    "y_platforms" => \DI\create(YPlatforms::class),
    "y_vendors" => \DI\create(YVendors::class),
    "z_core_settings" => \DI\create(ZCoreSettings::class),
    "z_email_settings" => \DI\create(ZEmailSettings::class),
    "z_price_settings" => \DI\create(ZPriceSettings::class),
    "view_pricing_all" => \DI\create(ViewPricingAll::class),
    "view_operators_platforms" => \DI\create(ViewOperatorsPlatforms::class),
    "view_pricing_options" => \DI\create(ViewPricingOptions::class),
    "view_bus_trans_options" => \DI\create(ViewBusTransOptions::class),
    "view_buses_interior" => \DI\create(ViewBusesInterior::class),
    "view_buses_exterior" => \DI\create(ViewBusesExterior::class),
    "view_bus_depot_summary" => \DI\create(ViewBusDepotSummary::class),
    "view_bus_int_summary_at_a_glance" => \DI\create(ViewBusIntSummaryAtAGlance::class),
    "view_bus_ext_summary_at_a_glance" => \DI\create(ViewBusExtSummaryAtAGlance::class),
    "view_bus_summary" => \DI\create(ViewBusSummary::class),
    "private_functions" => \DI\create(PrivateFunctions::class),
    "test" => \DI\create(Test::class),
    "paymentshandler" => \DI\create(Paymentshandler::class),
    "view_campaign_status" => \DI\create(ViewCampaignStatus::class),
    "view_payments_pending" => \DI\create(ViewPaymentsPending::class),
    "renewalhandler" => \DI\create(Renewalhandler::class),
    "view_transactions_all" => \DI\create(ViewTransactionsAll::class),
    "view_operators" => \DI\create(ViewOperators::class),
    "w_vendors_operators" => \DI\create(WVendorsOperators::class),
    "view_transactions_per_operator" => \DI\create(ViewTransactionsPerOperator::class),
    "view_transactions_per_platform" => \DI\create(ViewTransactionsPerPlatform::class),
    "view_vendors_operators" => \DI\create(ViewVendorsOperators::class),
    "view_campaigns_pending" => \DI\create(ViewCampaignsPending::class),
    "view_buses_assigned" => \DI\create(ViewBusesAssigned::class),
    "printers" => \DI\create(Printers::class),
    "print_orders" => \DI\create(PrintOrders::class),

    // User table
    "usertable" => \DI\get("main_users"),

    // Detail table pages
    "SubMediaAllocationGrid" => \DI\create(SubMediaAllocationGrid::class),
    "MainUsersGrid" => \DI\create(MainUsersGrid::class),
    "MainBusesGrid" => \DI\create(MainBusesGrid::class),
    "MainCampaignsGrid" => \DI\create(MainCampaignsGrid::class),
    "SubTransactionDetailsGrid" => \DI\create(SubTransactionDetailsGrid::class),
    "YOperatorsGrid" => \DI\create(YOperatorsGrid::class),
    "MainTransactionsGrid" => \DI\create(MainTransactionsGrid::class),
    "ViewBusesAssignedGrid" => \DI\create(ViewBusesAssignedGrid::class),
];

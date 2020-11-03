<?php

namespace PHPMaker2021\test;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
$topMenu->addMenuItem(129, "mci_Home", $MenuLanguage->MenuPhrase("129", "MenuText"), $MenuRelativePath . "welcome", -1, "", IsLoggedIn(), false, true, "", "", true);
$topMenu->addMenuItem(132, "mci_Order_Buses", $MenuLanguage->MenuPhrase("132", "MenuText"), $MenuRelativePath . "maincampaignsadd?showdetail=", -1, "", IsLoggedIn(), false, true, "", "", true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(20, "mi_welcome", $MenuLanguage->MenuPhrase("20", "MenuText"), $MenuRelativePath . "welcome", -1, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}welcome.php'), false, false, "fa-home", "", false);
$sideMenu->addMenuItem(32, "mci_Campaigns", $MenuLanguage->MenuPhrase("32", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-ad", "", false);
$sideMenu->addMenuItem(35, "mci_New_Campaign", $MenuLanguage->MenuPhrase("35", "MenuText"), $MenuRelativePath . "maincampaignsadd?showdetail=", 32, "", IsLoggedIn(), false, true, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(10, "mi_main_campaigns", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "maincampaignslist?cmd=resetall", 32, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}main_campaigns'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(133, "mci_Campaigns/Platform", $MenuLanguage->MenuPhrase("133", "MenuText"), $MenuRelativePath . "yplatformslist", 32, "", IsLoggedIn(), false, true, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(33, "mci_Buses", $MenuLanguage->MenuPhrase("33", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-bus", "", false);
$sideMenu->addMenuItem(13, "mi_main_buses", $MenuLanguage->MenuPhrase("13", "MenuText"), $MenuRelativePath . "mainbuseslist?cmd=resetall", 33, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}main_buses'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(178, "mi_view_buses_exterior", $MenuLanguage->MenuPhrase("178", "MenuText"), $MenuRelativePath . "viewbusesexteriorlist", 33, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}view_buses_exterior'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(177, "mi_view_buses_interior", $MenuLanguage->MenuPhrase("177", "MenuText"), $MenuRelativePath . "viewbusesinteriorlist", 33, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}view_buses_interior'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(98, "mci_Transactions", $MenuLanguage->MenuPhrase("98", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-search-dollar", "", false);
$sideMenu->addMenuItem(174, "mci_New_Transaction", $MenuLanguage->MenuPhrase("174", "MenuText"), $MenuRelativePath . "maintransactionsadd", 98, "", IsLoggedIn(), false, true, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(63, "mi_main_transactions", $MenuLanguage->MenuPhrase("63", "MenuText"), $MenuRelativePath . "maintransactionslist?cmd=resetall", 98, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}main_transactions'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(65, "mi_sub_transaction_details", $MenuLanguage->MenuPhrase("65", "MenuText"), $MenuRelativePath . "subtransactiondetailslist?cmd=resetall", 98, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}sub_transaction_details'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(14, "mi_sub_media_allocation", $MenuLanguage->MenuPhrase("14", "MenuText"), $MenuRelativePath . "submediaallocationlist?cmd=resetall", 98, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}sub_media_allocation'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(64, "mi_sub_renewal_requests", $MenuLanguage->MenuPhrase("64", "MenuText"), $MenuRelativePath . "subrenewalrequestslist", 98, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}sub_renewal_requests'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(34, "mci_Reports", $MenuLanguage->MenuPhrase("34", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-chart-pie", "", false);
$sideMenu->addMenuItem(60, "mi_main_reports", $MenuLanguage->MenuPhrase("60", "MenuText"), $MenuRelativePath . "mainreportslist", 34, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}main_reports'), false, false, "fa-chart-line", "", false);
$sideMenu->addMenuItem(182, "mi_view_bus_summary", $MenuLanguage->MenuPhrase("182", "MenuText"), $MenuRelativePath . "viewbussummarylist", 34, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}view_bus_summary'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(181, "mi_view_bus_ext_summary_at_a_glance", $MenuLanguage->MenuPhrase("181", "MenuText"), $MenuRelativePath . "viewbusextsummaryataglancelist", 34, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}view_bus_ext_summary_at_a_glance'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(180, "mi_view_bus_int_summary_at_a_glance", $MenuLanguage->MenuPhrase("180", "MenuText"), $MenuRelativePath . "viewbusintsummaryataglancelist", 34, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}view_bus_int_summary_at_a_glance'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(179, "mi_view_bus_depot_summary", $MenuLanguage->MenuPhrase("179", "MenuText"), $MenuRelativePath . "viewbusdepotsummarylist", 34, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}view_bus_depot_summary'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(185, "mi_view_payments_pending", $MenuLanguage->MenuPhrase("185", "MenuText"), $MenuRelativePath . "viewpaymentspendinglist", 34, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}view_payments_pending'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(184, "mi_view_payments_tracker", $MenuLanguage->MenuPhrase("184", "MenuText"), $MenuRelativePath . "viewpaymentstrackerlist", 34, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}view_payments_tracker'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(183, "mi_view_campaigns_pending", $MenuLanguage->MenuPhrase("183", "MenuText"), $MenuRelativePath . "viewcampaignspendinglist", 34, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}view_campaigns_pending'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(95, "mci_Others", $MenuLanguage->MenuPhrase("95", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-adjust", "", false);
$sideMenu->addMenuItem(1, "mi_main_users", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "mainuserslist?cmd=resetall", 95, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}main_users'), false, false, "fa-user", "", false);
$sideMenu->addMenuItem(8, "mi_y_platforms", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "yplatformslist", 95, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}y_platforms'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(5, "mi_y_inventory", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "yinventorylist", 95, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}y_inventory'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(7, "mi_y_operators", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "yoperatorslist?cmd=resetall", 95, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}y_operators'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(57, "mi_y_vendors", $MenuLanguage->MenuPhrase("57", "MenuText"), $MenuRelativePath . "yvendorslist", 95, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}y_vendors'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(56, "mci_Settings", $MenuLanguage->MenuPhrase("56", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-cog", "", false);
$sideMenu->addMenuItem(96, "mci_Main_Config", $MenuLanguage->MenuPhrase("96", "MenuText"), "", 56, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(61, "mi_z_core_settings", $MenuLanguage->MenuPhrase("61", "MenuText"), $MenuRelativePath . "zcoresettingslist", 96, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}z_core_settings'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(62, "mi_z_email_settings", $MenuLanguage->MenuPhrase("62", "MenuText"), $MenuRelativePath . "zemailsettingslist", 96, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}z_email_settings'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(6, "mi_z_price_settings", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "zpricesettingslist", 96, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}z_price_settings'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(97, "mci_Sub_Config", $MenuLanguage->MenuPhrase("97", "MenuText"), "", 56, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(58, "mi_x_user_types", $MenuLanguage->MenuPhrase("58", "MenuText"), $MenuRelativePath . "xusertypeslist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_user_types'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(59, "mi_x_report_types", $MenuLanguage->MenuPhrase("59", "MenuText"), $MenuRelativePath . "xreporttypeslist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_report_types'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(16, "mi_x_bus_depot", $MenuLanguage->MenuPhrase("16", "MenuText"), $MenuRelativePath . "xbusdepotlist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_bus_depot'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(9, "mi_x_print_stage", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "xprintstagelist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_print_stage'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(17, "mi_x_print_status", $MenuLanguage->MenuPhrase("17", "MenuText"), $MenuRelativePath . "xprintstatuslist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_print_status'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(19, "mi_x_payment_status", $MenuLanguage->MenuPhrase("19", "MenuText"), $MenuRelativePath . "xpaymentstatuslist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_payment_status'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(67, "mi_x_renewal_stage", $MenuLanguage->MenuPhrase("67", "MenuText"), $MenuRelativePath . "xrenewalstagelist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_renewal_stage'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(18, "mi_x_campaign_status", $MenuLanguage->MenuPhrase("18", "MenuText"), $MenuRelativePath . "xcampaignstatuslist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_campaign_status'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(15, "mi_x_bus_status", $MenuLanguage->MenuPhrase("15", "MenuText"), $MenuRelativePath . "xbusstatuslist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_bus_status'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(4, "mi_x_bus_sizes", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "xbussizeslist", 97, "", AllowListMenu('{7CA6B0F7-61EF-4DB7-A152-ED7AD2382C98}x_bus_sizes'), false, false, "fa-angle-double-right fas", "", false);
$sideMenu->addMenuItem(129, "mci_Home", $MenuLanguage->MenuPhrase("129", "MenuText"), $MenuRelativePath . "welcome", -1, "", IsLoggedIn(), false, true, "", "", true);
$sideMenu->addMenuItem(132, "mci_Order_Buses", $MenuLanguage->MenuPhrase("132", "MenuText"), $MenuRelativePath . "maincampaignsadd?showdetail=", -1, "", IsLoggedIn(), false, true, "", "", true);
echo $sideMenu->toScript();

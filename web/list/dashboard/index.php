<?php
// Init
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/hestia/php-error.log');
ob_start();
// session_start(); // Handled by main.php
include $_SERVER["HESTIA"] . "/web/inc/main.php";

// Check permissions
if (!isset($_SESSION["user"])) {
    header("Location: /login/");
    exit();
}

// Route to Admin or User Dashboard
if ($_SESSION["userContext"] === "admin" && empty($_SESSION["look"])) {
    render_page($user, "DASHBOARD", "list_dashboard_admin");
} else {
    render_page($user, "DASHBOARD", "list_dashboard");
}

// Flush ob
ob_end_flush();

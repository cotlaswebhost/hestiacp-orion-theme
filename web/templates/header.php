<!doctype html>
<html class="no-js" lang="<?= $_SESSION["LANGUAGE"] ?>">

<head>
<?php
require $_SERVER["HESTIA"] . "/web/templates/includes/title.php";
require $_SERVER["HESTIA"] . "/web/templates/includes/css.php";
// Include custom Orion Theme CSS
if (file_exists($_SERVER["HESTIA"] . "/web/css/custom/orion-ui.css")) {
    echo '<link rel="stylesheet" href="/css/custom/orion-ui.css?v=' . time() . '">';
}
require $_SERVER["HESTIA"] . "/web/templates/includes/js.php";
?>
</head>

<body class="page-<?= strtolower($TAB) ?> lang-<?= $_SESSION["language"] ?>">
	<div class="app">

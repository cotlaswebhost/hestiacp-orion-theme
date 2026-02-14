<!doctype html>
<html class="no-js" lang="<?= $_SESSION["LANGUAGE"] ?>">

<head>
<?php
require $_SERVER["HESTIA"] . "/web/templates/includes/title.php";
require $_SERVER["HESTIA"] . "/web/templates/includes/css.php";
// Include custom user CSS if exists
if (file_exists($_SERVER["HESTIA"] . "/web/css/custom/orion-custom.css")) {
    echo '<link rel="stylesheet" href="/css/custom/orion-custom.css?v=' . time() . '">';
}
require $_SERVER["HESTIA"] . "/web/templates/includes/js.php";
?>
</head>

<body class="page-<?= strtolower($TAB) ?> lang-<?= $_SESSION["language"] ?>">
	<div class="app">

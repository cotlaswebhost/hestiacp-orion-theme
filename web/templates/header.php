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

// Custom Favicon Logic
$favicon_link = '<link rel="icon" href="/images/favicon.ico" type="image/x-icon">';
if (file_exists($_SERVER['HESTIA'] . '/web/inc/orion_config.json')) {
    $theme_config = json_decode(file_get_contents($_SERVER['HESTIA'] . '/web/inc/orion_config.json'), true);
    if (!empty($theme_config['favicon_ext'])) {
        $custom_favicon = '/images/custom-favicon.' . $theme_config['favicon_ext'];
        if (file_exists($_SERVER['HESTIA'] . '/web' . $custom_favicon)) {
            $mime_type = 'image/x-icon';
            if ($theme_config['favicon_ext'] == 'svg') $mime_type = 'image/svg+xml';
            if ($theme_config['favicon_ext'] == 'png') $mime_type = 'image/png';
            $favicon_link = '<link rel="icon" href="' . $custom_favicon . '" type="' . $mime_type . '">';
        }
    }
}
// We echo the favicon script or manually inject it because title.php usually includes the default favicon.
// Hestia's title.php might already include a favicon. Let's check title.php first or just append this to override.
// Actually, standard Hestia title.php includes favicon. We can't easily remove it without editing title.php.
// But adding another link tag usually overrides the previous one in modern browsers.
echo $favicon_link;

require $_SERVER["HESTIA"] . "/web/templates/includes/js.php";
?>
</head>

<body class="page-<?= strtolower($TAB) ?> lang-<?= $_SESSION["language"] ?>">
	<div class="app">

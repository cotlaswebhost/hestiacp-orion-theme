<?php
// Init
error_reporting(E_ALL);
ini_set('display_errors', 0); // Hide errors on page, check logs
session_start();

// Include system
require_once($_SERVER['HESTIA'] . '/web/inc/main.php');

// Check user
if ($_SESSION['userContext'] != 'admin') {
    header("Location: /list/user/");
    exit;
}

$user = $_SESSION['user'];
$token = $_SESSION['token'];

// Define paths
$theme_css_path = $_SERVER['HESTIA'] . '/web/css/custom/orion-custom.css';
$theme_config_path = $_SERVER['HESTIA'] . '/web/inc/orion_config.json';
$theme_logo_path = $_SERVER['HESTIA'] . '/web/images/custom-logo.svg'; // Standardize on SVG for simplicity if possible, but handle uploads

// Load existing config
$config = [];
if (file_exists($theme_config_path)) {
    $config = json_decode(file_get_contents($theme_config_path), true);
}

// Defaults
$css_content = "";
if (file_exists($theme_css_path)) {
    $css_content = file_get_contents($theme_css_path);
}

$logo_height = isset($config['logo_height']) ? $config['logo_height'] : '50px';
$logo_width = isset($config['logo_width']) ? $config['logo_width'] : 'auto';
$login_logo_height = isset($config['login_logo_height']) ? $config['login_logo_height'] : '100px';

// Handle Form Submission
if (!empty($_POST) && $token == $_POST['token']) {
    
    // Save CSS
    if (isset($_POST['custom_css'])) {
        $css_content = $_POST['custom_css'];
        
        // Use temp file and CLI to write securely
        $temp_file = tempnam(sys_get_temp_dir(), 'orion_css');
        file_put_contents($temp_file, $css_content);
        
        exec(HESTIA_CMD . "v-update-orion-theme " . escapeshellarg($temp_file) . " css", $output, $return_var);
        unlink($temp_file);
        
        if ($return_var != 0) {
             $_SESSION['error_msg'] = _('Error saving CSS');
        }
    }
    
    // Save Dimensions
    $config['logo_height'] = $_POST['logo_height'];
    $config['logo_width'] = $_POST['logo_width'];
    $config['login_logo_height'] = $_POST['login_logo_height'];
    
    $temp_config = tempnam(sys_get_temp_dir(), 'orion_conf');
    file_put_contents($temp_config, json_encode($config, JSON_PRETTY_PRINT));
    
    exec(HESTIA_CMD . "v-update-orion-theme " . escapeshellarg($temp_config) . " config", $output, $return_var);
    unlink($temp_config);
    
    // Handle Logo Upload
    if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] == 0) {
        $allowed = ['image/svg+xml', 'image/png', 'image/jpeg', 'image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['logo_file']['tmp_name']);
        
        if (in_array($mime, $allowed)) {
            // Determine extension
            $ext = 'svg';
            if ($mime == 'image/png') $ext = 'png';
            if ($mime == 'image/jpeg') $ext = 'jpg';
            if ($mime == 'image/gif') $ext = 'gif';
            
            // Use CLI to move file to protected directory
            exec(HESTIA_CMD . "v-update-orion-theme " . escapeshellarg($_FILES['logo_file']['tmp_name']) . " logo " . $ext, $output, $return_var);
            
            if ($return_var == 0) {
                // Update config with new extension
                $config['logo_ext'] = $ext;
                $temp_config = tempnam(sys_get_temp_dir(), 'orion_conf');
                file_put_contents($temp_config, json_encode($config, JSON_PRETTY_PRINT));
                exec(HESTIA_CMD . "v-update-orion-theme " . escapeshellarg($temp_config) . " config", $output, $return_var);
                unlink($temp_config);
                
                $_SESSION['error_msg'] = _('Theme updated successfully');
            } else {
                $_SESSION['error_msg'] = _('Error uploading logo');
            }
        } else {
            $_SESSION['error_msg'] = _('Invalid file type');
        }
    }
    
    // Handle Favicon Upload
    if (isset($_FILES['favicon_file']) && $_FILES['favicon_file']['error'] == 0) {
        $allowed = ['image/svg+xml', 'image/png', 'image/vnd.microsoft.icon', 'image/x-icon'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['favicon_file']['tmp_name']);
        
        if (in_array($mime, $allowed)) {
            // Determine extension
            $ext = 'svg';
            if ($mime == 'image/png') $ext = 'png';
            if ($mime == 'image/vnd.microsoft.icon' || $mime == 'image/x-icon') $ext = 'ico';
            
            // Use CLI to move file to protected directory
            exec(HESTIA_CMD . "v-update-orion-theme " . escapeshellarg($_FILES['favicon_file']['tmp_name']) . " favicon " . $ext, $output, $return_var);
            
            if ($return_var == 0) {
                // Update config with new extension
                $config['favicon_ext'] = $ext;
                $temp_config = tempnam(sys_get_temp_dir(), 'orion_conf');
                file_put_contents($temp_config, json_encode($config, JSON_PRETTY_PRINT));
                exec(HESTIA_CMD . "v-update-orion-theme " . escapeshellarg($temp_config) . " config", $output, $return_var);
                unlink($temp_config);
                
                $_SESSION['error_msg'] = _('Theme updated successfully');
            } else {
                $_SESSION['error_msg'] = _('Error uploading favicon');
            }
        } else {
            $_SESSION['error_msg'] = _('Invalid favicon file type');
        }
    }

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = _('Theme settings saved');
    }
    
    // Redirect to avoid resubmission
    header("Location: /edit/theme/");
    exit;
}

// Render Page
require_once($_SERVER['HESTIA'] . '/web/templates/header.php');
require_once($_SERVER['HESTIA'] . '/web/templates/includes/panel.php');

// Check writability for UI feedback
// Note: We use CLI to write, but if CLI fails, we might want to warn. 
// Actually, checking is_writable here is misleading now because we use sudo wrapper.
// So we remove the checks or just verify if CLI works.
// We'll trust the CLI execution result.


require_once($_SERVER['HESTIA'] . '/web/templates/pages/edit_theme.php');
require_once($_SERVER['HESTIA'] . '/web/templates/includes/footer.php');

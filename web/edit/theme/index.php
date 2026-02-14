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
        file_put_contents($theme_css_path, $css_content);
    }
    
    // Save Dimensions
    $config['logo_height'] = $_POST['logo_height'];
    $config['logo_width'] = $_POST['logo_width'];
    $config['login_logo_height'] = $_POST['login_logo_height'];
    
    file_put_contents($theme_config_path, json_encode($config, JSON_PRETTY_PRINT));
    
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
            
            $target = $_SERVER['HESTIA'] . '/web/images/custom-logo.' . $ext;
            
            // Remove old custom logos to avoid confusion
            foreach(['svg', 'png', 'jpg', 'gif'] as $e) {
                if (file_exists($_SERVER['HESTIA'] . '/web/images/custom-logo.' . $e)) {
                    unlink($_SERVER['HESTIA'] . '/web/images/custom-logo.' . $e);
                }
            }
            
            // Try move_uploaded_file first
            $moved = move_uploaded_file($_FILES['logo_file']['tmp_name'], $target);
            
            // Fallback to copy if move fails (sometimes helpful with permission quirks)
            if (!$moved) {
                $moved = copy($_FILES['logo_file']['tmp_name'], $target);
            }
            
            if ($moved) {
                // Ensure readability
                chmod($target, 0644);
                
                $config['logo_ext'] = $ext;
                file_put_contents($theme_config_path, json_encode($config, JSON_PRETTY_PRINT));
                $_SESSION['error_msg'] = _('Theme updated successfully');
            } else {
                // Debugging
                $error = error_get_last();
                $_SESSION['error_msg'] = _('Error uploading logo: ') . ($error['message'] ?? 'Unknown error');
            }
        } else {
            $_SESSION['error_msg'] = _('Invalid file type');
        }
    } else {
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
if (!is_writable($theme_config_path)) {
    echo '<div class="alert alert-danger" style="margin: 20px;">' . _('Warning: Configuration file is not writable. Please check permissions for ') . $theme_config_path . '</div>';
}
if (!is_writable(dirname($theme_logo_path))) {
    echo '<div class="alert alert-danger" style="margin: 20px;">' . _('Warning: Images directory is not writable. Logo upload may fail. Please check permissions for ') . dirname($theme_logo_path) . '</div>';
}

require_once($_SERVER['HESTIA'] . '/web/templates/pages/edit_theme.php');
require_once($_SERVER['HESTIA'] . '/web/templates/includes/footer.php');

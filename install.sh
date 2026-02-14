#!/bin/bash

# HestiaCP Orion Theme Installer
# Installs the Orion Theme (Hostniki) for HestiaCP

THEME_DIR=$(dirname "$0")
HESTIA_WEB_DIR="/usr/local/hestia/web"
BACKUP_DIR="/root/hestiacp-theme-backup-$(date +%Y%m%d%H%M%S)"

echo "Starting Orion Theme Installation..."

# 1. Create Backup
echo "Creating backup of existing files to $BACKUP_DIR..."
mkdir -p "$BACKUP_DIR"

backup_file() {
    local file="$1"
    local rel_path="${file#$HESTIA_WEB_DIR/}"
    local backup_path="$BACKUP_DIR/$rel_path"
    
    if [ -f "$file" ]; then
        mkdir -p "$(dirname "$backup_path")"
        cp "$file" "$backup_path"
        echo "Backed up: $rel_path"
    fi
}

# List of files to backup (matching the structure we are installing)
backup_file "$HESTIA_WEB_DIR/css/custom/orion-ui.css"
backup_file "$HESTIA_WEB_DIR/css/themes/custom/orion.css"
backup_file "$HESTIA_WEB_DIR/css/themes/custom/orion.min.css"
backup_file "$HESTIA_WEB_DIR/inc/main.php"
backup_file "$HESTIA_WEB_DIR/inc/prevent_csrf.php"
backup_file "$HESTIA_WEB_DIR/inc/version.php"
backup_file "$HESTIA_WEB_DIR/list/dashboard/index.php"
backup_file "$HESTIA_WEB_DIR/login/index.php"
backup_file "$HESTIA_WEB_DIR/templates/header.php"
backup_file "$HESTIA_WEB_DIR/templates/includes/panel.php"
backup_file "$HESTIA_WEB_DIR/templates/includes/panel_orion.php"
backup_file "$HESTIA_WEB_DIR/templates/pages/list_dashboard.php"
backup_file "$HESTIA_WEB_DIR/templates/pages/list_dashboard_admin.php"
backup_file "$HESTIA_WEB_DIR/templates/pages/edit_theme.php"
backup_file "$HESTIA_WEB_DIR/edit/theme/index.php"
backup_file "$HESTIA_WEB_DIR/templates/pages/login/login.php"
backup_file "$HESTIA_WEB_DIR/templates/pages/login/login_1.php"
backup_file "$HESTIA_WEB_DIR/templates/pages/login/login_2.php"
backup_file "$HESTIA_WEB_DIR/templates/pages/login/login_a.php"
backup_file "$HESTIA_WEB_DIR/images/logo.svg"

# 2. Install New Files
echo "Installing new theme files..."

cp -rf "$THEME_DIR/web/"* "$HESTIA_WEB_DIR/"

# Ensure custom CSS file exists or is writable if it doesn't
touch "$HESTIA_WEB_DIR/css/custom/orion-custom.css"
touch "$HESTIA_WEB_DIR/inc/orion_config.json"

# 3. Set Permissions
echo "Setting permissions..."
chown -R root:root "$HESTIA_WEB_DIR"

# Allow hestiaweb user (admin panel) to write to specific directories for theme customization
# We use 777 to be absolutely sure it works across different system configurations,
# as strict ownership (chown) can sometimes be reset or vary by setup.
chmod 777 "$HESTIA_WEB_DIR/images/"

chmod 777 "$HESTIA_WEB_DIR/css/custom/"
chmod 666 "$HESTIA_WEB_DIR/css/custom/orion-custom.css" 2>/dev/null || touch "$HESTIA_WEB_DIR/css/custom/orion-custom.css" && chmod 666 "$HESTIA_WEB_DIR/css/custom/orion-custom.css"

chmod 777 "$HESTIA_WEB_DIR/inc/"
chmod 666 "$HESTIA_WEB_DIR/inc/orion_config.json" 2>/dev/null || touch "$HESTIA_WEB_DIR/inc/orion_config.json" && chmod 666 "$HESTIA_WEB_DIR/inc/orion_config.json"
find "$HESTIA_WEB_DIR" -type f -exec chmod 644 {} \;
find "$HESTIA_WEB_DIR" -type d -exec chmod 755 {} \;

echo "Installation complete!"
echo "Please clear your browser cache and hard refresh to see changes."

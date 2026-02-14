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
backup_file "$HESTIA_WEB_DIR/images/logo.svg"

# 2. Install New Files
echo "Installing new theme files..."

cp -rf "$THEME_DIR/web/"* "$HESTIA_WEB_DIR/"

# 3. Set Permissions
echo "Setting permissions..."
chown -R root:root "$HESTIA_WEB_DIR"
find "$HESTIA_WEB_DIR" -type f -exec chmod 644 {} \;
find "$HESTIA_WEB_DIR" -type d -exec chmod 755 {} \;

echo "Installation complete!"
echo "Please clear your browser cache and hard refresh to see changes."

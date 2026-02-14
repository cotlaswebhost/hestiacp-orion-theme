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

# Install CLI helper securely
cp "$THEME_DIR/bin/v-update-orion-theme" "/usr/local/hestia/bin/"
chmod 755 "/usr/local/hestia/bin/v-update-orion-theme"
chown root:root "/usr/local/hestia/bin/v-update-orion-theme"

# Ensure custom CSS file exists or is writable if it doesn't
# Note: With the CLI helper, these can remain root-owned and read-only for others
touch "$HESTIA_WEB_DIR/css/custom/orion-custom.css"
touch "$HESTIA_WEB_DIR/inc/orion_config.json"

# 3. Set Permissions
echo "Setting permissions..."
chown -R root:root "$HESTIA_WEB_DIR"

# Allow hestiaweb user (admin panel) to write to specific directories for theme customization
# REVERTED 777: We now use v-update-orion-theme via sudo wrapper, so these directories 
# can remain secure (root:root 755).
# We just ensure they exist.

# Ensure directories exist
mkdir -p "$HESTIA_WEB_DIR/images/"
mkdir -p "$HESTIA_WEB_DIR/css/custom/"
mkdir -p "$HESTIA_WEB_DIR/inc/"

# Reset permissions to secure defaults
chown root:root "$HESTIA_WEB_DIR/images/"
chmod 755 "$HESTIA_WEB_DIR/images/"

chown root:root "$HESTIA_WEB_DIR/css/custom/"
chmod 755 "$HESTIA_WEB_DIR/css/custom/"
chown root:root "$HESTIA_WEB_DIR/css/custom/orion-custom.css"
chmod 644 "$HESTIA_WEB_DIR/css/custom/orion-custom.css"

chown root:root "$HESTIA_WEB_DIR/inc/"
chmod 755 "$HESTIA_WEB_DIR/inc/"
chown root:root "$HESTIA_WEB_DIR/inc/orion_config.json"
chmod 644 "$HESTIA_WEB_DIR/inc/orion_config.json"

find "$HESTIA_WEB_DIR" -type f -exec chmod 644 {} \;
find "$HESTIA_WEB_DIR" -type d -exec chmod 755 {} \;

# Make sure our binary is executable (again, just in case find rewrote it)
chmod 755 "/usr/local/hestia/bin/v-update-orion-theme"

echo "Installation complete!"
echo "Please clear your browser cache and hard refresh to see changes."

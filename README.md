# HestiaCP Orion Theme (Hostniki)

A custom dashboard theme for Hestia Control Panel that provides a modern, clean interface for both Admin and User views.

## Features
- **Modern UI**: Clean, card-based dashboard layout.
- **Improved Navigation**: Simplified sidebar and top navigation.
- **Enhanced Dashboard**:
  - **Admin**: Shows total system users, disk usage, server info, and Hestia version.
  - **User**: Shows primary domain, disk usage, bandwidth, and quick links to common tasks.
- **Fixes**: Includes fixes for session handling, CSRF validation on custom pages, and domain counting logic.

## Installation

1. Clone this repository to your HestiaCP server (as root):
   ```bash
   git clone https://github.com/yourusername/hestiacp-orion-theme.git
   cd hestiacp-orion-theme
   ```

2. Run the installation script:
   ```bash
   chmod +x install.sh
   ./install.sh
   ```

3. Clear your browser cache and hard refresh (Ctrl+F5) to see the changes.

## Customization

### Changing the Logo
To change the logo displayed in the sidebar and login page:

1. Prepare your logo image (recommended format: SVG or PNG, transparent background).
2. Replace the existing logo file at:
   `/usr/local/hestia/web/images/logo.svg`
   (or `logo.png` depending on what is referenced in `header.php` css).

### Reverting Changes
The installation script creates a backup of all modified files in `/root/hestiacp-theme-backup-[timestamp]`. To revert, simply copy these files back to their original locations in `/usr/local/hestia/web/`.

## Compatibility
Tested with HestiaCP v1.9.x.

## Disclaimer
This theme modifies core HestiaCP files. While it includes backup functionality, please use at your own risk and test in a staging environment first. HestiaCP updates may overwrite these changes, so you might need to reinstall the theme after updating HestiaCP.

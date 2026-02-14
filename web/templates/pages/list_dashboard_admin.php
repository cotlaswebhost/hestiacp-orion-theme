<!-- Begin Admin Dashboard -->
<div class="container user-dashboard">

    <!-- Server Specs Block -->
    <div class="dash-section" style="margin-bottom: 30px; background: #fff; padding: 25px; border-radius: 10px; border: 1px solid rgba(0,0,0,0.1);">
        <div class="dash-section-header" style="margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <i class="fas fa-server"></i>
            <h2><?= _("Server Information") ?></h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <strong style="display: block; color: #64748b; font-size: 0.85rem; margin-bottom: 5px;"><?= _("Hostname") ?></strong>
                <span style="font-size: 1.1rem; font-weight: 600; color: #1e293b;"><?= $_SERVER['HTTP_HOST'] ?></span>
            </div>
            <div>
                <strong style="display: block; color: #64748b; font-size: 0.85rem; margin-bottom: 5px;"><?= _("OS") ?></strong>
                <span style="font-size: 1.1rem; font-weight: 600; color: #1e293b;">
                    <?php 
                        $os_release = shell_exec('cat /etc/os-release | grep "PRETTY_NAME" | cut -d= -f2 | tr -d \'"\'');
                        echo $os_release ? trim($os_release) : 'Linux';
                    ?>
                </span>
            </div>
            <div>
                <strong style="display: block; color: #64748b; font-size: 0.85rem; margin-bottom: 5px;"><?= _("Uptime") ?></strong>
                <span style="font-size: 1.1rem; font-weight: 600; color: #1e293b;">
                    <?php 
                        $uptime = shell_exec("uptime -p"); 
                        echo str_replace("up ", "", $uptime);
                    ?>
                </span>
            </div>
            <div>
                <strong style="display: block; color: #64748b; font-size: 0.85rem; margin-bottom: 5px;"><?= _("Hestia Version") ?></strong>
                <span style="font-size: 1.1rem; font-weight: 600; color: #1e293b;">
                    <?php 
                        if (file_exists($_SERVER['HESTIA'].'/web/inc/version.php')) {
                            include $_SERVER['HESTIA'].'/web/inc/version.php';
                        }
                        echo defined('HESTIA_VERSION') ? HESTIA_VERSION : 'Unknown'; 
                    ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Top Stats Cards -->
    <div class="dash-blocks u-mb30">
        <div class="dash-card">
            <div class="dash-card-icon bg-purple">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="dash-card-content">
                <span class="dash-label"><?= _("Admin User") ?></span>
                <span class="dash-value"><?= $user ?></span>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-card-icon bg-blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="dash-card-content">
                <span class="dash-label"><?= _("Total Users") ?></span>
                <span class="dash-value">
                    <?php
                        // Fetch system wide user count
                        $total_users = 0;
                        exec(HESTIA_CMD . "v-list-users json", $output, $return_var);
                        if ($return_var == 0) {
                            $users_list = json_decode(implode("", $output), true);
                            $total_users = count($users_list);
                            unset($output);
                        }
                        
                        // Fallback: If exec failed, try to check if we can get it from admin stats
                        if ($total_users == 0 && isset($panel[$user]['U_USERS'])) {
                             $total_users = $panel[$user]['U_USERS'];
                        }
                        
                        echo $total_users;
                    ?>
                </span>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-card-icon bg-green">
                <i class="fas fa-server"></i>
            </div>
            <div class="dash-card-content">
                <span class="dash-label"><?= _("Disk Usage") ?></span>
                <span class="dash-value">
                    <?php
                        // Calculate total disk usage across all users
                        $total_disk_usage = 0;
                        $total_disk_quota = 0;
                        
                        // Execute v-list-users to get data for all users
                        exec(HESTIA_CMD . "v-list-users json", $output, $return_var);
                        if ($return_var == 0) {
                            $users_list = json_decode(implode("", $output), true);
                            if (is_array($users_list)) {
                                foreach ($users_list as $u) {
                                    // U_DISK is usually in MB
                                    if (isset($u['U_DISK'])) {
                                        $total_disk_usage += intval($u['U_DISK']);
                                    }
                                    // Sum quotas if needed, though usually "server" quota is hard to define sum-wise if some are unlimited
                                    // But let's just show usage for now or usage / infinity if we treat server as infinite
                                }
                            }
                            unset($output);
                        }
                        
                        echo humanize_usage_size($total_disk_usage) . " " . humanize_usage_measure($total_disk_usage) . " / ∞";
                    ?>
                </span>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-card-icon bg-orange">
                <i class="fas fa-bolt"></i>
            </div>
            <div class="dash-card-content">
                <span class="dash-label"><?= _("Load Average") ?></span>
                <span class="dash-value"><?= sys_getloadavg()[0] ?></span>
            </div>
        </div>
    </div>

    <!-- Server Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-server"></i>
            <h2><?= _("Server Management") ?></h2>
        </div>
        <div class="dash-icons-grid">
            <a href="/list/server/" class="dash-icon-item">
                <div class="dash-icon-circle text-blue">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <span><?= _("Configure") ?></span>
            </a>
            <a href="/list/rrd/" class="dash-icon-item">
                <div class="dash-icon-circle text-green">
                    <i class="fas fa-chart-area"></i>
                </div>
                <span><?= _("Task Monitor") ?></span>
            </a>
            <a href="/list/updates/" class="dash-icon-item">
                <div class="dash-icon-circle text-orange">
                    <i class="fas fa-sync"></i>
                </div>
                <span><?= _("Updates") ?></span>
            </a>
            <a href="/list/log/" class="dash-icon-item">
                <div class="dash-icon-circle text-gray">
                    <i class="fas fa-list-alt"></i>
                </div>
                <span><?= _("Logs") ?></span>
            </a>
            <a href="/list/server/?restart=yes" class="dash-icon-item">
                <div class="dash-icon-circle text-red">
                    <i class="fas fa-power-off"></i>
                </div>
                <span><?= _("Restart Services") ?></span>
            </a>
            <a href="/list/ip/" class="dash-icon-item">
                <div class="dash-icon-circle text-purple">
                    <i class="fas fa-network-wired"></i>
                </div>
                <span><?= _("IP / Networks") ?></span>
            </a>
            <a href="/edit/server/" class="dash-icon-item">
                <div class="dash-icon-circle text-blue">
                    <i class="fas fa-tag"></i>
                </div>
                <span><?= _("White Label") ?></span>
            </a>
             <a href="/list/cron/" class="dash-icon-item">
                <div class="dash-icon-circle text-gray">
                    <i class="fas fa-clock"></i>
                </div>
                <span><?= _("Cron Jobs") ?></span>
            </a>
        </div>
    </div>

    <!-- Firewall Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-shield-alt"></i>
            <h2><?= _("Firewall") ?></h2>
        </div>
        <div class="dash-icons-grid">
            <a href="/list/firewall/" class="dash-icon-item">
                <div class="dash-icon-circle text-red">
                    <i class="fas fa-fire-alt"></i>
                </div>
                <span><?= _("Firewall Rules") ?></span>
            </a>
            <a href="/add/firewall/" class="dash-icon-item">
                <div class="dash-icon-circle text-green">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <span><?= _("Add Rule") ?></span>
            </a>
            <a href="/list/firewall/banlist/" class="dash-icon-item">
                <div class="dash-icon-circle text-orange">
                    <i class="fas fa-ban"></i>
                </div>
                <span><?= _("Banned IPs") ?></span>
            </a>
             <a href="/list/firewall/ipset/" class="dash-icon-item">
                <div class="dash-icon-circle text-blue">
                    <i class="fas fa-list"></i>
                </div>
                <span><?= _("IP Sets") ?></span>
            </a>
        </div>
    </div>

    <!-- Users Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-users"></i>
            <h2><?= _("Users") ?></h2>
        </div>
        <div class="dash-icons-grid">
            <a href="/list/user/" class="dash-icon-item">
                <div class="dash-icon-circle text-purple">
                    <i class="fas fa-users"></i>
                </div>
                <span><?= _("All Users") ?></span>
            </a>
            <a href="/add/user/" class="dash-icon-item">
                <div class="dash-icon-circle text-green">
                    <i class="fas fa-user-plus"></i>
                </div>
                <span><?= _("Add User") ?></span>
            </a>
        </div>
    </div>

    <!-- Packages Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-box"></i>
            <h2><?= _("Packages") ?></h2>
        </div>
        <div class="dash-icons-grid">
            <a href="/list/package/" class="dash-icon-item">
                <div class="dash-icon-circle text-blue">
                    <i class="fas fa-cubes"></i>
                </div>
                <span><?= _("All Packages") ?></span>
            </a>
            <a href="/add/package/" class="dash-icon-item">
                <div class="dash-icon-circle text-green">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <span><?= _("Add Package") ?></span>
            </a>
        </div>
    </div>

    <!-- Files Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-folder"></i>
            <h2><?= _("Files & Backups") ?></h2>
        </div>
        <div class="dash-icons-grid">
            <a href="/fm/" target="_blank" class="dash-icon-item">
                <div class="dash-icon-circle text-yellow">
                    <i class="fas fa-folder-open"></i>
                </div>
                <span><?= _("File Manager") ?></span>
            </a>
            <a href="/list/backup/" class="dash-icon-item">
                <div class="dash-icon-circle text-blue">
                    <i class="fas fa-file-zipper"></i>
                </div>
                <span><?= _("Backups") ?></span>
            </a>
            <a href="/list/backup/?backup=yes" class="dash-icon-item">
                <div class="dash-icon-circle text-green">
                    <i class="fas fa-save"></i>
                </div>
                <span><?= _("Create Backup") ?></span>
            </a>
            <a href="/list/backup/exclusions/" class="dash-icon-item">
                <div class="dash-icon-circle text-gray">
                    <i class="fas fa-minus-circle"></i>
                </div>
                <span><?= _("Backup Exclusions") ?></span>
            </a>
        </div>
    </div>

</div>

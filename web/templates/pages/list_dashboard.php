<!-- Begin User Dashboard -->
<div class="container user-dashboard">

    <!-- Top Stats Cards -->
    <?php
        // Helper to safely get user data
        // If $panel[$user] is not set, we need to fetch it
        $user_stats = [];
        if (isset($panel[$user])) {
            $user_stats = $panel[$user];
        } else {
            // Fetch fresh data
            $v_user = escapeshellarg($user);
            exec(HESTIA_CMD . "v-list-user " . $v_user . " json", $output, $return_var);
            if ($return_var == 0) {
                $user_data = json_decode(implode("", $output), true);
                if (isset($user_data[$user])) {
                    $user_stats = $user_data[$user];
                }
                unset($output);
            }
        }

        // Defaults if data is still missing (e.g. API error)
        $stat_name = isset($user_stats['NAME']) ? $user_stats['NAME'] : $user;
        
        // Fetch web domains to find the "Primary" (first added) domain
        // Clean the user variable - remove any existing quotes
        $cmd_user = str_replace("'", "", $user);
        $cmd_user = str_replace('"', "", $cmd_user);
        
        // Ensure simple alphanumeric username for safety without over-escaping
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $cmd_user)) {
             $cmd_user_safe = 'invalid_user_format'; 
        } else {
             $cmd_user_safe = $cmd_user;
        }
        
        // Use standard quoteshellarg from Hestia helpers if available, or manual single quotes
        $v_user = "'" . $cmd_user_safe . "'";
        
        $cmd = HESTIA_CMD . "v-list-web-domains $v_user json";
        exec($cmd, $output, $return_var);
        $raw_json = implode("\n", $output);
        
        // Fix: Clean up output if it contains non-JSON error messages
        // The debug output showed: "Error: invalid user format :: 'cotlasweb' \n { ... }"
        // This suggests Hestia might be printing an error to STDOUT even if it proceeds to dump JSON,
        // or there's some residual noise. We need to find the start of the JSON object.
        $json_start = strpos($raw_json, '{');
        if ($json_start !== false) {
            $raw_json = substr($raw_json, $json_start);
        }
        
        $web_domains_data = json_decode($raw_json, true);
        
        // --- DEBUG START ---
        // Commented out to clean up UI, but keeping structure just in case
        /*
        echo "<div style='background: #fff; padding: 20px; border: 2px solid red; margin-bottom: 20px;'>";
        echo "<strong>Debug Info:</strong><br>";
        echo "User Raw: " . $user . "<br>";
        echo "Cmd User: " . $cmd_user_safe . "<br>";
        echo "Command: " . $cmd . "<br>";
        echo "Return Code: " . $return_var . "<br>";
        echo "Raw Output: <pre>" . htmlspecialchars($raw_json) . "</pre><br>";
        echo "JSON Error: " . json_last_error_msg() . "<br>";
        echo "Decoded: <pre>" . print_r($web_domains_data, true) . "</pre><br>";
        echo "</div>";
        */
        // --- DEBUG END ---
        
        $primary_domain_display = _('No domains');
        
        if (is_array($web_domains_data) && !empty($web_domains_data)) {
            // Get the first key (domain name)
            // JSON from Hestia is usually sorted by date added (oldest first) or name
            // array_key_first() gets the first domain in the list
            $first_domain = array_key_first($web_domains_data);
            if (!empty($first_domain)) {
                $primary_domain_display = $first_domain;
            }
        } else {
             // Fallback to stats if direct list fails (just to show count if we can't get name)
             // But user specifically asked for Name. If we can't get name, "No domains" is appropriate or "Unknown"
             // Let's stick to "No domains" if the list is empty.
        }

        $stat_disk_u = isset($user_stats['U_DISK']) ? $user_stats['U_DISK'] : 0;
        $stat_disk_q = isset($user_stats['DISK_QUOTA']) ? $user_stats['DISK_QUOTA'] : 'unlimited';
        
        $stat_bw_u = isset($user_stats['U_BANDWIDTH']) ? $user_stats['U_BANDWIDTH'] : 0;
        $stat_bw_q = isset($user_stats['BANDWIDTH']) ? $user_stats['BANDWIDTH'] : 'unlimited';
    ?>

    <div class="dash-blocks u-mb30">
        <div class="dash-card">
            <div class="dash-card-icon bg-purple">
                <i class="fas fa-user"></i>
            </div>
            <div class="dash-card-content">
                <span class="dash-label"><?= _("Current User") ?></span>
                <span class="dash-value"><?= $stat_name ?></span>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-card-icon bg-blue">
                <i class="fas fa-globe"></i>
            </div>
            <div class="dash-card-content">
                <span class="dash-label"><?= _("Primary Domain") ?></span>
                <span class="dash-value"><?= $primary_domain_display ?></span>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-card-icon bg-green">
                <i class="fas fa-server"></i>
            </div>
            <div class="dash-card-content">
                <span class="dash-label"><?= _("Disk Usage") ?></span>
                <span class="dash-value"><?= humanize_usage_size($stat_disk_u) ?> / <?= humanize_usage_size($stat_disk_q) ?></span>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-card-icon bg-orange">
                <i class="fas fa-bolt"></i>
            </div>
            <div class="dash-card-content">
                <span class="dash-label"><?= _("Bandwidth") ?></span>
                <span class="dash-value"><?= humanize_usage_size($stat_bw_u) ?> / <?= humanize_usage_size($stat_bw_q) ?></span>
            </div>
        </div>
    </div>

    <!-- Sections Grid -->
    
    <!-- Domain Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-globe"></i>
            <h2><?= _("Domains") ?></h2>
        </div>
        <div class="dash-icons-grid">
            <a href="/list/web/" class="dash-icon-item">
                <div class="dash-icon-circle text-blue">
                    <i class="fas fa-globe"></i>
                </div>
                <span><?= _("Manage Domains") ?></span>
            </a>
            <a href="/add/web/" class="dash-icon-item">
                <div class="dash-icon-circle text-green">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <span><?= _("Add Domain") ?></span>
            </a>
            <a href="/list/dns/" class="dash-icon-item">
                <div class="dash-icon-circle text-orange">
                    <i class="fas fa-book-atlas"></i>
                </div>
                <span><?= _("DNS Zones") ?></span>
            </a>
        </div>
    </div>

    <!-- Email Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-envelope"></i>
            <h2><?= _("Email") ?></h2>
        </div>
        <div class="dash-icons-grid">
            <a href="/list/mail/" class="dash-icon-item">
                <div class="dash-icon-circle text-purple">
                    <i class="fas fa-envelope"></i>
                </div>
                <span><?= _("Email Accounts") ?></span>
            </a>
            <a href="/add/mail/" class="dash-icon-item">
                <div class="dash-icon-circle text-green">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <span><?= _("Add Mail Domain") ?></span>
            </a>
        </div>
    </div>

    <!-- Database Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-database"></i>
            <h2><?= _("Databases") ?></h2>
        </div>
        <div class="dash-icons-grid">
            <a href="/list/db/" class="dash-icon-item">
                <div class="dash-icon-circle text-red">
                    <i class="fas fa-database"></i>
                </div>
                <span><?= _("Manage Databases") ?></span>
            </a>
            <a href="/add/db/" class="dash-icon-item">
                <div class="dash-icon-circle text-green">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <span><?= _("Add Database") ?></span>
            </a>
            <a href="/phpmyadmin/" target="_blank" rel="noopener noreferrer" class="dash-icon-item">
                <div class="dash-icon-circle text-orange">
                    <i class="fab fa-php"></i>
                </div>
                <span><?= _("phpMyAdmin") ?></span>
            </a>
        </div>
    </div>

    <!-- Files Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-folder"></i>
            <h2><?= _("Files") ?></h2>
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
            <a href="/list/ftp/" class="dash-icon-item">
                <div class="dash-icon-circle text-purple">
                    <i class="fas fa-network-wired"></i>
                </div>
                <span><?= _("FTP Accounts") ?></span>
            </a>
        </div>
    </div>

    <!-- Advanced Section -->
    <div class="dash-section">
        <div class="dash-section-header">
            <i class="fas fa-cogs"></i>
            <h2><?= _("Advanced") ?></h2>
        </div>
        <div class="dash-icons-grid">
            <a href="/list/cron/" class="dash-icon-item">
                <div class="dash-icon-circle text-gray">
                    <i class="fas fa-clock"></i>
                </div>
                <span><?= _("Cron Jobs") ?></span>
            </a>
             <a href="/list/stats/" class="dash-icon-item">
                <div class="dash-icon-circle text-blue">
                    <i class="fas fa-chart-line"></i>
                </div>
                <span><?= _("Statistics") ?></span>
            </a>
        </div>
    </div>

</div>

<div id="token" token="<?= $_SESSION["token"] ?>"></div>

<aside class="orion-sidebar">
	<div class="orion-logo-wrapper">
		<a href="<?= ($_SESSION["userContext"] === "admin" && empty($_SESSION["look"])) ? "/list/user/" : "/list/dashboard/" ?>" class="orion-logo" title="<?= htmlentities($_SESSION["APP_NAME"]) ?>">
			<img src="/images/logo-hostniki.png" alt="<?= htmlentities($_SESSION["APP_NAME"]) ?>" style="max-height: 40px; max-width: 100%;">
		</a>
	</div>
	<ul class="orion-nav">
		<?php if ($_SESSION["userContext"] == "admin" && $_SESSION["look"] === "") { ?>
		<li class="<?= $TAB == "DASHBOARD" ? 'active' : '' ?>">
			<a href="/list/dashboard/" title="<?= _("Dashboard") ?>">
				<svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" fill="none" stroke="currentColor" stroke-width="2"/><polyline points="9 22 9 12 15 12 15 22" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("Dashboard") ?></span>
			</a>
		</li>
		<li class="<?= in_array($TAB, ["USER","LOG"]) ? 'active' : '' ?>">
			<a href="/list/user/" title="<?= _("Users") ?>">
				<svg viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-9 3-9 7h18c0-4-4-7-9-7" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("Users") ?></span>
			</a>
		</li>
		<?php } else { ?>
		<li class="<?= $TAB == "DASHBOARD" ? 'active' : '' ?>">
			<a href="/list/dashboard/" title="<?= _("Dashboard") ?>">
				<svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" fill="none" stroke="currentColor" stroke-width="2"/><polyline points="9 22 9 12 15 12 15 22" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("Dashboard") ?></span>
			</a>
		</li>
		<?php } ?>

		<?php if (!empty($_SESSION["WEB_SYSTEM"])) { ?>
		<li class="<?= $TAB == "WEB" ? 'active' : '' ?>">
			<a href="/list/web/">
				<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M3 12h18M12 3c2.5 3 2.5 15 0 18" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("Domains") ?></span>
			</a>
		</li>
		<?php } ?>
		<?php if (!empty($_SESSION["DNS_SYSTEM"])) { ?>
		<li class="<?= $TAB == "DNS" ? 'active' : '' ?>">
			<a href="/list/dns/">
				<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M8 12h8M12 8v8" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("DNS") ?></span>
			</a>
		</li>
		<?php } ?>
		<?php if (!empty($_SESSION["MAIL_SYSTEM"])) { ?>
		<li class="<?= $TAB == "MAIL" ? 'active' : '' ?>">
			<a href="/list/mail/">
				<svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M3 8l9 6 9-6" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("Mail") ?></span>
			</a>
		</li>
		<?php } ?>
		<?php if (!empty($_SESSION["DB_SYSTEM"])) { ?>
		<li class="<?= $TAB == "DB" ? 'active' : '' ?>">
			<a href="/list/db/">
				<svg viewBox="0 0 24 24"><ellipse cx="12" cy="6" rx="8" ry="3" fill="none" stroke="currentColor" stroke-width="2"/><path d="M4 6v12c0 1.7 3.6 3 8 3s8-1.3 8-3V6M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("DB") ?></span>
			</a>
		</li>
		<?php } ?>
		<?php if (!empty($_SESSION["CRON_SYSTEM"])) { ?>
		<li class="<?= $TAB == "CRON" ? 'active' : '' ?>">
			<a href="/list/cron/">
				<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 7v6l4 2" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("Cron") ?></span>
			</a>
		</li>
		<?php } ?>
		<?php if (!empty($_SESSION["BACKUP_SYSTEM"])) { ?>
		<li class="<?= $TAB == "BACKUP" ? 'active' : '' ?>">
			<a href="/list/backup/">
				<svg viewBox="0 0 24 24"><path d="M5 12a7 7 0 1 1 7 7H6" fill="none" stroke="currentColor" stroke-width="2"/><path d="M6 16l-2 3 3 2" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("Backup") ?></span>
			</a>
		</li>
		<?php } ?>
		<?php if (isset($_SESSION["FILE_MANAGER"]) && $_SESSION["FILE_MANAGER"] == "true" && !($_SESSION["userContext"] === "admin" && $_SESSION["look"] === "admin" && $_SESSION["POLICY_SYSTEM_PROTECTED_ADMIN"] == "yes")) { ?>
		<li class="<?= $TAB == "FM" ? 'active' : '' ?>">
			<a href="/fm/">
				<svg viewBox="0 0 24 24"><path d="M3 7h6l2 2h10v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("File Manager") ?></span>
			</a>
		</li>
		<?php } ?>
		<?php if (($_SESSION["userContext"] === "admin" && $_SESSION["POLICY_SYSTEM_HIDE_SERVICES"] !== "yes") || $_SESSION["user"] === "admin") { if (!($_SESSION["userContext"] === "admin" && $_SESSION["look"] !== "")) { ?>
		<li class="<?= in_array($TAB, ["SERVER","IP","RRD","FIREWALL"]) ? 'active' : '' ?>">
			<a href="/list/server/">
				<svg viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("Server") ?></span>
			</a>
		</li>
		<?php }} ?>
		<li class="<?= $TAB == 'STATS' ? 'active' : '' ?>">
			<a href="/list/stats/">
				<svg viewBox="0 0 24 24"><path d="M4 20V8m6 12V4m6 16v-8" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<span><?= _("Statistics") ?></span>
			</a>
		</li>
		<?php if ($_SESSION["HIDE_DOCS"] !== "yes") { ?>
		<li>
			<a href="https://hestiacp.com/docs/" target="_blank" rel="noopener">
				<i class="fas fa-circle-question"></i>
				<span><?= _("Help") ?></span>
			</a>
		</li>
		<?php } ?>
	</ul>
</aside>

<header class="app-header orion-header">
	<div class="orion-topbar">
		<div class="orion-topbar-left">
			<!-- Empty left side or breadcrumbs could go here -->
		</div>
		<div class="orion-topbar-right">
			<div class="orion-usage">
				<span class="orion-usage-item" title="<?= _("Disk") ?>">
					<svg viewBox="0 0 24 24" width="18" height="18"><path d="M3 7h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" fill="none" stroke="currentColor" stroke-width="2"/></svg>
					<strong><?= humanize_usage_size($panel[$user]["U_DISK"]) ?></strong>
					<?= humanize_usage_measure($panel[$user]["U_DISK"]) ?> /
					<strong><?= humanize_usage_size($panel[$user]["DISK_QUOTA"]) ?></strong>
					<?= humanize_usage_measure($panel[$user]["DISK_QUOTA"]) ?>
				</span>
				<span class="orion-usage-item" title="<?= _("Bandwidth") ?>">
					<svg viewBox="0 0 24 24" width="18" height="18"><path d="M3 12h6l3-6 3 12 3-6h3" fill="none" stroke="currentColor" stroke-width="2"/></svg>
					<strong><?= humanize_usage_size($panel[$user]["U_BANDWIDTH"]) ?></strong>
					<?= humanize_usage_measure($panel[$user]["U_BANDWIDTH"]) ?> /
					<strong><?= humanize_usage_size($panel[$user]["BANDWIDTH"]) ?></strong>
					<?= humanize_usage_measure($panel[$user]["BANDWIDTH"]) ?>
				</span>
			</div>
			<form action="/search/" method="get" class="orion-search">
				<input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
				<input type="search" name="q" placeholder="<?= _("Search") ?>" />
			</form>
			<a class="orion-logout" href="/logout/?token=<?= $_SESSION["token"] ?>" title="<?= _("Log out") ?>">
				<svg viewBox="0 0 24 24" width="18" height="18"><path d="M8 6v12M12 12h9M16 8l5 4-5 4" fill="none" stroke="currentColor" stroke-width="2"/></svg>
			</a>
		</div>
	</div>
</header>

<main class="app-content orion-content">

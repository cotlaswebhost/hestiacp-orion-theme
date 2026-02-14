<!-- Begin toolbar -->
<div class="l-center">
    <div class="l-sort clearfix">
        <div class="l-sort-toolbar clearfix">
            <span class="title"><?= _('Edit Theme') ?></span>
            <div class="l-sort-toolbar-search-box u-float-right">
                <a href="/list/server/" class="l-sort-toolbar-search-box-btn"><?= _('Back') ?></a>
            </div>
        </div>
    </div>
</div>
<!-- End toolbar -->

<div class="l-separator"></div>

<div class="l-center animated fadeIn">
    <form id="vstobjects" name="v_edit_theme" method="post" enctype="multipart/form-data">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>" />

        <div class="units-table">
            <div class="units-table-header">
                <div class="units-table-cell"><?= _('Theme Customization') ?></div>
            </div>
            
            <div class="units-table-body">
                <!-- Logo Section -->
                <div class="units-table-row">
                    <div class="units-table-cell" style="vertical-align: top; width: 30%;">
                        <div class="v-unit-title"><?= _('Logo Upload') ?></div>
                        <div class="v-unit-desc"><?= _('Upload a custom logo (SVG, PNG, JPG). Replaces the default logo.') ?></div>
                    </div>
                    <div class="units-table-cell">
                        <input type="file" name="logo_file" class="v-stnd" />
                    </div>
                </div>

                <div class="units-table-row">
                    <div class="units-table-cell" style="vertical-align: top;">
                        <div class="v-unit-title"><?= _('Logo Height (Sidebar)') ?></div>
                        <div class="v-unit-desc"><?= _('CSS value for logo height in sidebar (e.g. 50px, 3rem)') ?></div>
                    </div>
                    <div class="units-table-cell">
                        <input type="text" name="logo_height" value="<?= htmlentities($logo_height) ?>" class="v-stnd" />
                    </div>
                </div>

                <div class="units-table-row">
                    <div class="units-table-cell" style="vertical-align: top;">
                        <div class="v-unit-title"><?= _('Logo Width (Sidebar)') ?></div>
                        <div class="v-unit-desc"><?= _('CSS value for logo width in sidebar (e.g. auto, 100%)') ?></div>
                    </div>
                    <div class="units-table-cell">
                        <input type="text" name="logo_width" value="<?= htmlentities($logo_width) ?>" class="v-stnd" />
                    </div>
                </div>

                <div class="units-table-row">
                    <div class="units-table-cell" style="vertical-align: top;">
                        <div class="v-unit-title"><?= _('Logo Height (Login Page)') ?></div>
                        <div class="v-unit-desc"><?= _('CSS value for logo height on login screen') ?></div>
                    </div>
                    <div class="units-table-cell">
                        <input type="text" name="login_logo_height" value="<?= htmlentities($login_logo_height) ?>" class="v-stnd" />
                    </div>
                </div>

                <!-- CSS Section -->
                <div class="units-table-row">
                    <div class="units-table-cell" style="vertical-align: top;">
                        <div class="v-unit-title"><?= _('Custom CSS') ?></div>
                        <div class="v-unit-desc"><?= _('Add custom CSS rules here. They will override theme defaults.') ?></div>
                    </div>
                    <div class="units-table-cell">
                        <textarea name="custom_css" class="v-stnd" style="height: 300px; font-family: monospace; width: 100%; border: 1px solid #e5e7eb; border-radius: 4px; padding: 10px;"><?= htmlentities($css_content) ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding: 20px 0; text-align: right;">
            <input type="button" class="button check" value="<?= _('Back') ?>" onclick="window.location.href='/list/server/'" style="margin-right: 10px;" />
            <input type="submit" name="save" value="<?= _('Save Changes') ?>" class="button" />
        </div>

    </form>
</div>

<style>
.units-table {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 20px;
}
.units-table-header {
    background: #f8fafc;
    padding: 15px 20px;
    border-bottom: 1px solid #e5e7eb;
    font-weight: 600;
    color: #1e293b;
    font-size: 1.1rem;
}
.units-table-row {
    display: flex;
    border-bottom: 1px solid #f1f5f9;
}
.units-table-row:last-child {
    border-bottom: none;
}
.units-table-cell {
    padding: 20px;
    flex: 1;
}
.v-unit-title {
    font-weight: 600;
    color: #334155;
    margin-bottom: 5px;
}
.v-unit-desc {
    font-size: 0.85rem;
    color: #64748b;
}
.v-stnd {
    width: 100%;
    max-width: 500px;
    padding: 8px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 0.95rem;
}
</style>
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

		<table class="data" style="width: 100%;">
			<tr class="data-add">
				<td class="data-dotted">
					<table class="data-col1">
						<tr>
							<td></td>
						</tr>
					</table>
				</td>
				<td class="data-dotted">
					<table class="data-col2">
						<tr>
							<td class="step-top">
								<span class="page-title"><?= _('Theme Customization') ?></span>
							</td>
						</tr>
						<tr>
							<td>
								<div class="v-unit">
									<div class="v-unit-title"><?= _('Logo Upload') ?></div>
									<div class="v-unit-desc"><?= _('Upload a custom logo (SVG, PNG, JPG). Replaces the default logo.') ?></div>
									<input type="file" name="logo_file" class="v-stnd" />
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="v-unit">
									<div class="v-unit-title"><?= _('Logo Height (Sidebar)') ?></div>
									<div class="v-unit-desc"><?= _('CSS value for logo height in sidebar (e.g. 50px, 3rem)') ?></div>
									<input type="text" name="logo_height" value="<?= htmlentities($logo_height) ?>" class="v-stnd" />
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="v-unit">
									<div class="v-unit-title"><?= _('Logo Width (Sidebar)') ?></div>
									<div class="v-unit-desc"><?= _('CSS value for logo width in sidebar (e.g. auto, 100%)') ?></div>
									<input type="text" name="logo_width" value="<?= htmlentities($logo_width) ?>" class="v-stnd" />
								</div>
							</td>
						</tr>
                        <tr>
							<td>
								<div class="v-unit">
									<div class="v-unit-title"><?= _('Logo Height (Login Page)') ?></div>
									<div class="v-unit-desc"><?= _('CSS value for logo height on login screen') ?></div>
									<input type="text" name="login_logo_height" value="<?= htmlentities($login_logo_height) ?>" class="v-stnd" />
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="v-unit">
									<div class="v-unit-title"><?= _('Custom CSS') ?></div>
									<div class="v-unit-desc"><?= _('Add custom CSS rules here. They will override theme defaults.') ?></div>
									<textarea name="custom_css" class="v-stnd" style="height: 300px; font-family: monospace;"><?= htmlentities($css_content) ?></textarea>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<div class="data-col2">
			<div style="padding: 20px 0;">
				<input type="submit" name="save" value="<?= _('Save') ?>" class="button" />
				<input type="button" class="button check" value="<?= _('Back') ?>" onclick="window.location.href='/list/server/'" />
			</div>
		</div>

	</form>
</div>
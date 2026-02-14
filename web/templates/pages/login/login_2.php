<div class="login">
	<a href="/" class="u-block login-logo u-mb40">
		<?php
		    // Check for custom logo from theme settings
		    $logo_src = "/images/logo.svg";
		    $logo_style = "max-height: 100px; max-width: 100%;";
		    
		    if (file_exists($_SERVER['HESTIA'] . '/web/inc/orion_config.json')) {
		        $theme_config = json_decode(file_get_contents($_SERVER['HESTIA'] . '/web/inc/orion_config.json'), true);
		        if (!empty($theme_config['logo_ext'])) {
		            $custom_logo = '/images/custom-logo.' . $theme_config['logo_ext'];
		            if (file_exists($_SERVER['HESTIA'] . '/web' . $custom_logo)) {
		                $logo_src = $custom_logo;
		            }
		        }
		        if (!empty($theme_config['login_logo_height'])) {
		            $logo_style = "max-height: " . $theme_config['login_logo_height'] . ";";
		        }
		    }
		?>
		<img src="<?= $logo_src ?>" alt="<?= htmlentities($_SESSION["APP_NAME"]) ?>" style="<?= $logo_style ?>">
	</a>
	<form id="login-form" method="post" action="/login/">
		<input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
		<h1 class="login-title">
			<?= _("Two-factor Authentication") ?>
		</h1>
		<?php if (!empty($error)) { ?>
			<p class="error"><?= $error ?></p>
		<?php } ?>
		<div class="u-mb20">
			<label for="twofa" class="form-label u-side-by-side">
				<?= _("2FA Token") ?>
				<a class="login-form-link" href="/reset2fa/">
					<?= _("Forgot Token") ?>
				</a>
			</label>
			<input type="text" class="form-control" name="twofa" id="twofa" autocomplete="one-time-code" required autofocus>
		</div>
		<div class="u-side-by-side">
			<button type="submit" class="button">
				<i class="fas fa-right-to-bracket"></i><?= _("Login") ?>
			</button>
			<a href="/login/?logout" class="button button-secondary">
				<?= _("Back") ?>
			</a>
		</div>
	</form>
</div>

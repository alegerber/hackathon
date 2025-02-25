<h3><?php _e( 'Accessibility', 'mdbhc' ); ?></h3>
<?php
	if (isset($_GET['activate'])) {
		MDBHC\Accessibility::activate();
	}
	if (isset($_GET['deactivate'])) {
		MDBHC\Accessibility::deactivate();
	}

	$get_paramter = '';
	$button_name  = '';

	if(!MDBHC\Accessibility::getActivateStatus()){
		$get_paramter = 'activate';
		$button_name  = 'Activate';
	} else {
		$get_paramter = 'deactivate';
		$button_name  = 'Deactivate';
	}
?>
<div id="metabox" class="postbox" style="max-width: 400px">
	<div class="inside">
		<div class="main">
		<h2><span>Chart Accessibility</span></h2>
<?php
	echo '<p>';
	esc_html_e($button_name . ' High Contrast chart');
	echo '</p>';
	echo '<p>';
	echo '<a href="?page=mdbhc&tab=accessibility&' . $get_paramter . '" class="button button-primary">' . $button_name . '</a>';
	echo '</p>';
?>
		</div>
	</div>
</div>
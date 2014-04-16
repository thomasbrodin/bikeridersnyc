<?php
/*
Plugin Name: Admin Menu Editor
Plugin URI:
Description: Hide/Show admin menu items from users bases on their roles
Author: Marko Miljus (Incsub)
Version: 1.0
Author URI:
*/

class ub_custom_login_css {

	function __construct() {

		add_action( 'ultimatebranding_settings_menu_css', array(&$this, 'custom_login_css_options') );
		add_filter( 'ultimatebranding_settings_menu_css_process', array(&$this, 'update_custom_login_css'), 10, 1 );

		add_action('login_head', array(&$this, 'custom_login_css_output'), 99);
	}

	function ub_custom_login_css() {
		$this->__construct();
	}

	function update_custom_login_css( $status ) {

		$logincss = $_POST['logincss'];
		if ( $logincss == '' ) {
			$logincss = 'empty';
		}

		ub_update_option( 'global_login_css' , $logincss );

		if($status === false) {
			return $status;
		} else {
			return true;
		}
	}

	function custom_login_css_output() {
		$logincss = ub_get_option('global_login_css');
		if ( $logincss == 'empty' ) {
			$logincss = '';
		}
		if ( !empty( $logincss ) ) {
			?>
			<style type="text/css">
				<?php echo stripslashes( $logincss ); ?>
			</style>
			<?php
		}
	}

	function custom_login_css_options() {

		$logincss = ub_get_option('global_login_css');
		if ( $logincss == 'empty' ) {
			$logincss = '';
		}

		?>
			<div class="postbox">
			<h3 class="hndle" style='cursor:auto;'><span><?php _e( 'Custom Login CSS', 'ub' ) ?></span></h3>
			<div class="inside">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('CSS Styles', 'ub') ?></th>
						<td>
							<textarea name='logincss' style='width:100%; height: 20em;'><?php echo stripslashes( $logincss );  ?></textarea>
		                	<br />
							<?php _e('What is added here will be added to the header of the login page for every site.', 'ub') ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php
	}

}

$ub_custom_login_css = new ub_custom_login_css();

?>
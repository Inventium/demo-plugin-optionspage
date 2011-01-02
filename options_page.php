<?php
/**
 * Plugin Name: Demo Plugin Options Page
 * Plugin URI: 
 * Description: 
 * Author: 
 * Author URI: 
 */
 
  
/** 
 * This code was basedon Dave Gwyers example code.  That code is 
 * excellent for experienced WP and PHP programmers. This code
 * is more suitable for beginners to WP.  More information can 
 * be found at these links:
 * http://www.presscoders.com/wordpress-settings-api-explained/
 * http://www.presscoders.com/wp-content/uploads/text/ExampleOptionsPage.txt
 * http://automattic.com/code/widgets/plugins/
 */


// Register our settings. Add the settings section, and settings fields
function demo_options_init(){
	register_setting('plugin_options', 'plugin_options', 'plugin_options_validate' );
	add_settings_section('main_section', 'Main Settings', 'section_text_fn', __FILE__);
	add_settings_field('plugin_text_string', 'Text Input', 'hello_text', __FILE__, 'main_section');
}

function demo_options_page() {
  add_options_page('Demo Options Page Title', 'Demo Options Page', 'administrator', __FILE__, 'options_page_fn');
}

function  section_text_fn() {
	echo '<p>Below are some examples of different option controls.</p>';
}



function hello_text() {
	$options = get_option('plugin_options');
	echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
}


// Display the admin options page
function options_page_fn() {
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>My Example Options Page</h2>
		Some optional text here explaining the overall purpose of the options and what they relate to etc.
		<form action="options.php" method="post">
		<?php settings_fields('plugin_options'); ?>
		<?php do_settings_sections(__FILE__); ?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>
		</form>
	</div>
<?php
}

// Validate user data for some/all of your input fields
function plugin_options_validate($input) {
	// Check our textbox option field contains no HTML tags - if so strip them out
	$input['text_string'] =  wp_filter_nohtml_kses($input['text_string']);	
	return $input; // return validated input
}

add_action('admin_init', 'demo_options_init');
add_action('admin_menu', 'demo_options_page');

?>
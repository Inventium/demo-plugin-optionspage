<?php
/**
 * Plugin Name: Demo Plugin Options Page
 * Plugin URI: http://website-in-a-weekend/plugins/demo-options-page
 * Description: This plugins exercises the settings API for handling options, which handles the machinery of the HTTP request "under the covers."
 * Author: Dave Doolin
 * Author URI: http://dool.in/ 
 */
 
  
/** 
 * This code was based on Dave Gwyer's example code.  That code is 
 * excellent for experienced WP and PHP programmers. This code
 * is more suitable for beginners to WP.  More information can 
 * be found at these links:
 * http://www.presscoders.com/wordpress-settings-api-explained/
 * http://www.presscoders.com/wp-content/uploads/text/ExampleOptionsPage.txt
 * http://automattic.com/code/widgets/plugins/
 */
 
$hrecipe_pagehook = null; 
 
function demo_postbox($id, $title, $content) {
?>
      <div id="<?php echo $id; ?>" class="postbox">
        <div class="handlediv" title="Click to toggle"><br /></div>
        <h3 class="hndle"><span><?php echo $title; ?></span></h3>
        <div class="inside">
          <?php echo $content; ?>
        </div>
      </div>
<?php   
    }


function demo_postbox_fields($id, $title, $section) {
?>
      <div id="<?php echo $id; ?>" class="postbox">
        <div class="handlediv" title="Click to toggle"><br /></div>
        <h3 class="hndle"><span><?php echo $title; ?></span></h3>
        <div class="inside">
           <table class="form-table">
             <?php do_settings_fields(__FILE__, $section); ?>
          </table>
        </div>
      </div>
<?php   
    }

/**
 * TODO: 
 * - Turn this code into a class which doesn't run until instantiated.
 * - Use a self::text_input method for laying out options.
 * - Clean up function names.
 * - Add another settings group; more complicated but necessary.
 */

// Register our settings. Add the settings section, and settings fields
function demo_options_init() {
  
  wp_enqueue_style("wp-jquery-ui-dialog");
  //wp_enqueue_style("dashboard");

  wp_enqueue_script('common');
  wp_enqueue_script('wp-lists');
  wp_enqueue_script('postbox');
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-dialog');  
  
  
	register_setting('plugin_options_group', 'plugin_options', 'demo_options_validate' );
	//add_settings_section('main_section', 'Main Settings', 'main_section_text', __FILE__);
  add_settings_section('main_section', '', 'main_section_text', __FILE__);
	add_settings_field('plugin_hello_string', 'Hello Input', 'hello_text', __FILE__, 'main_section');
  add_settings_field('plugin_goodbye_string', 'Good Bye Input', 'goodbye_text', __FILE__, 'main_section');
  
 
 /* This needs to go on a different options page. That can be something 
  * for the future.
  */
  //register_setting('plugin_options_group2', 'plugin_options_2', 'demo_options_validate');
  add_settings_section('section-2', '', 'section_2_text', __FILE__);  
  add_settings_field('plugin_foo_string','Foo!', 'foo_text', __FILE__,'section-2');
  add_settings_field('plugin_bar_string','Bar!', 'bar_text', __FILE__,'section-2');
  
}

function demo_options_page() {
  $hrecipe_pagehook = add_options_page('Demo Options Page Title', 'Demo Options Page', 'administrator', __FILE__, 'options_page_fn');
}

function  main_section_text() {
	echo '<p>Below are some examples of different option controls.</p>';
}


function hello_text() {
	$options = get_option('plugin_options');
	echo "<input id='plugin_hello_string' name='plugin_options[hello_string]' size='40' type='text' value='{$options['hello_string']}' />";
}

function goodbye_text() {
  $options = get_option('plugin_options');
  echo "<input id='plugin_goodbye_string' name='plugin_options[goodbye_string]' size='40' type='text' value='{$options['goodbye_string']}' />";
}


function  section_2_text() {
  echo '<p>Below are some examples of different option controls.</p>';
}

function foo_text() {
  $options = get_option('plugin_options');
  echo "<input id='plugin_foo_string' name='plugin_options[hello_foo_string]' size='40' type='text' value='{$options['hello_foo_string']}' />";
}

function bar_text() {
  $options = get_option('plugin_options');
  echo "<input id='plugin_bar_string' name='plugin_options[hello_bar_string]' size='40' type='text' value='{$options['hello_bar_string']}' />";
}


// Display the admin options page
// function display_options_page() {
// This is the Javascript branch...
function options_page_fn() {
?>

<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready( function($) {
      // close postboxes that should be closed
      $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
      // postboxes setup
      postboxes.add_postbox_toggles('<?php global $hrecipe_pagehook; echo $hrecipe_pagehook; ?>');
    });
    //]]>
  </script>

<script type="text/javascript"> 
//<!--
    function toggleVisibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script> 

<style type="text/css">
h3.hndle { 
  padding: 6px 8px;
  margin: 0px;
}
</style>

	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
    

      <h2>My Example Options Page</h2>
		  Some optional text here explaining the overall purpose of the options and what they relate to etc.

          <form action="options.php" method="post">
          <?php settings_fields('plugin_options_group'); ?>

      <div class="postbox-container" style="width: 70%;">
        <div class="meta-box-sortables ui-sortable">

          
          <div id="hrecipelabels" class="postbox ">
                    <div class="handlediv" title="Click to toggle"><br/></div><!-- handlediv -->
                    <h3 class="hndle"><span><?php _e('Recipe Labels', 'hrecipe'); ?></span></h3>
                    <div class="inside">
          
	        <?php //do_settings_sections(__FILE__); ?>
          <?php //do_settings('plugins_option_group'); ?>

<?php     

          echo '<table class="form-table">';
          do_settings_fields(__FILE__, 'main_section');
          do_settings_fields(__FILE__, 'section-2'); 
          echo '</table>';

?>
          </div><!-- inside -->
         </div><!-- postbox -->


          <?php
            demo_postbox_fields('foobar', 'Foo Bar Demo Postbox', 'section-2');
            demo_postbox_fields('hello-box', 'Hello & Goodbye Postbox', 'main_section');
          ?>
          

          <?php
                demo_postbox('foobar', "Foo bar", "Content for Foo bar.");
          ?>

          <p class="submit">
          <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
          </p>
          </form>

        </div><!-- metabox-sortables -->
     </div><!-- postbox-container --> 

	</div>
<?php
}

// Validate user data for some/all of your input fields
function demo_options_validate($input) {
	// Check our textbox option field contains no HTML tags - if so strip them out
	//$input['text_string'] =  wp_filter_nohtml_kses($input['text_string']);	
	return $input; // return validated input
}

add_action('admin_init', 'demo_options_init');
add_action('admin_menu', 'demo_options_page');

?>

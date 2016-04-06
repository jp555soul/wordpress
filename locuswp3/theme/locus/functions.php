<?php 
/* PATHS */
define('ADMIN_PATH', TEMPLATEPATH . '/admin/');
define('ADMIN', get_template_directory_uri() . '/admin/');
define('FUNCTIONS_PATH', TEMPLATEPATH . '/functions/');
define('INCLUDES_PATH', TEMPLATEPATH . '/includes/');
define('RESIZE', get_template_directory_uri() . '/functions/img_resize');
define('RWMB_URL', trailingslashit( get_template_directory_uri().'/includes/meta-box' ) );
define('RWMB_DIR', trailingslashit( get_template_directory().'/includes/meta-box' ) );

/* INCLUDE THEME FUNCTIONS */
require_once (FUNCTIONS_PATH . 'locus-functions.php');
require_once (FUNCTIONS_PATH . 'locus-portfolio.php');
require_once (FUNCTIONS_PATH . 'locus-options.php');
include_once (INCLUDES_PATH . 'class.MultiImage.php');
include_once (INCLUDES_PATH . 'class.DC_PostMetaOptions.php');
include_once (INCLUDES_PATH  . 'stop-ie6/stopie6.php');
require_once (RWMB_DIR . 'meta-box.php');
include (INCLUDES_PATH  . 'meta-box/config.php');

/* PORTFOLIO ADD SLIDE */
function dc_admin_add_admin() {
	
	add_action("admin_print_styles",'dc_admin_style');
	add_action("admin_print_scripts", 'dc_admin_scripts');
} 

add_action('admin_menu', 'dc_admin_add_admin');

function dc_admin_style(){

	wp_enqueue_style('dc-admin', ADMIN . 'css/dc-admin.css');
}

function dc_admin_scripts(){
	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-widget', ADMIN . 'js/jquery.ui.widget.min.js');
	wp_enqueue_script('jquery-ui-mouse', ADMIN . 'js/jquery.ui.mouse.min.js');
	wp_enqueue_script('jquery-ui-sortable', ADMIN . 'js/jquery.ui.sortable.min.js');
	wp_enqueue_script('dc-admin', ADMIN . 'js/jquery.admin.js');
}

if ( !function_exists( 'optionsframework_init' ) ) {

	/*-----------------------------------------------------------------------------------*/
	/* Options Framework Theme
	/*-----------------------------------------------------------------------------------*/

	/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */

	if ( STYLESHEETPATH == TEMPLATEPATH ) {
		define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
	} else {
		define('OPTIONS_FRAMEWORK_URL', STYLESHEETPATH . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_stylesheet_directory_uri() . '/admin/');
	}

	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');

}

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
});
</script>


<?php
}

/* ENQUEUE SCRIPTS */
function jquery_init() {
if (!is_admin()) {
wp_deregister_script('jquery');
wp_register_script('jquery', get_template_directory_uri().'/style/js/jquery-1.6.4.min.js');//load jquery from google api, and place in footer
wp_enqueue_script('jquery');

wp_enqueue_script( 'quicksand', get_template_directory_uri().'/style/js/jquery.quicksand.js', array('jquery'));
wp_enqueue_script( 'easing', get_template_directory_uri().'/style/js/jquery.easing.js', array('jquery'));
wp_enqueue_script( 'flexslider', get_template_directory_uri().'/style/js/jquery.flexslider-min.js', array('jquery'));
wp_enqueue_script( 'twitter', get_template_directory_uri().'/style/js/twitter.min.js', array('jquery'));
wp_enqueue_script( 'fancybox', get_template_directory_uri().'/style/js/jquery.fancybox.pack.js', 'jquery', '2.0.6');
wp_enqueue_script( 'buttons', get_template_directory_uri().'/style/js/fancybox/helpers/jquery.fancybox-buttons.js', 'jquery', '1.0.2');
wp_enqueue_script( 'thumbs', get_template_directory_uri().'/style/js/fancybox/helpers/jquery.fancybox-thumbs.js', 'jquery', '1.0.2');
wp_enqueue_script( 'media', get_template_directory_uri().'/style/js/fancybox/helpers/jquery.fancybox-media.js', 'jquery', '1.0.0');
wp_enqueue_script( 'mosaic', get_template_directory_uri().'/style/js/mosaic.1.0.1.min.js', array('jquery'));
wp_enqueue_script( 'easytabs', get_template_directory_uri().'/style/js/jquery.easytabs.min.js', array('jquery'));
wp_enqueue_script( 'carousel', get_template_directory_uri().'/style/js/jquery.jcarousel.min.js', array('jquery'));
wp_enqueue_script( 'selectnav', get_template_directory_uri().'/style/js/selectnav.js', array('jquery'));
wp_enqueue_script( 'slickforms', get_template_directory_uri().'/style/js/jquery.slickforms.js', array('jquery'));
wp_enqueue_script( 'fitvid', get_template_directory_uri().'/style/js/jquery.fitvids.js', array('jquery'));
wp_enqueue_script( 'custom', get_template_directory_uri().'/style/js/custom.js', array('jquery'));

}elseif (is_admin()){

}
}
add_action('init', 'jquery_init');
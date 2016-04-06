<?php
/**
 * Registering meta boxes
 *
 * In this file, I'll show you how to add more field type (in this case, the 'taxonomy' type)
 * All the definitions of meta boxes are listed below with comments, please read them CAREFULLY
 *
 * You also should read the changelog to know what has been changed
 *
 * For more information, please visit: http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 *
 */

/**
 * Add field type: 'taxonomy'
 *
 * Note: The class name must be in format "RWMB_{$field_type}_Field"
 */
if ( !class_exists( 'RWMB_Taxonomy_Field' ) )
{
	class RWMB_Taxonomy_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_print_styles()
		{
			wp_enqueue_style( 'rwmb-taxonomy', RWMB_CSS_URL . 'taxonomy.css', RWMB_VER );
			wp_enqueue_script( 'rwmb-taxonomy', RWMB_JS_URL . 'taxonomy.js', array( 'jquery', 'wp-ajax-response' ), RWMB_VER, true );
		}

		/**
		 * Add default value for 'taxonomy' field
		 *
		 * @param $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			// Default query arguments for get_terms() function
			$default_args = array(
				'hide_empty' => false
			);
			if ( !isset( $field['options']['args'] ) )
				$field['options']['args'] = $default_args;
			else
				$field['options']['args'] = wp_parse_args( $field['options']['args'], $default_args );

			// Show field as checkbox list by default
			if ( !isset( $field['options']['type'] ) )
				$field['options']['type'] = 'checkbox_list';

			// If field is shown as checkbox list, add multiple value
			if ( 'checkbox_list' == $field['options']['type'] ||  'checkbox_tree' == $field['options']['type']){
				$field['multiple'] = true;
				$field['field_name'] = $field['field_name'] . '[]'; 
			}

			if('checkbox_tree' == $field['options']['type'] && !isset( $field['options']['args']['parent'] ) )
				$field['options']['args']['parent'] = 0;

			return $field;
		}

		/**
		 * Get field HTML
		 *
		 * @param $html
		 * @param $field
		 * @param $meta
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			global $post;

			$options = $field['options'];

			$terms = get_terms( $options['taxonomy'], $options['args'] );

			$html = '';
			// Checkbox_list
			if ( 'checkbox_list' == $options['type'] )
			{
				foreach ( $terms as $term )
				{
					$html .= "<input type='checkbox' name='{$field['field_name']}' value='{$term->slug}'" . checked( in_array( $term->slug, $meta ), true, false ) . " /> {$term->name}<br/>";
				}
			}
			//Checkbox Tree
			elseif ( 'checkbox_tree' == $options['type'] )
			{
				$html .= self::walk_checkbox_tree($meta, $field, true);
			}
			// Select
			else
			{
				
				$html .= "<select name='{$field['field_name']}'" . ( $field['multiple'] ? " multiple='multiple' style='height: auto;'" : "'" ) . ">";
				foreach ( $terms as $term )
				{
					$html .= "<option value='{$term->slug}'" . selected( in_array( $term->slug, $meta ), true, false ) . ">{$term->name}</option>";
				}
				$html .= "</select>";
			}

			return $html;
		}

		/**
		 * Walker for displaying checkboxes in treeformat
		 *
		 * @param $meta
		 * @param $field
		 * @param bool $active
		 *
		 * @return string
		 */
		static function walk_checkbox_tree( $meta, $field, $active = false )
		{
			$options = $field['options'];
			$terms = get_terms( $options['taxonomy'], $options['args'] );
			$count = count($terms);
			$html = '';
			$hidden = ( !$active ? 'hidden' : '' );
			if ( $count > 0 )
			{
				$html = "<ul class = 'rw-taxonomy-tree {$hidden}'>";
				foreach ( $terms as $term )
				{
					$html .= "<li> <input type='checkbox' name='{$field['field_name']}' value='{$term->slug}'" . checked( in_array( $term->slug, $meta ), true, false ) . disabled($active,false,false) . " /> {$term->name}";
					$field['options']['args']['parent'] = $term->term_id;
					$html .= self::walk_checkbox_tree($meta, $field, (in_array( $term->slug, $meta))) . "</li>";
				}
				$html .= "</ul>";
			}
			return $html;
		}

		/**
		 * Save post taxonomy
		 * @param $post_id
		 * @param $field
		 * @param $old
		 * @param $new
		 */
		static function save( $new, $old, $post_id, $field )
		{
			wp_set_object_terms( $post_id, $new, $field['options']['taxonomy'] );
		}
		
		/**
		 * Standard meta retrieval
		 *
		 * @param mixed 	$meta
		 * @param int		$post_id
		 * @param array  	$field
		 * @param bool  	$saved
		 *
		 * @return mixed
		 */
		static function meta( $meta, $post_id, $saved, $field )
		{
			
			$options = $field['options'];
			$meta = wp_get_post_terms( $post_id, $options['taxonomy'] );
			$meta = is_array( $meta ) ? $meta : ( array ) $meta;
			$meta = wp_list_pluck($meta, 'slug');
			return $meta;
		}
	}
}

/********************* META BOXES DEFINITION ***********************/

/**
 * Prefix of meta keys (optional)
 * Wse underscore (_) at the beginning to make keys hidden
 * You also can make prefix empty to disable it
 */
$prefix = 'rw_';

global $meta_boxes;

$meta_boxes = array();

// First meta box
$meta_boxes[] = array(
	'id' => 'template',							// meta box id, unique per meta box
	'title' => 'Page Template',			// meta box title
	'pages' => array('page'),	// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(							// list of meta fields
		
		array(
			'id' => $prefix . 'template',
			'type' => 'select',						// select box
			'options' => array(						// array of key => value pairs for select box
				'default' => 'Default',
				'home' => 'Home',
				'portfolio' => 'Portfolio',
				'news' => 'News',
				'contact' => 'Contact',
				'gallery' => 'Gallery'
			),
			'multiple' => false,						// select multiple values, optional. Default is false.
			'std' => array('default'),					// default value, can be string (single value) or array (for both single and multiple values)
			'desc' => 'Select a template for the page'
		),
		array(
			'name' => 'Page Description',					// field name
			'desc' => 'Enter a description for the page.',	// field description, optional
			'id' => $prefix . 'description',				// field id, i.e. the meta key
			'type' => 'text'
		)

	)
);
// Hook to 'admin_init' to make sure the meta box class is loaded before (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'your_prefix_register_meta_boxes' );

/**
 * Register meta boxes
 *
 * @return void
 */
function your_prefix_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
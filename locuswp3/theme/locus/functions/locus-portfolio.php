<?php
/* Declare the slider meta data array name */
define('SLIDERS', '_dc_sliders'); // name of entry into database

add_action('init', 'dc_sliders_init');

/* Custom post types */
function dc_sliders_init(){

  /* Portfolio */
  $labels = array(
    'name' => _x('Portfolio', 'post type general name', 'elemis'),
    'singular_name' => _x('Portfolio Post', 'post type singular name', 'elemis'),
    'add_new' => _x('Add New', 'Portfolio', 'elemis'),
    'add_new_item' => __('Add New Post', 'elemis'),
    'edit_item' => __('Edit Post', 'elemis'),
    'new_item' => __('New Post', 'elemis'),
    'view_item' => __('View Post', 'elemis'),
    'search_items' => __('Search Portfolio', 'elemis'),
    'not_found' =>  __('No Post found', 'elemis'),
    'not_found_in_trash' => __('No Post found in Trash', 'elemis'), 
    'parent_item_colon' => ''
  );
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
	'show_in_nav_menus' => true,
    'supports' => array('title','editor','author','thumbnail','comments')
  ); 
  
	register_post_type('Portfolio',$args);
	add_action( 'add_meta_boxes', 'dc_sliders_metabox' );
	add_action( 'save_post', 'dc_save_sliders_data' );
	
  /* videos */
  $labels = array(
    'name' => _x('Videos', 'post type general name', 'elemis'),
    'singular_name' => _x('video', 'post type singular name', 'elemis'),
    'parent_item_colon' => ''
  );
  
  $args = array(
    'labels' => $labels,
    'public' => false,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
	'show_in_nav_menus' => false,
    'supports' => array('title','excerpt','editor')
  ); 
  
  register_post_type('Video',$args);
}

/* Custom taxonomies */
function portfolio_taxonomy(){

	register_taxonomy(
        'filter',
        'portfolio',
        array(
            'hierarchical' => true,
            'label' => 'Filter',
            'query_var' => true,
			'show_in_nav_menus' => false,
            'rewrite' => array('slug' => 'filter'))
    );
}

add_action( 'init', 'portfolio_taxonomy' );

/* Declare sliders slide meta data */
$dc_slider_content_meta = array();
	
$dc_slider_content_meta[] = array( "name" => "slide",
					"label" => "Slide",
					"type" => "slide");

/* Slider meta boxes */
function dc_sliders_metabox() {

	add_meta_box('dc_slider_slides_id', __( 'Slides - Drag/Drop To Change Slide Order', 'dc_slider_input'), 'dc_slider_content_inner_custom_box', 'Portfolio', 'normal', 'high');
}

function get_slider_thumb(){

	update_post_meta( $_POST['attachID'], '_dc_slider_order', '99' );
	
	$attr = wp_get_attachment_image_src($_POST['attachID'],'large');
	$attach = get_post( $_POST['attachID'], OBJECT );
	
	$src = RESIZE.'/resize.php?src='.$attr[0].'&w=328&h=260';
	echo '<li rel="'.$_POST['attachID'].'"><img src="'.$src.'" alt="" /><a class="dc-actions button" rel="'.$_POST['attachID'].'" href="#">Delete</a>';	
	echo '<div class="slide-input">';
	echo '<label for="caption-'.$_POST['attachID'].'">Caption:</label>';
	echo '<textarea name="caption-'.$_POST['attachID'].'" class="dc-slide-caption dc-meta-input ">'.$attach->post_excerpt.'</textarea></li>';
	echo '</div>';
    die();
}

add_action('wp_ajax_getSliderThumb', 'get_slider_thumb');

/* Set slide order based on position of slide ID in array */
function dc_update_attachment_meta(){

	$i = 1;
	$list = '';
	$slides = explode(',', $_POST['slides']);
	foreach($slides as $slide){
	
		if($slide != ''){
			update_post_meta( $slide, '_dc_slider_order', $i );
			$list = $i > 1 ? $list.','.$slide : $slide ;
			$i++;
		}
	}
	update_post_meta( $_POST['post_id'], '_dc_slider_slide', $list );
	
    die();
}

add_action('wp_ajax_updateAttachmentMeta', 'dc_update_attachment_meta');

/* Prints the sliders slides box content */
function dc_slider_content_inner_custom_box(){

	global $dc_slider_content_meta, $post;
	
	wp_nonce_field('dc-portfolio-nonce', 'dc_slider_noncename');
	
	// create the meta data fields
	DC_PostMetaOptions::dc_meta_elements($dc_slider_content_meta,"_dc_slider",$post->ID);
}

add_action('wp_ajax_insertVideoPost', 'dc_insert_video_post');

/* Create video post entry */
function dc_insert_video_post(){

	  $postId = $_POST['post_id'];
	  $video = $_POST['video'];
	  
	  // Create post object
	  $my_post = array(
		 'post_title' => 'Video',
		 'post_content' => $video,
		 'post_status' => 'publish',
		 'post_author' => 1,
		 'post_type' => 'Video',
		 'post_parent' => $postId
	  );

	// Insert the post into the database
	$id = wp_insert_post( $my_post );
	
	// add slide meta
	update_post_meta( $id, '_dc_slider_order', '99' );
	
	$obj = get_post( $id, OBJECT );
	
	$width = 328;
	$height = 260;
	
	$vid = explode(',', $obj->post_content);
	
	echo '<li class="video-slide" rel="'.$id.'">';
	if($vid[0] == 'vimeo'){
		echo '<iframe class="vimeo-player" type="text/html" width="'.$width.'" height="'.$height.'" src="http://player.vimeo.com/video/'.$vid[1].'?title=0&amp;byline=0&amp;portrait=0" frameborder="0" allowFullScreen></iframe>';
	} else {
		echo '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$vid[1].'" frameborder="0" allowFullScreen></iframe>';
	}
	echo '<a class="dc-actions button" rel="'.$id.'" href="#">Delete</a>';	
	echo '</li>';
	echo '<input name="temp-new-id" type="hidden" id="dc-temp-id" value="'.$id.'" />';
    die();
}

/* When the post is saved, saves our custom data */
function dc_save_sliders_data() {
  
  global $dc_slider_content_meta, $post;
  
  // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
	  
  if (!isset($_POST['dc_slider_noncename']))
	  return;

  // verify this came from the our screen and with proper authorization
  if ( !wp_verify_nonce( $_POST['dc_slider_noncename'], 'dc-portfolio-nonce' ) )
      return;

  
  	$i = 1;

	$slides = explode(',', $_POST['_dc_slider_slide']);
	
	foreach($slides as $slide){
		
		if($slide != ''){
		
			$obj = get_post( $slide, OBJECT );
			if($obj->post_type == 'attachment'){			
							
				// Update attachment
				$my_post = array();
				$my_post['ID'] = $slide;
				$my_post['post_excerpt'] = $_POST['caption-'.$slide];
		
				// Update the post into the database
				wp_update_post( $my_post );
				
			}
		
			update_post_meta( $slide, '_dc_slider_order', $i );
			$i++;
		
		}
	}
  DC_PostMetaOptions::dc_meta_save($dc_slider_content_meta,"_dc_slider",$post->ID);
   
   return;
}

add_action("template_redirect", 'dc_slider_templates');

/* Slider custom template */
function dc_slider_templates(){

	global $wp, $wp_query;
	
	if ($wp_query->query_vars["post_type"] == "Portfolio"){
		if (have_posts()){
			include(TEMPLATEPATH . '/single-portfolio.php');
			die();
		} else {
			$wp_query->is_404 = true;
		}
	}
	
	wp_reset_postdata();
}

/* Create portfolio lightbox */
function dc_portfolio_lightbox( $id ){

	global $dc_slider_content_meta, $post;
	
	$slides = DC_PostMetaOptions::dc_meta_values($dc_slider_content_meta,'_dc_slider',$id);
	
	$arr = array();
	$opts = explode(',', $slides['slide']);
	foreach($opts as $opt){
		$arr[] = $opt;
	}
	
	$out ='<!-- Start portfolio lightbox -->';
	
		// slides - from attachment query
		$args = array(
			'post__in' => $arr,
			'post_status'=> 'any',
			'nopaging' => 'true',
			'posts_per_page' => 999,
			'post_type'=> Array('Video','attachment'),
			'orderby' => 'meta_value_num',
			'order' => 'ASC',
			'meta_key' => '_dc_slider_order'
		);

		$attachments = get_posts($args);

			if ($attachments) {
				
				$i = 0;
				
				foreach ($attachments as $attachment) {
				
					$url = wp_get_attachment_url($attachment->ID);
					$attach = get_post( $attachment->ID, OBJECT );
				
					if($attach->post_type == 'video'){
					
						$vid = explode(',', $attach->post_content);
						
						if($vid[0] == 'vimeo'){
							$href = 'http://vimeo.com/'.$vid[1];
						} else {
							$href = 'http://www.youtube.com/watch?v='.$vid[1];
						}

					} else {
					
						$href = $url;
					
					}
					
					
					$out .= $i == 0 ? '<a href="'.$href.'" class="fancybox-media" rel="portfolio-gallery" data-title-id="title-'.$id.'"><div class="caption">'.get_the_title($id).'</div>'.get_the_post_thumbnail( $id, 'portfolio_thumb' ).'</a><div id="title-'.$id.'" class="hidden"><h2>'.get_the_title($id).'</h2><div class="fancybox-desc">'.get_the_content($id).'</div></div>' : '<a href="'.$href.'" class="fancybox-media" rel="portfolio-gallery" data-title-id="title-'.$id.'"></a>' ;
					
					$i++;
				}
			}
			
	return $out;
	
}


?>
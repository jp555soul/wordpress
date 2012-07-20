<?php

if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run elemis_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'elemis_setup' );

if ( ! function_exists( 'elemis_setup' ) ):

/**
 * SETUP
 */
function elemis_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

/**
 * THUMBNAILS
 */
	add_theme_support( 'post-thumbnails' );
	
	
	if ( function_exists( 'add_image_size' ) ) add_theme_support( 'post-thumbnails' );
	if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'portfolio_thumb', 420, 266, true );
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'elemis', TEMPLATEPATH . '/lang' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/lang/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );


}
endif;


/**
 * TITLE
 */
function elemis_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'elemis' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'elemis' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'elemis' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'elemis_filter_wp_title', 10, 2 );

/**
 * Menu
 *
 */
 
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
}

	
	
function locus_addmenus() {
	register_nav_menus(
		array(
			'main_nav' => 'The Main Menu',
		)
	);
}
add_action( 'init', 'locus_addmenus' );
 
function locus_nav() {
    if ( function_exists( 'wp_nav_menu' ) )
        wp_nav_menu( 'container=&container_class=&fallback_cb=locus_nav_fallback' );
    else
        locus_nav_fallback();
}
 
function locus_nav_fallback() {
    wp_page_menu( 'show_home=0&include=999' );
}

/**
 * GALLERY SHORTCODE INLINE STYLE
 */
function elemis_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'elemis_remove_gallery_css' );

if ( ! function_exists( 'elemis_comment' ) ) :

/**
 * COMMENTS
 */
function elemis_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="com-wrap">
		<div class="comment-author vcard user">
			<?php echo get_avatar( $comment, 64 ); ?>
			<span class="edit-link"><?php edit_comment_link( __( 'Edit', 'elemis' ), ' ' ); ?></span>
		</div><!-- .comment-author .vcard -->
		<div class="message">
		<div class="info">
		<?php printf( __( '%s', 'elemis' ), sprintf( '<h4>%s</h4>', get_comment_author_link() ) ); ?>
		

<span class="date">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'elemis' ), get_comment_date(),  get_comment_time() ); ?>
		</span><!-- .comment-meta .commentmetadata -->
		<span class="reply-link"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
</div><div class="clear"></div><div class="divider"></div>
		<div class="comment-body "><?php comment_text(); ?></div>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="moderation"><?php _e( '(Your comment is awaiting moderation.)', 'elemis' ); ?></em>
		<?php endif; ?>
		
		</div>
		<div class="clear"></div>
	</div><!-- #comment-##  -->
<div class="clear"></div>
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'elemis' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'elemis'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;


function comment_reform ($arg) {
$arg['title_reply'] = __('Submit a comment', 'elemis');
return $arg;
}
add_filter('comment_form_defaults','comment_reform');

/**
 * SIDEBAR WIDGETS
 */
function elemis_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'elemis' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'elemis' ),
		'before_widget' => '<div id="%1$s" class="sidebox widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );

}
/** Register sidebars by running elemis_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'elemis_widgets_init' );

/**
 * RECENT COMMENTS WIDGET
 */
function elemis_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'elemis_remove_recent_comments_style' );

if ( ! function_exists( 'elemis_posted_on' ) ) :

/**
 * META
 */
function elemis_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'elemis' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'elemis' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'elemis_posted_in' ) ) :

function elemis_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'elemis' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'elemis' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'elemis' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;


/**
 * PAGINATION
 */

function pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1; 
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
     
     $navi_prev = __( 'Prev', 'elemis' );
     $navi_next = __( 'Next', 'elemis' );
     $navi_first = __( 'First', 'elemis' );
     $navi_last = __( 'Last', 'elemis' );
     
         echo "<div class=\"clear\"></div><ul class=\"page-navi\">";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>".$navi_first."</a></li>";
         if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>".$navi_prev."</a></li>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li><a href='".get_pagenum_link($i)."' class='current'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive'>".$i."</a></li>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<li><a href=\"".get_pagenum_link($paged + 1)."\">".$navi_next."</a></li>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>".$navi_last."</a></li>";
         echo "</ul>\n";
     }
}

/**
 * EXCLUDE PAGES FROM SEARCH
 */
 
function mySearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', 'post');
}
return $query;
}

add_filter('pre_get_posts','mySearchFilter');


/**
 * TAG CLOUD WIDGET SIZE
 */

function orz_tag_cloud_filter($args = array()) {
   $args['smallest'] = 13;
   $args['largest'] = 13;
   $args['unit'] = 'px';
   return $args;
}

add_filter('widget_tag_cloud_args', 'orz_tag_cloud_filter', 90);

/**
 * SHORTCODES IN WIDGETS
 */
 
add_filter('widget_text', 'do_shortcode');

/**
 * POST CLASS
 *
 */

add_filter( 'post_class', 'mysite_post_class', 10, 3 );
if( !function_exists( 'mysite_post_class' ) ) {
    /**
     * Append taxonomy terms to post class.
     * @since 2010-07-10
     */
    function mysite_post_class( $classes, $class, $ID ) {
        $taxonomy = 'filter';
        $terms = get_the_terms( (int) $ID, $taxonomy );
        if( !empty( $terms ) ) {
            foreach( (array) $terms as $order => $term ) {
                if( !in_array( $term->slug, $classes ) ) {
                    $classes[] = $term->slug;
                }
            }
        }
        return $classes;
    }
} 


/**
 * Slug
 *
 */

function the_slug($postID="") {
	
	global $post;
	$postID = ( $postID != "" ) ? $postID : $post->ID;
	$post_data = get_post($postID, ARRAY_A);
	$slug = $post_data['post_name'];
	return $slug;
}

/**
 * Custom Experts
 */
function new_excerpt_length($length) {
return 100;
}
function cutMe($content){
$limit = 340;
$content = strip_tags($content);
if (strlen($content) > $limit)
$content = substr($content, 0, strpos($content," ",$limit)) . ' [...]';
return $content;
}
function cutMeAgain($content){
$limit = 70;
$content = strip_tags($content);
if (strlen($content) > $limit)
$content = substr($content, 0, strpos($content," ",$limit)) . ' [...]';
return $content;
}
add_filter('excerpt_length', 'new_excerpt_length');

    add_filter('the_content', 'shortcode_empty_paragraph_fix');
    function shortcode_empty_paragraph_fix($content)
    {   
        $array = array (
            '<p>[' => '[', 
            ']</p>' => ']', 
            ']<br />' => ']'
        );

        $content = strtr($content, $array);

		return $content;
    }

	if ( !function_exists('elemis_shortcode_formatter') ) :

function elemis_shortcode_formatter($content) {
	$new_content = '';
	
	/* Matches the contents and the open and closing tags */
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	
	/* Matches just the contents */
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	
	/* Divide content into pieces */
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	
	/* Loop over pieces */
	foreach ($pieces as $piece) {
		/* Look for presence of the shortcode */
		if (preg_match($pattern_contents, $piece, $matches)) {
			
			/* Append to content (no formatting) */
			$new_content .= $matches[1];
		} else {
			
			/* Format and append to content */
			$new_content .= wptexturize(wpautop($piece));		
		}
	}
	
	return $new_content;
}

// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

// Before displaying for viewing, apply this function
add_filter('the_content', 'elemis_shortcode_formatter', 99);
add_filter('widget_text', 'elemis_shortcode_formatter', 99);

endif;

/** 2 Columns */
function col2_shortcode( $atts, $content = null ) {
   return '<div class="one-half">'."\n\n" . do_shortcode($content) . '</div>';
}
add_shortcode('col2', 'col2_shortcode');



/** 2 Columns Last */
add_shortcode( 'col2_last', 'col2_last_shortcode' );
function col2_last_shortcode( $atts, $content = null ) {
    return '<div class="one-half last">'."\n\n" . do_shortcode($content) . '</div><div class="clear"></div>';
}

/** 3 Columns */
function col3_shortcode( $atts, $content = null ) {
   return '<div class="one-third">'."\n\n" . do_shortcode($content) . '</div>';
}
add_shortcode('col3', 'col3_shortcode');



/** 3 Columns Last */
add_shortcode( 'col3_last', 'col3_last_shortcode' );
function col3_last_shortcode( $atts, $content = null ) {
    return '<div class="one-third last">'."\n\n" . do_shortcode($content) . '</div><div class="clear"></div>';
}

/** 4 Columns */
function col4_shortcode( $atts, $content = null ) {
   return '<div class="one-fourth">'."\n\n" . do_shortcode($content) . '</div>';
}
add_shortcode('col4', 'col4_shortcode');



/** 4 Columns Last */
add_shortcode( 'col4_last', 'col4_last_shortcode' );
function col4_last_shortcode( $atts, $content = null ) {
    return '<div class="one-fourth last">'."\n\n" . do_shortcode($content) . '</div><div class="clear"></div>';
}

/** 5 Columns */
function col5_shortcode( $atts, $content = null ) {
   return '<div class="one-fifth">'."\n\n" . do_shortcode($content) . '</div>';
}
add_shortcode('col5', 'col5_shortcode');

/** 5 Columns Last */
add_shortcode( 'col5_last', 'col5_last_shortcode' );
function col5_last_shortcode( $atts, $content = null ) {
    return '<div class="one-fifth last">'."\n\n" . do_shortcode($content) . '</div><div class="clear"></div>';
}

/** 6 Columns */
function col6_shortcode( $atts, $content = null ) {
   return '<div class="one-sixth">'."\n\n" . do_shortcode($content) . '</div>';
}
add_shortcode('col6', 'col6_shortcode');

/** 6 Columns Last */
add_shortcode( 'col6_last', 'col6_last_shortcode' );
function col6_last_shortcode( $atts, $content = null ) {
    return '<div class="one-sixth last">'."\n\n" . do_shortcode($content) . '</div><div class="clear"></div>';
}


/** One-Third Columns */
function col1_3_shortcode( $atts, $content = null ) {
   return '<div class="one-third">'."\n\n" . do_shortcode($content) . '</div>';
}
add_shortcode('col1_3', 'col1_3_shortcode');

/** One-Third Columns Last */
function col1_3_last_shortcode( $atts, $content = null ) {
   return '<div class="one-third last">'."\n\n" . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('col1_3_last', 'col1_3_last_shortcode');


/** Two-Third Columns */
function col2_3_shortcode( $atts, $content = null ) {
   return '<div class="two-third">'."\n\n" . do_shortcode($content) . '</div>';
}
add_shortcode('col2_3', 'col2_3_shortcode');

/** Two-Third Columns Last */
function col2_3_last_shortcode( $atts, $content = null ) {
   return '<div class="two-third last">'."\n\n" . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('col2_3_last', 'col2_3_last_shortcode');

/** One-Fourth Columns */
function col1_4_shortcode( $atts, $content = null ) {
   return '<div class="one-fourth">'."\n\n" . do_shortcode($content) . '</div>';
}
add_shortcode('col1_4', 'col1_4_shortcode');

/** One-Fourth Columns Last */
function col1_4_last_shortcode( $atts, $content = null ) {
   return '<div class="one-fourth last">'."\n\n" . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('col1_4_last', 'col1_4_last_shortcode');

/** Three-Fourth Columns */
function col3_4_shortcode( $atts, $content = null ) {
   return '<div class="three-fourth">'."\n\n" . do_shortcode($content) . '</div>';
}
add_shortcode('col3_4', 'col3_4_shortcode');

/** Three-Fourth Columns Last */
function col3_4_last_shortcode( $atts, $content = null ) {
   return '<div class="three-fourth last">'."\n\n" . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('col3_4_last', 'col3_4_last_shortcode');

/**
 * Image
 */
function image_shortcode($atts) {
	extract(shortcode_atts(array(		
		"url" => "",
		"img" => "",
		"alt" => "",
		"align" => "",
		"border" => "",
		"width" => "",
		"height" => "",
		"lightbox" => 'false'
	), $atts));
	
	if ( $img == '' )
		return NULL;
	
	if( $lightbox == 'true' )
		$img_rel = 'data-rel="prettyPhoto[]"';
		
	if( $url != '' & $width != '' & $height != '') {
		$output  .=  "\n" . '<a href="' . $url . '" ' . $img_rel . '><img src="' . $img . '" class="' . $align . '' . $border . '" width="' . $width . '" height="' . $height . '" alt="' . $alt . '" title="' . $alt . '" ' . $class . '/></a>';
	} elseif( $url != '' )  {
		$output  .=  "\n" . '<a href="' . $url . '" ' . $img_rel . '><img src="' . $img . '" class="' . $align . '' . $border . '" alt="' . $alt . '" title="' . $alt . '" ' . $class . '/></a>';
	} elseif( $width != '' & $height != '' )  {
		$output  .=  "\n" . '<img src="' . $img . '" class="' . $align . '' . $border . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '" title="' . $alt . '" ' . $class . '/>';
	} else {
		$output  .=  "\n" . '<img src="' . $img . '" alt="' . $alt . '" title="' . $alt . '" class="' . $align . '' . $border . '"/>';
	}
	
	return $output;
}
add_shortcode('image', 'image_shortcode');

/**
 * Mini-Services
 */
function mini_services_shortcode($atts, $content = null) {	
	return '<div id="service-columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('mini_services', 'mini_services_shortcode');


/**
 * Dropcap
 */
function dropcap_shortcode($atts, $content = null) {	
	return '<span class="dropcap">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap', 'dropcap_shortcode');

/**
 * Highlight
 */
function lite_shortcode($atts, $content = null) {	
	return '<span class="lite">' . do_shortcode($content) . '</span>';
}
add_shortcode('lite', 'lite_shortcode');

/**
 * Slider
 */
function slider_shortcode( $atts, $content = null ) {
   return '<div id="slider"><div class="flexslider"><ul class="slides">' . do_shortcode($content) . '</ul></div></div>';
}
add_shortcode('slider', 'slider_shortcode');

/**
 * Slide
 */
function slide_shortcode($atts) {
	extract(shortcode_atts(array(		
		"url" => "",
		"img" => "",
		"caption" => ""
	), $atts));
	
	
	if( $caption != '' ) {
		$output  .=  '<li><img src="' . $img . '"/><p class="flex-caption">' . $caption . '</p></li>';
	} else {
		$output  .=  '<li><img src="' . $img . '"/></li>';
	}
	
	return $output;
}
add_shortcode('slide', 'slide_shortcode');

/**
 * Slider Video
 */
function svideo_shortcode($atts, $content = null) {	
	return '<li>' . do_shortcode($content) . '</li>';
}
add_shortcode('svideo', 'svideo_shortcode');


/**
 * Forms
 */

function forms_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array( 
    "emailto" => '',
	"emailsubject" => '',
	"ip" => '',
	"url" => '',
	"submit" => 'Submit'
    ), $atts ) );
	
	$obfuscatedLink = "";
	for ($i=0; $i<strlen($emailto); $i++){
		$obfuscatedLink .= "&#" . ord($emailto[$i]) . ";";
	}
	
	
	$valid_err = of_get_option('valid_error');
	$valid_mail = of_get_option('valid_email');
	
	$validError = $valid_err == '' ? 'Required' : $valid_err;
	$validEmail = $valid_mail == '' ? 'Enter a valid email' : $valid_mail;
	
	$out = '<div class="form-container"><div class="response"></div>';
	$out .= '<form class="forms" action="'.get_stylesheet_directory_uri().'/admin/form-handler.php" method="post">';
	$out .= '<fieldset><ol>';
	$out .= do_shortcode( $content );
	$out .= '<li class="nocomment"><label for="nocomment">Leave This Field Empty</label><input id="nocomment" value="" name="nocomment" /></li>';
	$out .= '<li class="button-row"><input type="submit" value="'.$submit.'" name="submit" class="btn-submit" /></li>';
	$out .= '</ol>';
	$out .= '<input type="hidden" name="emailto" value="'.$obfuscatedLink.'" />';
	$out .= '<input type="hidden" name="emailsubject" value="'.$emailsubject.'" />';
	$out .= '<input type="hidden" name="v_error" id="v-error" value="'.$validError.'" />';
	$out .= '<input type="hidden" name="v_email" id="v-email" value="'.$validEmail.'" />';
	$out .= '<input type="hidden" name="ip" value="'.$ip.'" />';
	$out .= '<input type="hidden" name="url" value="'.$url.'" />';
	$out .= '</fieldset></form></div>';
	
   return $out;
}
add_shortcode('forms', 'forms_shortcode');

/**
 * Form Item
 */

function form_item_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array( 
    "input" => '', 
    "label" => '',
    "validation" => '1',
	"emailfrom" => '',
	"required" => '',
	"value" => '',
	"checked" => ''
    ), $atts ) );
	
	$valid = $required == 'true' ? ' required' : '';
	$checked = $checked == 'true' ? ' checked="checked"' : '';
	$name = strtolower(str_replace(" ", "-", $label));
	$validation = $input == 'text-input' ? $validation : '1' ;
	
	switch($validation)
    {
        case '1':
            $valid .= '';
            break;
        case '2':
			$valid .= ' email';
			$name = $emailfrom == true ? 'email' : $name ;
            break;
    }
	
	switch($input)
    {
        case 'text-input':
            $field = '<label>'.$label.'</label><input type="text" name="'.$name.'" value="" class="'.$input.$valid.'" title="" />';
            break;
        case 'password':
            $field = '<label>'.$label.'</label><input type="password" name="'.$name.'" value="" class="'.$input.$valid.'" />';
            break;
        case 'checkbox':
            $field = '<label>'.$label.'</label><input type="checkbox" name="'.$name.'" value="'.$value.'" class="'.$input.$valid.'"'.$checked.' />';
            break;
		case 'radio':
            $field = '<label>'.$label.'</label><input type="radio" name="'.$name.'" value="'.$value.'" class="'.$input.$valid.'"'.$checked.' />';
            break;
		case 'hidden':
            $field = '<input type="hidden" name="'.$name.'" value="" />';
            break;
		case 'text-area':
            $field = '<label>'.$label.'</label><textarea name="'.$name.'" class="'.$input.$valid.'"></textarea>';
            break;
    }
	
	$out = '<li class="form-row '.$input.'-row">';
	$out .= $field;
	$out .= '</li>';
	
   return $out;
}
add_shortcode('form_item', 'form_item_shortcode');

/**
 * Form Select List
 */

function form_select_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array( 
    "label" => ''
    ), $atts ) );
	
	$name = strtolower(str_replace(" ", "-", $label));
	$label = '<label>'.$label.'</label>';

	switch($selecttype)
    {
        case 'single':
            $field = $label.'<select name="'.$name.'" class="select" title="">';
			$field .= do_shortcode( $content );
			$field .= '</select>';
            break;
        case 'multi':
            $field = $label.'<select name="'.$name.'" class="multi-select" title="" multiple="multiple">';
			$field .= do_shortcode( $content );
			$field .= '</select>';
            break;
		default:
			$field = $label.'<select name="'.$name.'" class="select" title="">';
			$field .= do_shortcode( $content );
			$field .= '</select>';
            break;
    }
	
	$out = '<li class="form-row select-row">';
	$out .= $field;
	$out .= '</li>';
	
   return $out;
}
add_shortcode('form_select', 'form_select_shortcode');

/**
 * Form Select Option
 */

function form_option_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array( 
    "value" => ''
    ), $atts ) );

	$field = '<option value="'.$value.'">';
	$field .= do_shortcode( $content );
	$field .= '</option>';
	return $field;
}
add_shortcode('form_option', 'form_option_shortcode');

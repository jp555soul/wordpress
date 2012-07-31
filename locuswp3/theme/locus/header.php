<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php if ( of_get_option('favicon') ) { echo '<link rel="shortcut icon" href="'.of_get_option('favicon').'"/>'."\n"; } ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style/type/titillium.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/js/fancybox/jquery.fancybox.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.2" />
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style/css/ie8.css" media="screen" />
<![endif]-->
<!--[if IE 9]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style/css/ie9.css" media="screen" />
<![endif]-->
<?php if ( of_get_option('skin_select') ) { echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_template_directory_uri().'/style/css/'.of_get_option('skin_select').'.css"/>'."\n"; } ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	wp_head();
?>
<?php if ( of_get_option('twitter_username') ) { ?>
<script type="text/javascript">
getTwitters('twitter', {
        id: '<?php echo of_get_option('twitter_username'); ?>', 
        count: 1, 
        enableLinks: true, 
        ignoreReplies: false,
        template: '<span class="twitterPrefix"><span class="twitterStatus">%text%</span> <em class="twitterTime"><a href="http://twitter.com/%user_screen_name%/statuses/%id%">- %time%</a></em><br /><span class="username"><a href="http://twitter.com/%user_screen_name%">@%user_screen_name%</a></span>',
        newwindow: true
    });
</script>
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/css/media-queries.css" media="all" />
</head>
<body <?php body_class(); ?>  id="top">

<!-- Begin Wrapper -->
<div id="wrapper"> 
  <!-- Begin Header -->
  <div id="header">
    <div id="logo">
	
		<?php if ( of_get_option('logo') ) { ?>
			<a href="<?php echo home_url(); ?>"><img src="<?php echo of_get_option('logo'); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
		<?php } else {?>
			<h1 class="blog-title"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<?php } ?>
	
	</div>
    
    <!-- Begin Menu -->
		<?php wp_nav_menu( array( 'container_id' => '', 'container_class' => '', 'theme_location' => 'primary', 'items_wrap'  => '<ul id="menu" class="menu">%3$s</ul>', ) ); ?>
	<!-- End Menu -->
  </div>
  <!-- End Header --> 
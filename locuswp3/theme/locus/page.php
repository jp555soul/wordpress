<?php 

$home_url = get_bloginfo('url');
header("Location: $home_url");

get_header(); ?>

	
<?php get_footer(); ?>
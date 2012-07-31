<?php
$home_url = get_bloginfo('url');
header("Location: $home_url");
get_header();
?>
<h1>Error 404 - Not Found</h1>
<?php get_footer(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php global $data; ?>
<title>
<?php bloginfo('name'); ?>
</title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<link href="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/style.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/type/goudy.css" media="all" />
<style type="text/css">
body {
	background: #e8e8e8;
}
</style>
<?php wp_head();
?>
</head>
<body>
<div id="wrap" class="clear">
  <div class="logo">
    <div class="lcenter"> <a href="<?php echo home_url(); ?>">
    <?php if ( of_get_option('logo') ) { ?>
			<a href="<?php echo home_url(); ?>"><img src="<?php echo of_get_option('logo'); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
		<?php } else {?>
			<h1 class="blog-title"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<?php } ?>
    </a> </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
  <div class="box-top"></div>
  <div class="box-middle">
    <div class="intro">
      <?php _e('It looks like you are still using Internet Explorer 7 or earlier, which is not supported by this website. Please update to a cooler browser:', 'elemis') ?>
    </div>
    <ul id="icons">
      <li> <a href="http://www.mozilla.com/firefox/"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/firefox.png" alt="Firefox" /></a> </li>
      <li> <a href="http://www.apple.com/safari/download/"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/safari.png" alt="Safari" /></a> </li>
      <li> <a href="http://www.google.com/chrome/"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/chrome.png" alt="Chrome" /></a> </li>
      <li> <a href="http://www.opera.com/download/"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/opera.png" alt="Opera" /></a> </li>
      <li> <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/ie.png" alt="Internet Explorer 8" /></a> </li>
    </ul>
    <!-- Icons close --> 
  </div>
  <div class="box-bottom"></div>
</div>
</body>
</html>
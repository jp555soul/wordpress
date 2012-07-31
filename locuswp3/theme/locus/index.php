<?php get_header() ?> 

<?php
global $query_string;
query_posts($query_string . "post_type=page&post_status=publish&posts_per_page=9999&orderby=menu_order&order=ASC");
if ( have_posts() ) : while ( have_posts() ) : the_post(); 
$templates = get_post_meta( get_the_ID( ), 'rw_template', false );
$desc = get_post_meta(get_the_ID(), 'rw_description', true);
?>

<?php if ( in_array( home, $templates ) ) : ?>
<!-- Begin Home Page Template -->
<div id="<?php echo the_slug(); ?>" class="home-page borderline">
<div class="title"><h2><?php the_title(); ?><?php if ($desc) {echo " <span>$desc</span>";} ?></h2><div class="gototop"><a href="#top" class="scrolltop" title="<?php _e("Go to Top", "elemis"); ?>"></a></div></div>
<?php the_content(); ?>
</div>
<!-- End Home Page Template -->

<?php elseif ( in_array( portfolio, $templates ) ) : ?>
<!-- Begin Portfolio Section -->
  <div id="<?php echo the_slug(); ?>" class="portfolio-page borderline"> 
  	<div class="title"><h2><?php the_title(); ?><?php if ($desc) {echo " <span>$desc</span>";} ?></h2><div class="gototop"><a href="#top" class="scrolltop" title="<?php _e("Go to Top", "elemis"); ?>"></a></div></div>
    <!-- Begin Portfolio Navigation -->
    <ul id="content" class="gallerynav filter">
      <li class="all active"><a href="#"><?php _e("All", "elemis"); ?></a></li>
      <?php 
  $categories=  get_categories('taxonomy=filter&orderby=id'); 
  foreach ($categories as $cat) {
  	$input = '<li class="'.$cat->cat_name.'"><a href="#">';
	$input .= $cat->cat_name;
	$input .= '</a></li>';
	echo $input;
  } ?>
    </ul>
    <!-- End Portfolio Navigation --> 
    
    <!-- Begin Portfolio Elements -->
    <ul id="portfolio-gallery" class="grid">
   
   	<?php $recent = new WP_Query(); ?>
	<?php $recent->query('post_type=portfolio&posts_per_page=99999&order=DESC'); ?>
	<?php while($recent->have_posts()) : $recent->the_post(); ?>
	<?php $terms_as_text = strip_tags( get_the_term_list( $recent->post->ID, 'filter', '', ' ', '' ) ); ?>
      <!-- Begin Item -->
          <li data-id="<?php echo "".get_the_id();?>" class="portfolio-item" data-type="<?php echo $terms_as_text; ?>">
          	<?php echo dc_portfolio_lightbox( $post->ID ); ?>
			
          
          </li>
          <!-- End Item -->
      <?php endwhile; ?>

    </ul>
    <!-- End Portfolio Elements --> 
  </div>
  <!-- End Portfolio Section --> 


<?php elseif ( in_array( gallery, $templates ) ) : ?>
<!-- Begin Gallery Page Template -->
<div id="<?php echo the_slug(); ?>" class="gallery-page borderline">
<div class="title"><h2><?php the_title(); ?><?php if ($desc) {echo " <span>$desc</span>";} ?></h2><div class="gototop"><a href="#top" class="scrolltop" title="<?php _e("Go to Top", "elemis"); ?>"></a></div></div>

<?php if($content = $post->post_content ) {
      echo "<div class='gallery-text'>";
      the_content();
      echo "</div>";
   } ?>

<ul id="gallery-wrapper" class="gallery">
<?php
$args = array(
	'post_type' => 'attachment',
	'posts_per_page' => -1,
	'numberposts' => 9999,
	'post_status' => null,
	'order' => 'ASC',
	'orderby' => 'menu_order',
	'post_parent' => $post->ID
	); 
	
$attachments = get_posts($args);
if ($attachments) {
	foreach ($attachments as $attachment) {
		$attachment_img =  wp_get_attachment_url( $attachment->ID);
		$attachment_id = $attachment->ID;
        echo '<li><a data-title-id="title-'.$attachment_id.'" class="fancybox-media" rel="gallery" href="'.$attachment_img.'">';
        echo  '<img src="'.get_bloginfo('template_url').'/functions/img_resize/resize.php?src='.$attachment_img.'&amp;w=420&amp;h=266&amp;zc=1" alt=""/>';
        echo '</a><div id="title-'.$attachment_id.'" class="hidden"><h2>'.get_the_title($attachment_id).'</h2><div class="fancybox-desc">'.$attachment->post_content.'</div></div></li>';
	}
}
?>
</ul>
</div>
<!-- End Gallery Page Template -->

<?php elseif ( in_array( news, $templates ) ) : ?>
<!-- Begin News Page Template -->
  <div id="<?php echo the_slug(); ?>" class="news-page borderline">
  <div class="title"><h2><?php the_title(); ?><?php if ($desc) {echo " <span>$desc</span>";} ?></h2><div class="gototop"><a href="#top" class="scrolltop" title="<?php _e("Go to Top", "elemis"); ?>"></a></div></div>
  
  
  
  <div id="tab-buttons-container" class="tab-container">

 <ul id="carousel" class="etabs">
 <?php $lastposts = get_posts('numberposts=9999');
 foreach($lastposts as $post) :
    setup_postdata($post); ?>
  <li class="tab">
  <div class="date">
        				<div class="day"><?php the_time('d') ?></div>
        				<div class="month"><?php the_time('M') ?></div>
  					</div>
  
  <a href="#<?php echo the_slug(); ?>"><?php the_title(); ?></a></li>
  <?php endforeach; ?>
 </ul>

 <div class="panel-container">
 <?php $lastposts = get_posts('numberposts=9999');
 foreach($lastposts as $post) :
    setup_postdata($post); ?>
  <div id="<?php echo the_slug(); ?>" class="tab-buttons-panel">
	<h2><?php the_title(); ?></h2>
	<span class="postdate"><?php the_time('d M Y') ?></span>
          	<?php the_content(); ?>
  </div>
  <?php endforeach; ?>
 </div>
</div>

<script type="text/javascript">
$('#tab-buttons-container').easytabs({
	updateHash: false
});

var $tabContainer = $('#tab-buttons-container'),
    $tabs = $tabContainer.data('easytabs').tabs,
    $tabPanels = $(".tab-buttons-panel")
    totalSize = $tabPanels.length;

$tabPanels.each(function(i){
  if (i != 0) {
    prev = i - 1;
    $(this).prepend("<a href='#' class='prev-tab btn success' rel='" + prev + "'>&laquo; Prev Page</a>");
  } else {
    $(this).prepend("<span class='prev-tab btn'>&laquo; Prev Page</span>");
  }
  if (i+1 != totalSize) {
    next = i + 1;
    $(this).prepend("<a href='#' class='next-tab btn success' rel='" + next + "'>Next Page &raquo</a>");
  } else {
    $(this).prepend("<span class='next-tab btn'>Next Page &raquo</span>");
  }
});

$('.next-tab, .prev-tab').click(function() {
  var i = parseInt($(this).attr('rel'));
  var tabSelector = $tabs.children('a:eq(' + i + ')').attr('href');
  $tabContainer.easytabs('select', tabSelector);
  return false;
});
</script>
  

  
  </div>

<!-- End News Page Template -->

<?php elseif ( in_array( contact, $templates ) ) : ?>
<!-- Begin Contact Page Template -->
<!-- Begin Contact Section -->
  <div id="<?php echo the_slug(); ?>" class="contact-page borderline">
  	<div class="title"><h2><?php the_title(); ?><?php if ($desc) {echo " <span>$desc</span>";} ?></h2><div class="gototop"><a href="#top" class="scrolltop" title="<?php _e("Go to Top", "elemis"); ?>"></a></div></div>
    <div class="contact-container">
<?php 
$email_to = of_get_option('emailto'); 
$subject = of_get_option('email_subject'); 
$lname = of_get_option('label_name'); 
$lemail = of_get_option('label_email'); 
$lsubject = of_get_option('label_subject');
$lmessage = of_get_option('label_message');
$lsubmit = of_get_option('label_button');
?>
        <!-- Begin Form -->
        <?php echo do_shortcode("
        [forms emailsubject='$subject' submit='$lsubmit' emailto='$email_to']
        [form_item input='text-input' label='$lname' required='true' validation='1'] 
        [form_item input='text-input' label='$lemail' required='true' validation='2'] 
        [form_item input='text-input' label='$lsubject' required='true' validation='1'] 
        [form_item input='text-area' label='$lmessage' required='true' validation='1'] 
        [/forms]") ?> 
        <!-- End Form -->

        <!-- Begin Information -->
        <div class="contact-right">
        <?php if($content = $post->post_content ) {
      			echo "<div class='contact-info'>";
      			the_content();
      			echo "</div>";
   		} ?>
   		
          <?php if ( of_get_option('twitter_username') ) { ?>
			<div class="twitter-wrapper">
          	 <div class="message" id="twitter"></div>
          	 <div class="bird"></div>
            </div>
		  <?php } ?>
          
          <div class="contact-info"> 
            <!-- Begin Social Icons -->
          <ul class="social">
          	<?php if ( of_get_option('social_facebook') ) {?>
        	<li><a href="<?php echo of_get_option('social_facebook'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/style/images/icon-fb.png" alt="" /></a></li>
        	<?php } else {?>
        	<?php }?>
          	<?php if ( of_get_option('social_flickr') ) {?>
        	<li><a href="<?php echo of_get_option('social_flickr'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/style/images/icon-fl.png" alt="" /></a></li>
        	<?php } else {?>
        	<?php }?>
          	<?php if ( of_get_option('social_twitter') ) {?>
        	<li><a href="<?php echo of_get_option('social_twitter'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/style/images/icon-tw.png" alt="" /></a></li>
        	<?php } else {?>
        	<?php }?>
          	<?php if ( of_get_option('social_google') ) {?>
        	<li><a href="<?php echo of_get_option('social_google'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/style/images/icon-gp.png" alt="" /></a></li>
        	<?php } else {?>
        	<?php }?>
        	<?php if ( of_get_option('social_linkedin') ) {?>
        	<li><a href="<?php echo of_get_option('social_linkedin'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/style/images/icon-li.png" alt="" /></a></li>
        	<?php } else {?>
        	<?php }?>
          	<?php if ( of_get_option('social_dribbble') ) {?>
        	<li><a href="<?php echo of_get_option('social_dribbble'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/style/images/icon-db.png" alt="" /></a></li>
        	<?php } else {?>
        	<?php }?>
          	<?php if ( of_get_option('social_deviantart') ) {?>
        	<li><a href="<?php echo of_get_option('social_deviantart'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/style/images/icon-dev.png" alt="" /></a></li>
        	<?php } else {?>
        	<?php }?>
          	<?php if ( of_get_option('social_tumblr') ) {?>
        	<li><a href="<?php echo of_get_option('social_tumblr'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/style/images/icon-tu.png" alt="" /></a></li>
        	<?php } else {?>
        	<?php }?>
        	<?php if ( of_get_option('social_stumble') ) {?>
        	<li><a href="<?php echo of_get_option('social_stumble'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/style/images/icon-su.png" alt="" /></a></li>
        	<?php } else {?>
        	<?php }?>
          </ul>
          <!-- End Social Icons -->
          </div>
        </div>
        <!-- End Information --> 
      </div>
    <div id="bottom">
      <?php if ( of_get_option('footer_text') ) { echo '<div class="copyright">'.of_get_option('footer_text').'</div>'."\n"; } ?>
      <div class="gototop"><a href="#top" class="scrolltop" title="<?php _e("Go to Top", "elemis"); ?>"></a></div>
      <div class="clear"></div>
    </div>
  </div>
  <!-- End Contact Section -->
<!-- End Contact Page Template -->

<?php else : ?>
<!-- Begin Default Page Template -->
  <div id="<?php echo the_slug(); ?>" class="borderline">
  	<div class="title"><h2><?php the_title(); ?><?php if ($desc) {echo " <span>$desc</span>";} ?></h2><div class="gototop"><a href="#top" class="scrolltop" title="<?php _e("Go to Top", "elemis"); ?>"></a></div></div>
    <div class="section-container">
      <?php the_content(); ?>
    </div>
  </div>
<!-- End Default Page Template -->

<?php endif; ?>
<?php endwhile; endif; ?>



<?php wp_reset_query(); ?>
<script type="text/javascript">
$('a[data-rel]').each(function() {
    $(this).attr('rel', $(this).data('rel'));
});
</script>

<?php get_footer() ?>
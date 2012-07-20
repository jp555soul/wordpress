<?php
/*-----------------------------------------------------------------------------------*/
/* Class for handling Custom Post Metaboxes  */
/*-----------------------------------------------------------------------------------*/

class DC_PostMetaOptions{

	function __construct(){
	
	}
	
	/* Generates custom metabox inputs */
	public static function dc_meta_elements($options,$type,$postId){
 
		global $post;
		$i = 0;
		$out = '';
		foreach ($options as $value){
		
			if($value['type'] == 'heading'){
			
				$out .= '<h4 class="dc-meta-heading">'.$value['text'].'</h4>';
				
			} elseif($value['type'] == 'end'){
			
				$out .= '<div class="dc-clear"></div>';
				
			} else {
			
				$i++;
				if(isset($value['label'])){
					$label = $value['label'];
				} else {
					$label = $value['name'];
				}
				$name = $type.'_'.$value['name'];
				$itemId = str_replace('_dc','dc',$name);
				if(isset($value['row'])){
					$class = 'class="dc-meta-row '.$value['row'].'"';
				} else {
					$class = 'class="dc-meta-row"';
				}
				$val = get_post_custom_values($name,$postId);
				$std = isset($value['std']) ? $value['std'] : '' ;
				$val = $val[0] != '' ? $val[0] : $std;
				
				$out .= '<div '.$class.'>';

				switch ($value['type'])
				{
					
					case 'text':
						$out .= '<label for="'.$name.'">'.$label.':</label>';
						$out .= '<input class="dc-meta-input" name="'.$name.'" id="'.$itemId.'" type="'.$value['type'].'" value="'.$val.'" />';
					break;
					
					case 'slide':
						$width = 328;
						$height = 260;
						$out .= '<div id="'.$name.'-container" class="dc-slide-container"><ul>';
						$slides = explode(',', $val);
						foreach($slides as $slide){
						
							if($slide != ''){
							
								$obj = get_post( $slide, OBJECT );
								
								switch($obj->post_type)
								{
									case 'attachment':
										$out .= '<li rel="'.$slide.'">';
										$attr = wp_get_attachment_image_src($slide,'large');
										$src = RESIZE.'/resize.php?src='.$attr[0].'&w='.$width.'&h='.$height;
										$out .= '<img src="'.$src.'" alt="" />';
										$out .= '<a class="dc-actions button" rel="'.$slide.'" href="#">Delete</a>';
										$out .= '<div class="slide-input">';
									$out .= '<label for="'.$name.'">Caption:</label>';
									$out .= '<textarea name="caption-'.$slide.'" class="dc-slide-caption dc-meta-input ">'.$obj->post_excerpt.'</textarea>';
									$out .= '</div>';
									break;
									case 'Video':
										$out .= '<li class="video-slide" rel="'.$slide.'">';
										$vid = explode(',', $obj->post_content);
										if($vid[0] == 'vimeo'){
											$out .= '<iframe class="vimeo-player" type="text/html" width="'.$width.'" height="'.$height.'" src="http://player.vimeo.com/video/'.$vid[1].'?title=0&amp;byline=0&amp;portrait=0" frameborder="0" allowFullScreen></iframe>';
										} else {
											$out .= '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$vid[1].'" frameborder="0" allowFullScreen></iframe>';
										}
										$out .= '<a class="dc-actions button" rel="'.$slide.'" href="#">Delete</a>';
									break;
								}
								
									$out .= '</li>';
								
							}
						}
						$out .= '</ul>';
						$out .= '<div id="slider-holder-content"><label>Enter Video ID</label><input type="text" id="temp-video" name="temp-video" value="" class="slide-holder-input" />';
						$out .= '<input type="radio" name="source" class="video-source" value="vimeo" checked="checked" /> Vimeo';
						$out .= '<input type="radio" name="source" class="video-source" value="youtube" /> YouTube';
						$out .= '<a id="btn-video-cancel" class="button clear" rel="" href="#">Cancel</a><a id="btn-video" class="button" rel="" href="#">OK</a></div></div>';
						$out .= '<input name="'.$name.'" id="'.$name.'" class="dc-slide-value" type="hidden" value="'.$val.'" />';
						$out .= '<input type="button" class="button-secondary dc-button-image" id="'.$name.'-button" value="Add Slide" />';
						$out .= '<input type="button" class="button-secondary dc-button-video" id="'.$name.'-button" value="Add Video" />';

					break;
				}
	
					$out .= '</div>';

			}
		}

		echo $out;
		
		return;
	}
	
	/* Generates custom metabox inputs for slides */
	public static function dc_slide_elements($options,$type,$postId){
 
		global $post;
		$i = 0;
		$out = '';
		foreach ($options as $value){
		
			$slides = $value['name'];
			
				foreach ($slides as $slide){
				
					$out .= '<h4 class="dc-meta-heading">'.$slide.'</h4>';
					$width = 328;
					$height = 260;
					$out .= '<div id="'.$slide.'-container" rel="'.$slide.'" class="dc-slide-container">';
					
					$attr = wp_get_attachment_image_src($slide,'large');
					$src = RESIZE.'/resize.php?src='.$attr[0].'&w='.$width.'&h='.$height;
					$out .= '<img src="'.$src.'" alt="" />';
			
		
					$out .= '</div>';
					$out .= '<input name="'.$name.'" id="'.$name.'" class="dc-slide-value" type="hidden" value="'.$val.'" />';
					$out .= '<input type="button" class="button-secondary dc-button-image dc-actions button" id="'.$name.'-button-delete" value="Delete" />';
					$out .= '<input type="button" class="button-secondary dc-button-image" id="'.$name.'-button-image" value="Add Slide" />';
					$out .= '<input type="button" class="button-secondary dc-button-video" id="'.$name.'-button-video" value="Add Video" />';
	
					$out .= '<label for="'.$name.'-heading">Heading:</label>';
					$out .= '<input class="dc-meta-input" name="'.$name.'["heading"]" id="'.$name.'-heading" type="text" value="'.$val.'" />';
					
					$out .= '<label for="'.$name.'-caption">Caption:</label>';
					$out .= '<input class="dc-meta-input" name="'.$name.'["caption"]" id="'.$name.'-caption" type="text" value="'.$val.'" />';
			
				}
			}
		
		return $out;
	}
	
	/* Saves custom metabox data */
	public static function dc_meta_save($options,$type,$postId){
 
		// Check permissions
		if ( 'page' == $_POST['post_type'] ){
			if ( !current_user_can( 'edit_page', $postId ))
				return;
		} else {
			if ( !current_user_can( 'edit_post', $postId ))
				return;
		}
		
		foreach ($options as $value){
		
			if(isset($value['name'])){
				if ($value['name'] != 'shortcode_link'){
					$name = $type.'_'.$value['name'];
					$v = $_POST[$name];
					update_post_meta($postId, $name, $v);
				}
			}
		}
		
		return;
	}
	
	/* Retrieves custom metabox values for a post 
	 * returns array of values
	*/
	public static function dc_meta_values($options,$type=null,$postId){

		foreach ($options as $value){
			if(isset($value['name'])){
				$name = $type != '' ? $type.'_'.$value['name'] : $value['name'] ;
				$v = get_post_custom_values($name,$postId);
				if($v[0] != ''){
					$out[$value['name']] = $v[0];
				}
			}
		}
		
		return $out;
	}
	
	/* Retrieves custom metabox values for a post 
	 * returns array of values
	*/
	public static function dc_meta_post_values($options,$postId){

		$out = '';
		
		foreach ($options as $value){
			if(isset($value['name'])){
				$name = '_dc_theme_post_'.$value['name'] ;
				$v = get_post_custom_values($name,$postId);
				if($v[0] != ''){
					$out[$value['name']] = $v[0];
				}
			}
		}
		
		return $out;
	}

}// End Class
?>
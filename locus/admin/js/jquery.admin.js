jQuery(document).ready(function($){
	var slider = $('#dc_slider_type').val();
	dc_slider_options(slider);
	$('#dc_slider_type').change(function(){
		var val = $(this).val();
		dc_slider_options(val);
	});
	$('.dc-switch-link a').live('click',function(){
		var $tag = $(this).parent();
		$('a',$tag).toggleClass('active');
		var rel = $('a.active',$tag).attr('rel');
		$tag.next('.dc-switch-value').val(rel);
		return false;
	});
	$('.link-multi-set').live('click',function(){
		var href = $(this).attr('href');
		var vars = [], hash;
		var q = href.split('?')[1];
		if(q != undefined){
			q = q.split('&');
			for(var i = 0; i < q.length; i++){
				hash = q[i].split('=');
				vars.push(hash[1]);
				vars[hash[0]] = hash[1];
			}
		}
		var thumb_id = vars['thumb_id'];
		var id = vars['id'];
		var post_type = vars['post_type'];
		var nonce = vars['nonce'];
		
		var $link = $('a#' + post_type + '-' + id + '-thumbnail-' + thumb_id);
		
		$link.text(setPostThumbnailL10n.saving);
		
		jQuery.post(ajaxurl,{
			action:'set-' + post_type + '-' + id + '-thumbnail', post_id: post_id, thumbnail_id: thumb_id, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
		},function(str){
			var win = window.dialogArguments || opener || parent || top;
			$link.text( setPostThumbnailL10n.setThumbnail );
			if (str == '0'){
				alert( setPostThumbnailL10n.error );
			} else {
				$link.show();
				$link.text( setPostThumbnailL10n.done );
				$link.fadeOut( 2000, function() {
					jQuery('tr.' + post_type + '-' + id + '-thumbnail').hide();
				});
				win.MultiImageSetThumbnailID(thumb_id, id, post_type);
				win.MultiImageSetThumbnailHTML(str, id, post_type);
			}
		});
	return false;
	});
	$(".dc-slide-container ul").sortable({
		placeholder: "sort-holder",
		stop: function(event, ui) {
			var sortOrder = [];
			$(".dc-slide-container ul li").each(function(){
				var rel = $('.dc-actions',this).attr('rel');
				var i = $(this).index('.dc-slide-container ul li');
				sortOrder.push(rel);
			});
			$('.dc-slide-value').val(sortOrder);
			DCImageMeta.changeOrder();
		}
	});
	$('.dc-button-video').click(function(e){
		$('#slider-holder-content').slideDown();
		e.preventDefault();
	});
	$('#btn-video-cancel').click(function(e){
		$('#slider-holder-content').slideUp();
		$('#temp-video').val('');
		e.preventDefault();
	});
	
	$('#btn-video').bind('click',function(){
		var file = $('#temp-video').val();
		var source = $('.video-source:checked').val();
		var video = source+','+file;
		DCImageMeta.ajax('&action=insertVideoPost&video=' + video + '&post_id=' + jQuery('#post_ID').val(), 'html', function(response){
			 jQuery('.dc-slide-container ul').append(response);
			 var attachID = jQuery('#dc-temp-id').val();
			 jQuery('#dc-temp-id').remove();
			 var val = jQuery('.dc-slide-value').val() == '' ? attachID : jQuery('.dc-slide-value').val()+','+attachID ; 
			jQuery('.dc-slide-value').val(val);
			DCImageMeta.ajax('&action=updateAttachmentMeta&slides=' + val, 'html', function(response){});
			$('#slider-holder-content').slideUp();
			$('#temp-video').val('');
		});
		return false;
	});
	$('#dc-cancel').live('click',function(){
		$('.dc-slide-container ul li#slide-holder').remove();
		return false;
	});
});

// set slider options
function dc_slider_options(slider){

	jQuery('.dc-meta-row.slider-type').slideUp();
	jQuery('.dc-meta-row.slider-type.slider-'+slider).slideDown();
}

// update attachment meta
function dc_update_attachment_meta(slides){

	jQuery.ajax('&action=updateAttachmentMeta&slides=' + slides + '&post_id=' + jQuery('#post_ID').val(), 'html', function(response){
        jQuery('#_dc_slider_slide-container').after(response);
    });
}

var DCImageMeta = {

    is_upload:'',

    init:function() {
        jQuery('.dc-button-image').click(function(){
			DCImageMeta.is_upload = true;
			tb_show('', 'media-upload.php?post_id=' + jQuery('#post_ID').val() + 'type=image&TB_iframe=true');
			return false;
		});
		
        jQuery('.dc-actions').live('click', function(){
			var $slide = jQuery(this).parent();
			var rel = jQuery(this).attr('rel');
			$slide.fadeOut(function() {
				jQuery(this).remove();
			});
			var val = jQuery('.dc-slide-value').val();
			val = val.replace(rel,'');
			jQuery('.dc-slide-value').val(val);
			DCImageMeta.changeOrder();

			return false;
		});
        DCImageMeta.appendImage();
    },
    ajax:function(action, type, callback) {
        jQuery.ajax({type:"POST",url:ajaxurl,dataType:type,data:action,success:function(html) {
            if (typeof callback == 'function') callback(html);
        }});
    },
    appendImage:function() {
        window.original_action = window.send_to_editor;
        window.send_to_editor = function(response) {
            var html=jQuery(response);
            if (DCImageMeta.is_upload) {
                DCImageMeta.is_upload = false;
                if(jQuery('img',html).size()>0){
                    var attachClasses = jQuery('img',html).attr('class').split(' ');
                } else {
                    var attachClasses = jQuery(html).attr('class').split(' ');
                }
                for (key in attachClasses) {
                    if (attachClasses[key].indexOf("wp-image-") != -1) {
                        var attachID = attachClasses[key].split('-')[2];
                    }
                }
                DCImageMeta.ajax('&action=getSliderThumb&attachID=' + attachID, 'html', function(response){
					var val = jQuery('.dc-slide-value').val() == '' ? attachID : jQuery('.dc-slide-value').val()+','+attachID ; 
					jQuery('.dc-slide-value').val(val);
                    jQuery('.dc-slide-container ul').append(response);
                    tb_remove();
					DCImageMeta.ajax('&action=updateAttachmentMeta&slides=' + val, 'html', function(response){});
                });
            } else {
                window.original_action(response);
            }
        }
    },
	addVideo:function() {
        var video = $('#temp-video').val();
		DCImageMeta.ajax('&action=insertVideoPost&video=' + video, 'html', function(response){
			alert(response);
		});
    },
	changeOrder:function() {
        var val = jQuery('.dc-slide-value').val();
		DCImageMeta.ajax('&action=updateAttachmentMeta&post_id=' + jQuery('#post_ID').val() + '&slides=' + val, 'html', function(response){});
    },
    removeImage:function() {
        jQuery('.dc-slide-container li').fadeOut(function() {
            jQuery(this).remove();
            jQuery('.dc-slide-value').val('');
        });
        return false;
    }
}

jQuery(document).ready(function(){
    DCImageMeta.init();
});

function dc_send_to_editor(h){
	var ed;
	if (typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden()){
		ed.focus();
		if ( tinymce.isIE )
		ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);
		ed.execCommand('mceInsertContent', false, h);
		
	} else if ( typeof edInsertContent == 'function' ) {
		edInsertContent(edCanvas, h);
	} else {
		jQuery( edCanvas ).val( jQuery( edCanvas ).val() + h );
	}
	tb_remove();
};

function MultiImageSetThumbnailHTML(html, id, post_type){
	jQuery('.inside', '#' + post_type + '-' + id).html(html);
};

function MultiImageSetThumbnailID(thumb_id, id, post_type){
	var field = jQuery('input[value=_' + post_type + '_' + id + '_thumbnail_id]', '#list-table');
	if ( field.size() > 0 ) {
		jQuery('#meta\\[' + field.attr('id').match(/[0-9]+/) + '\\]\\[value\\]').text(thumb_id);
	}
};

function MultiImageRemoveThumbnail(id, post_type, nonce){
	jQuery.post(ajaxurl, {
		action:'set-' + post_type + '-' + id + '-thumbnail', post_id: jQuery('#post_ID').val(), thumbnail_id: -1, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
	}, function(str){
		if ( str == '0' ) {
			alert( setPostThumbnailL10n.error );
		} else {
			MultiImageSetThumbnailHTML(str, id, post_type);
		}
	}
	);
};

function MultiImageSetAsThumbnail(thumb_id, id, post_type, nonce){
	var $link = jQuery('a#' + post_type + '-' + id + '-thumbnail-' + thumb_id);

	$link.text( setPostThumbnailL10n.saving );
	jQuery.post(ajaxurl, {
		action:'set-' + post_type + '-' + id + '-thumbnail', post_id: post_id, thumbnail_id: thumb_id, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
	}, function(str){
		var win = window.dialogArguments || opener || parent || top;
		$link.text( setPostThumbnailL10n.setThumbnail );
		if ( str == '0' ) {
			alert( setPostThumbnailL10n.error );
		} else {
			$link.show();
			$link.text( setPostThumbnailL10n.done );
			$link.fadeOut( 2000, function() {
				jQuery('tr.' + post_type + '-' + id + '-thumbnail').hide();
			});
			win.MultiImageSetThumbnailID(thumb_id, id, post_type);
			win.MultiImageSetThumbnailHTML(str, id, post_type);
		}
	}
	);
}

jQuery(document).ready(function($){

	$('.link-multi-set').live('click',function(){
	
		var href = $(this).attr('href');
		var vars = [], hash;
		var q = href.split('?')[1];
		if(q != undefined){
			q = q.split('&');
			for(var i = 0; i < q.length; i++){
				hash = q[i].split('=');
				vars.push(hash[1]);
				vars[hash[0]] = hash[1];
			}
		}
		var thumb_id = vars['thumb_id'];
		var id = vars['id'];
		var post_type = vars['post_type'];
		var nonce = vars['nonce'];
		
		var $link = $('a#' + post_type + '-' + id + '-thumbnail-' + thumb_id);
		
		$link.text(setPostThumbnailL10n.saving);
		
		jQuery.post(ajaxurl,{
			action:'set-' + post_type + '-' + id + '-thumbnail', post_id: post_id, thumbnail_id: thumb_id, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
		},function(str){
			var win = window.dialogArguments || opener || parent || top;
			$link.text( setPostThumbnailL10n.setThumbnail );
			if (str == '0'){
				alert( setPostThumbnailL10n.error );
			} else {
				$link.show();
				$link.text( setPostThumbnailL10n.done );
				$link.fadeOut( 2000, function() {
					jQuery('tr.' + post_type + '-' + id + '-thumbnail').hide();
				});
				win.MultiImageSetThumbnailID(thumb_id, id, post_type);
				win.MultiImageSetThumbnailHTML(str, id, post_type);
			}
		});
	return false;
	});
});

function MultiImageSetThumbnailHTML(html, id, post_type){
	jQuery('.inside', '#' + post_type + '-' + id).html(html);
};

function MultiImageSetThumbnailID(thumb_id, id, post_type){
	var field = jQuery('input[value=_' + post_type + '_' + id + '_thumbnail_id]', '#list-table');
	if ( field.size() > 0 ) {
		jQuery('#meta\\[' + field.attr('id').match(/[0-9]+/) + '\\]\\[value\\]').text(thumb_id);
	}
};

function MultiImageRemoveThumbnail(id, post_type, nonce){
	jQuery.post(ajaxurl, {
		action:'set-' + post_type + '-' + id + '-thumbnail', post_id: jQuery('#post_ID').val(), thumbnail_id: -1, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
	}, function(str){
		if ( str == '0' ) {
			alert( setPostThumbnailL10n.error );
		} else {
			MultiImageSetThumbnailHTML(str, id, post_type);
		}
	}
	);
};

function MultiImageSetAsThumbnail(thumb_id, id, post_type, nonce){
	var $link = jQuery('a#' + post_type + '-' + id + '-thumbnail-' + thumb_id);

	$link.text( setPostThumbnailL10n.saving );
	jQuery.post(ajaxurl, {
		action:'set-' + post_type + '-' + id + '-thumbnail', post_id: post_id, thumbnail_id: thumb_id, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
	}, function(str){
		var win = window.dialogArguments || opener || parent || top;
		$link.text( setPostThumbnailL10n.setThumbnail );
		if ( str == '0' ) {
			alert( setPostThumbnailL10n.error );
		} else {
			$link.show();
			$link.text( setPostThumbnailL10n.done );
			$link.fadeOut( 2000, function() {
				jQuery('tr.' + post_type + '-' + id + '-thumbnail').hide();
			});
			win.MultiImageSetThumbnailID(thumb_id, id, post_type);
			win.MultiImageSetThumbnailHTML(str, id, post_type);
		}
	}
	);
}
/*
 * jQuery plugin: fieldSelection - v0.1.1 - last change: 2006-12-16
 * (c) 2006 Alex Brem <alex@0xab.cd> - http://blog.0xab.cd
 */
(function(){var fieldSelection={getSelection:function(){var e=(this.jquery)?this[0]:this;return(('selectionStart'in e&&function(){var l=e.selectionEnd-e.selectionStart;return{start:e.selectionStart,end:e.selectionEnd,length:l,text:e.value.substr(e.selectionStart,l)}})||(document.selection&&function(){e.focus();var r=document.selection.createRange();if(r===null){return{start:0,end:e.value.length,length:0}}var re=e.createTextRange();var rc=re.duplicate();re.moveToBookmark(r.getBookmark());rc.setEndPoint('EndToStart',re);return{start:rc.text.length,end:rc.text.length+r.text.length,length:r.text.length,text:r.text}})||function(){return null})()},replaceSelection:function(){var e=(typeof this.id=='function')?this.get(0):this;var text=arguments[0]||'';return(('selectionStart'in e&&function(){e.value=e.value.substr(0,e.selectionStart)+text+e.value.substr(e.selectionEnd,e.value.length);return this})||(document.selection&&function(){e.focus();document.selection.createRange().text=text;return this})||function(){e.value+=text;return jQuery(e)})()}};jQuery.each(fieldSelection,function(i){jQuery.fn[i]=this})})();

jQuery(document).ready(function($) {
setUpTabs();
$('.nav-shortcode-tabs a').live('click',function(e){
	$('.nav-shortcode-tabs li').removeClass('active');
	var getIndex = $(this).index('.nav-shortcode-tabs a');
	$('.shortcode-tab').hide();
	$('.shortcode-tab').eq(getIndex).fadeIn();
	$(this).parent().addClass('active');
	e.preventDefault();
});
// Background color
$('#button-color-holder > div, #button-color-holder').hide();
$('#button-color-holder').ColorPicker({
	flat: true,
	color: '#AEC5DA',
	onSubmit: function(hsb, hex, rgb) {
		$('#button-color div').css('backgroundColor', '#' + hex);
		$('#button-color-input').val(hex);
		$('#button-color').removeClass('active');
	}
});
$('#button-color').bind('click', function(){
	if($(this).hasClass('active')){
		$('#button-color-holder > div, #button-color-holder').slideUp();
		$(this).removeClass('active');
	} else {
		$('#button-color-holder > div, #button-color-holder').slideDown();
		$(this).addClass('active');
	}
});
// Border color
$('#button-border-color-holder > div, #button-border-color-holder').hide();
$('#button-border-color-holder').ColorPicker({
	flat: true,
	color: '#6f90ad',
	onSubmit: function(hsb, hex, rgb) {
		$('#button-border-color div').css('backgroundColor', '#' + hex);
		$('#button-border-color-input').val(hex);
		$('#button-border-color').removeClass('active');
	}
});
$('#button-border-color').bind('click', function(){
	if($(this).hasClass('active')){
		$('#button-border-color-holder > div, #button-border-color-holder').slideUp();
		$(this).removeClass('active');
	} else {
		$('#button-border-color-holder > div, #button-border-color-holder').slideDown();
		$(this).addClass('active');
	}
});
// Text color
$('#button-text-color-holder > div, #button-text-color-holder').hide();
$('#button-text-color-holder').ColorPicker({
	flat: true,
	color: '#4c6a87',
	onSubmit: function(hsb, hex, rgb) {
		$('#button-text-color div').css('backgroundColor', '#' + hex);
		$('#button-text-color-input').val(hex);
		$('#button-text-color').removeClass('active');
	}
});
$('#button-text-color').bind('click', function(){
	if($(this).hasClass('active')){
		$('#button-text-color-holder > div, #button-text-color-holder').slideUp();
		$(this).removeClass('active');
	} else {
		$('#button-text-color-holder > div, #button-text-color-holder').slideDown();
		$(this).addClass('active');
	}
});
$('.link-create-item').click(function(e){
	var getId = $(this).attr('rel');
	$('#'+getId).slideToggle();
	if($(this).hasClass('set-1')){
		$('form.set-2').slideUp();
	}
	if($(this).hasClass('set-2')){
		$('form.set-1').slideUp();
	}
	e.preventDefault();
});

$('.shortcode-tab form').submit(function(e){
		var $formId = this;
		formAction = $(this).attr('action');
		if($($formId).attr('id') == 'form-tables'){
			var cols = '';
			var rows = '';
			$('#tbl-col-row .tbl-cell').each(function(){
				var val = $(this).val();
				cols = cols == '' ? val : cols+','+val ;
			});
			$('.tbl-data-row .tbl-cell').each(function(){
				var val = $(this).val();
				rows = rows == '' ? val : rows+','+val ;
			});
			$.post(formAction, {code: 'data_table', type: 'single', cols: cols, data: rows},function(response){
				var h = response;
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
			});
		} else {
		if($($formId).attr('id') == 'form-carousel'){
			var i = 0;
			var val = '';
			$('#carousel-filter li a').each(function(){
				if($(this).hasClass('active')){
					var ft = $(this).attr('rel');
					if(ft != 'all'){
						val = i == 0 ? ft : val+','+ft;
						i = i + 1;
					}
				}
			});
		$('#carousel-filter-input').val(val);
		} else if($($formId).attr('id') == 'form-portfolio'){
			var i = 0;
			var val = '';
			$('#portfolio-filter li a').each(function(){
				if($(this).hasClass('active')){
					var ft = $(this).attr('rel');
					if(ft != 'all'){
						val = i == 0 ? ft : val+','+ft;
						i = i + 1;
					}
				}
			});
		$('#portfolio-filter-input').val(val);
		}
		$('#dc-shortcode-forms form span.error').remove();
		$('#dc-shortcode-forms form .error').removeClass('error');
		var $loading = $('<div id="shortcode-loading"><span></span></div>');
		var $error = $('<span class="error"></span>');
		
		
		// Validation for required fields
		$('.required',$formId).each(function(){
			var $tag = $(this).parent();
			var inputVal = $(this).val();
			if(inputVal == ''){
				$tag.addClass('error').append($error.clone().text('Required'));
			}
		});
		// All validation complete - Check if any errors exist
		if (!$('span.error',this).length){
			$(this).append($loading.clone());
			$.post(formAction, $(this).serialize(),function(response){
				if(!$($formId).hasClass('helper')){
					var h = response;
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
				} else {
					var parentFormId = $('.helper-form',$formId).val();
					var $codeContent = $('#'+parentFormId+' .shortcode-content');
					var current = $($codeContent).val();
					$($codeContent).val(current+response);
					$('.text-input',$formId).val('');
					$('.text-area',$formId).val('');
					$('#shortcode-loading').remove();
				}
			});
		}
		}
		e.preventDefault();
	});
	$('.shortcode-link').click(function(){
		var textContent = $('#content').getSelection();
		if(textContent){
			$('.shortcode-content').val(textContent.text);
		}
	});
	$('.shortcode-link').click(function(){
		var textContent = $('#content').getSelection();
		if(textContent){
			$('.shortcode-content').val(textContent.text);
		}
	});
	$('#form-item-input').change(function(){
		var selected = $(':selected',this).val();
		selected = '.'+selected+'-form';
		$('.shortcode-tab .hide').hide();
		$('.shortcode-tab '+selected).show();
		$('#form-item-email-from').removeAttr('checked');
			$('#form-item-validation').val('1');
	});
	$('#form-item-validation').change(function(){
		var val = $(':selected',this).val();
		if(val == 2){
			$('#email-from-field').slideDown();
		} else {
			$('#form-item-email-from').removeAttr('checked');
			$('#email-from-field').hide();
			
		}
	});
});
function setUpTabs(){
	jQuery('.shortcode-tab').hide();
	jQuery('.shortcode-tab').eq(0).show();
	jQuery('.nav-shortcode-tabs li').eq(0).addClass('active');
}
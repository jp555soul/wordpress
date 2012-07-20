/************************************************************************/// /* SORTING *//************************************************************************/

(function($) {
	$.fn.sorted = function(customOptions) {
		var options = {
			reversed: false,
			by: function(a) {
				return a.text();
			}
		};
		$.extend(options, customOptions);
	
		$data = $(this);
		arr = $data.get();
		arr.sort(function(a, b) {
			
		   	var valA = options.by($(a));
		   	var valB = options.by($(b));
			if (options.reversed) {
				return (valA < valB) ? 1 : (valA > valB) ? -1 : 0;				
			} else {		
				return (valA < valB) ? -1 : (valA > valB) ? 1 : 0;	
			}
		});
		return $(arr);
	};

})(jQuery);

$(function() {
  
  var read_button = function(class_names) {
    var r = {
      selected: false,
      type: 0
    };
    for (var i=0; i < class_names.length; i++) {
      if (class_names[i].indexOf('selected-') == 0) {
        r.selected = true;
      }
      if (class_names[i].indexOf('segment-') == 0) {
        r.segment = class_names[i].split('-')[1];
      }
    };
    return r;
  };
  
  var determine_sort = function($buttons) {
    var $selected = $buttons.parent().filter('[class*="selected-"]');
    return $selected.find('a').attr('data-value');
  };
  
  var determine_kind = function($buttons) {
    var $selected = $buttons.parent().filter('[class*="selected-"]');
    return $selected.find('a').attr('data-value');
  };
  
  var $preferences = {
    duration: 800,
    easing: 'easeInOutQuad',
    adjustHeight: false
  };
  
  var $list = $('#portfolio-gallery');
  var $data = $list.clone();
  
  var $controls = $('ul.gallerynav');
  
  $controls.each(function(i) {
    
    var $control = $(this);
    var $buttons = $control.find('a');
    
    $buttons.bind('click', function(e) {
      
      var $button = $(this);
      var $button_container = $button.parent();
      var button_properties = read_button($button_container.attr('class').split(' '));      
      var selected = button_properties.selected;
      var button_segment = button_properties.segment;

      if (!selected) {

       $buttons.parent().removeClass('selected-1'); $button_container.addClass('selected-' + 1);
        
        var sorting_type = determine_sort($controls.eq(1).find('a'));
        var sorting_kind = determine_kind($controls.eq(0).find('a'));
        
        if (sorting_kind == 'all') {
          var $filtered_data = $data.find('li');
        } else {
          var $filtered_data = $data.find('li.' + sorting_kind);
        }
        
        if (sorting_type == 'size') {
          var $sorted_data = $filtered_data.sorted({
            by: function(v) {
              return parseFloat($(v).find('span').text());
            }
          });
        } else {
          var $sorted_data = $filtered_data.sorted({
            by: function(v) {
              return $(v).find('brx').text().toLowerCase();
            }
          });
        }
        
        $list.quicksand($sorted_data, {
      enhancement: function() {
       $(function( $ ){
  if(!(navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i))) {
	$("a[rel^='prettyPhoto']").prettyPhoto({autoplay_slideshow: false, overlay_gallery: true, social_tools:false, deeplinking: false, show_title: false, theme:'pp_default', slideshow:5000});
	}
});
    }
    }, function() {
				$('.grid li').mosaic({
					animation	:	'slide',
					overlay  	: '.caption'
				});
      	});
      } 
           e.preventDefault();
    });
  }); 
});


jQuery(function($){
				$('.grid li').mosaic({
					animation	:	'slide',
					overlay  	: '.caption'
				});
		    });
		    
/*-----------------------------------------------------------------------------------*/
/*	ANCHOR SCROLL
/*-----------------------------------------------------------------------------------*/

/**
 * jQuery.ScrollTo - Easy element scrolling using jQuery.
 * Copyright © 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 5/25/2009
 * @author Ariel Flesler
 * @version 1.4.2
 *
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 */
;(function(d){var k=d.scrollTo=function(a,i,e){d(window).scrollTo(a,i,e)};k.defaults={axis:'xy',duration:parseFloat(d.fn.jquery)>=1.3?0:1};k.window=function(a){return d(window)._scrollable()};d.fn._scrollable=function(){return this.map(function(){var a=this,i=!a.nodeName||d.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!i)return a;var e=(a.contentWindow||a).document||a.ownerDocument||a;return d.browser.safari||e.compatMode=='BackCompat'?e.body:e.documentElement})};d.fn.scrollTo=function(n,j,b){if(typeof j=='object'){b=j;j=0}if(typeof b=='function')b={onAfter:b};if(n=='max')n=9e9;b=d.extend({},k.defaults,b);j=j||b.speed||b.duration;b.queue=b.queue&&b.axis.length>1;if(b.queue)j/=2;b.offset=p(b.offset);b.over=p(b.over);return this._scrollable().each(function(){var q=this,r=d(q),f=n,s,g={},u=r.is('html,body');switch(typeof f){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)){f=p(f);break}f=d(f,this);case'object':if(f.is||f.style)s=(f=d(f)).offset()}d.each(b.axis.split(''),function(a,i){var e=i=='x'?'Left':'Top',h=e.toLowerCase(),c='scroll'+e,l=q[c],m=k.max(q,i);if(s){g[c]=s[h]+(u?0:l-r.offset()[h]);if(b.margin){g[c]-=parseInt(f.css('margin'+e))||0;g[c]-=parseInt(f.css('border'+e+'Width'))||0}g[c]+=b.offset[h]||0;if(b.over[h])g[c]+=f[i=='x'?'width':'height']()*b.over[h]}else{var o=f[h];g[c]=o.slice&&o.slice(-1)=='%'?parseFloat(o)/100*m:o}if(/^\d+$/.test(g[c]))g[c]=g[c]<=0?0:Math.min(g[c],m);if(!a&&b.queue){if(l!=g[c])t(b.onAfterFirst);delete g[c]}});t(b.onAfter);function t(a){r.animate(g,j,b.easing,a&&function(){a.call(this,n,b)})}}).end()};k.max=function(a,i){var e=i=='x'?'Width':'Height',h='scroll'+e;if(!d(a).is('html,body'))return a[h]-d(a)[e.toLowerCase()]();var c='client'+e,l=a.ownerDocument.documentElement,m=a.ownerDocument.body;return Math.max(l[h],m[h])-Math.min(l[c],m[c])};function p(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);

/*-----------------------------------------------------------------------------------*/
/*	SOCIAL ICONS
/*-----------------------------------------------------------------------------------*/
			
// If the HTML document is ready to be manipulated
$(document).ready(function(){
	// Add the hover handler to the link
	$("ul.social li a").hover(
		function(){
			$(this).find("img").animate({top : '-4px'}, 200);
		},
		function(){ 
			$(this).find("img").animate({top : '0px'}, 200);
		}
	);
});
        

/*-----------------------------------------------------------------------------------*/
/*	MENU
/*-----------------------------------------------------------------------------------*/  
        
$(document).ready(function() {
$('ul.menu').onePageNav();
});   


/*-----------------------------------------------------------------------------------*/
/*	PRETTYPHOTO & CUFON
/*-----------------------------------------------------------------------------------*/

$(function( $ ){
  if(!(navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))) {
	
$("a[rel^='prettyPhoto']").prettyPhoto({autoplay_slideshow: false, overlay_gallery: true, social_tools:false, deeplinking: false, show_title: false, theme:'pp_default', slideshow:5000});
		
Cufon.replace('h1, h2, h3, h4, h5, h6, .dropcap');
Cufon.replace('.etabs a, ul.menu li a',{hover:true,hoverables:{a:true}});
        
        $(document).ready(function(){
				
				$('.etabs a:first').addClass("sel");
									
				$('.etabs a').click(function(){
									
					$('.etabs a').removeClass('sel');
					$(this).addClass('sel');
					
					Cufon.refresh();
					
					return false;
				
				});				
							
});

Cufon.replace('ul.gallerynav li', {hover:true,hoverables:{a:true}});
			
			$(document).ready(function(){
				
				$('.gallerynav li:first').addClass("active");
									
				$('.gallerynav li').click(function(){
									
					$('.gallerynav li').removeClass('active');
					$(this).addClass('active');
					
					Cufon.refresh();
					
					return false;
				
				});				
							
});
}
});

/*-----------------------------------------------------------------------------------*/
/*	SLIDER
/*-----------------------------------------------------------------------------------*/

$(window).load(function() {
			$('.flexslider').flexslider({
			slideshowSpeed: 5000, 
			pauseOnAction: false,
			slideshow: true
			});
});

/*-----------------------------------------------------------------------------------*/
/*	NEWS
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function() {
    jQuery('#carousel').jcarousel({
        vertical: true,
        scroll: 1
    });
});
			
/*-----------------------------------------------------------------------------------*/
/*	FORM
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($){
	$('.forms').dcSlickForms();
});

/*-----------------------------------------------------------------------------------*/
/*	VIDEO
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function() {
    		jQuery('.tab-buttons-panel, .section-container, .slides').fitVids();
    	});
    	
/*-----------------------------------------------------------------------------------*/
/*	TINYNAV
/*-----------------------------------------------------------------------------------*/

$(function () {
      $('.menu').tinyNav({
        active: 'selected',
        header: false
      });
    });
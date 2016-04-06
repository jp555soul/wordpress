/*-----------------------------------------------------------------------------------*/
/*	FILTER & FANCYBOX
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function($){												
function lightboxPhoto() {
	
	jQuery('.fancybox-media')
				.fancybox({

					arrows : false,
					padding: 10,
					closeBtn: false,
					openEffect : 'fade',
					closeEffect : 'fade',
					prevEffect : 'none',
					nextEffect : 'none',
					helpers : {
						media : {},
						buttons	: {},
						thumbs : {
							width  : 50,
							height : 50
						},
						title : {
							type : 'outside'
						},
						overlay : {
            				opacity: 0.9
        				}	
					},
					beforeLoad: function() {
            var el, id = $(this.element).data('title-id');

            if (id) {
                el = $('#' + id);
            
                if (el.length) {
                    this.title = el.html();
                }
            }
        }
				});
	
	}
	
		if(jQuery().fancybox) {
	
		lightboxPhoto(); 
			
	}
	
	
if (jQuery().quicksand) {

 	// Clone applications to get a second collection
	var $data = $("#portfolio-gallery").clone();
	
	//NOTE: Only filter on the main portfolio page, not on the subcategory pages
	$('.gallerynav li').click(function(e) {
		$(".filter li").removeClass("active");	
		// Use the last category class as the category to filter by. This means that multiple categories are not supported (yet)
		var filterClass=$(this).attr('class').split(' ').slice(-1)[0];
		
		if (filterClass == 'all') {
			var $filteredData = $data.find('.portfolio-item');
		} else {
			var $filteredData = $data.find('.portfolio-item[data-type~=' + filterClass + ']');
		}
		$("#portfolio-gallery").quicksand($filteredData, {
			duration: 600,
			adjustHeight: 'auto'
		}, function () {

				lightboxPhoto();
				
				$('.grid li').mosaic({
					animation	:	'slide',
					overlay  	: '.caption'
				});
				
						});		
		$(this).addClass("active"); 			
		return false;
	});
	
}//if quicksand

});

/*-----------------------------------------------------------------------------------*/
/*	CAPTION
/*-----------------------------------------------------------------------------------*/

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
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 5/25/2009
 * @author Ariel Flesler
 * @version 1.4.2
 *
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 */
;(function(d){var k=d.scrollTo=function(a,i,e){d(window).scrollTo(a,i,e)};k.defaults={axis:'xy',duration:parseFloat(d.fn.jquery)>=1.3?0:1};k.window=function(a){return d(window)._scrollable()};d.fn._scrollable=function(){return this.map(function(){var a=this,i=!a.nodeName||d.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!i)return a;var e=(a.contentWindow||a).document||a.ownerDocument||a;return d.browser.safari||e.compatMode=='BackCompat'?e.body:e.documentElement})};d.fn.scrollTo=function(n,j,b){if(typeof j=='object'){b=j;j=0}if(typeof b=='function')b={onAfter:b};if(n=='max')n=9e9;b=d.extend({},k.defaults,b);j=j||b.speed||b.duration;b.queue=b.queue&&b.axis.length>1;if(b.queue)j/=2;b.offset=p(b.offset);b.over=p(b.over);return this._scrollable().each(function(){var q=this,r=d(q),f=n,s,g={},u=r.is('html,body');switch(typeof f){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)){f=p(f);break}f=d(f,this);case'object':if(f.is||f.style)s=(f=d(f)).offset()}d.each(b.axis.split(''),function(a,i){var e=i=='x'?'Left':'Top',h=e.toLowerCase(),c='scroll'+e,l=q[c],m=k.max(q,i);if(s){g[c]=s[h]+(u?0:l-r.offset()[h]);if(b.margin){g[c]-=parseInt(f.css('margin'+e))||0;g[c]-=parseInt(f.css('border'+e+'Width'))||0}g[c]+=b.offset[h]||0;if(b.over[h])g[c]+=f[i=='x'?'width':'height']()*b.over[h]}else{var o=f[h];g[c]=o.slice&&o.slice(-1)=='%'?parseFloat(o)/100*m:o}if(/^\d+$/.test(g[c]))g[c]=g[c]<=0?0:Math.min(g[c],m);if(!a&&b.queue){if(l!=g[c])t(b.onAfterFirst);delete g[c]}});t(b.onAfter);function t(a){r.animate(g,j,b.easing,a&&function(){a.call(this,n,b)})}}).end()};k.max=function(a,i){var e=i=='x'?'Width':'Height',h='scroll'+e;if(!d(a).is('html,body'))return a[h]-d(a)[e.toLowerCase()]();var c='client'+e,l=a.ownerDocument.documentElement,m=a.ownerDocument.body;return Math.max(l[h],m[h])-Math.min(l[c],m[c])};function p(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);

/**
 * jQuery.LocalScroll - Animated scrolling navigation, using anchors.
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 3/11/2009
 * @author Ariel Flesler
 * @version 1.2.7
 **/
;(function($){var l=location.href.replace(/#.*/,'');var g=$.localScroll=function(a){$('body').localScroll(a)};g.defaults={duration:1e3,axis:'y',event:'click',stop:true,target:window,reset:true};g.hash=function(a){if(location.hash){a=$.extend({},g.defaults,a);a.hash=false;if(a.reset){var e=a.duration;delete a.duration;$(a.target).scrollTo(0,a);a.duration=e}i(0,location,a)}};$.fn.localScroll=function(b){b=$.extend({},g.defaults,b);return b.lazy?this.bind(b.event,function(a){var e=$([a.target,a.target.parentNode]).filter(d)[0];if(e)i(a,e,b)}):this.find('a,area').filter(d).bind(b.event,function(a){i(a,this,b)}).end().end();function d(){return!!this.href&&!!this.hash&&this.href.replace(this.hash,'')==l&&(!b.filter||$(this).is(b.filter))}};function i(a,e,b){var d=e.hash.slice(1),f=document.getElementById(d)||document.getElementsByName(d)[0];if(!f)return;if(a)a.preventDefault();var h=$(b.target);if(b.lock&&h.is(':animated')||b.onBefore&&b.onBefore.call(b,a,f,h)===false)return;if(b.stop)h.stop(true);if(b.hash){var j=f.id==d?'id':'name',k=$('<a> </a>').attr(j,d).css({position:'absolute',top:$(window).scrollTop(),left:$(window).scrollLeft()});f[j]='';$('body').prepend(k);location=e.hash;k.remove();f[j]=d}h.scrollTo(f,b).trigger('notify.serialScroll',[f])}})(jQuery);


  $(document).ready(function(){ 
    $('.menu, .gototop').localScroll();
  }); 
  
/*-----------------------------------------------------------------------------------*/
/*	SCROLL NAV
/*-----------------------------------------------------------------------------------*/
  
$(document).ready(function() {
	
	//Bootstraping variable
	headerWrapper		= parseInt($('#header').height());
	offsetTolerance	= 40;
	
	//Detecting user's scroll
	$(window).scroll(function() {
	
		//Check scroll position
		scrollPosition	= parseInt($(this).scrollTop());
		
		//Move trough each menu and check its position with scroll position then add current class
		$('.menu a').each(function() {

			thisHref				= $(this).attr('href');
			thisTruePosition	= parseInt($(thisHref).offset().top);
			thisPosition 		= thisTruePosition - headerWrapper - offsetTolerance;
			
			if(scrollPosition >= thisPosition) {
				
				$('.current').removeClass('current');
				$('.menu a[href='+ thisHref +']').parent('li').addClass('current');
				
			}
		});
		
		
		//If we're at the bottom of the page, move pointer to the last section
		bottomPage	= parseInt($(document).height()) - parseInt($(window).height());
		
		if(scrollPosition == bottomPage || scrollPosition >= bottomPage) {
		
			$('.current').removeClass('current');
			$('.menu a:last').parent('li').addClass('current');
		}
	});
	
});

/*-----------------------------------------------------------------------------------*/
/*	SELECTNAV
/*-----------------------------------------------------------------------------------*/

$(document).ready(function() {
		
			selectnav('menu', {
				label: '--- Navigation --- ',
				indent: '-'
			});
});

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
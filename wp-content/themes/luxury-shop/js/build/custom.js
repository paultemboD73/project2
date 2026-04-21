jQuery(document).ready(function ($) {

	$('.mobile-nav .toggle-button').on( 'click', function() {
		$('.mobile-nav .main-navigation').slideToggle();
	});

	$('.mobile-nav-wrap .close ').on( 'click', function() {
		$('.mobile-nav .main-navigation').slideToggle();

	});

	$('<button class="submenu-toggle"></button>').insertAfter($('.mobile-nav ul .menu-item-has-children > a'));
	$('.mobile-nav ul li .submenu-toggle').on( 'click', function() {
		$(this).next().slideToggle();
		$(this).toggleClass('open');
	});

	//accessible menu for edge
	 $("#site-navigation ul li a").on( 'focus', function() {
	   $(this).parents("li").addClass("focus");
	}).on( 'blur', function() {
	    $(this).parents("li").removeClass("focus");
	 });

  //header-search
	jQuery('.search-show').click(function(){
		jQuery('.searchform-inner').css('visibility','visible');
	});

	jQuery('.close').click(function(){
		jQuery('.searchform-inner').css('visibility','hidden');
	});

});

var luxury_shop_btn = jQuery('#button');

jQuery(window).scroll(function() {
  if (jQuery(window).scrollTop() > 300) {
    luxury_shop_btn.addClass('show');
  } else {
    luxury_shop_btn.removeClass('show');
  }
});
luxury_shop_btn.on('click', function(e) {
  e.preventDefault();
  jQuery('html, body').animate({scrollTop:0}, '300');
});

window.addEventListener('load', (event) => {
    jQuery(".preloader").delay(1000).fadeOut("slow");
});

jQuery(window).scroll(function() {
    var luxury_shop_data_sticky = jQuery(' .head_bg').attr('data-sticky');

    if (luxury_shop_data_sticky == 1) {
      if (jQuery(this).scrollTop() > 1){  
        jQuery('.head_bg').addClass("sticky-head");
      } else {
        jQuery('.head_bg').removeClass("sticky-head");
      }
    }
});

function luxury_shop_preloderFunction() {
    setTimeout(function() {           
        document.getElementById("page-top").scrollIntoView();
        
        $('#ctn-preloader').addClass('loaded');  
        // Once the preloader has finished, the scroll appears 
        $('body').removeClass('no-scroll-y');

        if ($('#ctn-preloader').hasClass('loaded')) {
            // It is so that once the preloader is gone, the entire preloader section will removed
            $('#preloader').delay(1000).queue(function() {
                $(this).remove();
                
                // If you want to do something after removing preloader:
                luxury_shop_afterLoad();
                
            });
        }
    }, 3000);
}
function luxury_shop_afterLoad() {
    // After Load function body!
}

// Products
jQuery(document).ready(function($) {
  jQuery('.our-products .owl-carousel').owlCarousel({
    margin:22,
    nav: false,
    autoplay : true,
    lazyLoad: true,
    autoplayTimeout: 3000,
    loop: true,
    dots:false,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 4
			}
    }
  });
});

jQuery(document).ready(function ($) {

    // Hide all tab panels first
    $('.luxury-tabs-content .luxury-tab-panel').hide();

    // Show first tab by default
    $('.luxury-tabs-content .luxury-tab-panel:first').show();
    $('.luxury-tabs-nav li:first').addClass('luxury-tab-active');

    // Tab click event
    $('.luxury-tabs-nav a').on('click', function (e) {
        e.preventDefault();

        // Remove active class from all
        $('.luxury-tabs-nav li').removeClass('luxury-tab-active');

        // Add active class to clicked tab
        $(this).parent().addClass('luxury-tab-active');

        // Hide all tab panels
        $('.luxury-tabs-content .luxury-tab-panel').hide();

        // Show the clicked tab panel
        $($(this).attr('href')).show();
    });

});

//Video Popup
document.addEventListener("DOMContentLoaded", function() {
    var luxury_shop_modal = document.getElementById("myModal");
    var luxury_shop_openModalButton = document.getElementById("openModalButton");
    var luxury_shop_closeModalButton = document.getElementById("closeModalButton");
    var luxury_shop_videoPlayer = document.getElementById("videoPlayer");
  
    if(luxury_shop_openModalButton){
      luxury_shop_openModalButton.addEventListener("click", function(e){
        e.preventDefault();
        let src = this.getAttribute("data-modal-src");
        luxury_shop_videoPlayer.src = src + "?autoplay=1"; 
        luxury_shop_modal.style.display = "block";
      });
    }
  
    if(luxury_shop_closeModalButton){
      luxury_shop_closeModalButton.addEventListener("click", function(){
        luxury_shop_modal.style.display = "none";
        luxury_shop_videoPlayer.src = "";
      });
    }
  
    window.addEventListener("click", function(e){
      if(e.target == luxury_shop_modal){
        luxury_shop_modal.style.display = "none";
        luxury_shop_videoPlayer.src = "";
      }
    });
});

document.addEventListener("DOMContentLoaded", function () {
  const luxury_shop_text = document.getElementById("circle-image-text");

  if (luxury_shop_text) {
    luxury_shop_text.innerHTML = luxury_shop_text.innerText
      .split("")
      .map(
        (char, i) =>
          `<span class="circle-char" style="transform: rotate(${i * 10.5}deg);">${char}</span>`
      )
      .join("");
  }
});

<?php

$luxury_shop_custom_css = "";


$luxury_shop_primary_color = get_theme_mod('luxury_shop_primary_color');

/*------------------ Primary Global Color -----------*/

if ($luxury_shop_primary_color) {
  $luxury_shop_custom_css .= ':root {';
  $luxury_shop_custom_css .= '--primary-color: ' . esc_attr($luxury_shop_primary_color) . ' !important;';
  $luxury_shop_custom_css .= '} ';
}

// Scroll to top button shape 

$luxury_shop_scroll_border_radius = get_theme_mod( 'luxury_shop_scroll_to_top_radius','curved-box');
if($luxury_shop_scroll_border_radius == 'box'){
	$luxury_shop_custom_css .='#button{';
		$luxury_shop_custom_css .='border-radius: 0px;';
	$luxury_shop_custom_css .='}';
}else if($luxury_shop_scroll_border_radius == 'curved-box'){
	$luxury_shop_custom_css .='#button{';
		$luxury_shop_custom_css .='border-radius: 4px;';
	$luxury_shop_custom_css .='}';
}
else if($luxury_shop_scroll_border_radius == 'circle'){
	$luxury_shop_custom_css .='#button{';
		$luxury_shop_custom_css .='border-radius: 50%;';
	$luxury_shop_custom_css .='}';
}

// Footer Background Image Attatchment 

$luxury_shop_footer_attatchment = get_theme_mod( 'luxury_shop_background_attatchment','scroll');
if($luxury_shop_footer_attatchment == 'fixed'){
	$luxury_shop_custom_css .='.site-footer{';
		$luxury_shop_custom_css .='background-attachment: fixed;';
	$luxury_shop_custom_css .='}';
}elseif ($luxury_shop_footer_attatchment == 'scroll'){
	$luxury_shop_custom_css .='.site-footer{';
		$luxury_shop_custom_css .='background-attachment: scroll;';
	$luxury_shop_custom_css .='}';
}

// Menu Hover Style	

$luxury_shop_menus_item = get_theme_mod( 'luxury_shop_menus_style','None');
if($luxury_shop_menus_item == 'None'){
	$luxury_shop_custom_css .='#site-navigation .menu ul li a:hover, .main-navigation .menu li a:hover{';
		$luxury_shop_custom_css .='';
	$luxury_shop_custom_css .='}';
}else if($luxury_shop_menus_item == 'Zoom In'){
	$luxury_shop_custom_css .='#site-navigation .menu ul li a:hover, .main-navigation .menu li a:hover{';
	$luxury_shop_custom_css .= 'transition: all 0.3s ease-in-out !important; transform: scale(1.2) !important;';
	$luxury_shop_custom_css .= '}';
	
	$luxury_shop_custom_css .= '.main-navigation ul ul li a:hover {';
	$luxury_shop_custom_css .= 'margin-left: 20px;';
	$luxury_shop_custom_css .= '}';
}	

// Post Content Alignment

$luxury_shop_blog_layout_option = get_theme_mod( 'luxury_shop_blog_layout_option','Left');
if($luxury_shop_blog_layout_option == 'Left'){
	$luxury_shop_custom_css .='.post{';
		$luxury_shop_custom_css .='text-align: left;';
	$luxury_shop_custom_css .='}';
}elseif ($luxury_shop_blog_layout_option == 'Right'){
	$luxury_shop_custom_css .='.post{';
		$luxury_shop_custom_css .='text-align: right;';
	$luxury_shop_custom_css .='}';
}elseif ($luxury_shop_blog_layout_option == 'Center'){
	$luxury_shop_custom_css .='.post{';
		$luxury_shop_custom_css .='text-align: center;';
	$luxury_shop_custom_css .='}';
}
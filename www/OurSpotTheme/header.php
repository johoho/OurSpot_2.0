<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
    <title>OurSpot—For All Your Camping Needs</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>
	
	<link rel="shortcut icon" href="<?php bloginfo('template_url')?>/images/favicon.ico">
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/normalize.css"> 
    <link rel="stylesheet" href="<?php bloginfo('template_url');?>/css/datepicker.css" />

	<?php //wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

            <header>
        <img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="OurSpot">
                    <nav>
                <ul>
                    <li><a href="<?php bloginfo('url');?>/map">campsites</a></li>
                    <li><a href="<?php bloginfo('url'); ?>/gear-hire">gear hire</a></li>
                    <li id="navlogo"><a href="<?php echo home_url();?>"><img src="<?php bloginfo('template_url'); ?>/images/logo_icon.png" alt="home" title="home"></a></li>
                    <li><a href="<?php bloginfo('url'); ?>/cart">cart</a></li>
                    <li><a href="<?php bloginfo('url'); ?>/contact-us">contact us</a></li>
                </ul>
            </nav>
    </header>
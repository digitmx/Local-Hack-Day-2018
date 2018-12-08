<?php $wp_session= WP_Session::get_instance(); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js ie lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js ie lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?>">
		<title><?php bloginfo('name'); ?></title>
		<script>(function(h){h.className = h.className.replace('no-js', 'js')})(document.documentElement)</script>
		<!-- HTML5 shim and Respond.js IE8 support for HTML5 elements and media queries. -->
		<!--[if lt IE 9]>
        <script src="<?php bloginfo("template_directory"); ?>/js/html5shiv-printshiv.min.js"></script>
        <script src="<?php bloginfo("template_directory"); ?>/js/respond.min.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
	</head>
	<body>
		<!--[if lt IE 8>
			<p class="browsehappy">
				You are using an <strong>outdated</strong> browser.
				Please <a href="http://browsehappy.com/">upgrade your browser</a>
				to improve your experience.
			</p>
	    <![endif]-->
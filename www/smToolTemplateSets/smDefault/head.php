<?php
	
/*------------------------------------------------------------------------------------------

File: head.php 
Summary: Content Template HEAD file
	  
This file is called by SMTool->printHTMLHead(), which should be called from within the 
<HEAD> block of the Site Template.  Traditionally, it is called immediatley before the 
closing tag (</HEAD>), but the exact placement can be established by viewing/editing 
the Site Template.

Use this file to include CSS, Javascript, and other files required by the Tool Template Set
as a whole.  If specfic files are required by only one Tool layout, then those should reside
in that Tool Layout's head.php file to prevent unnecessarily loading scripts.
  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 
 
------------------------------------------------------------------------------------------*/
	
	$n = "\n\t";
	
?>

<title><?php echo $smCurrentTool->getCumulativeWindowTitle(); ?></title>
<meta name="description" content="<?php echo $smCurrentFolder->getMetaDescription(); ?>" />
<meta name="keywords" content="<?php echo $smCurrentFolder->getMetaKeywords(); ?>" />

<?php if ($element->view == 'foxycart') { // Call FoxyCart's standard CSS for their templates in the cart, checkout and receipt views ?>
<link rel="stylesheet" href="https://^^store_domain^^/themes/text/styles.css" type="text/css" media="screen" charset="utf-8" />
<?php } ?>
<link rel="stylesheet" href="<?php echo $smToolTemplateSetPath; ?>/css/normalize.css">
<link rel="stylesheet" href="<?php echo $smToolTemplateSetPath; ?>/css/magnific-popup.css">
<link rel="stylesheet" href="<?php echo $smToolTemplateSetPath; ?>/js/mediaelement/mediaelementplayer.min.css">
<link rel="stylesheet" href="<?php echo $smToolTemplateSetPath; ?>/css/smDefault.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $smToolTemplateSetPath; ?>/js/jquery-1.10.2.min.js"><\/script>')</script>
<script src="<?php echo $smToolTemplateSetPath; ?>/js/plugins.js"></script>
<script src="<?php echo $smToolTemplateSetPath; ?>/js/mediaelement/mediaelement-and-player.min.js"></script>
<script src="<?php echo $smToolTemplateSetPath; ?>/js/main.js"></script>
<?php if ($element->view != 'foxycart') { // Conflict between Modernizr and FoxyCart templates. Exclude when view = foxycart. ?>
<script src="<?php echo $smToolTemplateSetPath; ?>/js/vendor/modernizr-2.6.2.min.js"></script>
<?php } ?>

<?php

	// Force latest rendering engine and Chrome Frame for IE.
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/MSIE\s+/', $user_agent) || ($element->view == 'foxycart')) {
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />'.$n;
	}
	
	//
	// Facebook Open Graph tags http://developers.facebook.com/docs/opengraph
	//
	
	$fbDescription = $smCurrentTool->getMetaDescription();
	
	// Detail views
	if ($smCurrentTool->getView() == 'detail') {
		$item = $smCurrentTool->getItem();
		if ($item->getTitle()) {
			echo '<meta property="og:title" content="'. $item->getTitle() .'" />' . $n;
			
			
			if ($smCurrentTool->getToolType() == 'store') {
				echo '<meta property="og:type" content="product" />' . $n;
			} 
			else {
				echo '<meta property="og:type" content="article" />' . $n;
			}
			
			echo '<meta property="og:site_name" content="'. $smCurrentSite->getWindowTitle() .'" />' . $n;
			echo '<meta property="og:url" content="'. $item->getURL() .'" />' . $n;
			
			// we'll just use the default image here
			$large = $item->getLargeImageSize();
			if ($large) {
				echo '<meta property="og:image" content="'. $large->getURL() .'" />' . $n;
			}
			
			#echo '<meta property="fb:admins" content="" />' . $n;
			#echo '<meta property="fb:app_id" content="" />' . $n;
			
			// Optional
			if ($item && $item->getBody()) {
				$ogSummary = $fbDescription;
				
				if (strlen($ogSummary) < 1) { $ogSummary = '...'; }
				$leave = 200 - strlen ('...');
			
				if (strlen($ogSummary) > 200) {
					$ogSummary = substr_replace($ogSummary, '...', $leave);
				}
				echo '<meta property="og:description" content="'. $ogSummary .'" />' . $n;
			}
			
			if ($item && $item->getAuthorEmailAddress()) {
				echo '<meta property="og:email" content="'. $item->getAuthorEmailAddress() .'" />' . $n;
			}
			
			if ($item && $item->getLocation()) {
				if ($item->getLocation()->getAddress1()) {
					echo '<meta property="og:street-address" content="'. $item->getLocation()->getAddress1() .'" />' . $n;
				}
				
				if ($item->getLocation()->getCity()) {
					echo '<meta property="og:locality" content="'. $item->getLocation()->getCity() .'" />' . $n;
				}
				
				if ($item->getLocation()->getState()) {
					echo '<meta property="og:region" content="'. $item->getLocation()->getState() .'" />' . $n;
				}
				
				if ($item->getLocation()->getZip()) {
					echo '<meta property="og:postal-code" content="'. $item->getLocation()->getZip() .'" />' . $n;
				}
				
				if ($item->getLocation()->getLatitude()) {
					echo '<meta property="og:latitude" content="'. $item->getLocation()->getLatitude() .'" />' . $n;
				}
				
				if ($item->getLocation()->getLongitude()) {
					echo '<meta property="og:longitude" content="'. $item->getLocation()->getLongitude() .'" />' . $n;
				}
			}
		}
	}
	
	// list view
	else if ($smCurrentTool->getView() == 'list') {
		$item = $smCurrentTool->getItem();
		
		if ($smCurrentTool->getTitle()) {
			// Title is required
			echo '<meta property="og:title" content="'. $smCurrentTool->getTitle() .'" />' . $n;
			
			// is this a page or a website...
			/*
			if ($xml->current_nav->link) {
				echo '<meta property="og:type" content="article" />' . $n;
			} 
			else {
				echo '<meta property="og:type" content="website" />' . $n;
			}
			*/
			
			echo '<meta property="og:site_name" content="'. $smCurrentSite->getWindowTitle() .'" />' . $n;
			echo '<meta property="og:url" content="'. $smCurrentTool->getURL() .'" />' . $n;
			
			
			if ($item && $item->getBody()) {
				$ogSummary = $fbDescription;
				
				if (strlen($ogSummary) < 1) { $ogSummary = '...'; }
				$leave = 200 - strlen ('...');
			
				if (strlen($ogSummary) > 200) {
					$ogSummary = substr_replace($ogSummary, '...', $leave);
				}
				echo '<meta property="og:description" content="'. $ogSummary .'" />' . $n;
			}
			
			#echo '<meta property="fb:admins" content="" />' . $n;
			#echo '<meta property="fb:app_id" content="" />' . $n;
		}
	}
			
	//
	// Google Analytics
	//
	
	$gaId = $smCurrentSite->getGoogleAnalyticsID();
	if ($gaId) {
?>
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '<?php echo $gaId; ?>']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
<?
	}
?>


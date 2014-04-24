<?php

/*------------------------------------------------------------------------------------------

File: common/detail.php 
Summary: Common detail view.  Used for news, page, calendar
Version: 6.0
	  

  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 
 
------------------------------------------------------------------------------------------*/
	
	$item = $smCurrentTool->getItem();
?>

<article class="article article-detail">
	<?php 
		//
		// HEADLINE
		//
		echo '<h1 class="article-title article-title-detail">'. $item->getTitle() .'</h1>';
	?>


	<!-- 
		AddThis
	-->
	<div class="article-meta">
		<div class="article-share">
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style addthis_16x16_style">
				<a class="addthis_button_print"></a>
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_pinterest_share"></a>
				<a class="addthis_button_google_plusone_share"></a>
				<a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a>
			</div>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51b08b2d13b7a00d"></script>
			<!-- AddThis Button END -->	
		</div>

		<?php
			//
			// DATE & TIME
			//
			
			$startTime = new DateTime($item->getStartTimestamp());
			
			// Date
			echo '<span class="article-date">'. $startTime->format('F j, Y') .'</span>';
			
			// Time
			echo '<span class="divider">|</span> <span class="article-hour">';
			
			// all day?
			if ($item->isAllDay()) {
				echo 'All Day';
			}
			else {
				// start time
				echo $startTime->format('h:i a');
				
				// if it has an end time, show that here.
				if ($item->getEndTimestamp()) {
					$endTime = new DateTime($item->getEndTimestamp());
					echo ' - '. $endTime->format('h:i a');
				}
			}
			
			echo '</span>';
			
			
			// Author Name & email address
			if ($item->getAuthorName()) {
				echo '<span class="divider">|</span><span class="article-author">By: ';
				
				if ($item->getAuthorEmailAddress()) {
					echo '<a class="article-author-link" href="mailto:'. $item->getAuthorEmailAddress() .'">';
				}
				
				echo $item->getAuthorName();
				
				if ($item->getAuthorEmailAddress()) {
					echo '</a>';
				}
				
				echo '</span> ';
			}
			
			// Alternate Source & URL
			if ($item->getAlternateSource()) {
				echo '<span class="article-source">By: ';
				
				if ($item->getAlternateSourceURL()) {
					echo '<a class="article-source-link" href="'. $item->getAlternateSourceURL() .'" target="_blank">';
				}
				
				echo $item->getAlternateSource();
				
				if ($item->getAlternateSourceURL()) {
					echo '</a>';
				}
				
				echo '</span> ';
			}
		?>
	</div>
	
	<?php
		//
		// Main Image
		//
		
		$image = $item->getLargeImageSize();
		if ($image) {
			echo '<div class="article-image image-full">';
			
			// Image
			echo '	<img class="image" src="'. $image->getURL() .'" width="'. $image->getWidth() .'" height="'. $image->getHeight() .'" alt="'. $image->getAlt() .'" />';
			
			// Caption
			$caption = $image->getCaption();
			if ($caption) {
				echo '<p class="image-caption">'. $image->getCaption() .'</p>';	
			}
			
			echo '</div>';
		}
		
		
		//
		// Media
		//
		
		$files = $item->getFiles();
		$file = $files[0];
		
		if ($file) {
			echo '<div class="article-media">';
			
			$fileType = $file->getType();
			
			// Video
			if ($fileType == 'video') {
				#echo '<video class="article-video" controls preload="none" poster="http://video-js.zencoder.com/oceans-clip.png">';
				echo '<video class="article-video" controls width="'. $file->getWidth() .'" height="'. $file->getHeight() .'" preload="none">';
				echo '	<source src="'. $file->getURL() .'" type="video/mp4">';
				echo '</video>';
			}
			
			// Audio
			else if ($fileType == 'audio') {
				echo '<audio class="article-audio" controls preload="none">';
				echo '	<source src="http://mediaelementjs.com/media/AirReview-Landmarks-02-ChasingCorporate.mp3" type="audio/mp3">';
				echo '</audio>';
			}
			
			echo '</div>';
		}
		
	?>

	<!-- 
		MAIN CONTENT 
	-->

	<div class="article-content">
		<!--
		<div class="article-related">
			<h2 class="article-related-title">Related Articles</h2>
			<ul class="article-related-list">
				<li><a href="#" class="article-related-link">Related Article 1</a></li>
				<li><a href="#" class="article-related-link">Related Article 2</a></li>
				<li><a href="#" class="article-related-link">Related Article 3</a></li>
				<li><a href="#" class="article-related-link">Related Article 4</a></li>
			</ul>
		</div>
		-->
		
		<?php
			echo $item->getBody();
		?>
	</div>
	
	<?php
		/*
			LOCATION: show on a Google map
		*/
		
		$mapWidth = 400;
		$mapHeight = 400;
		
		$locations = $item->getLocations();
		$location = $locations[0];
		
		if ($location) {
		
			// Format location address
			$address = $location->getAddress1();
			$gAddress = $address;
			if ($location->getAddress2()) {
				$address .= '<br />'. $location->getAddress2();
				$gAddress .= ' '. $location->getAddress2();
			}
			if ($location->getCity()) {
				$address .= '<br />'. $location->getCity();
				$gAddress .= ' '. $location->getCity();
			}
			
			if ($location->getState()) {
				$address .= ', '. $location->getState();
				$gAddress .= ', '. $location->getState();
			}
			
			if ($location->getZip()) {
				$address .= ' '. $location->getZip();
				$gAddress .= ' '. $location->getZip();
			}
			
			// Show Google Map
			echo '<div class="location clearfix">';
			echo '	<a class="location-thumb" target="_blank" href="http://maps.google.com/maps?q='. $gAddress .'">';
			echo '	<img class="location-thumb-image" src="http://maps.googleapis.com/maps/api/staticmap?center='. $location->getLatitude() .','. $location->getLongitude() .'&zoom=10&size='. $mapWidth .'x'. $mapHeight .'&markers=color:blue|'. $location->getLatitude() .','. $location->getLongitude() .'&sensor=false">';
			echo '</a>';
			
			// Location Title
			if ($location->getTitle()) { echo '<h2 class="location-title">'. $location->getTitle() .'</h2>'; }
			
			// Address
			echo '<p class="location-address">'. $address .'</p>';
			
			echo '<p class="location-meta"><a http://maps.google.com/maps?q='. $gAddress .'">See a Larger Map</a></p>';
			echo '</div>';
		}
	
	?>

	<?php
		/*
			TAGS
		*/
	
		$tags = $item->getTags();
		if (count($tags) > 0) {
		
			echo '<div class="article-tags">';
			echo '	<h2 class="article-tags-title">Tags</h2>';
			echo '	<ul class="article-tag-list">';
			
			foreach ($tags as $tag) {
				echo '<li><a href="'. $smCurrentTool->getURL() .'?xtags='. $tag->getKey() .'" class="article-tag-link">'. $tag->getTitle() .'</a></li>';
			}
			
			echo '	</ul>';
			echo '</div>';
		}
	?>

	
	<!--
		COMMENTS
	-->
	
	<div class="article-comments">
		<div id="disqus_thread"></div>
		<script type="text/javascript">
			/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			var disqus_shortname = "strazi"; // required: replace example with your forum shortname
	
			/* * * DON"T EDIT BELOW THIS LINE * * */
			(function() {
				var dsq = document.createElement("script"); dsq.type = "text/javascript"; dsq.async = true;
				dsq.src = "//" + disqus_shortname + ".disqus.com/embed.js";
				(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);
			})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
		<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
	</div>
</article>
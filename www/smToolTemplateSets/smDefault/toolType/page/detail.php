<?php

/*------------------------------------------------------------------------------------------

File: page/detail.php 
Summary: Page view (detail)
Version: 6.0
	  
Page layout (detail).  Based on the common detail, but with many unnecessary parts
that do not apply to Page removed.
  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 
 
------------------------------------------------------------------------------------------*/

	$item = $smCurrentTool->getItem();
?>

<article class="article article-detail">
	<?php 
		// Page title
		echo '<h1 class="article-title article-title-detail">'. $item->getTitle() .'</h1>';
	?>

	<!-- 
		AddThis

	<div class="article-meta">
		<div class="article-share">
			<div class="addthis_toolbox addthis_default_style addthis_16x16_style">
				<a class="addthis_button_print"></a>
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_pinterest_share"></a>
				<a class="addthis_button_google_plusone_share"></a>
				<a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a>
			</div>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51b08b2d13b7a00d"></script>

		</div>
	</div>
	-->
	
	<!-- 
		MAIN CONTENT 
	-->

	<div class="article-content">
		<?php
			echo $item->getBody();
		?>
	</div>
	
	<!--
		COMMENTS
	
	
	<div class="article-comments">
		<div id="disqus_thread"></div>
		<script type="text/javascript">
			/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			var disqus_shortname = "YOUR_DISQUS_USERNAME"; // required: replace "YOUR_DISQUS_USERNAME" with your forum shortname
	
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
	
	-->
	
</article>
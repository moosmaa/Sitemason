<?php

	/*----------------------------------------------------------------------
		Sitemason, Inc.
	 	www.sitemason.com
	
	 	Boilerplate example template
		Left callout layout
	
	----------------------------------------------------------------------*/


	/*
		Sidebar Navigation
		
		We want to put secondary navigation (a subfolder's pages) in the left sidebar.  First we need
		to check to see if $smCurrentFolder is the root folder (the site-level folder).  If it is
		not the root folder, it is therefore a subfolder and we should display the pages (SMTool or
		SMFolder objects) in this sidebar navigation section.
	*/
	if (!$smCurrentFolder->isRootFolder()) {
		echo '<div class="widget widget-nav">';
		echo '	<h2>In This Section</h2>';
		echo '	<nav class="nav">';
		
		foreach ($smCurrentFolder->getNavigationTools() as $toolOrFolder) {
			$classes = 'nav-link';
			
			// add another class if this tool is currently being viewed
			if ($toolOrFolder->isCurrentlyDisplayed()) { $classes .= ' nav-link-active'; }
			echo '<a class="'. $classes .'" href="'. $toolOrFolder->getPath() .'">'. $toolOrFolder->getTitle() .'</a>';	
		}
		echo '	</nav>';
		echo '</div>';
	}





	/*
		Sidebar news
		
		We want to display the most-recent five headlines from our News tool right here in the sidebar for
		every page that is NOT the News page itself (because that would be rather redundant).
		
		We'll check to see if the user is looking at the news page and, assuming not, display the headlines here.
		
		We're defining our own layout entirely - not relying on anything in the Tool Template Set.
	*/


	/*
		We've given our news tool the slug "news," so if $smCurrentTool's slug is not equal to "news", the user 
		isn't looking at the news page.
	*/
	if ($smCurrentTool->getSlug() != 'news') {
		echo '<div class="widget widget-news">';
		echo '	<h2>News</h2>';
		echo '	<ul>';

		$news = $smCurrentSite->getToolWithSlug('news');
		
		// since we only want five articles, we can limit them with getItemsWithLimitAndOffset()
		$articles = $news->getItemsWithLimitAndOffset(5,0);
		
		foreach ($articles as $article) {
			$startTime = new DateTime($article->getStartTimestamp());
			echo '<li><div class="headline"><a href="'. $article->getURL() .'">'. $article->getTitle() .'</a></div><div class="date">'. $startTime->format('F j, Y') .'</div></li>';
		}

		echo '	</ul>';
		echo '</div>';
	}

?>
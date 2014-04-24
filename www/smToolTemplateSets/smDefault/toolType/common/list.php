<?php

/*------------------------------------------------------------------------------------------

File: common/list.php 
Summary: Common list view for News, Calendar, and other list-based tools' views
Version: 6.0


Copyright (C) 2013 Sitemason, Inc. All Rights Reserved.

------------------------------------------------------------------------------------------*/

	//-----------------------
	// SETTINGS


	$numberOfItemsPerPage = 10; // show X items per page.  Set to 0 to disable pagination
	
	// END SETTINGS
	//-----------------------


	if ($numberOfItemsPerPage) {
		$numberOfPages = ceil($smCurrentTool->getNumberOfItems() / $numberOfItemsPerPage);
		$offset = $smCurrentTool->getOffset(); // really "start with index"
		$currentPage = 1;
		if ($offset > 0) {
			$currentPage = $offset / $numberOfItemsPerPage + 1;
		}	
	}

	/*
		If we've reached the landing page (no offset), limit the number of pages displayed
		and then set up pagination via URL manipulation.
	*/
	if ($numberOfItemsPerPage && !$offset && $numberOfPages > 1) {
		$items = $smCurrentTool->getItemsWithLimitAndOffset($numberOfItemsPerPage, $offset);
	}
	// Otherwise, display all Items returned from the API
	else {
		$items = $smCurrentTool->getItems();
	}
	

?>

<h1 class="title"><?php echo $smCurrentTool->getTitle(); ?></h1>
<?php
	$toolType = $smCurrentTool->getToolType();
	
	foreach ($items as $item) {
		
		$classList = 'article article-list';
		if ($toolType == 'calendar') { $classList .= ' article-event'; }
		
		echo '<article class="'. $classList .'">';
		
		//
		// Thumbnail
		//
		$thumbnail = $item->getThumbnailImageSize();
		if ($thumbnail) {
			echo '	<div class="article-thumb">';
			echo '		<a class="article-thumb-link" href="'. $item->getURL() .'"><img class="article-thumb-image" src="'. $thumbnail->getURL() .'" width="'. $thumbnail->getWidth() .'" height="'. $thumbnail->getHeight() .'" alt="'. $thumbnail->getAlt() .'" /></a>';
			echo '	</div>';
		}
		
		//
		// Title
		//
		echo '	<h2 class="article-title"><a class="article-title-link" href="'. $item->getURL() .'">'. $item->getTitle() .'</a></h2>';
		
		//
		// Date(s) / Time
		//
		
		// We don't want this for the Store
		if ($this->getToolType() != 'store') {
		
			$startDate = date('M d, Y', strtotime($item->getStartTimestamp()));
			$startTime = date('h:i a', strtotime($item->getStartTimestamp()));
			
			echo '<div class="article-meta">';
			
			// Date
			echo '<span class="article-date">'. $startDate .'</span> <span class="divider">|</span> ';
			
			// Time
			echo '<span class="article-hour">';
			
			if ($item->isAllDay()) {
				echo 'All Day';
			}
			else {
				echo $startTime;
				if ($item->getEndTimestamp()) { 
					$endTime = date('h:i a', strtotime($item->getEndTimestamp()));
					echo ' - '. $endTime; 
				}
			}
	
			echo '</span> <span class="divider">|</span> ';
			
			//
			// Author Name & email address
			//
			if ($item->getAuthorName()) {
				echo '<span class="article-author">By: ';
				
				if ($item->getAuthorEmailAddress()) {
					echo '<a class="article-author-link" href="mailto:'. $item->getAuthorEmailAddress() .'">';
				}
				
				echo $item->getAuthorName();
				
				if ($item->getAuthorEmailAddress()) {
					echo '</a>';
				}
				
				echo '</span> ';
			}
			
			//
			// Alternate Source & URL
			//
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
	
			echo '</div>'; // end .article-meta
		}
		
		
		//
		// Summary
		//
		if ($item->getSummary()) {
			echo '<div class="article-summary">';
			echo '	<p>'. $item->getSummary() .' &hellip; <a class="article-more" href="'. $item->getURL() .'">Read more &raquo;</a></p>';
			echo '</div>';	
		}
		
		echo '</article>';
	}
?>

<div class="pagination">
	<ul class="pagination-pages">
	<?php
		// Pagination navigation
		if ($numberOfItemsPerPage && $numberOfPages > 1) {
		
			$previousUrl = '';
			$queryString = $_SERVER['QUERY_STRING'];
			$queryString = preg_replace('/p=[0-9]*/','', $queryString);
			
			// the URL without the offset
			$link = $smCurrentTool->getPath() .'/list/set/'. $numberOfItemsPerPage;
			
			//
			// Previous page button
			//

			$previousURL = null;
			if ($currentPage > 1) {
				$previousOffset = $offset - $numberOfItemsPerPage;
				if ($previousOffset > 0) { $previousOffset--; }	// subtract one more unless we hit zero
				$previousURL = $link .'/'. $previousOffset .'/';
				if ($queryString) { $previousURL .= '?'. $queryString; }
			}
			
			echo '<li class="pagination-nav pagination-nav-prev pagination-page';
			if (!$previousURL) { echo ' pagination-unavailable'; }
			echo '">';
			if ($previousURL) { echo '<a class="pagination-page-link" href="'. $previousURL .'">'; }
			echo '&laquo;';
			if ($previousURL) { echo '</a>'; }
			echo '</li>';

			//
			// page buttons
			//
			
			for ($i = 1; $i < $numberOfPages + 1; $i++) {
				$pageOffset = ($i - 1) * $numberOfItemsPerPage;
				if ($pageOffset > 0) { $pageOffset++; }
				
				$pageURL = $link .'/'. $pageOffset .'/';
				if ($queryString) { $pageURL .= '?'. $queryString; }
				echo '<li class="pagination-page"><a class="pagination-page-link" href="'. $pageURL .'"';
				if ($page == $i) { echo ' class="current"'; }
				echo '>'. $i .'</a></li>';
			}
			
			
			//
			// Next page button
			//
			
			$nextURL = null;
			if ($currentPage < $numberOfPages) {
				$nextOffset = $offset + $numberOfItemsPerPage + 1;
				$nextURL = $link .'/'. $nextOffset .'/';
				if ($queryString) { $$nextURL .= '?'. $queryString; }
			}
			
			echo '<li class="pagination-nav pagination-nav-next pagination-page';
			if (!$nextURL) { echo ' pagination-unavailable'; }
			echo '">';
			if ($nextURL) { echo '<a class="pagination-page-link" href="'. $nextURL .'">'; }
			echo '&raquo;';
			if ($nextURL) { echo '</a>'; }
			echo '</li>';
		}
	?>
	</ul>
</div>
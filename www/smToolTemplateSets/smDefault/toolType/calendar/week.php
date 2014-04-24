<?php

/*------------------------------------------------------------------------------------------

File: calendar/week.php 
Summary: Calendar Tool (Week View / Grid) Template 
Version: 6.0
  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 
 
------------------------------------------------------------------------------------------*/


	/*
		We need to figure out the first and the last dates of the week.  For the moment,
		this is going to be tougher than it should be due to some Sitemason back-end 
		stipulations (with SMTool's displayedDate = "The 4th week of July 2012")
	*/
	
	// parse up the displayedDate
	$parsedDisplayedDate = array();
	preg_match('/The ([0-9])[a-z]* week of (.*)/', $smCurrentTool->getDisplayedDate(), $parsedDisplayedDate);
	$weekNumber = $parsedDisplayedDate[1];
	$monthYear = $parsedDisplayedDate[2];
		
	#echo '<pre>$parsedDisplayedDate'; print_r($parsedDisplayedDate); echo '</pre>';

	// today
	$today = new DateTime();
	
	// set $startDate to the first of the month initially
	$thisDay = new DateTime('1 '. $monthYear);

	// the weekday of the first of the month.  0 = Sunday, 1 = Monday... 6 = Saturday
	$firstOfTheMonthWeekday = (int)$thisDay->format('w');

	// reset $thisDay to the previous Sunday (first week of the month)
	if ($firstOfTheMonthWeekday > 0) {
		$thisDay->sub(new DateInterval('P'. $firstOfTheMonthWeekday .'D'));
	}

	// add $weekNumber weeks to $thisDay.  This is the starting date of the $weekNumber week of the month
	$weekNum = $weekNumber - 1; // we need to subtract one from this to account for the first (potentially partial) week
	$thisDay->add(new DateInterval('P'. $weekNum .'W'));
	
	// add 6 days to $thisDay and you'll get the last day of the week we're displaying
	$lastDay = clone $thisDay;
	$lastDay->add(new DateInterval('P6D'));
	
	// reformat $weekNumber
	if ($weekNumber == 1) { $weekNumber = '1st'; }
	else if ($weekNumber == 2) { $weekNumber = '2nd'; }
	else if ($weekNumber == 3) { $weekNumber = '3rd'; }
	else if ($weekNumber == 4) { $weekNumber = '4th'; }
	else if ($weekNumber == 5) { $weekNumber = '5th'; }
?>

<div class="calendar-nav">
	<a class="calendar-nav-link calendar-link-prev" href="<?php echo $smCurrentTool->getPreviousPageURL(); ?>">&#171;</a>
	<a class="calendar-nav-link calendar-link-next" href="<?php echo $smCurrentTool->getNextPageURL(); ?>">&#187;</a>
</div>

<h1 class="calendar-title title"><?php echo $weekNumber .' week of '. $thisDay->format('F') .' '. $thisDay->format('Y'); ?></h1>

<?php
	while ($thisDay <= $lastDay) {
		echo '<div class="calendar-week-events">';
		echo '	<h2 class="calendar-head-item calendar-weekday calendar-head-list">'. $thisDay->format('l') .'</h2>';
		echo '	<h3 class="calendar-date calendar-date-list"><span class="calendar-date-month">'. $thisDay->format('F') .'</span> <span class="calendar-date-day">'. $thisDay->format('j') .'</span>, <span class="calendar-date-year">'. $thisDay->format('Y') .'</span></h3>';
		
		$events = $smCurrentTool->getItemsWithDate($thisDay->format('Y-m-d'));
		if (count($events) > 0) {
			echo '<div class="calendar-event-list">';
			
			foreach ($events as $item) {
				$startDate = new DateTime($item->getStartTimestamp());
				$thumbnail = $item->getImageSizeWithLabelOfImageWithKey('thumbnail','image1');
				
				echo '<article class="event event-list article article-list">';
				
				if ($thumbnail) {
					echo '<div class="event-image event-image-thumb article-image article-image-thumb">';
					echo '	<a class="event-thumb article-thumb-link article-thumb-link" href="'. $item->getURL() .'">';
					echo '		<img class="event-thumb article-thumb" src="'. $thumbnail->getURL() .'" alt="'. $thumbnail->getAlt() .'">';
					echo '	</a>';
					echo '</div>';	
				}
				
				echo '	<h2 class="event-title article-title"><a class="event-title article-title-link" href="'. $item->getURL() .'">'. $item->getTitle() .'</a></h2>';
				echo '	<div class="event-meta article-meta">';
				echo '		<span class="event-date article-date">'. $thisDay->format('M j, Y') .'</span> <span class="divider">|</span> <span class="event-hour article-hour">'. $startDate->format('h:i a') .'</span>';
				echo '	</div>';

				if ($item->getSummary()) {
					echo '<div class="event-summary article-summary">'. $item->getSummary() .'</div>';	
				}
				echo '</article>';
			}
			
			echo '</div>';
		}
		else {
			echo '<p class="calendar-noevents">No events found.</p>';	
		}
		
		echo '</div>';
		
		$thisDay->add(new DateInterval('P1D'));
	}
?>
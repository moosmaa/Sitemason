<?php

/*------------------------------------------------------------------------------------------

File: calendar/month.php 
Summary: Calendar Tool (Month View / Grid) Template 
Version: 6.0
  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 
 
------------------------------------------------------------------------------------------*/

	/*
		We need to calculate a few things for the calendar.  We need to know what day of the week
		the first day of the month (the month being viewed, not necessarily THIS month) was.
		Also, we need to (probably) show a few days in the previous month as well as (probably) 
		a few days in the next month in order to fill the grid.
		
		We're using PHP's DateTime class instead of date functions because this will support
		pre-UNIX epoch dates...
	*/
	
	// today
	$today = new DateTime();
	
	// UNIX timestamp for the first day of the month being viewed.
	$firstDayOfTheMonth = new DateTime($smCurrentTool->getDisplayedDate());

	// 28-31
	$numberOfDaysInTheMonth = $firstDayOfTheMonth->format('t');
	
	$lastDayOfTheMonth = clone $firstDayOfTheMonth;
	$days = $numberOfDaysInTheMonth - 1;
	$lastDayOfTheMonth->add(new DateInterval('P'. $days .'D'));

	// the first day (day of the week) of the month.  0 = Sunday, 1 = Monday... 6 = Saturday
	$firstWeekDayOfTheMonth = $firstDayOfTheMonth->format('w');

	// go ahead and set the first date displayed on the grid
	$thisDate = clone $firstDayOfTheMonth;
	$thisDate->sub(new DateInterval('P'. $firstWeekDayOfTheMonth .'D'));

	// the last date displayed on the grid.
	$numberOfRowsToDisplay = ceil(($firstWeekDayOfTheMonth + $numberOfDaysInTheMonth) / 7);
	$numDays = 7 * $numberOfRowsToDisplay - 1;
	$lastDateToDisplay = clone $thisDate;
	$lastDateToDisplay->add(new DateInterval('P'. $numDays .'D'));
?>

<div class="calendar-nav">
	<a class="calendar-nav-link calendar-link-prev" href="<?php echo $smCurrentTool->getPreviousPageURL(); ?>">&#171;</a>
	<a class="calendar-nav-link calendar-link-next" href="<?php echo $smCurrentTool->getNextPageURL(); ?>">&#187;</a>
</div>
<h1 class="calendar-title title"><?php echo $smCurrentTool->getDisplayedDate(); ?></h1>
<table class="calendar calendar-month">
	<thead class="calendar-head">
		<tr class="calendar-head-row">
			<th class="calendar-head-item calendar-head-weekend">Sunday</th>
			<th class="calendar-head-item calendar-weekday">Monday</th>
			<th class="calendar-head-item calendar-weekday">Tuesday</th>
			<th class="calendar-head-item calendar-weekday">Wednesday</th>
			<th class="calendar-head-item calendar-weekday">Thursday</th>
			<th class="calendar-head-item calendar-weekday">Friday</th>
			<th class="calendar-head-item calendar-head-weekend">Saturday</th>
		</tr>
	</thead>
	<tbody class="calendar-body">
	<?php
		$continue = true;
		
		
		/*
			loop through the days for this calendar grid, starting with $thisDate, which is the first date shown on the grid.
			And ending with $lastDateToDisplay, which is the last date to show.
		*/
		$dayCounter = 0;
		while ($continue) {

			// get the events for thisDate
			$events = $smCurrentTool->getItemsWithDate($thisDate->format('Y-m-d'));

			// new week
			$dayOfTheWeek = $thisDate->format('w');
			if ($dayOfTheWeek == 0) {
				echo '<tr class="calendar-week">';
			}
			
			//
			// the day
			//
			
			// construct CSS classes
			$tableCellClasses = 'calendar-day';
			$headerClasses = 'calendar-date';
			
			// if thisDate is in the previous month, add a few styles
			if ($thisDate < $firstDayOfTheMonth) {
				$tableCellClasses .= '  calendar-inactive calendar-prev';	
				$headerClasses .= ' calendar-date-inactive';
			}
			
			// if thisDate is in the next month, add a few styles
			if ($thisDate > $lastDayOfTheMonth) {
				$tableCellClasses .= '  calendar-inactive calendar-next';
				$headerClasses .= ' calendar-date-inactive';
			}
			
			// if thisDate has events, add one style:
			if (count($events) > 0) {
				$tableCellClasses .= ' calendar-event';
			}
			
			// if thisDate is today, add a style:
			if ($thisDate == $today) {
				$tableCellClasses .= '  calendar-inactive calendar-day-active';	
				$headerClasses .= ' calendar-date-active';
			}
				
			
			// Start the cell for thisDate!
			echo '<td class="'. $tableCellClasses .'">';
			echo '	<h3 class="calendar-date calendar-date-inactive">';
			
			// if we're on the very first day shown or a new month, show some details for mobile devices
			if ($dayCounter == 0) {
				echo '<span class="desktop-hidden calendar-date-month">'. $thisDate->format('F') .' </span>';
			}
			
			// Show the day of the month
			echo $thisDate->format('j');
			
			// if we're on the very first day shown or a new month, show some details for mobile devices
			if ($dayCounter == 0) {
				echo '<span class="calendar-date-year desktop-hidden">, '. $thisDate->format('Y') .'</span>';
			}
			
			echo '	</h3>';
			
			
			//
			// Events on thisDate
			//
			if (count($events) > 0) {
				echo '<ul class="calendar-list">';
				
				foreach ($events as $item) {
					echo '	<li class="calendar-item"><a class="calendar-link" href="'. $item->getURL() .'">'. $item->getTitle() .'</a></li>';
				}
				echo '</ul>';
			}
				
			echo '</td>';
			
			
			// new week
			if ($dayOfTheWeek == 6) {
				echo '</tr>';
			}
			
			
			// sanity check.
			if ($dayCounter == ($numberOfRowsToDisplay * 7) - 1) {
				$continue = false;	
			}
			$dayCounter++;
			
			// Move onto the next day.
			$thisDate->add(new DateInterval('P1D'));
		}
	?>
	</tbody>
</table>
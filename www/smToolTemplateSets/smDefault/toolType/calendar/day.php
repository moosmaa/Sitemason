<?php

/*------------------------------------------------------------------------------------------

File: calendar/day.php 
Summary: Calendar Tool (Day View / Hourly) Template 
Version: 6.0
  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 
 
------------------------------------------------------------------------------------------*/
	$thisDay = new DateTime($smCurrentTool->getDisplayedDate());
	
	// go ahead and split up the Items into All Day, Morning, Afternoon, and Evening.
	$events = $smCurrentTool->getItems();
	$allDayEvents = array();
	$morningEvents = array();
	$afternoonEvents = array();
	$eveningEvents = array();
	
	foreach ($events as $event) {
		$isAllDay = $event->isAllDay();
		if ($isAllDay) {
			$allDayEvents[] = $event;
		}
		else {
			$eventStartTime = new DateTime($event->getStartTimestamp);
			$eventStartHour = $eventStartTime->format('G');
			
			if ($eventStartHour < 12) {
				$morningEvents[] = $event;
			}
			else if ($eventStartHour < 17) {
				$afternoonEvents[] = $event;
			}
			else {
				$eveningEvents[] = $event;
			}
		}
	}
	
?>

<div class="calendar-nav">
	<a class="calendar-nav-link calendar-link-prev calendar-link-disabled">«</a>
	<a class="calendar-nav-link calendar-link-next">»</a>
</div>

<h1 class="calendar-title title"><?php echo $thisDay->format('l F j, Y'); ?></h1>

<!-- ALL DAY -->
<div class="calendar-week-events">
	<h2 class="calendar-head-item calendar-weekday calendar-head-list">All Day</h2>
	<?php
		if (count($allDayEvents) > 0) {
			foreach ($allDayEvents as $event) {
				echo '<article class="event event-list article article-list">';
				echo '	<h2 class="event-title article-title"><a class="event-title article-title-link" href="'. $event->getURL() .'">'. $event->getTitle() .'</a></h2>';
				echo '</article>';	
			}
		}
		else {
			echo '<p class="calendar-noevents">No events found.</p>';
		}
	?>
</div>

<!-- Morning: 0:00-11:59 -->
<h2 class="calendar-head-item calendar-weekday calendar-head-list">Morning</h2>
<?php
	if (count($morningEvents) > 0) {
		echo '<div class="calendar-event-list">';
		foreach ($morningEvents as $event) {
			$startTime = new DateTime($event->getStartTimestamp());
			if ($event->getEndTimestamp()) {
				$endTime = new DateTime($event->getEndTimestamp());	
			}
			
			echo '<article class="event event-list article article-list">';
			echo '	<h2 class="event-title article-title"><a class="event-title article-title-link" href="'. $event->getURL() .'">'. $event->getTitle() .'</a></h2>';
			echo '	<div class="event-meta article-meta">';
			echo '		<span class="event-hour article-hour">'. $startTime->format('g:i a');
			if ($endTime) {
				echo ' - '. $endTime->format('g:i a');
			}
			echo '</span>';
			echo '	</div>';
			echo '</article>';
		}
		echo '</div>';
	}
	else {
		echo '<p class="calendar-noevents">No events found.</p>';
	}
?>

<!-- Afternoon: 12:00-16:59 -->
<h2 class="calendar-head-item calendar-weekday calendar-head-list">Afternoon</h2>
<?php
	if (count($afternoonEvents) > 0) {
		echo '<div class="calendar-event-list">';
		foreach ($afternoonEvents as $event) {
			$startTime = new DateTime($event->getStartTimestamp());
			if ($event->getEndTimestamp()) {
				$endTime = new DateTime($event->getEndTimestamp());	
			}
			
			echo '<article class="event event-list article article-list">';
			echo '	<h2 class="event-title article-title"><a class="event-title article-title-link" href="'. $event->getURL() .'">'. $event->getTitle() .'</a></h2>';
			echo '	<div class="event-meta article-meta">';
			echo '		<span class="event-hour article-hour">'. $startTime->format('g:i a');
			if ($endTime) {
				echo ' - '. $endTime->format('g:i a');
			}
			echo '</span>';
			echo '	</div>';
			echo '</article>';
		}
		echo '</div>';
	}
	else {
		echo '<p class="calendar-noevents">No events found.</p>';
	}
?>


<!-- Evening: 17:00-23:59 -->
<h2 class="calendar-head-item calendar-weekday calendar-head-list">Evening</h2>
<?php
	if (count($eveningEvents) > 0) {
		echo '<div class="calendar-event-list">';
		foreach ($eveningEvents as $event) {
			$startTime = new DateTime($event->getStartTimestamp());
			if ($event->getEndTimestamp()) {
				$endTime = new DateTime($event->getEndTimestamp());	
			}
			
			echo '<article class="event event-list article article-list">';
			echo '	<h2 class="event-title article-title"><a class="event-title article-title-link" href="'. $event->getURL() .'">'. $event->getTitle() .'</a></h2>';
			echo '	<div class="event-meta article-meta">';
			echo '		<span class="event-hour article-hour">'. $startTime->format('g:i a');
			if ($endTime) {
				echo ' - '. $endTime->format('g:i a');
			}
			echo '</span>';
			echo '	</div>';
			echo '</article>';
		}
		echo '</div>';
	}
	else {
		echo '<p class="calendar-noevents">No events found.</p>';
	}
?>
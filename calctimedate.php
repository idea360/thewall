<?php
function calcTimeDiff($cmpDate)
{
	//Caclute if the time difference from the post creation to NOW.
	$current_datetime = new DateTime('now', new DateTimeZone('America/Los_Angeles'));
	$post_datetime = new DateTime($cmpDate, new DateTimeZone('America/Los_Angeles'));
	$diff_datetime = $post_datetime->diff($current_datetime);
	// Convert to minutes!
	$diff_min = $diff_datetime->d * 1440;
	$diff_min += $diff_datetime->h * 60;
	$diff_min += $diff_datetime->i;
	
	return $diff_min;
}
?>
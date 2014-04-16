<?php

include_once('scheduler.php');

$appointment_type = 'service';
if (isset($_GET['appointment_type'])) {
	$appointment_type = $_GET['appointment_type'];
}

$s = new scheduler();
$calendars = $s->get_availability($appointment_type);

foreach ($calendars as $key => $cal) {
	foreach ($cal as $k => $v) {
		if ($k != 'availability' && $k != 'name' && $k != 'type' && $k != 'appointment_minutes') {
			unset($calendars[$key][$k]);
		}
	}
}

echo json_encode($calendars);

?>
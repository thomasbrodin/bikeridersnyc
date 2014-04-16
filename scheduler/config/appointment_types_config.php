<?php

/* Appointment type configurations */
/* NOTE: All fields are required AND id must be unique! */
$appointment_types_config = array(
	
	array('name'=>'Bike Fitting ($349.99)',
		  'type'=>'coach',
		  'id'=>'1',
		  'appointment_minutes'=>120),
	
	array('name'=>'Pre Fitting ($424.99)',
		  'type'=>'coach',
		  'id'=>'2',
		  'appointment_minutes'=>60),
	
	array('name'=>'Refitting (Bike Fit) ($174.99)',
		  'type'=>'coach',
		  'id'=>'3',
		  'appointment_minutes'=>60),
	
	array('name'=>'Cleat fitting ($74.99)',
		  'type'=>'coach',
		  'id'=>'4',
		  'appointment_minutes'=>30),
	
	array('name'=>'Lactate Testing ($224.99)',
		  'type'=>'coach',
		  'id'=>'5',
		  'appointment_minutes'=>90),
	
	array('name'=>'On-Bike Skills Session (1 hr) ($174.99)',
		  'type'=>'coach',
		  'id'=>'6',
		  'appointment_minutes'=>60),
	
	array('name'=>'Mechanical Service Call',
		  'type'=>'service',
		  'id'=>'7',
		  'appointment_minutes'=>180),
);

?>
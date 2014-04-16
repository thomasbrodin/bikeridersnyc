<?php

/* Calendar configurations - each calendar is defined as an array within the master "$calendars_config" array */
$calendars_config = array(
	
	/* 
	Individual calendar arrays:
	name (string, requred) 
	type (string, required, options: "coach","service")
	apointment_calendar (Google calendar id, required)
	availability_calendar (Google calendar id, required)
	max_appointments (integer or numeric string, optional, default:1)
	appointment_minutes (integer or numeric string, optional, default:60)
	buffer_minutes (integer or numeric string, optional, default:0)
	notification_email (string/email address, required)
	*/
	
	/* Mike */
	array('name'=>'Mike Sherry',
		'type'=>'coach',
		'apointment_calendar'=>'bikeriders.co_ld2clin2ptr6r9f43hlcknrro8@group.calendar.google.com',
		'availability_calendar'=>'bikeriders.co_8kd537m9rt4in9vd4oeiuuho98@group.calendar.google.com',
		'max_appointments'=>1,
		'appointment_types'=>array(1,2,3,4,5,6),
		'buffer_minutes'=>30,
		'notification_email'=>'schedule@bikeriders.co'),
	
	/* Dan */
	/*
	array('name'=>'Dan',
		'type'=>'coach',
		'apointment_calendar'=>'qp14r0tbqd0sdq9eveghm15spg@group.calendar.google.com',
		'availability_calendar'=>'fqeflmpi4r8glvp4lk13k37i88@group.calendar.google.com',
		'max_appointments'=>1,
		'appointment_types'=>array(1,2,3,4,5,6),
		'buffer_minutes'=>30,
		'notification_email'=>'schedule@bikeriders.co'),
	*/
	
	/* Bruno */
	/*
	array('name'=>'Bruno',
		'type'=>'coach',
		'apointment_calendar'=>'sq31r16jgjlsionlh3r7d8usbs@group.calendar.google.com',
		'availability_calendar'=>'8unhu44m66ua9u5dk0scuk25gs@group.calendar.google.com',
		'max_appointments'=>1,
		'appointment_types'=>array(1,2,3,4,5,6),
		'buffer_minutes'=>30,
		'notification_email'=>'schedule@bikeriders.co'),
	*/
	
	/* Service  - NOTE: do not change the name from Service */
	array('name'=>'Service',
		'type'=>'service',
		'apointment_calendar'=>'bikeriders.co_f43ap3llge4u6ncaoeaqfph2gc@group.calendar.google.com',
		'availability_calendar'=>'bikeriders.co_ktt1j8koupegh1s6cfqpem09dc@group.calendar.google.com',
		'max_appointments'=>10,
		'appointment_types'=>array(7),
		'buffer_minutes'=>0,
		'notification_email'=>'schedule@bikeriders.co'),
	
);

?>
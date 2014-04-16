<?php

include_once('Input.php');
include_once('scheduler.php');
include_once('form_builder.php');
include_once('../config/calendars_config.php');
include_once('../config/appointment_types_config.php');
include_once('../mailing/mailer.php');

// clean and gather post variables
$input = new Input();
$values = array();
foreach ($_POST as $k => $v) {
	$values[$input->xss_clean($k)] = $input->xss_clean($v);
}

// include form definition
if (isset($values['schedule_form']) && file_exists("../config/".$values['schedule_form']."_config.php")) {
	include_once('../config/'.$values['schedule_form'].'_config.php');
} else {
	echo json_encode(array('status'=>'error','errors'=>array('Error: form ('.$values['schedule_form'].') not found.')));
	exit();
}

// validate form
$errors = validate_form_fields($fields, $values);
$event = array();

// set appointment minutes
$appointment_minutes = 60;
foreach ($appointment_types_config as $appt_type) {
	if (isset($values['appointment_type']) && $appt_type['name'] == $values['appointment_type']) {
		$appointment_minutes = $appt_type['appointment_minutes'];
	}
}

// set destination calendar
$calendar = false;
if (isset($values['selected_coach'])) {
	$coach = $values['selected_coach'];
	foreach ($calendars_config as $cal) {
		if ($cal['name'] == $coach) {
			$calendar = $cal;
		}
	}
}
if ($calendar == false) {
	$errors['general'] = 'Error: department calendar not found';
}

// create Google calendar event
$event_uri = '';
if (count($errors) == 0) {
	
	if (isset($values['appointment']) && 
		isset($values['appointment_time']) && 
		isset($values['appointment_type']) && 
		isset($values['selected_coach'])
		) {
		
		// set event data
		$start_ts = strtotime($values['appointment'].' '.$values['appointment_time']);
		$event['title'] = $values['appointment_type'];
		$event['startTime'] = date("Y-m-d\TH:i:sP", $start_ts);
		$event['endTime'] = date("Y-m-d\TH:i:sP", strtotime("+".$appointment_minutes." minutes", $start_ts));
		if (strtolower($values['loc']) == 'in studio') {
			$event['address'] = 'In Studio, 142 Grand st, Brooklyn NY 11249';
		} else {
			$event['address'] = $values['address_1'];
			$event['address'] .= ($values['address_2'] != '') ? ', '.$values['address_2'] : '';
			$event['address'] .= ', '.$values['city'];
			$event['address'] .= ', '.$values['state'];
			$event['address'] .= ', '.$values['zip'];
		}
		$event['content'] = 'Thank you Booking an appointment with Bikeriders, below are the details, See you soon!'."\n";
		foreach ($values as $a => $b) {
			if ($a != 'address_1' && $a != 'address_2' && $a != 'city' && $a != 'state' && $a != 'zip' && $a != 'schedule_form' && $a != 'selected_coach') {
				$event['content'] .= ($event['content'] == '') ? '' : "\n";
				$event['content'] .= get_field_label($a,$fields).' - '.$b;
			}
		}
		
		// add event
		$scheduler = new scheduler();
		if ($scheduler) {
			$event_uri = $scheduler->add_event($calendar, $event);
			if (!$event_uri) {
				$errors['general'] = 'Error: event could not be created.';
			}
		} else {
			$errors['general'] = 'Error: your request could not be completed due to a system error.';
		}
		
	} else {
		$errors['general'] = 'Error: unable to create event, missing required values';
	}
	
}

// send email
if (count($errors) == 0 && isset($event['startTime']) && isset($event['endTime']) && isset($event['address']) && isset($event['content'])) {
	
	$email = array();
	$email['email_recips'][0] = $calendar['notification_email'];
	$email['from_name'] = 'SCHEDULE REQUEST';
	$email['from_email'] = 'schedule@bikeriders.co';
	$email['subject'] = 'A bikeridersnyc.com visitor has scheduled an appointment.';
	$email['body'] = '<p><b>Appointment details:</b><br />'.nl2br($event['content']).'</p>
					  <p><b>Location:</b><br />'.nl2br($event['address']).'</p>';
	if (!send_message($email)) {
		$errors['general'] = 'Error: notification email could not be sent.';
	}
	
}
	
// invalid, return errors
if (count($errors) > 0) {
	
	if (isset($errors['general']) && count($errors) > 1) {
		$errors['general'] = 'Please complete all required fields.';
	}
	echo json_encode( array('status'=>'error','errors'=>$errors) );

// success
} else {
	echo json_encode( array('status'=>'success','msg'=>'Your request has been submitted. You will be contacted shortly with confirmation of your appointment.') );
}

?>
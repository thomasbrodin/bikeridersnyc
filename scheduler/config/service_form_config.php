<?php

// WARNING: DO NOT EDIT THIS FILE
// Many variables names and values in this file are hard coded 

include_once('appointment_types_config.php');
$appt_type = '';
if (isset($appointment_types_config)) {
	foreach($appointment_types_config as $apptc) {
		if ($apptc['type'] == 'service') {
			$appt_type = $apptc['name'];
		}
	}
}

// define fields
$fields = array(
	array('type'=>'text',
		  'name'=>'name',
		  'label'=>'',
		  'placeholder'=>'Name',
		  'required'=>true,
		  ),
	array('type'=>'text',
		  'name'=>'email',
		  'label'=>'',
		  'placeholder'=>'Email',
		  'required'=>true,
		  ),
	array('type'=>'text',
		  'name'=>'phone',
		  'label'=>'',
		  'placeholder'=>'Phone',
		  'required'=>true,
		  ),
	array('type'=>'display',
		  'name'=>'appointment_type',
		  'label'=>'Type of Appointment :',
		  'value'=>$appt_type,
		  'display_condition'=>array('appointment_type'=> 'service'),
		  'required'=>true,
		  ),
	array('type'=>'radio',
		  'name'=>'loc',
		  'label'=>'Location',
		  'options'=>array('In Studio','Home Visit'),
		  'value'=>'Home Visit',
		  'display_condition'=>array('appointment_type'=> 'service'),
		  'required'=>true,
		  ),
	/* address fields (display if loc = 'Home Visit') */
	array('type'=>'text',
		  'name'=>'address_1',
		  'label'=>'',
		  'placeholder'=>'Address 1',
		  // 'display_condition'=>array('loc'=>'Home Visit'),
		  'required'=>true,
		  ),
	array('type'=>'text',
		  'name'=>'address_2',
		  'label'=>'',
		  'placeholder'=>'Address 2',
		  // 'display_condition'=>array('loc'=>'Home Visit'),
		  ),
	array('type'=>'select',
		  'name'=>'city',
		  'label'=>'',
		  'options'=>array('New York','Brooklyn','Queens', 'Long Island'),
		  // 'display_condition'=>array('loc'=>'Home Visit'),
		  'required'=>true,
		  ),
	array('type'=>'display',
		  'name'=>'state',
		  'label'=>'State',
		  'value'=>'NY',
		  // 'display_condition'=>array('loc'=>'Home Visit'),
		  ),
	array('type'=>'text',
		  'name'=>'zip',
		  'label'=>'',
		  'placeholder'=>'Zip',
		  // 'display_condition'=>array('loc'=>'Home Visit'),
		  'required'=>true,
		  ),
	array('type'=>'appointment',
		  'name'=>'appointment',
		  'label'=>'Date & Time',
		  'required'=>true,
		  ),
	array('type'=>'textarea',
		  'name'=>'comments',
		  'label'=>'',
		  'placeholder'=>'Any notes you think would help us get to you faster and If you just ordered a product online, please write us here your order ID',
		  ),
	
);

?>
<?php

function create_form_field($schedule_form='',$f) {
	
	$html = '';
	if (isset($f['type']) && isset($f['name'])) {
		
		$id = $schedule_form.'_'.$f['name'];
		$value = "";
		preg_match("/".$f['name']."=([^&\/]+)/", $_SERVER['REQUEST_URI'], $preset_match);
		if (isset($preset_match[1])) {
			$value = urldecode($preset_match[1]);
		} else if (isset($f['value'])) {
			$value = $f['value'];
		}
		
		switch($f['type']) {
			
			case 'select':
			
				$html = '<select name="'.$f['name'].'" id="'.$id.'" ';
				$html .= (isset($f['onchange'])) ? ' onchange="'.$f['onchange'].'" ' : '';
				$html .= '>';
				if (isset($f['options']) && is_array($f['options'])) {
					foreach ($f['options'] as $f_opt) {
						$html .= '<option value="'.htmlspecialchars($f_opt).'" ';
						$html .= ($value == $f_opt) ? ' selected="selected" ' : '';
						$html .= '>'.$f_opt.'</option>';
					}
				}
				$html .= '</select>';
				
			break;	
			case 'radio':
				
				if (isset($f['options']) && is_array($f['options'])) {
					foreach ($f['options'] as $i => $f_opt) {
						$html .= '<input type="radio" name="'.$f['name'].'" id="'.$id.'_'.$i.'" value="'.htmlspecialchars($f_opt).'" ';
						$html .= ($value == $f_opt) ? ' selected="selected" ' : '';
						$html .= '> <label for="'.$id.'_'.$i.'" id="'.$id.'">'.$f_opt.'</label>';
					}
				}
				
			break;
			case 'textarea':
				
				$html = '<textarea name="'.$f['name'].'" id="'.$id.'" ';
				$html .= (isset($f['placeholder'])) ? ' placeholder="'.$f['placeholder'].'" ' : '';
				$html .= '>'.$value.'</textarea>';
				
			break;
			case 'appointment':
			
				$html = '
				<input type="text" name="'.$f['name'].'" id="'.$id.'" class="date_input" value="'.$value.'" style="display:none;" />
				<span class="spinner">loading...</span>
				<span class="notification" style="display:none;">Please select an appointment type</span>
				<span class="date_times"></span>';
			
			break;
			case 'display':
			
				$html = '
				<input type="hidden" name="'.$f['name'].'" id="'.$id.'" value="'.$value.'" />
				<span name="'.$f['name'].'" id="'.$id.'">'.$value.'</span>';
			
			break;
			case 'hidden':
				
				$html = '
				<input type="hidden" name="'.$f['name'].'" id="'.$id.'" value="'.$value.'" />';
				
			break;
			default:
			case 'text':
				$html = '<input type="text" name="'.$f['name'].'" id="'.$id.'" value="'.$value.'" ';
				$html .= (isset($f['placeholder'])) ? ' placeholder="'.$f['placeholder'].'" ' : '';
				$html .= (isset($f['required']) && $f['required'] == true) ? ' class="required" ' : '';
				$html .= '>';
			break;
			
		}	
	}
	
	return $html;
}

function validate_form_fields($fields=array(), $values=array()) {
	$errors = array();
	if (count($fields) > 0 && count($values) > 0) {
		
		foreach ($fields as $k => $v) {
			switch($v['type']) {
			
				case 'email':
					if (isset($v['required']) && $v['required'] == true && (!isset($values[$v['name']]) || !validEmail($values[$v['name']]))) {
						$errors[$v['name']] = 'Please enter a valid email address';
					}
				break;
				case 'appointment':
					if (isset($v['required']) && $v['required'] == true && (!isset($values[$v['name']]) || trim($values[$v['name']]) == '' || !isset($values['appointment_time']) || trim($values['appointment_time']) == '')) {
						$errors[$v['name']] = 'Please select an appointment date and time';
					}
				break;	
				default:
					// no display conditions
					if (isset($v['required']) && $v['required'] == true && !isset($v['display_condition']) && (!isset($values[$v['name']]) || trim($values[$v['name']]) == '')) {
						$errors[$v['name']] = 'Please enter your '.$v['label'];
						
					// display conditions
					}  else if (isset($v['required']) && $v['required'] == true && isset($v['display_condition'])  && (!isset($values[$v['name']]) || trim($values[$v['name']]) == '')) {
						
						// check for display condition, then check if required
						foreach ($v['display_condition'] as $dck => $dcv) {
							if ((is_array($dcv) && in_array($values[$dck], $dcv)) || (!is_array($dcv) && $values[$dck] == $dcv)) {
									$errors[$v['name']] = 'Please enter your '.$v['label'];
							}
						}
						
					}
				break;
				
			}
		}
		
	} else {
		$errors['general'] = 'Please complete all required fields.';
	}
	return $errors;
}

function is_hidden_field($field=array(),$fields=array()) {
	$ret = false;
	if (isset($field['display_condition']) && count($field['display_condition']) > 0 && count($fields) > 0) {
		// field has condition, hide the field
		$ret = true;
		// check against default field values
		foreach ($fields as $f) {
			if (isset($field['display_condition'][$f['name']]) && isset($f['value']) && $field['display_condition'][$f['name']] == $f['value']) {
				$ret = false;
			}
		}
	} else if ($field['type'] == 'hidden') {
		$ret = true;
	}
	return $ret;
}
function get_js_field_conditions($schedule_form='', $fields=array()) {
	$js = '';
	if (count($fields) > 0) {
		foreach ($fields as $f) {
			if (isset($f['display_condition']) && count($f['display_condition']) > 0) {
				
				$selector = '#'.$schedule_form.'_form input[name='.$f['name'].']';
				if ($f['type'] == "radio") {
					$selector = str_replace('input[','input:radio[',$selector);
				} else if ($f['type'] == "select") {
					$selector = str_replace('input[','select[',$selector);
				} else if ($f['type'] == 'display') {
					$selector = str_replace('input[','span[',$selector);
				}
				
				$conditions = array();
				foreach ($f['display_condition'] as $fk => $fv) {
					
					$dc_selector = '#'.$schedule_form.'_form input[name='.$fk.']';
					foreach ($fields as $dc_field) {
						if ($dc_field['name'] == $fk) {
							if ($dc_field['type'] == 'radio') {
								$dc_selector = str_replace("input[","input:radio[",$dc_selector);
							} else if ($dc_field['type'] == 'select') {
								$dc_selector = str_replace("input[","select[",$dc_selector);
							} else if ($dc_field['type'] == 'display') {
								$dc_selector = str_replace("input[","span[",$dc_selector);
							}
						}
					}
					
					if (is_array($fv)) {
						foreach ($fv as $fvv) {
							$conditions[] = create_field_condition($dc_selector,$fk,$fvv,$fields);
						}
					} else {
						$conditions[] = create_field_condition($dc_selector,$fk,$fv,$fields);
					}
					
				}
				
				$js .= '
				if ('.implode(" || ",$conditions).') {
					dom.query("'.$selector.'").closest("p").show(time);
				} else {
					dom.query("'.$selector.'").closest("p").hide(time);
				}';
				
			}
		}
	}
	return $js;
}

function create_field_condition($dc_selector='',$fk='',$fv='',$fields=array()) {
	return 'get_field_value("'.$dc_selector.'") == "'.str_replace('"','\"',$fv).'"';
}
function valid_chars($str='') {
	return preg_replace("/([^a-z0-9\-\_]+)/i","",$str);
}
function validEmail($e) {
	// take a given email address and split it into the username and domain.
	if (strstr($e,'@')) {
		list($userName, $mailDomain) = explode("@", $e);
		if (checkdnsrr($mailDomain, "MX")) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
function get_field_label($name='',$fields=array()) {
	$ret = $name;
	foreach ($fields as $k => $v) {
		if ($v['name'] == $name) {
			$ret = (isset($v['label'])) ? $v['label'] : $name;
		}
	}
	return $ret;
}

?>
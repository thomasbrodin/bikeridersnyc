<?php

putenv("TZ=America/New_York");

class scheduler {
	
	var $calendars = array();
	var $appointment_types = array();
	var $startMin;
	var $startMax;
	var $gmail_user = 'schedule@bikeriders.co';
	var $gmail_pass = '5japancakes';
	var $minute_increment = 30;
	
	function __construct() {
		
		// load Zend
		ini_set('include_path', realpath('../'));
		require_once '../Zend/Loader.php';
		Zend_Loader::loadClass('Zend_Gdata');
		Zend_Loader::loadClass('Zend_Gdata_AuthSub');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_HttpClient');
		Zend_Loader::loadClass('Zend_Gdata_Calendar');
		
		// load calendar definitions
		include('../config/calendars_config.php');
		if (isset($calendars_config)) {
			$this->calendars = $calendars_config;
		} else {
			return false;
		}
		
		// load schedule types
		include('../config/appointment_types_config.php');
		if (isset($appointment_types_config)) {
			$this->appointment_types = $appointment_types_config;
		} else {
			return false;
		}
		
		$this->startMin = date("Y-m-d");
		$this->startMax = date("Y-m-d", strtotime("+6 months"));
		
	}
	
	function get_availability($service_type='', $calendar=array(), $startMin=0, $startMax=0) {
		
		$open = array();
		$scheduled = array();
		$apointments =array();
		$hours = array();
		$ret_key = 0;
		
		foreach($this->calendars as $cal_key => $cal_val) {
			
			if (($service_type == '' || (isset($cal_val['type']) && $service_type == $cal_val['type'])) && ((isset($calendar['name']) && $calendar['name'] == $cal_val['name']) || !isset($calendar['name']))) {
				
				$ret_key = $cal_key;
				$availability_calendar = (isset($cal_val['availability_calendar']) && trim($cal_val['availability_calendar']) != '') ? $cal_val['availability_calendar'] : false;
				$apointment_calendar = (isset($cal_val['apointment_calendar']) && trim($cal_val['apointment_calendar']) != '') ? $cal_val['apointment_calendar'] : false;
				$max_appointments = (isset($cal_val['max_appointments'])) ? $cal_val['max_appointments'] : 1;
				$buffer_minutes = (isset($cal_val['buffer_minutes'])) ? $cal_val['buffer_minutes'] : 0;
				
				foreach ($this->appointment_types as $appt_type) {
					
					// check to see if appointment type is relevant to calendar
					if (in_array($appt_type['id'], $cal_val['appointment_types'])) {
						
						$appointment_minutes = (isset($appt_type['appointment_minutes'])) ? $appt_type['appointment_minutes'] : 60;
						
						$open = $this->get_events($availability_calendar, $appointment_minutes, $startMin, $startMax);
						$scheduled = $this->get_events($apointment_calendar, $appointment_minutes, $startMin, $startMax);
						
						// unset fully booked time
						foreach ($scheduled as $key => $val) {
							foreach ($val as $k => $appts) {
								if (isset($open[$key][$k]) && $appts['num'] >= $max_appointments) {
									unset($open[$key][$k]);
								}
							}
						}
						
						// remove blocks that are less than the minimum appointment_minutes
						foreach ($open as $key => $val) {
							
							$block_minutes = 0;
							
							foreach ($val as $k => $v) {
								
								$block_now = strtotime($key.' '.$k.':00');
								$block_next = strtotime("+ ".$this->minute_increment." minutes", $block_now);
								
								// if not the end of the block
								if (isset($open[$key][date("H:i",$block_next)])) {
									$block_minutes += $this->minute_increment;
								
								// if too short, unset the block
								} else if ($block_minutes+$this->minute_increment < $appointment_minutes) {
									
									$block_back = $block_now;
									while ($block_back >= strtotime("- ".$block_minutes." minutes",$block_now)) {
										if (isset($open[$key][date("H:i",$block_back)])) {
											unset($open[$key][date("H:i",$block_back)]);
										}
										$block_back = strtotime("- ".$this->minute_increment." minutes",$block_back);
									}
									$block_minutes = 0;
									
								// otherwise, the block is long enough - remove last few segments
								} else {
									
									$block_back = $block_now;
									while ($block_back > strtotime("- ".($appointment_minutes-$this->minute_increment)." minutes",$block_now)) {
										if (isset($open[$key][date("H:i",$block_back)])) {
											unset($open[$key][date("H:i",$block_back)]);
										}
										$block_back = strtotime("- ".$this->minute_increment." minutes",$block_back);
									}
									$block_minutes = 0;
								}
								
							}
						}
						
						// unset empty dates
						foreach ($open as $key => $val) {
							if (count($val) == 0) {
								unset($open[$key]);
							}
						}
						
						$this->calendars[$cal_key]['availability'][$appt_type['name']] = $open;
						
					}
					
				}
				
			}
			
		}
		
		if (isset($calendar['name']) && $calendar['name'] != "") {
			return $this->calendars[$ret_key];
		} else {
			return $this->calendars;
		}
	}
	
	function get_events($calendarID, $appointment_minutes=60, $startMin=0, $startMax=0) {
		
		$data = array();
		$service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
		$client = Zend_Gdata_ClientLogin::getHttpClient($this->gmail_user, $this->gmail_pass, $service);
		$service = new Zend_Gdata_Calendar($client);
		$query = $service->newEventQuery();
		$query->setUser($calendarID);
		$query->setVisibility('private');
		$query->setProjection('full');
		$query->setOrderby('starttime');
		
		$startMin = ($startMin == 0) ? $this->startMin : $startMin;
		$startMax = ($startMax == 0) ? $this->startMax : $startMax;
		$query->setStartMin($startMin);
		$query->setStartMax($startMax);
		
		// Retrieve the event list from the calendar server
		try {
			$eventFeed = $service->getCalendarEventFeed($query);
		} catch (Zend_Gdata_App_Exception $e) {
			$output = "Error: " . $e->getMessage();
			echo $output;
		}
	
		foreach($eventFeed as $event) {
			foreach($event->when as $eventdate) {
				
				// add data in minimum minute_increment
				if (!stristr($event->eventStatus, "event.canceled")) {
					$block_date = date('Y-m-d',strtotime($eventdate->startTime));
					$block_start = $block_now = strtotime($eventdate->startTime);
					$block_end = strtotime($eventdate->endTime);
					while ($block_now < $block_end) {
						$num = (isset($data[$block_date][date("H:i",$block_now)]['num'])) ? $data[$block_date][date("H:i",$block_now)]['num']+1 : 1;
						$data[$block_date][date("H:i",$block_now)] = array('num'=>$num, 
																		   'start_time'=>date("H:i",$block_now), 
																		   'end_time'=>date("H:i",strtotime("+ ".$appointment_minutes." minutes",$block_now)));
						$block_now = strtotime("+ ".$this->minute_increment." minutes", $block_now);
					}
				}
				
			}
		}
		return $data;
	}
	
	function check_availability($calendar=array(), $appointment_type='', $startTime=0, $endTime=0) {
		$available = $this->get_availability('', $calendar, $startTime, $endTime);
		$start_date = date("Y-m-d",strtotime($startTime));
		$start_time = date("H:i",strtotime($startTime));
		return (isset($available['availability'][$appointment_type][$start_date][$start_time])) ? true : false;
	}
	
	function add_event($calendar=array(), $data=array()) {
		
		if ($this->check_availability($calendar, $data['title'], $data['startTime'], $data['endTime'])) {
		
			$service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
			$client = Zend_Gdata_ClientLogin::getHttpClient($this->gmail_user, $this->gmail_pass, $service);
			$service = new Zend_Gdata_Calendar($client);
			//$data is array takes following fields
			//$data['timeStart'] The event start datetime in RFC339
			//$data['timeEnd'] The event end datetime in RFC339
			//$data['address'] The address of the event
			//$data['content'] Any additional notes that should be included for the event
			//$data['startMin'] Used along with startMax to insure max apointments are not scheduled
			//$data['startMax'] Used along with startMin to insure max apointments are not scheduled
			
			// Create a new event object using calendar service's factory method.
			// We will then set different attributes of event in this object.
			$event= $service->newEventEntry();
			//$event->setUser($calendarID);
			// Create a new title instance and set it in the event
			$event->title = $service->newTitle($data['title']);
			// Where attribute can have multiple values and hence passing an array of where objects
			if (isset($data['address'])) {
				$event->where = array($service->newWhere($data['address']));
			}
			if (isset($data['content'])) {
				$event->content = $service->newContent($data['content']);
			}
			 
			// Create an object of When and set start and end datetime for the event
			$when = $service->newWhen();
			// Set start and end times in RFC3339 (http://www.ietf.org/rfc/rfc3339.txt)
			// ex. 2013-03-18T16:30:00.000+05:30 for 8th July 2010, 4:30 pm (+5:30 GMT)
			$when->startTime = $data['startTime'];
			$when->endTime = $data['endTime']; 
			// Set the when attribute for the event
			$event->when = array($when);
			 
			// Create the event on google server
			$newEvent = $service->insertEvent($event,'https://www.google.com/calendar/feeds/'.$calendar['apointment_calendar'].'/private/full');
			// URI of the new event which can be saved locally for later use
			
			return  $newEvent->id->text;
		} else {
			return false;	
		}
	}
	
}

?>
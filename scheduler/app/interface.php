<?php

// prerequisites
include_once('form_builder.php');

// URL & GET variables
preg_match("/interface.php\/([^\/\?]+)/",$_SERVER['REQUEST_URI'],$schedule_match);
$schedule_form = (isset($schedule_match[1])) ? valid_chars($schedule_match[1]) : false;
$schedule_form = file_exists('../config/'.$schedule_form.'_config.php') ? $schedule_form : false;

$callback = false;
if (isset($_GET['callback'])) {
	$callback = valid_chars($_GET['callback']);
}

// create form
if ($callback !== false && $schedule_form !== false) {
	
	// include config
	include_once('../config/'.$schedule_form.'_config.php');
	
	// create form
	$html = '
	<form action="javascript:submit_schedule_request(this);" method="post" class="schedule_form" id="'.$schedule_form.'_form">';
	
	$coach_value = '';
	$appointment_type = 'service';
	if (isset($fields) && count($fields) > 0) {
		foreach ($fields as $f) {
			$html .= (is_hidden_field($f, $fields)) ? '<p style="display:none;">' : '<p>';
			$html .= (isset($f['label']) && $f['label'] != '') ? '<label>'.$f['label'].'</label>' : '';
			$html .= create_form_field($schedule_form, $f).'</p>';
			
			if ($f['name'] == 'coach') {
				$appointment_type = 'coach';
				$coach_value = (isset($f['value'])) ? $f['value'] : '';
			}
		}
	}
	
	$html .= '
	<input type="hidden" name="schedule_form" value="'.$schedule_form.'" />
	<input type="hidden" name="selected_coach" id="'.$schedule_form.'_selected_coach" value="'.$coach_value.'" />
	
	<p><input type="submit" value="Submit&nbsp;&rarr;" /></p>
	<p id="'.$schedule_form.'_response" style="display:none;" class="response"></p>
	</form>
	<script type="text/javascript" src="app_path/js/include-jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="app_path/css/layout.css" />
	<link rel="stylesheet" type="text/css" href="app_path/css/ui-lightness/jquery-ui-1.8.9.custom.css" />
	<script>
	var dom = {}; // create custom jquery object
	var calendars;
	var in_progress = false;
	function scheduler_ini() {
		dom.query(".schedule_form").click(function() { update_fields(); }).keyup(function() { update_fields(); });
		update_fields(0);
		check_mobile();
		load_calendars();
		dom.query("#'.$schedule_form.' select[name=appointment_type],#'.$schedule_form.' select[name=coach]").change(function(){ resetAppointmentSelector(); });
	}
	function resetAppointmentSelector() {
		dom.query("#'.$schedule_form.' input[name=appointment]").val("");
		dom.query("#'.$schedule_form.' select[name=appointment_time]").remove();
	}
	function update_fields(time) {
		time = (time == undefined) ? 300 : 0;
		'.get_js_field_conditions($schedule_form, $fields).'
	}
	function get_field_value(selector) {
		if (dom.query(selector).attr("type") == "radio") {
			var rname = dom.query(selector).attr("name");
			var formid = dom.query(selector).closest("form").attr("id");
			var val = "";
			dom.query("#"+formid+" input[name="+rname+"]").each(function(ind,el) {
				val = (dom.query(this).is(":checked")) ? dom.query(this).val() : val;
			});
			return val;
		} else {
			return dom.query(selector).val();
		}
	}
	function check_mobile() { 
		if (dom.query(window).width() < 568) {
			dom.query(".date_input").each(function() {
				dom.query(this).css("display","hidden");
				dom.query(this).attr("class","");
				var input_value = dom.query(this).attr("value");
				dom.query(this).after(\'<div class="date_input">\'+input_value+\'</div>\');
			});
		}
	}
	function load_calendars() {
		dom.query.post("app_path/app/get_availability.php?appointment_type='.$appointment_type.'", function(response) {
			calendars = eval("(" + response + ")");
			dom.query(".date_input").next("span").hide();
			var appointment_name = dom.query("#'.$schedule_form.'_appointment_type").val();
			if (appointment_name != "") {
				dom.query(".date_input").show();
				ini_datepicker();
			} else {
				dom.query(".date_input").next("span").next("span").show();
			}
		});
	}
	function submit_schedule_request(form) {
		if (in_progress == false) {
			
			in_progress = true;
			dom.query("#'.$schedule_form.'_response").html("<span class=\"spinner\">Processing your request</span>").show();
			dom.query("#'.$schedule_form.'_form .error").remove();
			var values = "";
			dom.query("#'.$schedule_form.'_form").find(":input").each(function() {
				if (trim(this.name) != "" && this.name.search(/%/) == -1 && this.type != "checkbox" && this.type != "radio")
					values += "&"+this.name+"="+urlencode(this.value);
			});
			dom.query("#'.$schedule_form.'").find(":checkbox").each(function() {
				if (trim(this.name) != "" && this.name.search(/%/) == -1)
					values += (this.checked == true) ? "&"+this.name+"=1" : "&"+this.name+"=0";
			});
			dom.query("#'.$schedule_form.'").find(":radio").each(function() {
				if (trim(this.name) != "" && this.name.search(/%/) == -1 && document.getElementById(this.id).checked == true)
					values += "&"+this.name+"="+urlencode(this.value);							   
			});
			dom.query.post("app_path/app/submit_schedule_request.php", values, function(response) {
				in_progress = false;
				response = eval("(" + response +")");
				if (response["status"] == "success") {
					dom.query("#'.$schedule_form.'_response").html(response["msg"]);
					dom.query("#'.$schedule_form.'_form").find("input[type=text],textarea").each(function(ind,el) {
						dom.query(el).val("");
					});
				} else if (response["errors"] != undefined) {
					for (i in response["errors"]) {
						if (i == "general") {
							dom.query("#'.$schedule_form.'_response").html(response["errors"][i]);
						} else {
							dom.query("#'.$schedule_form.'_"+i).parent().append("<span class=\"error\">"+response["errors"][i]+"</span>");
							dom.query("#'.$schedule_form.'_"+i).click(function() { dom.query(this).find(".error").remove(); });
						}
					}
				}
				dom.query("#'.$schedule_form.'_response").show();
			});
		}
	}
	
	function reset_datepicker() {
		dom.query(".date_input").show();
		dom.query(".date_input").datepicker( "destroy" );
		dom.query(".date_input").removeClass("hasDatepicker");
		ini_datepicker();
	}
	
	function ini_datepicker() {
		
		dom.query(".date_input").next("span").next("span").hide();
		
		dom.query(".date_input").datepicker({
			
			beforeShowDay: function(date) {
				var d = js_date_to_mysql(date);
				var result = [false, "", null];
				
				var appointment_name = dom.query("#'.$schedule_form.'_appointment_type").val();
				var appointment_type = appointment_name;
				if (appointment_type.search(/service/i) != -1) {
					appointment_type = "Service";
				}
				var coach = dom.query("#'.$schedule_form.'_coach").val();
				
				// service calls
				if (appointment_type == "Service") {
					for (i in calendars) {
						if (calendars[i]["name"] == "Service") {
							if (calendars[i]["availability"][appointment_name] != undefined && calendars[i]["availability"][appointment_name][d] != undefined) {
								result = [true, "highlight", null];
							}
						}
					}
				// training
				} else {
					// any coach
					if (coach.search(/any coach/i) != -1) {
						for (i in calendars) {
							if (calendars[i]["name"] != "Service") {
								if (calendars[i]["availability"][appointment_name] != undefined && calendars[i]["availability"][appointment_name][d] != undefined) {
									result = [true, "highlight", null];
								}
							}
						}
					// specific coach
					} else {
						for (i in calendars) {
							if (calendars[i]["name"] == coach) {
								if (calendars[i]["availability"][appointment_name] != undefined && calendars[i]["availability"][appointment_name][d] != undefined) {
									result = [true, "highlight", null];
								}
							}
						}
					}
				}
				
				return result;
			},
			onSelect: function(dateText, obj) {
				
				if (dom.query("body").is("[data-menu-position]")) {
					dom.query(".date_input").prev("input").val(dateText);
				}
				
				var d = human_date_to_mysql(dateText);
				
				var appointment_name = dom.query("#'.$schedule_form.'_appointment_type").val();
				var appointment_type = appointment_name;
				if (appointment_type.search(/service/i) != -1) {
					appointment_type = "Service";
				}
				var coach = dom.query("#'.$schedule_form.'_coach").val();
				
				var times = \'<select name="appointment_time" id="'.$schedule_form.'_appointment_time" onchange="javascript:set_selected_coach(this);"><option value="">Select A Time</option>\';
				
				// service calls
				if (appointment_type == "Service") {
					for (i in calendars) {
						if (calendars[i]["name"] == "Service") {
							if (calendars[i]["availability"][appointment_name] != undefined && calendars[i]["availability"][appointment_name][d] != undefined) {
								for (j in calendars[i]["availability"][appointment_name][d]) {
									start_time = calendars[i]["availability"][appointment_name][d][j]["start_time"];
									end_time = calendars[i]["availability"][appointment_name][d][j]["end_time"];
									times += \'<option value="\'+start_time+\'" rel="\'+calendars[i]["name"]+\'">\'+display_time_span(start_time, end_time)+\'</option>\';
								}
							}
						}
					}
				// training
				} else {
					// any coach
					if (coach.search(/any coach/i) != -1) {
						var existing_times = Array();
						for (i in calendars) {
							if (calendars[i]["name"] != "Service") {
								if (calendars[i]["availability"][appointment_name] != undefined && calendars[i]["availability"][appointment_name][d] != undefined) {	
									for (j in calendars[i]["availability"][appointment_name][d]) {
										start_time = calendars[i]["availability"][appointment_name][d][j]["start_time"];
										end_time = calendars[i]["availability"][appointment_name][d][j]["end_time"];
										time_exists = false;
										for (u in existing_times) {
											if (existing_times[u] == start_time) {
												time_exists = true;
											}
										}
										if (time_exists == false) {
											times += \'<option value="\'+start_time+\'" rel="\'+calendars[i]["name"]+\'">\'+display_time_span(start_time, end_time)+\'</option>\';
											existing_times[existing_times.length] = start_time;
										} else {
											times = times.replace(\'<option value="\'+start_time+\'" rel="\', \'<option value="\'+start_time+\'" rel="\'+calendars[i]["name"]+\'|\');
										}
									}
								}
							}
						}
					// specific coach
					} else {
						for (i in calendars) {
							if (calendars[i]["name"] == coach) {
								if (calendars[i]["availability"][appointment_name] != undefined && calendars[i]["availability"][appointment_name][d] != undefined) {
									for (j in calendars[i]["availability"][appointment_name][d]) {
										start_time = calendars[i]["availability"][appointment_name][d][j]["start_time"];
										end_time = calendars[i]["availability"][appointment_name][d][j]["end_time"];
										times += \'<option value="\'+start_time+\'" rel="\'+calendars[i]["name"]+\'">\'+display_time_span(start_time, end_time)+\'</option>\';
									}
								}
							}
						}
					}
				}
				times += \'</select>\';
				
				dom.query("#'.$schedule_form.'_appointment").parent().find(".date_times").empty().append(times);
				
			}
		});
	}
	function js_date_to_mysql(d) {
		var month = d.getMonth()+1;
		var day = d.getDate();
		var output = d.getFullYear() + "-" +
		((""+month).length<2 ? "0" : "") + month + "-" +
		((""+day).length<2 ? "0" : "") + day;
		return output;
	}
	function human_date_to_mysql(d) {
		d = d.split("/");
		var output = d[2] + "-" +
		((""+d[0]).length<2 ? "0" : "") + d[0] + "-" +
		((""+d[1]).length<2 ? "0" : "") + d[1];
		return output;
	}
	function display_time(t) {
		var h = t.substr(0,2);
		var m = t.substr(3,2);
		var ampm = (Number(h) >= 12) ? "pm" : "am";
		h = (h.substr(0,1) == "0") ? h.substr(1) : h;
		h = (Number(h) > 12) ? h-12 : h;
		return h+":"+m+ampm;
	}
	function display_time_span(t1, t2) {
		t1 = display_time(t1);
		t2 = display_time(t2);
		//if ((t1.search(/am/) != -1 && t2.search(/am/) != -1) || (t1.search(/pm/) != -1 && t2.search(/pm/) != -1)) {
			//t1 = t1.replace("am","").replace("pm","");
		//}
		return t1+" - "+t2;
	}
	function set_selected_coach(obj) {
		var value = dom.query(obj).val();
		var coach_options = dom.query(obj).find("option[value="+value+"]").attr("rel").split("|");
		var rand = Math.floor(Math.random()*coach_options.length);
		var selected_coach = coach_options[rand];
		dom.query("#'.$schedule_form.'_selected_coach").val(selected_coach);
	}
	function urlencode( str ) {
		str = (str + "").toString();
		return encodeURIComponent(str).replace(/!/g, "%21").replace(/\'/g, "%27").replace(/\(/g, "%28").replace(/\)/g, "%29").replace(/\*/g, "%2A");//.replace(/%20/g, "+");
	}
	function trim(stringToTrim) {
		return stringToTrim.replace(/^\s+|\s+$/g,"");
	}
	</script>';
	
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('content-type: text/javascript; charset=utf-8');
	header("access-control-allow-origin: *");
	echo $callback.' ('.json_encode(array('html'=>$html)).')';
}

?>
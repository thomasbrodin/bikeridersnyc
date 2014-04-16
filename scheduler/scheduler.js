(function() {

// Localize jQuery variable
var jQuery;

/******** Load jQuery if not present *********/
if (window.jQuery === undefined || window.jQuery.fn.jquery !== '1.4.2') {
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src","//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
    if (script_tag.readyState) {
      script_tag.onreadystatechange = function () { // For old versions of IE
          if (this.readyState == 'complete' || this.readyState == 'loaded') {
              jqueryLoadHandler();
          }
      };
    } else {
      script_tag.onload = jqueryLoadHandler;
    }
    // Try to find the head, otherwise default to the documentElement
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
} else {
    // The jQuery version on the window is the one we want to use
    jQuery = window.jQuery;
    main();
}

/******** Called once jQuery has loaded ******/
function jqueryLoadHandler() {
    // Restore $ and window.jQuery to their previous values and store the
    // new jQuery in our local jQuery variable
    jQuery = window.jQuery.noConflict(true);
    // Call our main function
    main(); 
}

/******** Our main function ********/
function main() { 
    jQuery(document).ready(function($) {
		/******* Load HTML *******/
		var loc = String(window.location).split("?");
		var qs = (loc[1] != undefined) ? '/'+loc[1] : '';
		app_path = app_path || "scheduler";
		schedule_form = schedule_form || '';
		schedule_form_id = schedule_form_id || 'schedule_form';
        var jsonp_url = app_path+"/app/interface.php/"+schedule_form+qs+"/?callback=?";
		$.getJSON(jsonp_url, function(data) {
			data.html = data.html.replace(/app_path/g, app_path);
        	$('#'+schedule_form_id).html(data.html);
        });
    });
}

})(); // We call our anonymous function immediately
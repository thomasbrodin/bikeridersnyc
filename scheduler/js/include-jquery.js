(function() {

// Localize jQuery variable
var jQuery;
var load_count = 0;
var use_window_jquery = false;

/******** Load jQuery if not present *********/
if (window.jQuery === undefined || window.jQuery.fn.jquery !== '1.4.2') {
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src","//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
    if (script_tag.readyState) {
      script_tag.onreadystatechange = function () { // For old versions of IE
          if (this.readyState == 'complete' || this.readyState == 'loaded') {
              loadHandler();
          }
      };
    } else {
      script_tag.onload = loadHandler;
    }
	
    // Try to find the head, otherwise default to the documentElement
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
} else {
    // The jQuery version on the window is the one we want to use
	dom.query = window.jQuery;
	use_window_jquery = true;
    loadHandler();
}

/******* Load jQuery UI if not present *******/
function loadJQueryUI() {
	if (typeof window.jQuery.ui === 'undefined' || window.jQuery.ui.version !== '1.8.4') {
		var script_tag = document.createElement('script');
		script_tag.setAttribute("type","text/javascript");
		script_tag.setAttribute("src",app_path+"/js/jquery-ui-1.8.14-custom.min.js");
		if (script_tag.readyState) {
		  script_tag.onreadystatechange = function () { // For old versions of IE
			  if (this.readyState == 'complete' || this.readyState == 'loaded') {
				  loadHandler();
			  }
		  };
		} else {
		  script_tag.onload = loadHandler;
		}
		// Try to find the head, otherwise default to the documentElement
		(document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
	} else {
		loadHandler();
	}
}

/******** Called once jQuery has loaded ******/
function loadHandler() {
	load_count += 1;
	if (load_count == 1) {
		loadJQueryUI();
	} else if (load_count >= 2) {
		if (use_window_jquery == false) {
			// Restore $ and window.jQuery to their previous values and store the
			// new jQuery in our local jQuery variable
			dom.query = window.jQuery.noConflict(true);
		}
		// Call our main function
		main();
	}
}

/******** Our main function ********/
function main() {
    dom.query(document).ready(function($) {
		scheduler_ini();
    });
}

})(); // We call our anonymous function immediately
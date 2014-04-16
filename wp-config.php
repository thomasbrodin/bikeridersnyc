<?php
// ===================================================
// Load database info and local development parameters
// ===================================================
if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
	define( 'WP_LOCAL_DEV', true );
	include( dirname( __FILE__ ) . '/local-config.php' );
} else {
	define('DB_NAME', 'dev_wordpress_a');
	/** MySQL database username */
	define('DB_USER', 'wordpress_a');
	/** MySQL database password */
	define('DB_PASSWORD', 'E$9LviI0j4');
	/** MySQL hostname */
	define('DB_HOST', 'localhost:3306');
	
	define('FORCE_SSL_LOGIN', true);
	define('FORCE_SSL_ADMIN', true);
	if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') $_SERVER['HTTPS']='on';

	define( 'WP_AUTO_UPDATE_CORE', false );
}

// ========================
// Custom Content Directory
// ========================
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content' );

define( 'WP_PLUGIN_DIR', dirname(__FILE__) . '/content/plugins' );
define( 'WP_PLUGIN_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content/plugins' );

define( 'WPMU_PLUGIN_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content/mu-plugins' );

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
define('AUTH_KEY',         ';s-EC7[y8bK+#_na_G?}xM`KkF*kh)Gv4->Xc$R!_=SN?bO*b-Qye0GoOlA- aoe');
define('SECURE_AUTH_KEY',  '_||u*mT5t&qFK{gv8,qn/;~E$GMGQpMrpDpapgQ5F#mI7zfaH-K6}O! 5xOEm$X]');
define('LOGGED_IN_KEY',    '>IIMAeAuY$#_+HEwXQ!XOvrfrPT%(9!Irz.L]S,dnA9G|(:3uYbd#^RM&aNlda^Y');
define('NONCE_KEY',        'Z+{tl<0_8G:-H.0y2aD+T`Rjr;{0W,w]of8{^Cc~Bwg,tL-F BKPdT3EY@OI9cby');
define('AUTH_SALT',        ':$M%be-118@j+rUDAXRkO*KGf)/?`U|Bu91}G?K-F6wf-?RW_~}dvn2vFl`(=>]t');
define('SECURE_AUTH_SALT', 't$0)pWz[<7{Vn|gkmW pu!07F@;<|G|3C#%3>QECv=x+(.4k[,?&e~w|Py|n2p(v');
define('LOGGED_IN_SALT',   'Tun6nPX$%LsoAJ28{|w*B)+KdlpA$C@BRP)v7 ;shb,wN$UMtJf~IA#lF+TMq%=5');
define('NONCE_SALT',       ';}n`XQ-AWJ53cNZ(cIL3LXncBdK5C>n|HAgOGuGN=A?ErSR2/xu&qVZChVq00-n9');

// ==============================================================
// Table prefix
// Change this if you have multiple installs in the same database
// ==============================================================
$table_prefix  = 'wp_';

// ================================
// Language
// Leave blank for American English
// ================================
define('WPLANG', '');

// ===========
// Hide errors
// ===========
ini_set( 'display_errors', 0 );
define( 'WP_DEBUG_DISPLAY', false );

// ===================
// Bootstrap WordPress
// ===================
if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
require_once( ABSPATH . 'wp-settings.php' );

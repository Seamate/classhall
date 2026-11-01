<?php
define( 'ABSPATH', dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR );
define( 'CLASSHALL_LIVE_PLUGIN_DIR', dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
define( 'CLASSHALL_LIVE_DB_VERSION', '0.1.0' );
define( 'CLASSHALL_LIVE_VERSION', '0.1.0' );

require_once CLASSHALL_LIVE_PLUGIN_DIR . 'src/Support/Autoloader.php';
Classhall\LiveClasses\Support\Autoloader::register();


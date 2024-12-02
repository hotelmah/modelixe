<?php

namespace ModeliXe;

// General configuration of ModeliXe

// Changed from xml to classical
define('MX_FLAGS_TYPE', 'classical'); // Specifies the default template writing mode (xml or pear).

/* ===================================================================================================================== */
define('MX_OUTPUT_TYPE', 'html'); // Specifies the type of output markup.
define('MX_TEMPLATE_PATH', ''); // Specify the hard template directory. Leave blank to allow multi app use. Add to paramater in constructor
define('MX_DEFAULT_PARAMETER', ''); // Specifies a default settings file.
define('MX_CACHE_PATH', ''); // Specify the cache directory. Setting to empty no longer writes the directory.
define('MX_CACHE_DELAY', 60 * 60 * 24 * 10); // Sets the cache renewal timeout in seconds.
define('MX_SIGNATURE', 'off'); // Leaves the ModeliXe signature in the generated HTML page (on or off).
define('MX_COMPRESS', 'off'); // Enables page compression if the browser supports it (on or off).
define('MX_REWRITEURL', 'off'); // Use mod_rewrite to create the urls (on or off).
define('MX_PERFORMANCE_TRACER', 'off'); // Specifies whether to implement performance timing (on or off).
/* ===================================================================================================================== */

// Configuring Error Handling
define('ERROR_MANAGER_SYSTEM', true); // Errors are reported for on, ignored for off.
define('ERROR_MANAGER_LEVEL', '2'); // Specifies the level of error tolerated, the lower it is, the less errors are tolerated.
define('ERROR_MANAGER_ESCAPE', 'html/erreur.html'); // Allows you to specify a local replacement URL in case of errors.
define('ERROR_MANAGER_LOG', 'data/erreur.txt'); // Allows you to define a log file.
define('ERROR_MANAGER_ALARME', 'kevin@kevinp.net'); // Allows you to define a series of email addresses to which an alert email will be sent.

/* ===================================================================================================================== */
define('MX_GENERAL_PATH', '');
define('MX_ERROR_PATH', '');
/* ===================================================================================================================== */

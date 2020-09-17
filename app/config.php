<?php

/**
 * PHP setting
 */
ini_set("display_errors", true);
ini_set("error_reporting", E_ALL ^ E_DEPRECATED ^ E_NOTICE);
ini_set('memory_limit', '1024M');

/**
 * Absolute directory settings
 */

define('_ROOT_DIR', __DIR__ . '/../');
define('_APP_DIR', _ROOT_DIR . 'app/');
define('_PUBLIC_DIR', _ROOT_DIR . 'public/');
define('_VENDOR_DIR', _ROOT_DIR . 'vendor/');
define('_TEMPLATE_DIR', _ROOT_DIR . 'public/templates/');

/**
 * Url
 */
define('_SITE_URL', 'https://goat.local/p/hjson2propel/');

/**
 * Routes part of URL considered as root, rebase
 */
define('_SUB_DIR', 'p/hjson2propel/');

/**
 * Session name
 */

define('_SESSION_NAME', 'osHa1WJ1QQ');

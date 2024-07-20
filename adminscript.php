<?php
/**
 * Plugin Name: Adminscript
 * Plugin URI: https://www.nilambar.net/adminscript.
 * Description: WordPress plugin to add Javascript in the admin panel.
 * Version: 1.0.2
 * Requires at least: 6.6
 * Requires PHP: 7.2
 * Author: Nilambar Sharma
 * Author URI: https://www.nilambar.net/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: adminscript
 * Domain Path: /languages
 *
 * @package Adminscript
 */

namespace Nilambar\Adminscript;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ADMINSCRIPT_VERSION', '1.0.2' );
define( 'ADMINSCRIPT_SLUG', 'adminscript' );
define( 'ADMINSCRIPT_BASE_NAME', basename( __DIR__ ) );
define( 'ADMINSCRIPT_BASE_FILEPATH', __FILE__ );
define( 'ADMINSCRIPT_BASE_FILENAME', plugin_basename( __FILE__ ) );
define( 'ADMINSCRIPT_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'ADMINSCRIPT_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

// Include autoload.
if ( file_exists( ADMINSCRIPT_DIR . '/vendor/autoload.php' ) ) {
	require_once ADMINSCRIPT_DIR . '/vendor/autoload.php';
}

if ( class_exists( 'Nilambar\Adminscript\Init' ) ) {
	Init::register_services();
}

$adminscript_update_checker = PucFactory::buildUpdateChecker( 'https://github.com/ernilambar/adminscript', __FILE__, ADMINSCRIPT_SLUG );
$adminscript_update_checker->getVcsApi()->enableReleaseAssets();

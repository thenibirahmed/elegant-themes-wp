<?php
/**
 * Plugin Name:       Elegant Themes
 * Plugin URI:        https://nibirahmed.com
 * Description:       Handle ajax and create users.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nibir Ahmed
 * Author URI:        https://nibirahmed.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://nibirahmed.com
 * Text Domain:       nibir
 * Domain Path:       /languages
 */

use ElegantThemes\Admin;
use ElegantThemes\Admin\Installer;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . "/vendor/autoload.php";

/**
 *
 * Main Plugin Class
 *
 */
final class ElegantThemes {
    /**
     * Plugin Version
     */
    const version = '1.0.0';

    /**
     * Constructor
     *
     * @return void
     */
    private function __construct() {

        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'activate'] );

        add_action( 'plugins_loaded', [$this, 'init_plugin'] );        
    }

    /**
     * Initializes the plugin
     *
     * @return void
     */
    public function init_plugin() {

        if ( is_admin() ) {
            new Admin();
        }

    }

    /**
     * Initializing the plugin singleton instance
     *
     * @return \ElegantThemes
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Defining Constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'ElegantThemes_VERSION', self::version );
        define( 'ElegantThemes_FILE', __FILE__ );
        define( 'ElegantThemes_PATH', __DIR__ );
        define( 'ElegantThemes_URL', plugins_url( '', ElegantThemes_FILE ) );
        define( 'ElegantThemes_ASSETS', ElegantThemes_URL . '/assets' );
        define( 'CE_TD', 'nibir' );
    }

    /**
     * Do things while activating the plugin
     *
     * @return void
     */
    public function activate() {
        $installer = new Installer();

        $installer->add_version();
    }

}

/**
 * Run the plugin
 *
 * @return void
 */
function ElegantThemes() {
    return ElegantThemes::init();
}

// Kick start the plugin
ElegantThemes();

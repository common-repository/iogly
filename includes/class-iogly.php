<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link https://iogly.com
 * @since 1.0.0
 *
 * @package Iogly
 * @subpackage Iogly/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 1.0.0
 * @package Iogly
 * @subpackage Iogly/includes
 * @author Your Name <info@iogly.com>
 */
class Iogly
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since 1.0.0
     * @access protected
     * @var Iogly_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since 1.0.0
     * @access protected
     * @var string $iogly The string used to uniquely identify this plugin.
     */
    protected $iogly;

    /**
     * The current version of the plugin.
     *
     * @since 1.0.0
     * @access protected
     * @var string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if (defined('IOGLY_VERSION')) {
            $this->version = IOGLY_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->iogly = 'iogly';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_plugin_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Iogly_Loader. Orchestrates the hooks of the plugin.
     * - Iogly_i18n. Defines internationalization functionality.
     * - Iogly_Admin. Defines all hooks for the admin area.
     * - Iogly_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since 1.0.0
     * @access private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'includes/class-iogly-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'includes/class-iogly-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'admin/class-iogly-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'public/class-iogly-public.php';

        /**
         * The class responsible for defining all actions that are not just scaffold
         * but actual plugin code.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'plugin/class-iogly-plugin.php';

        $this->loader = new Iogly_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Iogly_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since 1.0.0
     * @access private
     */
    private function set_locale()
    {
        $plugin_i18n = new Iogly_i18n();

        $this->loader->add_action(
            'plugins_loaded',
            $plugin_i18n,
            'load_plugin_textdomain'
        );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since 1.0.0
     * @access private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Iogly_Admin(
            $this->get_iogly(),
            $this->get_version()
        );

        $this->loader->add_action(
            'admin_enqueue_scripts',
            $plugin_admin,
            'enqueue_styles'
        );
        $this->loader->add_action(
            'admin_enqueue_scripts',
            $plugin_admin,
            'enqueue_scripts'
        );

        $this->loader->add_action('init', $plugin_admin, 'init');
        $this->loader->add_action('admin_menu', $plugin_admin, 'menu');
        $this->loader->add_action('admin_notices', $plugin_admin, 'display_notice');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since 1.0.0
     * @access private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Iogly_Public(
            $this->get_iogly(),
            $this->get_version()
        );

        $this->loader->add_action(
            'wp_enqueue_scripts',
            $plugin_public,
            'enqueue_styles'
        );
        $this->loader->add_action(
            'wp_enqueue_scripts',
            $plugin_public,
            'enqueue_scripts'
        );
    }

    /**
     * Register all of the hooks related to actual plugin functionality
     * of the plugin.
     *
     * @since 1.0.0
     * @access private
     */
    private function define_plugin_hooks()
    {
        $plugin = new Iogly_Plugin(
            $this->get_iogly(),
            $this->get_version()
        );

        $this->loader->add_action(
            'pre_auto_update',
            $plugin,
            'enable_deploy_mode'
        );
        $this->loader->add_action(
            'automatic_updates_complete',
            $plugin,
            'disable_deploy_mode'
        );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since 1.0.0
     * @return string The name of the plugin.
     */
    public function get_iogly()
    {
        return $this->iogly;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since 1.0.0
     * @return Iogly_Loader Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since 1.0.0
     * @return string The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
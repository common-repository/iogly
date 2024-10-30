<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link https://iogly.com
 * @since 1.0.0
 *
 * @package Iogly
 * @subpackage Iogly/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package Iogly
 * @subpackage Iogly/admin
 * @author Your Name <info@iogly.com>
 */
class Iogly_Admin
{
    const NONCE = 'iogly';

    private $notices = [];

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $iogly    The ID of this plugin.
     */
    private $iogly;


    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;


    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->iogly = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->iogly,
            plugin_dir_url(__FILE__) . 'css/iogly-admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->iogly,
            plugin_dir_url(__FILE__) . 'js/iogly-admin.js',
            array('jquery'),
            $this->version,
            false
        );
    }

    /**
     * Handle post actions.
     *
     * @since    1.0.0
     */
    public function init()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'save-settings') {
            $this->settings_save();
        }
    }

    /**
     * Add menu items.
     *
     * @since    1.0.0
     */
    public function menu()
    {
        add_options_page(
            __('Iogly', 'iogly'),
            __('Iogly', 'iogly'),
            'manage_options',
            'iogly',
            array($this, 'settings_view')
        );
    }

    /**
     * Render admin settings page.
     *
     * @since    1.0.0
     */
    public function settings_view()
    {
        include('partials/iogly-admin-display.php');
    }

    /**
     * Handle admin settings save.
     *
     * @since    1.0.0
     */
    public function settings_save()
    {
        if (!current_user_can( 'manage_options')) {
            die(__('No...no.', 'iogly'));
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], self::NONCE)) {
            return false;
        }

        foreach (array('iogly_api_key') as $option ) {
            update_option($option, sanitize_text_field($_POST[$option]));
        }


        $this->add_notice('success', 'Settings successfully saved.');
    }

    /**
     * Display flash messages.
     *
     * @since    1.0.0
     */
    public function display_notice()
    {
        foreach ($this->notices as $notice) {
            printf(
                '<div class="notice notice-%s"><p>%s</p></div>',
                $notice['status'],
                esc_html($notice['message'], 'iogly')
            );
        }

        $this->notices = array();
    }

    /**
     * Add flash messages.
     *
     * @param      string    $satus     Message severity.
     * @param      string    $message   Message to display.
     *
     * @since    1.0.0
     */
    private function add_notice($status, $message)
    {
        $this->notices[] = array(
            'status' => $status,
            'message' => $message,
        );
    }
}

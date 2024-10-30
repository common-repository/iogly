<?php

/**
 * The non-scaffolding functionality of the plugin.
 *
 * @link https://iogly.com
 * @since 1.0.0
 *
 * @package Iogly
 * @subpackage Iogly/admin
 */

/**
 * @package Iogly
 * @subpackage Iogly/plugin
 * @author Your Name <info@iogly.com>
 */
class Iogly_Plugin
{
    private $iogly;
    private $version;

    const API_HOST = "api.iogly.com";

    public function __construct($plugin_name, $version)
    {
        $this->iogly = $plugin_name;
        $this->version = $version;
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return string The name of the plugin.
     *
     * @since 1.0.0
     */
    public function get_iogly()
    {
        return $this->iogly;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return string The version number of the plugin.
     *
     * @since 1.0.0
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Enable instance deploy mode
     *
     * @return string The version number of the plugin.
     *
     * @since 1.0.0
     */
    public function enable_deploy_mode()
    {
        $data = new stdClass;
        $data->deploymode = true;
        $this->api_request('deploy', 'PUT', $data);
    }

    /**
     * Disable instance deploy mode
     *
     * @return string The version number of the plugin.
     *
     * @since 1.0.0
     */
    public function disable_deploy_mode()
    {
        $data = new stdClass;
        $data->deploymode = false;
        $this->api_request('deploy', 'PUT', $data);
    }

    /**
     * Retrieve the api key for connecting to the Iogly API.
     *
     * @return string The version number of the plugin.
     *
     * @since 1.0.0
     */
    private function get_api_key()
    {
        return get_option('iogly_api_key');
    }

    /**
     * Perform an API request to the Iogly API.
     *
     * @param string $path REST path.
     * @param string $method REST request method.
     * @param mixed $data REST body.
     *
     * @return string The version number of the plugin.
     *
     * @since 1.0.0
     */
    private function api_request($path, $method, $data = null)
    {
        if (!is_null($data)) {
            $data = json_encode($data);
        }

        $contentType = sprintf(
            'application/x-www-form-urlencoded; charset=%s',
            get_option('blog_charset')
        );

        $host = self::API_HOST;

        $userAgent = sprintf(
            'WordPress Iogly Plugin/%s, %s',
            $GLOBALS['wp_version'],
            $this->get_version()
        );

        $args = array(
            'body' => $data,
            'method' => $method,
            'headers' => array(
                'Content-Type' => $contentType,
                'Host' => $host,
                'User-Agent' => $userAgent,
                'Authorization' => 'Bearer ' . $this->get_api_key(),
            ),
            'httpversion' => '1.0',
            'timeout' => 15,
        );

        $url = "https://{$host}/{$path}";

        $http = new WP_Http();
        $response = $http->request($url, $args);

        if (is_wp_error($response)) {
            return array();
        }

        return $response;
    }
}

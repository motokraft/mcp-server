<?php

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use \Motokraft\MCPServer\Container\WebContainer;

/**
 * Check for the minimum required PHP version.
 * If the requirement is not met, send a 500 HTTP status code and terminate the application.
 */
if (version_compare(PHP_VERSION, '8.1.0', '<'))
{
    header('HTTP/1.1 500 The application cannot be loaded');
    exit('The framework requires PHP version 8.1.0 or higher. Current version: ' . PHP_VERSION);
}

/**
 * Application start timestamp in seconds with microseconds.
 */
define('START_TIME', microtime(true));

/**
 * Memory usage in bytes at the start of the application.
 */
define('START_MEMORY', memory_get_usage());

/**
 * Absolute path to the application root directory.
 */
define('ROOT_PATH', __DIR__);

/**
 * Directory separator (platform-independent).
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Path to the application log files directory.
 */
define('LOG_PATH', ROOT_PATH . DS . '.logs');

/**
 * Path to the application log files directory.
 */
define('COMPOSER_PATH', ROOT_PATH . DS . '.composer');

/**
 * Path to the external libraries or system modules directory.
 */
define('VENDOR_PATH', ROOT_PATH . DS . 'vendor');

/**
 * Includes the custom class autoloader of the framework.
 */
require_once COMPOSER_PATH . DS . 'autoload.php';

/**
 * Includes the custom class autoloader of the framework.
 */
require_once VENDOR_PATH . DS . 'autoload.php';

/**
 * Creates and initializes the application environment
 */
$Environment = \ClassLoader::CreateEnvironmentBuilder();

/**
 * Builds and returns the application container.
 */
$Container = $Environment->MainBuild(WebContainer::class);

/**
 * Executes the application and sends the response to output.
 */
$Container->ExecuteResponse();
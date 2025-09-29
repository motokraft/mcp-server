<?php namespace Motokraft\MCPServer\Exception\Container;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

class MissingServiceProviderException extends \Exception
{
    /**
     * The route that is currently being used in the application
     *
     * @var string
     */
    private ?string $_Name = null;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Name Current application class
     *
     * @return void
     */
    function __construct(string $Name)
    {
        $this->_Name = $Name;

        parent::__construct(sprintf(
            t('system.exception.container.serviceprovider.missing'), $Name
        ), 404);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetName() : ?string
    {
        return $this->_Name;
    }
}
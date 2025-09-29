<?php namespace Motokraft\MCPServer\Interfaces\Providers;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;

interface IServiceProvider
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param IContainerBuilder $Container Current application class
     * @param string $Name Current application class
     *
     * @return void
     */
    function Register(IContainerBuilder $Container, string $Name) : void;
}
<?php namespace Motokraft\MCPServer\Interfaces\Container;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Environment\IEnvironmentBuilder;

interface IContainerBuilder
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Name Log settings array
     * @param object $ServiceObject Log settings array
     *
     * @return object
     */
    function Singleton(string $Name, object $ServiceObject) : void;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Name Log settings array
     *
     * @return object
     */
    function Get(string $Name) : object;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Name Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function Remove(string $Name) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Name Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function ContainsService(string $Name) : bool;
}
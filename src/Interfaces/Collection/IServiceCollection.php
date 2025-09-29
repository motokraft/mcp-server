<?php namespace Motokraft\MCPServer\Interfaces\Collection;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Generic\ICollection;

interface IServiceCollection extends ICollection
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Name Log settings array
     * @param object $Value Log settings array
     *
     * @return void
     */
    function Add(string $Name, object $Value) : void;
}
<?php namespace Motokraft\MCPServer\Interfaces\Collection;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Generic\ICollection;
use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;

interface IContainerCollection extends ICollection
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param IContainerBuilder $Value Log settings array
     *
     * @return void
     */
    function Add(IContainerBuilder $Value) : void;
}
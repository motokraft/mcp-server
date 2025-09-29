<?php namespace Motokraft\MCPServer\Interfaces\Collection;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Generic\ICollection;
use Motokraft\MCPServer\Interfaces\Collection\IFilteredCollection;
use Motokraft\MCPServer\Interfaces\Attribute\IAttributeBuilder;

interface IAttributeCollection extends ICollection
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param IAttributeBuilder $Value Log settings array
     *
     * @return void
     */
    function Append(IAttributeBuilder $Value) : void;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return IFilteredCollection
     */
    function GetFilteredCollection() : IFilteredCollection;
}
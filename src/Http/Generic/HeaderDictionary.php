<?php namespace Motokraft\MCPServer\Http\Generic;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Http\IHeaderDictionary;
use Motokraft\MCPServer\Traits\Generic\DictionaryTrait;

class HeaderDictionary implements IHeaderDictionary, \IteratorAggregate
{
    /**
     * Contains an array of default settings.
     */
    use DictionaryTrait;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return \Traversable
     */
    function GetIterator() : \Traversable
    {
        return new \ArrayIterator($this->GetProperties());
    }
}
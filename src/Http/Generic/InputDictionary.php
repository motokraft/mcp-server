<?php namespace Motokraft\MCPServer\Http\Generic;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Generic\IDictionary;
use Motokraft\MCPServer\Interfaces\Http\IInputDictionary;
use Motokraft\MCPServer\Traits\Generic\DictionaryTrait;

class InputDictionary implements IDictionary, IInputDictionary, \ArrayAccess, \IteratorAggregate
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
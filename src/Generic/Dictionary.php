<?php namespace Motokraft\MCPServer\Generic;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Generic\IDictionary;
use Motokraft\MCPServer\Traits\Generic\DictionaryTrait;

class Dictionary implements IDictionary, \ArrayAccess, \IteratorAggregate
{
    /**
     * Contains an array of default settings.
     */
    use DictionaryTrait;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param mixed $Data Log settings array
     *
     * @return void
     */
    function __construct(mixed $Data = [])
    {
        if(is_array($Data))
        {
            $this->LoadedArray($Data);
        }
        else if(is_string($Data))
        {
            $this->LoadedString($Data);
        }
        else if($Data instanceof \stdClass)
        {
            $this->LoadedObject($Data);
        }
        else if($Data instanceof Dictionary)
        {
            $this->LoadedObject($Data);
        }
    }

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
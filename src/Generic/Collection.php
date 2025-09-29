<?php namespace Motokraft\MCPServer\Generic;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Generic\ICollection;
use Motokraft\MCPServer\Traits\Generic\CollectionTrait;

class Collection implements ICollection, \ArrayAccess, \IteratorAggregate
{
    /**
     * Contains an array of default settings.
     */
    use CollectionTrait;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param \Traversable|ICollection|array $Items Log settings array
     * @param bool $Preserve Log settings array
     *
     * @return void
     */
    function __construct(\Traversable|ICollection|array $Items = [], bool $Preserve = false)
    {
        if($Items instanceof \Traversable)
        {
            $this->AppendIterator($Items, $Preserve);
        }
        else if($Items instanceof ICollection)
        {
            $this->AppendCollection($Items, $Preserve);
        }
        else
        {
            foreach($Items as $key => $item)
            {
                $this->Add($key, $item);
            }
        }
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return \Traversable
     */
    function GetIterator() : \Traversable
    {
        return new \ArrayIterator($this->_Items);
    }
}
<?php namespace Motokraft\MCPServer\Collection;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Collection\IContainerCollection;
use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;
use Motokraft\MCPServer\Traits\Generic\CollectionTrait;

class ContainerCollection implements IContainerCollection, \IteratorAggregate
{
    /**
     * Contains an array of default settings.
     */
    use CollectionTrait {
        CollectionTrait::Add as AddTrait;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param IContainerBuilder $Value Log settings array
     *
     * @return void
     */
    function Add(IContainerBuilder $Value) : void
    {
        $this->AddTrait(get_class($Value), $Value);
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
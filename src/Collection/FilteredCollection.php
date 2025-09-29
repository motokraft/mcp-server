<?php namespace Motokraft\MCPServer\Collection;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Collection\IFilteredCollection;
use Motokraft\MCPServer\Interfaces\Generic\ICollection;
use Motokraft\MCPServer\Traits\Generic\FilteredCollectionTrait;

class FilteredCollection implements IFilteredCollection, \IteratorAggregate
{
    /**
     * Creates a new instance of the AbstractLogging class
     */
    use FilteredCollectionTrait;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param ICollection $Collection Log settings array
     *
     * @return void
     */
    function __construct(ICollection $Collection)
    {
        $this->_Items = $Collection->GetArray();
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function FilterName(string $Value) : void
    {
        $this->Filter(fn($Attribute) => $Attribute->HasName($Value));
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function FilterInstance(string $Value) : void
    {
        $this->Filter(fn($Attribute) => $Attribute->HasInstance($Value));
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function FilterClass(string $Value) : void
    {
        $this->Filter(fn($Attribute) => $Attribute->HasClass($Value));
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function FilterClassA(string $Value) : void
    {
        $this->Filter(fn($Attribute) => $Attribute->HasClassA($Value));
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function FilterTarget(string $Value) : void
    {
        $this->Filter(fn($Attribute) => $Attribute->HasTarget($Value));
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function FilterTargetA(string $Value) : void
    {
        $this->Filter(fn($Attribute) => $Attribute->HasTargetA($Value));
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
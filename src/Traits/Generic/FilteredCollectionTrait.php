<?php namespace Motokraft\MCPServer\Traits\Generic;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Exception\InvalidCallbackException;
use Motokraft\MCPServer\Interfaces\Generic\ICollection;
use Motokraft\MCPServer\Generic\Collection;

trait FilteredCollectionTrait
{
    /**
     * Internal storage for collection items
     *
     * @var array<mixed, mixed>
     */
    private array $_Items = [];

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param mixed $Key Log settings array
     * @param mixed $Default Log settings array
     *
     * @return mixed
     */
    function Get(mixed $Key, mixed $Default = null) : mixed
    {
        if(!$this->ContainsKey($Key))
        {
            return $Default;
        }

        return $this->_Items[$Key];
    }

    /**
     * Checks if the collection contains a specific key
     *
     * @param mixed $Key Key to check
     *
     * @return bool true if key exists
     * @return bool false if key does not exist
     */
    function ContainsKey(mixed $Key) : bool
    {
        return array_key_exists($Key, $this->_Items);
    }

    /**
     * Checks if the collection contains a specific value
     *
     * @param mixed $Value Value to check
     *
     * @return bool true if value exists
     * @return bool false if value does not exist
     */
    function ContainsValue(mixed $Value) : bool
    {
        return in_array($Value, $this->_Items);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return bool true
     * @return bool false
     */
    function IsEmptyCollection() : bool
    {
        return ($this->GetCount() < 1);
    }

    /**
     * Maps each value using a callback and returns a new collection
     *
     * @return ICollection Collection of mapped values
     */
    function GetCollection() : ICollection
    {
        return new Collection($this->_Items);
    }

    /**
     * Maps each value using a callback and returns a new collection
     *
     * @param callable $Callback Function to apply to each value
     *
     * @return ICollection Collection of mapped values
     *
     * @throws InvalidCallbackException If callback is not callable
     */
    function Map(callable $Callback) : ICollection
    {
        if(!is_callable($Callback))
        {
            throw new InvalidCallbackException($Callback);
        }

        $Result = new Collection;

        foreach($this->_Items as $Key => $Item)
        {
            $Result->Add($Key, $Callback($Item, $Key));
        }

        return $Result;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param callable $Callback Current application class
     *
     * @return void
     */
    function Each(callable $Callback) : void
    {
        if(!is_callable($Callback))
        {
            throw new InvalidCallbackException($Callback);
        }

        foreach($this->_Items as $Key => $Item)
        {
            $Callback($Item, $Key);
        }
    }

    /**
     * Filters the collection using a callback and returns a new collection
     *
     * @param callable $Callback Function to determine if an item should be included
     *
     * @return void
     *
     * @throws InvalidCallbackException If callback is not callable
     */
    function Filter(callable $Callback) : void
    {
        if(!is_callable($Callback))
        {
            throw new InvalidCallbackException($Callback);
        }

        foreach($this->_Items as $Key => $Item)
        {
            if($Callback($Item, $Key)) continue;

            unset($this->_Items[$Key]);
        }

        $this->_Items = array_values($this->_Items);
    }

    /**
     * Sorts items in the collection using a callback
     *
     * @param callable $Callback Comparison function
     *
     * @return void The function does not return anything after execution
     */
    function Usort(callable $Callback) : void
    {
        usort($this->_Items, $Callback);
    }

    /**
     * Returns the first value in the collection
     *
     * @return mixed The first value or false if collection is empty
     */
    function GetFirstValue() : mixed
    {
        if($this->IsEmptyCollection())
        {
            return false;
        }

        return reset($this->_Items);
    }

    /**
     * Returns the number of items in the collection
     *
     * @return int Number of items
     */
	function GetCount() : int
    {
        return count($this->_Items);
    }
}
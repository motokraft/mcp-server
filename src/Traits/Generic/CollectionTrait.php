<?php namespace Motokraft\MCPServer\Traits\Generic;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Generic\ICollection;
use Motokraft\MCPServer\Exception\InvalidCallbackException;
use Motokraft\MCPServer\Generic\Collection;

trait CollectionTrait
{
    /**
     * Internal storage for collection items
     *
     * @var array<mixed, mixed>
     */
    private array $_Items = [];

    /**
     * Appends a collection into the current collection
     *
     * @param ICollection $Collection Collection to be appended
     * @param bool $Preserve Preserve original keys if true
     *
     * @return void The function does not return anything after execution
     */
    function AppendCollection(ICollection $Collection, bool $Preserve = false) : void
    {
        foreach($Collection as $Key => $Value)
        {
            if($Preserve)
            {
                $this->Add($Key, $Value);
            }
            else
            {
                $this->Append($Value);
            }
        }
    }

    /**
     * Appends an iterator into the current collection
     *
     * @param \Traversable $Iterator Iterator to be appended
     * @param bool $Preserve Preserve original keys if true
     *
     * @return void The function does not return anything after execution
     */
    function AppendIterator(\Traversable $Iterator, bool $Preserve = false) : void
    {
        foreach($Iterator as $Key => $Value)
        {
            if($Preserve)
            {
                $this->Add($Key, $Value);
            }
            else
            {
                $this->Append($Value);
            }
        }
    }

    /**
     * Appends a value to the end of the collection
     *
     * @param mixed $Value Value to be appended
     *
     * @return void The function does not return anything after execution
     */
    function Append(mixed $Value) : void
    {
        $this->Add($this->GetCount(), $Value);
    }

    /**
     * Adds a key-value pair into the collection
     *
     * @param mixed $Key Key for the value
     * @param mixed $Value Value to be stored
     *
     * @return void The function does not return anything after execution
     */
    function Add(mixed $Key, mixed $Value) : void
    {
        $this->_Items[$Key] = $Value;
    }

    /**
     * Retrieves a value by key or returns a default value if the key is not found
     *
     * @param mixed $Key Key to search for
     * @param mixed $Default Default value if key is missing
     *
     * @return mixed The value associated with the key or the default value
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
     * Removes a key from the collection
     *
     * @param mixed $Key Key to remove
     *
     * @return bool true if the key existed and was removed
     * @return bool false if the key does not exist
     */
    function Remove(mixed $Key) : bool
    {
        if(!$this->ContainsKey($Key))
        {
            return false;
        }

        unset($this->_Items[$Key]);
        return true;
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
     * Returns the internal array of items
     *
     * @return array Array of all items
     */
    function GetArray() : array
    {
        return $this->_Items;
    }

    /**
     * Clears all items from the collection
     *
     * @return void The function does not return anything after execution
     */
    function Clear() : void
    {
        $this->_Items = [];
    }

    /**
     * Checks if the collection is empty
     *
     * @return bool true if collection is empty
     * @return bool false if collection contains items
     */
    function IsEmptyCollection() : bool
    {
        return ($this->GetCount() < 1);
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
     * Maps each key using a callback and returns a new collection
     *
     * @param callable $Callback Function to apply to each key
     *
     * @return ICollection Collection with mapped keys
     *
     * @throws InvalidCallbackException If callback is not callable
     */
    function MapKey(callable $Callback) : ICollection
    {
        if(!is_callable($Callback))
        {
            throw new InvalidCallbackException($Callback);
        }

        $Result = new Collection;

        foreach($this->_Items as $Key => $Item)
        {
            $Result->Add($Callback($Item, $Key), $Item);
        }

        return $Result;
    }

    /**
     * Filters the collection using a callback and returns a new collection
     *
     * @param callable $Callback Function to determine if an item should be included
     *
     * @return ICollection Filtered collection
     *
     * @throws InvalidCallbackException If callback is not callable
     */
    function Filter(callable $Callback) : ICollection
    {
        if(!is_callable($Callback))
        {
            throw new InvalidCallbackException($Callback);
        }

        $Result = new Collection;

        foreach($this->_Items as $Key => $Item)
        {
            if(!$Callback($Item, $Key))
            {
                continue;
            }

            $Result->Add($Key, $Item);
        }

        return $Result;
    }

    /**
     * Applies a callback to each item in the collection
     *
     * @param callable $Callback Function to execute on each item
     *
     * @return void The function does not return anything after execution
     *
     * @throws InvalidCallbackException If callback is not callable
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
     * Sorts items in the collection using a callback
     *
     * @param callable $Callback Comparison function
     *
     * @return void The function does not return anything after execution
     *
     * @throws InvalidCallbackException If callback is not callable
     */
    function Usort(callable $Callback) : void
    {
        if(!is_callable($Callback))
        {
            throw new InvalidCallbackException($Callback);
        }

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

    /**
     * Returns a new collection instance containing all current items
     *
     * @return Collection Collection containing all items
     */
    function GetCollection() : Collection
    {
        return new Collection($this->_Items);
    }

    /**
     * Returns a RecursiveArrayIterator for the internal array
     *
     * @return \RecursiveArrayIterator Recursive array iterator
     */
	function GetRecursiveArrayIterator() : \RecursiveArrayIterator
    {
        return new \RecursiveArrayIterator($this->_Items);
    }

    /**
     * Checks if a key exists (ArrayAccess support)
     *
     * @param mixed $Key Key to check
     *
     * @return bool true if key exists
     * @return bool false if key does not exist
     */
    function OffsetExists(mixed $Key) : bool
    {
        return $this->ContainsKey($Key);
    }

    /**
     * Retrieves a value by key (ArrayAccess support)
     *
     * @param mixed $Key Key to retrieve
     *
     * @return mixed The value associated with the key
     */
    function OffsetGet(mixed $Key) : mixed
    {
        return $this->Get($Key);
    }

    /**
     * Sets a value for a key (ArrayAccess support)
     *
     * @param mixed $Key Key to set
     * @param mixed $Value Value to associate
     *
     * @return void The function does not return anything after execution
     */
    function OffsetSet(mixed $Key, mixed $Value) : void
    {
        $this->Add($Key, $Value);
    }

    /**
     * Unsets a key (ArrayAccess support)
     *
     * @param mixed $Key Key to unset
     *
     * @return void The function does not return anything after execution
     */
    function OffsetUnset(mixed $Key) : void
    {
        if($this->ContainsKey($Key)) $this->Remove($Key);
    }
}
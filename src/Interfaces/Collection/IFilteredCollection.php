<?php namespace Motokraft\MCPServer\Interfaces\Collection;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Generic\ICollection;

interface IFilteredCollection
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param mixed $Key Log settings array
     * @param mixed $Default Log settings array
     *
     * @return mixed
     */
    function Get(mixed $Key, mixed $Default = null) : mixed;

    /**
     * Checks if the collection contains a specific key
     *
     * @param mixed $Key Key to check
     *
     * @return bool true if key exists
     * @return bool false if key does not exist
     */
    function ContainsKey(mixed $Key) : bool;

    /**
     * Checks if the collection contains a specific value
     *
     * @param mixed $Value Value to check
     *
     * @return bool true if value exists
     * @return bool false if value does not exist
     */
    function ContainsValue(mixed $Value) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return bool true
     * @return bool false
     */
    function IsEmptyCollection() : bool;

    /**
     * Maps each value using a callback and returns a new collection
     *
     * @return ICollection Collection of mapped values
     */
    function GetCollection() : ICollection;

    /**
     * Maps each value using a callback and returns a new collection
     *
     * @param callable $Callback Function to apply to each value
     *
     * @return ICollection Collection of mapped values
     *
     * @throws InvalidCallbackException If callback is not callable
     */
    function Map(callable $Callback) : ICollection;

    /**
     * Filters the collection using a callback and returns a new collection
     *
     * @param callable $Callback Function to determine if an item should be included
     *
     * @return void
     *
     * @throws InvalidCallbackException If callback is not callable
     */
    function Filter(callable $Callback) : void;

    /**
     * Sorts items in the collection using a callback
     *
     * @param callable $Callback Comparison function
     *
     * @return void The function does not return anything after execution
     */
    function Usort(callable $Callback) : void;

    /**
     * Returns the first value in the collection
     *
     * @return mixed The first value or false if collection is empty
     */
    function GetFirstValue() : mixed;

    /**
     * Returns the number of items in the collection
     *
     * @return int Number of items
     */
	function GetCount() : int;
}
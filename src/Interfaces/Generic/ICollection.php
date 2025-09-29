<?php namespace Motokraft\MCPServer\Interfaces\Generic;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

interface ICollection
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return int
     */
	function GetCount() : int;

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
     * Creates a new instance of the AbstractLogging class
     *
     * @param mixed $Key Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function Remove(mixed $Key) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param mixed $Key Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function ContainsKey(mixed $Key) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return void
     */
    function Clear() : void;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return bool true
     * @return bool false
     */
    function IsEmptyCollection() : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param callable $Callback Current application class
     *
     * @return ICollection<mixed, mixed>
     */
    function Map(callable $Callback) : ICollection;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param callable $Callback Current application class
     *
     * @return ICollection<mixed, mixed>
     */
    function Filter(callable $Callback) : ICollection;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param callable $Callback Current application class
     *
     * @return void
     */
    function Each(callable $Callback) : void;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param callable $Callback Current application class
     *
     * @return void
     */
    function Usort(callable $Callback) : void;

    /**
     * Returns the internal array of items
     *
     * @return array Array of all items
     */
    function GetArray() : array;
}
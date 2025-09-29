<?php namespace Motokraft\MCPServer\Interfaces\Generic;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

interface IDictionary
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param mixed $Key Log settings array
     * @param mixed $Value Log settings array
     *
     * @return void
     */
    function Add(mixed $Key, mixed $Value) : void;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param mixed $Key Log settings array
     * @param mixed $Default Log settings array
     *
     * @return mixed
     */
    function GetValue(mixed $Key, mixed $Default = null) : mixed;

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
     * @param mixed $Key Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function Remove(mixed $Key) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param callable $Callback Current application class
     *
     * @return array<mixed, mixed>
     */
    function Map(callable $Callback) : array;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param callable $Callback Current application class
     * @param string $ClassName Current application class
     *
     * @return array<mixed, mixed>
     */
    function Filter(callable $Callback) : array;

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
     * @return bool true
     * @return bool false
     */
    function IsEmptyDictionary() : bool;
}
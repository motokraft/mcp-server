<?php namespace Motokraft\MCPServer\Interfaces\Attribute;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

interface IAttributeBuilder
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetName() : ?string;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasName(string $Value) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function SetClass(string $Value) : void;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetClass() : ?string;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasClassA(string $Value) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasClass(string $Value) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasInstance(string $Value) : bool;
}
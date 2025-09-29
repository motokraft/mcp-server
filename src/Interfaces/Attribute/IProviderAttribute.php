<?php namespace Motokraft\MCPServer\Interfaces\Attribute;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

interface IProviderAttribute extends IAttributeBuilder
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function SetTarget(string $Value) : void;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetTarget() : ?string;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasTargetA(string $Value) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasTarget(string $Value) : bool;
}
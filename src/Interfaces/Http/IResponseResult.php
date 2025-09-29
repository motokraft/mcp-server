<?php namespace Motokraft\MCPServer\Interfaces\Http;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

interface IResponseResult extends \Stringable
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function SetContentType(string $Value) : void;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function SetCharset(string $Value) : void;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetContentType() : ?string;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetCharset() : ?string;
}
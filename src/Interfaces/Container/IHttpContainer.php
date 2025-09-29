<?php namespace Motokraft\MCPServer\Interfaces\Container;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Http\IHttpRequest;
use Motokraft\MCPServer\Interfaces\Http\IHttpResponse;

interface IHttpContainer
{
    /**
     * Executes a specific resource using the current HTTP response handler.
     *
     * @return void Function does not return any value after execution.
     */
    function ExecuteResponse() : void;

    /**
     * Returns the HTTP request handler instance.
     *
     * @return IHttpRequest Provides access to incoming HTTP request data.
     */
    function GetHttpRequest() : IHttpRequest;

    /**
     * Returns the HTTP response handler instance.
     *
     * @return IHttpResponse Provides methods to build and send HTTP responses.
     */
    function GetHttpResponse() : IHttpResponse;
}
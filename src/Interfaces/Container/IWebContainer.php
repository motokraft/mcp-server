<?php namespace Motokraft\MCPServer\Interfaces\Container;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Http\IResponseResult;
use Motokraft\MCPServer\Interfaces\Routing\IRoutingCollection;

interface IWebContainer extends IHttpContainer
{
    /**
     * Executes the current matched route and returns the response result.
     *
     * @return IResponseResult The result of executing the current route.
     */
    function ExecuteResult() : IResponseResult;

    /**
     * Returns the routing collection service instance.
     *
     * @return IRoutingCollection Provides access to route matching and registration.
     */
    function GetRoutingCollection() : IRoutingCollection;
}
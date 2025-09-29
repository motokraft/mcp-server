<?php namespace Motokraft\MCPServer\Container;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Container\IWebContainer;
use Motokraft\MCPServer\Interfaces\Http\IHttpRequest;
use Motokraft\MCPServer\Interfaces\Http\IHttpResponse;
use Motokraft\MCPServer\Interfaces\Http\IResponseResult;
use Motokraft\MCPServer\Interfaces\Routing\IRoutingCollection;

class WebContainer extends ContainerBuilder implements IWebContainer
{
    /**
     * Executes the current matched route and returns the response result.
     *
     * @return IResponseResult The result of executing the current route.
     */
    function ExecuteResult() : IResponseResult
    {
        $Routing = $this->GetRoutingCollection();
        $Route = $Routing->MatchRequest($this);

        return $Route->Execute($this);
    }

    /**
     * Executes a specific resource using the current HTTP response handler.
     *
     * @return void Function does not return any value after execution.
     */
    function ExecuteResponse() : void
    {
        $HttpResponse = $this->GetHttpResponse();
        $HttpResponse->SetResult($this->ExecuteResult());
    }

    /**
     * Returns the routing collection service instance.
     *
     * @return IRoutingCollection Provides access to route matching and registration.
     */
    function GetRoutingCollection() : IRoutingCollection
    {
        return $this->Get(IRoutingCollection::class);
    }

    /**
     * Returns the HTTP request handler instance.
     *
     * @return IHttpRequest Provides access to incoming HTTP request data.
     */
    function GetHttpRequest() : IHttpRequest
    {
        return $this->Get(IHttpRequest::class);
    }

    /**
     * Returns the HTTP response handler instance.
     *
     * @return IHttpResponse Provides methods to build and send HTTP responses.
     */
    function GetHttpResponse() : IHttpResponse
    {
        return $this->Get(IHttpResponse::class);
    }
}
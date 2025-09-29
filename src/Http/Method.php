<?php namespace Motokraft\MCPServer\Http;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

final class Method
{
    /**
     * HTTP method for establishing a tunnel to the server
     *
     * @var string
     */
    const Connect = 'CONNECT';

    /**
     * HTTP method for deleting a specified resource
     *
     * @var string
     */
    const Delete = 'DELETE';

    /**
     * HTTP method for retrieving data from the server
     *
     * @var string
     */
    const Get = 'GET';

    /**
     * HTTP method for retrieving headers without the response body
     *
     * @var string
     */
    const Head = 'HEAD';

    /**
     * HTTP method for describing communication options for the target resource
     *
     * @var string
     */
    const Options = 'OPTIONS';

    /**
     * HTTP method for updating a current resource with new data
     *
     * @var string
     */
    const Patch = 'PATCH';

    /**
     * The route that is currently
     *
     * @var string
     */
    const Post = 'POST';

    /**
     * The route that is currently
     *
     * @var string
     */
    const Put = 'PUT';
}
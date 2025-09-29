<?php namespace Motokraft\MCPServer\Interfaces\Http;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Http\ICookieDictionary;
use Motokraft\MCPServer\Interfaces\Http\IInputDictionary;
use Motokraft\MCPServer\Interfaces\Http\IHeaderDictionary;
use Motokraft\MCPServer\Interfaces\Generic\ICollection;
use Motokraft\MCPServer\Interfaces\Uri\IUriBuilder;

interface IHttpRequest
{
    /**
     * Get the current request URI
     *
     * @return IUriBuilder The current URI instance
     */
    function GetUriBuilder() : IUriBuilder;

    /**
     * Get the input dictionary containing request parameters
     *
     * @return IInputDictionary The input dictionary
     */
    function GetInputDictionary() : ?IInputDictionary;

    /**
     * Get the request host name
     *
     * @return string The 'Host' value from the URI
     */
    function GetHost() : ?string;

    /**
     * Get the Content-Type header value
     *
     * @return string The Content-Type header if present
     */
    function GetHeaderContentType() : ?string;

    /**
     * Get the cookie dictionary
     *
     * @return ICookieDictionary The collection of cookies
     */
    function GetCookieDictionary() : ?ICookieDictionary;

    /**
     * Get the header collection
     *
     * @return IHeaderDictionary The collection of headers
     */
    function GetHeaderDictionary() : ?IHeaderDictionary;

    /**
     * Get the file collection
     *
     * @return ICollection The collection of uploaded files
     */
    function GetFileCollection() : ?ICollection;

    /**
     * Get a header value by key
     *
     * @param string $Key The header name
     * @param mixed $Default The default value if header does not exist
     *
     * @return mixed The header value or the default
     */
    function GetHeaderValue(string $Key, mixed $Default = null) : mixed;

    /**
     * Get an input parameter by key
     *
     * @param string $Key The input parameter name
     * @param mixed $Default The default value if parameter does not exist
     *
     * @return mixed The input value or the default
     */
    function GetInputValue(string $Key, mixed $Default = null) : mixed;

    /**
     * Determine whether a cookie exists
     *
     * @param string $Key The cookie name
     *
     * @return bool true if the cookie exists
     * @return bool false otherwise
     */
    function ContainsCookie(string $Key) : bool;

    /**
     * Get a cookie value by key
     *
     * @param string $Key The cookie name
     * @param mixed $Default The default value if cookie does not exist
     *
     * @return mixed The cookie value or the default
     */
    function GetCookieValue(string $Key, mixed $Default = null) : mixed;

    /**
     * Get a query value from the URI properties
     *
     * @param string $Key The query parameter name
     * @param mixed $Default The default value if parameter does not exist
     *
     * @return mixed The query value or the default
     */
    function GetQueryValue(string $Key, mixed $Default = null) : mixed;
}
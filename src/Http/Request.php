<?php namespace Motokraft\MCPServer\Http;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;
use Motokraft\MCPServer\Interfaces\Http\ICookieDictionary;
use Motokraft\MCPServer\Interfaces\Http\IHttpRequest;
use Motokraft\MCPServer\Interfaces\Http\IInputDictionary;
use Motokraft\MCPServer\Interfaces\Http\IHeaderDictionary;
use Motokraft\MCPServer\Interfaces\Generic\ICollection;
use Motokraft\MCPServer\Interfaces\Uri\IUriBuilder;
use Motokraft\MCPServer\Http\Generic\CookieDictionary;
use Motokraft\MCPServer\Filesystem\Collection\FileCollection;
use Motokraft\MCPServer\Http\Generic\InputDictionary;
use Motokraft\MCPServer\Http\Generic\HeaderDictionary;
use Motokraft\MCPServer\Uri\UriBuilder;
use Motokraft\MCPServer\Generic\Dictionary;

final class Request implements IHttpRequest
{
    /**
     * Current request URI
     *
     * @var IUriBuilder
     */
    private ?IUriBuilder $_UriBuilder = null;

    /**
     * Parsed input parameters from query and body
     *
     * @var IInputDictionary
     */
    private ?IInputDictionary $_InputDictionary = null;

    /**
     * HTTP headers collection
     *
     * @var IHeaderDictionary
     */
    private ?IHeaderDictionary $_HeaderDictionary = null;

    /**
     * Uploaded files collection
     *
     * @var ICollection
     */
    private ?ICollection $_FileCollection = null;

    /**
     * Constructor initializes request context and loads input, cookies, headers, files
     *
     * @param IContainerBuilder $Container Application container builder
     *
     * @return void The constructor does not return anything after execution
     */
    function __construct(IContainerBuilder $Container)
    {
        $this->_UriBuilder = clone UriBuilder::GetCurrent();
        $this->_InputDictionary = new InputDictionary;

        $Query = $this->_UriBuilder->GetProperties();
        $this->_InputDictionary->LoadedArray($Query);

        $this->_HeaderDictionary = new HeaderDictionary;

        foreach(getallheaders() as $Name => $Value)
        {
            $this->_HeaderDictionary->Add(strtolower($Name), $Value);
        }

        $Collection = new FileCollection($_FILES);

        $Collection = $Collection->Map(
            fn($FileItem) => strval($FileItem['tmp_name'])
        );

        $this->_FileCollection = $Collection->Filter(
            fn($FileItem) => is_uploaded_file($FileItem)
        );

        if((bool) fcontent('php://input', $Content))
        {
            $this->_ParseResourceContent($Content);
        }

        // echo $this->_UriBuilder . PHP_EOL . PHP_EOL;
        // $Event = $this->GetEventingBuilder('construct');
        // $Event->Dispatcher($Container, $Result);
    }

    /**
     * Get the current request URI
     *
     * @return IUriBuilder The current URI instance
     */
    function GetUriBuilder() : IUriBuilder
    {
        return $this->_UriBuilder;
    }

    /**
     * Get the request host name
     *
     * @return string The 'Host' value from the URI
     */
    function GetHost() : ?string
    {
        return $this->_UriBuilder->GetValue('Host');
    }

    /**
     * Get the Content-Type header value
     *
     * @return string The Content-Type header if present
     */
    function GetHeaderContentType() : ?string
    {
        return $this->GetHeaderValue('content-type');
    }

    /**
     * Get the input dictionary containing request parameters
     *
     * @return IInputDictionary The input dictionary
     */
    function GetInputDictionary() : ?IInputDictionary
    {
        return $this->_InputDictionary;
    }

    /**
     * Get the cookie dictionary
     *
     * @return ICookieDictionary The collection of cookies
     */
    function GetCookieDictionary() : ?ICookieDictionary
    {
        return $this->_CookieDictionary;
    }

    /**
     * Get the header collection
     *
     * @return IHeaderDictionary The collection of headers
     */
    function GetHeaderDictionary() : ?IHeaderDictionary
    {
        return $this->_HeaderDictionary;
    }

    /**
     * Get the file collection
     *
     * @return ICollection The collection of uploaded files
     */
    function GetFileCollection() : ?ICollection
    {
        return $this->_FileCollection;
    }

    /**
     * Get a header value by key
     *
     * @param string $Key The header name
     * @param mixed $Default The default value if header does not exist
     *
     * @return mixed The header value or the default
     */
    function GetHeaderValue(string $Key, mixed $Default = null) : mixed
    {
        return $this->_HeaderDictionary->GetValue($Key, $Default);
    }

    /**
     * Get an input parameter by key
     *
     * @param string $Key The input parameter name
     * @param mixed $Default The default value if parameter does not exist
     *
     * @return mixed The input value or the default
     */
    function GetInputValue(string $Key, mixed $Default = null) : mixed
    {
        return $this->_InputDictionary->GetValue($Key, $Default);
    }

    /**
     * Determine whether a cookie exists
     *
     * @param string $Key The cookie name
     *
     * @return bool true if the cookie exists
     * @return bool false otherwise
     */
    function ContainsCookie(string $Key) : bool
    {
        return $this->_CookieDictionary->ContainsKey($Key);
    }

    /**
     * Get a cookie value by key
     *
     * @param string $Key The cookie name
     * @param mixed $Default The default value if cookie does not exist
     *
     * @return mixed The cookie value or the default
     */
    function GetCookieValue(string $Key, mixed $Default = null) : mixed
    {
        return $this->_CookieDictionary->GetValue($Key, $Default);
    }

    /**
     * Get a query value from the URI properties
     *
     * @param string $Key The query parameter name
     * @param mixed $Default The default value if parameter does not exist
     *
     * @return mixed The query value or the default
     */
    function GetQueryValue(string $Key, mixed $Default = null) : mixed
    {
        return $this->_CurrentUri->GetValue($Key, $Default);
    }

    /**
     * Get a query value from the URI properties
     *
     * @param string $Content The query parameter name
     *
     * @return void
     */
    private function _ParseResourceContent(string $Content) : void
    {
        $ContentType = $this->GetHeaderContentType();

        if($ContentType === 'application/json')
        {
            $this->_InputDictionary->LoadedString($Content);
        }
        else
        {
            parse_str($Content, $Parsed);
            $this->_InputDictionary->LoadedArray($Parsed);
        }
    }
}
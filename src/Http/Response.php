<?php namespace Motokraft\MCPServer\Http;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;
use Motokraft\MCPServer\Interfaces\Http\IHeaderDictionary;
use Motokraft\MCPServer\Interfaces\Http\IHttpResponse;
use Motokraft\MCPServer\Interfaces\Http\IResponseResult;
use Motokraft\MCPServer\Http\Generic\HeaderDictionary;
use Motokraft\MCPServer\Exception\Filesystem\ResourceNotWriteableException;

final class Response implements IHttpResponse
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @var int
     */
    private int $_StatusCode = StatusCode::Status200OK;

    /**
     * HTTP headers collection
     *
     * @var IHeaderDictionary
     */
    private ?IHeaderDictionary $_HeaderDictionary = null;

    /**
     * Holds the result object associated with the response
     *
     * @var IResponseResult
     */
    private ?IResponseResult $_ResponseResult = null;

    /**
     * Creates a new instance of the Response class
     *
     * @return void The function does not return anything after execution
     */
    function __construct()
    {
        $this->_HeaderDictionary = new HeaderDictionary;
    }

    /**
     * Sets the HTTP status code for the response
     *
     * @param int $Value The HTTP status code to set
     *
     * @return void The function does not return anything after execution
     */
    function SetStatusCode(int $Value) : void
    {
        $this->_StatusCode = $Value;
    }

    /**
     * Sets the response result object
     *
     * @param IResponseResult $Value The response result object
     *
     * @return void The function does not return anything after execution
     */
    function SetResult(IResponseResult $Value) : void
    {
        $this->_ResponseResult = $Value;
    }

    /**
     * Retrieves the HTTP status code of the response
     *
     * @return int Returns the HTTP status code
     */
    function GetStatusCode() : int
    {
        return $this->_StatusCode;
    }

    /**
     * Sets the HTTP status code for the response
     *
     * @param int $Value The HTTP status code to set
     *
     * @return void The function does not return anything after execution
     */
    function HasStatusCode(int $Value) : bool
    {
        return ($this->_StatusCode === $Value);
    }

    /**
     * Retrieves the headers collection
     *
     * @return IHeaderDictionary Returns the headers collection or null if not set
     */
    function GetHeaderDictionary() : ?IHeaderDictionary
    {
        return $this->_HeaderDictionary;
    }

    /**
     * Retrieves the response result object
     *
     * @return IResponseResult Returns the response result object or null if not set
     */
    function GetResponseResult() : ?IResponseResult
    {
        return $this->_ResponseResult;
    }

    /**
     * Adds a header to the response
     *
     * @param array $Headers The name of the header
     *
     * @return void The function does not return anything after execution
     */
    function AddHeaders(array $Headers) : void
    {
        $this->_HeaderDictionary->LoadedArray($Headers);
    }

    /**
     * Adds a header to the response
     *
     * @param string $Name The name of the header
     * @param string $Value The value of the header
     *
     * @return void The function does not return anything after execution
     */
    function AddHeader(string $Name, string $Value) : void
    {
        $this->_HeaderDictionary->Add($Name, $Value);
    }

    /**
     * Retrieves a header by name from the response
     *
     * @param string $Name The name of the header
     *
     * @return Header Returns the header object if found
     * @return bool false If the header does not exist
     */
    function GetHeader(string $Name) : bool|Header
    {
        return $this->_HeaderDictionary->Get($Name);
    }

    /**
     * Checks whether a header with the specified name exists
     *
     * @param string $Name The name of the header
     *
     * @return bool true If the header exists
     * @return bool false If the header does not exist
     */
    function ContainsHeader(string $Name) : bool
    {
        return $this->_HeaderDictionary->ContainsKey($Name);
    }

    /**
     * Removes a header from the response by name
     *
     * @param string $Name The name of the header
     *
     * @return bool true If the header was successfully removed
     * @return bool false If the header does not exist
     */
    function RemoveHeader(string $Name) : bool
    {
        return $this->_HeaderDictionary->Remove($Name);
    }

    /**
     * Sets the content-type header for the response
     *
     * @param string $Value The content type value
     *
     * @return void The function does not return anything after execution
     */
    function SetContentType(string $Value) : void
    {
        $this->AddHeader('Content-Type', $Value);
    }

    /**
     * Sets the location header to redirect the response
     *
     * @param string $RouteName The URL to redirect to
     *
     * @return void The function does not return anything after execution
     */
    function SetRedirect(string $RouteName, int $Code = StatusCode::Status301MovedPermanently) : void
    {
        $this->AddHeader('Location', '/' . str_replace('_', '/', $RouteName));

        $this->SetStatusCode($Code);
        exit;
    }

    /**
     * Sets the content-disposition header to download a file
     *
     * @param string $Filename The filename to set for download
     *
     * @return void The function does not return anything after execution
     */
    function SetContentDisposition(string $Filename) : void
    {
        $Attachment = sprintf('attachment; filename="%s"', $Filename);
        $this->AddHeader('Content-Disposition', $Attachment);
    }

    /**
     * Executes the response by sending the resource content
     *
     * @param string $Resource The resource to execute
     * @param IContainerBuilder $Container The resource to execute
     *
     * @return void The function does not return anything after execution
     */
    function ExecuteResource(string $Resource, IContainerBuilder $Container) : void
    {
        if(!$StreamResource = fopen($Resource, 'w'))
        {
            throw new ResourceNotWriteableException($Resource);
        }

        $StatusCode = (int) $this->GetStatusCode();
        $Message = StatusCode::GetCodeMessage($StatusCode);

        header(StatusCode::ToString($StatusCode, $Message));

        if($this->_ResponseResult instanceof IResponseResult)
        {
            $ContentType = $this->_ResponseResult->GetContentType();

            if($Charset = $this->_ResponseResult->GetCharset())
            {
                $ContentType .= '; charset=' . $Charset;
            }

            $this->AddHeader('Content-Type', $ContentType);
        }

        foreach($this->_HeaderDictionary as $Name => $Value)
        {
            header($Name . ': ' . $Value, true);
        }

        if($this->_ResponseResult instanceof IResponseResult)
        {
            fwrite($StreamResource, $this->_ResponseResult);
        }
    }

    /**
     * Executes the response by sending the resource content
     *
     * @param Cookie $Resource The resource to execute
     * @param IContainerBuilder $Container The resource to execute
     *
     * @return void The function does not return anything after execution
     */
    private function _FilterCookie(Cookie $Cookie, IContainerBuilder $Container) : bool
    {
        return true;
    }
}
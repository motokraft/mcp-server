<?php namespace Motokraft\MCPServer\Http;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

final class Header implements \Stringable
{
    /**
     * Header for acceptable media types for the response
     *
     * @var string
     */
    const Accept = 'Accept';

    /**
     * Header for acceptable character sets
     *
     * @var string
     */
    const AcceptCharset = 'Accept-Charset';

    /**
     * Header for acceptable content encodings
     *
     * @var string
     */
    const AcceptEncoding = 'Accept-Encoding';

    /**
     * Header for acceptable natural languages
     *
     * @var string
     */
    const AcceptLanguage = 'Accept-Language';

    /**
     * Header indicating the range units accepted by the server
     *
     * @var string
     */
    const AcceptRanges = 'Accept-Ranges';

    /**
     * Header used to redirect the recipient to a different location
     *
     * @var string
     */
    const Location = 'Location';

    /**
     * Header representing the domain name of the server
     *
     * @var string
     */
    const Host = 'Host';

    /**
     * The name of the HTTP header
     *
     * @var string
     */
    private ?string $_Name = null;

    /**
     * The value of the HTTP header
     *
     * @var string
     */
    private ?string $_Value = null;

    /**
     * The HTTP response code associated with the header
     *
     * @var int
     */
    private int $_ResponseCode = 0;

    /**
     * Initializes a new Header instance with name, value, and optional response code
     *
     * @param string $Name The name of the HTTP header
     * @param string $Value The value of the HTTP header
     * @param int $Code The HTTP response code, default is 0
     *
     * @return void Function does not return anything after execution
     */
    function __construct(string $Name, string $Value, int $Code = 0)
    {
        $this->_Name = $Name;
        $this->_Value = $Value;
        $this->_ResponseCode = $Code;
    }

    /**
     * Updates the value of the header
     *
     * @param string $Value The new value for the header
     *
     * @return void Function does not return anything after execution
     */
    function SetValue(string $Value) : void
    {
        $this->_Value = $Value;
    }

    /**
     * Updates the HTTP response code associated with the header
     *
     * @param int $Value The new HTTP response code
     *
     * @return void Function does not return anything after execution
     */
    function SetResponseCode(int $Value) : void
    {
        $this->_ResponseCode = $Value;
    }

    /**
     * Returns the name of the header
     *
     * @return string Returns the header name or null if not set
     */
    function GetName() : ?string
    {
        return $this->_Name;
    }

    /**
     * Returns the value of the header
     *
     * @return string Returns the header value or null if not set
     */
    function GetValue() : ?string
    {
        return $this->_Value;
    }

    /**
     * Returns the HTTP response code associated with the header
     *
     * @return int Returns the HTTP response code
     */
    function GetResponseCode() : int
    {
        return $this->_ResponseCode;
    }

    /**
     * Converts the header to its string representation
     *
     * @return string Returns the header as a formatted string "Name: Value"
     */
    function __toString() : string
    {
        return $this->_Name . ': ' . $this->_Value;
    }
}
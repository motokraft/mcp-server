<?php namespace Motokraft\MCPServer\Http\Response;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Http\IResponseResult;

class ResultBuilder implements IResponseResult
{
    /**
     * The route that is currently being used in the application
     *
     * @var ?string
     */
    private ?string $_ContentType = 'application/json';

    /**
     * The route that is currently being used in the application
     *
     * @var ?string
     */
    private ?string $_Charset = 'UTF-8';

    /**
     * The route that is currently being used in the application
     *
     * @var string
     */
    private ?string $_Content = null;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Element Log settings array
     * @param array $Data Log settings array
     *
     * @return void
     */
    function __construct(string $Value, array $Data = [])
    {
        $this->SetContent($Value);

        if(isset($Data['ContentType']))
        {
            $this->SetContentType($Data['ContentType']);
        }

        if(isset($Data['Charset']))
        {
            $this->SetCharset($Data['Charset']);
        }
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function SetContentType(string $Value) : void
    {
        $this->_ContentType = $Value;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function SetCharset(string $Value) : void
    {
        $this->_Charset = $Value;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Element Log settings array
     *
     * @return void
     */
    function SetContent(string $Value) : void
    {
        $this->_Content = strval($Value);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetContentType() : ?string
    {
        return $this->_ContentType;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetCharset() : ?string
    {
        return $this->_Charset;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetContent() : ?string
    {
        return $this->_Charset;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function __ToString() : string
    {
        return strval($this->_Content);
    }
}
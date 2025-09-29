<?php namespace Motokraft\MCPServer\Http\Response;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Generic\IDictionary;
use Motokraft\MCPServer\Traits\Generic\DictionaryTrait;

class ResourceResult extends ResultBuilder
{
    /**
     * The route that is currently being used in the application
     *
     * @var mixed
     */
    private mixed $_Resource = null;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param mixed $Resource Log settings array
     *
     * @return void
     */
    function __construct(mixed $Resource)
    {
        $this->_Resource = $Resource;

        if(fcontent($this->_Resource, $Content))
        {
            $this->SetContent($Content);
        }

        if($Type = mime_content_type($this->_Resource))
        {
            $this->SetContentType($Type);
        }

        if(is_resource($this->_Resource))
        {
            fclose($this->_Resource);
        }
        else if(is_file($this->_Resource))
        {
            unlink($this->_Resource);
        }
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return mixed
     */
    function GetResource() : mixed
    {
        return $this->_Resource;
    }
}
<?php

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Exception\Filesystem\ResourceNotReadableException;

/**
 * Reads content from a resource and assigns it to a variable
 *
 * @param mixed $Resource A resource (string or object implementing Stringable) to read from
 * @param string $Content The variable to store the resulting content
 *
 * @return bool true If the content has been read successfully
 * @return bool false If the resource could not be read or is empty
 */
function fcontent(mixed $Resource, ?string &$Content = null) : bool
{
    if($Resource instanceof \Stringable)
    {
        $Resource = fopen($Resource, 'r');
    }
    else if(is_string($Resource))
    {
        $Resource = fopen($Resource, 'r');
    }

    if(!is_resource($Resource))
    {
        throw new ResourceNotReadableException($Resource);
    }

    while(feof($Resource) !== true)
    {
        $Content .= fread($Resource, 1048576);
    }

    return (bool) strlen($Content);
}

/**
 * Returns a translated value by its key or the key itself if not found
 *
 * @param string $Name The translation key to retrieve
 * @param array $Args Optional parameters to insert into the translation string
 *
 * @return string The translated string or the original key if not found
 */
function t(string $Name, array $Args = []) : ?string
{
    return $Name;
}
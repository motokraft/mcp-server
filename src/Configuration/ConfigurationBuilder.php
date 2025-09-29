<?php namespace Motokraft\MCPServer\Configuration;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Configuration\IConfigurationBuilder;
use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;
use Motokraft\MCPServer\Interfaces\Generic\IDictionary;
use Motokraft\MCPServer\Traits\Generic\DictionaryTrait;

class ConfigurationBuilder implements IConfigurationBuilder, IDictionary, \ArrayAccess
{
    /**
     * Contains an array of default settings.
     */
    use DictionaryTrait;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param IContainerBuilder $Container Log settings array
     *
     * @return void
     */
    function __construct(IContainerBuilder $Container)
    {
        $this->_LoadedIniFile(ROOT_PATH . DS . '.env');
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return bool true
     * @return bool false
     */
    function IsDevelopment() : bool
    {
        return $this->IsDebuging(true);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return bool true
     * @return bool false
     */
    function IsProduction() : bool
    {
        return $this->IsDebuging(false);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param bool $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function IsDebuging(bool $Value) : bool
    {
        $Debug = $this->GetValue('app.debug', true);
        return ((bool) $Debug === (bool) $Value);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Filepath Log settings array
     *
     * @return void
     */
    private function _LoadedIniFile(string $Filepath) : void
    {
        if(!$Data = parse_ini_file($Filepath))
        {
            throw new \Exception($Filepath, 404);
        }

        $this->LoadedArray($Data);
    }
}
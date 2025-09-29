<?php namespace Motokraft\MCPServer\Traits\Environment;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;
use Motokraft\MCPServer\Interfaces\Environment\IEnvironmentBuilder;
use Motokraft\MCPServer\Interfaces\Collection\IAttributeCollection;

trait EnvironmentTrait
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return IEnvironmentBuilder
     */
    function GetEnvironmentBuilder() : IEnvironmentBuilder
    {
        return \ClassLoader::GetEnvironmentBuilder();
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $ContainerClass settings array
     *
     * @return IContainerBuilder
     */
    function GetContainer(string $ContainerClass) : IContainerBuilder
    {
        $Environment = $this->GetEnvironmentBuilder();
        return $Environment->Get($ContainerClass);
    }

    /**
     * Removes a container from the collection.
     *
     * @param string $ContainerClass Fully qualified class name of the container
     *
     * @return bool True if removed, false otherwise
     */
    function RemoveContainer(string $ContainerClass) : bool
    {
        $Environment = $this->GetEnvironmentBuilder();
        return $Environment->Remove($ContainerClass);
    }

    /**
     * Checks whether a container is registered.
     *
     * @param string $ContainerClass Fully qualified class name of the container
     *
     * @return bool True if exists, false otherwise
     */
    function ContainsContainer(string $ContainerClass) : bool
    {
        $Environment = $this->GetEnvironmentBuilder();
        return $Environment->ContainsContainer($ContainerClass);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return IContainerBuilder
     */
    function GetMainContainer() : IContainerBuilder
    {
        $Environment = $this->GetEnvironmentBuilder();
        return $Environment->GetMainContainer();
    }

    /**
     * Returns the collection of registered attributes.
     *
     * @return IAttributeCollection
     */
    function GetAttributeCollection() : IAttributeCollection
    {
        $MainContainer = $this->GetMainContainer();
        return $MainContainer->GetAttributeCollection();
    }
}
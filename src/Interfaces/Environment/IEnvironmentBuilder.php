<?php namespace Motokraft\MCPServer\Interfaces\Environment;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;

interface IEnvironmentBuilder
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $ContainerName Log settings array
     *
     * @return IContainerBuilder
     */
    function MainBuild(string $ContainerName) : IContainerBuilder;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $ContainerName Log settings array
     *
     * @return IContainerBuilder
     */
    function Build(string $ContainerName) : IContainerBuilder;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $ContainerName Log settings array
     *
     * @return IContainerBuilder
     * @return bool false
     */
    function Get(string $ContainerName) : bool|IContainerBuilder;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $ContainerName Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function RemoveContainer(string $ContainerName) : bool;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $ContainerName Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function ContainsContainer(string $ContainerName) : bool;
}
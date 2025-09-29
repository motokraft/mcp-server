<?php namespace Motokraft\MCPServer\Interfaces\Container;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;

interface IExceptionBuilder extends IHttpContainer
{
    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @param IContainerBuilder $Container Array of repository definitions
     *
     * @return void
     */
    function SetMainContainer(IContainerBuilder $Container) : void;

    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @param \Throwable $Error Array of repository definitions
     *
     * @return void
     */
    function SetThrowable(\Throwable $Error) : void;

    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @return \Throwable
     */
    function GetThrowable() : ?\Throwable;

    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @return int
     */
    function GetThrowableCode() : int;

    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @return int
     */
    function GetThrowableLine() : int;

    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @return string
     */
    function GetThrowableFile() : string;

    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @return string
     */
    function GetThrowableMessage() : string;

    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @return array
     */
    function GetThrowableTrace() : array;

    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @return IContainerBuilder
     */
    function GetMainContainer() : IContainerBuilder;
}
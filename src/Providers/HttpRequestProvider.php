<?php namespace Motokraft\MCPServer\Providers;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Http\IHttpRequest;
use Motokraft\MCPServer\Interfaces\Providers\IServiceProvider;
use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;
use Motokraft\MCPServer\Attribute\ProviderAttribute;
use Motokraft\MCPServer\Http\Request;

#[ProviderAttribute(Name: 'request', Target: IHttpRequest::class)]
class HttpRequestProvider implements IServiceProvider
{
    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param IContainerBuilder $Container Current application class
     * @param string $Name Current application class
     *
     * @return void
     */
    function Register(IContainerBuilder $Container, string $Name) : void
    {
        $Environment = $Container->GetEnvironmentBuilder();
        $Environment->Singleton($Name, new Request($Container));
    }
}
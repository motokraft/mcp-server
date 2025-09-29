<?php namespace Motokraft\MCPServer\Container;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Configuration\IConfigurationBuilder;
use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;
use Motokraft\MCPServer\Interfaces\Container\IExceptionBuilder;
use Motokraft\MCPServer\Interfaces\Http\IHttpRequest;
use Motokraft\MCPServer\Interfaces\Http\IHttpResponse;
use Motokraft\MCPServer\Interfaces\Stylesheet\IStylesheetBuilder;
use Motokraft\MCPServer\Interfaces\WebAsset\IWebAssetBuilder;
use Motokraft\MCPServer\Interfaces\Template\ITemplateBuilder;

class ExceptionContainer extends ContainerBuilder implements IExceptionBuilder
{
    /**
     * Configuration builder used for reading and managing configuration settings
     *
     * @var IConfigurationBuilder
     */
    private ?IConfigurationBuilder $_Configuration = null;

    /**
     * The main application container
     *
     * @var IContainerBuilder
     */
    private ?IContainerBuilder $_MainContainer = null;

    /**
     * Throwable object representing the current exception
     *
     * @var \Throwable
     */
    private ?\Throwable $_Throwable = null;

    /**
     * Executes a specific resource using the current HTTP response handler.
     *
     * @return void Function does not return any value after execution.
     */
    function ExecuteResponse() : void
    {
        $TemplateBuilder = $this->GetTemplateBuilder();
        $TemplateBuilder->SetLayoutName('system.exception.default');

        $Result = $TemplateBuilder->GetResponseResult($this);
        $this->GetHttpResponse()->SetResult($Result);
    }

    /**
     * Stores the throwable object for later retrieval
     *
     * @param \Throwable $Error Exception or error to be stored
     *
     * @return void Function does not return anything after execution
     */
    function SetThrowable(\Throwable $Error) : void
    {
        $this->_Throwable = $Error;
    }

    /**
     * Stores the main container for access to additional services
     *
     * @param IContainerBuilder $Container Main application container
     *
     * @return void Function does not return anything after execution
     */
    function SetMainContainer(IContainerBuilder $Container) : void
    {
        $this->_MainContainer = $Container;
    }

    /**
     * Returns the stored throwable object
     *
     * @return \Throwable|null The previously stored exception or null
     */
    function GetThrowable() : ?\Throwable
    {
        return $this->_Throwable;
    }

    /**
     * Returns the code of the stored throwable
     *
     * @return int Integer error code from the throwable
     */
    function GetThrowableCode() : int
    {
        return $this->_Throwable->GetCode();
    }

    /**
     * Returns the line number where the throwable was triggered
     *
     * @return int Line number of the error
     */
    function GetThrowableLine() : int
    {
        return $this->_Throwable->GetLine();
    }

    /**
     * Returns the file in which the throwable was triggered
     *
     * @return string Path to the file that triggered the error
     */
    function GetThrowableFile() : string
    {
        return $this->_Throwable->GetFile();
    }

    /**
     * Returns the message from the stored throwable
     *
     * @return string Error message from the throwable
     */
    function GetThrowableMessage() : string
    {
        return $this->_Throwable->GetMessage();
    }

    /**
     * Returns the stack trace of the stored throwable
     *
     * @return array Stack trace as an array
     */
    function GetThrowableTrace() : array
    {
        return $this->_Throwable->GetTrace();
    }

    /**
     * Returns the configuration builder instance
     *
     * @return IConfigurationBuilder Provides access to application configuration settings
     */
    function GetConfiguration() : IConfigurationBuilder
    {
        return $this->_MainContainer->GetConfigurationBuilder();
    }

    /**
     * Returns the web asset builder instance
     *
     * @return IWebAssetBuilder Provides management of web assets such as scripts and images
     */
    function GetWebAssetBuilder() : IWebAssetBuilder
    {
        return $this->Get(IWebAssetBuilder::class);
    }

    /**
     * Returns the stylesheet builder instance
     *
     * @return IStylesheetBuilder Provides management of stylesheets and related resources
     */
    function GetStylesheetBuilder() : IStylesheetBuilder
    {
        return $this->Get(IStylesheetBuilder::class);
    }

    /**
     * Returns the main container that was previously stored
     *
     * @return IContainerBuilder The main application container
     */
    function GetMainContainer() : IContainerBuilder
    {
        return $this->_MainContainer;
    }

    /**
     * Returns the HTTP request handler instance.
     *
     * @return IHttpRequest Provides access to incoming HTTP request data.
     */
    function GetHttpRequest() : IHttpRequest
    {
        return $this->Get(IHttpRequest::class);
    }

    /**
     * Returns the HTTP response handler instance.
     *
     * @return IHttpResponse Provides methods to build and send HTTP responses.
     */
    function GetHttpResponse() : IHttpResponse
    {
        return $this->Get(IHttpResponse::class);
    }

    /**
     * Returns the HTTP response handler instance.
     *
     * @return ITemplateBuilder Provides methods to build and send HTTP responses.
     */
    function GetTemplateBuilder() : ITemplateBuilder
    {
        return $this->Get(ITemplateBuilder::class);
    }
}
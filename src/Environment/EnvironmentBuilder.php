<?php namespace Motokraft\MCPServer\Environment;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Environment\IEnvironmentBuilder;
use Motokraft\MCPServer\Interfaces\Collection\IAttributeCollection;
use Motokraft\MCPServer\Interfaces\Collection\IContainerCollection;
use Motokraft\MCPServer\Interfaces\Collection\IServiceCollection;
use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;
use Motokraft\MCPServer\Collection\AttributeCollection;
use Motokraft\MCPServer\Collection\ContainerCollection;
use Motokraft\MCPServer\Collection\ServiceCollection;

class EnvironmentBuilder implements IEnvironmentBuilder
{
    /**
     * The main application container.
     *
     * @var IContainerBuilder
     */
    private ?IContainerBuilder $_MainContainerBuilder = null;

    /**
     * A collection of all registered attributes.
     *
     * @var IAttributeCollection
     */
    private ?IAttributeCollection $_AttributeCollection = null;

    /**
     * A collection of all container builders.
     *
     * @var IContainerCollection
     */
    private ?IContainerCollection $_ContainerCollection = null;

    /**
     * Collection of registered service instances.
     *
     * @var IServiceCollection
     */
    private ?IServiceCollection $_ServiceCollection = null;

    /**
     * Initializes the environment with the given attributes and repositories.
     *
     * @param array $Attributes Array of attribute definitions
     *
     * @return void
     */
    function __construct(array $Attributes)
    {
        $this->_AttributeCollection = new AttributeCollection($Attributes);
        $this->_ContainerCollection = new ContainerCollection;
        $this->_ServiceCollection = new ServiceCollection;

        // register_shutdown_function([$this, '_ExecuteShutdownHandler']);

        set_exception_handler(
            fn($Error) => $this->_ExecuteEexceptionHandler($Error)
        );

        set_error_handler(
            fn(...$Args) => $this->_ExecuteErrorHandler($Args)
        );
    }

    /**
     * Returns the main application container.
     *
     * @return IContainerBuilder
     */
    function GetMainContainer() : IContainerBuilder
    {
        if(null === $this->_MainContainerBuilder)
        {
            throw new \RuntimeException('Main container is not initialized.');
        }

        return $this->_MainContainerBuilder;
    }

    /**
     * Returns the collection of registered attributes.
     *
     * @return IAttributeCollection
     */
    function GetAttributeCollection() : IAttributeCollection
    {
        return $this->_AttributeCollection;
    }

    /**
     * Returns the collection of container builders.
     *
     * @return IContainerCollection
     */
    function GetContainerCollection() : IContainerCollection
    {
        return $this->_ContainerCollection;
    }

    /**
     * Returns the configuration builder instance.
     *
     * @return IConfigurationBuilder Provides access to application configuration settings.
     */
    function GetConfigurationBuilder() : IConfigurationBuilder
    {
        return $this->GetService(IConfigurationBuilder::class);
    }

    /**
     * Retrieves the database provider service.
     *
     * @return IDatabaseBuilder The database provider instance.
     */
    function GetDatabaseBuilder() : IDatabaseBuilder
    {
        return $this->GetService(IDatabaseBuilder::class);
    }

    /**
     * Retrieves the database provider service.
     *
     * @return ILoggingBuilder The database provider instance.
     */
    function GetLoggingBuilder() : ILoggingBuilder
    {
        return $this->GetService(ILoggingBuilder::class);
    }

    /**
     * Builds and sets the main application container.
     *
     * @param string $ContainerClass Fully qualified class name of the container
     *
     * @return IContainerBuilder
     */
    function MainBuild(string $ContainerClass) : IContainerBuilder
    {
        $Container = $this->Build($ContainerClass);
        return $this->_MainContainerBuilder = $Container;
    }

    /**
     * Builds a new container instance and registers it in the container collection.
     *
     * @param string $ContainerClass Fully qualified class name of the container
     *
     * @return IContainerBuilder
     *
     * @throws \Exception If the class does not implement IContainerBuilder
     */
    function Build(string $ContainerClass) : IContainerBuilder
    {
        if(!is_a($ContainerClass, IContainerBuilder::class, 1))
        {
            throw new \Exception($ContainerName, 404);
        }

        $Container = new $ContainerClass($this);
        $this->_ContainerCollection->Add($Container);

        return $Container;
    }

    /**
     * Returns an existing container or builds it if it does not exist.
     *
     * @param string $ContainerClass Fully qualified class name of the container
     *
     * @return IContainerBuilder Returns container instance
     */
    function Get(string $ContainerClass) : IContainerBuilder
    {
        if(!$this->ContainsContainer($ContainerClass))
        {
            return $this->Build($ContainerClass);
        }

        return $this->_ContainerCollection->Get($ContainerClass);
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
        return $this->_ContainerCollection->Remove($ContainerClass);
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
        return $this->_ContainerCollection->ContainsKey($ContainerClass);
    }

    /**
     * Registers a singleton service instance in the container.
     *
     * @param string $Name The service name.
     * @param object $ServiceObject The service instance.
     *
     * @return void The function does not return any value after execution.
     */
    function Singleton(string $Name, object $ServiceObject) : void
    {
        $this->_ServiceCollection->Add($Name, $ServiceObject);
    }

    /**
     * Retrieves a service instance by name. Loads the service if not already registered.
     *
     * @param string $Name The service name.
     *
     * @return object The service instance.
     */
    function GetService(string $Name) : object
    {
        if(!$this->ContainsService($Name))
        {
            $this->_LoadedServiceProvider($Name);
        }

        return $this->_ServiceCollection->Get($Name);
    }

    /**
     * Removes a registered service by name.
     *
     * @param mixed $Name The service name.
     *
     * @return bool True if the service was removed, false otherwise.
     */
    function RemoveService(mixed $Name) : bool
    {
        return $this->_ServiceCollection->Remove($Name);
    }

    /**
     * Checks if the service is already registered in the container.
     *
     * @param string $Name The service name.
     *
     * @return bool True if the service exists, false otherwise.
     */
    function ContainsService(string $Name) : bool
    {
        return $this->_ServiceCollection->ContainsKey($Name);
    }

    /**
     * Executes the registered exception handler.
     *
     * @param \Throwable $Error The thrown exception
     *
     * @return void
     */
    private function _ExecuteEexceptionHandler(\Throwable $Error) : void
    {
        echo '<pre>' . __CLASS__ . ' | ' . print_R($Error, 1); exit;

        $AttributeCollection = $this->GetAttributeCollection();
        $MainContainer = $this->GetMainContainer();

        $FilteredCollection = $AttributeCollection->GetExceptionHandler();
        $FilteredCollection->FilterTargetA(get_class($Error));

        $FilteredCollection->Each(
            fn($Attribute) => $Attribute->Execute($Error, $MainContainer)
        );

        $FilteredCollection = $AttributeCollection->GetExceptionHandler();
        $FilteredCollection->FilterTargetA(get_class($MainContainer));
        
        $FilteredCollection->Each(
            fn($Attribute) => $Attribute->Execute($Error, $MainContainer)
        );

        $FilteredCollection = $AttributeCollection->GetExceptionHandler();
        $FilteredCollection->FilterTargetA(get_class($this));

        $FilteredCollection->Each(
            fn($Attribute) => $Attribute->Execute($Error, $MainContainer)
        );
    }

    /**
     * Executes the registered error handler.
     *
     * @param array $Args Error handler arguments (Code, Message, File, Line)
     *
     * @return void
     */
    private function _ExecuteErrorHandler(array $Args) : void
    {
        echo '<!-- ' . print_R($Args, 1) . ' -->' . PHP_EOL;

        /*
        $Data = array_combine(['Code', 'Text', 'File', 'Line'], $Args);

        $AttributeCollection = $this->GetAttributeCollection();
        $MainContainer = $this->GetMainContainer();

        $FilteredCollection = $AttributeCollection->GetErrorHandler();
        $FilteredCollection->FilterTargetA(get_class($this));

        $FilteredCollection->Each(
            fn($Attribute) => $Attribute->Execute($Data, $MainContainer)
        );
        */
    }

    /**
     * Executes shutdown routines for all containers.
     *
     * @return void
     */
    private function _ExecuteShutdownHandler() : void
    {
        /*
        $AttributeCollection = $this->GetAttributeCollection();
        $MainContainer = $this->GetMainContainer();

        $FilteredCollection = $AttributeCollection->GetShutdownHandler();
        $FilteredCollection->FilterTargetA(get_class($MainContainer));
        
        $FilteredCollection->Each(
            fn($Attribute) => $Attribute->Execute($MainContainer)
        );

        $FilteredCollection = $AttributeCollection->GetShutdownHandler();
        $FilteredCollection->FilterTargetA(get_class($this));

        $FilteredCollection->Each(
            fn($Attribute) => $Attribute->Execute($MainContainer)
        );
        */
    }

    /**
     * Loads and registers a service provider by name using attribute metadata.
     *
     * @param string $Name The name of the service to load.
     *
     * @return void The function does not return any value after execution.
     */
    private function _LoadedServiceProvider(string $Name) : void
    {
        $AttributeCollection = $this->GetAttributeCollection();
        $FilteredCollection = $AttributeCollection->GetProvider($Name);

        if(!$Attribute = $FilteredCollection->GetFirstValue())
        {
            throw new MissingServiceProviderException($Name);
        }

        $ProviderClass = (string) $Attribute->GetClass();
        $MainContainer = $this->GetMainContainer();

        $ServiceProvider = new $ProviderClass($MainContainer);
        $ServiceProvider->Register($MainContainer, $Name);
    }
}
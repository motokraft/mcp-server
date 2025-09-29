<?php namespace Motokraft\MCPServer\Container;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Caching\ICachingBuilder;
use Motokraft\MCPServer\Interfaces\Collection\IAttributeCollection;
use Motokraft\MCPServer\Interfaces\Collection\IDependencyCollection;
use Motokraft\MCPServer\Interfaces\Collection\IRepositoryCollection;
use Motokraft\MCPServer\Interfaces\Collection\IServiceCollection;
use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;
use Motokraft\MCPServer\Interfaces\Database\IDatabaseBuilder;
use Motokraft\MCPServer\Interfaces\Environment\IEnvironmentBuilder;
use Motokraft\MCPServer\Interfaces\Configuration\IConfigurationBuilder;
use Motokraft\MCPServer\Interfaces\Language\ILanguageBuilder;
use Motokraft\MCPServer\Interfaces\Session\ISessionProvider;
use Motokraft\MCPServer\Interfaces\Breadcrumb\IBreadcrumbBuilder;
use Motokraft\MCPServer\Traits\Environment\EnvironmentTrait;
use Motokraft\MCPServer\Collection\ServiceCollection;
use Motokraft\MCPServer\Exception\Container\MissingServiceProviderException;

class ContainerBuilder implements IContainerBuilder
{
    /**
     * Contains an array of default settings.
     */
    use EnvironmentTrait;

    /**
     * Collection of registered service instances.
     *
     * @var IServiceCollection
     */
    private ?IServiceCollection $_ServiceCollection = null;

    /**
     * Initializes a new instance of the container builder.
     *
     * @return void The function does not return any value after execution.
     */
    function __construct()
    {
        $this->_ServiceCollection = new ServiceCollection;
    }

    /**
     * Returns the attribute collection from the environment.
     *
     * @return IAttributeCollection The attribute collection.
     */
    function GetAttributeCollection() : IAttributeCollection
    {
        $Environment = $this->GetEnvironmentBuilder();
        return $Environment->GetAttributeCollection();
    }

    /**
     * Returns the repository collection from the environment.
     *
     * @return IRepositoryCollection The repository collection.
     */
    function GetRepositoryCollection() : IRepositoryCollection
    {
        $Environment = $this->GetEnvironmentBuilder();
        return $Environment->GetRepositoryCollection();
    }

    /**
     * Returns the dependency collection from the environment.
     *
     * @return IDependencyCollection The dependency collection.
     */
    function GetDependencyCollection() : IDependencyCollection
    {
        $Environment = $this->GetEnvironmentBuilder();
        return $Environment->GetDependencyCollection();
    }

    /**
     * Returns the configuration builder instance.
     *
     * @return IConfigurationBuilder Provides access to application configuration settings.
     */
    function GetConfigurationBuilder() : IConfigurationBuilder
    {
        return $this->Get(IConfigurationBuilder::class);
    }

    /**
     * Retrieves the database provider service.
     *
     * @return IDatabaseBuilder The database provider instance.
     */
    function GetDatabaseBuilder() : IDatabaseBuilder
    {
        return $this->Get(IDatabaseBuilder::class);
    }

    /**
     * Retrieves the caching builder service.
     *
     * @return ICachingBuilder The caching builder instance.
     */
    function GetCachingBuilder() : ICachingBuilder
    {
        return $this->Get(ICachingBuilder::class);
    }

    /**
     * Retrieves the caching builder service.
     *
     * @return ISessionProvider The caching builder instance.
     */
    function GetSessionBuilder() : ISessionProvider
    {
        return $this->Get(ISessionProvider::class);
    }

    /**
     * Retrieves the database provider service.
     *
     * @return ILanguageBuilder The database provider instance.
     */
    function GetLanguageBuilder() : ILanguageBuilder
    {
        return $this->Get(ILanguageBuilder::class);
    }

    /**
     * Retrieves the caching builder service.
     *
     * @return IBreadcrumbBuilder The caching builder instance.
     */
    function GetBreadcrumbBuilder() : IBreadcrumbBuilder
    {
        return $this->Get(IBreadcrumbBuilder::class);
    }

    /**
     * Retrieves the database provider service.
     *
     * @return IServiceCollection The database provider instance.
     */
    function GetServiceCollection() : IServiceCollection
    {
        return $this->_ServiceCollection;
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
     * @param string $Name The service name
     *
     * @return object The service instance.
     */
    function Get(string $Name) : object
    {
        $Environment = $this->GetEnvironmentBuilder();

        if($Environment->ContainsService($Name))
        {
            return $Environment->GetService($Name);
        }

        if(!$this->ContainsService($Name))
        {
            $this->_LoadedServiceProvider($Name);
        }

        if($Environment->ContainsService($Name))
        {
            return $Environment->GetService($Name);
        }

        return $this->_ServiceCollection->Get($Name);
    }

    /**
     * Removes a registered service by name.
     *
     * @param string $Name The service name.
     *
     * @return bool True if the service was removed, false otherwise.
     */
    function Remove(string $Name) : bool
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
     * Loads and registers a service provider by name using attribute metadata.
     *
     * @param string $Name The name of the service to load.
     *
     * @return void The function does not return any value after execution.
     */
    private function _LoadedServiceProvider(string $Name) : void
    {
        $Attribute = $this->GetAttributeCollection();

        $FilteredCollection = $Attribute->GetServiceProvider();
        $FilteredCollection->FilterTargetA($Name);

        if(!$Attribute = $FilteredCollection->GetFirstValue())
        {
            throw new MissingServiceProviderException($Name);
        }

        $ProviderClass = (string) $Attribute->GetClass();

        $ServiceProvider = new $ProviderClass($this);
        $ServiceProvider->Register($this, $Name);
    }
}
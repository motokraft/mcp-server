<?php namespace Motokraft\MCPServer\Collection;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Attribute\IAttributeBuilder;
use Motokraft\MCPServer\Interfaces\Collection\IAttributeCollection;
use Motokraft\MCPServer\Interfaces\Generic\ICollection;
use Motokraft\MCPServer\Interfaces\Collection\IFilteredCollection;
use Motokraft\MCPServer\Interfaces\Attribute\IServiceAttribute;
use Motokraft\MCPServer\Interfaces\Attribute\IProviderAttribute;
use Motokraft\MCPServer\Interfaces\Attribute\IMethodAttribute;
use Motokraft\MCPServer\Interfaces\Attribute\IControllerAttribute;
use Motokraft\MCPServer\Interfaces\Attribute\IViewAttribute;
use Motokraft\MCPServer\Interfaces\Attribute\IRendererAttribute;
use Motokraft\MCPServer\Interfaces\Attribute\IHandlerAttribute;
use Motokraft\MCPServer\Interfaces\Attribute\ISidebarAttribute;
use Motokraft\MCPServer\Interfaces\Attribute\IFieldAttribute;
use Motokraft\MCPServer\Interfaces\Attribute\IPropertyAttribute;
use Motokraft\MCPServer\Interfaces\Mvc\IControllerBuilder;
use Motokraft\MCPServer\Interfaces\Mvc\IViewBuilder;
use Motokraft\MCPServer\Interfaces\Handlers\IExceptionHandler;
use Motokraft\MCPServer\Interfaces\Handlers\IRouteHandler;
use Motokraft\MCPServer\Interfaces\Container\IShutdownHandler;
use Motokraft\MCPServer\Interfaces\Sidebar\ISidebarBuilder;
use Motokraft\MCPServer\Interfaces\Form\IFieldBuilder;
use Motokraft\MCPServer\Traits\Generic\CollectionTrait;
use Motokraft\MCPServer\Collection\FilteredCollection;

class AttributeCollection implements IAttributeCollection
{
    /**
     * Contains an array of default settings.
     */
    use CollectionTrait;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param |array $Items Log settings array
     *
     * @return void
     */
    function __construct(array $Items)
    {
        $this->_Items = $Items;

        $this->Usort(function ($One, $Two) {
            $OPriority = (int) $One->GetPriority();
            $TPriority = (int) $Two->GetPriority();

            if ($OPriority == $TPriority) return 0;
            return ($OPriority < $TPriority) ? -1 : 1;
        });
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return IFilteredCollection
     */
    function GetServiceProvider() : IFilteredCollection
    {
        $Collection = $this->GetFilteredCollection();
        $Collection->FilterInstance(IProviderAttribute::class);

        return $Collection;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return IFilteredCollection
     */
    function GetFilteredCollection() : IFilteredCollection
    {
        return new FilteredCollection($this);
    }
}
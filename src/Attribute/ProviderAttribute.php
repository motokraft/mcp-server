<?php namespace Motokraft\MCPServer\Attribute;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Attribute\IProviderAttribute;
use Motokraft\MCPServer\Interfaces\Container\IContainerBuilder;

#[\Attribute(\Attribute::TARGET_CLASS)]
class ProviderAttribute extends AttributeBuilder implements IProviderAttribute
{
    /**
     * The route that is currently being used in the application
     *
     * @var string
     */
    private ?string $_Target = null;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Name Log settings array
     * @param string $Target Log settings array
     *
     * @return void
     */
    function __construct(string $Name, string $Target)
    {
        parent::__construct($Name);
        $this->SetTarget($Target);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function SetTarget(string $Value) : void
    {
        $this->_Target = $Value;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetTarget() : ?string
    {
        return $this->_Target;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasTargetA(string $Value) : bool
    {   
        return is_a($this->_Target, $Value, true);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasTarget(string $Value) : bool
    {
        return ($this->_Target === $Value);
    }
}
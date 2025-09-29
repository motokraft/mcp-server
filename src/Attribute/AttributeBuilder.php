<?php namespace Motokraft\MCPServer\Attribute;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Interfaces\Attribute\IAttributeBuilder;

class AttributeBuilder implements IAttributeBuilder
{
    /**
     * The route that is currently being used in the application
     *
     * @var string
     */
    private ?string $_Name = null;

    /**
     * The route that is currently being used in the application
     *
     * @var string
     */
    private ?string $_Class = null;

    /**
     * The route that is currently being used in the application
     *
     * @var int
     */
    private int $_Priority  = 0;

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Name Log settings array
     * @param int $Priority Log settings array
     *
     * @return void
     */
    function __construct(string $Name, int $Priority = 0)
    {
        $this->_Name = $Name;
        // $this->SetPriority($Priority);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetName() : ?string
    {
        return $this->_Name;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasName(string $Value) : bool
    {
        return ($this->_Name === $Value);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return void
     */
    function SetClass(string $Value) : void
    {
        $this->_Class = $Value;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return string
     */
    function GetClass() : ?string
    {
        return $this->_Class;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasClassA(string $Value) : bool
    {
        return is_a($this->_Class, $Value, true);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasClass(string $Value) : bool
    {
        return ($this->_Class === $Value);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param string $Value Log settings array
     *
     * @return bool true
     * @return bool false
     */
    function HasInstance(string $Value) : bool
    {
        return ($this instanceof $Value);
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @param int $Value Log settings array
     *
     * @return void
     */
    function SetPriority(int $Value) : void
    {
        $this->_Priority = $Value;
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return int
     */
    function GetPriority() : int
    {
        return $this->_Priority;
    }
}
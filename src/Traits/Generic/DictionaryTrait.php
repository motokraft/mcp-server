<?php namespace Motokraft\MCPServer\Traits\Generic;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

use Motokraft\MCPServer\Exception\InvalidCallbackException;

trait DictionaryTrait
{
    /**
     * Internal storage for additional properties
     *
     * @var array<mixed, mixed>
     */
    private array $_Properties = [];

    /**
     * Loads public properties from an object or stdClass into the dictionary
     *
     * @param object $Object Source object or stdClass
     *
     * @return void Function does not return anything after execution
     */
    function LoadedObject(object $Object) : void
    {
        if($Object instanceof \stdClass)
        {
            $this->LoadedArray((array) $Object);
        }
        else
        {
            $this->LoadedArray($Object->GetCombine());
        }
    }

    /**
     * Loads key-value pairs from an array into the dictionary
     *
     * @param array<mixed, mixed> $Data Source data array
     *
     * @return void Function does not return anything after execution
     */
    function LoadedArray(array $Data) : void
    {
        foreach($Data as $Name => $Value)
        {
            $this->Add($Name, $Value);
        }
    }

    /**
     * Decodes a JSON string and loads its values into the dictionary
     *
     * @param string $Result JSON string to decode
     *
     * @throws JsonParseException If JSON decoding fails
     *
     * @return void Function does not return anything after execution
     */
    function LoadedString(string $Result) : void
    {
        $Data = (array) json_decode($Result);

        if(json_last_error() === JSON_ERROR_NONE)
        {
            $this->LoadedArray($Data);
        }
        else
        {
            throw new \Exception('Error', 500);
        }
    }

    /**
     * Returns all dictionary entries
     *
     * @return array<mixed, mixed> The underlying properties array
     */
    function GetProperties() : array
    {
        return $this->_Properties;
    }

    /**
     * Alias for GetProperties()
     *
     * @return array<mixed, mixed> The underlying properties array
     */
    function GetCombine() : array
    {
        return $this->GetProperties();
    }

    /**
     * Adds a key-value pair to properties or to the dictionary storage
     *
     * @param mixed $Key Property name or dynamic key
     * @param mixed $Value Value to assign
     *
     * @return void Function does not return anything after execution
     */
    function Add(mixed $Key, mixed $Value) : void
    {
        if($this->ExistsProperty($Key))
        {
            $this->{$Key} = $Value;
        }
        else
        {
            $this->_Properties[$Key] = $Value;
        }
    }

    /**
     * Retrieves a value by key or returns a default
     *
     * @param mixed $Key Property name or dynamic key
     * @param mixed $Default Default value if key does not exist
     *
     * @return mixed The value or default
     */
    function GetValue(mixed $Key, mixed $Default = null) : mixed
    {
        if($this->ExistsProperty($Key))
        {
            return $this->{$Key};
        }
        else if(isset($this->_Properties[$Key]))
        {
            return $this->_Properties[$Key];
        }

        return $Default;
    }

    /**
     * Removes a key from object properties or dictionary storage
     *
     * @param mixed $Key Property name or dynamic key
     *
     * @return bool true if the key existed and was removed
     * @return bool false otherwise
     */
    function Remove(mixed $Key) : bool
    {
        if($this->ExistsProperty($Key))
        {
            unset($this->{$Key});
            return true;
        }
        else if($this->ContainsProperty($Key))
        {
            unset($this->_Properties[$Key]);
            return true;
        }

        return false;
    }

    /**
     * Checks if a public class property exists
     *
     * @param mixed $Key Property name to check
     *
     * @return bool true if a class property exists
     * @return bool false otherwise
     */
    function ExistsProperty(mixed $Key) : bool
    {
        return property_exists($this, $Key);
    }

    /**
     * Checks if a dynamic dictionary key exists
     *
     * @param mixed $Key Dynamic key to check
     *
     * @return bool true if the key exists
     * @return bool false otherwise
     */
    function ContainsKey(mixed $Key) : bool
    {
        if($this->ExistsProperty($Key))
        {
            return true;
        }

        return $this->ContainsProperty($Key);
    }

    /**
     * Checks if a dynamic dictionary key exists
     *
     * @param mixed $Key Dynamic key to check in properties array
     *
     * @return bool true if the key exists in the properties array
     * @return bool false otherwise
     */
    function ContainsProperty(mixed $Key) : bool
    {
        return array_key_exists($Key, $this->_Properties);
    }

    /**
     * Transforms entries via a callback and returns a new array
     *
     * @param callable $Callback Function to apply on each item
     *
     * @throws InvalidCallbackException If callback is not callable
     *
     * @return array<mixed, mixed> The mapped array
     */
    function Map(callable $Callback) : array
    {
        if(!is_callable($Callback))
        {
            throw new InvalidCallbackException($Callback);
        }

        $Result = [];

        foreach($this as $Key => $Item)
        {
            $Result[$Key] = $Callback($Item, $Key);
        }

        return $Result;
    }

    /**
     * Filters entries via a callback and returns a new array
     *
     * @param callable $Callback Function to determine inclusion
     *
     * @throws InvalidCallbackException If callback is not callable
     *
     * @return array<mixed, mixed> The filtered array
     */
    function Filter(callable $Callback) : array
    {
        if(!is_callable($Callback))
        {
            throw new InvalidCallbackException($Callback);
        }

        $Result = [];

        foreach($this as $Key => $Item)
        {
            if(!$Callback($Item, $Key))
            {
                continue;
            }

            $Result[$Key] = $Item;
        }

        return $Result;
    }

    /**
     * Executes a callback for each entry without returning
     *
     * @param callable $Callback Function to execute on each item
     *
     * @throws InvalidCallbackException If callback is not callable
     *
     * @return void Function does not return anything after execution
     */
    function Each(callable $Callback) : void
    {
        if(!is_callable($Callback))
        {
            throw new InvalidCallbackException($Callback);
        }

        foreach($this as $Key => $Item)
        {
            $Callback($Item, $Key);
        }
    }

    /**
     * Creates a new instance of the AbstractLogging class
     *
     * @return bool true
     * @return bool false
     */
    function IsEmptyDictionary() : bool
    {
        return !count($this->_Properties);
    }

    /**
     * Checks if a key exists (ArrayAccess support)
     *
     * @param mixed $Key Key to check
     *
     * @return bool true if key exists
     * @return bool false if key does not exist
     */
    function OffsetExists(mixed $Key) : bool
    {
        return $this->ContainsKey($Key);
    }

    /**
     * Retrieves a value by key (ArrayAccess support)
     *
     * @param mixed $Key Key to retrieve
     *
     * @return mixed The value associated with the key
     */
    function OffsetGet(mixed $Key) : mixed
    {
        return $this->GetValue($Key);
    }

    /**
     * Sets a value for a key (ArrayAccess support)
     *
     * @param mixed $Key Key to set
     * @param mixed $Value Value to associate
     *
     * @return void The function does not return anything after execution
     */
    function OffsetSet(mixed $Key, mixed $Value) : void
    {
        $this->Add($Key, $Value);
    }

    /**
     * Unsets a key (ArrayAccess support)
     *
     * @param mixed $Key Key to unset
     *
     * @return void The function does not return anything after execution
     */
    function OffsetUnset(mixed $Key) : void
    {
        if($this->ContainsKey($Key)) $this->Remove($Key);
    }

    /**
     * Magic setter to allow dynamic property assignment
     *
     * @param mixed $Key Property name or dynamic key
     * @param mixed $Value Value to assign
     *
     * @return void Function does not return anything after execution
     */
    function __set(mixed $Key, mixed $Value) : void
    {
        $this->Add($Key, $Value);
    }

    /**
     * Magic getter to allow dynamic property retrieval
     *
     * @param mixed $Key Property name or dynamic key
     *
     * @return mixed The value associated with the key or null
     */
    function __get(mixed $Key) : mixed
    {
        return $this->GetValue($Key);
    }
}
<?php

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

abstract class ClassLoader
{
    /**
     * Singleton instance of the environment builder.
     *
     * @var IEnvironmentBuilder
     */
    private static ?IEnvironmentBuilder $_EnvironmentBuilder = null;

    /**
     * Map of class names to file paths to scan for autoloading.
     *
     * @var array<string, string>
     */
    private static array $_ScaningNamespaces = [];

    /**
     * List of collected class-level attributes.
     *
     * @var array<number, IAttributeBuilder>
     */
    private static array $_ScaningAttributes = [];

    /**
     * Creates a new instance of the AbstractLogger class
     *
     * @return IEnvironmentBuilder
     */
    final static function CreateEnvironmentBuilder() : IEnvironmentBuilder
    {
        if(null !== self::$_EnvironmentBuilder)
        {
            throw new \LogicException('EnvironmentBuilder has already been initialized.', 500);
        }

        spl_autoload_register(
            fn($Namespace) => self::_UsingNamespace($Namespace)
        );

        require_once VENDOR_PATH . DS . 'functions.php';
        self::_ScanningDirectory(ROOT_PATH . DS . 'src');

        self::$_EnvironmentBuilder = new EnvironmentBuilder(
            self::$_ScaningAttributes
        );

        return self::$_EnvironmentBuilder;
    }

    /**
     * Returns the existing instance of the environment builder.
     *
     * @return IEnvironmentBuilder
     */
    final static function GetEnvironmentBuilder() : IEnvironmentBuilder
    {
        if(null === self::$_EnvironmentBuilder)
        {
            throw new \RuntimeException('EnvironmentBuilder is not initialized.', 500);
        }

        return self::$_EnvironmentBuilder;
    }

    /**
     * Loads a specific namespace and includes its file.
     *
     * @param string $Namespace Fully-qualified class name.
     *
     * @return void
     */
    private static function _UsingNamespace(string $Namespace) : void
    {
        if(!isset(self::$_ScaningNamespaces[$Namespace]))
        {
            header('HTTP/1.1 500 The application cannot be loaded');

            throw new \RuntimeException(
                sprintf('Namespace not found: %s', $Namespace), 500
            );
        }

        $FilePath = self::$_ScaningNamespaces[$Namespace];

        if(!is_readable($FilePath))
        {
            header('HTTP/1.1 500 The application cannot be loaded');

            throw new \RuntimeException(
                sprintf('File not readable: %s', $FilePath), 500
            );
        }

        if(!in_array($FilePath, get_included_files()))
        {
            require_once (string) $FilePath;
        }
    }

    /**
     * Recursively scans a directory and registers PHP files.
     *
     * @param string $FolderPath Absolute path to the directory to scan.
     *
     * @return void
     */
    private static function _ScanningDirectory(string $FolderPath) : void
    {
        $Iterator = new \RecursiveDirectoryIterator($FolderPath);

        $Iterator = new \RecursiveCallbackFilterIterator(
            $Iterator, fn($Item) => (bool) $Item->IsReadable()
        );

        $Iterator = new \RecursiveIteratorIterator($Iterator);
        $Iterator = new \RegexIterator($Iterator, '/^.+\.php$/i');

        foreach($Iterator as $Item) self::_PrepareFile($Item);
    }

    /**
     * Parses a PHP file and maps classes to their file path.
     *
     * @param \SplFileInfo File object representing the PHP file.
     *
     * @return void
     */
    private static function _PrepareFile(\SplFileInfo $File) : void
    {
        if(!fcontent($File, $Content)) return;
        $Tokens = \PhpToken::Tokenize($Content);

        $Ids = [T_INTERFACE, T_TRAIT, T_CLASS];
        $Namespace = '';

        foreach($Tokens as $Key => $Token)
        {
            if($Token->is(T_NAMESPACE) && !$Namespace)
            {
                $Namespace = $Tokens[$Key + 2]->text;
                continue;
            }

            if(!in_array($Token->id, $Ids, true))
            {
                continue;
            }

            if(!$Tokens[$Key + 2]->is(T_STRING))
            {
                continue;
            }

            $Class = strval($Tokens[$Key + 2]->text);
            $Namespace = trim($Namespace . '\\' . $Class);

            $Path = (string) $File->GetRealPath();
            self::$_ScaningNamespaces[$Namespace] = $Path;
        }
    }

    /**
     * Collects and processes attributes for a class and its members.
     *
     * @param string $Class Fully-qualified class name.
     *
     * @return void
     */
    private static function _PrepareClassAttribute(string $Class) : void
    {
        static $IgnoreClasses = [];

        if(in_array($Class, $IgnoreClasses))
        {
            return;
        }

        if(strpos($Class, 'Interface') !== false)
        {
            array_push($IgnoreClasses, $Class);
            return;
        }
        else if(strpos($Class, 'Trait') !== false)
        {
            array_push($IgnoreClasses, $Class);
            return;
        }
        else if(strpos($Class, 'Attribute') !== false)
        {
            array_push($IgnoreClasses, $Class);
            return;
        }

        if(!class_exists($Class, true))
        {
            array_push($IgnoreClasses, $Class);
            return;
        }

        $Reflection = new \ReflectionClass($Class);

        if((bool) $Reflection->IsInterface())
        {
            array_push($IgnoreClasses, $Class);
            return;
        }

        if((bool) $Reflection->IsAnonymous())
        {
            array_push($IgnoreClasses, $Class);
            return;
        }

        if((bool) $Reflection->IsTrait())
        {
            array_push($IgnoreClasses, $Class);
            return;
        }

        $Attributes = (array) $Reflection->GetAttributes();
        $Collection = new Collection($Attributes);

        $Collection = $Collection->Filter(
            fn($Attribute) => self::_FilterAttribute($Attribute)
        );

        $Collection = $Collection->Map(
            fn($Attribute) => $Attribute->NewInstance()
        );

        $Collection->Each(
            fn($Attribute) => $Attribute->SetClass($Class)
        );

        $Collection->Each(
            fn($Attribute) => self::_PrepareAttribute($Attribute)
        );

        foreach($Reflection->GetProperties() as $Property)
        {
            self::_PreparePropertyAttribute($Property);
        }

        foreach($Reflection->GetMethods() as $Method)
        {
            self::_PrepareMethodAttribute($Method);
        }
    }

    /**
     * Collects and processes attributes for a class property.
     *
     * @param \ReflectionProperty $Property The class property reflection.
     *
     * @return void
     */
    private static function _PreparePropertyAttribute(\ReflectionProperty $Property) : void
    {
        $Name = (string) $Property->GetName();
        $Class = $Property->GetDeclaringClass()->GetName();

        $Attributes = (array) $Property->GetAttributes();
        $Collection = new Collection($Attributes);

        $Collection = $Collection->Filter(
            fn($attr) => self::_FilterAttribute($attr)
        );

        $Collection = $Collection->Map(
            fn($Attribute) => $Attribute->NewInstance()
        );

        $Collection->Each(
            fn($Attribute) => $Attribute->SetClass($Class)
        );

        $Collection->Each(
            fn($Attribute) => $Attribute->SetProperty($Name)
        );

        $Collection->Each(
            fn($Attribute) => self::_PrepareAttribute($Attribute)
        );
    }

    /**
     * Collects and processes attributes for a class method.
     *
     * @param \ReflectionMethod $Method The class method reflection.
     *
     * @return void
     */
    private static function _PrepareMethodAttribute(\ReflectionMethod $Method) : void
    {
        static $IgnoreMethods = [];

        $Name = (string) $Method->GetName();

        if(in_array($Name, $IgnoreMethods))
        {
            return;
        }

        if(strpos($Name, '__') !== false)
        {
            array_push($IgnoreMethods, $Name);
            return;
        }
        else if($Method->isAbstract())
        {
            array_push($IgnoreMethods, $Name);
            return;
        }
        else if($Method->isConstructor())
        {
            array_push($IgnoreMethods, $Name);
            return;
        }
        else if($Method->isDestructor())
        {
            array_push($IgnoreMethods, $Name);
            return;
        }
        else if($Method->isPrivate())
        {
            array_push($IgnoreMethods, $Name);
            return;
        }
        else if($Method->isProtected())
        {
            array_push($IgnoreMethods, $Name);
            return;
        }

        $Class = $Method->GetDeclaringClass();

        if(!$Class = (string) $Class->GetName())
        {
            array_push($IgnoreMethods, $Name);
            return;
        }

        $implements = class_implements($Class);

        if(in_array('ArrayAccess', $implements))
        {
            array_push($IgnoreMethods, $Name);
            return;
        }

        $Attributes = (array) $Method->GetAttributes();
        $Collection = new Collection($Attributes);

        $Collection = $Collection->Filter(
            fn($attr) => self::_FilterAttribute($attr)
        );

        $Collection = $Collection->Map(
            fn($Attribute) => $Attribute->NewInstance()
        );

        $Collection->Each(
            fn($Attribute) => $Attribute->SetClass($Class)
        );

        $Collection->Each(
            fn($Attribute) => $Attribute->SetMethod($Name)
        );

        $Collection->Each(
            fn($Attribute) => self::_PrepareAttribute($Attribute)
        );
    }

    /**
     * Checks if a given attribute implements the IAttributeBuilder interface.
     *
     * @param \ReflectionAttribute $Attribute $Attribute The reflection attribute.
     *
     * @return bool true if it is an IAttributeBuilder, false otherwise.
     */
    private static function _FilterAttribute(\ReflectionAttribute $Attribute) : bool
    {
        return is_a($Attribute->GetName(), IAttributeBuilder::class, true);
    }

    /**
     * Adds an attribute to the internal collection of scanned attributes.
     *
     * @param IAttributeBuilder $Attribute An instance of a class-level attribute.
     *
     * @return void
     */
    private static function _PrepareAttribute(IAttributeBuilder $Attribute) : void
    {
        array_push(self::$_ScaningAttributes, $Attribute);
    }
}
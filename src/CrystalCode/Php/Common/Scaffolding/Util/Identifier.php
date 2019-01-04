<?php

namespace CrystalCode\Php\Common\Scaffolding\Util;

final class Identifier
{

    /**
     * 
     * @var string
     */
    const PATTERN = '([A-Z]+(?![a-z])|[A-Z][a-z]+|[A-Z]+|[a-z]+|[0-9]+)';

    /**
     * 
     * @param string $name
     * @return iterable|string[]
     */
    public static function getParts(string $name): iterable
    {
        $matches = [];
        if (preg_match_all(self::PATTERN, $name, $matches) > 0) {
            foreach (current($matches) as $part) {
                yield strtolower($part);
            }
            return;
        }
        return [$name];
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getSingleClassName(string $name): string
    {
        $parts = [];
        foreach (self::getParts($name) as $part) {
            $parts[] = ucfirst(strtolower($part));
        }
        return implode($parts);
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getSingleFieldName(string $name): string
    {
        $parts = [];
        foreach (self::getParts($name) as $part) {
            if (count($parts) === 0) {
                $parts[] = strtolower($part);
                continue;
            }
            $parts[] = ucfirst(strtolower($part));
        }
        return implode($parts);
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getSingleConstName(string $name): string
    {
        $parts = [];
        foreach (self::getParts($name) as $part) {
            $parts[] = strtoupper($part);
        }
        return implode('_', $parts);
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getSingleXhtmlName(string $name): string
    {
        $parts = [];
        foreach (self::getParts($name) as $part) {
            $parts[] = strtolower($part);
        }
        return implode('-', $parts);
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getSingleTitleName(string $name): string
    {
        $parts = [];
        foreach (self::getParts($name) as $part) {
            $parts[] = ucfirst(strtolower($part));
        }
        return implode(' ', $parts);
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getPluralClassName(string $name): string
    {
        return self::getSingleClassName($name . 'List');
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getPluralFieldName(string $name): string
    {
        return self::getSingleFieldName($name . 'List');
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getPluralConstName(string $name): string
    {
        return self::getSingleConstName($name . 'List');
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getPluralXhtmlName(string $name): string
    {
        return self::getSingleXhtmlName($name . 'List');
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getPluralTitleName(string $name): string
    {
        return self::getSingleTitleName($name . 'List');
    }

}

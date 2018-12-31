<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Templates;

use CrystalCode\Php\Common\ArgumentException;
use IteratorAggregate;
use Traversable;

final class TemplateProviderValues implements IteratorAggregate
{

    /**
     * 
     * @param type $values
     * @return TemplateProviderValues
     * @throws ArgumentException
     */
    public static function create($values): TemplateProviderValues
    {
        if (is_array($values)) {
            return self::createFromIterable($values);
        }

        if (is_object($values)) {
            if ($values instanceof Traversable) {
                return self::createFromIterable($values);
            }

            return self::createFromObject($values);
        }

        throw new ArgumentException('values');
    }

    /**
     * 
     * @param object $object
     * @return TemplateProviderValues
     */
    public static function createFromObject(object $object): TemplateProviderValues
    {
        $values = get_object_vars($object);
        return new TemplateProviderValues($values);
    }

    /**
     * 
     * @param iterable $iterable
     * @return TemplateProviderValues
     */
    public static function createFromIterable(iterable $iterable): TemplateProviderValues
    {
        return new TemplateProviderValues($iterable);
    }

    /**
     *
     * @var array
     */
    private $values = [];

    /**
     * 
     * @param iterable $values
     */
    public function __construct(iterable $values)
    {
        foreach ($values as $name => $value) {
            $this->values[(string) $name] = $value;
        }
    }

    /**
     * 
     * @param string $name
     * @return mixed
     */
    public function &__get(string $name)
    {
        if (isset($this->values[$name])) {
            return $this->values[$name];
        }

        return null;
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->values[$name] = $value;
    }

    /**
     * 
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->values[$name]);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        foreach ($this->values as $name => $value) {
            yield $name => $value;
        }
    }

}

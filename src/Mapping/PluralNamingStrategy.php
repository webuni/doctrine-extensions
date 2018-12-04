<?php

declare(strict_types=1);

/*
 * This is part of the webuni/doctrine-extensions package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\DoctrineExtensions\Mapping;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\Mapping\NamingStrategy;

final class PluralNamingStrategy implements NamingStrategy
{
    private $cache = [];
    private $strategy;

    public function __construct(NamingStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function classToTableName($className): string
    {
        return $this->strategy->classToTableName($this->pluralize($className));
    }

    public function propertyToColumnName($propertyName, $className = null): string
    {
        return $this->strategy->propertyToColumnName($propertyName, $this->pluralize($className));
    }

    public function embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className = null, $embeddedClassName = null): string
    {
        return $this->strategy->embeddedFieldToColumnName($propertyName, $embeddedColumnName, $this->pluralize($className), $embeddedClassName);
    }

    public function referenceColumnName(): string
    {
        return $this->strategy->referenceColumnName();
    }

    public function joinColumnName($propertyName): string
    {
        return $this->strategy->joinColumnName($propertyName);
    }

    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null): string
    {
        return $this->strategy->joinTableName($this->pluralize($sourceEntity), $this->pluralize($targetEntity), $propertyName);
    }

    public function joinKeyColumnName($entityName, $referencedColumnName = null): string
    {
        return $this->strategy->joinKeyColumnName($this->pluralize($entityName), $referencedColumnName);
    }

    private function pluralize(?string $class): ?string
    {
        if (null === $class) {
            return null;
        }

        if (isset($this->cache[$class])) {
            return $this->cache[$class];
        }

        $pos = strrpos($class, '\\');
        if (false !== $pos) {
            $name = substr($class, $pos + 1);
            $namespace = substr($class, 0, $pos);
        } else {
            $name = $class;
            $namespace = '';
        }

        return $this->cache[$class] = ltrim($namespace.'\\'.Inflector::pluralize($name), '\\');
    }
}

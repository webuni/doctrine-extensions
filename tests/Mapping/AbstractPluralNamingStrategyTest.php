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

namespace Webuni\DoctrineExtension\Tests;

use PHPUnit\Framework\TestCase;
use Webuni\DoctrineExtensions\Mapping\PluralNamingStrategy;

abstract class AbstractPluralNamingStrategyTest extends TestCase
{
    /* @var PluralNamingStrategy */
    protected $strategy;

    /**
     * @dataProvider getClassToTableName
     */
    public function testClassToTableName($class, $table): void
    {
        $this->assertEquals($table, $this->strategy->classToTableName($class));
    }

    /**
     * @dataProvider getPropertyToColumnName
     */
    public function testPropertyToColumnName($class, $property, $column): void
    {
        $this->assertEquals($column, $this->strategy->propertyToColumnName($property, $class));
    }

    /**
     * @dataProvider getEmbeddedFieldToColumnName
     */
    public function testEmbeddedFieldToColumnName($class, $embeddedClass, $property, $embeddedColumn, $column): void
    {
        $this->assertEquals($column, $this->strategy->embeddedFieldToColumnName($property, $embeddedColumn, $class, $embeddedClass));
    }

    public function testReferenceColumnName(): void
    {
        $this->assertEquals('id', $this->strategy->referenceColumnName());
    }

    /**
     * @dataProvider getPropertyToColumnName
     */
    public function testJoinColumnName($class, $property, $column): void
    {
        $this->assertEquals($column.'_id', $this->strategy->joinColumnName($property));
    }

    /**
     * @dataProvider getJoinTableName
     */
    public function testJoinTableName($sourceClass, $targetClass, $property, $table): void
    {
        $this->assertEquals($table, $this->strategy->joinTableName($sourceClass, $targetClass, $property));
    }

    /**
     * @dataProvider getJoinKeyColumnName
     */
    public function testJoinKeyColumnName($class, $referencedColumn, $column): void
    {
        $this->assertEquals($column, $this->strategy->joinKeyColumnName($class, $referencedColumn));
    }
}

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

namespace Webuni\DoctrineExtensions\Tests\Mapping;

use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;
use Webuni\DoctrineExtensions\Mapping\AutoQuotingSubscriber;
use Webuni\DoctrineExtensions\Tests\Mapping\Entity\QuotedUser;
use Webuni\DoctrineExtensions\Tests\Mapping\Entity\User;

final class AutoQuotingSubscriberTest extends TestCase
{
    /**
     * @var ClassMetadataFactory
     */
    private $factory;

    /**
     * @var EventManager
     */
    private $evm;

    private $subscriber;

    protected function setUp(): void
    {
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__.'/Entity'], true, null, null, false);
        $em = EntityManager::create(['url' => 'sqlite:///:memory:'], $config);

        $this->evm = $em->getEventManager();
        $this->factory = new ClassMetadataFactory();
        $this->factory->setEntityManager($em);

        $this->subscriber = new AutoQuotingSubscriber();
    }

    public function testTable(): void
    {
        $metadata = $this->getMetadataFor(User::class);
        $this->assertArrayNotHasKey('quoted', $metadata->table);

        $metadata = $this->getMetadataFor(User::class, true);
        $this->assertArraySubset(['name' => 'User', 'quoted' => true], $metadata->table);
    }

    public function testQuotedTable(): void
    {
        $metadata = $this->getMetadataFor(QuotedUser::class);
        $this->assertArrayHasKey('quoted', $metadata->table);

        $metadata = $this->getMetadataFor(QuotedUser::class, true);
        $this->assertArraySubset(['name' => 'user', 'quoted' => true], $metadata->table);
    }

    public function testFields(): void
    {
        $metadata = $this->getMetadataFor(User::class);
        $this->assertArrayHasKey('quoted', $metadata->fieldMappings['select']);
        $this->assertArrayNotHasKey('quoted', $metadata->fieldMappings['where']);

        $metadata = $this->getMetadataFor(User::class, true);
        $this->assertArraySubset(['columnName' => 'select', 'quoted' => true], $metadata->fieldMappings['select']);
        $this->assertArraySubset(['columnName' => 'where', 'quoted' => true], $metadata->fieldMappings['where']);
    }

    public function testAssociations(): void
    {
        $metadata = $this->getMetadataFor(User::class);
        $this->assertArrayNotHasKey('quoted', $metadata->associationMappings['parent']['joinColumns'][0]);
        $this->assertArrayNotHasKey('quoted', $metadata->associationMappings['groups']['joinTable']);
        $this->assertArrayNotHasKey('quoted', $metadata->associationMappings['groups']['joinTable']['joinColumns'][0]);

        $metadata = $this->getMetadataFor(User::class, true);
        $this->assertArrayHasKey('quoted', $metadata->associationMappings['parent']['joinColumns'][0]);
        $this->assertArrayHasKey('quoted', $metadata->associationMappings['groups']['joinTable']);
        $this->assertArrayHasKey('quoted', $metadata->associationMappings['groups']['joinTable']['joinColumns'][0]);
    }

    public function testIndexes(): void
    {
        $metadata = $this->getMetadataFor(User::class);
        $this->assertEquals(['select', 'where'], $metadata->table['indexes']['search_idx']['columns']);

        $metadata = $this->getMetadataFor(User::class, true);
        $this->assertEquals(['`select`', '`where`'], $metadata->table['indexes']['search_idx']['columns']);
    }

    private function getMetadataFor($class, $register = false): ClassMetadataInfo
    {
        $this->factory->setMetadataFor($class, null);

        if ($register) {
            $this->evm->addEventSubscriber($this->subscriber);
        } else {
            $this->evm->removeEventSubscriber($this->subscriber);
        }

        return $this->factory->getMetadataFor($class);
    }
}

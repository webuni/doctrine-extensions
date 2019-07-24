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
use Webuni\DoctrineExtensions\Mapping\PhpDefaultValueSubscriber;
use Webuni\DoctrineExtensions\Tests\Mapping\Entity\User;

final class PhpDefaultValueSubscriberTest extends TestCase
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

        $this->subscriber = new PhpDefaultValueSubscriber();
    }

    /**
     * @dataProvider getDefaultValues
     */
    public function testDefaultValues($field, $value): void
    {
        $metadata = $this->getMetadataFor(User::class);
        $this->assertArrayHasKey($field, $metadata->fieldMappings);
        $mapping = $metadata->fieldMappings[$field];
        $this->assertArrayNotHasKey('default', $mapping);

        $metadata = $this->getMetadataFor(User::class, true);
        $this->assertArrayHasKey($field, $metadata->fieldMappings);

        $mapping = $metadata->fieldMappings[$field];
        $this->assertArrayHasKey('default', $mapping);
        $this->assertSame($value, $mapping['default']);
    }

    public function getDefaultValues(): array
    {
        return [
            ['defaultInteger', 1],
            ['defaultFloat', 1.1],
            ['defaultString', 'def'],
            ['defaultBoolean', 0],
            ['defaultArray', 'a:2:{i:0;s:3:"foo";i:1;s:3:"bar";}'],
            ['defaultSimpleArray', 'foo,bar'],
            ['defaultJson', '{"foo":[1],"bar":["data"]}'],
        ];
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

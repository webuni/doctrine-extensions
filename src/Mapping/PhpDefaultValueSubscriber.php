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

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

final class PhpDefaultValueSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event): void
    {
        $connection = $event->getEntityManager()->getConnection();
        $metadata = $event->getClassMetadata();
        /** @var \ReflectionClass|null */
        $class = $metadata->getReflectionClass();

        // skip special occasions e.g. for make.entity command
        if (null === $class) {
            return;
        }

        foreach ($metadata->getFieldNames() as $field) {
            // skip field with defined default value or embedded field
            if (\array_key_exists('default', $metadata->fieldMappings[$field]) || false !== strpos($field, '.')) {
                continue;
            }

            $this->fixField($connection, $metadata, $this->getPropertyReflection($class, $field));
        }
    }

    private function getPropertyReflection(\ReflectionClass $class, $property)
    {
        $mainClass = $class;
        do {
            if ($class->hasProperty($property)) {
                return $class->getProperty($property);
            }
        } while ($class = $class->getParentClass());

        throw new \InvalidArgumentException(sprintf('Field "%s" does not exist in class "%s".', $property, $mainClass->getName()));
    }

    private function fixField(Connection $connection, ClassMetadata $metadata, \ReflectionProperty $property): void
    {
        $name = $property->getName();

        $properties = $property->getDeclaringClass()->getDefaultProperties();
        if (!isset($properties[$name]) || \is_resource($properties[$name])) {
            return;
        }

        $mapping = $metadata->fieldMappings[$name];
        $type = $mapping['type'];
        $metadata->fieldMappings[$name]['default'] = $connection->convertToDatabaseValue($properties[$name], $type);
    }
}

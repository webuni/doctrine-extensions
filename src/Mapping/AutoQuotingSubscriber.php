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
use Doctrine\DBAL\Schema\AbstractAsset;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\DefaultQuoteStrategy;

/**
 * @see DefaultQuoteStrategy
 */
final class AutoQuotingSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $metadata = $eventArgs->getClassMetadata();
        foreach (array_keys($metadata->fieldMappings) as $id) {
            $metadata->fieldMappings[$id]['quoted'] = true;
        }

        $metadata->table['quoted'] = true;
        $metadata->sequenceGeneratorDefinition['quoted'] = true;

        foreach ($metadata->associationMappings as $id => $mapping) {
            if (isset($mapping['joinTable'])) {
                $metadata->associationMappings[$id]['joinTable']['quoted'] = true;
                if (isset($mapping['joinTable']['joinColumns'])) {
                    foreach (array_keys($mapping['joinTable']['joinColumns']) as $joinColumnId) {
                        $metadata->associationMappings[$id]['joinTable']['joinColumns'][$joinColumnId]['quoted'] = true;
                    }
                }
            }

            if (isset($mapping['joinColumns'])) {
                foreach (array_keys($mapping['joinColumns']) as $joinColumnId) {
                    $metadata->associationMappings[$id]['joinColumns'][$joinColumnId]['quoted'] = true;
                }
            }
        }

        if (isset($metadata->table['indexes'])) {
            foreach ($metadata->table['indexes'] as $index => $config) {
                foreach ($config['columns'] as $id => $name) {
                    $metadata->table['indexes'][$index]['columns'][$id] = $this->quote($name);
                }
            }
        }
    }

    private function quote(string $identifier): string
    {
        return $this->isQuoted($identifier) ? $identifier : '`'.$identifier.'`';
    }

    /**
     * @see AbstractAsset::isIdentifierQuoted()
     */
    private function isQuoted(string $identifier): bool
    {
        return isset($identifier[0]) && ('`' === $identifier[0] || '"' === $identifier[0] || '[' === $identifier[0]);
    }
}

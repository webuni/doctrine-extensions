<?php

namespace Webuni\DoctrineExtensions\Hydration;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Internal\Hydration\AbstractHydrator;
use Doctrine\ORM\Internal\Hydration\HydrationException;

abstract class HydratorDecorator extends AbstractHydrator
{
    public const HINT_DECORATED_HYDRATOR = 'doctrine.decoratedHydrator';

    protected $hydrator;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function iterate($stmt, $resultSetMapping, array $hints = [])
    {
        $hydrator = $this->getHydrator($hints);

        return $hydrator->iterate($stmt, $resultSetMapping, $hints);
    }

    public function hydrateAll($stmt, $resultSetMapping, array $hints = [])
    {
        $hydrator = $this->getHydrator($hints);

        return $hydrator->hydrateAll($stmt, $resultSetMapping, $hints);
    }

    public function hydrateRow()
    {
        throw new HydrationException("hydrateRowData() not implemented by this decorator hydrator.");
    }

    public function onClear($eventArgs)
    {
        throw new HydrationException("hydrateRowData() not implemented by this decorator hydrator.");
    }

    protected function hydrateAllData()
    {
        throw new HydrationException("hydrateRowData() not implemented by this decorator hydrator.");
    }

    protected function getHydrator(array &$hints): AbstractHydrator
    {
        if (null === $this->hydrator) {
            if (!isset($hints[self::HINT_DECORATED_HYDRATOR])) {
                throw new HydrationException(
                    sprintf('Query hint %s::HINT_DECORATED_HYDRATOR must be specified', __CLASS__)
                );
            }

            $hydrators = (array) $hints[self::HINT_DECORATED_HYDRATOR];

            if (empty($hydrators)) {
                throw new HydrationException(
                    sprintf('Query hint %s::HINT_DECORATED_HYDRATOR must not be empty', __CLASS__)
                );
            }

            $hydrator = array_pop($hydrators);
            $this->hydrator = $this->_em->getHydrator($hydrator);
        }

        return $this->hydrator;
    }
}

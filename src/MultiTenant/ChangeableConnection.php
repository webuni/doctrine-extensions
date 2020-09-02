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

namespace Webuni\DoctrineExtensions\MultiTenant;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Webuni\DoctrineExtensions\Decorator\ConnectionDecorator;

final class ChangeableConnection extends ConnectionDecorator
{
    public function __construct(array $params, Driver $driver, ?Configuration $config = null, ?EventManager $eventManager = null)
    {
        $connection = new Connection($params, $driver, $config, $eventManager);
        parent::__construct($connection);
    }

    public function setParams(array $params = [])
    {
        $newParams = array_merge($this->getParams(), $params);
        $diff = array_udiff_assoc($this->getParams(), $newParams, function ($a, $b) {
            return $a !== $b;
        });

        if (empty($diff)) {
            return;
        }

        $connected = $this->isConnected();
        if ($connected) {
            $this->close();
        }

        $connection = new Connection($newParams, $this->getDriver(), $this->getConfiguration(), $this->getEventManager());
        parent::__construct($connection);

        if ($connected) {
            try {
                $this->connect();
            } catch (\Exception $e) {
            }
        }
    }
}

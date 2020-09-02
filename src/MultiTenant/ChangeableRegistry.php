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

use Doctrine\Persistence\ManagerRegistry;
use Webuni\DoctrineExtensions\Persistence\ManagerRegistryDecorator;

final class ChangeableRegistry extends ManagerRegistryDecorator
{
    /**
     * @var TenantProviderInterface
     */
    private $tenantProvider;

    public function __construct(ManagerRegistry $wrapped, TenantProviderInterface $tenantProvider)
    {
        parent::__construct($wrapped);
        $this->tenantProvider = $tenantProvider;
    }

    public function getConnection($name = null)
    {
        return parent::getConnection($this->resolveName($name, $this->getDefaultConnectionName(), $this->getConnectionNames()));
    }

    public function getManager($name = null)
    {
        return parent::getManager($this->resolveName($name));
    }

    public function resetManager($name = null)
    {
        return parent::resetManager($this->resolveName($name));
    }

    public function getRepository($persistentObject, $persistentManagerName = null)
    {
        return parent::getRepository($persistentObject, $this->resolveName($persistentManagerName));
    }

    private function resolveName($name, $defaultName = null, $names = null): ?string
    {
        $defaultName = $defaultName ?? parent::getDefaultManagerName();
        $names = $names ?? parent::getManagerNames();

        if (empty($name)) {
            $name = $defaultName;
        }

        if (isset($names[$name])) {
            return $name;
        }

        $tenant = $this->tenantProvider->get($this, $name);

        if (null === $tenant) {
            throw new \InvalidArgumentException(sprintf('Tenant "%s" does not exist.', $name));
        }

        $connectionName = $tenant->getConnectionName();
        $connection = parent::getConnection($connectionName);
        if (!$connection instanceof ChangeableConnection) {
            throw new \InvalidArgumentException(sprintf('Connection for multi tenant must be instance of "%s".', ChangeableConnection::class));
        }

        $connection->setParams($tenant->getConnectionParams());

        return $connectionName;
    }
}

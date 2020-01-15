<?php

namespace Webuni\DoctrineExtensions\Persistence;

use Doctrine\Persistence\ManagerRegistry;

class ManagerRegistryDecorator implements ManagerRegistry
{
    private $wrapped;

    public function __construct(ManagerRegistry $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    public function getDefaultConnectionName()
    {
        return $this->wrapped->getDefaultConnectionName();
    }

    public function getConnection($name = null)
    {
        return $this->wrapped->getConnection($name);
    }

    public function getConnections()
    {
        return $this->wrapped->getConnections();
    }

    public function getConnectionNames()
    {
        return $this->wrapped->getConnectionNames();
    }

    public function getDefaultManagerName()
    {
        return $this->wrapped->getDefaultManagerName();
    }

    public function getManager($name = null)
    {
        return $this->wrapped->getManager($name);
    }

    public function getManagers()
    {
        return $this->wrapped->getManagers();
    }

    public function resetManager($name = null)
    {
        return $this->wrapped->resetManager($name);
    }

    public function getAliasNamespace($alias)
    {
        return $this->wrapped->getAliasNamespace($alias);
    }

    public function getManagerNames()
    {
        return $this->wrapped->getManagerNames();
    }

    public function getRepository($persistentObject, $persistentManagerName = null)
    {
        return $this->wrapped->getRepository($persistentObject, $persistentManagerName);
    }

    public function getManagerForClass($class)
    {
        return $this->wrapped->getManagerForClass($class);
    }
}
